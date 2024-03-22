@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}
@endprepend


@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#"> {{ $title }} </a> </li>
        </ol>
    </nav>

    @include('partials.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @can('edit-anggota')
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAnggota">
                            TAMBAH ANGGOTA
                        </button>
                    </div>
                @endcan

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">PANGKAT</th>
                                    <th scope="col">NAMA</th>
                                    <th scope="col">NRP</th>
                                    <th scope="col">JABATAN</th>
                                    <th scope="col">ACTION</th>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">TAMBAH ANGGOTA</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="anggota_baru">

                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <div class="form-control border-dark">
                                    <select class="form-select" data-choices name="pangkat[]" id="pangkat"
                                        aria-placeholder="Pangkat" required>
                                        @if (isset($pangkat))
                                            <option value="">-- PILIH PANGKAT --</option>
                                            @foreach ($pangkat as $key => $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->alias }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nama[]" id="nama"
                                        placeholder="Nama" autocomplete="off" required>
                                    <label for="nama">NAMA</label>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nrp[]" id="nrp"
                                        placeholder="NRP" autocomplete="off" required>
                                    <label for="nrp">NRP</label>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="jabatan[]" id="jabatan"
                                        placeholder="Jabatan" autocomplete="off" required>
                                    <label for="jabatan">JABATAN</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="tambah"><i class="far fa-user-plus"></i>
                            Tambah Anggota</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit Anggota -->
    <div class="modal fade" id="editAnggota" tabindex="-1" aria-labelledby="Edit Anggota" aria-hidden="true">
        <form action="" method="POST" id="edit_data">
            @csrf
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Anggota</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="edit_anggota">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            getData();

            $('#tambah').on('click', function() {
                $.ajax({
                    url: 'api/all-pangkat',
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('.loading').css('display', 'block')
                    },
                    success: function(data, status, xhr) {
                        $('.loading').css('display', 'none')

                        let pangkat = Object.values(data.data.pangkat)
                        let option = ''
                        pangkat.forEach(element => {
                            let opt = `<option value="` + element.id + `">` + element
                                .alias + `</option>`
                            option += opt
                        });
                        let html =
                            `<div class="row"><div class="col-lg-3 mb-3"><div class="form-control border-dark"><select class="form-select" data-choices name="pangkat[]" id="pangkat" aria-placeholder="Pangkat" required><option value="">-- PILIH PANGKAT --</option>` +
                            option +
                            `</select></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nama[]" id="nama" placeholder="NAMA" autocomplete="off" required><label for="nama">NAMA</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nrp[]" id="nrp" placeholder="NRP" autocomplete="off" required><label for="nrp">NRP</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="jabatan[]" id="jabatan" placeholder="JABATAN" autocomplete="off" required><label for="jabatan">JABATAN</label></div></div></div>`
                        $('.modal-body').append(html)
                    },
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
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
                searching: true,
                ajax: {
                    url: "{{ route('get.anggota') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [{
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

            // $('#kt_search').on('click', function(e) {
            //     e.preventDefault();
            //     table.table().draw();
            // });
        }

        function editAnggota(id) {
            console.log(id)
            $.ajax({
                url: 'edit-anggota/' + id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('.loading').css('display', 'block')
                },
                success: function(data, status, xhr) {
                    $('.loading').css('display', 'none')
                    let pangkat = Object.values(data.pangkat)
                    let anggota = data.anggota

                    let option = ''
                    pangkat.forEach(element => {
                        let selected = ''
                        if (element.id == anggota.pangkat) {
                            selected = 'selected'
                        }
                        option += '<option value="' + element.id + '" ' + selected + '>' + element
                            .alias + '</option>'
                    });

                    console.log(anggota)

                    let select =
                        `<div class="form-control border-dark"><select class="form-select" data-choices name="pangkat" id="pangkat" aria-placeholder="Pangkat" required><option value="">-- Pilih Pangkat --</option>` +
                        option + `</select></div>`

                    let html = `<div class="row"><div class="col-lg-3 mb-3">` + select +
                        `</div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nama" id="nama" placeholder="Nama" value="` +
                        anggota.nama +
                        `" autocomplete="off" required><label for="nama">Nama</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP" value="` +
                        anggota.nrp +
                        `" autocomplete="off" required><label for="nrp">NRP</label></div></div><div class="col-lg-3 mb-3"><div class="form-floating"><input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan" value="` +
                        anggota.jabatan + `" autocomplete="off" required><label for="jabatan">Jabatan</label></div></div></div>`

                    $('#edit_anggota').empty()
                    $('#editAnggota').modal('show');
                    $('#edit_data').attr('action', '/update-anggota/' + id)
                    $('#edit_anggota').append(html)
                },
                error: function(jqXhr, textStatus, errorMessage) { // error callback
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
        }

        function deleteAnggota(id) {
            Swal.fire({
                title: 'Yakin menghapus data Unit?',
                text: "Data akan terhapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data!',
                cancelButtonText: 'Tidak, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete-anggota/' + id,
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
                                    title: 'Gagal',
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
                        error: function(jqXhr, textStatus, errorMessage) { // error callback
                            $('.loading').css('display', 'none')
                            console.log('error message: ', errorMessage)
                            var option = {
                                title: 'Error',
                                text: 'Terjadi Kesalahan Sistem...',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }
                            Swal.fire(option)
                        }
                    })
                }
            })

        }
    </script>
@endsection
