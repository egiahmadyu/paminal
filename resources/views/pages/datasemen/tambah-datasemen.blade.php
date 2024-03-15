@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#">{{ $title }}</a> </li>
        </ol>
    </nav>

    @include('partials.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form action="{{$url}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark" name="nama_datasemen" id="nama_datasemen" placeholder="NAMA BAG/DEN" value="{{ isset($datasemen) ? $datasemen->name : '' }}" required style="text-transform:uppercase">
                                    <label for="name">NAMA BAG/DEN</label>
                                </div>
                            </div>

                            <!-- Kaden -->
                            <div class="col-lg-6 mb-3">
                                <div class="form-control border-dark">
                                    <select class="form-select border-dark" data-choices data-live-search="true" aria-label="Default select example" name="kaden" id="kaden" required>
                                        <option value="">-- PILIH KA. BAG/DEN --</option>
                                        @if (isset($anggota))
                                            @foreach ($anggota as $key => $a)
                                                <option value="{{ $a->id }}" {{ isset($kaden) ? ( $kaden->id == $a->id ? 'selected' : '' ) : ''}}>
                                                    {{ $a->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    {{-- <label for="kaden" class="form-label">Kepala Detasemen</label> --}}
                                </div>
                            </div>

                            <!--Wakaden-->
                            <div class="col-lg-6 mb-3">
                                <div class="form-control border-dark">
                                    <select class="form-select border-dark" data-choices data-live-search="true" aria-label="Default select example" name="wakaden" id="wakaden">
                                        <option value="">-- PILIH WA. KEPALA --</option>
                                        @if (isset($anggota))
                                            @foreach ($anggota as $key => $a)
                                                <option value="{{ $a->id }}" {{ isset($wakaden) ? ( $wakaden->id == $a->id ? 'selected' : '' ) : ''}}>
                                                    {{ $a->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    {{-- <label for="kaden" class="form-label">Wakil Kepala Detasemen</label> --}}
                                </div>
                            </div>
                            
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-primary form-control" type="submit">
                                    SUBMIT DATA
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
