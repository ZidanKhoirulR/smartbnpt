<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    const MAX_RECIPIENTS = 150; // Konstanta untuk batasan penerima
    const THRESHOLD_VALUE = 0.75; // Konstanta untuk threshold penerimaan

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

        // Query dengan ranking dan status berdasarkan threshold 0.75
        $nilaiAkhir = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.kode, 
                a.nik,
                a.alternatif, 
                CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)) as nilai,
                ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, a.created_at ASC) as ranking
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
            ->orderBy('nilai', 'desc')
            ->orderBy('a.created_at', 'asc') // Tie-breaker
            ->get()
            ->map(function ($item) {
                // Tentukan status berdasarkan threshold 0.75
                $nilai = (float) $item->nilai;
                $item->status = $nilai >= self::THRESHOLD_VALUE ? 'DITERIMA' : 'TIDAK DITERIMA';

                // Format nilai untuk display yang konsisten
                $item->nilai = number_format($nilai, 4);

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
                CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)) as nilai
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif')
            ->first();

        if (!$result) {
            return null;
        }

        // Hitung ranking
        $ranking = NilaiAkhir::query()
            ->join('alternatif as a2', 'a2.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)) as total_nilai, a2.created_at")
            ->groupBy('a2.id', 'a2.created_at')
            ->havingRaw(
                'total_nilai > ? OR (total_nilai = ? AND a2.created_at < (SELECT created_at FROM alternatif WHERE nik = ?))',
                [$result->nilai, $result->nilai, $nik]
            )
            ->count() + 1;

        $result->ranking = $ranking;

        // Status berdasarkan threshold, bukan ranking
        $nilai = (float) $result->nilai;
        $result->status = $nilai >= self::THRESHOLD_VALUE ? 'DITERIMA' : 'TIDAK DITERIMA';

        // Format nilai untuk display
        $result->nilai = number_format($nilai, 4);

        return $result;
    }

    // Method untuk mendapatkan statistik hasil akhir
    public function getStatistikHasilAkhir()
    {
        $nilaiAkhir = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.kode, 
                a.nik,
                a.alternatif, 
                CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)) as nilai
            ")
            ->groupBy('a.kode', 'a.nik', 'a.alternatif')
            ->get();

        $totalAlternatif = $nilaiAkhir->count();
        $totalDiterima = $nilaiAkhir->filter(function ($item) {
            return (float) $item->nilai >= self::THRESHOLD_VALUE;
        })->count();
        $totalTidakDiterima = $totalAlternatif - $totalDiterima;

        $persentaseDiterima = $totalAlternatif > 0 ? ($totalDiterima / $totalAlternatif) * 100 : 0;

        return [
            'total_alternatif' => $totalAlternatif,
            'total_diterima' => $totalDiterima,
            'total_tidak_diterima' => $totalTidakDiterima,
            'persentase_diterima' => number_format($persentaseDiterima, 1),
            'threshold' => self::THRESHOLD_VALUE
        ];
    }

    // Method untuk validasi data hasil akhir
    public function validateHasilAkhir()
    {
        try {
            // Cek apakah ada data nilai akhir
            $nilaiAkhirCount = NilaiAkhir::count();
            if ($nilaiAkhirCount === 0) {
                return [
                    'valid' => false,
                    'message' => 'Tidak ada data nilai akhir. Silakan lakukan perhitungan terlebih dahulu.',
                    'data' => []
                ];
            }

            // Cek konsistensi data
            $alternatifCount = Alternatif::count();
            $alternatifWithNilai = NilaiAkhir::distinct('alternatif_id')->count('alternatif_id');

            if ($alternatifCount !== $alternatifWithNilai) {
                return [
                    'valid' => false,
                    'message' => "Inkonsistensi data: {$alternatifCount} alternatif tetapi hanya {$alternatifWithNilai} yang memiliki nilai akhir.",
                    'data' => [
                        'total_alternatif' => $alternatifCount,
                        'alternatif_dengan_nilai' => $alternatifWithNilai
                    ]
                ];
            }

            // Cek apakah ada nilai null atau invalid
            $invalidNilai = NilaiAkhir::whereNull('nilai')
                ->orWhere('nilai', '')
                ->orWhere('nilai', '<', 0)
                ->orWhere('nilai', '>', 1)
                ->count();

            if ($invalidNilai > 0) {
                return [
                    'valid' => false,
                    'message' => "Ditemukan {$invalidNilai} nilai akhir yang tidak valid (null, kosong, atau di luar rentang 0-1).",
                    'data' => ['invalid_nilai_count' => $invalidNilai]
                ];
            }

            return [
                'valid' => true,
                'message' => 'Data hasil akhir valid dan siap ditampilkan.',
                'data' => $this->getStatistikHasilAkhir()
            ];

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Error saat validasi data: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
}