<!--Informasi Pulbaket-->

<div class="card border-0">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">Tanggal BAI Pelapor</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                        aria-describedby="emailHelp"
                        value="{{ isset($bai_pelapor) ? Carbon\Carbon::parse($bai_pelapor->created_at)->translatedFormat('d-m-Y') : '' }}"
                        readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">Tanggal BAI Terlapor</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"
                        aria-describedby="emailHelp"
                        value="{{ isset($bai_terlapor) ? Carbon\Carbon::parse($bai_terlapor->created_at)->translatedFormat('d-m-Y') : '' }}"
                        readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">Tanggal Permohonan Gelar Perkara</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                        value="{{ isset($nd_pgp) ? Carbon\Carbon::parse($nd_pgp->created_at)->translatedFormat('d-m-Y') : '' }}"
                        readonly>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-buat-surat col-lg-12 mb-3">
                    <label for="tgl_pembuatan_surat_perintah" class="form-label">Hasil Penyelidikan</label>
                    <input type="text" class="form-control border-dark" id="tgl_pembuatan_surat_perintah"aria-describedby="emailHelp"
                        value="{{ isset($lhp) ? ($lhp->hasil_penyelidikan == 1 ? 'Ditemukan Cukup Bukti' : 'Belum Ditemukan Cukup Bukti') : '' }}"
                        readonly>
                </div>
            </div>
        </div>
        @if ($saksis)
            <div class="card border-dark">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">LIST SAKSI</h4>
                    @can('edit-pulbaket')
                    <a href="#!" class="btn btn-outline-warning text-warning px-2"
                        data-bs-toggle="modal" data-bs-target="#modal_tambah_saksi">
                        <h6 class="p-0 m-0"><i class="far fa-user-plus"></i> TAMBAH SAKSI</h6>
                    </a>
                @endcan
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-saksi">
                            <tbody>
                                @foreach ($saksis as $key => $saksi)
                                    <tr>
                                        <td>{{ $saksis[$key]['nama'] }}</td>
                                        {{-- <td><a href="#" onclick="undanganSaksi({{$saksi->id}})"><i class="far fa-file-plus"></i> BUAT UNDANGAN KLARIFIKASI</a></td> --}}
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="card border-dark">
                <div class="card-header">
                    <h4>Saksi</h4>
                    @can('edit-pulbaket')
                        <a href="#!" class="btn btn-outline-warning text-warning px-2"
                                data-bs-toggle="modal" data-bs-target="#modal_tambah_saksi">
                            <h6 class="p-0 m-0"><i class="far fa-user-plus"></i> Saksi</h6>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($saksis as $i => $saksi)
                        <div class="col-lg-6">
                            <h5>
                                {{ $saksis[$i]['nama'] }}
                            </h5>
                            
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="#" id="undangan_saksi" onclick="undanganSaksi({{$saksi->id}})">
                                <i class="far fa-file-plus"></i> Undangan Klarifikasi
                            </a>
                        </div>
                        @endforeach
                        
                    </div>

                </div>
            </div>   --}}
        @endif
    </div>
    @can('edit-pulbaket')
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Undangan Klarifikasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <a href="javascript::void(0)" class="btn btn-outline-primary text-primary"
                                                data-bs-toggle="modal" data-bs-target="#modal_undangan_sipil">
                                                <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Undangan</h6>
                                            </a>
                                        </div>
                                    </div>
            
            
                                </td>
                            </tr>
                            <tr>
                                <td>Berita Acara Intograsi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="/bai-sipil/{{ $kasus->id }}" class="btn btn-outline-primary text-primary">
                                                <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Dokumen BAI Pelapor</h6>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="/bai-anggota/{{ $kasus->id }}" class="btn btn-outline-primary text-primary">
                                                <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Dokumen BAI Terduga Pelanggar</h6>
                                            </a>
                                        </div>
                                    </div>
            
                                </td>
                            </tr>
                            <tr>
                                <td>Laporan Hasil Penyelidikan</td>
                                <td>
                                    @if (!isset($lhp))
                                        <button class="btn btn-outline-primary text-primary" data-bs-toggle="modal"
                                            data-bs-target="#lhp">
                                            <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Buat Dokumen</h6>
                                        </button>
                                    @else
                                        <a href="/laporan-hasil-penyelidikan/{{ $kasus->id }}"
                                            class="btn btn-outline-success text-success">
                                            <h6 class="p-0 m-0"><i class="far fa-download"></i> Download Dokumen</h6>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>ND Permohonan Gelar Perkara</td>
                                <td>
                                    @if (!$nd_pgp)
                                        <button class="btn btn-outline-primary text-primary" data-bs-toggle="modal"
                                            data-bs-target="#nd_permohonan_gelar_perkara">
                                            <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Buat Dokumen</h6>
                                        </button>
                                    @else
                                        <a href="/nd-permohonan-gerlar/{{ $kasus->id }}"
                                            class="btn btn-outline-success text-primary">
                                            <h6 class="p-0 m-0"><i class="far fa-download"></i> Download Dokumen</h6>
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
    @if (isset($kasus) & ($kasus->status_id === 4))
    <div class="row mt-4">
        <div class="col-lg-12">
            <form action="/data-kasus/update" method="post">
                @csrf
                <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
                <input type="text" class="form-control" value="5" hidden name="disposisi_tujuan" hidden>
                <button class="btn btn-success" name="type_submit" {{ $kasus->status_id > 4 ? 'disabled' : '' }}
                    value="update_status">
                    Lanjutkan ke proses Gelar Penyelidikan
                </button>
            </form>
        </div>
    </div>
    @endif
@endcan


