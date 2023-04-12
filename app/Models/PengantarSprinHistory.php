<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengantarSprinHistory extends Model
{
    use HasFactory;
    protected $fillable = [ 'data_pelanggar_id', 'no_pengantar_sprin' ];
}
