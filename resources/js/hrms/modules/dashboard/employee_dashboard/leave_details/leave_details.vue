<template>
    <div class="!h-[180px]  rounded-[20px] shadow-sm bg-white ">
        <div class="px-6 py-4">
            <p class=" font-[14px] font-['Poppins']  text-gray-500 ">
                Current Month - <span class="mb-2 text-xl font-semibold">{{dayjs(new Date()).format('MMMM')}}</span>
            </p>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class=" bg-[#F6F6F6] rounded-lg p-3 ">
                    <div class="px-auto  text-center ">
                        <span class="mb-2 text-3xl font-bold text-center">
                            {{ useDashboard.attenanceReportPerMonth.present_count }}
                        </span>
                        <span class="px-1 text-base font-semibold text-gray-700">Days</span>
                    </div>
                    <p class="py-2 text-lg font-semibold text-center text-gray-500">Present</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg ">
                <div class="text-center">
                    <span class="mb-2 text-3xl  font-bold ">
                        {{ useDashboard.attenanceReportPerMonth.leave_count }}
                    </span>
                    <span class="px-1 text-base font-semibold text-gray-700">Days</span>
                </div>
                    <p class="py-2 text-lg font-semibold text-center text-gray-500">Leave</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                <div class="text-center" >
                    <span class="mb-2 text-3xl font-bold text-center ">
                        {{ useDashboard.attenanceReportPerMonth.absent_count }}</span>
                    <span class="px-1 text-base font-semibold text-gray-700">Days</span>
                </div>

                    <p class="py-2 text-lg font-semibold text-center text-gray-500">Absent</p>

                </div>
            </div>

        </div>
    </div>
</template>


<script setup>

import { onMounted, ref, reactive } from "vue";
import { useMainDashboardStore } from "../../stores/dashboard_service";
import dayjs from "dayjs";

const useDashboard = useMainDashboardStore();


onMounted(() => {

})

</script>
