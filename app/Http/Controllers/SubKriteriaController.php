<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubKriteriaRequest;
use App\Http\Resources\KriteriaResource;
use App\Http\Resources\SubKriteriaResource;
use App\Imports\SubKriteriaImport;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Sub Kriteria";
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('created_at', 'asc')->get());
        $subKriteria = SubKriteriaResource::collection(SubKriteria::with('kriteria')->orderBy('bobot', 'desc')->get());
        return view('dashboard.sub-kriteria.index', compact('title', 'kriteria', 'subKriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubKriteriaRequest $request)
    {
        try {
            $validated = $request->validated();

            $simpan = SubKriteria::create($validated);

            if ($simpan) {
                // Ambil nama kriteria untuk pesan
                $kriteriaNama = Kriteria::find($validated['kriteria_id'])->kriteria ?? 'Unknown';
                return to_route('sub-kriteria')->with('success', 'Sub Kriteria ' . $kriteriaNama . ' Berhasil Disimpan');
            } else {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria Gagal Disimpan');
            }
        } catch (\Exception $e) {
            return to_route('sub-kriteria')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            // Pastikan parameter ada
            $subKriteriaId = $request->sub_kriteria_id;

            if (!$subKriteriaId) {
                return response()->json(['error' => 'ID Sub Kriteria tidak ditemukan'], 400);
            }

            $subKriteria = SubKriteria::with('kriteria')->find($subKriteriaId);

            if (!$subKriteria) {
                return response()->json(['error' => 'Sub Kriteria tidak ditemukan'], 404);
            }

            // Return data yang sudah terstruktur untuk modal
            return response()->json([
                'id' => $subKriteria->id,
                'sub_kriteria' => $subKriteria->sub_kriteria,
                'bobot' => $subKriteria->bobot,
                'kriteria_id' => $subKriteria->kriteria_id,
                'kriteria' => $subKriteria->kriteria ? [
                    'id' => $subKriteria->kriteria->id,
                    'kriteria' => $subKriteria->kriteria->kriteria,
                    'kode' => $subKriteria->kriteria->kode
                ] : null
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubKriteriaRequest $request)
    {
        try {
            $validated = $request->validated();
            $subKriteriaId = $request->id;

            if (!$subKriteriaId) {
                return to_route('sub-kriteria')->with('error', 'ID Sub Kriteria tidak ditemukan');
            }

            $subKriteria = SubKriteria::find($subKriteriaId);

            if (!$subKriteria) {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria tidak ditemukan');
            }

            // Update data
            $perbarui = $subKriteria->update($validated);

            if ($perbarui) {
                // Ambil nama kriteria untuk pesan
                $kriteriaNama = Kriteria::find($validated['kriteria_id'])->kriteria ?? 'Unknown';
                return to_route('sub-kriteria')->with('success', 'Sub Kriteria ' . $kriteriaNama . ' Berhasil Diperbarui');
            } else {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria Gagal Diperbarui');
            }

        } catch (\Exception $e) {
            return to_route('sub-kriteria')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            $subKriteriaId = $request->sub_kriteria_id;

            if (!$subKriteriaId) {
                return to_route('sub-kriteria')->with('error', 'ID Sub Kriteria tidak ditemukan');
            }

            $subKriteria = SubKriteria::with('kriteria')->find($subKriteriaId);

            if (!$subKriteria) {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria tidak ditemukan');
            }

            $kriteriaNama = $subKriteria->kriteria->kriteria ?? 'Unknown';

            // Update penilaian yang menggunakan sub kriteria ini
            Penilaian::where('sub_kriteria_id', $subKriteriaId)->update(['sub_kriteria_id' => null]);

            // Hapus sub kriteria
            $hapus = $subKriteria->delete();

            if ($hapus) {
                return to_route('sub-kriteria')->with('success', 'Sub Kriteria ' . $kriteriaNama . ' Berhasil Dihapus');
            } else {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria ' . $kriteriaNama . ' Gagal Dihapus');
            }

        } catch (\Exception $e) {
            return to_route('sub-kriteria')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('import_data');
            $import = Excel::import(new SubKriteriaImport, $file);

            if ($import) {
                return to_route('sub-kriteria')->with('success', 'Sub Kriteria Berhasil Disimpan');
            } else {
                return to_route('sub-kriteria')->with('error', 'Sub Kriteria Gagal Disimpan');
            }
        } catch (\Exception $e) {
            return to_route('sub-kriteria')->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}