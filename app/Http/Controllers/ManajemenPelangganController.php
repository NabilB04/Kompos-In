<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ManajemenPelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('status')->paginate(10);
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
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'status_id' => 'required|exists:status_berlangganans,status_id',
    ], [
        'alamat.required' => 'Please fill out the field',
        'latitude.required' => 'Please fill out the field',
        'longitude.required' => 'Please fill out the field',
        'status_id.required' => 'Please fill out the field',
        'status_id.exists' => 'Please fill out the field',
    ]);

    $pelanggan = Pelanggan::findOrFail($id);

    if ($request->status_id == 1 && $pelanggan->status_id != 1) {
        $pelanggan->tanggal_berlangganan = now();
    }

    $pelanggan->alamat = $request->alamat;
    $pelanggan->latitude = $request->latitude;
    $pelanggan->longitude = $request->longitude;
    $pelanggan->status_id = $request->status_id;
    $pelanggan->save();

    return response()->json(['success' => true]);
}


}
