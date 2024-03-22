<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\Polda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception\InvalidOrderException;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'DASHBOARD';
        $data['poldas'] = Polda::get();
        $data['pelanggar'] = DataPelanggar::get();

        $from = Carbon::now()->firstOfMonth();
        $to = Carbon::now()->lastOfMonth();
        $data['dumas_bulanan'] = DataPelanggar::whereBetween('created_at', [$from, $to])->count();
        $data['dumas_terbukti'] = DataPelanggar::join('l_h_p_histories as lhp', 'lhp.data_pelanggar_id', '=', 'data_pelanggars.id')
            ->where('lhp.hasil_penyelidikan', 1)->count();

        $data['pengaduan_diproses'] = DataPelanggar::join('sprin_histories as sh', 'sh.data_pelanggar_id', '=', 'data_pelanggars.id')->count();
        $data['limpah_polda'] = DataPelanggar::join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
            ->where('lp.polda_id', 1)->count();

        $data['bid_binpam'] = Datasemen::select('name')->get()->toArray();
        array_push($data['bid_binpam'], ['name' => 'POLDA']);

        $data['pelimpahan'] = DataPelanggar::join('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
            ->where('dh.tipe_disposisi', 3)
            ->where('dh.limpah_den', 1)->count();

        return view('pages.dashboard.index', $data);
    }

    public function getDataChart($tipe, Request $request)
    {
        try {
            $data = null;
            if ($tipe == 'trend_dumas') {
                $data = $this->getTrendDumas();
            } elseif ($tipe == 'statistik_bulanan') {
                $data = $this->getStatistikBulanan();
            } elseif ($tipe == 'rekap_dumas') {
                $data = $this->DataTriwulanSemester($request->value);
            }

            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } catch (InvalidOrderException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getData($tipe, Request $request)
    {
        try {
            // $data = null;
            if ($tipe == 'status_dumas') {
                $data = $this->getStatusDumas($request->value);
            } elseif ($tipe == 'limpah_polda') {
                $data = $this->getLimpahPolda($request->value);
            } else {
                $data = $this->getLimpahDen($request->value);
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (InvalidOrderException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getLimpahDen($tipe)
    {
        try {
            $result = null;
            if ($tipe == 'POLDA') {
                $result = DataPelanggar::join('limpah_poldas', 'limpah_poldas.data_pelanggar_id', '=', 'data_pelanggars.id')->count();
            } else {
                $den = Datasemen::where('name', $tipe)->first();
                $result = DataPelanggar::join('disposisi_histories', 'disposisi_histories.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->where('disposisi_histories.tipe_disposisi', '=', 3)
                    ->where('disposisi_histories.limpah_den', '=', $den->id)
                    ->count();
            }

            return $result;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getLimpahPolda($tipe)
    {
        try {
            //code...
            $result = DataPelanggar::join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
                ->where('lp.polda_id', '=', $tipe)
                ->count();
            return $result;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getStatusDumas($tipe)
    {
        try {
            $data = null;
            if ($tipe == 'terbukti') {
                $data = DataPelanggar::join('l_h_p_histories', 'l_h_p_histories.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->where('l_h_p_histories.hasil_penyelidikan', '=', '1')
                    ->orderBy('data_pelanggars.id')
                    ->count();
            } elseif ($tipe == 'terbukti') {
                $data = DataPelanggar::join('l_h_p_histories', 'l_h_p_histories.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->where('l_h_p_histories.hasil_penyelidikan', '=', '2')
                    ->orderBy('data_pelanggars.id')
                    ->count();
            } elseif ($tipe == 'rj') {
                $data = DataPelanggar::where('status_id', 7)->count();
            } else {
                $data = DataPelanggar::join('sprin_histories as sh', 'sh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->whereBetween('data_pelanggars.status_id', [4, 5])
                    ->count();
            }
            return $data;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function DataTriwulanSemester($tipe)
    {
        Carbon::setLocale('id');
        $result = $this->getDataTriwulanSemester();

        return $result;
    }

    public function getTrendDumas()
    {
        try {
            for ($i = 1; $i < 13; $i++) {
                $awal = Carbon::now()->month($i)->firstOfMonth();
                $akhir = Carbon::now()->month($i)->lastOfMonth();
                $jumlah_etik = DB::table('data_pelanggars')
                    ->whereBetween('data_pelanggars.created_at', [$awal, $akhir])
                    ->where('wujud_perbuatans.jenis_wp', 'kode etik')
                    ->join('wujud_perbuatans', 'data_pelanggars.wujud_perbuatan', '=', 'wujud_perbuatans.id')
                    ->select('wujud_perbuatans.*')
                    ->count();
                $jumlah_etik = DB::table('data_pelanggars')
                    ->whereBetween('data_pelanggars.created_at', [$awal, $akhir])
                    ->where('wujud_perbuatans.jenis_wp', 'disiplin')
                    ->join('wujud_perbuatans', 'data_pelanggars.wujud_perbuatan', '=', 'wujud_perbuatans.id')
                    ->select('wujud_perbuatans.*')
                    ->count();
                $data['kode_etik'][$i] = $jumlah_etik;
                $data['disiplin'][$i] = $jumlah_etik;
            }

            return $data;
        } catch (InvalidOrderException $e) {
            $error = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $error;
        }
    }

    public function getStatistikBulanan()
    {
        try {
            $dumas = DataPelanggar::all();
            for ($i = 1; $i < 13; $i++) {
                $awal = Carbon::now()->month($i)->firstOfMonth();
                $akhir = Carbon::now()->month($i)->lastOfMonth();

                $diterima = $dumas->whereBetween('created_at', [$awal, $akhir])->where('status_id', 1)->count();
                $data['diterima'][$i] = $diterima;

                $diproses = DataPelanggar::join('sprin_histories as sh', 'sh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->whereBetween('sh.created_at', [$awal, $akhir])
                    ->whereBetween('data_pelanggars.status_id', [4, 5])
                    ->count();
                $data['diproses'][$i] = $diproses;

                $limpah_biro =  DataPelanggar::join('limpah_biro_histories as lbh', 'lbh.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->whereBetween('lbh.created_at', [$awal, $akhir])
                    ->where('data_pelanggars.status_id', 6)
                    ->count();
                $limpah_polda = DataPelanggar::join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->whereBetween('lp.created_at', [$awal, $akhir])
                    ->where('data_pelanggars.status_id', 3)
                    ->count();
                $rj = DataPelanggar::join('limpah_poldas as lp', 'lp.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->whereBetween('lp.created_at', [$awal, $akhir])
                    ->where('data_pelanggars.status_id', 7)
                    ->count();
                $data['selesai'][$i] = $limpah_biro + $limpah_polda + $rj;
            }

            return $data;
        } catch (InvalidOrderException $e) {
            $error = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $error;
        }
    }

    public function getDataTriwulanSemester()
    {
        // Triwullan
        $value = array_fill(1, 4, '');
        $label = array_fill(1, 4, '');
        $m_temp = 1;
        for ($i = 1; $i <= 4; $i++) {
            # code...
            $m = $i * 3;
            $from = Carbon::now()->month($m_temp)->firstOfMonth();
            $to = Carbon::now()->month($m)->lastOfMonth();
            $res = DataPelanggar::whereBetween('created_at', [$from, $to])->count();
            $value[$i] = $res;
            $label[$i] = 'T' . $i . ' : ' .  $from->isoFormat('MMMM') . ' - ' . $to->isoFormat('MMMM');
            $m_temp = $m + 1;
        }
        $tipe = 'triwulan';
        $triwulan = [$value, $label, $tipe];
        //End Triwulan

        //Semester
        $value = array_fill(1, 2, '');
        $label = array_fill(1, 2, '');
        $s_temp = 1;
        for ($i = 1; $i <= 2; $i++) {
            # code...
            $s = $i * 6;
            $from = Carbon::now()->month($s_temp)->firstOfMonth();
            $to = Carbon::now()->month($s)->lastOfMonth();
            $res = DataPelanggar::whereBetween('created_at', [$from, $to])->count();
            $value[$i] = $res;
            $label[$i] = 'S' . $i . ' : ' . $from->isoFormat('MMMM') . ' - ' . $to->isoFormat('MMMM');
            $s_temp = $s + 1;
        }
        $tipe = 'semester';
        $semester = [$value, $label, $tipe];
        // End Semester

        //Tahunan
        $value = array_fill(1, 12, '');
        $label = array_fill(1, 12, '');
        for ($i = 1; $i <= 12; $i++) {
            # code...
            $from = Carbon::now()->month($i)->firstOfMonth();
            $to = Carbon::now()->month($i)->lastOfMonth();
            $res = DataPelanggar::whereBetween('created_at', [$from, $to])->count();
            $value[$i] = $res;
            $label[$i] = Carbon::now()->month($i)->isoFormat('MMM');
        }
        $tipe = 'tahunan';
        $tahunan = [$value, $label, $tipe];
        //End Tahunan


        $result = [
            'triwulan' => $triwulan,
            'semester' => $semester,
            'tahunan' => $tahunan,
        ];
        return $result;
    }
}
