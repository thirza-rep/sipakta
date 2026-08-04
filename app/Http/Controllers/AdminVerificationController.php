<?php

namespace App\Http\Controllers;

use App\Models\ProfilPemohon;
use Illuminate\Http\Request;

class AdminVerificationController extends Controller
{
    /**
     * Display a listing of pemohon verification requests
     */
    public function index(Request $request)
    {
        $query = ProfilPemohon::with('user');

        // Status filter (default: show pending_verification first)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // By default, prioritize pending_verification, then show all
            $query->orderByRaw("CASE status 
                WHEN 'pending_verification' THEN 1 
                WHEN 'rejected' THEN 2 
                WHEN 'unverified' THEN 3 
                WHEN 'verified' THEN 4 
                ELSE 5 END ASC");
        }

        // Search by name or NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.verification.index', compact('requests'));
    }

    /**
     * Show detail of a verification request
     */
    public function show(int $id)
    {
        $requestData = ProfilPemohon::with('user')->findOrFail($id);
        return view('admin.verification.show', compact('requestData'));
    }

    /**
     * Approve the pemohon verification request
     */
    public function approve(int $id)
    {
        $profile = ProfilPemohon::findOrFail($id);
        
        $profile->update([
            'status' => 'verified',
            'rejected_reason' => null
        ]);

        return redirect()->route('admin.verification.index')
            ->with('success', 'Akun Pemohon atas nama "' . $profile->nama_lengkap . '" berhasil diverifikasi dan diaktifkan!');
    }

    /**
     * Reject the pemohon verification request
     */
    public function reject(Request $request, int $id)
    {
        $request->validate([
            'rejected_reason' => ['required', 'string', 'max:500'],
        ]);

        $profile = ProfilPemohon::findOrFail($id);
        
        $profile->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason
        ]);

        return redirect()->route('admin.verification.index')
            ->with('success', 'Verifikasi Akun Pemohon atas nama "' . $profile->nama_lengkap . '" berhasil ditolak.');
    }

    /**
     * Download or view the uploaded document (KTP or Dokumen Pendukung)
     */
    public function download(int $id, string $type)
    {
        $profile = ProfilPemohon::findOrFail($id);
        
        $path = $type === 'ktp' ? $profile->foto_ktp : $profile->dokumen_pendukung;
        
        if (!$path) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        try {
            return \Illuminate\Support\Facades\Storage::disk('google')->response($path);
        } catch (\Exception $e) {
            abort(404, 'File tidak ditemukan di Google Drive atau terjadi kesalahan otorisasi.');
        }
    }
}
