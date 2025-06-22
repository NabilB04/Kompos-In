<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusBerlangganan;

class StatusBerlanggananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        StatusBerlangganan::create([
            'status_id' => 1,
            'nama_status' => 'Aktif'
        ]);

        StatusBerlangganan::create([
            'status_id' => 2,
            'nama_status' => 'Tidak Aktif'
        ]);
    }
}
