<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\DPExtends;
use App\Models\LimpahPolda;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use PhpOffice\PhpWord\TemplateProcessor;

class LimpahPoldaController extends Controller
{
    public function generateLimpahPolda(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $data = LimpahPolda::where('data_pelanggar_id', $kasus->id)->first();
        $polda = Polda::find($data->polda_id);
        $pangkat_terlapor = Pangkat::find($kasus->pangkat);
        $terlapor = $pangkat_terlapor->name . ' ' . $kasus->terlapor;
        $wujud_perbuatan = WujudPerbuatan::find($kasus->wujud_perbuatan);
        $sesro = DataAnggota::where('jabatan', 'SESROPAMINAL')->first();
        $pangkat_sesro = Pangkat::find($sesro->pangkat);


        // limpah polda
        $template_filename_limpah_polda = 'template_limpah_polda';
        $filename_limpah_polda = $kasus->pelapor . '-surat-limpah-polda';

        $template_document_limpah_polda = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/' . $template_filename_limpah_polda . '.docx'));
        $template_document_limpah_polda->setValues(array(
            'nomor_agenda' => $data->no_agenda,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'tgl_diterima' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),
            'waktu_diterima' => Carbon::parse($data->created_at)->translatedFormat('H:i'),
            'tanggal' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
            'surat_dari' => 'BAGYANDUAN',
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tgl_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal' => $kasus->perihal_nota_dinas,
            'tipe_no_surat' => $data->klasifikasi == 'Biasa' ? 'B' : 'R',
            'polda' => $polda->name,
            'pelapor' => $kasus->pelapor,
            'terlapor' => $terlapor,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'wilayah_hukum' => $polda->name,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'sesro' => $sesro->nama,
            'pangkat_sesro' => $pangkat_sesro->name,
            'nrp_sesro' => $sesro->nrp,
        ));
        $template_document_limpah_polda->saveAs(storage_path('template_surat/' . $filename_limpah_polda . '.docx'));

        $path_files = storage_path('template_surat/' . $filename_limpah_polda . '.docx');
        toastr()->success('DUMAS DILIMPAHKAN KE POLDA', 'Berhasil!');

        return response()->download($path_files)->deleteFileAfterSend(true);

        // return $pdf->download($kasus->pelapor . '-dokumen-limpah-polda.pdf');
    }

    public function generateDisposisi(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);

        if ($request->limpah_den == 7) {
            $limpah = LimpahPolda::create([
                'data_pelanggar_id' => $request->kasus_id,
                'polda_id' => $request->polda,
                'tanggal_limpah' => date('Y-m-d'),
                'created_by' => auth()->user()->id,
                'isi_surat' => '<ol><li>Rujukan :&nbsp;<br><b>a</b>.&nbsp;Undang-Undang Nomor 2 Tahun 2022 tentang Kepolisian Negara Republik Indonesia.<br><b>b</b>.&nbsp;Peraturan Kepolisian Negara Republik Indonesia Nomor 7 Tahun 2022 tentang Kode Etik Profesi&nbsp; &nbsp; &nbsp;dan Komisi Kode Etik Polri.<br><b>c</b>.&nbsp;Peraturan Kepala Kepolisian Negara Republik Indonesia Nomor 13 Tahun 2016 tentang Pengamanan Internal di Lingkungan Polri<br><b>d</b>.&nbsp;Nota Dinas Kepala Bagian Pelayanan Pengaduan Divpropam Polri Nomor: R/ND-2766-b/XII/WAS.2.4/2022/Divpropam tanggal 16 Desember 2022 perihal pelimpahan Dumas BRIPKA JAMALUDDIN ASYARI.</li></ol>'
            ]);
            if ($limpah) {
                $kasus->status_id = $request->limpah_den;
                $kasus->save();
            }
        }

        $data = DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', $request->tipe_disposisi)->first();

        $status = true;
        if ($request->tipe_disposisi == 3 && (!DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->first())) {
            $message = 'DISTRIBUSI BINPAM BELUM DIBUAT !';
            $status = false;
        } elseif ($request->tipe_disposisi == 3 && ($distribusi_binpam = DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->first())) {
            if (is_null($distribusi_binpam->limpah_den)) {
                $message = 'LIMPAH BAG/ DEN BELUM DITENTUKAN !';
                $status = false;
            }
        }

        if ($request->tipe_disposisi == 2 && (!DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 1)->first())) {
            $message = 'DISPOSISI KARO/SESRO BELUM DIBUAT !';
            $status = false;
        }

        if ($status == false) {
            return redirect()->back()->with('error', $message);
            // return redirect()->route('kasus.detail',['id'=>$kasus_id])->with('error',$message);
        }
        if (!$data) {
            if ($request->tipe_disposisi == '3') {
                $distribusi_binpam = DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->first();
                $data = DisposisiHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'no_agenda' => $request->nomor_agenda,
                    'tipe_disposisi' => $request->tipe_disposisi,
                    'limpah_unit' => $request->limpah_unit,
                    'limpah_den' => $distribusi_binpam->limpah_den,
                ]);
            } else {
                $data = DisposisiHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'no_agenda' => $request->nomor_agenda,
                    'tipe_disposisi' => $request->tipe_disposisi,
                ]);
            }
        }

        if ($data && $data->tipe_disposisi == 2 && !isset($data->limpah_den)) {
            if ($request->has('limpah_den')) {
                if ($request->limpah_den == 7) {
                    $data->update([
                        'limpah_den' => $request->limpah_den
                    ]);
                    $kasus->update([
                        'status_id' => 3
                    ]);

                    return redirect()->back()->with('message', 'DUMAS DILIMPAHKAN KE POLDA.');
                }

                // limpah kabagden
                $template_filename_limpah_bagden = 'template_limpah_kabagbinpam';
                $filename_limpah_bagden = $kasus->pelapor . '-surat-limpah-kabagbinpam';

                $data->update([
                    'limpah_den' => $request->limpah_den
                ]);

                $pangkat_terlapor = Pangkat::find($kasus->pangkat);
                $wujud_perbuatan = WujudPerbuatan::find($kasus->wujud_perbuatan);
                $den = Datasemen::find($data->limpah_den);
                $kabagden = DataAnggota::find($den->kaden);
                $kabagden_pangkat = Pangkat::find($kabagden->pangkat);
                $kabagden_nrp = $kabagden->nrp;
                $limpah_bagden = Datasemen::find($data->limpah_den);

                $template_document_limpah_bagden = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/' . $template_filename_limpah_bagden . '.docx'));
                $template_document_limpah_bagden->setValues(array(
                    'nomor_agenda' => $data->no_agenda,
                    'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
                    'tahun' => Carbon::parse($data->created_at)->translatedFormat('Y'),
                    'tgl_diterima' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),
                    'waktu_diterima' => Carbon::parse($data->created_at)->translatedFormat('H:i'),
                    'tanggal' => Carbon::parse($data->created_at)->translatedFormat('F Y'),
                    'surat_dari' => 'BAGYANDUAN',
                    'no_nota_dinas' => $kasus->no_nota_dinas,
                    'tgl_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                    'perihal' => $kasus->perihal_nota_dinas,
                    'tipe_no_surat' => $data->klasifikasi == 'Biasa' ? 'B' : 'R',
                    'bag_den' => 'KA. ' . $limpah_bagden->name,
                    'pelapor' => $kasus->pelapor,
                    'pangkat_terlapor' => $pangkat_terlapor->name,
                    'terlapor' => $kasus->terlapor,
                    'jabatan_terlapor' => $kasus->jabatan,
                    'kesatuan_terlapor' => $kasus->kesatuan,
                    'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
                    'kabagden' => $kabagden->nama,
                    'kabagden_pangkat' => $kabagden_pangkat->name,
                    'kabagden_nrp' => $kabagden_nrp,
                ));
                $template_document_limpah_bagden->saveAs(storage_path('template_surat/' . $filename_limpah_bagden . '.docx'));

                $path_files = storage_path('template_surat/' . $filename_limpah_bagden . '.docx');
                toastr()->success('Limpah BAG / DEN telah ditentukan.', 'Berhasil!');

                return response()->download($path_files)->deleteFileAfterSend(true);
                // return redirect()->back()->with('message', 'Limpah BAG / DEN telah ditentukan.');
            }
        }

        if ($data && $data->tipe_disposisi == 3 && !isset($data->limpah_unit)) {
            if ($request->has('limpah_unit')) {
                $penyidik = DataAnggota::where('unit', (int)$request->limpah_unit)->get();
                if (count($penyidik) < 1) {
                    return back()->withInput()->with('error', 'ANGGOTA UNIT BELUM DIBUAT!');
                }

                $data->update([
                    'limpah_unit' => $request->limpah_unit
                ]);

                // Create pimpinan
                $datasemen = Datasemen::where('id', $data->limpah_den)->first();

                $pimpinans = DataAnggota::where('id', $datasemen->kaden)->orWhere('id', $datasemen->wakaden)->get();
                foreach ($pimpinans as $key => $pimpinan) {
                    Penyidik::create([
                        'data_pelanggar_id' => $kasus->id,
                        'name' => $pimpinan->nama,
                        'nrp' => $pimpinan->nrp,
                        'pangkat' => $pimpinan->pangkat,
                        'jabatan' => $pimpinan->jabatan,
                        'datasemen' => $pimpinan->datasemen,
                        'unit' => '',
                    ]);
                }

                // Create anggota tim
                $anggota = DataAnggota::where('unit', $data->limpah_unit)->where('datasemen', $data->limpah_den)->get();
                foreach ($anggota as $key => $valAnggota) {
                    # code...
                    Penyidik::create([
                        'data_pelanggar_id' => $kasus->id,
                        'name' => $valAnggota->nama,
                        'nrp' => $valAnggota->nrp,
                        'pangkat' => $valAnggota->pangkat,
                        'jabatan' => $valAnggota->jabatan,
                        'datasemen' => $valAnggota->datasemen,
                        'unit' => $valAnggota->unit,
                    ]);
                }

                $kasus->update([
                    'status_id' => 4
                ]);
                return redirect()->route('kasus.detail', ['id' => $kasus->id])->with('message', 'LIMPAH UNIT TELAH DITENTUKAN.');
            }
        }

        if ($request->tipe_data && $request->tipe_data != '1') {
            DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 1)->update([
                'klasifikasi' => $request->klasifikasi,
                'derajat' => $request->derajat,
                'no_agenda' => $request->nomor_agenda,
            ]);
            DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->update([
                'klasifikasi' => $request->klasifikasi,
                'derajat' => $request->derajat,
                'no_agenda' => $request->nomor_agenda,
            ]);
            DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 3)->update([
                'klasifikasi' => $request->klasifikasi,
                'derajat' => $request->derajat,
                'no_agenda' => $request->nomor_agenda,
                'tipe_disposisi' => $request->tipe_disposisi,
            ]);
            DataPelanggar::where('id', $kasus_id)->update([
                'no_nota_dinas' => $request->nomor_agenda,
                'status_id' => 4
            ]);
            return redirect()->route('kasus.detail', ['id' => $kasus->id])->with('success', 'BERHASIL MELAKUKAN PENOMORAN SURAT !');
        }

        if ($data->tipe_disposisi == 1) {
            $template_filename = 'template_disposisi_karopaminal';
            $filename = $kasus->pelapor . '-surat-disposisi-karopaminal';
        } elseif ($data->tipe_disposisi == 2) {
            $template_filename = 'template_disposisi_kabagbinpam';
            $filename = $kasus->pelapor . '-surat-distribusi-kabagbinpam';
        } else {
            $template_filename = 'template_disposisi_kadena';
            $filename = $kasus->pelapor . '-surat-disposisi-ka-den-a';
        }

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/' . $template_filename . '.docx'));

        $template_document->setValues(array(
            'klasifikasi' => $data->klasifikasi,
            'derajat' => $data->derajat,
            'nomor_agenda' => $data->no_agenda,
            'bulan_romawi' => $this->getRomawi(Carbon::parse($data->created_at)->translatedFormat('m')),
            'tahun_agenda' => Carbon::parse($data->created_at)->translatedFormat('Y'),
            'tgl_diterima' => Carbon::parse($data->created_at)->translatedFormat('d F Y'),
            'waktu_diterima' => Carbon::parse($data->created_at)->translatedFormat('H:i'),
            'surat_dari' => 'BAGYANDUAN',
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tgl_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'perihal' => $kasus->perihal_nota_dinas,
            'tipe_no_surat' => $data->klasifikasi == 'Biasa' ? 'B' : 'R',
        ));

        $template_document->saveAs(storage_path('template_surat/' . $filename . '.docx'));

        return response()->download(storage_path('template_surat/' . $filename . '.docx'))->deleteFileAfterSend(true);
    }

    public function generateLiInfosus($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);

        if ($kasus->tipe_data == '3') {
            $template_filename = 'dokumen_li';
            $filename = $kasus->pelapor . '-Surat-Laporan-Informasi';
        } else {
            $template_filename = 'dokumen_infosus';
            $filename = $kasus->pelapor . '-Surat-Informasi-Khusus';
        }

        $wujud_perbuatan = WujudPerbuatan::find($kasus->wujud_perbuatan);
        $wilayah_hukum = Polda::find($kasus->wilayah_hukum);

        $kronologi = DPExtends::where('data_pelanggar_id', $kasus->id)->where('tipe', 'kronologis')->get();
        $catatan = DPExtends::where('data_pelanggar_id', $kasus->id)->where('tipe', 'catatan')->get();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/' . $template_filename . '.docx'));

        $template_document->setValues(array(
            'pelapor' => $kasus->pelapor,
            'wilayah_hukum' => $wilayah_hukum->name,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'bulan_romawi' => $this->getRomawi(Carbon::now()->translatedFormat('m')),
            'tahun' => Carbon::now()->translatedFormat('Y'),
            'tgl_kejadian' => Carbon::parse($kasus->tanggal_kejadian)->translatedFormat('d F Y'),
            'perihal' => $kasus->tipe_data == 2 ? 'INFOSUS' : 'LAPORAN INFORMASI',
            'tgl_pelaporan' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y')
        ));

        $template_document->cloneBlock('kronologi_section', count($kronologi), true, true);
        foreach ($kronologi as $keyKrono => $valKrono) {
            $template_document->setValues(array(
                'kronologi#' . $keyKrono + 1 => $valKrono->deskripsi
            ));
        }

        $template_document->cloneBlock('catatan_section', count($catatan), true, true);
        foreach ($kronologi as $keyCatatan => $valCatatan) {
            $template_document->setValues(array(
                'catatan#' . $keyCatatan + 1 => $valCatatan->deskripsi
            ));
        }

        $template_document->saveAs(storage_path('template_surat/' . $filename . '.docx'));

        return response()->download(storage_path('template_surat/' . $filename . '.docx'))->deleteFileAfterSend(true);
    }


    public function downloadDisposisi($type)
    {
        if ($type == 1) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_disposisi_karopaminal.docx'));
            $template_document->saveAs(storage_path('template_surat/surat-disposisi_karopaminal.docx'));

            return response()->download(storage_path('template_surat/surat-disposisi_karopaminal.docx'))->deleteFileAfterSend(true);
        } elseif ($type == 2) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_disposisi_kabagbinpam.docx'));
            $template_document->saveAs(storage_path('template_surat/surat-distribusi_kabagbinpam.docx'));

            return response()->download(storage_path('template_surat/surat-template_disposisi_kabagbinpam.docx'))->deleteFileAfterSend(true);
        } elseif ($type == 3) {
            $template_document = new TemplateProcessor(storage_path('template_surat/template_disposisi_kadena.docx'));
            $template_document->saveAs(storage_path('template_surat/surat-template_disposisi_kadena.docx'));

            return response()->download(storage_path('template_surat/surat-template_disposisi_kadena.docx'))->deleteFileAfterSend(true);
        }
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
