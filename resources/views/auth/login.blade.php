<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>DMS PAMINAL | SIGN IN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/icon/Paminal.ico') }}" />

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
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"/>

    <style>
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
    </style>
</head>

<body>

    
    <div class="loading" style="display: none">Loading&#8230;</div>
    <section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
        <div class="bg-overlay"></div>
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-xl-8 col-lg-6">
                    <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                        {{-- <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <img src="assets/images/logo-light-full.png" alt="" height="32" />
                            </div>
                        </div> --}}

                        {{-- <div class="text-white mt-4">
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i>
                                by Themesbrand
                            </p>
                        </div> --}}
                    </div>
                </div>
                <!--end col-->
                <div class="col-xl-4 col-lg-6">
                    <div class="card mb-0" style="opacity: 0.9;">

                        <div class="card-body p-3 p-sm-5 m-lg-2">
                            <div class="text-center">
                                <img width="70%" src="{{ asset('assets/images/logo/paminal.png') }}" alt="">
                                
                                <h5 class="text-primary fs-22">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Propam Integrated System.</p>
                            </div>
                            <div class="p-2 mt-3">
                                <form action="{{ route('login-action') }}" method="post" id="form-login">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        {{-- <div class="float-end">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                        </div> --}}
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input"
                                                name="password" placeholder="Enter password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" id="sign-in" type="submit">Sign In</button>
                                    </div>
                                </form>

                                {{-- <div class="text-center mt-5">
                                    <p class="mb-0">Don't have an account ? <a href="auth-signup-cover.html"
                                            class="fw-semibold text-secondary text-decoration-underline"> SignUp</a>
                                    </p>
                                </div> --}}
                                
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <footer class="">
                                <p class="text-center text-muted mb-0">&copy;
                                    <script>document.write(new Date().getFullYear())</script> Propam Integrated System - Divisi Propam Polri
                                </p>
                            </footer>
                        </div>
                        
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end conatiner-->
    </section>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(document).ready(function(){
            $("form").submit(function(){
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

</body>

</html>
