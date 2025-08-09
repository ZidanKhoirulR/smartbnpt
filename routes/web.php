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

// API Routes untuk SMARTER-ROC
Route::prefix('api/smarter')->group(function () {

    // Get available rankings untuk form kriteria
    Route::get('available-rankings', [KriteriaController::class, 'getAvailableRankings'])
        ->name('api.smarter.available-rankings');

    // Preview bobot ROC berdasarkan ranking
    Route::get('roc-weight-preview', [KriteriaController::class, 'getROCWeightPreview'])
        ->name('api.smarter.roc-weight-preview');

    // Reorder rankings kriteria
    Route::post('reorder-rankings', [KriteriaController::class, 'reorderRankings'])
        ->name('api.smarter.reorder-rankings');

    // Reset semua rankings kriteria
    Route::post('reset-rankings', [KriteriaController::class, 'resetRankings'])
        ->name('api.smarter.reset-rankings');

    // Recalculate semua bobot ROC
    Route::post('recalculate-roc', function () {
        $result = SMARTERHelper::recalculateAllROCWeights();
        return response()->json($result);
    })->name('api.smarter.recalculate-roc');

    // Validasi data SMARTER
    Route::get('validate', function () {
        $validation = SMARTERHelper::validasiData();
        return response()->json($validation);
    })->name('api.smarter.validate');

    // Generate laporan lengkap
    Route::get('laporan-lengkap', function () {
        $laporan = SMARTERHelper::generateLaporanLengkap();
        return response()->json($laporan);
    })->name('api.smarter.laporan-lengkap');

});

// Web Routes untuk CRUD dengan middleware auth
Route::middleware(['auth'])->group(function () {

    // Additional web routes untuk kriteria management
    Route::post('kriteria/reset-rankings', [KriteriaController::class, 'resetRankings'])
        ->name('kriteria.reset-rankings');

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/search-nik', [WelcomeController::class, 'searchNik'])->name('search.nik');

// Tetap pakai controller untuk handle POST login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/hasil-akhir', [DashboardController::class, 'hasilAkhir'])->name('hasil-akhir');

    Route::group([
        'prefix' => 'kriteria',
    ], function () {
        Route::get('/reset-rankings', [KriteriaController::class, 'resetRankings'])->name('kriteria.reset-rankings.get');
        Route::post('/reset-rankings', [KriteriaController::class, 'resetRankings'])->name('kriteria.reset-rankings');
        Route::get('/', [KriteriaController::class, 'index'])->name('kriteria');
        Route::post('/simpan', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::get('/ubah', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::post('/ubah', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::post('/hapus', [KriteriaController::class, 'delete'])->name('kriteria.delete');
        Route::post('/impor', [KriteriaController::class, 'import'])->name('kriteria.import');
    });

    Route::group([
        'prefix' => 'sub-kriteria',
    ], function () {
        Route::get('/', [SubKriteriaController::class, 'index'])->name('sub-kriteria');
        Route::post('/simpan', [SubKriteriaController::class, 'store'])->name('sub-kriteria.store');
        Route::get('/ubah', [SubKriteriaController::class, 'edit'])->name('sub-kriteria.edit');
        Route::post('/ubah', [SubKriteriaController::class, 'update'])->name('sub-kriteria.update');
        Route::post('/hapus', [SubKriteriaController::class, 'delete'])->name('sub-kriteria.delete');
        Route::post('/impor', [SubKriteriaController::class, 'import'])->name('sub-kriteria.import');
        // Tambahan route untuk template download
        Route::get('/template', [SubKriteriaController::class, 'downloadTemplate'])->name('sub-kriteria.template');
    });

    Route::group([
        'prefix' => 'alternatif',
    ], function () {
        Route::get('/', [AlternatifController::class, 'index'])->name('alternatif');
        Route::get('/lihat', [AlternatifController::class, 'show'])->name('alternatif.show');
        Route::post('/simpan', [AlternatifController::class, 'store'])->name('alternatif.store');
        Route::get('/ubah', [AlternatifController::class, 'edit'])->name('alternatif.edit');
        Route::post('/ubah', [AlternatifController::class, 'update'])->name('alternatif.update');
        Route::post('/hapus', [AlternatifController::class, 'delete'])->name('alternatif.delete');
        Route::post('/impor', [AlternatifController::class, 'import'])->name('alternatif.import');
    });

    Route::group([
        'prefix' => 'penilaian',
    ], function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('penilaian');
        Route::get('/ubah', [PenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::post('/ubah', [PenilaianController::class, 'update'])->name('penilaian.update');
        Route::post('/impor', [PenilaianController::class, 'import'])->name('penilaian.import');
    });

    // Updated SMARTER routes with ROC integration
    Route::group([
        'prefix' => 'smarter',
    ], function () {
        // Route untuk halaman perhitungan utama
        Route::get('/perhitungan', [SMARTERController::class, 'indexPerhitungan'])->name('perhitungan');

        // Route untuk melakukan perhitungan SMARTER-ROC (updated)
        Route::post('/perhitungan', [SMARTERController::class, 'perhitunganMetode'])->name('perhitungan.smart');
        Route::post('/perhitungan/smarter', [SMARTERController::class, 'perhitunganSMARTER'])->name('perhitungan.smarter');

        // Routes untuk normalisasi bobot ROC (updated)
        Route::get('/normalisasi-bobot', [SMARTERController::class, 'indexNormalisasiBobot'])->name('normalisasi-bobot');
        Route::post('/normalisasi-bobot', [SMARTERController::class, 'perhitunganNormalisasiBobot'])->name('normalisasi-bobot.perhitungan');
        Route::post('/normalisasi-bobot/hitung', [SMARTERController::class, 'perhitunganNormalisasiBobot'])->name('normalisasi-bobot.hitung');

        // Routes untuk nilai utility (updated)
        Route::get('/nilai-utility', [SMARTERController::class, 'indexNilaiUtility'])->name('nilai-utility');
        Route::post('/nilai-utility', [SMARTERController::class, 'perhitunganNilaiUtility'])->name('nilai-utility.perhitungan');
        Route::post('/nilai-utility/hitung', [SMARTERController::class, 'perhitunganNilaiUtility'])->name('nilai-utility.hitung');

        // Routes untuk nilai akhir (updated)
        Route::get('/nilai-akhir', [SMARTERController::class, 'indexNilaiAkhir'])->name('nilai-akhir');
        Route::post('/nilai-akhir', [SMARTERController::class, 'perhitunganNilaiAkhir'])->name('nilai-akhir.perhitungan');
        Route::post('/nilai-akhir/hitung', [SMARTERController::class, 'perhitunganNilaiAkhir'])->name('nilai-akhir.hitung');

        // Route untuk hasil perhitungan detail (new)
        Route::get('/hasil-perhitungan', [SMARTERController::class, 'hasilPerhitungan'])->name('hasil-perhitungan');

        // Route untuk PDF hasil akhir
        Route::get('/pdf-hasil-akhir', [PDFController::class, 'pdf_hasil'])->name('pdf.hasilAkhir');

    });
});

require __DIR__ . '/auth.php';