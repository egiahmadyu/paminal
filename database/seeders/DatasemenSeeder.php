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
        $bagden = array(
            [
                'name' => 'DEN A',
                'kaden' => '28',
                'wakaden' => '2',
            ],
            [
                'name' => 'DEN B',
                'kaden' => '29',
                'wakaden' => '2',
            ],
            [
                'name' => 'DEN C',
                'kaden' => '30',
                'wakaden' => '2',
            ],
            [
                'name' => 'BAGBINPAM',
                'kaden' => '25',
                'wakaden' => null,
            ],
            [
                'name' => 'BAGLITPERS',
                'kaden' => '26',
                'wakaden' => null,
            ],
            [
                'name' => 'BAGPRODOK',
                'kaden' => '27',
                'wakaden' => null,
            ],
        );

        foreach ($bagden as $key => $value) {
            # code...
            Datasemen::create($value);
        }
    }
}
