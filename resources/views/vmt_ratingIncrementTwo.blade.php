@extends('layouts.master')

@section('css')
    <link href="{{ ('assets/css/table.css')}}" rel="stylesheet">
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Rating Increment Two @endslot
    @endcomponent
<div class="dashboard x-5">
            <!-- <div class="contents d-flex row justify-content-between align-items-center">
                <div class="col-6">
                    <div class="entry d-flex justify-content-start align-items-center">
                        <label for="entry">
                            Show <input type="text" id="entry" class=" w-100  entry border"> <span>Entries</span>
                        </label>
                    </div>
                </div>

                <div class=" col-6 ">
                    <div class="searchBar  d-flex justify-content-end align-items-center">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search w-50  border ">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div> -->


            <table class="table align-middle mb-0   responsive" id="table">

                <thead class="thead" id="tHead">
                    <tr>
                        <th scope="col">
                            Division
                        </th>
                        
                        <th scope="col">Increment Percentage</th>
                    </tr>
                </thead>

                <tbody class="tbody" id="tbody">
                    <tr>
                        <td>
                            Common Support
                        </td>

                        <td>
                            <input  class="border p-1 w-50" type="text" id="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Common Support
                        </td>


                        <td>

                            <input  class="border p-1 w-50 " type="text" id="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ho
                        </td>


                        <td>
                            <input  class="border p-1 w-50 " type="text" id="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Common Support
                        </td>

                        <td>
                            <input  class="border p-1 w-50 " type="text" id="">
                        </td>
                    </tr>
                    <tr>

                        <td>
                            VB-Associate
                        </td>

                        <td>
                            <input  class="border p-1 w-50 " type="text" id="">
                        </td>


                    </tr>
                </tbody>

            </table>
        </div>
    

    <script>

        //  sorting
        $('#table').DataTable();

        // for checkbox

        $('#selectAll').click(function (e) {
            $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        });

    </script>
@endsection