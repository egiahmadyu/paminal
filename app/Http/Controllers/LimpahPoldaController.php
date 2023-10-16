<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\LimpahPolda;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpWord\TemplateProcessor;

class LimpahPoldaController extends Controller
{
    public function generateLimpahPolda(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $data['ticketDesc'] = $request->ticketDesc;
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
            ->setPaper('A4', 'potrait')
            ->loadView('pages.data_pelanggaran.generate.limpah-polda', $data);

        return $pdf->download($kasus->pelapor . '-dokumen-limpah-polda.pdf');
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
            $message = 'Distribusi Binpam belum dibuat !';
            $status = false;
        } elseif ($request->tipe_disposisi == 3 && ($distribusi_binpam = DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->first())) {
            if (is_null($distribusi_binpam->limpah_den)) {
                $message = 'Limpah Datasemen belum ditentukan !';
                $status = false;
            }
        }

        if ($request->tipe_disposisi == 2 && (!DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 1)->first())) {
            $message = 'Disposisi Karo/Sesro belum dibuat !';
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
        } elseif ($data && $data->tipe_disposisi == 2 && !isset($data->limpah_den)) {
            if ($request->limpah_den == 7) {
                $data->update([
                    'limpah_den' => $request->limpah_den
                ]);
                $kasus->update([
                    'status_id' => 3
                ]);
                return redirect()->back()->with('message', 'Dumas dilimpahkan ke polda.');
            }
            $data->update([
                'limpah_den' => $request->limpah_den
            ]);
            return redirect()->back()->with('message', 'Limpah Datasemen telah ditentukan.');
        } elseif ($data && $data->tipe_disposisi == 3 && !isset($data->limpah_unit)) {
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
            return redirect()->back()->with('message', 'Limpah unit telah ditentukan.');
        } else {
            DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 3)->update([
                'klasifikasi' => $request->klasifikasi,
                'derajat' => $request->derajat,
                'no_agenda' => $request->nomor_agenda,
                'tipe_disposisi' => $request->tipe_disposisi,
            ]);
            $kasus->update([
                'status_id' => 4
            ]);
        }

        if ($request->tipe_disposisi == 1) {
            $template_filename = 'template_disposisi_karopaminal';
            $filename = $kasus->pelapor . '-surat-disposisi-karopaminal';
        } elseif ($request->tipe_disposisi == 2) {
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
            'surat_dari' => 'BagYanduan',
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

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/' . $template_filename . '.docx'));

        $template_document->setValues(array(
            'pelapor' => $kasus->pelapor,
            'wilayah_hukum' => $wilayah_hukum->name,
            'wujud_perbuatan' => $wujud_perbuatan->keterangan_wp,
            'bulan_romawi' => $this->getRomawi(Carbon::now()->translatedFormat('m')),
            'tahun' => Carbon::now()->translatedFormat('Y'),
            'tgl_kejadian' => Carbon::parse($kasus->tanggal_kejadian)->translatedFormat('d F Y'),
            'perihal' => $kasus->perihal_nota_dinas,
            'kronologis' => $kasus->kronologi,
            'tgl_pelaporan' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y')
        ));

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
