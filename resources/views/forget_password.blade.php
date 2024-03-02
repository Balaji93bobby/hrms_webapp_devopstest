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
                                        <label class="text-muted f-15 fw-bold mb-2 ">Forget password</label>
                                        <div class="mb-1 ">
                                            <label for="" class="">Please enter your Email or Employee Code to reset your password</label>
                                        </div>
                                        <br />
                                        @csrf
                                        <div class="mb-1 ">
                                            <label for="" class="">Email</label>
                                            <input type="email" class="form-control textbox" value="" id="email"
                                                name="email" placeholder="Enter email address">
                                        </div>
                                        <div class="divider d-flex align-items-center my-4 px-2 mx-5">
                                            <span class="text-center fw-bold mx-3 mb-0 text-muted">OR</span>
                                        </div>
                                        <div class="mb-1 ">
                                            <label for="" class="">Employee Code<Code></Code></label>
                                            <input type="text" class="form-control textbox" value="" id="user_code"
                                                name="user_code" placeholder="Enter Employee code">
                                        </div>
                                        <br />
                                        <span class="text-danger " id="error_message">
                                            {{ session('error_message') }}
                                        </span>
                                        <br />
                                        <input type="button"
                                            class="btn btn-orange w-100 sign-in-btn  mt-1  waves-effect waves-light "
                                            type="submit" value="Submit" onclick="submitForm()" />

                                        <br />
                                        <br />
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
                                                <span class="f-12 text-muted">Powered by</span>
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



        <div class="modal fade" id="notificationModal" role="dialog" aria-hidden="true"
            style="opacity:1; display:none;background:#00000073;">
            <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true"
                aria-labelledby="">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modalHeader">
                        </h6>
                        {{-- <button type="button" class="btn-close close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal" aria-label="Close">

                        </button> --}}
                        <button type="button" class="close close-modal outline-none bg-transparent border-0 h3"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-4">
                            <p class="mb-3 text-muted f-15 text-center" id="modalNot"></p>

                            <div class="text-end">



                                <button type="button" class="btn btn-light close-modal" id="closeModal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection

@section('script')
    <script type="text/javascript">
    var error_message_both_empty = "Please enter your registered Email or Employee-code to reset your passsword.";
    var error_message_email_invalid = "Email is invalid/ not found. Please enter your registered Email.";
    var error_message_user_code_invalid = "Employee Code is invalid/ not found. Please enter your valid Employee code.";

        $(document).ready(function() {
            // $('#modal_resetPassword').modal('show');

        });

        function closeModal() {
            $('#modal_resetPassword').modal('hide');
        }

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(
                /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
                );
            return pattern.test(emailAddress);
        }

        // for hide modal

        $(".close-modal").click(function() {
                console.log('close');
                $("#notificationModal").hide();
            });

        function submitForm() {

            if($('#email').val().trim().length != 0)
            {
                if (isValidEmailAddress($('#email').val())) {
                    $('#error_message').html("");

                    console.log("Email is valid");
                    ajax_SendPasswordResetLink();
                } else {
                    console.log("Email is invalid !");

                    Swal.fire({
                        icon: 'error',
                        text : error_message_email_invalid
                    });

                    $('#error_message').html(error_message_email_invalid);
                    return;
                }
            }
            else
            if($('#user_code').val().trim().length != 0)
            {
                console.log("Checking employee code now");
                ajax_SendPasswordResetLink();

            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    text : error_message_both_empty
                });

               $('#error_message').html(error_message_both_empty);
            }

        }

        function ajax_SendPasswordResetLink() {
            $.ajax({
                type: "POST",
                url: "{{ route('vmt-send-passwordresetlink') }}",
                data: {
                    'email': $('#email').val(),
                    'user_code' : $('#user_code').val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    if (data.status == "success") {

                        Swal.fire({
                            icon: 'success',
                            text : data.message
                        });

                        // $('#modalHeader').html("Mail sent Successfully");
                        // $('#modalNot').html(
                        //     data.message
                        // );
                        // $('#notificationModal').show();
                        // $('#notificationModal').removeClass('fade');



                    }
                    else
                    if (data.status == "failure") {
                        Swal.fire({
                            icon: 'error',
                            text : data.message
                        });

                        $('#error_message').html(data.message);
                    }

                    console.log(data.message);

                }
            });

        }
    </script>
@endsection
