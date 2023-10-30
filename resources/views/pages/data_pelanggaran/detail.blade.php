@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <style>
        select:hover, #datepicker:hover, #datepicker_tgl_kejadian:hover {
            cursor: pointer;
        }
        .loader-view {
            margin-top : 75px;
        }
    </style>
@endprepend

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item" aria-current="page"> <a href="#">LIST DATA DUMAS</a> </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }} {{ $kasus->id }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        {{ $kasus->no_nota_dinas ? 'DATA NOTA DINAS '. $kasus->no_nota_dinas : ($kasus->tipe_data == '2' ? 'DATA INFORMASI KHUSUS' : 'DATA LAPORAN INFORMASI')}}
                        ({{ strtoupper($kasus->status->name) }})
                        @if ($kasus->status->ticket_id)
                            <span class="badge bg-warning">DATA DARI YANDUAN DENGAN ID : {{ $kasus->ticket_id }}</span>
                        @endif
                    </h4>

                    @if ($kasus->status_id == 5 && $nd_hasil_gelar)
                        <button class="btn btn-danger" id="rj">RESTORATIVE JUSTICE</button>    
                    @endif
                    {{-- <button class="btn btn-danger" id="rj">RESTORATIVE JUSTICE</button> --}}

                </div><!-- end card header -->

                <div class="card-body" style="min-height:300px">
                    <input type="text" class="form-control" id="data_pelanggar_id" name="data_pelanggar_id"
                        value="{{ $kasus->id }}" hidden>
                    <input type="text" class="form-control" id="process_id" name="data_pelanggar_id"
                        value="{{ $kasus->status_id }}" hidden>
                    <div class="loader-view" style="display:block;">

                    </div>
                    <div id="viewProses">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // ClassicEditor
            //     .create(document.querySelector('#editor'))
            //     .catch(error => {
            //         console.error(error);
            //     });
            $('#rj').on('click', function() {
                let id = `{{ $kasus->id }}`
                Swal.fire({
                    title: 'YAKIN AKAN MELAKUKAN RESTORATIVE JUSTICE (RJ) ?',
                    text: "DUMAS AKAN DIHENTIKAN DENGAN STATUS RJ.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'YA, LAKUKAN RJ !',
                    cancelButtonText: 'TIDAK, BATALKAN !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : '/rj/'+id,
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function () {
                                $('.loading').css('display', 'block')
                            }, 
                            success: function (data, status, xhr) {
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
                            error: function (jqXhr, textStatus, errorMessage) { // error callback
                                $('.loading').css('display', 'none')
                                console.log('error message: ',errorMessage)
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
            });

            let process_id = $('#process_id').val()
            getViewProcess(process_id)
        });

        function getViewProcess(id) {
            let kasus_id = $('#data_pelanggar_id').val()
            let process_id = $('#process_id').val()
            $("#viewProses").html("")
            $('.loader-view').css("display", "block");
            if (id == 3 && process_id > 3) {
                id = 4
            }

            $.ajax({
                url: `/data-kasus/view/${kasus_id}/${id}`,
                method: "get"
            }).done(function(data) {
                $('.loader-view').css("display", "none");
                $("#viewProses").html(data)
            });
        }

        function getValue() {
            console.log($('#editor').text())
        }

        // $(function() {
        //     $( "#datepicker" ).datepicker({
        //         autoclose:true,
        //         todayHighlight:true,
        //         format:'yyyy-mm-dd',
        //         language: 'id'
        //     });
        //     $( "#datepicker_tgl_kejadian" ).datepicker({
        //         autoclose:true,
        //         todayHighlight:true,
        //         format:'yyyy-mm-dd',
        //         language: 'id'
        //     });
        // });
    </script>
@endsection
