<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 1)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya <i
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
                    <p>Diterima</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Pulbaket</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Gelar Penyelidikan</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>Limpah Biro</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Isi -->
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" required>
                        <label for="no_nota_dinas">No. Nota Dinas</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="perihal_nota_dinas" id="perihal_nota_dinas" placeholder="Perihal Nota Dinas" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" required>
                        <label for="perihal_nota_dinas">Perihal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" required>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-0">
                    <center>
                        <div class="form-label">
                            <label for="check-box">Tipe Pelanggaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="disiplin" value="1" onchange="disiplinChange(this);" {{ isset($kasus) ? ($wujud_perbuatan[$kasus->wujud_perbuatan-1]->jenis_wp == 'disiplin' ? 'checked' : 'disabled') : '' }} required>
                            <label class="form-check-label " for="disiplin">Disiplin</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="kode_etik" value="2" onchange="kodeEtikChange(this);" {{ isset($kasus) ? ($wujud_perbuatan[$kasus->wujud_perbuatan-1]->jenis_wp == 'kode etik' ? 'checked' : 'disabled') : '' }} required>
                            <label class="form-check-label" for="kode_etik">Kode Etik</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan"id="wujud_perbuatan" disabled required>
                            <option value="">-- Pilih Wujud Perbuatan --</option>
                        </select>
                        <label for="jenis_identitas" class="form-label">Wujud Perbuatan</label>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-6 p-3">
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
                                    <option value="" >-- Pilih Agama --</option>
                                    @if (isset($agama))
                                        @foreach ($agama as $key => $ag)
                                            <option value="{{ $ag->id }}"
                                                {{ $kasus->agama == $ag->id ? 'selected' : '' }}>{{ $ag->name }}
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
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas"id="jenis-identitas" required>
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

                <div class="col-lg-6 p-3">
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
                                    <label for="pangkat" class="form-label">Mabes/Polda</label>
                                </div>
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
                                <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" required>
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
                                <textarea class="form-control border-dark" name="kronologis" placeholder="Kronologis" id="kronologis" value="{{ isset($kasus) ? $kasus->kronologi : '' }}" style="height: 160px" required>{{ isset($kasus) ? $kasus->kronologi : '' }}</textarea>
                                <label for="kronologis" class="form-label">Kronologis</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card p-2">
                        <div class="col-lg-12 mb-3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Karo/Sesro</label>
                                    @if (isset($disposisi[0]) && $disposisi[0]->tipe_disposisi == 1)
                                        <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-download"></i> Download
                                        </button>
                                    @else
                                        <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-plus-square"></i> Buat
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Distribusi Binpam</label>
                                    @if (isset($disposisi[1]) && $disposisi[1]->tipe_disposisi == 2)
                                        <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi" id="binpam" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-download"></i> Download
                                        </button>
                                    @else
                                        <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi" id="binpam" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-plus-square"></i> Buat
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Ka. Den A</label>
                                    @if (isset($disposisi[2]) && $disposisi[2]->tipe_disposisi == 3)
                                        <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi_kadena" id="kadena" type="button">
                                            <i class="far fa-download"></i> Download
                                        </button>
                                    @else
                                        <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                            data-bs-target="#modal_disposisi_kadena" id="kadena" type="button">
                                            <i class="far fa-plus-square"></i> Buat
                                        </button>
                                    @endif
                                    
                                </div>
                            </div>

                            {{-- <input type="text" class="form-control" value="{{ $kasus->terlapor }}" > --}}
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select class="form-select border-dark" aria-label="Default select example"
                                name="disposisi_tujuan" onchange="getPolda()" id="disposisi-tujuan"  {{ $kasus->status_id > 4 ? 'disabled' : '' }}>
                                <option value="" class="text-center"> 
                                    @if ($kasus->status_id < 3)
                                        -- Pilih Status --
                                    @elseif ($kasus->status_id > 4)
                                        @if ($kasus->status_id == 5)
                                            Gelar Penyelidikan
                                        @else
                                            Limpah Biro
                                        @endif
                                    @endif
                                </option>
                                <option value="4" class="text-center"{{ $kasus->status_id == 4 ? 'selected' : '' }}>Pulbaket</option>
                                <option value="3" class="text-center"{{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah POLDA</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3" id="limpah-polda">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-update-diterima btn-success" type="submit" value="update_data"
                                name="type_submit">
                                <i class="far fa-upload"></i> Update Data
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-update-diterima btn-primary" type="submit" value="update_status"
                                name="type_submit" {{ $kasus->status_id > 1 ? 'disabled' : '' }}>
                                <i class="far fa-upload"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Disposisi Karo/Sesro-->
<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">Disposisi Karo/Sesro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi/{{ $kasus->id }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" pattern="[0-9]+" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                            name="nomor_agenda" placeholder="Nomor Agenda :" required>
                        <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="klasifikasi" id="klasifikasi" required>
                            <option value="" >-- Pilih Klasifikasi --</option>
                            <option value="Biasa" >Biasa</option>
                            <option value="Sangat Rahasia" >Sangat Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">Klafisikasi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat" id="derajat" required>
                            <option value="" >-- Pilih Derajat --</option>
                            <option value="Biasa" >Biasa</option>
                            <option value="Segera" >Segera</option>
                            <option value="Kilat" >Kilat</option>
                        </select>
                        <label for="derajat" class="form-label">Derajat</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari" aria-describedby="emailHelp"
                            name="surat_dari" placeholder="Surat dari :" value="BagYanduan" disabled>
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
                    <div class="form-floating mb-3" id="limpah_unit">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Disposisi Ka. Den A-->
<div class="modal fade" id="modal_disposisi_kadena" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">Disposisi Karo/Sesro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi/{{ $kasus->id }}" method="post">
                @csrf
                <input type="hidden" value="3" name="tipe_disposisi">
                <div class="modal-body">
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="number" class="form-control border-dark" id="nomor_agenda"
                            name="nomor_agenda" placeholder="Nomor Agenda :" value="{{ isset($disposisi_kadena) ? $disposisi_kadena->no_agenda : ''}}" {{ isset($disposisi_kadena) ? 'disabled' : '' }} required>
                        <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="klasifikasi" id="klasifikasi" {{ isset($disposisi_kadena) ? 'disabled' : '' }} required>
                            <option value="" >-- Pilih Klasifikasi --</option>
                            <option value="Biasa" {{ isset($disposisi_kadena) ? ($disposisi_kadena->klasifikasi == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Sangat Rahasia" {{ isset($disposisi_kadena) ? ($disposisi_kadena->klasifikasi == 'Sangat Rahasia' ? 'selected' : '') : '' }}>Sangat Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">Klafisikasi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat" id="derajat" {{ isset($disposisi_kadena) ? 'disabled' : '' }} required>
                            <option value="" >-- Pilih Derajat --</option>
                            <option value="Biasa" {{ isset($disposisi_kadena) ? ($disposisi_kadena->derajat == 'Biasa' ? 'selected' : '') : '' }}>Biasa</option>
                            <option value="Segera" {{ isset($disposisi_kadena) ? ($disposisi_kadena->derajat == 'Segera' ? 'selected' : '') : '' }}>Segera</option>
                            <option value="Kilat" {{ isset($disposisi_kadena) ? ($disposisi_kadena->derajat == 'Kilat' ? 'selected' : '') : '' }}>Kilat</option>
                        </select>
                        <label for="derajat" class="form-label">Derajat</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari" aria-describedby="emailHelp"
                            name="surat_dari" placeholder="Surat dari :" value="BagYanduan" disabled>
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
                    <div class="form-floating mb-3" id="limpah_unit">
                        @if (isset($disposisi_kadena))
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="limpah_unit" id="limpah_unit" {{ isset($disposisi_kadena) ? (isset($disposisi_kadena->limpah_unit) ? 'disabled' : '') : '' }} required>
                                <option value="">-- Pilih Limpah Unit --</option>
                                <option value="1" {{ isset($disposisi_kadena) ? ($disposisi_kadena->limpah_unit == '1' ? 'selected' : '') : '' }}>Unit I DEN A</option>
                                <option value="2" {{ isset($disposisi_kadena) ? ($disposisi_kadena->limpah_unit == '2' ? 'selected' : '') : '' }}>Unit II DEN A</option>
                                <option value="3" {{ isset($disposisi_kadena) ? ($disposisi_kadena->limpah_unit == '3' ? 'selected' : '') : '' }}>Unit III DEN A</option>
                                <option value="4" {{ isset($disposisi_kadena) ? ($disposisi_kadena->limpah_unit == '4' ? 'selected' : '') : '' }}>PAMIN DEN A</option>
                            </select>
                            <label for="limpah_unit" class="form-label">Limpah Unit</label>
                        @endif
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
    });

    function onClickModal(modal){
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
                console.log('no agenda : ',no_agenda);
                console.log('klasifikasi : ',klasifikasi);
                console.log('derajat : ',derajat);
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="Nomor Agenda :" value="`+no_agenda+`" required>
                            <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>`;
                let htmlKlasifikasi = `<option value="`+klasifikasi+`" selected>`+klasifikasi+`</option>`;
                let htmlDerajat = `<option value="`+derajat+`" selected>`+derajat+`</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').html(htmlKlasifikasi);
                $('#derajat').html(htmlDerajat);   
            }

            hiddenHtml = `<input type="number" value="1" hidden name="tipe_disposisi">`;
            $('.modal-body').append(hiddenHtml);
        } else if (modal.id == 'binpam') {
            $('#title_modal_disposisi').text('Distribusi Binpam');
            let dis_binpam = `{{ isset($disposisi[1]) ? $disposisi[1]->tipe_disposisi : '' }}`;
            if (dis_binpam == 2) {
                is_disabled = true;
            }

            let id_disposisi = `{{ isset($disposisi[1]) ? $disposisi[1]->id : ''}}`;

            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[1]) ? $disposisi[1]->no_agenda : '' }}`;
                let klasifikasi = `{{ isset($disposisi[1]) ? $disposisi[1]->klasifikasi : '' }}`;
                let derajat = `{{ isset($disposisi[1]) ? $disposisi[1]->derajat :'' }}`;
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="Nomor Agenda :" value="`+no_agenda+`" required>
                            <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>`;
                let htmlKlasifikasi = `<option value="`+klasifikasi+`" selected>`+klasifikasi+`</option>`;
                let htmlDerajat = `<option value="`+derajat+`" selected>`+derajat+`</option>`;

                $('#form_agenda').html(htmlNoAgenda);
                $('#klasifikasi').html(htmlKlasifikasi);
                $('#derajat').html(htmlDerajat);   
            }

            hiddenHtml = `<input type="number" value="2" hidden name="tipe_disposisi">`;
            $('.modal-body').append(hiddenHtml);
        } 
        if (is_disabled) {
            document.getElementById("nomor_agenda").setAttribute("disabled", "disabled");
            document.getElementById("klasifikasi").setAttribute("disabled", "disabled");
            document.getElementById("derajat").setAttribute("disabled", "disabled");
            
        }
    }

        function disiplinChange(checkbox) {
            if(checkbox.checked == true){
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("kode_etik").removeAttribute("required");
                document.getElementById("kode_etik").setAttribute("disabled", "disabled");
                getValDisiplin()
            }else{
                document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
                document.getElementById("kode_etik").setAttribute("required", "required");
                document.getElementById("kode_etik").removeAttribute("disabled");
            }
        }

        function kodeEtikChange(checkbox) {
            if(checkbox.checked == true){
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("disiplin").removeAttribute("required");
                document.getElementById("disiplin").setAttribute("disabled", "disabled");
                getValKodeEtik()
            }else{
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

            let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
            for (let index = 0; index < list_ketdis.length; index++) {
                const el_ketdis = list_ketdis[index];
                const el_id_dis = list_id_dis[index];
                if (kasus_wp != '' && kasus_wp == el_id_dis) {
                    html_wp += `<option value="`+el_id_dis+`" selected>`+el_ketdis+`</option>`;
                } else {
                    html_wp += `<option value="`+el_id_dis+`">`+el_ketdis+`</option>`;
                }
            }
            $('#wujud_perbuatan').html(html_wp);
        }

        function getValKodeEtik() {
            let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
            let list_ketke = new Array();
            list_ketke = `{{ $kode_etik }}`;
            list_ketke = list_ketke.split('|');

            let list_id_ke = new Array();
            list_id_ke = `{{ $id_kode_etik }}`;
            list_id_ke = list_id_ke.split('|');

            let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
            for (let index = 0; index < list_ketke.length; index++) {
                const el_ketke = list_ketke[index];
                const el_id_ke = list_id_ke[index];
                if (kasus_wp != '' && kasus_wp == el_id_ke) {
                    html_wp += `<option value="`+el_id_ke+`" selected>`+el_ketke+`</option>`;
                } else {
                    html_wp += `<option value="`+el_id_ke+`">`+el_ketke+`</option>`;
                }
            }
            $('#wujud_perbuatan').html(html_wp);
        }
    $(function() {
        $( "#datepicker" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id'
        });
        $( "#datepicker_tgl_kejadian" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id'
        });
    });

    function getPolda() {
        let disposisi = $('#disposisi-tujuan').val()
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
