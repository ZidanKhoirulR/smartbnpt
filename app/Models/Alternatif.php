<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatif';

    protected $fillable = [
        'kode',
        'nik',        // NIK tetap ada untuk admin internal
        'alternatif',
        'keterangan'
    ];

    // Relasi ke penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    // Relasi ke nilai utility
    public function nilaiUtility()
    {
        return $this->hasMany(NilaiUtility::class);
    }

    // Relasi ke nilai akhir
    public function nilaiAkhir()
    {
        return $this->hasMany(NilaiAkhir::class);
    }

    // Method untuk mendapatkan total nilai akhir (untuk admin)
    public function getTotalNilaiAkhirAttribute()
    {
        return $this->nilaiAkhir()->sum('nilai');
    }

    // Method untuk admin dashboard - ranking dengan tie-breaking
    public static function getAdminRankingWithTieBreaking()
    {
        return self::query()
            ->join('nilai_akhir', 'alternatif.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw('
                alternatif.id,
                alternatif.kode, 
                alternatif.nik,
                alternatif.alternatif,
                alternatif.keterangan,
                SUM(nilai_akhir.nilai) as total_nilai,
                ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, alternatif.created_at ASC) as ranking
            ')
            ->groupBy('alternatif.id', 'alternatif.kode', 'alternatif.nik', 'alternatif.alternatif', 'alternatif.keterangan', 'alternatif.created_at')
            ->orderBy('total_nilai', 'desc')
            ->orderBy('alternatif.created_at', 'asc')
            ->get();
    }
}