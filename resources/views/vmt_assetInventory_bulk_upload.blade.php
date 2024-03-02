@extends('layouts.master')
@section('css')

<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/employee_bulk.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">

@endsection
@section('content')

<div class="uploadEmployee-wrpper mt-30">

        <div class="card shadow profile-box card-top-border border-0">
            <div class="form-control">
                <div class="row">
                    <div class="col-md-6 col-xl-6  col-xxl-6  col-sm-12  col-lg-6 ">
                                                    <h6> Asset Inventory Bulk Upload</h6>
                            <div class="col col-form-label">
                                <ul class="list-style-numbered list-style-circle p-4">
                                        <li>Download the
                                            <a href="{{ url('/assets/sample_asset_investory.xlsx')  }}" target="_blank" class="ms-1 choose-file">
                                            <i class="fa fa-file" aria-hidden="true"></i>Sample File</a>

                                        </li>

                                       

                                        <li>Read the upload instructions on the right before uploading .</li>
                                        <li>Fill the information in excel template</li>
                                        <li>
                                            <form method="POST" id='role-form' action="{{ route('vmt-assetinventory-bulk-upload-post') }}"
                                                enctype="multipart/form-data">  
                                                @csrf
                                              
                                                    <label >Please Upload the Asset Inventories details excel-sheet.</label>
                                               
                                                <!-- <div class="mb-3 row">
                                                    <div class="col-md-10">
                                                        <input name="file" type="file" required>
                                                    </div>
                                                </div> -->

                                                <span class="choose-file ms-1">
                                                <input name="file" type="file" required>
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                                Choose file
                                            </span>

                                                
                                                    <div class="text-end col-12  mt-2">
                                                        <button type="submit" class="btn btn-orange">Upload</button>
                                                    </div>
                                                

                                                 <div class="rows">
                                                    <div class="col-xl-12">
                                                        <div id="success-msg"></div>
                                                        <div id="error-msg"></div>

                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                </ul>

                                </form>
                            
                        </div>

                    </div>

                    <div class="col-md-6 col-xl-6  col-xxl-6  col-sm-12  col-lg-6 ">
                      
                            <h6> Upload Instructions</h6>
                            <div class="alert py-2 f-12 alert-warning"><i class="fa fa-warning text-danger"></i> Read
                                    these instructions before uploading the file.</div>
                            <ul class="list-style-circle">
                                <li> Asset Name, Asset Type, Serial Number, Warranty, Vendor, Assignee, Asset Status And Assigned Date fields are required to add Asset Inventory. </li>
                            </ul>
                            </div>
                       
                    </div>
                </div>
            </div>
            {{--   <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                </div>

                <div class="card-body  pb-2">
                    <xhr-file-upload>
                                    <div class="d-inline-flex justify-content-center align-items-center">
                                        <div containerclass="max-w-300" container="body" class="d-inline-block position-relative"><button class="btn btn-sm btn-primary">Upload Excel File</button><input type="file" name="fileupload" class="input-file" accept=".xlsx"></div>
                                        <div class="ml-8"><span containerclass="max-w-300" container="body" class="icon ic-info cursor-pointer"></span>

                            </div>
                            <xhr-file-upload>


                    <div> --}}
            {{--   <form method="POST" id='role-form' action="{{url('/vmt-payslip')}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
                <label class="col-md-2 col-form-label">Select Files</label>
                <div class="col-md-10">
                    <input name="file" type="file">
                </div>
            </div>
            <div class="row mt-2">
                <div class="text-end col-xl-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            </form> --}}
        </div>
 
{{-- </div>end col --}}
{{-- </div>end row --}}
<div style="z-index: 11">
    <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-2">
                    <i class="ri-checkbox-circle-fill align-middle"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0" id="alert-msg">Yey! Everything worked!</h6>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="z-index: 11">
    <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-2">
                    <i class="ri-checkbox-circle-fill align-middle"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0" id="alert-msg">Yey! Everything worked!</h6>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Create Employee Modal window -->

<div class="modal fade" id="createEmployee">
    <div class="modal-dialog modal-xl" id="" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">

        <div class="modal-content">
            <div class="modal-header py-2 ">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title " id="exampleModalToggleLabel2">Create New
                        Employee
                    </h5>
                    <hr class="bottom-dash">
                    <button type="button" class="btn-close " data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body h-50">

                <div class="section-content w-100  my-4 d-flex justify-content-center">
                    <ul class="nav nav-pills w-100 mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item d-flex w-100 align-items-center justify-content-center  "
                            role="presentation">
                            <button class="nav-link active rounded-circle  mx-2 " id="pills-basic-btn"
                                data-bs-toggle="pill" data-bs-target="#pills-basic-details" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">1
                            </button><span>BASIC DETAILS</span>
                        </li>
                        <li class="nav-item d-flex w-100 align-items-center justify-content-center  "
                            role="presentation">
                            <button class="nav-link rounded-circle mx-2 " id="pills-job-btn" data-bs-toggle="pill"
                                data-bs-target="#pills-job-details" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">2</button> <span>JOB DETAILS</span>
                        </li>
                        <li class="nav-item d-flex w-100 align-items-center justify-content-center "
                            role="presentation">
                            <button class="nav-link rounded-circle mx-2 " id="pills-work-btn" data-bs-toggle="pill"
                                data-bs-target="#pills-work-details" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">3</button>
                            <span> WORK DETAILS</span>
                        </li>
                        <li class="nav-item d-flex w-100 align-items-center justify-content-center "
                            role="presentation">
                            <button class="nav-link rounded-circle mx-2 " id="pills-compension-btn"
                                data-bs-toggle="pill" data-bs-target="#pills-compension" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">4
                            </button>
                            <span>COMPENSATION</span>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-basic-details" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="row">

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    First Name
                                </label>
                                <input type="text" class="form-control" id="middleName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Middle Name
                                </label>
                                <input type="text" class="form-control" id="middleName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Last Name
                                </label>
                                <input type="text" class="form-control" id="lastName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Display Name
                                </label>
                                <input type="text" class="form-control" id="displayName">


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3 ">

                                <label for="firstName" class="form-label">
                                    Gender
                                </label>
                                <div class="d-flex">
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Female
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Date Of Birth
                                </label>
                                <input type="date" class="form-control" id="displayName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Email
                                </label>
                                <input type="text" class="form-control" id="displayName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Mobile Number
                                </label>
                                <input type="text" class="form-control" id="displayName">


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Work Type
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Work Type
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="empNuber" class="form-label">
                                    Employee Number
                                </label>
                                <input type="text" class="form-control" id="empNuber">


                            </div>
                        </div>
                        <div class="content-footer">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex">
                                        <ul class="nav nav-pills w-100 mb-4" id="pills-tab" role="tablist">
                                            <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                                role="presentation">
                                                <button data-bs-dismiss="modal"
                                                    class="btn btn-primary mx-2 p-2">Cancel</button>
                                                <button class="btn btn-primary waves-effect waves-light"
                                                    id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-job-details" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">
                                                    Continue
                                                </button>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade" id="pills-job-details" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Joining Date
                                </label>
                                <input type="date" class="form-control" id="displayName">


                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Job Title
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Time Type
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Business Unit
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>


                        </div>

                        <div class="row">

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Department
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Location
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="empNuber" class="form-label">
                                    Reporting Manager
                                </label>
                                <input type="text" class="form-control" id="empNuber">


                            </div>

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="empNuber" class="form-label">
                                    Dotted Line Manager
                                </label>
                                <input type="text" class="form-control" id="empNuber">


                            </div>

                        </div>
                        <div class="row">

                            <h5>Advanced</h5>


                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Probation Policy
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Notice Period
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <a href="#" class="d-flex align-items-center justifu-content-center">
                                    <i class="ri-plus-2-line"></i>
                                    add secondary job title
                                </a>




                            </div>
                        </div>

                        <div class="content-footer">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex">
                                        <ul class="nav nav-pills w-100 mb-4" id="pills-tab" role="tablist">
                                            <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                                role="presentation">
                                                <button class="btn btn-primary mx-2 p-6" id="pills-profile-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-basic-details"
                                                    type="button" role="tab" aria-controls="pills-profile"
                                                    aria-selected="false">
                                                    Back</button>
                                                <button class="btn btn-primary waves-effect waves-light"
                                                    id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-work-details" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">
                                                    Continue</button>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-work-details" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Invite Employee To Login
                                    </label>
                                </div>

                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">


                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Enable Onboarding Flow
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">


                                <select class="form-control">
                                    <option value="" default>Select Onboarding Flow</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                        </div>

                        <div class="row">

                            <h5>Time & Advanced Settings</h5>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Leave Plan
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Shift
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Week Off
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Holiday List
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Attandance Tracking Policy
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Attandance Capture Scheme
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Over Time Policy
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>

                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="empNuber" class="form-label">
                                    Attandance Number
                                </label>
                                <input type="text" class="form-control" id="empNuber">


                            </div>


                        </div>

                        <div class="row">

                            <h5>Other Settings</h5>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Expense Policy
                                </label>
                                <input type="text" class="form-control" id="middleName">


                            </div>

                        </div>

                        <div class="content-footer">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex">
                                        <ul class="nav nav-pills w-100 mb-4" id="pills-tab" role="tablist">
                                            <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                                role="presentation">
                                                <button class="btn btn-primary mx-2 p-6" id="pills-profile-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-job-details"
                                                    type="button" role="tab" aria-controls="pills-profile"
                                                    aria-selected="false">

                                                    Back</button>
                                                <button class="btn btn-primary waves-effect waves-light"
                                                    id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-compension" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">

                                                    Continue</button>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-compension" role="tabpanel"
                        aria-labelledby="pills-contact-tab">

                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Pay Group
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">
                                <label for="firstName" class="form-label">
                                    Pay Group
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>



                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        ESI Eligible
                                    </label>
                                </div>

                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        LWF Eligible
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xl-3 mb-3 col-md-3">

                                <label for="firstName" class="form-label">
                                    Salary Structure Type
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>

                            </div>
                            <div class="col-xl-3 mb-3 col-md-3">
                                <label for="firstName" class="form-label">
                                    Tax Regime To Cosider
                                </label>

                                <select class="form-control">
                                    <option value="" default>none</option>
                                    <option value="">Permanent</option>
                                    <option value="">Contract</option>
                                    <option value="">Intern</option>
                                </select>


                            </div>





                        </div>

                        <div class="content-footer">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex">
                                        <ul class="nav nav-pills w-100 mb-4" id="pills-tab" role="tablist">
                                            <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                                role="presentation">
                                                <button class="btn btn-primary mx-2 p-6" id="pills-profile-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-work-details"
                                                    type="button" role="tab" aria-controls="pills-profile"
                                                    aria-selected="false">

                                                    Back</button>
                                                <button class="btn btn-primary waves-effect waves-light" type="button"
                                                    role="tab" aria-controls="pills-profile" aria-selected="false">

                                                    Save</button>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>





    </div>

    <!-- george end -->

    <!-- add employee  Modal-->


</div>

</div>




@endsection
@section('script')

<!-- ui notifications -->

<script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
<!-- apexcharts -->

<!-- dashboard init -->

<script type="text/javascript">
$('#role-form').on('submit', function(e) {
    e.preventDefault();

    //var formData = new FormData(this);
    var roleUri = $('#role-form').attr('action');
    console.log(roleUri);

    $.ajax({
        type: "POST",
        url: roleUri,
        enctype: 'multipart/form-data',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data) {
            console.log('success', data);
            $('#success-msg').html(data.success);
            $('#error-msg').html(data.failed);


            //var toastLiveExample3 = document.getElementById("borderedToast2");
            //var toast = new bootstrap.Toast(toastLiveExample3);
            //toast.show();
            //alert(data); // show response from the php script.
        }, error: function(data){
            //console.log('error', data);
            $('#error-msg').html(data.responseText);
        }
    })
    //console.log($('#role-form').serialize());
});
</script>
@endsection
