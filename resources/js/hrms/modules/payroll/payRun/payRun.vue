<template>
    <div class="w-full ]">
        <!--Current  Financial Year  calculation -->
        <div class="">
            <CurrentFinancialYearStatus />
        </div>
        <!-- Run Current Month Payroll -->
        <div class="my-2">
            <p class="font-['poppins'] fs-6 ">{{ usePayrun.selectedmonthdate}} <span class="text-[#8B8B8B]">{{ usePayrun.selectedmonthstartenddate}}</span></p>
        </div>
        <div class="grid grid-cols-3  ">
            <div class=" col-span-2  pr-3  ... ">

                    <RunPayroll />
                <div class="my-2">
                    <PayrollOutCome />
                </div>
            </div>
            <div class="grid col-span-1 h-[10%] gap-4 ">
                <div class="...">
                    <calculatedPayRollPerMonth />
                <div class="... my-2">
                    <Activity />
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <LeaveAttendanceDailyWages v-if="route.params.module == 'leave'" />
    <newJoineeAndExitEmployeeVue v-if="route.params.module == 'attendance'" />
    <bonusSalaryRevision v-if="route.params.module == 'Salary-Revisions'" />
    <reimbursementAdhoc v-if="route.params.module == 'Reimbursement'" />
    <salaryHold v-if="route.params.module == 'Salaries-Hold'" />
    <overRide v-if="route.params.module == 'Override'" /> -->


    <!-- <leaveApplied /> -->
</template>

<script setup>
import CurrentFinancialYearStatus from './currentFinancialYearStatus/currentFinancialYearStatus.vue'
import RunPayroll from './runPayroll/runPayroll.vue'
import calculatedPayRollPerMonth from './calculatedPayrollPerMonth/calculatedPayrollPerMonth.vue'
import PayrollOutCome from './payrollOutcome/payrollOutcome.vue';
import Activity from './activity/activity.vue'

import { payrunMainStore } from './stores/payrunMainStore'

import LeaveAttendanceDailyWages from './runPayroll/leaveAttendanceDailyWages/leaveAttendanceDailyWages.vue';
import newJoineeAndExitEmployeeVue from './runPayroll/newJoineeAndExitEmployee/newJoineeAndExitEmployee.vue';
import bonusSalaryRevision from './runPayroll/bonusSalaryRevisionOvertime/bonusSalaryRevisionOvertime.vue'
import reimbursementAdhoc from './runPayroll/reimbursementAdhocPaymentDeduction/reimbursementAdhocPaymentDeduction.vue'
import salaryHold from './runPayroll/salaryOnHoldAndArrears/salaryOnHoldAndArrears.vue'
import overRide from './runPayroll/overRide/overRide.vue'

import managePayment from './payrollOutcome/managePayment.vue';
import leaveApplied from './runPayroll/leaveAttendanceDailyWages/leaveApplied/leaveApplied.vue';


import { useRouter, useRoute } from "vue-router";
import { onMounted } from 'vue';
const router = useRouter();
const route = useRoute();


const usePayrun = payrunMainStore()






onMounted(() => {
    usePayrun.getLeaveDetails()
})

</script>

<style>
.page-content
{
    padding: calc(40px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>
