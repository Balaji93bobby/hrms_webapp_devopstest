<template>
    <div class=" bg-white rounded-lg  h-[80%]  font-['poppins'] " v-if="usePayrun.payroll_stats">
        <!-- v-for="(item, index) in usePayrun.payroll_stats" :key="usePayrun.payroll_stats" -->
        <div class="w-full h-[50px]   bg-gray-200 p-2 grid grid-cols-3 gap-4 rounded-md">
            <div class="ml-2">
                <p class="text-[#888888]   font-semibold text-[11px] whitespace-nowrap">Total Employees</p>
                <p class="font-semibold pr-[6px] fs-6">{{ usePayrun.payroll_stats.total_employees }}

                    <img src="../calculatedPayrollPerMonth/assests/down_arrow.png" alt="" class="w-[12px] h-[10px] ">

                    <span class="font-semibold pl-[6px] pr-[6px] fs-6">{{ usePayrun.payroll_stats.exit_employees }} </span>

                    <img src="../calculatedPayrollPerMonth/assests/Arrow.png" class="w-[10px] h-[10px] ml-1" alt="">

                    <span class="font-semibold fs-6 pl-[6px]">{{ usePayrun.payroll_stats.new_employees }} </span>
                </p>
            </div>
            <div class="ml-5">
                <p class="text-[#888888] font-semibold text-[11px] whitespace-nowrap">Calendar Days</p>
                <p class="font-semibold fs-6">{{ usePayrun.payroll_stats.calendar_days }}</p>
            </div>
            <div class="ml-5">
                <p class="text-[#888888] font-semibold text-[11px] whitespace-nowrap">Payroll Processed</p>
                <p class="font-semibold fs-6">{{ usePayrun.payroll_stats.payroll_processed }}</p>
            </div>
        </div>
        <!-- 1 -->
        <div class="px-3 h-12 ">
            <div class="my-1">
                <div class="grid grid-cols-12">
                    <div class="col-span-6">
                        <p class="text-gray-500 font-semibold text-[12px]">Total Payroll Cost</p>
                        <p class="font-semibold text-xs"
                            v-if="String(usePayrun.payroll_stats.pre_month_cost).includes('-')"> {{
                                usePayrun.payroll_stats.previous_month }} <span class="font-semibold text-xs text-red-400">INR
                                {{ usePayrun.payroll_stats.pre_month_cost }}</span>
                            <img src="../calculatedPayrollPerMonth/assests/down_arrow.png" alt=""
                                class="w-[10px] h-[8px]  ">
                        </p>
                        <p class="font-semibold text-xs" v-else> {{ usePayrun.payroll_stats.previous_month }} <span
                                class="font-semibold text-xs text-green-400">INR {{
                                    usePayrun.payroll_stats.pre_month_cost }}</span>
                                    <img src="../calculatedPayrollPerMonth/assests/Arrow.png" class="w-[10px] h-[10px] ml-1" alt="">
                        </p>
                    </div>
                    <div class="col-span-2">
                        =
                    </div>
                    <div class="col-span-4">
                        <p class="font-semibold fs-6  text-right">INR {{ usePayrun.payroll_stats.total_payroll_cost }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3  h-12 text-[15px]">
            <div class="my-2">
                <div class="grid grid-cols-12">
                    <div class="col-span-6">
                        <p class="text-gray-500 font-semibold text-[12px]">Employee Deposit</p>
                        <p class="font-semibold text-xs"
                            v-if="String(usePayrun.payroll_stats.pre_month_deposit).includes('-')"> {{
                                usePayrun.payroll_stats.previous_month }} <span class="font-semibold text-xs text-red-400">INR
                                {{ usePayrun.payroll_stats.pre_month_deposit }}</span>
                            <img src="../calculatedPayrollPerMonth/assests/down_arrow.png" alt=""
                                class="w-[10px] h-[8px]  ">
                        </p>
                        <p class="font-semibold text-xs" v-else> {{ usePayrun.payroll_stats.previous_month }} <span
                                class="font-semibold text-xs text-green-400">INR {{
                                    usePayrun.payroll_stats.pre_month_deposit }}</span>
                            <!-- <img src="../calculatedPayrollPerMonth/assests/up_arrow.png" alt="" class="w-[10px] h-[8px]  "> -->
                            <img src="../calculatedPayrollPerMonth/assests/Arrow.png" class="w-[10px] h-[10px] ml-1" alt="">
                        </p>
                    </div>
                    <div class="col-span-2">
                        =
                    </div>
                    <div class="col-span-4   ">
                        <p class="font-semibold fs-6 text-right"> INR {{ usePayrun.payroll_stats.employee_deposit }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-3 h-12  ">
            <div class="my-2">
                <div class="grid grid-cols-12">
                    <div class="col-span-6">
                        <p class="text-gray-500 font-semibold text-[12px]">Total Deductions</p>
                        <p class="font-semibold text-xs"
                            v-if="String(usePayrun.payroll_stats.pre_month_deduction).includes('-')"> {{
                                usePayrun.payroll_stats.previous_month }} <span class="font-semibold text-xs text-red-400">INR
                                {{ usePayrun.payroll_stats.pre_month_deduction }}</span>
                            <img src="../calculatedPayrollPerMonth/assests/down_arrow.png" alt=""
                                class="w-[10px] h-[8px]  ">
                        </p>
                        <p class="font-semibold text-xs" v-else> {{ usePayrun.payroll_stats.previous_month }} <span
                                class="font-semibold text-xs text-green-400">INR {{
                                    usePayrun.payroll_stats.pre_month_deduction }}</span>
                                    <img src="../calculatedPayrollPerMonth/assests/Arrow.png" class="w-[10px] h-[10px] ml-1" alt="">
                        </p>
                    </div>
                    <div class="col-span-2">
                        =
                    </div>
                    <div class="col-span-4">
                        <p class="font-semibold fs-6 text-right"> INR {{ usePayrun.payroll_stats.total_deductions }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-3 h-12 ">
            <div class="my-2">
                <div class="grid grid-cols-12">
                    <div class="col-span-6">
                        <p class="text-gray-500 font-semibold text-[12px]">Total Contributions </p>
                        <p class="font-semibold text-xs"
                            v-if="String(usePayrun.payroll_stats.pre_month_contribution).includes('-')"> {{
                                usePayrun.payroll_stats.previous_month }} <span class="font-semibold text-xs text-red-400">INR
                                {{ usePayrun.payroll_stats.pre_month_contribution }}</span>
                            <img src="../calculatedPayrollPerMonth/assests/down_arrow.png" alt=""
                                class="w-[10px] h-[8px]  ">
                        </p>
                        <p class="font-semibold text-xs" v-else> {{ usePayrun.payroll_stats.previous_month }} <span
                                class="font-semibold text-xs text-green-400">INR {{
                                    usePayrun.payroll_stats.pre_month_contribution }}</span>
                        <img src="../calculatedPayrollPerMonth/assests/Arrow.png" class="w-[10px] h-[10px] ml-1" alt="">
                        </p>
                    </div>
                    <div class="col-span-2">
                        =
                    </div>
                    <div class="col-span-4">
                        <p class="font-semibold fs-6 text-right">INR {{ usePayrun.payroll_stats.total_contributions }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div></template>
<script setup>
import { payrunMainStore } from '../stores/payrunMainStore';

const usePayrun = payrunMainStore();
</script>








