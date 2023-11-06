<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terlapor extends Model
{
    use HasFactory;
    protected $fillable = ['data_pelanggar_id', 'nama', 'nrp', 'pangkat', 'jabatan'];
}
