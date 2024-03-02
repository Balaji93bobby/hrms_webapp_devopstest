<template>
    <Sidebar v-model:visible="visibleRight" position="right" class="" :style="{ width: '30vw !important' }">
        <template #header>
            <p class="absolute left-0 mx-4 font-semibold fs-5 "></p>
            <div class=" bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold relative">
                    Attendance Regularization
                </h1>
            </div>
        </template>

        <div v-if="currentlySelectedCellRecord.isAbsent" class="p-2">
            <div v-if="currentlySelectedCellRecord.absent_reg_status == 'None'">
                <!-- <div class="rounded-lg bg-red-50 p-3 my-3"> -->
                    <!-- <p class="text-center font-semibold fs-6">Absent</p> -->

                    <!-- <div class="flex justify-center gap-x-20 my-3"> -->
                        <!-- href="/attendance-leave" -->
                        <!-- <a class="text-left text-blue-500 underline font-semibold fs-6 cursor-pointer "
                            @click="useTimesheet.classicAttendanceRegularizationDialog = false">Apply leave</a>
                        <a class="text-right text-blue-500 underline font-semibold fs-6 cursor-pointer"
                            @click="useTimesheet.classicAttendanceRegularizationDialog = true">Regularize</a>
                    </div>
                </div> -->

                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
                    <li class=" nav-item" role="presentation">
                        <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                            aria-selected="true" @click="useTimesheet.classicAttendanceRegularizationDialog = false" :class="[useTimesheet.classicAttendanceRegularizationDialog  === false ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                            Apply leave
                        </a>
                        <div v-if="useTimesheet.classicAttendanceRegularizationDialog === false" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;" ></div>
                        <div v-else class=" border-2 h-1 rounded-l-3xl border-gray-300"></div>
                    </li>

                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="useTimesheet.classicAttendanceRegularizationDialog = true"
                            :class="[useTimesheet.classicAttendanceRegularizationDialog === true ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Regularize
                        </a>
                        <div v-if="useTimesheet.classicAttendanceRegularizationDialog === true"
                            class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]" style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1  border-gray-300"></div>

                    </li>
                    <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
                </ul>
                <!-- <button @click="" class="border" >test</button> -->

                <!-- start -->

                <div class=" box-border " v-if="!useTimesheet.classicAttendanceRegularizationDialog">
                    <!-- <p class="text-[14px] font-semibold font-['poppins'] mb-4 py-1">Leave Request</p> -->
                    <div class="bg-[#FFF4E3] p-4 box-border border-1 border-[#DDDDDD]  rounded-lg grid-cols-6 ">
                        <!-- leave type -->
                        <div class="  col-span-6">
                            <p class="text-[#757575] text-[12px] font-['poppins'] p-1 box-border font-semibold ">Choose
                                Leave
                                Type<span class="text-danger">*</span></p>
                            <div class=" flex justify-content-center box-border">
                                <Dropdown class=" h-[30px] w-full  flex justify-center items-center"
                                    v-model="useLeave.leave_data.selected_leave" :options="useLeave.leave_types"
                                    optionLabel="leave_type" optionValue="leave_value" placeholder="Select Leave Type"
                                    :class="[
                                        v$.selected_leave.$error ? 'p-invalid' : '',
                                    ]" @change="useLeave.checkLeaveEligibility(useLeave.leave_data.selected_leave,useTimesheet.selected_user_code)" />

                            </div>
                            <span v-if="v$.selected_leave.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.selected_leave.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- no of days -->
                        <div class="py-2 box-border col-span-6"
                            v-if="!useLeave.leave_data.selected_leave.includes('Permission') && !useLeave.leave_data.selected_leave.includes('Compensatory Off')">
                            <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">No of days<span
                                    class="text-danger">*</span></p>
                            <!-- {{ useLeave.leave_data.radiobtn_full_day }} -->
                            <div class="flex text-sm m-2 gap-6">
                                <div class="form-check form-check-inline ">

                                    <input style="height: 15px;width: 15px;"
                                        class="form-check-input border-2 border-gray-500   "
                                        :disabled="useLeave.check_full_day === false" type="radio" name="leave1"
                                        value="full_day" id="full_day" :value="'full_day'"
                                        v-model="useLeave.leave_data.radiobtn_full_day"
                                        @click="currentlySelectedCellRecord_date(), useLeave.leave_data.radiobtn_half_day = '', useLeave.leave_data.radiobtn_custom = '', h$.$reset(), c$.$reset()"
                                        :class="[
                                            f$.radiobtn_full_day.$error ? 'p-invalid' : '',
                                        ]">

                                    <label class=" ms-1 font-normal text-[12px] font-['poppins']" for="full_day">Full
                                        Day</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <!-- {{ useLeave.leave_data.radiobtn_half_day }} -->
                                    <input style="height: 15px;width: 15px;"
                                        class="form-check-input  border-2 border-gray-500 " type="radio" name="leave1"
                                        value="half_day" id="half_day" :value="'half_day'"
                                        v-model="useLeave.leave_data.radiobtn_half_day"
                                        :disabled="useLeave.check_half_day === false"
                                        @click="currentlySelectedCellRecord_date(), f$.$reset(), c$.$reset(), useLeave.leave_data.radiobtn_custom = '', useLeave.leave_data.radiobtn_full_day = ''"
                                        :class="[
                                            h$.radiobtn_half_day.$error ? 'p-invalid' : '',
                                        ]">

                                    <label class=" ms-1 font-normal text-[12px] font-['poppins']  " for="half_day">Half
                                        Day</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <!-- {{ useLeave.leave_data.radiobtn_custom }} -->
                                    <input style="height: 15px;width: 15px;"
                                        class="form-check-input  border-2 border-gray-500  "
                                        :disabled="useLeave.check_custom_day === false" type="radio" name="leave1"
                                        id="custom" :value="'custom'" v-model="useLeave.leave_data.radiobtn_custom"
                                        @click="currentlySelectedCellRecord_date(), useLeave.leave_data.radiobtn_half_day = '', useLeave.leave_data.radiobtn_full_day = '', h$.$reset(), f$.$reset()"
                                        :class="[
                                            c$.radiobtn_custom.$error ? 'p-invalid' : '',
                                        ]">

                                    <label class=" ms-1 font-normal text-[12px] font-['poppins']  "
                                        for="custom">Custom</label>

                                </div>
                            </div>
                            <span
                                v-if="f$.radiobtn_full_day.$error && h$.radiobtn_half_day.$error && c$.radiobtn_custom.$error"
                                class="font-semibold p-2 box-border text-red-400 fs-6">
                                <!-- {{ f$.radiobtn_full_day.$errors[0].$message }} -->
                                Value is Required
                            </span>
                            <!-- <span v-if="h$.radiobtn_half_day.$error" class="font-semibold p-2 box-border  text-red-400 fs-6">
                        {{ h$.radiobtn_half_day.$errors[0].$message }}
                    </span>
                    <span v-if="c$.radiobtn_custom.$error" class="font-semibold p-2 box-border  text-red-400 fs-6">
                        {{ c$.radiobtn_custom.$errors[0].$message }}
                    </span> -->
                        </div>
                        <!-- half day -->
                        <div v-if="useLeave.leave_data.radiobtn_half_day && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')"
                            class="py-1 col-span-6 ">
                            <p class="text-[#757575] text-[12px] font-['poppins'] font-semibold "> Date<span
                                    class="text-danger">*</span></p>
                            <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                                v-model="useLeave.leave_data.half_day_leave_date" disabled  placeholder="Select Date"
                                class="h-[38px] w-[130px] m-2 " :class="[
                                    h$.half_day_leave_date.$error ? 'p-invalid' : '',
                                ]" :value="'half_day'" :minDate="new Date(useLeave.before_date)"
                                />
                            <!-- :minDate="new Date()" -->
                            <!-- @date-select="useLeave.isRestrict(useLeave.leave_data.half_day_leave_date)" -->
                            <span v-if="h$.half_day_leave_date.$error"
                                class="font-semibold p-2 box-border  text-red-400 fs-6">
                                {{ h$.half_day_leave_date.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- half day session -->
                        <div v-if="useLeave.leave_data.radiobtn_half_day && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')"
                            class="py-1 col-span-6">
                            <p class="text-[#757575] text-[12px] font-['poppins'] font-semibold "> Session<span
                                    class="text-danger">*</span></p>
                            <div class="flex flex-wrap gap-3 m-2 ">
                                <div class="flex ">
                                    <!-- {{ useLeave.leave_data.half_day_leave_session }} -->
                                    <input type="radio" id="fn" name="session" :value="'Forenoon'"
                                        :disabled="useLeave.leave_data.half_day_leave_date === ''"
                                        class="h-5 form-check-input border-2 " style="height: 15px;width: 15px;"
                                        v-model="useLeave.leave_data.half_day_leave_session" :class="[
                                            h$.half_day_leave_session.$error ? 'p-invalid' : '',
                                        ]" />
                                    <label for="fn"
                                        class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Forenoon</label>
                                </div>
                                <div class="flex ">
                                    <input type="radio" id="an" name="session" :value="'Afternoon'" class="h-5
                            form-check-input border-2 " style="height: 15px;width: 15px;"
                                        :disabled="useLeave.leave_data.half_day_leave_date === ''"
                                        v-model="useLeave.leave_data.half_day_leave_session" :class="[
                                            h$.half_day_leave_session.$error ? 'p-invalid' : '',
                                        ]" />
                                    <label for="an"
                                        class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Afternoon</label>
                                </div>
                                <span v-if="h$.half_day_leave_session.$error"
                                    class="font-semibold p-2 box-border  text-red-400 fs-6">
                                    {{ h$.half_day_leave_session.$errors[0].$message }}
                                </span>
                            </div>
                        </div>
                        <!-- full day -->
                        <div v-if="useLeave.leave_data.radiobtn_full_day && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')"
                            class="col-span-6">
                            <p class="text-[#757575] font-normal text-[12px] font-['poppins']biorder-[1px] border-[#000] "> Date<span
                                    class="text-danger">*</span></p>
                            <!-- {{ new Date(useLeave.attendance_start_date +1) }} -->
                            <!-- {{ useLeave.leave_restrict_dates.value }} -->
                            <!-- :minDate="new Date(useLeave.before_date)" -->
                            <!-- @date-select="useLeave.isRestrict(useLeave.leave_data.full_day_leave_date)" -->
                            <Calendar dateFormat="dd-mm-yy"
                                :showIcon="true" disabled
                                v-model="useLeave.leave_data.full_day_leave_date"
                                placeholder="Select Date" class="h-[38px] w-[130px] m-2 " :class="[
                                    f$.full_day_leave_date.$error ? 'p-invalid' : '',
                                ]">
                                <template>
                                    <strong class=" text-[blue]"
                                        v-if="useLeave.leave_restrict_dates.includes(useLeave.leave_data.full_day_leave_date)"
                                        style="text-decoration: line-through !important">
                                        {{ useLeave.leave_data.full_day_leave_date }}
                                    </strong>
                                    <!--   v-if=" new Date(useLeave.leave_restrict_dates.value.includes(useLeave.leave_data.full_day_leave_date)) " -->
                                    <template v-else>
                                        {{ useLeave.leave_data.full_day_leave_date }}
                                    </template>
                                </template>
                            </Calendar>


                            <span v-if="f$.full_day_leave_date.$error"
                                class="font-semibold p-2 box-border  text-red-400 fs-6">
                                {{ f$.full_day_leave_date.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- start date -->
                        <div v-if="useLeave.leave_data.radiobtn_custom && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')"
                            class="col-span-6">
                            <p class="text-[#757575] font-semibold text-[12px] font-['poppins'] ">Start Date<span
                                    class="text-danger">*</span></p>
                            <div class="flex py-2 ">
                                <Calendar dateFormat="dd-mm-yy" :showIcon="true" disabled
                                    v-model="useLeave.leave_data.custom_start_date" placeholder="Select Date"
                                    class="h-[38px] w-[130px] mx-2 " :class="[
                                        c$.custom_start_date.$error ? 'p-invalid' : '',
                                    ]" :minDate="new Date(useLeave.before_date)"
                                     />
                                     <!-- @date-select="useLeave.isRestrict(useLeave.leave_data.custom_start_date)" -->

                                <div class="flex flex-wrap gap-3 ml-3 mt-2 ">
                                    <div class="flex ">
                                        <input type="radio" name="days1" value="Full day" id="startfull"
                                            class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                            v-model="useLeave.leave_data.custom_start_day_session" :class="[
                                                c$.custom_start_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="startfull"
                                            class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Full
                                            day</label>
                                    </div>
                                    <div class="flex ">
                                        <input type="radio" name="days1"  value="Forenoon" id="startfn"
                                            class="h-5 form-check-input border-2 " style="height: 15px;width: 15px;"
                                            v-model="useLeave.leave_data.custom_start_day_session" :class="[
                                                c$.custom_start_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="startfn"
                                            class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Forenoon</label>
                                    </div>
                                    <div class="flex ">
                                        <input type="radio" name="days1" value="Afternoon" id="startan" class="h-5
                                form-check-input border-2 " style="height: 15px;width: 15px;"
                                            v-model="useLeave.leave_data.custom_start_day_session" :class="[
                                                c$.custom_start_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="startan"
                                            class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Afternoon</label>
                                    </div>
                                    <span v-if="c$.custom_start_day_session.$error" class="font-semibold text-red-400 fs-6">
                                        {{ c$.custom_start_day_session.$errors[0].$message }}
                                    </span>
                                </div>

                            </div>

                            <span v-if="c$.custom_start_date.$error" class="font-semibold text-red-400 fs-6">
                                {{ c$.custom_start_date.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- end date -->
                        <div v-if="useLeave.leave_data.radiobtn_custom && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')"
                            class="py-3 col-span-6">
                            <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">End Date<span
                                    class="text-danger">*</span></p>
                            <div class="flex py-2 ">
                            <!-- :minDate="new Date(useLeave.before_date)" -->
                                <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                                    v-model="useLeave.leave_data.custom_end_date"  placeholder="Select Date"
                                    class="h-[38px] w-[130px] mx-" :class="[
                                        c$.custom_end_date.$error ? 'p-invalid' : '',
                                    ]" :minDate="useLeave.leave_data.custom_start_date"
                                    @date-select="useLeave.dayCalculation(),useLeave.custom_date_validation()" />
                                    <!-- useLeave.isRestrict(useLeave.leave_data.custom_end_date) -->
                                <div class="flex flex-wrap gap-3 ml-3 text-sm mt-2">
                                    <div class="flex ">
                                        <input type="radio"  @change="useLeave.leave_data.custom_end_day_session ? service.addFullday() : ''"  name="days2" value="Full day" id="endfull"
                                            style="width:15px;height:15px;" class="h-5 form-check-input border-2"
                                            v-model="useLeave.leave_data.custom_end_day_session" :class="[
                                                c$.custom_end_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="endfull"
                                            class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Full
                                            day</label>
                                    </div>
                                    <div class="flex ">
                                        <input type="radio" @change="useLeave.leave_data.custom_end_day_session ? service.addHalfday() : ''" name="days2" value="Forenoon" id="endfn"
                                            class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                            v-model="useLeave.leave_data.custom_end_day_session" :class="[
                                                c$.custom_end_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="endfn"
                                            class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Forenoon</label>
                                    </div>
                                    <div class="flex ">
                                        <input type="radio" name="days2" value="Afternoon" id="endan" class="h-5
                                form-check-input border-2" style="height: 15px;width: 15px;"
                                            v-model="useLeave.leave_data.custom_end_day_session" :class="[
                                                c$.custom_end_day_session.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="endan"
                                            class="ml-2 ms-1 font-normal text-[12px] font-['poppins']">Afternoon</label>
                                    </div>
                                    <span v-if="c$.custom_end_day_session.$error" class="font-semibold text-red-400 fs-6">
                                        {{ c$.custom_end_day_session.$errors[0].$message }}
                                    </span>
                                </div>
                            </div>
                            <span v-if="c$.custom_end_date.$error" class="font-semibold text-red-400 fs-6">
                                {{ c$.custom_end_date.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- total days -->
                        <div class="col-span-6"
                            v-if="useLeave.leave_data.radiobtn_custom && useLeave.leave_data.selected_leave !== 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')">
                            <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">Total Days</p>

                            <InputText style="width: 60px;text-align: center;margin: auto;"
                                class="capitalize form-onboard-form form-control textbox " type="text"
                                v-model="useLeave.leave_data.custom_total_days" readonly :class="[
                                    c$.custom_total_days.$error ? 'p-invalid' : '',
                                ]" />

                            <span v-if="c$.custom_total_days.$error" class="font-semibold text-red-400 fs-6">
                                {{ c$.custom_total_days.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- comp off -->
                        <div class="grid-cols-6 col-span-6"
                            v-if="useLeave.leave_data.selected_leave.includes('Compensatory Off')">
                            <p class="col-span-6 text-[#757575] font-semibold text-[12px] font-['poppins'] p-1 box-border">
                                Compensatory Off Dates</p>
                            <MultiSelect v-model="useLeave.leave_data.selected_compensatory_leaves"
                                :options="useLeave.leave_data.compensatory_leaves" optionLabel="emp_attendance_date"
                                optionValue="emp_attendance_id" display="chip" placeholder="Select Dates"
                                class="w-full md:w-20rem" :class="[
                                    cp$.selected_compensatory_leaves.$error ? 'p-invalid' : '',
                                ]">

                                <div class="flex align-items-center">

                                    <div>{{ useLeave.leave_data.compensatory_leaves.emp_attendance_date }}</div>
                                </div>

                            </MultiSelect>
                            <span v-if="cp$.selected_compensatory_leaves.$error" class="font-semibold text-red-400 fs-6">
                                {{ cp$.selected_compensatory_leaves.$errors[0].$message }}
                            </span>
                            <div v-if="useLeave.leave_data.compensatory_leaves.length === 1">
                                <p
                                    class="col-span-6 text-[#757575] font-semibold text-[12px] font-['poppins'] p-1 box-border">
                                    Select Date</p>
                                <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                                    v-model="useLeave.leave_data.compensatory_leaves_dates" placeholder="Select Date"
                                    class="h-[38px] w-[130px] m-2 " :minDate="new Date()" :class="[
                                        cp$.compensatory_leaves_dates.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="cp$.compensatory_leaves_dates.$error" class="font-semibold text-red-400 fs-6">
                                    {{ cp$.compensatory_leaves_dates.$errors[0].$message }}
                                </span>
                                <p class="text-[#757575] font-normal text-[12px] font-['poppins']">Total Day</p>
                                <InputText style="width: 60px;text-align: center;margin: auto;"
                                    class="capitalize form-onboard-form form-control textbox " type="text"
                                    v-model="useLeave.leave_data.compensatory_total_days" readonly value="1" />

                            </div>
                            <div v-if="useLeave.leave_data.compensatory_leaves.length > 1">
                                <!-- comp off start date -->
                                <p
                                    class="col-span-6 text-[#757575] font-normal text-[12px] font-['poppins'] p-1 box-border">
                                    Start
                                    Date</p>
                                <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                                    v-model="useLeave.leave_data.compensatory_start_date" placeholder="Select Date"
                                    class="h-[38px] w-[130px] mx-2 " :minDate="new Date()" :class="[
                                        cp$.compensatory_start_date.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="cp$.compensatory_start_date.$error" class="font-semibold text-red-400 fs-6">
                                    {{ cp$.compensatory_start_date.$errors[0].$message }}
                                </span>
                                <!-- comp off end date -->
                                <p
                                    class="col-span-6 text-[#757575] font-normal text-[12px] font-['poppins'] p-1 box-border">
                                    End
                                    Date</p>
                                <Calendar dateFormat="dd-mm-yy" @date-select="useLeave.dayCalculation" :showIcon="true"
                                    v-model="useLeave.leave_data.compensatory_end_date" placeholder="Select Date"
                                    class="h-[38px] w-[130px] mx-2 " :minDate="new Date()" :class="[
                                        cp$.compensatory_end_date.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="cp$.compensatory_end_date.$error" class="font-semibold text-red-400 fs-6">
                                    {{ cp$.compensatory_end_date.$errors[0].$message }}
                                </span>
                                <p class="text-[#757575] font-normal text-[12px] font-['poppins']">Total Days</p>
                                <!-- total comp off count -->
                                <InputText style="width: 60px;text-align: center;margin: auto;"
                                    class="capitalize form-onboard-form form-control textbox " type="text"
                                    v-model="useLeave.leave_data.compensatory_total_days" readonly />
                            </div>
                        </div>
                        <!-- permission -->
                        <div
                            v-if="useLeave.leave_data.selected_leave === 'Permission' && !useLeave.leave_data.selected_leave.includes('Compensatory Off')">
                            <p class="text-[#757575] font-semibold text-[12px] font-['poppins'] ">Permission Date<span
                                    class="text-danger">*</span></p>

                            <div class="flex gap-3 mx-2">
                                <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                                    v-model="useLeave.leave_data.permission_date" placeholder="Select Date"
                                    class="h-[38px] w-[130px]  " :class="[
                                        p$.permission_date.$error ? 'p-invalid' : '',
                                    ]" :minDate="new Date(useLeave.before_date)" />

                                <!-- <div class="flex gap-3 mt-3 px-2 box-border">
                            <div class="flex gap-2 ">
                                <input type="radio" name="permissionSession" value="Forenoon" id="permissionSession"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="useLeave.leave_data.permission_session" :class="[
                                        p$.permission_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="permissionSession"
                                    class="ml-2 ms-1 font-normal text-[12px] font-['poppins']">Forenoon</label>
                            </div>
                            <div class="flex gap-2 ">
                                <input type="radio" name="permissionSession" value="Afternoon" id="permissionSession"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="useLeave.leave_data.permission_session" :class="[
                                        p$.permission_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="permissionSession"
                                    class="ml-2 ms-1 font-normal text-[12px] font-['poppins']">Afternoon</label>
                            </div>

                        </div> -->

                            </div>
                            <span v-if="p$.permission_date.$error" class="font-semibold text-red-400 fs-6">
                                {{ p$.permission_date.$errors[0].$message }}
                            </span>
                            <div class="flex gap-3 my-2 px-2 box-border ">
                                <div class="grid grid-cols-2">
                                    <p class="col-span-2 font-['poppins'] text-[#757575] font-semibold text-[12px]">
                                        Start Time<span class="text-danger">*</span>
                                    </p>
                                    <!-- {{ useLeave.leave_data.permission_start_time }} -->
                                    <Calendar id="permission_start" class="col-span-2 h-[30px] text-center "
                                        v-model="useLeave.leave_data.permission_start_time" showTime hourFormat="12" timeOnly
                                        :class="[
                                            p$.permission_start_time.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="p$.permission_start_time.$error" class="font-semibold text-red-400 fs-6">
                                        {{ p$.permission_start_time.$errors[0].$message }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2">
                                    <p class="col-span-2 font-['poppins'] text-[#757575] font-semibold text-[12px]">
                                        End Time<span class="text-danger">*</span>
                                    </p>
                                    <Calendar @date-select="useLeave.time_difference()" id="permission_end"
                                        class="col-span-2 h-[30px] text-center"
                                        v-model="useLeave.leave_data.permission_end_time"
                                        :disabled="useLeave.leave_data.permission_date == ''" showTime hourFormat="12"
                                        timeOnly :class="[
                                            p$.permission_end_time.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="p$.permission_end_time.$error" class="font-semibold text-red-400 fs-6">
                                        {{ p$.permission_end_time.$errors[0].$message }}
                                    </span>
                                </div>

                            </div>

                            <!--
                    <span v-if="p$.permission_session.$error" class="font-semibold text-red-400 fs-6">
                        {{ p$.permission_session.$errors[0].$message }}
                    </span> -->
                        </div>
                        <div class="grid grid-cols-6  mt-3" v-if="useLeave.leave_data.selected_leave === 'Permission'">
                            <p class="text-[#757575] col-span-6 font-semibold text-[12px] font-['poppins']">Total Minutes
                            </p>
                            <div class="flex col-span-6 justify-center items-center">
                                <InputText style="width: 60px;text-align: center;margin: auto;"
                                    class="capitalize form-onboard-form form-control textbox " type="text"
                                    v-model="useLeave.leave_data.permission_total_time_in_minutes" readonly />

                            </div>
                        </div>
                        <!-- <div class="grid-cols-6" v-if="useLeave.leave_data.selected_leave === 'Permission'">
                    <p class="text-[#757575] my-2 font-normal text-[12px] font-['poppins'] ">Select Timings <span
                            class="text-danger">*</span></p>
                    <div class="flex  gap-4 mx-2">
                        <button class="w-[20px] h-[20px] rounded-full flex justify-center items-center bg-[#f6f6f6]"
                            :disabled="useLeave.leave_data.permission_total_time_in_minutes === 30" @click="decrementTime()">
                            <i class="pi pi-minus"></i>
                        </button>
                        <div>
                            <p>{{ useLeave.leave_data.permission_total_time_in_minutes }} &nbsp; Minutes</p>
                        </div>
                        <button :disabled="useLeave.leave_data.permission_total_time_in_minutes === 120"
                            class="w-[20px] h-[20px] rounded-full flex justify-center items-center bg-[#f6f6f6]"
                            @click="incrementTime()">
                            <i class="pi pi-plus"></i>
                        </button>
                    </div>

                </div> -->
                        <!-- MANAGER NOTIFICATION -->
                        <div class="col-span-6 grid-cols-6">
                            <!-- <p class="text-[#757575] flex gap-3 font-semibold text-[12px] font-['poppins'] p-1 box-border">
                                Notify to
                                Peers Groups <span class="text-[#e94545]"><strong>Not the Line Manager</strong></span></p>
                            <div class="col-span-6"> -->
                                <!-- <Dropdown :options="samplearr" optionLabel="managerName" placeholder="Select Manager"
                            class=" mx-2 box-border" v-model="useLeave.leave_data.notifyTo" :class="[
                                nm$.notifyTo.$error ? 'p-invalid' : '',
                            ]" /> -->
                                <!-- <MultiSelect filter v-model="useLeave.leave_data.notifyTo" display="chip"
                                    placeholder="Select Employee" class="w-full md:w-20rem"
                                    :options="useLeaveStore.leave_notify_to_dropdown" optionLabel="name" optionValue="id"> -->
                                    <!-- :options="managerArr" optionLabel="label" -->
                                    <!-- :class="[
                                nm$.notifyTo.$error ? 'p-invalid' : '',
                            ]" -->
                                    <!-- <template #optiongroup="slotProps">
                                        <div class="flex align-items-center">
                                            <div>{{ slotProps.option.label }}</div>
                                        </div>
                                    </template>
                                </MultiSelect>
                            </div> -->
                            <!-- {{ useLeave.leave_data.notifyTo }} -->


                        </div>

                        <!-- reason -->
                        <div class="col-span-6   ">
                            <p class="my-2 text-[#757575] font-semibold text-[12px] font-['poppins']">Reason<span
                                    class="text-danger">*</span></p>
                            <div class="mx-2">
                                <Textarea rows="3" placeholder="Your Comments" cols="50" class="p-3 box-border w-[100%]"
                                    v-model="useLeave.leave_data.leave_reason" :class="[
                                        r$.leave_reason.$error ? 'p-invalid' : '',
                                    ]" />

                            </div>
                            <span v-if="r$.leave_reason.$error" class="font-semibold text-red-400 fs-6">
                                {{ r$.leave_reason.$errors[0].$message }}
                            </span>
                        </div>
                        <!-- button -->
                        <div class="flex my-4 col-span-6 justify-center items-center gap-2    ">
                            <!-- <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                                @click=" useLeave.restChars()">Cancel</button> -->
                            <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                                @click="submitForm()">Submit</button>
                        </div>

                    </div>



                </div>





                <!-- end -->


                <div class="my-2 bg-orange-50 rounded-lg p-3 py-4 transition-all duration-700"
                    v-if="useTimesheet.classicAttendanceRegularizationDialog">
                    <div class="grid grid-cols-2 ">
                        <div class=""><label class="font-semibold fs-6 text-gray-700 ">Date</label></div>
                        <div class="">
                            <span class="text-ash-medium fs-15" id="current_date">
                             {{dayjs(currentlySelectedCellRecord.date).format('DD-MMM-YYYY') }}</span>

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
            <div v-else>
                <!-- {{ currentlySelectedCellRecord }} -->
                <div v-if="currentlySelectedCellRecord.absent_reg_status == 'Pending'" class="p-3 rounded-lg my-3"
                    :class="findAbsentStatus(currentlySelectedCellRecord.absent_reg_status)">
                    Absent Regularization applied successful <i
                        :class="icons(true, currentlySelectedCellRecord.absent_reg_status)" class="py-auto"
                        style="font-size: 1.2rem"></i>
                </div>
                <div v-else class="p-3 rounded-lg my-3"
                    :class="findAbsentStatus(currentlySelectedCellRecord.absent_reg_status)">
                    Absent Regularization {{ currentlySelectedCellRecord.absent_reg_status }} <i
                        :class="icons(true, currentlySelectedCellRecord.absent_reg_status)" class="py-auto"
                        style="font-size: 1.2rem"></i>
                </div>
                <div class="my-2 bg-orange-50 rounded-lg p-3 py-4 transition-all duration-700"
                    v-if="currentlySelectedCellRecord.absent_reg_checkin && currentlySelectedCellRecord.absent_reg_checkout">
                    <div class="grid grid-cols-2 ">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Date</label></div>
                        <div class="">
                            <span class="text-ash-medium fs-15" id="current_date">
                                {{ currentlySelectedCellRecord.date }}</span>
                            <input type="hidden" class="text-ash-medium form-control fs-15" name="attendance_date"
                                id="attendance_date">
                        </div>
                    </div>
                    <div class="grid grid-cols-2  my-4">
                        <div class="">
                            <label class="font-semibold fs-6 text-gray-700">Check In Time</label>
                        </div>
                        <div class="">
                            {{ currentlySelectedCellRecord.absent_reg_checkin }}
                        </div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Check Out Time</label>
                        </div>
                        <div class="">
                            {{ currentlySelectedCellRecord.absent_reg_checkout }}
                        </div>
                    </div>
                    <div v-if="currentlySelectedCellRecord.absent_reg_status != 'Pending'" class="grid grid-cols-2 my-4">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Approver name</label>
                        </div>
                        <div class="">
                            {{ currentlySelectedCellRecord.absent_approver_name }}
                        </div>
                    </div>
                    <div class="grid grid-cols-2"
                        :class="{ 'my-4': currentlySelectedCellRecord.absent_reg_status == 'Pending' }">
                        <div class=""><label class="font-semibold fs-6 text-gray-700">Reason</label></div>
                        <div>
                            {{ currentlySelectedCellRecord.absent_reg_reason }}
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
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-orange-50 p-3" v-if="!currentlySelectedCellRecord.isAbsent">
            <p class="font-sans font-bold fs-6">Check-in</p>
            <div class="my-2  ">
                <div class="grid grid-cols-6 gap-y-4">
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Date</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] whitespace-nowrap col-span-2">
                        {{ moment(currentlySelectedCellRecord.date).format('DD-MMM-YYYY') }}
                    </p>
                    <p class="font-medium text-[12px] text-gray-700 col-span-2 ">In Time</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-3">
                        {{ getProcessedCheckInTime(currentlySelectedCellRecord, true) }}</p>
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check In Mode</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-3">
                        {{ capitalizeFLetter(currentlySelectedCellRecord.attendance_mode_checkin) }}
                        <i v-if="currentlySelectedCellRecord.attendance_mode_checkin == 'mobile'"
                            class="fa fa-picture-o fs-6 cursor-pointer  animate-pulse"
                            @click="viewSelfieImage('checkin', currentlySelectedCellRecord.selfie_checkin)"
                            aria-hidden="true"></i>
                    </p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Check In Status</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] whitespace-nowrap col-span-2">{{
                            capitalizeFLetter(findCheckInStatus('checkin', currentlySelectedCellRecord)) }}
                    </p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Approval Status</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] col-span-2">
                        {{ findCheckInStatus('checkInStatus', currentlySelectedCellRecord) }}</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Remarks</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time"
                        class="font-semibold text-[12px] col-span-3">
                        {{ findRegularizeRemarks('checkin', currentlySelectedCellRecord) }}</p>

                    <p v-if="currentlySelectedCellRecord.selfie_checkin && currentlySelectedCellRecord.checkin_full_address"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Location</p>
                    <p v-if="currentlySelectedCellRecord.selfie_checkin && currentlySelectedCellRecord.checkin_full_address"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.selfie_checkin && currentlySelectedCellRecord.checkin_full_address"
                        class="font-semibold text-[12px] col-span-2">{{ currentlySelectedCellRecord.checkin_full_address }}
                    </p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-blue-50 p-3 my-3" v-if="!currentlySelectedCellRecord.isAbsent">
            <p class="font-sans font-bold text-[12px]">Check-out</p>
            <div class="my-2">
                <div class="grid grid-cols-6 my-1 gap-y-4">
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Date</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] whitespace-nowrap col-span-2">
                        {{ moment(currentlySelectedCellRecord.date).format('DD-MMM-YYYY') }}
                    </p>
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Out Time</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">
                        {{ getProcessedCheckOutTime(currentlySelectedCellRecord, true) }}
                    </p>
                    <p class="font-medium text-[12px] text-gray-700 col-span-2">Check Out Mode</p>
                    <p class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p class="font-semibold text-[12px] col-span-2">{{
                        capitalizeFLetter(currentlySelectedCellRecord.attendance_mode_checkout) }}
                        <i v-if="currentlySelectedCellRecord.attendance_mode_checkout == 'mobile'"
                            class="fa fa-picture-o text-[12px] cursor-pointer animate-pulse" aria-hidden="true"
                            @click="viewSelfieImage('checkout', currentlySelectedCellRecord.selfie_checkout)"></i>
                    </p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Check Out Status</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-2 whitespace-nowrap">{{ findCheckInStatus('checkout',
                            currentlySelectedCellRecord) }}</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Approval Status</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-2">{{ findCheckInStatus('checkOutStatus',
                            currentlySelectedCellRecord) }}</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Remarks</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time"
                        class="font-semibold text-[12px] col-span-2">{{ findRegularizeRemarks('checkout',
                            currentlySelectedCellRecord) }}</p>
                    <p v-if="currentlySelectedCellRecord.selfie_checkout && currentlySelectedCellRecord.checkout_full_address"
                        class="font-medium text-[12px] text-gray-700 col-span-2">Location</p>
                    <p v-if="currentlySelectedCellRecord.selfie_checkout && currentlySelectedCellRecord.checkout_full_address"
                        class="font-semibold text-[12px] col-span-1 text-center">:</p>
                    <p v-if="currentlySelectedCellRecord.selfie_checkout && currentlySelectedCellRecord.checkout_full_address"
                        class="font-semibold text-[12px] col-span-3">{{ currentlySelectedCellRecord.checkout_full_address }}
                    </p>
                </div>
            </div>
        </div>

        <p class="font-bold mx-2 my-3"
            v-if="currentlySelectedCellRecord.isLC || currentlySelectedCellRecord.isMIP || currentlySelectedCellRecord.isEG || currentlySelectedCellRecord.isMOP">
            Attendance regularization</p>

        <div class="bg-yellow-50 text-yellow-400 p-1 rounded-sm"
            v-if="currentlySelectedCellRecord.isLC && currentlySelectedCellRecord.is_Lc_Voided">
            <p class="font-bold mx-2 my-3 text-center">
                LC is voided
            </p>
        </div>
        <div v-if="currentlySelectedCellRecord.checkin_time && currentlySelectedCellRecord.checkout_time">
            <div v-if="!(currentlySelectedCellRecord.checkin_time > currentlySelectedCellRecord.shift_start_time) && !(currentlySelectedCellRecord.checkout_time < currentlySelectedCellRecord.shift_end_time) && !(currentlySelectedCellRecord.absent_reg_checkin && currentlySelectedCellRecord.absent_reg_checkout)"
                class="flex justify-center mx-auto my-2 w-60 p-1.5 bg-green-50 rounded-md">
                <p class="text-center font-semibold text-green-800 text-lg">Good job👍</p>
            </div>
        </div>
        <Accordion>
            <AccordionTab v-if="currentlySelectedCellRecord.isLC && !currentlySelectedCellRecord.is_Lc_Voided">
                <template #header>
                    <div class="grid grid-cols-2 w-full">
                        <span class="w-10/12 px-2 font-semibold fs-6 my-auto whitespace-nowrap">Late Coming</span>
                        <p class="text-right px-4"><i
                                :class="icons(currentlySelectedCellRecord.isLC, currentlySelectedCellRecord.lc_status)"
                                class="py-auto" style="font-size: 1.2rem"></i></p>
                    </div>
                </template>
                <AttendanceRegularization :source="useTimesheet.lcDetails" :type="'LC'" />
            </AccordionTab>
            <AccordionTab v-if="currentlySelectedCellRecord.isMIP">
                <template #header>
                    <div class="grid grid-cols-2 w-full">
                        <span class="w-10/12 px-2 font-semibold fs-6 my-auto whitespace-nowrap">Missed in punch</span>
                        <p class="text-right px-4"><i
                                :class="icons(currentlySelectedCellRecord.isMIP, currentlySelectedCellRecord.mip_status)"
                                class="py-auto" style="font-size: 1.2rem"></i></p>
                    </div>
                </template>
                <AttendanceRegularization :source="useTimesheet.mipDetails" :type="'MIP'" />
            </AccordionTab>
            <AccordionTab v-if="currentlySelectedCellRecord.isEG">
                <template #header>
                    <div class="grid grid-cols-2 w-full">
                        <span class="w-10/12 px-2 font-semibold fs-6 my-auto whitespace-nowrap">Early going</span>
                        <p class="text-right px-4"><i
                                :class="icons(currentlySelectedCellRecord.isEG, currentlySelectedCellRecord.eg_status)"
                                class="py-auto" style="font-size: 1.2rem"></i></p>
                    </div>
                </template>
                <AttendanceRegularization :source="useTimesheet.egDetails" :type="'EG'" />
            </AccordionTab>
            <AccordionTab v-if="currentlySelectedCellRecord.isMOP">
                <template #header>
                    <div class="grid grid-cols-2 w-full">
                        <span class="w-10/12 px-2 font-semibold fs-6 my-auto whitespace-nowrap">Missed out punch</span>
                        <p class="text-right px-4"><i
                                :class="icons(currentlySelectedCellRecord.isMOP, currentlySelectedCellRecord.mop_status)"
                                class="py-auto" style="font-size: 1.2rem"></i></p>
                    </div>
                </template>
                <AttendanceRegularization :source="useTimesheet.mopDetails" :type="'MOP'" />
            </AccordionTab>

        </Accordion>

    </Sidebar>

    <div ref="calendarContainer" class="min-h-full min-w-fit text-gray-800 card" v-if="singleAttendanceDay">
        <div class="min-w-max border  grid grid-cols-7  card-body ">
            <!-- Top navigation bar  -->
            <Top />

            <!-- Finding Days -->
            <div v-for="day in daysOfTheWeek" class="text-center text-sm md:text-base lg:text-lg font-semibold  py-2 border">
                {{ day.substring(0, 3) }}
            </div>

            <div v-if="firstDayOfCurrentMonth > 0" v-for="day in firstDayOfCurrentMonth" :key="day"
                class=" w-full border opacity-50 "></div>


            <!-- singleAttendanceDay Timesheet Data from current month  -->

            <div v-for="day in daysInCurrentMonth" :key="day" class=" h-16 py-3 shadow-sm  md:h-36 w-full border align-top "
                :class="{
                    'bg-slate-50 text-gray-600 font-medium': isToday(day),
                    'hover:bg-gray-100 hover:text-gray-700': !isToday(day),
                    'bg-gray-200': isWeekEndDays(day),
                }">


                <!-- EACH CELL -->
                <div v-if="currentMonthSingleAttendanceDay(day, singleAttendanceDay).length"
                    v-for="singleAttendanceDay in currentMonthSingleAttendanceDay(day, singleAttendanceDay)"
                    class="hidden md:block"
                    @click="(!singleAttendanceDay.attendance_status && !singleAttendanceDay.isAbsent && !singleAttendanceDay.is_sandwich_applicable && !singleAttendanceDay.leave_status)
                        ? getSelectedCellValues(singleAttendanceDay) : (singleAttendanceDay.is_week_off || isWeekEndDays(day)) && !singleAttendanceDay.is_sandwich_applicable ? '' : !singleAttendanceDay.leave_status ? getSelectedCellValues(singleAttendanceDay) : ''">

                    <div>
                        <div
                            class="w-full h-full text-xs md:text-sm lg:text-base text-left transition-colors font-semibold relative">
                            <div class="flex justify-center relative">
                                <p class="mx-3 font-semibold text-sm">{{ dayjs(singleAttendanceDay.date).format('D') }}<span class=" absolute top-2 right-2  font-['poppins'] text-sm " >{{singleAttendanceDay.workshift_code }}</span></p>
                            </div>
                            <!-- Week end -->
                            <div v-if="isWeekEndDays(day) && !singleAttendanceDay.is_sandwich_applicable"
                                class=" flex justify-center items-center bg-gray-200">
                                <p v-if="singleAttendanceDay.isAbsent"
                                    class="px-auto font-semibold  fs-6  text-black text-center py-5">Week
                                    Off
                                </p>
                                <div v-else-if="singleAttendanceDay.is_sandwich_applicable"
                                    class="w-full my-3  p-2.5  rounded-sm mr-3 flex font-semibold"
                                    style="max-width: 140px;" :class="findAttendanceStatus(singleAttendanceDay)">
                                    <p v-if="singleAttendanceDay.isAbsent">Absent</p>
                                    <img src="../timesheet/assests/sandwich_policy_icon.png" alt="" class="w-25 h-25">
                                </div>
                            </div>
                            <div class="my-3 " v-else-if="(!isWeekEndDays(day) && singleAttendanceDay.is_week_off)">
                                <div class="p-2 bg-green-50 text-green-600 font-medium mr-6">
                                    <p class="font-semibold text-green-700 text-center text-[12px] ">
                                        Week Off
                                    </p>
                                </div>
                            </div>
                            <!-- check doj is intermediate of month-->
                            <div v-else-if="singleAttendanceDay.is_sandwich_applicable"
                                class="w-full my-3  p-2.5  rounded-sm mr-3 flex font-semibold " style="max-width: 140px;"
                                :class="findAttendanceStatus(singleAttendanceDay)">
                                <p v-if="singleAttendanceDay.isAbsent">Absent</p>
                                <img src="../timesheet/assests/sandwich_policy_icon.png" alt="" class="w-25 h-25">
                            </div>
                            <div v-else-if="singleAttendanceDay.leave_status"
                                class="w-full my-3  p-2.5  rounded-sm mr-3 flex font-semibold " style="max-width: 140px;"
                                :class="findAttendanceStatus(singleAttendanceDay)">
                                <p>{{ singleAttendanceDay.leave_type + " " + singleAttendanceDay.leave_status }}</p>

                            </div>
                            <div v-else-if="singleAttendanceDay.attendance_status"
                                class="flex  justify-center items-center">
                                <p v-if="!singleAttendanceDay.isAbsent"
                                    class="px-auto font-semibold  fs-6  text-black text-center py-5">NA
                                </p>
                            </div>

                            <div v-else @click=" find(singleAttendanceDay)  == 'Absent' ? (useLeave.get_leave_types(useTimesheet.selected_user_code),useLeave.getLeaveRestrictDates() , useLeave.leave_apply_role_type = 2,useLeave.restChars() ) :''  "
                                class=" py-1 flex space-x-1 items-center  overflow-hidden  hover: cursor-pointer rounded-sm hp"
                                :class="[find(singleAttendanceDay).length > 20 ? 'whitespace-normal' : 'whitespace-nowrap']">

                                <div v-if="isFutureDate(day)"
                                    class="w-full my-3  p-2.5  rounded-sm mr-3 flex font-semibold  "
                                    style="max-width: 140px;" :class="findAttendanceStatus(singleAttendanceDay)">
                                    <!-- <p class="font-sans w-2"> <i class="text-green-800 font-semibold text-sm"
                                            :class="findAttendanceMode(singleAttendanceDay.attendance_mode_checkin)"></i>
                                    </p> -->
                                 <!-- {{   find(singleAttendanceDay)  == 'Absent'? 'sad':'pradeesh'}} -->
                                    <p class="font-sans fs-6  mx-2">{{ find(singleAttendanceDay) }}

                                        <i v-if="singleAttendanceDay.isLC"
                                            :class="icons(singleAttendanceDay.isLC, singleAttendanceDay.lc_status)"
                                            style="font-size: 0.9rem" class="px-1"></i>
                                        <i v-else-if="singleAttendanceDay.isMIP"
                                            :class="icons(singleAttendanceDay.isMIP, singleAttendanceDay.mip_status)"
                                            style="font-size: 0.9rem" class="px-1"></i>
                                        <i v-else-if="singleAttendanceDay.isEG"
                                            :class="icons(singleAttendanceDay.isEG, singleAttendanceDay.eg_status)"
                                            style="font-size: 0.9rem" class="px-1"></i>
                                        <i v-else-if="singleAttendanceDay.isMOP"
                                            :class="icons(singleAttendanceDay.isMOP, singleAttendanceDay.mop_status)"
                                            style="font-size: 0.9rem" class="px-1"></i>
                                        <i v-else-if="singleAttendanceDay.absent_reg_checkin && singleAttendanceDay.absent_reg_checkout"
                                            :class="icons(singleAttendanceDay.isAbsent && singleAttendanceDay.absent_reg_status, singleAttendanceDay.absent_reg_status)"
                                            style="font-size: 0.9rem" class="px-1"></i>
                                    </p>
                                </div>

                            </div>
                            <div v-if="!singleAttendanceDay.isAbsent"
                                class="hop  transition p-2 ease-in-out delay-150 bg-white border rounded-lg absolute  z-50">
                                <div
                                    class="w-full my-3  p-2.5  rounded-sm mr-3 flex  border-l-4 border-green-500 bg-green-50 text-green-600 font-medium fs-5">
                                    <i class="fa fa-arrow-down text-green-800  font-medium text-sm "
                                        style='transform: rotate(-45deg);'></i>
                                    <p class="bg-blue-50 text-blue-600   font-sans font-semibold text-sm mx-1"
                                        v-if="singleAttendanceDay.isMIP">
                                        MIP
                                    </p>
                                    <p class="text-green-800 font-sans font-semibold text-sm mx-1" v-else>
                                        {{ getProcessedCheckInTime(singleAttendanceDay, false) }}
                                    </p>
                                </div>
                                <div class="w-full my-3  p-2.5  rounded-sm mr-3 flex  border-l-4  font-medium fs-5 "
                                    :class="singleAttendanceDay.isMOP ? 'bg-blue-50 text-blue-600' : 'border-red-500 bg-red-50 text-red-600'">
                                    <i class="fa fa-arrow-down font-medium text-sm text-red-800 "
                                        style='transform: rotate(230deg);'></i>
                                    <!-- :class="" -->
                                    <p class="bg-blue-50 text-blue-600   font-sans font-semibold text-sm mx-1"
                                        v-if="singleAttendanceDay.isMOP">
                                        MOP
                                    </p>
                                    <p class="text-red-800  font-sans font-semibold text-sm mx-1" v-else>
                                        {{ getProcessedCheckOutTime(singleAttendanceDay, false) }}
                                    </p>

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
                        stroke="currentColor" class="w-5 h-5 cursor-pointer transition-all"
                        @click="calendarStore.decrementMonth(1)">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 cursor-pointer transition-all"
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
import { ref, onMounted, onUpdated, watch ,computed } from "vue";
import Top from "./components/Top.vue"
import { useCalendarStore } from './stores/calendar.js';
import { useAttendanceTimesheetMainStore } from './stores/attendanceTimesheetMainStore'
import dayjs from "dayjs";
import moment from "moment";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { Service } from "../../Service/Service.js";
import AttendanceRegularization from './components/ClassicAttendanceRegularizationSidebar.vue'
import { useLeaveService } from "../../leave_module/leave_apply/leave_apply_service";;
import { useLeaveModuleStore} from '../../leave_module/LeaveModuleService';
import LoadingSpinner from "../../../components/LoadingSpinner.vue";

const useLeave = useLeaveService();
const useLeaveStore = useLeaveModuleStore();

const currentlySelectedCellRecord = ref({})

const useTimesheet = useAttendanceTimesheetMainStore()
const service = Service()
const visibleRight = ref(false)


watch(
    () => useTimesheet.canShowSidebar, // Watch changes in route parameters
    (newParams, oldParams) => {
        if (oldParams) {
            // console.log("newParams" + newParams);
            // console.log("oldParams" + oldParams);
            visibleRight.value = newParams
        }
    }
);

function currentlySelectedCellRecord_date(){

    console.log(currentlySelectedCellRecord.value.date);

    console.log( dayjs(currentlySelectedCellRecord.value.date).format('DD-MMM-YYYY'), Date(dayjs(currentlySelectedCellRecord.value.date).format('DD-MMM-YYYY')) ,'testing date :: ');

    useLeave.leave_data.half_day_leave_date = new Date(dayjs(currentlySelectedCellRecord.value.date).format('DD-MMM-YYYY'));
    useLeave.leave_data.full_day_leave_date = new Date(dayjs(currentlySelectedCellRecord.value.date).format('DD-MMM-YYYY'));
    useLeave.leave_data.custom_start_date = new Date(dayjs(currentlySelectedCellRecord.value.date).format('DD-MMM-YYYY'));
}



// const toCloseSideBar = (val) => {
//     console.log(val);
//     visibleRight.value = val
// }



const viewSelfieImage = (isSelected, selectedCells) => {
    useTimesheet.dialog_Selfie = true
    if (isSelected == 'checkin') {
        useTimesheet.selfieDetails = selectedCells
    } else
        if (isSelected == 'checkout') {
            useTimesheet.selfieDetails = selectedCells
        } else {
            useTimesheet.selfieDetails = ''
        }

}




const getSelectedCellValues = (selectedCells) => {
    // useTimesheet.classicTimesheetSidebar = true
    visibleRight.value = true
    useTimesheet.canShowSidebar = true
    console.log(selectedCells);
    if (useTimesheet.currentlySelectedTimesheet == 2 || useTimesheet.currentlySelectedTimesheet == 3) {
        useTimesheet.CurrentlySelectedUser = selectedCells.user_code
    }
    currentlySelectedCellRecord.value = { ...selectedCells }
    if (selectedCells.isLC) {
        useTimesheet.lcDetails = { ...selectedCells }
        useTimesheet.AttendanceLateOrMipRegularization = selectedCells.shift_start_time
    }
    if (selectedCells.isEG) {
        useTimesheet.egDetails = { ...selectedCells }
        useTimesheet.AttendanceEarylOrMopRegularization = selectedCells.shift_end_time
    }
    if (selectedCells.isMIP) {
        useTimesheet.mipDetails = { ...selectedCells }
        useTimesheet.AttendanceLateOrMipRegularization = selectedCells.shift_start_time
    }
    if (selectedCells.isMOP) {
        useTimesheet.mopDetails = { ...selectedCells }
        useTimesheet.AttendanceEarylOrMopRegularization = selectedCells.shift_end_time
    }
    if (selectedCells.isAbsent) {
        useTimesheet.absentRegularizationDetails = { ...selectedCells }
        useTimesheet.absentRegularizationDetails.start_time = selectedCells.shift_start_time
        useTimesheet.absentRegularizationDetails.end_time = selectedCells.shift_end_time
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
        if (data.isAbsent && data.absent_reg_status.includes('Pending')) {
            return ` Absent Regularization`
        } else
            if (data.isAbsent && data.absent_reg_status.includes('Rejected')) {
                return ` Absent Regularization`
            } else
                if (data.isAbsent && data.absent_reg_status.includes('Approved')) {
                    return ` Absent Regularization`
                }
                else
                    if (data.isAbsent && data.is_holiday) {
                        return data.is_holiday == false ? 'Absent' : `${data.holiday_name} Holiday`
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

const props = defineProps({
    singleAttendanceDay: {
        type: Object,
        required: true,
    },
    sidebar: {
        type: Boolean,
        required: true
    }

});

const findAttendanceRegularizationStatus = (data) => {
    if (data.isLc) {
        if (data.lc_status.includes('Approved')) {
            return ' bg-green-50 text-green-600  fs-6 rounded-lg'
        } else
            if (data.lc_status.includes('Rejected')) {
                return ' bg-red-50 text-red-600  fs-6 rounded-lg'
            } else
                if (data.lc_status.includes('Pending')) {
                    return 'border-yellow-500 bg-yellow-50 text-yellow-600  fs-6 rounded-lg'
                } else
                    if (data.lc_status.includes('Revoked')) {
                        return ' bg-gray-50 text-gray-600  fs-6 rounded-lg'
                    }
                    else
                        if (data.lc_status.includes('None')) {
                            return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                        }
    } else
        if (data.isMIP) {
            if (data.mip_status.includes('Approved')) {
                return ' bg-green-50 text-green-600  fs-6 rounded-lg'
            } else
                if (data.mip_status.includes('Rejected')) {
                    return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                } else
                    if (data.mip_status.includes('Pending')) {
                        return 'border-yellow-500 bg-yellow-50 text-yellow-600  fs-6 rounded-lg'
                    } else
                        if (data.mip_status.includes('Revoked')) {
                            return ' bg-gray-50 text-gray-600  fs-6 rounded-lg'
                        }
                        else
                            if (data.mip_status.includes('None')) {
                                return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                            }
        } else
            if (data.isEG) {
                if (data.eg_status.includes('Approved')) {
                    return ' bg-green-50 text-green-600  fs-6 rounded-lg'
                } else
                    if (data.eg_status.includes('Rejected')) {
                        return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                    } else
                        if (data.eg_status.includes('Pending')) {
                            return 'border-yellow-500 bg-yellow-50 text-yellow-600  fs-6 rounded-lg'
                        } else
                            if (data.eg_status.includes('Revoked')) {
                                return ' bg-gray-50 text-gray-600  fs-6 rounded-lg'
                            }
                            else
                                if (data.eg_status.includes('None')) {
                                    return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                                }
            } else
                if (data.isMOP) {
                    if (data.mop_status.includes('Approved')) {
                        return ' bg-green-50 text-green-600  fs-6 rounded-lg'
                    } else
                        if (data.mop_status.includes('Rejected')) {
                            return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                        } else
                            if (data.mop_status.includes('Pending')) {
                                return 'border-yellow-500 bg-yellow-50 text-yellow-600  fs-6 rounded-lg'
                            } else
                                if (data.mop_status.includes('Revoked')) {
                                    return ' bg-gray-50 text-gray-600  fs-6 rounded-lg'
                                }
                                else
                                    if (data.mop_status.includes('None')) {
                                        return ' bg-red-50 text-red-600  fs-6 rounded-lg'
                                    }
                }


}



function capitalizeFLetter(name) {
    if (name) {
        let result = name.charAt(0).toUpperCase() +
            name.slice(1)
        return result
    }

}

const leaveShortFormat = (leave_type) => {
    if (leave_type == 'Sick Leave / Casual Leave') {
        return SL / CL
    } else {
        return leave_type
    }

}






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
const isDojlessThanToday = (data) => {

    if (data.attendance_status) {
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

// const getSession = (time) => {

//     let output_timeformat = 'h:mm a';

//     if)
//         output_timeformat = 'h:mm:ss a'

//     let timeFormat = time == null ? "--:--:--" : moment(
//         time, ["HH:mm"]).format(output_timeformat);

//     return timeFormat
// };

function getSession(time) {
    if (time) { // Split the time into hours, minutes, and seconds
        var timeArray = time.split(':');
        // Extract hours, minutes, and seconds
        var hours = parseInt(timeArray[0]);
        var minutes = timeArray[1];
        var seconds = timeArray[2];
        // Determine AM or PM
        var period = hours >= 12 ? 'PM' : 'AM';
        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be converted to 12
        // Format the time in 12-hour format
        var formattedTime = hours + ':' + minutes + ':' + seconds + ' ' + period;
        return formattedTime;
    } else {
        return "--:--:--"
    }
}




/*
    Checks and returns the checkin time .
        1. If LC/MIP is done, returns LC/MIP regularized time.
        2. Else return the 'checkin_time'.

*/
function getProcessedCheckInTime(t_singleAttendanceDay) {

    if (t_singleAttendanceDay.lc_status == 'Approved') {
        return getSession(t_singleAttendanceDay.lc_regularized_time);
    }
    else
        if (t_singleAttendanceDay.mip_status == 'Approved') {
            return getSession(t_singleAttendanceDay.mip_regularized_time);
        }
        else {
            return getSession(t_singleAttendanceDay.checkin_time);
        }
}


/*
    Checks and returns the checkin time .
        1. If EG/MOP is approved, returns those regularized time.
        2. Else return the 'checkout_time'.

*/
function getProcessedCheckOutTime(t_singleAttendanceDay) {

    if (t_singleAttendanceDay.eg_status == 'Approved') {
        return getSession(t_singleAttendanceDay.eg_regularized_time);
    }
    else
        if (t_singleAttendanceDay.mop_status == 'Approved') {
            return getSession(t_singleAttendanceDay.mop_regularized_time);
        }
        else {
            return getSession(t_singleAttendanceDay.checkout_time);
        }
}


const isNumber = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[0-9:]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
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
const currentMonthSingleAttendanceDay = (day, singleAttendanceDay) => {
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

//  start


const visible = ref(false)
const leave_types = ref();
const sidebarnew = ref(false)
const fulldate = ref();
const fulldatenew = ref();
const full_half_custom = ref('')
const day = ref('');
const dayone = ref('');

let start_date = '12-12-2023'
let end_date = '01-12-2023'
let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();
let prevMonth = (month === 0) ? 11 : month - 1;
let prevYear = (prevMonth === 11) ? year - 1 : year;
let nextMonth = (month === 11) ? 0 : month + 1;
let nextYear = (nextMonth === 0) ? year + 1 : year;

const date = ref();
const minDate = ref(new Date());
const maxDate = ref(new Date());

minDate.value.setMonth(prevMonth);
minDate.value.setFullYear(prevYear);
maxDate.value.setMonth(nextMonth);
maxDate.value.setFullYear(nextYear);

const Leavevisible = ref(false);






const rules = computed(() => {
    return {
        selected_leave: { required: helpers.withMessage('Leave Type is Required', required) },

    }
}

)

const full_day_rules = computed(() => {
    return {
        radiobtn_full_day: { required: helpers.withMessage('Full Day Date is Required', required) },
        full_day_leave_date: { required: helpers.withMessage('Full Day Date is Required', required) },
    }
})

const half_day_rules = computed(() => {
    return {
        half_day_leave_session: { required: helpers.withMessage('Session is Required', required) },
        half_day_leave_date: { required: helpers.withMessage('Half Day Date is Required', required) },
        radiobtn_half_day: { required: helpers.withMessage('Half Day Date is Required', required) },

    }
})

const custom_day_rules = computed(() => {
    return {
        radiobtn_custom: { required },
        custom_start_date: { required: helpers.withMessage('Start Date is Required', required) },
        custom_end_date: { required: helpers.withMessage('End Date is Required', required) },
        custom_start_day_session: { required: helpers.withMessage('Session is Required', required) },
        custom_end_day_session: { required: helpers.withMessage('Session is Required', required) },
        custom_total_days: { required: helpers.withMessage('Total Days is Required', required) }
    }
})
const reason_rules = computed(() => {
    return {
        leave_reason: { required: helpers.withMessage('Reason is Required', required) },
    }
})


const permissionRules = computed(() => {
    return {
        permission_date: { required: helpers.withMessage('Date is Required', required) },
        // permission_session: { required: helpers.withMessage('Session is Required', required) },
        permission_start_time: { required: helpers.withMessage('Start Time is Required', required) },
        permission_end_time: { required: helpers.withMessage('End Time is Required', required) },
        permission_total_time_in_minutes: { required: helpers.withMessage('Timings is Required', required) }
    }
})

// const notifyrules = computed(() => {
//     return {
//         notifyTo: { required: helpers.withMessage('Employee is Required', required) },
//     }
// })
//Todo : Wrote this but its not triggering correctly in vue-validate. Kept for future use
const computeCheckMinPermissionDuration = (value) => {
    console.log("Invoked computeCheckMinPermissionDuration() : " + value);

    if (value <= 120) {
        console.log("Not Error : Perm min <= 120");
        return true
    } else {
        console.log("Error : Perm min > 120");
        return false
    }
}
const samplearr = ref([
    {
        id: '1',
        managerName: 'manager1',
    },
    {
        id: '2',
        managerName: 'manager2',
    }, {
        id: '3',
        managerName: 'manager3',
    }
])
const compNegative = (value) => {
    if (value < 0) {
        return false
    } else {
        return true
    }
}
const compen_day_rules = computed(() => {
    return {
        selected_compensatory_leaves: { required: helpers.withMessage('Value is Required', required) },//This refers to comp days selected in dropdown
        compensatory_leaves_dates: { required: helpers.withMessage('Date is Required', required) },
        // compensatory_start_date: { required :helpers.withMessage('Start Date is Required',required) },
        compensatory_total_days: { required, compNegative: helpers.withMessage('days not lesser than zero', compNegative) },
        // compensatory_end_date: { required :helpers.withMessage('End Date is Required',required) },

    }
})
const f$ = useValidate(full_day_rules, useLeave.leave_data)
const h$ = useValidate(half_day_rules, useLeave.leave_data)
const c$ = useValidate(custom_day_rules, useLeave.leave_data)
const cp$ = useValidate(compen_day_rules, useLeave.leave_data)
const r$ = useValidate(reason_rules, useLeave.leave_data)
const p$ = useValidate(permissionRules, useLeave.leave_data)
const v$ = useValidate(rules, useLeave.leave_data)
// const nm$ = useValidate(notifyrules, service.leave_data)



const submitForm = () => {
    console.log(useTimesheet.selected_user_code == service.current_user_code);
    v$.value.$validate() // checks all inputs
    f$.value.$validate()
    h$.value.$validate()
    c$.value.$validate()
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log(useLeave.leave_data.selected_leave);


        if (useLeave.leave_data.selected_leave.includes('Compensatory')) {
            cp$.value.$validate()
            if (!cp$.value.$error) {
                // if ANY fail validation
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log(useTimesheet.selected_user_code);
                    useLeave.Submit(useTimesheet.selected_user_code == service.current_user_code ? 'applyleave' :'')
                    r$.value.$reset()
                    cp$.value.$reset()
                    v$.value.$reset()

                }

                console.log('Form successfully submitted.')
            } else {
                console.log('Form failed validation')
            }
        }

        if (useLeave.leave_data.radiobtn_full_day == "full_day") {
            f$.value.$validate()
            // f$.value.$reset()
            if (!f$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log(useTimesheet.selected_user_code);
                    useLeave.Submit(useTimesheet.selected_user_code == service.current_user_code ? 'applyleave' :'' )
                    r$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    visibleRight.value = false

                }
                else {
                    console.log('Reason Validation Error')
                }

                // }
            } else {
                console.log('Form failed validation')
            }
        }

        else if (useLeave.leave_data.radiobtn_half_day == "half_day") {
            h$.value.$validate()
            if (!h$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log('Half Day');
                    console.log(useTimesheet.selected_user_code);
                    useLeave.Submit(useTimesheet.selected_user_code == service.current_user_code ? 'applyleave' :'')
                    r$.value.$reset()
                    // h$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    useLeave.value = false

                }
                else {
                    console.log('Reason Validation Error')
                }

                // }



            } else {
                console.log('Form failed validation')
            }
        }
        else if (useLeave.leave_data.radiobtn_custom === "custom") {
            c$.value.$validate()

            if (!c$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log(useTimesheet.selected_user_code);
                    useLeave.Submit(useTimesheet.selected_user_code == service.current_user_code ? 'applyleave' :'')
                    r$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    visibleRight.value = false
                }
                else {
                    console.log('Reason Validation Error')
                }


                // }
            } else {
                console.log('Form failed validation')
            }
        }
        if (useLeave.leave_data.selected_leave.includes('Permission')) {
            p$.value.$validate()

            if (!p$.value.$error) {
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log(useTimesheet.selected_user_code);
                    useLeave.Submit(useTimesheet.selected_user_code == service.current_user_code ? 'applyleave' :'')
                    r$.value.$reset()
                    p$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    visibleRight.value = false
                }
                else {
                    console.log('Reason Validation Error')
                }
                // }
            } else {
                console.log('Form failed validation')
            }

        }
    } else {
        console.log('Form failed validation')
    }

}


const leaveRules = computed(() => {
    return {
        selected_leave: { required: helpers.withMessage('Leave Type is Required', required) },
        custom_total_days: { required: helpers.withMessage('Total Days is Required', required) },
        leave_reason: { required: helpers.withMessage('Reason is Required', required) },
        custom_start_date: { required: helpers.withMessage('Start Date is Required', required) },
        custom_end_date: { required: helpers.withMessage('End Date is Required', required) },
        radiobtn_full_day: { required },
        radiobtn_custom: { required },
        radiobtn_half_day: { required },
        half_day_leave_session: { required: helpers.withMessage('Session is Required', required) },
        full_day_leave_date: { required: helpers.withMessage('Full Day Date is Required', required) },
        half_day_leave_date: { required: helpers.withMessage('Half Day Date is Required', required) },
        custom_start_day_session: { required: helpers.withMessage('Session is Required', required) },
        custom_end_day_session: { required: helpers.withMessage('Session is Required', required) },
    }
})
const leaveV$ = useValidate(leaveRules, useLeave.leave_data)
const leaveValidate = () => {
    leaveV$.value.$validate()
    console.log(leaveV$)
    console.log(leaveV$.value)
    console.log(useLeave.leave_data)
    if (!leaveV$.value.$error) {
        // if ANY fail validation
        useLeave.Submit();
        // sidebarnew.value = false
        console.log('Form successfully submitted.')
        sidebarnew.value = false;
        console.log(useLeave.leave_data, 'service.leave_data');
        resetValidators()
        // leaveV$.value.$reset()

    }
    else {
        console.log('Form failed validation')
        console.log(service.leave_data)
    }

}
const resetValidators = () => {
    // service.leave_data.leave_reason=''
    // service.leave_data.custom_total_days=''
    // service.leave_data.custom_start_date=''
    // service.leave_data.custom_end_date=''
    // service.leave_data.selected_leave=''
    // service.leave_data.radiobtn_custom=''
    // service.leave_data.radiobtn_full_day=''
    // service.leave_data.radiobtn_half_day=''
    // service.leave_data.half_day_leave_session=''
    // service.leave_data.custom_start_day_session=''
    // service.leave_data.custom_end_day_session=''
    useLeave.restChars()

    r$.value.$reset();
    c$.value.$reset();
    h$.value.$reset()
    f$.value.$reset()
    v$.value.$reset()


}



</script>

<style>
.hop
{
    display: none;
    width: 150px;
    top: 80px;
    left: 25px;
    z-index: 9999;
}

.hp:hover+.hop
{
    display: block;
}



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
}

.swal2-container .swal2-center .swal2-backdrop-show{
    z-index: 100000 !important;
}
</style>
