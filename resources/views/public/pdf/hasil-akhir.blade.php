<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }}</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4a5568;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }

        .header p {
            font-size: 12px;
            color: #718096;
            margin: 5px 0;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
            padding: 8px 12px;
            background-color: #edf2f7;
            border-left: 4px solid #4299e1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background-color: white;
        }

        table th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            text-align: center;
            font-size: 11px;
            border: 1px solid #2d3748;
        }

        table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }

        table td:first-child {
            text-align: left;
            font-weight: 500;
        }

        table tr:nth-child(even) {
            background-color: #f7fafc;
        }

        table tr:hover {
            background-color: #edf2f7;
        }

        .ranking-1 {
            background-color: #fef3c7 !important;
            font-weight: bold;
        }

        .ranking-2 {
            background-color: #e0e7ff !important;
            font-weight: bold;
        }

        .ranking-3 {
            background-color: #fecaca !important;
            font-weight: bold;
        }

        .status-diterima {
            color: #065f46;
            background-color: #d1fae5;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .status-tidak-diterima {
            color: #7f1d1d;
            background-color: #fee2e2;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .nilai-badge {
            background-color: #4299e1;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .summary-box {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .summary-content {
            font-size: 11px;
            line-height: 1.5;
        }

        .conclusion {
            background-color: #e6fffa;
            border-left: 4px solid #38b2ac;
            padding: 15px;
            margin-top: 20px;
        }

        .conclusion h3 {
            font-size: 14px;
            font-weight: bold;
            color: #234e52;
            margin: 0 0 8px 0;
        }

        .conclusion p {
            font-size: 12px;
            margin: 0;
            line-height: 1.5;
        }

        .page-break {
            page-break-before: always;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }

        .info-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
        }

        .info-number {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
        }

        .info-label {
            font-size: 10px;
            color: #718096;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $judul }}</h1>
        <p>Hasil Perhitungan Menggunakan Metode SMARTER-ROC</p>
        <p>Dicetak pada: {{ date('d F Y, H:i:s') }}</p>
    </div>

    <!-- Info Summary -->
    <div class="info-grid">
        <div class="info-item">
            <div class="info-number">{{ $tabelPerankingan->count() }}</div>
            <div class="info-label">Total Alternatif</div>
        </div>
        <div class="info-item">
            <div class="info-number">150</div>
            <div class="info-label">Penerima Bantuan</div>
        </div>
        <div class="info-item">
            <div class="info-number">SMARTER-ROC</div>
            <div class="info-label">Metode Perhitungan</div>
        </div>
    </div>

    <!-- Tabel Perankingan -->
    <div class="section">
        <div class="section-title">Hasil Perankingan Alternatif</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">Ranking</th>
                    <th style="width: 12%;">Kode</th>
                    <th style="width: 50%;">Nama Alternatif</th>
                    <th style="width: 15%;">Nilai Akhir</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tabelPerankingan as $index => $item)
                    @php
                        $ranking = $index + 1;
                        $isDiterima = $ranking <= 150;
                        $rowClass = '';
                        if ($ranking === 1)
                            $rowClass = 'ranking-1';
                        elseif ($ranking === 2)
                            $rowClass = 'ranking-2';
                        elseif ($ranking === 3)
                            $rowClass = 'ranking-3';
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <td style="text-align: center; font-weight: bold;">
                            @if($ranking === 1) 🏆 @elseif($ranking === 2) 🥈 @elseif($ranking === 3) 🥉 @endif
                            {{ $ranking }}
                        </td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->kode }}</td>
                        <td style="text-align: left;">{{ $item->alternatif }}</td>
                        <td style="text-align: center;">
                            <span class="nilai-badge">{{ round($item->nilai, 4) }}</span>
                        </td>
                        <td style="text-align: center;">
                            @if($isDiterima)
                                <span class="status-diterima">DITERIMA</span>
                            @else
                                <span class="status-tidak-diterima">TIDAK DITERIMA</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Kesimpulan -->
    <div class="conclusion">
        <h3>Kesimpulan</h3>
        @php $topRanking = $tabelPerankingan->first(); @endphp
        <p>
            Berdasarkan hasil perhitungan menggunakan metode SMARTER-ROC, alternatif dengan nilai tertinggi adalah
            <strong>{{ $topRanking->alternatif }}</strong> ({{ $topRanking->kode }}) dengan nilai
            <strong>{{ round($topRanking->nilai, 4) }}</strong>.
        </p>
        <p style="margin-top: 8px;">
            Dari {{ $tabelPerankingan->count() }} alternatif yang dievaluasi, sebanyak
            <strong>150 alternatif teratas</strong> ditetapkan sebagai penerima bantuan sosial
            berdasarkan ranking nilai SMARTER-ROC tertinggi.
        </p>
    </div>

    <!-- Page Break untuk detail perhitungan -->
    <div class="page-break"></div>

    <!-- Detail Perhitungan -->
    <div class="section">
        <div class="section-title">Detail Penilaian Alternatif</div>
        <table>
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach ($kriteria as $item)
                        <th>{{ $item->kriteria }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatif as $item)
                    <tr>
                        <td style="text-align: left; font-weight: bold;">{{ $item->alternatif }}</td>
                        @foreach ($tabelPenilaian->where("alternatif_id", $item->id) as $value)
                            <td>{{ $value->subKriteria->sub_kriteria }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Normalisasi Bobot -->
    <div class="section">
        <div class="section-title">Normalisasi Bobot Kriteria (ROC Method)</div>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Bobot Normalisasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tabelNormalisasi as $item)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $item->kriteria->kode }}</td>
                        <td style="text-align: left;">{{ $item->kriteria->kriteria }}</td>
                        <td style="text-align: center;">
                            <span class="nilai-badge">{{ round($item->normalisasi, 4) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nilai Utility -->
    <div class="section">
        <div class="section-title">Hasil Nilai Utility</div>
        <table>
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach ($kriteria as $item)
                        <th>{{ $item->kriteria }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatif as $item)
                    <tr>
                        <td style="text-align: left; font-weight: bold;">{{ $item->alternatif }}</td>
                        @foreach ($tabelUtility->where("alternatif_id", $item->id) as $value)
                            <td>{{ round($value->nilai, 4) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nilai Akhir Detail -->
    <div class="section">
        <div class="section-title">Detail Nilai Akhir (Weighted Sum)</div>
        <table>
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach ($kriteria as $item)
                        <th>{{ $item->kriteria }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatif as $item)
                    <tr>
                        <td style="text-align: left; font-weight: bold;">{{ $item->alternatif }}</td>
                        @foreach ($tabelNilaiAkhir->where("alternatif_id", $item->id) as $value)
                            <td>{{ round($value->nilai, 4) }}</td>
                        @endforeach
                        <td style="text-align: center;">
                            <span
                                class="nilai-badge">{{ round($tabelNilaiAkhir->where("alternatif_id", $item->id)->sum("nilai"), 4) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Penjelasan Metode -->
    <div class="summary-box">
        <div class="summary-title">Tentang Metode SMARTER-ROC</div>
        <div class="summary-content">
            <strong>SMARTER (Simple Multi-Attribute Rating Technique Extended to Ranking)</strong> adalah metode
            pengambilan keputusan
            multi-kriteria yang menggunakan pendekatan utility function. Metode ini diperkuat dengan
            <strong>ROC (Rank Order Centroid)</strong> untuk pembobotan kriteria yang objektif.
            <br><br>
            <strong>Tahapan perhitungan:</strong><br>
            1. Penilaian alternatif berdasarkan sub-kriteria<br>
            2. Normalisasi bobot kriteria menggunakan ROC<br>
            3. Konversi nilai ke utility (0-1)<br>
            4. Perhitungan nilai akhir dengan weighted sum<br>
            5. Perankingan berdasarkan nilai tertinggi
        </div>
    </div>

    <!-- Footer -->
    <div
        style="text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #718096;">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Bantuan Sosial</p>
        <p>Dicetak pada {{ date('d F Y \p\u\k\u\l H:i:s \W\I\B') }}</p>
    </div>
</body>

</html>