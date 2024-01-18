<?php

namespace Database\Seeders;

use App\Models\DataAnggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataAnggotaSeederBaru extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anggota = array(
            [
                'nama' => 'ANGGORO SUKARTONO, SIK',
                'pangkat' => '4',
                'nrp' => '72040506',
                'jabatan' => 'KAROPAMINAL',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'YUDO HERMANTO, SIK, MM',
                'pangkat' => '5',
                'nrp' => '74110683',
                'jabatan' => 'SESROPAMINAL',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'HERY PURNOMO,SIK',
                'pangkat' => '6',
                'nrp' => '68080625',
                'jabatan' => 'PENYELIDIK PAMINAL TK III',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'SUGENG PUJIHARTONO, SE, MH',
                'pangkat' => '6',
                'nrp' => '74110877',
                'jabatan' => 'PENYELIDIK PAMINAL TK III',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'BAGUS CAHYO SAKTI, SE, MM',
                'pangkat' => '8',
                'nrp' => '81040398',
                'jabatan' => 'BPL ROPAMINAL',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'IRVAN JOHAN SIMANJUNTAK',
                'pangkat' => '15',
                'nrp' => '95051148',
                'jabatan' => 'BOP',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'SUMIYEM, SH',
                'pangkat' => '8',
                'nrp' => '66030597',
                'jabatan' => 'KAURTU',
                'datasemen' => null,
                'unit' => null,
            ],
            [
                'nama' => 'R.FERRY INDRAWAN, SH, SIK', //25
                'pangkat' => '5',
                'nrp' => '70020175',
                'jabatan' => 'KABAGBINPAM',
                'datasemen' => '4',
                'unit' => null,
            ],
            [
                'nama' => 'DONALD P SIMANJUNTAK, SIK, MH', //26
                'pangkat' => '5',
                'nrp' => '75120905',
                'jabatan' => 'KABAGLITPERS',
                'datasemen' => '5',
                'unit' => null,
            ],
            [
                'nama' => 'ARMAINI, SIK', //27
                'pangkat' => '5',
                'nrp' => '74080668',
                'jabatan' => 'KABAGPRODOK',
                'datasemen' => '6',
                'unit' => null,
            ],
            [
                'nama' => 'IRWAN MASULIN GINTING, SIK', //28
                'pangkat' => '5',
                'nrp' => '75050934',
                'jabatan' => 'KADEN A',
                'datasemen' => '1',
                'unit' => null,
            ],
            [
                'nama' => 'I PUTU YUNI SETIAWAN, SIK, MH', //29
                'pangkat' => '5',
                'nrp' => '78061013',
                'jabatan' => 'KADEN B',
                'datasemen' => '2',
                'unit' => null,
            ],
            [
                'nama' => 'RONI FAISAL SAIFUL FATON, SIK, MH, MSi', //30
                'pangkat' => '5',
                'nrp' => '78041178',
                'jabatan' => 'KADEN C',
                'datasemen' => '3',
                'unit' => null,
            ],
            [
                'nama' => 'FAHRUROZI, SIK, MM', //31
                'pangkat' => '6',
                'nrp' => '78081585',
                'jabatan' => 'WAKADEN A',
                'datasemen' => '1',
                'unit' => null,
            ],
            [
                'nama' => 'Dr.AGUNG WIBOWO,SH,MH', //32
                'pangkat' => '6',
                'nrp' => '69050148',
                'jabatan' => 'WAKADEN B',
                'datasemen' => '2',
                'unit' => null,
            ],
            [
                'nama' => 'GANANG NUGROHO WIDHI,SIK,M.T', //33
                'pangkat' => '6',
                'nrp' => '80100972',
                'jabatan' => 'WAKADEN C',
                'datasemen' => '3',
                'unit' => null,
            ],

        );
        foreach ($anggota as $key => $value) {
            # code...
            DataAnggota::create($value);
        }
    }
}
