<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Salinan Arsip Akta Nikah — SIPAKTA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; line-height: 1.5; padding: 30px; }

        /* Remove old header styles as we use inline styles for the table layout now */

        .section-title { font-size: 13pt; font-weight: bold; color: #000; border-bottom: 2px solid #000; padding-bottom: 5px; margin-top: 25px; margin-bottom: 15px; text-transform: uppercase; }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data td { padding: 8px 10px; vertical-align: top; border-bottom: 1px solid #333; font-size: 12pt; }
        table.data td.label { width: 220px; font-weight: bold; color: #000; }
        table.data td.value { color: #000; }

        .notice { border: 2px solid #000; padding: 15px; margin-top: 25px; font-size: 11pt; }
        .notice strong { color: #000; }

        .footer { margin-top: 40px; border-top: 1px solid #000; padding-top: 10px; font-size: 10pt; color: #333; text-align: center; font-style: italic; }
    </style>
</head>
<body>
    <table style="width: 100%; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td style="width: 15%; text-align: center; vertical-align: middle;">
                <img src="{{ public_path('images/logo-kua.jpg') }}" alt="Logo KUA" style="width: 80px;">
            </td>
            <td style="width: 70%; text-align: center; vertical-align: middle;">
                <h1 style="font-size: 16pt; font-weight: bold; color: #000; margin-bottom: 2px;">KANTOR URUSAN AGAMA (KUA)</h1>
                <h1 style="font-size: 16pt; font-weight: bold; color: #000; margin-bottom: 2px;">KEMANTREN TEGALREJO — KOTA YOGYAKARTA</h1>
                <h2 style="font-size: 12pt; font-weight: normal; color: #000; margin-bottom: 2px;">Kementerian Agama Republik Indonesia</h2>
                <div style="font-size: 10pt; color: #000; margin-top: 5px;">Jl. Tompeyan No.200A, Tegalrejo, Kec. Tegalrejo, Kota Yogyakarta, DIY 55244</div>
            </td>
            <td style="width: 15%; text-align: center; vertical-align: middle;">
                <!-- Penyeimbang layout -->
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 25px;">
        <strong style="font-size: 14pt; text-decoration: underline;">SALINAN ARSIP AKTA NIKAH</strong><br>
        <span style="font-size: 11pt; color: #000;">Dokumen ini merupakan bukti hasil pencarian arsip digital</span>
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
        <tr><td class="label">Validasi / Alasan</td><td class="value">{{ $alasanCetak }}</td></tr>
    </table>
    @endif

    <table class="data">
        <tr><td class="label">Tanggal & Waktu Cetak</td><td class="value">{{ $tanggalCetak }}</td></tr>
    </table>

    <div class="notice">
        <strong>PENTING: PERSIAPAN PENGAMBILAN DOKUMEN FISIK</strong><br><br>
        Dokumen ini merupakan bukti awal hasil pencarian digital dan <strong>BUKAN</strong> merupakan salinan resmi akta nikah. Untuk mendapatkan kutipan atau legalisir dokumen resmi, pemohon diwajibkan datang langsung ke Kantor KUA Kemantren Tegalrejo.
        <br><br>
        <strong>Dokumen Persyaratan yang Wajib Dibawa:</strong>
        <ul style="margin-top: 5px; margin-left: 20px;">
            <li>KTP Asli Pemohon (Sesuai nama yang tertera di atas)</li>
            <li>Fotokopi Kartu Keluarga (KK)</li>
            <li>Hasil Cetak (Print out) Bukti Pencarian ini</li>
            <li>Surat Kuasa bermaterai (Jika pengambilan diwakilkan oleh pihak lain)</li>
        </ul>
    </div>

    <div class="footer">
        Dokumen ini dicetak oleh sistem SIPAKTA — Sistem Informasi Pencarian dan Pengarsipan Akta Nikah<br>
        KUA Kemantren Tegalrejo, Kota Yogyakarta &bull; {{ $tanggalCetak }}
    </div>
</body>
</html>
