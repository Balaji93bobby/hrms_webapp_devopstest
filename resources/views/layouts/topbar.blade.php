<?php

use App\Models\User;

 if(sessionGetSelectedClientName()){

  if(sessionGetSelectedClientName() == 'All'){
      $logoSrc = sessionGetSelectedClientLogo();
    }else{
     $logoSrc = sessionGetSelectedClientLogo();
    }

 }else{

     $logoSrc =  getClientLogo(auth()->user()->id);
  }

?>



<header id="page-topbar" class="border">
    <div class="navbar-header d-flex justify-content-between align-items-center ">

        <div class="d-flex ">
            <button type="button" class="btn btn-sm fs-16 vertical-menu-btn topnav-hamburger border-0 outline-none"
                id="topnav-hamburger-icon">
                <span class="hamburger-icon open">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <div class="topbar-logo mx-2 ">
                <img src=" {{$logoSrc }}" alt="" class=""
                    style="height: 40px;width:140px;">
            </div>
        </div>

        <div class="d-flex">
            <div class="notify-content d-flex justify-content-center align-items-center">
                <button type="button" class="form-select outline-none border-0 fw-bold dropdown-toggle" id="page-header-user-dropdown"
                    data-bs-toggle="offcanvas" data-bs-target=".offcanvas" aria-controls="" aria-haspopup="true"
                    aria-expanded="false">
                    <?php
                    if(sessionGetSelectedClientName()){
                        if(sessionGetSelectedClientName() == 'All'){
                            echo sessionGetSelectedClientFullName();
                        }else{
                        echo sessionGetSelectedClientFullName().'  ( '.(sessionGetSelected_abs_clientcode()).' )';
                        }
                    }else{
                        echo getClientFullName(auth()->user()->id).'  ( '.(sessionGetSelected_abs_clientcode()).' )';
                    }


                    ?>


                </button>
                <div class="offcanvas  selectClient-Offcanvas offcanvas-end" data-bs-keyboard="true"
                    data-bs-backdrop="true" tabindex="-1" id="select_client" aria-labelledby=""
                    style="top: 50px;border-radius:10px 0px 0px 0px;">
                    <div class="offcanvas-header pb-0 bg-ash w-100 d-flex justify-content-between align-items-center  ">

                        <a role="button" href="{{ route('pages-profile-new') }}"
                            {{-- class="border-0 outline-none profile-icon bg-transparent" data-bs-toggle="tooltip"
                            data-bs-placement="right" title="View Profile">
                            <i class="fa fa-user text-muted fs-15"></i>
                        </a> --}}
                        class="text-dark profile-icon d-flex align-items-center "  >
                        <i class="fa fa-user fs-4 text-primary" ></i>
                        <h1 class="ml-3 text-primary">View Profile</h1>
                    </a>

                        <button type="button" class="close outline-none  h3"
                            data-bs-dismiss="offcanvas" aria-label="Close" style="" >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="offcanvas-body overflow-hidden p-0 ">
                        <div
                            class="bg-ash border-bottom-liteAsh d-flex align-items-center justify-content-center flex-column pt-3">
                            <?php
                            //dd($currentUser);
                            $t_userAvatarDetails = json_decode(getEmployeeAvatarOrShortName(auth()->user()->id), true);

                              //Get the user record and update avatar column
                             $avatar_filename = User::where('user_code',auth()->user()->user_code)->first()->avatar;

                            //Get the image from PRIVATE disk and send as BASE64
                            $response = Storage::disk('private')->get(auth()->user()->user_code ."/profile_pics/".$avatar_filename);

                            $base_codeimg = base64_encode($response);
                            ?>

                            @if(!empty($base_codeimg))
                            <img class="rounded-circle header-profile-user img-xl"
                            src="data:image/png;base64,{{ $base_codeimg}}" alt="user-image">
                            @else
                                <div id=""
                                    class="align-middle fw-600 img-xl text-white  rounded-circle d-flex align-items-center justify-content-center  rounded-circle <?php echo $t_userAvatarDetails['color']; ?>"
                                    style="font-size: 25px">
                                    {{ $t_userAvatarDetails['data'] }}</div>
                            @endif



                            <p class="text-dark text-center  fs-5 my-2">
                                {{ Auth::user()->name }}</p>
                            <div class="text-muted fs-5 d-flex justify-items-center">
                                <span class="fs-5 text-center">User Id :{{ Auth::user()->user_code }}</span>
                            </div>

                            <div class="mb-3 mt-3">
                                <a class="bg-danger p-2 rounded-1 d-flex justify-items-center align-items-center" href="javascript:void();"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="bx bx-power-off fs-5 text-light "></i>
                                        <span key="t-logout " class="text-light">Sign Out</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>

                        @if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR']) && hasSubClients())
                            <?php
                            $clientsList = fetchClients() ;
                            $currentClientID = session('client_id');

                            ?>
                            <div class=" text-start text-muted px-3 py-2 border-bottom-liteAsh">

                                <span>My Organizations </span>
                                {{-- <a href="{{ route('vmt_topbar_settings') }}" class="text-info" style="cursor: pointer">
                                </a> --}}
                            </div>

                            <div class="choose-client-wrapper overflow-y-scroll pb-20 ">
                                @foreach ($clientsList as $client)
                                    <div class="choose-client justify-content-between  d-flex p-2  border-bottom-liteAsh  align-items-center  @if (!empty($currentClientID) && $currentClientID == $client->id) bg-ash @endif>"
                                        data-client_id="{{ $client->id }}">
                                        <div class="d-flex mx-2   align-items-center">
                                            <div class="mx-2 p-1 border d-flex align-items-center  rounded border-1"
                                                style="height: 40px;width:40px">
                                                <img src="{{ URL::asset($client->client_logo) }}" alt=""
                                                    class=" mh-100 mw-100">
                                            </div>
                                            <?php
                                               echo GetSelectedClientFullName($client->id).'  ( '.(GetSelected_abs_clientcode($client->id)).' )';
                                             ?>
                                        </div>
                                        @if (!empty($currentClientID) && $currentClientID == $client->id)
                                            <img src='{{ URL::asset('assets/images/check.png') }}'
                                                style='height:13px;width:13px;' class="me-2">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </div>

            </div>


            <a role="button"    type="button" class="btn bg-transparent border-0 mx-1 py-1 " id="page-header-user-dropdown"
                aria-haspopup="true" aria-expanded="false"
                aria-controls="" aria-haspopup="true" aria-expanded="false"   data-bs-toggle="offcanvas" data-bs-target=".offcanvas">
                <div class="d-flex align-items-center page-header-user-dropdown">

                    <?php
                    //dd($currentUser);
                    $t_userAvatarDetails = json_decode(getEmployeeAvatarOrShortName(auth()->user()->id), true);
                    // dd($t_userAvatarDetails);
                    ?>

                    @if(!empty($base_codeimg))
                        <img class="rounded-circle header-profile-user"
                         src="data:image/png;base64,{{ $base_codeimg}}" alt="user-image">
                    @else
                    <div id=""
                    class="align-middle img-sm text-white  rounded-circle d-flex align-items-center justify-content-center  rounded-circle <?php echo $t_userAvatarDetails['color']; ?>"
                    style="height:35px;width:35px;">
                    {{ $t_userAvatarDetails['data'] }}</div>
                @endif

                </div>
            </a>

        </div>
    </div>
</header>
<!-- added jquery script temporarily here since Jquery plugin is not loaded at this point -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function generateProfileShortName_Topbar() {
        var username = "{{ trim(auth()->user()->name) }}";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ' }}';
        const splitArray = username.split(" ");
        var finalname = "empty111";

        if (splitArray.length == 1) {
            finalname = splitArray[0][0] + "" + splitArray[0][1];
        } else {
            if (splitArray[0].length == 1)
                finalname = splitArray[0][0] + "" + splitArray[1][0];
            else
                finalname = splitArray[0][0] + "" + splitArray[0][1];
        }

        var a = $('.topbar_username').text(finalname.toUpperCase());
    }

    generateProfileShortName_Topbar();
    $('#shorthand_name_bg').css("backgroundColor", getRandomColor());


    function updateGlobalClient(client_id) {

        $.ajax({
            url: "{{ route('session-update-globalClient') }}",
            type: "POST",
            data: {
                client_id: client_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log("Response : " + data);
                location.reload();
            }
        });

        //location.reload();
    }

    //$('#dropdown_client').selectpicker("refresh");
    $('.choose-client').click(function() {
        let selectedClientID = $(this).attr('data-client_id');
        console.log("Client ID chosen : " + selectedClientID);
        updateGlobalClient(selectedClientID);
    });
</script>


{
    {{-- <a role="button" href="{{ route('pages-profile-new') }}"
                            class="border-0 outline-none profile-icon bg-transparent" data-bs-toggle="tooltip"
                            data-bs-placement="right" title="View Profile">
                            <i class="fa fa-user text-muted fs-15"></i>
                        </a> --}}
}
