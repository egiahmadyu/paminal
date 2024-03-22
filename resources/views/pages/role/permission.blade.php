@extends('partials.master')

@prepend('styles')
    {{-- <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endprepend


@section('content')

    <!-- DataTable list pelanggar -->
    <div class="row">
        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
            <h5 class="mb-0 pb-1">PERMISSION ROLE PAMINAL</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">PERMISSION UNTUK ROLE {{ strtoupper($role->name) }}</h5>
                <a href="/permission" type="button" class="btn btn-outline-success">MANAGE PERMISSION</a>
                <button type="button" class="btn btn-outline-info mx-3" onclick="checkAll()"><i class="far fa-check-square"></i> PILIH SEMUA CEKLIS</button>
                <button type="button" class="btn btn-outline-danger" onclick="uncheckAll()"><i class="far fa-check-square"></i> HAPUS SEMUA CEKLIS</button>
            </div>

            <div class="card-body">
                @include('partials.message')
                <form action="/role/permission/{{ $role->id }}/save" method="post" style="min-height: 500px;">
                    @csrf
                    <div class="row">
                        @foreach ($permissions as $value)
                            <div class="col-2 mb-2 mt-2 form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $value->name }}"
                                    name="permissions[]" {{ in_array($value->name, $myPermissions) ? 'checked' : '' }} autocomplete="off">
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                    {{ $value->name }}
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-4 ">UPDATE</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">BUAT PERMISSION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/role/save" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">NAMA PERMISSION</label>
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
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            
        })
        
        function checkAll() {
            $('input[type="checkbox"]').each(function() { 
                this.checked = true; 
            });
        }
        
        function uncheckAll() {
            $('input[type="checkbox"]').each(function() { 
                this.checked = false; 
            });
        }
    </script>
@endsection
