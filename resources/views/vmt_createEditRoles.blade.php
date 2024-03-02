@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection


@section('content')




    <div class="row">
        <div class="col-xl-8">
            <div class="card">

                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Please Fill Form</h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" action="/vmt-roles" id="role-form">
                            @csrf
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Role Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="" id="example-text-input" placeholder="roles" name="name" required>
                                </div>
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="mb-1  row"><hr/></div>
                    <div>
                        <form method="POST" action="/vmt-delete-roles" id="delete-roles">
                            @csrf
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Delete Roles</label>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Select Role</label>
                                <div class="col-md-9">
                                   <select class="form-select" name="roles" required id="delete-select">
                                        <option>Select</option>
                                        @foreach($roles as $pRole)
                                            <option value="{{$pRole->id}}">{{$pRole->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>




                            <div class="row mt-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mb-1 mt-1 row"><hr/></div>
                    <div>
                        <form method="POST" action="/vmt-permissions" id="permission-form">
                            @csrf
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Permissions</label>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Select Role</label>
                                <div class="col-md-9">
                                   <select class="form-select" name="roles" required id="permission-select">
                                        <option>Select</option>
                                        @foreach($roles as $pRole)
                                            <option value="{{$pRole->id}}">{{$pRole->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 mt-1 row" style="align-items: baseline;">
                                <label for="example-text-input" class="col-md-3 col-form-label">Page Level</label>

                                <div class="col-lg-9 col-md-9">
                                    <div>
                                        <div class="form-check ">
                                            <input class="form-check-input" type="checkbox" id="formCheck1"  name="page_level[]"  value="Performance_Appraisal">
                                            <label class="form-check-label" for="formCheck1">
                                                Performance Appraisal
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck2"  name="page_level[]"  value="Self_Appraisal">
                                            <label class="form-check-label" for="formCheck2">
                                                Self Appraisal
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck3" name="page_level[]"   value="Team">
                                            <label class="form-check-label" for="formCheck3">
                                                Team
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck4" name="page_level[]"  value="ORG">
                                            <label class="form-check-label" for="formCheck4">
                                                ORG
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck5" name="page_level[]"  value="360_Degree_Review">
                                            <label class="form-check-label" for="formCheck5">
                                                360 Degree Review
                                            </label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div>


                            <div class="mb-3 mt-1 row" style="align-items: baseline;">
                                <label for="example-text-input" class="col-md-3 col-form-label">Section Level</label>
                                <div class="col-lg-9 col-md-9">
                                    <div>
                                        <div class="form-check ">
                                            <input class="form-check-input" type="checkbox" id="formCheck11" name="section_level[]" value="L1_Review">
                                            <label class="form-check-label" for="formCheck11">
                                                Can see L1 manager review
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck12" name="section_level[]" value="L2_Review">
                                            <label class="form-check-label" for="formCheck12">
                                                Can see L2 manager review
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="formCheck13" name="section_level[]" value="Final_Review">
                                            <label class="form-check-label" for="formCheck13">
                                                Can see Final review
                                            </label>
                                        </div>

                                    </div>
                                </div><!--end col-->
                            </div>
                            <div class="row mt-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <!-- Display Toast Notification Bordered With Icon Toast -->
    <div style="z-index: 11">
        <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true">
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

<!-- Modal To Confirm Delete -->
<!-- Default Modals -->

<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <h5 class="fs-15">
                    Are you sure ?
                </h5>
                <p class="text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmDelete()">Delete</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- dashboard init -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // get updated roles list
        function getRoleList(){
             $.ajax({
                type: "GET",
                url: '/vmt-role-list', // serializes the form's elements.
                success: function(data)
                {
                    //console.log(data); // show response from the php script.
                    $('#permission-form')[0].reset();
                    $('#permission-select')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option >Select</option>')
                        .val('');

                    $('#delete-select')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option >Select</option>')
                        .val('');

                    for (var i = data.length - 1; i >= 0; i--) {
                      //console.log(data[i]);
                        var optionText = data[i].name;
                        var optionValue = data[i].id;

                        $('#permission-select').append(new Option(optionText, optionValue));
                        $('#delete-select').append(new Option(optionText, optionValue));
                    }

                    // permission-select
                    // delete-select


                }
            })
        }

        // select roles to assign permission
        $('#permission-select').on('change', function(){
            getPermissions($(this).val())
        });

        // get default permission for selected roles.
        function getPermissions(roleId){
             $.ajax({
                type: "GET",
                url: '/vmt-role-permissions/'+roleId, // serializes the form's elements.
                success: function(data)
                {
                    console.log(data);

                    if(data.length == 0){
                        console.log('nodata')
                        $('input[type=checkbox]').each(function () {
                            //console.log($(this).val());

                                $(this).prop("checked", false);
                            //$(this).removeAttribute("checked");

                        });
                        return false;
                    }else{
                        $('input[type=checkbox]').each(function () {
                            //console.log($(this).val());
                            var dValue =  $(this).val();
                            console.log($.inArray(dValue, data));
                            if($.inArray(dValue, data) != -1 ) {
                                $(this).prop("checked", true);
                                console.log("is in array" + dValue  );
                            } else {
                                //$("#captureAudio").prop('checked', false);
                                $(this).removeAttr("checked");
                                console.log("is NOT in array"+ dValue);
                            }
                            //var sThisVal = (this.checked ? $(this).val() : "");
                        });
                    }

                }
            })
        }

        // Save Permissions
        $('#permission-form').on('submit', function(e){
            e.preventDefault();
            var roleUri = $('#permission-form').attr('action');
            $.ajax({
                type: "POST",
                url: roleUri,
                data: $('#permission-form').serialize(), // serializes the form's elements.
                success: function(data)
                {
                  $('#alert-msg').html(data);
                  var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                  //alert(data); // show response from the php script.
                }
            })
        });

        // show alert box to cofirm delete.
        $('#delete-roles').on('submit', function(e){
            e.preventDefault();
            $("#myModal").modal("show");
        });

        // deleting role after confirmation
        function confirmDelete(e){
            //e.preventDefault();
            var roleUri = $('#delete-roles').attr('action');
            $.ajax({
                type: "POST",
                url: roleUri,
                data: $('#delete-roles').serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('#alert-msg').html(data);
                    var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    $("#myModal").modal("hide");
                    toast.show();
                    getRoleList();
                }
            })
        }

        // Save new roles
        $('#role-form').on('submit', function(e){
            e.preventDefault();
            var roleUri = $('#role-form').attr('action');
            $.ajax({
                type: "POST",
                url: roleUri,
                data: $('#role-form').serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('#alert-msg').html(data);
                    var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                    getRoleList();
                }
            })
        });
    </script>
@endsection
