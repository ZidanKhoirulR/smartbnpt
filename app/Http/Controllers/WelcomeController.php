<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\NilaiAkhir;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    const MAX_RECIPIENTS = 150; // Konstanta untuk batasan penerima

    public function index()
    {
        // Statistik untuk ditampilkan di halaman welcome
        $totalAlternatif = Alternatif::count();
        $totalPenerima = min($totalAlternatif, self::MAX_RECIPIENTS);

        return view('welcome', compact('totalAlternatif', 'totalPenerima'));
    }

    public function searchNik(Request $request)
    {
        // Validasi input NIK
        $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]+$/'
            ]
        ], [
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'nik.regex' => 'NIK hanya boleh berisi angka'
        ]);

        $nik = $request->nik;

        // Cari alternatif berdasarkan NIK
        $alternatif = Alternatif::where('nik', $nik)->first();

        if (!$alternatif) {
            return back()->with([
                'error' => 'NIK tidak ditemukan dalam database sistem bantuan sosial.',
                'search_nik' => $nik
            ])->withInput();
        }

        // Cek apakah sudah ada perhitungan nilai akhir
        $nilaiAkhirExists = NilaiAkhir::where('alternatif_id', $alternatif->id)->exists();

        if (!$nilaiAkhirExists) {
            return back()->with([
                'warning' => 'Data ditemukan, namun perhitungan SMARTER-ROC belum dilakukan. Silakan hubungi administrator.',
                'result' => [
                    'alternatif' => $alternatif,
                    'status_perhitungan' => false
                ],
                'search_nik' => $nik
            ])->withInput();
        }

        // Hitung ranking dan status
        $result = $this->calculateRankingAndStatus($alternatif);

        // Tentukan jenis notifikasi berdasarkan status
        $notificationType = $result->status === 'Diterima' ? 'success' : 'info';
        $message = $this->generateStatusMessage($result);

        return back()->with([
            $notificationType => $message,
            'result' => $result,
            'search_nik' => $nik
        ])->withInput();
    }

    private function calculateRankingAndStatus($alternatif)
    {
        // Hitung total nilai dari nilai akhir
        $totalNilai = NilaiAkhir::where('alternatif_id', $alternatif->id)->sum('nilai');

        // Hitung ranking dengan tie-breaking
        $ranking = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("
                a.id,
                SUM(nilai_akhir.nilai) as total_nilai,
                a.created_at
            ")
            ->groupBy('a.id', 'a.created_at')
            ->havingRaw(
                'total_nilai > ? OR (total_nilai = ? AND a.created_at < ?)',
                [$totalNilai, $totalNilai, $alternatif->created_at]
            )
            ->count() + 1;

        // Tentukan status berdasarkan ranking
        $status = $ranking <= self::MAX_RECIPIENTS ? 'Diterima' : 'Tidak Diterima';

        // Return object dengan semua informasi
        return (object) [
            'kode' => $alternatif->kode,
            'nik' => $alternatif->nik,
            'alternatif' => $alternatif->alternatif,
            'keterangan' => $alternatif->keterangan,
            'nilai' => round($totalNilai, 4),
            'ranking' => $ranking,
            'status' => $status,
            'total_alternatif' => Alternatif::count(),
            'batas_penerima' => self::MAX_RECIPIENTS
        ];
    }

    private function generateStatusMessage($result)
    {
        $baseMessage = "Data ditemukan! {$result->alternatif} (NIK: {$result->nik}) ";
        $baseMessage .= "mendapat nilai {$result->nilai} dengan ranking {$result->ranking} dari {$result->total_alternatif} peserta.";

        if ($result->status === 'Diterima') {
            return $baseMessage . " Status: DITERIMA sebagai penerima bantuan sosial.";
        } else {
            $kurangRanking = $result->ranking - self::MAX_RECIPIENTS;
            return $baseMessage . " Status: TIDAK DITERIMA (kelebihan {$kurangRanking} dari batas {$result->batas_penerima} penerima).";
        }
    }

    /**
     * API endpoint untuk pencarian NIK (jika diperlukan untuk AJAX)
     */
    public function apiSearchNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/'
        ]);

        $alternatif = Alternatif::where('nik', $request->nik)->first();

        if (!$alternatif) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak ditemukan dalam database'
            ], 404);
        }

        $nilaiAkhirExists = NilaiAkhir::where('alternatif_id', $alternatif->id)->exists();

        if (!$nilaiAkhirExists) {
            return response()->json([
                'success' => false,
                'message' => 'Data ditemukan, namun perhitungan belum dilakukan',
                'data' => [
                    'alternatif' => $alternatif,
                    'status_perhitungan' => false
                ]
            ]);
        }

        $result = $this->calculateRankingAndStatus($alternatif);

        return response()->json([
            'success' => true,
            'message' => $this->generateStatusMessage($result),
            'data' => $result
        ]);
    }
}