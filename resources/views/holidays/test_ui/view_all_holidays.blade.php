<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
     #add_holi{

        position:absolute;
         left:1000px;
     }
     #view_holi{
    position:absolute;
    left:920px;
     }
    </style>
</head>
<body>

  @extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    {{-- @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}


        <div class="card mb-0 approvals_wrapper mt-30">
            <div class="card-body ">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-sm-12 col-xxl-6 col-md-6 col-xl-6 col-lg-6">
                            <h6 class=""> Holiday  summary</h6>
                        </div>
                    </div>
                </div>
                <div id="VJS_LeaveApproval">
                    <a id="add_holi" href="../holidays/add_holidays"><button type="button">Add holidays</button></a>
                    <a id="view_holi" href="../holiday/visit-page"><button type="button">view list</button></a>
                    @foreach ($master_holidays as $singleHoliday)
                    <br/>
                    <div>
                        <img src="{{url('storage/images/'.$singleHoliday->image)}} " width="100px"  heigth="100px" >
                    </div>
                        <div>
                            <span> {{ $singleHoliday->holiday_name}} </span> <br/>
                            <span> {{ $singleHoliday->holiday_date}}</span> <br/>
                            <span><a href="{{url('/holiday/edit_holiday/'.$singleHoliday->id.'/')}}"><input type="button" class="editHoliday" value="Edit" /></a>
                            </span>
                            <span><a href="{{url('holidays/delete_holiday/'.$singleHoliday->id.'/')}}"><input type="button" class="deleteHoliday" value="Delete" /></a></span>

                        </div>
                    @endforeach
                    @if(!empty($result))
                    <h2>Form Saved successfully</h2>
                    @endif


            </div>
         </div>


@endsection

@section('script')
<script>

    $(document).ready(function() {

        console.log("Holiday page opened");

    });

    $('#myBtn').click(function(e) {
        $("#myModal").modal();
    });

</script>
@endsection

</body>
</html>
