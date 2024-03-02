<?php

    use Illuminate\Support\Facades\Storage;
?>

@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">
@endsection
@endsection
@section('content')
<!doctype html>
<html lang="en">
<head>


</head>
<body>

   @vite('resources/js/hrms/modules/profile_pages/EmployeeDocumentsManager.js')
   <div id="EmployeeDocumentManager"></div>

</body>
</html>
@endsection
