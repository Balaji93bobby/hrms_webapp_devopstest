@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/swiper/swiper.min.css')}}" rel="stylesheet" type="text/css" />


<!-- prem content -->

<!--Bootstrap CSS-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/bootstrap.min.css') }}">

<!--Custom style.css-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/quicksand.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/dashboard.css') }}">
<!--Bootstrap Calendar-->
<!-- <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/bootstrap_calendar.css') }}"> -->

<!--Font Awesome-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome.css') }}">
<!--Animate CSS-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/chartist.min.css') }}">
<!--Map-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/jquery-jvectormap-2.0.2.css') }}">


<!-- calendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<!-- prem content end -->
<style>
.f-20 {
    font-size: 20px;
}

.rounded-corner-add {
    border-radius: 30px !important;
    padding: 10px !important;
    width: 100px !important;
}

.br-card {
    border-radius: 10px !important;
}

.round {
  position: relative;
}

.round label {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 50%;
  cursor: pointer;
  height: 20px;
  left: 0;
  position: absolute;
  top: 0;
  width: 20px;
}

.round label:after {
  border: 2px solid #fff;
  border-top: none;
  border-right: none;
  content: "";
  height: 6px;
  left: 4px;
  opacity: 0;
  position: absolute;
  top: 5px;
  transform: rotate(-45deg);
  width: 12px;
}

.round input[type="checkbox"] {
  visibility: hidden;
}

.round input[type="checkbox"]:checked + label {
  background-color: #e9284a;
  border-color: #e9284a;
}

.round input[type="checkbox"]:checked + label:after {
  opacity: 1;
}

.number-top {
    border-radius: 0px 0px 30px 0px;
    padding: 2px 18px 12px 17px;
}

.plus-sign {
    --vz-bg-opacity: 1;
    background-color: rgba(var(--vz-light-rgb), var(--vz-bg-opacity)) !important;
    border-radius: 20px;
}

.avatar {
  display: inline-block;
}

.avatar:not(:first-child) {
  margin-left: -13px;
}

.img-addition {
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
</style>

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Dashboard @endslot
@endcomponent




<div class="container-fluid ">
    <div class="cards-wrapper">

        <div class="row">
            <div class="col-12 col-lg-12 col-md-12 ">
                <div class="card ">
                    <div class="card-body">

                        <!-- <div class="d-flex justify-content-between align-items-center">

                            <div class="row align-items-center">
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="image-content mx-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}"
                                                        class="img-round">
                                                </div>
                                                <div class="message-content mx-2">
                                                    <h5 class="fw-bold">250/200</h5>
                                                    <span>Lorem ipsum dolor sit amet.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="image-content mx-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}"
                                                        class="img-round">
                                                </div>
                                                <div class="message-content mx-2">
                                                    <h5 class="fw-bold">250/200</h5>
                                                    <span>Lorem ipsum dolor sit amet.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="image-content mx-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}"
                                                        class="img-round">
                                                </div>
                                                <div class="message-content mx-2">
                                                    <h5 class="fw-bold">250/200</h5>
                                                    <span>Lorem ipsum dolor sit amet.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="image-content mx-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}"
                                                        class="img-round">
                                                </div>
                                                <div class="message-content mx-2">
                                                    <h5 class="fw-bold">250/200</h5>
                                                    <span>Lorem ipsum dolor sit amet.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="align-items-center" style="justify-content:center;">
                            <div class="row align-items-center">
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0"></div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Employees with Goals</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Employees assessed/ rated</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Goals assignment reminder notification</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Rating assessment reminder notification</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0"></div>
                            </div>
                        </div>
                        <div class="align-items-center mt-3" style="justify-content:center;">

                            <div class="row align-items-center">
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3"></div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Self Review</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Manger Review</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 col-xl-2 pr-0">
                                    <div class="card employee-cards m-0">
                                        <div class="card-body p-0">
                                            <div class="row mt-2">
                                                <p class="pl-3 col-auto pb-2">
                                                    <img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round">
                                                </p>
                                                <div class="pt-2 col pb-2 pl-0">
                                                    <h5 class="fw-bold">-</h5>
                                                    <span>Org review</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6 col-xl-3"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 p-5" id="initial-section">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2 p-5">
                    <div class="p-3"><img src="{{ URL::asset('assets/images/vmt_user_icon.jpeg') }}" style="width: 37%;height: 74%;"></div>
                    <h4><b>Assign Goals for your employees</b></h4>
                    <div class="mt-4">
                        <button id="add-goals" class="rounded-pill py-1 px-2 mx-2 text-white btn btn-primary"><h6 class="m-0 text-white p-2"><i class="text-white fa fa-plus mr-2"></i><b>Add</b></h6></button>
                    </div>
                </div>
            </div>
        </div> 

    </div>

    <!-- <div class="assign-cards-wrapper">
        <div class="card mt-5 assignCards">
            <div class="card-header p-0 m-0">
                <div class="d-flex   justify-content-between align-items-center ">
                    <div class="d-flex  align-items-center">
                        <span class="left fw-bold text-white pt-3 px-4 pb-4">New</span>
                        <h5 class="m-0 mx-3">Assign Goals</h5>
                    </div>
                    <div class="d-flex align-items-center">

                        <span class="right rounded-pill py-1 px-2 mx-2 text-white btn btn-lg" id="publish-goal" style="cursor: pointer;">Publish</span>
                        <i class="ri-close-fill fw-bold mx-1 mt-0"></i>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="goalForm">
                    @csrf
                    <input type="hidden" name="kpitable_id" id="kpitable_id">
                    <input type="hidden" name="employees[]" id="sel_employees">
                    <input type="hidden" name="reviewer" id="sel_reviewer">
                    <div class="row mt-3">
                        <div class="col-4  mt-3 mb-3">
                            <div class="d-flex flex-column">
                                <label class="" for="Assignment">
                                    Assignment Period</label>
                                <input type="text" name="assignment_period" class="" required />
                            </div>
                        </div>
                        <div class="col-4 mt-3 mb-3 ml-5">
                            <div class="d-flex flex-column">
                                <label class="" for="Assignment">
                                    Coverage</label>
                                <select name="coverage" id="">
                                    <option value="Employee">Employee</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Project Manager">Project Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4  mt-3 mb-3">
                            <div class="d-flex flex-column">
                                <label class="" for="Assignment">Employees-02</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-group-item">
                                        <a >
                                            <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle">
                                        </a>
                                        <div class="mt-1 message-content align-items-start d-flex flex-column  mx-2">
                                            <span id="group-employee"></span>
                                        </div>
                                    </div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#changeEmployee" class="right btn btn-primary py-1 px-3 rounded-pill mx-3 text-white">Change</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 mt-3 mb-3 d-flex ml-5">

                            <div class="d-flex flex-column">
                                <label class="" for="Assignment">Reviwer</label>
                                <div class="d-flex align-items-center">
                                    <div class="card reviwer-cards  m-0 rounded-pill">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <a>
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle">
                                                </a>

                                                <div class=" mt-1 message-content align-items-start d-flex flex-column  mx-2">
                                                    <h6 class="fw-bold m-0" id="reviewer-name">Steve Jobs</h6>
                                                    <span id="reviewer-email">Steve@gmail.com</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button 
                                        type="button" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#createEmployee"
                                        class="right btn btn-primary py-1 px-3 rounded-pill mx-3 text-white"
                                    >
                                        Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="table-wrapper">
                    <h5>Key focus areas</h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="container-fluid bg-light mt-3 py-2 rounded-border d-felx align-items-center">
                                <h6 class="m-0">Goals / Areas of development</h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="container-fluid mb-1 mt-3 ">
                                <form id="kpiTableForm">
                                    
                                <table class="table align-middle mb-0 table-nowrap responsive table-responsive" id="kpiTable">
                                    @csrf
                                    <thead class="text-white bg-primary thead" id="tHead">

                                            <tr class="text-uppercase">
                                                <th class="sort" data-sort="id" style="width: 2%;">#</th>
                                                <th class="sort" data-sort="customer_name" style="width: 8%;">Dimension</th>
                                                <th class="sort" data-sort="product_name" style="width: 25%;">KPI</th>
                                                <th class="sort" data-sort="date" style="width: 25%;">Operational Definition</th>
                                                <th class="sort" data-sort="amount" style="width: 25%;">Measure</th>
                                                <th class="sort" data-sort="payment" style="width: 10%;">Frequency</th>
                                                <th class="sort" data-sort="status" style="width: 20%;">Target</th>
                                                <th class="sort" data-sort="status" style="width: 20%;">Stretch Target</th>
                                                <th class="sort" data-sort="status" style="">Source</th>
                                                <th class="sort" data-sort="status" style="width: 10%;" width="10%">KPI Weightage</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody content-container" id="tbody">
                                            <tr class="addition-content cursor-pointer" id="content1">
                                                <td class="">
                                                    <span  name="numbers" id="" class="tableInp" >1</span>
                                                    <div class="text-danger delete-row cursor-pointer"><i class="fa fa-trash f-20"></i></div>
                                                </td>

                                                <td class="">
                                                    <textarea name="dimension[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>

                                                <td class="">
                                                    <textarea name="kpi[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="operational[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="measure[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="frequency[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="target[]" id="" cols="20" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="stretchTarget[]" id="" cols="10" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="source[]" id="" cols="10" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea name="kpiWeightage[]" id="" cols="10" rows="2"
                                                        placeholder="type here"></textarea>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </form>
                                <div class="align-items-center justify-content-center d-flex mt-4 cursor-pointer">
                                    <span class="plus-sign p-4"><i class="fa fa-plus f-20"></i></span>
                                </div>
                                <div class="buttons d-flex justify-content-end align-items-center mt-4 ">
                                    <button class="btn btn-primary table-btn mx-2" id="save-table">Save Table</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<div id="add-goals-modal" class="modal custom-modal fade show" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-0">
                <div class="assign-cards-wrapper col-12 p-0">
                    <div class="assignCards">
                        <div class="card-header p-0 m-0">
                            <div class="d-flex   justify-content-between align-items-center ">
                                <div class="d-flex  align-items-center">
                                    <span class="left fw-bold text-white pt-3 px-4 pb-4">New</span>
                                    <h5 class="m-0 mx-3">Assign Goals</h5>
                                </div>
                                <div class="d-flex align-items-center mx-5">
                                    <span class="right rounded-pill py-1 px-2 mx-2 text-white btn btn-lg" id="publish-goal" style="cursor: pointer;">Publish</span>
                                </div>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="assign-cards-wrapper">
                    <div class="assignCards">
                        <form id="goalForm">
                            @csrf
                            <input type="hidden" name="kpitable_id" id="kpitable_id">
                            <input type="hidden" name="employees[]" id="sel_employees">
                            <input type="hidden" name="reviewer" id="sel_reviewer">
                            <div class="row mt-3">
                                <div class="col-4  mt-3 mb-3">
                                    <div class="d-flex flex-column">
                                        <label class="" for="Assignment">
                                            Assignment Period</label>
                                        <input type="text" name="assignment_period" class="" required />
                                    </div>
                                </div>
                                <div class="col-4 mt-3 mb-3 ml-5">
                                    <div class="d-flex flex-column">
                                        <label class="" for="Assignment">
                                            Coverage</label>
                                        <select name="coverage" id="">
                                            <option value="Employee">Employee</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Project Manager">Project Manager</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-4  mt-3 mb-3">
                                    <div class="d-flex flex-column">
                                        <label class="" for="Assignment">Employees-02</label>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-group-item">
                                                <a class="avatar">
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle p-0">
                                                </a>
                                                <a class="avatar">
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle p-0">
                                                </a>
                                                <a class="avatar">
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle p-0">
                                                </a>
                                                <a class="avatar">
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle p-0">
                                                </a>
                                                <span class="img-addition" style="background-color: rgb(134, 192, 106);width: 30px;height: 30px;font-size:12px;"> +12 </span>
                                                <div class="mt-1 message-content align-items-start d-flex flex-column  mx-2">
                                                    <span id="group-employee"></span>
                                                </div>
                                            </div>
                                            <button type="button" target="#changeEmployee" class="right btn btn-primary py-1 px-3 rounded-pill mx-3 text-white chnageButton">Edit</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 mt-3 mb-3 d-flex ml-5">

                                    <div class="d-flex flex-column">
                                        <label class="" for="Assignment">Reviwer</label>
                                        <div class="d-flex align-items-center">
                                            <div class="card reviwer-cards  m-0 rounded-pill">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <a>
                                                            <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded-circle">
                                                        </a>

                                                        <div class=" mt-1 message-content align-items-start d-flex flex-column  mx-2">
                                                            <h6 class="fw-bold m-0" id="reviewer-name">Steve Jobs</h6>
                                                            <span id="reviewer-email">Steve@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button 
                                                type="button" 
                                                target="#createEmployee"
                                                class="right btn btn-primary py-1 px-3 rounded-pill mx-3 text-white reviewerButton"
                                            >
                                                Change
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-wrapper">
                            <h5>Key focus areas</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="container-fluid bg-light mt-3 py-2 rounded-border d-felx align-items-center">
                                        <h6 class="m-0">Goals / Areas of development</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="container-fluid mb-1 mt-3 ">
                                        <form id="kpiTableForm">
                                            <table class="table align-middle mb-0 table-nowrap responsive table-responsive" id="kpiTable">
                                                @csrf
                                                <thead class="text-white bg-primary thead" id="tHead">
                                                    <tr class="text-uppercase">
                                                        <th class="sort" data-sort="id" style="width: 2%;">#</th>
                                                        <th class="sort" data-sort="customer_name" style="width: 8%;">Dimension</th>
                                                        <th class="sort" data-sort="product_name" style="width: 25%;">KPI</th>
                                                        <th class="sort" data-sort="date" style="width: 25%;">Operational Definition</th>
                                                        <th class="sort" data-sort="amount" style="width: 25%;">Measure</th>
                                                        <th class="sort" data-sort="payment" style="width: 10%;">Frequency</th>
                                                        <th class="sort" data-sort="status" style="width: 20%;">Target</th>
                                                        <th class="sort" data-sort="status" style="width: 20%;">Stretch Target</th>
                                                        <th class="sort" data-sort="status" style="">Source</th>
                                                        <th class="sort" data-sort="status" style="width: 10%;" width="10%">KPI Weightage</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody content-container" id="tbody">
                                                    <tr class="addition-content cursor-pointer" id="content1">
                                                        <td class="">
                                                            <span  name="numbers" id="" class="tableInp" >1</span>
                                                            <div class="text-danger delete-row cursor-pointer"><i class="fa fa-trash f-20"></i></div>
                                                        </td>

                                                        <td class="">
                                                            <textarea name="dimension[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>

                                                        <td class="">
                                                            <textarea name="kpi[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="operational[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="measure[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="frequency[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="target[]" id="" cols="20" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="stretchTarget[]" id="" cols="10" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="source[]" id="" cols="10" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                        <td class="">
                                                            <textarea name="kpiWeightage[]" id="" cols="10" rows="2"
                                                                placeholder="type here"></textarea>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </form>
                                        <div class="align-items-center justify-content-center d-flex mt-4 cursor-pointer">
                                            <span class="plus-sign p-4"><i class="fa fa-plus f-20"></i></span>
                                        </div>
                                        <div class="buttons d-flex justify-content-end align-items-center mt-4 ">
                                            <button class="btn btn-primary table-btn mx-2" id="save-table">Save Table</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Reviewr window -->

<div class="modal fade" id="createEmployee">
    <div class="modal-dialog modal-md" id="" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-backdrop="static">
        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Change Reviewer
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close btn-close-white close-reviewerButton" data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form id="newQuestion" method="POST" >
                    @csrf
                    <label for="FormSelectDefault" class="form-label text-muted">Reviewer</label>
                    <select class="form-select mb-3" aria-label="Default select example" name="reviewer" id="select-reviewer" >
                        @foreach($users as $index => $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    <div class="content-footer">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="d-flex">
                                    <ul class="nav nav-pills w-100 mb-4" id="pills-tab"
                                        role="tablist">
                                        <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                            role="presentation">
                                           
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="submit">
                                                Save
                                            </button>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- add employee  Modal-->
</div>

<!-- Select Employees window -->
<div class="modal fade" id="changeEmployee">
    <div class="modal-dialog modal-md" id="" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-backdrop="static">

        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Select Employees
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close btn-close-white close-changeEmployee" data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                    </button>
                </div>
            </div>
            <div class="modal-body">

                <form id="changeEmployeeForm" method="POST" >
                    @csrf
                    <label for="FormSelectDefault" class="form-label text-muted">Employees</label>
                    <select class="form-select mb-3" aria-label="Default select example" name="employees[]" id="select-employees" multiple>
                        @foreach($employees as $index => $employee)
                            <option value="{{$employee->id}}">{{$employee->emp_name}}</option>
                        @endforeach
                    </select>
                
                    <div class="content-footer">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="d-flex">
                                    <ul class="nav nav-pills w-100 mb-4" id="pills-tab"
                                        role="tablist">
                                        <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                            role="presentation">
                                           
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="submit">
                                                Save
                                            </button>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- add employee  Modal-->
</div>


<!--Main Content-->



<!--  -->
@endsection

@section('script')
<!-- Prem assets -->
<!-- OWL CAROUSEL -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>

<!--Charts JS-->
<script src="{{ URL::asset('/assets/premassets/js/charts/chart.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/charts/demo.js') }}"></script>
<!--Maps-->
<script src="{{ URL::asset('/assets/premassets/js/maps/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/maps/jvector-maps.js') }}"></script>
<!--Bootstrap Calendar JS-->
<!-- <script src="{{ URL::asset('/assets/premassets/js/calendar/bootstrap_calendar.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/calendar/demo.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<!--Nice select-->
<script src="{{ URL::asset('/assets/premassets/js/jquery.nice-select.min.js') }}"></script>

<!--Custom Js Script-->
<script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/dashboard.js') }}"></script>


<!-- Prem assets ends -->

<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<!-- for date and time -->
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function () {
    $("#kpiTable").sortable({
        items: 'tr',
        cursor: 'pointer',
        axis: 'y',
        dropOnEmpty: false,
        start: function (e, ui) {
            ui.item.addClass("selected");
        },
        stop: function (e, ui) {
            ui.item.removeClass("selected");
            $(this).find("tr").each(function (index) {
                // if (index > 0) {
                //     $(this).find("td").eq(1).html(index);
                // }
            });
        }
    });
});
</script>
<script>
    // $("#select-reviewer").select2({
    //     dropdownParent: $("#createEmployee")
    // });
    $('.reviewerButton').click(function() {
        $('#createEmployee').show();
        $('#createEmployee').removeClass('fade');
    });
    $('.close-reviewerButton').click(function() {
        $('#createEmployee').hide();
        $('#createEmployee').addClass('fade');
    });
    $('.chnageButton').click(function() {
        $('#changeEmployee').show();
        $('#changeEmployee').removeClass('fade');
    });
    $('.close-changeEmployee').click(function() {
        $('#changeEmployee').hide();
        $('#changeEmployee').addClass('fade');
    });
    $('#add-goals').click(function() {
        $('#add-goals-modal').modal('show');
    });

$('body').on('click', '.plus-sign', function() {
    var id = $('.addition-content:last').attr('id');
    var length = 1;
    if (id) {
        length = parseInt(id.replace('content', '')) + 1;
    }
    $('.content-container').append('<tr class="addition-content cursor-pointer" id="content'+length+'"><td class=""><span  name="numbers" id="" class="tableInp" >'+length+'</span><div class="text-danger delete-row cursor-pointer"><i class="fa fa-trash f-20"></i></div></td><td class=""><textarea name="dimension[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="kpi[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="operational[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="measure[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="frequency[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""> <textarea name="target[]" id="" cols="20" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="stretchTarget[]" id="" cols="10" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="source[]" id="" cols="10" rows="2" placeholder="type here"></textarea></td><td class=""><textarea name="kpiWeightage[]" id="" cols="10" rows="2" placeholder="type here"></textarea></td></tr>');
});

$('body').on('click', '.delete-row', function() {
    $(this).parent().parent().remove();
});

$('#changeEmployeeForm').on('submit', function(e){
    e.preventDefault();
    var employeeSelected = $('#select-employees').val();
    var employees = {!!json_encode($employees)!!};
    var employeeArray = [];

    $("#sel_employees").val(employeeSelected);

    $.each(employees, function(i, data){
        if($.inArray(data.id.toString(), employeeSelected) > -1){
            employeeArray.push(data.emp_name);
        }
    });
    $('#group-employee').html(employeeArray.join());
    $('#changeEmployee').modal('hide');
});

// select reviewer
$('#newQuestion').on('submit', function(e){
    e.preventDefault();
    var userList = {!!json_encode($users)!!};
    var selReviewer = $('#select-reviewer').val();
    $("#sel_reviewer").val(selReviewer);

    $.each(userList, function(i, data){
        if(data.id == $('#select-reviewer').val()){
            $('#reviewer-name').html(data.name);
            $('#reviewer-email').html(data.email);
        }
    });

    $('#createEmployee').modal('hide');
});

// publishing tables
$('body').on('click', '#save-table', function(e){
    // e.preventDefault();
    console.log('assigning Goals');
    console.log($('#kpiTableForm').serialize());

    $.ajax({
        type: "POST", 
        url: "{{url('vmt-pms-kpi-table/save')}}", 
        data: $('#kpiTableForm').serialize(), 
        success: function(data){

            $("#kpiTableForm :input").prop("disabled", true);
            $(".table-btn").prop('disabled', true);

            alert("Table Saved, Please publish goals");
            $("#kpitable_id").val(data.table_id);
        }
    })
})

//
$("#publish-goal").click(function(e){
    e.preventDefault();

    if($('#kpitable_id').val()){  
        $.ajax({
            type: "POST", 
            url: "{{url('vmt-pms-assign-goals/publish')}}", 
            data: $('#goalForm').serialize(), 
            success: function(data){

                $("#kpiTableForm :input").prop("disabled", true);
                $(".table-btn").prop('disabled', true);

                alert("Goal Assigned, Email Sent to the employees");
                $("kpitable_id").val(data.table_id);
            }
        })
    }else{
        alert("please publish table first");
    }
   
});


</script>

@endsection