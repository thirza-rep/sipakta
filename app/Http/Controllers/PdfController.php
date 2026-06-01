<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use App\Models\AktaNikah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    /**
     * Export PDF salinan data pemohon (untuk Admin)
     */
    public function exportProfilPemohon(string $id)
    {
        $profil = ProfilPemohon::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.profil-pemohon-pdf', [
            'profil' => $profil,
            'petugasNama' => Auth::user()?->name ?? 'Admin',
            'tanggalCetak' => now()->translatedFormat('d F Y, H:i'),
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('salinan-data-pemohon-' . $profil->nik . '.pdf');
    }

    /**
     * Export PDF salinan arsip akta nikah (untuk Pemohon)
     */
    public function exportAktaNikah(string $id)
    {
        $akta = AktaNikah::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profil = $user->profilPemohon;

        $pdf = Pdf::loadView('pdf.akta-nikah-pdf', [
            'akta' => $akta,
            'pemohon' => $profil,
            'userName' => $user->name,
            'tanggalCetak' => now()->translatedFormat('d F Y, H:i'),
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('salinan-arsip-akta-' . $akta->no_akta . '.pdf');
    }
}
