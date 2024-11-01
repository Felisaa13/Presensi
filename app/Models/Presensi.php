<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    // Kolom yang bisa diisi
    protected $fillable = ['user_id', 'check_in_time', 'check_out_time'];
}
