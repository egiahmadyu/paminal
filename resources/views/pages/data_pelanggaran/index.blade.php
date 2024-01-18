@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .box-1 {
            width: 8px;
            height: 8px;
            border: 1px solid #66ABC5;
            background-color: #66ABC5;
            padding: 10px;
            margin: 10px;
        }
        .box-2 {
            width: 8px;
            height: 8px;
            border: 1px solid #fcad03;
            background-color: #fcad03;
            padding: 10px;
            margin: 10px;
        }
        .box-3 {
            width: 8px;
            height: 8px;
            border: 1px solid #027afa;
            background-color: #027afa;
            padding: 10px;
            margin: 10px;
        }
        .box-4 {
            width: 8px;
            height: 8px;
            border: 1px solid #61fa61;
            background-color: #61fa61;
            padding: 10px;
            margin: 10px;
        }
        .box-5 {
            width: 8px;
            height: 8px;
            border: 1px solid #DBFF33;
            background-color: #DBFF33;
            padding: 10px;
            margin: 10px;
        }
        .box-6 {
            width: 8px;
            height: 8px;
            border: 1px solid #c5c7c5;
            background-color: #c5c7c5;
            padding: 10px;
            margin: 10px;
        }
    </style>
@endprepend

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="#">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <div class="row mb-3">
        <div class="col-xl-12 col-md-12 col-lg-12">

            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="card-box bg-gradient" style="background: #011a7d;">
                        <div class="inner">
                            <h1 style="color: white"> {{ isset($diterima) ? count($diterima) : 0 }} </h1>
                            <h5 style="color: white"> PENGADUAN DITERIMA </h5>
                        </div>
                        <div class="icon">
                            <i class="fa fa-gavel f-left" aria-hidden="true"></i>
                        </div>
                        {{-- <a href="#" class="card-box-footer"><h6 style="color: white">Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></h6></a> --}}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card-box bg-gradient" style="background: #fab005">
                        <div class="inner">
                            <h1 style="color: white"> {{ isset($diproses) ? count($diproses) : 0 }} </h1>
                            <h5 style="color: white"> PENGADUAN DIPROSES </h5>
                        </div>
                        <div class="icon">
                            <i class="fa fa-sync-alt fa-spin" aria-hidden="true"></i>
                        </div>
                        {{-- <a href="#" class="card-box-footer"> <h6 style="color: white"> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a> --}}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card-box bg-gradient" style="background: #fa3605">
                        <div class="inner">
                            <h1 style="color: white"> {{ isset($selesai) ? count($selesai) : 0 }} </h1>
                            <h5 style="color: white"> PENGADUAN SELESAI </h5>
                        </div>
                        <div class="icon">
                            <i class="fad fa-clipboard-check fa-swap-opacity"></i>
                        </div>
                        {{-- <a href="#" class="card-box-footer"> <h6 style="color: white"> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if ($user->hasRole('operator') || $user->hasRole('admin'))
        <hr>
        <div class="row">
            <h4>INFORMARI URTU</h4>
            <div class="col">
                <div class="card-box bg-gradient" style="background: #011a7d;">
                    <div class="inner">
                        <h1 style="color: white"> {{ isset($diterima_urtu) ? count($diterima_urtu) : 0 }} </h1>
                        <h5 style="color: white"> DITERIMA DI URTU </h5>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gavel f-left" aria-hidden="true"></i>
                    </div>
                    {{-- <a href="#" class="card-box-footer"><h6 style="color: white">Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></h6></a> --}}
                </div>
            </div>
            <div class="col">
                <div class="card-box bg-gradient" style="background: #fa3605;">
                    <div class="inner">
                        <h1 style="color: white"> {{ isset($disposisi_binpam) ? $disposisi_binpam : 0 }} </h1>
                        <h5 style="color: white"> DISPOSISI KE BINPAM </h5>
                    </div>
                    <div class="icon">
                        <i class="fas fa-expand-arrows-alt" aria-hidden="true"></i>
                    </div>
                    {{-- <a href="#" class="card-box-footer"><h6 style="color: white">Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></h6></a> --}}
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            FILTER
        </div>
        <div class="card-body">
            @if ($user->hasRole('operator') || $user->hasRole('admin'))
                <button type="button" class="btn btn-outline-success" id="f-disposisi-binpam" onclick="filter('disposisi-binpam')">DISPOSISI BINPAM</button>
            @elseif ($user->hasRole('min') || $user->hasRole('admin'))
                <button type="button" class="btn btn-outline-success" id="f-disposisi-bagden" onclick="filter('disposisi-bagden')">DISTRIBUSI BAG / DEN</button>
            @else
                <button type="button" class="btn btn-outline-success" id="f-disposisi-unit" onclick="filter('disposisi-unit')">DISPOSISI UNIT</button>
            @endif
            <button type="button" class="btn btn-outline-success" id="f-diterima" onclick="filter('diterima')">DITERIMA</button>
            <button type="button" class="btn btn-outline-success" id="f-diproses" onclick="filter('diproses')">DIPROSES</button>
            <button type="button" class="btn btn-outline-success" id="f-selesai" onclick="filter('selesai')">SELESAI</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                    <p>
                        KETERANGAN : 
                        <div class="box-1"></div> DISPOSISI KE BINPAM
                        <div class="box-2"></div> DISTRIBUSI KE BAG/DEN
                        <div class="box-3"></div> DISPOSISI KE UNIT
                        <div class="box-4"></div> SELESAI (LIMPAH POLDA)
                        <div class="box-5"></div> SELESAI (LIMPAH BRIO)
                        <div class="box-6"></div> SELESAI (RJ)
                    </p>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">NO. NOTA DINAS</th>
                                    <th scope="col">TANGGAL PELAPORAN</th>
                                    <th scope="col">PELAPOR</th>
                                    <th scope="col">TERLAPOR</th>
                                    <th scope="col">PANGKAT</th>
                                    <th scope="col">NAMA KORBAN</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ID YANDUAN</th>
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
            var table;
            getData()
        });

        function filter(value) {
            // alert(value)
            table.destroy();
            getData(value)
        }

        function getData(filter) {
            $('data-data').DataTable().destroy();
            console.log(filter);
            table = $('#data-data').DataTable({
                // retrieve: true,
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('kasus.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}',
                        data.filter = filter
                        // data.jenis_kelamin = $('#jenis_kelamin').val(),
                        // data.jenis_pelanggaran = $('#jenis_pelanggaran').val(),
                        // data.pangkat = $('#pangkat').val(),
                        // data.wujud_perbuatan = $('#wujud_perbuatan').val()
                    }
                },
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'no_nota_dinas',
                        name: 'no_nota_dinas'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },
                    {
                        data: 'terlapor',
                        name: 'terlapor'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'nama_korban',
                        name: 'nama_korban'
                    },
                    {
                        data: 'status.name',
                        name: 'status.name'
                    },
                    {
                        data: 'ticket_id',
                        name: 'ticket_id'
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                createdRow: (row, data, dataIndex, cells) => {
                    $(cells[3]).css('background-color', data.status_color)
                }
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }
    </script>
@endsection
