<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        $user = auth()->user();
        $profil = $user->profilPemohon ?? new ProfilPemohon(['user_id' => $user->id, 'nama_lengkap' => $user->name]);

        return view('profil-pemohon.edit', compact('profil', 'user'));
    }

    /**
     * Update the pemohon profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $profil = $user->profilPemohon;

        // Validation rules
        $rules = [
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ];

        // NIK must be unique in profil_pemohon table (except for current profile)
        $nikUniqueRule = 'unique:profil_pemohon,nik';
        if ($profil) {
            $nikUniqueRule .= ',' . $profil->id;
        }
        $rules['nik'][] = $nikUniqueRule;



        $validated = $request->validate($rules);

        // Verify Phone Number Check:
        // Either the phone number hasn't changed from a previously verified number,
        // or the new number is verified in the session.
        $phoneVerified = false;
        $phoneNumber = trim($validated['no_telepon']);
        $sessionPhone = session('verified_phone_number');

        if ($profil && $profil->phone_verified_at && $profil->no_telepon === $phoneNumber) {
            $phoneVerified = true;
        } elseif ($sessionPhone && trim($sessionPhone) === $phoneNumber) {
            $phoneVerified = true;
        }

        if (!$phoneVerified) {
            return back()->withInput()->withErrors([
                'no_telepon' => 'Nomor telepon harus diverifikasi melalui OTP WhatsApp terlebih dahulu.'
            ]);
        }



        // Update or create profile
        $newProfil = ProfilPemohon::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'status' => 'pending_verification', // set status to pending review
                'rejected_reason' => null, // clear old rejection reason
                'phone_verified_at' => $profil && $profil->phone_verified_at && $profil->no_telepon === $phoneNumber
                    ? $profil->phone_verified_at
                    : now(),
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
        $user = auth()->user();
        $profil = $user->profilPemohon;

        if (!$profil) {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        return view('profil-pemohon.show', compact('profil', 'user'));
    }

    /**
     * AJAX endpoint to send phone OTP via WhatsApp
     */
    public function sendPhoneOtp(Request $request)
    {
        try {
            $request->validate([
                'no_telepon' => ['required', 'string', 'min:9', 'max:16'],
            ]);

            $phone = $request->no_telepon;
            
            /** @var \App\Models\User $currentUser */
            $currentUser = auth()->user();
            // Generate OTP
            $code = $this->otpService->generateOtp($phone, 'phone', $currentUser->id);
            
            // Send OTP
            $sent = $this->otpService->sendWhatsAppOtp($phone, $code);

            if ($sent) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kode OTP berhasil dikirim ke nomor WhatsApp Anda.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP. Harap hubungi Admin atau coba sesaat lagi.'
            ], 500);

        } catch (\Exception $e) {
            Log::error("AJAX Send OTP Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses permintaan: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * AJAX endpoint to verify phone OTP
     */
    public function verifyPhoneOtp(Request $request)
    {
        try {
            $request->validate([
                'no_telepon' => ['required', 'string'],
                'otp' => ['required', 'string', 'size:6'],
            ]);

            $phone = $request->no_telepon;
            $code = $request->otp;

            $isVerified = $this->otpService->verifyOtp($phone, 'phone', $code);

            if ($isVerified) {
                // Save verified status in session
                session(['verified_phone_number' => $phone]);

                // If user already has profile database record, update it immediately
                /** @var \App\Models\User $user */
                $user = auth()->user();
                if ($user->profilPemohon) {
                    $user->profilPemohon->update([
                        'no_telepon' => $phone,
                        'phone_verified_at' => now(),
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Nomor WhatsApp Anda berhasil diverifikasi!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah atau telah kedaluwarsa.'
            ], 422);

        } catch (\Exception $e) {
            Log::error("AJAX Verify OTP Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses verifikasi.'
            ], 422);
        }
    }
}
