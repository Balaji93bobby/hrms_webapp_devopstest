@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <style>
        .main-page {
            width: 210mm;
            min-height: 297mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);


        }

        .payslip_table {
            border-collapse: collapse;

        }

        table.payslip_table tr p,
        table.payslip_table td p {
            font-size: 9pt;
            margin-top: 3pt;
            margin-bottom: 3pt;
            padding: 0px 5px;
        }

        .txt-left {
            text-align: left;
        }

        .txt-right {
            text-align: right;
        }

        .txt-center {
            text-align: center;
        }

        .text-strong {
            font-weight: 600;
        }

        .header-row {
            height: 50px;
        }

        td.bg-ash {
            background-color: #c1c1c1;
        }

        .header-cotent p.brand-name {
            font-weight: 600;
            color: #002f56;
            font-size: 16px;
        }

        table.payslip_table tr,
        table.payslip_table td {
            border: 2px solid #ff5a38 !important;
        }

        .gen_terms-table tr td ul li {
            padding: 10px 0px;
        }

        .gen_terms-table tr td ol li {
            padding: 2px 0px;
        }

        table.payslip_table td.bg-ash {
            background-color: #c1c1c1;
        }

        .sub-page {
            padding: 10px 30px;
            height: 297mm;
        }

        #ass_details_table {
            border: 1px solid #000;
        }

        .paratag {
            margin: 5px 0px;
            /* font-size: 15px; */
        }

        .table-one tr,
        .table-one th,
        .table-one td,
        .table-one td p {
            /* font-size: 14px; */
        }

        table tr td,
        table tr td p,
        table tbody th,
        table tbody tr td,
        table tr td ul li p {
            /* color: #7b68ee; */
            font-size: 13px;
        }

        table span {
            font-weight: bold;
        }

        .core {
            margin: 7px;
        }

        .core li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cont-list {
            list-style: decimal;
        }

        .cont-list p {
            /* font-size: 15px; */
        }




        .assign-table {
            width: 100%;
        }

        #ass_details_table tr,
        #ass_details_table td,
        #ass_details_table th {
            font-size: 13px;
            padding: 3px 8px;

        }



        @media print {
            .main-page {
                page-break-after: always;
            }
        }


        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .main-page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        p {
            text-align: justify;

        }

        .color-link-blue {
            color: #0065c2;
        }

        ul>li::marker {
            font-weight: bolder;
            margin: 2px;
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid   mt-30">
        <div class="card  left-line mb-2 ">
            <div class="card-body pb-0 pt-1">
                <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item active ember-view me-4" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                            Appointment Letter</a>
                    </li>
                    <li class="nav-item ember-view" role="presentation ">
                        <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips"
                            type="button" role="tab" aria-controls="payslips" aria-selected="false">Pay Slip</a>
                    </li>
                </ul>

            </div>

        </div>
    </div>

    <div class="card">


        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="text-center">
                    <div class="col-md-4 mx-auto">
                        <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="">
                        <h4> <span class="text-orange">Sorry !</span> No data</h4>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="container-fluid m-2 pdf-container ">
                    {{-- <div class="main-page">
                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                        <h5>Template not found for the client : {{ sessionGetSelectedClientName() }}</h5>
                    </div>
                </div> --}}
                    <div class="text-center">
                        <div class="col-md-4 mx-auto">
                            <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="">
                            <h4> <span class="text-orange">Sorry !</span> No data</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
