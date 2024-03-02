<template>
    <div class="p-2 overflow-hidden bg-white rounded-lg" style="height: 200px;">
        <span class="font-semibold text-[14px] text-[#000] font-['Poppins]">Analytics</span>
        <div class="h-full overflow-x-scroll bg-white rounded-lg">
            <!-- <div class="px-auto" v-for="request in useDashboard.hrPendingRequestCount"
                v-if="useDashboard.hrPendingRequestCount">
                <div
                    class="p-2  my-2 transition duration-700 ease-in-out bg-[#E4ECFF] rounded-lg cursor-pointer hover:-translate-y-1 hover:scale-100 ">
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
            </div> -->
            <p  class="font-medium text-sm text-center">No data to display</p>

        </div>
    </div>
</template>

<script setup>
import { useMainDashboardStore } from '../../stores/dashboard_service';

const useDashboard = useMainDashboardStore()

</script>
