@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <!-- DataTable list pelanggar -->
    <div class="row">
        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
            <h5 class="mb-0 pb-1 text-decoration-underline">ROLE USER PAMINAL</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">ROLES</h5>
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#add_role"><i class="ri-add-line align-bottom me-1"></i>TAMBAH ROLE</button>
                </div>
            </div>

            <div class="card-body">
                @include('partials.message')
                <div class="table-responsive table-card px-3" style="min-height: 500px;">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NAMA ROLE</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-cogs"></i> SETTING
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item" href="/role/permission/{{ $role->id }}">
                                                    <i class="bx bx-edit-alt me-1"></i> SET PERMISSION
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="editRole({{$role->id}})">
                                                    <i  class="bx bx-edit me-1"></i> EDIT
                                                </a>
                                                <a class="dropdown-item" href="#" type="button" class="btn" onclick="deleteRole({{$role->id}})">
                                                    <i  class="bx bx-trash me-1"></i> DELETE
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="add_role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BUAT ROLE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/role/save" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">NAMA ROLE</label>
                            <input type="text" class="form-control" name="name" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="edit_role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT ROLE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="formEditRole">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">NAMA ROLE</label>
                            <input type="text" class="form-control border-dark" name="name" id="editName" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function deleteRole(id) {
            Swal.fire({
                title: 'Yakin menghapus role?',
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
                        url: '/role/destroy/' + id,
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

        function editRole(id) {
            $.ajax({
                url: '/role/edit/' + id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('.loading').css('display', 'block')
                },
                success: function(data, status, xhr) {
                    $('.loading').css('display', 'none')
                    $('#edit_role').modal('show');
                    $('#formEditRole').attr('action', "/role/update/"+data.role.id)
                    $('#editName').attr('value', data.role.name)
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


    </script>
@endsection
