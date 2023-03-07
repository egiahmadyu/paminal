<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\NDHasilGelarPenyelidikanHistory;
use App\Models\NdPermohonanGelar;
use App\Models\SprinHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class GelarPerkaraController extends Controller
{
    public function printUGP($kasus_id, Request $request)
    {
        $nd_permohonan_gelar = NdPermohonanGelar::where('data_pelanggar_id',$kasus_id)->first();
        if (!isset($nd_permohonan_gelar)) {
            // dd(isset($nd_permohonan_gelar));
            return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error','ND Permohonan Gelar Penyelidikan belum dibuat');
        }

        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = GelarPerkaraHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'tanggal' => Carbon::createFromFormat('m/d/Y',$request->tanggal_gelar_perkara)->format('Y-m-d H:i:s'),
                'waktu' => Carbon::createFromFormat('H:i:s',$request->waktu_gelar_perkara)->format('H:i:s'),
                'tempat' => $request->tempat_gelar_perkara,
                'pimpinan' => $request->nama_pimpinan,
                'pangkat_pimpinan' => $request->pangkat_pimpinan,
                'jabatan_pimpinan' => $request->jabatan_pimpinan,
                'nrp_pimpinan' => $request->nrp_pimpinan,
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_undangan_gelar_perkara.docx'));

        $template_document->setValues(array(
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_ttd' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'no_surat_nd_permohonan_gp' => $nd_permohonan_gelar->no_surat,
            'tgl_nd_permohonan_gp' => Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('d F Y'),
            'hari_gp' => Carbon::parse($data->tanggal)->translatedFormat('l'),
            'tanggal_gp' => Carbon::parse($data->tanggal)->translatedFormat('d F Y'),
            'waktu' => Carbon::parse($data->waktu)->format('H:i'),
            'tempat' => $data->tempat,
            'pimpinan' => $data->pimpinan,
            'pangkat_pimpinan' => $data->pangkat_pimpinan,
            'jabatan_pimpinan' => $data->jabatan_pimpinan,
            'tanggal_ugp' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
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
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();

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
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'tgl_gp' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('F Y'),
            'pimpinan_gp' => $gelar_perkara->pangkat_pimpinan .' '. $gelar_perkara->pimpinan,
        ));
        $template_document->saveAs(storage_path('template_surat/dokumen-notulen_gelar_perkara.docx'));

        return response()->download(storage_path('template_surat/dokumen-notulen_gelar_perkara.docx'))->deleteFileAfterSend(true);
    }

    public function laporanHasilGelar($kasus_id, Request $request)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/laporan_hasil_gelar.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $nd_permohonan_gelar = NdPermohonanGelar::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();

        if (!$data = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = NDHasilGelarPenyelidikanHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_surat' => $request->no_surat,
            ]);
        }

        $template_document->setValues(array(
            'tahun_ttd' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('Y'),
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
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'bulan_tahun_gp' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('F Y'),
            'hari_gp' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('l'),
            'tgl_gp' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'waktu_gp' => Carbon::parse($gelar_perkara->waktu)->translatedFormat('H:i'),
            'tempat_gp' => $gelar_perkara->tempat,
            'pimpinan_gelar' => $gelar_perkara->pangkat_pimpinan.' '.$gelar_perkara->pimpinan,
            'jabatan_pimpinan_gelar' => $gelar_perkara->jabatan_pimpinan,
            'no_nd_permohonan_gelar' => 'R/ND - '. $nd_permohonan_gelar->no_surat . '/'. $this->getRomawi(Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('m')) .'/WAS.2.4./'.Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('Y').'/Den A',
            'tgl_nd_permohonan_gelar' => Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('d F Y'),
            'perihal_nd_permohonan_gelar' => '*masih belum*', //belum dibuat
            'dugaan' => '*masih belum*',
            'bulan_ttd_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_ttd' => Carbon::parse($data->created_at)->translatedFormat('Y'),
        ));
        $template_document->saveAs(storage_path('template_surat/dokumen-laporan_hasil_gelar.docx'));

        return response()->download(storage_path('template_surat/dokumen-laporan_hasil_gelar.docx'))->deleteFileAfterSend(true);
    }

    public function baglitpers($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/BAGLITPERS.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $nd_hasil_gelar = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus->id)->first();

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
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'no_surat_nd_hasil_gelar' => 'R/ND-'. $nd_hasil_gelar->no_surat .'/'. $this->getRomawi(Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('m')) .'/WAS.2.4./'. Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('Y') .'/Ropaminal',
            'tgl_nd_surat_hasil_gelar' => Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('d F Y'),
            'dugaan' => '*masih belum*', //masih belum
            'hari_gelar' => Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('l'),
            'tgl_gelar' => Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('d F Y'),
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            'bulan_ttd_romawi' => $this->getRomawi(Carbon::now()->translatedFormat('m')),
            'tahun_ttd' => Carbon::now()->translatedFormat('Y'),
        ));
        $template_document->saveAs(storage_path('template_surat/dokumen-BAGLITPERS.docx'));

        return response()->download(storage_path('template_surat/dokumen-BAGLITPERS.docx'))->deleteFileAfterSend(true);
    }

    private function getRomawi($bln)
    {
        switch ($bln){
            case 1: 
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
