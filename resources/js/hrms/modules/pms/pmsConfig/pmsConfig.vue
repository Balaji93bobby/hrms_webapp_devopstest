<template>
    <Toast />
    <div class="w-full !font-['poppins']" v-if="useConfig.pmsConfig">
        <h1 class=" text-[#000] font-semibold my-2 text-[18px]">KPI/OKR Goal Settings</h1>
        <div class=" rounded-md  p-2 bg-white">
            <h1 class="text-[#000] font-semibold my-2 text-[16px]">PMS Calendar Settings</h1>
            <div class="grid grid-cols-4 gap-4 my-3">
                <div class=" flex flex-col justify-end border-[1px] border-[#0000]">
                    <p class=" text-[#000000] text-left py-1 text-[14px] ">Calendar Type</p>
                    <div class="flex items-center justify-start ">
                        <!-- {{useConfig.canFreezeCalendarSetting}} -->
                        <button class=" px-3 py-1 rounded-l-md border-[1px]" :disabled="useConfig.canFreezeCalendarSetting"
                            @click=" findCalendarType('financial_year'), useConfig.pmsConfig.pms_calendar_settings.calendar_type = 'financial_year'"
                            :class="useConfig.pmsConfig.pms_calendar_settings ? useConfig.pmsConfig.pms_calendar_settings.calendar_type == 'financial_year' ? ' bg-[#F9BE00] text-[#000]' : ' bg-[#F9F9F9] text-[#8B8B8B]  ' : ' bg-[#F9F9F9] text-[#8B8B8B]'">Financial
                            Year</button>
                        <button class=" px-3 py-1 border-[1px] rounded-r-md" :disabled="useConfig.canFreezeCalendarSetting"
                            @click="findCalendarType('calendar_year'), useConfig.pmsConfig.pms_calendar_settings.calendar_type = 'calendar_year'"
                            :class="useConfig.pmsConfig.pms_calendar_settings ? useConfig.pmsConfig.pms_calendar_settings.calendar_type == 'calendar_year' ? 'bg-[#F9BE00] text-[#000]  ' : 'bg-[#F9F9F9] text-[#8B8B8B] ' : 'bg-[#F9F9F9] text-[#8B8B8B]'">Calendar
                            Year</button>
                    </div>
                </div>
                <div>
                    <p class=" text-[#000]  py-1 font-['poppins']">Year</p>
                    <p v-if="useConfig.pmsConfig.pms_calendar_settings.calendar_type">{{
                        useConfig.pmsConfig.pms_calendar_settings ?
                        useConfig.pmsConfig.pms_calendar_settings.year : '' }}</p>
                </div>
                <div>
                    <!-- :disabled="useConfig.canFreezeCalendarSetting" -->
                    <h1 class=" text-[#000]  py-1 font-['poppins']">Frequency</h1>
                    <Dropdown @change="findAssignmentPeriod(useConfig.pmsConfig.pms_calendar_settings.frequency)"
                        :disabled="useConfig.canFreezeCalendarSetting"
                        v-model="useConfig.pmsConfig.pms_calendar_settings.frequency" :options="frequencyOption"
                        optionLabel="displayValue" optionValue="title" placeholder="Select Frequency"
                        class=" w-[100%] md:w-[230px] h-10" :class="[
                            calv$.frequency.$error ? 'p-invalid' : '',
                        ]" />
                    <span v-if="calv$.frequency.$error" class="  flex justify-start  font-semibold text-red-400 fs-6">
                        {{ calv$.frequency.$errors[0].$message }}
                    </span>
                </div>
                <div>
                    <h1 class=" text-[#000] py-1 font-['poppins'] ">Assignment period</h1>
                    <!-- <Dropdown v-model="useConfig.pmsConfig.assignment_id" v-if="useConfig.canFreezeCalendarSetting"
                    :options="useConfig.getAssignmentPeriod" optionLabel="assignment_period" optionValue="assignment_period_id"
                    placeholder="Select Assignment Period" class=" w-[100%] md:w-[230px] h-10" :class="[
                        calv$.assignment_period.$error ? 'p-invalid' : '',
                    ]" />
                    <Dropdown v-model="useConfig.pmsConfig.pms_calendar_settings.assignment_period" v-else
                        :options="assignmentPeriodOption" optionLabel="value" optionValue="value"
                        placeholder="Select Assignment Period" class=" w-[100%] md:w-[230px] h-10" :class="[
                            calv$.assignment_period.$error ? 'p-invalid' : '',
                        ]" /> -->
                    <!-- :disabled="useConfig.canFreezeCalendarSetting" -->
                    <!-- {{useConfig.canFreezeCalendarSetting ? 1 : 2 }} -->
                    <!-- {{useConfig.pmsConfig.pms_calendar_settings.assignment_period}} -->
                    <!-- {{ useConfig.pmsConfig.pms_calendar_settings.assignment_period }} -->
                    <Dropdown v-if="useConfig.canFreezeCalendarSetting"
                        v-model="useConfig.pmsConfig.pms_calendar_settings.assignment_period"
                        @change="useConfig.getPMSSetting_forGivenAssignmentPeriod(useConfig.pmsConfig.pms_calendar_settings.assignment_period)"
                        :options="useConfig.getAssignmentPeriod" optionLabel="assignment_period"
                        optionValue="assignment_period_id" placeholder="Select Assignment Period"
                        class=" w-[100%] md:w-[230px] h-10" :class="[
                            calv$.assignment_period.$error ? 'p-invalid' : '',
                        ]" />

                    <Dropdown v-else v-model="useConfig.pmsConfig.pms_calendar_settings.assignment_period"
                        :options="assignmentPeriodOption" optionLabel="value" optionValue="value"
                        placeholder="Select Assignment Period" class=" w-[100%] md:w-[230px] h-10" :class="[
                            calv$.assignment_period.$error ? 'p-invalid' : '',
                        ]" />

                    <span v-if="calv$.assignment_period.$error"
                        class="  flex justify-start  font-semibold text-red-400 fs-6">
                        {{ calv$.assignment_period.$errors[0].$message }}
                    </span>
                </div>
            </div>
        </div>
        <h1 class="text-[#000] font-semibold text-[14px] my-4 ">PMS Basic Settings</h1>
        <div class="p-2 bg-white rounded-md">
            <div class=" flex justify-between items-center w-[500px]">

                <div class="flex flex-col justify-start items-center w-[200px]">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Assign Upcoming Goal</h1>
                    <div class="flex items-center justify-start">
                        <input v-model="useConfig.pmsConfig.pms_basic_settings.can_assign_upcoming_goals" type="radio"
                            name="Assign Upcoming Goal" value="auto" class="accent-black w-[20px] h-[20px] " id="" :class="[
                                v$.can_assign_upcoming_goals.$error ? 'p-invalid' : '',
                            ]" /> <label for="" class="mx-2 text-[#000]">Auto</label>
                        <input v-model="useConfig.pmsConfig.pms_basic_settings.can_assign_upcoming_goals" type="radio"
                            name="Assign Upcoming Goal" id="" value="manual" class="accent-black w-[20px] h-[20px]" :class="[
                                v$.can_assign_upcoming_goals.$error ? 'p-invalid' : '',
                            ]"> <label for="" class="mx-2 text-[#000]">Manual</label>
                    </div>
                    <span v-if="v$.can_assign_upcoming_goals.$error"
                        class=" w-[150px] flex justify-start  font-semibold text-red-400 fs-6">
                        {{ v$.can_assign_upcoming_goals.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col justify-start items-center w-[250px] ">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Annual Score Calculation Method
                    </h1>
                    <div class="flex px-2 justify-start w-[100%] items-center ">
                        <input v-model="useConfig.pmsConfig.pms_basic_settings.annual_score_cal_method" value="average"
                            type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                v$.annual_score_cal_method.$error ? 'p-invalid' : '',
                            ]">Average</label>
                        <input v-model="useConfig.pmsConfig.pms_basic_settings.annual_score_cal_method" value="sum"
                            type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                v$.annual_score_cal_method.$error ? 'p-invalid' : '',
                            ]">Sum</label>
                    </div>
                    <span v-if="v$.annual_score_cal_method.$error"
                        class="font-semibold w-[250px] flex justify-start text-red-400 fs-6">
                        {{ v$.annual_score_cal_method.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-start px-4 my-4">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Can Employee allow to proceed
                        for next PMS before completing the current PMS?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input
                            v-model="useConfig.pmsConfig.pms_basic_settings.can_emp_proceed_nextpms_wo_currpms_completion"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id="" :class="[
                                v$.can_emp_proceed_nextpms_wo_currpms_completion.$error ? 'p-invalid' : '',
                            ]"> <label for="" class="mx-2 text-[#000]">Yes</label>
                        <input
                            v-model="useConfig.pmsConfig.pms_basic_settings.can_emp_proceed_nextpms_wo_currpms_completion"
                            value="0" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                v$.can_emp_proceed_nextpms_wo_currpms_completion.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="v$.can_emp_proceed_nextpms_wo_currpms_completion.$error"
                        class="font-semibold text-red-400 fs-6 w-[100%] flex justify-start ">
                        {{ v$.can_emp_proceed_nextpms_wo_currpms_completion.$errors[0].$message }}
                    </span>
                </div>

            </div>
            <div class="flex items-center justify-start px-4 my-4">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Can Organization allow to
                        proceed for next PMS before completing the current PMS?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input
                            v-model="useConfig.pmsConfig.pms_basic_settings.can_org_proceed_nextpms_wo_currpms_completion"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                v$.can_org_proceed_nextpms_wo_currpms_completion.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input
                            v-model="useConfig.pmsConfig.pms_basic_settings.can_org_proceed_nextpms_wo_currpms_completion"
                            value="0" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]" :class="[
                                v$.can_org_proceed_nextpms_wo_currpms_completion.$error ? 'p-invalid' : '',
                            ]"> <label for="" class="mx-2 text-[#000]">No</label>
                    </div>
                    <span v-if="v$.can_org_proceed_nextpms_wo_currpms_completion.$error"
                        class="font-semibold text-red-400 fs-6 w-[100%] flex justify-start">
                        {{ v$.can_org_proceed_nextpms_wo_currpms_completion.$errors[0].$message }}
                    </span>
                </div>
            </div>
        </div>
        <h1 class="text-[#000] font-semibold text-[14px] my-4">PMS Dashboard Page</h1>
        <div class=" grid grid-cols-3 gap-2 bg-[white] rounded-md">
            <div class="flex items-center justify-start px-4 my-4">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Show Overall Score card in
                        Self-Appraisal Dashboard?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_overall_score_in_selfappr_dashboard"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_overall_score_in_selfappr_dashboard.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_overall_score_in_selfappr_dashboard"
                            value="0" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_overall_score_in_selfappr_dashboard.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="dv$.can_show_overall_score_in_selfappr_dashboard.$error"
                        class="font-semibold text-red-400 fs-6 w-[100%] flex justify-start">
                        {{ dv$.can_show_overall_score_in_selfappr_dashboard.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-start px-4 my-4">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Show Rating Card in Review Page?
                    </h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_rating_card_in_review_page"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_rating_card_in_review_page.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_rating_card_in_review_page"
                            value="0" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_rating_card_in_review_page.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="dv$.can_show_rating_card_in_review_page.$error"
                        class="font-semibold text-red-400 w-[100%] flex justify-start fs-6">
                        {{ dv$.can_show_rating_card_in_review_page.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-start px-4 my-4">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Show Overall Score card in
                        Review Page?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_overall_scr_card_in_review_page"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_overall_scr_card_in_review_page.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.pms_dashboard_page.can_show_overall_scr_card_in_review_page"
                            value="0" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                dv$.can_show_overall_scr_card_in_review_page.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="dv$.can_show_overall_scr_card_in_review_page.$error"
                        class="font-semibold text-red-400 fs-6 w-[100%] flex justify-start">
                        {{ dv$.can_show_overall_scr_card_in_review_page.$errors[0].$message }}
                    </span>
                </div>
            </div>
        </div>
        <!-- Reminder Alert -->
        <h1 class="text-[#000] font-semibold text-[14px] my-4">Reminder Alert</h1>
        <div class=" grid grid-cols-3 gap-2 bg-white">
            <div class="flex items-start justify-start px-4 my-4 col-span-1">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Reminder to alert Employees
                        before due date</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input value="1" v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active"
                            type="radio" name="employeeRemainder" class="accent-black w-[20px] h-[20px] " id=""> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rfv$.active.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active" type="radio"
                            name="employeeRemainder" id="" value="0" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rfv$.active.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="rfv$.active.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rfv$.active.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <!--  -->
            <div class="flex items-center justify-start px-4 my-4 col-span-2">
                <div class="flex flex-col items-center justify-start"
                    v-if="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active ? useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active == 1 : false">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">How many Instances to alert
                        Employees before due date in a day?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.notif_count" :class="[
                            rfv$.notif_count.$error ? 'p-invalid' : '',
                        ]" type="radio" name="employeeInstance" class="accent-black w-[20px] h-[20px] " id=""
                            value="1">
                        <label for="" class="mx-2 text-[#000]">Once</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.notif_count" :class="[
                            rfv$.notif_count.$error ? 'p-invalid' : '',
                        ]" type="radio" name="employeeInstance" id="" class="accent-black w-[20px] h-[20px]" value="2">
                        <label for="" class="mx-2 text-[#000]">Twice</label>
                    </div>
                    <span v-if="rfv$.notif_count.$error"
                        class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rfv$.notif_count.$errors[0].$message }}
                    </span>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.notif_mode"
                            type="checkbox" name="employeeNotifyMode" value="Mail"
                            class=" w-[20px] h-[20px] my-2 !checked:bg-black" :class="[
                                rfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">
                        <label for="" class="mx-2 text-[#000] ">Mail</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.notif_mode"
                            type="checkbox" name="employeeNotifyMode" id="" class="accent-black w-[20px] h-[20px]"
                            value="SMS"> <label for="" class="mx-2 text-[#000]" :class="[
                                rfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">SMS</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.notif_mode"
                            type="checkbox" name="employeeNotifyMode" id="" class="accent-black w-[20px] h-[20px]"
                            value="Whatsapp" :class="[
                                rfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]"> <label for="" class="mx-2 text-[#000]">Whatsapp</label>
                        <input type="checkbox" name="employeeNotifyMode" id="" class="accent-black w-[20px] h-[20px]"
                            value="Telegram" :class="[
                                rfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">
                        <label for="" class="mx-2 text-[#000]">Telegram</label>
                    </div>
                    <span v-if="rfv$.notif_mode.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rfv$.notif_mode.$errors[0].$message }}
                    </span>
                </div>
            </div>

            <div class="flex items-start justify-start px-4 my-1 col-span-1">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Reminder to alert Employees
                        before for over due</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input value="1" v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active"
                            type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rsv$.active.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"
                            v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active" value="0"
                            :class="[
                                rsv$.active.$error ? 'p-invalid' : '',
                            ]">
                        <label for="" class="mx-2 text-[#000]">No</label>

                    </div>
                    <span v-if="rsv$.active.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rsv$.active.$errors[0].$message }}
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-start px-4 my-1 col-span-2">
                <div class="flex flex-col items-center justify-start"
                    v-if="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active ? useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active == 1 : false">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">How many Instances to alert
                        Employees before due date in a day?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_count"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rsv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Once</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_count"
                            value="2" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rsv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Twice</label>
                    </div>
                    <span v-if="rsv$.notif_count.$error"
                        class=" w-[100%] flex justify-startfont-semibold text-red-400 fs-6">
                        {{ rsv$.notif_count.$errors[0].$message }}
                    </span>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_mode"
                            value="Mail" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black">
                        <label for="" class="mx-2 text-[#000]" :class="[
                            rsv$.notif_mode.$error ? 'p-invalid' : '',
                        ]">Mail</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_mode"
                            value="Sms" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">SMS</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_mode"
                            value="Whatsapp" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Whatsapp</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.notif_mode"
                            value="Telegram" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Telegram</label>

                    </div>
                    <span v-if="rsv$.notif_mode.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rsv$.notif_mode.$errors[0].$message }}
                    </span>
                </div>

            </div>

            <div class="flex items-start justify-start px-4 my-1 col-span-1">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[rgb(0,0,0)] font-semibold text-[14px] my-3">Reminder to alert Managers
                        before for over date</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active" value="1"
                            type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmfv$.active.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active" value="0"
                            type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmfv$.active.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="rmfv$.active.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmfv$.active.$errors[0].$message }}
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-start px-4 my-1 col-span-2">
                <div class="flex flex-col items-center justify-start"
                    v-if="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active ? useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active == 1 : false">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">How many Instances to alert
                        mana before due date in a day?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_count" value="1"
                            type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmfv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Once</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_count" value="2"
                            type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmfv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Twice</label>
                    </div>
                    <span v-if="rmfv$.notif_count.$error"
                        class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmfv$.notif_count.$errors[0].$message }}
                    </span>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_mode"
                            value="Mail" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black">
                        <label for="" class="mx-2 text-[#000]" :class="[
                            rmfv$.notif_mode.$error ? 'p-invalid' : '',
                        ]">Mail</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_mode"
                            value="Sms" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">SMS</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_mode"
                            value="Whatsapp" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rmfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Whatsapp</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.notif_mode"
                            value="Telegram" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rmfv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Telegram</label>
                    </div>
                    <span v-if="rmfv$.notif_mode.$error"
                        class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmfv$.notif_mode.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div class="flex items-start justify-start px-4 my-1 col-span-1">
                <div class="flex flex-col items-center justify-start">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Reminder to alert Managers for
                        over due</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active" value="1"
                            type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmsv$.active.$error ? 'p-invalid' : '',
                            ]">Yes</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active" value="0"
                            type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmsv$.active.$error ? 'p-invalid' : '',
                            ]">No</label>
                    </div>
                    <span v-if="rmsv$.active.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmsv$.active.$errors[0].$message }}
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-start px-4 my-1 col-span-2">

                <div class="flex flex-col items-center justify-start"
                    v-if="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active ? useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active == 1 : false">
                    <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">How many Instances to alert
                        Managers before due date in a day?</h1>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_count"
                            value="1" type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmsv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Once</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_count"
                            value="2" type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmsv$.notif_count.$error ? 'p-invalid' : '',
                            ]">Twice</label>
                    </div>
                    <span v-if="rmsv$.notif_count.$error"
                        class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmsv$.notif_count.$errors[0].$message }}
                    </span>
                    <div class="flex justify-start items-center w-[100%]">
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_mode"
                            value="Mail" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black">
                        <label for="" class="mx-2 text-[#000]" :class="[
                            rmsv$.notif_mode.$error ? 'p-invalid' : '',
                        ]">Mail</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_mode"
                            value="SMS" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label for=""
                            class="mx-2 text-[#000]" :class="[
                                rmsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">SMS</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_mode"
                            value="Whatsapp" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rmsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Whatsapp</label>
                        <input v-model="useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.notif_mode"
                            value="Telegram" type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black"> <label
                            for="" class="mx-2 text-[#000]" :class="[
                                rmsv$.notif_mode.$error ? 'p-invalid' : '',
                            ]">Telegram</label>

                    </div>
                    <span v-if="rmsv$.notif_mode.$error"
                        class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                        {{ rmsv$.notif_mode.$errors[0].$message }}
                    </span>
                </div>
            </div>
        </div>

        <!-- PMS Metrics -->

        <p class=" text-[#000] font-semibold text-[14px] my-4 ">PMS Metrics</p>

        <div class="p-3 bg-white rounded-md">
            <div class="grid grid-span-12">
                <p class=" text-[#000] text-left py-1 font-semibold">Column need to be shown in KPI/OKR</p>
            </div>
            <!-- {{ useConfig.pmsConfig.pms_metrics }}-->
            <div class="grid grid-cols-12">
                <div class="col-span-8">
                    <div class="grid grid-rows-5 grid-cols-5 grid-flow-col gap-x-96  h-[300px]">
                        <div class="grid grid-cols-2 gap-x-52" v-for="(item, index) in useConfig.pmsDefaultHeaders"
                            :key="index">

                            <div class="p-3" :class="[index > 4 ? 'mx-10' : '']">
                                <div class="flex items-center ">
                                    <h1 v-if="[0, 5, 10, 15].includes(index)" class=" text-gray-400 font-['poppins']">
                                        Columns
                                    </h1>
                                </div>
                                <div class="flex items-center my-2">
                                    <input type="checkbox" name="pmsMetrics" v-model="useConfig.pmsConfig.pms_metrics"
                                        class=" w-[20px] h-[20px] my-2 !checked:bg-black" :value="item" :class="[
                                            pmsv$.pms_metrics.$error ? 'p-invalid' : '',
                                        ]">
                                    <h1 class="mx-2 text-[#000] ">{{ item.header_label ?
                                        item.header_label : item.header_name ? item.header_name : 'empty' }}</h1>
                                </div>
                            </div>
                            <div class=" p-3 w-[200px]">
                                <div class="flex items-center ">
                                    <h1 v-if="[0, 5, 10, 15].includes(index)" class=" text-gray-400 font-['poppins']">Rename
                                    </h1>
                                </div>
                                <div class="flex items-center my-2">
                                    <InputText type="text" v-model="item.alias_name"
                                        class="w-48 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-4">
                    <OrderList v-model="useConfig.pmsConfig.pms_metrics" listStyle="height:auto" dataKey="id">
                        <template #header> Order of Pms Metrics </template>
                        <template #item="slotProps">
                            <div class="flex flex-wrap p-2 align-items-center gap-3">
                                <div class="flex-1 flex flex-column gap-2">
                                    <span class="font-bold">{{ slotProps.item.alias_name ? slotProps.item.alias_name :
                                        slotProps.item.header_label ? slotProps.item.header_label :
                                            slotProps.item.header_label }}</span>
                                </div>
                            </div>
                        </template>
                    </OrderList>
                </div>
            </div>
            <span v-if="pmsv$.pms_metrics.$error" class="font-semibold text-red-400 fs-6">
                {{ pmsv$.pms_metrics.$errors[0].$message }}
            </span>
            <!-- <div class="">
                    <div class="">
                        <div class="flex items-center my-1">
                            <button class="border-[2px] border-[#0873CD] text-[#0873CD] rounded-[30px] my-2 px-3 py-1 ">
                                <i class="pi pi-plus "></i>
                                Add more
                            </button>
                        </div>
                        <div class="flex items-center my-1">
                            <button class="border-[2px] border-[#C4302B] text-[#C4302B] rounded-[30px] my-2 px-3 py-1">
                                <i class="pi pi-pencil"></i>
                                Rename
                            </button>
                        </div>
                    </div>
                </div> -->
            <!-- </div> -->
        </div>

        <!-- Goal Settings -->
        <p class=" text-[#000] font-semibold text-[14px] my-4 font-['poppins'] ">Goal Settings</p>

        <div class="bg-white  rounded-md p-4">
            <h1 class="my-2">Who can Set the Goal</h1>
            <MultiSelect v-model="useConfig.pmsConfig.goal_settings.who_can_set_goal"
                :options="useConfig.whoCanSetRoleTypes" optionLabel="role_type" optionValue="role_shortname"
                placeholder=" Select" class="w-[180px]" :maxSelectedLabels="3" :class="[
                    goalv$.who_can_set_goal.$error ? 'p-invalid' : '',
                ]" />
            <span v-if="goalv$.who_can_set_goal.$error" class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                {{ goalv$.who_can_set_goal.$errors[0].$message }}
            </span>
            <div class="grid grid-cols-2 ">
                <div class="flex items-start justify-start px-2 my-4 col-span-1">
                    <div class="flex flex-col items-center justify-start">
                        <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Does the Employee need to
                            Approve/Reject the Goal Setting?</h1>
                        <div class="flex justify-start items-center w-[100%]">
                            <input v-model="useConfig.pmsConfig.goal_settings.should_emp_acp_rej_goals" value="1"
                                type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                                class="mx-2 text-[#000]" :class="[
                                    goalv$.should_emp_acp_rej_goals.$error ? 'p-invalid' : '',
                                ]">Yes</label>
                            <input v-model="useConfig.pmsConfig.goal_settings.should_emp_acp_rej_goals" value="0"
                                type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                                class="mx-2 text-[#000]" :class="[
                                    goalv$.should_emp_acp_rej_goals.$error ? 'p-invalid' : '',
                                ]">No</label>
                        </div>
                        <span v-if="goalv$.should_emp_acp_rej_goals.$error"
                            class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                            {{ goalv$.should_emp_acp_rej_goals.$errors[0].$message }}
                        </span>
                    </div>
                </div>
                <div class="flex items-start justify-start px-2 my-4 col-span-1">
                    <div class="flex flex-col items-center justify-start">
                        <h1 class="font-['poppins'] text-[#000] font-semibold text-[14px] my-3">Does the Manager need to
                            Approve/Reject the Goal Setting?</h1>
                        <div class="flex justify-start items-center w-[100%]">
                            <input v-model="useConfig.pmsConfig.goal_settings.should_mgr_appr_rej_goals" value="1"
                                type="radio" name="" class="accent-black w-[20px] h-[20px] " id=""> <label for=""
                                class="mx-2 text-[#000]" :class="[
                                    goalv$.should_mgr_appr_rej_goals.$error ? 'p-invalid' : '',
                                ]">Yes</label>
                            <input v-model="useConfig.pmsConfig.goal_settings.should_mgr_appr_rej_goals" value="0"
                                type="radio" name="" id="" class="accent-black w-[20px] h-[20px]"> <label for=""
                                class="mx-2 text-[#000]" :class="[
                                    goalv$.should_mgr_appr_rej_goals.$error ? 'p-invalid' : '',
                                ]">No</label>
                        </div>
                        <span v-if="goalv$.should_mgr_appr_rej_goals.$error"
                            class="font-semibold w-[100%] flex justify-start text-red-400 fs-6">
                            {{ goalv$.should_mgr_appr_rej_goals.$errors[0].$message }}
                        </span>
                    </div>
                </div>
            </div>

            <h1 class=" text-[#000] font-semibold ">Due Date</h1>

            <div class="my-3">
                <div class="grid grid-cols-12 my-4">
                    <div class="col-span-5">
                        <h1 class="font-['poppins] text-[#000] text-[16px]   col-span-2">step 1:Goal initiate</h1>
                    </div>
                    <div class="col-span-5 grid grid-cols-12 items-center   gap-4">
                        <div class="col-span-7">
                            <h1 class="font-['poppins] text-[#000] text-[16px]   text-right">Beginning of the month</h1>
                        </div>
                        <div class="col-span-3">
                            <InputText placeholder="Enter days" type="text"
                                v-model="useConfig.pmsConfig.goal_settings.duedate_goal_initiate"
                                v-on:keypress="NumbersOnly" class="w-36 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2"
                                :class="[
                                    goalv$.duedate_goal_initiate.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="goalv$.duedate_goal_initiate.$error" class="font-semibold text-red-400 fs-6">
                                {{ goalv$.duedate_goal_initiate.$errors[0].$message }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <h1 class="font-['poppins] text-[16px]  text-[#000]">days</h1>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 my-4" v-if="useConfig.pmsConfig.goal_settings.should_mgr_appr_rej_goals == 1">
                    <div class="col-span-5">
                        <h1 class="font-['poppins] text-[#000] text-[16px]   col-span-2">step 2:Approval/Acceptance</h1>
                    </div>
                    <div class="col-span-5 grid grid-cols-12 gap-4  items-center">
                        <div class="col-span-7">
                            <h1 class="font-['poppins] text-[#000] text-[16px]  text-right">Nett</h1>
                        </div>
                        <div class="col-span-3">
                            <InputText placeholder="Enter days" type="text"
                                v-model="useConfig.pmsConfig.goal_settings.duedate_approval_acceptance"
                                v-on:keypress="NumbersOnly" class="w-36 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2"
                                :class="[
                                    goalv$.duedate_approval_acceptance.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="goalv$.duedate_approval_acceptance.$error" class="font-semibold text-red-400 fs-6">
                                {{ goalv$.duedate_approval_acceptance.$errors[0].$message }}
                            </span>

                        </div>
                        <div class="col-span-2">
                            <h1 class="font-['poppins] text-[16px]  text-[#000]">days</h1>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 my-4">
                    <div class="col-span-5">
                        <h1 class="font-['poppins] text-[#000] text-[16px]   col-span-2">step 3:Self-review</h1>
                    </div>
                    <div class="col-span-5 grid grid-cols-12 items-center  gap-4">
                        <div class="col-span-7">
                            <h1 class="font-['poppins] text-[#000] text-[16px]  text-right">End of the month</h1>
                        </div>
                        <div class="col-span-3">
                            <InputText placeholder="Enter days" type="text"
                                v-model="useConfig.pmsConfig.goal_settings.duedate_self_review" v-on:keypress="NumbersOnly"
                                class="w-36 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2" :class="[
                                    goalv$.duedate_self_review.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="goalv$.duedate_self_review.$error" class="font-semibold text-red-400 fs-6">
                                {{ goalv$.duedate_self_review.$errors[0].$message }}
                            </span>

                        </div>
                        <div class="col-span-2">
                            <h1 class="font-['poppins] text-[16px]  text-[#000]">days</h1>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12  my-4">
                    <div class="col-span-5">
                        <h1 class="font-['poppins] text-[#000] text-[16px]   col-span-2">step 4:Manager-review</h1>
                    </div>
                    <div class="col-span-5 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-7">
                            <h1 class="font-['poppins] text-[#000] text-[16px]  text-right">Nett</h1>
                        </div>
                        <div class="col-span-3">
                            <InputText placeholder="Enter days" type="text"
                                v-model="useConfig.pmsConfig.goal_settings.duedate_mgr_review" v-on:keypress="NumbersOnly"
                                class="w-36 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2" :class="[
                                    goalv$.duedate_mgr_review.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="goalv$.duedate_mgr_review.$error" class="font-semibold text-red-400 fs-6">
                                {{ goalv$.duedate_mgr_review.$errors[0].$message }}
                            </span>

                        </div>
                        <div class="col-span-2">
                            <h1 class="font-['poppins] text-[16px]  text-[#000]">days</h1>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 my-4">
                    <div class="col-span-5">
                        <h1 class="font-['poppins] text-[#000] text-[16px]   col-span-2">step 5:Hr-review</h1>
                    </div>
                    <div class="col-span-5 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-7">
                            <h1 class="font-['poppins] text-[#000] text-[16px]  text-right">Nett</h1>
                        </div>
                        <div class="col-span-3">
                            <InputText placeholder="Enter days" type="text"
                                v-model="useConfig.pmsConfig.goal_settings.duedate_hr_review" v-on:keypress="NumbersOnly"
                                class="w-36 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)]  p-2" :class="[
                                    goalv$.duedate_hr_review.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="goalv$.duedate_hr_review.$error" class="font-semibold text-red-400 fs-6">
                                {{ goalv$.duedate_hr_review.$errors[0].$message }}
                            </span>

                        </div>
                        <div class="col-span-2">
                            <h1 class="font-['poppins] text-[16px]  text-[#000]">days</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviewing Order -->
            <h1 class=" text-[#000] font-['poppins'] text-[18px] my-2 ">Reviewing Order</h1>
            <div class="flex flex-col">
                <Dropdown v-model="useConfig.reviewerFlowSelection.flow1" :options="useConfig.roleTypes"
                    @change="useConfig.reviewerFlowSetter(1)" optionLabel="role_type" optionValue="role_shortname"
                    placeholder="Select Reviewer" class="w-[180px]" :class="[
                        goalv$.reviewers_flow.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="goalv$.reviewers_flow.$error" class="font-semibold text-red-400 fs-6">
                    {{ goalv$.reviewers_flow.$errors[0].$message }}
                </span>

                <div class="flex items-center my-2">
                    <input type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black mx-2"
                        @change="useConfig.reviewerFlowSetter('', 1)" v-model="useConfig.enabledReviewerFlow.flow1"
                        :true-value=1 :false-value=0>
                    <label for="" class=" text-[14px] text-gray-400">Do you want to assign the pending reviewer,if the
                        current reviewer
                        does not complete the
                        review.</label>
                </div>


                <Dropdown v-model="useConfig.reviewerFlowSelection.flow2" :options="useConfig.roleTypes"
                    @change="useConfig.reviewerFlowSetter(2)" optionLabel="role_type" optionValue="role_shortname"
                    placeholder="Select Reviewer" class="w-[180px]" :class="[
                        goalv$.reviewers_flow.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="goalv$.reviewers_flow.$error" class="font-semibold text-red-400 fs-6">
                    {{ goalv$.reviewers_flow.$errors[0].$message }}
                </span>
                <div class="flex items-center my-2">
                    <input type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black mx-2"
                        v-model="useConfig.enabledReviewerFlow.flow2" :true-value=1 :false-value=0
                        @change="useConfig.reviewerFlowSetter('', 2)">
                    <label for="" class=" font-['poppins'] text-gray-400 text-[14px]">Do you want to assign the pending
                        reviewer,if the
                        current reviewer does not complete the
                        review.</label>
                </div>
                <Dropdown v-model="useConfig.reviewerFlowSelection.flow3" :options="useConfig.roleTypes"
                    @change="useConfig.reviewerFlowSetter(3)" optionLabel="role_type" optionValue="role_shortname"
                    placeholder="Select Reviewer" class="w-[180px]" :class="[
                        goalv$.reviewers_flow.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="goalv$.reviewers_flow.$error" class="font-semibold text-red-400 fs-6">
                    {{ goalv$.reviewers_flow.$errors[0].$message }}
                </span>
                <div class="flex items-center my-2">
                    <input type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black mx-2"
                        v-model="useConfig.enabledReviewerFlow.flow3" :true-value=1 :false-value=0
                        @change="useConfig.reviewerFlowSetter('', 3)">
                    <label for="" class=" font-['poppins']  text-[14px] text-gray-400">Do you want to assign the pending
                        reviewer,if the
                        current reviewer does not complete the
                        review.</label>
                </div>
                <Dropdown v-model="useConfig.reviewerFlowSelection.flow4" :options="useConfig.roleTypes"
                    @change="useConfig.reviewerFlowSetter(4)" optionLabel="role_type" optionValue="role_shortname"
                    placeholder="Select Reviewer" class="w-[180px]" :class="[
                        goalv$.reviewers_flow.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="goalv$.reviewers_flow.$error" class="font-semibold text-red-400 fs-6">
                    {{ goalv$.reviewers_flow.$errors[0].$message }}
                </span>
                <div class="flex items-center my-2">
                    <input type="checkbox" class=" w-[20px] h-[20px] my-2 !checked:bg-black mx-2"
                        v-model="useConfig.enabledReviewerFlow.flow4" :true-value=1 :false-value=0
                        @change="useConfig.reviewerFlowSetter('', 4)">
                    <label for="" class=" font-['poppins']  text-[14px] text-gray-400">Do you want to assign the pending
                        reviewer,if the
                        current reviewer does not complete the
                        review.</label>
                </div>
                <!-- <Dropdown v-model="useConfig.reviewerFlowSelection.flow5" :options="useConfig.roleTypes"
                    @change="useConfig.reviewerFlowSetter(5)" optionLabel="role_type" optionValue="role_type"
                    placeholder="Select Reviewer" class="w-[180px]" /> -->
            </div>

            <div class="table-responsive flex justify-center">
                <div class="w-[80%] flex flex-col">


                    <DataTable v-model:editingRows="editingRows" :value="useConfig.pmsConfig.score_card" editMode="row"
                        dataKey="sort_order" @row-edit-save="onRowEditSave">
                        <Column field="score_range" header="Score Rating" style="width: 20%">
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>
                        <Column field="performance_rating" header="Performance Rating" style="width: 20%">
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>
                        <Column field="ranking" header="Ranking" style="width: 20%">
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>
                        <Column field="action" header="Action" style="width: 20%">
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>
                        <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">
                        <template>
                            <div>

                            </div>
                        </template>
                        </Column>

                    </DataTable>




                </div>
                <div class="flex flex-col items-center justify-center">
                    <button class=" text-yellow-400 p-2" @click="add_more(useConfig.pmsConfig.score_card)"><i
                            class="pi pi-plus"></i> Add more</button>
                    <!-- <button class=" text-red-400 p-2" ><i class="pi pi-file-edit"></i> Edit</button> -->
                </div>

            </div>

            <div class="flex flex-col items-center my-4">
                <button v-if="useConfig.canFreezeCalendarSetting" @click="useConfig.savePMSConfiguration()"
                    class=" bg-yellow-400 px-4 py-1 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                    Save</button>
                <button @click="submitForm()" v-else
                    class="  bg-yellow-400 px-4 py-1 my-4 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                    Save</button>
            </div>



        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, onUpdated, ref } from 'vue';
import { usePmsConfigStore } from '../stores/pmsConfigMainStore'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'


const useConfig = usePmsConfigStore()

const Toggle = ref();
var calendarType = '';
const selectedCity = ref()
const cities = ref([])
const checked = ref(true);
const startDate = ref()
const endDate = ref()
const assignmentPeriodOption = ref();


const editingRows = ref([]);

const onRowEditSave = (event) => {
    let { newData, index } = event;
    console.log(event);
    useConfig.pmsConfig.score_card[index] = newData;
};

function add_more(data) {

    let addrow = '';

    let addmore = {
        sort_order: 1,
        score_range: '',
        performance_rating: '',
        ranking: '',
        action: ''
    }

    console.log(data, 'data');

    if (data.at(-1)) {
        addrow = data.at(-1).sort_order;
        console.log(addrow, 'addrow')
        addmore.sort_order += addrow;
        useConfig.pmsConfig.score_card.push(addmore);
    } else {
        useConfig.pmsConfig.score_card.push(addmore);

    }



    // useConfig.pmsConfig.score_card.push()

}


const findCalendarType = (type) => {
    calendarType = type;
    if (type == 'financial_year') {
        // useConfig.pmsConfig.pms_calendar_settings.cal_type_full_year = `April ${new Date().getFullYear() - 1} - March ${new Date().getFullYear()}`;

        // if(new Date().getFullYear() -1 ){

        // };
        // start_date < dayjs(new Date()).format('YYYY-MM-DD') && end_date >  dayjs(new Date()).format('YYYY-MM-DD')

        if (new Date() <= new Date(new Date().getFullYear(), 3)) {
            useConfig.pmsConfig.pms_calendar_settings.cal_type_full_year = `April ${new Date().getFullYear() - 1} - March ${new Date().getFullYear()}`;
            console.log('April :: ');
            startDate.value = new Date(new Date().getFullYear() - 1, 3)
            endDate.value = new Date(new Date().getFullYear(), 2)
        } else {
            console.log('March :: ');
            useConfig.pmsConfig.pms_calendar_settings.cal_type_full_year = `April ${new Date().getFullYear()} - March ${new Date().getFullYear() + 1}`;
            startDate.value = new Date(new Date().getFullYear(), 3)
            endDate.value = new Date(new Date().getFullYear() + 1, 2)
        }

        console.log(new Date(new Date().getFullYear(), 3), new Date(new Date().getFullYear(), 2));

        // startDate.value = new Date(new Date().getFullYear(), 3)
        // endDate.value = new Date(new Date().getFullYear() + 1, 2)
    } else
        if (type == 'calendar_year') {
            useConfig.pmsConfig.pms_calendar_settings.cal_type_full_year = ` January ${new Date().getFullYear()} - December ${new Date().getFullYear()}`
            startDate.value = new Date(new Date().getFullYear(), 0)
            endDate.value = new Date(new Date().getFullYear(), 11)
        } else {
            console.log("Error : Calendar type is invalid");
        }
}


const frequencyOption = ref([
    { id: 1, title: "weekly", displayValue: "Weekly" },
    { id: 2, title: "monthly", displayValue: "Monthly" },
    { id: 3, title: "quarterly", displayValue: "Quarterly" },
    { id: 4, title: "half_yearly", displayValue: "Bi-Annually" },
    { id: 5, title: "yearly", displayValue: "Annually" },
]);

const findAssignmentPeriod = (frequency) => {
    console.log("Selected Frequency : " + frequency);
    console.log(startDate.value, 'startDate');
    console.log(endDate.value, 'endDate');
    if (frequency == 'monthly') {
        const month = generateMonthlyDropdownOptions(startDate.value, endDate.value)
        assignmentPeriodOption.value = month
        console.log(month);
    }
    else
        if (frequency == 'quarterly') {
            const quarter = generateQuarterlyDropdownOptions()
            assignmentPeriodOption.value = quarter
            console.log(quarter)
        }
        else
            if (frequency == 'half_yearly') {
                const quarter = generateBiAnnuallyDropdownOptions()
                assignmentPeriodOption.value = quarter
                console.log(quarter)
            }
            else
                if (frequency == 'yearly') {
                    const quarter = generateAnnuallyDropdownOptions()
                    assignmentPeriodOption.value = quarter
                    console.log(quarter)
                }
    if (frequency == 'weekly') {
        const month = generateWeekDropdownOptions(startDate.value, endDate.value)
        assignmentPeriodOption.value = month
        console.log(month);
    }
}

function generateMonthlyDropdownOptions(startDate, endDate) {
    const options = [];
    for (let date = new Date(startDate); date <= endDate; date.setMonth(date.getMonth() + 1)) {
        const month = date.toLocaleString('en-US', { month: 'long' });
        const year = date.getFullYear();
        options.push({ value: `${month}-${year}`, text: `${month} ${year}` })
    }
    return options;
}



function generateQuarterlyDropdownOptions() {
    const options = [];

    let quarter = ['Q-1', 'Q-2', 'Q-3', 'Q-4'];
    let current_year = new Date().getFullYear();
    let next_year = new Date().getFullYear() + 1;

    if (calendarType == 'financial_year') {
        quarter.map((x) => {
            let ui_value = '';

            if (x == 'Q-1') {
                ui_value = 'Q-1 - ( Apr - ' + current_year + ' to Jun - ' + current_year + ')';

                options.push({ value: ui_value, text: ui_value })
            }
            else
                if (x == 'Q-2') {
                    ui_value = 'Q-2 - ( Jul - ' + current_year + ' to Sept - ' + current_year + ')';

                    options.push({ value: ui_value, text: ui_value })
                }
                else
                    if (x == 'Q-3') {
                        ui_value = 'Q-3 - ( Oct - ' + current_year + ' to Dec - ' + current_year + ')';

                        options.push({ value: ui_value, text: ui_value })
                    }
                    else
                        if (x == 'Q-4') {
                            ui_value = 'Q-4 - ( Jan - ' + next_year + ' to Mar - ' + next_year + ')';

                            options.push({ value: ui_value, text: ui_value })
                        }

        });
    }
    else
        if (calendarType == 'calendar_year') {
            quarter.map((x) => {
                let ui_value = '';

                if (x == 'Q-1') {
                    ui_value = 'Q-1 - ( Jan - ' + current_year + ' to Mar - ' + current_year + ')';

                    options.push({ value: ui_value, text: ui_value })
                }
                else
                    if (x == 'Q-2') {
                        ui_value = 'Q-2 - ( Apr - ' + current_year + ' to Jun - ' + current_year + ')';

                        options.push({ value: ui_value, text: ui_value })
                    }
                    else
                        if (x == 'Q-3') {
                            ui_value = 'Q-3 - ( Jul - ' + current_year + ' to Sept - ' + current_year + ')';

                            options.push({ value: ui_value, text: ui_value })
                        }
                        else
                            if (x == 'Q-4') {
                                ui_value = 'Q-4 - ( Oct - ' + current_year + ' to Dec - ' + current_year + ')';

                                options.push({ value: ui_value, text: ui_value })
                            }


            });

        }

    return options;
}

function generateBiAnnuallyDropdownOptions() {
    const options = [];

    let current_year = new Date().getFullYear();
    let next_year = new Date().getFullYear() + 1;

    if (calendarType == 'financial_year') {

        let ui_value = 'H1 - ( Apr - ' + current_year + ' to Sept - ' + current_year + ')';
        options.push({ value: ui_value, text: ui_value })

        ui_value = 'H2 - ( Oct - ' + current_year + ' to Mar - ' + next_year + ')';
        options.push({ value: ui_value, text: ui_value })

    }
    else
        if (calendarType == 'calendar_year') {

            let ui_value = 'H1 - ( Jan - ' + current_year + ' to Jun - ' + current_year + ')';
            options.push({ value: ui_value, text: ui_value })

            ui_value = 'H2 - ( Jul - ' + current_year + ' to Dec - ' + current_year + ')';
            options.push({ value: ui_value, text: ui_value })
        }

    return options;
}

function generateAnnuallyDropdownOptions() {
    const options = [];

    let current_year = new Date().getFullYear();
    let next_year = new Date().getFullYear() + 1;

    if (calendarType == 'financial_year') {

        let ui_value = 'Y - ( Apr - ' + current_year + ' to Mar - ' + next_year + ')';
        options.push({ value: ui_value, text: ui_value })

    }
    else
        if (calendarType == 'calendar_year') {

            let ui_value = 'Y - ( Jan - ' + current_year + ' to Dec - ' + current_year + ')';
            options.push({ value: ui_value, text: ui_value })
        }

    return options;
}


function generateWeekDropdownOptions(startDate, endDate) {
    const options = [];

    // Ensure the start date is before the end date
    if (startDate > endDate) {
        return options;
    }

    // Loop through each week within the specified date range
    let i = 0;
    for (let date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 7)) {
        const weekStartDate = new Date(date);
        const weekEndDate = new Date(date.getTime() + 6 * 24 * 60 * 60 * 1000); // End of the week

        const weekStartString = weekStartDate.toDateString();
        const weekEndString = weekEndDate.toDateString();

        options.push({ value: `W${i + 1} - (${weekStartString} - ${weekEndString})`, text: `${i + 1} -(${weekStartString} ${weekEndString})` });
        i++;
    }

    return options;
}
function NumbersOnly(evt) {
    var charCode = evt.which || evt.keyCode;

    // Check if the key is a digit or a valid character
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
    }

}


// Define a method to filter out non-numeric characters
const filterNonNumeric = (field) => {
    useConfig.value[field] = useConfig.value[field].replace(/[^0-9]/g, '');
};
// calender setting
const calenderRules = computed(() => {
    return {
        frequency: { required: helpers.withMessage('Frequency is required', required) },
        assignment_period: { required: helpers.withMessage('Assignment Period is required', required) },
    }
})
const calv$ = useValidate(calenderRules, useConfig.pmsConfig.pms_calendar_settings)
// basic setting
const basicRules = computed(() => {
    return {
        can_assign_upcoming_goals: { required: helpers.withMessage('Goal is required', required) },
        annual_score_cal_method: { required: helpers.withMessage('Score is Required', required) },
        can_emp_proceed_nextpms_wo_currpms_completion: { required: helpers.withMessage('Value is Required', required) },
        can_org_proceed_nextpms_wo_currpms_completion: { required: helpers.withMessage('Value is Required', required) },
    }
})

const v$ = useValidate(basicRules, useConfig.pmsConfig.pms_basic_settings)
// dashboard setting
const dashboardRules = computed(() => {
    return {
        can_show_overall_score_in_selfappr_dashboard: { required: helpers.withMessage('Value is Required', required) },
        can_show_rating_card_in_review_page: { required: helpers.withMessage('Value is Required', required) },
        can_show_overall_scr_card_in_review_page: { required: helpers.withMessage('Value is Required', required) },
    }
})
const dv$ = useValidate(dashboardRules, useConfig.pmsConfig.pms_dashboard_page)

// remainder  first alert employee
const remainderRules = computed(() => {
    return {
        active: { required: helpers.withMessage('Value is Required', required) },
        notif_count: {
            required: helpers.withMessage('Value is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert) {
                    if (useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active == 1) {
                        if (value) {
                            return true
                        } else {
                            return false
                        }
                    } else {
                        return true
                    }
                }

            })
        },
        notif_mode: {
            required: helpers.withMessage('Mode is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate.active == 1) {
                    if (value.length > 0) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        },
    }
})
const rfv$ = useValidate(remainderRules, useConfig.pmsConfig.remainder_alert.can_alert_emp_bfr_duedate)
// remainder second alert employee
const overDueRemaindersRules = computed(() => {
    return {
        active: { required: helpers.withMessage('Value is Required', required) },
        notif_count: {
            required: helpers.withMessage('Value is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active == 1) {
                    if (value) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        },
        notif_mode: {
            required: helpers.withMessage('Mode is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate.active == 1) {
                    if (value.length > 0) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        }
    }
})
const rsv$ = useValidate(overDueRemaindersRules, useConfig.pmsConfig.remainder_alert.can_alert_emp_for_overduedate)
// remainder first manager alert
const firstRemainderForManagerRules = computed(() => {
    return {
        active: { required: helpers.withMessage('Value is Required', required) },
        notif_count: {
            required: helpers.withMessage('Value is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active == 1) {
                    if (value) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        },
        notif_mode: {
            required: helpers.withMessage('Mode is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate.active == 1) {
                    if (value.length > 0) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        }
    }
})
const rmfv$ = useValidate(firstRemainderForManagerRules, useConfig.pmsConfig.remainder_alert.can_alert_mgr_bfr_duedate)
// remainder second manager alert
const secondRemainderForManagerRules = computed(() => {
    return {
        active: { required: helpers.withMessage('Value is Required', required) },
        notif_count: {
            required: helpers.withMessage('Value is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active == 1) {
                    if (value) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        },
        notif_mode: {
            required: helpers.withMessage('Mode is Required', (value) => {
                if (useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate.active == 1) {
                    if (value.length > 0) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return true
                }
            })
        }
    }
})
const rmsv$ = useValidate(secondRemainderForManagerRules, useConfig.pmsConfig.remainder_alert.can_alert_mgr_for_overduedate)
// pms metrics
const pmsRules = computed(() => {
    return {
        pms_metrics: { required: helpers.withMessage('PMS Metrics is Required', required) }
    }
})
const pmsv$ = useValidate(pmsRules, useConfig.pmsConfig)

// goal setting rules
const goalRules = computed(() => {
    return {
        who_can_set_goal: { required: helpers.withMessage('Goal Setter is Required', required) },
        should_emp_acp_rej_goals: { required: helpers.withMessage('Value is Required', required) },
        should_mgr_appr_rej_goals: { required: helpers.withMessage('Value is Required', required) },
        duedate_goal_initiate: { required: helpers.withMessage('Days is Required', required) },
        duedate_approval_acceptance: { required: helpers.withMessage('Days is Required', required) },
        duedate_self_review: { required: helpers.withMessage('Days is Required', required) },
        duedate_mgr_review: { required: helpers.withMessage('Days is Required', required) },
        duedate_hr_review: { required: helpers.withMessage('Days is Required', required) },
        reviewers_flow: { required: helpers.withMessage('Reviewer Flow is Required', required) }
    }
})
const goalv$ = useValidate(goalRules, useConfig.pmsConfig.goal_settings)
const submitForm = () => {

    v$.value.$validate()
    dv$.value.$validate()
    rfv$.value.$validate()
    rsv$.value.$validate()
    rmfv$.value.$validate()
    rmsv$.value.$validate()
    pmsv$.value.$validate()
    goalv$.value.$validate()
    calv$.value.$validate()
    // checks all inputs
    if ((!v$.value.$error) && (!dv$.value.$error) && (!calv$.value.$error)) {
        if ((!rfv$.value.$error) && (!rsv$.value.$error) && (!rmfv$.value.$error) && (!rmsv$.value.$error)) {
            if ((!pmsv$.value.$error) && (!goalv$.value.$error)) {
                console.log('Form submitted successfully')
                useConfig.savePMSConfiguration()
                calv$.value.$reset()
                v$.value.$reset()
                dv$.value.$reset()
                rfv$.value.$reset()
                rsv$.value.$reset()
                rmfv$.value.$reset()
                rmsv$.value.$reset()
                pmsv$.value.$reset()
                goalv$.value.$reset()
            }
            else {
                console.log('Form failed validation')
            }
        }
        else {
            console.log('remainder_alert Form failed validation')
        }

    } else {
        console.log('calender basic dashboard cleared Form failed validation')

    }
}


onMounted(async () => {

    useConfig.getPmsSettings();
    await useConfig.getPmsConfigSettings()
    await useConfig.getSessionClient()

    startDate.value = new Date(new Date().getFullYear(), 3)
    endDate.value = new Date(new Date().getFullYear() + 1, 2)
    useConfig.pmsConfig.pms_calendar_settings.cal_type_full_year = ` April ${new Date().getFullYear()} - March ${new Date().getFullYear() + 1}`

    findCalendarType(useConfig.pmsConfig.pms_calendar_settings ? useConfig.pmsConfig.pms_calendar_settings.calendar_type : '');
    findAssignmentPeriod(useConfig.pmsConfig.pms_calendar_settings ? useConfig.pmsConfig.pms_calendar_settings.frequency : '');

    //  useConfig.pmsConfig.pms_calendar_settings.frequency


    // setTimeout(()=>{
    // console.log(useConfig.pmsConfig ? useConfig.pmsConfig.pms_calendar_settings.frequency : '' ,'useConfig.pmsConfig.pms_calendar_settings.frequency');

    // },3000);

    // console.log();
})
</script>

<style scoped>
.p-dropdown
{
    background: #E6E6E6 !important;
}

.p-dropdown-label
{
    margin-top: 30px !important;
}</style>
