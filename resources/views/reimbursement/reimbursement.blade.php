@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@section('css')
@endsection
@endsection
@section('content')
<div class="reimbursement-wrapper mt-30">
    <div class="card  left-line mb-2">
        <div class="card-body  pb-1 pt-1">
            <div class="row">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">

                    <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                        <li class="nav-item text-muted " role="presentation">
                            <a class="nav-link active pb-2" data-bs-toggle="tab" href="#active_employees"
                                aria-selected="true" role="tab">
                                Reimbursement
                            </a>
                        </li>
                        <li class="nav-item text-muted ms-5" role="presentation">
                            <a class="nav-link  pb-2" data-bs-toggle="tab" href="#not_active_employees"
                                aria-selected="true" role="tab">
                                Local Conveyance
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 d-flex justify-content-end">
                    <select name="" id="" class="form-select border-primary w-50 me-3">
                        <option value="" disabled hidden selected>Choose Month</option>
                        <option value="">Jan 2023</option>
                        <option value="">Feb 2023</option>
                    </select>
                    <button class="btn btn-orange"><i class="fa fa-plus-circle me-1"></i>Add Claim</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show fade active" id="active_employees" role="tabpanel"
                    aria-labelledby="pills-profile-tab">
                    <div id="active-directory-table" class="noCustomize_gridjs"></div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
@endsection
