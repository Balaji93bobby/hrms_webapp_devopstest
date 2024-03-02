<template>
    <Toast />


    <div class="flex gap-3">
    {{ useLeaveStore.leave_apply_role_type  }}
        <div class="mb-2 flex justify-end items-end gap-0">
            <!-- <label for="" class="my-2 text-lg font-semibold">Select Month</label> -->
            <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
            <Calendar view="month" dateFormat="MM-yy" class="mx-4 border-[#535353]  border-[1px] w-[200px] "
                v-model="useLeaveStore.selectedLeaveMonth" style=" border-radius: 7px; height: 30px;"
                @date-select="useLeaveStore.leaveBalMonthFilter()" />
        </div>
        <button
            class="flex justify-center items-center gap-[10px] font-['poppins'] text-[white] bg-[#000] py-2 px-4 text-[12px] font-semibold rounded-lg"
            @click="sidebarnew = true, service.getLeaveRestrictDates() ,service.restChars()">
            <i class="pi pi-plus text-[#ffff]"></i>
            Apply Leave
        </button>
    </div>


    <!-- <button class=" text-[white] bg-[#000] py-2 px-4 text-[10px] font-semibold rounded-lg" @click="service.leaveApplyDailog = true" >Apply Leave</button> -->
    <!-- <Button label="Apply Leave" class=" border-0 outline-none font-medium text-[2px] bg-black"  /> -->
    <!-- <Transition name="modal" >
        <ABS_loading_spinner v-if="service.data_checking" />
    </Transition> -->
    <Dialog header="Header" v-model:visible="service.data_checking" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>
    <Dialog header="Header" v-model:visible="service.Email_Service" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">

        <template #header>
            <h5 class="m-auto">Leave applied Successfully</h5>
        </template>
        <template #footer>
            <div class="text-center">
                <Button label="OK" style="justify-content: center;" severity="help" @click="service.ReloadPage" raised
                    class="justify-content-center" />
            </div>
        </template>
    </Dialog>
    <Dialog header="Header" v-model:visible="service.Email_Error" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">

        <template #header>
            <h5 class="m-auto"> {{ service.leave_data.leave_request_error_messege }}</h5>
        </template>
        <template #footer>
            <div class="text-center">
                <Button label="OK" style="justify-content: center;" severity="help" @click="service.Email_Error = false"
                    raised class="justify-content-center" />
            </div>
        </template>
    </Dialog>


    <!-- Leave apply dailog -->





    <!-- new design sidebar -->

    <Sidebar v-model:visible="sidebarnew" position="right"  :style="{ width: '30vw !important' }">

        <!-- <template #header>
            <div class="flex justify-center w-[300px] bg-black">
                <Avatar image="/images/avatar/amyelsner.png" shape="circle" />
                <span class="font-bold text-[white]">Leave Request</span>
            </div>
        </template> -->
        <template #header>
            <div class=" bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold">Leave Request </h1>
            </div>
        </template>

        <div class=" box-border ">
            <!-- <p class="text-[14px] font-semibold font-['poppins'] mb-4 py-1">Leave Request</p> -->
            <div class="bg-[#FFF4E3] p-4 box-border border-1 border-[#DDDDDD]  rounded-lg grid-cols-6 ">
                <!-- leave type -->
                <div class="  col-span-6">
                    <p class="text-[#757575] text-[12px] font-['poppins'] p-1 box-border font-semibold ">Choose Leave
                        Type<span class="text-danger">*</span></p>
                    <div class=" flex justify-content-center box-border">
                        <Dropdown class=" h-[30px] w-full  flex justify-center items-center"
                            v-model="service.leave_data.selected_leave" :options="service.leave_types"
                            optionLabel="leave_type" optionValue="leave_value" placeholder="Select Leave Type" :class="[
                                v$.selected_leave.$error ? 'p-invalid' : '',
                            ]" @change="service.checkLeaveEligibility(service.leave_data.selected_leave)" />

                    </div>
                    <span v-if="v$.selected_leave.$error" class="font-semibold text-red-400 fs-6">
                        {{ v$.selected_leave.$errors[0].$message }}
                    </span>
                </div>
                <!-- no of days -->
                <div class="py-2 box-border col-span-6"
                    v-if="!service.leave_data.selected_leave.includes('Permission') && !service.leave_data.selected_leave.includes('Compensatory Off')">
                    <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">No of days<span
                            class="text-danger">*</span></p>
                    <!-- {{ service.leave_data.radiobtn_full_day }} -->
                    <div class="flex text-sm m-2 gap-6">
                        <div class="form-check form-check-inline ">

                            <input style="height: 15px;width: 15px;" class="form-check-input border-2 border-gray-500   "
                                :disabled="service.check_full_day === false" type="radio" name="leave1" value="full_day"
                                id="full_day" :value="'full_day'" v-model="service.leave_data.radiobtn_full_day"
                                @click=" service.leave_data.radiobtn_half_day = '', service.leave_data.radiobtn_custom = '', h$.$reset(), c$.$reset()"
                                :class="[
                                    f$.radiobtn_full_day.$error ? 'p-invalid' : '',
                                ]">

                            <label class=" ms-1 font-normal text-[12px] font-['poppins']" for="full_day">Full Day</label>

                        </div>
                        <div class="form-check form-check-inline">
                            <!-- {{ service.leave_data.radiobtn_half_day }} -->
                            <input style="height: 15px;width: 15px;" class="form-check-input  border-2 border-gray-500 "
                                type="radio" name="leave1" value="half_day" id="half_day" :value="'half_day'"
                                v-model="service.leave_data.radiobtn_half_day" :disabled="service.check_half_day === false"
                                @click=" f$.$reset(), c$.$reset(), service.leave_data.radiobtn_custom = '', service.leave_data.radiobtn_full_day = ''"
                                :class="[
                                    h$.radiobtn_half_day.$error ? 'p-invalid' : '',
                                ]">

                            <label class=" ms-1 font-normal text-[12px] font-['poppins']  " for="half_day">Half Day</label>

                        </div>
                        <div class="form-check form-check-inline">
                            <!-- {{ service.leave_data.radiobtn_custom }} -->
                            <input style="height: 15px;width: 15px;" class="form-check-input  border-2 border-gray-500  "
                                :disabled="service.check_custom_day === false" type="radio" name="leave1" id="custom"
                                :value="'custom'" v-model="service.leave_data.radiobtn_custom"
                                @click=" service.leave_data.radiobtn_half_day = '', service.leave_data.radiobtn_full_day = '', h$.$reset(), f$.$reset()"
                                :class="[
                                    c$.radiobtn_custom.$error ? 'p-invalid' : '',
                                ]">

                            <label class=" ms-1 font-normal text-[12px] font-['poppins']  " for="custom">Custom</label>

                        </div>
                    </div>
                    <span v-if="f$.radiobtn_full_day.$error && h$.radiobtn_half_day.$error && c$.radiobtn_custom.$error"
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
                <div v-if="service.leave_data.radiobtn_half_day && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')"
                    class="py-1 col-span-6 ">
                    <p class="text-[#757575] text-[12px] font-['poppins'] font-semibold "> Date<span
                            class="text-danger">*</span></p>
                    <Calendar dateFormat="dd-mm-yy" :showIcon="true" v-model="service.leave_data.half_day_leave_date"
                        placeholder="Select Date" class="h-[38px] w-[130px] m-2 " :class="[
                            h$.half_day_leave_date.$error ? 'p-invalid' : '',
                        ]" :value="'half_day'" :minDate="new Date(service.before_date)"
                        @date-select="service.isRestrict(service.leave_data.half_day_leave_date)" />
                    <!-- :minDate="new Date()" -->
                    <span v-if="h$.half_day_leave_date.$error" class="font-semibold p-2 box-border  text-red-400 fs-6">
                        {{ h$.half_day_leave_date.$errors[0].$message }}
                    </span>
                </div>
                <!-- half day session -->
                <div v-if="service.leave_data.radiobtn_half_day && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')"
                    class="py-1 col-span-6">
                    <p class="text-[#757575] text-[12px] font-['poppins'] font-semibold "> Session<span
                            class="text-danger">*</span></p>
                    <div class="flex flex-wrap gap-3 m-2 ">
                        <div class="flex ">
                            <!-- {{ service.leave_data.half_day_leave_session }} -->
                            <input type="radio" id="fn" name="session" :value="'Forenoon'"
                                :disabled="service.leave_data.half_day_leave_date === ''"
                                class="h-5 form-check-input border-2 " style="height: 15px;width: 15px;"
                                v-model="service.leave_data.half_day_leave_session" :class="[
                                    h$.half_day_leave_session.$error ? 'p-invalid' : '',
                                ]" />
                            <label for="fn" class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Forenoon</label>
                        </div>
                        <div class="flex ">
                            <input type="radio" id="an" name="session" :value="'Afternoon'" class="h-5
                            form-check-input border-2 " style="height: 15px;width: 15px;"
                                :disabled="service.leave_data.half_day_leave_date === ''"
                                v-model="service.leave_data.half_day_leave_session" :class="[
                                    h$.half_day_leave_session.$error ? 'p-invalid' : '',
                                ]" />
                            <label for="an" class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Afternoon</label>
                        </div>
                        <span v-if="h$.half_day_leave_session.$error"
                            class="font-semibold p-2 box-border  text-red-400 fs-6">
                            {{ h$.half_day_leave_session.$errors[0].$message }}
                        </span>
                    </div>
                </div>
                <!-- full day -->
                <div v-if="service.leave_data.radiobtn_full_day && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')"
                    class="col-span-6">
                    <p class="text-[#757575] font-normal text-[12px] font-['poppins'] "> Date<span
                            class="text-danger">*</span></p>
                    <!-- {{ new Date(service.attendance_start_date +1) }} -->
                    {{ service.leave_restrict_dates.value }}
                    <Calendar dateFormat="dd-mm-yy"
                        @date-select="service.isRestrict(service.leave_data.full_day_leave_date)" :showIcon="true"
                        v-model="service.leave_data.full_day_leave_date" :minDate="new Date(service.before_date)"
                        placeholder="Select Date" class="h-[38px] w-[130px] m-2 " :class="[
                            f$.full_day_leave_date.$error ? 'p-invalid' : '',
                        ]">
                        <template>
                            <strong class=" text-[blue]"
                                v-if="service.leave_restrict_dates.value.includes(service.leave_data.full_day_leave_date)"
                                style="text-decoration: line-through !important">
                                {{ service.leave_data.full_day_leave_date }}
                            </strong>
                            <!--   v-if=" new Date(service.leave_restrict_dates.value.includes(service.leave_data.full_day_leave_date)) " -->
                            <template v-else>
                                {{ service.leave_data.full_day_leave_date }}
                            </template>
                        </template>
                    </Calendar>


                    <span v-if="f$.full_day_leave_date.$error" class="font-semibold p-2 box-border  text-red-400 fs-6">
                        {{ f$.full_day_leave_date.$errors[0].$message }}
                    </span>
                </div>
                <!-- start date -->
                <div v-if="service.leave_data.radiobtn_custom && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')"
                    class="col-span-6">
                    <p class="text-[#757575] font-semibold text-[12px] font-['poppins'] ">Start Date<span
                            class="text-danger">*</span></p>
                    <div class="flex py-2 ">
                        <Calendar dateFormat="dd-mm-yy" :showIcon="true" v-model="service.leave_data.custom_start_date"
                            placeholder="Select Date" class="h-[38px] w-[130px] mx-2 " :class="[
                                c$.custom_start_date.$error ? 'p-invalid' : '',
                            ]" :minDate="new Date(service.before_date)"
                            @date-select="service.isRestrict(service.leave_data.custom_start_date)" />

                        <div class="flex flex-wrap gap-3 ml-3 mt-2 ">
                            <div class="flex ">
                                <input type="radio" name="days1" value="Full day" id="startfull"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.custom_start_day_session" :class="[
                                        c$.custom_start_day_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="startfull" class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Full
                                    day</label>
                            </div>
                            <div class="flex ">
                                <input type="radio" name="days1" value="Forenoon" id="startfn"
                                    class="h-5 form-check-input border-2 " style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.custom_start_day_session" :class="[
                                        c$.custom_start_day_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="startfn"
                                    class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Forenoon</label>
                            </div>
                            <div class="flex ">
                                <input type="radio" name="days1" value="Afternoon" id="startan" class="h-5
                                form-check-input border-2 " style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.custom_start_day_session" :class="[
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
                <div v-if="service.leave_data.radiobtn_custom && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')"
                    class="py-3 col-span-6">
                    <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">End Date<span
                            class="text-danger">*</span></p>
                    <div class="flex py-2 ">
                        <Calendar dateFormat="dd-mm-yy" :showIcon="true" v-model="service.leave_data.custom_end_date"
                            placeholder="Select Date" class="h-[38px] w-[130px] mx-2 " :class="[
                                c$.custom_end_date.$error ? 'p-invalid' : '',
                            ]" :minDate="new Date(service.before_date)"
                            @date-select="service.isRestrict(service.leave_data.custom_end_date), service.dayCalculation()" />
                        <div class="flex flex-wrap gap-3 ml-3 text-sm mt-2">
                            <div class="flex ">
                                <input type="radio" name="days2" value="Full day"  @change="service.leave_data.custom_end_day_session ? service.addFullday() : ''" id="endfull"
                                    style="width:15px;height:15px;" class="h-5 form-check-input border-2"
                                    v-model="service.leave_data.custom_end_day_session" :class="[
                                        c$.custom_end_day_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="endfull" class="ml-2  ms-1 font-normal text-[12px] font-['poppins']">Full
                                    day</label>
                            </div>
                            <div class="flex ">
                                <input type="radio" name="days2" @change=" service.leave_data.custom_end_day_session ? service.addHalfday() : ''" value="Forenoon" id="endfn"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.custom_end_day_session" :class="[
                                        c$.custom_end_day_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="endfn"
                                    class="ml-2 ms-1 font-normal text-[12px] font-['poppins']  ">Forenoon</label>
                            </div>
                            <div class="flex ">
                                <input type="radio" name="days2" value="Afternoon" id="endan" class="h-5
                                form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.custom_end_day_session" :class="[
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
                    v-if="service.leave_data.radiobtn_custom && service.leave_data.selected_leave !== 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')">
                    <p class="text-[#757575] font-semibold text-[12px] font-['poppins']">Total Days</p>

                    <InputText style="width: 60px;text-align: center;margin: auto;"
                        class="capitalize form-onboard-form form-control textbox " type="text"
                        v-model="service.leave_data.custom_total_days" readonly :class="[
                            c$.custom_total_days.$error ? 'p-invalid' : '',
                        ]" />

                    <span v-if="c$.custom_total_days.$error" class="font-semibold text-red-400 fs-6">
                        {{ c$.custom_total_days.$errors[0].$message }}
                    </span>
                </div>
                <!-- comp off -->
                <div class="grid-cols-6 col-span-6" v-if="service.leave_data.selected_leave.includes('Compensatory Off')">
                    <p class="col-span-6 text-[#757575] font-semibold text-[12px] font-['poppins'] p-1 box-border">
                        Compensatory Off Dates</p>
                    <MultiSelect v-model="service.leave_data.selected_compensatory_leaves"
                        :options="service.leave_data.compensatory_leaves" optionLabel="emp_attendance_date"
                        optionValue="emp_attendance_id" display="chip" placeholder="Select Dates" class="w-full md:w-20rem"
                        :class="[
                            cp$.selected_compensatory_leaves.$error ? 'p-invalid' : '',
                        ]">

                        <div class="flex align-items-center">

                            <div>{{ service.leave_data.compensatory_leaves.emp_attendance_date }}</div>
                        </div>

                    </MultiSelect>
                    <span v-if="cp$.selected_compensatory_leaves.$error" class="font-semibold text-red-400 fs-6">
                        {{ cp$.selected_compensatory_leaves.$errors[0].$message }}
                    </span>
                    <div v-if="service.leave_data.compensatory_leaves.length === 1">
                        <p class="col-span-6 text-[#757575] font-semibold text-[12px] font-['poppins'] p-1 box-border">
                            Select Date</p>
                        <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                            v-model="service.leave_data.compensatory_leaves_dates" placeholder="Select Date"
                            class="h-[38px] w-[130px] m-2 " :minDate="new Date()" :class="[
                                cp$.compensatory_leaves_dates.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="cp$.compensatory_leaves_dates.$error" class="font-semibold text-red-400 fs-6">
                            {{ cp$.compensatory_leaves_dates.$errors[0].$message }}
                        </span>
                        <p class="text-[#757575] font-normal text-[12px] font-['poppins']">Total Day</p>
                        <InputText style="width: 60px;text-align: center;margin: auto;"
                            class="capitalize form-onboard-form form-control textbox " type="text"
                            v-model="service.leave_data.compensatory_total_days" readonly value="1" />

                    </div>
                    <div v-if="service.leave_data.compensatory_leaves.length > 1">
                        <!-- comp off start date -->
                        <p class="col-span-6 text-[#757575] font-normal text-[12px] font-['poppins'] p-1 box-border">Start
                            Date</p>
                        <Calendar dateFormat="dd-mm-yy" :showIcon="true"
                            v-model="service.leave_data.compensatory_start_date" placeholder="Select Date"
                            class="h-[38px] w-[130px] mx-2 " :minDate="new Date()" :class="[
                                cp$.compensatory_start_date.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="cp$.compensatory_start_date.$error" class="font-semibold text-red-400 fs-6">
                            {{ cp$.compensatory_start_date.$errors[0].$message }}
                        </span>
                        <!-- comp off end date -->
                        <p class="col-span-6 text-[#757575] font-normal text-[12px] font-['poppins'] p-1 box-border">End
                            Date</p>
                        <Calendar dateFormat="dd-mm-yy" @date-select="service.dayCalculation" :showIcon="true"
                            v-model="service.leave_data.compensatory_end_date" placeholder="Select Date"
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
                            v-model="service.leave_data.compensatory_total_days" readonly />
                    </div>
                </div>
                <!-- permission -->
                <div
                    v-if="service.leave_data.selected_leave === 'Permission' && !service.leave_data.selected_leave.includes('Compensatory Off')">
                    <p class="text-[#757575] font-semibold text-[12px] font-['poppins'] ">Permission Date<span
                            class="text-danger">*</span></p>

                    <div class="flex gap-3 mx-2">
                        <Calendar dateFormat="dd-mm-yy" :showIcon="true" v-model="service.leave_data.permission_date"
                            placeholder="Select Date" class="h-[38px] w-[130px]  "  :class="[
                                p$.permission_date.$error ? 'p-invalid' : '',
                            ]"
                            :minDate="new Date(service.before_date)"

                             />

                        <!-- <div class="flex gap-3 mt-3 px-2 box-border">
                            <div class="flex gap-2 ">
                                <input type="radio" name="permissionSession" value="Forenoon" id="permissionSession"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.permission_session" :class="[
                                        p$.permission_session.$error ? 'p-invalid' : '',
                                    ]" />
                                <label for="permissionSession"
                                    class="ml-2 ms-1 font-normal text-[12px] font-['poppins']">Forenoon</label>
                            </div>
                            <div class="flex gap-2 ">
                                <input type="radio" name="permissionSession" value="Afternoon" id="permissionSession"
                                    class="h-5 form-check-input border-2" style="height: 15px;width: 15px;"
                                    v-model="service.leave_data.permission_session" :class="[
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
                            <!-- {{ service.leave_data.permission_start_time }} -->
                            <Calendar id="permission_start" class="col-span-2 h-[30px] text-center "
                                v-model="service.leave_data.permission_start_time" showTime hourFormat="12" timeOnly :class="[
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
                            <Calendar @date-select="service.time_difference()" id="permission_end"
                                class="col-span-2 h-[30px] text-center" v-model="service.leave_data.permission_end_time"
                                :disabled="service.leave_data.permission_date == ''" showTime hourFormat="12" timeOnly
                                :class="[
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
                <div class="grid grid-cols-6  mt-3" v-if="service.leave_data.selected_leave === 'Permission'">
                    <p class="text-[#757575] col-span-6 font-semibold text-[12px] font-['poppins']">Total Minutes</p>
                    <div class="flex col-span-6 justify-center items-center">
                        <InputText style="width: 60px;text-align: center;margin: auto;"
                            class="capitalize form-onboard-form form-control textbox " type="text"
                            v-model="service.leave_data.permission_total_time_in_minutes" readonly />

                    </div>
                </div>
                <!-- <div class="grid-cols-6" v-if="service.leave_data.selected_leave === 'Permission'">
                    <p class="text-[#757575] my-2 font-normal text-[12px] font-['poppins'] ">Select Timings <span
                            class="text-danger">*</span></p>
                    <div class="flex  gap-4 mx-2">
                        <button class="w-[20px] h-[20px] rounded-full flex justify-center items-center bg-[#f6f6f6]"
                            :disabled="service.leave_data.permission_total_time_in_minutes === 30" @click="decrementTime()">
                            <i class="pi pi-minus"></i>
                        </button>
                        <div>
                            <p>{{ service.leave_data.permission_total_time_in_minutes }} &nbsp; Minutes</p>
                        </div>
                        <button :disabled="service.leave_data.permission_total_time_in_minutes === 120"
                            class="w-[20px] h-[20px] rounded-full flex justify-center items-center bg-[#f6f6f6]"
                            @click="incrementTime()">
                            <i class="pi pi-plus"></i>
                        </button>
                    </div>

                </div> -->
                <!-- MANAGER NOTIFICATION -->
                <div class="col-span-6 grid-cols-6">
                    <p class="text-[#757575] flex gap-3 font-semibold text-[12px] font-['poppins'] p-1 box-border">Notify to
                        Peers Groups <span class="text-[#e94545]"><strong>Not the Line Manager</strong></span></p>
                    <div class="col-span-6">
                        <!-- <Dropdown :options="samplearr" optionLabel="managerName" placeholder="Select Manager"
                            class=" mx-2 box-border" v-model="service.leave_data.notifyTo" :class="[
                                nm$.notifyTo.$error ? 'p-invalid' : '',
                            ]" /> -->
                        <MultiSelect filter v-model="service.leave_data.notifyTo" display="chip"
                            placeholder="Select Employee" class="w-full md:w-20rem"
                            :options="useLeaveStore.leave_notify_to_dropdown" optionLabel="name" optionValue="id">
                            <!-- :options="managerArr" optionLabel="label" -->
                            <!-- :class="[
                                nm$.notifyTo.$error ? 'p-invalid' : '',
                            ]" -->
                            <template #optiongroup="slotProps">
                                <div class="flex align-items-center">
                                    <div>{{ slotProps.option.label }}</div>
                                </div>
                            </template>
                        </MultiSelect>
                    </div>
                    <!-- {{ service.leave_data.notifyTo }} -->


                </div>

                <!-- reason -->
                <div class="col-span-6   ">
                    <p class="my-2 text-[#757575] font-semibold text-[12px] font-['poppins']">Reason<span
                            class="text-danger">*</span></p>
                    <div class="mx-2">
                        <Textarea rows="3" placeholder="Your Comments" cols="50" class="p-3 box-border w-[100%]"
                            v-model="service.leave_data.leave_reason" :class="[
                                r$.leave_reason.$error ? 'p-invalid' : '',
                            ]" />

                    </div>
                    <span v-if="r$.leave_reason.$error" class="font-semibold text-red-400 fs-6">
                        {{ r$.leave_reason.$errors[0].$message }}
                    </span>
                </div>
                <!-- button -->
                <div class="flex my-4 col-span-6 justify-center items-center gap-2    ">
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                        @click=" service.restChars(), sidebarnew = false">Cancel</button>
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]" @click="submitForm()">Submit</button>
                </div>

            </div>



        </div>
        <!-- absolute bottom-7 left-[30%] -->

    </Sidebar>
</template>


<script setup>



import { computed, inject, onMounted, reactive, ref } from "vue";
import ABS_loading_spinner from "../../../components/ABS_loading_spinner.vue";
import axios from "axios";
import useValidate from '@vuelidate/core'
import dayjs from "dayjs";
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { useLeaveModuleStore } from "../LeaveModuleService";
import { useLeaveService } from './leave_apply_service';
import { useAttendanceTimesheetMainStore } from "../../attendence/timesheet/stores/attendanceTimesheetMainStore";

const visible = ref(false)
const leave_types = ref();
const sidebarnew = ref(false)
const useLeaveStore = useLeaveModuleStore()
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
// sample  data



const AttendanceTimesheetMainStore = useAttendanceTimesheetMainStore();
//permission timings

const incrementTime = () => {
    service.leave_data.permission_total_time_in_minutes += 30;
};

const decrementTime = () => {
    service.leave_data.permission_total_time_in_minutes -= 30;
};
//get first day of current month

// var date = new Date();
// var first_day_of_the_month = new Date(date.getFullYear(), date.getMonth(), 1);
// var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);


// Check All Varaibles and Events Here
const service = useLeaveService()

const leaves = ref();
// const leave = ref([
//     { name: 'Sick Leave', code: 'NY' },
//     { name: 'Casual Leave', code: 'RM' },
//     { name: 'Earn Leave', code: 'LDN' },
//     { name: 'Compensatory Leave', code: 'IST' },

// ]);


onMounted(() => {

    service.get_user()
    service.get_leave_types()
    service.get_compensatroy_leaves()
    // service.getLeaveRestrictDates()
    service.leave_data.custom_start_date = new Date()
    service.leave_data.permission_start_time = new Date();

    console.log("AttendanceTimesheetMainStore ::", AttendanceTimesheetMainStore.CurrentlySelectedUser);

    useLeaveStore.selectedLeaveMonth = new Date()
});


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
const f$ = useValidate(full_day_rules, service.leave_data)
const h$ = useValidate(half_day_rules, service.leave_data)
const c$ = useValidate(custom_day_rules, service.leave_data)
const cp$ = useValidate(compen_day_rules, service.leave_data)
const r$ = useValidate(reason_rules, service.leave_data)
const p$ = useValidate(permissionRules, service.leave_data)
const v$ = useValidate(rules, service.leave_data)
// const nm$ = useValidate(notifyrules, service.leave_data)



const submitForm = () => {
    v$.value.$validate() // checks all inputs
    f$.value.$validate()
    h$.value.$validate()
    c$.value.$validate()
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log(service.leave_data.selected_leave);


        if (service.leave_data.selected_leave.includes('Compensatory')) {
            cp$.value.$validate()
            if (!cp$.value.$error) {
                // if ANY fail validation
                r$.value.$validate()
                if (!r$.value.$error) {
                    service.Submit('applyleave')
                    r$.value.$reset()
                    cp$.value.$reset()
                    v$.value.$reset()

                }

                console.log('Form successfully submitted.')
            } else {
                console.log('Form failed validation')
            }
        }

        if (service.leave_data.radiobtn_full_day == "full_day") {
            f$.value.$validate()
            // f$.value.$reset()
            if (!f$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    service.Submit('applyleave')
                    r$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    sidebarnew.value = false

                }
                else {
                    console.log('Reason Validation Error')
                }

                // }
            } else {
                console.log('Form failed validation')
            }
        }

        else if (service.leave_data.radiobtn_half_day == "half_day") {
            h$.value.$validate()
            if (!h$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    console.log('Half Day');
                    service.Submit('applyleave')
                    r$.value.$reset()
                    // h$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    sidebarnew.value = false

                }
                else {
                    console.log('Reason Validation Error')
                }

                // }



            } else {
                console.log('Form failed validation')
            }
        }
        else if (service.leave_data.radiobtn_custom === "custom") {
            c$.value.$validate()

            if (!c$.value.$error) {
                // if ANY fail validation
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    service.Submit('applyleave')
                    r$.value.$reset()
                    f$.value.$reset()
                    c$.value.$reset()
                    h$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    console.log('Form successfully submitted.')
                    sidebarnew.value = false
                }
                else {
                    console.log('Reason Validation Error')
                }


                // }
            } else {
                console.log('Form failed validation')
            }
        }
        if (service.leave_data.selected_leave.includes('Permission')) {
            p$.value.$validate()

            if (!p$.value.$error) {
                // nm$.value.$validate()
                // if (!nm$.value.$error) {
                r$.value.$validate()
                if (!r$.value.$error) {
                    service.Submit('applyleave')
                    r$.value.$reset()
                    p$.value.$reset()
                    v$.value.$reset()
                    // nm$.value.$reset()
                    sidebarnew.value = false
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
const leaveV$ = useValidate(leaveRules, service.leave_data)
const leaveValidate = () => {
    leaveV$.value.$validate()
    console.log(leaveV$)
    console.log(leaveV$.value)
    console.log(service.leave_data)
    if (!leaveV$.value.$error) {
        // if ANY fail validation
        service.Submit();
        // sidebarnew.value = false
        console.log('Form successfully submitted.')
        sidebarnew.value = false;
        console.log(service.leave_data, 'service.leave_data');
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
    service.restChars()

    r$.value.$reset();
    c$.value.$reset();
    h$.value.$reset()
    f$.value.$reset()
    v$.value.$reset()


}
</script>



<style>
.p-multiselect-filter .p-inputtext .p-component
{
    border: 1px solid gray;
    height: 34px;
}

label
{
    font-size: 15px;
    font-weight: 502;
}

.leave_type
{
    font-size: 15px;
    font-weight: 400;
}


.p-datepicker .p-datepicker-header
{
    padding: 0.5rem;
    color: #061328;
    background: #002f56;
    font-weight: 600;
    margin: 0;
    border-bottom: 1px solid #dee2e6;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
}

.p-datepicker .p-datepicker-header .p-datepicker-title .p-datepicker-year,
.p-datepicker .p-datepicker-header .p-datepicker-title .p-datepicker-month
{
    color: #fff;
    transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 600;
    padding: 0.5rem;
}

.p-datepicker:not(.p-datepicker-inline) .p-datepicker-header
{
    background: #002f56;
    color: black;
}

.p-calendar-w-btn .p-datepicker-trigger
{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    background: #002f56;
}

.p-dialog-mask
{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
    background: #433f3f6b;
}

.p-button:enabled:hover
{
    background: #002f56;
    color: #ffffff;
    border-color: none;
}

.p-multiselect.p-multiselect-chip .p-multiselect-token
{
    padding: 0.2rem 0.55rem;
    margin-right: 0.5rem;
    background: #dee2e6;
    color: #495057;
    border-radius: 16px;
}

.p-checkbox .p-checkbox-box.p-highlight
{
    border-color: #3B82F6;
    background: #103674;
}

.p-chips .p-chips-multiple-container
{
    padding: 0.375rem 0.75rem;
}

.p-chips.p-component.p-inputwrapper
{
    width: 100%;
}

.form-select:focus
{
    border-color: #002f56;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 5%);
}

.form-control:focus
{
    border-color: #002f56;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 5%);
}

.p-chips-multiple-container
{
    margin: 0;
    padding: 0;
    list-style-type: none;
    cursor: text;
    overflow: hidden;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    width: 100%;
}

.p-button,
.p-button-icon-only,
.p-datepicker-trigger
{
    height: 50px !important;
    border: 2px solid black;
}

/*.p-dialog.p-component:before {
    content: "";
    background: #002f56;
    height: 8px;
    border-radius: 50px 50px 0px;
    position: relative;
    top: 3px;
}*/

.p-button
{
    height: 3rem !important;
}


.p-sidebar-close-icon
{
    position: absolute;
    top: 10px;
    color: #fff;
}

.p-sidebar-content
{
    padding: 0px !important;
}

/* sidebar close button */


/* p-component p-button-icon-only p-datepicker-trigger */
</style>
