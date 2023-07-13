<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit_a = ['UNIT I', 'UNIT II', 'UNIT III','MIN'];
        $tim_a = '1';

        $unit_b = ['UNIT I', 'UNIT II', 'UNIT III','MIN'];
        $tim_b = '2';

        $unit_c = ['UNIT I', 'UNIT II', 'UNIT III','MIN'];
        $tim_c = '3';

        foreach ($unit_a as $key => $value) {
            Unit::create([
                'unit' => $value,
                'datasemen' => $tim_a,
            ]);
        }

        foreach ($unit_b as $key => $value) {
            Unit::create([
                'unit' => $value,
                'datasemen' => $tim_b,
            ]);
        }

        foreach ($unit_c as $key => $value) {
            Unit::create([
                'unit' => $value,
                'datasemen' => $tim_c,
            ]);
        }
        
    }
}
