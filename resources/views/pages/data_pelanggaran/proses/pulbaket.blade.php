<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(1)">Sebelumnya</button>
            </div>
            <div>

                @if ($kasus->status_id > 4)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(5)">Selanjutnya</button>
                @endif

            </div>
        </div>
    </div>

    {{-- Timeline Pengaduan --}}
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 50%;">
                    </div>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Diterima</p>
                </div>
                <div class="f1-step active">
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

    {{-- Isi Form --}}
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="row mv-3">
                <div class="col-lg-4">
                    <input type="text" id="test_sprin" value="{{ !empty($sprin) ? 'done' : '' }}" hidden>
                    <input type="text" id="kasus_id" value="{{ $kasus->id }}" hidden>
                    <form>
                        <div class="col-lg-12 mb-3">
                            <label for="tgl_pembuatan_surat_perintah" class="form-label">Tanggal Pembuatan Surat Perintah</label>
                            <input type="text" class="form-control" id="tgl_pembuatan_surat_perintah"
                                aria-describedby="emailHelp"
                                value="{{ !empty($sprin) ? date('d-m-Y H:i', strtotime($sprin->created_at)) . ' WIB' : '' }}"
                                readonly>
                        </div>
                        @if (!empty($sprin))
                            <a href="/surat-perintah/{{ $kasus->id }}">
                                Sprin <i class="far fa-download"></i>
                            </a> <br>
                            <a href="/surat-perintah-pengantar/{{ $kasus->id }}">
                                Surat Pengantar Sprin <i class="far fa-download"></i>
                            </a>
                        @else
                            <a href="#!" data-bs-toggle="modal" data-bs-target="#modal_sprin">
                                Buat Surat <i class="far fa-file-plus"></i>
                            </a>
                        @endif

                    </form>
                </div>
                <div class="col-lg-4">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan UUK</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                value="{{ !empty($uuk) ? date('d-m-Y H:i', strtotime($uuk->created_at)) : '' }}"
                                readonly aria-describedby="emailHelp">
                        </div>
                        <a href="/surat-uuk/{{ $kasus->id }}">
                            UUK <i class="far fa-download"></i>
                        </a>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form>
                        <div class="form">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp_awal) ? date('d-m-Y H:i', strtotime($sp2hp_awal->created_at)) : '' }}"
                                    readonly>
                            </div>
                            @if (!empty($sp2hp_awal))
                                <a href="/surat-sp2hp2-awal/{{ $kasus->id }}">
                                    Surat <i class="far fa-download"></i>
                                </a>
                            @else
                                <a href="#!" data-bs-toggle="modal" data-bs-target="#modal_sp2hp2_awal">
                                    SP2HP2 <i class="far fa-file-plus"></i>
                                </a>
                            @endif
    
                        </div>
                    </form>

                    {{-- <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-label">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2 Awal</label>
                                </div>
                                
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp_awal) ? date('d-m-Y H:i', strtotime($sp2hp_awal->created_at)) : '' }}"
                                    readonly>
                            </div>
                            @if (!empty($sp2hp_awal))
                                <a href="/surat-sp2hp2-awal/{{ $kasus->id }}">
                                    Surat <i class="far fa-download"></i>
                                </a>
                            @else
                                <a href="#!" data-bs-toggle="modal" data-bs-target="#modal_sp2hp2_awal">
                                    Buat Surat <i class="far fa-file-plus"></i>
                                </a>
                            @endif

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-label">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2 Akhir</label>
                                </div>
                                
                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <a href="/surat-sp2hp2-awal/{{ $kasus->id }}">
                                Buat Surat <i class="far fa-file-plus"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div id="viewNext">

    </div>
</div>

<div class="modal fade" id="modal_sprin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Perintah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-perintah/{{ $kasus->id }}">
                    <div class="form-outline mb-3">
                        <label class="form-label" for="textAreaExample2">Isi Surat</label>
                        <textarea class="form-control" name="isi_surat_perintah" rows="8"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Surat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_uuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Perintah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-uuk/{{ $kasus->id }}">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Pangkat</label>
                        <input type="text" class="form-control" name="pangkat">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">NRP</label>
                        <input type="text" class="form-control" name="nrp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nomor Telp.</label>
                        <input type="text" class="form-control" name="jabatan">
                    </div>

                    <button type="submit" class="btn btn-primary">Buat Surat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sp2hp2_awal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Perintah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-sp2hp2-awal/{{ $kasus->id }}">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama yang Menangani</label>
                        <input type="text" class="form-control" name="penangan" aria-describedby="emailHelp"
                            placeholder="Unit II Detasemen A Ropaminal Divpropam Polri">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nama yang dihubungi</label>
                        <input type="text" class="form-control" name="dihubungi"
                            placeholder="AKP ERICSON SIREGAR, S.Kom., M.T., M.Sc">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Jabatan yang dihubungi</label>
                        <input type="text" class="form-control" name="jabatan_dihubungi"
                            placeholder="Kanit II Den A">
                    </div>
                    <div class="mb-3">
                        <label for="telp_dihubungi" class="form-label">No. Telepon yang dihubungi</label>
                        <input type="text" class="form-control" name="telp_dihubungi">
                    </div>

                    <button type="submit" class="btn btn-primary">Buat Surat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<!-- Vertically centered modal -->
<div class="modal fade" id="modal_tambah_saksi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Saksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <div class="mb-3" id="form_tambah_saksi">
                        <label for="nama_saksi" class="form-label">Nama Saksi</label>
                        <input type="text" class="form-control inputNamaSaksi" name="nama_saksi[]" aria-describedby="emailHelp" placeholder="Enter Nama Saksi">
                        <a href="#" onclick="tambahSaksi()"><i class="far fa-plus"></i> Tambah Saksi</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary form-control">Simpan</button>
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getNextData()
    });

    function tambahSaksi() {
        let inHtml = '<input type="text" class="form-control" name="nama_saksi[]" aria-describedby="emailHelp" placeholder="Enter Nama ">';
        $('#form_tambah_saksi .inputNamaSaksi:last').before(inHtml);
    }

    function getNextData() {
        console.log($('#test_sprin').val())
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
</script>
