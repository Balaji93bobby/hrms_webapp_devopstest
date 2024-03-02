<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
</script>

<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>

{{-- sweet alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>

<!--Nice select-->
<script src="{{ URL::asset('/assets/premassets/js/jquery.nice-select.min.js') }}"></script>


{{-- grid js --}}
<script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.min.js') }}" defer></script><!-- Vendor Script -->


<!-- validation script  -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>

<!-- Layout config Js -->
<script src="{{ URL::asset('assets/js/layout.js') }}"></script>


{{-- for calendar --}}
<!--
<script src="{{ URL::asset('/assets/premassets/js/calendar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/calendar.js') }}"></script> -->

<script>
    $(document).ready(function() {
        $('.common-toast-close').click(function() {
            $('.common-toast').toast('hide');
        });
        var resultToast = "<?= Session::get('result') ?>";
        var alertToast = "<?= Session::get('alert') ?>";

        if (resultToast != "" && alertToast != "") {

            if (alertToast == "success") {
                $("#result-toast-success").html(resultToast);
                $('.common-toast-success').toast('show');
            } else {
                $("#result-toast-error").html(resultToast);
                $('.common-toast-error').toast('show');
            }
        }
    });

    function generateProfileShortName_VendorScript(element_id, t_user_id) {

        let shortName = null;

        $.getJSON( "/getEmployeeAvatar/"+t_user_id, function( response ) {
          // console.log("Response : "+JSON.stringify(response));

           shortName = response.data;
          // console.log("Data : "+response.data);

           $('#' + element_id).text(shortName);
           console.log("Changed shortname is element ID : "+element_id);
        });

    }

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
@yield('script')
@yield('script-bottom')
