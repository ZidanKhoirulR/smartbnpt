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
use Maatwebsite\Excel\Facades\Excel;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Kriteria";

        // Urutkan berdasarkan ranking, lalu kode sebagai fallback
        $kriteria = KriteriaResource::collection(
            Kriteria::orderByRaw('ranking IS NULL, ranking ASC')
                ->orderBy('kode', 'asc')
                ->get()
        );

        $sumBobot = $kriteria->sum('bobot');

        // Generate kode otomatis
        $lastKode = Kriteria::orderBy('kode', 'desc')->first();
        if ($lastKode) {
            $kode = "K" . str_pad((int) substr($lastKode->kode, 1) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $kode = "K00001";
        }

        return view('dashboard.kriteria.index', compact('title', 'kriteria', 'sumBobot', 'kode'));
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

            // Adjust ranking untuk kriteria yang ada
            $this->adjustExistingRankings($newRanking);

            // Buat kriteria baru
            $kriteria = Kriteria::create($validated);

            // Buat penilaian untuk semua alternatif yang ada
            $this->createPenilaianForAlternatif($kriteria->id);

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil disimpan dengan ranking ' . $newRanking);

        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('kriteria')->with('error', 'Kriteria gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return new KriteriaResource(Kriteria::find($request->kriteria_id));
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
            $newRanking = $validated['ranking'];

            // Ambil kriteria yang akan diupdate
            $kriteria = Kriteria::findOrFail($kriteriaId);
            $oldRanking = $kriteria->ranking;

            // Jika ranking berubah, adjust ranking kriteria lain
            if ($oldRanking != $newRanking) {
                $this->adjustRankingsForUpdate($kriteriaId, $oldRanking, $newRanking);
            }

            // Update kriteria
            $kriteria->update($validated);

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('kriteria')->with('error', 'Kriteria gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();

            $kriteriaId = $request->kriteria_id;
            $kriteria = Kriteria::findOrFail($kriteriaId);
            $deletedRanking = $kriteria->ranking;

            // Hapus relasi terkait
            Penilaian::where('kriteria_id', $kriteriaId)->delete();
            SubKriteria::where('kriteria_id', $kriteriaId)->delete();
            NormalisasiBobot::where('kriteria_id', $kriteriaId)->delete();
            NilaiUtility::where('kriteria_id', $kriteriaId)->delete();
            NilaiAkhir::where('kriteria_id', $kriteriaId)->delete();

            // Hapus kriteria
            $kriteria->delete();

            // Adjust ranking kriteria yang tersisa
            if ($deletedRanking) {
                $this->adjustRankingsAfterDelete($deletedRanking);
            }

            DB::commit();

            return to_route('kriteria')->with('success', 'Kriteria berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('kriteria')->with('error', 'Kriteria gagal dihapus: ' . $e->getMessage());
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
            return to_route('kriteria')->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Adjust ranking kriteria yang ada ketika menambah kriteria baru
     */
    private function adjustExistingRankings($newRanking)
    {
        // Geser ranking yang >= newRanking ke atas
        Kriteria::where('ranking', '>=', $newRanking)
            ->increment('ranking');
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

            // Ambil semua kriteria, urutkan berdasarkan ranking lama (jika ada) atau bobot
            $kriteria = Kriteria::orderByRaw('ranking IS NULL, ranking ASC')
                ->orderBy('bobot', 'desc')
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
            ->orderBy('bobot', 'desc') // Fallback berdasarkan bobot
            ->orderBy('created_at', 'asc')
            ->get();

        $nextRanking = Kriteria::max('ranking') + 1;

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
            return response()->json(['error' => 'Gagal memperbarui ranking'], 500);
        }
    }
}