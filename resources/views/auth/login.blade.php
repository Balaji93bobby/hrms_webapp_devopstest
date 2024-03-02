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
    $query_clientMaster = \DB::table('vmt_client_master')->first();

    if ($query_clientMaster) {
        $logoSrc = $query_clientMaster->client_logo;
    } else {
        $logoSrc = '';
    }
    //dd($logoSrc);
    ?>
    <section class="h-screen" id="section-head">
        <div class="h-full">
            <div class="row h-full">
                <div class="col col-xl-12">
                    <div class="card h-full">
                        <div class="row g-0 h-full">
                            <div class="col-md-6 col-xl-7 col-lg-7 d-none d-xs-none d-sm-none d-md-block left-content">
                                <div id="features" class="carousel w-full slide" data-bs-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#features" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></li>
                                        <li data-target="#features" data-bs-slide-to="1"></li>
                                        <li data-target="#features" data-bs-slide-to="2"></li>
                                        <li data-target="#features" data-bs-slide-to="3"></li>
                                    </ol>
                                    <div class="carousel-inner h-full">
                                        <div class="carousel-item active h-full" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/illustrator.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption">
                                                <p>Your Data is Protected with
                                                    <span class="text-orange">2048-Bit</span> Encryption, Bank Grade
                                                    Security
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-full" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/Chat support.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p>Instant answers to
                                                    your questions with <span class="text-orange">Chat Support</span></p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-full" data-bs-interval="2000">
                                            <img src="{{ URL::asset('assets/images/login_img/Payroll.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p> Quickest Salary Payout is here!
                                                    Transfer Salaries in less than <span class="text-orange">2 mins</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item h-full">
                                            <img src="{{ URL::asset('assets/images/login_img/Certified.svg') }}"
                                                alt="" class="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p><span class="text-danger">Quality</span> and <span
                                                        class="text-danger">Information</span> Security Management
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#features" role="button"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#features" role="button"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div
                                class="col-md-6 col-sm-12 col-xs-12 col-xl-5 col-lg-5 d-flex align-items-center right-content">
                                <div class="card-body te1xt-black login-card px-5 py-0">
                                    <form action="{{ route('login') }}" method="POST" class="login-form">
                                        <div class="d-flex align-items-center justify-content-center mb-3 ">
                                            <div class="login-top-img">
                                                <img src="{{ URL::asset($logoSrc) }}" alt=""  class="">
                                            </div>
                                        </div>
                                        <!-- <p class="m-0   h5 fw-bold log">Login <span class="me-1">to</span><span
                                                class="m-0 fw-bold h4 me-1">ABS</span><small
                                                class="text-orange fw-bold f-10">hrms</small></p> -->
                                        <p class="text-muted f-12 mb-3 fw-bold">Login to run your business together</p>


                                        @csrf
                                        <div class="form-outline mb-3 form-row">
                                            <label for="" class="">Employee Code</label>
                                            <input type="text"
                                                class="form-control textbox  @error('user_code') is-invalid @enderror"
                                                value="{{ old('user_code', '') }}" id="user_code" name="user_code"
                                                placeholder="Employee Code">
                                            @error('user_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-3    form-row">
                                            <label for="" class="">Password</label>
                                            <input type="password"
                                                class="form-control textbox @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" id="password-input"
                                                value="">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-outline mb-1 form-row">
                                            {{-- @if (!empty($clientList) && $clientList->count() > 1)

                                                    <select class="form-select" aria-label="Default select example"
                                                        name="client_code">
                                                        <option value="" selected>Choose Client</option>
                                                        @foreach ($clientList as $singleClient)
                                                            <option value="{{ $singleClient->client_name }}">
                                                                {{ $singleClient->client_name }}</option>
                                                        @endforeach
                                                    </select>

                                            @endif --}}
                                            @error('client_code')
                                                <span class="invalid-feedback" role="">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        @if (count($errors) > 0)
                                            @foreach ($errors->all() as $message)
                                                {{-- <div class="alert alert-danger "> --}}
                                                    <span class="text-danger display-hide">{{ $message }}</span>
                                                {{-- </div> --}}
                                            @endforeach
                                        @endif

                                        <div class="d-flex justify-content-end align-items-center mb-2">
                                            <a href="{{ route('vmt-forgetpassword-page')}}" class="f-12 text-orange">Forgot password?</a>
                                        </div>


                                            <button
                                            class="btn btn-orange w-100 sign-in-btn   waves-effect waves-light "
                                            type="submit">Log-In
                                        </button>


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
                                            <a href="https://play.google.com/store/apps/details?id=com.abs.hrms_app&pcampaignid=web_share" class="mx-2">
                                                <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                                    alt="" class="">
                                            </a>
                                            <a href="https://apps.apple.com/in/app/abshrms/id6460931056" class="">
                                                <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                                    alt="" class="">
                                            </a>

                                        </div>
                                        <div
                                            class="d-flex text-center align-items-center mt-2 power-by-logo justify-content-center">

                                            <a href="#" class="">
                                                <span class="f-12 text-muted">Powered by</span>
                                                <img src="{{ URL::asset('assets/images/poweredby_abs_logo.png') }}" alt=""
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
                        Reset Password</h5>
                    <input type="button" value="X" onclick="closeModal()" class="close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal" />
                </div>
                <div class="modal-body">
                    <form id="form_updatePassword" action="" method="POST">
                        @csrf
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
                                <span class="text-danger" id="error_message"></span>
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

            var temp = '{{ $cacheStatus }}';
            console.log(temp);
            // document.cookie = 'XSRF-TOKEN=your-token-value; SameSite=None; Secure';
            var allCookies = document.cookie.split(';');

            for (var i = 0; i < allCookies.length; i++)
                document.cookie = allCookies[i] + "=;expires=" +
                new Date(0).toUTCString();

            console.log("All cookies cleared");

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
                    'password': $('#new_password_confirm').val(),
                    "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {

                        if(data.status == "success")
                        {


                        }
                        else
                        if(data.status == "failure")
                        {

                        }

                        console.log(data.message);

                    }
            });

        }

    </script>
@endsection
