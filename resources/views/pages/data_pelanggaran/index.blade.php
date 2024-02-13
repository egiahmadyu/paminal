@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
    
    <div class="row">
        <div class="col-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5>FILTER</h5>
                    <a type="button" href="" id="tinjut-polda" hidden></a>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0)" method="post" id="form-filter">
                        @csrf
                        <input type="hidden" name="filter" value="1">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="disposisi-bagden" id="disposisi-bagden">
                            <label class="form-check-label" for="disposisi-bagden">
                              DISTRIBUSI BAG / DEN
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="disposisi-unit" id="disposisi-unit" name="disposisi-unit">
                            <label class="form-check-label" for="disposisi-unit">
                              DISPOSISI UNIT
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="diterima" id="diterima" name="diterima">
                            <label class="form-check-label" for="diterima">
                              DITERIMA
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="diproses" id="diproses" name="diproses">
                            <label class="form-check-label" for="diproses">
                              DIPROSES
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="selesai" id="selesai" name="selesai">
                            <label class="form-check-label" for="selesai">
                              SELESAI
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="selesai-tidak-benar" id="selesai-tidak-benar" name="selesai-tidak-benar">
                            <label class="form-check-label" for="selesai-tidak-benar">
                              SELESAI TIDAK BENAR
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="rj" id="rj" name="rj">
                            <label class="form-check-label" for="rj">
                              RESTORATIVE JUSTICE
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="limpah-biro" id="limpah-biro" name="limpah-biro">
                            <label class="form-check-label" for="limpah-biro">
                              LIMPAH BIRO
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="limpah-polda" id="limpah-polda" name="limpah-polda">
                            <label class="form-check-label" for="limpah-polda">
                              LIMPAH POLDA
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="diproses-polda" id="diproses-polda" name="diproses-polda">
                            <label class="form-check-label" for="diproses-polda">
                              DIPROSES POLDA
                            </label>
                        </div>

                        <div class="form-control" id="select-polda" hidden>
                            <select class="form-select border-dark" aria-label="Default select example" name="selected_polda" id="selected_polda">
                                <option value="">PILIH POLDA</option>
                                @foreach ($poldas as $polda)
                                    <option value={{$polda->id}}>{{ $polda->name }}</option>
                                @endforeach
                            </select>

                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <div class="form-custom">
                        <button type="button" id="button-filter" class="btn btn-outline-secondary" onclick="filter()" style="width: 100%">Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <table class="table mb-0" id="data-data">
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
                <div class="card-footer">
                    KETERANGAN : 
                    <div class="row d-flex align-items-center">
                        <div class="box-1"></div> DISPOSISI KE BINPAM
                        <div class="box-2"></div> DISTRIBUSI KE BAG/DEN
                        <div class="box-3"></div> DISPOSISI KE UNIT
                        <div class="box-4"></div> DIPROSES POLDA
                        <div class="box-5"></div> SELESAI (LIMPAH BIRO)
                        <div class="box-6"></div> SELESAI (RJ)
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var table
            getData()

            $('#selected_polda').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            
            $('#diproses-polda').on("change", function() {
                if ($(this).is(":checked")) {
                    $('#select-polda').removeAttr('hidden')
                } else {
                    $('#select-polda').attr('hidden','hidden')
                }
            })
        });

        function filter() {
            table.destroy();
            let form =  $("#form-filter").serializeArray()

            getData(form)
        }

        function getData(filter) {
            let button = buttonBuatLaporanTinjutPolda()

            $('data-data').DataTable().destroy();

            table = $('#data-data').DataTable({
                // retrieve: true,
                dom: 'lBfrtip',
                paging: "true",
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
                        // formName: 'form-filter'
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
                },
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
            
            if ($('#diproses-polda').is(":checked")) {
                $('.dt-buttons').append(button)
                $('#select-polda').removeAttr('hidden')
            }

            if ($('#selected_polda').val() != '') {
                $('#print-tinjut-polda').removeAttr('hidden')
            } else {
                $('#print-tinjut-polda').attr('hidden','hidden')
            }
        }

        function buttonBuatLaporanTinjutPolda() {
            const id = $( "#selected_polda option:selected" ).val();
            let url = `/penagihan-tinjut-polda/${id}`

            html = `<a href="${url}"><button class="dt-button buttons-print-buat-laporan-tinjut" id="print-tinjut-polda" tabindex="0" aria-controls="data-data" type="button" hidden><span>Buat Laporan Tinjut Polda</span></button></a>`
            return html
        }
    </script>
@endsection
