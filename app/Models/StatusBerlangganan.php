<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusBerlangganan extends Model
{
    protected $table = 'status_berlangganans';
    protected $primaryKey = 'status_id';
    public $timestamps = false;

    protected $fillable = ['status_id', 'nama_status'];
}
