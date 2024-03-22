<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 1)
                    <button type="button" class="btn btn-primary"
                        onclick="getViewProcess({{ $kasus->status_id == 8 ? 8 : 3 }})">SELANJUTNYA <i
                            class="far fa-arrow-right"></i></button>
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
    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post" id="form_input_data" class="needs-validation" novalidate>
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label for="tipe_data" class="form-label">TIPE ADUAN</label>
                    <select class="form-select border-dark" aria-label="Default select example" name="tipe_data"
                        id="tipe_data" disabled required>
                        <option value="1" {{ isset($kasus) ? ($kasus->tipe_data == '1' ? 'selected' : '') : '' }}>
                            ADUAN MASYARAKAT</option>
                        <option value="2" {{ isset($kasus) ? ($kasus->tipe_data == '2' ? 'selected' : '') : '' }}>
                            INFO KHUSUS</option>
                        <option value="3" {{ isset($kasus) ? ($kasus->tipe_data == '3' ? 'selected' : '') : '' }}>
                            LAPORAN INFORMASI</option>
                    </select>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="jenis_laporan" class="form-label">JENIS PELAPORAN </label>
                    <input type="text" class="form-control border-dark" name="jenis_laporan" id="jenis_laporan"
                        placeholder="LANGSUNG/WHATSAPP"
                        value="{{ isset($kasus) ? $kasus->jenis_laporan : (old('jenis_laporan') ? old('jenis_laporan') : '') }}"
                        disabled>
                    <div class="invalid-feedback">
                        MOHON ISI JENIS PELAPORAN !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="no_nota_dinas" class="form-label">NO. NOTA DINAS </label>
                    <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas"
                        placeholder="R/ND-      /WAS.2.4/2023/Bagyanduan"
                        value="{{ isset($kasus) ? $kasus->no_nota_dinas : (old('no_nota_dinas') ? old('no_nota_dinas') : '') }}"
                        required>
                    <div class="invalid-feedback">
                        MOHON ISI NO. NOTA DINAS !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <center>
                        <div class="form-label">
                            <label for="check-box">TIPE PELANGGARAN</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="disiplin"
                                value="1" onchange="disiplinChange(this);"
                                {{ $kasus->wujud_perbuatan ? ($kasus->wujudPerbuatan->jenis_wp == 'disiplin' ? 'checked' : 'disabled') : (old('disiplin') ? old('disiplin') : '') }}
                                required>
                            <label class="form-check-label" for="disiplin">DISIPLIN</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="kode_etik"
                                value="2" onchange="kodeEtikChange(this);"
                                {{ $kasus->wujud_perbuatan ? ($kasus->wujudPerbuatan->jenis_wp == 'kode etik' ? 'checked' : 'disabled') : (old('kode_etik') ? old('kode_etik') : '') }}
                                required>
                            <label class="form-check-label" for="kode_etik">KODE ETIK</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="tanggal_nota_dinas" class="form-label">WUJUD PERBUATAN</label>
                    <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan"
                        id="wujud_perbuatan" disabled required>
                        <option value="">PILIH WUJUD PERBUATAN</option>
                    </select>
                    <div class="invalid-feedback">
                        MOHON PILIH WUJUD PERBUATAN !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="tanggal_nota_dinas" class="form-label">TANGGAL NOTA DINAS</label>
                    <input type="text" data-provider="flatpickr" data-date-format="d F Y"
                        name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker"
                        placeholder="Tanggal Nota Dinas"
                        value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : (old('tanggal_nota_dinas') ? old('tanggal_nota_dinas') : '') }}"
                        readonly required>
                    <div class="invalid-feedback">
                        MOHON PILIH TANGGAL NOTA DINAS !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="perihal" class="form-label">PERIHAL</label>
                    <textarea class="form-control border-dark" name="perihal" placeholder="Perihal" id="perihal"
                        value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : (old('perihal') ? old('perihal') : '') }}"
                        onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 150px" required>{{ isset($kasus) ? $kasus->perihal_nota_dinas : (old('perihal') ? old('perihal') : '') }}</textarea>
                    <div class="invalid-feedback">
                        MOHON ISI PERIHAL ADUAN !
                    </div>
                    @if ($errors->has('perihal'))
                        <div class="invalid-feedback">
                            {{ strtoupper($errors->first('perihal')) }}
                        </div>
                    @endif
                </div>
                <hr>
            </div>
            <div class="row">
                <h4>PELAPOR</h4>

                <!-- foto ktp, selfie dan bukti pendukung -->
                <div class="card col-lg-12 mb-0 border-0">
                    <div class="card-body">
                        <h5>DATA PENDUKUNG </h5>
                        <div class="row mt-3">
                            <div class="col-lg-6 d-flex justify-content-center">
                                <div class="card mb-0 border-0">
                                    <img src="{{ $kasus->link_ktp }}" class="card-img-top" alt="foto-ktp" height="400">
                                    <a href="{{ $kasus->link_ktp }}" target="_blank" class="btn btn-outline-primary mt-3" style="width: 100%">BUKA FOTO KTP</a>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-center">
                                <div class="card mb-0 border-0">
                                    <img src="{{ $kasus->selfie }}" class="card-img-top" alt="foto-selfie" height="400">
                                    <a href="{{ $kasus->selfie }}" target="_blank" class="btn btn-outline-primary mt-3">BUKA FOTO SELFIE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="pelapor" class="form-label">NAMA PELAPOR</label>
                            <input type="text" class="form-control border-dark" name="pelapor" id="pelapor"
                                placeholder="Nama Pelapor" onkeyup="this.value = this.value.replace(/[&*/<>]/g, '')"
                                value="{{ isset($kasus) ? $kasus->pelapor : (old('pelapor') ? old('pelapor') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="umur" class="form-label">UMUR</label>
                            <input type="number" class="form-control border-dark" name="umur" id="umur"
                                placeholder="Umur Pelapor"
                                value="{{ isset($kasus) ? $kasus->umur : (old('umur') ? old('umur') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI UMUR PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">PILIH JENIS KELAMIN</label>
                            <select class="form-select border-dark" aria-label="Default select example"
                                name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="" disabled selected>PILIH JENIS KELAMIN</option>
                                @if (isset($jenis_kelamin))
                                    @foreach ($jenis_kelamin as $key => $jk)
                                        <option value="{{ $jk->id }}"
                                            {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : (old('jenis_kelamin') ? 'selected' : '')) : '' }}>
                                            {{ strtoupper($jk->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH JENIS KELAMIN PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="pekerjaan" class="form-label">PEKERJAAN</label>
                            <input type="text" name="pekerjaan" class="form-control border-dark"
                                placeholder="Pekerjaan Pelapor"
                                value="{{ isset($kasus) ? $kasus->pekerjaan : (old('pekerjaan') ? old('pekerjaan') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI PEKERJAAN PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="agama" class="form-label">PILIH AGAMA</label>
                            <select class="form-select border-dark" aria-label="Default select example"
                                name="agama" id="agama" required>
                                <option value="" disabled selected>PILIH AGAMA</option>
                                @if (isset($agama))
                                    @foreach ($agama as $key => $ag)
                                        <option value="{{ $ag->id }}"
                                            {{ $kasus->agama == $ag->id ? 'selected' : (old('agama') ? 'selected' : '') }}>
                                            {{ $ag->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH AGAMA PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="no_identitas" class="form-label">NO. IDENTITAS</label>
                            <input type="text" name="no_identitas" id="no_identitas"
                                placeholder="contoh : 1234-5678-9012-1234" maxlength="20"
                                class="form-control border-dark"
                                value="{{ isset($kasus) ? $kasus->no_identitas : (old('no_identitas') ? old('no_identitas') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI NO. IDENTITAS !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jenis_identitas" class="form-label">PILIH JENIS IDENTITAS</label>
                            <select class="form-select border-dark" aria-label="Default select example"
                                name="jenis_identitas" id="jenis_identitas" required>
                                <option value="" disabled selected>PILIH JENIS IDENTITAS</option>
                                @if (isset($jenis_identitas))
                                    @foreach ($jenis_identitas as $key => $ji)
                                        <option value="{{ $ji->id }}"
                                            {{ $kasus->jenis_identitas == $ji->id ? 'selected' : (old('jenis_identitas') ? 'selected' : '') }}>
                                            {{ $ji->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH JENIS IDENTITAS !
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="no_telp" class="form-label">NO. TELEPON PELAPOR</label>
                            <input type="tel" name="no_telp" id="no_telp" maxlength="18"
                                placeholder="contoh: 0888-1234-9999" class="form-control border-dark"
                                value="{{ isset($kasus) ? $kasus->no_telp : (old('no_telp') ? old('no_telp') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI NO. TELEPON PELAPOR !
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="floatingTextarea" class="form-label">ALAMAT LENGKAP</label>
                            <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea"
                                value="{{ isset($kasus) ? $kasus->alamat : (old('alamat') ? old('alamat') : '') }}"
                                onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" required>{{ isset($kasus) ? $kasus->alamat : (old('alamat') ? old('alamat') : '') }}</textarea>
                            <div class="invalid-feedback">
                                MOHON ISI ALAMAT PELAPOR !
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <h4>TERLAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="nrp" class="form-label">NRP TERDUGA PELANGGAR</label>
                            <input type="text" class="form-control border-dark" name="nrp" id="nrp"
                                placeholder="NRP Terduga Pelanggar"
                                value="{{ isset($kasus) ? $kasus->nrp : (old('nrp') ? old('nrp') : '') }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NRP TERDUGA PELANGGAR !
                                *ISI DEFAULT "0" JIKA NOMOR NRP BELUM DIKETAHUI.
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="terlapor" class="form-label">NAMA TERDUGA TERLAPOR</label>
                            <input type="text" class="form-control border-dark" name="terlapor" id="terlapor"
                                placeholder="Nama Terduga Pelanggar" onkeyup="this.value = this.value.replace(/[&*/<>]/g, '')"
                                value="{{ isset($kasus) ? $kasus->terlapor : (old('terlapor') ? old('terlapor') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA TERDUGA PELANGGAR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="pangkat" class="form-label">PANGKAT</label>
                            <select class="form-select border-dark" data-live-search="true"
                                aria-label="Default select example" name="pangkat" id="pangkat" required>
                                <option value="" disabled selected>PILIH PANGKAT</option>
                                @if (isset($pangkat))
                                    @foreach ($pangkat as $key => $p)
                                        <option value="{{ $p->id }}"
                                            {{ $kasus->pangkat == $p->id ? 'selected' : (old('pangkat') ? 'selected' : '') }}>
                                            {{ $p->alias }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH PANGKAT TERDUGA PELANGGAR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jabatan" class="form-label">JABATAN TERDUGA PELANGGAR</label>
                            <input type="text" class="form-control border-dark" name="jabatan" id="jabatan"
                                placeholder="Jabatan Terduga Pelanggar"
                                value="{{ isset($kasus) ? $kasus->jabatan : (old('jabatan') ? old('jabatan') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI JABATAN TERDUGA PELANGGAR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="kesatuan" class="form-label">KESATUAN TERDUGA PELANGGAR</label>
                            <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan"
                                placeholder="Kesatuan Terduga Pelanggar"
                                value="{{ isset($kasus) ? $kasus->kesatuan : (old('kesatuan') ? old('kesatuan') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI KESATUAN TERDUGA PELANGGAR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="wilayah_hukum" class="form-label">WILAYAH HUKUM</label>
                            <select class="form-select border-dark" data-live-search="true"
                                aria-label="Default select example" name="wilayah_hukum" id="wilayah_hukum" required>
                                <option value="" disabled selected>PILIH MABES / POLDA</option>
                                @if (isset($wilayah_hukum))
                                    @foreach ($wilayah_hukum as $key => $wh)
                                        <option value="{{ $wh->id }}"
                                            {{ $kasus->wilayah_hukum == $wh->id ? 'selected' : (old('wilayah_hukum') ? 'selected' : '') }}>
                                            {{ $wh->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH WILAYAH HUKUM TERDUGA PELANGGAR !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">TEMPAT KEJADIAN</label>
                            <input type="text" class="form-control border-dark" name="tempat_kejadian"
                                id="tempat_kejadian" placeholder="Tempat Kejadian"
                                value="{{ isset($kasus) ? $kasus->tempat_kejadian : (old('tempat_kejadian') ? old('tempat_kejadian') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI TEMPAT KEJADIAN PELANGGARAN !
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">TANGGAL KEJADIAN</label>
                            <input type="text" data-provider="flatpickr" data-date-format="d F Y"
                                id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark"
                                placeholder="BB/HH/TTTT"
                                value="{{ isset($kasus) ? $kasus->tanggal_kejadian : (old('tanggal_kejadian') ? old('tanggal_kejadian') : '') }}"
                                readonly required>
                            <div class="invalid-feedback">
                                MOHON PILIH TANGGAL KEJADIAN PELANGGARAN !
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="nama_korban" class="form-label">NAMA KORBAN</label>
                            <input type="text" class="form-control border-dark" name="nama_korban"
                                id="nama_korban" placeholder="Nama korban"
                                value="{{ isset($kasus) ? $kasus->nama_korban : (old('nama_korban') ? old('nama_korban') : '') }}"
                                required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA KORBAN !
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="kronologis" class="form-label">KRONOLOGIS</label>
                            <textarea class="form-control border-dark" name="kronologis[]" placeholder="Kronologis" id="kronologis"
                                value="{{ isset($kasus) ? $kasus->kronologi : (old('kronologis') ? old('kronologis')[0] : '') }}"
                                onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 300px" required>{{ isset($kasus) ? $kasus->kronologi : (old('kronologis') ? old('kronologis')[0] : '') }}</textarea>
                            <div class="invalid-feedback">
                                MOHON ISI KRONOLOGIS PELANGGARAN !
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12 mt-0 mb-3 mx-0">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalBukti" style="width: 100%">LIHAT BUKTI-BUKTI</button>
                </div>

                @if ($kasus->status_id != 8)
                    <!-- Submit data / Update status button -->
                    @can('edit-diterima')
                        <div class="col-lg-10 mb-3">
                            <button class="btn btn-update-diterima btn-info" type="submit" value="update_data"
                                name="type_submit" style="width: 100%">
                                <i class="far fa-upload"></i> Update Data
                            </button>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <button type="button" class="btn btn-danger" id="selesai-tidak-benar"
                                onclick="selesaiTidakBenar({{ $kasus->id }})" style="width: 100%">
                                <i class="fas fa-minus-circle"></i> Selesaikan Aduan
                            </button>
                        </div>
                        @if (!$is_datalengkap)
                            <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                <h3 style="color:tomato">MOHON LENGKAPI DATA DUMAS UNTUK MELANJUTKAN !</h3>
                            </div>
                        @endif
                    @endcan

                    <!--Disposisi Button-->
                    @if ($is_datalengkap)
                    <div class="col-lg-12">
                        <div class="card p-2">
                            <div class="col-lg-12 mb-3">
                                    <div class="row">
                                        @can('edit-diterima')
                                            <!--Disposisi Karo/Sesro-->
                                            <div class="col-lg-12 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">DISPOSISI KARO/SESRO</label>
                                                    @if (isset($disposisi[0]) && $disposisi[0]->tipe_disposisi == 1)
                                                        <button class="btn btn-success" style="width: 100%"
                                                            data-bs-toggle="modal" data-bs-target="#modal_disposisi"
                                                            id="karosesro" onclick="onClickModal(this)" type="button">
                                                            <i class="far fa-download"></i> DOWNLOAD
                                                        </button>
                                                    @else
                                                        <button class="btn btn-primary" style="width: 100%"
                                                            data-bs-toggle="modal" data-bs-target="#modal_disposisi"
                                                            id="karosesro" onclick="onClickModal(this)" type="button">
                                                            <i class="far fa-plus-square"></i> BUAT
                                                        </button>
                                                    @endif
                                            </div>
                                        @endcan

                                        @can('edit-gelar_perkara')
                                                <!--Distrubisi Binpam-->
                                                <div class="col-lg-12">
                                                    <label for="exampleFormControlInput1" class="form-label">DISTRIBUSI BINPAM</label>
                                                    @if (isset($disposisi[1]) && $disposisi[1]->tipe_disposisi == 2 && is_null($disposisi[1]->limpah_den))
                                                        <button class="btn btn-success" style="width: 100%"
                                                            data-bs-toggle="modal" data-bs-target="#modal_distribusi"
                                                            id="binpam" onclick="onClickModal(this)" type="button">
                                                            <i class="far fa-download"></i> DOWNLOAD
                                                        </button>
                                                    @elseif (isset($disposisi[1]) && $disposisi[1]->tipe_disposisi == 2 && $disposisi[1]->limpah_den)
                                                        <button class="btn btn-success" style="width: 100%"
                                                            data-bs-toggle="modal" data-bs-target="#modal_distribusi"
                                                            id="binpam" onclick="onClickModal(this)" type="button">
                                                            <i class="far fa-download"></i> DOWNLOAD
                                                        </button>
                                                    @else
                                                        @if (($user->hasDatasemen && $user->hasDatasemen->name == 'BAGBINPAM') || $user->name == 'Super Admin')
                                                            <button class="btn btn-primary" style="width: 100%"
                                                                data-bs-toggle="modal" data-bs-target="#modal_distribusi"
                                                                id="binpam" onclick="onClickModal(this)" type="button">
                                                                <i class="far fa-plus-square"></i> BUAT
                                                            </button>
                                                        @else
                                                            <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                                                <h3>DATA SEDANG DIPROSES BAGBINPAM</h3>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    <!-- Disposisi BAG/DEN -->
                                                    <div class="form-floating mb-3 mt-3">
                                                        @if (isset($disposisi[1]))
                                                            @if (isset($tim_disposisi) && $disposisi[1]->tipe_disposisi == 2 && is_null($disposisi[1]->limpah_den))
                                                                <select class="form-select border-dark mb-3"
                                                                    data-live-search="true"
                                                                    aria-label="Default select example" name="limpah_den"
                                                                    id="limpah_den"
                                                                    {{ $user->hasDatasemen ? ($user->hasDatasemen->name == 'BAGBINPAM' ? '' : 'disabled') : '' }}
                                                                    {{ $kasus->status_id == 3 ? 'disabled' : '' }} required>
                                                                    <option value="">-- PILIH LIMPAH BAG / DETASEMEN --
                                                                    </option>
                                                                    @foreach ($tim_disposisi as $key => $tim)
                                                                        <option value="{{ $tim->id }}"
                                                                            {{ isset($disposisi[1]->limpah_den) ? ($disposisi[1]->limpah_den == $tim->id ? 'selected' : '') : '' }}>
                                                                            {{ $tim->name }}</option>
                                                                    @endforeach
                                                                    <option value="7"{{ $kasus->status_id == 9 ? 'selected' : '' }}>
                                                                        LIMPAH POLDA
                                                                    </option>
                                                                </select>
                                                                <label for="limpah_unit" class="form-label">LIMPAH DETASEMEN</label>
                                                            @elseif (isset($tim_disposisi) && $disposisi[1]->tipe_disposisi == 2 && $disposisi[1]->limpah_den)
                                                                <select class="form-select border-dark mb-3"
                                                                    data-live-search="true"
                                                                    aria-label="Default select example" name="limpah_den"
                                                                    id="limpah_den"
                                                                    {{ \Auth::user()->hasRole('admin') ? '' : ($user->hasDatasemen->name == 'BAGBINPAM' ? '' : 'disabled') }}
                                                                    {{ $kasus->status_id == 3 ? 'disabled' : '' }} required>
                                                                    <option value="">
                                                                        -- PILIH LIMPAH DETASEMEN --
                                                                    </option>
                                                                    @foreach ($tim_disposisi as $key => $tim)
                                                                        <option value="{{ $tim->id }}"
                                                                            {{ isset($disposisi[1]->limpah_den) ? ($disposisi[1]->limpah_den == $tim->id ? 'selected' : '') : '' }}>
                                                                            {{ $tim->name }}</option>
                                                                    @endforeach
                                                                    <option value="7" {{ $kasus->status_id == 3 ? 'selected' : '' }}>
                                                                        LIMPAH POLDA
                                                                    </option>
                                                                </select>
                                                                <label for="limpah_unit" class="form-label">LIMPAH DETASEMEN</label>
                                                            @endif
                                                            <div class="col-lg-12 mb-3" id="limpah-polda">

                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                        @endcan

                                        @can('edit-pulbaket')
                                                <!--Disposisi UNIT-->
                                                <div class="col-lg-12" id="disposisi_kadena">
                                                    <label for="exampleFormControlInput1" class="form-label">DISPOSISI</label>
                                                    @if (isset($disposisi[2]) && $disposisi[2]->tipe_disposisi == 3)
                                                        <button class="btn btn-success" style="width: 100%"
                                                            data-bs-toggle="modal" data-bs-target="#modal_disposisi_kadena"
                                                            id="kadena" type="button">
                                                            <i class="far fa-download"></i> DOWNLOAD
                                                        </button>
                                                    @else
                                                        @if (($user->hasDatasemen && $user->hasDatasemen->name != 'BAGBINPAM') || $user->name == 'Super Admin')
                                                            <button class="btn btn-primary" style="width: 100%"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal_disposisi_kadena" id="kadena"
                                                                type="button">
                                                                <i class="far fa-plus-square"></i> BUAT
                                                            </button>
                                                        @else
                                                            <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                                                <h3>DATA SEDANG DIPROSES
                                                                    {{ $disposisi[1]->disposisiBagDen->name }} </h3>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    <div class="form-floating mb-3 mt-3">
                                                        @if (isset($disposisi[2]))
                                                            @if (isset($unit) && $disposisi[2]->tipe_disposisi == 3 && is_null($disposisi[2]->limpah_unit))
                                                                <select class="form-select border-dark"
                                                                    data-live-search="true"
                                                                    aria-label="Default select example" name="limpah_unit"
                                                                    id="limpah_unit"
                                                                    {{ isset($disposisi[2]) ? (isset($disposisi[2]->limpah_unit) ? 'disabled' : '') : '' }}
                                                                    required>
                                                                    <option value="">-- PILIH LIMPAH UNIT --</option>
                                                                    @foreach ($unit as $key => $u)
                                                                        <option value="{{ $u->id }}"
                                                                            {{ isset($unit) ? ($u->id == $disposisi[2]['limpah_unit'] ? 'selected' : '') : '' }}>
                                                                            {{ $u->unit }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="limpah_unit" class="form-label">LIMPAH UNIT</label>
                                                            @elseif (isset($unit) && $disposisi[2]->tipe_disposisi == 3 && $disposisi[2]->limpah_unit)
                                                                <select class="form-select border-dark"
                                                                    data-live-search="true"
                                                                    aria-label="Default select example" name="limpah_unit"
                                                                    id="limpah_unit"
                                                                    {{ isset($disposisi[2]) ? (isset($disposisi[2]->limpah_unit) ? 'disabled' : '') : '' }}
                                                                    required>
                                                                    <option value="">-- PILIH LIMPAH UNIT --</option>
                                                                    @foreach ($unit as $key => $u)
                                                                        <option value="{{ $u->id }}"
                                                                            {{ isset($unit) ? ($u->id == $disposisi[2]['limpah_unit'] ? 'selected' : '') : '' }}>
                                                                            {{ $u->unit }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="limpah_unit" class="form-label">LIMPAH UNIT</label>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                        @endcan    
                                    </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

            </div>
        </form>
    </div>
</div>

<form action="/lembar-disposisi/{{ $kasus->id }}" method="post" id="form_dis_karo_binpam">
    @csrf
    <input type="hidden" name="limpah_den" id="limpah_den_input" value="">
    <input type="hidden" name="limpah_unit" id="limpah_unit_input" value="">
    <input type="hidden" name="nomor_agenda"
        value="{{ isset($disposisi[0]) ? $disposisi[0]['no_agenda'] : null }}">
    <input type="hidden" name="klasifikasi"
        value="{{ isset($disposisi[0]) ? $disposisi[0]['klasifikasi'] : null }}">
    <input type="hidden" name="derajat" value="{{ isset($disposisi[0]) ? $disposisi[0]['derajat'] : null }}">
    <input type="hidden" name="tipe_disposisi" id="tipe_disposisi" value="">
    {{-- <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate</button>
    </div> --}}
</form>

<!-- Modal Disposisi Karo/Sesro-->
<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">DISPOSISI KARO/SESRO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(1)"></button>
            </div>
            <form action="{{ route('post.lembar.disposisi', ['id' => $kasus->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="tipe_data" name="tipe_data"
                    value="{{ isset($kasus) ? ($kasus->tipe_data ? $kasus->tipe_data : '') : '' }}">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="nomor_surat" name="nomor_surat"
                            placeholder="NOMOR SURAT" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}"
                            disabled>
                        <label for="nomor_surat" class="form-label">NOMOR SURAT</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" pattern="[0-9]+" class="form-control border-dark" id="nomor_agenda" name="nomor_agenda" placeholder="NOMOR AGENDA :" value="{{ isset($disposisi[0]) ? $disposisi[0]->no_agenda : '' }}" {{ isset($disposisi[0]) ? 'readonly' : '' }} required>
                        <label for="nomor_agenda" class="form-label">NOMOR AGENDA :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example"
                            name="klasifikasi" id="klasifikasi" {{ isset($disposisi[0]) ? 'disabled' : '' }}
                            required>
                            <option value="">-- PILIH KLASIFIKASI --</option>
                            <option value="Biasa"
                                {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Biasa' ? 'selected' : '') : '' }}>
                                BIASA</option>
                            <option value="Sangat Rahasia"
                                {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Sangat Rahasia' ? 'selected' : '') : '' }}>
                                SANGAT RAHASIA</option>
                        </select>
                        <label for="klasifikasi" class="form-label">KLASIFIKASI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat"
                            id="derajat" {{ isset($disposisi[0]) ? 'disabled' : '' }} required>
                            <option value="">-- PILIH DERAJAT --</option>
                            <option value="Biasa"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Biasa' ? 'selected' : '') : '' }}>
                                BIASA</option>
                            <option value="Segera"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Segera' ? 'selected' : '') : '' }}>
                                SEGERA</option>
                            <option value="Kilat"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Kilat' ? 'selected' : '') : '' }}>
                                KILAT</option>
                        </select>
                        <label for="derajat" class="form-label">DERAJAT</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari"
                            aria-describedby="emailHelp" name="surat_dari" placeholder="Surat dari :"
                            value="BAGYANDUAN" disabled>
                        <label for="surat_dari" class="form-label">SURAT DARI :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="perihal" id="perihal" placeholder="HAL" cols="30" rows="10" style="height: 100px" readonly>{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}</textarea>
                        <label for="perihal" class="form-label">HAL</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="isi_disposisi" id="isi_disposisi" placeholder="ISI DISPOSISI" cols="30" rows="10" style="height: 100px" required>{{ $disposisi[0] ? $disposisi[0]->isi_disposisi : ''}}</textarea>
                        <label for="isi_disposisi" class="form-label">ISI DISPOSISI</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">UPLOAD FILE DISPOSISI :</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".doc,.docx,.pdf">
                    </div>
                    <div class="upload-file-desc d-flex justify-content-between">
                        PDF (MAKS 300kb)
                        @if ($disposisi[0] && $disposisi[0]->file)
                            <a href="/download-disposisi/{{ $disposisi[0]['id'] }}" title="DOWNLOAD FILE"> <i class="far fa-download"></i> FILE DISPOSISI</a>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="width: 100%">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Distribusi  Binpam-->
<div class="modal fade" id="modal_distribusi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">DISTRIBUSI KABAG BINPAM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(1)"></button>
            </div>
            <form action="{{ route('post.lembar.disposisi', ['id' => $kasus->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="tipe_data" name="tipe_data"
                    value="{{ isset($kasus) ? ($kasus->tipe_data ? $kasus->tipe_data : '') : '' }}">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="nomor_surat" name="nomor_surat"
                            placeholder="NOMOR SURAT" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}"
                            disabled>
                        <label for="nomor_surat" class="form-label">NOMOR SURAT</label>
                    </div>
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" pattern="[0-9]+" class="form-control border-dark" id="nomor_agenda"
                            aria-describedby="emailHelp" name="nomor_agenda" placeholder="Nomor Agenda :" value="{{ isset($disposisi[1]) ? $disposisi[1]['no_agenda'] : '' }}" {{ isset($disposisi[1]) ? 'disabled' : '' }} required>
                        <label for="nomor_agenda" class="form-label">NOMOR AGENDA :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example"
                            name="klasifikasi" id="klasifikasi" {{ isset($disposisi[0]) ? 'disabled' : '' }}
                            required>
                            <option value="">-- PILIH KLASIFIKASI --</option>
                            <option value="Biasa"
                                {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Biasa' ? 'selected' : '') : '' }}>
                                Biasa</option>
                            <option value="Sangat Rahasia"
                                {{ $disposisi[0] ? ($disposisi[0]['klasifikasi'] == 'Sangat Rahasia' ? 'selected' : '') : '' }}>
                                Sangat Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">KLASIFIKASI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat"
                            id="derajat" {{ isset($disposisi[0]) ? 'disabled' : '' }} required>
                            <option value="">-- PILIH DERAJAT --</option>
                            <option value="Biasa"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Biasa' ? 'selected' : '') : '' }}>
                                BIASA</option>
                            <option value="Segera"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Segera' ? 'selected' : '') : '' }}>
                                SEGERA</option>
                            <option value="Kilat"
                                {{ isset($disposisi[0]) ? ($disposisi[0]->derajat == 'Kilat' ? 'selected' : '') : '' }}>
                                KILAT</option>
                        </select>
                        <label for="derajat" class="form-label">DERAJAT</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari"
                            aria-describedby="emailHelp" name="surat_dari" placeholder="SURAT DARI :"
                            value="BAGYANDUAN" disabled>
                        <label for="surat_dari" class="form-label">SURAT DARI :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="perihal" id="perihal" placeholder="HAL" cols="30" rows="10" style="height: 100px" readonly>{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}</textarea>
                        <label for="perihal" class="form-label">HAL</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="isi_disposisi" id="isi_disposisi" placeholder="ISI DISTRIBUSI" cols="30" rows="10" style="height: 100px" required>{{ $disposisi[1] ? ($disposisi[1]->isi_disposisi ?? '') : ($disposisi[1]->isi_disposisi ?? '')}}</textarea>
                        <label for="isi_disposisi" class="form-label">ISI DISTRIBUSI</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">UPLOAD FILE DISTRIBUSI :</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".doc,.docx,.pdf">
                    </div>
                    <div class="upload-file-desc d-flex justify-content-between">
                        PDF (MAKS 300kb)
                        @if ($disposisi[1] && $disposisi[1]->file)
                            <a href="/download-disposisi/{{ $disposisi[1]['id'] }}" title="DOWNLOAD FILE"> <i class="far fa-download"></i> FILE DISTRIBUSI</a>
                        @endif
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="width: 100%">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Disposisi Datasemen-->
<div class="modal fade" id="modal_disposisi_kadena" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true" data-bs-backdrop="static">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">DISPOSISI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi/{{ $kasus->id }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="3" name="tipe_disposisi">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="nomor_surat" name="nomor_surat"
                            placeholder="NOMOR SURAT" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}"
                            disabled>
                        <label for="nomor_surat" class="form-label">NOMOR SURAT</label>
                    </div>
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" class="form-control border-dark" id="nomor_agenda" name="nomor_agenda"
                            placeholder="NOMOR AGENDA :"
                            value="{{ isset($disposisi_kadena) ? $disposisi_kadena->no_agenda : '' }}"
                            {{ isset($disposisi_kadena) ? 'disabled' : '' }} required>
                        <label for="nomor_agenda" class="form-label">NOMOR AGENDA :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example"
                            name="klasifikasi" id="klasifikasi" {{ isset($disposisi[1]) ? 'disabled' : '' }}
                            required>
                            <option value="">-- PILIH KLASIFIKASI --</option>
                            <option value="Biasa"
                                {{ isset($disposisi[1]) ? ($disposisi[1]->klasifikasi == 'Biasa' ? 'selected' : '') : '' }}>
                                BIASA</option>
                            <option value="Sangat Rahasia"
                                {{ isset($disposisi[1]) ? ($disposisi[1]->klasifikasi == 'Sangat Rahasia' ? 'selected' : '') : '' }}>
                                SANGAT RAHASIA</option>
                        </select>
                        <label for="klasifikasi" class="form-label">KLASIFIKASI</label>
                        <input type="hidden" name="klasifikasi"
                            value="{{ isset($disposisi[0]) ? $disposisi[0]['klasifikasi'] : null }}">

                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat"
                            id="derajat" {{ isset($disposisi[1]) ? 'disabled' : '' }} required>
                            <option value="">-- PILIH DERAJAT --</option>
                            <option value="Biasa"
                                {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Biasa' ? 'selected' : '') : '' }}>
                                BIASA</option>
                            <option value="Segera"
                                {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Segera' ? 'selected' : '') : '' }}>
                                SEGERA</option>
                            <option value="Kilat"
                                {{ isset($disposisi[1]) ? ($disposisi[1]->derajat == 'Kilat' ? 'selected' : '') : '' }}>
                                KILAT</option>
                        </select>
                        <label for="derajat" class="form-label">DERAJAT</label>
                        <input type="hidden" name="derajat"
                            value="{{ isset($disposisi[1]) ? $disposisi[1]['derajat'] : null }}">
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari"
                            aria-describedby="emailHelp" name="surat_dari" placeholder="SURAT DARI :"
                            value="BagYanduan" disabled>
                        <label for="surat_dari" class="form-label">SURAT DARI :</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="perihal" id="perihal" placeholder="HAL" cols="30" rows="10" style="height: 100px" readonly>{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}</textarea>
                        <label for="perihal" class="form-label">HAL</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="isi_disposisi" id="isi_disposisi" placeholder="ISI DISTRIBUSI" cols="30" rows="10" style="height: 100px" required>{{ $disposisi[2] ? ($disposisi[2]->isi_disposisi ?? '') : ($disposisi[2]->isi_disposisi ?? '')}}</textarea>
                        {{-- <textarea class="form-control border-dark" name="isi_disposisi" id="isi_disposisi" placeholder="ISI DISPOSISI" cols="30" rows="10" style="height: 100px" required>{{ $disposisi[2] ? $disposisi[2]->isi_disposisi : ''}}</textarea> --}}
                        <label for="isi_disposisi" class="form-label">ISI DISPOSISI</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">UPLOAD FILE DISPOSISI :</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".doc,.docx,.pdf">
                    </div>
                    <div class="upload-file-desc d-flex justify-content-between">
                        PDF (MAKS 300kb)
                        @if ($disposisi[2] && $disposisi[2]->file)
                            <a href="/download-disposisi/{{ $disposisi[2]['id'] }}" title="DOWNLOAD FILE"> <i class="far fa-download"></i> FILE DISPOSISI</a>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="width: 100%">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Bukti-bukti-->
<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti-bukti</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if (isset($kasus->evidences))
                <div class="row">
                    @foreach ($evidences as $key => $evidence)
                        @if (pathinfo($evidence, PATHINFO_EXTENSION) == 'jpg' || pathinfo($evidence, PATHINFO_EXTENSION) == 'jpeg' || pathinfo($evidence, PATHINFO_EXTENSION) == 'png')
                            <div class="col-lg-6">
                                <a href="{{$evidence}}" target="_blank" class="d-flex justify-content-center">
                                    <figure class="figure">
                                        <img src="{{$evidence}}" class="figure-img img-fluid rounded" alt="bukti-{{$key+1}}" style="height: 400px">
                                        <figcaption class="figure-caption">Bukti ke {{ $key+1 }}</figcaption>
                                    </figure>
                                </a>
                            </div>
                        @else
                            <div class="col-lg-6 d-flex justify-content-center">
                                <a href="{{$evidence}}" target="_blank" class="d-flex justify-content-center">
                                    <figure class="figure">
                                        <img src="{{ asset('assets/images/new-document.png') }}" class="figure-img img-fluid rounded" alt="bukti-{{$key+1}}" style="height: 400px">
                                        <figcaption class="figure-caption">Bukti ke {{ $key+1 }}</figcaption>
                                    </figure>
                                </a>
                            </div>
                        @endif
                        
                    @endforeach
                </div>
            @endif
        </div>
      </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        checkUser()
        checkStatusID()
        getPolda()

        if ($('#disiplin').is(':checked')) {
            // $().
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

        $('#wilayah_hukum').select2({
            theme: "bootstrap-5",
            width: 'resolve'
        })

        $('#pangkat').select2({
            theme: "bootstrap-5",
            width: 'resolve'
        })

        $('#agama').select2({
            theme: "bootstrap-5",
            width: 'resolve'
        })

        $('#jenis_kelamin').select2({
            theme: "bootstrap-5",
            width: 'resolve'
        })

        $('#jenis_identitas').select2({
            theme: "bootstrap-5",
            width: 'resolve'
        })


        //no identitas
        no_identitas.addEventListener('keyup', function(e) {
            no_identitas.value = format_no_identitas(this.value, '');
        });

        no_telp.addEventListener('keyup', function(e) {
            no_telp.value = format_no_telp(this.value, '');
        });

        function format_no_identitas(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 4,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{4}/gi);

            if (ribuan) {
                separator = sisa ? '-' : '';
                rupiah += separator + ribuan.join('-');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        };

        function format_no_telp(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 4,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{4}/gi);

            if (ribuan) {
                separator = sisa ? '-' : '';
                rupiah += separator + ribuan.join('-');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        };
    });

    function selesaiTidakBenar(id) {
        let url = '/data-kasus/selesai-tidak-benar/' + id
        Swal.fire({
            icon: 'question',
            showDenyButton: false,
            title: 'Yakin akan selesaikan data dengan status "SELESAI TIDAK BENAR"?',
            showCancelButton: true,
            confirmButtonText: "Ya, selesaikan aduan!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax(url, {
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            html: "<h5>Please Wait...</h5>",
                            customClass: {},
                            buttonsStyling: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        })
                        Swal.showLoading()
                    },
                    success: function(data, status, xhr) { // success callback function
                        Swal.close()
                        location.reload()
                    },
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
                        $('.preloader').css('display', 'none')
                        let text = jqXhr.responseJSON?.message == undefined ?
                            "Terjadi Kesalahan Pada Sistem!" : jqXhr.responseJSON.message
                        var option = {
                            text: text,
                            pos: 'top-center',
                            backgroundColor: '#e7515a'
                        }
                        window[onerror](errorMessage);
                    }
                })
                // ajaxGetJson(`/transaction/surat-masuk/print-blanko/${data.txNumber}`, 'printBlanko', 'input_error')
            } else {
                return false
            }
        });
    }

    function checkUser() {
        let user = `{{ $user->hasRole('operator') }}`
        let disposisi_kaden = `{{ $disposisi[0] }}`
        if (user) {
            if (!disposisi_kaden) {
                $('#modal_disposisi').modal('show');
                $('#form_agenda').append('<input type="hidden" name="tipe_disposisi" id="tipe_disposisi" value="1">');
            }
        }
    }

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
            $('#title_modal_disposisi').text('DISPOSISI KARO/SESRO');
            let dis_karosesro = `{{ isset($disposisi[0]) ? $disposisi[0]->tipe_disposisi : '' }}`;
            if (dis_karosesro == 1) {
                is_disabled = true;
            }

            let id_disposisi = `{{ isset($disposisi[0]) ? $disposisi[0]->id : '' }}`;

            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[0]) ? $disposisi[0]['no_agenda'] : '' }}`;
                let klasifikasi = `{{ isset($disposisi[0]) ? $disposisi[0]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[0]) ? $disposisi[0]->derajat : '' }}`;
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="NOMOR AGENDA" value="` + no_agenda + `" required>
                            <label for="nomor_agenda" class="form-label">NOMOR AGENDA :</label>`;
                let htmlKlasifikasi = `<option value="` + klasifikasi + `" selected>` + klasifikasi + `</option>`;
                let htmlDerajat = `<option value="` + derajat + `" selected>` + derajat + `</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').html(htmlKlasifikasi);
                $('#derajat').html(htmlDerajat);
            }

            hiddenHtml = `<input type="number" value="1" hidden name="tipe_disposisi">`;
            $('.modal-body').append(hiddenHtml);

        } else if (modal.id == 'binpam') {
            $('#title_modal_disposisi').text('DISTRIBUSI BINPAM');
            let hiddenHtml = ''
            let dis_binpam = `{{ isset($disposisi[1]) ? $disposisi[1]->tipe_disposisi : '' }}`;
            if (dis_binpam == 2) {
                is_disabled = true;
            }

            let id_disposisi = `{{ isset($disposisi[1]) ? $disposisi[1]->id : '' }}`;

            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[1]) ? $disposisi[1]->no_agenda : '' }}`;
                let klasifikasi = `{{ isset($disposisi[1]) ? $disposisi[1]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[1]) ? $disposisi[1]->derajat : '' }}`;
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="NOMOR AGENDA :" value="` + no_agenda + `" disabled required>
                            <label for="nomor_agenda" class="form-label">NOMOR AGENDA :</label>`;
                let htmlKlasifikasi = `<option value="` + klasifikasi + `" selected>` + klasifikasi + `</option>`;
                let htmlDerajat = `<option value="` + derajat + `" selected>` + derajat + `</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').append(htmlKlasifikasi);
                $('#derajat').append(htmlDerajat);
            } else {
                let klasifikasi = `{{ isset($disposisi[0]) ? $disposisi[0]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[0]) ? $disposisi[0]->derajat : '' }}`;
                hiddenHtml += `<input type="text" value="` + klasifikasi + `" hidden name="klasifikasi">`
                hiddenHtml += `<input type="text" value="` + derajat + `" hidden name="derajat">`
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
            $('#wujud_perbuatan').find("option").remove().end()
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
            $('#wujud_perbuatan').find("option").remove().end()
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

        let html_wp = `<option value="">PILIH WUJUD PERBUATAN</option>`;
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

        let html_wp = `<option value="">PILIH WUJUD PERBUATAN</option>`;
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

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                var errorElements = document.querySelectorAll("input.form-control:invalid");
                errorElements.forEach(function(element) {
                    element.parentNode.childNodes.forEach(function(node) {
                        if (node.className == 'valid-feedback') {
                            node.className = 'invalid-feedback';
                        }
                    });
                });
                $('html, body').animate({
                    scrollTop: $(errorElements[0]).offset().top
                }, 100);
                form.classList.add('was-validated')
            }, false)
        })
    });

    function getPolda(val) {
        let disposisi = $('#disposisi-tujuan').val() ? $('#disposisi-tujuan').val() : val
        if (disposisi == '3') {
            $.ajax({
                url: "/api/all-polda",
                method: "get"
            }).done(function(data) {
                $("#limpah-polda").html(data)
            });
        } else $("#limpah-polda").html("")
    }
</script>
