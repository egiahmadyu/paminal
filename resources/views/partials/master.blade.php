<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">


<head>
    <meta charset="utf-8" />
    <title>PIS PAMINAL | {{ isset($title) ? $title : '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="PAMINAL" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/icon/Paminal.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" /> --}}
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/pelljs/pell.scss') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css">
    
    <style>
        [data-layout-mode=light] .page-content {
            background: #ededed;
        }

        [data-layout-mode=dark] {
            .select2-container--bootstrap-5 .select2-selection {
                background-color: #252b37;
                color: #ffffff;
            }

            .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field {
                background-color: #252b37;
                color: #ffffff
            }

            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
                color: #ffffff;
            }

            .select2-search { 
                background-color: #252b37;
                color: #ffffff;
            }
            .select2-search input { 
                background-color: #252b37;
                color: #ffffff;
            }
            .select2-results { 
                background-color: #252b37;
                color: #ffffff;
            }
        }
        /* Loader */
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 9000;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(1, 240, 5, 0.75) 1.5em 0 0 0, rgba(1, 240, 5, 0.75) 1.1em 1.1em 0 0, rgba(1, 240, 5, 0.75) 0 1.5em 0 0, rgba(1, 240, 5, 0.75) -1.1em 1.1em 0 0, rgba(1, 240, 5, 0.75) -1.5em 0 0 0, rgba(1, 240, 5, 0.75) -1.1em -1.1em 0 0, rgba(1, 240, 5, 0.75) 0 -1.5em 0 0, rgba(1, 240, 5, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(1, 240, 5, 0.75) 1.5em 0 0 0, rgba(1, 240, 5, 0.75) 1.1em 1.1em 0 0, rgba(1, 240, 5, 0.75) 0 1.5em 0 0, rgba(1, 240, 5, 0.75) -1.1em 1.1em 0 0, rgba(1, 240, 5, 0.75) -1.5em 0 0 0, rgba(1, 240, 5, 0.75) -1.1em -1.1em 0 0, rgba(1, 240, 5, 0.75) 0 -1.5em 0 0, rgba(1, 240, 5, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .loader-view {
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        .f1-steps {
            overflow: hidden;
            position: relative;
            margin-top: 20px;
        }

        .f1-progress {
            position: absolute;
            top: 24px;
            left: 0;
            width: 100%;
            height: 1px;
            background: #ddd;
        }

        .f1-progress-line {
            position: absolute;
            top: 0;
            left: 0;
            height: 1px;
            background: #338056;
        }

        .f1-step {
            position: relative;
            float: left;
            width: 25%;
            padding: 0 5px;
        }

        .f1-step-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-top: 4px;
            background: #ddd;
            font-size: 16px;
            color: #fff;
            line-height: 40px;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }

        .f1-step.activated .f1-step-icon {
            background: #fff;
            border: 1px solid #338056;
            color: #338056;
            line-height: 38px;
        }

        .f1-step.active .f1-step-icon {
            width: 48px;
            height: 48px;
            margin-top: 0;
            background: #0c19db;
            font-size: 22px;
            line-height: 48px;
        }

        .f1-step p {
            color: #ccc;
        }

        .f1-step.activated p {
            color: #338056;
        }

        .f1-step.active p {
            color: #338056;
        }

        .f1 fieldset {
            display: none;
            text-align: left;
        }

        .f1-buttons {
            text-align: right;
        }

        .f1 .input-error {
            border-color: #f35b3f;
        }

        .title h1,
        .title h2,
        .title h3,
        .title h4 {
            margin: 5px;
        }

        .title {
            position: relative;
            display: block;
            padding-bottom: 0;
            border-bottom: 3px double #dcdcdc;
            margin-bottom: 30px;
        }

        .title::before {
            width: 15%;
            height: 3px;
            background: #53bdff;
            position: absolute;
            bottom: -3px;
            content: '';
        }

        a {
            color: #53bdff;
            text-decoration: none;
            outline: 0;
        }

        a:hover {
            color: #06a0ff;
            text-decoration: none;
        }

        p {
            margin: 10px 0;
        }

        #editor {
            resize: vertical;
            overflow: auto;
            line-height: 1.5;
            /* background-color: #fafafa; */
            background-image: none;
            border: 0;
            border-bottom: 1px solid #3b8dbd;
            min-height: 500px;
            box-shadow: none;
            padding: 8px 16px;
            margin: 0 auto;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        #editor:focus {
            background-color: #f0f0f0;
            border-color: #38af5b;
            box-shadow: none;
            outline: 0 none;
        }

    </style>

    @stack('styles')
</head>

<body>

    <div class="loading" style="display: none">Loading&#8230;</div>
    <div id="layout-wrapper">
        <div class="top-tagbar">
            <div class="w-100">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4 col-9">
                        <div class="text-white-50 fs-13">
                            <i class="bi bi-clock align-middle me-2"></i>
                            {{-- <span id="current-time"></span> --}}
                            <span id="waktu-saat-ini"></span>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 col-6 d-none d-lg-block">
                        <div class="d-flex align-items-center justify-content-center gap-3 fs-13 text-white-50">
                            <div>
                                <i class="bi bi-envelope align-middle me-2"></i> support@themesbrand.com
                            </div>
                            <div>
                                <i class="bi bi-globe align-middle me-2"></i> www.themesbrand.com
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        @include('partials.navbar')

        @include('partials.sidebar')

        <div class="vertical-overlay"></div>

        <div class="main-content">

            <div class="page-content ">
                <div class="container-fluid">
                    <div class="loading" style="display: none">Loading&#8230;</div>
                    @yield('content')
                    <footer class="">
                        <p class="text-center text-muted">&copy; 2023 Propam Integrated System - Divisi Propam Polri</p>
                    </footer>
                </div>
            </div>
        </div>

        <div id="preloader">
            <div id="status">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        {{-- <div class="customizer-setting d-none d-md-block">
            <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
                data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div> --}}


        <!-- Theme Settings -->
        @include('partials.theme')

        @include('partials.javascript')
        <script>
            let a;
            let date;
            setInterval(() => {
                a = new Date();
                date = getDaysName() +', '+a.getDate() + ' ' + getMonthName(a.getMonth()) + ' ' +a.getFullYear() + ' | ' + a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds()  + ' WIB'
                document.getElementById('waktu-saat-ini').innerHTML = date;
            }, 1000);

            function getMonthName(monthNumber) {
                const date = new Date();
                date.setMonth(monthNumber);

                return date.toLocaleString('id-ID', {
                    month: 'long',
                });
            }

            function getDaysName() {
                const weekday = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];

                const d = new Date();
                let day = weekday[d.getDay()];

                return day
            }

            const flatPickrList = [].slice.call(document.querySelectorAll('.flatpickr-validation'))
            // Flat pickr
            if (flatPickrList) {
                flatPickrList.forEach(flatPickr => {
                    flatPickr.flatpickr({
                        allowInput: true,
                        monthSelectorType: 'static'
                    });
                });
            }

            $("#import_data").submit(function(event){
                event.preventDefault();
                $('.loading').css('display', 'block')
                var form = $('#import_data').serialize()
                $.ajax('/api/yanduan', {
                    type: 'POST',  // http method
                    data: form,
                    dataType: 'json', // type of response data
                    success: function (data,status,xhr) {   // success callback function
                        if(data.status == 200) {
                            $('#modal_import_yanduan').modal('hide')
                            $('.loading').css('display', 'none')
                            Swal.fire({
                                title: 'BERHASIL !',
                                text: data.total_import + ' Data berhasil ditambahkan',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        $('p').append('Error: ' + errorMessage);
                    }
                });
            });
            
        </script>

        @yield('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            $(document).ready(function(){
                $("logout").on('click',function(){
                    $('.loading').css('display', 'block')
                });
            });

            @if(Session::has('message'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.success("{{ session('message') }}");
            @endif

            @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.error("{{ session('error') }}");
            @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.info("{{ session('info') }}");
            @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.warning("{{ session('warning') }}");
            @endif
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "700",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
          </script>

    </div>

</body>

</html>
