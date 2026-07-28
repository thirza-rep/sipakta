<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfilPemohonController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the form for editing the pemohon profile
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profil = $user->profilPemohon ?? new ProfilPemohon(['user_id' => $user->id, 'nama_lengkap' => $user->name]);

        return view('profil-pemohon.edit', compact('profil', 'user'));
    }

    /**
     * Update the pemohon profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profil = $user->profilPemohon;

        // Validation rules
        $rules = [
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'keperluan' => ['required', 'string'],
        ];

        // NIK must be unique in profil_pemohon table (except for current profile)
        $nikUniqueRule = 'unique:profil_pemohon,nik';
        if ($profil) {
            $nikUniqueRule .= ',' . $profil->id;
        }
        $rules['nik'][] = $nikUniqueRule;



        $validated = $request->validate($rules);





        // Update or create profile
        $newProfil = ProfilPemohon::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'keperluan' => $validated['keperluan'],
                'status' => 'pending_verification', // set status to pending review
                'rejected_reason' => null, // clear old rejection reason
                'phone_verified_at' => now(), // automatically verified without OTP
            ]
        );

        // Update user name to match profile
        $user->update(['name' => $validated['nama_lengkap']]);

        // Clear session variables used for phone verification
        session()->forget(['verified_phone_number']);

        return redirect()->route('profil-pemohon.edit')
            ->with('success', 'Data profil berhasil diajukan untuk verifikasi! Harap tunggu persetujuan Admin.');
    }

    /**
     * Show the pemohon profile
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profil = $user->profilPemohon;

        if (!$profil) {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        return view('profil-pemohon.show', compact('profil', 'user'));
    }


}
