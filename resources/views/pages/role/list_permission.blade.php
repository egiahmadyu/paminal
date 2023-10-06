@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-end">
            <li class="breadcrumb-item active"><a href="">Permission</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Permission</h5>
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#create_permission"><i class="ri-add-line align-bottom me-1"></i>Add Permission</button>
                </div>
            </div>

            <div class="card-body">
                @include('partials.message')
                <table class="table table-centered align-middle table-nowrap mb-0" id="datalist">
                    <thead class="text-muted table-light">
                        <tr>
                            <th scope="col">Permission</th>
                            <th scope="col">Guard Name</th>
                            <th scope="col">Action
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal create permission -->
    <div class="modal fade" id="create_permission" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/permission/store" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="name" placeholder="Permission Name" required>
                            <label for="exampleFormControlInput1" class="form-label">Permission Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="guard_name" value="web" placeholder="Guard Name" disabled required>
                            <label for="exampleFormControlInput1" class="form-label">Guard Name</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create permission -->
    <div class="modal fade" id="editPermission" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="name" placeholder="Permission Name" required>
                            <label for="exampleFormControlInput1" class="form-label">Permission Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="guard_name" value="web" placeholder="Guard Name" disabled required>
                            <label for="exampleFormControlInput1" class="form-label">Guard Name</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
            getDataTable();
            
        });

        async function getDataTable() {
            var table = $('#datalist').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('get.permission') }}",
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
                        data: 'guard_name',
                        name: 'guard_name'
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

        function editPermission(id) {
            $('#editPermission').modal('show');

        }
    </script>
@endsection
