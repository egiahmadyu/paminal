<?php

namespace App\Http\Controllers;

use App\Http\Integrations\YanduanIntegration;
use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\JenisKelamin;
use App\Models\Pangkat;
use App\Models\Saksi;
use App\Models\Terlapor;
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
        if ($response == null) {
            return response()->json([
                'status' => 200,
                'total_import' => 0
            ]);
        }

        if (count($response->data) == 0) {
            return response()->json([
                'status' => 200,
                'total_import' => 0
            ]);
        }
        $import = 0;
        foreach ($response->data as $key => $value) {
            $tiket = DataPelanggar::where('ticket_id', $value->ticket_id)->first();
            if (($value->biro == 'BIRO PAMINAL') && (!$tiket)) {
                if (count($value->defendants) > 0) {
                    $data['terlapor'] = strtoupper($value->defendants[0]->name);
                    $data['kesatuan'] = strtoupper($value->defendants[0]->unit);
                    // $occupation = explode("/", $value->defendants[0]->occupation);
                    // $pangkat = Pangkat::where('name', $occupation[0]);
                    $data['jabatan'] = strtoupper($value->defendants[0]->occupation);
                    // $data['pangkat'] = $pangkat->id;
                }


                $data['pelapor'] = $value->reporter->name ? strtoupper($value->reporter->name) : null;
                $data['jenis_kelamin'] = $value->reporter->gender ? ($value->reporter->gender == 'LAKI-LAKI' ? 1 : 2) : null;
                $data['no_identitas'] = $value->reporter->identity_number ? $value->reporter->identity_number : null;
                $data['jenis_identitas'] = 1;
                $data['alamat'] = $value->reporter->alamat ?? null;
                $data['pekerjaan'] = $value->reporter->occupation ?? null;
                $data['no_telp'] = $value->reporter->phonenumber ?? null;

                if ($value->reporter->religion) {
                    $agamas = Agama::all();
                    $agama_api = preg_replace('/\s+/', '', strtoupper($value->reporter->religion));
                    foreach ($agamas as $key => $valAgama) {
                        if ($agama_api == strtoupper($valAgama->name)) {
                            $data['agama'] = $key + 1;
                        }
                    }
                }

                $data['perihal_nota_dinas'] = $value->perihal_nota_dinas != '-' ? strtoupper($value->perihal_nota_dinas) : null;
                $data['tanggal_nota_dinas'] = $value->tanggal_nota_dinas != '-' ? Carbon::create($value->tanggal_nota_dinas)->format('Y-m-d') : null;
                $data['kronologi'] = $value->chronology ? strtoupper(strip_tags($value->chronology)) : null;
                $data['created_at'] = $value->released_at;
                $data['status_id'] = 1;
                $data['tipe_data'] = 1;
                $data['ticket_id'] = $value->ticket_id ? $value->ticket_id : null;
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
                    $data['nama_korban'] = strtoupper($korban);
                }

                if ($value->evidences) {
                    foreach ($value->evidences as $key => $valEvidences) {
                        $evidences[$key] = $valEvidences->file_path;
                    }
                    $data['evidences'] = json_encode($evidences);
                }

                $insert = DataPelanggar::create($data);
                $insert->created_at = $value->released_at;
                $insert->save();
                $import++;

                if ($value->witness_detail != '-' && !is_null($value->witness_detail)) {
                    $this->getSaksi($value->witness_detail, $insert->id);
                }

                if (count($value->defendants) > 1) {
                    for ($i = 1; $i < count($value->defendants); $i++) {
                        // $occupation = explode("/", $value->defendants[$i]->occupation);
                        // $pangkat = Pangkat::where('name', $occupation[0]);

                        $terlapor['data_pelanggar_id'] = $insert->id;
                        $terlapor['nama'] = strtoupper($value->defendants[$i]->name);
                        $terlapor['kesatuan'] = strtoupper($value->defendants[$i]->unit);
                        $terlapor['jabatan'] = strtoupper($value->defendants[$i]->occupation);
                        $terlapor['pangkat'] = null;

                        Terlapor::create([
                            'data_pelanggar_id' => $insert->id,
                            'nama' => strtoupper($value->defendants[$i]->name),
                            'kesatuan' => strtoupper($value->defendants[$i]->unit),
                            'jabatan' => strtoupper($value->defendants[$i]->occupation),
                        ]);
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
                'nama' => strtoupper($value),
                'jenis_kelamin' => $jenis_kelamin[$key],
                'alamat' => strtoupper($alamat[$key]),
                'no_telp' => $no_telp[$key],
            ]);
        }
    }
}
