<?php

namespace Database\Seeders;

use App\Models\Datasemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatasemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Datasemen::create([
            'name' => 'Den A',
            'kaden' => 'DWI SAMAYO SATIADY,SIK',
            'pangkat_kaden' => 'KOMBES POL',
            'nrp_kaden' => '78050947',
            'jabatan_kaden' => 'Kaden A',
        ]);
    }
}
