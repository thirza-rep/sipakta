<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AktaNikahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        if ($search) {
            // Use Laravel Scout for searching
            $akta = AktaNikah::search($search)->paginate(20);
        } else {
            // Default listing
            $akta = AktaNikah::orderByDesc('tanggal_akad')->paginate(20);
        }

        return view('akta_nikah.index', compact('akta', 'search'));
    }

    public function create()
    {
        return view('akta_nikah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_akta'   => 'required|unique:akta_nikah,nomor_akta',
            'tanggal_akad' => 'required|date',
            'nama_suami'   => 'required|string|max:255',
            'nama_istri'   => 'required|string|max:255',
            'kategori'     => 'nullable|string',
            'lokasi_fisik' => 'nullable|string',
            'file'         => 'nullable|file|max:2048',
        ]);

        $data = $request->all();
        $data['petugas_input_id'] = Auth::id();
        $data['status_arsip'] = 'aktif';

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('arsip', 'public');
        }

        AktaNikah::create($data);

        return redirect()->route('akta-nikah.index')
            ->with('success', 'Akta nikah berhasil disimpan.');
    }

    public function show($id)
    {
        $aktaNikah = AktaNikah::findOrFail($id);
        return view('akta_nikah.show', compact('aktaNikah'));
    }

    public function edit($id)
    {
        $aktaNikah = AktaNikah::findOrFail($id);
        return view('akta_nikah.edit', compact('aktaNikah'));
    }

    public function update(Request $request, $id)
    {
        $aktaNikah = AktaNikah::findOrFail($id);

        $validated = $request->validate([
            'nomor_akta'   => 'required|unique:akta_nikah,nomor_akta,' . $aktaNikah->id,
            'tanggal_akad' => 'required|date',
            'nama_suami'   => 'required|string|max:255',
            'nama_istri'   => 'required|string|max:255',
            'kategori'     => 'nullable|string',
            'lokasi_fisik' => 'nullable|string',
            'file'         => 'nullable|file|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($aktaNikah->file_path && Storage::disk('public')->exists($aktaNikah->file_path)) {
                Storage::disk('public')->delete($aktaNikah->file_path);
            }
            $data['file_path'] = $request->file('file')->store('arsip', 'public');
        }

        $aktaNikah->update($data);

        return redirect()->route('akta-nikah.index')
            ->with('success', 'Akta nikah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aktaNikah = AktaNikah::findOrFail($id);
        
        if ($aktaNikah->file_path && Storage::disk('public')->exists($aktaNikah->file_path)) {
            Storage::disk('public')->delete($aktaNikah->file_path);
        }
        
        $aktaNikah->delete();

        return redirect()->route('akta-nikah.index')
            ->with('success', 'Akta nikah berhasil dihapus.');
    }
}