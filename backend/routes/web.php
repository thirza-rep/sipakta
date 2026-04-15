<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilPemohonController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\AktaNikahController;
use App\Http\Controllers\DashboardController;

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

    // Email verification routes
    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

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

    // ============================================
    // ADMIN ONLY ROUTES - User Management
    // ============================================
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
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
    // LAPORAN ROUTES - Pengelola Data & Kepala KUA
    // ============================================
    Route::middleware('role:pengelola_data,kepala_kua')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
        Route::get('/laporan/rekap', [LaporanController::class, 'rekap'])->name('laporan.rekap');
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
    });
});
