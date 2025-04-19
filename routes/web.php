<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Pelanggan.landing');
});

Route::get('/register', function () {
    return view('Pelanggan.register');
});

Route::get('/ecomerce', function () {
    return view('Pelanggan.ecomerce');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin areas
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('Admin.dashboard'))->name('admin.dashboard');
    // ... route lain
});

Route::patch('/admin/update/nama', [AdminController::class, 'updateNama'])->name('admin.nama.update');
Route::patch('/admin/update/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');





// Pelanggan area
Route::middleware(['pelanggan'])->group(function () {
    Route::get('/pelanggan/landing', [PelangganController::class, 'landing'])->name('pelanggan.landing');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:pelanggan')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('pelanggan.dashboard');
})->middleware(['auth:pelanggan', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user('pelanggan')->sendEmailVerificationNotification();
    return back()->with('status', 'Link verifikasi telah dikirim!');
})->middleware(['auth:pelanggan', 'throttle:6,1'])->name('verification.send');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/pengaturan/nama', [PelangganController::class, 'updateNama'])->name('pengaturan.nama.simpan');
Route::post('/pengaturan/password', [PelangganController::class, 'updatePassword'])->name('pengaturan.password.simpan');


