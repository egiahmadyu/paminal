<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LHPHistory extends Model
{
    use HasFactory;
    protected $fillable = [ 'data_pelanggar_id', 'no_lhp', 'hasil_penyelidikan' ];
}
