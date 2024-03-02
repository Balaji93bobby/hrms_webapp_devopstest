<template>
    <div class="mb-3 card">
        <div class="card-body">
            <div class="mb-2 row">
                <div class="col-sm-6 col-xl-6 col-md-6 col-lg-6">
                    <span class="font-semibold text-[14px] text-[#000] font-['Poppins]">Leave balance</span>
                </div>
                <div class="col-6 justify-content-end d-flex">
                    <LeaveApply />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-4 sm:grid-cols-1 xxl:grid-cols-6 xl:grid-cols-6 lg:grid-cols-5"
                style="display: grid;">
                <div v-for="leave_balance in useLeaveStore.array_employeeLeaveBalance" :key="leave_balance"
                    class="p-1 my-2 rounded-lg border bg-gray-100 hover:bg-slate-100 cursor-pointer">
                    <p class=" my-1 lg:text-[12px] font-semibold text-center md:text-[10px]  xl:text-[13px]">{{
                        leave_balance.leave_type }}</p>
                    <p class="my-1 text-xl font-semibold text-center">
                        <span class="text-lg font-semibold" v-if="leave_balance.leave_balance == ''">0</span>
                        <span class="text-lg font-semibold" v-else>{{ leave_balance.leave_balance }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card ">
        <div class="card-body">
            <span class="font-semibold text-[14px] text-[#000] font-['Poppins]">Leave Availed</span>
            <div class="grid gap-4 md:grid-cols-4 sm:grid-cols-1 xxl:grid-cols-6 xl:grid-cols-6 lg:grid-cols-5"
                style="display: grid;">
                <div class="bg-gray-100 border-l-4 border-indigo-300 p-1 rounded-lg border my-2 cursor-pointer hover:bg-slate-100 "
                    v-for="leave_balance in useLeaveStore.array_employeeLeaveBalance" :key="leave_balance">
                    <div class="text-center">
                        <p class="my-1 lg:text-[12px] font-semibold text-center md:text-[10px]  xl:text-[13px]">
                            {{ leave_balance.leave_type }}
                        </p>
                        <p class="my-1 text-xl font-semibold text-center">
                            <span class="text-lg font-semibold" v-if="leave_balance.availed_leaves == ''">0</span>
                            <span class="text-lg font-semibold" v-else>{{ leave_balance.availed_leaves }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import LeaveApply from '../leave_apply/LeaveApply.vue'
import { useLeaveModuleStore } from '../LeaveModuleService';
import { ref } from 'vue';

const useLeaveStore = useLeaveModuleStore()

</script>
