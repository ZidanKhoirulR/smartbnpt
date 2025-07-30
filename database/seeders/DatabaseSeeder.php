<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\UpdatePenilaianSeeder;
use App\Models\NilaiAkhir;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kriteria dan bobotnya
        $kriteria[] = Kriteria::updateOrCreate(
            ['kode' => 'K00001'],
            ['kriteria' => 'SOC', 'bobot' => 30, 'jenis_kriteria' => 'benefit']
        );
        $kriteria[] = Kriteria::updateOrCreate(
            ['kode' => 'K00002'],
            ['kriteria' => 'RAM', 'bobot' => 15, 'jenis_kriteria' => 'benefit']
        );
        $kriteria[] = Kriteria::updateOrCreate(
            ['kode' => 'K00003'],
            ['kriteria' => 'Storage', 'bobot' => 20, 'jenis_kriteria' => 'benefit']
        );
        $kriteria[] = Kriteria::updateOrCreate(
            ['kode' => 'K00004'],
            ['kriteria' => 'Battery', 'bobot' => 10, 'jenis_kriteria' => 'benefit']
        );
        $kriteria[] = Kriteria::updateOrCreate(
            ['kode' => 'K00005'],
            ['kriteria' => 'Price', 'bobot' => 25, 'jenis_kriteria' => 'cost']
        );

        // Sub Kriteria
        $subKriteria = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];
        $subKriteriaPrice = ['Sangat Murah', 'Murah', 'Cukup', 'Mahal', 'Sangat Mahal'];

        foreach ($kriteria as $item) {
            $labels = $item->jenis_kriteria === 'cost' ? $subKriteriaPrice : $subKriteria;
            $bobotList = $item->jenis_kriteria === 'cost' ? [2, 4, 6, 8, 10] : [10, 8, 6, 4, 2];

            foreach ($labels as $i => $label) {
                SubKriteria::updateOrCreate(
                    ['sub_kriteria' => $label, 'kriteria_id' => $item->id],
                    ['bobot' => $bobotList[$i]]
                );
            }
        }

        // Alternatif
        $alternatif[] = Alternatif::updateOrCreate(
            ['kode' => 'A00001'],
            ['alternatif' => 'Alternatif 1']
        );
        $alternatif[] = Alternatif::updateOrCreate(
            ['kode' => 'A00002'],
            ['alternatif' => 'Alternatif 2']
        );
        $alternatif[] = Alternatif::updateOrCreate(
            ['kode' => 'A00003'],
            ['alternatif' => 'Alternatif 3']
        );
        $alternatif[] = Alternatif::updateOrCreate(
            ['kode' => 'A00004'],
            ['alternatif' => 'Alternatif 4']
        );

        // Seeder lainnya
        $this->call([
            UserSeeder::class,
            UpdatePenilaianSeeder::class,
        ]);

        // Fitur Ranking Otomatis
        DB::statement("SET @rank = 0");
        $ranks = DB::select("
            SELECT
                a.id AS alternatif_id,
                a.kode AS kode,
                a.alternatif,
                SUM(na.nilai) AS total_nilai,
                @rank := @rank + 1 AS peringkat
            FROM alternatif a
            JOIN nilai_akhirs na ON na.alternatif_id = a.id
            GROUP BY a.id
            ORDER BY total_nilai DESC
        ");

        // Simpan hasil ranking ke log atau lanjutkan sesuai kebutuhan
        foreach ($ranks as $rank) {
            echo "{$rank->alternatif} - Total: {$rank->total_nilai}, Peringkat: {$rank->peringkat}\n";
        }
    }
}
