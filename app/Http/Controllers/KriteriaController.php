<?php

namespace App\Http\Controllers;

use App\Http\Requests\KriteriaRequest;
use App\Http\Resources\KriteriaResource;
use App\Imports\KriteriaImport;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\NilaiUtility;
use App\Models\NormalisasiBobot;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Kriteria";

        // Pastikan semua kriteria memiliki ranking sebelum ditampilkan
        $this->ensureAllKriteriaHaveRanking();

        // Urutkan berdasarkan ranking, lalu kode sebagai fallback
        $kriteria = KriteriaResource::collection(
            Kriteria::orderByRaw('ranking IS NULL, ranking ASC')
                ->orderBy('kode', 'asc')
                ->get()
        );

        // HAPUS PERHITUNGAN SUM BOBOT KARENA MENGGUNAKAN ROC
        // $sumBobot = $kriteria->sum('bobot');

        // Generate kode otomatis
        $lastKode = Kriteria::orderBy('kode', 'desc')->first();
        if ($lastKode) {
            $kode = "K" . str_pad((int) substr($lastKode->kode, 1) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $kode = "K00001";
        }

        // HAPUS $sumBobot DARI COMPACT
        return view('dashboard.kriteria.index', compact('title', 'kriteria', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KriteriaRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $newRanking = $validated['ranking'];

            Log::info('Creating new kriteria with data:', $validated);

            // Validasi ranking tidak duplikat
            $existingRanking = Kriteria::where('ranking', $newRanking)->first();
            if ($existingRanking) {
                Log::info("Adjusting existing rankings from: {$newRanking}");
                // Adjust ranking untuk kriteria yang ada
                $this->adjustExistingRankings($newRanking);
            }

            // Buat kriteria baru (tanpa bobot karena tidak ada kolom bobot di database)
            $kriteria = Kriteria::create($validated);
            Log::info('Kriteria created with ID:', ['id' => $kriteria->id]);

            // Buat penilaian untuk semua alternatif yang ada
            $this->createPenilaianForAlternatif($kriteria->id);

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil disimpan dengan ranking ' . $newRanking);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing kriteria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return to_route('kriteria')->with('error', 'Kriteria gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $kriteriaId = $request->kriteria_id;

            if (!$kriteriaId) {
                Log::error('Kriteria ID not provided in edit request');
                return response()->json(['error' => 'ID tidak ditemukan'], 400);
            }

            $kriteria = Kriteria::find($kriteriaId);

            if (!$kriteria) {
                Log::error("Kriteria not found with ID: {$kriteriaId}");
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            // Log untuk debugging
            Log::info('Kriteria edit data:', $kriteria->toArray());

            // Return resource dengan format yang konsisten (tanpa bobot)
            return response()->json([
                'data' => [
                    'id' => $kriteria->id,
                    'kode' => $kriteria->kode,
                    'kriteria' => $kriteria->kriteria,
                    'ranking' => $kriteria->ranking,
                    'jenis_kriteria' => $kriteria->jenis_kriteria
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in kriteria edit: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KriteriaRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $kriteriaId = $request->id;

            Log::info('Updating kriteria with data:', $validated);

            if (!$kriteriaId) {
                throw new \Exception('ID Kriteria tidak valid');
            }

            // Ambil kriteria yang akan diupdate
            $kriteria = Kriteria::findOrFail($kriteriaId);
            $oldRanking = $kriteria->ranking;

            // UNTUK EDIT, RANKING TIDAK BERUBAH (SESUAI DENGAN FORM YANG READONLY)
            // Tapi jika ada perubahan ranking (untuk future development)
            if (isset($validated['ranking'])) {
                $newRanking = $validated['ranking'];
                if ($oldRanking != $newRanking) {
                    Log::info("Adjusting rankings for update: {$oldRanking} -> {$newRanking}");
                    $this->adjustRankingsForUpdate($kriteriaId, $oldRanking, $newRanking);
                }
            }

            // Update kriteria (tanpa bobot)
            $kriteria->update($validated);

            Log::info('Kriteria updated successfully');

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating kriteria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return to_route('kriteria')->with('error', 'Kriteria gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        // Validate input
        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id'
        ]);

        try {
            DB::beginTransaction();

            $kriteriaId = $request->kriteria_id;

            // Check if kriteria exists
            $kriteria = Kriteria::find($kriteriaId);
            if (!$kriteria) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kriteria tidak ditemukan'
                ], 404);
            }

            $deletedRanking = $kriteria->ranking;

            Log::info("Deleting kriteria with ID: {$kriteriaId}, ranking: {$deletedRanking}");

            // Check if kriteria is being used in calculations
            $hasActiveCalculations = NilaiAkhir::where('kriteria_id', $kriteriaId)->exists();
            if ($hasActiveCalculations) {
                Log::warning("Attempting to delete kriteria {$kriteriaId} that has active calculations");
                return response()->json([
                    'success' => false,
                    'message' => 'Kriteria tidak dapat dihapus karena masih digunakan dalam perhitungan'
                ], 422);
            }

            // Delete related records with error handling
            try {
                // Delete penilaian
                $deletedPenilaian = Penilaian::where('kriteria_id', $kriteriaId)->delete();
                Log::info("Deleted {$deletedPenilaian} penilaian records");

                // Delete sub kriteria
                $deletedSubKriteria = SubKriteria::where('kriteria_id', $kriteriaId)->delete();
                Log::info("Deleted {$deletedSubKriteria} sub kriteria records");

                // Delete normalisasi bobot
                $deletedNormalisasi = NormalisasiBobot::where('kriteria_id', $kriteriaId)->delete();
                Log::info("Deleted {$deletedNormalisasi} normalisasi bobot records");

                // Delete nilai utility
                $deletedUtility = NilaiUtility::where('kriteria_id', $kriteriaId)->delete();
                Log::info("Deleted {$deletedUtility} nilai utility records");

                // Delete nilai akhir
                $deletedNilaiAkhir = NilaiAkhir::where('kriteria_id', $kriteriaId)->delete();
                Log::info("Deleted {$deletedNilaiAkhir} nilai akhir records");

            } catch (\Exception $e) {
                Log::error('Error deleting related records: ' . $e->getMessage());
                throw new \Exception('Gagal menghapus data terkait: ' . $e->getMessage());
            }

            // Delete the kriteria itself
            $kriteria->delete();
            Log::info("Kriteria {$kriteriaId} successfully deleted");

            // Adjust ranking kriteria yang tersisa
            if ($deletedRanking) {
                try {
                    $this->adjustRankingsAfterDelete($deletedRanking);
                    Log::info("Rankings adjusted after deleting ranking {$deletedRanking}");
                } catch (\Exception $e) {
                    Log::error('Error adjusting rankings: ' . $e->getMessage());
                    // Don't fail the entire operation for ranking adjustment issues
                }
            }

            DB::commit();

            Log::info("Kriteria deletion completed successfully");

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error deleting kriteria: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Model not found error deleting kriteria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data kriteria tidak ditemukan'
            ], 404);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Database error deleting kriteria: ' . $e->getMessage(), [
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings()
            ]);

            // Check for foreign key constraint error
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak dapat dihapus karena masih digunakan di tabel lain'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('General error deleting kriteria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * METODE BARU: Hitung bobot menggunakan ROC (Rank Order Centroid)
     * Ini untuk keperluan perhitungan internal saja, tidak disimpan ke database
     */
    private function calculateROCWeight($ranking, $totalKriteria)
    {
        if ($totalKriteria == 0)
            return 0;

        $weight = 0;
        for ($k = $ranking; $k <= $totalKriteria; $k++) {
            $weight += 1 / $k;
        }

        return ($weight / $totalKriteria) * 100; // Dalam persentase
    }

    /**
     * METODE BARU: Mendapatkan semua bobot ROC untuk perhitungan
     * (tidak menyimpan ke database, hanya untuk perhitungan on-the-fly)
     */
    public function getROCWeights()
    {
        $allKriteria = Kriteria::orderBy('ranking', 'asc')->get();
        $totalKriteria = $allKriteria->count();
        $weights = [];

        foreach ($allKriteria as $kriteria) {
            if ($kriteria->ranking) {
                $weights[$kriteria->id] = $this->calculateROCWeight($kriteria->ranking, $totalKriteria);
            }
        }

        return $weights;
    }

    /**
     * Get ROC weights untuk semua kriteria (untuk digunakan di perhitungan SMARTER)
     * 
     * @return array
     */
    public function getAllROCWeights()
    {
        $kriteria = Kriteria::orderBy('ranking', 'asc')->get();
        $totalKriteria = $kriteria->count();
        $rocWeights = [];

        foreach ($kriteria as $item) {
            if ($item->ranking) {
                $rocWeights[$item->id] = [
                    'kode' => $item->kode,
                    'kriteria' => $item->kriteria,
                    'ranking' => $item->ranking,
                    'bobot_roc' => $this->calculateROCWeight($item->ranking, $totalKriteria),
                    'jenis_kriteria' => $item->jenis_kriteria
                ];
            }
        }

        return $rocWeights;
    }

    /**
     * Get ROC weight untuk kriteria tertentu
     * 
     * @param int $kriteriaId
     * @return float
     */
    public function getROCWeightForKriteria($kriteriaId)
    {
        $kriteria = Kriteria::findOrFail($kriteriaId);
        $totalKriteria = Kriteria::count();

        return $this->calculateROCWeight($kriteria->ranking, $totalKriteria);
    }

    /**
     * API endpoint untuk mendapatkan semua bobot ROC
     */
    public function apiGetROCWeights()
    {
        try {
            $rocWeights = $this->getAllROCWeights();

            return response()->json([
                'success' => true,
                'data' => $rocWeights,
                'total_kriteria' => count($rocWeights)
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting ROC weights: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Gagal mengambil bobot ROC'
            ], 500);
        }
    }

    /**
     * Import kriteria dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('import_data');
            Excel::import(new KriteriaImport, $file);

            // Re-generate ranking untuk semua kriteria yang di-import
            $this->regenerateAllRankings();

            // Recreate penilaian untuk semua kombinasi kriteria-alternatif
            $this->recreateAllPenilaian();

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil diimpor');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import error: ' . $e->getMessage());
            return to_route('kriteria')->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Pastikan semua kriteria memiliki ranking
     */
    private function ensureAllKriteriaHaveRanking()
    {
        $kriteriaWithoutRanking = Kriteria::whereNull('ranking')->get();
        if ($kriteriaWithoutRanking->count() > 0) {
            $maxRanking = Kriteria::max('ranking') ?? 0;
            foreach ($kriteriaWithoutRanking as $item) {
                $item->update(['ranking' => ++$maxRanking]);
            }
            Log::info("Updated {$kriteriaWithoutRanking->count()} kriteria with missing rankings");
        }
    }

    /**
     * Adjust ranking kriteria yang ada ketika menambah kriteria baru
     */
    private function adjustExistingRankings($newRanking)
    {
        // Geser ranking yang >= newRanking ke atas
        $updated = Kriteria::where('ranking', '>=', $newRanking)->increment('ranking');
        Log::info("Adjusted {$updated} existing rankings");
    }

    /**
     * Adjust ranking ketika update kriteria
     */
    private function adjustRankingsForUpdate($kriteriaId, $oldRanking, $newRanking)
    {
        if ($oldRanking > $newRanking) {
            // Pindah ke ranking yang lebih tinggi (angka lebih kecil)
            // Geser ranking yang di antara newRanking dan oldRanking ke bawah
            Kriteria::where('id', '!=', $kriteriaId)
                ->whereBetween('ranking', [$newRanking, $oldRanking - 1])
                ->increment('ranking');
        } else {
            // Pindah ke ranking yang lebih rendah (angka lebih besar)
            // Geser ranking yang di antara oldRanking dan newRanking ke atas
            Kriteria::where('id', '!=', $kriteriaId)
                ->whereBetween('ranking', [$oldRanking + 1, $newRanking])
                ->decrement('ranking');
        }
    }

    /**
     * Adjust ranking setelah delete kriteria
     */
    private function adjustRankingsAfterDelete($deletedRanking)
    {
        if (is_null($deletedRanking)) {
            return; // Tidak perlu adjust jika tidak ada ranking
        }

        // Geser semua ranking yang > deletedRanking turun satu tingkat
        Kriteria::where('ranking', '>', $deletedRanking)
            ->whereNotNull('ranking')
            ->decrement('ranking');
    }

    /**
     * Method untuk reset dan cleanup ranking yang rusak
     */
    public function resetRankings()
    {
        try {
            DB::beginTransaction();

            // Ambil semua kriteria, urutkan berdasarkan ranking lama (jika ada) atau ID
            $kriteria = Kriteria::orderByRaw('ranking IS NULL, ranking ASC')
                ->orderBy('id', 'asc')
                ->get();

            // Re-assign ranking secara berurutan
            foreach ($kriteria as $index => $item) {
                $item->update(['ranking' => $index + 1]);
            }

            DB::commit();

            return to_route('kriteria')->with('success', 'Ranking berhasil direset dan diurutkan ulang');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error resetting rankings: ' . $e->getMessage());
            return to_route('kriteria')->with('error', 'Gagal reset ranking: ' . $e->getMessage());
        }
    }

    /**
     * Re-generate ranking untuk semua kriteria (untuk import)
     */
    private function regenerateAllRankings()
    {
        $kriteria = Kriteria::whereNull('ranking')
            ->orWhere('ranking', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $nextRanking = (Kriteria::max('ranking') ?? 0) + 1;

        foreach ($kriteria as $item) {
            $item->update(['ranking' => $nextRanking]);
            $nextRanking++;
        }
    }

    /**
     * Buat penilaian untuk semua alternatif ketika kriteria baru ditambah
     */
    private function createPenilaianForAlternatif($kriteriaId)
    {
        $alternatif = Alternatif::all();

        foreach ($alternatif as $item) {
            Penilaian::firstOrCreate([
                'alternatif_id' => $item->id,
                'kriteria_id' => $kriteriaId,
            ], [
                'sub_kriteria_id' => null,
            ]);
        }

        Log::info("Created penilaian for {$alternatif->count()} alternatif");
    }

    /**
     * Recreate semua penilaian (untuk import)
     */
    private function recreateAllPenilaian()
    {
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();

        if ($kriteria->isNotEmpty() && $alternatif->isNotEmpty()) {
            // Hapus penilaian lama
            Penilaian::truncate();

            // Buat penilaian baru untuk semua kombinasi
            foreach ($kriteria as $krit) {
                foreach ($alternatif as $alt) {
                    Penilaian::create([
                        'alternatif_id' => $alt->id,
                        'kriteria_id' => $krit->id,
                        'sub_kriteria_id' => null,
                    ]);
                }
            }
        }
    }

    /**
     * API endpoint untuk mendapatkan ranking yang tersedia
     */
    public function getAvailableRankings(Request $request)
    {
        $excludeId = $request->get('exclude_id'); // ID kriteria yang dikecualikan (untuk edit)

        $usedRankings = Kriteria::when($excludeId, function ($query) use ($excludeId) {
            return $query->where('id', '!=', $excludeId);
        })
            ->whereNotNull('ranking')
            ->pluck('ranking')
            ->toArray();

        $totalKriteria = Kriteria::count();
        $maxRanking = $excludeId ? $totalKriteria : $totalKriteria + 1;

        $availableRankings = [];
        for ($i = 1; $i <= $maxRanking; $i++) {
            if (!in_array($i, $usedRankings)) {
                $availableRankings[] = $i;
            }
        }

        return response()->json([
            'available_rankings' => $availableRankings,
            'max_ranking' => $maxRanking,
            'used_rankings' => $usedRankings
        ]);
    }

    /**
     * Reorder semua ranking kriteria
     */
    public function reorderRankings(Request $request)
    {
        $request->validate([
            'rankings' => 'required|array',
            'rankings.*.id' => 'required|exists:kriteria,id',
            'rankings.*.ranking' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->rankings as $item) {
                Kriteria::where('id', $item['id'])
                    ->update(['ranking' => $item['ranking']]);
            }

            DB::commit();

            return response()->json(['message' => 'Ranking berhasil diperbarui']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error reordering rankings: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui ranking'], 500);
        }
    }
}