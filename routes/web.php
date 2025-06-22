<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManajemenPelangganController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PelaporanAdminController;
use App\Http\Controllers\PengambilanSampahController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\BerlanggananController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/', [PelangganController::class, 'landing'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/password/forgot', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetFormWithToken'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// Verifikasi Email
Route::get('/email/verify', function () {
    return view('Pelanggan.verify-email');
})->middleware(['auth:pelanggan,admin'])->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user('pelanggan', 'admin')->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim!');
})->middleware(['auth:pelanggan,admin', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('login');
})->middleware(['auth:pelanggan,admin', 'signed'])->name('verification.verify');

// Verifikasi Profil Pelanggan
Route::middleware(['auth:pelanggan', 'no.cache'])->group(function () {
    Route::post('/pengaturan/request-verification', [PengaturanController::class, 'requestVerification'])->name('pengaturan.request-verification');
    Route::post('/pengaturan/data/simpan', [PengaturanController::class, 'simpan'])->name('pengaturan.data.simpan');
    Route::post('/email/resend', [VerificationController::class, 'resend'])
        ->name('verification.resend')
        ->middleware('throttle:6,1');
});
Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verifyProfile'])
    ->name('verification.verify.profile')
    ->middleware(['signed', 'auth:pelanggan']);


// Admin Routes - MAIN ROUTES
Route::prefix('admin')->middleware(['admin', 'no.cache'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ManajemenPelangganController::class, 'index'])->name('admin.dashboard');

    // Pelanggan Management
    Route::get('/pelanggan/{id}/edit', [ManajemenPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/pelanggan/{id}', [ManajemenPelangganController::class, 'update'])->name('admin.pelanggan.update');

    // Admin Profile
    Route::patch('/update-profile', [AdminController::class, 'updateProfileAndPassword'])->name('admin.nama_dan_password.update');

    // Artikel Management
    Route::get('/manajemenartikel', [ArtikelController::class, 'showArtikelAdmin'])->name('admin.manajemenArtikel');
    Route::get('/createartikel', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/storeartikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/edit/{artikel_id}', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::post('/artikel/update/{artikel_id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/destroy/{artikel_id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    // Rute & Pengambilan Sampah
    Route::get('/rute', [RuteController::class, 'showRute'])->name('admin.rute');
    Route::post('/rute/konfirmasi/{id}', [PengambilanSampahController::class, 'konfirmasi'])->name('admin.konfirmasi');
    Route::post('/tambah-ember', [PengambilanSampahController::class, 'tambahEmber'])->name('admin.tambahEmber');

    // Pelaporan
    Route::get('/pelaporan', [PelaporanAdminController::class, 'pengambilanPerBulan'])->name('admin.pelaporan');
});

// COMPATIBILITY ROUTES - untuk menangani URL lama
Route::middleware(['admin', 'no.cache'])->group(function () {
    // Route untuk URL tanpa prefix admin (backward compatibility)
    Route::get('/Admin.manajemenArtikel', [ArtikelController::class, 'showArtikelAdmin'])->name('Admin.manajemenArtikel');
    Route::get('/Admin.rute', [RuteController::class, 'showRute'])->name('Admin.rute');

    // Route untuk tambah ember dengan nama yang berbeda
    Route::post('/Admin/tambah-ember', [PengambilanSampahController::class, 'tambahEmber'])->name('Admin.tambahEmber');
    Route::post('/admin/Admin/tambah-ember', [PengambilanSampahController::class, 'tambahEmber'])->name('admin.Admin.tambahEmber');

    // Alternative routes untuk konfirmasi
    Route::post('/Admin/rute/konfirmasi/{id}', [PengambilanSampahController::class, 'konfirmasi'])->name('Admin.konfirmasi');
    Route::post('/pelanggan/konfirmasi/{id}', [PengambilanSampahController::class, 'konfirmasi'])->name('pelanggan.konfirmasi');
});

// Pelanggan Routes
Route::middleware(['pelanggan', 'no.cache'])->group(function () {
    Route::get('/pelanggan/landing', [PelangganController::class, 'landing'])->name('pelanggan.landing');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');
    Route::post('/pengaturan/nama', [PelangganController::class, 'updateNama'])->name('pengaturan.nama.simpan');
    Route::post('/pengaturan/password', [PelangganController::class, 'updatePassword'])->name('pengaturan.password.simpan');
    Route::get('/ecomerce', function () {
        return view('Pelanggan.ecomerce');
    })->name('pelanggan.ecomerce');
    Route::post('/berlangganan/create', [BerlanggananController::class, 'create'])->name('berlangganan.create');
    Route::post('/berlangganan/store', [BerlanggananController::class, 'store'])->name('berlangganan.store');
});

// Artikel Publik
Route::get('/artikel/read/{artikel_id}', [ArtikelController::class, 'read'])->name('artikel.read');
