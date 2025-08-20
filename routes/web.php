<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SMARTERController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\WelcomeController;
use App\Helpers\SMARTERHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Welcome page - hanya informational
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// PUBLIC Routes - Dapat diakses tanpa login
Route::prefix('public')->group(function () {
    // Hasil akhir untuk user umum (tidak perlu login)
    Route::get('/hasil-akhir', [WelcomeController::class, 'hasilAkhir'])->name('public.hasil-akhir');

    // PDF untuk user umum
    Route::get('/pdf-hasil-akhir', [PDFController::class, 'pdf_hasil_public'])->name('public.pdf.hasil');
});

// Auth routes
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes - Protected
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/hasil-akhir', [DashboardController::class, 'hasilAkhir'])->name('hasil-akhir');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kriteria Management
    Route::prefix('kriteria')->group(function () {
        Route::get('/', [KriteriaController::class, 'index'])->name('kriteria');
        Route::post('/simpan', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::get('/ubah', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::post('/ubah', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::post('/hapus', [KriteriaController::class, 'delete'])->name('kriteria.delete');
        Route::post('/impor', [KriteriaController::class, 'import'])->name('kriteria.import');
        Route::get('/reset-rankings', [KriteriaController::class, 'resetRankings'])->name('kriteria.reset-rankings.get');
        Route::post('/reset-rankings', [KriteriaController::class, 'resetRankings'])->name('kriteria.reset-rankings');
    });

    // Sub Kriteria Management
    Route::prefix('sub-kriteria')->group(function () {
        Route::get('/', [SubKriteriaController::class, 'index'])->name('sub-kriteria');
        Route::post('/simpan', [SubKriteriaController::class, 'store'])->name('sub-kriteria.store');
        Route::get('/ubah', [SubKriteriaController::class, 'edit'])->name('sub-kriteria.edit');
        Route::post('/ubah', [SubKriteriaController::class, 'update'])->name('sub-kriteria.update');
        Route::post('/hapus', [SubKriteriaController::class, 'delete'])->name('sub-kriteria.delete');
        Route::post('/impor', [SubKriteriaController::class, 'import'])->name('sub-kriteria.import');
    });

    // Alternatif Management
    Route::prefix('alternatif')->group(function () {
        Route::get('/', [AlternatifController::class, 'index'])->name('alternatif');
        Route::get('/lihat', [AlternatifController::class, 'show'])->name('alternatif.show');
        Route::post('/simpan', [AlternatifController::class, 'store'])->name('alternatif.store');
        Route::get('/ubah', [AlternatifController::class, 'edit'])->name('alternatif.edit');
        Route::post('/ubah', [AlternatifController::class, 'update'])->name('alternatif.update');
        Route::post('/hapus', [AlternatifController::class, 'delete'])->name('alternatif.delete');
        Route::post('/impor', [AlternatifController::class, 'import'])->name('alternatif.import');
    });

    // Penilaian Management
    Route::prefix('penilaian')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('penilaian');
        Route::get('/ubah', [PenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::post('/ubah', [PenilaianController::class, 'update'])->name('penilaian.update');
        Route::post('/impor', [PenilaianController::class, 'import'])->name('penilaian.import');
    });

    // SMARTER-ROC Calculations
    Route::prefix('smarter')->group(function () {
        // Perhitungan utama
        Route::get('/perhitungan', [SMARTERController::class, 'indexPerhitungan'])->name('perhitungan');
        Route::post('/perhitungan', [SMARTERController::class, 'perhitunganMetode'])->name('perhitungan.smart');
        Route::post('/perhitungan/smarter', [SMARTERController::class, 'perhitunganSMARTER'])->name('perhitungan.smarter');

        // Normalisasi Bobot ROC
        Route::get('/normalisasi-bobot', [SMARTERController::class, 'indexNormalisasiBobot'])->name('normalisasi-bobot');
        Route::post('/normalisasi-bobot', [SMARTERController::class, 'perhitunganNormalisasiBobot'])->name('normalisasi-bobot.perhitungan');
        Route::post('/normalisasi-bobot/hitung', [SMARTERController::class, 'perhitunganNormalisasiBobot'])->name('normalisasi-bobot.hitung');

        // Nilai Utility
        Route::get('/nilai-utility', [SMARTERController::class, 'indexNilaiUtility'])->name('nilai-utility');
        Route::post('/nilai-utility', [SMARTERController::class, 'perhitunganNilaiUtility'])->name('nilai-utility.perhitungan');
        Route::post('/nilai-utility/hitung', [SMARTERController::class, 'perhitunganNilaiUtility'])->name('nilai-utility.hitung');

        // Matriks Ternormalisasi - NEW ROUTES
        Route::get('/matriks-ternormalisasi', [SMARTERController::class, 'indexMatriksTernormalisasi'])->name('matriks-ternormalisasi');
        Route::post('/matriks-ternormalisasi', [SMARTERController::class, 'perhitunganMatriksTernormalisasi'])->name('matriks-ternormalisasi.perhitungan');
        Route::post('/matriks-ternormalisasi/hitung', [SMARTERController::class, 'perhitunganMatriksTernormalisasi'])->name('matriks-ternormalisasi.hitung');

        // Nilai Akhir
        Route::get('/nilai-akhir', [SMARTERController::class, 'indexNilaiAkhir'])->name('nilai-akhir');
        Route::post('/nilai-akhir', [SMARTERController::class, 'perhitunganNilaiAkhir'])->name('nilai-akhir.perhitungan');
        Route::post('/nilai-akhir/hitung', [SMARTERController::class, 'perhitunganNilaiAkhir'])->name('nilai-akhir.hitung');

        // Hasil Perhitungan Detail
        Route::get('/hasil-perhitungan', [SMARTERController::class, 'hasilPerhitungan'])->name('hasil-perhitungan');

        // PDF Export untuk admin
        Route::get('/pdf-hasil-akhir', [PDFController::class, 'pdf_hasil'])->name('pdf.hasil');
    });

    // API Routes untuk SMARTER-ROC (admin only)
    Route::prefix('api/smarter')->group(function () {
        Route::get('available-rankings', [KriteriaController::class, 'getAvailableRankings'])->name('api.smarter.available-rankings');
        Route::get('roc-weight-preview', [KriteriaController::class, 'getROCWeightPreview'])->name('api.smarter.roc-weight-preview');
        Route::post('reorder-rankings', [KriteriaController::class, 'reorderRankings'])->name('api.smarter.reorder-rankings');
        Route::post('reset-rankings', [KriteriaController::class, 'resetRankings'])->name('api.smarter.reset-rankings');

        Route::post('recalculate-roc', function () {
            $result = SMARTERHelper::recalculateAllROCWeights();
            return response()->json($result);
        })->name('api.smarter.recalculate-roc');

        Route::get('validate', function () {
            $validation = SMARTERHelper::validasiData();
            return response()->json($validation);
        })->name('api.smarter.validate');

        Route::get('laporan-lengkap', function () {
            $laporan = SMARTERHelper::generateLaporanLengkap();
            return response()->json($laporan);
        })->name('api.smarter.laporan-lengkap');
    });

    // Recalculate weights utility
    Route::post('kriteria/recalculate-weights', function () {
        $result = SMARTERHelper::recalculateAllROCWeights();

        if ($result['success']) {
            return redirect()->route('kriteria')
                ->with('success', $result['message'] . " ({$result['total_updated']} kriteria diupdate)");
        } else {
            return redirect()->route('kriteria')
                ->with('error', $result['message']);
        }
    })->name('kriteria.recalculate-weights');
});

Route::get('/debug-nilai-akhir', function () {
    try {
        echo "<h2>Debug Data Nilai Akhir</h2>";

        // 1. Cek jumlah data
        $nilaiAkhirCount = DB::table('nilai_akhir')->count();
        echo "<p>Total records di nilai_akhir: " . $nilaiAkhirCount . "</p>";

        if ($nilaiAkhirCount === 0) {
            echo "<p style='color: red;'>TIDAK ADA DATA di tabel nilai_akhir!</p>";
            return;
        }

        // 2. Cek struktur data
        echo "<h3>Sample Data (5 records pertama):</h3>";
        $sampleData = DB::table('nilai_akhir')->limit(5)->get();
        echo "<pre>" . json_encode($sampleData, JSON_PRETTY_PRINT) . "</pre>";

        // 3. Cek tipe data kolom nilai
        echo "<h3>Tipe Data Kolom 'nilai':</h3>";
        $columnInfo = DB::select("DESCRIBE nilai_akhir");
        foreach ($columnInfo as $column) {
            if ($column->Field === 'nilai') {
                echo "<pre>" . json_encode($column, JSON_PRETTY_PRINT) . "</pre>";
            }
        }

        // 4. Test query manual
        echo "<h3>Test Query Manual:</h3>";
        try {
            $testQuery = DB::select("
                SELECT 
                    a.kode,
                    a.alternatif,
                    na.nilai,
                    CAST(na.nilai AS DECIMAL(10,4)) as nilai_decimal
                FROM nilai_akhir na
                JOIN alternatif a ON a.id = na.alternatif_id
                LIMIT 10
            ");
            echo "<pre>" . json_encode($testQuery, JSON_PRETTY_PRINT) . "</pre>";
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }

        // 5. Test SUM query
        echo "<h3>Test SUM Query:</h3>";
        try {
            $sumQuery = DB::select("
                SELECT 
                    a.kode,
                    a.alternatif,
                    SUM(CAST(na.nilai AS DECIMAL(10,4))) as total_nilai
                FROM nilai_akhir na
                JOIN alternatif a ON a.id = na.alternatif_id
                GROUP BY a.id, a.kode, a.alternatif
                ORDER BY total_nilai DESC
                LIMIT 5
            ");
            echo "<pre>" . json_encode($sumQuery, JSON_PRETTY_PRINT) . "</pre>";
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error di SUM Query: " . $e->getMessage() . "</p>";
        }

        // 6. Cek data alternatif
        echo "<h3>Data Alternatif:</h3>";
        $alternatifCount = DB::table('alternatif')->count();
        echo "<p>Total alternatif: " . $alternatifCount . "</p>";

        // 7. Cek relasi
        echo "<h3>Cek Relasi nilai_akhir dengan alternatif:</h3>";
        $relationCheck = DB::select("
            SELECT 
                COUNT(*) as total_nilai_akhir,
                COUNT(DISTINCT na.alternatif_id) as distinct_alternatif_ids,
                COUNT(DISTINCT a.id) as valid_alternatif_relations
            FROM nilai_akhir na
            LEFT JOIN alternatif a ON a.id = na.alternatif_id
        ");
        echo "<pre>" . json_encode($relationCheck, JSON_PRETTY_PRINT) . "</pre>";

    } catch (\Exception $e) {
        echo "<p style='color: red;'>General Error: " . $e->getMessage() . "</p>";
        echo "<pre>Stack Trace:\n" . $e->getTraceAsString() . "</pre>";
    }
})->name('debug.nilai-akhir');

// Route untuk clear cache jika diperlukan
Route::get('/debug-clear-cache', function () {
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return "Cache cleared successfully!";
    } catch (\Exception $e) {
        return "Error clearing cache: " . $e->getMessage();
    }
})->name('debug.clear-cache');