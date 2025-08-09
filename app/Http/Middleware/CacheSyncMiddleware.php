<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\NilaiAkhir;
use Illuminate\Support\Facades\Log;

/**
 * Middleware untuk memastikan sinkronisasi data admin dashboard
 * Akan membersihkan cache ketika ada perubahan data
 */
class CacheSyncMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // List of routes yang mempengaruhi data perhitungan
        $dataAffectingRoutes = [
            'kriteria.store',
            'kriteria.update',
            'kriteria.destroy',
            'alternatif.store',
            'alternatif.update',
            'alternatif.destroy',
            'penilaian.store',
            'penilaian.update',
            'penilaian.destroy',
            'nilai-utility.calculate',
            'nilai-akhir.calculate',
            'normalisasi-bobot.calculate',
            'sub-kriteria.store',
            'sub-kriteria.update',
            'sub-kriteria.destroy',
        ];

        // Cek jika request adalah POST, PUT, PATCH, DELETE ke route yang mempengaruhi data
        if (
            in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']) &&
            $this->isDataAffectingRoute($request, $dataAffectingRoutes)
        ) {

            // Clear semua cache yang terkait
            $this->clearCalculationCache();

            Log::info('Cache cleared due to data modification', [
                'route' => $request->route()->getName(),
                'method' => $request->method(),
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);
        }

        $response = $next($request);

        // Jika response adalah redirect dengan success message (menandakan perubahan data)
        if (
            $response->getStatusCode() === 302 &&
            session()->has(['success', 'updated', 'created', 'deleted'])
        ) {

            $this->clearCalculationCache();

            Log::info('Cache cleared after successful data operation', [
                'session_messages' => session()->only(['success', 'updated', 'created', 'deleted']),
                'timestamp' => now()
            ]);
        }

        return $response;
    }

    /**
     * Cek apakah route saat ini mempengaruhi data perhitungan
     */
    private function isDataAffectingRoute(Request $request, array $routes): bool
    {
        $currentRoute = $request->route()->getName();

        // Cek exact match
        if (in_array($currentRoute, $routes)) {
            return true;
        }

        // Cek pattern match untuk route yang mempengaruhi perhitungan
        foreach ($routes as $route) {
            if (str_contains($currentRoute, $route) || str_contains($route, '*')) {
                return true;
            }
        }

        // Cek berdasarkan URI pattern untuk admin dashboard
        $uri = $request->path();
        $dataAffectingUris = [
            'dashboard/kriteria',
            'dashboard/alternatif',
            'dashboard/penilaian',
            'dashboard/sub-kriteria',
            'dashboard/nilai-utility',
            'dashboard/nilai-akhir',
            'dashboard/normalisasi',
            'dashboard/calculate',
            'dashboard/recalculate',
        ];

        foreach ($dataAffectingUris as $pattern) {
            if (str_contains($uri, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Membersihkan semua cache yang terkait dengan perhitungan admin
     */
    private function clearCalculationCache(): void
    {
        try {
            // Cache keys yang perlu dibersihkan untuk admin dashboard
            $cacheKeys = [
                'has_calculation_results_v2',
                'admin_ranking_data',
                'admin_system_stats',
                'calculation_timestamp',
                'dashboard_stats',
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            // Update timestamp cache clearing
            Cache::put('last_cache_clear', now(), 60); // Cache for 1 hour

            // Optional: Set flag bahwa data telah berubah
            Cache::put('data_updated', true, 300); // Cache for 5 minutes

        } catch (\Exception $e) {
            Log::error('Error clearing calculation cache', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Static method untuk clear cache dari controller
     */
    public static function clearCache(): void
    {
        $middleware = new self();
        $middleware->clearCalculationCache();
    }
}