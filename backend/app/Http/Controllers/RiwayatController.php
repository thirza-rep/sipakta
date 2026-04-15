<?php

namespace App\Http\Controllers;

use App\Models\LogPencarian;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display list of search history (for Kepala KUA)
     */
    public function index(Request $request)
    {
        $query = LogPencarian::with('user')
            ->orderBy('waktu', 'desc');

        // Filter by user type (pemohon only or all)
        if ($request->get('filter') === 'pemohon') {
            $query->whereHas('user', function ($q) {
                $q->where('role', User::ROLE_PEMOHON);
            });
        }

        // Search by keyword or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kata_kunci', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('waktu', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('waktu', '<=', $request->sampai);
        }

        $riwayat = $query->paginate(15);

        // Statistics
        $stats = [
            'total_pencarian' => LogPencarian::count(),
            'pencarian_hari_ini' => LogPencarian::whereDate('waktu', today())->count(),
            'pencarian_bulan_ini' => LogPencarian::whereMonth('waktu', now()->month)
                                                  ->whereYear('waktu', now()->year)
                                                  ->count(),
            'total_pemohon' => User::where('role', User::ROLE_PEMOHON)->count(),
        ];

        return view('riwayat.index', compact('riwayat', 'stats'));
    }

    /**
     * Show detail riwayat for a specific user
     */
    public function showUser(User $user)
    {
        $riwayat = LogPencarian::where('user_id', $user->id)
            ->orderBy('waktu', 'desc')
            ->paginate(20);

        return view('riwayat.user', compact('user', 'riwayat'));
    }

    /**
     * Show detail of a specific search log
     */
    public function show(LogPencarian $riwayat)
    {
        $riwayat->load('user.profilPemohon');

        return view('riwayat.show', compact('riwayat'));
    }
}
