<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Pelanggan;

class PasswordResetController extends Controller
{
    public function showResetForm(Request $request)
    {
        // Tidak perlu guard di view, karena akan ditentukan di controller
        return view('auth.password.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Cek apakah email ada di tabel admins
        $adminTable = (new Admin)->getTable();
        $isAdmin = \DB::table($adminTable)->where('email', $email)->exists();

        // Cek apakah email ada di tabel pelanggans
        $pelangganTable = (new Pelanggan)->getTable();
        $isPelanggan = \DB::table($pelangganTable)->where('email', $email)->exists();

        // Tentukan guard berdasarkan tabel tempat email ditemukan
        if ($isAdmin) {
            $guard = 'admin';
        } elseif ($isPelanggan) {
            $guard = 'pelanggan';
        } else {
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        // Kirim link reset password menggunakan guard yang sesuai
        $status = Password::broker($guard)->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetFormWithToken($token, Request $request)
    {
        $email = $request->query('email');

        // Cek email di kedua tabel untuk menentukan guard
        $adminTable = (new Admin)->getTable();
        $isAdmin = \DB::table($adminTable)->where('email', $email)->exists();
        $pelangganTable = (new Pelanggan)->getTable();
        $isPelanggan = \DB::table($pelangganTable)->where('email', $email)->exists();

        if ($isAdmin) {
            $guard = 'admin';
        } elseif ($isPelanggan) {
            $guard = 'pelanggan';
        } else {
            return redirect()->route('password.request')->withErrors(['email' => 'Alamat email tidak valid.']);
        }

        return view('auth.password.reset', [
            'token' => $token,
            'email' => $email,
            'guard' => $guard
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = $request->input('email');
        $guard = $request->input('guard', 'pelanggan');

        $adminTable = (new Admin)->getTable();
        $isAdmin = \DB::table($adminTable)->where('email', $email)->exists();
        $pelangganTable = (new Pelanggan)->getTable();
        $isPelanggan = \DB::table($pelangganTable)->where('email', $email)->exists();

        if ($isAdmin) {
            $guard = 'admin';
        } elseif ($isPelanggan) {
            $guard = 'pelanggan';
        } else {
            return back()->withErrors(['email' => 'Alamat email tidak valid.']);
        }

        $status = Password::broker($guard)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
