<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(4)"><i class="far fa-arrow-left"></i> Sebelumnya</button>
            </div>
            <div>

                @if ($kasus->status_id > 5)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(6)">Selanjutnya <i class="far fa-arrow-right"></i></button>
                @endif

            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 75%;">
                    </div>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Diterima</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Pulbaket</p>
                </div>
                <div class="f1-step active">
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-dark">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td> No. SPRIN </td>
                                    <td>:</td>
                                    <td>
                                        @if (isset($sprin))
                                            Sprin/{{ $sprin->no_sprin }}/HUK.6.6./2023
                                        @else 
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pelapor</td>
                                    <td>:</td>
                                    <td>{{ $kasus->pelapor }}</td>
                                </tr>
                                <tr>
                                    <td>Terlapor</td>
                                    <td>:</td>
                                    <td>{{ $kasus->terlapor }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td>Perihal</td>
                                    <td>:</td>
                                    <td>Perihal</td>
                                </tr>
                                <tr>
                                    <td>Unit Pelaksana</td>
                                    <td>:</td>
                                    <td>{{ $kasus->pelapor }}</td>
                                </tr>
                                <tr>
                                    <td>Ketua Tim</td>
                                    <td>:</td>
                                    <td>{{ $kasus->terlapor }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Isi Form -->
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                <thead class="text-muted table-light">
                    <tr>
                        <th scope="col"> Nama Kegiatan</th>
                        <th scope="col">Action</th>
                        {{-- <th scope="col">Pelapor</th>
                        <th scope="col">Terlapor</th>
                        <th scope="col">Pangkat</th>
                        <th scope="col">Nama Korban</th>
                        <th scope="col">Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Undangan Gelar Perkara Penyelidikan</td>
                        <td>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modal_undangan_gelar_perkara">
                                <button type="button" class="btn btn-outline-primary text-primary">
                                    <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen</h6>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @if (!empty($ugp))
                        <tr>
                            <td>Notulen Hasil Gelar Perkara</td>
                            <td>
                                <a href="/notulen-gelar-perkara/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen</h6>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nota Dinas Laporan Hasil Gelar Penyelidikan</td>
                            <td>
                                <a href="/nd-hasil-gelar-perkara/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen</h6>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nota Dinas Ka. LITPERS</td>
                            <td>
                                <a href="/gelar-perkara-baglitpers/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen</h6>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endif
                    {{-- <tr>
                        <td>Berita Acara Intograsi</td>
                        <td><button type="button" class="btn btn-primary">Buat Dokumen BAI</button></td>
                    </tr>
                    <tr>
                        <td>Laporan Hasil Penyelidikan</td>
                        <td><button type="button" class="btn btn-primary">Buat Dokumen</button></td>
                    </tr>
                    <tr>
                        <td>ND Permohonan Gelar Perkara</td>
                        <td><button type="button" class="btn btn-primary">Buat Dokumen</button></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    @if (isset($kasus) & ($kasus->status_id === 5))
        <div class="row mt-3">
            <div class="col-lg-12">
                @if (!empty($ugp))
                    <form action="/data-kasus/update" method="post">
                        @csrf
                        <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
                        <input type="text" class="form-control" value="6" hidden name="disposisi_tujuan" hidden>
                        <button class="btn btn-success" name="type_submit" {{ $kasus->status_id > 5 ? 'disabled' : '' }}
                            value="update_status">Lanjutkan
                            ke Provos / Wabprof</button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>

<div class="modal fade" id="modal_undangan_gelar_perkara" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Undangan Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/gelar-perkara-undangan/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <input type="date" class="form-control" name="tanggal_gelar_perkara"
                                    id="tanggal_gelar_perkara">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" name="waktu_gelar_perkara"
                                    id="waktu_gelar_perkara" placeholder="Waktu Gelar Perkara">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" name="tempat_gelar_perkara"
                                    id="tempat_gelar_perkara" placeholder="Tempat Gelar Perkara">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" name="pangkat_pimpinan"
                                    id="pangkat_pimpinan" placeholder="Pangkat Pimpinan">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" name="nama_pimpinan"
                                    id="nama_pimpinan" placeholder="Nama Pimpinan">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-outline mb-3">
                                <input type="text" class="form-control" name="jabatan_pimpinan"
                                    id="jabatan_pimpinan" placeholder="Jabatan Pimpinan">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <button type="submit" class="form-control btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>