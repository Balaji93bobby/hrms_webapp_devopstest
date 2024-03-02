@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pmsReports-wrapper mt-30 ">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">

                    <div class="col-3">
                        <label class="fw-bold"> Assignment Year </label>
                        {{-- <input type="text" id="year" readonly value="{{ $query_configPms-> year}}" size="25" /> --}}
                        <select id="year" class="form-select " style="" aria-label=".form-select-sm example">
                            <option value="" selected hidden disabled>Select Assignment Year</option>
                            @foreach ($query_years as $key => $value)
                                <option value="{{ $value }}"> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3">
                        <label class="fw-bold">Assignment Period</label>
                        <select placeholder="Select Calendar Type" style="" id="dropdownAssignment_period"
                            class="form-select ">
                            <option value="All" selected>Select</option>
                            @if ($query_configPms->calendar_type == 'financial_year')
                                @if ($query_configPms->frequency == 'monthly')
                                    <option value="apr">Apr</option>
                                    <option value="may">May</option>
                                    <option value="jun">Jun</option>
                                    <option value="jul">Jul</option>
                                    <option value="aug">Aug</option>
                                    <option value="sep">Sep</option>
                                    <option value="oct">Oct</option>
                                    <option value="nov">Nov</option>
                                    <option value="dec">Dec</option>
                                    <option value="jan">Jan</option>
                                    <option value="feb">Feb</option>
                                    <option value="mar">Mar</option>
                                @elseif($query_configPms->frequency == 'quarterly')
                                    <option name="Q1" value="q1"> Q1 (Apr-Jun)</option>
                                    <option name="Q2" value="q2"> Q2 (Jul-Sept)</option>
                                    <option name="Q3" value="q3"> Q3 (Oct-Dec)</option>
                                    <option name="Q4" value="q4"> Q4 (Jan-March)</option>
                                @elseif($query_configPms->frequency == 'halfYearly')
                                    <option name="H1" value="h1">H1 (Apr-Sept)</option>
                                    <option name="H2" value="h2">H2 (Oct-Mar)</option>
                                @elseif($query_configPms->frequency == 'annually')
                                    <option name="A" value="A">A (Apr-Mar)</option>
                                @endif
                            @elseif($query_configPms->calendar_type == 'calendar_year')
                                @if ($query_configPms->frequency == 'monthly')
                                    <option value="jan">Jan</option>
                                    <option value="feb">Feb</option>
                                    <option value="mar">Mar</option>
                                    <option value="apr">Apr</option>
                                    <option value="may">May</option>
                                    <option value="jun">Jun</option>
                                    <option value="jul">Jul</option>
                                    <option value="aug">Aug</option>
                                    <option value="sep">Sep</option>
                                    <option value="oct">Oct</option>
                                    <option value="nov">Nov</option>
                                    <option value="dec">Dec</option>
                                @elseif($query_configPms->frequency == 'quarterly')
                                    <option name="Q1" value="q1"> Q1 (Jan-March)</option>
                                    <option name="Q2" value="q2"> Q2 (Apr-Jun)</option>
                                    <option name="Q3" value="q3"> Q3 (Jul-Sept)</option>
                                    <option name="Q4" value="q4"> Q4 (Oct-Dec)</option>
                                @elseif($query_configPms->frequency == 'halfYearly')
                                    <option name="H1" value="h1">H1 (Jan-Jun)</option>
                                    <option name="H2" value="h2">H2 (Jul-Dec)</option>
                                @elseif($query_configPms->frequency == 'annually')
                                    <option name="A" value="A">A (Jan-Dec)</option>
                                @endif
                            @endif
                        </select>

                    </div>
                    <div class="col-3">

                        <label class="fw-bold pe-2">Employee Submission status </label>
                        <select id="dropdownSubmittedStatus" class="form-select " style=""
                            aria-label=".form-select-sm example">
                            <option value="All" class="text-ash"  selected>--- Select All---</option>
                            <option value="1">Submitted</option>
                            <option value="">Not Yet Submitted</option>

                        </select>

                    </div>
                    <div class="col-3">

                        <label class="fw-bold pe-2">Manager Review Status </label>
                        <select id="dropdownReviewedStatus" class="form-select " style=""
                            aria-label=".form-select-sm example">
                            <option value="All" class="text-ash"  selected>------ Select All------
                            </option>
                            <option value="1">Reviewed</option>
                            <option value="">Not Yet Reviewed</option>
                        </select>

                    </div>

                    <div class="col-3">

                        <label class="fw-bold pe-2">Employee Accepted Status </label>
                        <select id="dropdownEmpAcpStatus" class="form-select " style=""
                            aria-label=".form-select-sm example">
                            <option value="All" class="text-ash"  selected>------ Select All------
                            </option>
                            <option value="1">Accepted</option>
                            <option value="">Not Yet Accepted</option>
                        </select>

                    </div>

                    <div class="col-3">

                        <label class="fw-bold pe-2">Manager Accepted Status </label>
                        <select id="dropdownMangrAcpStatus" class="form-select " style=""
                            aria-label=".form-select-sm example">
                            <option value="All" class="text-ash"  selected>------ Select All------
                            </option>
                            <option value="1">Accepted</option>
                            <option value="">Not Yet Accepted</option>
                        </select>

                    </div>
                </div>
                <div class="row mb-3">
                    {{-- <div class="col-3">

                        <label class="fw-bold pe-2">Line Manager </label>
                        <select id="dropdownReviewedStatus" class="form-select " style=""
                            aria-label=".form-select-sm example">
                            <option value="All" class="text-ash" hidden disabled selected>Select Manager Review Status
                            </option>
                            <option value="1">Reviewed</option>
                            <option value="">Not Yet Reviewed</option>
                        </select>

                    </div> --}}

                    <div class="col-3 d-flex align-items-center ">
                        <p class=" align-items-centerd-flex pt-1">
                            <label class=" fw-bold "> Calendar Year : </label>
                            <?php

                            if ($query_configPms->calendar_type == 'financial_year') {
                                echo 'Financial Year';
                            } elseif ($query_configPms->calendar_type == 'calendar_year') {
                                echo 'Calendar Year';
                            } else {
                                echo 'Error';
                            }
                            ?>

                        </p>
                    </div>
                    <div class="col-3 d-flex align-items-center ">
                        <p class="  ">
                            <span class="fw-bold"> Frequency : </span> {{ ucfirst($query_configPms->frequency) }}

                        </p>
                    </div>
                    <div class="col-3 ">
                        <div class="d-flex mt-2">
                            <button class="btn btn-orange me-2" id="btn_run"><i class="fa fa-cog me-2"></i> Generate
                            </button>

                            <button class="btn btn-orange " id="btn_downloadReport"><i
                                    class=' me-2 fas fa-file-download'></i>Download Report</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="pmsReportTable" class="table table-bordered" style="display: none;white-space:nowrap;">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Emp Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Calendar Type</th>
                                <th scope="col" style="width: 100%;">Year</th>
                                <th scope="col">Frequency</th>
                                <th scope="col">Assignment Period</th>
                                <th scope="col">Employees Submission Status</th>
                                <th scope="col">Manager Review Status</th>
                                <th scope="col">Manager Name</th>
                            </tr>
                        </thead>
                        <tbody id="pmsTbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    {{-- <script src="https://ajax.googleapis.com//ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pmsReportTable').DataTable({
                searching: false,
                pagingType: "full_numbers",
                "paging": false,
                "ordering": false,
                "lengthMenu": [10, 25, 50, 75, 100],
                responsive: true,
                scroolY: true,


            });

            let calenderType = '{{ $query_configPms->calendar_type }}';
            //let year = $('#year').val();

            $('#btn_run').on('click', function() {
                var year = $('#year').val();
                var assignment_period = $('#dropdownAssignment_period').val();
                let selectedSubmittedDropdown = $('#dropdownSubmittedStatus').find(":selected").val();
                let selectedReviewedDropdown = $('#dropdownReviewedStatus').find(":selected").val();
                let selectedEmpAcpDropdown = $('#dropdownEmpAcpStatus').find(":selected").val();
                let selectedEmpMangrDropdown = $('#dropdownMangrAcpStatus').find(":selected").val();

                console.log(year);
                $.ajax({
                    url: "{{ route('pms-filter-info') }}",
                    type: 'GET',
                    data: {
                        year: year,
                        assignment_period: assignment_period,
                        submission_status: selectedSubmittedDropdown,
                        reviewed_status: selectedReviewedDropdown,
                        emp_accepted_status:selectedEmpAcpDropdown,
                        mangr_accepted_status:selectedEmpMangrDropdown,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        document.getElementById("pmsReportTable").style.display = "block";
                        var trHtml = ""
                        $('#pmsReportTable').find('tbody').empty();
                        // console.log(res.length);

                        $.each(res, function(i, userdata) {
                            console.log(userdata);
                            if (userdata.calendar_type == 'financial_year') {
                                userdata.calendar_type = "Financial Year";
                                if (userdata.frequency == "quarterly") {
                                    userdata.frequency = "Quarterly";
                                    if (userdata.assignment_period == "q1") {
                                        userdata.assignment_period = "Q1 (Apr-Jun)"
                                    } else if (userdata.assignment_period == "q2") {
                                        userdata.assignment_period = "Q2 (Jul-Sept)"
                                    } else if (userdata.assignment_period == "q3") {
                                        userdata.assignment_period = "Q3 (Oct-Dec)"
                                    } else if (userdata.assignment_period == "q4") {
                                        userdata.assignment_period = "Q4 (Jan-March)"
                                    }
                                }
                            } else if (userdata.calendar_type == 'calendar_year') {
                                userdata.calendar_type = 'Calendar Year';
                                if (userdata.frequency == "quarterly") {
                                    userdata.frequency = "Quarterly";
                                    if (userdata.assignment_period == "q1") {
                                        userdata.assignment_period = "Q1 (Jan-March)"
                                    } else if (userdata.assignment_period == "q2") {
                                        userdata.assignment_period = "Q2 (Apr-Jun)"
                                    } else if (userdata.assignment_period == "q3") {
                                        userdata.assignment_period = "Q3 (Jul-Sept)"
                                    } else if (userdata.assignment_period == "q4") {
                                        userdata.assignment_period = "Q4 (Oct-Dec)"
                                    }
                                }
                            }

                            // if (userdata.frequency == 'monthly') {
                            //     userdata.frequency = "Monthly";
                            //     switch (userdata.assignment_period) {
                            //         case "jan":
                            //             userdata.assignment_period = 'January';
                            //             break;
                            //         case "feb":
                            //             userdata.assignment_period = "February"
                            //             break;
                            //         case "mar":
                            //             userdata.assignment_period = "March"
                            //             break;
                            //         case "apr":
                            //             userdata.assignment_period = "April"
                            //             break;
                            //         case "may":
                            //             userdata.assignment_period = "May"
                            //             break;
                            //         case "june":
                            //             userdata.assignment_period = "June"
                            //             break;
                            //         case "july":
                            //             userdata.assignment_period = "July"
                            //             break;
                            //         case "aug":
                            //             userdata.assignment_period "August"
                            //             break;
                            //         case "sept":
                            //             userdata.assignment_period = "September"
                            //             break;
                            //         case "oct":
                            //             userdata.assignment_period = "October"
                            //             break;
                            //         case "nov":
                            //             userdata.assignment_period = "November"
                            //             break;
                            //         case "dec":
                            //             userdata.assignment_period = "December"
                            //             break;
                            //     }
                            // }

                            if (userdata.is_assignee_submitted == "1") {
                                userdata.is_assignee_submitted = "Submitted";
                            } else {
                                userdata.is_assignee_submitted =
                                    "Not Yet Submitted";
                            }

                            // if(userdata.is_reviewer_submitted!=0){
                            var data = JSON.parse(userdata.is_reviewer_submitted)
                            var keys, values
                            var data2 = '<?php echo json_encode($username); ?>';
                            var name = JSON.parse(data2)
                            Object.keys(data)
                                .forEach(key => {
                                    // console.log(key, data[key]);
                                    keys = name[key];
                                    values = data[key] == "1" ? 'Reviewed' :
                                        'Not Reviewed';
                                    // console.log(keys,)
                                })
                            // }

                            trHtml =
                                '<tr><td>' +
                                (i + 1) + '</td><td>' +
                                userdata.user_code + '</td><td>' +
                                userdata.name + '</td><td>' +
                                userdata.calendar_type + '</td><td>' +
                                userdata.year + '</td><td>' +
                                userdata.frequency + '</td><td>' +
                                userdata.assignment_period + '</td><td>' +
                                userdata.is_assignee_submitted + '</td><td>' +
                                values + '</td><td>' +
                                keys + '</td></tr>'
                            $('#pmsTbody').append(trHtml);
                        });

                    }

                });
            });

            // Table = $('#pmsReportTable').DataTable({
            //     "searching": false,
            //     "pagingType": "full_numbers",
            //     "paging": false,
            //     "ordering": true,
            //     "lengthMenu": [10, 25, 50, 75, 100],
            //     "responsive": true,
            // });
            // $('#your_input_text_field').keyup(function() {
            //     Table.search($(this).val()).draw();
            // })


            $('#btn_downloadReport').on('click', function(e) {

                console.log("Download payroll reports....");
                let selectedAssingementPeriod = $('#dropdownAssignment_period').find(":selected").val();
                let year = $('#year').val();
                let selectedSubmittedDropdown = $('#dropdownSubmittedStatus').find(":selected").val();
                let selectedReviewedDropdown = $('#dropdownReviewedStatus').find(":selected").val();
                let selectedEmpAcpDropdown = $('#dropdownEmpAcpStatus').find(":selected").val();
                let selectedEmpMangrDropdown = $('#dropdownMangrAcpStatus').find(":selected").val();
                console.log(selectedAssingementPeriod + ' ' + selectedSubmittedDropdown);
                let URL = '/reports/generatePmsReviewsReports?calender_type=' + calenderType + '&year=' +
                    year + '&assignment_period=' + selectedAssingementPeriod + '&is_assignee_submitted=' +
                    selectedSubmittedDropdown + '&is_reviewer_submitted=' + selectedReviewedDropdown +
                    '&is_reviewer_accepted=' + selectedEmpMangrDropdown +  '&is_emp_accepted=' + selectedEmpAcpDropdown +
                    '&_token={{ csrf_token() }}';
                console.log("Generated URL : " + URL);

                window.location = URL;




            });


        });
    </script>
@endsection
