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
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: bo;
        }

        .sub-page {
            padding: 1cm;

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

        table {
            width: 100%;
            vertical-align: middle;
            font-family: sans-serif;
        }


        .border-less {
            border: 0px !important;
        }

        tr {
            height: 12.55pt;
        }

        td {
            width: 81.35pt
        }


        .margin-0 {
            margin: 0px;
        }


        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
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

        .p3 {
            padding: 3px;
        }

        .border_bottom-brown {
            border-bottom: 2px solid #863b28;
        }

        .border_top-brown {
            border-top: 2px solid #863b28;
        }

        .text-sky_blue {
            color: #24bdf2 !important;
        }

        .f-14 {
            font-size: 14px
        }

        .f-13 {
            font-size: 13px
        }

        .pad-top-10 {
            padding-top: 10px;
        }

        .pad-top-15 {
            padding-top: 15px;
        }

        .pad-top-20 {
            padding-top: 20px;
        }

        .pad-top-5 {
            padding-top: 5px;
        }

        .pad-bottom-25 {
            padding-bottom: 25px;
        }

        .pad-top-8 {
            padding-top: 8px;
        }

        .pad-bottom-10 {
            padding-bottom: 10px;
        }

        .pad-top-25 {
            padding-top: 25px;
        }

        .pad-0 {
            padding: 0px;
        }

        .m-0 {
            margin: 0px;
        }


        .text-white {
            color: #ffffff;
        }

        .ptb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .f-12 {
            font-size: 12px;
        }

        tr:first-child th:last-child,
        tr:first-child th:first-child,
        tr:first-child th:first-child,
        tr:first-child th:last-child,
        tr:last-child td:first-child,
        tr:last-child td:last-child {
            border-radius: 0px;
        }

        .border_tb {
            border-top: 2px solid #006bb1;
            border-bottom: 2px solid #006bb1;
        }

        .border_b {
            border-bottom: 2px solid #006bb1;
        }

        .border_b1 {
            border-bottom: 1px solid #006bb1;
        }

        .border_t2_b1 {
            border-top: 2px solid #006bb1;
            border-bottom: 1px solid #006bb1;
        }

        .txt_blue {
            color: #006bb1;
        }

        .pad-bottom-15 {
            padding-bottom: 15px;

        }
    </style>
@endsection
@section('content')

    <div class="card mt-30 mb-0">
        <div class="card-body">
            <div class="fill salary-header nav-tab-header">
                <div>
                    <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                        <li class="nav-item active ember-view mx-4" role="presentation">
                            <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                                data-bs-target="#appointment" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                Leave Policy Explanation</a>
                        </li>


                    </ul>

                </div>
            </div>

            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div id="policy_carousel" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active ">
                                <div class="main-page">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
