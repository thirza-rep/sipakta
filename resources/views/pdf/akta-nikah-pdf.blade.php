<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Salinan Arsip Akta Nikah — SIPAKTA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 13pt; color: #1e293b; line-height: 1.6; padding: 30px; }

        .header { text-align: center; border-bottom: 3px solid #0f766e; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { font-size: 16pt; font-weight: bold; color: #0f766e; margin-bottom: 3px; }
        .header h2 { font-size: 12pt; font-weight: normal; color: #475569; }
        .header .sub { font-size: 10pt; color: #94a3b8; margin-top: 5px; }

        .section-title { font-size: 14pt; font-weight: bold; color: #0f766e; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-top: 25px; margin-bottom: 15px; }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data td { padding: 10px 12px; vertical-align: top; border-bottom: 1px solid #e2e8f0; font-size: 12pt; }
        table.data td.label { width: 200px; font-weight: bold; color: #475569; background: #f8fafc; }
        table.data td.value { color: #1e293b; font-weight: 600; }

        .notice { background: #f0fdf4; border: 2px solid #86efac; padding: 15px; border-radius: 8px; margin-top: 25px; font-size: 12pt; }
        .notice strong { color: #166534; }

        .footer { margin-top: 40px; border-top: 2px solid #e2e8f0; padding-top: 15px; font-size: 10pt; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANTOR URUSAN AGAMA (KUA)</h1>
        <h1>KEMANTREN TEGALREJO — KOTA YOGYAKARTA</h1>
        <h2>Kementerian Agama Republik Indonesia</h2>
        <div class="sub">Jl. Magelang KM 4,5 No.03, Tegalrejo, Yogyakarta | Telp: (0274) 623456</div>
    </div>

    <div style="text-align: center; margin-bottom: 25px;">
        <strong style="font-size: 14pt; text-decoration: underline;">SALINAN ARSIP AKTA NIKAH</strong><br>
        <span style="font-size: 11pt; color: #64748b;">Dokumen ini merupakan bukti hasil pencarian arsip digital</span>
    </div>

    <div class="section-title">Data Akta Nikah</div>
    <table class="data">
        <tr><td class="label">Nomor Akta</td><td class="value">{{ $akta->no_akta }}</td></tr>
        <tr><td class="label">Nama Suami</td><td class="value">{{ $akta->nama_suami }}</td></tr>
        <tr><td class="label">Nama Istri</td><td class="value">{{ $akta->nama_istri }}</td></tr>
        <tr><td class="label">Tanggal Akad Nikah</td><td class="value">{{ $akta->tanggal_akad ? \Carbon\Carbon::parse($akta->tanggal_akad)->translatedFormat('d F Y') : '-' }}</td></tr>
        <tr><td class="label">Lokasi Penyimpanan Fisik</td><td class="value">{{ $akta->lokasi_fisik ?? '-' }}</td></tr>
        <tr><td class="label">Arsip Digital</td><td class="value">{{ $akta->file_path ? 'Tersedia (Tersertifikasi)' : 'Belum Tersedia (Fisik Saja)' }}</td></tr>
    </table>

    @if($pemohon)
    <div class="section-title">Data Pemohon Pencarian</div>
    <table class="data">
        <tr><td class="label">Nama Pemohon</td><td class="value">{{ $pemohon->nama_lengkap ?? $userName }}</td></tr>
        <tr><td class="label">NIK Pemohon</td><td class="value">{{ $pemohon->nik ?? '-' }}</td></tr>
        <tr><td class="label">Nomor WhatsApp</td><td class="value">{{ $pemohon->no_telepon ?? '-' }}</td></tr>
        <tr><td class="label">Alamat Pemohon</td><td class="value">{{ $pemohon->alamat ?? '-' }}</td></tr>
    </table>
    @endif

    <table class="data">
        <tr><td class="label">Tanggal & Waktu Cetak</td><td class="value">{{ $tanggalCetak }}</td></tr>
    </table>

    <div class="notice">
        <strong>PENTING:</strong> Dokumen ini merupakan hasil pencarian digital dan <strong>BUKAN</strong> merupakan salinan resmi akta nikah. Untuk mendapatkan kutipan atau legalisir dokumen resmi, pemohon diwajibkan datang langsung ke Kantor KUA Kemantren Tegalrejo dengan membawa KTP asli dan menyebutkan Nomor Akta di atas.
    </div>

    <div class="footer">
        Dokumen ini dicetak oleh sistem SIPAKTA — Sistem Informasi Pencarian dan Pengarsipan Akta Nikah<br>
        KUA Kemantren Tegalrejo, Kota Yogyakarta &bull; {{ $tanggalCetak }}
    </div>
</body>
</html>
