<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\GelarPerkaraHistory;
use App\Models\LimpahPolda;
use App\Models\Process;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UukHistory;
use Illuminate\Http\Request;
use DataTables;

class KasusController extends Controller
{
    public function index()
    {
        $data['kasuss'] = DataPelanggar::all();

        return view('pages.data_pelanggaran.index', $data);
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

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process
        ];

        // if ($kasus->status_id == 3)
        // {

        // }

        return view('pages.data_pelanggaran.detail', $data);
    }

    public function updateData(Request $request)
    {
        // dd($request->all());
        if ($request->type_submit = 'update_status') return $this->updateStatus(($request));
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
        } return $this->limpahToPolda($request);
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

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process
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