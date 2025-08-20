<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #1e40af;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            color: #374151;
        }

        .header p {
            font-size: 10px;
            margin: 5px 0;
            color: #6b7280;
        }

        .info-section {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #8b5cf6;
        }

        .info-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #8b5cf6;
        }

        .info-section p {
            margin: 0;
            font-size: 11px;
            color: #4b5563;
        }

        .table-container {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        thead th {
            background-color: #1e293b;
            color: white;
            font-weight: bold;
            padding: 12px 8px;
            text-align: center;
            font-size: 11px;
            border: 1px solid #374151;
        }

        tbody td {
            padding: 10px 8px;
            border: 1px solid #d1d5db;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        .ranking-1 {
            background-color: #fef3c7 !important;
            border-left: 4px solid #f59e0b;
        }

        .ranking-2 {
            background-color: #e0e7ff !important;
            border-left: 4px solid #6366f1;
        }

        .ranking-3 {
            background-color: #fecaca !important;
            border-left: 4px solid #ef4444;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .ranking-badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            text-align: center;
            line-height: 25px;
            font-size: 10px;
            margin-right: 8px;
        }

        .badge-1 { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .badge-2 { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .badge-3 { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .badge-other { background: linear-gradient(135deg, #6b7280, #4b5563); }

        .nilai-badge {
            background: #10b981;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 10px;
        }

        .interpretation-section {
            background-color: #ecfdf5;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #10b981;
        }

        .interpretation-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #10b981;
        }

        .interpretation-grid {
            display: flex;
            gap: 20px;
        }

        .interpretation-col {
            flex: 1;
        }

        .interpretation-col h4 {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 8px 0;
            color: #374151;
        }

        .interpretation-col ul {
            margin: 0;
            padding-left: 15px;
            font-size: 10px;
            color: #4b5563;
        }

        .interpretation-col li {
            margin-bottom: 4px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
            font-size: 10px;
            color: #6b7280;
        }

        .footer .date {
            font-weight: bold;
            color: #374151;
        }

        .medal {
            font-size: 14px;
            margin-right: 5px;
        }

        .medal-gold { color: #f59e0b; }
        .medal-silver { color: #6b7280; }
        .medal-bronze { color: #d97706; }

        @media print {
            body { 
                font-size: 11px; 
                padding: 15px;
            }
            .info-section, .interpretation-section { 
                break-inside: avoid; 
            }
            table { 
                page-break-inside: auto; 
            }
            tr { 
                page-break-inside: avoid; 
                page-break-after: auto; 
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>SISTEM PENDUKUNG KEPUTUSAN</h1>
        <h2>PENERIMAAN BANTUAN PANGAN NON TUNAI (BPNT)</h2>
        <p>Kabupaten Cirebon - Metode SMARTER-ROC</p>
        <p>{{ $title }}</p>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <h3>Informasi Hasil Perhitungan</h3>
        <p>
            Hasil perhitungan menggunakan metode <strong>SMARTER-ROC</strong> (Simple Multi-Attribute Rating Technique Exploiting Ranks - Rank Order Centroid) 
            telah diurutkan berdasarkan nilai tertinggi. Alternatif dengan nilai tertinggi adalah yang terbaik sesuai kriteria yang telah ditetapkan 
            untuk program Bantuan Pangan Non Tunai (BPNT) Kabupaten Cirebon.
        </p>
    </div>

    <!-- Results Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Ranking</th>
                    <th style="width: 15%;">Kode</th>
                    <th style="width: 55%;">Nama Alternatif</th>
                    <th style="width: 20%;">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nilaiAkhir as $index => $item)
                    <tr class="@if($index === 0) ranking-1 @elseif($index === 1) ranking-2 @elseif($index === 2) ranking-3 @endif">
                        <!-- Ranking -->
                        <td class="text-center">
                            @if($index === 0)
                                <span class="medal medal-gold">🏆</span>
                            @elseif($index === 1)
                                <span class="medal medal-silver">🥈</span>
                            @elseif($index === 2)
                                <span class="medal medal-bronze">🥉</span>
                            @endif
                            <span class="font-bold">{{ $index + 1 }}</span>
                        </td>

                        <!-- Kode -->
                        <td class="text-center">
                            <span class="ranking-badge 
                                @if($index === 0) badge-1 
                                @elseif($index === 1) badge-2 
                                @elseif($index === 2) badge-3 
                                @else badge-other @endif">
                                {{ $item->kode }}
                            </span>
                        </td>

                        <!-- Alternatif -->
                        <td class="text-left">
                            <div>
                                <strong>{{ $item->alternatif }}</strong>
                                <br>
                                <small style="color: #6b7280;">
                                    @if($index === 0)
                                        🏆 Alternatif Terbaik
                                    @elseif($index === 1)
                                        🥈 Alternatif Kedua
                                    @elseif($index === 2)
                                        🥉 Alternatif Ketiga
                                    @else
                                        Peringkat {{ $index + 1 }}
                                    @endif
                                </small>
                            </div>
                        </td>

                        <!-- Nilai Akhir -->
                        <td class="text-center">
                            <span class="nilai-badge">{{ $item->nilai }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Interpretation Section -->
    <div class="interpretation-section">
        <h3>Interpretasi Nilai Akhir & Metodologi</h3>
        <div class="interpretation-grid">
            <div class="interpretation-col">
                <h4>Kategori Nilai:</h4>
                <ul>
                    <li><strong>0.8 - 1.0:</strong> Sangat Baik - Sangat layak menerima BPNT</li>
                    <li><strong>0.6 - 0.8:</strong> Baik - Layak menerima BPNT</li>
                    <li><strong>0.4 - 0.6:</strong> Cukup - Dapat dipertimbangkan</li>
                    <li><strong>0.2 - 0.4:</strong> Kurang - Prioritas rendah</li>
                    <li><strong>0.0 - 0.2:</strong> Sangat Kurang - Tidak direkomendasikan</li>
                </ul>
            </div>
            <div class="interpretation-col">
                <h4>Metodologi SMARTER-ROC:</h4>
                <ul>
                    <li>• Nilai dihitung berdasarkan normalisasi utility 0-1</li>
                    <li>• Pembobotan menggunakan metode ROC (Rank Order Centroid)</li>
                    <li>• Semakin tinggi nilai, semakin baik alternatif</li>
                    <li>• Ranking otomatis berdasarkan nilai tertinggi</li>
                    <li>• Metode objektif dan transparan untuk seleksi BPNT</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div style="margin-top: 20px; background-color: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
        <h3 style="font-size: 14px; font-weight: bold; margin: 0 0 10px 0; color: #f59e0b;">Ringkasan Hasil</h3>
        <div style="display: flex; gap: 20px; font-size: 11px;">
            <div style="flex: 1;">
                <strong>Total Alternatif:</strong> {{ count($nilaiAkhir) }} calon penerima BPNT
            </div>
            <div style="flex: 1;">
                <strong>Nilai Tertinggi:</strong> {{ $nilaiAkhir[0]->nilai ?? 'N/A' }}
            </div>
            <div style="flex: 1;">
                <strong>Nilai Terendah:</strong> {{ end($nilaiAkhir)->nilai ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh Sistem Pendukung Keputusan BPNT</p>
        <p>Kabupaten Cirebon - Metode SMARTER-ROC</p>
        <p class="date">Tanggal Cetak: {{ $tanggal }}</p>
        <p style="font-size: 9px; margin-top: 10px;">
            Dokumen ini sah dan dapat dipertanggungjawabkan sesuai dengan perhitungan sistem.<br>
            Untuk informasi lebih lanjut, hubungi Dinas Sosial Kabupaten Cirebon.
        </p>
    </div>
</body>
</html>