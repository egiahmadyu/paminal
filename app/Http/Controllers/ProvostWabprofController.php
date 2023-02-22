<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\LimpahBiro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProvostWabprofController extends Controller
{
    public function printLimpahBiro($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = SprinHistory::where('data_pelanggar_id', $kasus_id)->first())
        {

            $data = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_sprin' => $request->no_sprin
                // 'isi_surat_perintah' => $request->isi_surat_perintah
            ]);

            Penyidik::create([
                'data_pelanggar_id' => $kasus_id,
                'name' => $request->nama_penyelidik_ketua,
                'nrp' => $request->nrp_ketua,
                'pangkat' => $request->pangkat_ketua,
                'jabatan' => $request->jabatan_ketua
            ]);

            for ($i=0; $i < count($request->nama_penyelidik_anggota); $i++) {
                Penyidik::create([
                    'data_pelanggar_id' => $kasus_id,
                    'name' => $request->nama_penyelidik_anggota[$i],
                    'nrp' => $request->nrp_anggota[$i],
                    'pangkat' => $request->pangkat_anggota[$i],
                    'jabatan' => $request->jabatan_anggota[$i]
                ]);
            }
        }
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus_id)->get()->toArray();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        // dd($penyidik[0]);
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_sprin.docx'));
        $template_document->setValues(array(
            'no_sprin' => $sprin->no_sprin,
            'tanggal' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'kesatuan' => $kasus->kesatuan,
            'tanggal_ttd' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'ketua' => $penyidik[0]['name'] ?? '',
            'pangkat_ketua' => $penyidik[0]['pangkat'] ?? '',
            'nrp_ketua' => $penyidik[0]['nrp'] ?? '',
            'anggota_1' => $penyidik[1]['name'] ?? '',
            'pangkat_1' => $penyidik[1]['pangkat'] ?? '',
            'nrp_1' => $penyidik[1]['nrp'] ?? '',
            'anggota_2' => $penyidik[2]['name'] ?? '',
            'pangkat_2' => $penyidik[2]['pangkat'] ?? '',
            'nrp_2' => $penyidik[2]['nrp'] ?? '',
            'anggota_3' => $penyidik[3]['name'] ?? '',
            'pangkat_3' => $penyidik[3]['pangkat'] ?? '',
            'nrp_3' => $penyidik[3]['nrp'] ?? '',
            'anggota_4' => $penyidik[4]['name'] ?? '',
            'pangkat_4' => $penyidik[4]['pangkat'] ?? '',
            'nrp_4' => $penyidik[4]['nrp'] ?? '',
            'anggota_5' => $penyidik[5]['name'] ?? '',
            'pangkat_5' => $penyidik[5]['pangkat'] ?? '',
            'nrp_5' => $penyidik[5]['nrp'] ?? '',

        ));

        $template_document->saveAs(storage_path('template_surat/surat-perintah.docx'));

        return response()->download(storage_path('template_surat/surat-perintah.docx'))->deleteFileAfterSend(true);
    }

    public function simpanData($kasus_id, Request $request)
    {
        // dd($request->all());
        $kasus = DataPelanggar::find($kasus_id);
        
        LimpahBiro::create([
            'data_pelanggar_id' => $kasus_id,
            'jenis_limpah' => $request->jenis_limpah,
            'tanggal_limpah' => Carbon::now()
        ]);

        return redirect()->route('kasus.detail',['id'=>$kasus_id]);

        // $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_sprin.docx'));
        // $template_document->setValues(array(
        //     'no_sprin' => $sprin->no_sprin,
        //     'tanggal' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
        //     'no_nota_dinas' => $kasus->no_nota_dinas,
        //     'perihal' => $kasus->perihal_nota_dinas,
        //     'kesatuan' => $kasus->kesatuan,
        //     'tanggal_ttd' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
        //     'ketua' => $penyidik[0]['name'] ?? '',
        //     'pangkat_ketua' => $penyidik[0]['pangkat'] ?? '',
        //     'nrp_ketua' => $penyidik[0]['nrp'] ?? '',
        //     'anggota_1' => $penyidik[1]['name'] ?? '',
        //     'pangkat_1' => $penyidik[1]['pangkat'] ?? '',
        //     'nrp_1' => $penyidik[1]['nrp'] ?? '',
        //     'anggota_2' => $penyidik[2]['name'] ?? '',
        //     'pangkat_2' => $penyidik[2]['pangkat'] ?? '',
        //     'nrp_2' => $penyidik[2]['nrp'] ?? '',
        //     'anggota_3' => $penyidik[3]['name'] ?? '',
        //     'pangkat_3' => $penyidik[3]['pangkat'] ?? '',
        //     'nrp_3' => $penyidik[3]['nrp'] ?? '',
        //     'anggota_4' => $penyidik[4]['name'] ?? '',
        //     'pangkat_4' => $penyidik[4]['pangkat'] ?? '',
        //     'nrp_4' => $penyidik[4]['nrp'] ?? '',
        //     'anggota_5' => $penyidik[5]['name'] ?? '',
        //     'pangkat_5' => $penyidik[5]['pangkat'] ?? '',
        //     'nrp_5' => $penyidik[5]['nrp'] ?? '',

        // ));

        // $template_document->saveAs(storage_path('template_surat/surat-perintah.docx'));

        // return response()->download(storage_path('template_surat/surat-perintah.docx'))->deleteFileAfterSend(true);
    }
}
