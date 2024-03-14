<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(4)">
                    <i class="far fa-arrow-left"></i> SEBELUMNYA
                </button>
            </div>
            <div>

                @if ($kasus->status_id > 5)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(6)">
                        SELANJUTNYA <i class="far fa-arrow-right"></i>
                    </button>
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
                    <p>DITERIMA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>PULBAKET</p>
                </div>
                <div class="f1-step active">
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-dark">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td> ND PERMOHONAN GELAR </td>
                                    <td> : </td>
                                    <td>
                                        @if (isset($ndPG))
                                            R/ND-{{ $ndPG->no_surat }}/{{ $bulan_romawi_ndPG }}/WAS.2.4./{{ Carbon\Carbon::parse($ndPG->created_at)->translatedFormat('Y') }}/{{$bag_den}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>PELAPOR</td>
                                    <td> : </td>
                                    <td>{{ strtoupper($kasus->pelapor) }}</td>
                                </tr>
                                <tr>
                                    <td>TERDUGA PELANGGAR</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($terlapor) }} / {{ $kasus->nrp }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL BAI PELAPOR</td>
                                    <td>:</td>
                                    <td>{{ $tgl_bai_terlapor }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL BAI TERDUGA PELANGGAR</td>
                                    <td>:</td>
                                    <td>{{ $tgl_bai_pelapor }}</td>
                                </tr>
                                <tr>
                                    <td>HASIL PENYELIDIKAN</td>
                                    <td>:</td>
                                    <td>{{ $hasil_lhp }}</td>
                                </tr>
                                <tr>
                                    <td>USIA DUMAS</td>
                                    <td>:</td>
                                    <td>{{ $usia_dumas }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td>UNIT PELAKSANA</td>
                                    <td>:</td>
                                    <td>{{ $unit }}</td>
                                </tr>
                                <tr>
                                    <td>KETUA TIM</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($penyidik[0]->pangkat) . ' ' . $penyidik[0]->name . ' / ' . $penyidik[0]->nrp }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>TANGGAL PERMOHONAN GELAR</td>
                                    <td>:</td>
                                    <td>{{ $tgl_nd_pg }}</td>
                                </tr>
                                <tr>
                                    <td>HAL</td>
                                    <td>:</td>
                                    <td>{{ $kasus->perihal_nota_dinas }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Isi Form -->
    <div class="card border-0">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-buat-surat col-lg-12 mb-3">
                        <label for="tgl_pembuatan_surat_perintah" class="form-label">
                            TANGGAL PELAKSANAAN GELAR PERKARA
                        </label>
                        <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                            aria-describedby="emailHelp" value="{{ isset($tgl_ugp) ? $tgl_ugp : '' }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-buat-surat col-lg-12 mb-3">
                        <label for="tgl_pembuatan_surat_perintah" class="form-label">
                            TANGGAL PEMBUATAN SP2HP2 AKHIR
                        </label>
                        <input type="text" class="form-control border-dark"
                            id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                            value="{{ isset($sp2hp2_akhir) ? Carbon\Carbon::parse($sp2hp2_akhir->created_at)->translatedFormat('d F Y') : '' }}"
                            readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-buat-surat col-lg-12 mb-3">
                        <label for="pimpinan_gelar" class="form-label">PIMPINAN GELAR PERKARA</label>
                        <input type="text" class="form-control border-dark" id="pimpinan_gelar"
                            aria-describedby="emailHelp"
                            value="{{ isset($gelar_perkara) ? $pangkat_pimpinan_gelar . ' ' . $gelar_perkara->pimpinan . ' / ' . $gelar_perkara->nrp_pimpinan : '' }}"
                            readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-buat-surat col-lg-12 mb-3">
                        <label for="tgl_pembuatan_surat_perintah" class="form-label">PELIMPAHAN</label>
                        <input type="text" class="form-control border-dark"
                            id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                            value="{{ isset($limpah_biro) ? $limpah_biro : '' }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        @can('edit-gelar_perkara')
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">NAMA KEGIATAN</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>UNDANGAN GELAR PERKARA</td>
                                    <td>
                                        @if (!empty($ugp))
                                            <a href="/gelar-perkara-undangan/{{ $kasus->id }}">
                                                <button type="button" class="btn btn-outline-primary text-primary">
                                                    <h6 class="p-0 m-0"><i class="fas fa-print"></i> DOKUMEN UNDANGAN</h6>
                                                </button>
                                            </a>
                                        @else
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modal_undangan_gelar_perkara">
                                                <button type="button" class="btn btn-outline-primary text-primary">
                                                    <h6 class="p-0 m-0"><i class="fas fa-plus"></i> DOKUMEN UNDANGAN</h6>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if (!empty($ugp))
                                    <tr>
                                        <td>NOTULEN HASIL GELAR PERKARA</td>
                                        <td>
                                            <a href="/notulen-gelar-perkara/{{ $kasus->id }}">
                                                <button type="button" class="btn btn-outline-primary text-primary">
                                                    <h6 class="p-0 m-0">
                                                        <i class="fas fa-print"></i>
                                                        DOKUMEN NOTULEN
                                                    </h6>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NOTA DINAS HASIL GELAR PERKARA</td>
                                        <td>
                                            @if (isset($ndHGP))
                                                <a href="/nd-hasil-gelar-perkara/{{ $kasus->id }}">
                                                    <button type="button" class="btn btn-outline-primary text-primary">
                                                        <h6 class="p-0 m-0">
                                                            <i class="fas fa-print"></i>
                                                            DOKUMEN ND LAPORAN
                                                        </h6>
                                                    </button>
                                                </a>
                                            @else
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#modal_nd_laporan_hasil_gelar">
                                                    <button type="button" class="btn btn-outline-primary text-primary">
                                                        <h6 class="p-0 m-0">
                                                            <i class="fas fa-plus"></i>
                                                            DOKUMEN ND LAPORAN
                                                        </h6>
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SP2HP2 AKHIR</td>
                                        <td>
                                            <a href="/surat-sp2hp2-akhir/{{ $kasus->id }}">
                                                <button type="button" class="btn btn-outline-primary text-primary">
                                                    <h6 class="p-0 m-0">
                                                        <i class="fas fa-print"></i>
                                                        DOKUMEN SP2HP2 AKHIR
                                                    </h6>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    @if ($lhp->hasil_penyelidikan == '1')
                                        <tr>
                                            <td>NOTA DINAS KA. LITPERS</td>
                                            <td>
                                                @if (isset($litpers))
                                                    <a href="/gelar-perkara-baglitpers/{{ $kasus->id }}">
                                                        <button type="button"
                                                            class="btn btn-outline-primary text-primary">
                                                            <h6 class="p-0 m-0">
                                                                <i class="fas fa-print"></i> 
                                                                DOKUMEN ND KA. LITPERS
                                                            </h6>
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="" data-bs-toggle="modal"
                                                        data-bs-target="#modal_litpers">
                                                        <button type="button"
                                                            class="btn btn-outline-primary text-primary">
                                                            <h6 class="p-0 m-0">
                                                                <i class="fas fa-plus"></i> 
                                                                DOKUEN ND KA. LITPERS
                                                            </h6>
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan

    </div>

    @can('edit-gelar_perkara')
        @if (isset($kasus) & ($kasus->status_id == 5) & ($lhp->hasil_penyelidikan == '1'))
            <div class="row mt-3">
                <div class="col-lg-6">
                    @if (!empty($ugp))
                        <form action="/data-kasus/update" method="post">
                            @csrf
                            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden
                                name="kasus_id">
                            <input type="text" class="form-control" value="6" hidden name="disposisi_tujuan"
                                hidden>
                            <button class="btn btn-success" name="type_submit" {{ $kasus->status_id > 5 ? 'disabled' : '' }} value="update_status">
                                LANJUTKAN KE LIMPAH
                            </button>
                            @if ($kasus->status_id == 5 && $nd_hasil_gelar)
                                <button class="btn btn-danger" id="rj">RESTORATIVE JUSTICE</button>
                            @endif
                        </form>
                    @endif
                </div>

            </div>
        @endif
    @endcan

</div>

<!-- Modal undangan gelar penyelidikan -->
<div class="modal fade" id="modal_undangan_gelar_perkara" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UNDANGAN GELAR PERKARA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(5)"></button>
            </div>
            <div class="modal-body">
                <form action="/gelar-perkara-undangan/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" name="tanggal_gelar_perkara"
                                        class="form-control border-dark" id="tanggal_gelar_perkara"
                                        placeholder="TANGGAL GELAR PERKARA" required>
                                    <label for="tanggal_gelar_perkara">TANGGAL PELAKSANAAN GELAR PERKARA</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="time" name="waktu_gelar_perkara" class="form-control border-dark"
                                        id="waktu_gelar_perkara" placeholder="WAKTU GELAR PERKARA" required>
                                    <label for="waktu_gelar_perkara">WAKTU PELAKSANAAN GELAR PERKARA</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark"
                                        name="tempat_gelar_perkara" id="tempat_gelar_perkara"
                                        placeholder="TEMPAT GELAR PERKARA" required>
                                    <label for="tempat_gelar_perkara">TEMPAT PELAKSANAAN GELAR PERKARA</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <select class="form-select border-dark bg-dark" name="pimpinan" id="pimpinan"
                                    required style="background-color: var(--tb-card-bg-custom)">
                                    <option value="">PILIH PIMPINAN GELAR</option>
                                    @if (isset($pimpinans))
                                        @foreach ($pimpinans as $key => $pim)
                                            <option value="{{ $pim->id }}">{{ $pim->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <button type="submit" class="form-control btn btn-primary">SIMPAN</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal ND Laporan Hasil Gelar Penyelidikan -->
<div class="modal fade" id="modal_nd_laporan_hasil_gelar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NOTA DINAS LAPORAN HASIL GELAR PENYELIDIKAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(5)"></button>
            </div>
            <div class="modal-body">
                <form action="/nd-hasil-gelar-perkara/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating ">
                                    <input type="text" class="form-control border-dark" name="no_surat"
                                        placeholder="MASUKAN NO. NOTA DINAS LAPORAN HASIL GELAR PENYELIDIKAN" required>
                                    <label for="no_nd_gelar_penyelidikan">NO. NOTA DINAS LAPORAN HASIL GELAR PENYELIDIKAN</label>
                                </div>
                            </div>
                            <div class="form-outline mb-3">
                                <div class="form-floating">
                                    <select class="form-select border-dark" aria-label="Default select example"
                                        name="limpah_biro" id="limpah_biro" required>
                                        <option value="">-- PILIH LIMPAH --</option>
                                        @if ($kasus->wujudPerbuatan->jenis_wp == 'disiplin')
                                            <option value="1">PROVOS</option>
                                        @elseif ($kasus->wujudPerbuatan->jenis_wp == 'kode etik')
                                            <option value="2">WABPROF</option>
                                        @endif
                                        <option value="3">BID PROPAM POLDA</option>
                                    </select>
                                    <label for="limpah_biro" class="form-label">LIMPAH</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <button type="submit" class="form-control btn btn-primary">SIMPAN</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal ND Laporan Hasil Gelar Penyelidikan -->
<div class="modal fade" id="modal_litpers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UNDANGAN GELAR PERKARA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="getViewProcess(5)"></button>
            </div>
            <div class="modal-body">
                <form action="/gelar-perkara-baglitpers/{{ $kasus->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <div class="form-floating ">
                                    <input type="text" class="form-control border-dark" name="pasal"
                                        placeholder="MASUKAN PASAL PELANGGARAN" required>
                                    <label for="pasal">MASUKAN PASAL PELANGGARAN</label>
                                </div>
                            </div>
                            <div class="form-outline mb-3">
                                <div class="form-floating ">
                                    <input type="text" class="form-control border-dark" name="ayat"
                                        placeholder="MASUKAN AYAT PELANGGARAN" required>
                                    <label for="ayat">MASUKAN AYAT PELANGGARAN</label>
                                </div>
                            </div>
                            <div class="form-outline mb-3">
                                <div class="form-floating ">
                                    <textarea class="form-control border-dark" name="bunyi_pasal" id="bunyi_pasal"
                                        placeholder="MASUKAN BUNYI PASAL PELANGGARAN" style="height: 100px" required></textarea>
                                    <label for="bunyi_pasal">MASUKAN BUNYI PASAL PELANGGARAN</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-outline mb-3">
                                <button type="submit" class="form-control btn btn-primary">SIMPAN</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#pimpinan').select2({
            theme: "bootstrap-5"
        })

        $('#rj').on('click', function() {
            let id = `{{ $kasus->id }}`
            Swal.fire({
                title: 'YAKIN AKAN MELAKUKAN RESTORATIVE JUSTICE (RJ) ?',
                text: "DUMAS AKAN DIHENTIKAN DENGAN STATUS RJ.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, LAKUKAN RJ !',
                cancelButtonText: 'TIDAK, BATALKAN !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/rj/' + id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('.loading').css('display', 'block')
                        },
                        success: function(data, status, xhr) {
                            $('.loading').css('display', 'none')

                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'Terhapus',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload()
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'GAGAL',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload()
                                    }
                                })
                            }

                        },
                        error: function(jqXhr, textStatus,
                            errorMessage) { // error callback
                            $('.loading').css('display', 'none')
                            console.log('error message: ', errorMessage)
                            var option = {
                                title: 'ERROR',
                                text: 'TERJADI KESALAHAN SISTEM...',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }
                            Swal.fire(option)
                        }
                    })
                }
            })
        });
    });

    $(function() {
        $("#tanggal_gelar_perkara").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id',
            beforeShow: function(input, inst) {
                setDatepickerPos(input, inst)
            },
        });
    });

    function setDatepickerPos(input, inst) {
        var rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function() {
            var scrollTop = $("body").scrollTop();
            inst.dpDiv.css({
                top: rect.top + input.offsetHeight + scrollTop
            });
        }, 0);
    }
</script>
