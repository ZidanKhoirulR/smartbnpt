<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkhir extends Model
{
    use HasFactory;

    protected $table = 'nilai_akhir';

    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'nilai'
    ];

    protected $casts = [
        'nilai' => 'decimal:4'
    ];

    // Relasi ke alternatif
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

    // Relasi ke kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    // Scope untuk mendapatkan ranking
    public function scopeRanking($query)
    {
        return $query->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("a.kode, a.alternatif, SUM(nilai_akhir.nilai) as total_nilai")
            ->groupBy('a.kode', 'a.alternatif', 'a.id')
            ->orderBy('total_nilai', 'desc');
    }
}