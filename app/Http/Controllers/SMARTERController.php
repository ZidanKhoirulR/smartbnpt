<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlternatifResource;
use App\Http\Resources\KriteriaResource;
use App\Http\Resources\NilaiAkhirResource;
use App\Http\Resources\NilaiUtilityResource;
use App\Http\Resources\NormalisasiBobotResource;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\NilaiUtility;
use App\Models\NormalisasiBobot;
use App\Models\Penilaian;

class SMARTERController extends Controller
{
    /**
     * Tampilan halaman perhitungan SMARTER-ROC
     */
    public function indexPerhitungan()
    {
        $title = "Perhitungan SMARTER-ROC";

        // Data untuk normalisasi bobot ROC
        $normalisasiBobot = NormalisasiBobotResource::collection(
            NormalisasiBobot::with('kriteria')->orderBy('kriteria_id', 'asc')->get()
        );

        // Data kriteria dan alternatif
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        // Data nilai utility
        $nilaiUtility = NilaiUtilityResource::collection(
            NilaiUtility::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get()
        );

        // Data nilai akhir
        $nilaiAkhir = NilaiAkhirResource::collection(
            NilaiAkhir::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get()
        );

        // Sum bobot kriteria untuk validasi
        $sumBobotKriteria = $kriteria->sum('bobot');

        return view('dashboard.perhitungan.index', compact(
            'title',
            'normalisasiBobot',
            'kriteria',
            'alternatif',
            'nilaiUtility',
            'nilaiAkhir',
            'sumBobotKriteria'
        ));
    }

    /**
     * Perhitungan lengkap SMARTER-ROC
     */
    public function perhitunganSMARTER()
    {
        try {
            // 1. Hitung normalisasi bobot ROC
            $this->perhitunganNormalisasiBobot();

            // 2. Hitung nilai utility
            $this->perhitunganNilaiUtility();

            // 3. Hitung nilai akhir
            $this->perhitunganNilaiAkhir();

            return response()->json([
                'status' => 'success',
                'message' => 'Perhitungan SMARTER-ROC berhasil dilakukan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perhitungan gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function indexNormalisasiBobot()
    {
        $title = "Normalisasi Bobot SMARTER - ROC";
        $normalisasiBobot = NormalisasiBobotResource::collection(NormalisasiBobot::with('kriteria')->orderBy('kriteria_id', 'asc')->get());
        return view('dashboard.normalisasi-bobot.index', compact('title', 'normalisasiBobot'));
    }

    public function perhitunganNormalisasiBobot()
    {
        // Gunakan ranking manual, bukan bobot
        $kriteria = Kriteria::orderBy('ranking', 'asc')->get();

        if ($kriteria->isEmpty()) {
            return to_route('normalisasi-bobot')->with('error', 'Data kriteria tidak tersedia');
        }

        // Pastikan semua kriteria memiliki ranking
        $unranked = $kriteria->whereNull('ranking');
        if ($unranked->count() > 0) {
            return to_route('normalisasi-bobot')->with('error', 'Harap set ranking untuk semua kriteria terlebih dahulu');
        }

        NormalisasiBobot::truncate();
        $K = count($kriteria);

        foreach ($kriteria as $item) {
            $rank = $item->ranking; // Gunakan ranking manual

            $sum = 0;
            for ($i = $rank; $i <= $K; $i++) {
                $sum += 1 / $i;
            }

            $bobotROC = (1 / $K) * $sum;

            NormalisasiBobot::create([
                'kriteria_id' => $item->id,
                'normalisasi' => round($bobotROC, 4),
            ]);
        }

        return to_route('normalisasi-bobot')->with('success', 'Normalisasi Bobot SMARTER-ROC Berhasil Dilakukan');
    }

    public function perhitunganNilaiUtility()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return to_route('nilai-utility')->with('error', 'Data kriteria atau alternatif tidak tersedia');
        }

        NilaiUtility::truncate();

        // Ambil nilai max dan min untuk setiap kriteria
        $nilaiMaxMin = Penilaian::query()
            ->join('kriteria as k', 'k.id', '=', 'penilaian.kriteria_id')
            ->join('sub_kriteria as sk', 'sk.id', '=', 'penilaian.sub_kriteria_id')
            ->selectRaw("penilaian.kriteria_id, k.kriteria, k.jenis_kriteria, MAX(sk.bobot) as nilaiMax, MIN(sk.bobot) as nilaiMin")
            ->groupBy('penilaian.kriteria_id', 'k.kriteria', 'k.jenis_kriteria')
            ->get();

        $createUtility = false;

        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $kriteriaNilai = $nilaiMaxMin->where('kriteria_id', $krit->id)->first();

                if (!$kriteriaNilai) {
                    continue;
                }

                $nilaiMax = $kriteriaNilai->nilaiMax;
                $nilaiMin = $kriteriaNilai->nilaiMin;
                $jenisKriteria = $kriteriaNilai->jenis_kriteria;

                $penilaianData = Penilaian::where('kriteria_id', $krit->id)
                    ->where('alternatif_id', $alt->id)
                    ->with('subKriteria')
                    ->first();

                if (!$penilaianData || !$penilaianData->subKriteria) {
                    continue;
                }

                $nilaiSubKriteria = $penilaianData->subKriteria->bobot;
                $divisor = $nilaiMax - $nilaiMin;

                // Perhitungan Utility SMARTER
                if ($divisor == 0) {
                    $utility = 1; // Jika semua nilai sama
                } else {
                    if ($jenisKriteria == 'benefit') {
                        // Untuk kriteria benefit: semakin tinggi semakin baik
                        $utility = ($nilaiSubKriteria - $nilaiMin) / $divisor;
                    } else {
                        // Untuk kriteria cost: semakin rendah semakin baik
                        $utility = ($nilaiMax - $nilaiSubKriteria) / $divisor;
                    }
                }

                $createUtility = NilaiUtility::create([
                    'alternatif_id' => $alt->id,
                    'kriteria_id' => $krit->id,
                    'nilai' => round($utility, 4),
                ]);
            }
        }

        if ($createUtility) {
            return to_route('nilai-utility')->with('success', 'Nilai Utility SMARTER Berhasil Dihitung');
        } else {
            return to_route('nilai-utility')->with('error', 'Nilai Utility SMARTER Gagal Dihitung');
        }
    }

    public function indexNilaiAkhir()
    {
        $title = "Nilai Akhir SMARTER";
        $nilaiAkhir = NilaiAkhirResource::collection(NilaiAkhir::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        return view('dashboard.nilai-akhir.index', compact('title', 'nilaiAkhir', 'alternatif', 'kriteria'));
    }

    public function perhitunganNilaiAkhir()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return to_route('nilai-akhir')->with('error', 'Data kriteria atau alternatif tidak tersedia');
        }

        // Pastikan normalisasi bobot dan utility sudah ada
        $normalisasiCount = NormalisasiBobot::count();
        $utilityCount = NilaiUtility::count();

        if ($normalisasiCount == 0) {
            return to_route('nilai-akhir')->with('error', 'Silakan lakukan normalisasi bobot terlebih dahulu');
        }

        if ($utilityCount == 0) {
            return to_route('nilai-akhir')->with('error', 'Silakan hitung nilai utility terlebih dahulu');
        }

        NilaiAkhir::truncate();
        $createNilaiAkhir = false;

        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                // Ambil bobot yang sudah dinormalisasi dengan ROC
                $normalisasiBobot = NormalisasiBobot::where('kriteria_id', $krit->id)->first();

                // Ambil nilai utility
                $nilaiUtility = NilaiUtility::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();

                if ($normalisasiBobot && $nilaiUtility) {
                    // Nilai Akhir = Bobot ROC × Utility
                    $nilaiAkhir = $normalisasiBobot->normalisasi * $nilaiUtility->nilai;

                    $createNilaiAkhir = NilaiAkhir::create([
                        'alternatif_id' => $alt->id,
                        'kriteria_id' => $krit->id,
                        'nilai' => round($nilaiAkhir, 4),
                    ]);
                }
            }
        }

        if ($createNilaiAkhir) {
            return to_route('nilai-akhir')->with('success', 'Nilai Akhir SMARTER Berhasil Dihitung');
        } else {
            return to_route('nilai-akhir')->with('error', 'Nilai Akhir SMARTER Gagal Dihitung');
        }
    }

    /**
     * Method untuk melihat hasil perhitungan detail - FIXED
     */
    public function hasilPerhitungan()
    {
        try {
            $title = "Hasil Perhitungan SMARTER-ROC";

            // 1. Data Normalisasi Bobot ROC
            $normalisasiBobot = NormalisasiBobot::with('kriteria')
                ->orderBy('kriteria_id', 'asc')
                ->get();

            // 2. Data Kriteria
            $kriteria = Kriteria::orderBy('ranking', 'asc')->get();

            // 3. Data Alternatif
            $alternatif = Alternatif::orderBy('kode', 'asc')->get();

            // 4. Data Nilai Utility
            $nilaiUtility = NilaiUtility::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get();

            // 5. Data Nilai Akhir
            $nilaiAkhir = NilaiAkhir::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get();

            // 6. Hasil Akhir dengan Ranking
            $hasilAkhir = NilaiAkhir::query()
                ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw("
                    a.id,
                    a.kode, 
                    a.nik,
                    a.alternatif, 
                    SUM(nilai_akhir.nilai) as total_nilai,
                    ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, a.created_at ASC) as ranking
                ")
                ->groupBy('a.id', 'a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
                ->orderBy('total_nilai', 'desc')
                ->orderBy('a.created_at', 'asc')
                ->get();

            // 7. Data untuk tabel perhitungan ROC (untuk detail)
            $K = count($kriteria);
            $hasilROC = [];

            foreach ($kriteria as $item) {
                $rank = $item->ranking ?? 1;
                $sum = 0;
                $rumusPenjumlahan = [];

                for ($i = $rank; $i <= $K; $i++) {
                    $sum += 1 / $i;
                    $rumusPenjumlahan[] = "1/{$i}";
                }

                $bobotROC = (1 / $K) * $sum;

                $hasilROC[] = [
                    'kriteria' => $item->kriteria,
                    'rank' => $rank,
                    'rumus' => implode(' + ', $rumusPenjumlahan),
                    'penjumlahan' => round($sum, 3),
                    'bobot' => round($bobotROC, 4)
                ];
            }

            // 8. Data matriks ternormalisasi (utility) - grouped by alternatif
            $utilityData = $nilaiUtility->groupBy('alternatif_id');

            // 9. Validasi data
            if ($normalisasiBobot->isEmpty()) {
                return redirect()->route('perhitungan')
                    ->with('error', 'Data normalisasi bobot belum tersedia. Silakan lakukan perhitungan terlebih dahulu.');
            }

            if ($hasilAkhir->isEmpty()) {
                return redirect()->route('perhitungan')
                    ->with('error', 'Data hasil perhitungan belum tersedia. Silakan lakukan perhitungan terlebih dahulu.');
            }

            // 10. Return view dengan semua data yang diperlukan
            return view('dashboard.smarter.hasil-perhitungan', compact(
                'title',
                'normalisasiBobot',
                'kriteria',
                'alternatif',
                'nilaiUtility',
                'nilaiAkhir',
                'hasilAkhir',
                'hasilROC',
                'utilityData'
            ));

        } catch (\Exception $e) {
            // Jika ada error, redirect ke perhitungan dengan pesan error
            return redirect()->route('perhitungan')
                ->with('error', 'Terjadi kesalahan saat mengambil data hasil perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Method tambahan untuk mendukung view index perhitungan
     */
    public function indexUtilityNilai()
    {
        $title = "Nilai Utility SMARTER";
        $nilaiUtility = NilaiUtilityResource::collection(
            NilaiUtility::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get()
        );
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());

        return view('dashboard.nilai-utility.index', compact('title', 'nilaiUtility', 'alternatif', 'kriteria'));
    }
}