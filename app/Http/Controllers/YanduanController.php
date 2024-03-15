<?php

namespace App\Http\Controllers;

use App\Http\Integrations\YanduanIntegration;
use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\Pangkat;
use App\Models\HistorySaksi;
use App\Models\Terlapor;
use Carbon\Carbon;
use Illuminate\Http\Request;

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


                $pelapor = strtoupper(str_replace('/', '-', $value->reporter->name));
                $data['pelapor'] = $value->reporter->name ? str_replace('&', 'DAN', $pelapor) : null;
                $data['jenis_kelamin'] = $value->reporter->gender ? ($value->reporter->gender == 'LAKI-LAKI' ? 1 : 2) : null;
                $data['no_identitas'] = $value->reporter->identity_number ? $value->reporter->identity_number : null;
                $data['jenis_identitas'] = 1;
                $data['alamat'] = $value->reporter->alamat ?? null;
                $data['pekerjaan'] = $value->reporter->occupation ?? null;
                $data['no_telp'] = $value->reporter->phonenumber ?? null;
                $data['link_ktp'] = $value->reporter->id_card ? $value->reporter->id_card : null;
                $data['selfie'] = $value->reporter->selfie ? $value->reporter->selfie : null;

                if ($value->reporter->religion) {
                    $agamas = Agama::all();
                    $agama_api = preg_replace('/\s+/', '', strtoupper($value->reporter->religion));
                    foreach ($agamas as $key => $valAgama) {
                        if ($agama_api == strtoupper($valAgama->name)) {
                            $data['agama'] = $key + 1;
                        }
                    }
                }

                $data['perihal_nota_dinas'] = $value->perihal_nota_dinas != '-' ? strtoupper(str_replace('&', 'DAN', $value->perihal_nota_dinas)) : null;
                $data['tanggal_nota_dinas'] = $value->tanggal_nota_dinas != '-' ? Carbon::create($value->tanggal_nota_dinas)->format('Y-m-d') : null;
                $data['kronologi'] = $value->chronology ? strtoupper(strip_tags($value->chronology)) : null;
                $data['created_at'] = $value->released_at;
                $data['status_id'] = 1;
                $data['tipe_data'] = 1;
                $data['ticket_id'] = $value->ticket_id ? $value->ticket_id : null;
                $data['no_nota_dinas'] = $value->nomor_nota_dinas ? $value->nomor_nota_dinas : null;
                $data['jenis_laporan'] = $value->jenis_pelaporan ? $value->jenis_pelaporan : null;
                $data['tempat_kejadian'] = $value->crime_scenes ? $value->crime_scenes[0]->detail : null;
                $data['tanggal_kejadian'] = $value->crime_scenes ? Carbon::createFromFormat('d/m/Y H:i', $value->crime_scenes[0]->datetime)->format('Y-m-d') : null;
                $data['nama_korban'] = $value->victims ? strtoupper($value->victims[0]->name) : null;

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

    public function getDataYanduan(Request $request)
    {
        $start = Carbon::now()->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $body = [
            'release_date_from' => $start,
            'release_date_to' => $end
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
                    $data['jabatan'] = strtoupper($value->defendants[0]->occupation);
                }

                $pelapor = strtoupper(str_replace('/', '-', $value->reporter->name));
                $data['pelapor'] = $value->reporter->name ? str_replace('&', 'DAN', $pelapor) : null;
                $data['jenis_kelamin'] = $value->reporter->gender ? ($value->reporter->gender == 'LAKI-LAKI' ? 1 : 2) : null;
                $data['no_identitas'] = $value->reporter->identity_number ? $value->reporter->identity_number : null;
                $data['jenis_identitas'] = 1;
                $data['alamat'] = $value->reporter->alamat ?? null;
                $data['pekerjaan'] = $value->reporter->occupation ?? null;
                $data['no_telp'] = $value->reporter->phonenumber ?? null;
                $data['link_ktp'] = $value->reporter->id_card ? $value->reporter->id_card : null;
                $data['selfie'] = $value->reporter->selfie ? $value->reporter->selfie : null;

                if ($value->reporter->religion) {
                    $agamas = Agama::all();
                    $agama_api = preg_replace('/\s+/', '', strtoupper($value->reporter->religion));
                    foreach ($agamas as $key => $valAgama) {
                        if ($agama_api == strtoupper($valAgama->name)) {
                            $data['agama'] = $key + 1;
                        }
                    }
                }

                $data['perihal_nota_dinas'] = $value->perihal_nota_dinas != '-' ? strtoupper(str_replace('&', 'DAN', $value->perihal_nota_dinas)) : null;
                $data['tanggal_nota_dinas'] = $value->tanggal_nota_dinas != '-' ? Carbon::create($value->tanggal_nota_dinas)->format('Y-m-d') : null;
                $data['kronologi'] = $value->chronology ? strtoupper(strip_tags($value->chronology)) : null;
                $data['created_at'] = $value->released_at;
                $data['status_id'] = 1;
                $data['tipe_data'] = 1;
                $data['ticket_id'] = $value->ticket_id ? $value->ticket_id : null;
                $data['no_nota_dinas'] = $value->nomor_nota_dinas ? $value->nomor_nota_dinas : null;
                $data['jenis_laporan'] = $value->jenis_pelaporan ? $value->jenis_pelaporan : null;
                $data['tempat_kejadian'] = $value->crime_scenes ? $value->crime_scenes[0]->detail : null;
                $data['tanggal_kejadian'] = $value->crime_scenes ? Carbon::createFromFormat('d/m/Y H:i', $value->crime_scenes[0]->datetime)->format('Y-m-d') : null;
                $data['nama_korban'] = $value->victims ? strtoupper($value->victims[0]->name) : null;

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

    public function importPangkat()
    {
        $body = [];
        $response = $this->yanduan->importPangkat($body);
        if ($response == null) {
            return response()->json([
                'status' => 200,
                'total_import' => 0
            ]);
        }

        foreach ($response->data as $key => $value) {
            # code...
            $pangkat = Pangkat::whereRaw('UPPER(name) = (?)', strtoupper($value->name))->first();
            if (!$pangkat) {
                Pangkat::create([
                    'name' => strtoupper($value->name)
                ]);
            }
        }

        return 'ok';
    }

    private function getSaksi($obj, $dp_id)
    {
        HistorySaksi::create([
            'data_pelanggar_id' => $dp_id,
            'saksi' => $obj,
        ]);
    }
}
