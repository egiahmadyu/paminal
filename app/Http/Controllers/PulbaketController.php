<?php

namespace App\Http\Controllers;

use App\Models\BaiPelapor;
use App\Models\BaiTerlapor;
use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\GelarPerkaraHistory;
use App\Models\LHPHistory;
use App\Models\NdPermohonanGelar;
use App\Models\Pangkat;
use App\Models\PengantarSprinHistory;
use App\Models\Penyidik;
use App\Models\Saksi;
use App\Models\HistorySaksi;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UndanganKlarifikasiHistory;
use App\Models\Unit;
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
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();

        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        if (!$data = SprinHistory::where('data_pelanggar_id', $kasus_id)->first()) {

            $data = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_sprin' => $request->no_sprin,
                'created_by' => auth()->user()->id,
                'masa_berlaku_sprin' => Carbon::createFromFormat('m/d/Y', $request->masa_berlaku_sprin)->format('Y-m-d H:i:s'),
            ]);
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_sprin.docx'));
        $template_document->setValues(array(
            'no_sprin' => $data->no_sprin,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_sprin' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'mulai_berlaku_sprin' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),
            'masa_berlaku_sprin' => Carbon::parse($data->masa_berlaku_sprin)->translatedFormat('d F Y'),
            'tanggal' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'kesatuan' => $kasus->kesatuan,
            'wilayah_hukum' => $kasus->wilayahHukum->name,
            'tanggal_ttd' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),

        ));

        for ($i = 0; $i < 10; $i++) {
            # code...
            $template_document->setValues(array(
                'anggota_' . $i => $penyidik[$i]['name'] ?? '',
                'pangkat_' . $i => $penyidik[$i]['pangkat'] ?? '',
                'nrp_' . $i => $penyidik[$i]['nrp'] ?? '',
                'jabatan_' . $i => $penyidik[$i]['jabatan'] ?? '',
            ));
        }

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-perintah.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-perintah.docx'))->deleteFileAfterSend(true);
    }

    public function printSuratPengantarSprin($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();

        if (!$data = PengantarSprinHistory::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = PengantarSprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_pengantar_sprin' => null,
            ]);
        }
        $karopaminal = DataAnggota::where('jabatan', 'LIKE', 'KAROPAMINAL')->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/pengantar_sprin.docx'));
        $template_document->setValues(array(
            'nama_karopaminal' => $karopaminal->nama,
            'pangkat_karopaminal' => Pangkat::find($karopaminal->pangkat)->name,
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'kronologi' => $kasus->kronologi,
            'tanggal' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_pengantar_sprin' => Carbon::parse($data->created_at)->translatedFormat('Y'),
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-pengantar-sprin.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-pengantar-sprin.docx'))->deleteFileAfterSend(true);
    }

    public function printUUK($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        if (!$data = UukHistory::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = UukHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'created_by' => auth()->user()->id,
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $karopaminal = DataAnggota::where('jabatan', 'LIKE', 'KAROPAMINAL')->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_uuk.docx'));
        $template_document->setValues(array(
            'nama_karopaminal' => $karopaminal->nama,
            'pangkat_karopaminal' => Pangkat::find($karopaminal->pangkat)->name,
            'nama' => strtoupper($kasus->terlapor),
            'nrp' => $kasus->nrp,
            'pangkat' => $pangkat->alias,
            'jabatan' => $kasus->jabatan,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'tanggal' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'kronologi' => $kasus->kronologi,
            'unit' => $unit,
            'den' => $den,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_uuk' => Carbon::parse($data->created_at)->translatedFormat('Y')
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-uuk.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-uuk.docx'))->deleteFileAfterSend(true);
    }

    public function sp2hp2Awal($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        if (!$data = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->where('tipe', 'awal')->first()) {
            $data = Sp2hp2Hisory::create([
                'data_pelanggar_id' => $kasus_id,
                'penangan' => $request->penangan,
                'pangkat_dihubungi' => $request->pangkat_dihubungi,
                'dihubungi' => $request->dihubungi,
                'jabatan_dihubungi' => $request->jabatan_dihubungi,
                'telp_dihubungi' => $request->telp_dihubungi,
                'created_by' => auth()->user()->id,
                'tipe' => 'awal',
            ]);
        }

        $sesropaminal = DataAnggota::where('jabatan', 'LIKE', 'SESROPAMINAL')->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/sp2hp2_awal.docx'));

        $template_document->setValues(array(
            'nama_sesropaminal' => $sesropaminal->nama,
            'pangkat_sesropaminal' => Pangkat::find($sesropaminal->pangkat)->name,
            'nrp_sesropaminal' => $sesropaminal->nrp,
            'penangan' => $data->penangan . ' Datasemen A',
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi,
            'pelapor' => $kasus->pelapor,
            'alamat' => $kasus->alamat,
            'bulan_tahun' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_sp2hp2' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'klasifikasi' => strtoupper($disposisi->klasifikasi),
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-sp2hp2_awal.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-sp2hp2_awal.docx'))->deleteFileAfterSend(true);
    }

    public function sp2hp2Akhir($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $sp2hp2_awal = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->where('tipe', 'awal')->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $lhp = LHPHistory::where('data_pelanggar_id', $kasus_id)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();
        $pangkat_pimpinan_gelar = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();

        if (!$data = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->where('tipe', 'akhir')->first()) {
            $data = Sp2hp2Hisory::create([
                'data_pelanggar_id' => $kasus_id,
                'penangan' => $sp2hp2_awal->penangan,
                'pangkat_dihubungi' => $sp2hp2_awal->pangkat_dihubungi,
                'dihubungi' => $sp2hp2_awal->dihubungi,
                'jabatan_dihubungi' => $sp2hp2_awal->jabatan_dihubungi,
                'telp_dihubungi' => $sp2hp2_awal->telp_dihubungi,
                'created_by' => auth()->user()->id,
                'tipe' => 'akhir',
            ]);
        }
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/sp2hp2_akhir.docx'));

        $template_document->setValues(array(
            'dihubungi' => $data->pangkat_dihubungi . ' ' . $data->dihubungi . ' jabatan ' . $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi,
            'pelapor' => $kasus->pelapor,
            'alamat' => $kasus->alamat,
            'bulan_tahun' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_sp2hp2' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'klasifikasi' => strtoupper($disposisi->klasifikasi),
            'no_sprin' => 'SPRIN/' . $sprin->no_sprin . '/' . $this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')) . '/HUK.6.6./' . Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'terlapor' => $pangkat_terlapor->alias . ' ' . $kasus->terlapor . ' jabatan ' . $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'wilayah_hukum' => $kasus->wilayahHukum->name,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'hasil_penyelidikan' => $lhp->hasil_penyelidikan == 1 ? 'Ditemukan cukup bukti' : 'Belum ditemukan cukup bukti',
            'tgl_gelar' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tempat_gelar' => $gelar_perkara->tempat,
            'pimpinan_gelar' => $pangkat_pimpinan_gelar->alias . ' ' . $gelar_perkara->pimpinan . ' jabatan ' . $gelar_perkara->jabatan_pimpinan,
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-sp2hp2_akhir.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-sp2hp2_akhir.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiSipil($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Data Penyidik SP2HP2 belum dibuat !');
        } elseif (!isset($undangan_klarifikasi)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Undangan Klarifikasi belum dibuat !');
        }

        $template_document = new TemplateProcessor(storage_path('template_surat/BAI_SIPIL.docx'));
        if (!$data = BaiPelapor::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = BaiPelapor::create([
                'data_pelanggar_id' => $kasus_id,
                'created_by' => auth()->user()->id,

            ]);
        }
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        $karopaminal = DataAnggota::where('jabatan', 'LIKE', 'KAROPAMINAL')->first();

        $template_document->setValues(array(
            'nama_karopaminal' => $karopaminal->nama,
            'pangkat_karopaminal' => Pangkat::find($karopaminal->pangkat)->name,
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal_nota_dinas' => $kasus->perihal_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pelapor' => $kasus->pelapor,
            'pekerjaan' => $kasus->pekerjaan,
            'nik' => $kasus->no_identitas,
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

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-pelapor.docx'));
        Redirect::away("bai-sipil/" . $kasus_id);
        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-pelapor.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiSaksi($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Data Penyidik SP2HP2 belum dibuat !');
        } elseif (!isset($undangan_klarifikasi)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Undangan Klarifikasi belum dibuat !');
        }

        $template_document = new TemplateProcessor(storage_path('template_surat/BAI_SAKSI.docx'));
        if (!$data = BaiPelapor::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = BaiPelapor::create([
                'data_pelanggar_id' => $kasus_id,
                'created_by' => auth()->user()->id,

            ]);
        }
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
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

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-pelapor.docx'));
        Redirect::away("bai-sipil/" . $kasus_id);
        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-pelapor.docx'))->deleteFileAfterSend(true);
    }

    public function printBaiAnggota($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $sp2hp = Sp2hp2Hisory::where('data_pelanggar_id', $kasus_id)->first();
        $undangan_klarifikasi = UndanganKlarifikasiHistory::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($sp2hp)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Data Penyidik SP2HP2 belum dibuat !');
        } elseif (!isset($undangan_klarifikasi)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'Undangan Klarifikasi belum dibuat !');
        }

        $template_document = new TemplateProcessor(storage_path('template_surat/bai_anggota.docx'));
        if (!$data = BaiTerlapor::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = BaiTerlapor::create([
                'data_pelanggar_id' => $kasus_id,
                // 'tanggal_introgasi' => Carbon::createFromFormat('m/d/Y',$request->tanggal_introgasi)->format('Y-m-d H:i:s'),
                // 'waktu_introgasi' => Carbon::createFromFormat('H:i:s',$request->waktu_introgasi)->format('H:i:s'),
                'created_by' => auth()->user()->id,

            ]);
        }
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();


        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();

        $karopaminal = DataAnggota::where('jabatan', 'LIKE', 'KAROPAMINAL')->first();

        $template_document->setValues(array(
            'nama_karopaminal' => $karopaminal->nama,
            'pangkat_karopaminal' => Pangkat::find($karopaminal->pangkat)->name,
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => strtoupper($kasus->terlapor),
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

        ));

        for ($i = 0; $i < 10; $i++) {
            # code...
            $template_document->setValues(array(
                'anggota_' . $i => $penyidik[$i]['name'] ?? '',
                'pangkat_' . $i => $penyidik[$i]['pangkat'] ?? '',
                'nrp_' . $i => $penyidik[$i]['nrp'] ?? '',
                'jabatan_' . $i => $penyidik[$i]['jabatan'] ?? '',
            ));
        }

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-anggota.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-surat-bai-anggota.docx'))->deleteFileAfterSend(true);
    }

    public function lhp(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat/lhp.docx'));

        if (!$data = LHPHistory::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = LHPHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_lhp' => null,
                'hasil_penyelidikan' => $request->hasil_penyelidikan,
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $template_document->setValues(array(
            'tgl_lhp' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'no_sprin' => $sprin->no_sprin,
            'tanggal_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'tahun_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat_terlapor->name,
            'jabatan' => $kasus->jabatan,
            'perihal' => $kasus->perihal_nota_dinas,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => strtoupper($kasus->terlapor),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'ketua' => $penyidik[0]['name'] ?? '',
            'pangkat_ketua' => $penyidik[0]['pangkat'] ?? '',
            'jabatan_ketua' => $penyidik[0]['jabatan'] ?? '',
            'nrp_ketua' => $penyidik[0]['nrp'] ?? '',
            'anggota_1' => $penyidik[1]['name'] ?? '',
            'pangkat_1' => $penyidik[1]['pangkat'] ?? '',
            'jabatan_1' => $penyidik[1]['jabatan'] ?? '',
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
            'jabatan_2' => $penyidik[2]['jabatan'] ?? '',
            'jabatan_3' => $penyidik[3]['jabatan'] ?? '',
            'jabatan_4' => $penyidik[4]['jabatan'] ?? '',
            'jabatan_5' => $penyidik[5]['jabatan'] ?? '',
            'no_lhp' => $data->no_lhp,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_no_lhp' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'hasil_penyelidikan' => $data->hasil_penyelidikan == "1" ? 'Ditemukan' : 'Belum ditemukan',
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-lhp.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-lhp.docx'))->deleteFileAfterSend(true);
    }

    public function ndPG($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template_surat/nd_permohonan_gelar.docx'));
        if (!$data = NdPermohonanGelar::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = NdPermohonanGelar::create([
                'data_pelanggar_id' => $kasus->id,
                'no_surat' => $request->no_surat,
                'created_by' => auth()->user()->id
            ]);
        }

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first();
        $den_name = explode(" ", $den->name);
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        $anggota = DataAnggota::where('id', $den->kaden)->first();
        $kadena = Penyidik::where('datasemen', $anggota->datasemen)->where('jabatan', $anggota->jabatan)->first();

        $template_document->setValues(array(
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'nomor_nd_permohonan' => $data->no_surat,
            'bulan_nd_permohonan' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->alias,
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
            'kadena' => strtoupper($kadena->name),
            'pangkat_kadena' => strtoupper(Pangkat::where('id', $kadena->pangkat)->first()->name),
            'nrp_kadena' => $kadena->nrp,
            'detasemen' => $den->name,
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_permohonan_gelar.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_permohonan_gelar.docx'))->deleteFileAfterSend(true);
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

        if (!$data) {
            $data = UndanganKlarifikasiHistory::create([
                'data_pelanggar_id' => $kasus->id,
                'no_surat_undangan' => $request->no_surat_undangan,
                'tgl_klarifikasi' => Carbon::createFromFormat('m/d/Y', $request->tgl_klarifikasi)->format('Y-m-d'),
                'waktu_klarifikasi' => Carbon::createFromFormat('m/d/Y H:i', $request->tgl_klarifikasi . ' ' . $request->waktu_klarifikasi)->format('Y-m-d H:i'),
                'jenis_undangan' => $request->jenis_undangan,
            ]);
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $sesropaminal = DataAnggota::where('jabatan', 'LIKE', 'SESROPAMINAL')->first();

        // dd($kasus->perihal_nota_dinas);
        if ($data->jenis_undangan == 1) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_klarifikasi_sipil.docx'));

            $template_document->setValues(array(
                'nama_sesropaminal' => $sesropaminal->nama,
                'pangkat_sesropaminal' => Pangkat::find($sesropaminal->pangkat)->name,
                'nrp_sesropaminal' => $sesropaminal->nrp,
                'no_surat_undangan' => $data->no_surat_undangan,
                'tgl_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
                'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
                'tgl_undangan_sipil' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
                'pelapor' => $kasus->pelapor,
                'alamat_pelapor' => $kasus->alamat,
                'terlapor' => $kasus->terlapor,
                'pangkat_terlapor' => $kasus->pangkat,
                'nrp_terlapor' => $kasus->nrp,
                'jabatan_terlapor' => $kasus->jabatan,
                'kesatuan_terlapor' => $kasus->kesatuan,
                'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
                'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'no_nota_dinas' => $kasus->no_nota_dinas,
                'perihal' => $kasus->perihal_nota_dinas,
                'no_sprin' => 'SPRIN/' . $sprin->no_sprin . '/I/HUK.6.6./2023',
                'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'hari_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('l'),
                'tgl_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('d F Y'),
                'waktu_klarifikasi' => Carbon::parse($request->waktu_klarifikasi)->translatedFormat('H:i'),
                // 'pangkat_penyelidik' => $penyidik,
                'nama_penyelidik' => $sp2hp->dihubungi,
                'jabatan_penyelidik' => $sp2hp->jabatan_dihubungi,
                'no_telp_penyelidik' => $sp2hp->telp_dihubungi,
            ));

            $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_sipil.docx'));

            return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_sipil.docx'))->deleteFileAfterSend(true);
        } elseif ($data->jenis_undangan == 2) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_klarifikasi_personel.docx'));

            $template_document->setValues(array(
                'nama_sesropaminal' => $sesropaminal->nama,
                'pangkat_sesropaminal' => Pangkat::find($sesropaminal->pangkat)->name,
                'nrp_sesropaminal' => $sesropaminal->nrp,
                'no_surat_undangan' => $data->no_surat_undangan,
                'tgl_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
                'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
                'tgl_undangan' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
                'pelapor' => $kasus->pelapor,
                'alamat_pelapor' => $kasus->alamat,
                'terlapor' => $kasus->terlapor,
                'pangkat_terlapor' => $pangkat->name,
                'nrp_terlapor' => $kasus->nrp,
                'jabatan_terlapor' => $kasus->jabatan,
                'kesatuan_terlapor' => $kasus->kesatuan,
                'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
                'wilayah_hukum' => $kasus->wilayahHukum->name,
                'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'no_nota_dinas' => $kasus->no_nota_dinas,
                'perihal' => $kasus->perihal_nota_dinas,
                'no_sprin' => 'SPRIN/' . $sprin->no_sprin . '/' . $this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')) . '/HUK.6.6./' . Carbon::parse($sprin->created_at)->translatedFormat('Y'),
                'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'hari_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('l'),
                'tgl_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('d F Y'),
                'waktu_klarifikasi' => Carbon::parse($request->waktu_klarifikasi)->translatedFormat('H:i'),
                // 'pangkat_penyelidik' => $penyidik,
                'nama_penyelidik' => $sp2hp->dihubungi,
                'jabatan_penyelidik' => $sp2hp->jabatan_dihubungi,
                'no_telp_penyelidik' => $sp2hp->telp_dihubungi,
                'wilayah_hukum' => $kasus->wilayahHukum->name,
            ));

            $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_personel.docx'));

            return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_personel.docx'))->deleteFileAfterSend(true);
        } else {
            $saksis = Saksi::where('data_pelanggar_id', $kasus->id)->get();
            $filenames = [];
            foreach ($saksis as $key => $saksi) {
                # code...
                $data_saksi = [
                    'data' => $data,
                    'kasus' => $kasus,
                    'wujud_perbuatan' => $wujud_perbuatan,
                    'pangkat' => $pangkat,
                    'sprin' => $sprin,
                    'sp2hp' => $sp2hp,
                    'saksi' => $saksi,
                    'key' => $key,
                ];
                $filenames[$key] = storage_path($this->UndanganKlarifikasiSaksi($data_saksi));
            }
            // response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_saksi.docx'))->deleteFileAfterSend(true);

            // [public_path('myimage.jpg'), public_path('myimage2.jpg')]
            return response()->download($filenames);
        }
    }

    public function undanganGelarPerkara($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_gelar_perkara.docx'));
        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-template_undangan_gelar_perkara.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-template_undangan_gelar_perkara.docx'))->deleteFileAfterSend(true);
    }

    public function viewNextData($id)
    {
        $kasus = DataPelanggar::find($id);
        $ndPG = NdPermohonanGelar::where('data_pelanggar_id', $id)->first();
        $bulan_romawi_ndPG = isset($ndPG) ? $this->getRomawi(Carbon::parse($ndPG->created_at)->translatedFormat('m')) : '';
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();
        $history_saksi = HistorySaksi::where('data_pelanggar_id', $kasus->id)->first() ?? '';
        $saksis = Saksi::where('data_pelanggar_id', $kasus->id)->get();
        $bai_pelapor = BaiPelapor::where('data_pelanggar_id', $kasus->id)->first();
        $bai_terlapor = BaiTerlapor::where('data_pelanggar_id', $kasus->id)->first();

        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $data = [
            'kasus' => $kasus,
            'nd_pgp' => $ndPG,
            'bulan_romawi_ndPG' => $bulan_romawi_ndPG,
            'unit' => $unit,
            'den' => $den,
            'lhp' => $lhp,
            'history_saksi' => $history_saksi,
            'saksis' => $saksis,
            'penyidik' => $penyidik,
            'bai_pelapor' => $bai_pelapor,
            'bai_terlapor' => $bai_terlapor,
        ];
        return view('pages.data_pelanggaran.proses.pulbaket-next', $data);
    }

    public function getSaksi($id)
    {
        $data = Saksi::find($id);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'sukses',
            'data' => $data,
        ]);
    }

    public function tambahSaksi($id, Request $request)
    {
        $data_pelangggar = DataPelanggar::find($id);

        Saksi::create([
            'data_pelanggar_id' => $data_pelangggar->id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);
        return redirect()->route('kasus.detail', ['id' => $id]);
    }

    private function UndanganKlarifikasiSaksi($data_saksi)
    {
        $data = $data_saksi['data'];
        $kasus = $data_saksi['kasus'];
        $wujud_perbuatan = $data_saksi['wujud_perbuatan'];
        $pangkat = $data_saksi['pangkat'];
        $sprin = $data_saksi['sprin'];
        $sp2hp = $data_saksi['sp2hp'];
        $saksi = $data_saksi['saksi'];

        $template_document = new TemplateProcessor(storage_path('template_surat/template_undangan_klarifikasi_saksi.docx'));

        $template_document->setValues(array(
            'no_surat_undangan' => $data->no_surat_undangan,
            'tgl_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_surat' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'tgl_undangan' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'saksi' => $saksi->nama,
            'alamat_saksi' => $saksi->alamat,
            'pelapor' => $kasus->pelapor,
            'alamat_pelapor' => $kasus->alamat,
            'terlapor' => $kasus->terlapor,
            'pangkat_terlapor' => $pangkat->name,
            'nrp_terlapor' => $kasus->nrp,
            'jabatan_terlapor' => $kasus->jabatan,
            'kesatuan_terlapor' => $kasus->kesatuan,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'wilayah_hukum' => $kasus->wilayahHukum->name,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'perihal' => $kasus->perihal_nota_dinas,
            'no_sprin' => 'SPRIN/' . $sprin->no_sprin . '/' . $this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')) . '/HUK.6.6./' . Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'hari_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('l'),
            'tgl_klarifikasi' => Carbon::parse($data->tgl_klarifikasi)->translatedFormat('d F Y'),
            'waktu_klarifikasi' => Carbon::parse($data->waktu_klarifikasi)->translatedFormat('H:i'),
            'nama_penyelidik' => $sp2hp->dihubungi,
            'jabatan_penyelidik' => $sp2hp->jabatan_dihubungi,
            'no_telp_penyelidik' => $sp2hp->telp_dihubungi,
            'wilayah_hukum' => $kasus->wilayahHukum->name,
        ));

        $filename = 'template_surat/' . $kasus->pelapor . '-dokumen-undangan_klarifikasi_saksi_.' . $data_saksi['key'] . 'docx';
        $template_document->saveAs(storage_path($filename));

        return $filename;
    }

    private function getRomawi($bln)
    {
        switch ($bln) {
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
