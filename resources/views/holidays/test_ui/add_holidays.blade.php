<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <form action="{{url('holiday/create_holiday')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="custom-file">
                 <label for="fname">holiday_name:</label>
                 <input type="text" id="f1" name="holiday_name" value="">
        </div><br>
        <div class="custom-file">
                 <label for="lname" id ="f1">holiday_date:</label>
                 <input type="date" name="holiday_date">
        </div><br>
        <div class="custom-file">
                 <label for="lname" id ="f1">holiday_description:</label>
                 <input type="text" name="holiday_description">
        </div><br>

         <div class="custom-file">
                 <label class="custom-file-label" for="chooseFile">image</label>
                 <input type="file" name="image" class="custom-file-input" id="chooseFile">

        </div>
                 <button type="submit" name="submit" value="save" class="btn btn-primary btn-block mt-4">
                 submit
                 </button>

        </form>
    </div>
</body>
</html>
