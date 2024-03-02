@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
@endsection


@section('content')
    <div class="tw-card mt-30">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-xl primary-blue font-semibold"> Policy Settings</h6>
            <div class="flex items-center justify-between">
                <button type="button"
                    class="text-white bg-orange-600  font-medium rounded-lg text-sm px-3.5 py-2.5 mr-2 mb-2 "><i
                        class="fa fa-plus-circle mr-1 5"></i>Add New</button>
            </div>
        </div>

        <div class="relative overflow-inherit shadow-md sm:rounded-lg">
            <table class="w-full  text-sm  text-gray-500 ">
                <thead class=" font-semibold text-lg uppercase bg-primary     text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Leave Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Annula(Days)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Accural
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Restricted Days
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Year End
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b  hover:bg-gray-50  ">
                        <td class="" colspan="12">
                            <table class="w-full  text-sm  text-gray-500 ">
                                <tr class="bg-white   hover:bg-gray-50  ">

                                    <td class="px-3 py-2.5" colspan="2">
                                        Casual Leave
                                    </td>
                                    <td class="px-3 py-2.5" colspan="2">
                                        12
                                    </td>
                                    <td class="px-3 py-2.5" colspan="2">
                                        Monthly
                                    </td>
                                    <td class="px-3 py-2.5" colspan="2">
                                        04
                                    </td>
                                    <td class="px-3 py-2.5" colspan="2">
                                        Lapsed
                                    </td>
                                    <td class="px-3 py-2.5" colspan="2">
                                        <div class="dropdown investment_dropDown">
                                            <button class="btn  bg-transparent outline-none border-0 dropdown-toggle"
                                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu border-0 py-2.5 shadow-md"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-gray-500" href="#"><i
                                                        class="fa fa-cog text-gray-400  me-2" aria-hidden="true"></i>
                                                    Configure</a>
                                                <a class="dropdown-item mt-2 text-gray-500" href="#"><i
                                                        class="fa fa-trash text-danger me-2" aria-hidden="true"></i>
                                                    Delete</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <div class="w-full bg-pink-100 rounded-lg px-3 py-2">
                                            <span class="text-orange-400">Note :</span>
                                        </div>

                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>

    </div>
@endsection
