<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --> <!-- jQuery CDN -->
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
</head>
<body>

    <div class="container mt-5">
        <form action="{{url('holidays/update_holiday_list/'.$vmt_holiday_edit->id.'/')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="custom-file">
                 <label for="lname" id ="f1">name:</label>
                 <input type="text" name="name" value="{{$vmt_holiday_edit->name}}">
        </div><br>
        <div class="custom-file1">
            <div class="custom-file">
                <label for="fname">choose the holidays:</label>
                 @foreach ($holidays_list as $singleHoliday)<br/>
                   <input type="checkbox" name="holiday_id[]" value="{{$singleHoliday->id}}">
                   <label for="fname"> {{$singleHoliday->holiday_name}}</label><br>
                 @endforeach
            </div>
        <div>
        <input type="submit" class="btn btn-primary" value="Edit" />
       </div>
        </form>
    </div>

</body>
</html>

