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
                        <div class="col-lg-7">
                            <table>
                                <tr>
                                    <td> ND Permohonan Gelar Penyelidikan </td>
                                    <td> : </td>
                                    <td>
                                        @if (isset($ndPG))
                                            R/ND-{{ $ndPG->no_surat }}/II/WAS.2.4./2023/Den A
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
                                    <td>Terduga Pelapor</td>
                                    <td>:</td>
                                    <td>{{ $kasus->terlapor }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-5">
                            <table>
                                <tr>
                                    <td>Perihal</td>
                                    <td>:</td>
                                    <td>{{ $kasus->perihal_nota_dinas}}</td>
                                </tr>
                                <tr>
                                    <td>Unit Pelaksana</td>
                                    <td>:</td>
                                    <td>{{ $unit }}</td>
                                </tr>
                                <tr>
                                    <td>Ketua Tim</td>
                                    <td>:</td>
                                    <td>{{ $penyidik[0]->name }}</td>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Undangan Gelar Perkara Penyelidikan</td>
                        <td>
                            @if (!empty($ugp))
                                <a href="/gelar-perkara-undangan/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen Undangan</h6>
                                    </button>
                                </a>
                            @else
                                <a href="" data-bs-toggle="modal" data-bs-target="#modal_undangan_gelar_perkara">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-plus"></i> Dokumen Undangan</h6>
                                    </button>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @if (!empty($ugp))
                        <tr>
                            <td>Notulen Hasil Gelar Perkara</td>
                            <td>
                                <a href="/notulen-gelar-perkara/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen Notulen</h6>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nota Dinas Laporan Hasil Gelar Penyelidikan</td>
                            <td>
                                @if (isset($ndHGP))
                                    <a href="/nd-hasil-gelar-perkara/{{ $kasus->id }}">
                                        <button type="button" class="btn btn-outline-primary text-primary">
                                            <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen ND Laporan</h6>
                                        </button>
                                    </a>
                                @else
                                    <a href="" data-bs-toggle="modal" data-bs-target="#modal_nd_laporan_hasil_gelar">
                                        <button type="button" class="btn btn-outline-primary text-primary">
                                            <h6 class="p-0 m-0"><i class="fas fa-plus"></i> Dokumen ND Laporan</h6>
                                        </button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Nota Dinas Ka. LITPERS</td>
                            <td>
                                <a href="/gelar-perkara-baglitpers/{{ $kasus->id }}">
                                    <button type="button" class="btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="fas fa-print"></i> Dokumen ND Ka. LITPERS</h6>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endif
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

<!-- Modal undangan gelar penyelidikan -->
<div class="modal fade" id="modal_undangan_gelar_perkara" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Undangan Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(5)"></button>
            </div>
            <div class="modal-body">
                <form action="/gelar-perkara-undangan/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" name="tanggal_gelar_perkara" class="form-control border-dark" id="tanggal_gelar_perkara" placeholder="Tanggal Gelar Perkara" required>
                                    <label for="tanggal_gelar_perkara">Tanggal Gelar Perkara</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="time" name="waktu_gelar_perkara" class="form-control border-dark" id="waktu_gelar_perkara" placeholder="Waktu Gelar Perkara" required>
                                    <label for="waktu_gelar_perkara">Waktu Gelar Perkara</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="tempat_gelar_perkara" id="tempat_gelar_perkara" placeholder="Tempat Gelar Perkara" required>
                                    <label for="tempat_gelar_perkara">Tempat Gelar Perkara</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="pangkat_pimpinan" id="pangkat_pimpinan" placeholder="Pangkat Pimpinan" required>
                                    <label for="pangkat_pimpinan">Pangkat Pimpinan</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nama_pimpinan" id="nama_pimpinan" placeholder="Nama Pimpinan" required>
                                    <label for="nama_pimpinan">Nama Pimpinan</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="jabatan_pimpinan" id="jabatan_pimpinan" placeholder="Jabatan Pimpinan" required>
                                    <label for="jabatan_pimpinan">Jabatan Pimpinan</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nrp_pimpinan" id="nrp_pimpinan" placeholder="NRP Pimpinan" required>
                                    <label for="nrp_pimpinan">NRP Pimpinan</label>
                                </div>
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

<!-- Modal ND Laporan Hasil Gelar Penyelidikan -->
<div class="modal fade" id="modal_nd_laporan_hasil_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Undangan Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(5)"></button>
            </div>
            <div class="modal-body">
                <form action="/nd-hasil-gelar-perkara/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="no_surat"
                                placeholder="Masukan No. Nota Dinas Laporan Hasil Gelar Penyelidikan" required>
                                    <label for="no_nd_gelar_penyelidikan">Masukan No. Nota Dinas Laporan Hasil Gelar Penyelidikan</label>
                                </div>
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

<script>
    $(document).ready(function(){

    });
    $(function() {
        $( "#tanggal_gelar_perkara" ).datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
            language: 'id',
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
        });
        $('#waktu_gelar_perkara').timepicker({
            'timeFormat': 'HH:mm:ss'
        });
    });
    function setDatepickerPos(input, inst) {
        var rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function () {
            var scrollTop = $("body").scrollTop();
    	    inst.dpDiv.css({ top: rect.top + input.offsetHeight + scrollTop });
        }, 0);
    }
</script>
