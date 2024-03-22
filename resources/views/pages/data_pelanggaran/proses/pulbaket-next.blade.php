<!--Informasi Pulbaket-->

<div class="card border-0">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">TANGGAL BAI PELAPOR</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                        aria-describedby="emailHelp"
                        value="{{ isset($bai_pelapor) ? Carbon\Carbon::parse($bai_pelapor->created_at)->translatedFormat('d-m-Y') : '' }}"
                        autocomplete="off" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">TANGGAL BAI TERLAPOR</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                        aria-describedby="emailHelp"
                        value="{{ isset($bai_terlapor) ? Carbon\Carbon::parse($bai_terlapor->created_at)->translatedFormat('d-m-Y') : '' }}"
                        autocomplete="off" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">TANGGAL PERMOHONAN GELAR PERKARA</label>
                    <input type="text" class="form-control border-dark"
                        id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                        value="{{ isset($nd_pgp) ? Carbon\Carbon::parse($nd_pgp->created_at)->translatedFormat('d-m-Y') : '' }}"
                        autocomplete="off" readonly>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">HASIL PENYELIDIKAN</label>
                    <input type="text" class="form-control border-dark"
                        id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                        value="{{ isset($lhp) ? ($lhp->hasil_penyelidikan == 1 ? 'DITEMUKAN CUKUP BUKTI' : 'BELUM DITEMUKAN CUKUP BUKTI') : '' }}"
                        autocomplete="off" readonly>
                </div>
            </div>
        </div>
        @if ($saksis)
            <div class="card border-dark">
                <div class="card-header">
                    DAFTAR SAKSI YANG DIAJUKAN PELAPOR
                </div>
                <div class="card-body">
                    {{ $history_saksi == '' ? '-' : $history_saksi->saksi }}
                </div>
            </div>
            <div class="card border-dark">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">DAFTAR SAKSI DITERIMA</h4>
                    @can('edit-pulbaket')
                        <a href="#!" class="btn btn-outline-warning text-warning px-2" data-bs-toggle="modal"
                            data-bs-target="#modal_tambah_saksi">
                            <h6 class="p-0 m-0"><i class="far fa-user-plus"></i> TAMBAH SAKSI</h6>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-saksi">
                            <tbody>
                                @foreach ($saksis as $key => $saksi)
                                    <tr>
                                        <td>{{ $saksis[$key]['nama'] }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @can('edit-pulbaket')
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">NAMA KEGIATAN</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>UNDANGAN KLARIFIKASI</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <a href="javascript::void(0)" class="btn btn-outline-primary text-primary"
                                                data-bs-toggle="modal" data-bs-target="#modal_undangan_sipil">
                                                <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> UNDANGAN</h6>
                                            </a>
                                        </div>
                                    </div>


                                </td>
                            </tr>
                            <tr>
                                <td>BERITA ACARA INTEROGASI</td>
                                <td>
                                    <div class="row">
                                        @if ($kasus->tipe_data == '1')
                                            <div class="col-lg-6">
                                                <a href="/bai-sipil/{{ $kasus->id }}"
                                                    class="btn btn-outline-primary text-primary">
                                                    <h6 class="p-0 m-0">
                                                        <i class="far fa-file-plus"></i> DOKUMEN BAI PELAPOR
                                                    </h6>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="col-lg-6">
                                            <a href="/bai-anggota/{{ $kasus->id }}"
                                                class="btn btn-outline-primary text-primary">
                                                <h6 class="p-0 m-0">
                                                    <i class="far fa-file-plus"></i> DOKUMEN BAI TERLAPOR
                                                </h6>
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>LAPORAN HASIL PENYELIDIKAN</td>
                                <td>
                                    @if (!isset($lhp))
                                        <button class="btn btn-outline-primary text-primary" data-bs-toggle="modal"
                                            data-bs-target="#lhp">
                                            <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> BUAT DOKUMEN</h6>
                                        </button>
                                    @else
                                        <a href="/laporan-hasil-penyelidikan/{{ $kasus->id }}"
                                            class="btn btn-outline-success text-success">
                                            <h6 class="p-0 m-0"><i class="far fa-download"></i> DOWNLOAD DOKUMEN</h6>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>ND PERMOHONAN GELAR PERKARA</td>
                                <td>
                                    @if (!$nd_pgp)
                                        <button class="btn btn-outline-primary text-primary" data-bs-toggle="modal"
                                            data-bs-target="#nd_permohonan_gelar_perkara">
                                            <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> BUAT DOKUMEN</h6>
                                        </button>
                                    @else
                                        <a href="/nd-permohonan-gerlar/{{ $kasus->id }}"
                                            class="btn btn-outline-success text-primary">
                                            <h6 class="p-0 m-0"><i class="far fa-download"></i> DOWNLOAD DOKUMEN</h6>
                                        </a>
                                    @endif


                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endcan
</div>


@can('edit-pulbaket')
    @if (isset($kasus) & ($kasus->status_id == 4))
        <div class="row mt-4">
            <div class="col-lg-12">
                <form action="/data-kasus/update" method="post">
                    @csrf
                    <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
                    <input type="text" class="form-control" value="5" hidden name="disposisi_tujuan" hidden>
                    <button class="btn btn-success" name="type_submit" {{ $kasus->status_id > 4 ? 'disabled' : '' }}
                        value="update_status">
                        LANJUTKAN KE PROSES GELAR PENYELIDIKAN
                    </button>
                    @if ($kasus->status_id != 5)
                        <button class="btn btn-danger" id="rj">RESTORATIVE JUSTICE</button>
                    @endif
                </form>
            </div>
        </div>
    @endif
@endcan
