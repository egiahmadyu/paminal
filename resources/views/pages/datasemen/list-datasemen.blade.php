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
                    <h4 class="card-title mb-0 flex-grow-1">Datasemen</h4>
                    <a type="button" class="btn btn-success" href="/tambah-datasemen">
                        Tambah Datasemen
                    </a>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Datasemen</th>
                                    <th scope="col">Kepala Datasemen</th>
                                    <th scope="col">Wakil Kepala Datasemen</th>
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
                searching: false,
                ajax: {
                    url: "{{ route('get.datasemen') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'kaden',
                        name: 'kaden'
                    },
                    {
                        data: 'wakaden',
                        name: 'wakaden'
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

        function deleteDatasemen(id) {
            Swal.fire({
                title: 'Yakin menghapus data?',
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
                        url : 'delete-datasemen/'+id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $('.loading').css('display', 'block')
                        }, 
                        success: function (data, status, xhr) {
                            $('.loading').css('display', 'none')

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
