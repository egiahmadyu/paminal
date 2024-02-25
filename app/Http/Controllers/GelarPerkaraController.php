<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\GelarPerkaraHistory;
use App\Models\LHPHistory;
use App\Models\LimpahBiro;
use App\Models\LimpahBiroHistory;
use App\Models\LitpersHistory;
use App\Models\NDHasilGelarPenyelidikanHistory;
use App\Models\NdPermohonanGelar;
use App\Models\Pangkat;
use App\Models\PasalPelanggaran;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\SprinHistory;
use App\Models\Unit;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Controllers\APILimpahBiroController;
use Illuminate\Support\Facades\DB;

class GelarPerkaraController extends Controller
{
    public function printUGP($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $nd_permohonan_gelar = NdPermohonanGelar::where('data_pelanggar_id', $kasus_id)->first();
        if (!isset($nd_permohonan_gelar)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'ND Permohonan Gelar Penyelidikan belum dibuat');
        }

        $pimpinan = DataAnggota::find($request->pimpinan);

        if (!$data = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = GelarPerkaraHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'tanggal' => Carbon::createFromFormat('m/d/Y', $request->tanggal_gelar_perkara)->format('Y-m-d H:i:s'),
                'waktu' => Carbon::createFromFormat('H:i', $request->waktu_gelar_perkara)->format('Y-m-d H:i'),
                'tempat' => $request->tempat_gelar_perkara,
                'pimpinan' => $pimpinan->nama,
                'pangkat_pimpinan' => $pimpinan->pangkat,
                'jabatan_pimpinan' => $pimpinan->jabatan,
                'nrp_pimpinan' => $pimpinan->nrp,
            ]);
        }

        $pangkat_pimpinan = Pangkat::where('id', $data->pangkat_pimpinan)->first();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $detasemen = Datasemen::find($disposisi->limpah_den);

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/template_undangan_gelar_perkara.docx'));

        $template_document->setValues(array(
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_ttd' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'no_surat_nd_permohonan_gp' => $nd_permohonan_gelar->no_surat . '/' . $this->getRomawi(Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('m')) . '/WAS.2.4/' . Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('T') . '/Den A',
            'tgl_nd_permohonan_gp' => Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('d F Y'),
            'hari_gp' => Carbon::parse($data->tanggal)->translatedFormat('l'),
            'tanggal_gp' => Carbon::parse($data->tanggal)->translatedFormat('d F Y'),
            'waktu' => Carbon::parse($data->waktu)->translatedFormat('H:i'),
            'tempat' => $data->tempat,
            'pimpinan' => strtoupper($data->pimpinan),
            'pangkat_pimpinan' => strtoupper($pangkat_pimpinan->name),
            'jabatan_pimpinan' => strtoupper($data->jabatan_pimpinan),
            'tanggal_ugp' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'penangan' => $data->penangan,
            'dihubungi' => $data->dihubungi,
            'jabatan_dihubungi' => $data->jabatan_dihubungi,
            'telp_dihubungi' => $data->telp_dihubungi,
            'pangkat_terlapor' => strtoupper($pangkat_terlapor->name),
            'terlapor' => strtoupper($kasus->terlapor),
            'nrp_terlapor' => $kasus->nrp,
            'jabatan_terlapor' => strtoupper($kasus->jabatan),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'kronologi' => $kasus->kronologi,
            'detasemen' => $detasemen->name,
        ));

        $template_document->saveAs(storage_path("template_surat/" . $kasus->pelapor . "-UGP-$kasus->id.docx"));
        return response()->download(storage_path("template_surat/" . $kasus->pelapor . "-UGP-$kasus->id.docx"))->deleteFileAfterSend(true);
    }

    public function notulenHasilGelar($kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/notulen_gelar_perkara.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $pangkat_pimpinan = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $pangkat->name,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'wilayah_hukum' => $kasus->wilayahHukum->name,
            'kwn' => $kasus->kewarganegaraan,
            'nama' => $kasus->terlapor,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => strtoupper($kasus->terlapor),
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'tgl_gp' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('F Y'),
            'pimpinan_gp' => $pangkat_pimpinan->name . ' ' . $gelar_perkara->pimpinan,
            'nrp_gp' => $gelar_perkara->nrp_pimpinan,
        ));
        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-notulen_gelar_perkara.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-notulen_gelar_perkara.docx'))->deleteFileAfterSend(true);
    }

    public function laporanHasilGelar($kasus_id, Request $request)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/laporan_hasil_gelar.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $nd_permohonan_gelar = NdPermohonanGelar::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();

        if (!$limpah_biro = LimpahBiro::where('data_pelanggar_id', $kasus_id)->first()) {

            DB::beginTransaction();
            try {
                //code...
                $limpah_biro = LimpahBiro::create([
                    'data_pelanggar_id' => $kasus_id,
                    'jenis_limpah' => $request->limpah_biro,
                    'tanggal_limpah' => Carbon::now()
                ]);

                LimpahBiroHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                ]);

                if ($request->limpah_biro == 2) {
                    $limpah_api = new APILimpahBiroController();
                    $response = $limpah_api->limpahWabprof($kasus->id);
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }

        if ($limpah_biro->jenis_limpah == 1) {
            $jenis_limpah = "ROPROVOS";
        } elseif ($limpah_biro->jenis_limpah == 2) {
            $jenis_limpah = "ROWABPROF";
        } else {
            $jenis_limpah = "BID PROPAM POLDA";
        }

        if (!$data = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = NDHasilGelarPenyelidikanHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_surat' => $request->no_surat,
            ]);
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;
        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }
        $pangkat_pimpinan_gelar = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first()->name;

        $wilayah_hukum = Polda::where('id', $kasus->wilayah_hukum)->first();

        $template_document->setValues(array(
            'tahun_ttd' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => strtoupper($pangkat->name),
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'nama' => strtoupper($kasus->terlapor),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'terlapor' => strtoupper($kasus->terlapor),
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => strtoupper($kasus->pelapor),
            'wilayah_hukum' => strtoupper($wilayah_hukum->name),
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'bulan_tahun_gp' => Carbon::parse($gelar_perkara->created_at)->translatedFormat('F Y'),
            'hari_gp' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('l'),
            'tgl_gp' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'waktu_gp' => Carbon::parse($gelar_perkara->waktu)->translatedFormat('H:i'),
            'tempat_gp' => $gelar_perkara->tempat,
            'pimpinan_gelar' => strtoupper($pangkat_pimpinan_gelar . ' ' . $gelar_perkara->pimpinan),
            'jabatan_pimpinan_gelar' => strtoupper($gelar_perkara->jabatan_pimpinan),
            'no_nd_permohonan_gelar' => 'R/ND - ' . $nd_permohonan_gelar->no_surat . '/' . $this->getRomawi(Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('m')) . '/WAS.2.4./' . Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('Y') . '/Den A',
            'tgl_nd_permohonan_gelar' => Carbon::parse($nd_permohonan_gelar->created_at)->translatedFormat('d F Y'),
            'dugaan' => $wujud_perbuatan->keterangan_wp,
            'bulan_ttd_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_ttd' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'hasil_penyelidikan' => $lhp->hasil_penyelidikan == '1' ? 'Ditemukan' : 'Belum ditemukan',
            'jumlah_penyidik' => count($penyidik) . ' (' . $this->getTerbilang(count($penyidik)) . ')',
            'katim_penyidik' => strtoupper($penyidik[0]['pangkat'] . ' ' . $penyidik[0]['name'] . ' jabatan ' . $penyidik[0]['jabatan']),
            'jenis_wp' => $wujud_perbuatan->jenis_wp == 'disiplin' ? 'DISIPLIN' : 'KEPP',
            'jenis_limpah' => $jenis_limpah
        ));
        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-laporan_hasil_gelar.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-laporan_hasil_gelar.docx'))->deleteFileAfterSend(true);
    }

    public function baglitpers(Request $request, $kasus_id)
    {
        $template_document = new TemplateProcessor(storage_path('template_surat/BAGLITPERS.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $nd_hasil_gelar = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus->id)->first() ?? '';

        $data = LitpersHistory::where('data_pelanggar_id', $kasus_id)->first();
        $pasal_pelanggaran = PasalPelanggaran::where('data_pelanggar_id', $kasus_id)->first();

        if (!isset($nd_hasil_gelar)) {
            return redirect()->route('kasus.detail', ['id' => $kasus_id])->with('error', 'ND Laporan Hasil Gelar Penyelidikan belum dibuat');
        }

        if (!$data && !$pasal_pelanggaran) {
            $data = LitpersHistory::create([
                'data_pelanggar_id' => $kasus_id,
            ]);

            $pasal_pelanggaran = PasalPelanggaran::create([
                'data_pelanggar_id' => $kasus_id,
                'pasal' => $request->pasal,
                'ayat' => $request->ayat,
                'bunyi_pasal' => $request->bunyi_pasal,
            ]);
        }

        $limpah_biro = LimpahBiro::where('data_pelanggar_id', $kasus->id)->first();

        if ($limpah_biro->jenis_limpah == 1) {
            $jenis_limpah = "ROPROVOS";
        } elseif ($limpah_biro->jenis_limpah == 2) {
            $jenis_limpah = "ROWABPROF";
        } else {
            $jenis_limpah = "BID PROPAM POLDA";
        }

        $pangkat = Pangkat::where('id', $kasus->pangkat)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => strtoupper($pangkat->name),
            'jabatan' => strtoupper($kasus->jabatan),
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => strtoupper($kasus->terlapor),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => strtoupper($kasus->kesatuan),
            'pelapor' => strtoupper($kasus->pelapor),
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y'),
            'no_surat_nd_hasil_gelar' => 'R/ND-' . $nd_hasil_gelar->no_surat . '/' . $this->getRomawi(Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('m')) . '/WAS.2.4./' . Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('Y') . '/Ropaminal',
            'tgl_nd_surat_hasil_gelar' => Carbon::parse($nd_hasil_gelar->created_at)->translatedFormat('d F Y'),
            'dugaan' => $wujud_perbuatan->keterangan_wp, //masih belum
            'hari_gelar' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('l'),
            'tgl_gelar' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            'bulan_ttd_romawi' => $this->getRomawi(Carbon::now()->translatedFormat('m')),
            'tahun_ttd' => Carbon::now()->translatedFormat('Y'),
            'pasal' => $pasal_pelanggaran->pasal,
            'ayat' => $pasal_pelanggaran->ayat,
            'bunyi_pasal' => $pasal_pelanggaran->bunyi_pasal,
            'jenis_wp' => $wujud_perbuatan->jenis_wp == 'disiplin' ? 'DISIPLIN' : 'KEPP',
            'jenis_limpah' => $jenis_limpah,
        ));
        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-BAGLITPERS.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-BAGLITPERS.docx'))->deleteFileAfterSend(true);
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

    private function getTerbilang($number)
    {
        switch ($number) {
            case 1:
                return "satu";
                break;
            case 2:
                return "dua";
                break;
            case 3:
                return "tiga";
                break;
            case 4:
                return "empat";
                break;
            case 5:
                return "lima";
                break;
            case 6:
                return "enam";
                break;
            case 7:
                return "tujuh";
                break;
            case 8:
                return "delapan";
                break;
            case 9:
                return "sembilan";
                break;
            case 10:
                return "sepuluh";
                break;
        }
    }
}
