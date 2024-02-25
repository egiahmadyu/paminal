<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Polda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APILimpahBiroController extends Controller
{
    public function process_limpah_wabprof($body)
    {
        $url = 'http://10.100.102.202:9100/api/limpat_to_wabprof';
        return $this->post_wabprof($url, $body);
    }

    private function post_wabprof($url, $body)
    {
        $response = Http::post($url, $body);
        $res = json_decode($response->body());
        return $res;
    }

    public function process_limpah_provos($body)
    {
        $url = 'http://10.100.102.202:9500/api/limpah-provos';
        return $this->post_provos($url, $body);
    }

    private function post_provos($url, $body)
    {
        $response = Http::withHeaders([
            'api_key' => 'dUtudjBrV0lSZXNxWERjOHNWM1RCZ1F3aGgxZ3NVNUR4RUVBR1hwZU51a2R5OHdiTjE=',
        ])->withOptions(["verify" => false])->post($url, $body);

        // $response = Http::post($url, $body);
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
            "wujud_perbuatan" => $data->wujudPerbuatan->keterangan_wp,
            "tanggal_nota_dinas" => $data->tanggal_nota_dinas,
            "pelapor" => $data->pelapor,
            "jenis_kelamin" => $data->jenis_kelamin,
            "no_telp" => $data->no_telp,
            "alamat" => $data->alamat,
            "no_identitas" => $data->no_identitas,
            "jenis_identitas" => $data->jenis_identitas,
            "terlapor" => $data->terlapor,
            "agama" => $data->agama,
            "umur" => $data->umur,
            "pekerjaan" => $data->pekerjaan,
            "kesatuan" => $data->kesatuan,
            "nrp" => $data->nrp,
            "tempat_kejadian" => $data->tempat_kejadian,
            "tanggal_kejadian" => $data->tanggal_kejadian,
            "pangkat" => $data->pangkat,
            "jabatan" => $data->jabatan,
            "wilayah_hukum" => strtoupper($wilayah_hukum),
            "nama_korban" => $data->nama_korban,
            "id_card" => $data->link_ktp,
            "selfie" => $data->selfie,
        ];

        if ($data->tipe_data == '1') {
            $body['kronologi'] = $data->kronologi;
        } elseif ($data->tipe_data == '2') {
            $kronologi = json_decode($data->kronologi);
            // dd($kronologi);
            $body['fakta_fakta'] = $kronologi['kronologis'];
            $body['catatan'] = $kronologi['catatan'];
        } else {
            $kronologi = json_decode($data->kronologi);
            $body['fakta_fakta'] = $kronologi['kronologis'];
            $body['pendapat_pelapor'] = $kronologi['catatan'];
        }
        // return response()->json($body);

        $result = $this->process_limpah_wabprof($body);

        return $result;
    }

    public function limpahProvos($id)
    {
        $data = DataPelanggar::find($id);
        $wilayah_hukum = $data->wilayahHukum->name;

        $body = [
            "no_nota_dinas" => $data->no_nota_dinas,
            "perihal_nota_dinas" => $data->perihal_nota_dinas,
            "wujud_perbuatan" => $data->wujud_perbuatan,
            "tanggal_nota_dinas" => $data->tanggal_nota_dinas,
            "pelapor" => $data->pelapor,
            "jenis_kelamin" => $data->jenis_kelamin,
            "no_telp" => $data->no_telp,
            "alamat" => $data->alamat,
            "no_identitas" => $data->no_identitas,
            "jenis_identitas" => $data->jenis_identitas,
            "terlapor" => $data->terlapor,
            "agama" => $data->agama,
            "umur" => $data->umur,
            "pekerjaan" => $data->pekerjaan,
            "kesatuan" => $data->kesatuan,
            "nrp" => $data->nrp,
            "tempat_kejadian" => $data->tempat_kejadian,
            "tanggal_kejadian" => $data->tanggal_kejadian,
            "pangkat" => $data->pangkat,
            "jabatan" => $data->jabatan,
            "wilayah_hukum" => strtoupper($wilayah_hukum),
            "nama_korban" => $data->nama_korban,
            "id_card" => $data->link_ktp,
            "selfie" => $data->selfie,
        ];

        if ($data->tipe_data == '1') {
            $body['kronologi'] = $data->kronologi;
        } elseif ($data->tipe_data == '2') {
            $kronologi = json_decode($data->kronologi, true);
            // dd($kronologi);
            $body['fakta_fakta'] = json_encode($kronologi['kronologis'], true);
            $body['catatan'] = json_encode($kronologi['catatan'], true);
        } else {
            $kronologi = json_decode($data->kronologi);
            $body['fakta_fakta'] = $kronologi['kronologis'];
            $body['pendapat_pelapor'] = $kronologi['catatan'];
        }

        $result = $this->process_limpah_provos($body);
        // dd($result);

        return $result;
    }
}
