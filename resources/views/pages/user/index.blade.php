@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    {{-- Title --}}
    <!-- STAT -->

    <!-- DataTable list pelanggar -->
    <div class="row">
        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
            <h5 class="mb-0 pb-1 text-decoration-underline">Paminal User</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Daftar User</h5>
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-outline-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#add_user"><i class="ri-add-line align-bottom me-1"></i>Tambah User</button>
                </div>
            </div>

            <div class="card-body">
                @include('partials.message')
                <div class="table-responsive table-card px-3">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->getRoleNames()[0] }}</td>
                                    <td>
                                        <a href="#" type="button" class="btn btn-sm btn-outline-info">Reset Password</a>
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="editData({{$user->id}})">Edit User</button>
                                        <a href="/user/destroy/{{$user->id}}" type="button" class="btn btn-sm btn-outline-danger">Hapus User</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/user/save" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="datasemen" class="form-label">Bag / Detasemen</label>
                            <select class="form-select" id="datasemen" data-choices name="datasemen" required>
                                <option value="">Pilih Datasemen</option>
                                @foreach ($datasemens as $datasemen)
                                    <option value="{{ $datasemen->id }}">{{ $datasemen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="unit">
                            <label for="unit" class="form-label">UNIT</label>
                            <select class="form-select" data-choice aria-label="Default select example" name="unit">
                                <option selected>Pilih Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" aria-label="Default select example" name="role" required>
                                <option selected>Open this select menu</option>
                                @foreach ($roles as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#datasemen').on('change', function() {
            let val = $('#datasemen').find(":selected").val()
            if (val != 0) {
                $.ajax({
                    url : 'api/get-unit/'+val,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $('.loading').css('display', 'block')
                    }, 
                    success: function (data, status, xhr) {
                        $('.loading').css('display', 'none')
                        console.log(data)

                        let unit = Object.values(data.data.unit)
                        let option = '<option value="">Pilih Unit</option>'
                        let html = ''
                        console.log(unit.length)
                        if (unit.length == 0) {
                            html = `<label for="unit" class="form-label">UNIT</label>
                                <select class="form-select" data-choices aria-label="Default select example" name="unit" disabled>
                                    <option value="">-- Unit Belum Tersedia --</option>
                                </select>`
                        } else {
                            option += `<option value="">KABAG / KADEN</option>`
                            unit.forEach(element => {
                                let opt = `<option value="`+element.id+`">`+element.unit+`</option>`
                                option += opt
                            });
                            
                            console.log(option)
                            html = `<label for="unit" class="form-label">UNIT</label>
                                <select class="form-select" data-choices aria-label="Default select example" name="unit">
                                    `+option+`
                                </select>`
                            // html = `<select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" required><option value="">-- Pilih Unit --</option>`+option+`</select><label for="unit_den_bag" class="form-label">Unit</label>`
                        }
                        
                        $('#unit').empty()
                        $('#unit').append(html)
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
            
        });
    });

    function editData(id) {
        let url = `/user/edit/${id}`
        $.ajax(url, {
            type: 'get',
            dataType: 'json',
            beforeSend: function () {
                Swal.fire({
                    html: "<h5>Please Wait...</h5>",
                    customClass: {
                    },
                    buttonsStyling: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                })
                Swal.showLoading()
            },
            success: function (data, status, xhr) {   // success callback function
                Swal.close()
                console.log(data)
                let datas = data.data
                let user = datas.user
                let datasemens = datas.all_datasemen
                let datasamen = datas.datasemen

                $('#name').val(user.name);
                $('#username').val(user.username);
                $('#jabatan').val(user.jabatan);

                

                $('#add_user').modal('toggle')
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback
                $('.load_process').css('display', 'none')
                let text = jqXhr.responseJSON?.message == undefined ? "Terjadi Kesalahan Pada Sistem!" : jqXhr.responseJSON.message
                var option = {
                    text: text,
                    pos: 'top-center',
                    backgroundColor: '#e7515a'
                }
                // Snackbar.show(option);
                window[onerror](errorMessage);
            }
        })
    }
</script>
@endsection
