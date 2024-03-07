<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_pelanggar_id', 'no_agenda', 'klasifikasi', 'derajat', 'tipe_disposisi', 'limpah_unit', 'limpah_den', 'file', 'isi_disposisi'
    ];

    function disposisiBagDen()
    {
        return $this->hasOne(Datasemen::class, 'id', 'limpah_den');
    }
}
