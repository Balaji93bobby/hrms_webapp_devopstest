@extends('layouts.master')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/css/jquery.orgchart.min.css" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/employee_hirarchy.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/app.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .orgchart .dept-level .content {
            height: 0;
            border: none !important;
        }

        .orgchart .dept-level .title .symbol {
            display: none;
        }





        /*  Logo node style */
        .orgchart .logo-level .title {
            /* display: none;*/
            height: auto;
            display: inline-flex;
            margin: 0px;
            text-align: center;
            justify-content: center;
        }

        .orgchart .logo-level .title span {

            font-size: 20px;
        }

        .orgchart .logo-level .content {
            display: none;
        }

        .logo-level figure {
            margin: 0;
        }

        .tree-avatar .rounded-circle.user-profile {
            background: #003156;
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    {{-- @component('components.organization_breadcrumb')
@slot('li_1') @endslot
@endcomponent --}}
    <div class="hierarchy-wrapper">
        <div id="chart-container" class="">
        </div>
        <div class="form-check  department-wise">
            <input type="checkbox" name="department" class="form-check-input" id="department-wise">
            <label class="form-check-label fw-bold f-15" for="flexCheckDefault">
                Department
            </label>
        </div>

    </div>
@endsection


@section('script')
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="module" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js">
    import html2canvas from 'html2canvas';
</script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/js/jquery.orgchart.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var mydata = {
                "name": "Lao Lao",
                "title": "general manager",
                "children": [{
                        "name": "Bo Miao",
                        "title": "department manager"
                    },
                    {
                        "name": "Su Miao",
                        "title": "department manager",
                        "children": [{
                                "name": "Tie Hua",
                                "title": "senior engineer"
                            },
                            {
                                "name": "Hei Hei",
                                "title": "senior engineer",
                                "children": [{
                                        "name": "Pang Pang",
                                        "title": "engineer"
                                    },
                                    {
                                        "name": "Xiang Xiang",
                                        "title": "UE engineer"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        "name": "Yu Jie",
                        "title": "department manager"
                    },
                    {
                        "name": "Yu Li",
                        "title": "department manager"
                    },
                    {
                        "name": "Hong Miao",
                        "title": "department manager"
                    },
                    {
                        "name": "Yu Wei",
                        "title": "department manager"
                    },
                    {
                        "name": "Chun Miao",
                        "title": "department manager"
                    },
                    {
                        "name": "Yu Tie",
                        "title": "department manager"
                    }
                ]

            };


            var ajaxURLs = {

                'children': function(nodeData) {
                    if (nodeData.user_code == "LogoNode") {
                        var url =
                            '{{ route('getTwoLevelOrgTree', ['user_code' => Auth::user()->user_code]) }}';
                    } else {
                        var url = "{{ route('getChildrenForUser', '') }}" + "/" + nodeData.user_code;
                    }

                    if ($('input[name="department"]:checked').val()) {
                        return url + '?department=true';
                    }
                    return url;
                },
                'parent': '/orgchart/parent/',
                'siblings': function(nodeData) {
                    console.log("siblings Node URL " + nodeData.avatar);
                    // getSiblingsForUser
                    //return "{{ route('getSiblingsForUser', '') }}"+"/"+nodeData.user_code;
                    return '/orgchart/siblings/' + nodeData.user_code;
                },
                'families': function(nodeData) {
                    console.log("families Node URL " + nodeData.user_code);
                    return '/orgchart/families/' + nodeData.user_code;
                }
            };


            var ocOption = {
                'data': '{{ route('getLogoLevelOrgTree') }}',
                //'{{ route('getTwoLevelOrgTree', ['user_code' => Auth::user()->user_code]) }}', LogoNode
                'ajaxURL': ajaxURLs,
                'pan': true,


                'nodeContent': 'designation',
                'exportButton': true,
                'parentNodeSymbol': '',
                'exportFilename': 'OrgChartImage',
                'exportFileextension': 'png',
                'nodeTemplate': function(data) {
                    var nodeHtml = '';


                   // data.user_code = ' ('+ data.user_code +') ';
                    let label_user_code = data.user_code ? ' ( '+data.user_code+' )' : '';

                    if (data.image_exist) {
                        if (data.className != "logo-level")
                            nodeHtml = '<div class="title">' + '<span>' + data.name +' ( '+data.user_code+' )' +' </span>' + '</div>';

                        var imageHtml = '<img class="user-avatar" src="' + data.image + '" />';

                    } else {
                        if (data.className == "logo-level") {
                            var imageHtml = '';
                            nodeHtml = '<div class="title">' + '<span>' + data.name + '</span>' + '</div>';

                        } else {
                            nodeHtml = '<div class="title">' + '<span>' + data.name + label_user_code +' </span>' + '</div>';

                            var imageHtml =
                                '<span class="rounded-circle user-profile  ml-2 " id=""><i id="topbar_username" class="align-middle ">' +
                                data.name.split(" ").join("").substring(0, 2).toUpperCase() + '</i></span>';
                        }

                    }



                    if (data.className != 'dept-level') {
                        nodeHtml = nodeHtml + '<div class="tree-avatar">' + imageHtml + '</div>';

                    } else {
                        nodeHtml = nodeHtml + '<div class="content">' + '<span></span>' + '</div>';
                    }
                    if (data.designation) {
                        nodeHtml = nodeHtml + '<div class="content">' + '<span>' + data.designation +
                            '</span>' + '</div>';
                    }
                    return nodeHtml;
                },
                'createNode': function($node, data) {

                    if (data.className == "logo-level") {
                        /*var photo =  '<figure><img class="empPhoto" src="'+data.image+'" ></figure>';
                        $node.append(photo);*/
                    }

                    return $node;
                }
            };


            var orgContainer = $('#chart-container').orgchart(ocOption);

            // refresh organisation chart on click department checkbox
            $('input[name="department"]').on('click', function(e) {

                if ($('input[name="department"]:checked').val()) {
                    ocOption.data =
                        '{{ route('getLogoLevelOrgTree', ['user_code' => Auth::user()->user_code]) }}?department=true';
                } else {
                    ocOption.data =
                        '{{ route('getLogoLevelOrgTree', ['user_code' => Auth::user()->user_code]) }}';
                }
                orgContainer.init(ocOption);
            });



        });
    </script>
@endsection
