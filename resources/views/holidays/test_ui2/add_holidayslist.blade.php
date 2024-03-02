<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/example-styles.css">
    <link rel="stylesheet" type="text/css" href="css/demo-styles.css">
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.multi-select.js"></script>
<style>

    </style>
</head>
<body>
    <div class="container mt-5">
        <form action="{{url('holiday/create_holidaylist')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="custom-file">
                 <label for="fname"> List Name:</label>
                 <input type="text" id="f1" name="name" value=""><br>

        </div><br>
        <div class="custom-file1">
            <div class="custom-file">
                <label for="fname">choose the holidays:</label>
                 @foreach ($holidays_data as $singleHoliday)<br/>
                   <input type="checkbox" name="holiday_list_id[]" value="{{$singleHoliday->id}}">
                   <label for="fname"> {{$singleHoliday->holiday_name}}</label><br>
                 @endforeach
            </div>
        <div>
                 <button type="submit" name="submit" value="save" class="btn btn-primary btn-block mt-4">create</button>
        </div>
        </form>
    </div>
</body>
</html>


