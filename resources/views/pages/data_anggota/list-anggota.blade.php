@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List Anggota</h4>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAnggota">
                        Tambah Anggota
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Pangkat</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NRP</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div class="modal fade" id="tambahAnggota" tabindex="-1" aria-labelledby="Tambah Anggota" aria-hidden="true">
        <form action="/tambah-anggota" method="post" id="input_data">
            @csrf
            <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="anggota_baru">

                    <div class="row">
                        <div class="col-lg-3 mb-3">
                            <div class="form-control border-dark">
                                <select class="form-select" data-choices name="pangkat[]" id="pangkat" aria-placeholder="Pangkat" required>
                                    @if (isset($pangkat))
                                        <option value="">-- Pilih Pangkat --</option>
                                        @foreach ($pangkat as $key => $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nama[]" id="nama" placeholder="Nama" required>
                                <label for="nama">Nama</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp[]" id="nrp" placeholder="NRP" required>
                                <label for="nrp">NRP</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="jabatan[]" id="jabatan" placeholder="Jabatan" required>
                                <label for="jabatan">Jabatan</label>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="tambah"><i class="far fa-user-plus"></i> Tambah Anggota</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit Anggota -->
    <div class="modal fade" id="editAnggota" tabindex="-1" aria-labelledby="Edit Anggota" aria-hidden="true">
        <form action="/" method="post" id="edit_data">
            @csrf
            <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit_anggota">

                    <div class="row">
                        <div class="col-lg-3 mb-3">
                            <div class="form-control border-dark">
                                <select class="form-select" data-choices name="pangkat" id="pangkat" aria-placeholder="Pangkat" required>
                                    @if (isset($pangkat))
                                        <option value="">-- Pilih Pangkat --</option>
                                        @foreach ($pangkat as $key => $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nama" id="nama" placeholder="Nama" required>
                                <label for="nama">Nama</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP" required>
                                <label for="nrp">NRP</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan" required>
                                <label for="jabatan">Jabatan</label>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" disabled>Update</button>
                </div>
            </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            getData();

            $('#tambah').on('click', function() {
                $.ajax({
                    url : 'api/all-pangkat',
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $('.loading').css('display', 'block')
                    }, 
                    success: function (data, status, xhr) {
                        $('.loading').css('display', 'none')
                        
                        let pangkat = Object.values(data.data.pangkat)
                        let option = ''
                        pangkat.forEach(element => {
                            let opt = `<option value="`+element.id+`">`+element.name+`</option>`
                            option += opt
                        });
                        let html = `<div class="row"><div class="col-lg-3 mb-3"><div class="form-control border-dark"><select class="form-select" data-choices name="pangkat[]" id="pangkat" aria-placeholder="Pangkat" required><option value="">-- Pilih Pangkat --</option>`+option+`</select></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nama[]" id="nama" placeholder="Nama" required><label for="nama">Nama</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nrp[]" id="nrp" placeholder="NRP" required><label for="nrp">NRP</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="jabatan[]" id="jabatan" placeholder="Jabatan" required><label for="jabatan">Jabatan</label></div></div></div>`
                        $('.modal-body').append(html)
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        $('.loading').css('display', 'none')
                        var option = {
                            title: 'Error',
                            text: 'Terjadi Kesalahan Sistem...',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }
                        Swal.fire(option) 
                    }
                })
            })
        });

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('get.anggota') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nrp',
                        name: 'nrp'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }

        function deleteAnggota(id) {
            // console.log(id)
            Swal.fire({
                title: 'Yakin akan menghapus Data Anggota ?',
                text: "Data akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'terhapus!',
                    'Data Anggota telah terhapus',
                    'success'
                    )
                }
            })
        }
    </script>
@endsection
