<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Salinan Data Pemohon — SIPAKTA</title>
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

        .checklist { margin: 15px 0; }
        .checklist-item { padding: 8px 12px; margin-bottom: 5px; border: 1px solid #e2e8f0; border-radius: 5px; font-size: 12pt; }
        .checklist-item.ok { background: #f0fdf4; border-color: #86efac; }
        .checklist-item.fail { background: #fef2f2; border-color: #fca5a5; }

        .footer { margin-top: 40px; border-top: 2px solid #e2e8f0; padding-top: 15px; font-size: 10pt; color: #94a3b8; text-align: center; }
        .stamp-area { margin-top: 40px; text-align: right; }
        .stamp-area .label { font-size: 11pt; color: #475569; }
        .stamp-area .name { font-size: 12pt; font-weight: bold; color: #1e293b; margin-top: 60px; border-top: 1px solid #1e293b; display: inline-block; padding-top: 5px; }
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
        <strong style="font-size: 14pt; text-decoration: underline;">SALINAN DATA PEMOHON</strong><br>
        <span style="font-size: 11pt; color: #64748b;">Dokumen ini dicetak sebagai arsip kelengkapan verifikasi</span>
    </div>

    <div class="section-title">Identitas Pemohon</div>
    <table class="data">
        <tr><td class="label">Nama Lengkap</td><td class="value">{{ $profil->nama_lengkap }}</td></tr>
        <tr><td class="label">NIK</td><td class="value">{{ $profil->nik }}</td></tr>
        <tr><td class="label">Alamat Domisili</td><td class="value">{{ $profil->alamat ?? '-' }}</td></tr>
        <tr><td class="label">Nomor WhatsApp</td><td class="value">{{ $profil->no_telepon ?? '-' }}</td></tr>
        <tr><td class="label">Email</td><td class="value">{{ $profil->user->email }}</td></tr>
    </table>

    <div class="section-title">Status Verifikasi</div>
    <div class="checklist">
        <div class="checklist-item {{ $profil->user->email_verified_at ? 'ok' : 'fail' }}">
            {{ $profil->user->email_verified_at ? '✔' : '✘' }} Email: {{ $profil->user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
        </div>
        <div class="checklist-item {{ $profil->no_telepon ? 'ok' : 'fail' }}">
            {{ $profil->no_telepon ? '✔' : '✘' }} WhatsApp: {{ $profil->no_telepon ? 'Sudah Diisi' : 'Belum Diisi' }}
        </div>

        <div class="checklist-item {{ $profil->nik && strlen($profil->nik) === 16 ? 'ok' : 'fail' }}">
            {{ $profil->nik && strlen($profil->nik) === 16 ? '✔' : '✘' }} NIK: {{ $profil->nik && strlen($profil->nik) === 16 ? '16 Digit Valid' : 'Tidak Valid' }}
        </div>
    </div>

    <table class="data">
        <tr>
            <td class="label">Status Akun</td>
            <td class="value">
                @if($profil->status === 'verified') DISETUJUI (AKTIF)
                @elseif($profil->status === 'pending_verification') MENUNGGU VERIFIKASI
                @elseif($profil->status === 'rejected') DITOLAK
                @else BELUM DIAJUKAN
                @endif
            </td>
        </tr>
        @if($profil->status === 'rejected' && $profil->rejected_reason)
        <tr><td class="label">Alasan Penolakan</td><td class="value">{{ $profil->rejected_reason }}</td></tr>
        @endif
        <tr><td class="label">Tanggal Pengajuan</td><td class="value">{{ $profil->updated_at ? $profil->updated_at->translatedFormat('d F Y, H:i') : '-' }}</td></tr>
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
