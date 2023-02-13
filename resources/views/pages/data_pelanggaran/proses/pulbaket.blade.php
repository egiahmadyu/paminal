<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(1)">Sebelumnya</button>
            </div>
            <div>

                @if ($kasus->status_id > 4)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif

            </div>
        </div>
    </div>
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
                    <p>Gelar Peneyelidikan</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>Provost / Wabprof</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="row mv-3">
                <div class="col-lg-4">
                    <input type="text" id="test_sprin" value="{{ !empty($sprin) ? 'done' : '' }}" hidden>
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan Surat Perintah</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp"
                                value="{{ !empty($sprin) ? date('d-m-Y H:i', strtotime($sprin->created_at)) . ' WIB' : '' }}"
                                readonly>
                        </div>
                        @if (!empty($sprin))
                            <a href="/surat-perintah/{{ $kasus->id }}"><button type="button"
                                    class="btn btn-primary">Download Sprin</button></a>
                            <a href="/surat-perintah-pengantar/{{ $kasus->id }}"><button type="button"
                                    class="btn btn-info">Download Surat Pengantar Sprin</button></a>
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal_sprin">Buat Surat</button>
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
                        <a href="/surat-uuk/{{ $kasus->id }}"><button type="button" class="btn btn-primary">Download
                                UUK</button></a>
                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal_uuk">Buat Surat</button> --}}
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2 Awal</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp_awal) ? date('d-m-Y H:i', strtotime($sp2hp_awal->created_at)) : '' }}"
                                    readonly>
                            </div>
                            @if (!empty($sp2hp_awal))
                                <a href="/surat-sp2hp2-awal/{{ $kasus->id }}"><button type="button"
                                        class="btn btn-primary">Download Surat</button></a>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal_sp2hp2_awal">Buat Surat</button>
                            @endif

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2
                                    Akhir</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <a href="/surat-sp2hp2-awal/{{ $kasus->id }}"><button type="button"
                                    class="btn btn-primary">Buat Surat</button></a>
                        </div>
                    </div>
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
                        <label for="exampleInputPassword1" class="form-label">Jabatan</label>
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
                        <label for="exampleInputPassword1" class="form-label">Jabatan</label>
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

<script>
    $(document).ready(function() {
        getNextData()
    });

    function getNextData() {
        console.log($('#test_sprin').val())
        if ($('#test_sprin').val() == 'done') {
            $.ajax({
                url: `/pulbaket/view/next-data`,
                method: "get"
            }).done(function(data) {
                $('.loader-view').css("display", "none");
                $("#viewNext").html(data)
            });
        }
    }
</script>
