<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnggota extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'pangkat', 'nrp', 'jabatan', 'unit', 'datasemen'];
}
