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
        <form action="{{url('holidays/update_holiday/'.$vmt_holiday_edit->id.'/')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="custom-file">
                 <label for="fname">holiday_name:</label>
                 <input type="text" id="f1" name="holiday_name" value="{{$vmt_holiday_edit->holiday_name}}">
        </div><br>
        <div class="custom-file">
                 <label for="lname" id ="f1">holiday_date:</label>
                 <input type="date" name="holiday_date" value="{{$vmt_holiday_edit->holiday_date}}">
        </div><br>
        <div class="custom-file">
                 <label for="lname" id ="f1">holiday_description:</label>
                 <input type="text" name="holiday_description" value="{{$vmt_holiday_edit->holiday_description}}">
        </div><br>

         <div class="custom-file">
                 <label class="custom-file-label" for="chooseFile">image</label>
                 <input type="file" name="image" />
					<br />
					<img src="{{ asset('storage/images/'. $vmt_holiday_edit->image) }}" width="100" class="img-thumbnail" />
					<input type="hidden" name="image" value="{{ $vmt_holiday_edit->image}}" />
         </div>
        <input type="submit" class="btn btn-primary" value="Edit" />
        </form>
    </div>

</body>
</html>

