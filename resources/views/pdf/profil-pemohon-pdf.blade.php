<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Salinan Data Pemohon — SIPAKTA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; line-height: 1.5; padding: 30px; }

        /* Remove old header styles as we use inline styles for the table layout now */

        .section-title { font-size: 13pt; font-weight: bold; color: #000; border-bottom: 2px solid #000; padding-bottom: 5px; margin-top: 25px; margin-bottom: 15px; text-transform: uppercase; }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data td { padding: 8px 10px; vertical-align: top; border-bottom: 1px solid #333; font-size: 12pt; }
        table.data td.label { width: 220px; font-weight: bold; color: #000; }
        table.data td.value { color: #000; }

        .checklist { margin: 15px 0; }
        .checklist-item { padding: 5px 0; font-size: 12pt; }
        
        .footer { margin-top: 40px; border-top: 1px solid #000; padding-top: 10px; font-size: 10pt; color: #333; text-align: center; font-style: italic; }
        .stamp-area { margin-top: 40px; text-align: right; }
        .stamp-area .label { font-size: 11pt; color: #000; }
        .stamp-area .name { font-size: 12pt; font-weight: bold; color: #000; margin-top: 60px; border-top: 1px solid #000; display: inline-block; padding-top: 5px; }
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
        <strong style="font-size: 14pt; text-decoration: underline;">SALINAN DATA PEMOHON</strong><br>
        <span style="font-size: 11pt; color: #000;">Dokumen ini dicetak sebagai arsip kelengkapan verifikasi</span>
    </div>

    <div class="section-title">Identitas Pemohon</div>
    <table class="data">
        <tr><td class="label">Nama Lengkap</td><td class="value">{{ $profil->nama_lengkap }}</td></tr>
        <tr><td class="label">NIK</td><td class="value">{{ $profil->nik }}</td></tr>
        <tr><td class="label">Tempat, Tgl Lahir</td><td class="value">{{ $profil->tempat_lahir ?? '-' }}, {{ $profil->tanggal_lahir_formatted }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td class="value">{{ $profil->jenis_kelamin_display }}</td></tr>
        <tr><td class="label">Alamat Domisili</td><td class="value">{{ $profil->alamat ?? '-' }}</td></tr>
        <tr><td class="label">Nomor WhatsApp</td><td class="value">{{ $profil->no_telepon ?? '-' }}</td></tr>
        <tr><td class="label">Email</td><td class="value">{{ $profil->user->email }}</td></tr>
        <tr><td class="label">Keperluan Akses</td><td class="value">{{ $profil->keperluan ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Status Kelengkapan Berkas</div>
    <div class="checklist">
        <div class="checklist-item">
            [ {{ $profil->user->email_verified_at ? 'X' : ' ' }} ] Email ({{ $profil->user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }})
        </div>
        <div class="checklist-item">
            [ {{ $profil->no_telepon ? 'X' : ' ' }} ] Nomor WhatsApp ({{ $profil->no_telepon ? 'Sudah Diisi' : 'Belum Diisi' }})
        </div>
        <div class="checklist-item">
            [ {{ $profil->nik && strlen($profil->nik) === 16 ? 'X' : ' ' }} ] NIK KTP ({{ $profil->nik && strlen($profil->nik) === 16 ? '16 Digit Valid' : 'Tidak Valid' }})
        </div>
    </div>

    <div class="section-title">Riwayat Persetujuan & Verifikasi</div>
    <table class="data">
        <tr><td class="label">Tanggal Pengajuan</td><td class="value">{{ $profil->created_at ? $profil->created_at->translatedFormat('d F Y, H:i') : '-' }}</td></tr>
        <tr>
            <td class="label">Status Verifikasi</td>
            <td class="value">
                @if($profil->status === 'verified') <strong>DISETUJUI (AKTIF)</strong>
                @elseif($profil->status === 'pending_verification') <strong>MENUNGGU VERIFIKASI</strong>
                @elseif($profil->status === 'rejected') <strong>DITOLAK</strong>
                @else <strong>BELUM DIAJUKAN</strong>
                @endif
            </td>
        </tr>
        @if($profil->status === 'rejected' && $profil->rejected_reason)
        <tr><td class="label">Alasan Penolakan</td><td class="value">{{ $profil->rejected_reason }}</td></tr>
        @endif
        @if($profil->status !== 'pending_verification')
        <tr><td class="label">Tanggal Diproses</td><td class="value">{{ $profil->updated_at ? $profil->updated_at->translatedFormat('d F Y, H:i') : '-' }}</td></tr>
        @endif
    </table>

    <div class="stamp-area">
        <div class="label">Yogyakarta, {{ $tanggalCetak }}</div>
        <div class="label">Dicetak oleh:</div>
        <div class="name">{{ $petugasNama }}</div>
    </div>

    <div class="footer">
        Dokumen ini dicetak oleh sistem SIPAKTA — Sistem Informasi Pencarian dan Pengarsipan Akta Nikah<br>
        KUA Kemantren Tegalrejo, Kota Yogyakarta &bull; {{ $tanggalCetak }}
    </div>
</body>
</html>
