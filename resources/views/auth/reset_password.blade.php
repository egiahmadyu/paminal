@extends('partials.master')

@prepend('styles')
<link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endprepend


@section('content')

<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    {{-- <div class="bg-overlay"></div> --}}
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
                                        <input type="password" class="form-control pe-5 password-input border-dark" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" autocomplete="off" required>
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
                                    <p class="mb-0">Kembali ke halaman login ? <a href="/login" class="fw-semibold text-primary text-decoration-underline"> Klik di sini </a> </p>
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

@endsection

@section('scripts')

@endsection