<?php

namespace App\Http\Controllers;

use App\Models\NilaiAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    const THRESHOLD_VALUE = 0.75;

    public function index()
    {
        // Halaman welcome utama
        $title = "Selamat Datang";
        return view('welcome', compact('title'));
    }

    public function hasilAkhir()
    {
        $title = "Hasil Akhir";

        try {
            // Debug: Cek total data di nilai_akhir
            $totalNilaiAkhir = NilaiAkhir::count();

            if ($totalNilaiAkhir === 0) {
                return view('public.hasil-akhir-kosong', [
                    'title' => $title,
                    'error' => 'Hasil perhitungan belum tersedia. Silakan hubungi administrator untuk melakukan perhitungan terlebih dahulu.',
                    'details' => [
                        'Tidak ada data dalam tabel hasil akhir',
                        'Perhitungan SMARTER-ROC belum dilakukan',
                        'Silakan hubungi admin untuk memproses data'
                    ]
                ]);
            }

            // Query utama - pastikan semua alternatif muncul termasuk yang nilai 0
            $nilaiAkhir = NilaiAkhir::query()
                ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw("
                    a.kode, 
                    a.nik,
                    a.alternatif, 
                    a.created_at,
                    COALESCE(CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)), 0.0000) as nilai_raw
                ")
                ->groupBy('a.id', 'a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
                ->orderByRaw('nilai_raw DESC, a.created_at ASC') // Urutkan berdasarkan nilai, termasuk 0
                ->get()
                ->map(function ($item, $index) {
                    // Konversi nilai ke float untuk konsistensi
                    $nilai = (float) $item->nilai_raw;

                    // Format untuk display
                    $item->nilai_formatted = number_format($nilai, 4);
                    $item->nilai = $item->nilai_formatted; // Untuk kompatibilitas dengan view
                    $item->ranking = $index + 1;

                    // Status berdasarkan threshold
                    $item->status = $nilai >= self::THRESHOLD_VALUE ? 'DITERIMA' : 'TIDAK DITERIMA';

                    return $item;
                });

            // Debug: Log jumlah data yang ditemukan
            \Log::info("Public Hasil Akhir - Total data ditemukan: " . $nilaiAkhir->count());

            if ($nilaiAkhir->isEmpty()) {
                return view('public.hasil-akhir-kosong', [
                    'title' => $title,
                    'error' => 'Data tidak dapat ditampilkan. Terjadi masalah dalam pemrosesan data.',
                    'details' => [
                        'Query tidak mengembalikan hasil',
                        'Kemungkinan ada masalah relasi data',
                        'Silakan hubungi administrator sistem'
                    ]
                ]);
            }

            // Debug: Log beberapa sampel data
            \Log::info("Sample data:", [
                'first' => $nilaiAkhir->first(),
                'last' => $nilaiAkhir->last(),
                'count' => $nilaiAkhir->count()
            ]);

            return view('public.hasil-akhir', compact('title', 'nilaiAkhir'));

        } catch (\Exception $e) {
            \Log::error("Error di hasilAkhir: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());

            return view('public.hasil-akhir-kosong', [
                'title' => $title,
                'error' => 'Terjadi kesalahan sistem saat mengambil data hasil akhir.',
                'details' => [
                    'Error: ' . $e->getMessage(),
                    'Silakan hubungi administrator sistem',
                    'Atau coba akses kembali beberapa saat lagi'
                ]
            ]);
        }
    }

    // Method untuk pencarian berdasarkan NIK (untuk welcome page)
    public function searchByNik($nik)
    {
        try {
            $result = NilaiAkhir::query()
                ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
                ->where('a.nik', $nik)
                ->selectRaw("
                    a.kode, 
                    a.nik,
                    a.alternatif, 
                    a.created_at,
                    COALESCE(CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)), 0.0000) as nilai_raw
                ")
                ->groupBy('a.id', 'a.kode', 'a.nik', 'a.alternatif', 'a.created_at')
                ->first();

            if (!$result) {
                return null;
            }

            // Hitung ranking dengan query terpisah - termasuk nilai 0
            $ranking = NilaiAkhir::query()
                ->join('alternatif as a2', 'a2.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw("
                    COALESCE(CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)), 0.0000) as total_nilai, 
                    a2.created_at
                ")
                ->groupBy('a2.id', 'a2.created_at')
                ->havingRaw(
                    'total_nilai > ? OR (total_nilai = ? AND a2.created_at < ?)',
                    [$result->nilai_raw, $result->nilai_raw, $result->created_at]
                )
                ->count() + 1;

            $result->ranking = $ranking;

            // Status berdasarkan threshold
            $nilai = (float) $result->nilai_raw;
            $result->status = $nilai >= self::THRESHOLD_VALUE ? 'DITERIMA' : 'TIDAK DITERIMA';

            // Format nilai untuk display
            $result->nilai = number_format($nilai, 4);

            return $result;

        } catch (\Exception $e) {
            \Log::error("Error di searchByNik: " . $e->getMessage());
            return null;
        }
    }

    // Method untuk mendapatkan statistik hasil akhir
    public function getStatistikHasilAkhir()
    {
        try {
            $nilaiAkhir = NilaiAkhir::query()
                ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw("
                    a.kode, 
                    a.nik,
                    a.alternatif, 
                    COALESCE(CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)), 0.0000) as nilai_raw
                ")
                ->groupBy('a.id', 'a.kode', 'a.nik', 'a.alternatif')
                ->get();

            $totalAlternatif = $nilaiAkhir->count();
            $totalDiterima = $nilaiAkhir->filter(function ($item) {
                return (float) $item->nilai_raw >= self::THRESHOLD_VALUE;
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

        } catch (\Exception $e) {
            \Log::error("Error di getStatistikHasilAkhir: " . $e->getMessage());
            return [
                'total_alternatif' => 0,
                'total_diterima' => 0,
                'total_tidak_diterima' => 0,
                'persentase_diterima' => 0,
                'threshold' => self::THRESHOLD_VALUE
            ];
        }
    }

    // Method untuk debug - bisa digunakan sementara untuk testing
    public function debugNilaiAkhir()
    {
        try {
            // 1. Cek data mentah
            $rawData = DB::table('nilai_akhir')
                ->join('alternatif', 'alternatif.id', '=', 'nilai_akhir.alternatif_id')
                ->select(
                    'alternatif.kode',
                    'alternatif.alternatif',
                    'nilai_akhir.nilai'
                )
                ->orderBy('alternatif.kode')
                ->get();

            // 2. Cek hasil SUM
            $sumData = DB::table('nilai_akhir')
                ->join('alternatif', 'alternatif.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw('
                    alternatif.kode,
                    alternatif.alternatif,
                    COALESCE(CAST(SUM(nilai_akhir.nilai) AS DECIMAL(10,4)), 0.0000) as total_nilai
                ')
                ->groupBy('alternatif.id', 'alternatif.kode', 'alternatif.alternatif')
                ->orderByRaw('total_nilai DESC')
                ->get();

            return response()->json([
                'raw_count' => $rawData->count(),
                'sum_count' => $sumData->count(),
                'raw_sample' => $rawData->take(5),
                'sum_sample' => $sumData->take(5),
                'sum_all' => $sumData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}