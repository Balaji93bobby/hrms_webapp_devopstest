@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    @vite(['resources/scss/views/leave.scss'])
@endsection


@section('content')
    <div class="mt-30 ">
        <h6 class="text-xl mb-3 primary-blue font-semibold">Casual Leave</h6>
        {{-- <div class=" transform -skew-y-6 bg-purple-200">
            <div class="transform skew-y-6">
                <h2 class="text-lg">Tailind Skew Cards</h2>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci ex
                    vitae sequi nostrum quidem vero odio repudiandae expedita, quis aliquam?
                </p>
            </div>
        </div> --}}

        <div class="mb-2 tw-card py-0 top-line">
            <div class="pt-1 pb-0 card-body">
                <ul class="nav nav-pills custom-timeline nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item custom-timeline-item " role="presentation">
                        <a class="nav-link active  " id="" data-bs-toggle="pill" href=""
                            data-bs-target="#step_1" role="tab" aria-controls="pills-home" aria-selected="true">
                            Step-1
                        </a>
                    </li>
                    <li class="mx-4 nav-item custom-timeline-item" role="presentation">
                        <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#step_2" role="tab" aria-controls="pills-home" aria-selected="true">
                            Step-2</a>
                    </li>
                    <li class="nav-item custom-timeline-item " role="presentation">
                        <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#step_3" role="tab" aria-controls="pills-home" aria-selected="true">
                            Step-3</a>
                    </li>
                    <li class="mx-4 nav-item custom-timeline-item" role="presentation">
                        <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#step_4"
                            role="tab" aria-controls="pills-home" aria-selected="true">
                            Step-4</a>
                    </li>
                    <li class="nav-item custom-timeline-item" role="presentation">
                        <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#step_5"
                            role="tab" aria-controls="pills-home" aria-selected="true">
                            Step-5</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tw-card">
            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane active fade  show" id="step_1" role="tabpanel" aria-labelledby="">
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            What is the annual quota of Casual Leave days for an employee?
                        </div>

                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">MAX UPTO <input
                                            type="text"
                                            class=" w-12 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                        DAYS PER YEAR</p>
                                    <span class="text-sm text-yellow-400 "> <i
                                            class="fa fa-exclamation-circle h-4 w-4 text-red-500"></i> (Employees can avail
                                        leaves as per their available
                                        leave balance)
                                    </span>
                                </div>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">UNLIMITED</p>
                                    <span class="text-sm text-gray-900"> (Employees may take leave without requiring leave
                                        balance. This function can be used as LWP (Leave With Pay))
                                    </span>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            When the yearly leaves quota will get alloted to the employees?
                        </div>

                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">AT START OF THE YEAR (APRIL)
                                    </p>
                                    <span class="text-sm text-gray-900"> (Employees will be alloted their leaves quota right
                                        from FY start date)
                                    </span>
                                </div>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">AT END OF THE YEAR ALLOTED TO
                                        EMPLOYEES WHICH TO BE AVAILED FROM NEXT YEAR.</p>

                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you want to restrict employees from applying leave more than a certain number of days in a
                            month?
                        </div>

                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="Checkbox"
                                    name="" class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">RESTRICT MAXIMUM <input
                                            type="text"
                                            class=" w-12 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                        DAYS OF LEAVES WHICH CAN BE APPLIED BY THE EMPLOYEES PER MONTH</p>

                                </div>
                            </li>

                        </ul>

                    </div>

                </div>
                <div class="tab-pane fade  show" id="step_2" role="tabpanel" aria-labelledby="">
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Spcify Employees Entitlement Criteria Who Can Available This Leave?
                        </div>

                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500">EMPLOYEES ARE ENTITLED TO AVAIL THIS
                                    LEAVE TYPE FROM THEIR DATE OF JOINING</p>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500">EMPLOYEES ARE ENTITLED TO AVAIL THIS
                                    LEAVE TYPE FROM THEIR DATE OF CONFIRMATION</p>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base  font-semibold text-gray-500">EMPLOYEES ARE ENTITLEMENT ON THEIR
                                    CONFIRMATION DATE BUT LEAVES BALANCE TO BE CALCULATED FROM THEIR JOINING DATE</p>
                            </li>
                        </ul>


                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            For new joined employees during leave calendar year, how to pro-rate their leave alloted balance
                            for the year?
                        </div>


                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500">PRO-RATE BASED FROM JOINING DATE FOR
                                    REMAINING MONTHS [RECOMMENDED]</p>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500">PRO-RATE BASED FROM JOINING DATE FOR
                                    REMAINING DAYS</p>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500">EMPLOYEE WILL GET FULL LEAVE QUOTA OF THE
                                    YEAR REGARDLESS OF THEIR JOINING DATE</p>
                            </li>

                        </ul>
                        <div class=" px-4  mb-3 ">
                            <p class="text-sm"> For the month on which employees become eligible to avail the leave,
                                specify
                                how do
                                employees
                                will get leave quota for that starting month <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose a month</option>

                                </select>
                                and leaves to be alloted only after the
                                <input type="text"
                                    class=" w-12 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                days of month on which employee becomes eligible, for that month only, but not before these
                                days.

                            </p>
                        </div>


                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            How to restrict accrue of leave in a month or week?
                        </div>

                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center ">

                                <input type="checkbox" class=" form-check-input h-5 w-5 mr-4" />
                                <p class="text-base font-semibold text-gray-500 uppercase">
                                    Accure
                                    <input type="text"
                                        class=" w-12 mx-3 p-2 capitalize  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    Days Of Leaves Which Can Be Applied By Employees During These Days

                                </p>
                            </li>

                        </ul>


                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            How To Apply Rounding On Leave Balance Decimals?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">ROUND-OFF TO NEAREST
                                        QUARTER-DAY
                                        [RECOMMENDED] </p>
                                    <span class="text-sm text-gray-900"> Leave balance value : 1.2 will become 1.25,
                                        1.3....
                                        See More</span>
                                </div>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">ROUND-OFF TO NEAREST
                                        HALF-DAY
                                    </p>
                                    <span class="text-sm text-gray-900"> Leave balance value : 1.2 will become 1.25,
                                        1.3....
                                        See More</span>
                                </div>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">ROUND-OFF TO NEAREST
                                        FULL-DAY
                                    </p>
                                    <span class="text-sm text-gray-900"> (Leave balance value : 1.3 will become 1 and
                                        balance
                                        value : 1.5 will become 2)</span>
                                </div>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">NOT TO ROUND THE LEAVE
                                        BALANCE
                                        DECIMALS VALUE AUTOMATICALLY
                                    </p>
                                    <span class="text-sm text-gray-900"> (Employees can see their leave balance without any
                                        rounding done due to pro-rate working)</span>
                                </div>
                            </li>
                        </ul>



                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            How to display the leave opening balance in leave balance report?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">OPENING BALANCE COLUMN TO
                                    DISPLAY THE OPENING BALANCE AS AT YEAR START DATE, ACCRUED COLUMN TO DISPLAY ACCRUALS OF
                                    THE YEAR.</p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">OPENING BALANCE COLUMN TO
                                    DISPLAY THE CLOSING BALANCE OF PREVIOUS MONTH, ACCRUED COLUMN TO DISPLAY ACCRUAL OF
                                    CURRENT MONTH ONLY.</p>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade   show" id="step_3" role="tabpanel" aria-labelledby="">
                    <div class="rounded-lg bg-gray-100 shadow-lg mb-4 pb-3">
                        <ul>
                            <li class=" py-2 px-4 inline-flex justify-between w-full items-center ">
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">WHETHER THIS LEAVE TYPE IS
                                        APPLICABLE TO EMPLOYEES OF PARTICULAR RELIGION?</p>
                                    <span class="text-sm text-gray-900">(Leave balance value : 1.3 will become 1 and
                                        balance
                                        value : 1.5 will become 2)</span>
                                </div>
                                <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose a month</option>

                                </select>

                            </li>
                            <li class=" py-2 px-4 inline-flex justify-between w-full items-center ">
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">ALLOW EMPLOYEE TO APPLY FOR
                                        HALF-DAY LEAVE TYPE</p>

                                </div>
                                <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose</option>
                                    <option>Yes</option>
                                    <option>No</option>

                                </select>

                            </li>
                            <li class=" py-2 px-4 inline-flex justify-between w-full items-center ">
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">DO YOU WANT TO DISPLAY THIS
                                        LEAVE TYPE BALANCE IN LEAVE BALANCE REPORT</p>

                                </div>
                                <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose</option>
                                    <option>Yes</option>
                                    <option>No</option>

                                </select>

                            </li>

                            <li class=" py-2 px-4 inline-flex justify-between w-full items-center ">
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">DO YOU WANT TO DISPLAY THIS
                                        LEAVE TYPE BALANCE IN EMPLOYEE'S PAYSLIP</p>

                                </div>
                                <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose</option>
                                    <option>Yes</option>
                                    <option>No</option>

                                </select>

                            </li>
                            <li class=" py-2 px-4 inline-flex justify-between w-full items-center ">
                                <div>
                                    <p class="text-base uppercase font-semibold text-gray-500">RESTRICT LEAVE APPLICATION
                                        BEFORE EMPLOYEE CONFIRMATION</p>

                                </div>
                                <select id="small"
                                    class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    <option selected>Choose</option>
                                    <option>Yes</option>
                                    <option>No</option>

                                </select>

                            </li>

                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Allow employee to see and apply this leave type
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">
                                    YES, EMPLOYEES CAN SEE THIS LEAVE TYPE AND APPLY</p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">
                                    NO, EMPLOYEES CANNOT SEE THIS LEAVE TYPE. HR OR ADMIN USER CAN APPLY THIS LEAVE TYPE ON
                                    EMPLOYEE BEHALF
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input type="radio"
                                    class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">
                                    HIDE FOR ALL EMPLOYEES, HR AND ADMIN USERS. NO ONE CAN SEE THIS LEAVE TYPE IN LEAVE
                                    APPLICATION
                                </p>

                            </li>
                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you want to restrict employees not to apply for more than specified day in a single leave
                            application?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input
                                    type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">SET RESTRICTION FOR MAXIMUM
                                    <input type="text"
                                        class=" w-60 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    NUMBER CALENDAR DAYS OF LEAVES PER LEAVE APPLICATION
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input
                                    type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">SET RESTRICTION FOR MAXIMUM
                                    <input type="text"
                                        class=" w-60 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    NUMBER WORKING DAYS OF LEAVES PER LEAVE APPLICATION
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input
                                    type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">SET RESTRICTION FOR MAXIMUM
                                    <input type="text"
                                        class=" w-60 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    NUMBER CALENDAR DAYS OF LEAVES PER LEAVE APPLICATION
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input
                                    type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">SET RESTRICTION FOR MAXIMUM
                                    <input type="text"
                                        class=" w-60 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    NUMBER WORKING DAYS OF LEAVES PER LEAVE APPLICATION
                                </p>

                            </li>
                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you want to restrict employees not to apply for more than specified days in a month or week?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center "><input
                                    type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                <p class="text-base uppercase font-semibold text-gray-500">RESTRICTION MINIMUM
                                    <input type="text"
                                        class=" w-14 mx-3 p-2 capitalize  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    DAYS OF LEAVES WHICH CAN BE APPLIED BY EMPLOYEES DURING THESE RANGE
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center ">
                                <p class="text-base uppercase font-semibold text-gray-500">LEAVE REQUEST MUST BE MADE
                                    BEFORE
                                    <input type="text"
                                        class=" w-60  mx-3 p-2 capitalize  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    CALENDAR DAYS PRIOR TO THE LEAVE DATE
                                </p>

                            </li>
                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you require a document proof or attachment for extended days of this leave?
                        </div>
                        <ul class="">
                            <li class=" border-b-gray-300   hover:bg-pink-100 py-3 px-4 ">
                                <label class=" inline-flex w-full items-center  cursor-pointer"
                                    for="leave_proofAttachment_yes">
                                    <input type="radio" class="form-check-input h-5 w-5 mr-4"
                                        id="leave_proofAttachment_yes" name="leave_proofAttachment" />
                                    YES: REQUIRE AN
                                    ATTACHMENT IF
                                    THE LEAVE EXCEEDS
                                    <input type="text"
                                        class=" w-60  mx-3 p-2 capitalize  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                    CALENDAR DAYS
                                </label>

                            </li>
                            <li class=" border-b-gray-300 w-full   hover:bg-pink-100 py-3 px-4 ">
                                <label class=" inline-flex w-full items-center  cursor-pointer"
                                    for="leave_proofAttachment_no">
                                    <input type="radio" class="form-check-input h-5 w-5 mr-4"
                                        id="leave_proofAttachment_no" name="leave_proofAttachment" />
                                    <p class="text-base uppercase font-semibold text-gray-500">
                                        NO: THIS LEAVE DOES NOT REQUIRE ANY ATTACHMENTS OF DOCUMENT PROOFS
                                    </p>
                                </label>

                            </li>
                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you require to give a prompt message to employee when they apply for leave (Optional)?
                        </div>
                        <ul class="">
                            <li class="hover:bg-pink-100 py-3   px-4  w-full  ">
                                <label for="prompt_message_yes"
                                    class="text-base inline-flex  cursor-pointer w-full items-center uppercase font-semibold text-gray-500">
                                    <input type="radio" class="form-check-input h-5 w-5 mr-4" name="prompt_message"
                                        id="prompt_message_yes" />
                                    YES: PROMPT EMPLOYEE TO READ
                                    THESE CONTENT WHILE THEY APPLY FOR LEAVE.
                                </label>

                            </li>
                            <li class="hover:bg-pink-100 border-b border-gray-300 py-3 px-4  w-full ">
                                <label
                                    class="text-base uppercase cursor-pointer  font-semibold text-gray-500 inline-flex w-full items-center"
                                    for="prompt_message_no" id="">
                                    <input type="radio" class="form-check-input h-5 w-5 mr-4" name="prompt_message"
                                        id="prompt_message_no" />
                                    NO: THERE SHOULD NOT BE ANY
                                    PROMPT MESSAGE TO BE DISPLAYED.
                                </label>

                            </li>
                        </ul>
                        <div class="bg-gray-100 mt-4 shadow-lg p-4 rounded-lg mx-4">

                            <div class="flex justify between  items-center">
                                <p class="text-base  cursor-pointer w-full uppercase font-semibold text-gray-500">
                                    DO YOU WANT TO EMPLOYEE WHO ARE ON NOTICE PERIOD TO APPLY THIS LEAVE TYPE
                                </p>
                                <div class="text-end"><select id="small"
                                        class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                        <option selected>Choose</option>
                                        <option>Yes</option>
                                        <option>No </option>

                                    </select>
                                </div>
                            </div>
                            <span class="text-sm text-gray-900"> (Employees on notice period can apply the leave..... See
                                More)
                            </span>

                        </div>

                    </div>

                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4  font-semibold">
                            <p class=" text-lg text-white "> How to handle leaves clubbing on two different leaves in
                                continuation</p>

                            <span class="text-sm text-white ">With leaves clubbing feature, you can restrict employees to
                                apply leaves in continuation with any other leave type. Whether on same day or subsequent
                                days.
                            </span>

                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4  w-full  ">
                                <div class="inline-flex items-center">
                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                    <p class="text-base uppercase font-semibold text-gray-500">THIS LEAVE TYPE CANNOT BE
                                        CLUB
                                        WITH ANY OTHER LEAVE ON THE SAME DAY?</p>
                                </div>
                                <p class="text-sm text-gray-900 ">(If one same day employee has applied any other leave
                                    type then to allow this leave type or not)
                                </p>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full ">
                                <div class="inline-flex items-center">
                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" />
                                    <p class="text-base uppercase font-semibold text-gray-500">THIS LEAVE TYPE CANNOT BE
                                        APPLIED IF ON PREVIOUS

                                        <input type="text"
                                            class=" w-60  mx-3 p-2 capitalize  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                        THESE LEAVES
                                        <select id="small"
                                            class=" w-48 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                            <option selected>Choose a month</option>

                                        </select>
                                        HAS BEEN APPLIED BY THE EMPLOYEE
                                    </p>
                                </div>


                            </li>
                        </ul>
                    </div>

                </div>

                <div class="tab-pane fade   show" id="step_4" role="tabpanel" aria-labelledby="">

                    <h6 class="mb-3 text-xl text-gray-900">Holidays & Week-Offs Sandwich Policy</h6>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Sandwich rule happen when employee applies leave before and after the week-offs or holidays,
                            then in such cases the week-offs and holidays shall also be treated as leaves or not.
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full ">
                                <label for="" name="balance_lapsed"
                                    class="inline-flex cursor-pointer w-full items-center ">
                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" id="sandwich_one" />
                                    <p class="text-base uppercase font-semibold text-gray-500">SPECIFY WHETHER SANDWICH
                                        RULES
                                        TO APPLY ON</p>
                                    <select id="small"
                                        class=" w-60 mx-3 p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                        <option selected>Choose </option>
                                        <option>Week Offs Only </option>
                                        <option>Hoidays Only </option>
                                        <option>Both </option>

                                    </select>
                                </label>

                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4  w-full  ">
                                <label for="sandwich_two" class="inline-flex cursor-pointer w-full items-center ">
                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" id="sandwich_two" />
                                    <p class="text-base uppercase font-semibold text-gray-500">DO NOT APPLY ABSENT SANDWICH
                                        POLICY</p>
                                </label>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 inline-flex w-full items-center ">

                                <label for="sandwich_three" class="inline-flex cursor-pointer w-full items-center ">
                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" id="sandwich_three" />
                                    <p class="text-base uppercase font-semibold text-gray-500">DO NOT SANDWICH IF PRESENT
                                        ON
                                        OFF-DAY</p>
                                </label>

                            </li>
                        </ul>
                    </div>



                </div>
                <div class="tab-pane fade    show" id="step_5" role="tabpanel" aria-labelledby="">

                    <h6 class="mb-3 text-xl text-gray-900">Year end Process and Encashment</h6>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            What happens to the leave balances at year end?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full inline-flex cursor-pointer items-center ">


                                <p class="text-base uppercase w-3/6 font-semibold  text-gray-500 ">
                                    SHOULD ALL THE LEAVE
                                    BALANCE
                                    TO BE LAPSED?
                                </p>
                                <div class=" flex  items-center justify-between">
                                    <label for="balance_lapsed_yes" class="flex cursor-pointer mr-5 items-center ">
                                        <input type="radio" class="form-check-input h-5 w-5 mr-2"
                                            id="balance_lapsed_yes" name="balance_lapsed" />
                                        Yes
                                    </label>

                                    <label for="balance_lapsed_no" class="flex items-center cursor-pointer ">
                                        <input type="radio" class="form-check-input h-5 w-5 mr-2"
                                            id="balance_lapsed_no" name="balance_lapsed" />
                                        No
                                    </label>
                                </div>


                            </li>

                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Do you want to recover excess leave availed by employees during the Full and Final Settlement
                            process?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full inline-flex cursor-pointer items-center ">
                                <label for="settlement_yes" class="flex  mr-5 items-center ">

                                    <input type="radio" class="form-check-input h-5 w-5  mr-4" id="settlement_yes"
                                        name="settlement" />
                                    <p class="text-base uppercase font-semibold text-gray-500">YES, RECOVER EXCESS
                                        LEAVES AVAILED BY EMPLOYEES IN ADVANCE DURING THE FNF PROCESS</p>
                                </label>
                            </li>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full inline-flex cursor-pointer items-center ">
                                <label for="settlement_no" class="flex  mr-5 items-center ">

                                    <input type="radio" class="form-check-input h-5 w-5  mr-4" id="settlement_no"
                                        name="settlement" />
                                    <p class="text-base uppercase font-semibold text-gray-500">NO, DO NOT RECOVER EXCESS
                                        LEAVES AVAILED BY EMPLOYEES IN ADVANCE DURING THE FNF PROCESS</p>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            Other Option
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 w-full inline-flex cursor-pointer items-center ">
                                <label for="other_option" class="flex  mr-5 items-center ">

                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4" id="other_option"
                                        name="otherOption" />
                                    <p class="text-base uppercase font-semibold text-gray-500">ALLOW LEAVE ENCASHMENT FOR
                                        EXCESS DAYS THEN THE AVAILABLE LEAVE BALANCE</p>
                                </label>
                            </li>

                        </ul>
                    </div>


                </div>
                <div class="tab-pane fade    show" id="step_6" role="tabpanel" aria-labelledby="">

                    {{-- <h6 class="mb-3 text-xl text-gray-900">Year end Process and Encashment</h6> --}}
                    <div class="rounded-lg shadow-lg mb-4 pb-3">
                        <div class="bg-primary rounded-t-md   py-3 px-4 text-white text-lg font-semibold">
                            How you want to configure leave application approval process?
                        </div>
                        <ul>
                            <li class="hover:bg-pink-100 py-3 px-4 flex flex-col  w-full ">
                                <label for="leaveApplication_Process"
                                    class="  cursor-pointer  text-base uppercase font-semibold text-gray-500"><input
                                        type="radio" class="form-check-input h-5 w-5 mr-4"
                                        id="leaveApplication_Process" />
                                    Yes,Leave Application
                                    Requests
                                    Requires Approval
                                </label>


                                <ul class="mt-4">
                                    <li class="hover:bg-pink-100  flex w-full items-center ">
                                        <label for="approval_process"
                                            class="  cursor-pointer  text-base uppercase font-semibold text-gray-500">
                                            <input type="radio" id="approval_process"
                                                class="form-check-input h-5 w-5 mr-4" />
                                            Predefined Standard
                                            Approval
                                            Process

                                        </label>
                                    </li>
                                    <li class="hover:bg-pink-100 py-3 px-4 w-full  cursor-pointer  ">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-base uppercase font-semibold  text-gray-500 ">
                                                Predefined Workflow
                                            </span>
                                            <select id="small"
                                                class=" w-80 p-2   text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 ">
                                                <option selected>Employee To Reporting </option>

                                            </select>
                                            <div class="flex items-center">
                                                <label for="include_admin"
                                                    class=" cursor-pointer w-full text-base mr-7 whitespace-nowrap uppercase font-semibold text-gray-500">
                                                    <input id="include_admin" type="checkbox"
                                                        class="form-check-input h-5 w-5 mr-4" />Allow
                                                    To
                                                    Include Admin
                                                </label>

                                                <label for="dont_sendEmail"
                                                    class=" cursor-pointer w-full text-base mr-7 whitespace-nowrap uppercase font-semibold text-gray-500">
                                                    <input id="dont_sendEmail" type="checkbox"
                                                        class="form-check-input h-5 w-5 mr-4" />Don't
                                                    Send Email
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 ">
                                        <label for="customization_approvalProcess"
                                            class="  cursor-pointer py-3 mr-5 text-base uppercase font-semibold text-gray-500">
                                            <input type="radio" class="form-check-input h-5 w-5 mr-4"
                                                id="customization_approvalProcess" />
                                            Customization
                                            Approval
                                            Process
                                        </label>

                                        <ul>
                                            <li class="py-2">
                                                <label for="replaceExisting_configure"
                                                    class="  cursor-pointer mr-5 text-base uppercase font-semibold text-gray-500">
                                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4"
                                                        id="replaceExisting_configure" />
                                                    Replace Existing Configured Workflow Into All Attendance And Leave
                                                    Policies
                                                </label>
                                            </li>
                                            <li class="py-2">
                                                <label for="replaceWorkflow_configure"
                                                    class="  cursor-pointer mr-5 text-base uppercase font-semibold text-gray-500">
                                                    <input type="checkbox" class="form-check-input h-5 w-5 mr-4"
                                                        id="replaceWorkflow_configure" />
                                                    Replace Workflow Into All Attendance And Leave
                                                    Policies Which Have Not Workflow Configure
                                                </label>
                                            </li>

                                        </ul>

                                    </li>


                                </ul>



                            </li>



                            <li class="hover:bg-pink-100 py-3 px-4 flex flex-col  w-full ">
                                <label for="no_autoApproval"
                                    class="  cursor-pointer  text-base uppercase font-semibold text-gray-500"><input
                                        type="radio" class="form-check-input h-5 w-5 mr-4" id="no_autoApproval" />
                                    No ,Auto Approval Without Requiring Any Approval,Employees Can Apply Leave Application
                                    Requests Without Any Approvals
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
