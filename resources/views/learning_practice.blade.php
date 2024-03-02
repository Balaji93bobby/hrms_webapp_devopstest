@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
@endsection
@section('content')
    @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent

    <div class="show_content">


            <div class="col-sm-6 col-sm-offset-3">
              <h1>Processing an AJAX Form</h1>

              <form action="process.php" method="POST">
                <div id="name-group" class="form-group">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    placeholder="Full Name"
                  />
                </div>

                <div id="email-group" class="form-group">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="email@example.com"
                  />
                </div>

                <div id="superhero-group" class="form-group">
                  <label for="superheroAlias">Superhero Alias</label>
                  <input
                    type="text"
                    class="form-control"
                    id="superheroAlias"
                    name="superheroAlias"
                    placeholder="Ant Man, Wonder Woman, Black Panther, Superman, Black Widow"
                  />
                </div>

                <button type="submit" class="btn btn-success">
                  Submit
                </button>
              </form>


    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {


            $("#clickMe").click(function() {

                var usercode="BA015"
                $.ajax({
                    url: "{{ route('get-employee-name') }}", ///web.php
                    type: "GET",
                    status:"success",
                    data: {
                        user_code: usercode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log("AJAX response : " + data);
                        $('#showValue').text(data);
                    }
                });

            });

        })
    </script>
@endsection
