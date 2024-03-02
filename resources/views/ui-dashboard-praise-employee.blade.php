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
    <div class="card-body " id="style-4">
        <div class="action-content pr-1 d-flex align-items-start" style="height: 200px;">
                @if(count($praiseData) > 0)
                @foreach ($praiseData as $praise)
                <p
                    class="text-muted mr-1 w-100 f-10 my-2 d-felx align-items-center justify-content-center p-1" style="border-bottom: 1px solid;"><span style="font-size: 15px;">{{ $praise->praise_data }}</span>
                </p>
                @endforeach
                @endif
        </div>
    </div>
