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
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Datasemen</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form action="{{$url}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nama_datasemen" id="nama_datasemen" placeholder="Nama Datasemen" value="{{ isset($datasemen) ? $datasemen->name : '' }}" required>
                                    <label for="name">Nama Detasemen</label>
                                </div>
                            </div>

                            <!-- Kaden -->
                            <div class="col-lg-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="kaden" id="kaden" required>
                                        <option value="">-- Pilih Kepala Detasemen --</option>
                                        @if (isset($anggota))
                                            @foreach ($anggota as $key => $a)
                                                <option value="{{ $a->id }}" {{ isset($kaden) ? ( $kaden->id == $a->id ? 'selected' : '' ) : ''}}>
                                                    {{ $a->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="kaden" class="form-label">Kepala Detasemen</label>
                                </div>
                            </div>

                            <!--Wakaden-->
                            <div class="col-lg-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="wakaden" id="wakaden" required>
                                        <option value="">-- Pilih Wakil Kepala Detasemen --</option>
                                        @if (isset($anggota))
                                            @foreach ($anggota as $key => $a)
                                                <option value="{{ $a->id }}" {{ isset($wakaden) ? ( $wakaden->id == $a->id ? 'selected' : '' ) : ''}}>
                                                    {{ $a->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="kaden" class="form-label">Wakil Kepala Detasemen</label>
                                </div>
                            </div>
                            
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-primary form-control" type="submit">
                                    Submit Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
    </script>
@endsection
