<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kode',
        'kriteria',
        'bobot',
        'ranking', // Tambahkan ini
        'jenis_kriteria'
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'ranking' => 'integer'
    ];

    // Method untuk auto-generate ranking berdasarkan bobot
    public static function generateRanking()
    {
        $kriteria = self::orderBy('bobot', 'desc')->get();

        foreach ($kriteria as $index => $item) {
            $item->update(['ranking' => $index + 1]);
        }
    }

    // Method untuk hitung bobot ROC
    public function getBobotRocAttribute()
    {
        $K = self::count();
        $rank = $this->ranking ?? 1;

        $sum = 0;
        for ($i = $rank; $i <= $K; $i++) {
            $sum += 1 / $i;
        }

        return (1 / $K) * $sum;
    }

    // Relasi ke sub kriteria
    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }

    // Relasi ke penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    // Relasi ke normalisasi bobot
    public function normalisasiBobot()
    {
        return $this->hasOne(NormalisasiBobot::class);
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

    // Scope untuk kriteria benefit
    public function scopeBenefit($query)
    {
        return $query->where('jenis_kriteria', 'benefit');
    }

    // Scope untuk kriteria cost
    public function scopeCost($query)
    {
        return $query->where('jenis_kriteria', 'cost');
    }

    // Scope untuk urutkan berdasarkan ranking
    public function scopeByRanking($query)
    {
        return $query->orderBy('ranking', 'asc');
    }
}