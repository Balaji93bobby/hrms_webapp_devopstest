@extends('layouts.master')

@section('css')
    <link href="{{ ('assets/css/table.css')}}" rel="stylesheet">
@endsection
@section('content')

    
<div class="dashboard">
    <table class="table align-middle mb-0  responsive" id="table">

        <thead class="thead" id="tHead">
            <tr>
                <th scope="col">Score Start</th>
                <th scope="col">Score End</th>
                <th scope="col">Naming Convention</th>
                <th scope="col">Description</th>

                <th scope="col">Action</th>
            </tr>
        </thead>

        <tbody class="tbody" id="tbody">
            <tr>
                <td>0</td>
                <td>1</td>
                <td>E</td>
                <td>Far below expectation</td>


                <td>
                    <div class="searchBar ">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search tdTxt border rounded-pill">
                        <i class="fa fa-search tdFa"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>0</td>
                <td>1</td>
                <td>E</td>
                <td>Far below expectation</td>

                <td>
                    <div class="searchBar ">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search tdTxt border rounded-pill">
                        <i class="fa fa-search tdFa"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>0</td>
                <td>1</td>
                <td>E</td>
                <td>Meets Expectation</td>

                <td>
                    <div class="searchBar ">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search tdTxt border rounded-pill">
                        <i class="fa fa-search tdFa"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>0</td>
                <td>1</td>
                <td>D</td>
                <td>Above Expectation</td>

                <td>
                    <div class="searchBar ">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search tdTxt border rounded-pill">
                        <i class="fa fa-search tdFa"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>0</td>
                <td>1</td>
                <td>A</td>
                <td>Far Above Expectation</td>

                <td>
                    <div class="searchBar ">
                        <input type="text" placeholder="Search here...." id="search" onkeyup="searchData()"
                            class="search tdTxt border rounded-pill">
                        <i class="fa fa-search tdFa"></i>
                    </div>
                </td>


            </tr>
        </tbody>

    </table>
</div>
@endsection