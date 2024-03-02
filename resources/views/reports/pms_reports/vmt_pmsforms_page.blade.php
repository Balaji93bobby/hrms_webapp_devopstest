@extends('layouts.master')

@section('content')
<div class="card mb-0 approvals_wrapper mt-30">
    <div class="card-body ">
        <div class="filter-content">
            <div class="row">
                <div class="col-sm-12 col-xxl-6 col-md-6 col-xl-6 col-lg-6">
                        <h6 class="">PMS Forms Download</h6>
                </div>
            </div>
        </div>
        <div>
            <div id="vjs_PMSFormsDownloadTable"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationModal" role="dialog" aria-hidden="true"
    style="opacity:1; display:none;background:#00000073;">
    <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true" aria-labelledby="">
        <div class="modal-content top-line">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="modalHeader">
                </h6>
                {{-- <button type="button" class="btn-close close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal" aria-label="Close">

                    </button> --}}
                <button type="button" class="close close-modal outline-none bg-transparent border-0 h3"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <p class="mb-3 text-muted f-15 text-center" id="modalNot"></p>
                    <textarea name="reject_content" id="leave_reject_content" class="form-control border-primary  mb-3"></textarea>
                    <div class="text-end">
                        <input type="hidden" id="selected_leaveId" />
                        <input type="hidden" id="selected_userId" />
                        <input type="hidden" id="selected_statusText" />

                        <button type="button" class="btn btn-primary submit_notify"
                            id="modal_leave_reject">Submit</button>
                        <button type="button" class="btn btn-border-primary close-modal"
                            id="closeModal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    @vite(['resources/js/hrms/modules/reports/pms/PMSFormsDownloadTable.js'])

@endsection
