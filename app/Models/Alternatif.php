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
        'nik',        // Tambahkan NIK
        'alternatif',
        'keterangan'  // Tambahkan keterangan yang ada di migration
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

    // Method untuk mendapatkan ranking dengan tie-breaking
    public static function getRankingWithTieBreaking()
    {
        return self::query()
            ->join('nilai_akhir', 'alternatif.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw('
                alternatif.kode, 
                alternatif.nik,
                alternatif.alternatif, 
                SUM(nilai_akhir.nilai) as total_nilai,
                ROW_NUMBER() OVER (ORDER BY SUM(nilai_akhir.nilai) DESC, alternatif.created_at ASC) as ranking
            ')
            ->groupBy('alternatif.id', 'alternatif.kode', 'alternatif.nik', 'alternatif.alternatif', 'alternatif.created_at')
            ->orderBy('total_nilai', 'desc')
            ->orderBy('alternatif.created_at', 'asc')
            ->get();
    }

    // Method untuk cek status penerima bantuan
    public function getStatusBantuanAttribute()
    {
        $ranking = self::getRankingWithTieBreaking()
            ->where('nik', $this->nik)
            ->first();

        if (!$ranking) {
            return 'Tidak Diketahui';
        }

        return $ranking->ranking <= 150 ? 'Diterima' : 'Tidak Diterima';
    }

    // Scope untuk pencarian berdasarkan NIK
    public function scopeByNik($query, $nik)
    {
        return $query->where('nik', $nik);
    }
}