@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item"><a href="/">UNIT DETASEMEN</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#"> {{ $title }}
                    {{ $unit->unit }} </a> </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $title }} {{ $unit->unit }} </h4>
                    @can('edit-anggota_unit')
                        <a type="button" class="btn btn-outline-success" id="tambah_anggota">
                            TAMBAH ANGGOTA UNIT
                        </a>
                    @endcan
                    @can('edit-anggota')
                        <a type="button" class="btn btn-outline-info ms-3" href="/list-anggota">
                            TAMBAH ANGGOTA PAMINAL
                        </a>
                    @endcan

                </div>
                <div class="card-header" id="form_tambah_anggota" hidden>
                    <form action="/tambah-anggota-unit/{{ $id_unit }}" method="post">
                        @csrf
                        <div class="row" id="isi_form">
                            <div class="col-lg-6 mb-3">
                                <select class="form-select border-dark" data-choices name="anggota" id="anggota" required>
                                    <option value="">-- PILIH ANGGOTA --</option>
                                    @if (isset($anggota))
                                        @foreach ($anggota as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    SIMPAN
                                </button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
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
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            getData();

            $('#tambah_anggota').on('click', function() {
                $('#form_tambah_anggota').removeAttr('hidden')
            })
        });

        function getData() {
            let id = `{{ $id_unit }}`
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: `/get-detail-unit/` + id,
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [{
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

        function editAnggotaUnit(id) {
            $.ajax({
                url: 'edit-anggota-unit/' + id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('.loading').css('display', 'block')
                },
                success: function(data, status, xhr) {
                    $('.loading').css('display', 'none')

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

        function deleteAnggotaUnit(id) {
            Swal.fire({
                title: 'Yakin menghapus anggota Unit?',
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
                        url: '/delete-anggota-unit/' + id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('.loading').css('display', 'block')
                        },
                        success: function(data, status, xhr) {
                            $('.loading').css('display', 'none')

                            Swal.fire({
                                title: 'Terhapus',
                                text: 'Data berhasil terhapus...',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
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
