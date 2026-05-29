<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerifiedWithOtp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only enforce for pemohon (public users)
        if ($user && $user->isPemohon() && !$user->email_verified_at) {
            // Allow access to verification routes and logout
            if ($request->routeIs('verification.otp.show') || 
                $request->routeIs('verification.otp.verify') || 
                $request->routeIs('verification.otp.resend') || 
                $request->routeIs('logout')) {
                return $next($request);
            }

            return $request->expectsJson()
                ? abort(403, 'Alamat email Anda belum terverifikasi.')
                : Redirect::guest(route('verification.otp.show'));
        }

        return $next($request);
    }
}
