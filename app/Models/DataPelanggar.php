<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggar extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_nota_dinas', 'no_pengaduan', 'pelapor', 'umur', 'jenis_kelamin', 'pekerjaan', 'agama',
        'alamat', 'no_identitas', 'jenis_identitas', 'terlapor', 'kesatuan', 'wilayah_hukum', 'tempat_kejadian', 'nrp', 'tanggal_kejadian', 'kronologi',
        'pangkat', 'jabatan', 'nama_korban', 'status_id', 'no_telp', 'kewarganegaraan', 'perihal_nota_dinas', 'tanggal_nota_dinas',
        'wujud_perbuatan', 'ticket_id', 'tipe_data', 'evidences'
    ];

    public function status()
    {
        return $this->hasOne(Process::class, 'id', 'status_id');
    }

    public function religi()
    {
        return $this->hasOne(Agama::class, 'id', 'agama');
    }

    public function identitas()
    {
        return $this->hasOne(JenisIdentitas::class, 'id', 'jenis_identitas');
    }

    public function wilayahHukum()
    {
        return $this->hasOne(Polda::class, 'id', 'wilayah_hukum');
    }
}
