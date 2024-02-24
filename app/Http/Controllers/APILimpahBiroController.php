<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Polda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APILimpahBiroController extends Controller
{
    public function process_limpah($body)
    {
        $url = 'http://10.100.102.202:9100/api/limpat_to_wabprof';
        return $this->post($url, $body);
    }

    private function post($url, $body)
    {
        $response = Http::post($url, $body);
        $res = json_decode($response->body());
        return $res;
    }

    public function limpahWabprof($id)
    {
        $data = DataPelanggar::find($id);
        $wujud_perbuatan = [
            'jenis_wp' => $data->wujudPerbuatan->jenis_wp,
            'keterangan_wp' => $data->wujudPerbuatan->keterangan_wp
        ];
        $wilayah_hukum = $data->wilayahHukum->name;

        $body = [
            "no_nota_dinas" => $data->no_nota_dinas,
            "perihal_nota_dinas" => $data->perihal_nota_dinas,
            "wujud_perbuatan" => json_encode($wujud_perbuatan),
            "tanggal_nota_dinas" => $data->tanggal_nota_dinas,
            "pelapor" => $data->pelapor,
            "jenis_kelamin" => $data->jenis_kelamin,
            "no_telp" => $data->no_telp,
            "alamat" => $data->alamat,
            "no_identitas" => $data->no_identitas,
            "jenis_identitas" => $data->jenis_identitas,
            "terlapor" => $data->terlapor,
            "agama_terlapor" => $data->agama,
            "kesatuan" => $data->kesatuan,
            "nrp" => $data->nrp,
            "tempat_kejadian" => $data->tempat_kejadian,
            "tanggal_kejadian" => $data->tanggal_kejadian,
            "id_pangkat" => $data->agama,
            "jabatan" => $data->jabatan,
            "kronologi" => $data->kronologi,
            "wilayah_hukum" => strtoupper($wilayah_hukum),
            "nama_korban" => $data->nama_korban,
        ];
        // dd(json_encode($body));

        // return response()->json($body);

        $result = $this->process_limpah($body);

        return true;
    }
}
