<?php

// File: app/Helpers/SMARTERHelper.php

namespace App\Helpers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use App\Models\NormalisasiBobot;
use App\Models\NilaiUtility;
use App\Models\NilaiAkhir;

class SMARTERHelper
{
    /**
     * Validasi dan hitung bobot ROC (Rank Order Centroid)
     * Menggunakan ranking manual dari database, bukan bobot
     * 
     * @param array $kriteria Array kriteria yang sudah diurutkan berdasarkan ranking
     * @return array Hasil perhitungan ROC
     */
    public static function hitungBobotROC($kriteria = null)
    {
        // Ambil kriteria dari database jika tidak disediakan
        if ($kriteria === null) {
            $kriteria = Kriteria::whereNotNull('ranking')
                ->orderBy('ranking', 'asc')
                ->get()
                ->toArray();
        }

        if (empty($kriteria)) {
            throw new \Exception('Tidak ada kriteria dengan ranking yang valid');
        }

        // Validasi ranking berurutan
        $rankings = collect($kriteria)->pluck('ranking')->sort()->values();
        $expectedRankings = range(1, count($kriteria));

        if ($rankings->toArray() !== $expectedRankings) {
            throw new \Exception('Ranking kriteria tidak berurutan. Harap perbaiki ranking terlebih dahulu.');
        }

        $K = count($kriteria); // Jumlah kriteria
        $hasilROC = [];
        $totalBobotROC = 0;

        foreach ($kriteria as $index => $item) {
            $rank = $item['ranking']; // Gunakan ranking dari database

            // Hitung sum untuk rumus ROC
            $sum = 0;
            $rumusDetail = [];

            for ($i = $rank; $i <= $K; $i++) {
                $nilai = 1 / $i;
                $sum += $nilai;
                $rumusDetail[] = [
                    'pembagi' => $i,
                    'nilai' => round($nilai, 4)
                ];
            }

            // Bobot ROC = (1/K) × sum
            $bobotROC = (1 / $K) * $sum;
            $totalBobotROC += $bobotROC;

            $hasilROC[] = [
                'kriteria_id' => $item['id'],
                'kriteria' => $item['kriteria'],
                'rank' => $rank,
                'rumus_penjumlahan' => $rumusDetail,
                'hasil_penjumlahan' => round($sum, 4),
                'formula_akhir' => "(1/{$K}) × " . round($sum, 4),
                'bobot_roc' => round($bobotROC, 4),
                'jenis_kriteria' => $item['jenis_kriteria']
            ];
        }

        // Validasi total bobot ROC harus = 1
        if (abs($totalBobotROC - 1.0) > 0.0001) {
            throw new \Exception("Total bobot ROC harus sama dengan 1.0, saat ini: " . round($totalBobotROC, 4));
        }

        return [
            'hasil_roc' => $hasilROC,
            'total_bobot' => round($totalBobotROC, 4),
            'jumlah_kriteria' => $K,
            'validasi' => true
        ];
    }

    /**
     * Normalisasi matriks keputusan dengan metode SMARTER
     * 
     * @param array $alternatif Array alternatif
     * @param array $kriteria Array kriteria
     * @return array Matriks ternormalisasi
     */
    public static function normalisasiMatriks($alternatif = null, $kriteria = null)
    {
        // Ambil data dari database jika tidak disediakan
        if ($alternatif === null) {
            $alternatif = Alternatif::orderBy('kode', 'asc')->get()->toArray();
        }

        if ($kriteria === null) {
            $kriteria = Kriteria::whereNotNull('ranking')
                ->orderBy('ranking', 'asc')
                ->get()
                ->toArray();
        }

        if (empty($alternatif) || empty($kriteria)) {
            throw new \Exception('Data alternatif atau kriteria tidak tersedia');
        }

        $matriks = [];

        // Ambil nilai min dan max untuk setiap kriteria
        $nilaiMaxMin = Penilaian::query()
            ->join('kriteria as k', 'k.id', '=', 'penilaian.kriteria_id')
            ->join('sub_kriteria as sk', 'sk.id', '=', 'penilaian.sub_kriteria_id')
            ->selectRaw("
                penilaian.kriteria_id, 
                k.kriteria, 
                k.jenis_kriteria, 
                MAX(sk.bobot) as nilaiMax, 
                MIN(sk.bobot) as nilaiMin
            ")
            ->groupBy('penilaian.kriteria_id', 'k.kriteria', 'k.jenis_kriteria')
            ->get()
            ->keyBy('kriteria_id')
            ->toArray();

        foreach ($alternatif as $alt) {
            $barisMatriks = [
                'alternatif_id' => $alt['id'],
                'alternatif' => $alt['alternatif'],
                'kode' => $alt['kode'],
                'nilai_kriteria' => []
            ];

            foreach ($kriteria as $krit) {
                $kriteriaId = $krit['id'];

                if (!isset($nilaiMaxMin[$kriteriaId])) {
                    throw new \Exception("Tidak ada data penilaian untuk kriteria: {$krit['kriteria']}");
                }

                $penilaian = Penilaian::where('alternatif_id', $alt['id'])
                    ->where('kriteria_id', $kriteriaId)
                    ->with('subKriteria')
                    ->first();

                if (!$penilaian || !$penilaian->subKriteria) {
                    throw new \Exception("Data penilaian tidak lengkap untuk alternatif: {$alt['alternatif']}, kriteria: {$krit['kriteria']}");
                }

                // Cast to float to prevent type mismatch errors
                $nilaiAsli = (float) $penilaian->subKriteria->bobot;
                $nilaiMax = (float) $nilaiMaxMin[$kriteriaId]['nilaiMax'];
                $nilaiMin = (float) $nilaiMaxMin[$kriteriaId]['nilaiMin'];
                $jenisKriteria = $nilaiMaxMin[$kriteriaId]['jenis_kriteria'];

                // Perhitungan utility berdasarkan jenis kriteria
                $utility = self::hitungUtility($nilaiAsli, $nilaiMin, $nilaiMax, $jenisKriteria);

                $barisMatriks['nilai_kriteria'][$kriteriaId] = [
                    'nilai_asli' => $nilaiAsli,
                    'utility' => round($utility, 4),
                    'perhitungan' => self::getPerhitunganDetail($nilaiAsli, $nilaiMin, $nilaiMax, $jenisKriteria)
                ];
            }

            $matriks[] = $barisMatriks;
        }

        return [
            'matriks' => $matriks,
            'info_normalisasi' => $nilaiMaxMin,
            'jumlah_alternatif' => count($alternatif),
            'jumlah_kriteria' => count($kriteria)
        ];
    }

    /**
     * Hitung nilai utility SMARTER
     */
    private static function hitungUtility(float $nilaiAsli, float $nilaiMin, float $nilaiMax, string $jenisKriteria): float
    {
        $range = $nilaiMax - $nilaiMin;

        if ($range == 0) {
            return 1.0; // Jika semua nilai sama
        }

        if ($jenisKriteria == 'benefit') {
            // Untuk kriteria benefit: semakin tinggi semakin baik
            return ($nilaiAsli - $nilaiMin) / $range;
        } else {
            // Untuk kriteria cost: semakin rendah semakin baik
            return ($nilaiMax - $nilaiAsli) / $range;
        }
    }

    /**
     * Hitung nilai akhir SMARTER dengan bobot ROC
     * 
     * @param array $matriks Matriks utility
     * @param array $bobotROC Bobot ROC dari perhitungan sebelumnya
     * @return array Hasil nilai akhir
     */
    public static function hitungNilaiAkhir($matriks = null, $bobotROC = null)
    {
        // Jika tidak ada input, ambil dari database
        if ($matriks === null) {
            $normalisasi = self::normalisasiMatriks();
            $matriks = $normalisasi['matriks'];
        }

        if ($bobotROC === null) {
            $hasilROC = self::hitungBobotROC();
            $bobotROC = [];
            foreach ($hasilROC['hasil_roc'] as $hasil) {
                $bobotROC[$hasil['kriteria_id']] = $hasil['bobot_roc'];
            }
        }

        $hasilAkhir = [];

        foreach ($matriks as $baris) {
            $totalNilai = 0;
            $detailPerhitungan = [];

            foreach ($baris['nilai_kriteria'] as $kriteriaId => $nilai) {
                if (!isset($bobotROC[$kriteriaId])) {
                    throw new \Exception("Bobot ROC tidak ditemukan untuk kriteria ID: {$kriteriaId}");
                }

                $bobot = (float) $bobotROC[$kriteriaId];
                $utility = (float) $nilai['utility'];
                $nilaiTerbobot = $utility * $bobot;
                $totalNilai += $nilaiTerbobot;

                $detailPerhitungan[] = [
                    'kriteria_id' => $kriteriaId,
                    'utility' => $utility,
                    'bobot_roc' => $bobot,
                    'nilai_terbobot' => round($nilaiTerbobot, 4),
                    'rumus' => "{$utility} × {$bobot} = " . round($nilaiTerbobot, 4)
                ];
            }

            $hasilAkhir[] = [
                'alternatif_id' => $baris['alternatif_id'],
                'alternatif' => $baris['alternatif'],
                'kode' => $baris['kode'],
                'detail_perhitungan' => $detailPerhitungan,
                'total_nilai' => round($totalNilai, 4)
            ];
        }

        // Urutkan berdasarkan total nilai tertinggi dengan tie-breaking
        usort($hasilAkhir, function ($a, $b) {
            if ($a['total_nilai'] == $b['total_nilai']) {
                // Tie-breaking berdasarkan alternatif_id (yang lebih kecil menang)
                return $a['alternatif_id'] <=> $b['alternatif_id'];
            }
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        // Tambahkan ranking
        foreach ($hasilAkhir as $index => &$hasil) {
            $hasil['ranking'] = $index + 1;
        }

        return [
            'hasil_akhir' => $hasilAkhir,
            'total_alternatif' => count($hasilAkhir),
            'nilai_tertinggi' => $hasilAkhir[0]['total_nilai'] ?? 0,
            'nilai_terendah' => end($hasilAkhir)['total_nilai'] ?? 0
        ];
    }

    /**
     * Generate laporan lengkap SMARTER-ROC
     * 
     * @return array Laporan lengkap
     */
    public static function generateLaporanLengkap()
    {
        try {
            // Validasi data terlebih dahulu
            $validasi = self::validasiData();
            if (!$validasi['valid']) {
                throw new \Exception('Validasi gagal: ' . implode(', ', $validasi['errors']));
            }

            $kriteria = Kriteria::whereNotNull('ranking')
                ->orderBy('ranking', 'asc')
                ->get()
                ->toArray();

            $alternatif = Alternatif::orderBy('kode', 'asc')->get()->toArray();

            // 1. Perhitungan Bobot ROC
            $hasilROC = self::hitungBobotROC($kriteria);

            // 2. Normalisasi Matriks (Utility)
            $normalisasi = self::normalisasiMatriks($alternatif, $kriteria);

            // 3. Ekstrak bobot ROC untuk perhitungan akhir
            $bobotROC = [];
            foreach ($hasilROC['hasil_roc'] as $hasil) {
                $bobotROC[$hasil['kriteria_id']] = $hasil['bobot_roc'];
            }

            // 4. Perhitungan Nilai Akhir
            $nilaiAkhir = self::hitungNilaiAkhir($normalisasi['matriks'], $bobotROC);

            return [
                'perhitungan_roc' => $hasilROC,
                'normalisasi_utility' => $normalisasi,
                'nilai_akhir' => $nilaiAkhir,
                'metadata' => [
                    'jumlah_kriteria' => count($kriteria),
                    'jumlah_alternatif' => count($alternatif),
                    'tanggal_perhitungan' => now()->format('Y-m-d H:i:s'),
                    'metode' => 'SMARTER-ROC',
                    'validasi_passed' => true
                ]
            ];

        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'metadata' => [
                    'tanggal_perhitungan' => now()->format('Y-m-d H:i:s'),
                    'validasi_passed' => false
                ]
            ];
        }
    }

    /**
     * Helper untuk detail perhitungan normalisasi
     * 
     * @param float $nilai Nilai asli
     * @param float $min Nilai minimum
     * @param float $max Nilai maksimum
     * @param string $jenis Jenis kriteria (benefit/cost)
     * @return array Detail perhitungan
     */
    private static function getPerhitunganDetail(float $nilai, float $min, float $max, string $jenis): array
    {
        $range = $max - $min;

        if ($jenis == 'benefit') {
            return [
                'rumus' => '(nilai - min) / (max - min)',
                'substitusi' => "({$nilai} - {$min}) / ({$max} - {$min})",
                'hasil' => $range == 0 ? 1.0 : round(($nilai - $min) / $range, 4),
                'penjelasan' => 'Kriteria benefit: semakin tinggi semakin baik'
            ];
        } else {
            return [
                'rumus' => '(max - nilai) / (max - min)',
                'substitusi' => "({$max} - {$nilai}) / ({$max} - {$min})",
                'hasil' => $range == 0 ? 1.0 : round(($max - $nilai) / $range, 4),
                'penjelasan' => 'Kriteria cost: semakin rendah semakin baik'
            ];
        }
    }

    /**
     * Validasi data sebelum perhitungan
     * 
     * @return array Status validasi
     */
    public static function validasiData()
    {
        $errors = [];
        $warnings = [];

        // Cek kriteria
        $jumlahKriteria = Kriteria::count();
        if ($jumlahKriteria == 0) {
            $errors[] = 'Tidak ada data kriteria';
        }

        // Cek ranking kriteria
        $kriteriaRanked = Kriteria::whereNotNull('ranking')->count();
        if ($kriteriaRanked < $jumlahKriteria) {
            $errors[] = 'Ada kriteria yang belum memiliki ranking';
        }

        // Cek duplikasi ranking
        $duplicateRankings = Kriteria::select('ranking')
            ->whereNotNull('ranking')
            ->groupBy('ranking')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('ranking')
            ->toArray();

        if (!empty($duplicateRankings)) {
            $errors[] = 'Ada ranking yang duplikat: ' . implode(', ', $duplicateRankings);
        }

        // Cek alternatif
        $jumlahAlternatif = Alternatif::count();
        if ($jumlahAlternatif == 0) {
            $errors[] = 'Tidak ada data alternatif';
        }

        // Cek penilaian
        $jumlahPenilaian = Penilaian::whereNotNull('sub_kriteria_id')->count();
        $expectedPenilaian = $jumlahKriteria * $jumlahAlternatif;

        if ($jumlahPenilaian < $expectedPenilaian) {
            $errors[] = "Data penilaian tidak lengkap. Dibutuhkan {$expectedPenilaian}, tersedia {$jumlahPenilaian}";
        }

        // Cek konsistensi bobot ROC
        try {
            $totalBobotROC = Kriteria::whereNotNull('ranking')->sum('bobot');
            if (abs($totalBobotROC - 1.0) > 0.001) {
                $warnings[] = "Total bobot ROC tidak sama dengan 1.0 (saat ini: " . round($totalBobotROC, 4) . "). Perlu recalculate bobot ROC.";
            }
        } catch (\Exception $e) {
            $warnings[] = 'Tidak dapat menghitung total bobot ROC';
        }

        // Cek sub kriteria untuk setiap kriteria
        $kriteriaWithoutSub = Kriteria::whereDoesntHave('subKriteria')->count();
        if ($kriteriaWithoutSub > 0) {
            $warnings[] = "Ada {$kriteriaWithoutSub} kriteria yang belum memiliki sub kriteria";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings,
            'info' => [
                'jumlah_kriteria' => $jumlahKriteria,
                'jumlah_alternatif' => $jumlahAlternatif,
                'jumlah_penilaian' => $jumlahPenilaian,
                'kriteria_ranked' => $kriteriaRanked,
                'expected_penilaian' => $expectedPenilaian,
                'completion_percentage' => $expectedPenilaian > 0 ? round(($jumlahPenilaian / $expectedPenilaian) * 100, 2) : 0
            ]
        ];
    }

    /**
     * Method untuk recalculate semua bobot ROC
     */
    public static function recalculateAllROCWeights()
    {
        try {
            $kriteria = Kriteria::whereNotNull('ranking')
                ->orderBy('ranking', 'asc')
                ->get();

            $K = count($kriteria);

            foreach ($kriteria as $item) {
                $sum = 0;
                for ($i = $item->ranking; $i <= $K; $i++) {
                    $sum += 1 / $i;
                }

                $bobotROC = (1 / $K) * $sum;
                $item->updateQuietly(['bobot' => round($bobotROC, 4)]);
            }

            return [
                'success' => true,
                'message' => 'Semua bobot ROC berhasil dihitung ulang',
                'total_updated' => count($kriteria)
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal menghitung ulang bobot ROC: ' . $e->getMessage()
            ];
        }
    }
}