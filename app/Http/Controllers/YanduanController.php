<?php

namespace App\Http\Controllers;

use App\Http\Integrations\YanduanIntegration;
use App\Models\DataPelanggar;
use App\Models\JenisKelamin;
use App\Models\Saksi;
use Carbon\Carbon;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;

use function PHPUnit\Framework\countOf;

class YanduanController extends Controller
{
    private $yanduan;
    public function __construct()
    {
        $this->yanduan = new YanduanIntegration();
    }

    public function getData(Request $request)
    {
        $body = [
            'release_date_from' => $request->start,
            'release_date_to' => $request->end
        ];

        $response = $this->yanduan->processed_reports($body);
        // $test = $response->data[25];
        // dd($test);
        if (count($response->data) == 0) {
            return response()->json([
                'status' => 200,
                'total_import' => 0
            ]);
        }
        $import = 0;
        foreach ($response->data as $key => $value) {
            // if ($value->ticket_id == '230920000039') {
            //     dd($value);
            // }
            if ($value->biro == 'BIRO PAMINAL') {
                $data['perihal_nota_dinas'] = $value->perihal_nota_dinas;
                $data['tanggal_nota_dinas'] = Carbon::create($value->tanggal_nota_dinas)->format('Y-m-d');
                $data['kronologi'] = $value->chronology ? strip_tags($value->chronology) : null;
                $data['created_at'] = $value->released_at;
                $data['status_id'] = 1;
                $data['tipe_data'] = 1;
                $data['ticket_id'] = $value->ticket_id;
                $data['tempat_kejadian'] = $value->crime_scenes ? $value->crime_scenes[0]->detail : null;
                $data['tanggal_kejadian'] = $value->crime_scenes ? Carbon::createFromFormat('d/m/Y H:i', $value->crime_scenes[0]->datetime)->format('Y-m-d') : null;
                if ($value->victims) {
                    $korban = '';
                    foreach ($value->victims as $key => $victim) {
                        if ($key == 0) {
                            $korban = $victim->name;
                        } else {
                            $korban = $korban . ', ' . $victim->name;
                        }
                    }
                    $data['nama_korban'] = $korban;
                }

                if ($value->evidences) {
                    foreach ($value->evidences as $key => $valEvidences) {
                        $evidences[$key] = $valEvidences->file_path;
                    }
                    $data['evidences'] = json_encode($evidences);
                }

                if (!DataPelanggar::where('ticket_id', $value->ticket_id)->first()) {
                    for ($i = 0; $i < count($value->defendants); $i++) {
                        $data['terlapor'] = $value->defendants[$i]->name;
                        $data['kesatuan'] = $value->defendants[$i]->unit;
                        $data['jabatan'] = $value->defendants[$i]->occupation;

                        $insert = DataPelanggar::create($data);
                        $insert->created_at = $value->released_at;
                        $insert->save();
                        $import++;

                        if ($value->witness_detail != '-' && !is_null($value->witness_detail)) {
                            $this->getSaksi($value->witness_detail, $insert->id);
                        }
                    }
                }
            }
        }
        return response()->json([
            'status' => 200,
            'total_import' => $import
        ]);
    }

    private function getSaksi($obj, $dp_id)
    {
        $saksis = preg_split('/' . '\r\n|\r|\n' . '/', $obj);

        $counter = count($saksis);
        $nama = [];
        $i_nama = 0;

        while ($i_nama < $counter) {
            # code...
            array_push($nama, $saksis[$i_nama] ?? '-');
            $i_nama = $i_nama + 4;
        }

        $jenis_kelamin = [];
        $i_jenis_kelamin = 1;
        while ($i_jenis_kelamin < $counter) {
            # code...
            array_push($jenis_kelamin, $saksis[$i_jenis_kelamin] ?? '-');
            $i_jenis_kelamin = $i_jenis_kelamin + 4;
        }

        $alamat = [];
        $i_alamat = 2;
        while ($i_alamat < $counter) {
            # code...
            array_push($alamat, $saksis[$i_alamat] ?? '-');
            $i_alamat = $i_alamat + 4;
        }

        $no_telp = [];
        $i_no_telp = 3;
        while ($i_no_telp < $counter) {
            # code...
            array_push($no_telp, $saksis[$i_no_telp] ?? '-');
            $i_no_telp = $i_no_telp + 4;
        }

        foreach ($nama as $key => $value) {
            Saksi::create([
                'data_pelanggar_id' => $dp_id,
                'nama' => $value,
                'jenis_kelamin' => $jenis_kelamin[$key],
                'alamat' => $alamat[$key],
                'no_telp' => $no_telp[$key],
            ]);
        }
    }
}
