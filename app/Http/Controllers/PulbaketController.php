<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\HistorySprin;
use App\Models\Penyidik;
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
        // dd($request->all());
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
            'anggota_1' => $penyidik[0]['name'] ?? '',
            'pangkat_1' => $penyidik[0]['pangkat'] ?? '',
            'nrp_1' => $penyidik[0]['nrp'] ?? '',
            'anggota_2' => $penyidik[1]['name'] ?? '',
            'pangkat_2' => $penyidik[1]['pangkat'] ?? '',
            'nrp_2' => $penyidik[1]['nrp'] ?? '',
            'anggota_3' => $penyidik[2]['name'] ?? '',
            'pangkat_3' => $penyidik[2]['pangkat'] ?? '',
            'nrp_3' => $penyidik[2]['nrp'] ?? '',
            'anggota_4' => $penyidik[3]['name'] ?? '',
            'pangkat_4' => $penyidik[3]['pangkat'] ?? '',
            'nrp_4' => $penyidik[3]['nrp'] ?? '',
            'anggota_5' => $penyidik[4]['name'] ?? '',
            'pangkat_5' => $penyidik[4]['pangkat'] ?? '',
            'nrp_5' => $penyidik[4]['nrp'] ?? '',

        ));

        $template_document->saveAs(storage_path('template_surat/surat-perintah.docx'));

        return response()->download(storage_path('template_surat/surat-perintah.docx'))->deleteFileAfterSend(true);
    }

    public function printSuratPengantarSprin($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\pengantar_sprin.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'kronologi' => $kasus->kronologi,
            'tanggal' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y')
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