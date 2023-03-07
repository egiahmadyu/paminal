<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\LimpahBiro;
use App\Models\LimpahBiroHistory;
use App\Models\SprinHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class ProvostWabprofController extends Controller
{
    public function printLimpahBiro($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $limpah_biro = LimpahBiro::where('data_pelanggar_id', $kasus->id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat/template_nd_tindak_lanjut_hasil_penyelidikan.docx'));

        $template_document->setValues(array(
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::now()->month),
            'tahun_ttd' => Carbon::now()->year,
            'yth_kabiro' => $limpah_biro->jenis_limpah == 1 ? 'Kepala Biro Provos' : 'Kepala Kepala Biro Pertanggungjawaban Profesi',
            'no_nd_yanduan' => $kasus->no_nota_dinas,
            'tgl_no_nd_yanduan' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal_nd_yanduan' => $kasus->perihal_nota_dinas,
            'no_sprin' => 'Sprin/',$sprin->no_sprin,'/',$this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')),'/HUK.6.6./',Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'pangkat_terlapor' => $kasus->pangkat,
            'nama_terlapor' => $kasus->terlapor,
            'jabatan_terlapor' => $kasus->jabatan,
            'dugaan_pelanggaran' => $limpah_biro->jenis_limpah == 1 ? 'Disiplin' : 'Kode Etik Profesi Polri',
            'tgl_gelar_perkara' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tempat_gelar_perkara' => $gelar_perkara->tempat,
            'pemimpin_gelar_perkara' => $gelar_perkara->pimpinan,
            'pangkat_pemimpin_gelar' => $gelar_perkara->pangkat_pimpinan,
            'jabatan_pemimpin_gelar' => $gelar_perkara->jabatan_pimpinan,
            'tgl_ttd' => Carbon::now()->format('F Y'),
        ));

        $template_document->saveAs(storage_path('template_surat/nd_tindak_lanjut_hasil_penyelidikan.docx'));

        return response()->download(storage_path('template_surat/nd_tindak_lanjut_hasil_penyelidikan.docx'))->deleteFileAfterSend(true);
    }

    public function simpanData($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);

        if (!$data = LimpahBiroHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            LimpahBiro::create([
                'data_pelanggar_id' => $kasus_id,
                'jenis_limpah' => $request->jenis_limpah,
                'tanggal_limpah' => Carbon::now()
            ]);

            $data = LimpahBiroHistory::create([
                'data_pelanggar_id' => $kasus_id,
            ]);

        }
        
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_nd_tindak_lanjut_hasil_penyelidikan.docx'));
        $template_document->setValues(array(
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::now()->month),
            'tahun_ttd' => Carbon::now()->year,
            'yth_kabiro' => $request->jenis_limpah == 1 ? 'Kepala Biro Provos' : 'Kepala Kepala Biro Pertanggungjawaban Profesi',
            'no_nd_yanduan' => $kasus->no_nota_dinas,
            'tgl_no_nd_yanduan' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal_nd_yanduan' => $kasus->perihal_nota_dinas,
            'no_sprin' => 'Sprin/',$sprin->no_sprin,'/',$this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')),'/HUK.6.6./',Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'pangkat_terlapor' => $kasus->pangkat,
            'nama_terlapor' => $kasus->terlapor,
            'jabatan_terlapor' => $kasus->jabatan,
            'dugaan_pelanggaran' => $request->jenis_limpah == 1 ? 'Disiplin' : 'Kode Etik Profesi Polri',
            'tgl_gelar_perkara' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tempat_gelar_perkara' => $gelar_perkara->tempat,
            'pemimpin_gelar_perkara' => $gelar_perkara->pimpinan,
            'pangkat_pemimpin_gelar' => $gelar_perkara->pangkat_pimpinan,
            'jabatan_pemimpin_gelar' => $gelar_perkara->jabatan_pimpinan,
            'tgl_ttd' => Carbon::now()->locale('id')->format('F Y'),
        ));

        $template_document->saveAs(storage_path('template_surat/nd_tindak_lanjut_hasil_penyelidikan.docx'));

        return response()->download(storage_path('template_surat/nd_tindak_lanjut_hasil_penyelidikan.docx'))->deleteFileAfterSend(true);
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
