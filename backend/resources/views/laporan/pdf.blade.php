<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arsip Akta Nikah - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
            color: #0f766e;
        }
        .header h2 {
            font-size: 14px;
            margin: 0 0 5px 0;
            font-weight: normal;
        }
        .header p {
            margin: 0;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 4px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-item strong {
            color: #0f766e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #0f766e;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANTOR URUSAN AGAMA KEMANTREN TEGALREJO</h1>
        <h2>LAPORAN ARSIP AKTA NIKAH</h2>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span>Total Arsip:</span>
            <strong>{{ $summary['total'] }}</strong>
        </div>
        <div class="summary-item">
            <span>Dengan Dokumen:</span>
            <strong>{{ $summary['dengan_dokumen'] }}</strong>
        </div>
        <div class="summary-item">
            <span>Tanpa Dokumen:</span>
            <strong>{{ $summary['tanpa_dokumen'] }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Nomor Akta</th>
                <th style="width: 20%">Nama Suami</th>
                <th style="width: 20%">Nama Istri</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Lokasi</th>
                <th style="width: 13%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arsip as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nomor_akta }}</td>
                    <td>{{ $item->nama_suami }}</td>
                    <td>{{ $item->nama_istri }}</td>
                    <td>{{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->lokasi_fisik ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        Tidak ada data arsip untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <p>Tegalrejo, {{ now()->format('d F Y') }}</p>
        <p>Kepala KUA Kemantren Tegalrejo</p>
        <br><br><br>
        <div class="signature-line"></div>
        <p>NIP. _____________________</p>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
