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
            <h5 class="mb-0 pb-1 text-decoration-underline">Permission Role</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Permission untuk Role {{ $role->name }}</h5>
                {{-- <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#add_permission"><i class="ri-add-line align-bottom me-1"></i>Add Permission</button>
                </div> --}}
            </div>

            <div class="card-body">
                @include('partials.message')
                <form action="/role/permission/{{ $role->id }}/save" method="post" style="min-height: 500px;">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($permissions as $value)
                                <div class="col-2 mt-2 mb-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $value->name }}"
                                        name="permissions[]" {{ in_array($value->name, $myPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        {{ $value->name }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary mt-4 ">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal permission -->
    <div class="modal fade" id="add_role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/role/save" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name Role</label>
                            <input type="text" class="form-control" name="name" required>
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
@endsection
