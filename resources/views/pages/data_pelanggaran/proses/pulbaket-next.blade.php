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
                        <a href="http://"><i class="fas fa-print"></i>
                            Undangan Pelapor</a> | <a href="http://"><i class="fas fa-print"></i>
                            Undangan Terlapor</a>
                        {{-- <button type="button" class="btn btn-warning btn-sm">Tambah Saksi</button> --}}
                    </td>
                </tr>
                <tr>
                    <td>Berita Acara Intograsi</td>
                    <td>
                        <a href="/bai-sipil/{{ $kasus->id }}"><i class="fas fa-print"></i>
                            BAI Pelapor</a> | <a href="/bai-anggota/{{ $kasus->id }}"><i class="fas fa-print"></i>
                            BAI Terlapor</a>
                    </td>
                </tr>
                <tr>
                    <td>Laporan Hasil Penyelidikan</td>
                    <td>
                        <a href="/laporan-hasil-penyelidikan/{{ $kasus->id }}"><i class="fas fa-print"></i>
                            LHP</a>
                    </td>
                </tr>
                <tr>
                    <td>ND Permohonan Gelar Perkara</td>
                    <td>
                        <a href="/nd-permohonan-gerlar/{{ $kasus->id }}"><i class="fas fa-print"></i>
                            ND Perrmohonan Gelar Perkara</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="5" hidden name="disposisi_tujuan" hidden>
            <button class="btn btn-success" name="type_submit" {{ $kasus->status_id > 4 ? 'disabled' : '' }}
                value="update_status">Lanjutkan
                ke proses Gelar Penyelidikan</button>
        </form>
    </div>
</div>
