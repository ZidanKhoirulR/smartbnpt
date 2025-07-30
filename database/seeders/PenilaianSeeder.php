<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alternatif = Alternatif::orderBy('id', 'asc')->get();
        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        $subKriteria = [
            [
                'alternatif_id' => 1,
                'sub_kriteria_id' => [1, 6, 11, 17, 23],
            ],
            [
                'alternatif_id' => 2,
                'sub_kriteria_id' => [3, 7, 12, 18, 24],
            ],
            [
                'alternatif_id' => 3,
                'sub_kriteria_id' => [1, 8, 12, 18, 21],
            ],
            [
                'alternatif_id' => 4,
                'sub_kriteria_id' => [1, 7, 11, 18, 25],
            ],
        ];
        foreach ($alternatif as $alt => $item) {
            foreach ($kriteria as $kri => $value) {
                Penilaian::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'sub_kriteria_id' => $subKriteria[$alt]['sub_kriteria_id'][$kri],
                ]);
            }
        }
    }
}
