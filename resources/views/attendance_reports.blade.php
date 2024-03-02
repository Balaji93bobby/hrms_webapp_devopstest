@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection


@section('content')
 @component('components.attendance_breadcrumb')
   @slot('li_1')@endslot
<link rel="stylesheet" href="http://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

 @endcomponent

<div class="card flex-fill project-wrapper">
	<div class="card-header">
	   <h5><span class="text-muted">Attendance &gt;</span> <span class="text-danger"> Reports </span></h5>
	</div>
        <div class="card-body p-2 table-responsive">
            <table id="attendence_table" class="table">
                <thead>
                    <tr>
                        <th>Employee Code</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Date</th>
                        <th>Punch In</th>
                        <th>Punch Out</th>
                        <th>Regularization_type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>

	</div>
</div>
@endsection

@section('script')
<script src="http://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
{{-- <script src=""></script>
<script src=""></script>
<script src=""></script>
<script src=""></script> --}}
<script>

    var attendance_details = <?php echo json_encode($attendance_details); ?>;
    var dummy_obj = {}
    var table = $('#attendanceReport').dataTable();
    var rows=[];
    $.get('attendanceReport',function(){
        attendance_details.map(function(val,index){
                Object.keys(val).forEach(function(value,i) {
                    console.log('testing.. '+value+ " "+val[value]+" index: "+i);

                });
        });
    })

     $(document).ready( function () {

            $('#attendence_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

    } );
</script>
@endsection
