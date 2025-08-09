<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SMARTERHelper;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * Menampilkan hasil akhir untuk user umum (public)
     */
    public function hasilAkhir()
    {
        // Validasi data terlebih dahulu
        $validation = SMARTERHelper::validasiData();

        if (!$validation['valid']) {
            return view('public.hasil-akhir-kosong', [
                'title' => 'Hasil Akhir BPNT',
                'error' => 'Data belum lengkap untuk menampilkan hasil akhir.',
                'details' => $validation['errors']
            ]);
        }

        try {
            // Ambil data hasil akhir yang sudah diurutkan
            $nilaiAkhir = SMARTERHelper::hitungNilaiAkhir();

            // Jika tidak ada data hasil
            if (empty($nilaiAkhir)) {
                return view('public.hasil-akhir-kosong', [
                    'title' => 'Hasil Akhir BPNT',
                    'error' => 'Belum ada hasil perhitungan yang tersedia.',
                    'details' => ['Silakan hubungi admin untuk melakukan perhitungan SMARTER-ROC.']
                ]);
            }

            return view('public.hasil-akhir', [
                'title' => 'Hasil Akhir BPNT',
                'nilaiAkhir' => $nilaiAkhir
            ]);

        } catch (\Exception $e) {
            return view('public.hasil-akhir-kosong', [
                'title' => 'Hasil Akhir BPNT',
                'error' => 'Terjadi kesalahan dalam memuat hasil akhir.',
                'details' => ['Silakan coba lagi nanti atau hubungi administrator.']
            ]);
        }
    }
}