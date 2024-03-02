@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/roles_permission.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="exit-details mt-30">

        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Resignation Details</h6>

                {{-- <div class="table-responsive"> --}}
                {{-- <div class="resignation-detailsTable" id="resignationTable"></div> --}}

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date Of Resignation Initiated</th>
                            <th>Resignation Type</th>
                            <th>Exprected Last Working Day</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>04-Feb-2023</td>
                            <td>Illness</td>
                            <td>04-Feb-2023</td>
                            <td>
                                <div class="dropdown custom-dropDown dropdown-action">
                                    <button class="btn bg-transparent  outline-none border-0 dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                        <a class="dropdown-item" href="#"><i class="fa fa-eye text-info me-2"
                                                aria-hidden="true"></i>
                                            View</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-trash text-danger me-2"
                                                aria-hidden="true"></i>
                                            Delete Resignation</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- </div> --}}
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {

            if (document.getElementById("resignationTable")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'number',
                            name: 'Date Of Resignation Initiated'

                        },
                        {
                            id: 'number',
                            name: 'Resignation Type',

                        },
                        {
                            id: 'number',
                            name: 'Exprected Last Working Day',

                        },
                        {
                            id: 'number',
                            name: 'Actions',

                        },



                    ],
                    data: [

                    ],

                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("resignationTable"));


            }



        });
    </script>
@endsection
