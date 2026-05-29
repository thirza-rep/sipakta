<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the dashboard display and filtering.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pemohon redirects to search or profile completion
        if ($user->isPemohon()) {
            if (!$user->hasCompletedProfile()) {
                return redirect()->route('profil-pemohon.edit');
            }
            return redirect()->route('pencarian.index');
        }

        $perPage = $request->per_page ?? 10;

        $searchTerm = $request->input('search', '');

        $arsip = AktaNikah::search($searchTerm)->query(function ($query) use ($request) {
            // Standardized Filtering Logic
            if ($request->filled('nama')) {
                $pattern = '%' . $request->nama . '%';
                $query->whereNested(function ($q) use ($pattern) {
                    $q->where('nama_suami', 'like', $pattern)
                      ->orWhere('nama_istri', 'like', $pattern);
                });
            }

            if ($request->filled('nomor_akta')) {
                $query->where('nomor_akta', 'like', '%' . $request->nomor_akta . '%');
            }

            if ($request->filled('lokasi_fisik')) {
                $query->where('lokasi_fisik', 'like', '%' . $request->lokasi_fisik . '%');
            }

            if ($request->filled('tahun_dari') || $request->filled('tahun_sampai')) {
                if ($request->tahun_dari && $request->tahun_sampai) {
                    $query->whereYear('tanggal_akad', '>=', $request->tahun_dari)
                          ->whereYear('tanggal_akad', '<=', $request->tahun_sampai);
                } elseif ($request->tahun_dari) {
                    $query->whereYear('tanggal_akad', '>=', $request->tahun_dari);
                } elseif ($request->tahun_sampai) {
                    $query->whereYear('tanggal_akad', '<=', $request->tahun_sampai);
                }
            }

            if ($request->filled('tanggal')) {
                $query->whereDate('tanggal_akad', $request->tanggal);
            }

            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            if ($request->filled('status_dokumen')) {
                if ($request->status_dokumen === 'ada') {
                    $query->whereNotNull('file_path')->where('file_path', '!=', '');
                } elseif ($request->status_dokumen === 'tidak') {
                    $query->whereNested(function ($q) {
                        $q->whereNull('file_path')->orWhere('file_path', '');
                    });
                }
            }

            // Standardized Sorting
            $sortBy = $request->get('sort_by', 'terbaru');
            switch ($sortBy) {
                case 'terlama':
                    $query->orderBy('tanggal_akad', 'asc');
                    break;
                case 'nama_suami':
                    $query->orderBy('nama_suami', 'asc');
                    break;
                case 'nama_istri':
                    $query->orderBy('nama_istri', 'asc');
                    break;
                case 'tahun':
                    $query->orderBy('tanggal_akad', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        })->paginate($perPage);

        $stats = [
            'total_arsip' => AktaNikah::count(),
            'arsip_bulan_ini' => AktaNikah::whereMonth('tanggal_akad', now()->month)
                                         ->whereYear('tanggal_akad', now()->year)
                                         ->count(),
        ];

        return view('dashboard', [
            'arsip' => $arsip,
            'stats' => $stats,
        ]);
    }
}
