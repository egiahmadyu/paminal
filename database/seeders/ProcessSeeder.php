<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['DITERIMA', 'DISPOSISI', 'LIMPAH POLDA', 'PULBAKET', 'GELAR PENYELIDIKAN', 'NOTA DINAS HASIL GELAR PERKARA', 'RESTORATIVE JUSTICE', 'SELESAI TIDAK BENAR'];

        foreach ($name as $key => $value) {
            Process::create([
                'name' => $value
            ]);
        }
    }
}
