<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function updateNama(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $admin = auth('admin')->user();
        $admin->nama_lengkap = $request->nama_lengkap;
        $admin->nomor_telepon = $request->nomor_telepon;
        $admin->save();

        return back()->with('success', 'Nama berhasil diperbarui.');
    }


public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = auth('admin')->user();
        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
