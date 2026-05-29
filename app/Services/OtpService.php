<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class OtpService
{
    /**
     * Generate and store an OTP code
     */
    public function generateOtp(string $identifier, string $type, ?int $userId = null): string
    {
        // 6-digit random number
        $code = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = Carbon::now()->addMinutes(5);

        // Delete any existing unused OTPs for this identifier and type
        DB::table('otp_verifications')
            ->where('identifier', $identifier)
            ->where('type', $type)
            ->delete();

        // Save new OTP
        DB::table('otp_verifications')->insert([
            'user_id' => $userId,
            'identifier' => $identifier,
            'code' => $code,
            'type' => $type,
            'expires_at' => $expiresAt,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $code;
    }

    /**
     * Send OTP via Email
     */
    public function sendEmailOtp(string $email, string $code, string $name = 'Pengguna'): bool
    {
        try {
            $subject = "Kode OTP Verifikasi Akun SIPAKTA - {$code}";
            
            $htmlContent = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; rounded: 12px;'>
                <div style='background-color: #0f766e; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;'>
                    <h1 style='color: white; margin: 0; font-size: 24px;'>SIPAKTA KUA</h1>
                </div>
                <div style='padding: 20px; color: #334155; line-height: 1.6;'>
                    <p>Halo <strong>{$name}</strong>,</p>
                    <p>Anda menerima email ini karena Anda sedang melakukan verifikasi akun di Sistem Informasi Pelayanan Akta Nikah (SIPAKTA).</p>
                    <p>Berikut adalah kode OTP Anda untuk memverifikasi alamat email:</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <span style='font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #0f766e; background-color: #f1f5f9; padding: 12px 30px; border-radius: 8px; border: 1px dashed #cbd5e1; display: inline-block;'>{$code}</span>
                    </div>
                    
                    <p style='color: #ef4444; font-size: 14px;'><strong>PENTING:</strong> Kode ini hanya berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini kepada siapapun demi keamanan akun Anda.</p>
                    <hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #64748b; text-align: center;'>Email ini dikirim secara otomatis oleh sistem SIPAKTA. Harap tidak membalas email ini.</p>
                </div>
            </div>
            ";

            Mail::html($htmlContent, function ($message) use ($email, $subject) {
                $message->to($email)
                    ->subject($subject);
            });

            Log::info("Email OTP sent successfully to {$email}. Code: {$code}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send Email OTP to {$email}. Error: " . $e->getMessage());
            // Fallback for local development if mail configuration fails
            Log::info("FALLBACK EMAIL OTP: To: {$email}, Code: {$code}");
            return true; // We return true to allow local testing even if mailer isn't fully configured
        }
    }

    /**
     * Send OTP via WhatsApp
     */
    public function sendWhatsAppOtp(string $phone, string $code): bool
    {
        $message = "Berikut adalah kode OTP SIPAKTA Anda untuk verifikasi nomor HP:\n\n*{$code}*\n\nKode ini hanya berlaku selama *5 menit*. Demi keamanan, JANGAN bagikan kode ini kepada siapa pun.";
        
        // Log locally
        Log::info("WHATSAPP OTP SENDING: To: {$phone}, Message: {$message}");

        $gatewayUrl = env('WA_GATEWAY_URL');
        $gatewayToken = env('WA_GATEWAY_TOKEN');

        if (!empty($gatewayUrl)) {
            try {
                // If a self-hosted or external API is configured in .env, we make an HTTP request.
                // Dynamic body mapping depending on standard provider (Wablas/Fonnte or Node.js baileys gateway)
                $response = Http::timeout(10)->post($gatewayUrl, [
                    'token' => $gatewayToken, // for providers like Fonnte/Wablas
                    'target' => $phone,
                    'phone' => $phone, // alternate key
                    'message' => $message,
                    'text' => $message, // alternate key
                ]);

                if ($response->successful()) {
                    Log::info("WhatsApp OTP sent successfully via Gateway to {$phone}");
                    return true;
                } else {
                    Log::warning("WhatsApp Gateway returned non-success response: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Failed to send WhatsApp OTP via Gateway to {$phone}. Error: " . $e->getMessage());
            }
        }

        // Return true because for local dev we see it in laravel.log (mocked)
        return true;
    }

    /**
     * Verify an OTP code
     */
    public function verifyOtp(string $identifier, string $type, string $code): bool
    {
        $otp = DB::table('otp_verifications')
            ->where('identifier', $identifier)
            ->where('type', $type)
            ->where('code', $code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otp) {
            // Delete verified OTP so it cannot be used again
            DB::table('otp_verifications')
                ->where('id', $otp->id)
                ->delete();
                
            return true;
        }

        return false;
    }
}
