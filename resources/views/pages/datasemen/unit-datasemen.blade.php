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
                    <h4 class="card-title mb-0 flex-grow-1">Unit Datasemen</h4>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahUnit">
                        Tambah Unit
                    </button>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Datasemen</th>
                                    <th scope="col">Unit</th>
                                    {{-- <th scope="col">Action</th> --}}
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
                    <h5 class="modal-title" id="exampleModalLabel">Create Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/permission/store" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark" name="name" placeholder="Permission Name" required>
                            <label for="exampleFormControlInput1" class="form-label">Nama Unit</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select border-dark" aria-label="Default select example" name="tipe_data" id="tipe_data" required>
                                <option value="">-- Pilih Bag / Detasemen --</option>
                                <option value="1">Den A</option>
                                <option value="1">Den B</option>
                                <option value="1">Den C</option>
                                <option value="1">Bag Binpam</option>
                                
                            </select>
                            <label for="tipe_data" class="form-label">Bag / Detasemen</label>
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
                    
                    // {
                    //     data: 'action',
                    //     name: 'action'
                    // },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }
    </script>
@endsection
