@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <style>
        select:hover, #datepicker:hover {
            cursor: pointer;
        }
        .loader-view {
            margin-top : 75px;
        }
    </style>
@endprepend

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data No Nota Dinas {{ $kasus->no_nota_dinas }}
                        ({{ $kasus->status->name }})</h4>

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
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/decoupled-document/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/inline/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}



    {{-- <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            // ClassicEditor
            //     .create(document.querySelector('#editor'))
            //     .catch(error => {
            //         console.error(error);
            //     });

            let process_id = $('#process_id').val()
            getViewProcess(process_id)
        });
    </script>
    <script>
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

    </script>
@endsection
