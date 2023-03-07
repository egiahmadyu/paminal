<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiPelapor extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id', 'tanggal_introgasi','waktu_introgasi', 'created_by'
    ];
}