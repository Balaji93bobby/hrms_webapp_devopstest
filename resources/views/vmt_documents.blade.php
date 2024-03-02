@extends('layouts.master')
{{-- @include('ui-onboarding')
 --}}
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        input {
            width: 100% !important;
            margin-left: 0 !important;
            height: 2.9em;
        }

        #current_address_copy {
            height: 12px !important;
            width: 12px !important;
        }

        .addfiles {
            padding: 7px;
            border-radius: 2px;
        }
    </style>
@endsection

@section('content')
    @if (Auth::user()->is_onboarded == '1')
        {{-- @component('components.organization_breadcrumb')
    @slot('li_1') @endslot
    @endcomponent --}}
    @endif
    <div class="documents-wrapper mt-30">

        @include('ui-documents')

    </div>
@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <!-- dashboard init -->

    <!--Page Wrapper-->


    <!-- jQuery easing plugin -->
    <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>

    <script src="{{ URL::asset('/assets/premassets/js/sweetalert.js') }}"></script>
    <!--Progressbar JS-->
    <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>
    <!--Charts-->
    <!--Canvas JS-->
    <!--Custom Js Script-->
    <!--Custom Js Script-->
    <script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/onboarding.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>


    <script>
        $('body').on('click', '.close-modal', function() {
            $('#notificationModal').hide();
            $('#notificationModal').addClass('fade');
        });

        // $('#submit_button').on('click', function(e) {
        //      console.log("Submitting documents");

        //     if ($('#form-documentsupload').valid()) {

        //         //alert("1 st one");
        //         var form_data1 = new FormData(document.getElementById("form-documentsupload"));
        //         console.log("Form data : "+form_data1);
        //         $.ajax({
        //             url: "{{ route('vmt-storedocuments-route') }}",
        //             type: "POST",
        //             dataType: "json",
        //             data: form_data1,
        //             contentType: false,
        //             processData: false,
        //             success: function(data) {

        //                 if (data.status == "success") {
        //                     $('#modalNot').html(data.message);
        //                     $('#notificationModal').show();
        //                     $('#notificationModal').removeClass('fade');
        //                 } else {
        //                     $('#modalNot').html(data.message);
        //                     $('#notificationModal').show();
        //                     $('#notificationModal').removeClass('fade');
        //                 }
        //                 console.log(data);

        //             },
        //             error: function(data) {

        //             }
        //         });

        //     }
        // });



        $('#form-1').validate({
            errorPlacement: function(error, element) {
                error.text('* ' + error.text());
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent()); // radio/checkbox?
                } else if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter(element.next('span')); // select2
                    element.next('span').addClass('error').removeClass('valid');
                } else {
                    error.insertAfter(element); // default
                }
            }
        });

        $("#button_close").click(function() {
            window.location.reload();
        });

    </script>
@endsection
