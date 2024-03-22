<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(1)">
                    <i class="far fa-arrow-left"></i> SEBELUMNYA
                </button>
            </div>
            <div>

                @if ($kasus->status_id > 4)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(5)">
                        SELANJUTNYA <i class="far fa-arrow-right"></i>
                    </button>
                @endif

            </div>
        </div>
    </div>

    <!-- Timeline Pengaduan -->
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 50%;">
                    </div>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>DITERIMA</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>PULBAKET</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>GELAR PERKARA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>LIMPAH</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Isi Form -->
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="row mv-3">
                <div class="col-lg-12">
                    <!--Informasi Pulbaket-->
                    <div class="card border-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table>
                                        <tr>
                                            <td> NO. SURAT PERINTAH (SPRIN) </td>
                                            <td>:</td>
                                            <td>
                                                @if (isset($sprin))
                                                    SPRIN/{{ $sprin->no_sprin }}/HUK.6.6./{{date('Y')}}
                                                @else
                                                    SPRIN/____/HUK.6.6./{{date('Y')}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PEMBUAT SPRIN</td>
                                            <td>:</td>
                                            <td>{{ isset($sprin) ? strtoupper($sprin->user->name) : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>PELAPOR</td>
                                            <td>:</td>
                                            <td>{{ strtoupper($kasus->pelapor) }}</td>
                                        </tr>
                                        <tr>
                                            <td>USIA DUMAS</td>
                                            <td>:</td>
                                            <td>{{ strtoupper($usia_dumas) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <table>
                                        <tr>
                                            <td>TERLAPOR</td>
                                            <td>:</td>
                                            <td>{{ strtoupper($terlapor) }} / {{ $kasus->nrp }}</td>
                                        </tr>
                                        <tr>
                                            <td>PANGKAT / NRP TERLAPOR</td>
                                            <td>:</td>
                                            <td>{{ strtoupper($pangkat_terlapor) }} / {{ $kasus->nrp }}</td>
                                        </tr>
                                        <tr>
                                            <td>UNIT PELAKSANA</td>
                                            <td>:</td>
                                            <td> {{ $den.' '.$unit }}</td>
                                        </tr>
                                        <tr>
                                            <td>KETUA TIM</td>
                                            <td>:</td>
                                            <td>{{ $penyidik[0]->pangkat.' '.$penyidik[0]->name.' / '.$penyidik[0]->nrp }}</td>
                                        </tr>
                                        
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mv-3">
                <div class="col-lg-4 mb-3">
                    <input type="text" id="test_sprin" value="{{ !empty($sprin) ? 'done' : '' }}" hidden>
                    <input type="text" id="kasus_id" value="{{ $kasus->id }}" hidden>
                    <form>
                        <div class="form-buat-surat col-lg-12 mb-3">
                            <label for="tgl_pembuatan_surat_perintah" class="form-label">
                                TANGGAL PEMBUATAN SPRIN
                            </label>
                            <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                                aria-describedby="emailHelp"
                                value="{{ !empty($sprin) ? date('d-m-Y H:i', strtotime($sprin->created_at)) . ' WIB' : '' }}"
                                autocomplete="off" readonly>
                        </div>
                        @can('edit-pulbaket')
                            @if (!empty($sprin))
                                <div class="row">
                                    <div class="col-4">
                                        <a type="button" class="text-info" onclick="printSprin({{$kasus->id}})">
                                            <i class="far fa-download"></i> SPRIN
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <a type="button" class="text-info" onclick="printPengantarSprin({{$kasus->id}})">
                                            <i class="far fa-download"></i> ND PENGANTAR SPRIN
                                        </a>
                                    </div>
                                </div>
                            @else
                                <a href="#!" data-bs-toggle="modal" data-bs-target="#modal_sprin">
                                    <i class="far fa-file-plus"></i> SPRIN
                                </a>
                            @endif
                        @endcan
                        
                    </form>
                </div>
                <div class="col-lg-4 mb-3">
                    <form>
                        <div class="form-buat-surat col-lg-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">TANGGAL PEMBUATAN UUK</label>
                            <input type="text" class="form-control border-dark" id="exampleInputEmail1"
                                value="{{ !empty($uuk) ? date('d-m-Y H:i', strtotime($uuk->created_at)) : '' }}"
                                readonly autocomplete="off" aria-describedby="emailHelp">
                        </div>
                        @can('edit-pulbaket')
                            <a type="button" class="text-info" onclick="printUUK({{$kasus->id}})">
                                <i class="far fa-download"></i> UUK
                            </a>
                        @endcan
                    </form>
                </div>
                <div class="col-lg-4 mb-3">
                    <form>
                        <div class="form">
                            <div class="form-buat-surat col-lg-12 mb-3">
                                <label for="exampleInputEmail1" class="form-label">TANGGAL PEMBUATAN SP2HP2 AWAL</label>
                                <input type="text" class="form-control border-dark" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp_awal) ? date('d-m-Y H:i', strtotime($sp2hp_awal->created_at)) : '' }}"
                                    autocomplete="off" readonly>
                            </div>
                            @can('edit-pulbaket')
                                @if (!empty($sp2hp_awal))
                                    <a type="button" class="text-info" onclick="printSP2HP2({{$kasus->id}})">
                                        <i class="far fa-download"></i> SURAT
                                    </a>
                                @else
                                    <a href="#!" data-bs-toggle="modal" data-bs-target="#modal_sp2hp2_awal">
                                        <i class="far fa-file-plus"></i> SP2HP2
                                    </a>
                                @endif
                            @endcan
                            
                            @if($errors->any())
                                <h4>{{$errors->first()}}</h4>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div id="viewNext">

            </div>
        </div>
    </div>
</div>

<!-- Modal Buat SPRIN -->
<div class="modal fade" id="modal_sprin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PEMBUATAN SPRIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-perintah/{{ $kasus->id }}" method="post" target="_blank">
                    @csrf
                    <!-- Input no SPRIN -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" name="no_sprin"
                            placeholder="NO. SPRIN" autocomplete="off" required>
                        <label for="no_sprin">NO. SPRIN </label>
                        @if ($errors->has('no_sprin'))
                            <div class="invalid-feedback">{{ $errors->first('no_sprin') }}</div>
                        @endif
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" name="masa_berlaku_sprin" id="masa_berlaku_sprin"
                            placeholder="MASA BERLAKU SPRIN" autocomplete="off" required>
                        <label for="masa_berlaku_sprin">MASA BERLAKU SPRIN </label>
                    </div>

                    <div class="card border-dark">
                        <div class="card-header border-dark">
                            <h5>TIM PENYELIDIK</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NO.</th>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">PANGKAT/NRP</th>
                                        <th scope="col">JABAAN STRUKTURAL</th>
                                        <th scope="col">JABATAN TIM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($penyidik)
                                        @foreach ($penyidik as $keyPenyidik => $p)
                                            <tr>
                                                <th scope="row">{{ $keyPenyidik+1 }}</th>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->pangkat }} / {{ $p->nrp }}</td>
                                                <td>{{ $p->jabatan }}</td>
                                                <td>{{ $keyPenyidik == 0 ? 'KATIM' : 'ANGGOTA'}}</td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-outline mb-3">
                        @can('edit-pulbaket')
                            <button type="submit" class="form-control btn btn-primary">BUAT SPRIN</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat UUK -->
<div class="modal fade" id="modal_uuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PEMBUATAN SURAT UUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-control" action="/surat-uuk/{{ $kasus->id }}">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NAMA</label>
                        <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">PANGKAT</label>
                        <input type="text" class="form-control" name="pangkat" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">NRP</label>
                        <input type="text" class="form-control" name="nrp" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">NOMOR TELEPON</label>
                        <input type="text" class="form-control" name="jabatan" autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-primary">BUAT SURAT</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat SP2HP2 -->
<div class="modal fade" id="modal_sp2hp2_awal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PEMBUATAN SP2HP2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(4)"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-sp2hp2-awal/{{ $kasus->id }}">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="penangan" aria-describedby="emailHelp"
                            placeholder="Unit yang Menangani" value="{{ isset($unit) ? $unit : ''}}" autocomplete="off" required>
                        <label for="exampleInputEmail1" class="form-label">UNIT YANG MENANGANI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pangkat_dihubungi"
                            placeholder="Pangkat yang dihubungi" value="{{ isset($penyidik) ? $penyidik[2]->pangkat : ''}}" autocomplete="off" required>
                        <label for="exampleInputPassword1" class="form-label">PANGKAT YANG DIHUBUNGI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="dihubungi"
                            placeholder="Nama yang dihubungi" value="{{ isset($penyidik) ? $penyidik[2]->name : ''}}" autocomplete="off" required>
                        <label for="exampleInputPassword1" class="form-label">NAMA YANG DIHUBUNGI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jabatan_dihubungi"
                            placeholder="Jabatan yang dihubungi" value="{{ isset($penyidik) ? $penyidik[2]->jabatan : ''}}" autocomplete="off" required>
                        <label for="exampleInputPassword1" class="form-label">JABATAN YANG DIHUBUNGI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="telp_dihubungi" placeholder="No. Telepon yang dihubungi" autocomplete="off" required>
                        <label for="telp_dihubungi" class="form-label">NO. TELEPON YANG DIHUBUNGI</label>
                    </div>

                    @can('edit-pulbaket')
                        <button type="submit" class="btn btn-primary">BUAT SURAT</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Undangan Klarifikasi -->
<div class="modal fade" id="modal_undangan_sipil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PEMBUATAN SURAT UNDANGAN KLARIFIKASI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <div class="modal-body">
                <form action="/undangan-klarifikasi/{{ $kasus->id }}" id="form_undangan_klarifikasi" method="post">
                    @csrf
                    <!-- Input no surat undangan -->
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="jenis_undangan" id="jenis_undangan" required>
                            <option value="">PILIH JENIS UNDANGAN</option>
                            <option value="1">PELAPOR</option>
                            <option value="2">TERLAPOR</option>
                        </select>
                        <label for="jenis_undangan" class="form-label">-- PILIH JENIS UNDANGAN --</label>
                    </div>

                    <!--undangan sipil-->
                    <div class="row mb-3">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="no_surat_undangan" placeholder="MASUKAN NO. SURAT UNDANGAN" autocomplete="off" required>
                                <label for="no_surat_undangan">NO. SURAT UNDANGAN</label>
                                @if ($errors->has('no_surat_undangan'))
                                    <div class="invalid-feedback">{{ $errors->first('no_surat_undangan') }}</div>
                                @endif
                            </div>
                            @if ($errors->has('no_surat_undangan'))
                                <div class="invalid-feedback">{{ $errors->first('no_surat_undangan') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" name="tgl_klarifikasi" class="form-control border-dark" id="tgl_klarifikasi" placeholder="TANGGAL KLARIFIKASI" autocomplete="off" required>
                                <label for="tgl_klarifikasi">TANGGAL KLARIFIKASI</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-outline">
                                <div class="form-floating">
                                    <input type="time" data-provider="timepickr" data-time-basic="true" name="waktu_klarifikasi" class="form-control border-dark" id="waktu_klarifikasi" placeholder="WAKTU KLARIFIKASI" autocomplete="off" required>
                                    <label for="waktu_klarifikasi">WAKTU KLARIFIKASI</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-outline mb-3">
                        @can('edit-pulbaket')
                            <button type="submit" class="form-control btn btn-primary">BUAT UNDANGAN</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Saksi -->
<div class="modal fade" id="modal_tambah_saksi" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SAKSI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="getViewProcess(4)" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/tambah-saksi/{{ $kasus->id }}" method="post">
                    @csrf
                    <div class="form-outline mb-3" id="form_tambah_saksi">
                        <div class="mb-3">
                            <label for="nama_saksi" class="form-label">NAMA SAKSI</label>
                            <input type="text" class="form-control border-dark inputNamaSaksi" name="nama"
                                aria-describedby="emailHelp" placeholder="MASUKAN NAMA SAKSI" autocomplete="off" required>
                        </div>
                        <div class="invalid-feedback">
                            MOHON ISI NAMA SAKSI !
                        </div>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="jenis_kelamin" class="form-label">JENIS KELAMIN</label>
                        <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="" selected disabled>PILIH JENIS KELAMIN</option>
                            @if (isset($jenis_kelamin))
                                @foreach ($jenis_kelamin as $key => $jk)
                                    <option value="{{ $jk->id }}" {{ old('jenis_kelamin') == $jk->id ? 'selected' : '' }}>{{ strtoupper($jk->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            MOHON PILIH JENIS KELAMIN PELAPOR !
                        </div>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="floatingTextarea" class="form-label">ALAMAT LENGKAP</label>
                        <textarea class="form-control border-dark" name="alamat" placeholder="ALAMAT" id="floatingTextarea" value="{{ old('alamat') ? old('alamat') : '' }}" style="height: 160px" autocomplete="off" required></textarea>
                        <div class="invalid-feedback">
                            MOHON ISI ALAMAT PELAPOR !
                        </div>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="no_telp" class="form-label">NO. TELEPON</label>
                        <input type="text" name="no_telp" maxlength="15" id="no_telp" placeholder="contoh: 0888-1234-9999" class="form-control border-dark" value="{{ old('no_telp') ? old('no_telp') : '' }}" autocomplete="off" required>
                        <div class="invalid-feedback">
                            MOHON ISI NO. TELEPON PELAPOR !
                        </div>
                    </div>
                    <div class="form-outline mb-3">
                        <button type="submit" class="btn btn-outline-primary form-control">SIMPAN</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah BAI Pelapor -->
<div class="modal fade" id="bai_pelapor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BUAT BAI PELAPOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <form action="/bai-sipil/{{ $kasus->id }}" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="tanggal_introgasi" class="form-control border-dark" id="tanggal_introgasi" placeholder="TANGGAL INTEROGASI" autocomplete="off" required>
                            <label for="tanggal_introgasi">TANGGAL INTEROGASI</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="waktu_introgasi" class="form-control border-dark" id="waktu_introgasi" placeholder="WAKTU INTEROGASI" autocomplete="off" required>
                            <label for="waktu_introgasi">WAKTU INTEROGASI</label>
                        </div>
                    </div>
                    <div class="form-outline border-0">
                        <button type="submit" class="btn btn-primary form-control">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah BAI Terlapor -->
<div class="modal fade" id="bai_terlapor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat BAI TERLAPOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <form action="/bai-anggota/{{ $kasus->id }}" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="tanggal_introgasi" class="form-control border-dark" id="tanggal_introgasi_terlapor" placeholder="TANGGAL INTEROGASI" autocomplete="off" required>
                            <label for="tanggal_introgasi_terlapor">TANGGAL INTEROGASI</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="waktu_introgasi" class="form-control border-dark" id="waktu_introgasi" placeholder="WAKTU INTEROGASI" autocomplete="off" required>
                            <label for="waktu_introgasi">WAKTU INTEROGASI</label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary form-control">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal ND Permohonan Gelar Perkara --}}
<div class="modal fade" id="nd_permohonan_gelar_perkara" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BUAT NOTA DINAS PERMOHONAN GELAR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <form action="/nd-permohonan-gerlar/{{ $kasus->id }}" target="_blank" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" name="no_surat"
                                placeholder="MASUKAN NO. NOTA DINAS PERMOHONAN GELAR" autocomplete="off" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary form-control">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal LHP --}}
<div class="modal fade" id="lhp" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BUAT LAPORAN HASIL PENYELIDIKAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(4)"></button>
            </div>
            <form action="/laporan-hasil-penyelidikan/{{ $kasus->id }}" target="_blank" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="hasil_penyelidikan" id="hasil_penyelidikan" {{ isset($lhp) ? 'disabled' : '' }} required>
                                    <option value="">-- PILIH HASIL PENYELIDIKAN  --</option>
                                    <option value="1" {{ isset($lhp) ? ($lhp->hasil_penyelidikan == '1' ? 'selected' : '') : '' }}>DITEMUKAN CUKUP BUKTI</option>
                                    <option value="2" {{ isset($lhp) ? ($lhp->hasil_penyelidikan == '2' ? 'selected' : '') : '' }}>BELUM DITEMUKAN CUKUP BUKTI</option>
                                </select>
                                <label for="hasil_penyelidikan" class="form-label">HASIL PENYELIDIKAN</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary form-control">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        getNextData();
        no_telp.addEventListener('keyup', function(e){
                no_telp.value = format_no_telp(this.value, '');
            });
        function format_no_telp(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 4,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{4}/gi);
                
                if(ribuan){
                    separator = sisa ? '-' : '';
                    rupiah += separator + ribuan.join('-');
                }
                
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        };
        $('#print-uuk').on('click', function () {
            location.reload();
        })
    });

    $(function() {
        $( "#tanggal_introgasi" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id',
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
        });
        $( "#tanggal_introgasi_terlapor" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id',
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
        });
        $( "#tgl_klarifikasi" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id',
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
        });
        $( "#masa_berlaku_sprin" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id',
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
        });
    });

    function undanganSaksi(id) {
        $.ajax({
            url : '/get-saksi/'+id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $('.loading').css('display', 'block')
            }, 
            success: function (data, status, xhr) {
                $('.loading').css('display', 'none')
                console.log(data.data)



                $('#modal_undangan_sipil').modal('show'); 
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback
                $('.loading').css('display', 'none')
                var option = {
                    title: 'Error',
                    text: 'Terjadi Kesalahan Sistem...',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }
                Swal.fire(option) 
            }
        })
    }

    function setDatepickerPos(input, inst) {
        var rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function () {
            var scrollTop = $("body").scrollTop();
    	    inst.dpDiv.css({ top: rect.top + input.offsetHeight + scrollTop });
        }, 0);
    }

    function submitForm(event) {
        // document.forms['myform'].submit();
        getViewProcess(4)
    }

    function tambahSaksi() {
        let inHtml =
            `<div class="mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border-dark inputNamaSaksi" name="nama_saksi[]" aria-describedby="emailHelp" placeholder="Enter Nama Saksi" autocomplete="off" required>
                    <label for="no_nota_dinas" class="form-label">Nama Saksi</label>
                </div>
            </div>`;
        $('#form_tambah_saksi').append(inHtml);
    }

    function tambahAnggota() {
        let inHtml =
            `<div class="row mb-3">
            <div class="col-lg-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-dark" name="pangkat_anggota[]" id="pangkat" placeholder="Pangkat Penyelidik" autocomplete="off" required>
                    <label for="pangkat_anggota" class="form-label">Pangkat Penyelidik</label>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-dark" name="nama_penyelidik_anggota[]" id="nama_penyidik" placeholder="Nama Penyelidik" autocomplete="off" required>
                    <label for="nama_penyelidik_anggota" class="form-label">Nama Penyelidik</label>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-dark" name="nrp_anggota[]" id="nrp" placeholder="NRP" autocomplete="off" required>
                    <label for="nrp_anggota" class="form-label">NRP</label>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-dark" name="jabatan_anggota[]" id="jabatan" placeholder="Jabatan Penyelidik" autocomplete="off" required>
                    <label for="jabatan_anggota" class="form-label">Jabatan Penyelidik</label>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    <select name="tipe_tim_anggota[]" id="tipe_tim" class="form-control border-dark" disabeled>
                        <option value="2" class="text-center" selected>Anggota</option>
                    </select>
                    <label for="tipe_tim" class="form-label">Jabatan TIM : </label>
                </div>
            </div>
        </div>
        <hr>`;
        $('#form_input_anggota').append(inHtml);
    }

    function getNextData() {
        if ($('#test_sprin').val() == 'done') {

            $.ajax({
                url: `/pulbaket/view/next-data/` + $('#kasus_id').val(),
                method: "get"
            }).done(function(data) {
                $('.loader-view').css("display", "none");
                $("#viewNext").html(data)
            });
        }
    }

    function printUUK(id){
        // alert(id)
        var tempDownload = document.createElement("a");
        tempDownload.style.display = 'none';

        document.body.appendChild( tempDownload );

        // var download = data.file;
        tempDownload.setAttribute( 'href', `/surat-uuk/${id}` );
        // tempDownload.setAttribute( 'download', download );

        tempDownload.click();

        reloadPage()
    }
    
    function printSprin(id){
        // alert(id)
        var tempDownload = document.createElement("a");
        tempDownload.style.display = 'none';

        document.body.appendChild( tempDownload );

        // var download = data.file;
        tempDownload.setAttribute( 'href', `/surat-perintah/${id}` );
        // tempDownload.setAttribute( 'download', download );

        tempDownload.click();

        reloadPage()
    }
    
    function printPengantarSprin(id){
        // alert(id)
        var tempDownload = document.createElement("a");
        tempDownload.style.display = 'none';

        document.body.appendChild( tempDownload );

        // var download = data.file;
        tempDownload.setAttribute( 'href', `/surat-perintah-pengantar/${id}` );
        // tempDownload.setAttribute( 'download', download );

        tempDownload.click();

        reloadPage()
    }
    
    function printSP2HP2(id){
        // alert(id)
        var tempDownload = document.createElement("a");
        tempDownload.style.display = 'none';

        document.body.appendChild( tempDownload );

        // var download = data.file;
        tempDownload.setAttribute( 'href', `/surat-sp2hp2-awal/${id}` );
        // tempDownload.setAttribute( 'download', download );

        tempDownload.click();

        reloadPage()
    }
    
    function reloadPage() {
        setTimeout(function(){
            location.reload(1);
        }, 1000);
    }
</script>
