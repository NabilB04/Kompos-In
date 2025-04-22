<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi
     */
    public function showRegistrationForm()
    {
        return view('Pelanggan.register');
    }

    /**
     * Tangani registrasi
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $pelanggan = $this->create($request->all());

        $nama   = $request->name;
        $email  = $request->email;
        $alamat = $request->address;

        $nomorAdmin = '6282257161599';

        $pesan = urlencode("Halo Admin, saya baru saja mendaftar:\n\nNama: $nama\nEmail: $email\nAlamat: $alamat\n\nMohon dibantu ya!");

        $linkWA = "https://wa.me/$nomorAdmin?text=$pesan";

        return redirect()->away($linkWA);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    /**
     * Validator input pengguna
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:pelanggans,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'phone'     => ['required', 'string', 'min:11', 'max:13'],
            'address'   => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Buat akun pelanggan baru
     */
    protected function create(array $data)
    {
        return Pelanggan::create([
            'nama_lengkap'  => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'nomor_telepon' => $data['phone'],
            'alamat'        => $data['address'],
        ]);
    }
}
