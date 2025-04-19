<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;


class PelangganController extends Controller
{
    public function landing()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('Pelanggan.landing', compact('pelanggan'));
    }

    public function updateNama(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $pelanggan = auth('pelanggan')->user();

        if ($pelanggan) {
            $pelanggan->nama_lengkap = $request->nama_lengkap;
            $pelanggan->save();

            return back()->with('success', 'Nama berhasil diperbarui.');
        }

        return back()->with('error', 'Gagal memperbarui nama.');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = auth('pelanggan')->user();

        if ($pelanggan) {
            $pelanggan->password = Hash::make($request->password);
            $pelanggan->save();

            return back()->with('success', 'Password berhasil diubah.');
        }

        return back()->with('error', 'Gagal mengubah password.');
    }

    // Tambah method lain sesuai kebutuhan
    // public function profil() { ... }
}
