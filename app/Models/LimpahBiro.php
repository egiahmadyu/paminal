<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimpahBiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id', 'tanggal_limpah', 'jenis_limpah' ,'created_by', 'isi_surat'
    ];
}
