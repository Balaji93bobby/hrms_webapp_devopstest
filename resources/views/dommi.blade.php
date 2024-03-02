<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($status)
    <h1> {{ $status }} <h1>
    @endif
    @if ($err_msg != 'null')
    <p> {{ $err_msg }} <p>
    @endif
    @if ($err_str != 'null')
    <p> {{ $err_str }} <p>
    @endif

</body>
</html>
