<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimpahPolda extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id', 'polda_id', 'tanggal_limpah', 'created_by', 'isi_surat', 'hasil_tinjut_limpah', 'catatan'
    ];

    public function polda()
    {
        return $this->hasOne(Polda::class, 'id', 'polda_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
