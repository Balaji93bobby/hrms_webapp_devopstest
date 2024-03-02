<template>
    <!-- <div style="display: none;">
        <LeaveApply />
    </div> -->


    <div class="p-2 overflow-hidden bg-white rounded-lg" style="height: 200px;">
        <span class="font-semibold text-[14px] text-[#000] font-['Poppins]">Leave Balance</span>
        <div class="h-full overflow-x-scroll bg-white rounded-lg">
            <div class="px-auto">
                <a href="attendance-leave" v-for="leaveBalance in useDashboard.leaveBalancePerMonthSource" :key="leaveBalance.leave_type"
                    class="p-2 block mx-2 my-2 transition duration-700 ease-in-out bg-[#E4ECFF] rounded-lg cursor-pointer hover:-translate-y-1 hover:scale-100 ">
                    <div class="flex px-2 ">
                            <div class="">
                                <span class="text-3xl font-semibold text-black">{{ leaveBalance.leave_balance }}</span>
                                <span class="">/</span>
                                <span class="">{{ leaveBalance.availed_leaves }}</span>
                            </div>
                        <div class="px-3">
                            <p class=" font-semibold text-primary text-[14px] align-bottom  py-2">{{ leaveBalance.leave_type }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useLeaveService } from "../../../leave_module/leave_apply/leave_apply_service";
import { useMainDashboardStore } from "../../stores/dashboard_service";
import LeaveApply from "../../../leave_module/leave_apply/LeaveApply.vue";


const useDashboard = useMainDashboardStore()
const useLeave = useLeaveService()
</script>

<style>
::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #888888;
    border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
