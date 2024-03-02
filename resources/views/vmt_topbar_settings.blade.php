@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .btn-file {
            position: absolute;
            overflow: hidden;
            cursor: pointer;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            cursor: pointer;
            color: orange;
            display: block;
        }

        .browse-logo-wrapper {
            position: relative;
        }

        .browse-logo-wrapper .logo-img {
            height: 50px;
            width: 100px;

        }

        .logo-img img {
            height: 100%;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="settings-wrapper    mt-30">
        <div class="text-start">
            <!-- href for dashboard -->
            

            <a href="{{ url('vmt_hr_dashboard') }}"><i class=" ri-arrow-left-circle-line mx-2 "></i> Back to dashboard</a>
        </div>
        <div class="settings-layout p-0 d-flex justify-content-start container-fluid ">
            <div class="row w-100">
                <div class="col-md-4 col-xl-4 col-lg-4 ">
                    <div class="left-content  d-flex">
                        <div class="card ">
                            <div class="card-body p-0">
                                <div class="nav list-group flex-column " id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a href="#v-general" class="nav-link list-group-item flex-column d-flex"
                                        id="v-pills-home-tab" data-bs-toggle="pill" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true">
                                        <label>Org Infoz</label>
                                        <span> General info settings </span>
                                    </a>



                                    <a href="#" class="list-group-item"><label>
                                            Account & Billing </label>
                                        <span> Information about account and billing </span>
                                    </a>



                                    <a href="#v-company" class="nav-link flex-column list-group-item  d-flex"
                                        id="v-pills-home-tab" data-bs-toggle="pill" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true"><label>
                                            Company Info </label>
                                        <span> Information about Company </span>
                                    </a>

                                    <a href="#v-welcome" class="nav-link flex-column list-group-item  d-flex"
                                        id="v-pills-home-tab" data-bs-toggle="pill" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true"><label>
                                            Welcome Screen </label>
                                        <span> Welcome screen settings </span>
                                    </a>
                                    <a href="#v-roll" class="nav-link flex-column list-group-item d-flex"
                                        id="v-pills-home-tab" data-bs-toggle="pill" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true"><label>
                                            Roles & Permissions </label><span> Manage roles and permissions
                                        </span></a>
                                    <a href="#" class="list-group-item"><label>
                                            Integrations and Automation </label><span> Login, Event triggers,
                                            Email digest and API
                                            access
                                        </span></a>
                                    <a href="#" class="list-group-item"><label>
                                            Data Imports </label><span> Data import tracker
                                        </span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-xl-8 col-lg-8 ">
                    <div class=" tab-content right-content p-0 mx-1 container-fluid" id="v-pills-tabContent">
                        <!-- general info -->
                        <div class=" p-0  tab-pane fade show active" id="v-general" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">


                            <div class="header-content d-flex align-items-center bg-white  px-3">
                                <label class="heading">General Info</label>
                            </div>


                            <div class="container-fluid p-0 content-body bg-white my-1" id="general-Info">
                                <div class="card ">
                                    <div class="card-body">


                                        {{-- <form method="POST" id='role-form' action="{{ url('/vmt-general-info') }}"
                                            enctype="multipart/form-data"> --}}
                                            @csrf
                                            <div class="mb-3">
                                                <label for="short-name" class="form-label">Short Name</label>
                                                <input type="text" class="form-control w-25" id="short_name"
                                                    name="short_name">

                                            </div>


                                            <div class="mb-3 d-flex flex-column">
                                                <label for="logo" class="form-label">Logo</label>


                                                <span class="text-secondary">Logo dimensions cannot exceed 100 px
                                                    width
                                                    60
                                                    px height. <span class="text-danger">*</span> </span>

                                            </div>

                                            <div class="mb-3">
                                                <div class="browse-logo-wrapper d-flex align-items-center">
                                                    <?php
                                                    $client_list = getClientList();
                                                    ?>
                                                    @foreach ($client_list as $singleClient)
                                                        <div class="logo-img ">
                                                            <span>{{ $singleClient->client_name}}</span>
                                                            <img
                                                                src="{{ request()->getSchemeAndHttpHost() . '' . $singleClient->client_logo }}">
                                                        </div>
                                                        <div class="logo-img d-flex align-items-center">
                                                            <button type="button" class="btn btn-primary btn-file">
                                                                Browse <input type="file" id="{{ $singleClient->id }}" name="client_logo[]"
                                                                    accept=".png,.jpg,.jpeg,.bmp" onchange="readURL(this);"
                                                                    style="width:20px;height:15px;cursor: pointer;">
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>


                                            {{-- <div class="mb-3 ">
                                            <div class="background-image-content d-flex flex-column">
                                                <label for="logo" class="form-label">Background Image</label>

                                                <span class="text-secondary">
                                                    This Background Image will be displayed in the Login Page.
                                                </span>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <div class="background-container d-flex align-items-center">

                                                <div class="background-img">
                                                    <img id="profile_background_image_dist" src=""
                                                        alt="brand-logo">
                                                </div>
                                                <div class="background-image-pin">
                                                    <button type="button" class="btn btn-warning mx-2">
                                                        <i class="ri-attachment-line px-1"></i>
                                                        <span> Pick different background</span>
                                                        <input type="file" id="background-img" name="background-img" accept=".png,.jpg,.jpeg,.bmp" onchange="readBackgroundURL(this);">
                                                    </button>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-3">
                                            <div class="intructions-container d-flex flex-column">
                                                <label for="logo" class="form-label">Instruction
                                                    Information</label>
                                                <span class="text-secondary">This text will be displayed in the
                                                    Login Page.</span>


                                            </div>

                                        </div>

                                        <div class="mb-3">
                                            <div class="scrollBar  d-flex align-items-center">
                                                <textarea
                                                    placeholder="You can provide instructions or similar information not exceeding 250 characters"
                                                    rows="4" maxlength="250" formcontrolname="loginInstructions"
                                                    class="form-control "></textarea>
                                            </div>

                                        </div> --}}



                                            <div class="text-end">
                                                {{-- <button class="btn btn-default mx-2">Preview</button> --}}
                                                <button id="btn_submit" type="submit" class="btn btn-primary">Save</button>
                                            </div>

                                            <!-- for success message -->

                                            <div style="z-index: 11">
                                                <div id="borderedToast2"
                                                    class="toast toast-border-success overflow-hidden mt-3" role="alert"
                                                    aria-live="assertive" aria-atomic="true">
                                                    <div class="toast-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-2">
                                                                <i class="ri-checkbox-circle-fill align-middle"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0" id="alert-msg">Yey! Everything
                                                                    worked!</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!--user  rolls -->

                        <div class="p-0   tab-pane fade show " id="v-roll" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">

                            <div class="header-content d-flex align-items-center bg-white  px-3">
                                <label class="heading">User Roll</label>
                            </div>
                            <div class="container-fluid p-0  bg-white my-3 ">
                                <div class="card m-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4 justify-content-between">
                                            <div>
                                                <h4 class="fw-bold text-primary">User Roles</h4>
                                                <p class=" text-secondary"> User Roles can be assigned to the
                                                </p>
                                            </div>
                                            <div class="d-flex w-50 align-items-center w-75  justify-content-end ">
                                                <div class="input-search align-self-center w-50">
                                                    <i class=" ri-search-line "></i>
                                                    <input type="text" placeholder="Search Roles" autocomplete="off"
                                                        class="search-bar border-none rounded-pill outline-none "><span
                                                        class="ic-search icon"></span>

                                                </div>
                                                <button class="btn btn-primary mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#rollModal">New Role</button>

                                            </div>
                                        </div>
                                        <div class="">
                                            <table class="table table-bordered">
                                                <thead class="" style="background-color:#f3f4f7">
                                                    <tr>
                                                        <th class="w-250">User Roles</th>
                                                        <th>Scope and Permissions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <td>
                                                            <p> Asset Manager <span><a class="icon-click"><span
                                                                            class="ri-pencil-line"></span></a></span>

                                                            </p>
                                                            <p class="text-small text-secondary">An asset
                                                                manager
                                                                has all
                                                                the permissions to manage the assets in the
                                                                organization.
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <div class="d-flex">

                                                                    <p class="">Across all employees</p>
                                                                </div>
                                                                <div class="">
                                                                    <div class="chip-wrapper b-0 p-0">
                                                                        <div class="chips d-flex m-2">
                                                                            <div
                                                                                class="employee-profile-header  d-flex align-items-center justify-content-center">
                                                                                <div
                                                                                    class="profile-picture  d-flex align-items-center justify-content-center">
                                                                                    <div class="img-initials">
                                                                                        RS </div>
                                                                                </div>

                                                                            </div><span class="name px-2">Rashmi
                                                                                Singh</span>
                                                                        </div>


                                                                        <div class="chips d-flex m-2">
                                                                            <div
                                                                                class="employee-profile-header  d-flex align-items-center justify-content-center">
                                                                                <div
                                                                                    class="profile-picture  d-flex align-items-center justify-content-center">
                                                                                    <div class="img-initials">
                                                                                        AD </div>


                                                                                </div>

                                                                            </div><span class="name px-2">Abhishek
                                                                                Dey
                                                                            </span>
                                                                        </div>

                                                                        <div class="chips d-flex m-2">
                                                                            <div
                                                                                class="employee-profile-header  d-flex align-items-center justify-content-center">
                                                                                <div
                                                                                    class="profile-picture  d-flex align-items-center justify-content-center">
                                                                                    <div class="img-initials">
                                                                                        AD </div>


                                                                                </div>

                                                                            </div><span class="name px-2">Abhishek
                                                                                Dey
                                                                            </span>
                                                                        </div>
                                                                        <!---->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!---->
                                                            <!---->
                                                            <!----><a class="text-link">Manage Users</a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="p-0   tab-pane fade show " id="v-company" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">

                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class=" header-card-text">
                                        <h6>Personal Details</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Employee Code</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Company Name</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Contract Start Date </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label"> Contract End Date</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Company Identification
                                                        Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Company TAN</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Company PAN</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Employee Code"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">GST No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="EPF Registration Number"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">EPF Registration
                                                        Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="ESIC Registration Number"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">ESIC Registration
                                                        Number</label>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="LWF Registration Number"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">LWF Registration
                                                        Number</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text"
                                                        placeholder="Professional Tax Registration Number"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Professional Tax
                                                        Registration Number</label>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class=" header-card-text">
                                        <h6>Authorized Details</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Authorized Person Name"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Authorized Person
                                                        Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Authorized Person Designation"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Authorized Person
                                                        Designation</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Authorized Person Contact Number"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Authorized Person Contact
                                                        Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Authorized Person Contact Email"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Authorized Person Contact
                                                        Email</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Billing Address"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Billing Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="text" placeholder="Shipping Address"
                                                        name="employee_code" class="onboard-form form-control textbox"
                                                        required />
                                                    <label for="" class="float-label">Shipping Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <input type="file" placeholder="" name="employee_code"
                                                        class="onboard-form form-control textbox" required />
                                                    <!-- <label for="" class="float-label"></label> -->
                                                </div>


                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <select class="form-select textbox" aria-label="">
                                                        <option value="Select Subscription Type" show disabled readonly>
                                                            Select Subscription Type>
                                                        </option>
                                                        <option value="Monthly">Monthly</option>
                                                        <option value="Quarterly">Quarterly</option>
                                                        <option value="BiAnnually">BiAnnually</option>
                                                        <option value="Annually">Annually</option>
                                                    </select>
                                                    <label for="" class="float-label">Subscription Type</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 mb-3">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">

                                                    <select class="form-select textbox" aria-label="">
                                                        <option value="">Select Product</option>
                                                        <option value="Recruitment">Recruitment</option>
                                                        <option value="Payroll">Payroll</option>
                                                        <option value="Statutory Complainces">Statutory Complainces
                                                        </option>
                                                        <option value="Staffing">Staffing</option>
                                                        <option value="PMS">PMS</option>
                                                        <option value="Accounting">Accounting</option>
                                                        <option value="ROC Complainces">ROC Complainces</option>
                                                        <option value="Trade Mark">Trade Mark</option>
                                                        <option value="Patent Right">Patent Right</option>
                                                    </select>
                                                    <label for="" class="float-label">Product</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 mb-3 text-end">
                                                <button type="submit" class="btn btn-primary  action-button text-center"
                                                    value="Submit">Submit</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- welcome -->

                        <div class="p-0   tab-pane fade show " id="v-welcome" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">

                            <div class="header-content d-flex align-items-center bg-white  px-3">
                                <label class="heading">Welcome Screen</label>
                            </div>
                            <div class="container-fluid p-0  bg-white my-3 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="intructions-container ">
                                                <h4 class="fw-bold text-primary">Welcome Screen</h4>
                                                <p class="">This screen is visible </p>


                                            </div>

                                        </div>

                                        <div class="mb-4">
                                            <div class="welcone-msg">
                                                <p>Welcome Message</p>
                                            </div>

                                            <div class="scrollBar  w-50 d-flex align-items-center">
                                                <textarea rows="4" class="form-control" placeholder="Welcome Message.." style="height: 111px;"></textarea>
                                            </div>

                                        </div>



                                        <div class="mb-4">

                                            <p>Contacts to assist new joinees</p>
                                            <p>These contacts will be shown on the welcome screen to assist new
                                                joinees.
                                            </p>

                                            <div class="d-flex">
                                                <div class="chip-wrapper  p-0">

                                                    <input class="form-control Search-Employee" aria-expanded="false"
                                                        aria-autocomplete="list" placeholder="Search Employee">


                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-4 ">
                                            <div class=" mt-4 buttons-container d-flex align-items-center">
                                                <button class="btn btn-default mx-2">Preview</button><button
                                                    class="btn btn-primary">Save</button>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- roll modal -->

                    <div class="modal fade p-2" id="rollModal">
                        <div class="modal-dialog modal-lg " id="" aria-hidden="true"
                            aria-labelledby="exampleModalToggleLabel2" tabindex="-1">

                            <div class="modal-content ">
                                <div class="modal-header py-3 new-role-header d-flex align-items-center">


                                    <h4 class="modal-title">Create New
                                        Role
                                    </h4>
                                    <hr class="bottom-dash">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>

                                </div>
                                <div class="modal-body">
                                    <div class="settings-contents container-fluid">

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label for="nameRoll" class="form-label">Name of the
                                                    Role</label>
                                                <input type="text" class="form-control" id="nameRoll">
                                            </div>
                                            <div class="col-6">
                                                <label for="Short" class="form-label">Short
                                                    Descriptions</label>
                                                <textarea type="text" class="form-control" id="Short" style="resize:none;height:15px"></textarea>
                                            </div>
                                        </div>



                                        <div class="mb-3 ">

                                            <div class="row ">
                                                <div class="col-6">
                                                    <h4>Permissions</h4>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-search align-self-center"><input type="text"
                                                            placeholder="Search Roles" autocomplete="off"
                                                            class="form-control w-100 "><span
                                                            class="ic-search icon"></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <div class="container-fluid p-0 d-flex">

                                                <div class="left-content-settings">
                                                    <div class="card ">

                                                        <div class="card-body p-0">
                                                            <div class="nav list-group" id="v-pills-tab" role="tablist"
                                                                aria-orientation="vertical">
                                                                <a href="#v-pills-assest"
                                                                    class="nav-link active list-group-item flex-column d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true">
                                                                    <label>Assets</label>
                                                                    <span> </span>
                                                                </a>



                                                                <a href="#v-pills-attendance"
                                                                    class="nav-link list-group-item flex-column d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true">
                                                                    <label>Attendance</label>
                                                                    <span> </span>
                                                                </a>
                                                                <a href="#v-pills-document"
                                                                    class="nav-link flex-column list-group-item  d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Documents</label>
                                                                    <span></span>
                                                                </a>
                                                                <a href="#v-pills-finance"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Employee Finance</label>
                                                                    <span>
                                                                    </span></a>
                                                                <a href="#v-pills-engage"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Engage </label><span>
                                                                    </span></a>
                                                                <a href="#v-pills-expenses"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Expenses </label><span> </span></a>
                                                                <a href="#v-pills-helpdesk"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Helpdesk </label><span> </span></a>
                                                                <a href="#v-pills-hris"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        HRIS </label><span> </span></a>
                                                                <a href="#v-pills-helpdesk"
                                                                    class="nav-link flex-column list-group-item d-flex"
                                                                    id="v-pills-home-tab" data-bs-toggle="pill"
                                                                    role="tab" aria-controls="v-pills-home"
                                                                    aria-selected="true"><label>
                                                                        Helpdesk </label><span> </span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="right-content-settings mt-0 mx-5 d-flex">

                                                    <div class="tab-content" id="v-pills-tabContent ">
                                                        <!-- assest -->
                                                        <div class="">
                                                            <div class="tab-pane active assest fade show"
                                                                id="v-pills-assest" role="tabpanel"
                                                                aria-labelledby="v-pills-home-tab">
                                                                <div class="list-group assest ">
                                                                    <label class="list-group-item fw-bold">
                                                                        <input class="form-check-input me-1 "
                                                                            type="checkbox" value="">
                                                                        Asset Privileges
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        View Asset Dashboard
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        View Asset Inventory
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Add Individual Asset
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Edit Individual Asset Information
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Bulk import assets & assignment
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Assign Asset to an Employee
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Update Asset Availability
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Recover Asset & Update Condition
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        View Reports
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Download Reports
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Manage Asset DefinitionsGlobal
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Manage Asset SettingsGlobal
                                                                    </label>
                                                                    <label class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox" value="">
                                                                        Delete Asset
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- attendance -->
                                                        <div class="tab-pane fade " id="v-pills-attendance"
                                                            role="tabpanel">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Attendance Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View employees attendance details
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Apply for attendance adjustment / regularisation
                                                                    on behalf of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject attendance adjustment /
                                                                    regularisation requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Apply 'Work from Home (WFH) / On Duty (OD)' on
                                                                    behalf of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject 'Work from Home (WFH) / On Duty
                                                                    (OD)' requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Cancel 'Work from Home (WFH) / On Duty (OD)'
                                                                    requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Apply for partial day on behalf of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject partial day requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Cancel partial day request
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View employees' overtime (OT) requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Apply for overtime (OT) permission on behalf of
                                                                    employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject overtime (OT) requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Cancel Overtime request
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject 'Remote Clock-In' requests
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Assign Shifts and Weekly-offs to Employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Shift and Weekly-offs
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Shifts and Weekly-offs
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Assign tracking policies to Employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Tracking Policy
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage tracking policies
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Assign capture scheme to Employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Capture scheme
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View employees' Shift/Weekly-off requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Apply for Shift/Weekly-off permission on behalf
                                                                    of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve/Reject Shift/Weekly-off requests
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Shift/Weekly-off Rules
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Shift/Weekly-off Rules
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Assign Shift/Weekly-off Rule to Employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage employees on shift board
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Shift Board
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Shift Board
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage employees in shift Rotation

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Shift Rotation
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Shift Rotation
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Assign OT policy to employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage OT Policy and Pay Codes
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View OT Policy and Pay Codes
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Attendance Diplay Settings
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage IP Network Configuration
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Geo Locations
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Geo Locations
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View attendance reports of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Download attendance reports of employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Attendance Dashboard Summary
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Shift Allowance
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Shift Allowance
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Assign Shift Allowance
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- documents -->
                                                        <div class="tab-pane active fade " id="v-pills-document"
                                                            role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Employee Document Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Employee Documents
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Add / Edit Employee Documents
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Delete Employee Documents
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Download Employee Documents
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Remind Employee To Submit Document
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Verify Employee Documents
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Document Definitions
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Document Audit Logs
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Bulk Upload Documents
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Move Bulk Uploaded Documents in Profile
                                                                </label>
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Employee Letter Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Letters
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Download Employee Letters
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Delete Employee Letters
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Generate Employee Letters
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Letter Templates
                                                                </label>
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 " type="checkbox"
                                                                        value="">

                                                                    Org Document Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add / Edit Org Documentss
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Delete Org Documents
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Org Document Folders
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Employee Finance -->

                                                        <div class="tab-pane active fade " id="v-pills-finance"
                                                            role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Employee Finance Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Employee Salary Details
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Add/Update Salary Details

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View employee Payslips
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View IncomeTaxDetails
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Access Form 12BB
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View employee income tax declarations
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage employee income tax declarations
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Delete Employee Declarations
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View employee component claims
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add/Update employee component claims
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">


                                                                    Approve employee component claims
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View employee FBP declarations
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">


                                                                    Add/Update employee FBP declaration
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Previous Income
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add Previous Income
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View employee financial data
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1 " type="checkbox"
                                                                        value="">

                                                                    Add/Update employee financial data
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View loan details
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Request loan for employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add loan for employees
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Approve/Reject loan request
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update loan of Employees
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Engage -->
                                                        <div class="tab-pane  fade " id="v-pills-engage" role="tabpanel"
                                                            aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Employee Communication Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Announcements
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Polls

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Articles
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Pulses
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Pulse Analytics
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Surveys
                                                                </label>

                                                            </div>
                                                        </div>

                                                        <!-- expenses -->
                                                        <div class="tab-pane  fade " id="v-pills-expenses"
                                                            role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Expense Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Expense Dashboard
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Expense Claim

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add Expense Claim
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve Expense Claim
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Delete Expense Claim
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Advance Request
                                                                </label>


                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Add Advance Request
                                                                </label>


                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve Advance Request
                                                                </label>


                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Delete Advance Request
                                                                </label>


                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Approve Travel Request
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Expense Settings
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Expense Categories
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Download Reports
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update Expense Payment Status
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Update Advance Payment Status
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Change Expense Payout Date
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Change Advance Payout Date
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- helpdesk -->

                                                        <div class="tab-pane  fade " id="v-pills-helpdesk"
                                                            role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Helpdesk Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage All Tickets
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Reports

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Download Reports
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Settings
                                                                </label>

                                                            </div>
                                                        </div>

                                                        <!-- HRIS -->


                                                        <div class="tab-pane  fade " id="v-pills-hris" role="tabpanel"
                                                            aria-labelledby="v-pills-home-tab">
                                                            <div class="list-group assest ">
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1 fw-bold"
                                                                        type="checkbox" value="">
                                                                    Core HR Privileges
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Employee Settings
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Employee Probation Evaluation

                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Reports
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Download Reports
                                                                </label>
                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Logins
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Organization Information
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage abs Account And Billing
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Welcome Screen Settings
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Roles And Permissions
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Authentication Settings
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Event Triggers
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Data Imports
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Custom Reports
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Custom Reports
                                                                </label>

                                                                <label class="list-group-item">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Org Tree Settings
                                                                </label>

                                                                <label class="list-group-item px-2 py-3 fw-bold">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Dashboard Privileges
                                                                </label>

                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Customize Home Page Widgets
                                                                </label>
                                                                <label class="list-group-item px-2 py-3 fw-bold">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Email Digest Privileges
                                                                </label>

                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Email Digest Settings
                                                                </label>
                                                                <label class="list-group-item px-2 py-3 fw-bold">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Employee Job Privileges
                                                                </label>

                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Job Info
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update Employee Job Info
                                                                </label>

                                                                <label class="list-group-item px-2 py-3 fw-bold">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Employee Offboarding Privileges
                                                                </label>

                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    Manage Bulk Exit Imports
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Exit Tasks
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Exit Status
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Exited Employees
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employees Exit Pending Requests
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">
                                                                    View Employees In Exit Process
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Reverted Exits
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Initiate Employee Exit
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Process & Settle
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Cancel Exit
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add Adhoc Task
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update Task
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Approve / Reject Exit Notice
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Settings
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Settings
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Exit Tasks
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Exit Task Dashboard
                                                                </label>
                                                                <label class="list-group-item fw-bold mx-2 my-3">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Employee Onboarding Privileges
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Employee Onboarding
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Add Adhoc Task
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update Task
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Initiate Employee Onboarding
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Complete Employee Onboarding
                                                                </label>

                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    View Onboarding Groups
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Onboarding Groups
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Manage Onboarding Tasks
                                                                </label>
                                                                <label class="list-group-item fw-bold px-2 py-3">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Employee Profile Privileges
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">


                                                                    View Employee Profile Info
                                                                </label>
                                                                <label class="list-group-item ">
                                                                    <input class="form-check-input me-1" type="checkbox"
                                                                        value="">

                                                                    Update Employee Profile Info
                                                                </label>
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
                </div>



                <!--end row-->
            </div>
        </div>


    </div>
@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile_round_image_dist')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBackgroundURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile_background_image_dist')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        // $('#role-form').on('submit', function(e) {


        //     //var formData = new FormData(this);
        //     var roleUri = $('#role-form').attr('action');
        //     // console.log(roleUri);
        //     function(e) {
        //         $.ajax({
        //             type: "POST",
        //             url: roleUri,
        //             enctype: 'multipart/form-data',
        //             data: new FormData(this),
        //             processData: false,
        //             contentType: false,
        //             success: function(data) {
        //                 $('#alert-msg').html(data);
        //                 var toastLiveExample3 = document.getElementById("borderedToast2");
        //                 var toast = new bootstrap.Toast(toastLiveExample3);
        //                 //  toast.show();


        //                 //alert(data); // show response from the php script.
        //             }
        //             e.preventDefault();

        //         })
        //     }
        //     //console.log($('#role-form').serialize());
        // });

        $(document).ready(function(){
        $("#btn_submit").on('click',function(e){
            e.preventDefault();
       
           
            var fields = document.getElementsByName("client_logo[]");
            let client_logo = $('input[name="client_logo[]"]').map(function() {
                 return  $(this).val(); 
                } ).get();
                


            // console.log(client_logo);
            $.ajax({
                url: "{{ route('update_client_logo')}}",
                type:'POST',
                data_type: "json",
                data: {
                    'client_logo[]': client_logo,
                   _token : '{{ csrf_token() }}'
                    },
                    success: function(data) {
                     location.reload();
                }
                     });
       
        }); });
    </script>
@endsection
