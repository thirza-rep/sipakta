<?php

namespace App\Http\Controllers;

use App\Models\AktaNikah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        return view('laporan.index', compact('stats'));
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

        // Get available years for filter
        $availableYears = AktaNikah::selectRaw('YEAR(tanggal_akad) as year')
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
     * Export monthly report to PDF
     */
    public function exportPdf(Request $request)
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
        
        $filename = "Laporan_Arsip_Akta_Nikah_{$namaBulan}_{$tahun}.pdf";
        
        return $pdf->download($filename);
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

        // Get available years
        $availableYears = AktaNikah::selectRaw('YEAR(tanggal_akad) as year')
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
