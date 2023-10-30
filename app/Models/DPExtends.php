<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPExtends extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_pelanggar_id', 'deskripsi', 'tipe'
    ];
}
