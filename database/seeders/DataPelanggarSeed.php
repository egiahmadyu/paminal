<?php

namespace Database\Seeders;

use App\Models\DataPelanggar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPelanggarSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataPelanggar::create([
            'no_nota_dinas' => "10/24/propam",
            'no_pengaduan' => "123456",
            'pelapor' => "Ahmad",
            'umur' => 24,
            'jenis_kelamin' => 1,
            'pekerjaan' => 'swasta',
            'agama' => 1,
            'alamat' => 'cianjur',
            'no_identitas' => 123456789,
            'jenis_identitas' => 1,
            'terlapor' => 'Rizky',
            'kesatuan' => 'Polri',
            'tempat_kejadian' => 'Tebet',
            'kronologi' => 'Jatuh Bangun',
            'pangkat' => 'tengkorak',
            'nama_korban' => 'Prayogi',
            'status_id' => 1
        ]);
    }
}