@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection


@section('content')
 @component('components.attendance_breadcrumb')
   @slot('li_1')@endslot
 @endcomponent

<div class="card flex-fill project-wrapper">
	<div class="card-header">
	   <h5><span class="text-muted">Attendance &gt;</span> <span class="text-danger"> OverTime </span></h5>
	</div>
        <div class="card-body p-2">

	</div>
</div>
@endsection

@section('script')
<script>
</script>
@endsection