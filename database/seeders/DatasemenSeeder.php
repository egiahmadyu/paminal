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
            'kaden' => '1',
            'wakaden' => '2',
        ]);

        Datasemen::create([
            'name' => 'Den B',
            'kaden' => '1',
            'wakaden' => '2',
        ]);

        Datasemen::create([
            'name' => 'Den C',
            'kaden' => '1',
            'wakaden' => '2',
        ]);
    }
}
