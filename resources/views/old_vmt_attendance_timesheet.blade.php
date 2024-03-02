@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent


    <div class="card timeSheet_wrapper">
        <div class="card-body">

            <h6 class="">Employee Time Sheet</h6>

            <div class="" id="timeSheet_table"></div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>


    <script>
        var timesheetArray = <?php echo json_encode($employeeAttendanceData); ?>;

        $(document).ready(function() {
            if (document.getElementById("timeSheet_table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'date',
                            name: 'Date',
                        },
                        {
                            id: 'checkin_time',
                            name: 'Check-In',
                        },
                        {
                            id: 'checkout_time',
                            name: 'Check-Out',
                        },
                    ],
                    data: timesheetArray,
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("timeSheet_table"));
            }

        });
    </script>
@endsection
