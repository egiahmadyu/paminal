<?php

namespace Database\Seeders;

use App\Models\Polda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoldaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Polda::create([
            'name' => 'Polda Metro Jaya'
        ]);

        Polda::create([
            'name' => 'Polda Jabar'
        ]);

        Polda::create([
            'name' => 'Polda Jateng'
        ]);
    }
}