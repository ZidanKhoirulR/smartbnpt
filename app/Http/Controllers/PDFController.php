<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\NilaiUtility;
use App\Models\NormalisasiBobot;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\PDF;

class PDFController extends Controller
{
    /**
     *Generate PDF hasil akhir untuk user umum (public access)
     */
    public function pdf_hasil_public()
    {
        // Validasi data terlebih dahulu
        $validation = SMARTERHelper::validasiData();

        if (!$validation['valid']) {
            return redirect()->route('public.hasil-akhir')
                ->with('error', 'Data belum lengkap untuk mengexport PDF.');
        }

        try {
            // Ambil data hasil akhir
            $nilaiAkhir = SMARTERHelper::hitungNilaiAkhir();

            if (empty($nilaiAkhir)) {
                return redirect()->route('public.hasil-akhir')
                    ->with('error', 'Belum ada hasil perhitungan yang tersedia.');
            }

            // Load view PDF dengan data
            $pdf = PDF::loadView('pdf.hasil-akhir-public', [
                'title' => 'Hasil Akhir Penerimaan BPNT',
                'nilaiAkhir' => $nilaiAkhir,
                'tanggal' => now()->format('d F Y')
            ]);

            // Set paper size dan orientasi
            $pdf->setPaper('A4', 'portrait');

            // Download PDF dengan nama file yang sesuai
            $fileName = 'Hasil_Akhir_BPNT_' . now()->format('Y-m-d') . '.pdf';

            return $pdf->download($fileName);

        } catch (\Exception $e) {
            return redirect()->route('public.hasil-akhir')
                ->with('error', 'Terjadi kesalahan dalam mengexport PDF.');
        }
    }

    public function pdf_hasil()
    {
        $judul = 'Laporan Hasil Akhir';
        $tabelPenilaian = Penilaian::with('kriteria', 'subKriteria', 'alternatif')->get();
        $tabelNormalisasi = NormalisasiBobot::with('kriteria')->get();
        $tabelUtility = NilaiUtility::with('kriteria', 'alternatif')->get();
        $tabelNilaiAkhir = NilaiAkhir::with('kriteria', 'alternatif')->get();
        $tabelPerankingan = NilaiAkhir::query()
            ->join('alternatif as a', 'a.id', '=', 'nilai_akhir.alternatif_id')
            ->selectRaw("a.kode, a.alternatif, SUM(nilai) as nilai")
            ->groupBy('a.kode', 'a.alternatif')
            ->orderBy('nilai', 'desc')
            ->get();
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadview('dashboard.pdf.hasil_akhir', [
            'judul' => $judul,
            'tabelPenilaian' => $tabelPenilaian,
            'tabelNormalisasi' => $tabelNormalisasi,
            'tabelUtility' => $tabelUtility,
            'tabelNilaiAkhir' => $tabelNilaiAkhir,
            'tabelPerankingan' => $tabelPerankingan,
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
        ]);

        // return $pdf->download('laporan-penilaian.pdf');
        return $pdf->stream();
    }
}
