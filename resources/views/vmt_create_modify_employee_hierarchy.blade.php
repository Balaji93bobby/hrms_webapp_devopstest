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
                        <form method="POST" action="{{url('vmt-employee-hierarchy/store')}}" id="role-form">
                            @csrf
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Select Parent</label>
                                <div class="col-md-9">
                                    <select class="form-select" name="parent" required id="select-parent" selected="">
                                        <option value="-1" >Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" style="align-items: baseline;">
                                <label for="example-text-input" class="col-md-3 col-form-label">Select Childs</label>
                                <div class="col-md-9 select-child">
                                    @foreach($users as $index => $user)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{'formCheck-'.$index}}" name="childs[]"  value="{{$user->id}}">
                                        <label class="form-check-label" for="{{'formCheck-'.$index}}">
                                            {{$user->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mt-2 mb-2">
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
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        

        // select roles to assign permission 
        $('#select-parent').on('change', function(){
            var userList  = {!!json_encode($users) !!};
            var parentVal = $(this).val();
            var editMode = {{$edit}};
            if(editMode == 1){
                $.ajax({
                    url: "{{url('vmt-employee-hierarchy/')}}"+"/"+parentVal+"/childrens",
                    type: "GET",
                    success: function(data){
                       if(data.length > 1){

                       }else{
                         data = [];
                        console.log('no nodes');
                       }

                        $('.select-child').html('');
                        for (var i = userList.length - 1; i >= 0; i--) {
                            //Things[i]
                            var existNode  =  data.includes(''+userList[i].id);
                            if(userList[i].id !=  parentVal){
                                if(existNode){
                                    var inputvar =  '<div class="form-check"><input  checked="" class="form-check-input" type="checkbox"'+ 
                                                'id="formCheck-'+i+'" name="childs[]"  value="'+userList[i].id+'"><label class="form-check-label" for="formCheck-'+i+'">'+userList[i].name+'</label></div>';
                                }else{
                                    var inputvar =  '<div class="form-check"><input class="form-check-input" type="checkbox"'+ 
                                                'id="formCheck-'+i+'" name="childs[]"  value="'+userList[i].id+'"><label class="form-check-label" for="formCheck-'+i+'">'+userList[i].name+'</label></div>';
                                }
                                
                                $('.select-child').append(inputvar);
                            }
                        }
                    }
                });
            }else{
                if(parentVal != -1){
                    $('.select-child').html('');
                    for (var i = userList.length - 1; i >= 0; i--) {
                        //Things[i]
                        if(userList[i].id !=  parentVal){
                            var inputvar =  '<div class="form-check"><input class="form-check-input" type="checkbox"'+ 
                                            'id="formCheck-'+i+'" name="childs[]"  value="'+userList[i].id+'"><label class="form-check-label" for="formCheck-'+i+'">'+userList[i].name+'</label></div>';
                            $('.select-child').append(inputvar);
                        }
                    }
                }    
            }

            
        });

        $('#role-form').on('submit', function(e){
            e.preventDefault();
            var formData    =   $('#role-form').serialize();
            $.ajax({
                url: $('#role-form').attr('action'),
                type: "POST",
                data: formData,
                success: function(data){
                    $('#alert-msg').html(data);
                    var toastLiveExample3   =   document.getElementById("borderedToast2");
                    var toast               =   new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                }
            })
        });
        
    </script>
@endsection
