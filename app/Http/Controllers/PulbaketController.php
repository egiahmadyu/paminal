<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\HistorySprin;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UukHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class PulbaketController extends Controller
{
    public function printSuratPerintah($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = SprinHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id
                // 'isi_surat_perintah' => $request->isi_surat_perintah
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_sprin.docx'));
        $template_document->setValues(array(
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'kesatuan' => $kasus->kesatuan,
            'tanggal_ttd' => Carbon::parse($data->created_at)->translatedFormat('F Y')

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
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'kronologi' => $kasus->kronologi
        ));

        $template_document->saveAs(storage_path('template_surat/surat-pengantar-sprin.docx'));

        return response()->download(storage_path('template_surat/surat-pengantar-sprin.docx'))->deleteFileAfterSend(true);
    }

    public function printUUK($kasus_id, Request $request)
    {
        // Carbon

        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = UukHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = UukHistory::create([
                'data_pelanggar_id' => $kasus_id,
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_uuk.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'tanggal' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'kronologi' => $kasus->kronologi
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
            'telp_dihubungi' => $data->telp_dihubungi,
            'pelapor' => $kasus->pelapor,
            'alamat' => $kasus->alamat,
            'bulan_tahun' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-sp2hp2_awal.docx'));

        return response()->download(storage_path('template_surat/surat-sp2hp2_awal.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiSipil($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);

        $template_document = new TemplateProcessor(storage_path('template_surat\BAI_SIPIL.docx'));

        $template_document->setValues(array(
            'pelapor' => $kasus->pelapor,
            'pekerjaan' => $kasus->pekerjaan,
            'nik' => $kasus->nik,
            'agama' => $kasus->religi->name,
            'alamat' => $kasus->alamat,
            'telp' => $kasus->no_telp,
            'pelapor' => $kasus->pelapor,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan
        ));

        $template_document->saveAs(storage_path('template_surat/surat-bai-pelapor.docx'));

        return response()->download(storage_path('template_surat/surat-bai-pelapor.docx'))->deleteFileAfterSend(true);

    }

    public function printBaiAnggota($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);

        $template_document = new TemplateProcessor(storage_path('template_surat\bai_anggota.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-bai-anggota.docx'));

        return response()->download(storage_path('template_surat/surat-bai-anggota.docx'))->deleteFileAfterSend(true);

    }

    public function lhp($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat\lhp.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));

        $template_document->saveAs(storage_path('template_surat/dokumen-lhp.docx'));

        return response()->download(storage_path('template_surat/dokumen-lhp.docx'))->deleteFileAfterSend(true);
    }

    public function ndPG($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat\nd_permohonan_gelar.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));

        $template_document->saveAs(storage_path('template_surat/dokumen-nd_permohonan_gelar.docx'));

        return response()->download(storage_path('template_surat/dokumen-nd_permohonan_gelar.docx'))->deleteFileAfterSend(true);
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