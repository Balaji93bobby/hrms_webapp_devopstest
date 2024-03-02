@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent


    <div class="card leave_settings-wrapper">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-8">
                    <h6 class="">Leave Settings</h6>
                </div>
                <div class="col-4 text-end">
                    <div class="d-flex justify-content-end">
                        <div class="input-group  w-50 me-2">
                            <label class="input-group-text " for="inputGroupSelect01"><i class="fa fa-calendar text-primary "
                                    aria-hidden="true"></i></label>
                            <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                <option selected>FY 2022-23</option>

                            </select>
                        </div>
                        <div>
                            <button class="btn btn-orange" type="button">
                                New policy
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card top-line">
                <div class="card-body">

                    <div class="row">
                        <div class="col-8">
                            <h6>Policy Settings- <span class="f-12 fw-bold text-muted">(All)</span></h6>
                        </div>
                        <div class="col-4 ">
                            <div class="d-flex justify-content-end">
                                <select class="form-select w-50 btn-line-primary" id="inputGroupSelect01">
                                    <option selected>Assign-to</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-12 mt-2">

                            <div class="table-responsive">
                                <table class="table table-hover table-borderless mb-0">
                                    <thead class="bg-primary">
                                        <th colspan="2">
                                            Leave Type
                                        </th>
                                        <th colspan="2">Annual <span class="f-10">(Days)</span> </th>
                                        <th colspan="2">Month <span class="f-10">(Days)</span> </th>
                                        <th colspan="2">Restricted <span class="f-10">(Days)</span> </th>
                                        <th colspan="2">Accural <span class="f-10">(Days)</span> </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="" colspan="10">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr class="">
                                                            <td colspan="2"></td>
                                                            <td colspan="2">12</td>
                                                            <td colspan="2">01</td>
                                                            <td colspan="2">10</td>
                                                            <td colspan="2">20</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="10 p-0">
                                                                <div class="alert alert-danger mb-0 py-1 d-flex align-items-center"
                                                                    role="alert">
                                                                    <div class="d-flex justify-content-center">
                                                                        <span class="text-warning fw-bold me-1">Note :
                                                                        </span><span class="  text-muted "> Lorem ipsum
                                                                            dolor sit amet.</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>

                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                            {{-- click on the add new will create new table  --}}
                            <div class="text-end">
                                <button class="btn btn-orange">
                                    Add New
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>


    <script>
        $(document).ready(function() {
            if (document.getElementById("leaveSettings_table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'number',
                            name: 'Leave Type',
                        },
                        {
                            id: 'name',
                            name: 'Annual(Days)',
                        },
                        {
                            id: 'job_title',
                            name: 'Month(Days)',
                        },
                        {
                            id: 'reporting_to',
                            name: 'Restricted Days',
                        },
                        {
                            id: 'reporting_to',
                            name: 'Department',
                        },
                    ],
                    data: [
                        // {
                        //     name: 'John',
                        //     email: 'john@example.com',
                        //     phoneNumber: '(353) 01 222 3333'
                        // },
                        // {
                        //     name: 'Mark',
                        //     email: 'mark@gmail.com',
                        //     phoneNumber: '(01) 22 888 4444'
                        // },
                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("leaveSettings_table"));
            }
        });
    </script>
@endsection
