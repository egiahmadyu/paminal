<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\BaiPelapor;
use App\Models\BaiTerlapor;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\GelarPerkaraHistory;
use App\Models\JenisIdentitas;
use App\Models\JenisKelamin;
use App\Models\LHPHistory;
use App\Models\LimpahBiro;
use App\Models\LimpahBiroHistory;
use App\Models\LimpahPolda;
use App\Models\LitpersHistory;
use App\Models\NDHasilGelarPenyelidikanHistory;
use App\Models\NdPermohonanGelar;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\Process;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\Unit;
use App\Models\UukHistory;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class KasusController extends Controller
{
    public function index()
    {
        $data['kasuss'] = DataPelanggar::get();
        $data['diterima'] = $data['kasuss']->where('status_id',1);
        $data['diproses'] = $data['kasuss']->where('status_id','>',1)->where('status_id','<',6);
        $data['selesai'] = $data['kasuss']->where('status_id',6);

        return view('pages.data_pelanggaran.index', $data);
    }

    public function inputKasus()
    {
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();
        $polda = Polda::get();
        $wilayah_hukum = $polda;
        
        $i_dis = 0;
        $i_ke = 0;
        foreach ($wujud_perbuatan as $key => $value) {
            if ($value->jenis_wp == 'disiplin') {
                $disiplin[$i_dis] = $value->keterangan_wp;
                $id_disiplin[$i_dis] = $value->id;
                $i_dis++;
            } else {
                $kode_etik[$i_ke] = $value->keterangan_wp;
                $id_kode_etik[$i_ke] = $value->id;
                $i_ke++;
            }
        }

        $disiplin = implode('|',$disiplin);
        $id_disiplin = implode('|',$id_disiplin);
        $kode_etik = implode('|',$kode_etik);
        $id_kode_etik = implode('|',$id_kode_etik);

        // dd($id_kode_etik);

        $data = [
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'jenis_kelamin' => $jenis_kelamin,
            'pangkat' => $pangkat,
            'wujud_perbuatan' => $wujud_perbuatan,
            'disiplin' => $disiplin,
            'id_disiplin' => $id_disiplin,
            'kode_etik' => $kode_etik,
            'id_kode_etik' => $id_kode_etik,
            'wilayah_hukum' => $wilayah_hukum,
        ];

        return view('pages.data_pelanggaran.input_kasus.input',$data);
    }

    public function storeKasus(Request $request)
    {
        $wujud_perbuatan = WujudPerbuatan::where('jenis_wp',$request->jenis_wp)->where('keterangan_wp',$request->wujud_perbuatan)->first();
        $no_pengaduan = "123456"; //generate otomatis
        $DP = DataPelanggar::create([
            // Pelapor
            'no_nota_dinas' => $request->no_nota_dinas,
            'no_pengaduan' => $no_pengaduan,
            'perihal_nota_dinas' => $request->perihal_nota_dinas,
            'wujud_perbuatan' => $request->wujud_perbuatan,
            'tanggal_nota_dinas' => Carbon::create($request->tanggal_nota_dinas)->format('Y-m-d'),
            'pelapor' => $request->pelapor,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_identitas' => $request->no_identitas,
            'no_telp' => $request->no_telp,
            'jenis_identitas' => $request->jenis_identitas,
            //Terlapor
            'terlapor' => $request->terlapor,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'kesatuan' => $request->kesatuan,
            'wilayah_hukum' => $request->wilayah_hukum,
            'tempat_kejadian' => $request->tempat_kejadian,
            'tanggal_kejadian' => Carbon::create($request->tanggal_kejadian)->format('Y-m-d'),
            'kronologi' => $request->kronologis,
            'pangkat' => $request->pangkat,
            'nama_korban' => $request->nama_korban,
            'status_id' => 1
        ]);
        return redirect()->route('kasus.detail',['id'=>$DP->id]);
    }

    public function data(Request $request)
    {
        $query = DataPelanggar::orderBy('id', 'desc')->with('status');

        return Datatables::of($query)
            ->editColumn('no_nota_dinas', function($query) {
                // return $query->no_nota_dinas;
                return '<a href="/data-kasus/detail/'.$query->id.'">'.$query->no_nota_dinas.'</a>';
            })
            ->addColumn('pangkat', function($query) {
                $pangkat = Pangkat::where('id',$query->pangkat)->first();
                $pangkat = $pangkat->name;

                return $pangkat;
            })
            ->rawColumns(['no_nota_dinas'])
            ->make(true);
    }

    public function detail($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $agama = Agama::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'agama' => $agama,
            'pangkat' => $pangkat,
            'wujud_perbuatan' => $wujud_perbuatan,
        ];

        return view('pages.data_pelanggaran.detail', $data);
    }

    public function updateData(Request $request)
    {
        if ($request->type_submit === 'update_status') {
            return $this->updateStatus(($request));
        }
        $no_pengaduan = "123456"; //generate otomatis
        $data_pelanggar = DataPelanggar::where('id', $request->kasus_id)->first();
        $data_pelanggar->update([
            'no_nota_dinas' => $request->no_nota_dinas,
            'no_pengaduan' => $no_pengaduan,
            'perihal_nota_dinas' => $request->perihal_nota_dinas,
            'wujud_perbuatan' => $request->wujud_perbuatan,
            'tanggal_nota_dinas' => Carbon::create($request->tanggal_nota_dinas)->format('Y-m-d'),
            'pelapor' => $request->pelapor,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_identitas' => $request->no_identitas,
            'jenis_identitas' => $request->jenis_identitas,
            'terlapor' => $request->terlapor,
            'pangkat' => $request->pangkat,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'kesatuan' => $request->kesatuan,
            'wilayah_hukum' => $request->wilayah_hukum,
            'tempat_kejadian' => $request->tempat_kejadian,
            'tanggal_kejadian' => Carbon::create($request->tanggal_kejadian)->format('Y-m-d'),
            'kronologi' => $request->kronologis,
            'pangkat' => $request->pangkat,
            'nama_korban' => $request->nama_korban,
        ]);
        return redirect()->back();

    }

    public function updateStatus(Request $request)
    {
        if ($request->disposisi_tujuan != 3)
        {
            $data = DataPelanggar::where('id', $request->kasus_id)->first();
            $disposisi = DisposisiHistory::where('data_pelanggar_id',$data->id)->where('tipe_disposisi',3)->first();
            if ($disposisi && isset($disposisi->limpah_unit)) {
                $data->update([
                    'status_id' => $request->disposisi_tujuan
                ]);
    
                return redirect()->back();
            } elseif ($disposisi && !isset($disposisi->limpah_unit)) {
                return redirect()->route('kasus.detail',['id'=>$data->id])->with('error','Limpah Unit (Penyelidik) belum ditentukan');
            } {
                return redirect()->route('kasus.detail',['id'=>$data->id])->with('error','Disposisi Ka. Den A belum dibuat');
            }
        } 
        return $this->limpahToPolda($request);
    }

    public function viewProcess($kasus_id,$status_id)
    {
        if ($status_id == 1) return $this->viewDiterima($kasus_id);
        elseif ($status_id == 2) return $this->viewDisposisi($kasus_id);
        elseif ($status_id == 3) return $this->viewLimpah($kasus_id);
        elseif ($status_id == 4) return $this->viewPulbaket($kasus_id);
        elseif ($status_id == 5) return $this->viewGelarPenyelidikan($kasus_id);
        elseif ($status_id == 6) return $this->viewLimpahBiro($kasus_id);
    }

    private function viewLimpahBiro($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $polda = Polda::get();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

        $pangkat = Pangkat::get();
        $pangkat_terlapor = Pangkat::where('id',$kasus->pangkat)->first();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        $den = Datasemen::where('id',$disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id',$disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id',$kasus->id)->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id',$value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $pangkat_pimpinan_gelar = Pangkat::where('id',$gelar_perkara->pangkat_pimpinan)->first();

        $limpah_biro = LimpahBiro::where('data_pelanggar_id', $id)->first();
        if ($limpah_biro->jenis_limpah == 1) {
            $jenis_limpah = "ROPROVOS";
        } elseif ($limpah_biro->jenis_limpah == 2) {
            $jenis_limpah = "ROWABPROF";
        } else {
            $jenis_limpah = "BID PROPAM POLDA";
        }

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'limpah_biro' => $limpah_biro,
            'ugp' => $gelar_perkara,
            'polda' => $polda,
            'usia_dumas' => $usia_dumas.' hari',
            'terlapor' => $pangkat_terlapor->name.' '. $kasus->terlapor,
            'sprin' => $sprin,
            'unit' => $unit,
            'penyidik' => $penyidik,
            'gelar_perkara' => $gelar_perkara,
            'pimpinan_gelar' => $pangkat_pimpinan_gelar->name.' '. $gelar_perkara->pimpinan.' / '.$gelar_perkara->nrp_pimpinan,
            'jenis_limpah' => $jenis_limpah,
        ];

        return view('pages.data_pelanggaran.proses.limpah-biro', $data);
    }

    private function viewGelarPenyelidikan($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);

        $ndPG = NdPermohonanGelar::where('data_pelanggar_id', $id)->first();
        $bulan_romawi_ndPG = $this->getRomawi(Carbon::parse($ndPG->created_at)->translatedFormat('m'));

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        $den = Datasemen::where('id',$disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id',$disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id',$kasus->id)->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id',$value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $pangkat = Pangkat::get();
        $pangkat_terlapor = Pangkat::where('id',$kasus->pangkat)->first();
        
        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);
        
        $lhp = LHPHistory::where('data_pelanggar_id',$kasus->id)->first();
        $bai_pelapor = BaiPelapor::where('data_pelanggar_id',$kasus->id)->first();
        $bai_terlapor = BaiTerlapor::where('data_pelanggar_id',$kasus->id)->first();
        $ugp = GelarPerkaraHistory::where('data_pelanggar_id', $id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->first();
        $litpers = LitpersHistory::where('data_pelanggar_id', $id)->first();
        $sp2hp2_akhir = Sp2hp2Hisory::where('data_pelanggar_id', $id)->where('tipe','akhir')->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $id)->first();
        $pangkat_pimpinan_gelar = isset($gelar_perkara) ? Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first() : '';
        
        $limpah_biro = LimpahBiro::where('data_pelanggar_id', $id)->first();

        if (isset($limpah_biro)) {
            if ($limpah_biro->jenis_limpah == 1) {
                $limpah_biro = "ROPROVOS";
            } elseif ($limpah_biro->jenis_limpah == 2) {
                $limpah_biro = "ROWABPROF";
            } else {
                $limpah_biro = "BID PROPAM POLDA";
            }
        }
        

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sprin' => $sprin,
            'ugp' => $ugp,
            'ndPG' => $ndPG,
            'litpers' => $litpers,
            'sp2hp2_akhir' => $sp2hp2_akhir,
            'lhp' => $lhp,
            'bulan_romawi_ndPG' => $bulan_romawi_ndPG,
            'gelar_perkara' => $gelar_perkara,
            'pangkat_pimpinan_gelar' => isset($gelar_perkara) ? $pangkat_pimpinan_gelar->name : '',
            'limpah_biro' => isset($limpah_biro) ? $limpah_biro : '',
            'ndHGP' => NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $id)->first(),
            'unit' => $unit,
            'penyidik' => $penyidik,
            'pangkat' => $pangkat,
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name.' '. $kasus->terlapor,
            'tgl_bai_pelapor' => Carbon::parse($bai_pelapor->created_at)->translatedFormat('d F Y'),
            'tgl_bai_terlapor' => Carbon::parse($bai_terlapor->created_at)->translatedFormat('d F Y'),
            'tgl_nd_pg' => Carbon::parse($ndPG->created_at)->translatedFormat('d F Y'),
            'hasil_lhp' => $lhp->hasil_penyelidikan == 1 ? 'Ditemukan Cukup Bukti' : 'Belum Ditemukan cukup bukti',
            'tgl_ugp' => isset($ugp) ? Carbon::parse($ugp->tanggal)->translatedFormat('d F Y') : '',
        ];

        return view('pages.data_pelanggaran.proses.gelar_penyelidikan', $data);
    }

    private function viewLimpah($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now();
        $usia_dumas = $tgl_dumas->diffInDays($today);
        $limpahPolda = LimpahPolda::where('data_pelanggar_id', $id)->first();

        $polda = Polda::get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'usia_dumas' => $usia_dumas,
            'polda' => $polda,
            'limpahPolda' => $limpahPolda,
            'tgl_limpah' => Carbon::parse($limpahPolda->tanggal_limpah)->translatedFormat('d F Y'),
        ];

        return view('pages.data_pelanggaran.proses.limpah_polda', $data);
    }

    private function limpahToPolda(Request $request)
    {
        // dd(auth()->user()->id);
        $data = DataPelanggar::find($request->kasus_id);
        $limpah = LimpahPolda::create([
            'data_pelanggar_id' => $request->kasus_id,
            'polda_id' => $request->polda,
            'tanggal_limpah' => date('Y-m-d'),
            'created_by' => auth()->user()->id,
            'isi_surat' => '<ol><li>Rujukan :&nbsp;<br><b>a</b>.&nbsp;Undang-Undang Nomor 2 Tahun 2022 tentang Kepolisian Negara Republik Indonesia.<br><b>b</b>.&nbsp;Peraturan Kepolisian Negara Republik Indonesia Nomor 7 Tahun 2022 tentang Kode Etik Profesi&nbsp; &nbsp; &nbsp;dan Komisi Kode Etik Polri.<br><b>c</b>.&nbsp;Peraturan Kepala Kepolisian Negara Republik Indonesia Nomor 13 Tahun 2016 tentang Pengamanan Internal di Lingkungan Polri<br><b>d</b>.&nbsp;Nota Dinas Kepala Bagian Pelayanan Pengaduan Divpropam Polri Nomor: R/ND-2766-b/XII/WAS.2.4/2022/Divpropam tanggal 16 Desember 2022 perihal pelimpahan Dumas BRIPKA JAMALUDDIN ASYARI.</li></ol>'
        ]);
         if ($limpah)
         {
            $data->status_id = $request->disposisi_tujuan;
            $data->save();
         }

         return redirect()->back();
    }

    private function viewDisposisi($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process
        ];

        return view('pages.data_pelanggaran.proses.disposisi', $data);
    }

    private function viewDiterima($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();
        $disposisi[0] = DisposisiHistory::where('data_pelanggar_id',$kasus->id)->where('tipe_disposisi',1)->first();
        $disposisi[1] = DisposisiHistory::where('data_pelanggar_id',$kasus->id)->where('tipe_disposisi',2)->first();
        $disposisi[2] = DisposisiHistory::where('data_pelanggar_id',$kasus->id)->where('tipe_disposisi',3)->first();

        $disposisi_kadena = DisposisiHistory::where('data_pelanggar_id',$kasus->id)->where('tipe_disposisi',3)->first();
        
        $tim_disposisi = Datasemen::get();
        $unit = $disposisi[1] ?  Unit::where('datasemen',$disposisi[1]['limpah_den'])->get() : array();

        $polda = Polda::get();
        $wilayah_hukum = $polda;

        $i_dis = 0;
        $i_ke = 0;
        foreach ($wujud_perbuatan as $key => $value) {
            if ($value->jenis_wp == 'disiplin') {
                $disiplin[$i_dis] = $value->keterangan_wp;
                $id_disiplin[$i_dis] = $value->id;
                $i_dis++;
            } else {
                $kode_etik[$i_ke] = $value->keterangan_wp;
                $id_kode_etik[$i_ke] = $value->id;
                $i_ke++;
            }
        }

        $disiplin = implode('|',$disiplin);
        $id_disiplin = implode('|',$id_disiplin);
        $kode_etik = implode('|',$kode_etik);
        $id_kode_etik = implode('|',$id_kode_etik);

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'jenis_kelamin' => $jenis_kelamin,
            'pangkat' => $pangkat,
            'wujud_perbuatan' => $wujud_perbuatan,
            'disiplin' => $disiplin,
            'id_disiplin' => $id_disiplin,
            'kode_etik' => $kode_etik,
            'id_kode_etik' => $id_kode_etik,
            'disposisi' => $disposisi,
            'disposisi_kadena' => $disposisi_kadena,
            'wilayah_hukum' => $wilayah_hukum,
            'tim_disposisi' => $tim_disposisi,
            'unit' => $unit,
        ];

        return view('pages.data_pelanggaran.proses.diterima', $data);
    }

    private function viewPulbaket($id)
    {
        $kasus = DataPelanggar::find($id);
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',3)->first();
        $den = Datasemen::where('id',$disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id',$disposisi->limpah_unit)->first()->unit;
        
        $pangkat_terlapor = Pangkat::where('id',$kasus->pangkat)->first();

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id',$kasus->id)->get();
        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id',$value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();
        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi',1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $data = [
            'kasus' => $kasus,
            'sprin' => SprinHistory::where('data_pelanggar_id', $id)->first(),
            'uuk' => UukHistory::where('data_pelanggar_id', $id)->first(),
            'sp2hp_awal' => Sp2hp2Hisory::where('data_pelanggar_id', $id)->first(),
            'penyidik' => $penyidik,
            'unit' => $unit,
            'den' => $den,
            'lhp' => $lhp,
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name.' '. $kasus->terlapor,
        ];
        return view('pages.data_pelanggaran.proses.pulbaket', $data);
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