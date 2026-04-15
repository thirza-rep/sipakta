<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use Illuminate\Http\Request;

class ProfilPemohonController extends Controller
{
    /**
     * Show the form for editing the pemohon profile
     */
    public function edit()
    {
        $user = auth()->user();
        $profil = $user->profilPemohon ?? new ProfilPemohon(['user_id' => $user->id, 'nama_lengkap' => $user->name]);

        return view('profil-pemohon.edit', compact('profil', 'user'));
    }

    /**
     * Update the pemohon profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ]);

        $user = auth()->user();

        ProfilPemohon::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // Update user name to match profile
        $user->update(['name' => $validated['nama_lengkap']]);

        return redirect()->route('profil-pemohon.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show the pemohon profile
     */
    public function show()
    {
        $user = auth()->user();
        $profil = $user->profilPemohon;

        if (!$profil) {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        return view('profil-pemohon.show', compact('profil', 'user'));
    }
}
