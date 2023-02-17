<div class="row mt-4">
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
                    <td>Undangan Klarifikasi</td>
                    <td>
                        {{-- <button type="button" class="btn btn-primary">Buat Undangan <i class="far fa-file-plus"></i></button>
                        <button type="button" class="btn btn-warning">Tambah Saksi <i class="far fa-user-plus"></i></button> --}}
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <a href="#" class="btn btn-outline-primary text-primary"> <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Undangan</h6> </a>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <a href="#!" class="btn btn-outline-warning text-warning px-2" data-bs-toggle="modal" data-bs-target="#modal_tambah_saksi"> <h6 class="p-0 m-0"><i class="far fa-user-plus"></i> Saksi</h6> </a>
                            </div>
                        </div>
                        
                        
                    </td>
                </tr>
                <tr>
                    <td>Berita Acara Intograsi</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary text-primary"> <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Dokumen BAI</h6> </a>
                    </td>
                </tr>
                <tr>
                    <td>Laporan Hasil Penyelidikan</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary text-primary"> <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Dokumen</h6> </a>
                        {{-- <button type="button" class="btn btn-outline-primary text-primary">Buat Dokumen</button> --}}
                    </td>
                </tr>
                <tr>
                    <td>ND Permohonan Gelar Perkara</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary text-primary"> <h6 class="p-0 m-0"><i class="far fa-file-plus"></i> Dokumen</h6> </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@if ( isset($kasus) & $kasus->status_id === 4)
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
@else
    
@endif

