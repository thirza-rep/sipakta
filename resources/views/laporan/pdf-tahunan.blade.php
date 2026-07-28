<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Tahunan - {{ $tahun }}</title>
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
            text-align: center;
        }
        .summary-item {
            display: inline-block;
            margin: 0 20px;
            font-size: 14px;
        }
        .summary-item strong {
            color: #0f766e;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #0f766e;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        td.text-center {
            text-align: center;
        }
        td.text-right {
            text-align: right;
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
        <h2>LAPORAN REKAPITULASI TAHUNAN ARSIP AKTA NIKAH</h2>
        <p>Tahun: {{ $tahun }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span>Total Arsip Terdaftar Tahun {{ $tahun }}:</span><br>
            <strong>{{ number_format($totalTahun) }} Dokumen</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%">No</th>
                <th style="width: 50%">Bulan</th>
                <th style="width: 40%">Jumlah Arsip Akta Nikah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyStats as $index => $data)
                <tr>
                    <td class="text-center">{{ $index }}</td>
                    <td><strong>{{ $data['bulan'] }}</strong></td>
                    <td class="text-center">{{ number_format($data['jumlah']) }} Arsip</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right" style="font-weight: bold; padding-right: 15px;">TOTAL KESELURUHAN</td>
                <td class="text-center" style="font-weight: bold; background: #0f766e; color: white;">
                    {{ number_format($totalTahun) }} Arsip
                </td>
            </tr>
        </tfoot>
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
