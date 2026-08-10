<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilPemohonController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\EmailOtpVerificationController;
use App\Http\Controllers\AktaNikahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\PdfController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Email verification routes (OTP-based)
    Route::get('/verify-email-otp', [EmailOtpVerificationController::class, 'show'])
        ->name('verification.otp.show');

    Route::post('/verify-email-otp', [EmailOtpVerificationController::class, 'verify'])
        ->middleware('throttle:6,1')
        ->name('verification.otp.verify');

    Route::post('/verify-email-otp/resend', [EmailOtpVerificationController::class, 'resend'])
        ->middleware('throttle:3,1')
        ->name('verification.otp.resend');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Profile routes - accessible by all
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile-photo/{uuid}', [ProfileController::class, 'showPhoto'])->name('profile.photo');

    // ============================================
    // ADMIN ONLY ROUTES - User Management
    // ============================================
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
            
        // Komparasi Pencarian
        Route::get('/komparasi', [\App\Http\Controllers\KomparasiPencarianController::class, 'index'])->name('komparasi.index');
    });

    // ============================================
    // PENGELOLA DATA ROUTES - Unified Akta Nikah
    // ============================================
    Route::middleware('role:pengelola_data')->group(function () {
        Route::resource('akta-nikah', AktaNikahController::class);
    });

    // Unified index and show - accessible by pengelola_data and kepala_kua
    Route::middleware('role:pengelola_data,kepala_kua')->group(function () {
        Route::get('/akta-nikah', [AktaNikahController::class, 'index'])->name('akta-nikah.index');
        Route::get('/akta-nikah/{id}', [AktaNikahController::class, 'show'])->name('akta-nikah.show');
    });

    // ============================================
    // VERIFIKASI PEMOHON ROUTES - Admin & Pengelola Data
    // ============================================
    Route::middleware('role:admin,pengelola_data')->group(function () {
        Route::get('/admin/verifikasi-pemohon', [AdminVerificationController::class, 'index'])->name('admin.verification.index');
        Route::get('/admin/verifikasi-pemohon/{id}', [AdminVerificationController::class, 'show'])->name('admin.verification.show');
        Route::post('/admin/verifikasi-pemohon/{id}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verification.approve');
        Route::post('/admin/verifikasi-pemohon/{id}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verification.reject');
        Route::get('/admin/verifikasi-pemohon/{id}/cetak-pdf', [PdfController::class, 'exportProfilPemohon'])->name('admin.verification.cetak-pdf');
        Route::get('/admin/verifikasi-pemohon/{id}/dokumen/{type}', [AdminVerificationController::class, 'download'])->name('admin.verification.download');
    });


    // ============================================
    // LAPORAN ROUTES - Pengelola Data & Kepala KUA
    // ============================================
    Route::middleware('role:pengelola_data,kepala_kua')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/download-tersimpan/{id}', [LaporanController::class, 'downloadTersimpan'])->name('laporan.download-tersimpan');
    });

    Route::middleware('role:pengelola_data')->group(function () {
        Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::post('/laporan/simpan-bulanan', [LaporanController::class, 'simpanBulanan'])->name('laporan.simpan-bulanan');
        Route::get('/laporan/rekap', [LaporanController::class, 'rekap'])->name('laporan.rekap');
        Route::post('/laporan/simpan-tahunan', [LaporanController::class, 'simpanTahunan'])->name('laporan.simpan-tahunan');
    });

    // ============================================
    // KEPALA KUA - RIWAYAT ROUTES
    // ============================================
    Route::middleware('role:kepala_kua')->group(function () {
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/user/{user}', [RiwayatController::class, 'showUser'])->name('riwayat.user');
        Route::get('/riwayat/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });

    // ============================================
    // PEMOHON ROUTES
    // ============================================
    Route::middleware('role:pemohon')->group(function () {
        Route::get('/profil-pemohon', [ProfilPemohonController::class, 'edit'])->name('profil-pemohon.edit');
        Route::put('/profil-pemohon', [ProfilPemohonController::class, 'update'])->name('profil-pemohon.update');
        Route::get('/profil-pemohon/lihat', [ProfilPemohonController::class, 'show'])->name('profil-pemohon.show');

        
        Route::get('/cari-arsip', [PencarianController::class, 'index'])->name('pencarian.index');
        Route::get('/cari-arsip/hasil', [PencarianController::class, 'search'])->name('pencarian.search');
        Route::get('/cari-arsip/{arsip}', [PencarianController::class, 'show'])->name('pencarian.detail');
        Route::get('/cari-arsip/{arsip}/cetak-pdf', [PdfController::class, 'exportAktaNikah'])->name('pencarian.cetak-pdf');
    });
});
