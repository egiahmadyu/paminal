<?php

namespace App\Http\Controllers;

use App\Models\Pangkat;
use App\Models\Polda;
use App\Models\Unit;

class HelperController extends Controller
{
    public function getAllPangkat()
    {
        $data['pangkat'] = Pangkat::orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function getUnit($den_bag)
    {
        $data['unit'] = Unit::where('datasemen', $den_bag)->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
            'den' => $den_bag
        ]);
    }

    public static function cekKelengkapanData($kasus)
    {
        $result = true;
        $data_pelanggar = (clone $kasus)->toArray();
        foreach ($data_pelanggar as $key => $value) {
            # code...
            if ($result == true) {
                if ($key != 'no_pengaduan' && $key != 'kewarganegaraan' && $key != 'catatan' && $key != 'link_ktp' && $key != 'selfie' && $key != 'evidences') {
                    $result = is_null($value) ? false : true;
                }
            }
        }
        return $result;
    }

    public static function dataFilter($data, $data_filter)
    {
        foreach ($data_filter as $key => $value) {
            if ($value['name'] == 'selected_polda') {
                $selected_polda = $value['value'];
            }
        }
        // dd($data_filter);
        $result = static::getFilter($data, $data_filter, $selected_polda);
        return $result;
    }

    public static function getFilter($data, $data_filter, $selected_polda)
    {
        if ($selected_polda != null) {
            $polda = Polda::find($selected_polda);
        }

        foreach ($data_filter as $key => $value) {
            # code...
            if ($value['name'] == 'diterima') {
                $data->orwhere('status_id', 1);
            }

            if ($value['name'] == 'diproses') {
                $data->orwhereBetween('status_id', [4, 5]);
            }

            if ($value['name'] == 'limpah-biro') {
                $data->orwhere('status_id', 6);
            }

            if ($value['name'] == 'limpah-polda') {
                $data->orwhere('status_id', 3);
            }

            if ($value['name'] == 'rj') {
                $data->orwhere('status_id', 7);
            }

            if ($value['name'] == 'selesai-tidak-benar') {
                $data->orwhere('status_id', 8);
            }

            if ($value['name'] == 'selesai') {
                $data->orwhere('status_id', 6)->orwhere('status_id', 3)->orwhere('status_id', 7)->orwhere('status_id', 8);
            }

            if ($value['name'] == 'disposisi-binpam') {
                $data->join('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->select('data_pelanggars.*')
                    ->where('dh.tipe_disposisi', 1);
            }

            if ($value['name'] == 'disposisi-bagden') {
                $data->join('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->select('data_pelanggars.*')
                    ->where('dh.tipe_disposisi', 2);
            }

            if ($value['name'] == 'disposisi-unit') {
                $data->join('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->select('data_pelanggars.*')
                    ->where('dh.tipe_disposisi', 3);
            }

            if ($value['name'] == 'diproses-polda') {
                $data->join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->join('poldas', 'poldas.id', '=', 'lp.polda_id')
                    ->select('data_pelanggars.*')
                    ->orwhere('data_pelanggars.status_id', 9)
                    ->orwhere('poldas.id', $polda->id);
            }
        }

        return $data;
    }
}
