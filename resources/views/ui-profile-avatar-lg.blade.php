<?php
    //dd($currentUser);
    $t_userAvatarDetails = json_decode(getEmployeeAvatarOrShortName($currentUser->id),true);
    // dd($t_userAvatarDetails);
?>

@if( $t_userAvatarDetails["type"]=="shortname")
        <div id="" style="width: 50px; height:50px; font-size:18px " class=" align-middle rounded-circle user-name-container d-flex align-items-center justify-content-center  <?php echo $t_userAvatarDetails['color']; ?>">{{ $t_userAvatarDetails["data"] }}</div>
@else
    <img class="rounded-circle header-profile-user " style="" src=" {{URL::asset('images/'. $t_userAvatarDetails['data'])}}" alt="user-image" >
@endif


@section('script-profile-avatar')

<script>

</script>
@endsection
