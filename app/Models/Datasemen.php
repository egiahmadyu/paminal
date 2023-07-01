<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datasemen extends Model
{
    use HasFactory;

    protected $fillable = ['name','kaden','pangkat_kaden', 'nrp_kaden', 'jabatan_kaden'];
}
