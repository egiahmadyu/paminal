<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggar extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->hasOne(Process::class, 'id', 'status_id');
    }
}