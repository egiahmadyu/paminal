<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 1)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya <i class="far fa-arrow-right"></i></button>
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
                    <label for="no_nota_dinas" class="form-label">No. Nota Dinas</label>
                    <input type="text" name="no_nota_dinas" class="form-control border-dark" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="perihal_nota_dinas" class="form-label">Perihal Nota Dinas</label>
                    <input type="text" name="perihal_nota_dinas" class="form-control border-dark" placeholder="Perihal Nota Dinas" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="wujud_perbuatan" class="form-label">Wujud Perbuatan</label>
                    <input type="text" name="wujud_perbuatan" class="form-control border-dark" placeholder="Wujud Perbuatan" value="{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="tanggal_nota_dinas" class="form-label">Tanggal Nota Dinas</label>
                    <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" >
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="pelapor" class="form-label">Pelapor</label>
                            <input type="text" name="pelapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" name="umur" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->umur : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">-- Jenis Kelamin --</option>
                                @if (isset($jenis_kelamin))
                                    @foreach ($jenis_kelamin as $key => $jk)
                                        <option value="{{ $jk->id }}" {{ $kasus->jenis_identitas == $jk->id ? 'selected' : '' }}>{{ $jk->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            {{-- <input type="text" name="agama" class="form-control" value="{{ isset($kasus) ? ($kasus->agama == 0 ? 'Islam' : 'Kristen') : '' }}" > --}}
                            <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama">
                                <option value="">-- Agama --</option>
                                @if (isset($agama))
                                    @foreach ($agama as $key => $ag)
                                        <option value="{{ $ag->id }}" {{ $kasus->agama == $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="no_identitas" class="form-label">No Identitas</label>
                            <input type="text" name="no_identitas" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_identitas : ''}}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            {{-- <input type="text" name="jenis_identitas" class="form-control" value="{{ isset($kasus) ? $kasus->jenis_identitas : '' }}" > --}}
                            <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas" id="jenis_identitas">
                                <option value="">-- Jenis Identitas --</option>
                                @if (isset($jenis_identitas))
                                    @foreach ($jenis_identitas as $key => $ji)
                                        <option value="{{ $ji->id }}" {{ $kasus->jenis_identitas == $ji->id ? 'selected' : '' }}>{{ $ji->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" cols="30" rows="9" placeholder="Alamat" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->alamat : '' }}">{{ isset($kasus) ? $kasus->alamat : '' }}</textarea>
                        </div>
                    </div>
                    <hr>
                </div>
                
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="terlapor" class="form-label">Terlapor</label>
                            <input type="text" name="terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="pangkat" class="form-label">Pangkat</label>
                            <input type="text" name="pangkat" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->pangkat : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="nrp" class="form-label">NRP</label>
                            <input type="text" name="nrp" placeholder="NRP Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->nrp : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" placeholder="Jabatan Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="kesatuan" class="form-label">Kesatuan</label>
                            <input type="text" name="kesatuan" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
                            <input type="text" name="tempat_kejadian" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}"
                                >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                            <input type="text" name="tanggal_kejadian" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}"
                                >
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="nama_korban" class="form-label">Nama Korban</label>
                            <input type="text" name="nama_korban" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" >
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kronologis</label>
                            <textarea name="kronologis" cols="30" rows="5" placeholder="Alamat" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->kronologi : '' }}">{{ isset($kasus) ? $kasus->kronologi : '' }}</textarea>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-lg-12">
                    <div class="card p-2">
                        <div class="col-lg-12 mb-3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Karo/Sesro</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">
                                        <i class="far fa-download"></i> Download
                                    </button>
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Distribusi Binpam</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">
                                        <i class="far fa-download"></i> Download
                                    </button>
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Ka. Den A</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">
                                        <i class="far fa-download"></i> Download
                                    </button>
                                </div>
                            </div>
    
                            {{-- <input type="text" class="form-control" value="{{ $kasus->terlapor }}" > --}}
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select class="form-select border-dark" aria-label="Default select example" name="disposisi_tujuan"
                                {{-- {{ 2 != $kasus->status_id ? 'disabled' : '' }}  --}} onchange="getPolda()" id="disposisi-tujuan">
                                <option value="" class="text-center">-- Pilih Status --</option>
                                <option value="4" class="text-center" {{ $kasus->status_id == 4 ? 'selected' : '' }}>Pulbaket</option>
                                <option value="3" class="text-center" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah
                                </option>
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
                            <button class="btn btn-update-diterima btn-success" type="submit" value="update_data" name="type_submit">
                                <i class="far fa-upload"></i> Update Data
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-update-diterima btn-primary" type="submit" value="update_status" name="type_submit"
                                {{ $kasus->status_id > 1 ? 'disabled' : '' }}>
                                <i class="far fa-upload"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template Disposisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/lembar-disposisi" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Agenda :</label>
                        <input type="text" class="form-control" id="nomor_agenda" aria-describedby="emailHelp"
                            name="nomor_agenda">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Surat dari :</label>
                        <input type="text" class="form-control" id="surat_dari" aria-describedby="emailHelp"
                            name="surat_dari">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getPolda()
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
