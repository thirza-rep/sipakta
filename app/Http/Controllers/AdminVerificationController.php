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
            $query->orderByRaw("FIELD(status, 'pending_verification', 'rejected', 'unverified', 'verified') ASC");
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
}
