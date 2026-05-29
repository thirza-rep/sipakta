<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use App\Models\LogPencarian;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    /**
     * Show the search page for pemohon
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if pemohon is verified
        if ($redirect = $this->checkVerification($user)) {
            return $redirect;
        }

        return view('pencarian.index');
    }

    /**
     * Process search and show results
     */
    public function search(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if pemohon is verified
        if ($redirect = $this->checkVerification($user)) {
            return $redirect;
        }

        $keyword = $request->get('keyword', '');

        if (empty(trim($keyword))) {
            return redirect()->route('pencarian.index')
                ->with('error', 'Masukkan kata kunci pencarian.');
        }

        // Perform search using Laravel Scout (Meilisearch)
        $results = AktaNikah::search($keyword)->paginate(10);

        // Log the search
        LogPencarian::log($user->id, $keyword, $results->total());

        return view('pencarian.hasil', [
            'results' => $results,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show detail of a specific arsip (read-only for pemohon)
     */
    public function show($id)
    {
        $arsip = AktaNikah::findOrFail($id);
        return view('pencarian.detail', compact('arsip'));
    }

    /**
     * Helper to verify if pemohon is fully verified by KUA Admin
     */
    private function checkVerification($user)
    {
        if (!$user->isPemohon()) {
            return null; // non-pemohon roles are exempted
        }

        $profil = $user->profilPemohon;

        if (!$profil || $profil->status === 'unverified') {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil, verifikasi WhatsApp, dan unggah berkas KTP Anda untuk mengajukan verifikasi.');
        }

        if ($profil->status === 'pending_verification') {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Profil Anda sedang dalam proses verifikasi oleh Admin/Petugas KUA. Harap tunggu persetujuan.');
        }

        if ($profil->status === 'rejected') {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Pengajuan verifikasi profil Anda ditolak oleh Admin. Alasan: "' . $profil->rejected_reason . '". Silakan perbarui data & foto KTP Anda.');
        }

        if ($profil->status !== 'verified') {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Akun Anda harus terverifikasi untuk dapat menggunakan fitur pencarian.');
        }

        return null; // OK
    }
}
