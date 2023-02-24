<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NdPermohonanGelar extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_pelanggar_id', 'created_by', 'no_surat'
    ];
}