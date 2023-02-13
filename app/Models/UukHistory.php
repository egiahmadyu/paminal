<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UukHistory extends Model
{
    use HasFactory;

    protected $fillable = [ 'data_pelanggar_id', 'nama', 'pangkat', 'nrp', 'jabatan' ];
}