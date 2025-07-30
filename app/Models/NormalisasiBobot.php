<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalisasiBobot extends Model
{
    use HasFactory;

    protected $table = 'normalisasi_bobot';

    protected $fillable = [
        'kriteria_id',
        'normalisasi'
    ];

    protected $casts = [
        'normalisasi' => 'decimal:4'
    ];

    // Relasi ke kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}