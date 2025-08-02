<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\SubKriteria;

class DashboardController extends Controller
{
    const MAX_RECIPIENTS = 150; // Konstanta untuk batasan penerima

    public function index()
    {
        $title = "Dashboard";

        $jmlKriteria = Kriteria::count();
        $jmlSubKriteria = SubKriteria::count();
        $jmlAlternatif = Alternatif::count();

        $nilaiAkhir = NilaiAkhir::selectRaw('alternatif_id, SUM(nilai) as nilai')->groupBy('alternatif_id')->orderBy('alternatif_id', 'asc')->get();

        return view('dashboard/index', compact('title', 'jmlKriteria', 'jmlSubKriteria', 'jmlAlternatif', 'nilaiAkhir'));
    }

    public function hasilAkhir()
    {
        $title = "Hasil Akhir";

        // Query dengan ranking dan tie-breaking
        $nilaiAkhir = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.kode, 
                a.nik,
                a.alternatif, 
                SUM(nilai_akhir.nilai) as nilai,
                ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, a.created_at ASC) as ranking
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
            ->orderBy('nilai', 'desc')
            ->orderBy('a.created_at', 'asc') // Tie-breaker
            ->get()
            ->map(function ($item) {
                // Tentukan status berdasarkan ranking
                $item->status = $item->ranking <= self::MAX_RECIPIENTS ? 'Diterima' : 'Tidak Diterima';
                return $item;
            });

        return view('dashboard.hasil-akhir.index', compact('title', 'nilaiAkhir'));
    }

    // Method untuk pencarian berdasarkan NIK (akan digunakan di welcome page)
    public function searchByNik($nik)
    {
        $result = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->where('a.nik', $nik)
            ->selectRaw("
                a.kode, 
                a.nik,
                a.alternatif, 
                SUM(nilai_akhir.nilai) as nilai
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif')
            ->first();

        if (!$result) {
            return null;
        }

        // Hitung ranking
        $ranking = NilaiAkhir::query()
            ->join('alternatif as a2', 'a2.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("SUM(nilai_akhir.nilai) as total_nilai, a2.created_at")
            ->groupBy('a2.id', 'a2.created_at')
            ->havingRaw(
                'total_nilai > ? OR (total_nilai = ? AND a2.created_at < (SELECT created_at FROM alternatif WHERE nik = ?))',
                [$result->nilai, $result->nilai, $nik]
            )
            ->count() + 1;

        $result->ranking = $ranking;
        $result->status = $ranking <= self::MAX_RECIPIENTS ? 'Diterima' : 'Tidak Diterima';

        return $result;
    }
}