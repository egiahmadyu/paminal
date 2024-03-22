@extends('partials.master')

@prepend('styles')
<link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endprepend


@section('content')

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    {{-- <div class="bg-overlay"></div> --}}
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-xl-8 col-lg-6">
                <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-lg-6">
                <div class="card mb-0" style="opacity: 0.9;">

                    <div class="card-body p-3 p-sm-5 m-lg-2">
                        <div class="text-center">
                            <img width="40%" src="{{ asset('assets/images/logo/logo-paminal.png') }}"
                                alt="">

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
                                    <button class="btn btn-primary w-100" id="sign-in" type="submit">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="card-footer">
                        <footer class="">
                            <p class="text-center text-muted mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Propam Integrated System - Divisi Propam Polri
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


@endsection

@section('scripts')

@endsection