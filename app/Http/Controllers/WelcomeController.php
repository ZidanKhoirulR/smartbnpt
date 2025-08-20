<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SMARTERHelper;
use App\Models\NilaiAkhir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * Menampilkan hasil akhir untuk user umum (public)
     */
    public function hasilAkhir()
    {
        try {
            // Method 1: Coba ambil dari database nilai_akhir langsung
            $nilaiAkhir = $this->getNilaiAkhirFromDatabase();

            if (!empty($nilaiAkhir) && count($nilaiAkhir) > 0) {
                return view('public.hasil-akhir', [
                    'title' => 'Hasil Akhir BPNT',
                    'nilaiAkhir' => $nilaiAkhir
                ]);
            }

            // Method 2: Jika database kosong, coba gunakan SMARTERHelper
            return $this->getResultsFromSMARTERHelper();

        } catch (\Exception $e) {
            Log::error('Error in hasilAkhir: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return view('public.hasil-akhir-kosong', [
                'title' => 'Hasil Akhir BPNT',
                'error' => 'Terjadi kesalahan dalam memuat hasil akhir.',
                'details' => [
                    'Error: ' . $e->getMessage(),
                    'Silakan coba lagi nanti atau hubungi administrator.'
                ]
            ]);
        }
    }

    /**
     * Method 1: Ambil data langsung dari tabel nilai_akhir
     */
    private function getNilaiAkhirFromDatabase()
    {
        try {
            // Cek apakah tabel nilai_akhir ada data
            $count = DB::table('nilai_akhir')->count();
            if ($count === 0) {
                return null;
            }

            // Query dengan error handling untuk tipe data
            $results = DB::select("
                SELECT 
                    a.id as alternatif_id,
                    a.kode,
                    a.alternatif,
                    ROUND(SUM(
                        CASE 
                            WHEN na.nilai REGEXP '^[0-9]+([.][0-9]+)?$' 
                            THEN CAST(na.nilai AS DECIMAL(10,4))
                            WHEN na.nilai REGEXP '^[0-9]+([,][0-9]+)?$' 
                            THEN CAST(REPLACE(na.nilai, ',', '.') AS DECIMAL(10,4))
                            ELSE 0 
                        END
                    ), 4) as total_nilai,
                    ROUND(SUM(
                        CASE 
                            WHEN na.nilai REGEXP '^[0-9]+([.][0-9]+)?$' 
                            THEN CAST(na.nilai AS DECIMAL(10,4))
                            WHEN na.nilai REGEXP '^[0-9]+([,][0-9]+)?$' 
                            THEN CAST(REPLACE(na.nilai, ',', '.') AS DECIMAL(10,4))
                            ELSE 0 
                        END
                    ), 4) as nilai
                FROM nilai_akhir na
                JOIN alternatif a ON a.id = na.alternatif_id
                GROUP BY a.id, a.kode, a.alternatif
                HAVING total_nilai > 0
                ORDER BY total_nilai DESC
            ");

            if (!empty($results)) {
                return collect($results);
            }

            // Fallback ke query sederhana
            return $this->getFallbackResults();

        } catch (\Exception $e) {
            Log::error('Error in getNilaiAkhirFromDatabase: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fallback query yang lebih sederhana
     */
    private function getFallbackResults()
    {
        try {
            // Ambil semua data dan proses di PHP
            $nilaiAkhir = DB::table('nilai_akhir')
                ->join('alternatif', 'nilai_akhir.alternatif_id', '=', 'alternatif.id')
                ->select('alternatif.id', 'alternatif.kode', 'alternatif.alternatif', 'nilai_akhir.nilai')
                ->get();

            if ($nilaiAkhir->isEmpty()) {
                return null;
            }

            // Group dan sum di PHP
            $grouped = $nilaiAkhir->groupBy('id')->map(function ($group) {
                $first = $group->first();
                $totalNilai = $group->sum(function ($item) {
                    return $this->convertToNumeric($item->nilai);
                });

                return (object) [
                    'alternatif_id' => $first->id,
                    'kode' => $first->kode,
                    'alternatif' => $first->alternatif,
                    'total_nilai' => round($totalNilai, 4),
                    'nilai' => number_format(round($totalNilai, 4), 4)
                ];
            })->sortByDesc('total_nilai')->values();

            return $grouped;

        } catch (\Exception $e) {
            Log::error('Error in getFallbackResults: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Method 2: Gunakan SMARTERHelper dengan error handling
     */
    private function getResultsFromSMARTERHelper()
    {
        try {
            // Validasi data terlebih dahulu
            $validation = SMARTERHelper::validasiData();

            if (!$validation['valid']) {
                return view('public.hasil-akhir-kosong', [
                    'title' => 'Hasil Akhir BPNT',
                    'error' => 'Data belum lengkap untuk menampilkan hasil akhir.',
                    'details' => $validation['errors']
                ]);
            }

            // Coba hitung nilai akhir
            $nilaiAkhir = SMARTERHelper::hitungNilaiAkhir();

            // Jika tidak ada data hasil
            if (empty($nilaiAkhir)) {
                return view('public.hasil-akhir-kosong', [
                    'title' => 'Hasil Akhir BPNT',
                    'error' => 'Belum ada hasil perhitungan yang tersedia.',
                    'details' => ['Silakan hubungi admin untuk melakukan perhitungan SMARTER-ROC.']
                ]);
            }

            // Pastikan format data konsisten
            $formattedResults = collect($nilaiAkhir)->map(function ($item) {
                if (is_array($item)) {
                    $item = (object) $item;
                }

                // Pastikan ada field yang dibutuhkan
                if (!isset($item->nilai) && isset($item->total_nilai)) {
                    $item->nilai = $item->total_nilai;
                }

                return $item;
            });

            return view('public.hasil-akhir', [
                'title' => 'Hasil Akhir BPNT',
                'nilaiAkhir' => $formattedResults
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getResultsFromSMARTERHelper: ' . $e->getMessage());

            return view('public.hasil-akhir-kosong', [
                'title' => 'Hasil Akhir BPNT',
                'error' => 'Terjadi kesalahan dalam perhitungan SMARTER-ROC.',
                'details' => [
                    'Error: ' . $e->getMessage(),
                    'Silakan hubungi administrator untuk memperbaiki perhitungan.'
                ]
            ]);
        }
    }

    /**
     * Helper function untuk convert nilai ke numeric
     */
    private function convertToNumeric($value)
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            // Replace comma with dot
            $cleaned = str_replace(',', '.', $value);
            if (is_numeric($cleaned)) {
                return (float) $cleaned;
            }
        }

        return 0.0;
    }
}