<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Pelanggan;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Admin',
            'email' => 'admin@komposin.com',
            'password' => Hash::make('password'),
            'nomor_telepon' => '081234567890',
        ]);

        Pelanggan::create([
            'nama_lengkap' => 'Ivan',
            'email' => 'ivan@example.com',
            'password' => Hash::make('password'),
            'nomor_telepon' => '081345678901',
            'alamat' => 'Semboro',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'tanggal_berlangganan' => now(),
            'status_id' => 1, // Pastikan status_id 1 ada
        ]);


    }
}
