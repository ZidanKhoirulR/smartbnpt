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
     * Hitung bobot ROC (Rank Order Centroid)
     * 
     * @param array $kriteria Array kriteria yang sudah diurutkan berdasarkan kepentingan
     * @return array Hasil perhitungan ROC
     */
    public static function hitungBobotROC($kriteria)
    {
        $K = count($kriteria); // Jumlah kriteria
        $hasilROC = [];

        foreach ($kriteria as $index => $item) {
            $rank = $index + 1; // Ranking dimulai dari 1

            // Hitung sum untuk rumus ROC
            $sum = 0;
            $rumusDetail = [];

            for ($i = $rank; $i <= $K; $i++) {
                $nilai = 1 / $i;
                $sum += $nilai;
                $rumusDetail[] = [
                    'pembagi' => $i,
                    'nilai' => round($nilai, 3)
                ];
            }

            // Bobot ROC = (1/K) × sum
            $bobotROC = (1 / $K) * $sum;

            $hasilROC[] = [
                'kriteria_id' => $item->id,
                'kriteria' => $item->kriteria,
                'rank' => $rank,
                'rumus_penjumlahan' => $rumusDetail,
                'hasil_penjumlahan' => round($sum, 3),
                'formula_akhir' => "(1/{$K}) × " . round($sum, 3),
                'bobot_roc' => round($bobotROC, 4)
            ];
        }

        return $hasilROC;
    }

    /**
     * Normalisasi matriks keputusan
     * 
     * @param array $alternatif Array alternatif
     * @param array $kriteria Array kriteria
     * @return array Matriks ternormalisasi
     */
    public static function normalisasiMatriks($alternatif, $kriteria)
    {
        $matriks = [];

        // Ambil nilai min dan max untuk setiap kriteria
        $nilaiMaxMin = Penilaian::query()
            ->join('kriteria as k', 'k.id', '=', 'penilaian.kriteria_id')
            ->join('sub_kriteria as sk', 'sk.id', '=', 'penilaian.sub_kriteria_id')
            ->selectRaw("penilaian.kriteria_id, k.jenis_kriteria, MAX(sk.bobot) as nilaiMax, MIN(sk.bobot) as nilaiMin")
            ->groupBy('penilaian.kriteria_id', 'k.jenis_kriteria')
            ->pluck('nilaiMax', 'kriteria_id')
            ->toArray();

        foreach ($alternatif as $alt) {
            $barisMatriks = [
                'alternatif_id' => $alt->id,
                'alternatif' => $alt->alternatif,
                'nilai_kriteria' => []
            ];

            foreach ($kriteria as $krit) {
                $penilaian = Penilaian::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->with('subKriteria')
                    ->first();

                if ($penilaian && $penilaian->subKriteria) {
                    $nilaiAsli = $penilaian->subKriteria->bobot;
                    $nilaiMax = $nilaiMaxMin[$krit->id]['nilaiMax'] ?? 1;
                    $nilaiMin = $nilaiMaxMin[$krit->id]['nilaiMin'] ?? 0;

                    // Perhitungan utility berdasarkan jenis kriteria
                    if ($krit->jenis_kriteria == 'benefit') {
                        $utility = ($nilaiMax - $nilaiMin) == 0 ? 1 : ($nilaiAsli - $nilaiMin) / ($nilaiMax - $nilaiMin);
                    } else { // cost
                        $utility = ($nilaiMax - $nilaiMin) == 0 ? 1 : ($nilaiMax - $nilaiAsli) / ($nilaiMax - $nilaiMin);
                    }

                    $barisMatriks['nilai_kriteria'][$krit->id] = [
                        'nilai_asli' => $nilaiAsli,
                        'utility' => round($utility, 4),
                        'perhitungan' => self::getPerhitunganDetail($nilaiAsli, $nilaiMin, $nilaiMax, $krit->jenis_kriteria)
                    ];
                }
            }

            $matriks[] = $barisMatriks;
        }

        return $matriks;
    }

    /**
     * Hitung nilai akhir SMARTER
     * 
     * @param array $matriks Matriks utility
     * @param array $bobotROC Bobot ROC
     * @return array Hasil nilai akhir
     */
    public static function hitungNilaiAkhir($matriks, $bobotROC)
    {
        $hasilAkhir = [];

        foreach ($matriks as $baris) {
            $totalNilai = 0;
            $detailPerhitungan = [];

            foreach ($baris['nilai_kriteria'] as $kriteriaId => $nilai) {
                $bobot = $bobotROC[$kriteriaId] ?? 0;
                $nilaiTerbobot = $nilai['utility'] * $bobot;
                $totalNilai += $nilaiTerbobot;

                $detailPerhitungan[] = [
                    'kriteria_id' => $kriteriaId,
                    'utility' => $nilai['utility'],
                    'bobot_roc' => $bobot,
                    'nilai_terbobot' => round($nilaiTerbobot, 4)
                ];
            }

            $hasilAkhir[] = [
                'alternatif_id' => $baris['alternatif_id'],
                'alternatif' => $baris['alternatif'],
                'detail_perhitungan' => $detailPerhitungan,
                'total_nilai' => round($totalNilai, 4)
            ];
        }

        // Urutkan berdasarkan total nilai tertinggi
        usort($hasilAkhir, function ($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        // Tambahkan ranking
        foreach ($hasilAkhir as $index => &$hasil) {
            $hasil['ranking'] = $index + 1;
        }

        return $hasilAkhir;
    }

    /**
     * Generate laporan lengkap SMARTER-ROC
     * 
     * @return array Laporan lengkap
     */
    public static function generateLaporanLengkap()
    {
        $kriteria = Kriteria::orderBy('bobot', 'desc')->get()->toArray();
        $alternatif = Alternatif::all()->toArray();

        // 1. Perhitungan Bobot ROC
        $hasilROC = self::hitungBobotROC($kriteria);

        // 2. Normalisasi Matriks
        $matriksUtility = self::normalisasiMatriks($alternatif, $kriteria);

        // 3. Ekstrak bobot ROC untuk perhitungan akhir
        $bobotROC = [];
        foreach ($hasilROC as $hasil) {
            $bobotROC[$hasil['kriteria_id']] = $hasil['bobot_roc'];
        }

        // 4. Perhitungan Nilai Akhir
        $nilaiAkhir = self::hitungNilaiAkhir($matriksUtility, $bobotROC);

        return [
            'perhitungan_roc' => $hasilROC,
            'matriks_utility' => $matriksUtility,
            'nilai_akhir' => $nilaiAkhir,
            'metadata' => [
                'jumlah_kriteria' => count($kriteria),
                'jumlah_alternatif' => count($alternatif),
                'tanggal_perhitungan' => now()->format('Y-m-d H:i:s')
            ]
        ];
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
    private static function getPerhitunganDetail($nilai, $min, $max, $jenis)
    {
        $range = $max - $min;

        if ($jenis == 'benefit') {
            return [
                'rumus' => '(nilai - min) / (max - min)',
                'substitusi' => "({$nilai} - {$min}) / ({$max} - {$min})",
                'hasil' => $range == 0 ? 1 : round(($nilai - $min) / $range, 4)
            ];
        } else {
            return [
                'rumus' => '(max - nilai) / (max - min)',
                'substitusi' => "({$max} - {$nilai}) / ({$max} - {$min})",
                'hasil' => $range == 0 ? 1 : round(($max - $nilai) / $range, 4)
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

        // Cek kriteria
        $jumlahKriteria = Kriteria::count();
        if ($jumlahKriteria == 0) {
            $errors[] = 'Tidak ada data kriteria';
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

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'info' => [
                'jumlah_kriteria' => $jumlahKriteria,
                'jumlah_alternatif' => $jumlahAlternatif,
                'jumlah_penilaian' => $jumlahPenilaian
            ]
        ];
    }
}