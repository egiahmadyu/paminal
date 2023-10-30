<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 1)
                <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">SELANJUTNYA <i class="far fa-arrow-right"></i></button>
                @endif

            </div>
        </div>
    </div>

    <!--Timeline-->
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 25%;">
                    </div>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>DITERIMA</p>
                </div>
                <div class="f1-step">
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

    <!-- Isi -->
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post" id="form_input_data">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <select class="form-select border-dark" aria-label="Default select example" name="tipe_data" id="tipe_data" disabled required>
                            <option value="1" {{ isset($kasus) ? ($kasus->tipe_data == '1' ? 'selected' : '') : '' }}>Aduan Masyarakat</option>
                            <option value="2" {{ isset($kasus) ? ($kasus->tipe_data == '2' ? 'selected' : '') : '' }}>Info Khusus</option>
                            <option value="3" {{ isset($kasus) ? ($kasus->tipe_data == '3' ? 'selected' : '') : '' }}>Laporan Informasi</option>
                        </select>
                        <label for="tipe_data" class="form-label">Tipe Aduan</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" required>
                        <label for="no_nota_dinas">No. Nota Dinas</label>
                    </div>
                </div>
                
                <div class="col-lg-12 mb-3">
                    <center>
                        <div class="form-label">
                            <label for="check-box">Tipe Pelanggaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="disiplin" value="1" onchange="disiplinChange(this);" {{ $kasus->wujud_perbuatan ? ($wujud_perbuatan[$kasus->wujud_perbuatan]->jenis_wp == 'disiplin' ? 'checked' : 'disabled') : '' }} required>
                            <label class="form-check-label" for="disiplin">Disiplin</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="kode_etik" value="2" onchange="kodeEtikChange(this);" {{ $kasus->wujud_perbuatan ? ($wujud_perbuatan[$kasus->wujud_perbuatan]->jenis_wp == 'kode etik' ? 'checked' : 'disabled') : '' }} required>
                            <label class="form-check-label" for="kode_etik">Kode Etik</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-12 mb-3">
                    <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan" id="wujud_perbuatan" disabled required style="height: 100%"> 
                        <option value="">PILIH WUJUD PERBUATAN</option>
                    </select>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" readonly required>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <textarea class="form-control border-dark" name="perihal" placeholder="Perihal" id="perihal" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" style="height: 150px" required>{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}</textarea>
                        <label for="perihal" class="form-label">Perihal</label>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row">
                <h4>PELAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="pelapor" id="pelapor" placeholder="Nama Pelapor" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" required>
                                <label for="pelapor">Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control border-dark" name="umur" id="umur" placeholder="Umur Pelapor" value="{{ isset($kasus) ? $kasus->umur : '' }}" required>
                                <label for="umur">Umur</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @if (isset($jenis_kelamin))
                                    @foreach ($jenis_kelamin as $key => $jk)
                                    <option value="{{ $jk->id }}" {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>{{ $jk->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="pekerjaan" class="form-control border-dark" placeholder="Pekerjaan Pelapor" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" required>
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @if (isset($agama))
                                    @foreach ($agama as $key => $ag)
                                    <option value="{{ $ag->id }}" {{ $kasus->agama == $ag->id ? 'selected' : '' }}>{{ $ag->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="agama" class="form-label">Agama</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_identitas" id="no_identitas" placeholder="1234-5678-9012-1234" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_identitas : '' }}" required>
                                <label for="no_identitas" class="form-label">No Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas" id="jenis-identitas" required>
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    @if (isset($jenis_identitas))
                                    @foreach ($jenis_identitas as $key => $ji)
                                    <option value="{{ $ji->id }}" {{ $kasus->jenis_identitas == $ji->id ? 'selected' : '' }}>
                                        {{ $ji->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_telp" id="no_telp" placeholder="No. Telp Pelapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_telp : '' }}" required>
                                <label for="no_telp" class="form-label">No. Telepon Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea" value="{{ isset($kasus) ? $kasus->alamat : '' }}" style="height: 160px" required>{{ isset($kasus) ? $kasus->alamat : '' }}</textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <h4>TERLAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->nrp : '' }}" required>
                                <label for="nrp">NRP Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="Nama Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" required>
                                <label for="terlapor">Nama Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="pangkat" id="pangkat" required>
                                    <option value="">-- Pilih Pangkat --</option>
                                    @if (isset($pangkat))
                                    @foreach ($pangkat as $key => $p)
                                    <option value="{{ $p->id }}" {{ $kasus->pangkat == $p->id ? 'selected' : ''}}>
                                        {{ $p->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="pangkat" class="form-label">Pangkat Terduga Pelangar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" required>
                                <label for="jabatan">Jabatan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="Kesatuan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" required>
                                <label for="kesatuan">Kesatuan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="wilayah_hukum" id="wilayah_hukum" required>
                                    <option value="">-- Mabes/Polda --</option>
                                    @if (isset($wilayah_hukum))
                                    @foreach ($wilayah_hukum as $key => $wh)
                                    <option value="{{ $wh->id }}" {{ $kasus->wilayah_hukum == $wh->id ? 'selected' : ''}}>
                                        {{ $wh->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="tempat_kejadian" id="tempat_kejadian" placeholder="Tempat Kejadian" value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tempat Kejadian</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" readonly required>
                                <label for="tempat_kejadian">Tanggal Kejadian</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nama_korban" id="nama_korban" placeholder="Nama korban" value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" required>
                                <label for="nama_korban">Nama Korban</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="kronologis[]" placeholder="Kronologis" id="kronologis" value="{{ isset($kasus) ? $kasus->kronologi : '' }}" style="height: 160px" required>{{ isset($kasus) ? $kasus->kronologi : '' }}</textarea>
                                <label for="kronologis" class="form-label">Kronologis</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Submit data / Update status button -->
                @can('edit-diterima')
                <div class="col-lg-12 mb-3">
                    <button class="btn btn-update-diterima btn-info" type="submit" value="update_data" name="type_submit" style="width: 100%">
                        <i class="far fa-upload"></i> Update Data
                    </button>
                </div>
                @endcan 

                <!--Disposisi Button-->
                <div class="col-lg-12">
                    <div class="card p-2">
                        <div class="col-lg-12 mb-3">
                            <div class="row">

                                @can('edit-diterima')
                                    <!--Disposisi Karo/Sesro-->
                                    <div class="col-lg-12 mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Disposisi Karo/Sesro</label>
                                        @if (isset($disposisi[0]) && $disposisi[0]->tipe_disposisi == 1)
                                        <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-download"></i> Download
                                        </button>
                                        @else
                                        <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-plus-square"></i> Buat
                                        </button>
                                        @endif
                                    </div>
                                @endcan

                                @can('edit-gelar_perkara')
                                    <!--Distrubisi Binpam-->
                                    <div class="col-lg-12">
                                        <label for="exampleFormControlInput1" class="form-label">Distribusi Binpam</label>
                                        @if ((isset($disposisi[1]) && $disposisi[1]->tipe_disposisi == 2 && is_null($disposisi[1]->limpah_den)))
                                            <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="binpam" onclick="onClickModal(this)" type="button">
                                                <i class="far fa-download"></i> Download
                                            </button>
                                        @elseif ((isset($disposisi[1]) && $disposisi[1]->tipe_disposisi == 2 && $disposisi[1]->limpah_den))
                                            <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="binpam" onclick="onClickModal(this)" type="button">
                                                <i class="far fa-download"></i> Download
                                            </button>
                                        @else
                                            <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="binpam" onclick="onClickModal(this)" type="button">
                                                <i class="far fa-plus-square"></i> Buat
                                            </button>
                                        @endif

                                        <div class="form-floating mb-3 mt-3">
                                            @if (isset($disposisi[1]))
                                                @if (isset($tim_disposisi) && $disposisi[1]->tipe_disposisi == 2 && is_null($disposisi[1]->limpah_den))
                                                    <select class="form-select border-dark mb-3" data-live-search="true" aria-label="Default select example" name="limpah_den" id="limpah_den" {{ isset($disposisi[1]) ? (isset($disposisi[1]->limpah_den) ? 'disabled' : '') : '' }} {{ $kasus->status_id == 3 ? 'disabled' : '' }} required>
                                                        <option value="">-- Pilih Limpah Datasemen --</option>
                                                        @foreach ($tim_disposisi as $key => $tim)
                                                            <option value="{{ $tim->id }}" {{ isset($disposisi[1]->limpah_den) ? ($disposisi[1]->limpah_den == $tim->id ? 'selected' : '')  : '' }}>{{ $tim->name }}</option>
                                                        @endforeach
                                                        <option value="7" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah POLDA</option>
                                                    </select>
                                                    <label for="limpah_unit" class="form-label">Limpah Datasemen</label>
                                                @elseif (isset($tim_disposisi) && $disposisi[1]->tipe_disposisi == 2 && $disposisi[1]->limpah_den)
                                                    <select class="form-select border-dark mb-3" data-live-search="true" aria-label="Default select example" name="limpah_den" id="limpah_den" {{ isset($disposisi[1]) ? (isset($disposisi[1]->limpah_den) ? 'disabled' : '') : '' }} {{ $kasus->status_id == 3 ? 'disabled' : '' }} required>
                                                        <option value="">-- Pilih Limpah Datasemen --</option>
                                                        @foreach ($tim_disposisi as $key => $tim)
                                                            <option value="{{ $tim->id }}" {{ isset($disposisi[1]->limpah_den) ? ($disposisi[1]->limpah_den == $tim->id ? 'selected' : '')  : '' }}>{{ $tim->name }}</option>
                                                        @endforeach
                                                        <option value="7" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah POLDA</option>
                                                    </select>
                                                    <label for="limpah_unit" class="form-label">Limpah Datasemen</label>
                                                @endif
                                                <div class="col-lg-12 mb-3" id="limpah-polda">

                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                @endcan

                                @can('edit-pulbaket')
                                    <!--Disposisi Den-->
                                    <div class="col-lg-12" id="disposisi_kadena">
                                        <label for="exampleFormControlInput1" class="form-label">Disposisi</label>
                                        @if (isset($disposisi[2]) && $disposisi[2]->tipe_disposisi == 3)
                                            <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi_kadena" id="kadena" type="button">
                                                <i class="far fa-download"></i> Download
                                            </button>
                                        @else
                                            <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi_kadena" id="kadena" type="button">
                                                <i class="far fa-plus-square"></i> Buat
                                            </button>
                                        @endif

                                        <div class="form-floating mb-3 mt-3">
                                            @if (isset($disposisi[2]))

                                                @if (isset($unit) && $disposisi[2]->tipe_disposisi == 3 && is_null($disposisi[2]->limpah_unit))
                                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="limpah_unit" id="limpah_unit" {{ isset($disposisi[2]) ? (isset($disposisi[2]->limpah_unit) ? 'disabled' : '') : '' }} required>
                                                    <option value="">-- Pilih Limpah Unit --</option>
                                                    @foreach ($unit as $key => $u)
                                                    <option value="{{ $u->id }}" {{ isset($unit) ? ($u->id == $disposisi[2]['limpah_unit'] ? 'selected' : '') : '' }}>{{ $u->unit }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="limpah_unit" class="form-label">Limpah Unit</label>

                                                @elseif (isset($unit) && $disposisi[2]->tipe_disposisi == 3 && $disposisi[2]->limpah_unit)
                                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="limpah_unit" id="limpah_unit" {{ isset($disposisi[2]) ? (isset($disposisi[2]->limpah_unit) ? 'disabled' : '') : '' }} required>
                                                    <option value="">-- Pilih Limpah Unit --</option>
                                                    @foreach ($unit as $key => $u)
                                                    <option value="{{ $u->id }}" {{ isset($unit) ? ($u->id == $disposisi[2]['limpah_unit'] ? 'selected' : '') : '' }}>{{ $u->unit }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="limpah_unit" class="form-label">Limpah Unit</label>
                                                @endif

                                            @endif
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>

<form action="/lembar-disposisi/{{ $kasus->id }}" method="post" id="form_dis_karo_binpam">
    @csrf
    <input type="hidden" name="limpah_den" id="limpah_den_input" value="">
    <input type="hidden" name="limpah_unit" id="limpah_unit_input" value="">
    <input type="hidden" name="nomor_agenda" value="{{ isset($disposisi[0]) ? $disposisi[0]['no_agenda'] : null }}">
    <input type="hidden" name="klasifikasi" value="{{ isset($disposisi[0]) ? $disposisi[0]['klasifikasi'] : null }}">
    <input type="hidden" name="derajat" value="{{ isset($disposisi[0]) ? $disposisi[0]['derajat'] : null }}">
    <input type="hidden" name="tipe_disposisi" id="tipe_disposisi" value="">
    {{-- <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate</button>
    </div> --}}
</form>

<!-- Modal Disposisi Karo/Sesro & Binpam-->
<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">Disposisi Karo/Sesro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="{{ route('post.lembar.disposisi', ['id' => $kasus->id]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" pattern="[0-9]+" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp" name="nomor_agenda" placeholder="Nomor Agenda :" required>
                        <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="klasifikasi" id="klasifikasi" {{ isset($disposisi[0]) ? 'disabled' : '' }} required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            <option value="Biasa" {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Sangat Rahasia" {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Sangat Rahasia' ? 'selected' : '') : '' }}>Sangat Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">Klafisikasi</label>
                        {{-- <input type="hidden" name="klasifikasi" value="{{ isset($disposisi[0]) ? $disposisi[0]['klasifikasi'] : null }}"> --}}
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat" id="derajat" {{ isset($disposisi[0]) ? 'disabled' : '' }} required>
                            <option value="">-- Pilih Derajat --</option>
                            <option value="Biasa" {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Segera" {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Segera' ? 'selected' : '') : '' }}>Segera</option>
                            <option value="Kilat" {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Kilat' ? 'selected' : '') : '' }}>Kilat</option>
                        </select>
                        <label for="derajat" class="form-label">Derajat</label>
                        {{-- <input type="hidden" name="derajat" value="{{ isset($disposisi[0]) ? $disposisi[0]['derajat'] : null }}"> --}}
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari" aria-describedby="emailHelp" name="surat_dari" placeholder="Surat dari :" value="BagYanduan" disabled>
                        <label for="surat_dari" class="form-label">Surat dari :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" disabled>
                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="perihal" name="perihal" placeholder="Perihal" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" disabled>
                        <label for="perihal" class="form-label">Perihal</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Disposisi Datasemen-->
<div class="modal fade" id="modal_disposisi_kadena" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">Disposisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi/{{ $kasus->id }}" method="post">
                @csrf
                <input type="hidden" value="3" name="tipe_disposisi">
                <div class="modal-body">
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" class="form-control border-dark" id="nomor_agenda" name="nomor_agenda" placeholder="Nomor Agenda :" value="{{ isset($disposisi_kadena) ? $disposisi_kadena->no_agenda : ''}}" {{ isset($disposisi_kadena) ? 'disabled' : '' }} required>
                        <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="klasifikasi" id="klasifikasi" {{ isset($disposisi[1]) ? 'disabled' : '' }} required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            <option value="Biasa" {{ isset($disposisi[1]) ? ($disposisi[1]->klasifikasi == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Sangat Rahasia" {{ isset($disposisi[1]) ? ($disposisi[1]->klasifikasi == 'Sangat Rahasia' ? 'selected' : '') : '' }}>Sangat Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">Klafisikasi</label>
                        <input type="hidden" name="klasifikasi" value="{{ isset($disposisi[0]) ? $disposisi[0]['klasifikasi'] : null }}">
                        
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat" id="derajat" {{ isset($disposisi[1]) ? 'disabled' : '' }} required>
                            <option value="">-- Pilih Derajat --</option>
                            <option value="Biasa" {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Segera" {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Segera' ? 'selected' : '') : '' }}>Segera</option>
                            <option value="Kilat" {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Kilat' ? 'selected' : '') : '' }}>Kilat</option>
                        </select>
                        <label for="derajat" class="form-label">Derajat</label>
                        <input type="hidden" name="derajat" value="{{ isset($disposisi[1]) ? $disposisi[1]['derajat'] : null }}">
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari" aria-describedby="emailHelp" name="surat_dari" placeholder="Surat dari :" value="BagYanduan" disabled>
                        <label for="surat_dari" class="form-label">Surat dari :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" disabled>
                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="perihal" name="perihal" placeholder="Perihal" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" disabled>
                        <label for="perihal" class="form-label">Perihal</label>
                    </div>


                </div>
                <div class="modal-footer">
                    @if (isset($disposisi_kadena) && $disposisi_kadena->tipe_disposisi == 3 && isset($disposisi_kadena->limpah_unit))
                    <button type="submit" class="btn btn-success">Download</button>
                    @elseif (isset($disposisi_kadena) && $disposisi_kadena->tipe_disposisi == 3 && !isset($disposisi_kadena->limpah_unit))
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    @elseif (!isset($disposisi_kadena))
                    <button type="submit" class="btn btn-primary">Generate</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        checkStatusID()
        getPolda()

        if ($('#disiplin').is(':checked')) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("kode_etik").setAttribute("disabled", "disabled");
            getValDisiplin()
        } else if ($('#kode_etik').is(':checked')) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("disiplin").setAttribute("disabled", "disabled");
            getValKodeEtik()
        }

        $('#limpah_den').on('change', function() {
            let valLimpahDen = this.value;
            if (valLimpahDen == 7) {
                getPolda(3)
            } else {
                $('#limpah_den_input').val(valLimpahDen);
                $('#tipe_disposisi').val(2);
                $('#form_dis_karo_binpam').submit();
            }
            
        });
        $('#limpah_unit').on('change', function() {
            let valLimpahUnit = this.value;
            let valLimpahDen = $('#limpah_den').val();
            $('#limpah_unit_input').val(valLimpahUnit);
            $('#limpah_den_input').val(valLimpahDen);
            $('#tipe_disposisi').val(3);
            $('#form_dis_karo_binpam').submit();
        });


    });

    function checkStatusID() {
        let status_id = `{{ $kasus->status_id }}`
        if (status_id == 3) {
            $('#disposisi_kadena').hide();
        }
    }

    function limpahPolda() {
        $('#form_input_data').submit();
    }

    function onClickModal(modal) {
        let is_disabled = false;
        if (modal.id == 'karosesro') {
            $('#title_modal_disposisi').text('Disposisi Karo/Sesro');
            let dis_karosesro = `{{ isset($disposisi[0]) ? $disposisi[0]->tipe_disposisi : '' }}`;
            if (dis_karosesro == 1) {
                is_disabled = true;
            }

            let id_disposisi = `{{ isset($disposisi[0]) ? $disposisi[0]->id : ''}}`;

            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[0]) ? $disposisi[0]['no_agenda'] : ''}}`;
                let klasifikasi = `{{isset($disposisi[0]) ?  $disposisi[0]->klasifikasi : ''}}`;
                let derajat = `{{ isset($disposisi[0]) ? $disposisi[0]->derajat : '' }}`;
                console.log('no agenda : ', no_agenda);
                console.log('klasifikasi : ', klasifikasi);
                console.log('derajat : ', derajat);
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="Nomor Agenda :" value="` + no_agenda + `" required>
                            <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>`;
                let htmlKlasifikasi = `<option value="` + klasifikasi + `" selected>` + klasifikasi + `</option>`;
                let htmlDerajat = `<option value="` + derajat + `" selected>` + derajat + `</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').html(htmlKlasifikasi);
                $('#derajat').html(htmlDerajat);
            }

            hiddenHtml = `<input type="number" value="1" hidden name="tipe_disposisi">`;
            $('.modal-body').append(hiddenHtml);
            
        } else if (modal.id == 'binpam') {
            $('#title_modal_disposisi').text('Distribusi Binpam');
            let hiddenHtml = ''
            let dis_binpam = `{{ isset($disposisi[1]) ? $disposisi[1]->tipe_disposisi : '' }}`;
            if (dis_binpam == 2) {
                is_disabled = true;
            }

            let id_disposisi = `{{ isset($disposisi[1]) ? $disposisi[1]->id : ''}}`;

            console.log(id_disposisi > 0)
            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[1]) ? $disposisi[1]->no_agenda : '' }}`;
                let klasifikasi = `{{ isset($disposisi[1]) ? $disposisi[1]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[1]) ? $disposisi[1]->derajat :'' }}`;
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="Nomor Agenda :" value="` + no_agenda + `" required>
                            <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>`;
                let htmlKlasifikasi = `<option value="` + klasifikasi + `" selected>` + klasifikasi + `</option>`;
                let htmlDerajat = `<option value="` + derajat + `" selected>` + derajat + `</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').append(htmlKlasifikasi);
                $('#derajat').append(htmlDerajat);
            } else {
                let klasifikasi = `{{ isset($disposisi[0]) ? $disposisi[0]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[0]) ? $disposisi[0]->derajat :'' }}`;
                hiddenHtml += `<input type="text" value="`+klasifikasi+`" hidden name="klasifikasi">`
                hiddenHtml += `<input type="text" value="`+derajat+`" hidden name="derajat">`
            }

            hiddenHtml += `<input type="number" value="2" hidden name="tipe_disposisi">`;
            $('.modal-body').append(hiddenHtml);
        }
        if (is_disabled) {
            document.getElementById("nomor_agenda").setAttribute("disabled", "disabled");
            document.getElementById("klasifikasi").setAttribute("disabled", "disabled");
            document.getElementById("derajat").setAttribute("disabled", "disabled");

        }
    }

    function disiplinChange(checkbox) {
        if (checkbox.checked == true) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("kode_etik").removeAttribute("required");
            document.getElementById("kode_etik").setAttribute("disabled", "disabled");
            getValDisiplin()
        } else {
            document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
            document.getElementById("kode_etik").setAttribute("required", "required");
            document.getElementById("kode_etik").removeAttribute("disabled");
        }
    }

    function kodeEtikChange(checkbox) {
        if (checkbox.checked == true) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("disiplin").removeAttribute("required");
            document.getElementById("disiplin").setAttribute("disabled", "disabled");
            getValKodeEtik()
        } else {
            document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
            document.getElementById("disiplin").setAttribute("required", "required");
            document.getElementById("disiplin").removeAttribute("disabled");
        }
    }

    function getValDisiplin() {
        let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
        let list_ketdis = new Array();
        list_ketdis = `{{ $disiplin }}`;
        list_ketdis = list_ketdis.split('|');

        let list_id_dis = new Array();
        list_id_dis = `{{ $id_disiplin }}`;
        list_id_dis = list_id_dis.split('|');

        let html_wp = ``;
        for (let index = 0; index < list_ketdis.length; index++) {
            const el_ketdis = list_ketdis[index];
            const el_id_dis = list_id_dis[index];
            if (kasus_wp != '' && kasus_wp == el_id_dis) {
                html_wp += `<option value="` + el_id_dis + `" selected>` + el_ketdis + `</option>`;
            } else {
                html_wp += `<option value="` + el_id_dis + `">` + el_ketdis + `</option>`;
            }
        }
        $('#wujud_perbuatan').append(html_wp);

        $('#wujud_perbuatan').select2({
                theme: "bootstrap-5",
                height: "100%"
        })
    }

    function getValKodeEtik() {
        let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
        let list_ketke = new Array();
        list_ketke = `{{ $kode_etik }}`;
        list_ketke = list_ketke.split('|');

        let list_id_ke = new Array();
        list_id_ke = `{{ $id_kode_etik }}`;
        list_id_ke = list_id_ke.split('|');

        let html_wp = ``;
        for (let index = 0; index < list_ketke.length; index++) {
            const el_ketke = list_ketke[index];
            const el_id_ke = list_id_ke[index];
            if (kasus_wp != '' && kasus_wp == el_id_ke) {
                html_wp += `<option value="` + el_id_ke + `" selected>` + el_ketke + `</option>`;
            } else {
                html_wp += `<option value="` + el_id_ke + `">` + el_ketke + `</option>`;
            }
        }
        $('#wujud_perbuatan').append(html_wp);
        $('#wujud_perbuatan').select2({
                theme: "bootstrap-5",
                height: "100%"
            })
    }

    $(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id'
        });
        $("#datepicker_tgl_kejadian").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id'
        });
    });

    function getPolda(val) {
        let disposisi = $('#disposisi-tujuan').val() ? $('#disposisi-tujuan').val() : val
        if (disposisi == '3') {
            $.ajax({
                url: "/api/all-polda",
                method: "get"
            }).done(function(data) {
                console.log(data)
                $("#limpah-polda").html(data)
            });
        } else $("#limpah-polda").html("")
    }
</script>
