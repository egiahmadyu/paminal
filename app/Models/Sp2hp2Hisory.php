<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sp2hp2Hisory extends Model
{
    use HasFactory;

    protected $fillable = [ 'data_pelanggar_id', 'penangan', 'dihubungi', 'jabatan_dihubungi', 'telp_dihubungi' ];
}