@extends('layouts.master')

@section('css')
    <link href="{{ ('assets/css/table.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="row">
    <div class="col-xl-12">
        <div class="contents">
            <div class=" buttons text-end mb-3 col-12">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#conventionModal">Add
                    <i class="fa fa-plus"></i></button>
            </div>

            <!-- modal has opened when click on the add button -->

            <div class="modal fade " id="conventionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content px-4 py-2">
                        <div class="modal-header">
                            <h5 class="modal-title">Rating Convention</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row contents">
                                <div class="mb-3 row">

                                    <div class="col-md-6"><label class="form-label">Score Start</label></div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="example-text-input">
                                    </div>
                                </div>
                                <div class="mb-3 row">

                                    <div class="col-md-6"><label class="form-label">Score End</label></div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="example-text-input">
                                    </div>
                                </div>
                                <div class="mb-3 row">

                                    <div class="col-md-6"><label class="form-label">Naming Convention</label></div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="example-text-input">
                                    </div>
                                </div>
                                <div class="mb-3 row">

                                    <div class="col-md-6"><label class="form-label">Description</label></div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="example-text-input">
                                    </div>
                                </div>
                                <div class="mb-3 row">

                                    <div class="col-md-6"><label class="form-label">Increment Percentage</label></div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="example-text-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table align-middle mb-0  responsive" id="table">

                <thead class="thead" id="tHead">
                    <tr>
                        <th scope="col">Score Start</th>
                        <th scope="col">Score End</th>
                        <th scope="col">Naming Convention</th>
                        <th scope="col">Description</th>
                        <th scope="col">Increment Percentage</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody" id="tbody">
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>
                        <td>0</td>
                        
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>
                        <td>0</td>
                        
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>
                        <td>0</td>
                        
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>
                        <td>0</td>
                        
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>1</td>
                        <td>E</td>
                        <td>Far below expectation</td>
                        <td>0</td>
      
                        <td><button class="border-0 bg-transparent"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection