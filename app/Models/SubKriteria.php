<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';

    protected $fillable = [
        'kriteria_id',
        'sub_kriteria',
        'bobot'
    ];

    protected $casts = [
        'bobot' => 'decimal:2'
    ];

    // Relasi ke kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    // Relasi ke penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}