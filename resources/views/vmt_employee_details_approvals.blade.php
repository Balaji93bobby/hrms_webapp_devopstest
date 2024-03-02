@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/employee-directory.css') }}">

@endsection


@section('content')
{{-- @component('components.organization_breadcrumb')
@slot('li_1') @endslot
@endcomponent --}}


@vite('resources/js/hrms/modules/approvals/employeeDetails_approvals/EmpDetails_approvals.js')
<div id="EmpDetails_approvals"></div>

@endsection
@section('script')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $(function() {
            $("[data-toggle=popover]").popover({
                html: true,
                content: function() {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
            });
        });

        $('.status').click(function() {
            var status = $(this).val();
            var name = $(this).attr('name');
            var id = $('#id' + name).val(); //get employee id from hidden htmlelement
            // console.log(id);

            $.ajax({
                url: "{{route('updateUserAccountStatus')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    "status": status,
                    "id": id,
                },
                success: function(data) {
                    //window.location.reload();
                    $('#tr_' + id).remove();
                    console.log("Deleting TR " + '#tr_' + id);
                    //console.log(data);
                }
            });
        });

    });
</script>
