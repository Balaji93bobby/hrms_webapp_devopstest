@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/create_leave.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="create-holiday-wrapper mt-30">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h6>Holiday Settings</h6>

                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 col-lg-4 col-xxl-4 col-md-6">
                        <div class="card" >

                            <img src="{{ URL::asset('assets/images/holiday/Diwali.png') }}" class="rounded" alt="">
                            <div class="card-body py-1 px-2">
                                <div class="card-text p-2 d-flex align-items-center justify-content-between">
                                    <h6 class="holiday-name mb-0">Independance Day</h6>
                                    <span class="holiday-day fs-12 fw-bold text-muted">Nov
                                        1
                                        (sunday)</span>

                                    {{-- <button data-bs-target="#edit-img" data-bs-toggle="modal"
                                        class="border-0 bg-transparent outline-none fs-14 fa text-muted fa-pencil"></button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="createHoliday-wrapper">
                    <div class="d-flex align-items-center filter-set">

                        <div class="filter me-2">
                            <select name="" id="" class="form-select assign-to form-control ">
                                <option value="" selected hidden disabled>Assign To</option>

                            </select>
                        </div>
                        <div class="filter d-flex me-2">
                            <i class=" text-muted far fa-calendar"></i>
                            <select name="" id="" class="form-select form-control ">
                                <option value="" selected hidden disabled>Chooose Month</option>

                            </select>
                        </div>
                        <button data-bs-target="#add-newHoliday" data-bs-toggle="modal" class="btn btn-orange "><i
                            class="fa fa-plus-circle me-1"></i> Add New Holiday</button>

                    </div>
                    <div id="createHoliday-table" class="createHoliday-table"></div>
                </div>


            </div>
        </div>


        <div id="add-newHoliday" class="modal   fade" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0  text-end d-flex justify-content-end">

                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0 ">
                        <div class="edit-image-wrapper">
                            <div class="edit-img  text-end my-1">
                                <button class="bg-transparent border-0 outline-none fs-14"> <i
                                        class="fa fa-pencil  text-muted" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Edit image"></i></button>
                            </div>
                            <div class="img-cotainer">

                                <img src="{{ URL::asset('assets/images/holiday/Diwali.png') }}" class="rounded h-100 w-100"
                                    alt="">
                            </div>
                            <div class="img-content">
                                <div class="mb-2">
                                    <label for="festival_name" class="form-label">Festival name</label>
                                    <input type="text" class="form-control" id="festival_name">
                                </div>
                                <div class="mb-2">
                                    <label for="festival_description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="festival_description">
                                </div>
                                <div class="mb-2">
                                    <label for="festival_date" class="form-label">Festival Date</label>
                                    <input type="Date" class="form-control" id="festival_date">
                                </div>
                            </div>

                            <div class="text-right">
                                <button class="btn btn-orange">Save</button>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div id="edit-img" class="modal   fade" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-md" role="document">
                <div class="modal-content profile-box">
                    <div class="modal-header border-0  text-end d-flex justify-content-end">

                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body  text-center">
                        <div class="drag-area">
                            <h6>Upload Images</h6>
                            <span class="fs-12">(PNG,JPEG,JPG files are allowed)</span>
                            <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <header>Drag & Drop to Upload File</header>
                            <span>OR</span>
                            <button class="bg-transparent btn btn-border ">Browse File</button>
                            <input type="file" hidden>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            if (document.getElementById("createHoliday-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'number',
                            name: 'Check box',

                        },
                        {
                            id: 'name ',
                            name: ' Festival ',

                        },
                        {
                            id: 'job_title',
                            name: 'Description',
                        },
                        {
                            id: 'reporting_to',
                            name: ' Date(dd/mm/yyyy)',
                        },

                        {
                            id: 'reporting_to',
                            name: ' Day',
                        },


                    ],
                    data: [

                    ],

                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,




                }).render(document.getElementById("createHoliday-table"));


            }



        });
    </script>
@endsection
