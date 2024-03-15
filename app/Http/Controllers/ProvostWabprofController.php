<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\LimpahBiro;
use App\Models\LimpahBiroHistory;
use App\Models\Pangkat;
use App\Models\Polda;
use App\Models\SprinHistory;
use App\Models\WujudPerbuatan;
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

        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();
        $pangkat_pimpinan = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();
        $polda = isset($limpah_biro->limpah_polda) ? Polda::where('id', $limpah_biro->limpah_polda)->first() : '';

        if ($limpah_biro->jenis_limpah == 1) {
            $jenis_limpah = "Kepala Biro Provos";
        } elseif ($limpah_biro->jenis_limpah == 2) {
            $jenis_limpah = "Kepala Biro Pertanggungjawaban Profesi";
        } else {
            $jenis_limpah = "Kepala BID PROPAM " . $polda->name;
        }

        $karopaminal = DataAnggota::where('jabatan', 'LIKE', 'KAROPAMINAL')->first();

        $template_document->setValues(array(
            'nama_karopaminal' => $karopaminal->nama,
            'pangkat_karopaminal' => Pangkat::find($karopaminal->pangkat)->name,
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::now()->month),
            'tahun_ttd' => Carbon::now()->year,
            'yth_kabiro' => $jenis_limpah,
            'no_nd_yanduan' => $kasus->no_nota_dinas,
            'tgl_no_nd_yanduan' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal_nd_yanduan' => $kasus->perihal_nota_dinas,
            'no_sprin' => 'SPRIN/' . $sprin->no_sprin . '/' . $this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')) . '/HUK.6.6./' . Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'pangkat_terlapor' => strtoupper($pangkat_terlapor->name),
            'nama_terlapor' => strtoupper($kasus->terlapor),
            'jabatan_terlapor' => $kasus->jabatan,
            'dugaan_pelanggaran' => $limpah_biro->jenis_limpah == 1 ? 'Disiplin' : 'Kode Etik Profesi Polri',
            'tgl_gelar_perkara' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tempat_gelar_perkara' => $gelar_perkara->tempat,
            'pemimpin_gelar_perkara' => strtoupper($gelar_perkara->pimpinan),
            'pangkat_pemimpin_gelar' => strtoupper($pangkat_pimpinan->name),
            'jabatan_pemimpin_gelar' => strtoupper($gelar_perkara->jabatan_pimpinan),
            'tgl_ttd' => Carbon::now()->format('F Y'),
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_tindak_lanjut_hasil_penyelidikan.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_tindak_lanjut_hasil_penyelidikan.docx'))->deleteFileAfterSend(true);
    }

    public function simpanData($kasus_id, Request $request)
    {
        $kasus = DataPelanggar::find($kasus_id);

        if (!$data = LimpahBiro::where('data_pelanggar_id', $kasus_id)->first()) {
            $data = LimpahBiro::create([
                'data_pelanggar_id' => $kasus_id,
                'jenis_limpah' => $request->jenis_limpah,
                'tanggal_limpah' => Carbon::now(),
                'limpah_polda' => $request->limpah_polda,
            ]);

            LimpahBiroHistory::create([
                'data_pelanggar_id' => $kasus_id,
            ]);
        } elseif (($data->jenis_limpah === 3) && (is_null($data->limpah_polda))) {
            $data->update(['limpah_polda' => $request->limpah_polda]);
        }
        $polda = Polda::where('id', $data->limpah_polda)->first();

        if ($data->jenis_limpah == 1) {
            $jenis_limpah = "Kepala Biro Provos";
        } elseif ($data->jenis_limpah == 2) {
            $jenis_limpah = "Kepala Biro Pertanggungjawaban Profesi";
        } else {
            $jenis_limpah = "Kepala BID PROPAM " . $polda->name;
        }

        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();
        $pangkat_pimpinan = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();
        $wujud_perbuatan = WujudPerbuatan::where('id', $kasus->wujud_perbuatan)->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat\template_nd_tindak_lanjut_hasil_penyelidikan.docx'));
        $template_document->setValues(array(
            'tgl_ttd_romawi' => $this->getRomawi(Carbon::now()->month),
            'tahun_ttd' => Carbon::now()->year,
            'yth_kabiro' => $jenis_limpah,
            'no_nd_yanduan' => $kasus->no_nota_dinas,
            'tgl_no_nd_yanduan' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal_nd_yanduan' => $kasus->perihal_nota_dinas,
            'no_sprin' => 'Sprin/', $sprin->no_sprin, '/', $this->getRomawi(Carbon::parse($sprin->created_at)->translatedFormat('m')), '/HUK.6.6./', Carbon::parse($sprin->created_at)->translatedFormat('Y'),
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'pangkat_terlapor' => $pangkat_terlapor->name,
            'nama_terlapor' => $kasus->terlapor,
            'jabatan_terlapor' => $kasus->jabatan,
            'dugaan_pelanggaran' => $request->jenis_limpah == 1 ? 'Disiplin' : 'Kode Etik Profesi Polri',
            'tgl_gelar_perkara' => Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y'),
            'tempat_gelar_perkara' => $gelar_perkara->tempat,
            'pemimpin_gelar_perkara' => $gelar_perkara->pimpinan,
            'pangkat_pemimpin_gelar' => $pangkat_pimpinan->name,
            'jabatan_pemimpin_gelar' => $gelar_perkara->jabatan_pimpinan,
            'tgl_ttd' => Carbon::now()->locale('id')->format('F Y'),
        ));

        $template_document->saveAs(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_tindak_lanjut_hasil_penyelidikan.docx'));

        return response()->download(storage_path('template_surat/' . $kasus->pelapor . '-dokumen-nd_tindak_lanjut_hasil_penyelidikan.docx'))->deleteFileAfterSend(true);
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
