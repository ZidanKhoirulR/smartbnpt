<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlternatifResource;
use App\Http\Resources\KriteriaResource;
use App\Http\Resources\NilaiAkhirResource;
use App\Http\Resources\NilaiUtilityResource;
use App\Http\Resources\NormalisasiBobotResource;
use App\Http\Resources\MatriksTernormalisasiResource;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\NilaiUtility;
use App\Models\NormalisasiBobot;
use App\Models\Penilaian;
use App\Models\MatriksTernormalisasi;

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
            NilaiUtility::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get()
        );

        // Data matriks ternormalisasi dengan relasi
        $matriksTernormalisasi = MatriksTernormalisasiResource::collection(
            MatriksTernormalisasi::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get()
        );

        // Data nilai akhir per kriteria DAN total
        $nilaiAkhirPerKriteria = collect();
        $nilaiAkhirTotal = NilaiAkhirResource::collection(
            NilaiAkhir::with(['alternatif'])
                ->whereNull('kriteria_id') // Hanya record total
                ->orderBy('alternatif_id', 'asc')
                ->get()
        );

        // TAMBAHAN: Buat struktur data nilai akhir per kriteria dari matriks ternormalisasi
        // untuk menampilkan detail per kriteria di tabel nilai akhir
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $matriksValue = $matriksTernormalisasi
                    ->where("alternatif_id", $alt->id)
                    ->where("kriteria_id", $krit->id)
                    ->first();

                if ($matriksValue) {
                    $nilaiAkhirPerKriteria->push([
                        'alternatif_id' => $alt->id,
                        'kriteria_id' => $krit->id,
                        'nilai' => $matriksValue->nilai
                    ]);
                }
            }
        }

        // Sum bobot kriteria untuk validasi
        $sumBobotKriteria = $kriteria->sum('bobot');

        // DEBUG: Tambahkan ini untuk debugging
        \Log::info('Debug Data:', [
            'kriteria_count' => $kriteria->count(),
            'alternatif_count' => $alternatif->count(),
            'matriks_count' => $matriksTernormalisasi->count(),
            'nilai_akhir_count' => $nilaiAkhirTotal->count(),
            'matriks_sample' => $matriksTernormalisasi->take(3)->toArray(),
        ]);

        return view('dashboard.perhitungan.index', compact(
            'title',
            'normalisasiBobot',
            'kriteria',
            'alternatif',
            'nilaiUtility',
            'matriksTernormalisasi',
            'nilaiAkhirTotal',
            'nilaiAkhirPerKriteria',
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

            // 3. Hitung matriks ternormalisasi
            $this->perhitunganMatriksTernormalisasi();

            // 4. Hitung nilai akhir
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
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());
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

    public function indexMatriksTernormalisasi()
    {
        $title = "Matriks Ternormalisasi SMARTER";
        $matriksTernormalisasi = MatriksTernormalisasiResource::collection(
            MatriksTernormalisasi::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get()
        );
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());

        return view('dashboard.matriks-ternormalisasi.index', compact('title', 'matriksTernormalisasi', 'alternatif', 'kriteria'));
    }

    /**
     * Perhitungan matriks ternormalisasi
     * Formula: Nilai Utility × Bobot ROC
     */
    public function perhitunganMatriksTernormalisasi()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return to_route('matriks-ternormalisasi')->with('error', 'Data kriteria atau alternatif tidak tersedia');
        }

        // Pastikan normalisasi bobot dan utility sudah ada
        $normalisasiCount = NormalisasiBobot::count();
        $utilityCount = NilaiUtility::count();

        if ($normalisasiCount == 0) {
            return to_route('matriks-ternormalisasi')->with('error', 'Silakan lakukan normalisasi bobot terlebih dahulu');
        }

        if ($utilityCount == 0) {
            return to_route('matriks-ternormalisasi')->with('error', 'Silakan hitung nilai utility terlebih dahulu');
        }

        MatriksTernormalisasi::truncate();
        $createMatriks = false;

        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                // Ambil bobot yang sudah dinormalisasi dengan ROC
                $normalisasiBobot = NormalisasiBobot::where('kriteria_id', $krit->id)->first();

                // Ambil nilai utility
                $nilaiUtility = NilaiUtility::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();

                if ($normalisasiBobot && $nilaiUtility) {
                    // Matriks Ternormalisasi = Utility × Bobot ROC
                    $nilaiMatriks = $nilaiUtility->nilai * $normalisasiBobot->normalisasi;

                    $createMatriks = MatriksTernormalisasi::create([
                        'alternatif_id' => $alt->id,
                        'kriteria_id' => $krit->id,
                        'nilai' => round($nilaiMatriks, 4),
                    ]);
                }
            }
        }

        if ($createMatriks) {
            return to_route('matriks-ternormalisasi')->with('success', 'Matriks Ternormalisasi SMARTER Berhasil Dihitung');
        } else {
            return to_route('matriks-ternormalisasi')->with('error', 'Matriks Ternormalisasi SMARTER Gagal Dihitung');
        }
    }

    public function indexNilaiAkhir()
    {
        $title = "Nilai Akhir SMARTER";

        // Tambahkan ini
        $matriksTernormalisasi = MatriksTernormalisasiResource::collection(
            MatriksTernormalisasi::with(['alternatif', 'kriteria'])
                ->orderBy('alternatif_id', 'asc')
                ->orderBy('kriteria_id', 'asc')
                ->get()
        );

        $nilaiAkhirTotal = NilaiAkhirResource::collection(
            NilaiAkhir::with(['alternatif'])
                ->whereNull('kriteria_id') // Hanya ambil record total
                ->orderBy('alternatif_id', 'asc')
                ->get()
        );

        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('ranking', 'asc')->get());

        return view('dashboard.nilai-akhir.index', compact(
            'title',
            'nilaiAkhir',
            'alternatif',
            'kriteria',
            'matriksTernormalisasi'
        ));

    }

    public function perhitunganNilaiAkhir()
    {
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        if ($alternatif->isEmpty()) {
            return to_route('nilai-akhir')->with('error', 'Data alternatif tidak tersedia');
        }

        // Pastikan matriks ternormalisasi sudah ada
        $matriksCount = MatriksTernormalisasi::count();
        if ($matriksCount == 0) {
            return to_route('nilai-akhir')->with('error', 'Silakan hitung matriks ternormalisasi terlebih dahulu');
        }

        NilaiAkhir::truncate();
        $createNilaiAkhir = false;

        foreach ($alternatif as $alt) {
            // Ambil semua nilai matriks ternormalisasi untuk alternatif ini
            $nilaiMatriks = MatriksTernormalisasi::where('alternatif_id', $alt->id)->get();

            if ($nilaiMatriks->count() > 0) {
                // HANYA SIMPAN 1 RECORD UNTUK TOTAL NILAI
                // Jumlahkan semua nilai matriks ternormalisasi
                $totalNilai = $nilaiMatriks->sum('nilai');

                $createNilaiAkhir = NilaiAkhir::create([
                    'alternatif_id' => $alt->id,
                    'kriteria_id' => null, // NULL karena ini adalah total
                    'nilai' => round($totalNilai, 4),
                ]);
            }
        }

        if ($createNilaiAkhir) {
            return to_route('nilai-akhir')->with('success', 'Nilai Akhir SMARTER Berhasil Dihitung');
        } else {
            return to_route('nilai-akhir')->with('error', 'Nilai Akhir SMARTER Gagal Dihitung');
        }
    }

    // Method untuk melihat hasil perhitungan detail
    public function hasilPerhitungan()
    {
        $title = "Hasil Perhitungan SMARTER-ROC";

        // Data untuk tabel perhitungan ROC
        $kriteria = Kriteria::orderBy('ranking', 'asc')->get();
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

        // Data matriks ternormalisasi (utility)
        $utilityData = NilaiUtility::with(['alternatif', 'kriteria'])
            ->orderBy('alternatif_id')
            ->orderBy('kriteria_id')
            ->get()
            ->groupBy('alternatif_id');

        // Hasil akhir dengan ranking
        $hasilAkhir = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.kode, 
                a.nik,
                a.alternatif, 
                SUM(nilai_akhir.nilai) as total_nilai,
                ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, a.created_at ASC) as ranking
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
            ->orderBy('total_nilai', 'desc')
            ->orderBy('a.created_at', 'asc')
            ->get();

        return view('dashboard.smarter.hasil-perhitungan', compact(
            'title',
            'hasilROC',
            'utilityData',
            'hasilAkhir',
            'kriteria'
        ));
    }
}