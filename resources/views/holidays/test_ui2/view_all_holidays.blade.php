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
     #add_loc{

         position:absolute;
         left:870px;
    }

     table,#head ,#data{
        border:1px solid black;
        padding: 30px 30px;
        border-collapse: separate;
    }
        table,#data{
            height: 10px;;
            width:30%;
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
                            <h6 class=""> Year 2023-24</h6>
                        </div>
                    </div>
                </div>
                <div id="VJS_LeaveApproval">
                    <a id="add_holi" href="../holidays/add_holidayslist"><button type="button">CreateNewList</button></a>
                    <a id="add_loc" href="../holidays/add_holidayslocation"><button type="button">AddNewLocation</button></a>
                <table>
                         <tr id="head">
                            <th>id</th>
                            <th>list_name</th>
                         </tr>
                      @foreach ($holidays_list as $singleHoliday)<br/>
                        <div>
                            <tr id="data">
                            <td><span> {{ $singleHoliday->id}} </span> <br/></td>
                            <td> <span> {{ $singleHoliday->name}}</span> <br/></td>
                            <td><span><a href="{{url('/holiday/edit_holiday_list/'.$singleHoliday->id.'/')}}"><input type="button" class="editHoliday" value="Edit" /></a>
                            </span></td>
                            <td> <span><a href="{{url('holidays/delete_holiday_list/'.$singleHoliday->id.'/')}}"><input type="button" class="deleteHoliday" value="Delete" /></a>
                            </span></td>
                            </tr>
                        </div>
                    @endforeach
                </table>
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
