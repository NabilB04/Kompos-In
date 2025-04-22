<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ManajemenPelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::paginate(10);
        return view('admin.manajemenPelanggan', compact('pelanggans'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.manajemen-pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longtitude' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }


}
