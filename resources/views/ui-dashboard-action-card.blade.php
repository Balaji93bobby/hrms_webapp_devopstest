<style type="text/css">
header {
    /* font-family: 'Lobster', cursive; */
    text-align: center;
    font-size: 25px;
}


.scrollbar {
    margin-left: 10px;
    float: left;
    height: 100px;
    width: 400px;

    overflow-y: scroll;
    margin-bottom: 25px;
}

.force-overflow {
    min-height: 450px;
}

#wrapper {
    text-align: center;
    width: 500px;
    margin: auto;
}

/*
 *  STYLE 1
 */

#style-1::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #555;
}
</style>
<div class="card profile-box wrapper flex-fill">
    <h4 class="m-0 title text-center text-primary card-title my-2 fw-bold">My Actions</h4>
    <hr class="m-0">
    <div class="card-body " id="style-4">
        <div class="action-content pr-1 d-flex align-items-start"> @php
            $currentUser = Auth::user();
            $User = Auth::user()->unreadNotifications->count();
            foreach ($currentUser->unreadNotifications as $notification) {
            // if($notification){
            @endphp


                {{-- <b>6 July 2022</b> --}}

                <p
                    class="text-muted mr-1 w-100 f-10 my-2 d-felx align-items-center justify-content-center p-1 bg-box-color-success">{{$notification->data['message']}}
                </p>
                <!-- <br>       -->


            @php } @endphp
            @php
            foreach ($currentUser->Notifications as $not) {
            @endphp


                <p class="text-muted w-100 f-10 my-2 d-felx align-items-center justify-content-center p-1 bg-box-color-pink  align-items-center ">{{$not->data['message']}}

            @php } @endphp
        </div>
    </div>
</div>
