<?php

namespace App\Http\Controllers;

use App\Models\HistorySprin;
use App\Models\SprinHistory;
use App\Models\UukHistory;
use Illuminate\Http\Request;

class PulbaketController extends Controller
{
    public function printSuratPerintah($kasus_id, Request $request)
    {
        setlocale(LC_ALL, 'id_ID');
        if (!$data = SprinHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'isi_surat_perintah' => $request->isi_surat_perintah
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_sprin.docx'));
        $template_document->setValues(array(
            'bulan' => date('F', strtotime($data->created_at)),
            'isi_surat_perintah' => $data->isi_surat_perintah
        ));

        $template_document->saveAs(storage_path('template_surat/surat-perintah.docx'));

        return response()->download(storage_path('template_surat/surat-perintah.docx'))->deleteFileAfterSend(true);
    }

    public function printUUK($kasus_id, Request $request)
    {
        if (!$data = UukHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = UukHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'nama' => $request->nama,
                'nrp' => $request->nrp,
                'pangkat' => $request->pangkat,
                'jabatan' => $request->jabatan,
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_uuk.docx'));
        $template_document->setValues(array(
            'nama' => $data->nama,
            'nrp' => $data->nrp,
            'pangkat' => $data->pangkat,
            'jabatan' => $data->jabatan,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-uuk.docx'));

        return response()->download(storage_path('template_surat/surat-uuk.docx'))->deleteFileAfterSend(true);
    }
}