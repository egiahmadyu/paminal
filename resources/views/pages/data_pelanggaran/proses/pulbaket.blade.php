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
                                    class="btn btn-primary">Download Surat</button></a>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal_uuk">Buat Surat</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Pembuatan SP2HP2</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <a href="/surat-sp2hp2-awal/{{ $kasus->id }}"><button type="button"
                                class="btn btn-primary">Buat Surat</button></a>
                    </form>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button>Lanjutkan ke proses Gelar Penyelidikan</button>
        </div>
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
