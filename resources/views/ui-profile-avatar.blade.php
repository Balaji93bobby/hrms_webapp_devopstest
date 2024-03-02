@if (empty(Auth::user()->avatar) || !file_exists(public_path('images/' . Auth::user()->avatar)))
    <div class=" rounded-circle h-100 w-100 f-18 d-flex align-items-center justify-content-center  usershortName_bg ">
        <i id="profileShortNameLargeCircle" class="align-middle "></i>
    </div>
@else
    <div class="bg-light userImg_bg">
        <img class="w-100 h-100 rounded-circle header-profile-user"
            src=" {{ URL::asset('images/' . Auth::user()->avatar) }}" alt="Header Avatar">
    </div>
@endif


@section('script-profile-avatar')
    <script>
        // $(document).ready(function() {

        generateProfileShortName_VendorScript('profileShortNameLargeCircle', '{{ auth()->user()->id }}');

    </script>
@endsection
