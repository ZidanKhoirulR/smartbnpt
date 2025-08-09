<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Akhir BPNT - PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Hasil Akhir Penerimaan BPNT</h1>
        <p>Metode SMARTER - Metode SMARTER</p>
    </div>

    <div class="content">
        <h2>Hasil Akhir Penerimaan BPNT</h2>
        <p>Metode SMARTER - Metode SMARTER</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilAkhir as $item)
                    <tr>
                        <td>{{ $item->ranking }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->alternatif }}</td>
                        <td>{{ $item->nilai }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('d F Y') }}</p>
    </div>
</body>

</html>