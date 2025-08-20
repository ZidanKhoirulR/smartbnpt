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

    // Scope untuk mendapatkan ranking - FIXED VERSION
    public function scopeRanking($query)
    {
        return $query->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.id as alternatif_id,
                a.kode, 
                a.alternatif, 
                CAST(SUM(CAST(nilai_akhir.nilai AS DECIMAL(10,4))) AS DECIMAL(10,4)) as total_nilai
            ")
            ->groupBy('a.id', 'a.kode', 'a.alternatif')
            ->orderBy('total_nilai', 'desc');
    }

    // Method alternatif untuk mendapatkan ranking tanpa SUM (jika masih error)
    public function scopeRankingSimple($query)
    {
        return $query->with(['alternatif'])
            ->get()
            ->groupBy('alternatif_id')
            ->map(function ($group) {
                $alternatif = $group->first()->alternatif;
                $total = $group->sum(function ($item) {
                    return (float) $item->nilai;
                });

                return (object) [
                    'alternatif_id' => $alternatif->id,
                    'kode' => $alternatif->kode,
                    'alternatif' => $alternatif->alternatif,
                    'total_nilai' => number_format($total, 4),
                    'nilai' => number_format($total, 4) // alias untuk compatibility
                ];
            })
            ->sortByDesc('total_nilai')
            ->values();
    }
}