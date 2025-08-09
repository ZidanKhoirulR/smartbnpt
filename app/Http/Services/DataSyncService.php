<?php

namespace App\Services;

use App\Models\NilaiAkhir;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NormalisasiBobot;
use App\Models\NilaiUtility;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Service untuk mengelola sinkronisasi data antara admin dan public
 * Memastikan konsistensi data dan performa optimal
 */
class DataSyncService
{
    const CACHE_TTL = 3600; // 1 jam
    const MAX_RECIPIENTS = 150;

    /**
     * Mendapatkan data ranking yang konsisten untuk admin dan public
     */
    public function getRankingData(bool $useCache = true): array
    {
        $cacheKey = 'consistent_ranking_data';

        if ($useCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // Query yang konsisten untuk semua penggunaan
            $rankingData = NilaiAkhir::query()
                ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
                ->selectRaw("
                    a.id,
                    a.kode,
                    a.nik,
                    a.alternatif,
                    a.keterangan,
                    SUM(nilai_akhir.nilai) as nilai,
                    a.created_at,
                    ROW_NUMBER() OVER (
                        ORDER BY SUM(nilai_akhir.nilai) DESC, a.created_at ASC
                    ) as ranking
                ")
                ->groupBy('a.id', 'a.kode', 'a.nik', 'a.alternatif', 'a.keterangan', 'a.created_at')
                ->orderByRaw('SUM(nilai_akhir.nilai) DESC, a.created_at ASC')
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'id' => $item->id,
                        'kode' => $item->kode,
                        'nik' => $item->nik,
                        'alternatif' => $item->alternatif,
                        'keterangan' => $item->keterangan,
                        'nilai' => round($item->nilai, 4),
                        'ranking' => $item->ranking,
                        'status' => $item->ranking <= self::MAX_RECIPIENTS ? 'Diterima' : 'Tidak Diterima',
                        'created_at' => $item->created_at
                    ];
                });

            $result = [
                'data' => $rankingData,
                'total_alternatif' => $rankingData->count(),
                'total_diterima' => $rankingData->where('status', 'Diterima')->count(),
                'total_tidak_diterima' => $rankingData->where('status', 'Tidak Diterima')->count(),
                'last_updated' => now(),
                'has_data' => $rankingData->isNotEmpty()
            ];

            // Cache hasil
            if ($useCache) {
                Cache::put($cacheKey, $result, self::CACHE_TTL);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Error in getRankingData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'data' => collect(),
                'total_alternatif' => 0,
                'total_diterima' => 0,
                'total_tidak_diterima' => 0,
                'last_updated' => now(),
                'has_data' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Mendapatkan status berdasarkan NIK
     */
    public function getStatusByNik(string $nik): ?object
    {
        try {
            $alternatif = Alternatif::where('nik', $nik)->first();

            if (!$alternatif) {
                return null;
            }

            // Ambil data ranking
            $rankingData = $this->getRankingData();
            $targetData = $rankingData['data']->where('id', $alternatif->id)->first();

            if (!$targetData) {
                // Jika tidak ada di hasil perhitungan
                return (object) [
                    'kode' => $alternatif->kode,
                    'nik' => $alternatif->nik,
                    'alternatif' => $alternatif->alternatif,
                    'keterangan' => $alternatif->keterangan,
                    'nilai' => 0,
                    'ranking' => null,
                    'status' => 'Belum Dihitung',
                    'calculated' => false
                ];
            }

            return (object) [
                'kode' => $targetData->kode,
                'nik' => $targetData->nik,
                'alternatif' => $targetData->alternatif,
                'keterangan' => $targetData->keterangan,
                'nilai' => $targetData->nilai,
                'ranking' => $targetData->ranking,
                'status' => $targetData->status,
                'calculated' => true,
                'total_alternatif' => $rankingData['total_alternatif'],
                'batas_penerima' => self::MAX_RECIPIENTS
            ];

        } catch (\Exception $e) {
            Log::error('Error in getStatusByNik', [
                'nik' => $nik,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Cek apakah ada data hasil perhitungan
     */
    public function hasCalculationResults(): bool
    {
        $cacheKey = 'has_calculation_results_v2';

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return NilaiAkhir::exists();
        });
    }

    /**
     * Mendapatkan statistik sistem
     */
    public function getSystemStats(): array
    {
        $cacheKey = 'system_stats';

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            try {
                $totalAlternatif = Alternatif::count();
                $totalKriteria = Kriteria::count();
                $hasResults = NilaiAkhir::exists();
                $totalPenerima = min($totalAlternatif, self::MAX_RECIPIENTS);

                $lastCalculation = null;
                if ($hasResults) {
                    $lastCalculation = NilaiAkhir::max('updated_at');
                }

                return [
                    'total_alternatif' => $totalAlternatif,
                    'total_kriteria' => $totalKriteria,
                    'total_penerima' => $totalPenerima,
                    'has_results' => $hasResults,
                    'last_calculation' => $lastCalculation,
                    'max_recipients' => self::MAX_RECIPIENTS,
                    'last_updated' => now()
                ];

            } catch (\Exception $e) {
                Log::error('Error in getSystemStats', [
                    'error' => $e->getMessage()
                ]);

                return [
                    'total_alternatif' => 0,
                    'total_kriteria' => 0,
                    'total_penerima' => 0,
                    'has_results' => false,
                    'last_calculation' => null,
                    'max_recipients' => self::MAX_RECIPIENTS,
                    'last_updated' => now(),
                    'error' => true
                ];
            }
        });
    }

    /**
     * Mendapatkan data untuk PDF yang konsisten
     */
    public function getPDFData(): array
    {
        try {
            $judul = 'Laporan Hasil Akhir Perankingan Bantuan Sosial';

            // Ambil data dengan query yang konsisten
            $tabelPenilaian = Penilaian::with(['kriteria', 'subKriteria', 'alternatif'])->get();
            $tabelNormalisasi = NormalisasiBobot::with('kriteria')->get();
            $tabelUtility = NilaiUtility::with(['kriteria', 'alternatif'])->get();
            $tabelNilaiAkhir = NilaiAkhir::with(['kriteria', 'alternatif'])->get();

            // Data perankingan yang konsisten
            $rankingData = $this->getRankingData();
            $tabelPerankingan = $rankingData['data'];

            $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
            $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);

            return [
                'judul' => $judul,
                'tabelPenilaian' => $tabelPenilaian,
                'tabelNormalisasi' => $tabelNormalisasi,
                'tabelUtility' => $tabelUtility,
                'tabelNilaiAkhir' => $tabelNilaiAkhir,
                'tabelPerankingan' => $tabelPerankingan,
                'kriteria' => $kriteria,
                'alternatif' => $alternatif,
                'stats' => $rankingData
            ];

        } catch (\Exception $e) {
            Log::error('Error in getPDFData', [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Clear semua cache terkait perhitungan
     */
    public function clearAllCache(): void
    {
        try {
            $cacheKeys = [
                'consistent_ranking_data',
                'has_calculation_results_v2',
                'system_stats',
                'last_cache_clear',
                'data_updated'
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            // Set timestamp cache clearing
            Cache::put('last_cache_clear', now(), 60);

            Log::info('All calculation cache cleared successfully');

        } catch (\Exception $e) {
            Log::error('Error clearing all cache', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Validasi konsistensi data
     */
    public function validateDataConsistency(): array
    {
        try {
            $issues = [];

            // Cek apakah ada alternatif tanpa penilaian
            $alternatifTanpaPenilaian = Alternatif::whereDoesntHave('penilaian')->count();
            if ($alternatifTanpaPenilaian > 0) {
                $issues[] = "Ada {$alternatifTanpaPenilaian} alternatif tanpa penilaian";
            }

            // Cek apakah ada nilai akhir tanpa referensi alternatif
            $nilaiAkhirOrphan = NilaiAkhir::whereDoesntHave('alternatif')->count();
            if ($nilaiAkhirOrphan > 0) {
                $issues[] = "Ada {$nilaiAkhirOrphan} nilai akhir tanpa referensi alternatif";
            }

            // Cek konsistensi jumlah kriteria
            $totalKriteria = Kriteria::count();
            $expectedPenilaianPerAlternatif = $totalKriteria;

            $alternatifWithIncompleteData = DB::table('alternatif as a')
                ->leftJoin('penilaian as p', 'a.id', '=', 'p.alternatif_id')
                ->groupBy('a.id')
                ->havingRaw('COUNT(p.id) != ?', [$expectedPenilaianPerAlternatif])
                ->count();

            if ($alternatifWithIncompleteData > 0) {
                $issues[] = "Ada {$alternatifWithIncompleteData} alternatif dengan data penilaian tidak lengkap";
            }

            return [
                'is_consistent' => empty($issues),
                'issues' => $issues,
                'total_alternatif' => Alternatif::count(),
                'total_kriteria' => $totalKriteria,
                'checked_at' => now()
            ];

        } catch (\Exception $e) {
            Log::error('Error in validateDataConsistency', [
                'error' => $e->getMessage()
            ]);

            return [
                'is_consistent' => false,
                'issues' => ['Error saat validasi: ' . $e->getMessage()],
                'total_alternatif' => 0,
                'total_kriteria' => 0,
                'checked_at' => now()
            ];
        }
    }

    /**
     * Force refresh semua data cache
     */
    public function forceRefresh(): array
    {
        try {
            // Clear all cache first
            $this->clearAllCache();

            // Regenerate cache dengan data fresh
            $rankingData = $this->getRankingData(false); // Force tanpa cache
            $systemStats = $this->getSystemStats(); // Will use fresh data since cache cleared
            $validation = $this->validateDataConsistency();

            return [
                'success' => true,
                'message' => 'Data cache berhasil di-refresh',
                'ranking_count' => $rankingData['data']->count(),
                'has_results' => $systemStats['has_results'],
                'validation' => $validation,
                'refreshed_at' => now()
            ];

        } catch (\Exception $e) {
            Log::error('Error in forceRefresh', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal refresh data cache: ' . $e->getMessage(),
                'refreshed_at' => now()
            ];
        }
    }

    /**
     * Mendapatkan informasi cache status
     */
    public function getCacheInfo(): array
    {
        return [
            'has_ranking_cache' => Cache::has('consistent_ranking_data'),
            'has_stats_cache' => Cache::has('system_stats'),
            'has_results_cache' => Cache::has('has_calculation_results_v2'),
            'last_clear' => Cache::get('last_cache_clear'),
            'data_updated' => Cache::get('data_updated', false),
            'cache_ttl' => self::CACHE_TTL,
            'current_time' => now()
        ];
    }

    /**
     * Generate message untuk status pencarian NIK
     */
    public function generateStatusMessage(object $result): string
    {
        if (!$result->calculated) {
            return "Data ditemukan! {$result->alternatif} (NIK: {$result->nik}) belum dihitung dalam sistem SMARTER-ROC. Silakan hubungi administrator.";
        }

        $baseMessage = "Data ditemukan! {$result->alternatif} (NIK: {$result->nik}) ";
        $baseMessage .= "mendapat nilai {$result->nilai} dengan ranking {$result->ranking} dari {$result->total_alternatif} peserta.";

        if ($result->status === 'Diterima') {
            return $baseMessage . " Status: DITERIMA sebagai penerima bantuan sosial.";
        } else {
            $kurangRanking = $result->ranking - $result->batas_penerima;
            return $baseMessage . " Status: TIDAK DITERIMA (kelebihan {$kurangRanking} dari batas {$result->batas_penerima} penerima).";
        }
    }
}