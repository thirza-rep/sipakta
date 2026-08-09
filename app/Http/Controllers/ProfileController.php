<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->filled('foto_profil') && str_starts_with($request->foto_profil, 'data:image')) {
            $user = $request->user();
            
            // Delete old photo if exists
            if ($user->foto_profil) {
                Storage::disk('google')->delete($user->foto_profil);
            }
            
            // Decode base64
            $image_parts = explode(";base64,", $request->foto_profil);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            $fileName = 'profile_photos/' . Str::uuid() . '.' . $image_type;
            
            // Store new photo
            Storage::disk('google')->put($fileName, $image_base64);
            $user->foto_profil = $fileName;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Stream profile photo from Google Drive with caching.
     */
    public function showPhoto($filename)
    {
        $path = 'profile_photos/' . $filename;
        
        // Cache the file content for 24 hours to reduce API calls
        $cacheKey = 'profile_photo_' . $filename;
        
        $fileContent = Cache::remember($cacheKey, now()->addHours(24), function () use ($path) {
            if (Storage::disk('google')->exists($path)) {
                return Storage::disk('google')->get($path);
            }
            return null;
        });

        if (!$fileContent) {
            abort(404);
        }

        $mimeType = 'image/jpeg';
        if (str_ends_with($filename, '.png')) {
            $mimeType = 'image/png';
        }

        return Response::make($fileContent, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
