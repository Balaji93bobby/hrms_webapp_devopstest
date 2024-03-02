<template>
    <div class=" bg-[#E4ECFF]  h-full rounded-lg  p-3">
        <div class=" mx-4 flex items-center justify-between">
            <span class="font-semibold text-[14px] text-[#000] font-['Poppins] ">Upcomings</span>
        <i class=" pi pi-calendar text-[#000] text-[16px]"></i>
        </div>

        <div class="overflow-x-scroll bg-[#E4ECFF] rounded-lg">
            <div class="px-auto" v-if="useDashboard.attendanceDashboardUpcoming"
                v-for="request in  useDashboard.attendanceDashboardUpcoming ">
                <div
                    class="p-2  my-2 transition duration-700 ease-in-out bg-white rounded-lg cursor-pointer hover:-translate-y-1 hover:scale-100 ">
                    <div class="flex px-2 justify-between items-center">
                        <div>
                            <span class="text-[14px] font-semibold">{{ request.title }}</span>
                        </div>
                        <div class="flex items-center gap-6">
                            <span class="text-xl font-semibold text-black">{{ request.value }}</span>
                            <span>
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <p v-else class="font-medium text-sm text-center">No data to display</p>
        </div>
    </div>
</template>
<script setup>
import { useAttendanceDashboardMainStore } from '../stores/attendanceDashboardMainStore.js';

const useDashboard = useAttendanceDashboardMainStore()
</script>
