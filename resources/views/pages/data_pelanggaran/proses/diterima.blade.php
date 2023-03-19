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
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="wujud_perbuatan" id="wujud_perbuatan" placeholder="Wujud Perbuatan" value="{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}" required>
                        <label for="wujud_perbuatan">Wujud Perbuatan</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" required readonly>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
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
                                    <option value=""></option>
                                    @if (isset($jenis_kelamin))
                                        @foreach ($jenis_kelamin as $key => $jk)
                                            <option value="{{ $jk->id }}" {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>{{ $jk->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">-- Pilih Jenis Kelamin --</label>
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
                                    <option value="" selected></option>
                                    @if (isset($agama))
                                        @foreach ($agama as $key => $ag)
                                            <option value="{{ $ag->id }}"
                                                {{ $kasus->agama == $ag->id ? 'selected' : '' }}>{{ $ag->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="agama" class="form-label">-- Pilih Agama --</label>
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
                                    <option value="" selected></option>
                                    @if (isset($jenis_identitas))
                                        @foreach ($jenis_identitas as $key => $ji)
                                            <option value="{{ $ji->id }}"
                                                {{ $kasus->jenis_identitas == $ji->id ? 'selected' : '' }}>{{ $ji->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">-- Pilih Jenis Identitas --</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea" value="{{ isset($kasus) ? $kasus->alamat : '' }}" style="height: 235px" required>{{ isset($kasus) ? $kasus->alamat : '' }}</textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="Nama Terlapor" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" required>
                                <label for="terlapor">Nama Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="pangkat" id="pangkat" placeholder="Pangkat Terlapor" value="{{ isset($kasus) ? $kasus->pangkat : '' }}" required>
                                <label for="pangkat">Pangkat Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP Terlapor" value="{{ isset($kasus) ? $kasus->nrp : '' }}" required>
                                <label for="nrp">NRP</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan Terlapor" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" required>
                                <label for="jabatan">Jabatan Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="Kesatuan Terlapor" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" required>
                                <label for="kesatuan">Kesatuan Terlapor</label>
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
                                <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" required readonly>
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
                                <textarea class="form-control border-dark" name="kronologis" placeholder="Kronologis" id="kronologis" value="{{ isset($kasus) ? $kasus->kronologi : '' }}" style="height: 161px" required>{{ isset($kasus) ? $kasus->kronologi : '' }}</textarea>
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
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi
                                        Karo/Sesro</label>
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
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Ka. Den
                                        A</label>
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

<!-- Modal Disposisi Ka Den A -->
<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disposisi Ka. Den A</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nomor_agenda" aria-describedby="emailHelp"
                            name="nomor_agenda" placeholder="Nomor Agenda :">
                        <label for="nomor_agenda" class="form-label">Nomor Agenda :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="surat_dari" aria-describedby="emailHelp"
                            name="surat_dari" placeholder="Surat dari :">
                        <label for="surat_dari" class="form-label">Surat dari :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat">
                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="mm/dd/yyyy">
                        <label for="tanggal" class="form-label">Tanggal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Perihal">
                        <label for="perihal" class="form-label">Perihal</label>
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
