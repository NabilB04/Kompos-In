<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap', 'email', 'email_verified_at', 'password', 'nomor_telepon',
        'alamat', 'latitude', 'longitude', 'tanggal_berlangganan', 'status_id',
    ];

    protected $hidden = ['password'];

    public function tempatSampah()
    {
        return $this->hasOne(TempatSampah::class, 'pelanggan_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusBerlangganan::class, 'status_id');
    }

        public function pengambilanSampah()
    {
        return $this->hasOne(PengambilanSampah::class, 'pelanggan_id');
    }

    public function sendProfileVerificationNotification($field, $value)
    {
        $this->notify(new \App\Notifications\CustomVerifyProfile($field, $value));
    }
}
