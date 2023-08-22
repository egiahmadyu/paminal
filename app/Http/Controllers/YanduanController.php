<?php

namespace App\Http\Controllers;

use App\Http\Integrations\YanduanIntegration;
use App\Models\DataPelanggar;
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
        $response =$this->yanduan->processed_reports($body);
        if (count($response->data) == 0) {
            return response()->json([
                'status' => 200,
                'total_import' => 0
                ]);
        }
        $import = 0;
        foreach ($response->data as $key => $value) {
            $data['kronologi']= $value->chronology;
            $data['created_at']= $value->released_at;
            $data['status_id']= 1;
            $data['ticket_id'] = $value->ticket_id;
            if (!DataPelanggar::where('ticket_id', $value->ticket_id)->first()) {
                for ($i=0; $i < count($value->defendants); $i++) {
                    $data['terlapor'] = $value->defendants[$i]->name;
                    $data['kesatuan'] = $value->defendants[$i]->unit;
                    $data['jabatan'] = $value->defendants[$i]->occupation;
                    $insert = DataPelanggar::create($data);
                    $insert->created_at = $value->released_at;
                    $insert->save();
                    $import++;
                }
            }

        }
        return response()->json([
            'status' => 200,
            'total_import' => $import
            ]);
    }
}
