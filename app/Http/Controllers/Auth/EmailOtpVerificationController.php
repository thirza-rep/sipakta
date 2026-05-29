<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailOtpVerificationController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Display the email OTP verification view.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $identifier = $user->email;
        
        // Check if there is an active OTP that hasn't expired yet
        $existingOtp = \Illuminate\Support\Facades\DB::table('otp_verifications')
            ->where('identifier', $identifier)
            ->where('type', 'email')
            ->where('expires_at', '>', \Carbon\Carbon::now()->addMinutes(1))
            ->first();

        if (!$existingOtp) {
            $code = $this->otpService->generateOtp($identifier, 'email', $user->id);
            $this->otpService->sendEmailOtp($identifier, $code, $user->name);
        }

        return view('auth.email-otp', ['email' => $user->email]);
    }

    /**
     * Verify the email OTP code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6', 'regex:/^[0-9]+$/'],
        ]);

        $user = $request->user();
        $isVerified = $this->otpService->verifyOtp($user->email, 'email', $request->otp);

        if ($isVerified) {
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            return redirect()->route('profil-pemohon.edit')
                ->with('success', 'Email Anda berhasil diverifikasi! Silakan lengkapi profil Anda.');
        }

        return back()->withErrors(['otp' => 'Kode OTP yang dimasukkan tidak valid atau telah kedaluwarsa.']);
    }

    /**
     * Resend the email OTP.
     */
    public function resend(Request $request)
    {
        $user = $request->user();
        $identifier = $user->email;

        $code = $this->otpService->generateOtp($identifier, 'email', $user->id);
        $this->otpService->sendEmailOtp($identifier, $code, $user->name);

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
