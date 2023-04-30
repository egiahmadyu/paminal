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
        $polda = [
            'MABES POLRI',' POLDA ACEH', 'POLDA BALI', 'POLDA BANTEN', 'POLDA BENGKULU', 'POLDA D.I. YOGYAKARTA',
            'POLDA GORONTALO', 'POLDA JAMBI', 'POLDA JAWA BARAT', 'POLDA JAWA TENGAH', 'POLDA JAWA TIMUR',
            'POLDA KALIMANTAN BARAT', 'POLDA KALIMANTAN SELATAN', 'POLDA KALIMANTAN TENGAH',
            'POLDA KALIMANTAN TIMUR', 'POLDA KALIMANTAN UTARA', 'POLDA KEPULAUAN BANGKA BELITUNG',
            'POLDA KEPULAUAN RIAU', 'POLDA LAMPUNG', 'POLDA MALUKU', 'POLDA MALUKU UTARA', 'POLDA METRO JAYA',
            'POLDA NTB', 'POLDA NTT', 'POLDA PAPUA', 'POLDA PAPUA BARAT', 'POLDA RIAU', 'POLDA SULAWESI BARAT',
            'POLDA SULAWESI SELATAN', 'POLDA SULAWESI TENGAH', 'POLDA SULAWESI TENGGARA', 'POLDA SULAWESI UTARA',
            'POLDA SUMATRA BARAT', 'POLDA SUMATRA SELATAN', 'POLDA SUMATRA UTARA'];

        foreach ($polda as $key => $value) {
            Polda::create([
                'name' => $value
            ]);
        }
    }
}