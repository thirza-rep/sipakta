<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use App\Models\AktaNikah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Export PDF salinan data pemohon (untuk Admin)
     */
    public function exportProfilPemohon($id)
    {
        $profil = ProfilPemohon::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.profil-pemohon-pdf', [
            'profil' => $profil,
            'petugasNama' => auth()->user()->name,
            'tanggalCetak' => now()->translatedFormat('d F Y, H:i'),
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('salinan-data-pemohon-' . $profil->nik . '.pdf');
    }

    /**
     * Export PDF salinan arsip akta nikah (untuk Pemohon)
     */
    public function exportAktaNikah($id)
    {
        $akta = AktaNikah::findOrFail($id);
        $user = auth()->user();
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
