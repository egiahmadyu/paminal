<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SprinHistory extends Model
{
    use HasFactory;

    protected $fillable = [ 'data_pelanggar_id', 'no_sprin', 'created_by', 'masa_berlaku_sprin' ];

    public $rules = [
        'no_sprin' => 'required',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}