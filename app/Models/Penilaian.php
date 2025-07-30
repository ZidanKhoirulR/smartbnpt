<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'sub_kriteria_id'
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

    // Relasi ke sub kriteria
    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    // Scope untuk mendapatkan penilaian per alternatif
    public function scopeByAlternatif($query, $alternatifId)
    {
        return $query->where('alternatif_id', $alternatifId);
    }

    // Scope untuk mendapatkan penilaian per kriteria
    public function scopeByKriteria($query, $kriteriaId)
    {
        return $query->where('kriteria_id', $kriteriaId);
    }
}