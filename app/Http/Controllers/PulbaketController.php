<?php

namespace App\Http\Controllers;

use App\Models\BaiPelapor;
use App\Models\BaiTerlapor;
use App\Models\DataPelanggar;
use App\Models\DisposisiHistory;
use App\Models\GelarPerkaraHistory;
use App\Models\HistorySprin;
use App\Models\LHPHistory;
use App\Models\NdPermohonanGelar;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Saksi;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UndanganKlarifikasiHistory;
use App\Models\UndanganKlarifikasiSipilHistory;
use App\Models\UukHistory;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\TemplateProcessor;

class PulbaketController extends Controller
{
    public function printSuratPerintah($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = SprinHistory::where('data_pelanggar_id', $kasus_id)->first())
        {

            $data = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_sprin' => $request->no_sprin,
                'created_by' => auth()->user()->id,
                'masa_berlaku_sprin' => Carbon::createFromFormat('m/d/Y',$request->masa_berlaku_sprin)->format('Y-m-d H:i:s'),
                // 'isi_surat_perintah' => $request->isi_surat_perintah
            ]);

            // if ($request->nama_penyelidik_ketua)
            // {
            //     Penyidik::create([
            //         'data_pelanggar_id' => $kasus_id,
            //         'name' => $request->nama_penyelidik_ketua,
            //         'nrp' => $request->nrp_ketua,
            //         'pangkat' => $request->pangkat_ketua,
            //         'jabatan' => $request->jabatan_ketua
            //     ]);

            //     if ($request->nama_penyelidik_anggota)
            //     {
            //         for ($i=0; $i < count($request->nama_penyelidik_anggota); $i++) {
            //             Penyidik::create([
            //                 'data_pelanggar_id' => $kasus_id,
            //                 'name' => $request->nama_penyelidik_anggota[$i],
            //                 'nrp' => $request->nrp_anggota[$i],
            //                 'pangkat' => $request->pangkat_anggota[$i],
            //                 'jabatan' => $request->jabatan_anggota[$i]
            //             ]);
            //         }
            //     }

            // }

        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }

        $penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get()->toArray();
        $ketua_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_sprin.docx'));
        $template_document->setValues(array(
            'no_sprin' => $data->no_sprin,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_sprin' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'masa_berlaku_sprin' => Carbon::parse($data->masa_berlaku_sprin)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'kesatuan' => $kasus->kesatuan,
            'wilayah_hukum' => $kasus->wilayah_hukum,
            'tanggal_ttd' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),
            'ketua' => $ketua_penyidik->name ?? '',
            'pangkat_ketua' => $ketua_penyidik->pangkat ?? '',
            'nrp_ketua' => $ketua_penyidik->nrp ?? '',
            'jabatan_ketua' => $ketua_penyidik->jabatan ?? '',
            'anggota_1' => $penyidik[0]['name'] ?? '',
            'pangkat_1' => $penyidik[0]['pangkat'] ?? '',
            'nrp_1' => $penyidik[0]['nrp'] ?? '',
            'jabatan_1' => $penyidik[0]['jabatan'] ?? '',
            'anggota_2' => $penyidik[1]['name'] ?? '',
            'pangkat_2' => $penyidik[1]['pangkat'] ?? '',
            'nrp_2' => $penyidik[1]['nrp'] ?? '',
            'jabatan_2' => $penyidik[1]['jabatan'] ?? '',
            'anggota_3' => $penyidik[2]['name'] ?? '',
            'pangkat_3' => $penyidik[2]['pangkat'] ?? '',
            'nrp_3' => $penyidik[2]['nrp'] ?? '',
            'jabatan_3' => $penyidik[2]['jabatan'] ?? '',
            'anggota_4' => $penyidik[3]['name'] ?? '',
            'pangkat_4' => $penyidik[3]['pangkat'] ?? '',
            'nrp_4' => $penyidik[3]['nrp'] ?? '',
            'jabatan_4' => $penyidik[3]['jabatan'] ?? '',
            'anggota_5' => $penyidik[4]['name'] ?? '',
            'pangkat_5' => $penyidik[4]['pangkat'] ?? '',
            'nrp_5' => $penyidik[4]['nrp'] ?? '',
            'jabatan_5' => $penyidik[4]['jabatan'] ?? '',

        ));

        $template_document->saveAs(storage_path('template_surat/surat-perintah.docx'));

        return response()->download(storage_path('template_surat/surat-perintah.docx'))->deleteFileAfterSend(true);
    }

    public function printSuratPengantarSprin($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/pengantar_sprin.docx'));
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
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = UukHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = UukHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'created_by' => auth()->user()->id,
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }

        $pangkat = Pangkat::where('id',$kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_uuk.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'tanggal' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'kronologi' => $kasus->kronologi,
            'unit' => $unit,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_uuk' => Carbon::parse($data->created_at)->translatedFormat('Y')
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
                'telp_dihubungi' => $request->telp_dihubungi,
                'created_by' => auth()->user()->id,
            ]);
        }
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/sp2hp2_awal.docx'));

        $template_document->setValues(array(
            'penangan' => $data->penangan.' Datasemen A',
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi,
            'pelapor' => $kasus->pelapor,
            'alamat' => $kasus->alamat,
            'bulan_tahun' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
        ));

        $template_document->saveAs(storage_path('template_surat/surat-sp2hp2_awal.docx'));

        return response()->download(storage_path('template_surat/surat-sp2hp2_awal.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiSipil($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error','Data Penyidik SP2HP2 belum dibuat !');
        } elseif (!isset($undangan_klarifikasi)) {
            return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error','Undangan Klarifikasi belum dibuat !');
        }

        $template_document = new TemplateProcessor(storage_path('template_surat/BAI_SIPIL.docx'));
        if (!$data = BaiPelapor::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = BaiPelapor::create([
                'data_pelanggar_id' => $kasus_id,
                'created_by' => auth()->user()->id,

            ]);
        }
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }

        $ketua_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();
        $penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get()->toArray();

        $katim_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();
        $anggota_penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get();
        $penyidik[0] = $katim_penyidik;
        foreach ($anggota_penyidik as $key => $value) {
            $penyidik[$key+1] = $value;
        }

        $pangkat = Pangkat::where('id',$kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();
        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal_nota_dinas' => $kasus->perihal_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pelapor' => $kasus->pelapor,
            'pekerjaan' => $kasus->pekerjaan,
            'nik' => $kasus->nik,
            'agama' => $kasus->religi->name,
            'alamat' => $kasus->alamat,
            'telp' => $kasus->no_telp,
            'pelapor' => $kasus->pelapor,
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'kronologi' => $kasus->kronologi,
            'tanggal_introgasi' => Carbon::parse($undangan_klarifikasi->tgl_klarifikasi)->translatedFormat('d F Y'),
            'waktu_introgasi' => Carbon::parse($undangan_klarifikasi->waktu_klarifikasi)->translatedFormat('H:i'),
            'hari_introgasi' => Carbon::parse($undangan_klarifikasi->tgl_klarifikasi)->translatedFormat('l'),
            'ketua' => $penyidik[0]['name'] ?? '',
            'pangkat_ketua' => $penyidik[0]['pangkat'] ?? '',
            'nrp_ketua' => $penyidik[0]['nrp'] ?? '',
            'jabatan_ketua' => $penyidik[0]['jabatan'] ?? '',
            'anggota_1' => $penyidik[1]['name'] ?? '',
            'pangkat_1' => $penyidik[1]['pangkat'] ?? '',
            'nrp_1' => $penyidik[1]['nrp'] ?? '',
            'jabatan_1' => $penyidik[1]['jabatan'] ?? '',
            'anggota_2' => $penyidik[2]['name'] ?? '',
            'pangkat_2' => $penyidik[2]['pangkat'] ?? '',
            'nrp_2' => $penyidik[2]['nrp'] ?? '',
            'jabatan_2' => $penyidik[2]['jabatan'] ?? '',
            'anggota_3' => $penyidik[3]['name'] ?? '',
            'pangkat_3' => $penyidik[3]['pangkat'] ?? '',
            'nrp_3' => $penyidik[3]['nrp'] ?? '',
            'jabatan_3' => $penyidik[3]['jabatan'] ?? '',
            'anggota_4' => $penyidik[4]['name'] ?? '',
            'pangkat_4' => $penyidik[4]['pangkat'] ?? '',
            'nrp_4' => $penyidik[4]['nrp'] ?? '',
            'jabatan_4' => $penyidik[4]['jabatan'] ?? '',
            'anggota_5' => $penyidik[5]['name'] ?? '',
            'pangkat_5' => $penyidik[5]['pangkat'] ?? '',
            'nrp_5' => $penyidik[5]['nrp'] ?? '',
            'jabatan_5' => $penyidik[5]['jabatan'] ?? '',
        ));

        $template_document->saveAs(storage_path('template_surat/surat-bai-pelapor.docx'));
        Redirect::away("bai-sipil/".$kasus_id);
        return response()->download(storage_path('template_surat/surat-bai-pelapor.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiAnggota($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error','Data Penyidik SP2HP2 belum dibuat !');
        } elseif (!isset($undangan_klarifikasi)) {
            return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error','Undangan Klarifikasi belum dibuat !');
        }

        $template_document = new TemplateProcessor(storage_path('template_surat/bai_anggota.docx'));
        if (!$data = BaiTerlapor::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = BaiTerlapor::create([
                'data_pelanggar_id' => $kasus_id,
                // 'tanggal_introgasi' => Carbon::createFromFormat('m/d/Y',$request->tanggal_introgasi)->format('Y-m-d H:i:s'),
                // 'waktu_introgasi' => Carbon::createFromFormat('H:i:s',$request->waktu_introgasi)->format('H:i:s'),
                'created_by' => auth()->user()->id,

            ]);
        }
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }

        $katim_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();
        $anggota_penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get();
        $penyidik[0] = $katim_penyidik;
        foreach ($anggota_penyidik as $key => $value) {
            $penyidik[$key+1] = $value;
        }

        $pangkat = Pangkat::where('id',$kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'kronologi' => $kasus->kronologi,
            'no_sprin' => $sprin->no_sprin,
            'tanggal_sprin' => Carbon::parse($sprin->created_ats)->translatedFormat('d F Y'),
            'tanggal_introgasi' => Carbon::parse($undangan_klarifikasi->tgl_klarifikasi)->translatedFormat('d F Y'),
            'waktu_introgasi' => Carbon::parse($undangan_klarifikasi->waktu_klarifikasi)->translatedFormat('H:i'),
            'hari_introgasi' => Carbon::parse($undangan_klarifikasi->tgl_klarifikasi)->translatedFormat('l'),
            'ketua' => $penyidik[0]['name'] ?? '',
            'pangkat_ketua' => $penyidik[0]['pangkat'] ?? '',
            'jabatan_ketua' => $penyidik[0]['jabatan'] ?? '',
            'nrp_ketua' => $penyidik[0]['nrp'] ?? '',
            'anggota_1' => $penyidik[1]['name'] ?? '',
            'pangkat_1' => $penyidik[1]['pangkat'] ?? '',
            'jabatan_1' => $penyidik[0]['jabatan'] ?? '',
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
            'jabatan_2' => $penyidik[1]['jabatan'] ?? '',
            'jabatan_3' => $penyidik[2]['jabatan'] ?? '',
            'jabatan_4' => $penyidik[3]['jabatan'] ?? '',
            'jabatan_5' => $penyidik[4]['jabatan'] ?? '',
        ));

        $template_document->saveAs(storage_path('template_surat/surat-bai-anggota.docx'));

        return response()->download(storage_path('template_surat/surat-bai-anggota.docx'))->deleteFileAfterSend(true);

    }

    public function lhp(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat/lhp.docx'));

        if (!$data = LHPHistory::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = LHPHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_lhp' => null,
                'hasil_penyelidikan' => $request->hasil_penyelidikan,
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }
        $pangkat = Pangkat::where('id',$kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();

        $ketua_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();
        $penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get()->toArray();

        $template_document->setValues(array(
            'tgl_lhp' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'no_sprin' => $sprin->no_sprin,
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'perihal' => $kasus->perihal_nota_dinas,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'tanggal_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'ketua' => $ketua_penyidik->name ?? '',
            'pangkat_ketua' => $ketua_penyidik->pangkat ?? '',
            'nrp_ketua' => $ketua_penyidik->nrp ?? '',
            'jabatan_ketua' => $ketua_penyidik->jabatan ?? '',
            'anggota_1' => $penyidik[0]['name'] ?? '',
            'pangkat_1' => $penyidik[0]['pangkat'] ?? '',
            'nrp_1' => $penyidik[0]['nrp'] ?? '',
            'jabatan_1' => $penyidik[0]['jabatan'] ?? '',
            'anggota_2' => $penyidik[1]['name'] ?? '',
            'pangkat_2' => $penyidik[1]['pangkat'] ?? '',
            'nrp_2' => $penyidik[1]['nrp'] ?? '',
            'jabatan_2' => $penyidik[1]['jabatan'] ?? '',
            'anggota_3' => $penyidik[2]['name'] ?? '',
            'pangkat_3' => $penyidik[2]['pangkat'] ?? '',
            'nrp_3' => $penyidik[2]['nrp'] ?? '',
            'jabatan_3' => $penyidik[2]['jabatan'] ?? '',
            'anggota_4' => $penyidik[3]['name'] ?? '',
            'pangkat_4' => $penyidik[3]['pangkat'] ?? '',
            'nrp_4' => $penyidik[3]['nrp'] ?? '',
            'jabatan_4' => $penyidik[3]['jabatan'] ?? '',
            'anggota_5' => $penyidik[4]['name'] ?? '',
            'pangkat_5' => $penyidik[4]['pangkat'] ?? '',
            'nrp_5' => $penyidik[4]['nrp'] ?? '',
            'jabatan_5' => $penyidik[4]['jabatan'] ?? '',
            'no_lhp' => $data->no_lhp,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_no_lhp' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'hasil_penyelidikan' => $data->hasil_penyelidikan == "1" ? 'Ditemukan' : 'Belum ditemukan',
        ));

        $template_document->saveAs(storage_path('template_surat/dokumen-lhp.docx'));

        return response()->download(storage_path('template_surat/dokumen-lhp.docx'))->deleteFileAfterSend(true);
    }

    public function ndPG($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat/nd_permohonan_gelar.docx'));
        if (!$data = NdPermohonanGelar::where('data_pelanggar_id', $kasus_id)->first())
        {
            $data = NdPermohonanGelar::create([
                'data_pelanggar_id' => $kasus->id,
                'no_surat' => $request->no_surat,
                'created_by' => auth()->user()->id
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }
        $pangkat = Pangkat::where('id',$kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();

        $kadena = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();

        $template_document->setValues(array(
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'nomor_nd_permohonan' => $data->no_surat,
            'bulan_nd_permohonan' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'kadena' => $kadena->name,
            'pangkat_kadena' => $kadena->pangkat,
            'nrp_kadena' => $kadena->nrp,
        ));

        $template_document->saveAs(storage_path('template_surat/dokumen-nd_permohonan_gelar.docx'));

        return response()->download(storage_path('template_surat/dokumen-nd_permohonan_gelar.docx'))->deleteFileAfterSend(true);
    }
    
    public function printUndanganKlarifikasi($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return back()->with('error', 'SP2HP2 belum dibuat !');
        }

        $data = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->where('jenis_undangan', $request->jenis_undangan)->first();
        
        if (!$data)
        {
            $data = UndanganKlarifikasiHistory::create([
                'data_pelanggar_id' => $kasus->id,
                'no_surat_undangan' => $request->no_surat_undangan,
                'tgl_klarifikasi' => Carbon::createFromFormat('m/d/Y',$request->tgl_klarifikasi)->format('Y-m-d H:i:s'),
                'waktu_klarifikasi' => Carbon::createFromFormat('H:i',$request->waktu_klarifikasi)->format('H:i'),
                'jenis_undangan' => $request->jenis_undangan,
            ]);
        }

        $wujud_perbuatan = WujudPerbuatan::where('id',$kasus->wujud_perbuatan)->first();

        if ($data->jenis_undangan == 1) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_klarifikasi_sipil.docx'));

            $template_document->setValues(array(
                'no_surat_undangan' => $data->no_surat_undangan,
                'tgl_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
                'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
                'tgl_undangan_sipil' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
                'pelapor' => $kasus->pelapor,
                'alamat_pelapor' => $kasus->alamat,
                'terlapor' => $kasus->terlapor,
                'pangkat_terlapor' => $kasus->pangkat,
                'nrp_terlapor' => $kasus->nrp,
                'jabatan_terlapor' =>$kasus->jabatan,
                'kesatuan_terlapor' => $kasus->kesatuan,
                'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
                'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'no_nota_dinas' => $kasus->no_nota_dinas,
                'perihal' => $kasus->perihal_nota_dinas,
                'no_sprin' => 'SPRIN/'. $sprin->no_sprin .'/I/HUK.6.6./2023',
                'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'hari_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('l'),
                'tgl_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('d F Y'),
                'waktu_klarifikasi' => Carbon::parse($request->waktu_klarifikasi)->translatedFormat('H:i'),
                // 'pangkat_penyelidik' => $penyidik,
                'nama_penyelidik' => $sp2hp->dihubungi,
                'jabatan_penyelidik' => $sp2hp->jabatan_dihubungi,
                'no_telp_penyelidik' => $sp2hp->telp_dihubungi,
            ));
        
            $template_document->saveAs(storage_path('template_surat/dokumen-undangan_klarifikasi_sipil.docx'));
        
            return response()->download(storage_path('template_surat/dokumen-undangan_klarifikasi_sipil.docx'))->deleteFileAfterSend(true);
        } else {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_klarifikasi_personel.docx'));

            $template_document->setValues(array(
                'no_surat_undangan' => $data->no_surat_undangan,
                'tgl_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
                'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
                'tgl_undangan' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
                'pelapor' => $kasus->pelapor,
                'alamat_pelapor' => $kasus->alamat,
                'terlapor' => $kasus->terlapor,
                'pangkat_terlapor' => $kasus->pangkat,
                'nrp_terlapor' => $kasus->nrp,
                'jabatan_terlapor' =>$kasus->jabatan,
                'kesatuan_terlapor' => $kasus->kesatuan,
                'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
                'wilayah_hukum' => $kasus->wilayah_hukum,
                'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'no_nota_dinas' => $kasus->no_nota_dinas,
                'perihal' => $kasus->perihal_nota_dinas,
                'no_sprin' => 'SPRIN/'. $sprin->no_sprin .'/'.$this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')).'/HUK.6.6./'.Carbon::parse($sprin->created_at)->translatedFormat('Y'),
                'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'hari_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('l'),
                'tgl_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('d F Y'),
                'waktu_klarifikasi' => Carbon::parse($request->waktu_klarifikasi)->translatedFormat('H:i'),
                // 'pangkat_penyelidik' => $penyidik,
                'nama_penyelidik' => $sp2hp->dihubungi,
                'jabatan_penyelidik' => $sp2hp->jabatan_dihubungi,
                'no_telp_penyelidik' => $sp2hp->telp_dihubungi,
                'wilayah_hukum' => $kasus->wilayah_hukum,
            ));
        
            $template_document->saveAs(storage_path('template_surat/dokumen-undangan_klarifikasi_personel.docx'));
        
            return response()->download(storage_path('template_surat/dokumen-undangan_klarifikasi_personel.docx'))->deleteFileAfterSend(true);
        }
    }

    public function undanganGelarPerkara($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_gelar_perkara.docx'));
        $template_document->saveAs(storage_path('template_surat/dokumen-template_undangan_gelar_perkara.docx'));

        return response()->download(storage_path('template_surat/dokumen-template_undangan_gelar_perkara.docx'))->deleteFileAfterSend(true);
    }

    public function viewNextData($id)
    {
        $kasus = DataPelanggar::find($id);
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        if ($disposisi->limpah_unit == '1') {
            $unit = "UNIT I";
        } elseif ($disposisi->limpah_unit == '2') {
            $unit = "UNIT II";
        } elseif ($disposisi->limpah_unit == '3') {
            $unit = "UNIT III";
        } else {
            $unit = "MIN DEN A";
        }

        $lhp = LHPHistory::where('data_pelanggar_id',$kasus->id)->first();

        $katim_penyidik = Penyidik::where('tim','Den A')->where('jabatan','KADEN A')->first();
        $anggota_penyidik = Penyidik::where('tim','Den A')->where('unit',$unit)->get();

        $penyidik[0] = $katim_penyidik;
        foreach ($anggota_penyidik as $key => $value) {
            $penyidik[$key+1] = $value;
        }

        $data = [
            'kasus' => $kasus,
            'bai_terlapor' => BaiPelapor::where('data_pelanggar_id', $id)->first(),
            'nd_pgp' => NdPermohonanGelar::where('data_pelanggar_id', $id)->first(),
            'unit' => $unit,
            'lhp' => $lhp,
            'penyidik' => $penyidik,
        ];
        return view('pages.data_pelanggaran.proses.pulbaket-next', $data);
    }

    public function tambahSaksi($id, Request $request)
    {
        // dd($id);
        $data_pelangggar = DataPelanggar::find($id);

        foreach ($request->nama_saksi as $key => $value) {
            Saksi::create([
                'data_pelanggar_id' => $id,
                'name' => $value
            ]);
        }
        return redirect()->route('kasus.detail',['id'=>$id]);
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