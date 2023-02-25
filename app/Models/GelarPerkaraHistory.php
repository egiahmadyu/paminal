<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelarPerkaraHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id','tanggal','waktu','tempat','pimpinan','pangkat_pimpinan','jabatan_pimpinan'
    ];
}