<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use Illuminate\Http\Request;

class GelarPerkaraController extends Controller
{
    public function printUGP($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = GelarPerkaraHistory::create([
                'data_pelanggar_id' => $kasus_id

            ]);
        }
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_undangan_gelar_perkara.docx'));

        $template_document->setValues(array(
            'penangan' => $data->penangan,
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi
        ));

        $template_document->saveAs(storage_path("template_surat/UGP-$kasus->id.docx"));
        return response()->download(storage_path("template_surat/UGP-$kasus->id.docx"))->deleteFileAfterSend(true);
    }
}