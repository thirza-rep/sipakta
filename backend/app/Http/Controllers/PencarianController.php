<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use App\Models\LogPencarian;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    /**
     * Show the search page for pemohon
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if pemohon has completed profile
        if ($user->isPemohon() && !$user->hasCompletedProfile()) {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu sebelum melakukan pencarian.');
        }

        return view('pencarian.index');
    }

    /**
     * Process search and show results
     */
    public function search(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if pemohon has completed profile
        if ($user->isPemohon() && !$user->hasCompletedProfile()) {
            return redirect()->route('profil-pemohon.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $keyword = $request->get('keyword', '');

        if (empty(trim($keyword))) {
            return redirect()->route('pencarian.index')
                ->with('error', 'Masukkan kata kunci pencarian.');
        }

        // Perform search using Laravel Scout (Meilisearch)
        $results = AktaNikah::search($keyword)->paginate(10);

        // Log the search
        LogPencarian::log($user->id, $keyword, $results->total());

        return view('pencarian.hasil', [
            'results' => $results,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show detail of a specific arsip (read-only for pemohon)
     */
    public function show($id)
    {
        $arsip = AktaNikah::findOrFail($id);
        return view('pencarian.detail', compact('arsip'));
    }
}
