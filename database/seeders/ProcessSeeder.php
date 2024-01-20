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
        Process::create([
            'name' => 'Restorative Justice'
        ]);
        Process::create([
            'name' => 'Selesai Tidak Benar'
        ]);
    }
}
