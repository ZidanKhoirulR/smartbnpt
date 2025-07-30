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
        'alternatif'
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

    // Method untuk mendapatkan total nilai akhir
    public function getTotalNilaiAkhirAttribute()
    {
        return $this->nilaiAkhir()->sum('nilai');
    }

    // Method untuk mendapatkan ranking
    public static function getRanking()
    {
        return self::join('nilai_akhir', 'alternatif.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw('alternatif.kode, alternatif.alternatif, SUM(nilai_akhir.nilai) as total_nilai')
            ->groupBy('alternatif.id', 'alternatif.kode', 'alternatif.alternatif')
            ->orderBy('total_nilai', 'desc')
            ->get();
    }
}