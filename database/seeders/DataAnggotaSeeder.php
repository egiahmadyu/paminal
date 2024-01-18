<?php

namespace Database\Seeders;

use App\Models\DataAnggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = ['DWI SAMAYO SATIADY, SIK', 'EDWIN LOUIS SENGKA, SIK, MSi', 'LIRISMAN MARBUN, SH, MH', 'ANGGA NAZMI SAPUTRA', 'THUBAGUS', 'ERICSON SIREGAR, SKom, MT, MSc', 'ACHMAD HUSNI IMAWAN, STrK, SIK', 'APRI AJI SETYAWAN, SH', 'YOBIE ARI YUANDANA', 'SANDI YUDHA WIRATAMA, SH', 'YULIUS SYAHPUTRA, STrK, SIK', 'DIMAS ERI PRABOWO, STrK', 'GILANG EKA NUGRAHA', 'I KADEK NOVA ADI WIJAYA KUSUMA', 'MUHAMMAD MAHDII HEAVENY NOVIANSYAH, STrK', 'I MADE PUTRA SETYA DHARMA', 'RINALDI PUTRA ISTIYONO',];
        $pangkat = ['5', '6', '9', '15', '14', '8', '9', '10', '15', '15', '9', '10', '14', '14', '10', '15', '16'];
        $nrp = ['78050947', '78081217', '78071162', '94110803', '9501033', '88090982', '94081263', '87040482', '96090598', '97060437', '93071063', '95091233', '90120155', '94110684', '98110752', '97100356', '00110861'];
        $jabatan = ['ANJAK ROPAMINAL', 'WAKADEN A', 'PS.PANIT 2 UNIT I DEN A', 'BANIT DEN A', 'BANIT I DEN A', 'PS.KANIT II DEN A', 'PS. PANIT 1 UNIT II DEN A', 'PS.PANIT 2 UNIT II DEN A', 'BANIT DEN A', 'BANIT DEN A', 'PS. PANIT 1 UNIT III DEN A', 'PS.PANIT 2 UNIT III DEN A', 'BANIT DEN A', 'BANIT DEN A', 'PAMIN DEN A', 'BAMIN DEN A', 'BAMIN DEN A'];
        $tim = '1';
        $unit = [null, null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'];
        $unit = [null, null, '1', '1', '1', '2', '2', '2', '2', '2', '3', '3', '3', '3', '4', '4', '4'];

        foreach ($nama as $key => $value) {
            DataAnggota::create([
                'nama' => $value,
                'pangkat' => $pangkat[$key],
                'nrp' => $nrp[$key],
                'jabatan' => $jabatan[$key],
                'datasemen' => $tim,
                'unit' => $unit[$key],
            ]);
        }
    }
}
