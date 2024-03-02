@extends('layouts.master-without-nav')
@section('title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/login_page.css') }}" rel="stylesheet">
    <style>
    .fade {
        transition: opacity 0.2s linear !important;
      }
    </style>
@endsection
@section('content')

    <?php

    $logoObj = \DB::table('vmt_client_master')->first();

    if ($logoObj) {
        $logoSrc = $logoObj->client_logo;
    } else {
        $logoSrc = 'assets/images/vasa.jpg';
    }
    //dd($logoSrc);
    ?>


    <section class="vh-100" id="section-head">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col col-xl-12">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-6 col-xl-7 col-lg-7 d-none d-xs-none d-sm-none d-md-block left-content">
                                <div id="carouselExampleIndicators" class="carousel w-100 slide" data-bs-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></li>
                                        <li data-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                        <li data-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                                        <li data-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
                                    </ol>
                                    <div class="carousel-inner h-100">
                                        <div class="carousel-item active h-100" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/illustrator.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption">
                                                <p>Your Data is Protected with
                                                    <span class="text-orange">2048-Bit</span> Encryption, Bank Grade
                                                    Security
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-100" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/Chat support.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p>Instant answers to
                                                    your questions with <span class="text-orange">Chat Support</span></p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-100" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/Payroll.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p> Quickest Salary Payout is here!
                                                    Transfer Salaries in less than <span class="text-orange">2 mins</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-100">
                                            <img src="{{ URL::asset('assets/images/login_img/Certified.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p><span class="text-danger">Quality</span> and <span
                                                        class="text-danger">Information</span> Security Management
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleSlides" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleSlides" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div
                                class="col-md-6 col-sm-12 col-xs-12 col-xl-5 col-lg-5 d-flex align-items-center right-content">
                                <div class="card-body te1xt-black login-card px-5 py-0">
                                    <form action="#}" method="POST" class="login-form">
                                        <div class="d-flex align-items-center justify-content-center mb-3 ">
                                            <div class="login-top-img">
                                                <img src="{{ URL::asset($logoSrc) }}" alt=""
                                                    class="">
                                                    <!-- <img src="{{ URL::asset('assets/images/vasa.jpg') }}" alt="" class="w-100 h-100"> -->
                                            </div>
                                        </div>
                                        <!-- <p class="m-0   h5 fw-bold log">Login <span class="me-1">to</span><span
                                                class="m-0 fw-bold h4 me-1">ABS</span><small
                                                class="text-orange fw-bold f-10">hrms</small></p> -->
                                        <p class="text-muted f-12 mb-3 fw-bold">Reset your password to proceed further</p>


                                        @csrf
                                        <div class="form-outline mb-3 form-row">
                                            <label for="" class="">New Password</label>
                                            <input type="password"
                                                class="form-control textbox  @error('user_code') is-invalid @enderror"
                                                value="" id="new_password" name="user_code"
                                                placeholder="Employee Code">
                                            @error('user_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-3    form-row">
                                            <label for="" class="">Confirm Password</label>
                                            <input type="password"
                                                class="form-control textbox @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" id="new_password_confirm"
                                                value="">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                            <span style="color: red;" id="error_message"></span>

                                        <input type="button"
                                            class="btn btn-orange w-100 sign-in-btn   waves-effect waves-light "
                                            type="submit" value="Reset Password" onclick="submitForm()" />


                                        <div class="divider d-flex align-items-center my-4 px-2 mx-5">
                                            <span class="text-center fw-bold mx-3 mb-0 text-muted">OR</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center social-icons-wrapper">
                                            <a href="https://accounts.google.com/signin" class="me-5">

                                                <img src="{{ URL::asset('assets/images/login_img/google.png') }}"
                                                    alt="" class="h-50 w-25">
                                            </a>
                                            <a href="https://www.linkedin.com/login" class="me-5">

                                                <img src="{{ URL::asset('assets/images/login_img/linkedIn_PNG39.png') }}"
                                                    alt="" class="h-50 w-25">
                                            </a>
                                            <a class="me"
                                                href="https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=13&ct=1658217648&rver=7.0.6738.0&wp=MBI_SSL&wreply=https:%2F%2Faccount.microsoft.com%2Fauth%2Fcomplete-signin%3Fru%3Dhttps%253A%252F%252Faccount.microsoft.com%252F%253Frefp%253Dsignedout-index%2526refd%253D127.0.0.1&lc=1033&id=292666&lw=1&fl=easi2">

                                                <img src="{{ URL::asset('assets/images/login_img/microsoft_PNG18.png') }}"
                                                    alt="" class="h-50 w-25">
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center my-4  available-app justify-content-center ">

                                            <span class="f-12 me-3">Available On</span>
                                            <a href="#" class="mx-2">
                                                <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                                    alt="" class="">
                                            </a>
                                            <a href="#" class="">
                                                <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                                    alt="" class="">
                                            </a>

                                        </div>
                                        <div
                                            class="d-flex text-center align-items-center mt-2 power-by-logo justify-content-center">

                                            <a href="#" class="">
                                                <span class="f-12">Powered by</span>
                                                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt=""
                                                    class="h-25 w-25 ">
                                            </a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="login-bottom"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div id="modal_resetPassword" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal" role="document">
            <div class="modal-content">
                <div class="modal-header py-3 new-role-header d-flex align-items-center">
                    <h5 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                        Kindly Reset Password to proceed further</h5>
                    <input type="button" value="X" onclick="closeModal()" class="close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal" />
                </div>
                <div class="modal-body">
                    <form id="form_updatePassword" action="" method="POST">
                        @csrf
                        <input type="hidden" name="uid" id="uid" value="{{ session('uid') }}" />
                        <label for="FormSelectDefault" class="form-label">Please reset your password.</label>
                        <div class="mb-3 row">
                            <div class="col-12 col-md-12 col-lg-12 ">
                                <label class="" for="">New Password</label>
                                <input type="password" name="new_password" id="new_password" />
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 ">
                                <label class="" for="">Confirm New Password</label>
                                <input type="password" name="new_password_confirm" id="new_password_confirm" />
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 ">
                                <span style="color: red;" id="error_message"></span>
                            </div>
                        </div>
                        <input type="button" value = "Submit" class="btn btn-primary waves-effect waves-light" onclick="submitForm()" />

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
           // $('#modal_resetPassword').modal('show');

        });

        function closeModal()
        {
            $('#modal_resetPassword').modal('hide');
        }

        function submitForm()
        {
           //Check the password length
           if( $("#new_password").val().length < 8 )
           {
                $('#error_message').html("Password min.length should be 8");
                return;
            }


           if( $("#new_password").val() ==  $("#new_password_confirm").val())
           {
                $('#error_message').html("");
                console.log("Pwd matched");
                ajax_UpdatePassword();
           }
           else
           {
                $('#error_message').html("Password doesnt match!");
                console.log("Pwd doesnt matched");
           }
        }

        function ajax_UpdatePassword()
        {
            $.ajax({
                    type: "POST",
                    url: "{{ route('vmt-updatepassword') }}",
                    data: {
                    'uid' : $('#uid').val(),
                    'password': $('#new_password_confirm').val(),
                    "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {

                        if(data.status == "success")
                        {
                            window.location.href ="/"

                        }
                        else
                        if(data.status == "failure")
                        {
                            $('#error_message').html("Password doesnt match!");
                        }

                        console.log(data.message);

                    }
            });

        }

    </script>
@endsection
