<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\SprinHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_undangan_gelar_perkara.docx'));

        $template_document->setValues(array(
            'penangan' => $data->penangan,
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi
        ));

        $template_document->saveAs(storage_path("template_surat/UGP-$kasus->id.docx"));
        return response()->download(storage_path("template_surat/UGP-$kasus->id.docx"))->deleteFileAfterSend(true);
    }

    public function notulenHasilGelar($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/notulen_gelar_perkara.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'nama' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));
        $template_document->saveAs(storage_path('template_surat/dokumen-notulen_gelar_perkara.docx'));

        return response()->download(storage_path('template_surat/dokumen-notulen_gelar_perkara.docx'))->deleteFileAfterSend(true);
    }

    public function laporanHasilGelar($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/laporan_hasil_gelar.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'nama' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));
        $template_document->saveAs(storage_path('template_surat/dokumen-laporan_hasil_gelar.docx'));

        return response()->download(storage_path('template_surat/dokumen-laporan_hasil_gelar.docx'))->deleteFileAfterSend(true);
    }

    public function baglitpers($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/BAGLITPERS.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

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
        $template_document->saveAs(storage_path('template_surat/dokumen-BAGLITPERS.docx'));

        return response()->download(storage_path('template_surat/dokumen-BAGLITPERS.docx'))->deleteFileAfterSend(true);
    }
}
