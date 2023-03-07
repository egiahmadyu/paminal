<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganKlarifikasiHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id', 'no_surat_undangan', 'tgl_klarifikasi', 'waktu_klarifikasi', 'jenis_undangan',
    ];
}
