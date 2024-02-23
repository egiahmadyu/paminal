<?php

namespace App\Http\Controllers;

use App\Enums\StatusDumas;
use App\Models\Agama;
use App\Models\BaiPelapor;
use App\Models\BaiTerlapor;
use App\Models\DataAnggota;
use App\Models\DataPelanggar;
use App\Models\Datasemen;
use App\Models\DisposisiHistory;
use App\Models\DPExtends;
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
use App\Models\Saksi;
use App\Models\Sp2hp2Hisory;
use App\Models\SprinHistory;
use App\Models\UndanganKlarifikasiHistory;
use App\Models\Unit;
use App\Models\UukHistory;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\HelperController;

use function PHPUnit\Framework\countOf;
use function PHPUnit\Framework\isNull;

class KasusController extends Controller
{
    public function index()
    {
        $data['user'] = Auth::getUser();
        $data['title'] = 'LIST DATA DUMAS';
        $data['kasuss'] = DataPelanggar::get();
        $data['diterima'] = $data['kasuss']->where('status_id', 1);
        $data['diproses'] = DataPelanggar::join('sprin_histories as sh', 'sh.data_pelanggar_id', '=', 'data_pelanggars.id')
            ->whereBetween('data_pelanggars.status_id', [4, 5])->get();
        $data['selesai'] = DataPelanggar::where('status_id', 6)->orwhere('status_id', 3)->orwhere('status_id', 7)->get();
        $data['poldas'] = Polda::all();

        if ($data['user']->hasRole('operator') || $data['user']->hasRole('admin')) {
            $data['diterima_urtu'] = $data['diterima'];
            $data['disposisi_binpam'] = DataPelanggar::leftJoin('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                ->select('data_pelanggars.id')
                ->where('dh.tipe_disposisi', 1)
                ->where('status_id', 1)->count();
        }

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

        $disiplin = implode('|', $disiplin);
        $id_disiplin = implode('|', $id_disiplin);
        $kode_etik = implode('|', $kode_etik);
        $id_kode_etik = implode('|', $id_kode_etik);

        $bag_den = Datasemen::get();
        $unit_bag_den = Unit::get();
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
            'bag_den' => $bag_den,
            'unit_bag_den' => $unit_bag_den,
            'title' => 'INPUT DUMAS',
        ];

        return view('pages.data_pelanggaran.input_kasus.input', $data);
    }

    public function storeKasus(Request $request)
    {
        try {
            $wujud_perbuatan = WujudPerbuatan::where('jenis_wp', $request->jenis_wp)->where('keterangan_wp', $request->wujud_perbuatan)->first();
            $no_pengaduan = null; //generate otomatis

            if ($request->tipe_data != 1) {

                $penyidik = DataAnggota::where('unit', (int)$request->unit_den_bag)->get();
                if (count($penyidik) < 1) {
                    return back()->withInput()->with('error', 'Anggota Unit belum dibuat !');
                }

                $kronologis = [
                    'kronologis' => $request->kronologis,
                    'catatan' => $request->catatan,
                ];

                $kronologis = json_encode($kronologis);


                $DP = DataPelanggar::create([
                    // Pelapor
                    'no_nota_dinas' => $request->no_nota_dinas,
                    'no_pengaduan' => $no_pengaduan,
                    'perihal_nota_dinas' => $request->perihal,
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
                    'kronologi' => $kronologis,
                    'pangkat' => $request->pangkat,
                    'nama_korban' => $request->nama_korban,
                    'status_id' => 1,
                    'tipe_data' => $request->tipe_data,
                ]);

                foreach ($request->kronologis as $key => $valKrono) {
                    DPExtends::create([
                        'data_pelanggar_id' => $DP->id,
                        'deskripsi' => $valKrono,
                        'tipe' => 'kronologis'
                    ]);
                }

                foreach ($request->catatan as $key => $valCatatan) {
                    DPExtends::create([
                        'data_pelanggar_id' => $DP->id,
                        'deskripsi' => $valCatatan,
                        'tipe' => 'catatan'
                    ]);
                }

                DisposisiHistory::create([
                    'data_pelanggar_id' => $DP->id,
                    'tipe_disposisi' => 1,
                ]);


                DisposisiHistory::create([
                    'data_pelanggar_id' => $DP->id,
                    'tipe_disposisi' => 2,
                    'limpah_den' => $request->den_bag,
                ]);

                DisposisiHistory::create([
                    'data_pelanggar_id' => $DP->id,
                    'tipe_disposisi' => 3,
                    'limpah_den' => $request->den_bag,
                    'limpah_unit' => $request->unit_den_bag,
                ]);

                // Create katim
                $datasemen = Datasemen::where('id', (int)$request->den_bag)->first();
                $pimpinans = DataAnggota::where('id', $datasemen->kaden)->orWhere('id', $datasemen->wakaden)->get();
                foreach ($pimpinans as $key => $pimpinan) {
                    Penyidik::create([
                        'data_pelanggar_id' => $DP->id,
                        'name' => $pimpinan->nama,
                        'nrp' => $pimpinan->nrp,
                        'pangkat' => $pimpinan->pangkat,
                        'jabatan' => $pimpinan->jabatan,
                        'datasemen' => $pimpinan->datasemen,
                        'unit' => '',
                    ]);
                }

                foreach ($penyidik as $key => $value) {
                    Penyidik::create([
                        'data_pelanggar_id' => $DP->id,
                        'name' => $value->nama,
                        'nrp' => $value->nrp,
                        'pangkat' => $value->pangkat,
                        'jabatan' => $value->jabatan,
                        'datasemen' => $value->datasemen,
                        'unit' => $value->unit,
                    ]);
                }
            } else {
                $DP = DataPelanggar::create([
                    // Pelapor
                    'no_nota_dinas' => $request->no_nota_dinas,
                    'no_pengaduan' => $no_pengaduan,
                    'perihal_nota_dinas' => $request->perihal,
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
                    'kronologi' => $request->kronologis[0],
                    'pangkat' => $request->pangkat,
                    'nama_korban' => $request->nama_korban,
                    'status_id' => 1,
                    'tipe_data' => $request->tipe_data,
                ]);
            }

            return redirect()->route('kasus.detail', ['id' => $DP->id]);
        } catch (\Exception $e) {
            //throw $th;
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function data(Request $request)
    {
        // dd($request->filter['diterima']);
        $user = Auth::getUser();
        $role = $user->roles->first();

        if ($role->name == 'admin' || $role->name == 'operator') {
            // filter
            $query = DataPelanggar::with('status');
            if ($request->has('filter')) {
                $query = HelperController::dataFilter($query, $request->filter);
            }
        } elseif (!$user->unit && !$user->datasemen) {
            $query = DataPelanggar::orderBy('created_at', 'asc')->with('status');
            if ($request->has('filter')) {
                $query = HelperController::dataFilter($query, $request->filter);
            }
        } elseif (!$user->unit && $user->datasemen) {
            $query = DataPelanggar::leftJoin('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                ->select('data_pelanggars.*')
                ->where('dh.limpah_den', $user->datasemen)
                ->where('dh.tipe_disposisi', '=', 3)
                ->orderBy('data_pelanggars.created_at', 'asc')->with('status');
            if ($request->has('filter')) {
                $query = HelperController::dataFilter($query, $request->filter);
            }
        } else {
            $query = DataPelanggar::leftJoin('disposisi_histories as dh', 'dh.data_pelanggar_id', '=', 'data_pelanggars.id')
                ->select('data_pelanggars.*')
                ->where('dh.limpah_unit', '=', $user->unit)
                ->where('dh.limpah_den', $user->datasemen)
                ->where('dh.tipe_disposisi', '=', 3)
                ->orderBy('data_pelanggars.created_at', 'asc')->with('status');
            if ($request->has('filter')) {
                $query = HelperController::dataFilter($query, $request->filter);
            }
        }

        if ($role->name == 'min') {
            if ($user->hasDatasemen->name == 'BAGBINPAM') {
                $query = DataPelanggar::leftJoin('disposisi_histories as dhf', 'dhf.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->select('data_pelanggars.*')
                    ->where('dhf.tipe_disposisi', 1)
                    ->orderBy('data_pelanggars.created_at', 'asc')->with('status');
            } else {
                $query = DataPelanggar::leftJoin('disposisi_histories as dhf', 'dhf.data_pelanggar_id', '=', 'data_pelanggars.id')
                    ->select('data_pelanggars.*')
                    ->where('dhf.tipe_disposisi', 2)
                    ->where('dhf.limpah_den', $user->datasemen)
                    ->orderBy('data_pelanggars.created_at', 'asc')->with('status');
            }
        }

        $table = DataTables::of($query->get())
            ->editColumn('no_nota_dinas', function ($query) {
                // return $query->no_nota_dinas;
                if (is_null($query->no_nota_dinas)) return '<a href="/data-kasus/detail/' . $query->id . '">Edit Data</a>';
                return '<a href="/data-kasus/detail/' . $query->id . '" class="text-dark">' . $query->no_nota_dinas . '</a>';
            })
            ->editColumn('created_at', function ($query) {
                $created_at = Carbon::parse($query->created_at)->translatedFormat('Y/m/d');

                return $created_at;
            })
            ->addColumn('pangkat', function ($query) {
                $pangkat = Pangkat::where('id', $query->pangkat)->first();
                if (!$pangkat) return '';
                $pangkat = $pangkat->name;

                return $pangkat;
            })
            ->setRowAttr([
                'style' => function ($data) {
                    $disposisi = DisposisiHistory::where('data_pelanggar_id', $data->id);
                    $disposisi_exists = (clone $disposisi)->exists();
                    // $disposisi_binpam = (clone $disposisi)->where('limpah_unit', null)->where('limpah_den', null)->first();
                    // $disposisi_bagden = (clone $disposisi)->where('limpah_unit', null)->where('limpah_den', '>', 0)->first();
                    // $disposisi_unit = (clone $disposisi)->where('limpah_unit', '>', 0)->where('limpah_den', '>', 0)->first();

                    $disposisi_binpam = (clone $disposisi)->where('tipe_disposisi', 1)->first();
                    $disposisi_bagden = (clone $disposisi)->where('tipe_disposisi', 2)->first();
                    $disposisi_unit = (clone $disposisi)->where('tipe_disposisi', 3)->first();

                    if ($disposisi_binpam) {
                        $color = 'background-color: #66ABC5;';
                    }
                    if ($disposisi_bagden) {
                        $color = 'background-color: #fcad03;';
                    }
                    if ($disposisi_unit) {
                        $color = 'background-color: #027afa;';
                    }

                    if ($data->status->id == StatusDumas::DiprosesPolda) {
                        $color = 'background-color: #61fa61;color:black';
                    }
                    if ($data->status->id == StatusDumas::RestorativeJustice) {
                        $color = 'background-color: #c5c7c5;color:black';
                    }
                    if ($data->status->id == StatusDumas::SelesaiTidakBenar) {
                        $color = 'background-color: #c90e0e;color:white';
                    }
                    if ($data->status->id == StatusDumas::LimpahBiro) {
                        $color = 'background-color: #B8BE25';
                    }


                    return $disposisi_exists ? $color : '';
                }
            ])
            ->rawColumns(['no_nota_dinas', 'created_at']);

        return $table->make(true);
    }

    public function detail($id)
    {

        $id_pimpinan = ['1', '2', '3', '4', '5'];
        $pimpinan = DataAnggota::whereIn('pangkat', $id_pimpinan)->get();

        $kasus = DataPelanggar::find($id);
        $saksis = Saksi::where('data_pelanggar_id', $kasus->id)->get();
        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();

        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $agama = Agama::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();
        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();
        $nd_hasil_gelar = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus->id)->first();

        $disposisi[0] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $disposisi[1] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 2)->first();
        $disposisi[2] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'agama' => $agama,
            'pangkat' => $pangkat,
            'wujud_perbuatan' => $wujud_perbuatan,
            'pimpinan' => $pimpinan,
            'lhp' => $lhp ?? '',
            'saksis' => $saksis,
            'disposisi' => $disposisi,
            'nd_hasil_gelar' => $nd_hasil_gelar ?? '',
            'title' => 'DETAIL DATA PELANGGAR',
        ];

        return view('pages.data_pelanggaran.detail', $data);
    }

    public function updateData(Request $request)
    {
        if ($request->type_submit === 'update_status') {
            return $this->updateStatus(($request));
        }

        $rules = [
            'perihal' => 'required|regex:/[a-zA-Z 0-9\!@$%\*\(\)_=\?;\':\[\]\",.]/',
            'pelapor' => 'required|regex:/[a-zA-Z 0-9\!@$%\*\(\)_=\?;\':\[\]\",.]/',
            'alamat' => 'required|regex:/[a-zA-Z 0-9\!@$%\*\(\)_=\?;\':\[\]\",.]/',

        ];

        $messages = [
            'perihal.regex' => 'spesial karakter (&) tidak diizinkan pada field input perihal !',
            'pelapor.regex' => 'spesial karakter (&) tidak diizinkan pada field input pelapor !',
            'alamat.regex' => 'spesial karakter (&) tidak diizinkan pada field input alamat !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', strtoupper($validator->messages()));
            // return redirect()->back()->withInput()->withErrors($validator)->with('error', strtoupper($validator->messages()));
        }

        $no_pengaduan = "123456"; //generate otomatis
        $data_pelanggar = DataPelanggar::where('id', $request->kasus_id)->first();
        $data_pelanggar->update([
            'no_nota_dinas' => $request->no_nota_dinas,
            'no_pengaduan' => $no_pengaduan,
            'perihal_nota_dinas' => $request->perihal,
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
            'terlapor' => $request->terlapor,
            'pangkat' => $request->pangkat,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'kesatuan' => $request->kesatuan,
            'wilayah_hukum' => $request->wilayah_hukum,
            'tempat_kejadian' => $request->tempat_kejadian,
            'tanggal_kejadian' => Carbon::create($request->tanggal_kejadian)->format('Y-m-d'),
            'kronologi' => $request->kronologis[0],
            'pangkat' => $request->pangkat,
            'nama_korban' => $request->nama_korban,
        ]);
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $data = DataPelanggar::where('id', $request->kasus_id)->first();

        if ($data->tipe_data != 1) {
            $data->update([
                'status_id' => 4
            ]);

            return redirect()->back();
        } else {
            if ($request->disposisi_tujuan != 3) {
                $disposisi = DisposisiHistory::where('data_pelanggar_id', $data->id)->where('tipe_disposisi', 3)->first();

                if ($disposisi && isset($disposisi->limpah_unit)) {
                    if ($request->disposisi_tujuan == 5) {
                        $pulbaket[0] = UndanganKlarifikasiHistory::where('data_pelanggar_id', $data->id)->where('jenis_undangan', 1)->first();
                        $pulbaket[1] = UndanganKlarifikasiHistory::where('data_pelanggar_id', $data->id)->where('jenis_undangan', 2)->first();
                        $pulbaket[2] = BaiPelapor::where('data_pelanggar_id', $data->id)->first();
                        $pulbaket[3] = BaiTerlapor::where('data_pelanggar_id', $data->id)->first();
                        $pulbaket[4] = LHPHistory::where('data_pelanggar_id', $data->id)->first();
                        $pulbaket[5] = NdPermohonanGelar::where('data_pelanggar_id', $data->id)->first();

                        $keyPulbaket = ['UNDANGAN KLARIFIKASI PELAPOR', 'UNDANGAN KLARIFIKASI TERLAPOR', 'BAI PELAPOR', 'BAI TERLAPOR', 'LAPORAN HASIL PENYELIDIKAN', 'NOTA DINAS PERMOHONAN GELAR PERKARA'];
                        foreach ($pulbaket as $key => $value) {
                            if (!$value) {
                                return redirect()->route('kasus.detail', ['id' => $data->id])->with('error', $keyPulbaket[$key] . ' BELUM DIBUAT');
                            }
                        }
                    } elseif ($request->disposisi_tujuan == 6) {
                        $pulbaket[0] = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $data->id)->first();
                        $pulbaket[1] = Sp2hp2Hisory::where('data_pelanggar_id', $data->id)->where('tipe', 'akhir')->first();
                        $pulbaket[2] = LitpersHistory::where('data_pelanggar_id', $data->id)->first();

                        $keyPulbaket = ['NOTA DINAS HASIL GELAR PERKARA', 'SP2HP2 AKHIR', 'NOTA DINAS KA. LITPERS'];
                        foreach ($pulbaket as $key => $value) {
                            if (!$value) {
                                return redirect()->route('kasus.detail', ['id' => $data->id])->with('error', $keyPulbaket[$key] . ' BELUM DIBUAT');
                            }
                        }
                    }

                    $data->update([
                        'status_id' => $request->disposisi_tujuan
                    ]);

                    return redirect()->back();
                } elseif ($disposisi && !isset($disposisi->limpah_unit)) {
                    return redirect()->route('kasus.detail', ['id' => $data->id])->with('error', 'Limpah Unit (Penyelidik) belum ditentukan');
                } {
                    return redirect()->route('kasus.detail', ['id' => $data->id])->with('error', 'Disposisi Ka. Den A belum dibuat');
                }
            }

            return $this->limpahToPolda($request);
        }
    }

    public function viewProcess($kasus_id, $status_id)
    {
        if ($status_id == 1) return $this->viewDiterima($kasus_id);
        elseif ($status_id == 2) return $this->viewDisposisi($kasus_id);
        elseif ($status_id == 3) return $this->viewLimpah($kasus_id);
        elseif ($status_id == 4) return $this->viewPulbaket($kasus_id);
        elseif ($status_id == 5) return $this->viewGelarPenyelidikan($kasus_id);
        elseif ($status_id == 6) return $this->viewLimpahBiro($kasus_id);
        elseif ($status_id == 7) return $this->viewRJ($kasus_id);
        elseif ($status_id == 8) return $this->viewSelesaiTidakBenar($kasus_id);
        elseif ($status_id == 9) return $this->viewDiprosesPolda($kasus_id);
    }

    public function selesaiTidakBenar($id)
    {
        $data_pelanggar = DataPelanggar::where('id', $id)->first();
        $data_pelanggar->update([
            'status_id' => StatusDumas::SelesaiTidakBenar
        ]);

        return response()->json([
            'status' => JsonResponse::HTTP_OK,
            'message' => 'DUMAS DISELESAIKAN DENGAN STATUS "SELESAI TIDAK BENAR".',
        ]);
    }

    public function viewSelesaiTidakBenar($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $status = Process::find($kasus->status_id);
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'terlapor' => $pangkat_terlapor ? $pangkat_terlapor->name . ' ' . $kasus->terlapor : 'TIDAK TAHU',
            'title' => 'DUMAS SELESAI TIDAK BENAR',
        ];

        return view('pages.data_pelanggaran.proses.selesai-tidak-benar', $data);
    }

    public function RJ($kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $kasus->update([
            'status_id' => 7
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'DUMAS DIHENTIKAN DENGAN STATUS RJ'
        ]);
    }

    private function viewRJ($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $polda = Polda::get();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

        $pangkat = Pangkat::get();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();

        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $pangkat_pimpinan_gelar = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();

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
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name . ' ' . $kasus->terlapor,
            'sprin' => $sprin,
            'unit' => $unit,
            'den' => $den,
            'penyidik' => $penyidik,
            'gelar_perkara' => $gelar_perkara,
            'pimpinan_gelar' => $pangkat_pimpinan_gelar->name . ' ' . $gelar_perkara->pimpinan . ' / ' . $gelar_perkara->nrp_pimpinan,
            'jenis_limpah' => $jenis_limpah,
            'title' => 'RESTORATIVE JUSTICE',
        ];

        return view('pages.data_pelanggaran.proses.rj', $data);
    }

    private function viewLimpahBiro($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $polda = Polda::get();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();

        $pangkat = Pangkat::get();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();

        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $kasus->id)->first();
        $pangkat_pimpinan_gelar = Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first();

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
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name . ' ' . $kasus->terlapor,
            'sprin' => $sprin,
            'unit' => $unit,
            'penyidik' => $penyidik,
            'gelar_perkara' => $gelar_perkara,
            'pimpinan_gelar' => $pangkat_pimpinan_gelar->name . ' ' . $gelar_perkara->pimpinan . ' / ' . $gelar_perkara->nrp_pimpinan,
            'jenis_limpah' => $jenis_limpah,
            'title' => 'LIMPAH BIRO',
        ];

        return view('pages.data_pelanggaran.proses.limpah-biro', $data);
    }

    private function viewGelarPenyelidikan($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);

        $ndPG = NdPermohonanGelar::where('data_pelanggar_id', $id)->first();
        if ($ndPG->created_at == null) {
            $ndPG->created_at = date('Y-m-d H:i:s');
            $ndPG->save();
        }
        $bulan_romawi_ndPG = $this->getRomawi(Carbon::parse($ndPG->created_at)->translatedFormat('m'));

        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();


        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $pangkat = Pangkat::get();
        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $nd_hasil_gelar = NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $kasus->id)->first();
        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();
        $bai_pelapor = BaiPelapor::where('data_pelanggar_id', $kasus->id)->first() ?? '';
        $bai_terlapor = BaiTerlapor::where('data_pelanggar_id', $kasus->id)->first() ?? '';
        $ugp = GelarPerkaraHistory::where('data_pelanggar_id', $id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->first();
        $litpers = LitpersHistory::where('data_pelanggar_id', $id)->first();
        $sp2hp2_akhir = Sp2hp2Hisory::where('data_pelanggar_id', $id)->where('tipe', 'akhir')->first();
        $gelar_perkara = GelarPerkaraHistory::where('data_pelanggar_id', $id)->first();
        $pangkat_pimpinan_gelar = isset($gelar_perkara) ? Pangkat::where('id', $gelar_perkara->pangkat_pimpinan)->first() : '';
        $id_pimpinan = ['1', '2', '3', '4', '5'];
        $pimpinan = DataAnggota::whereIn('pangkat', $id_pimpinan)->get();

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
            'nd_hasil_gelar' => $nd_hasil_gelar,
            'bulan_romawi_ndPG' => $bulan_romawi_ndPG,
            'gelar_perkara' => $gelar_perkara,
            'pangkat_pimpinan_gelar' => isset($gelar_perkara) ? $pangkat_pimpinan_gelar->name : '',
            'pimpinans' => $pimpinan,
            'limpah_biro' => isset($limpah_biro) ? $limpah_biro : '',
            'ndHGP' => NDHasilGelarPenyelidikanHistory::where('data_pelanggar_id', $id)->first(),
            'unit' => $unit,
            'penyidik' => $penyidik,
            'pangkat' => $pangkat,
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name . ' ' . $kasus->terlapor,
            'tgl_bai_pelapor' => $bai_pelapor ? Carbon::parse($bai_pelapor->created_at)->translatedFormat('d F Y') : 'BAI PELAPOR BELUM DIBUAT',
            'tgl_bai_terlapor' => $bai_terlapor ? Carbon::parse($bai_terlapor->created_at)->translatedFormat('d F Y') : 'BAI TERLAPOR BELUM DIBUAT',
            'tgl_nd_pg' => Carbon::parse($ndPG->created_at)->translatedFormat('d F Y'),
            'hasil_lhp' => $lhp->hasil_penyelidikan == 1 ? 'Ditemukan Cukup Bukti' : 'Belum Ditemukan cukup bukti',
            'tgl_ugp' => isset($ugp) ? Carbon::parse($ugp->tanggal)->translatedFormat('d F Y') : '',
            'title' => 'GELAR PERKARA',
        ];

        return view('pages.data_pelanggaran.proses.gelar_penyelidikan', $data);
    }

    private function viewLimpah($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
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
            'title' => 'LIMPAH ' . $limpahPolda->polda->name,
        ];

        return view('pages.data_pelanggaran.proses.limpah_polda', $data);
    }

    private function viewDiprosesPolda($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
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
            'title' => 'LIMPAH ' . $limpahPolda->polda->name,
        ];

        return view('pages.data_pelanggaran.proses.limpah_polda', $data);
    }

    private function limpahToPolda(Request $request)
    {
        $data = DataPelanggar::find($request->kasus_id);
        $limpah = LimpahPolda::create([
            'data_pelanggar_id' => $request->kasus_id,
            'polda_id' => $request->polda,
            'tanggal_limpah' => date('Y-m-d'),
            'created_by' => auth()->user()->id,
            'isi_surat' => '<ol><li>Rujukan :&nbsp;<br><b>a</b>.&nbsp;Undang-Undang Nomor 2 Tahun 2022 tentang Kepolisian Negara Republik Indonesia.<br><b>b</b>.&nbsp;Peraturan Kepolisian Negara Republik Indonesia Nomor 7 Tahun 2022 tentang Kode Etik Profesi&nbsp; &nbsp; &nbsp;dan Komisi Kode Etik Polri.<br><b>c</b>.&nbsp;Peraturan Kepala Kepolisian Negara Republik Indonesia Nomor 13 Tahun 2016 tentang Pengamanan Internal di Lingkungan Polri<br><b>d</b>.&nbsp;Nota Dinas Kepala Bagian Pelayanan Pengaduan Divpropam Polri Nomor: R/ND-2766-b/XII/WAS.2.4/2022/Divpropam tanggal 16 Desember 2022 perihal pelimpahan Dumas BRIPKA JAMALUDDIN ASYARI.</li></ol>'
        ]);
        if ($limpah) {
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
        $kasus->tanggal_nota_dinas = Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d-m-Y');
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();
        $disposisi[0] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $disposisi[1] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 2)->first();
        $disposisi[2] = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();

        $disposisi_kadena = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();

        $tim_disposisi = Datasemen::get();
        $unit = $disposisi[1] ?  Unit::where('datasemen', $disposisi[1]['limpah_den'])->get() : array();

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

        $disiplin = implode('|', $disiplin);
        $id_disiplin = implode('|', $id_disiplin);
        $kode_etik = implode('|', $kode_etik);
        $id_kode_etik = implode('|', $id_kode_etik);

        $evidences = json_decode($kasus->evidences);

        $is_datalengkap = HelperController::cekKelengkapanData($kasus);

        $data = [
            'user' => Auth::getUser(),
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
            'evidences' => $evidences,
            'title' => 'DATA DUMAS',
            'is_datalengkap' => $is_datalengkap,
        ];

        if ($kasus->tipe_data == 2 || $kasus->tipe_data == 3) {
            $den_bag = Datasemen::where('id', $disposisi[2]['limpah_den'])->first();
            $data['den_bag_pemohon'] =  $den_bag;
            return view('pages.data_pelanggaran.proses.diterima_li_infosus', $data);
        } else {
            return view('pages.data_pelanggaran.proses.diterima', $data);
        }
    }

    private function viewPulbaket($id)
    {
        $kasus = DataPelanggar::find($id);
        $disposisi = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 3)->first();
        $den = Datasemen::where('id', $disposisi->limpah_den)->first()->name;
        $unit = Unit::where('id', $disposisi->limpah_unit)->first()->unit;

        $pangkat_terlapor = Pangkat::where('id', $kasus->pangkat)->first();

        // Get Penyidik
        $penyidik = Penyidik::where('data_pelanggar_id', $kasus->id)->orderBy('pangkat', 'asc')->get();

        foreach ($penyidik as $key => $value) {
            $pangkat = Pangkat::where('id', $value->pangkat)->first();
            $value->pangkat = $pangkat->name;
        }

        $lhp = LHPHistory::where('data_pelanggar_id', $kasus->id)->first();
        $saksis = Saksi::where('data_pelanggar_id', $kasus->id)->get();
        $disposisi_karosesro = DisposisiHistory::where('data_pelanggar_id', $kasus->id)->where('tipe_disposisi', 1)->first();
        $tgl_dumas = Carbon::parse($disposisi_karosesro->created_at);
        $today = Carbon::now()->addDays();
        $usia_dumas = $tgl_dumas->diffInDays($today);

        $jenis_kelamin = JenisKelamin::all();

        $data = [
            'kasus' => $kasus,
            'sprin' => SprinHistory::where('data_pelanggar_id', $id)->first(),
            'uuk' => UukHistory::where('data_pelanggar_id', $id)->first(),
            'sp2hp_awal' => Sp2hp2Hisory::where('data_pelanggar_id', $id)->first(),
            'penyidik' => $penyidik,
            'unit' => $unit,
            'den' => $den,
            'lhp' => $lhp,
            'saksis' => $saksis,
            'jenis_kelamin' => $jenis_kelamin,
            'usia_dumas' => $usia_dumas . ' hari',
            'terlapor' => $pangkat_terlapor->name . ' ' . $kasus->terlapor,
            'title' => 'PULBAKET',
        ];
        return view('pages.data_pelanggaran.proses.pulbaket', $data);
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
