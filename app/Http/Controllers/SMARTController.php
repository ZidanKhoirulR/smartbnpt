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

class SMARTController extends Controller
{
    public function indexNormalisasiBobot()
    {
        $title = "Normalisasi Bobot";
        $normalisasiBobot = NormalisasiBobotResource::collection(NormalisasiBobot::with('kriteria')->orderBy('kriteria_id', 'asc')->get());
        $sumBobot = Kriteria::sum('bobot');
        return view('dashboard.normalisasi-bobot.index', compact('title', 'normalisasiBobot', 'sumBobot'));
    }

    public function perhitunganNormalisasiBobot()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $sumBobot = $kriteria->sum('bobot');

        // Validasi total bobot tidak boleh 0
        if ($sumBobot == 0) {
            return to_route('normalisasi-bobot')->with('error', 'Total bobot kriteria tidak boleh 0');
        }

        NormalisasiBobot::truncate();
        $createNormalisasi = false;

        foreach ($kriteria as $item) {
            $createNormalisasi = NormalisasiBobot::create([
                'kriteria_id' => $item->id,
                'normalisasi' => round($item->bobot / $sumBobot, 4),
            ]);
        }

        if ($createNormalisasi) {
            return to_route('normalisasi-bobot')->with('success', 'Normalisasi Bobot Kriteria Berhasil Dilakukan');
        } else {
            return to_route('normalisasi-bobot')->with('error', 'Normalisasi Bobot Kriteria Gagal Dilakukan');
        }
    }

    public function indexNilaiUtility()
    {
        $title = "Nilai Utility";
        $nilaiUtility = NilaiUtilityResource::collection(NilaiUtility::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        return view('dashboard.nilai-utility.index', compact('title', 'nilaiUtility', 'alternatif', 'kriteria'));
    }

    public function perhitunganNilaiUtility()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        // Validasi data
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

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $kriteriaNilai = $nilaiMaxMin->where('kriteria_id', $value->id)->first();

                if (!$kriteriaNilai) {
                    continue; // Skip jika tidak ada data min/max
                }

                $nilaiMax = $kriteriaNilai->nilaiMax;
                $nilaiMin = $kriteriaNilai->nilaiMin;
                $jenisKriteria = $kriteriaNilai->jenis_kriteria;

                // Ambil nilai sub kriteria untuk alternatif dan kriteria tertentu
                $penilaianData = Penilaian::where('kriteria_id', $value->id)
                    ->where('alternatif_id', $item->id)
                    ->with('subKriteria')
                    ->first();

                if (!$penilaianData || !$penilaianData->subKriteria) {
                    continue; // Skip jika tidak ada sub kriteria
                }

                $nilaiSubKriteria = $penilaianData->subKriteria->bobot;
                $divisor = $nilaiMax - $nilaiMin;

                // PERBAIKAN UTAMA: Logika utility untuk program bantuan sosial (BPNT)
                // Semua kriteria diperlakukan sebagai COST (nilai rendah = kebutuhan tinggi = utility tinggi)
                if ($divisor == 0) {
                    // Jika semua nilai sama
                    $nilai = 5.5; // Nilai tengah
                } else {
                    // Untuk semua kriteria dalam konteks BPNT:
                    // - Pendapatan rendah = butuh bantuan = utility tinggi
                    // - Tanggungan banyak = butuh bantuan = utility tinggi  
                    // - Kondisi rumah buruk = butuh bantuan = utility tinggi
                    // - Aset sedikit = butuh bantuan = utility tinggi
                    // - Pekerjaan tidak stabil = butuh bantuan = utility tinggi

                    // Formula untuk semua kriteria: ((max - nilai) / (max - min)) * 9 + 1
                    // Semakin rendah nilai asli, semakin tinggi utility
                    if ($jenisKriteria === 'benefit') {
                        $nilai = (($nilaiSubKriteria - $nilaiMin) / $divisor) * 9 + 1;
                    } else {
                        $nilai = (($nilaiMax - $nilaiSubKriteria) / $divisor) * 9 + 1;
                    }

                }

                // Pastikan nilai dalam rentang 1-10
                $nilai = max(1, min(10, $nilai));

                $createUtility = NilaiUtility::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'nilai' => round($nilai, 3), // Bulatkan ke 3 desimal untuk presisi
                ]);
            }
        }

        if ($createUtility) {
            return to_route('nilai-utility')->with('success', 'Perhitungan Nilai Utility Berhasil Dilakukan');
        } else {
            return to_route('nilai-utility')->with('error', 'Perhitungan Nilai Utility Gagal Dilakukan');
        }
    }

    public function indexNilaiAkhir()
    {
        $title = "Nilai Akhir";
        $nilaiAkhir = NilaiAkhirResource::collection(NilaiAkhir::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        return view('dashboard.nilai-akhir.index', compact('title', 'nilaiAkhir', 'alternatif', 'kriteria'));
    }

    public function perhitunganNilaiAkhir()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());

        // Validasi data
        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return to_route('nilai-akhir')->with('error', 'Data kriteria atau alternatif tidak tersedia');
        }

        NilaiAkhir::truncate();
        $createNilaiAkhir = false;

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $normalisasiBobotData = NormalisasiBobot::where('kriteria_id', $value->id)->first();
                $nilaiUtilityData = NilaiUtility::where('kriteria_id', $value->id)->where('alternatif_id', $item->id)->first();

                if (!$normalisasiBobotData || !$nilaiUtilityData) {
                    continue; // Skip jika data tidak lengkap
                }

                $normalisasiBobot = $normalisasiBobotData->normalisasi;
                $nilaiUtility = $nilaiUtilityData->nilai;
                $nilai = $normalisasiBobot * $nilaiUtility;

                $createNilaiAkhir = NilaiAkhir::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'nilai' => round($nilai, 4), // Bulatkan ke 4 desimal untuk presisi tinggi
                ]);
            }
        }

        if ($createNilaiAkhir) {
            return to_route('nilai-akhir')->with('success', 'Perhitungan Nilai Akhir Berhasil Dilakukan');
        } else {
            return to_route('nilai-akhir')->with('error', 'Perhitungan Nilai Akhir Gagal Dilakukan');
        }
    }

    public function indexPerhitungan()
    {
        $title = "Perhitungan Metode";

        $normalisasiBobot = NormalisasiBobotResource::collection(NormalisasiBobot::with('kriteria')->orderBy('kriteria_id', 'asc')->get());
        $nilaiUtility = NilaiUtilityResource::collection(NilaiUtility::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());
        $nilaiAkhir = NilaiAkhirResource::collection(NilaiAkhir::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());

        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $sumBobotKriteria = $kriteria->sum('bobot');

        return view('dashboard.perhitungan.index', compact('title', 'normalisasiBobot', 'nilaiUtility', 'nilaiAkhir', 'alternatif', 'kriteria', 'sumBobotKriteria'));
    }

    public function perhitunganMetode()
    {
        try {
            // Jalankan perhitungan secara berurutan
            $this->perhitunganNormalisasiBobot();
            $this->perhitunganNilaiUtility();
            $this->perhitunganNilaiAkhir();

            return to_route('perhitungan')->with('success', 'Perhitungan Metode SMART Berhasil Dilakukan');
        } catch (\Exception $e) {
            return to_route('perhitungan')->with('error', 'Perhitungan Metode SMART Gagal Dilakukan: ' . $e->getMessage());
        }
    }
}