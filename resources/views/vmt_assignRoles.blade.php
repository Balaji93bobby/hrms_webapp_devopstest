@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <style>
        .card-border-blue {
            border-top: 7px solid #002F56!important;
        }
    </style>
@endsection
@section('content')


    <div class="row">
        <div class="col-xl-8">
            <div class="card card-border-blue">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create Role</h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" id='role-form' action="/vmt-assign-roles">

                            @csrf
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Enter Role Name</label>
                                <div class="col-md-10">
                                    <input type="text"  name="role_name" id="role_name" class=""  />
                                </div>
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


            <div class="card card-border-blue">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Assign Roles to User</h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" id='role-form' action="/vmt-assign-roles">

                            @csrf
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Select User</label>
                                <div class="col-md-10">
                                    <select class="form-select select2_form_without_search" name="user_id" id="user_id" required>
                                        <option>Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Select Role</label>
                                <div class="col-md-10">
                                    <select class="form-select" name="role_id" required>
                                        <option>Select</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
            <div class="card card-border-blue">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Assign Permissions to Roles</h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" id='role-form' action="/vmt-assign-roles">

                            @csrf
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Select Permissions</label>
                                <div class="col-md-10">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1"> Permission 1</label><br>
                                    <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
                                    <label for="vehicle2">  Permission 2</label><br>
                                    <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
                                    <label for="vehicle3">  Permission 3</label><br>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Select Roles</label>
                                <div class="col-md-10">
                                    <select class="form-select" name="role_id" required>
                                        <option>Select</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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

            <div class="card card-border-blue">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">View Users by Roles</h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" id='role-form' action="/vmt-assign-roles">

                            @csrf
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Select Role</label>
                                <div class="col-md-10">
                                    <select class="form-select" name="role_id" required>
                                        <option>Select</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Users</label>
                                <div class="col-md-10">
                                    <h4> View all users based on selected roles </h4>
                                </div>
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
<div style="z-index: 11">
    <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true" >
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
@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <script type="text/javascript">

$(document).ready(function() {

        $('#user_id').select2({
                width: '100%',
                placeholder: "Select User",
        });


        $('#role-form').on('submit', function(e){
            e.preventDefault();
            var roleUri = $('#role-form').attr('action');
            console.log(roleUri);

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
                  //alert(data); // show response from the php script.
                }
            })
            //console.log($('#role-form').serialize());
        });
    });
    </script>
@endsection
