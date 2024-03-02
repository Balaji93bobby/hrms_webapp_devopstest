@extends('layouts.master')
{{-- @include('ui-onboarding')
 --}}
@inject('carbon', 'Carbon\Carbon')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        input {
            /* width: 100% !important;
                                                            margin-left: 0 !important;
                                                            height: 2.9em; */
        }

        #current_address_copy {
            height: 12px !important;
            width: 12px !important;
        }

        .addfiles {
            padding: 7px;
            border-radius: 2px;
        }
    </style>
@endsection
@section('content')
    @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent

    <div class="card top-line" id="msform">
        <div class="card-body">
            <form method="GET" class="form-inline mb-2">
                <div class="row">
                    <div class="col-5">
                        <h6 class="mb-0 text-start">Daily Attendance</h6>
                    </div>
                    <div class="col-5">
                        <input type="date" name="date" value="{{ \Request::get('date') }}" class="form-control"
                            placeholder="select date">
                    </div>
                    <div class="col-2">
                        <button class="btn  btn-orange" type="submit">Apply</button>
                    </div>
                </div>
            </form>

            <table class="table table-hover">
                <thead>
                    <tr>

                        <th>Employee Code</th>
                        <th>Name</th>
                        <th>Check-in Time </th>
                        <th>Check-out Time</th>
                        <th>Late Coming delay </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->user_code }}
                            </td>
                            <td>{{ $user->name }}
                            </td>

                            <td>{{ $user->check_in_time ? $carbon::parse($user->check_in_time)->format('h:i:s A') : 'Absent' }}
                            </td>

                            <td>{{ $user->check_out_time ? $carbon::parse($user->check_out_time)->format('h:i:s A'): 'Absent' }}
                            </td>

                            <td>
                                <?php

                                    if(!empty( $user->check_in_time ))
                                    {
                                        $checkin_time =  $carbon::parse($user->check_in_time);
                                        $shift_starttime = $carbon::parse($shift_timings->shift_start_time);
                                        echo $checkin_time->diff($shift_starttime)->format('%H:%I:%S');
                                    }
                                ?>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>

    <!-- jQuery easing plugin -->
    <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>

    <!--Progressbar JS-->
    <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>


    <script>
        // $("#button_close").click(function(){
        //     window.location.href = "/";
        // });
    </script>
@endsection
