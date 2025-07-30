<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;

class UpdatePenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $alternatifList = Alternatif::all();
        $kriteriaList = Kriteria::all();

        foreach ($alternatifList as $index => $alternatif) {
            foreach ($kriteriaList as $kriteria) {
                // Ambil semua sub_kriteria yang sesuai dengan kriteria
                $subKriterias = SubKriteria::where('kriteria_id', $kriteria->id)
                    ->orderBy('bobot', 'asc')
                    ->get();

                // Skip jika belum ada sub_kriteria untuk kriteria ini
                if ($subKriterias->isEmpty())
                    continue;

                // Pilih sub_kriteria berdasarkan index alternatif agar menyebar merata
                $selected = $subKriterias[$index % $subKriterias->count()];

                // Update atau insert penilaian
                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteria->id,
                    ],
                    [
                        'sub_kriteria_id' => $selected->id,
                    ]
                );
            }
        }
    }
}
