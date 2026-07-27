<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use App\Models\LaporanTersimpan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display laporan index page
     */
    public function index()
    {
        $stats = [
            'total_arsip' => AktaNikah::count(),
            'arsip_bulan_ini' => AktaNikah::whereMonth('tanggal_akad', now()->month)
                                         ->whereYear('tanggal_akad', now()->year)
                                         ->count(),
            'arsip_tahun_ini' => AktaNikah::whereYear('tanggal_akad', now()->year)->count(),
        ];

        $laporanTersimpan = LaporanTersimpan::with('pengelola')->orderBy('created_at', 'desc')->get();

        return view('laporan.index', compact('stats', 'laporanTersimpan'));
    }

    /**
     * Display monthly report
     */
    public function bulanan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $arsip = AktaNikah::whereMonth('tanggal_akad', $bulan)
                          ->whereYear('tanggal_akad', $tahun)
                          ->orderBy('tanggal_akad', 'desc')
                          ->get();

        $namaBulan = $this->getNamaBulan($bulan);

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearSql = $driver === 'sqlite' ? "strftime('%Y', tanggal_akad)" : 'YEAR(tanggal_akad)';

        $availableYears = AktaNikah::selectRaw("{$yearSql} as year")
                                   ->distinct()
                                   ->orderBy('year', 'desc')
                                   ->pluck('year')
                                   ->toArray();

        if (empty($availableYears)) {
            $availableYears = [now()->year];
        }

        $summary = [
            'total' => $arsip->count(),
            'dengan_dokumen' => $arsip->filter(fn($a) => $a->file_path !== null && $a->file_path !== '')->count(),
            'tanpa_dokumen' => $arsip->filter(fn($a) => $a->file_path === null || $a->file_path === '')->count(),
        ];

        return view('laporan.bulanan', compact(
            'arsip', 
            'bulan', 
            'tahun', 
            'namaBulan', 
            'availableYears',
            'summary'
        ));
    }

    /**
     * Generate and save monthly report to system (Pengelola Data)
     */
    public function simpanBulanan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $arsip = AktaNikah::whereMonth('tanggal_akad', $bulan)
                          ->whereYear('tanggal_akad', $tahun)
                          ->orderBy('tanggal_akad', 'desc')
                          ->get();

        $namaBulan = $this->getNamaBulan($bulan);

        $summary = [
            'total' => $arsip->count(),
            'dengan_dokumen' => $arsip->filter(fn($a) => $a->file_path !== null && $a->file_path !== '')->count(),
            'tanpa_dokumen' => $arsip->filter(fn($a) => $a->file_path === null || $a->file_path === '')->count(),
        ];

        $pdf = Pdf::loadView('laporan.pdf', compact('arsip', 'bulan', 'tahun', 'namaBulan', 'summary'));
        
        $filename = "Laporan_Bulanan_{$namaBulan}_{$tahun}_" . time() . ".pdf";
        $path = "laporan_arsip/{$filename}";
        
        // Save PDF to storage
        Storage::disk('public')->put($path, $pdf->output());

        // Save record to database
        LaporanTersimpan::create([
            'judul_laporan' => "Laporan Akta Nikah Bulan {$namaBulan} {$tahun}",
            'tipe_laporan' => 'bulanan',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'file_path' => $path,
            'pengelola_id' => Auth::id(),
        ]);
        
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil di-generate dan disimpan ke sistem.');
    }

    /**
     * Download a saved report (Pengelola Data & Kepala KUA)
     */
    public function downloadTersimpan($id)
    {
        $laporan = LaporanTersimpan::findOrFail($id);

        if (!Storage::disk('public')->exists($laporan->file_path)) {
            return back()->with('error', 'File PDF tidak ditemukan di sistem.');
        }

        return Storage::disk('public')->download($laporan->file_path);
    }

    /**
     * Display rekap/summary report
     */
    public function rekap(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        // Get monthly stats for the year
        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = AktaNikah::whereMonth('tanggal_akad', $i)
                              ->whereYear('tanggal_akad', $tahun)
                              ->count();
            $monthlyStats[$i] = [
                'bulan' => $this->getNamaBulan($i),
                'jumlah' => $count,
            ];
        }

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearSql = $driver === 'sqlite' ? "strftime('%Y', tanggal_akad)" : 'YEAR(tanggal_akad)';

        $availableYears = AktaNikah::selectRaw("{$yearSql} as year")
                                   ->distinct()
                                   ->orderBy('year', 'desc')
                                   ->pluck('year')
                                   ->toArray();

        if (empty($availableYears)) {
            $availableYears = [now()->year];
        }

        $totalTahun = AktaNikah::whereYear('tanggal_akad', $tahun)->count();

        return view('laporan.rekap', compact('monthlyStats', 'tahun', 'availableYears', 'totalTahun'));
    }

    /**
     * Get Indonesian month name
     */
    private function getNamaBulan(int $bulan): string
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $namaBulan[$bulan] ?? '';
    }
}
