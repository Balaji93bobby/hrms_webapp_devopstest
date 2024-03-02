@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
<div class="pt-5 auth-page-wrapper">

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">

                    <!-- auth page bg -->
                    <div class=""  id="auth-particles">
                        <div style="">
                            <img src="{{ URL::asset($generalInfo->background_img)}}" alt="" style="width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="p-4 mb-2 mt-sm-5">
                        <div class="text-center ">
                            <a href="index" class="d-inline-block auth-logo">
                                <img src="{{ URL::asset($generalInfo->client_logo)}}" alt="" style="width:100%;height: auto;">
                            </a>
                        </div>
                        <p class="mt-3 text-left fs-15 fw-medium">{{$generalInfo->short_name}}<!-- Performance Management System --></p>
                        <p class="mt-2 text-left fs-12 fw-medium">{{$generalInfo->login_instruction}}<!-- Performance Management System --></p>
                    </div>
                <!-- <div class="row "> -->
                    <!-- <div class="col-md-12 col-lg-12 col-xl-12"> -->
                        <div class="p-4 mb-4 sm-5">
                                <!-- <div class="mt-2 text-center">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted"></p>
                                </div> -->
                                <div class="p-2 mt-2">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', 'admin@themesbrand.com') }}" id="username" name="email" placeholder="Enter username">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="auth-pass-reset-basic" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="mb-3 position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" placeholder="Enter password" id="password-input" value="123456">
                                                <button class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="align-middle ri-eye-fill"></i></button>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>

                                    </form>
                                </div>

                                <div class="mt-4 text-center">
                                    <p class="mb-0">Don't have an account ? <a href="register" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                                </div>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
                <!-- end row -->
                </div>
            </div>
            <!-- end row -->


        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->

    <!-- end Footer -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>
@endsection
