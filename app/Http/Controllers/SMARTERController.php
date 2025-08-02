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
    public function indexNormalisasiBobot()
    {
        $title = "Normalisasi Bobot SMARTER";
        $normalisasiBobot = NormalisasiBobotResource::collection(NormalisasiBobot::with('kriteria')->orderBy('kriteria_id', 'asc')->get());
        $sumBobot = Kriteria::sum('bobot');
        return view('dashboard.normalisasi-bobot.index', compact('title', 'normalisasiBobot', 'sumBobot'));
    }

    public function perhitunganNormalisasiBobot()
    {
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        $sumBobot = $kriteria->sum('bobot');

        if ($sumBobot == 0) {
            return to_route('normalisasi-bobot')->with('error', 'Total bobot kriteria tidak boleh 0');
        }

        NormalisasiBobot::truncate();
        $createNormalisasi = false;

        // SMARTER menggunakan normalisasi langsung tanpa pembagian
        // Bobot sudah dalam bentuk persentase, langsung dibagi 100
        foreach ($kriteria as $item) {
            $createNormalisasi = NormalisasiBobot::create([
                'kriteria_id' => $item->id,
                'normalisasi' => round($item->bobot / 100, 4), // Bobot dalam persen dibagi 100
            ]);
        }

        if ($createNormalisasi) {
            return to_route('normalisasi-bobot')->with('success', 'Normalisasi Bobot SMARTER Berhasil Dilakukan');
        } else {
            return to_route('normalisasi-bobot')->with('error', 'Normalisasi Bobot SMARTER Gagal Dilakukan');
        }
    }

    public function indexNilaiUtility()
    {
        $title = "Nilai Utility SMARTER";
        $nilaiUtility = NilaiUtilityResource::collection(NilaiUtility::orderBy('alternatif_id', 'asc')->orderBy('kriteria_id', 'asc')->get());
        $alternatif = AlternatifResource::collection(Alternatif::orderBy('kode', 'asc')->get());
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('kode', 'asc')->get());
        return view('dashboard.nilai-utility.index', compact('title', 'nilaiUtility', 'alternatif', 'kriteria'));
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

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $kriteriaNilai = $nilaiMaxMin->where('kriteria_id', $value->id)->first();

                if (!$kriteriaNilai) {
                    continue;
                }

                $nilaiMax = $kriteriaNilai->nilaiMax;
                $nilaiMin = $kriteriaNilai->nilaiMin;
                $jenisKriteria = $kriteriaNilai->jenis_kriteria;

                $penilaianData = Penilaian::where('kriteria_id', $value->id)
                    ->where('alternatif_id', $item->id)
                    ->with('subKriteria')
                    ->first();

                if (!$penilaianData || !$penilaianData->subKriteria) {
                    continue;
                }

                $nilaiSubKriteria = $penilaianData->subKriteria->bobot;
                $divisor = $nilaiMax - $nilaiMin;

                // SMARTER: