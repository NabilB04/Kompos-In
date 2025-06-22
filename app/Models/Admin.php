<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap', 'email', 'email_verified_at', 'password', 'nomor_telepon',
    ];

    protected $hidden = ['password'];
}
