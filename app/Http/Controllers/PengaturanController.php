<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function requestVerification(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();
        $email = $request->input('email');
        $nomorTelepon = $request->input('nomor_telepon');
        $isEmailChanged = $email !== $user->email;
        $isPhoneChanged = $nomorTelepon !== $user->nomor_telepon;

        if ($isEmailChanged || $isPhoneChanged) {
            $pendingData = [
                'nama_lengkap' => $request->input('nama_lengkap'),
                'alamat' => $request->input('alamat'),
            ];

            if ($isEmailChanged) {
                $user->email = $email;
                $user->email_verified_at = null;
                $pendingData['email'] = $email;
                $pendingData['email_verified'] = false;
            }

            if ($isPhoneChanged) {
                $pendingData['nomor_telepon'] = $nomorTelepon;
                $pendingData['phone_verified'] = false;
            }

            $user->save();
            session(['pending_profile_update' => $pendingData]);

            // Kirim notifikasi untuk field yang berubah
            if ($isEmailChanged) {
                $user->sendProfileVerificationNotification('email', $email);
            }
            if ($isPhoneChanged) {
                $user->sendProfileVerificationNotification('phone', $nomorTelepon);
            }

            return response()->json([
                'success' => true,
                'message' => 'Link verifikasi untuk ' . ($isEmailChanged ? 'email' : '') . ($isEmailChanged && $isPhoneChanged ? ' dan ' : '') . ($isPhoneChanged ? 'nomor telepon' : '') . ' telah dikirim ke email Anda.'
            ]);
        }

        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->alamat = $request->input('alamat');
        $user->nomor_telepon = $nomorTelepon;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Data profil berhasil diperbarui tanpa perubahan email atau nomor telepon.']);
    }

    public function simpan(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();
        $email = $request->input('email');
        $nomorTelepon = $request->input('nomor_telepon');
        $isEmailChanged = $email !== $user->email;
        $isPhoneChanged = $nomorTelepon !== $user->nomor_telepon;

        if ($isEmailChanged || $isPhoneChanged) {
            $pendingData = [
                'nama_lengkap' => $request->input('nama_lengkap'),
                'alamat' => $request->input('alamat'),
            ];

            if ($isEmailChanged) {
                $user->email = $email;
                $user->email_verified_at = null;
                $pendingData['email'] = $email;
                $pendingData['email_verified'] = false;
            }

            if ($isPhoneChanged) {
                $pendingData['nomor_telepon'] = $nomorTelepon;
                $pendingData['phone_verified'] = false;
            }

            $user->save();
            session(['pending_profile_update' => $pendingData]);

            if ($isEmailChanged) {
                $user->sendProfileVerificationNotification('email', $email);
            }
            if ($isPhoneChanged) {
                $user->sendProfileVerificationNotification('phone', $nomorTelepon);
            }

            return response()->json([
                'success' => true,
                'message' => 'Link verifikasi untuk ' . ($isEmailChanged ? 'email' : '') . ($isEmailChanged && $isPhoneChanged ? ' dan ' : '') . ($isPhoneChanged ? 'nomor telepon' : '') . ' telah dikirim ke email Anda.'
            ]);
        }

        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->alamat = $request->input('alamat');
        $user->nomor_telepon = $nomorTelepon;
        $user->save();

        return redirect()->back()->with('success', 'Data profil berhasil diperbarui.');
    }
}
