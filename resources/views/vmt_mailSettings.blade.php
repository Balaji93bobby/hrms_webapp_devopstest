@extends('layouts.master')

@section('css')
    <link href="{{ ('assets/css/table.css')}}" rel="stylesheet">
@endsection
@section('content')
    
<div class="dashboard ">
            <div class="contents d-flex row justify-content-between align-items-center">
             <h4>Reminder Mail</h4>
                </div>
            

            <table class="table align-middle mb-0  responsive" id="table">

                <thead class="thead" id="tHead">
                    <tr>
                        <th scope="col">Events</th>
                        <th scope="col">Days</th>
                        <th scope="col">Mail To</th>
                        <th scope="col">Cc Mail</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody class="tbody" id="tbody">
                    <tr>
                        <td>Employee Entry Pendings</td>
                        <td>1</td>
                        <td>Approval Pending</td>
                        <td>Far below expectation</td>
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>

                    </tr>
                    <tr>
                        <td>Approval Pending</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>

                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Meets Expectation</td>

                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>D</td>
                        <td>Above Expectation</td>

                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>A</td>
                        <td>Far Above Expectation</td>

                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>


                    </tr>
                </tbody>

            </table>
        </div>

@endsection