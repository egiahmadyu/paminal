<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\HistorySprin;
use App\Models\Sp2hp2Hisory;
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

    public function printSuratPengantarSprin($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\pengantar_sprin.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-pengantar-sprin.docx'));

        return response()->download(storage_path('template_surat/surat-pengantar-sprin.docx'))->deleteFileAfterSend(true);
    }

    public function printUUK($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!UukHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            UukHistory::create([
                'data_pelanggar_id' => $kasus_id,
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_uuk.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-uuk.docx'));

        return response()->download(storage_path('template_surat/surat-uuk.docx'))->deleteFileAfterSend(true);
    }

    public function sp2hp2Awal($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = Sp2hp2Hisory::create([
                'data_pelanggar_id' => $kasus_id,
                'penangan' => $request->penangan,
                'dihubungi' => $request->dihubungi,
                'jabatan_dihubungi' => $request->jabatan_dihubungi,
                'telp_dihubungi' => $request->telp_dihubungi

            ]);
        }
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\sp2hp2_awal.docx'));

        $template_document->setValues(array(
            'penangan' => $data->penangan,
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi
        ));

        $template_document->saveAs(storage_path('template_surat/surat-sp2hp2_awal.docx'));

        return response()->download(storage_path('template_surat/surat-sp2hp2_awal.docx'))->deleteFileAfterSend(true);
    }

    public function viewNextData($id)
    {
        $kasus = DataPelanggar::find($id);
        // $status = Process::find($kasus->status_id);
        // $process = Process::where('sort', '<=', $status->id)->get();

        $data = [
            'kasus' => $kasus
        ];
        return view('pages.data_pelanggaran.proses.pulbaket-next', $data);
    }
}