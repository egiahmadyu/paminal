<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\JenisIdentitas;
use App\Models\JenisKelamin;
use App\Models\LimpahPolda;
use App\Models\Process;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UukHistory;
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
        // dd($data['k']);
        return view('pages.data_pelanggaran.index', $data);
    }

    public function inputKasus()
    {
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $data = [
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'jenis_kelamin' => $jenis_kelamin
        ];

        return view('pages.data_pelanggaran.input_kasus.input',$data);
    }

    public function storeKasus(Request $request)
    {
        $no_nota_dinas = "11/32/propam";
        $perihal_nota_dinas = "Penting";
        $wujud_perbuatan = "Kode Erik";
        $tgl_nota_dinas = Carbon::now();
        $no_pengaduan = "123456"; //generate otomatis
        // dd($request->all());
        $DP = DataPelanggar::create([
            'no_nota_dinas' => $no_nota_dinas,
            'no_pengaduan' => $no_pengaduan,
            'perihal_nota_dinas' => $perihal_nota_dinas,
            'wujud_perbuatan' => $wujud_perbuatan,
            'tanggal_nota_dinas' => $tgl_nota_dinas,
            'pelapor' => $request->pelapor,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_identitas' => $request->no_identitas,
            'no_telp' => '08212345678',
            'jenis_identitas' => $request->jenis_identitas,
            'kewarganegaraan' => 'WNI',
            'terlapor' => $request->terlapor,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'kesatuan' => $request->kesatuan,
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
            ->rawColumns(['no_nota_dinas'])
            ->make(true);
    }

    public function detail($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $agama = Agama::get();
        
        // dd($agama[0]->name);
        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
        ];

        // if ($kasus->status_id == 3)
        // {

        // }

        return view('pages.data_pelanggaran.detail', $data);
    }

    public function updateData(Request $request)
    {
        if ($request->type_submit === 'update_status') {
            return $this->updateStatus(($request));
        } 
        $data_pelanggar = DataPelanggar::where('id', $request->kasus_id)->first();
        $data_pelanggar->update([
            'pelapor' => $request->pelapor,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_identitas' => $request->no_identitas,
            'no_telp' => '08212345678',
            'jenis_identitas' => $request->jenis_identitas,
            'kewarganegaraan' => 'WNI',
            'terlapor' => $request->terlapor,
            'kesatuan' => $request->kesatuan,
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
            DataPelanggar::where('id', $request->kasus_id)
            ->update([
                'status_id' => $request->disposisi_tujuan
            ]);

            return redirect()->back();
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
        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sprin' => SprinHistory::where('data_pelanggar_id', $id)->first(),
            'ugp' => GelarPerkaraHistory::where('data_pelanggar_id', $id)->first()
        ];

        return view('pages.data_pelanggaran.proses.limpah-biro', $data);
    }

    private function viewGelarPenyelidikan($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sprin' => SprinHistory::where('data_pelanggar_id', $id)->first(),
            'ugp' => GelarPerkaraHistory::where('data_pelanggar_id', $id)->first()
        ];

        return view('pages.data_pelanggaran.proses.gelar_penyelidikan', $data);
    }

    private function viewLimpah($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process
        ];
        $data['limpahPolda'] = LimpahPolda::where('data_pelanggar_id', $id)->first();

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

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'jenis_kelamin' => $jenis_kelamin
        ];

        return view('pages.data_pelanggaran.proses.diterima', $data);
    }

    private function viewPulbaket($id)
    {
        $kasus = DataPelanggar::find($id);
        // $status = Process::find($kasus->status_id);
        // $process = Process::where('sort', '<=', $status->id)->get();

        $data = [
            'kasus' => $kasus,
            'sprin' => SprinHistory::where('data_pelanggar_id', $id)->first(),
            'uuk' => UukHistory::where('data_pelanggar_id', $id)->first(),
            'sp2hp_awal' => Sp2hp2Hisory::where('data_pelanggar_id', $id)->first(),
        ];
        return view('pages.data_pelanggaran.proses.pulbaket', $data);
    }
}