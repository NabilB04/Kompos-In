<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VerificationController extends Controller
{
    protected $redirectTo = '/pelanggan/landing';

    public function __construct()
    {
        $this->middleware('auth:pelanggan');
        $this->middleware('signed')->only('verifyProfile');
    }

    protected function guard()
    {
        return Auth::guard('pelanggan');
    }

    public function verifyProfile(Request $request)
    {
        $user = $this->guard()->user();
        if ($request->route('id') != $user->getKey()) {
            return redirect($this->redirectTo)->with('error', 'Verifikasi tidak valid.');
        }

        $pendingData = session('pending_profile_update');
        if (!$pendingData) {
            return redirect($this->redirectTo)->with('error', 'Tidak ada data yang perlu diverifikasi.');
        }

        // Verifikasi hash gabungan
        $hashInput = '';
        if (isset($pendingData['email'])) {
            $hashInput .= $pendingData['email'];
        }
        if (isset($pendingData['nomor_telepon'])) {
            $hashInput .= $pendingData['nomor_telepon'];
        }
        $hashInput = $hashInput ?: $user->getKey();
        $expectedHash = sha1($hashInput);

        if ($request->route('hash') !== $expectedHash) {
            return redirect($this->redirectTo)->with('error', 'Verifikasi tidak valid.');
        }

        // Update data pengguna
        $this->updatePendingData($user);

        // Hapus session setelah verifikasi selesai
        session()->forget('pending_profile_update');

        $message = 'Profil berhasil diverifikasi dan diperbarui.';
        return redirect($this->redirectTo)->with('success', $message);
    }

    public function resend(Request $request)
    {
        $user = $this->guard()->user();
        $pendingData = session('pending_profile_update');

        if (!$pendingData ||
            ((isset($pendingData['email']) && ($pendingData['email_verified'] ?? false)) &&
             (isset($pendingData['nomor_telepon']) && ($pendingData['phone_verified'] ?? false)))) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang perlu diverifikasi.']);
        }

        $user->notify(new \App\Notifications\CustomVerifyProfile($pendingData));

        return response()->json(['success' => true, 'message' => 'Link verifikasi telah dikirim ulang ke email Anda.']);
    }

    protected function updatePendingData($user)
    {
        $pendingData = session('pending_profile_update');
        if ($pendingData) {
            $user->nama_lengkap = $pendingData['nama_lengkap'] ?? $user->nama_lengkap;
            $user->alamat = $pendingData['alamat'] ?? $user->alamat;
            if (isset($pendingData['email'])) {
                $user->email = $pendingData['email'];
                $user->email_verified_at = Carbon::now();
                $pendingData['email_verified'] = true;
            }
            if (isset($pendingData['nomor_telepon'])) {
                $user->nomor_telepon = $pendingData['nomor_telepon'];
                $pendingData['phone_verified'] = true; // Tandai sebagai diverifikasi di session
            }
            $user->save();
        }
    }
}
