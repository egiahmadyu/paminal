<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 1)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif

            </div>
        </div>
    </div>
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
                    <p>Provost / Wabprof</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="pelapor" class="form-label">Pelapor</label>
                            <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" class="form-control" value="{{ isset($kasus) ? $kasus->umur : '' }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label> 
                            <input type="text" class="form-control" value="{{ isset($kasus) ? ($kasus->jenis_kelamin === 0 ? 'Laki-laki' : 'Perempuan') : '' }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" value="{{ isset($kasus) ? ($kasus->agama == 0 ? 'Islam' : 'Kristen') : '' }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="no_identitas" class="form-label">No Identitas</label>
                            <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->no_identitas : ''}}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->jenis_identitas : '' }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            {{-- <textarea class="form-control" value="{{ isset($kasus) ? $kasus->alamat }}"></textarea> --}}
                            <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->alamat : '' }}" readonly>
                            {{-- <input type="text" class="form-control" value="{{ isset($kasus) ? $kasus->alamat }}" readonly> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Terlapor</label>
                            <input type="text" class="form-control" value="{{ $kasus->terlapor }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pangkat</label>
                            <input type="text" class="form-control" value="{{ $kasus->pangkat }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kesatuan</label>
                            <input type="text" class="form-control" value="{{ $kasus->kesatuan }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tempat Kejadian</label>
                            <input type="text" class="form-control" value="{{ $kasus->tempat_kejadian }}"
                                readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tanggal Kejadian</label>
                            <input type="text" class="form-control" value="{{ $kasus->tanggal_kejadian }}"
                                readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Korban</label>
                            <input type="text" class="form-control" value="{{ $kasus->nama_korban }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kronologis</label>
                            <input type="text" class="form-control" value="{{ $kasus->kronologi }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card p-2">
                        <div class="col-lg-12 mb-3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Karo/Sesro</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">Download</button>
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Distribusi Binpam</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">Download</button>
                                </div>
                                <div class="col-lg-4">
                                    <label for="exampleFormControlInput1" class="form-label">Disposisi Ka. Den A</label>
                                    <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                        data-bs-target="#modal_disposisi" type="button">Download</button>
                                </div>
                            </div>
    
                            {{-- <input type="text" class="form-control" value="{{ $kasus->terlapor }}" readonly> --}}
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Update Status</label>
                            <select class="form-select" aria-label="Default select example" name="disposisi_tujuan"
                                {{-- {{ 2 != $kasus->status_id ? 'disabled' : '' }}  --}} onchange="getPolda()" id="disposisi-tujuan">
                                <option value="">--Update Status--</option>
                                <option value="4">Pulbaket</option>
                                <option value="3" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3" id="limpah-polda">
    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="float: right;">
                    <button class="btn btn-success" type="submit" value="update_data" name="type_submit">Update
                        Data</button>
                    <button class="btn btn-primary" type="submit" value="update_status" name="type_submit"
                        {{ $kasus->status_id > 1 ? 'disabled' : '' }}>Update
                        Status</button>
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
