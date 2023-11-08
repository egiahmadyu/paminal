<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agama::create([
            'name' => 'ISLAM'
        ]);

        Agama::create([
            'name' => 'KRISTEN'
        ]);

        Agama::create([
            'name' => 'KATOLIK'
        ]);

        Agama::create([
            'name' => 'BUDDHA'
        ]);

        Agama::create([
            'name' => 'HINDU'
        ]);

        Agama::create([
            'name' => 'KONGHUCU'
        ]);
    }
}
