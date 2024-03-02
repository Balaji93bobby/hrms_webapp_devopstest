@extends('layouts.master')
{{-- @include('ui-onboarding')
 --}}
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
    {{-- @section('ui-onboarding') --}}
    <div class="container-fluid documentReview_wrapper mt-30">
        <div id="msform">
            @csrf
            <input type="hidden" name="hidden_user_code" id="hidden_user_code" value="{{ $user_code }}" />
            <div class="card shadow  profile-box card-top-border p-2">
                <div class="card-body">
                    <h6 class="mb-0 text-start">Documents Review</h6>
                    <div class="header-card-text text-end">

                        @if (str_contains(json_encode($docs_reviewed), -1) || $docs_reviewed == null)
                            <button class="btn  btn-orange" onclick="approveAllDocument()">Approve All</button>
                        @endif
                    </div>
                    <div class="form-card mb-2 mt-2">


                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>File</th>
                                    <th>Approval Status</th>
                                    <th>Action</th>
                                </tr>
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
                                            <button class="btn btn-success"
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
            </div>
            </form>
        </div>


<div id="notificationModal" class="modal custom-modal fade" role="dialog"  style="opacity:1; display:none;background:#00000073;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-lg" role="document">
        <div class="modal-content top-line">
            <div id="modalHeader" class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                <h6 class="modal-title mb-1 text-primary"  >
                 Documents Review</h6>
                <button type="button" class="close-modal outline-none bg-transparent border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"  id="modalBody">



        {{-- <div class="modal fade" id="notificationModal" role="dialog" aria-hidden="true"
            style="opacity:1; display:none;background:#00000073;">
            <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true"
                aria-labelledby="">
                <div class="modal-content">
                    <div class="modal-header py-2 bg-primary">
                        <div class="w-100 modal-header-content d-flex align-items-center py-2">
                            <h5 class="modal-title text-white" id="modalHeader">Documents
                            </h5>
                            <button type="button" class="btn-close btn-close-white close-modal" data-bs-dismiss="modal"
                                aria-label="Close">
                            </button>
                        </div>
                    </div>
                    <div class="modal-body"> --}}


                            <div class="text-end">
                                <button type="button" id="button_close" class="btn btn-border-primary close-modal"
                                    data-bs-dismiss="modal">Close</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @endsection --}}



@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>

    <!-- jQuery easing plugin -->
    <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>

    <script src="{{ URL::asset('/assets/premassets/js/sweetalert.js') }}"></script>
    <!--Progressbar JS-->
    <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>






    <script>
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
                    //location.reload();
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



        // $("#button_close").click(function(){
        //     window.location.href = "/";
        // });
    </script>
@endsection
