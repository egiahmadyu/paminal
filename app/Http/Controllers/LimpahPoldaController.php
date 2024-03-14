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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use PDF;
use PhpOffice\PhpWord\TemplateProcessor;

class LimpahPoldaController extends Controller
{
    public function penagihanTinjutPolda($polda_id)
    {
        $polda = Polda::where('id', $polda_id)->get();
        $kasus = DataPelanggar::join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
            ->join('poldas', 'poldas.id', '=', 'lp.polda_id')
            ->select('data_pelanggars.*')
            ->where('data_pelanggars.status_id', 9)
            ->where('poldas.id', $polda[0]->id);

        if ($kasus->count() < 1) {
            return redirect()->back()->with('error', 'DATA DUMAS DI ' . $polda[0]->name . ' KOSONG');
        }

        $values = [];
        $i = 1;
        foreach ($kasus->get() as $key => $value) {
            $data = [
                'counter' => $i,
                'no_nota_dinas' => $value->no_nota_dinas,
                'bulan' => Carbon::parse($value->tanggal_nota_dinas)->translatedFormat('F'),
                'tanggal_nota_dinas' => Carbon::parse($value->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'nama_pendumas' => $value->pelapor,
                'perihal' => $value->perihal_nota_dinas,
            ];
            array_push($values, $data);
            $i++;
        }

        //Open template with ${table}
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template_surat/penagihan_tinjut_polda.docx'));

        $template_document->setValues([
            'judul' => 'REKAP PELIMPAHAN DUMAS KE POLDA ' . $polda[0]->name . ' T.A.' . Carbon::now()->translatedFormat('Y'),
        ]);

        $template_document->cloneRowAndSetValues('counter', $values);

        //save template with table
        $template_document->saveAs(storage_path('template_surat/REKAP-PELIMPAHAN-DUMAS-' . $polda[0]->name . '.docx'));

        // dd($template_document);
        return response()->download(storage_path('template_surat/REKAP-PELIMPAHAN-DUMAS-' . $polda[0]->name . '.docx'))->deleteFileAfterSend(true);
    }

    public function updateDataLimpahPolda(Request $request, $id)
    {
        // dd($request->all());
        $data = LimpahPolda::find($id);
        $polda = Polda::find($data->polda_id);
        // $tgl_limpah = Carbon::createFromFormat('d-m-Y', $request->tgl_limpah)->format('Y-m-d');
        $tgl_limpah = strtotime($request->tgl_limpah);
        $tgl_limpah = date('Y-m-d', $tgl_limpah);

        $data->update([
            'polda_id' => $polda->id,
            'tanggal_limpah' => $tgl_limpah,
            'hasil_tinjut_limpah' => $request->hasil_tinjut_polda,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function generateLimpahPolda($kasus_id)
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
        }

        // dd($request->all());
        // dd(!$data);

        if (!$data) {
            $disposisi_name = $request->tipe_disposisi == '1' ? 'disposisi-karo-sesro-paminal' : 'distribusi-kabag-binpam';
            if ($request->tipe_disposisi == '3') {
                if ($request->has('file')) {
                    $filename = time() . '-' . strtoupper($kasus->pelapor) . '-' . $disposisi_name . '.' . $request->file->extension();
                    $request->file->move(public_path('assets/dokumen/disposisi'), $filename);
                }
                $distribusi_binpam = DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->first();
                $data = DisposisiHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'no_agenda' => $request->nomor_agenda,
                    'tipe_disposisi' => $request->tipe_disposisi,
                    'limpah_unit' => $request->limpah_unit,
                    'limpah_den' => $distribusi_binpam->limpah_den,
                    'isi_disposisi' => $request->isi_disposisi,
                    'file' => $filename,
                ]);
            } else {
                if ($request->has('file')) {
                    $filename = time() . '-' . strtoupper($kasus->pelapor) . '-' . $disposisi_name . '.' . $request->file->extension();
                    $request->file->move(public_path('assets/dokumen/disposisi'), $filename);
                }
                $data = DisposisiHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'no_agenda' => $request->nomor_agenda,
                    'tipe_disposisi' => $request->tipe_disposisi,
                    'isi_disposisi' => $request->isi_disposisi,
                    'file' => $filename,
                ]);
            }
        } else {
            if ($data && $data->tipe_disposisi == 1) {
                $disposisi_name = 'disposisi-karo-sesro-paminal';
                $filename = time() . '-' . strtoupper($kasus->pelapor) . '-' . $disposisi_name . '.' . $request->file->extension();
                if ($request->has('limpah_den')) {
                    if ($request->has('file')) {
                        if (File::exists(public_path('assets/dokumen/disposisi/' . $data->file))) {
                            File::delete(public_path('assets/dokumen/disposisi/' . $data->file));
                        }

                        $request->file->move(public_path('assets/dokumen/disposisi'), $filename);
                        $data->update([
                            'limpah_den' => $request->limpah_den,
                            'isi_disposisi' => $request->isi_disposisi,
                            'file' => $filename,
                        ]);
                    } else {
                        $data->update([
                            'limpah_den' => $request->limpah_den,
                            'isi_disposisi' => $request->isi_disposisi,
                        ]);
                    }
                } else {
                    if ($request->has('file')) {
                        if (File::exists(public_path('assets/dokumen/disposisi/' . $data->file))) {
                            File::delete(public_path('assets/dokumen/disposisi/' . $data->file));
                        }

                        $request->file->move(public_path('assets/dokumen/disposisi'), $filename);

                        $data->update([
                            'isi_disposisi' => $request->isi_disposisi,
                            'file' => $filename,
                        ]);
                    } else {
                        $data->update([
                            'isi_disposisi' => $request->isi_disposisi,
                        ]);
                    }
                }
            }

            if ($data && $data->tipe_disposisi == 2) {
                if ($request->has('limpah_den')) {
                    if ($request->limpah_den == 7) {
                        $data->update([
                            'limpah_den' => $request->limpah_den,
                            'isi_disposisi' => $request->isi_disposisi,
                        ]);
                        $kasus->update([
                            'status_id' => 3
                        ]);

                        return redirect()->back()->with('message', 'DUMAS DILIMPAHKAN KE POLDA.');
                    }

                    $data->update([
                        'limpah_den' => $request->limpah_den,
                    ]);

                    return redirect()->back()->with("success", "LIMPAH BAG / DEN TELAH DITENTUKAN!");
                } else {
                    $disposisi_name = 'distribusi-kabag-binpam';
                    if ($request->has('file')) {
                        if (File::exists(public_path('assets/dokumen/disposisi/' . $data->file))) {
                            File::delete(public_path('assets/dokumen/disposisi/' . $data->file));
                        }

                        $filename = time() . '-' . strtoupper($kasus->pelapor) . '-' . $disposisi_name . '.' . $request->file->extension();
                        $request->file->move(public_path('assets/dokumen/disposisi'), $filename);

                        $data->update([
                            'isi_disposisi' => $request->isi_disposisi,
                            'file' => $filename,
                        ]);
                    } else {
                        $data->update([
                            'isi_disposisi' => $request->isi_disposisi,
                        ]);
                    }
                }
            }

            if ($data && $data->tipe_disposisi == 3 && !isset($data->limpah_unit)) {
                if ($request->has('limpah_unit')) {
                    $penyidik = DataAnggota::where('unit', (int)$request->limpah_unit)->get();
                    if (count($penyidik) < 1) {
                        return back()->withInput()->with("error", "ANGGOTA UNIT BELUM DIBUAT !");
                    }

                    $disposisi_name = 'disposisi-kaden';
                    if ($request->has('file')) {
                        if (File::exists(public_path('assets/dokumen/disposisi/' . $data->file))) {
                            File::delete(public_path('assets/dokumen/disposisi/' . $data->file));
                        }
                        $filename = time() . '-' . strtoupper($kasus->pelapor) . '-' . $disposisi_name . '.' . $request->file->extension();
                        $request->file->move(public_path('assets/dokumen/disposisi'), $filename);

                        $data->update([
                            'limpah_unit' => $request->limpah_unit,
                            'isi_disposisi' => $request->isi_disposisi,
                            'file' => $filename,
                        ]);
                    } else {
                        $data->update([
                            'limpah_unit' => $request->limpah_unit,
                            'isi_disposisi' => $request->isi_disposisi,
                        ]);
                    }

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
                    return redirect()->route('kasus.detail', ['id' => $kasus->id])->with("success", "LIMPAH UNIT TELAH DITENTUKAN !");
                }
            }

            if ($request->tipe_data && $request->tipe_data != '1') {
                DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 1)->update([
                    'no_agenda' => $request->nomor_agenda,
                ]);
                DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 2)->update([
                    'no_agenda' => $request->nomor_agenda,
                ]);
                DisposisiHistory::where('data_pelanggar_id', $kasus_id)->where('tipe_disposisi', 3)->update([
                    'no_agenda' => $request->nomor_agenda,
                    'tipe_disposisi' => $request->tipe_disposisi,
                ]);

                $bulan = $this->getRomawi(date('m'));
                if ($kasus->tipe_data == '2') {
                    $no_surat = 'R/Infosus-' . $request->nomor_agenda . '/' . $bulan . '/' . date('Y') . '/ROPAMINAL';
                } else {
                    $no_surat = 'R/LI-' . $request->nomor_agenda . '/' . $bulan . '/' . date('Y') . '/ROPAMINAL';
                }

                DataPelanggar::where('id', $kasus_id)->update([
                    'no_nota_dinas' => $no_surat,
                ]);
            }
        }

        return redirect()->route('kasus.detail', ['id' => $kasus->id])->with("success", "BERHASIL SIMPAN DATA !");
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

    public function downloadDisposisi($disposisi_id)
    {
        $disposisi = DisposisiHistory::find($disposisi_id);
        if (File::exists(public_path('assets/dokumen/disposisi/' . $disposisi->file))) {
            return response()->download(public_path('assets/dokumen/disposisi/' . $disposisi->file));
        } else {
            return redirect()->back()->with("error", "File doesn't exists !");
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
