<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>DMS PAMINAL | RESET PASSWORD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DMS PAMINAL" name="description" />
    <meta content="Paminal" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/icon/Paminal.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* #password-contain {
            display: block
        } */
        #password-contain p.invalid::before {
            margin-right: 10px;
        }
        #password-contain p.valid::before {
            margin-right: 10px;
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

</head>

<body>

    <div class="loading" style="display: none">Loading&#8230;</div>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="container-fluid">
            <div class="row g-0 justify-content-center">
                <div class="col-xl-4 col-lg-6">
                    {{-- <div class="text-center mb-4 pb-2">
                        <img src="assets/images/logo-light-full.png" alt="" height="32" />
                    </div> --}}
                    <div class="card mb-0 border-0 shadow-none">
                        <div class="card-body p-4 p-sm-5 m-lg-2">
                            <div class="text-center">
                                <h5 class="text-primary fs-20">Buat password baru</h5>
                                <p class="text-muted mb-5">Kata sandi baru harus berbeda dengan password sebelumnya.</p>
                            </div>
                    
                            <div class="p-2">
                                <form action="{{ route('reset.action') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5 password-input border-dark" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                        <div id="passwordInput" class="form-text">Password harus berisi 8-20 karakter.</div>
                                    </div>
                    
                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password harus berisi :</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2"> Minimal <b>8 karakter</b></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2"> Minimal huruf <b>kecil</b> (a-z)</p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2"> Minimal huruf <b>kapital</b> (A-Z)</p>
                                        <p id="pass-number" class="invalid fs-12 mb-0"> Minimal ada <b>angka</b> (0-9)</p>
                                    </div>
                    
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Kembali ke halaman login ? <a href="login" class="fw-semibold text-primary text-decoration-underline"> Klik di sini </a> </p>
                                    </div>
                                    
                                </form>
                            </div>
                            <footer class="">
                                <p class="text-center text-muted mb-0">&copy;
                                    <script>document.write(new Date().getFullYear())</script> Propam Integrated System - Divisi Propam Polri
                                </p>
                            </footer>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end conatiner-->
    </div>
    <!-- end auth-page-wrapper -->

    

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/passowrd-create.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>

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

</body>

</html>
