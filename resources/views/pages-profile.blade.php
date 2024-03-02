@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/pages_profile.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/payCheck.css') }}">
@endsection
@section('content')

    <div class="container-fluid user-details-wrapper mt-30 ">
        <div class="card  left-line mb-3">
            <div class="card-body px-2 py-2">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="nav-item text-muted" role="presentation">
                                <a class="nav-link active pb-2" data-bs-toggle="tab" href="#basic_info" aria-selected="true"
                                    role="tab">
                                    Info</a>
                            </li>
                            <li class="nav-item text-muted" role="presentation">
                                <a class="nav-link  pb-2" data-bs-toggle="tab" href="#info_document" aria-selected="true"
                                    role="tab">
                                    Document</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show fade active" id="basic_info" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="pro-overview">
                            <div class="row">
                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex">
                                    <div class="card profile-box border-0 flex-fill ">
                                        <div class="card-body">
                                            <div class="profile-wrapper d-flex w-100 ">
                                                <div class="profile-img d-flex">
                                                    @include('ui-profile-avatar-lg', [
                                                        'currentUser' => $user,
                                                    ])
                                                    <span class="personal-edit img-edit"><a href="#" class="edit-icon"
                                                            data-bs-toggle="modal" data-bs-target="#personal_info"
                                                            id="pencil-on-avatar">
                                                            <i class="ri-pencil-fill"></i></a></span>
                                                </div>
                                                <div class="profile-info w-75 ">
                                                    <h6 class="fw-bold mb-2 pt-1">{{ $user->name }}
                                                    </h6>
                                                    <p class="departmnet fw-bold f-15 text-muted">
                                                        {{ !empty($user_full_details->department) ? $user_full_details->department : '' }}
                                                    </p>
                                                    <p class="role text-muted f-15 fw-bold">
                                                        {{ !empty($user_full_details->designation) ? $user_full_details->designation : '' }}
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="mt-4">
                                                <h6 class="mb-2">Profile Completeness</h6>

                                                <div class="progress-wrapper">

                                                    <div class="mb-1 d-flex -justify-content-between ">
                                                        <p class="text-muted f-12">Profile Percentage</p>
                                                        <p class="text-muted text-end f-12 fw-bold">
                                                            {{ $profileCompletenessValue }}%
                                                        </p>
                                                    </div>
                                                    <div class="progress progress-bar-content mb-2">
                                                        <div class="progress-bar " role="progressbar"
                                                            style="width:{{ $profileCompletenessValue }}%"
                                                            aria-valuenow="{{ $profileCompletenessValue }}"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="text-muted f-12 fw-bold">Your profile is completed</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex col-xl-4 col-lg-6 col-sm-12s">
                                    <div class="card  profile-box employee-info-card flex-fill">
                                        <div class="card-body">
                                            <h6 class="">Employee Informations
                                                <span class="personal-edit"><a class="edit-icon" data-bs-toggle="modal"
                                                        data-bs-target="#employee_info"><i
                                                            class="ri-pencil-fill"></i></a></span>
                                            </h6>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{ !empty($user_full_details->mobile_number) ? $user_full_details->mobile_number : '' }}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href="">{{ $user->email }}</a></div>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    @if (!empty($user_full_details->dob))
                                                        <div class="text">
                                                            {{ date('d F Y', strtotime($user_full_details->dob)) }}
                                                        </div>
                                                    @endif
                                                </li>
                                                <li>
                                                    <div class="title">Current Address:</div>
                                                    <div class="text">
                                                        {{ $user_full_details->current_address_line_1 ?? '' }}
                                                        <br />
                                                        {{ $user_full_details->current_address_line_2 ?? '' }}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div class="text">{{ $user_full_details->gender ?? '' }}</div>
                                                </li>
                                                {{-- <li>
                                            <div class="title">Gender:</div>
                                            <div class="text">{{ $user_full_details->gender ?? '' }}</div>
                                        </li> --}}
                                                <li>
                                                    <div class="title">Reports to:</div>
                                                    <div class="text d-flex align-items-center">
                                                        <div class="avatar-box">
                                                            <div
                                                                class="avatar avatar-xs d-flex align-items-center page-header-user-dropdown me-2">
                                                                @if (!empty($reportingManager) &&
                                                                    $reportingManager->avatar &&
                                                                    file_exists(public_path('images/' . $reportingManager->avatar)))
                                                                    <img class="w-100 h-100 soc-det-img "
                                                                        src="{{ URL::asset('images/' . $reportingManager->avatar) }}"
                                                                        alt="Header Avatar">
                                                                @else
                                                                    <span class="rounded-circle user-profile  ml-2 "
                                                                        id="">
                                                                        <i id="manager_shortname" class="align-middle "></i>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if (!empty($reportingManager) && $reportingManager->name)
                                                            <a href="{{ $reportingManager->id }}">
                                                                {{ $reportingManager->name }}
                                                            </a>
                                                        @else
                                                            ---
                                                        @endif
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <form action="{{ route('updatePersonalInformation', $user->id) }}"
                                                Method="POST" enctype="multipart/form-data">
                                                <h6 class="">Personal Informations
                                                    <span class="personal-edit"><a href="#" class="edit-icon"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#personal_info_modal"><i
                                                                class="ri-pencil-fill"></i></a></span>
                                                </h6>
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Passport No.</div>
                                                        <div class="text">
                                                            {{ $user_full_details->passport_number ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Passport Exp Date.</div>
                                                        <div class="text">{{ $user_full_details->passport_date ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Tel</div>
                                                        <div class="text">{{ $user_full_details->mobile_number ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Nationality</div>
                                                        <div class="text">{{ $user_full_details->nationality ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Religion</div>
                                                        <div class="text">{{ $user_full_details->religion ?? '' }}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Marital status</div>
                                                        <div class="text text-capitalize">
                                                            {{ $user_full_details->marital_status ?? '' }}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Spouse Name</div>
                                                        <div class="text">{{ $user_full_details->spouse_name ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">No. of children</div>
                                                        <div class="text">{{ $user_full_details->no_of_children ?? '' }}
                                                        </div>
                                                    </li>
                                                </ul>
                                        </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h6 class="">Experience Details
                                                <span class="personal-edit">
                                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                                        data-bs-target="#experience_info">
                                                        <i class="ri-pencil-fill"></i>
                                                    </a>
                                                </span>
                                            </h6>
                                            <div class="table-responsive" id="experience-detail-table">
                                                <table class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Organization</th>
                                                            <th>Designation</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($exp)
                                                            @foreach ($exp as $k => $info)
                                                                <tr>
                                                                    <td>{{ $info['company_name'] }}</td>
                                                                    <td>{{ $info['job_position'] }}</td>
                                                                    <td>{{ $info['period_from'] }}</td>
                                                                    <td>{{ $info['period_to'] }}</td>
                                                                    {{-- <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a aria-expanded="false" data-bs-toggle="dropdown"
                                                            class="action-icon dropdown-toggle" href="#"><i
                                                                class="ri-more-2-fill material-icons"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="#" class="dropdown-item"><i
                                                                    class=" ri-pencil-fill m-r-5"></i>
                                                                Edit</a>
                                                            <a href="#" class="dropdown-item"><i
                                                                    class=" ri-delete-bin-line"></i>
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </td> --}}
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12  d-flex">
                                    <div class="card top-line w-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="fw-bold mb-0 ">Family Informations
                                                </h6>
                                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                                    data-bs-target="#family_info_modal">
                                                    <i class=" ri-pencil-fill"></i>
                                                </a>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Relationship</th>
                                                            <th>Date of Birth</th>
                                                            <th>Phone</th>
                                                            {{-- <th></th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($familydetails))
                                                            @foreach ($familydetails as $singledetail)
                                                                <tr>
                                                                    <td>{{ $singledetail->name }}</td>
                                                                    <td>{{ $singledetail->relationship }}</td>
                                                                    <td>{{ $singledetail->dob }}</td>
                                                                    <td>{{ $singledetail->phone_number }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title fw-bold">Leave Details
                                    <span class="personal-edit"><a href="#" class="edit-icon" data-bs-toggle="modal"
                                            data-bs-target="#leave_info"><i class="ri-pencil-fill"></i></a></span>
                                </h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Allocated Paid Leaves</div>
                                        <!-- <div class="text">{{$details->passport}}</div> -->
                                        <div class="text">21</div>
                                    </li>
                                    <li>
                                        <div class="title"> Paid Leave Balance</div>
                                        <!-- <div class="text">{{$details->passport}}</div> -->
                                        <div class="text">19</div>
                                    </li>
                                    <li>
                                        <div class="title">Allocated Restricted Holidays</div>
                                        <div class="text">2</div>
                                    </li>
                                    <li>
                                        <div class="title">Allocated Restricted Balance</div>
                                        <div class="text">4</div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div> --}}

                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h6 class="">Bank information
                                                <span class="personal-edit"><a href="#" class="edit-icon"
                                                        data-bs-toggle="modal" data-bs-target="#Bank_info"><i
                                                            class="ri-pencil-fill"></i></a></span>

                                            </h6>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Bank name</div>
                                                    <?php $bank_name = App\Models\Bank::where('id', $user_full_details->bank_id)->value('bank_name'); ?>
                                                    <div class="text">{{ $bank_name ?? '' }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">Bank account No.</div>
                                                    <div class="text">
                                                        {{ $user_full_details->bank_account_number ?? '' }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">IFSC Code</div>
                                                    <div class="text">{{ $user_full_details->bank_ifsc_code ?? '' }}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">PAN No</div>
                                                    <div class="text">{{ $user_full_details->pan_number ?? '' }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 col-lg-6 col-sm-12 d-flex  ">
                                    <div class="card profile-box flex-fill mb-0 ">
                                        <div class="card-body">
                                            <h6 class="">Emergency Contact <a href="#" class="edit-icon"
                                                    data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i
                                                        class=" ri-pencil-fill"></i></a></h6>

                                            @if (!empty($emergencyContactDetails))
                                                <ul class="personal-info">


                                                    <li>
                                                        <div class="title">Name</div>
                                                        <div class="text">{{ $emergencyContactDetails->name ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Relationship</div>
                                                        <div class="text">
                                                            {{ $emergencyContactDetails->relationship ?? '' }}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Phone</div>
                                                        <div class="text">
                                                            {{ $emergencyContactDetails->phone_number_1 ?? '' }}
                                                        </div>
                                                    </li>
                                                    {{-- <li>
                                                <div class="title">Phone - 2</div>
                                                <div class="text">{{ $emergencyContactDetails->phone_number_2 ?? '' }}
                                                </div>
                                            </li> --}}
                                                </ul>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane  fade " id="info_document" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <form action="{{ route('updatePersonalInformation', $user->id) }}" Method="POST"
                            enctype="multipart/form-data">
                            <h6 class="">Document Of Employee

                            </h6>

                            <div class="table responsive">
                                <table class="table">
                                    <thead class="bg-primary text-white">
                                        <th>Document Type</th>
                                        <th>Number/ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @if( !empty($documents_filenames[0]->aadhar_card_file))
                                        <tr>

                                            <td>Aadhar Card Front</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->aadhar_card_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->aadhar_card_file) }}">View Documents</a>
                                                @else
                                                    <a class="view-file text-info"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->aadhar_card_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->aadhar_card_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->aadhar_card_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->aadhar_card_file == -1)
                                                    <button class="btn btn-border-primary"
                                                        onclick="approveOrRejectDocument('aadhar_card_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('aadhar_card_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('aadhar_card_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('aadhar_card_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->aadhar_card_backend_file))

                                        <tr>
                                            <td>Aadhar Card Back</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->aadhar_card_backend_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->aadhar_card_backend_file) }}">View Documents</a>
                                                @else
                                                <a class="view-file"
                                                    data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->aadhar_card_backend_file) }}"
                                                    style="cursor:pointer">
                                                    {{ 'View Documents' }}
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->aadhar_card_backend_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->aadhar_card_backend_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->aadhar_card_backend_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('aadhar_card_backend_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('aadhar_card_backend_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('aadhar_card_backend_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('aadhar_card_backend_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->pan_card_file))

                                        <tr>
                                            <td>Pan Card</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->pan_card_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->pan_card_file) }}">View Documents</a>
                                                @else
                                                    <div class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->pan_card_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->pan_card_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->pan_card_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->pan_card_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('pan_card_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('pan_card_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('pan_card_file', 1)">
                                                        Approve</button>
                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('pan_card_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->passport_file))

                                        <tr>
                                            <td>Passport</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->passport_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->passport_file) }}">View Documents</a>
                                                @else
                                                    <a class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->passport_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->passport_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->passport_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->passport_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('passport_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('passport_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('passport_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('passport_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>

                                        </tr>

                                        @endif
                                        @if( !empty($documents_filenames[0]->voters_id_file))

                                        <tr>
                                            <td>Voters ID</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->voters_id_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->voters_id_file) }}">View Documents</a>
                                                @else
                                                    <div class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->voters_id_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->voters_id_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->voters_id_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->voters_id_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('voters_id_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('voters_id_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('voters_id_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('voters_id_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>

                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->dl_file))

                                        <tr>
                                            <td>Driving License</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->dl_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->dl_file) }}">View Documents</a>
                                                @else
                                                    <div class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->dl_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->dl_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->dl_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->dl_file == -1)
                                                    <button class="btn btn-success" onclick="approveOrRejectDocument('dl_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger" onclick="approveOrRejectDocument('dl_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"onclick="approveOrRejectDocument('dl_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger" onclick="approveOrRejectDocument('dl_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>

                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->education_certificate_file))
                                        <tr>
                                            <td>Educational Certificate</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->education_certificate_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->education_certificate_file) }}">View Documents</a>
                                                @else
                                                    <div class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->education_certificate_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->education_certificate_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->education_certificate_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($docs_reviewed) && $docs_reviewed->education_certificate_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('education_certificate_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('education_certificate_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('education_certificate_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('education_certificate_file', 0)">
                                                        Reject</button>
                                                @endif
                                            </td>

                                        </tr>
                                        @endif
                                        @if( !empty($documents_filenames[0]->reliving_letter_file))
                                        <tr>
                                            <td>Relieving Letter</td>
                                            <td>
                                                @if (Str::contains($documents_filenames[0]->reliving_letter_file, '.pdf'))
                                                    <a target="_blank" href="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->reliving_letter_file) }}">View Documents</a>
                                                @else
                                                    <div class="view-file"
                                                        data-src="{{ URL::asset('employee_documents/' . $user_code . '/' . $documents_filenames[0]->reliving_letter_file) }}"
                                                        style="cursor:pointer">
                                                        {{ 'View Documents' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs_reviewed != null)
                                                    @if ($docs_reviewed->reliving_letter_file == 1)
                                                        {{ 'Approved' }}
                                                    @elseif($docs_reviewed->reliving_letter_file == 0)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ 'Not Reviewed' }}
                                                    @endif
                                                @else
                                                    {{ 'Not Reviewed' }}
                                                @endif
                                            </td>
                                            <td>

                                                @if (isset($docs_reviewed) && $docs_reviewed->reliving_letter_file == -1)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('reliving_letter_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('reliving_letter_file', 0)">
                                                        Reject</button>
                                                @endif

                                                @if ($docs_reviewed == null)
                                                    <button class="btn btn-success"
                                                        onclick="approveOrRejectDocument('reliving_letter_file', 1)">
                                                        Approve</button>

                                                    <button class="btn btn-danger"
                                                        onclick="approveOrRejectDocument('reliving_letter_file', 0)">
                                                        Reject</button>
                                                @endif

                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="bank_statutory">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fw-bold"> Basic Salary Information</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Salary basis <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select form-control select2-hidden-accessible"
                                            data-select2-id="select2-data-1-ecvr" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-3-iget">Select salary basis
                                                type
                                            </option>
                                            <option>Hourly</option>
                                            <option>Daily</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-2-xiji"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-hgdl-container"
                                                    aria-controls="select2-hgdl-container"><span
                                                        class="select2-selection__rendered" id="select2-hgdl-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select salary basis type">Select
                                                        salary basis
                                                        type</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Salary amount <small class="text-muted">per
                                                month</small></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control"
                                                placeholder="Type your salary amount" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Payment type</label>
                                        <select class="form-select form-control select2-hidden-accessible"
                                            data-select2-id="select2-data-4-dj2y" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-6-iwpp">Select payment type
                                            </option>
                                            <option>Bank transfer</option>
                                            <option>Check</option>
                                            <option>Cash</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-5-s3wp"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-37e7-container"
                                                    aria-controls="select2-37e7-container"><span
                                                        class="select2-selection__rendered" id="select2-37e7-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select payment type">Select
                                                        payment type</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title fw-bold"> PF Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">PF contribution</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-7-w8sh" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-9-r0ka">Select PF contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-8-lbfb"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-k79s-container"
                                                    aria-controls="select2-k79s-container"><span
                                                        class="select2-selection__rendered" id="select2-k79s-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select PF contribution">Select
                                                        PF contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">PF No. <span class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-10-v11n" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-12-3a7c">Select PF
                                                contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-11-0xtt"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-ku2h-container"
                                                    aria-controls="select2-ku2h-container"><span
                                                        class="select2-selection__rendered" id="select2-ku2h-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select PF contribution">Select
                                                        PF contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-13-sglc" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-15-o5s2">Select PF
                                                contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-14-t7xx"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-zo26-container"
                                                    aria-controls="select2-zo26-container"><span
                                                        class="select2-selection__rendered" id="select2-zo26-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select PF contribution">Select
                                                        PF contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-16-y0rb" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-18-nnwh">Select additional
                                                rate
                                            </option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-17-ouwe"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-cc48-container"
                                                    aria-controls="select2-cc48-container"><span
                                                        class="select2-selection__rendered" id="select2-cc48-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select additional rate">Select
                                                        additional rate</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-19-dbno" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-21-ajce">Select PF
                                                contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-20-rwtr"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-qvdw-container"
                                                    aria-controls="select2-qvdw-container"><span
                                                        class="select2-selection__rendered" id="select2-qvdw-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select PF contribution">Select
                                                        PF contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select ">
                                            <option data-select2-id="select2-data-24-ngjq">Select additional
                                                rate
                                            </option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title fw-bold"> ESI Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">ESI contribution</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-25-9ci2" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-27-u74r">Select ESI
                                                contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-26-tskv"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-r6du-container"
                                                    aria-controls="select2-r6du-container"><span
                                                        class="select2-selection__rendered" id="select2-r6du-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select ESI contribution">Select
                                                        ESI contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">ESI No. <span class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-28-mjdh" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-30-7ur7">Select ESI
                                                contribution
                                            </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-29-nbip"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-un38-container"
                                                    aria-controls="select2-un38-container"><span
                                                        class="select2-selection__rendered" id="select2-un38-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select ESI contribution">Select
                                                        ESI contribution</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Employee ESI rate</label>
                                        <select class="select ">
                                            <option>Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-34-23ui" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-36-9t77">Select additional
                                                rate
                                            </option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-35-uyht"
                                            style="width: 100%;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox"
                                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                    aria-disabled="false" aria-labelledby="select2-vkjw-container"
                                                    aria-controls="select2-vkjw-container"><span
                                                        class="select2-selection__rendered" id="select2-vkjw-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Select additional rate">Select
                                                        additional rate</span><span class="select2-selection__arrow"
                                                        role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-orange submit-btn" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- employee info -->

        <div id="employee_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
                <div class="modal-content top-line">
                    <div class="modal-header border-0 ">
                        <h6 class="">Employee
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updatePersonalInformation', $user->id) }}" Method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-center">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Birth Date</label>
                                                <div class="cal-icon">
                                                    @if (!empty($user_full_details->dob))
                                                        <input class="form-control datetimepicker" type="date"
                                                            max="9999-12-31" name="dob"
                                                            value="{{ date('Y-m-d', strtotime($user_full_details->dob)) }}"
                                                            readonly>
                                                    @else
                                                        <input class="form-control datetimepicker" type="date"
                                                            max="9999-12-31" name="dob" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Gender</label>

                                                <select class="form-select form-control" name="gender"
                                                    aria-label="Default select">
                                                    <option selected hidden disabled>Choose Gender</option>
                                                    @foreach ($genderArray as $item)
                                                        <option value="{{ $item }}"
                                                            @if (!empty($user_full_details->gender) && $user_full_details->gender == $item) selected @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">

                                                <label>Reports To <span class="text-danger">*</span></label>
                                                <select class="form-select form-control" name="report">
                                                    <option disabled hidden selected>Select Report</option>

                                                    @foreach ($allEmployees as $singleEmp)
                                                        <option value="{{ $singleEmp->user_code }}"
                                                            @if (!empty($reportingManager) && $reportingManager->user_code == $singleEmp->user_code) selected @endif>
                                                            {{ $singleEmp->user_code . ' (' . $singleEmp->name . ')' }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Phone Number</label>
                                        <input type=text size=20 maxlength=10 onkeypress='return isNumberKey(event)'
                                            class="form-control" name="mobile_number"
                                            value="{{ $user_full_details->mobile_number ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input type="email" name="present_email"
                                            onkeypress='return isValidEmail(email)' class="form-control"
                                            value="{{ $user->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Current Address Line - 1</label>
                                        <textarea name="current_address_line_1" id="current_address_line_1" cols="30" rows="3"
                                            class="form-control" value="{{ $user_full_details->current_address_line_1 ?? '' }}">{{ $user_full_details->current_address_line_1 ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Current Address Line - 2</label>
                                        <textarea name="current_address_line_2" id="current_address_line_2" cols="30" rows="3"
                                            class="form-control" value="{{ $user_full_details->current_address_line_2 ?? '' }}">{{ $user_full_details->current_address_line_2 ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Permanent Address Line - 1</label>
                                        <textarea name="permanent_address_line_1" id="permanent_address_line_1" cols="30" rows="3"
                                            class="form-control" value="{{ $user_full_details->permanent_address_line_1 ?? '' }}">{{ $user_full_details->permanent_address_line_1 ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Permanent Address Line - 2</label>
                                        <textarea name="permanent_address_line_2" id="permanent_address_line_2" cols="30" rows="3"
                                            class="form-control" value="{{ $user_full_details->permanent_address_line_2 ?? '' }}">{{ $user_full_details->permanent_address_line_2 ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- personal info -->
        <div id="personal_info" class="modal  custom-modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered " role="document">
                <div class="modal-content profile-box">
                    <div class="modal-header border-0  new-role-header d-flex align-items-center">
                        <h6 class="">Personal
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('storeProfileImage', $user->id) }}" Method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <div class="profile-img-wrap edit-img">
                                            <img id="profile_round_image_dist" class="rounded-circle header-profile-user"
                                                src="@if (!empty($user->avatar)) {{ URL::asset('images/' . $user->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                                alt="">
                                            <div class="fileupload btn">
                                                <span class="btn-text">Change</span>
                                                <input type='file' name="profilePic" class="upload" accept="image/*"
                                                    onchange="readURL(this);" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- bank informatios -->
        <div id="Bank_info" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box top-line">
                    <div class="modal-header d-flex align-items-center border-0">
                        <h6 class="">Bank Information
                        </h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateBankInfo', $user->id) }}" Method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Bank name</label>
                                        @if (!empty($bank))
                                            <select name="bank_name" id="bank_name"
                                                class="form-select form-control onboard-form" required>
                                                <option value="">Select</option>
                                                @foreach ($bank as $b)
                                                    @if (!empty($b->bank_name) && !empty($b->min_length) && !empty($b->max_length))
                                                        <option value="{{ $b->bank_name ?? '' }}"
                                                            min-data="{{ $b->min_length }}" max-data="{{ $b->max_length }}"
                                                            @if (!empty($user_full_details->bank_name) && $user_full_details->bank_name == $b->bank_name) selected @endif>
                                                            {{ $b->bank_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Bank account No</label>
                                        <div class="cal-icon">
                                            <input name="account_no" type="number" minlength="9" maxlength="18"
                                                class="form-control onboard-form"
                                                value="{{ $user_full_details->bank_account_number ?? '' }}"
                                                pattern-data="account" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>IFSC Code</label>
                                        <input name="bank_ifsc" class="form-control onboard-form"
                                            value="{{ $user_full_details->bank_ifsc_code ?? '' }}" type="text"
                                            pattern-data="ifsc" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>PAN No</label>
                                        <input name="pan_no" class="form-control onboard-form"
                                            value="{{ $user_full_details->pan_number ?? '' }}" type="text"
                                            pattern-data="pan" required>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- leave information -->
        <div id="leave_info" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box">
                    <div class="modal-header">
                        <h6 class="">Leave Information
                        </h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateLeaveInfo', $user->id) }}" Method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Allocated Paid Leaves</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Paid Leave Balance</label>
                                        <div class="cal-icon">
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Allocated Restricted Holidays</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Allocated Restricted Balance</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div id="personal_info_modal" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box top-line">
                    <div class="modal-header border-0">
                        <h6 class="">Personal
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updatePersonalInfo', $user->id) }}" Method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Passport No</label>
                                        <input type="text" class="form-control" name="passport_number"
                                            value="{{ $user_full_details->passport_number ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Passport Expiry Date</label>
                                        <div class="cal-icon">
                                            @if (!empty($user_full_details->passport_date))
                                                <input class="form-control datetimepicker" name="passport_date"
                                                    type="date" max="9999-12-31"
                                                    value="{{ date('Y-m-d', strtotime($user_full_details->passport_date)) }}">
                                            @else
                                                <input class="form-control datetimepicker" name="passport_date"
                                                    type="date" max="9999-12-31" value="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Tel</label>
                                        <input class="form-control" value="{{ $user_full_details->mobile_number ?? '' }}"
                                            name="mobile_number" minlength="10" maxlength="10" type="number"
                                            maxlength="10" minlength="10" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Nationality <span class="text-danger">*</span></label>
                                        <select placeholder="Choose nationality" name="nationality" id="nationality"
                                            class="onboard-form form-control textbox form-select  select2_form_without_search"
                                            required>
                                            <option value="" hidden selected disabled>Choose nationality</option>
                                            <option value="Indian" @if ($user_full_details->nationality == 'Indian') selected @endif>
                                                Indian</option>
                                            <option value="Other Nationality"
                                                @if ($user_full_details->nationality == 'Other Nationality') selected @endif>Other Nationality
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Religion</label>
                                        <div class="cal-icon">
                                            <input class="form-control onboard-form" pattern-data="name" name="religion"
                                                type="text" pattern-data="alpha"
                                                value="{{ $user_full_details->religion ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Marital status <span class="text-danger">*</span></label>
                                        <select class="form-select form-control text-capitalize" name="marital_status"
                                            required>
                                            <option class="" selected hidden disabled>Select Marital</option>
                                            @foreach ($maritalStatus as $item_maritalStatus)
                                                <option @if (!empty($user_full_details->marital_status) && $user_full_details->marital_status == $item_maritalStatus) selected @endif
                                                    value="{{ $item_maritalStatus }}">{{ ucfirst($item_maritalStatus) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Spouse Name</label>
                                        <input class="form-control onboard-form" type="text" name="spouse"
                                            pattern-data="alpha" value="{{ $user_full_details->spouse_name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>No. of children </label>
                                        <input class="form-control onboard-form" type="number" name="no_of_children"
                                            maxlength="2" value="{{ $user_full_details->no_of_children ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- emergency modal-->
        <div id="emergency_contact_modal" class="modal custom-modal fade show" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box top-line">
                    <div class="modal-header new-role-header d-flex align-items-center border-0">
                        <h6 class="">Emergency Contact
                        </h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateEmergencyInfo', $user->id) }}" Method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="emergency-content-wrapper">
                                <div class="card mb-3  emergency-addition-content" id="emergencyPopup_card">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="text-end col-md-12">
                                                <button
                                                    class="btn text-danger delete-btn p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                                    type="button"><i class="f-12 me-1 fa text-danger  fa-trash"
                                                        aria-hidden="true"></i>Delete
                                                    </i></button>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name"
                                                        class="form-control onboard-form" pattern-data="name"
                                                        value="{{ $emergencyContactDetails->name ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Relationship <span class="text-danger">*</span></label>
                                                    <input name="relationship" class="form-control onboard-form"
                                                        type="text" pattern-data="alpha"
                                                        value="{{ $emergencyContactDetails->relationship ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                    <input name="phone_number_1" class="form-control onboard-form"
                                                        type="number" maxlength="10" minlength="10"
                                                        value="{{ $emergencyContactDetails->phone_number_1 ?? '' }}">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Phone 2</label>
                                                <input name="phone_number_2" class="form-control onboard-form"
                                                    type="number" maxlength="10" minlength="10"
                                                    value="{{ $emergencyContactDetails->phone_number_2 ?? '' }}">
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="add-more text-end mb-2" style="cursor:pointer;">

                                <button id="addMore_emergencyCont"
                                    class="btn text-primary p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                    type="button"><i class="f-12 me-1 fa  fa-plus-circle" aria-hidden="true"></i>Add
                                    More</i></button>
                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- family modal-->

        <div id="family_info_modal" class="modal custom-modal fade show" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box">
                    <div class="modal-header new-role-header">
                        <h6 class="modal-title">Family
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateFamilyInfo', $user->id) }}" Method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            @if (!empty($familydetails) && count($familydetails) > 0)
                                @foreach ($familydetails as $singledetail)
                                    {{-- <div class="content-container"> --}}
                                    <div class="family-addition-container">
                                        <div class="card mb-3 addition-content" id="content1">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-md-12 m-0 text-end">
                                                        <button
                                                            class="btn text-danger delete-btn p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                                            type="button"><i class="f-12 me-1 fa text-danger  fa-trash"
                                                                aria-hidden="true"></i>Delete
                                                            </i></button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Name <span class="text-danger">*</span></label>
                                                            <input name="name[]" class="form-control onboard-form"
                                                                type="text" pattern-data="name" required
                                                                value="{{ $singledetail->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Relationship <span class="text-danger">*</span></label>
                                                            <input name="relationship[]" class="form-control onboard-form"
                                                                type="text" pattern-data="alpha" required
                                                                value="{{ $singledetail->relationship }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Date of birth <span class="text-danger">*</span></label>
                                                            <input name="dob[]" class="form-control onboard-form"
                                                                type="date" max="9999-12-31" required
                                                                value="{{ $singledetail->dob }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label>Phone <span class="text-danger">*</span></label>
                                                            <input name="phone_number[]"
                                                                class="form-control onboard-form" type="number"
                                                                maxlength="10" minlength="10" required
                                                                value="{{ $singledetail->phone_number }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                @endforeach

                                <div class="add-more text-end mb-2" style="cursor:pointer;">
                                    {{-- <div id="add_more" class="text-primary  cursor-pointer">
                                        <i class=" ri-add-circle-fill"></i> Add More
                                    </div> --}}
                                    <button id="add_more"
                                        class="btn text-primary p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                        type="button"><i class="f-12 me-1 fa  fa-plus-circle"
                                            aria-hidden="true"></i>Add
                                        More</i></button>
                                </div>
                            @else
                                <div class="family-addition-container">
                                    <div class="card mb-3 addition-content" id="content1">
                                        <div class="card-body">
                                            <!-- <h3 class="card-title fw-bold">Education Informations <a href="javascript:void(0);"
                                                                                    {{-- class="delete-icon"><i class="   ri-delete-bin-line"></i></a> --}}
                                                                            </h3> -->

                                            <div class="row ">
                                                <div class="col-md-12 m-0 text-end">
                                                    <button
                                                        class="btn text-danger delete-btn p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                                        type="button"><i class="f-12 me-1 fa text-danger  fa-trash"
                                                            aria-hidden="true"></i>Delete
                                                        </i></button>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Name<span class="text-danger">*</span></label>
                                                        <input name="name[]" class="form-control onboard-form"
                                                            type="text" pattern-data="name" required
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Relationship <span class="text-danger">*</span></label>
                                                        <input name="relationship[]" class="form-control onboard-form"
                                                            type="text" pattern-data="alpha" required
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Date of birth <span class="text-danger">*</span></label>
                                                        <input name="dob[]" class="form-control onboard-form"
                                                            type="date" max="9999-12-31" required value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label>Phone <span class="text-danger">*</span></label>
                                                        <input name="phone_number[]" class="form-control onboard-form"
                                                            type="number" maxlength="10" minlength="10" required
                                                            value="">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="add-more text-end mb-2" style="cursor:pointer;">
                                    {{-- <button id="add_more" class="text-primary  cursor-pointer">
                                    <i class=" ri-add-circle-fill"></i> Add More
                                </button> --}}
                                    <button id="add_more"
                                        class="btn text-primary p-0 bg-transparent outline-none border-0 f-12 plus-sign"
                                        type="button"><i class="f-12 me-1 fa  fa-plus-circle"
                                            aria-hidden="true"></i>Add
                                        More</i></button>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- education modal-->
        <div id="education_info" class="modal custom-modal fade show" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box">
                    <div class="modal-header">
                        <h6 class="">Education
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title fw-bold">Education Informations <a
                                                href="javascript:void(0);" class="delete-icon"><i
                                                    class="   ri-delete-bin-line"></i></a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Institution</label>
                                                    <input type="text" value="Oxford University"
                                                        class="form-control floating">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Subject</label>
                                                    <input type="text" value="Computer Science"
                                                        class="form-control floating">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Starting Date</label>
                                                    <div class="cal-icon">
                                                        <input type="text" value="01/06/2002"
                                                            class="form-control floating datetimepicker">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Complete Date</label>
                                                    <div class="cal-icon">
                                                        <input type="text" value="31/05/2006"
                                                            class="form-control floating datetimepicker">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Degree</label>
                                                    <input type="text" value="BE Computer Science"
                                                        class="form-control floating">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 form-focus focused">
                                                    <label class="focus-label">Grade</label>
                                                    <input type="text" value="Grade A"
                                                        class="form-control floating">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title fw-bold">Education Informations <a
                                                href="javascript:void(0);" {{-- class="delete-icon"><i class="   ri-delete-bin-line"></i></a> --}} </h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <label class="focus-label">Institution</label>
                                                            <input type="text" value="Oxford University"
                                                                class="form-control floating">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <label class="focus-label">Subject</label>
                                                            <input type="text" value="Computer Science"
                                                                class="form-control floating">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <div class="cal-icon">
                                                                <label class="focus-label">Starting Date</label>
                                                                <input type="date" max="9999-12-31"
                                                                    value="01/06/2002"
                                                                    class="form-control floating datetimepicker">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <label class="focus-label">Complete Date</label>
                                                            <div class="cal-icon">
                                                                <input type="date" max="9999-12-31"
                                                                    value="31/05/2006"
                                                                    class="form-control floating datetimepicker">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <label class="focus-label">Degree</label>
                                                            <input type="text" value="BE Computer Science"
                                                                class="form-control floating">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3 form-focus focused">
                                                            <label class="focus-label">Grade</label>
                                                            <input type="text" value="Grade A"
                                                                class="form-control floating">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-more ">
                                                    <a href="javascript:void(0);" class="text-secondary"><i
                                                            class=" ri-add-circle-fill"></i> Add
                                                        More</a>
                                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- experience modal-->

        <div id="experience_info" class="modal custom-modal fade show" role="dialog" aria-modal="true"s>
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content profile-box top-line">
                    <div class="modal-header border-0">
                        <h6 class="">Experience
                            Information</h6>
                        <button type="button" class="close  border-0 h3" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateExperienceInfo', $user->id) }}" Method="POST">
                            @csrf
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="javascript:void(0);" class="delete-icon text-end"><i
                                                class="   ri-delete-bin-line"></i></a>

                                        <div class="exp-content-container">
                                            <div class="row exp-addition-content" id="content1">
                                                <input type="hidden" name="ids[]">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 form-focus focused">
                                                        <label class="focus-label">Company Name</label>
                                                        <input type="text" name="company_name[]"
                                                            class="form-control floating" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 form-focus focused">
                                                        <label class="focus-label">Location</label>
                                                        <input type="text" name="location[]"
                                                            class="form-control floating" value="" required>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 form-focus focused">
                                                        <label class="focus-label">Job Position</label>
                                                        <input type="text" name="job_position[]"
                                                            class="form-control floating" value="" required>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 form-focus focused">
                                                        <label class="focus-label">Period From</label>
                                                        <div class="cal-icon">
                                                            <input type="date" max="9999-12-31"
                                                                name="period_from[]"
                                                                class="form-control floating datetimepicker"
                                                                value="" required>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 form-focus focused">
                                                        <div class="cal-icon">
                                                            <label class="focus-label">Period To</label>
                                                            <input type="date" max="9999-12-31" name="period_to[]"
                                                                class="form-control floating datetimepicker"
                                                                value="" required>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more text-end">
                                            <div class="text-primary f-13" id="exp-add-more">
                                                <i class=" ri-add-circle-fill"></i> Add More
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-orange submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!--end row-->
@endsection
@section('script')
    @yield('script-profile-avatar')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            @if (!empty($reportingManager))
                generateProfileShortName_VendorScript("manager_shortname", "{{ $reportingManager->name }}");
            @endif

            console.log("ready!");
        });

        $('body').on('keyup', ".onboard-form", function() {
            var inputvalues = $(this).val();
            var data = $(this).attr('name');
            if ($(this).attr('maxlength')) {
                var dtl = $(this).val().length;
                var val = parseInt($(this).attr('maxlength'));
                if (dtl > val) {
                    $(this).val($(this).val().substr(0, val));
                }
            }
            if ($(this).attr('pattern-data') != undefined && $(this).attr('pattern-data') != '' && inputvalues !=
                '') {
                var pattern = {
                    'pan': /^([A-Z]){3}P([A-Z]){1}([0-9]){4}([A-Z]){1}?$/,
                    'ifsc': /^([A-Z]){4}0([A-Z0-9]){6}?$/,
                    'aadhar': /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/,
                    'passport': /^[a-zA-Z]{2}[0-9]{7}$/,
                    'account': /^[0-9]{9,18}$/,
                    'dl': /^(([A-Z]{2}[0-9]{2})( )|([A-Z]{2}-[0-9]{2}))((19|20)[0-9][0-9])[0-9]{7}$/,
                    'gst': /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/,
                    'alp-num': /^[a-zA-Z0-9]+$/,
                    'alpha': /^[a-zA-Z]+$/,
                    'name': /^[a-zA-Z.]+$/,
                };
                var regex = $(this).attr('pattern-data');
                if (!pattern[regex].test(inputvalues)) {
                    var v = $(this).val();
                    if (regex == 'name') {
                        $(this).val(v.replace(/[_\W0-9]+/g, ''));
                    } else if (regex == 'alpha') {
                        $(this).val(v.replace(/[_\W0-9.]+/g, ''));
                    } else if (regex == 'alp-num') {
                        $(this).val(v.replace(/[_\W.]+/g, ''));
                    }
                }
            }
        });

        $('.edit-icon').click(function() {
            var modalid = $(this).attr('data-bs-target');
            $(modalid).modal('show');
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile_round_image_dist')
                        .attr('src', e.target.result);

                    $('#profile_round_image_dist1')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        $('#exp-add-more').click(function() {
            var id = $('.exp-addition-content:last').attr('id');
            var length = 1;
            if (id) {
                length = parseInt(id.replace('content', '')) + 1;
            }
            $('.exp-content-container').append('<div class="row exp-addition-content" id="content' + length +
                '"><input type="hidden" name="ids[]"><div class="col-md-6"><div class="form-group mb-3 form-focus focused"><label class="focus-label">Company Name</label><input type="text" class="form-control floating" name="company_name[]" required></div></div><div class="col-md-6"><div class="form-group mb-3 form-focus focused"><label class="focus-label">Location</label><input type="text" class="form-control floating" name="location[]" required></div></div><div class="col-md-6"><div class="form-group mb-3 form-focus focused"><label class="focus-label">Job Position</label><input type="text" class="form-control floating" name="job_position[]" required></div></div><div class="col-md-6"><div class="form-group mb-3 form-focus focused"><label class="focus-label">Period From</label><div class="cal-icon"><input type="date" max="9999-12-31" class="form-control floating datetimepicker" name="period_from[]" required></div></div></div><div class="col-md-6"><div class="form-group mb-3 form-focus focused"><div class="cal-icon"><label class="focus-label">Period To</label><input type="date" max="9999-12-31"  class="form-control floating datetimepicker" name="period_to[]" required></div></div></div></div>'
            );
        });

        $('#add_more').click(function() {
            var id = $('.addition-content:last').attr('id');
            var length = 1;
            if (id) {
                length = parseInt(id.replace('content', '')) + 1;
            }
            $('.family-addition-container').append(' <div class="card mb-2  addition-content" id="content' +
                length +
                '"><div class="card-body"> <div class="row" > <div class="col-md-12 m-0 text-end"><button class="btn text-danger delete-btn p-0 bg-transparent outline-none border-0 f-12 plus-sign" type="button"><i class="f-12 me-1 fa text-danger  fa-trash" aria-hidden="true"></i>Delete</i></button></div><div class="col-md-6"><div class="form-group mb-3"><label>Name <span class="text-danger">*</span></label><input name="name[]" class="form-control onboard-form" type="text" pattern-data="name" required></div></div><div class="col-md-6"><div class="form-group mb-3"><label>Relationship <span class="text-danger">*</span></label><input name="relationship[]" class="form-control onboard-form" type="text" pattern-data="alpha" required></div></div><div class="col-md-6"><div class="form-group mb-3"><label>Date of birth <span class="text-danger">*</span></label><input name="dob[]" class="form-control onboard-form" type="date" max="9999-12-31" required></div></div><div class="col-md-6"><div class="form-group mb-3"><label>Phone <span class="text-danger">*</span></label><input name="phone_number[]" class="form-control onboard-form" type="number" maxlength="10" minlength="10" required></div></div></div>'
            );
        });

        // emergency contact

        $('#addMore_emergencyCont').click(function() {
            var id = $('.emergency-addition-content:last').attr('id');
            var length = 1;
            if (id) {
                length = parseInt(id.replace('content', '')) + 1;
            }
            $('.emergency-content-wrapper').append(
                ' <div class="card mb-3  emergency-addition-content" id="content' +
                length +
                '"><div class="card-body"> <div class="row" > <div class="col-md-12 m-0 text-end"><button class="btn text-danger delete-btn p-0 bg-transparent outline-none border-0 f-12 plus-sign" type="button"><i class="f-12 me-1 fa text-danger  fa-trash" aria-hidden="true"></i>Delete</i></button></div><div class="col-md-6"><div class="form-group mb-3"><label>Name <span class="text-danger">*</span></label><input name="name[]" class="form-control onboard-form" type="text" pattern-data="name" required></div></div><div class="col-md-6"><div class="form-group mb-3"><label>Relationship <span class="text-danger">*</span></label><input name="relationship[]" class="form-control onboard-form" type="text" pattern-data="alpha" required></div></div><div class="col-md-6"><div class="form-group mb-3"><label>Phone<span class="text-danger">*</span></label><input name="dob[]" class="form-control onboard-form" type="text"  required></div></div></div>'
            );
        });




        // delete card funtion
        // $('.delete-btn').click(function() {
        //     var $target = $(this).parents('');
        //     $target.hide('slow', function() {
        //         $target.remove();
        //     });
        // })


        const optionMenu = $(".select-menu"),
            selectBtn = $(".select-btn"),
            options = $(".option"),
            sBtn_text = $(".sBtn-text");

        selectBtn.click(function() {
            optionMenu.classList.toggle("active")
        });

        options.each((option) => {
            option.addEventListener("click", () => {
                let selectedOption = option.querySelector(".option-text").innerText;
                sBtn_text.innerText = selectedOption;

                optionMenu.classList.remove("active");

            });
        });

        $('#bank_name').change(function() {
            var min = $('#bank_name option:selected').attr('min-data');
            var max = $('#bank_name option:selected').attr('max-data');
            $('#account_no').attr('minlength', min);
            $('#account_no').attr('maxlength', min);
        });

        $('body').on('keyup', ".onboard-form", function() {
            var inputvalues = $(this).val();
            var data = $(this).attr('name');
            if ($(this).attr('maxlength')) {
                var dtl = $(this).val().length;
                var val = parseInt($(this).attr('maxlength'));
                if (dtl > val) {
                    $(this).val($(this).val().substr(0, val));
                }
            }
            if ($(this).attr('pattern') != undefined && $(this).attr('pattern') != '' && inputvalues !=
                '') {
                var pattern = {
                    'pan': /^([A-Z]){3}P([A-Z]){1}([0-9]){4}([A-Z]){1}?$/,
                    'ifsc': /^([A-Z]){4}0([A-Z0-9]){6}?$/,
                    'aadhar': /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/,
                    'passport': /^[a-zA-Z]{2}[0-9]{7}$/,
                    'account': /^[0-9]{9,18}$/,
                    'dl': /^(([A-Z]{2}[0-9]{2})( )|([A-Z]{2}-[0-9]{2}))((19|20)[0-9][0-9])[0-9]{7}$/,
                    'gst': /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/,
                    'alp-num': /^[a-zA-Z0-9]+$/,
                    'alpha': /^[a-zA-Z]+$/,
                    'name': /^[a-zA-Z.]+$/,
                };
                var regex = $(this).attr('pattern');
                if (!pattern[regex].test(inputvalues)) {
                    $('.' + data + '_label').addClass('patternErr');
                    var v = $(this).val();
                    if (regex == 'name') {
                        $(this).val(v.replace(/[_\W0-9]+/g, ''));
                    } else if (regex == 'alpha') {
                        $(this).val(v.replace(/[_\W0-9.]+/g, ''));
                    } else if (regex == 'alp-num') {
                        $(this).val(v.replace(/[_\W.]+/g, ''));
                    }
                } else {
                    $('.' + data + '_label').removeClass('patternErr');
                }
            }
        });
    </script>
    <!-- number validation  -->
    <script type="text/javascript">
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;

        }

        function isValidEmail(email) {
            const re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        // $(".progress-bar").animate({
        // style="width: {{ $profileCompletenessValue }}%"
        // }, 2500);

        $('body').on('click', '.close-modal', function() {
            $('#notificationModal').hide();
            $('#notificationModal').addClass('fade');
        });


        $('.view-file').on('click', function(e) {
            console.log($(this).data('src'));
            var docHtmlString = "<img src=" + $(this).data('src') + " width='100%' / style='width:100%;height:400px;'>";
            $('#modalBody').html(docHtmlString);

            $('#notificationModal').show();
        })

        function approveOrRejectDocument(docName, aproveStatus) {
            $.ajax({
                url: "{{ route('vmt-store-documents-review') }}",
                type: "POST",
                data: {
                    user_code: $('#hidden_user_code').val(),
                    doc_name: docName,
                    approve_status: aproveStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert("Document reviewed successfully");
                    //window.location.href = "/";
                    location.reload();
                }
            });
        }

        function approveAllDocument() {
            //e.preventDefault();
            console.log('aprove_All');

            var doc_reviewed = {
                aadhar_card_file: 1,
                aadhar_card_backend_file: 1,
                pan_card_file: 1,
                passport_file: 1,
                voters_id_file: 1,
                dl_file: 1,
                education_certificate_file: 1,
                reliving_letter_file: 1
            }

            $.ajax({
                url: "{{ route('vmt-store-documents-review-approve-all') }}",
                type: "POST",
                data: {
                    user_code: $('#hidden_user_code').val(),
                    doc_array: doc_reviewed,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert("All Documents approved successfully");
                    //window.location.href = "/";
                    location.reload();
                }
            });
        }

    </script>
@endsection
