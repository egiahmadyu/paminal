@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#"> {{ $title }} </a> </li>
        </ol>
    </nav>

    @include('partials.message')    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                    @can('manage-auth')
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#tambahUnit">
                            TAMBAH UNIT
                        </button>
                    @endcan
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">DETASEMEN</th>
                                    <th scope="col">UNIT</th>
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

    <!-- Modal create permission -->
    <div class="modal fade" id="tambahUnit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BUAT UNIT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/store-unit" method="POST" id="form_unit">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="nama" placeholder="Nama Unit" autocomplete="off" required>
                            <label for="exampleFormControlInput1" class="form-label">NAMA UNIT</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select border-dark" aria-label="Default select example" name="datasemen" id="tipe_data" required>
                                <option value="">-- PILIH BAG/DEN --</option>
                                @foreach ($datasemen as $den)
                                    <option value="{{ $den->id }}">{{ $den->name }}</option>
                                @endforeach
                            </select>
                            <label for="tipe_data" class="form-label">BAG / DEN</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">BUAT</button>
                    </div>
                </form>
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
        });

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('get.unit') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [
                    
                    {
                        data: 'datasemen',
                        name: 'datasemen'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
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

        function editUnit(id) {
            
            $.ajax({
                url : 'edit-unit/'+id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $('.loading').css('display', 'block')
                }, 
                success: function (data, status, xhr) {
                    $('.loading').css('display', 'none')
                    let datasemen = Object.values(data.datasemen)
                    let unit_den = data.unit.datasemen

                    // console.log(datasemen)

                    let option = ''
                    datasemen.forEach(element => {
                        console.log(element.id)
                        let selected = ''
                        if (element.id == unit_den) {
                            selected = 'selected'
                        }
                        option += '<option value="'+ element.id +'" '+selected+'>'+ element.name +'</option>'
                    });

                    let html = '@csrf<div class="modal-body"><div class="form-floating mb-3">'
                    html += '<input type="text" class="form-control border-dark" name="nama" placeholder="Nama Unit" value="'+ data.unit.unit +'" autocomplete="off" required>'
                    
                    html +=   '<label for="exampleFormControlInput1" class="form-label">Nama Unit</label></div><div class="form-floating"><select class="form-select border-dark" aria-label="Default select example" name="datasemen" id="tipe_data" required><option value="">-- Pilih Bag / Detasemen --</option>'

                    html += option

                    html += '</select><label for="tipe_data" class="form-label">Bag / Detasemen</label></div></div><div class="modal-footer"><button type="submit" class="btn btn-primary">Update</button></div>'

                    $('#form_unit').attr('action', '/update-unit/'+id)
                    $('#form_unit').empty()
                    $('#tambahUnit').modal('show')
                    $('#form_unit').append(html)
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
        }

        function deleteUnit(id) {
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
                        url : 'delete-unit/'+id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $('.loading').css('display', 'block')
                        }, 
                        success: function (data, status, xhr) {
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
                        error: function (jqXhr, textStatus, errorMessage) { // error callback
                            $('.loading').css('display', 'none')
                            console.log('error message: ',errorMessage)
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
