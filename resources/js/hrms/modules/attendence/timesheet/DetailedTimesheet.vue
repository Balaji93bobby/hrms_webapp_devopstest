<template>
    <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
    <Sidebar v-model:visible="useTimesheet.canShowSidebar" position="right" class="" :style="{ width: '30vw !important' }">
        <template #header>
            <p class="absolute left-0 mx-4 font-semibold fs-5 "></p>
            <div class=" bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold relative">
                    Attendance Reports
                </h1>
            </div>
        </template>

        <div v-if="useTimesheet.currentlySelectedCellRecord.isAbsent" class="p-2">
            <div v-if="useTimesheet.currentlySelectedCellRecord.absent_reg_status == 'None'">
                <div class="rounded-lg bg-red-50 p-3 my-3">
                    <p class="text-center font-semibold fs-6">Absent</p>

                    <div class="flex justify-center gap-x-20 my-3">
                        <a class="text-left text-blue-500 underline font-semibold fs-6 cursor-pointer "
                            href="/attendance-leave">Apply leave</a>
                        <a class="text-right text-blue-500 underline font-semibold fs-6 cursor-pointer"
                            @click="useTimesheet.classicAttendanceRegularizationDialog = true">Regularize</a>
                    </div>
                </div>
                <div class="my-2 bg-orange-50 rounded-lg p-3 py-4 transition-all duration-700"
                    v-if="useTimesheet.classicAttendanceRegularizationDialog">
                    <div class="grid grid-cols-2 ">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Date</label></div>
                        <div class="">
                            <span class="text-ash-medium fs-15" id="current_date">
                                {{ useTimesheet.currentlySelectedCellRecord.date }}</span>
                            <input type="hidden" class="text-ash-medium form-control fs-15" name="attendance_date"
                                id="attendance_date">
                        </div>
                    </div>
                    <div class="grid grid-cols-2  my-4">
                        <div class="">
                            <label class="font-semibold fs-6 text-gray-700">Check In Time</label>
                        </div>
                        <div class="">
                            <input placeholder="format-09:30:00" type="time" @keypress="isNumber($event)"
                                class="border-1 p-1.5 rounded-lg border-gray-400 w-full" name="" id=""
                                v-model="useTimesheet.absentRegularizationDetails.start_time">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 ">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Check Out Time</label>
                        </div>
                        <div class="">
                            <input placeholder="format-09:30:00" type="time" @keypress="isNumber($event)"
                                class="border-1 p-1.5 rounded-lg border-gray-400 w-full" name="" id=""
                                v-model="useTimesheet.absentRegularizationDetails.end_time">
                        </div>
                    </div>
                    <div class="grid grid-cols-2  my-4">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Reason</label></div>
                        <div>
                            <select name="reason" class="form-select btn-line-orange w-full" id="reason_lc"
                                v-model="useTimesheet.absentRegularizationDetails.reason">
                                <option selected hidden disabled>
                                    Choose Reason
                                </option>
                                <option value="Permission">Permission</option>
                                <option value="Technical Error">Technical Error</option>
                                <option value="Official">Official</option>
                                <option value="Personal">Personal</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 " v-if="useTimesheet.absentRegularizationDetails.reason == 'Others'">
                        <div class="row">
                            <div class="col-12">
                                <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                                    placeholder="Reason here...."
                                    v-model="useTimesheet.absentRegularizationDetails.custom_reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">
                        <button type="button" class="btn btn-orange"
                            @click="useTimesheet.applyAbsentRegularization">Apply</button>
                    </div>

                </div>
            </div>
            <div v-else class="p-3 rounded-lg my-3 "
                :class="findAbsentStatus(useTimesheet.currentlySelectedCellRecord.absent_reg_status)">
                Absent Regularization applied successful <i
                    :class="icons(true, useTimesheet.currentlySelectedCellRecord.absent_reg_status)" class="py-auto"
                    style="font-size: 1.2rem"></i>
            </div>
        </div>

        <div class="rounded-lg bg-orange-50 p-3" v-if="!useTimesheet.currentlySelectedCellRecord.isAbsent">
            <p class="font-sans font-bold fs-6">Check-in</p>
            <div class="my-2  ">
                <div class="grid grid-cols-6 gap-y-4">
                    <p class="font-medium text-[12px] text-gray-700 col-span-2 ">In Time</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-3">{{
                        getProcessedCheckInTime(useTimesheet.currentlySelectedCellRecord,
                            true) }}</p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check In Mode</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-3">{{
                        capitalizeFLetter(useTimesheet.currentlySelectedCellRecord.attendance_mode_checkin) }}

                        <!-- <i class="text-green-800 font-semibold text-sm mx-2"
                            :class="findAttendanceMode(useTimesheet.currentlySelectedCellRecord.attendance_mode_checkin)"></i> -->
                        <i v-if="useTimesheet.currentlySelectedCellRecord.attendance_mode_checkin == 'mobile'"
                            class="fa fa-picture-o fs-6 cursor-pointer  animate-pulse"
                            @click="viewSelfieImage('checkin', useTimesheet.currentlySelectedCellRecord.selfie_checkin)"
                            aria-hidden="true"></i>
                    </p>


                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check In Status</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] whitespace-nowrap col-span-2">{{
                        capitalizeFLetter(findCheckInStatus('checkin', useTimesheet.currentlySelectedCellRecord)) }}

                    </p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Approval Status</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">
                        {{ findCheckInStatus('checkInStatus', useTimesheet.currentlySelectedCellRecord) }}</p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Remarks</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-3">
                        {{ findRegularizeRemarks('checkin', useTimesheet.currentlySelectedCellRecord) }}</p>

                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkin && useTimesheet.currentlySelectedCellRecord.checkin_full_address"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Location</p>
                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkin && useTimesheet.currentlySelectedCellRecord.checkin_full_address"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkin && useTimesheet.currentlySelectedCellRecord.checkin_full_address"
                        class="font-semibold text-[12px] col-span-2">{{
                            useTimesheet.currentlySelectedCellRecord.checkin_full_address }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-blue-50 p-3 my-3" v-if="!useTimesheet.currentlySelectedCellRecord.isAbsent">
            <p class="font-sans font-bold text-[12px]">Check-out</p>

            <div class="my-2">
                <div class="grid grid-cols-6 my-1 gap-y-4">
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Out Time</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">{{
                        getProcessedCheckOutTime(useTimesheet.currentlySelectedCellRecord,
                            true) }}</p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check Out Mode</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">{{
                        capitalizeFLetter(useTimesheet.currentlySelectedCellRecord.attendance_mode_checkout) }}
                        <i v-if="useTimesheet.currentlySelectedCellRecord.attendance_mode_checkout == 'mobile'"
                            class="fa fa-picture-o text-[12px] cursor-pointer animate-pulse" aria-hidden="true"
                            @click="viewSelfieImage('checkout', useTimesheet.currentlySelectedCellRecord.selfie_checkout)"></i>

                        <!-- <i class="text-green-800 font-semibold text-sm mx-2"
                            :class="findAttendanceMode(useTimesheet.currentlySelectedCellRecord.attendance_mode_checkout)"></i> -->
                    </p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check Out Status</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2 whitespace-nowrap">{{ findCheckInStatus('checkout',
                        useTimesheet.currentlySelectedCellRecord) }}</p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Approval Status</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">{{ findCheckInStatus('checkOutStatus',
                        useTimesheet.currentlySelectedCellRecord) }}</p>

                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Remarks</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">{{ findRegularizeRemarks('checkout',
                        useTimesheet.currentlySelectedCellRecord) }}</p>

                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkout && useTimesheet.currentlySelectedCellRecord.checkout_full_address"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Location</p>
                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkout && useTimesheet.currentlySelectedCellRecord.checkout_full_address"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="useTimesheet.currentlySelectedCellRecord.selfie_checkout && useTimesheet.currentlySelectedCellRecord.checkout_full_address"
                        class="font-semibold text-[12px] col-span-3">{{
                            useTimesheet.currentlySelectedCellRecord.checkout_full_address }}
                    </p>

                </div>
            </div>
        </div>
    </Sidebar>
    <div ref="calendarContainer" class="min-h-full min-w-fit text-gray-800 card" v-if="singleAttendanceDay">
        <div class="min-w-max border  grid grid-cols-7 gap-1 card-body ">
            <!-- Top navigation bar  -->
            <Top />

            <!-- Finding Days -->
            <div v-for="day in daysOfTheWeek"
                class="text-center text-sm md:text-base lg:text-lg font-semibold text-orange-500 my-4">
                {{ day.substring(0, 3) }}
            </div>
            <div v-if="firstDayOfCurrentMonth > 0" v-for="day in firstDayOfCurrentMonth" :key="day"
                class=" w-full border opacity-50 "></div>
            <!-- singleAttendanceDay Timesheet Data from current month  -->

            <div v-for="day in daysInCurrentMonth" :key="day"
                class=" h-16 py-3 shadow-sm  md:h-36 w-full border align-top rounded-lg " :class="{
                    'bg-slate-50 text-gray-600 font-medium': isToday(day),
                    'hover:bg-gray-100 hover:text-gray-700': !isToday(day),
                    'bg-gray-200': isWeekEndDays(day)
                }">


                <!-- EACH CELL -->
                <div v-if="currentMonthsingleAttendanceDay(day, singleAttendanceDay).length"
                    v-for="singleAttendanceDay in currentMonthsingleAttendanceDay(day, singleAttendanceDay)"
                    class="hidden md:block">
                    <div v-if="isFutureDate(day)" style="max-width: 140px;">
                        <div
                            class="w-full h-full text-xs md:text-sm lg:text-base text-left px-2 transition-colors font-semibold ">
                            <div class="flex justify-center">
                                <p>{{ dayjs(singleAttendanceDay.date).format('D') }}</p>
                                <div v-if="!singleAttendanceDay.isAbsent">
                                    <p v-if="singleAttendanceDay.workshift_code && !singleAttendanceDay.attendance_status"
                                        class="text-right px-2 text-white font-semibold text-xs bg-indigo-900  rounded-md">
                                        {{ singleAttendanceDay.workshift_code }}</p>
                                </div>

                            </div>

                            <!-- Week end -->

                            <div v-if="isWeekEndDays(day)">
                                <p v-if="singleAttendanceDay.isAbsent" class="font-bold text-sm text-orange-400">Week Off
                                </p>
                            </div>


                            <!-- If Employee is Absent  -->
                            <!-- {{ leaveStatus(singleAttendanceDay.isAbsent) }} -->
                            <div v-if="singleAttendanceDay.attendance_status" class="flex justify-center items-center">
                                <p v-if="!singleAttendanceDay.isAbsent && !isWeekEndDays(day)"
                                    class="px-auto font-semibold  fs-6  text-black text-center py-5">NA
                                </p>
                            </div>
                            <div v-else-if="singleAttendanceDay.isAbsent">
                                <div v-if="singleAttendanceDay.leave_status">
                                    <div class="bg-green-100 p-3 rounded-lg"
                                        v-if="singleAttendanceDay.leave_status.includes('Approved')">
                                        <p class="font-semibold fs-6 text-green-900 text-center">
                                            {{ singleAttendanceDay.leave_type == 'Sick Leave / Casual Leave'
                                                ? 'Sl/CL Approved'
                                                : singleAttendanceDay.leave_type }}
                                        </p>
                                        <p class="text-center">Approved
                                            <i class='fa fa-check-circle text-success mx-2' v-tooltip="'Approved'"
                                                title="Not Applied"></i>
                                        </p>
                                    </div>
                                    <div class="bg-red-100 p-3 rounded-lg"
                                        v-else-if="singleAttendanceDay.leave_status.includes('Rejected')">
                                        <p class="font-semibold fs-6 text-red-900 text-center">
                                            {{ singleAttendanceDay.leave_type == 'Sick Leave / Casual Leave'
                                                ? 'Sl/CL Approved' : singleAttendanceDay.leave_type }}
                                        </p>
                                        <p class="text-center">Rejected <i class="fa fa-times-circle mx-2 text-danger"></i>
                                        </p>
                                    </div>
                                    <div class="bg-yellow-100 p-3 rounded-lg"
                                        v-else-if="singleAttendanceDay.leave_status.includes('Pending')">
                                        <p class="font-semibold fs-6 text-yellow-600 text-center">
                                            {{ singleAttendanceDay.leave_type == 'Sick Leave / Casual Leave'
                                                ? 'Sl/CL Approved' : singleAttendanceDay.leave_type }}
                                        </p>
                                        <p class="text-center">Pending<i
                                                class="fa fa-question-circle fs-15 text-secondary mx-2"
                                                v-tooltip="'Pending'"></i></p>
                                    </div>
                                    <div class="bg-slate-100 p-3 rounded-lg"
                                        v-else-if="singleAttendanceDay.leave_status.includes('Revoked')">
                                        <p class="font-semibold fs-6 text-slate-600 text-center">
                                            {{ singleAttendanceDay.leave_type == 'Sick Leave / Casual Leave'
                                                ? 'Sl/CL Approved' : singleAttendanceDay.leave_type }}
                                        </p>
                                        <p class="text-center">Revoked</p>
                                    </div>
                                </div>
                                <div class="bg-green-100 p-3 rounded-lg" v-else-if="singleAttendanceDay.is_holiday">
                                    <p class="font-semibold fs-6 text-green-900 text-center">
                                        {{ singleAttendanceDay.holiday_name }}
                                    </p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-lg" v-else-if="(!isWeekEndDays(day) && singleAttendanceDay.is_week_off)">
                                    <p class="font-semibold fs-6 text-green-900 text-center">
                                        Week Off
                                    </p>
                                </div>

                                <div class="bg-red-100 p-3 rounded-lg" v-else-if="!isWeekEndDays(day)">
                                    <p class="font-semibold fs-6 text-red-900 text-center">Absent <i
                                            class="fa fa-exclamation-circle text-warning fs-15 mx-2"
                                            v-tooltip="'Not Applied'"></i></p>

                                </div>
                            </div>


                            <!-- If Employee is Present -->
                            <div v-else
                                class="w-full  py-1 flex space-x-1 items-center whitespace-nowrap overflow-hidden  hover: cursor-pointer rounded-sm">
                                <div class="w-full ">
                                    <div class="text-xs tracking-tight text-clip overflow-hidden p-1 overflow-y-auto">
                                        <!-- singleAttendanceDay Check in  -->
                                        <div class="flex">
                                            <div class="flex ">
                                                <i class="fa fa-arrow-down text-green-800  font-semibold text-sm "
                                                    style='transform: rotate(-45deg);'></i>
                                                <p class="text-green-800 font-semibold text-sm mx-1" style="width: 40px;">
                                                    {{ getProcessedCheckInTime(singleAttendanceDay, false) }}
                                                </p>
                                            </div>
                                            <div class="px-1">
                                                <i class="text-green-800 font-semibold text-sm"
                                                    :class="useTimesheet.findAttendanceMode(singleAttendanceDay.attendance_mode_checkin)"></i>
                                                <button
                                                    @click="useTimesheet.onClickSViewSelfie(singleAttendanceDay.selfie_checkin)"
                                                    v-if="singleAttendanceDay.attendance_mode_checkin == 'mobile'"
                                                    class="mx-2">
                                                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="">
                                                <button v-if="singleAttendanceDay.isMIP"
                                                    class="regualarization_button bg-orange-600 text-white"
                                                    @click="useTimesheet.onClickShowMipRegularization(singleAttendanceDay)">MIP</button>

                                                <button v-if="singleAttendanceDay.isLC"
                                                    @click="useTimesheet.onClickShowLcRegularization(singleAttendanceDay)"
                                                    class="regualarization_button bg-blue-900 text-white font-semibold ">LC</button>

                                                <button v-if="singleAttendanceDay.isLC">
                                                    <i v-if="singleAttendanceDay.lc_status.includes('Approved')"
                                                        class='fa fa-check-circle text-success mx-2' v-tooltip="'Approved'"
                                                        title="Not Applied"></i>

                                                    <i v-if="singleAttendanceDay.lc_status.includes('Pending')"
                                                        class="fa fa-question-circle fs-15 text-secondary mx-2"
                                                        v-tooltip="'Pending'"></i>

                                                    <i v-if="singleAttendanceDay.lc_status.includes('Rejected')"
                                                        class="fa fa-times-circle mx-2 text-danger"></i>

                                                    <i v-if="singleAttendanceDay.lc_status.includes('None')"
                                                        class="fa fa-exclamation-circle text-warning fs-15 mx-2"
                                                        v-tooltip="'Not Applied'"></i>
                                                </button>

                                                <button v-if="singleAttendanceDay.isMIP">
                                                    <i v-if="singleAttendanceDay.mip_status.includes('Approved')"
                                                        class='fa fa-check-circle text-success mx-2'
                                                        v-tooltip="'Approved'"></i>

                                                    <i v-if="singleAttendanceDay.mip_status.includes('Pending')"
                                                        class="fa fa-question-circle fs-15 text-secondary mx-2"
                                                        v-tooltip="'Pending'"></i>

                                                    <i v-if="singleAttendanceDay.mip_status.includes('Rejected')"
                                                        class="fa fa-times-circle mx-2 text-danger"
                                                        v-tooltip="'Rejected'"></i>

                                                    <i v-if="singleAttendanceDay.mip_status.includes('None')"
                                                        class="fa fa-exclamation-circle text-warning fs-15 mx-2"
                                                        v-tooltip="'Not Applied'"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs tracking-tight text-clip overflow-hidden p-1">
                                        <!-- singleAttendanceDay Check out  -->

                                        <div class="flex">
                                            <div class="flex">
                                                <i class="fa fa-arrow-down font-semibold text-sm text-red-800 "
                                                    style='transform: rotate(230deg);'></i>
                                                <p class="text-red-800 font-semibold text-sm mx-1" style="width: 40px;">
                                                    {{ getProcessedCheckOutTime(singleAttendanceDay, false) }}
                                                </p>
                                            </div>
                                            <div class="px-1">
                                                <i class="text-red-800 font-semibold text-sm"
                                                    :class="useTimesheet.findAttendanceMode(singleAttendanceDay.attendance_mode_checkout)"></i>
                                                <button
                                                    @click="useTimesheet.onClickSViewSelfie(singleAttendanceDay.selfie_checkout)"
                                                    v-if="singleAttendanceDay.attendance_mode_checkout == 'mobile'"
                                                    class="mx-2">
                                                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="">
                                                <button v-if="singleAttendanceDay.isMOP"
                                                    class="regualarization_button bg-orange-600 text-white"
                                                    @click="useTimesheet.onClickShowMopRegularization(singleAttendanceDay)">MOP</button>
                                                <button v-if="singleAttendanceDay.isEG"
                                                    class="regualarization_button bg-orange-400 text-white"
                                                    @click="useTimesheet.onClickShowEgRegularization(singleAttendanceDay)">EG</button>

                                                <button v-if="singleAttendanceDay.isEG">
                                                    <i v-if="singleAttendanceDay.eg_status.includes('Approved')"
                                                        class='fa fa-check-circle text-success mx-2' v-tooltip="'Approved'"
                                                        title="Not Applied"></i>
                                                    <i v-if="singleAttendanceDay.eg_status.includes('Pending')"
                                                        v-tooltip="'Pending'"
                                                        class="fa fa-question-circle fs-15 text-secondary mx-2"></i>
                                                    <i v-if="singleAttendanceDay.eg_status.includes('Rejected')"
                                                        v-tooltip="'Rejected'"
                                                        class="fa fa-times-circle mx-2 text-danger"></i>
                                                    <i v-if="singleAttendanceDay.eg_status.includes('None')"
                                                        class="fa fa-exclamation-circle text-warning fs-15 mx-2"
                                                        v-tooltip="'Not Applied'"></i>
                                                </button>

                                                <button v-if="singleAttendanceDay.isMOP">
                                                    <i v-if="singleAttendanceDay.mop_status.includes('Approved')"
                                                        v-tooltip="'Approved'" class='fa fa-check-circle text-success mx-2'
                                                        title="Not Applied"></i>
                                                    <i v-if="singleAttendanceDay.mop_status.includes('Pending')"
                                                        v-tooltip="'Pending'"
                                                        class="fa fa-question-circle fs-15 text-secondary mx-2"></i>

                                                    <i v-if="singleAttendanceDay.mop_status.includes('Rejected')"
                                                        v-tooltip="'Rejected'"
                                                        class="fa fa-times-circle  text-danger mx-2"></i>

                                                    <i v-if="singleAttendanceDay.mop_status.includes('None')"
                                                        class="fa fa-exclamation-circle text-warning fs-15 mx-2"
                                                        v-tooltip="'Not Applied'"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Cells in month  -->
            <div v-if="lastEmptyCells > 0" v-for="day in lastEmptyCells" :key="day"
                class="h-16  md:h-36 w-full border rounded-lg opacity-50"></div>

            <div class="rounded-lg md:hidden col-span-7 flex justify-between items-center p-2 ">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5cursor-pointer  transition-all"
                        @click="calendarStore.decrementMonth(1)">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 cursor-pointer  transition-all"
                        @click="calendarStore.incrementMonth(1)">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUpdated, watch } from "vue";
import Top from "./components/Top.vue"
import { useCalendarStore } from "./stores/calendar";
import { useAttendanceTimesheetMainStore } from './stores/attendanceTimesheetMainStore'
import { Service } from '../../Service/Service'
import dayjs from "dayjs";
import moment from "moment";
import LoadingSpinner from "../../../components/LoadingSpinner.vue";




const useTimesheet = useAttendanceTimesheetMainStore()
const service = Service()

const props = defineProps({
    singleAttendanceDay: {
        type: Object,
        required: true,
    },

});

const calendarStore = useCalendarStore();

calendarStore.$subscribe((mutation, state) => {
    getDaysInMonth();
    getFirstDayOfMonth();
});

// component variables
const daysOfTheWeek = {
    1: "Sunday",
    2: "Monday",
    3: "Tuesday",
    4: "Wednesday",
    5: "Thursday",
    6: "Friday",
    7: "Saturday",
};

const daysInCurrentMonth = ref(0);
const firstDayOfCurrentMonth = ref(0);
const lastEmptyCells = ref(0);
/**
 * Gets the number of days present in a month
 * The month is gotten from the calendar store
 */
const getDaysInMonth = () => {
    daysInCurrentMonth.value = new Date(
        calendarStore.getYear,
        calendarStore.getMonth + 1, // 👈️ months are 0-based
        0
    ).getDate();
};




/**
 * Gets in number, the first day of a month
 * The month is gotten from the calendar store
 */


const getFirstDayOfMonth = () => {
    firstDayOfCurrentMonth.value = new Date(
        calendarStore.getYear,
        calendarStore.getMonth,
        1
    ).getDay();
};


const visibleRight = ref(false)


watch(
    () => useTimesheet.canShowSidebar, // Watch changes in route parameters
    (newParams, oldParams) => {
        if (oldParams) {
            console.log("newParams" + newParams);
            console.log("oldParams" + oldParams);
            visibleRight.value = newParams
        }
    }
);


/**
 * Gets the last empty cells (if any) on the calendar grid
 */


const lastCalendarCells = () => {
    let totalGrid = firstDayOfCurrentMonth.value <= 5 ? 35 : 42;

    lastEmptyCells.value =
        totalGrid - daysInCurrentMonth.value - firstDayOfCurrentMonth.value;
};



/**
 * Validates a day to check if it's today or not
 *
 * @param {number} day The day to validate
 * @return boolean True or false if it's today or not
 */
const isToday = (day) => {
    let today = new Date();
    if (
        calendarStore.getYear == today.getFullYear() &&
        calendarStore.getMonth == today.getMonth() &&
        day == today.getDate()
    )
        return true;

    return false;
};


const isWeekEndDays = (day) => {
    var dayValue = new Date(
        calendarStore.getYear,
        calendarStore.getMonth,
        day
    ).getDay();


    if (dayValue == 0) {
        return true;
    } else {
        return false;
    }
}


const isFutureDate = (today) => {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate());

    var dayValue = new Date(
        calendarStore.getYear,
        calendarStore.getMonth,
        today
    )
    if (tomorrow > dayValue) {
        return true
    } else {
        return false
    }
}

/*
    Checks and returns the checkin time .
        1. If LC/MIP is Approved, returns those regularized time.
        2. Else return the 'checkin_time'.

*/
function getProcessedCheckInTime(t_singleAttendanceDay, canShowSeconds) {

    if (t_singleAttendanceDay.lc_status == 'Approved') {
        return getSession(t_singleAttendanceDay.lc_regularized_time, canShowSeconds);
    }
    else
        if (t_singleAttendanceDay.mip_status == 'Approved') {
            return getSession(t_singleAttendanceDay.mip_regularized_time, canShowSeconds);
        }
        else {
            return getSession(t_singleAttendanceDay.checkin_time, canShowSeconds);
        }
}

/*
    Checks and returns the checkin time .
        1. If EG is approved, returns EG regularized time.
        2. Else return the 'checkout_time'.

*/
function getProcessedCheckOutTime(t_singleAttendanceDay, canShowSeconds) {

    if (t_singleAttendanceDay.eg_status == 'Approved') {
        return getSession(t_singleAttendanceDay.eg_regularized_time, canShowSeconds);
    }
    else
        if (t_singleAttendanceDay.mop_status == 'Approved') {
            return getSession(t_singleAttendanceDay.mop_regularized_time, canShowSeconds);
        }
        else {
            return getSession(t_singleAttendanceDay.checkout_time, canShowSeconds);
        }
}

const getSession = (time, canShowSeconds) => {

    let output_timeformat = 'h:mm a';

    if (canShowSeconds)
        output_timeformat = 'h:mm:ss a'

    let timeFormat = time == null ? "--:--:--" : moment(
        time, ["HH:mm"]).format(output_timeformat);

    return timeFormat
};

const isAbesent = (date) => {

}




/**
 * Validates a day to check if event start date is current calendar date or not
 *
 * @param {number} day The calendar month date to check against
 * @param {string} startdate The event start date
 * @return boolean True or false if event is today or not
 */
const isEventToday = (day, startdate) => {
    if (
        calendarStore.getYear == startdate.substring(0, 4) &&
        calendarStore.getMonth + 1 == startdate.substring(5, 7) &&
        day == startdate.substring(8, 10)
    )
        return true;

    return false;
};

/**
 * Gets all the calendar singleAttendanceDay on a given day
 *
 * @param {number} day calendar month day whose event(s) we're getting
 * @param {array} singleAttendanceDay Array of singleAttendanceDay objects to filter through
 *
 * @return array Array of the filtered day's event(s)
 */
const currentMonthsingleAttendanceDay = (day, singleAttendanceDay) => {
    if (!singleAttendanceDay.length) return [];

    let todaysEvent = [];
    singleAttendanceDay.forEach((event) => {
        if (isEventToday(day, event.date)) {
            todaysEvent.push(event);
        }
    });

    return todaysEvent;
};

/**
 * Open the event details modal
 *
 * @param {number} day current calendar month day
 * @param {array} singleAttendanceDay Array of singleAttendanceDay objects to show on the modal
 *
 * @return null
 */

onMounted(() => {
    getDaysInMonth();
    getFirstDayOfMonth();
    lastCalendarCells();
});

onUpdated(() => {
    getFirstDayOfMonth();
    lastCalendarCells();
});

function capitalizeFLetter(name) {
    if (name) {
        let result = name.charAt(0).toUpperCase() +
            name.slice(1)
        return result
    }

}

const findAttendanceStatus = (data) => {
    // console.log(data);
    if (data.is_sandwich_applicable) {
        return 'border-l-4 border-red-500 bg-red-50 text-red-600 font-medium fs-5'
    }
    else if (data.isAbsent) {
        if (data.isAbsent && data.absent_reg_status.includes('Approved')) {
            return 'border-l-4 border-green-500 bg-green-50 text-green-600 font-medium text-[6px]'
        }
        if (data.isAbsent && data.is_holiday) {
            return 'border-l-4 border-green-500 bg-green-50 text-green-600 font-medium fs-5'
        }
        else if (data.leave_status && data.leave_status.includes('Approved')) {
            return 'border-l-4 border-green-500 bg-green-50 text-green-600 font-medium fs-5'
        } else
            if (data.leave_status && data.leave_status.includes('Rejected')) {
                return 'border-l-4 border-red-500 bg-red-50 text-red-600 font-medium fs-5'
            } else
                if (data.leave_status && data.leave_status.includes('Pending')) {
                    return 'border-l-4 border-yellow-500 bg-yellow-50 text-yellow-600 font-medium fs-5'
                } else
                    if (data.leave_status && data.leave_status.includes('Revoked')) {
                        return 'border-l-4 border-gray-500 bg-gray-50 text-gray-600 font-medium fs-5'

                    } else {
                        return 'border-l-4 border-red-500 bg-red-50 text-red-600 font-medium fs-5 '
                    }
    } else {
        if (data.lc_status) {
            return 'border-l-4 border-yellow-500 bg-yellow-50 text-yellow-900 font-medium fs-5 rounded-lg'

        } else
            if (data.mip_status) {
                return 'border-l-4 border-blue-500 bg-blue-50 text-blue-600 font-medium fs-5 rounded-lg'

            } else
                if (data.eg_status) {
                    return 'border-l-4 border-yellow-500 bg-yellow-50 text-yellow-900 font-medium fs-5 rounded-lg'

                }
                else
                    if (data.mop_status) {
                        return 'border-l-4 border-blue-500 bg-blue-50 text-blue-600 font-medium fs-5 rounded-lg'

                    }
                    else {
                        return 'border-l-4 border-green-500 bg-green-50 text-green-600 font-medium fs-5 rounded-lg'

                    }
    }
}

const findAttendanceMode = (attendance_mode) => {
    // console.log(attendance_mode);
    if (attendance_mode == "biometric")
        // return '&nbsp;<i class="fa-solid fa-fingerprint"></i>';
        return 'fas fa-fingerprint fs-12'
    else
        if (attendance_mode == "web")
            return 'fa fa-laptop fs-12';
        else
            if (attendance_mode == "mobile")
                return 'fa fa-mobile-phone fs-12';
            else {
                return ''; // when attendance_mode column is empty.
            }
}
const icons = (isSelected, data) => {

    if (isSelected) {
        if (data == 'Approved') {
            return 'pi pi-check-circle text-green-600 font-semibold'
        } else
            if (data == 'Pending') {
                return 'pi pi-question-circle text-gray-600 font-semibold'
            } else
                if (data == 'Rejected') {
                    return 'pi pi-times-circle text-red-600 font-semibold'
                } else {
                    return 'pi pi-exclamation-circle text-yellow-600 font-semibold'
                }
    } else {
        console.log('no data');
    }

}

const find = (data) => {
    if (data.isAbsent) {
        if (data.isAbsent && data.absent_reg_status.includes('Approved')) {
            return ` Absent Regularization`
        }
        else
            if (data.isAbsent && data.is_holiday) {
                return data.is_holiday == false ? 'Absent' : `${data.holiday_name} Present`
            }

        if (data.leave_status) {
            if (data.leave_status.includes('Approved')) {
                return data.leave_type == 'Sick Leave / Casual Leave' ? 'Sl/CL Approved' : `${data.leave_type} Approved`
            } else
                if (data.leave_status.includes('Rejected')) {
                    return data.leave_type == 'Sick Leave / Casual Leave' ? 'Sl/CL Rejected' : `${data.leave_type} Rejected`
                } else
                    if (data.leave_status.includes('Pending')) {
                        return data.leave_type == 'Sick Leave / Casual Leave' ? 'Sl/CL Pending' : `${data.leave_type} Pending`
                    } else
                        if (data.leave_status.includes('Revoked')) {
                            return `${data.leave_type} Revoked`

                        }

        } else {
            return 'Absent'

        }
    } else {
        if (data.lc_status) {
            return 'Late coming'

        } else
            if (data.mip_status) {
                return 'Missed in punch'

            } else
                if (data.eg_status) {
                    return 'Early going'

                } else
                    if (data.mop_status) {
                        return 'Missed out punch'

                    } else {
                        return 'Present'

                    }
    }
}


const findCheckInStatus = (type, data) => {

    if (type == 'checkin') {
        if (data.isLC) {
            return 'Late coming'

        } else
            if (data.isMIP) {
                return 'Missed in punch'
            } else {
                return '-'
            }

    }
    if (type == 'checkout') {

        if (data.isEG) {
            return 'Early going'

        } else
            if (data.isMOP) {
                return 'Missed out punch'
            } else {
                return '-'
            }

    }

    if (type == 'checkInStatus') {

        if (data.lc_status == 'None' || data.lc_status == 'None') {
            return 'Not Applied'
        } else
            if (data.lc_status) {
                return data.lc_status
            } else
                if (data.mip_status) {
                    return data.mip_status
                } else {
                    return '-'
                }

    }

    if (type == 'checkOutStatus') {
        if (data.eg_status == 'None' || data.mop_status == 'None') {
            return 'Not Applied'
        } else
            if (data.eg_status) {
                return data.eg_status
            } else
                if (data.mop_status) {
                    return data.mop_status
                } else {
                    return '-'
                }

    }


}
const findRegularizeRemarks = (type, data) => {

    if (type == 'checkin') {
        if (data.isLC) {

            return data.lc_reason == 'Others' ? data.lc_reason_custom : data.lc_reason

        } else
            if (data.isMIP) {
                return data.mip_reason == 'Others' ? data.mip_reason_custom : data.mip_reason

            } else {
                return '-'
            }

    }
    if (type == 'checkout') {

        if (data.isEG) {
            return data.eg_reason == 'Others' ? data.eg_reason_custom : data.eg_reason

        } else
            if (data.isMOP) {
                return data.mop_reason == 'Others' ? data.mop_reason_custom : data.mop_reason
            } else {
                return '-'
            }

    }
}

const findAbsentStatus = (data) => {
    if (data.includes('Approved')) {
        return 'bg-green-50'
    } else
        if (data.includes('Pending')) {
            return 'bg-yellow-50'
        } else
            if (data.includes('Rejected')) {
                return 'bg-red-50'
            } else
                if (data.includes('Revoked')) {
                    return 'bg-slate-50'

                }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active
{
    transition: translate 0.5s ease;
}

.modal-enter-from,
.modal-leave-to
{
    /** opacity: 0; **/
    translate: 0px 100%;
}

.regualarization_button
{
    padding: 1px !important;
    height: 14px;
    width: auto;
    min-width: 20px;
    border-radius: 2px;
    font-size: 8px !important;
    text-align: center;
}</style>

