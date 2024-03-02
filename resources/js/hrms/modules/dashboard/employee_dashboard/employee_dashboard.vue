<template>
    <div class=" p-2 " @mousemove="useDashboard.canShowConfiguration = false">
        <div class="grid grid-cols-12 gap-4" >
            <div class="col-span-5 w-[100%] !rounded-[20px]  ">
                <WelcomeCard   />
            </div>
            <div class="col-span-4 w-[100%]  !rounded-[20px] ">
                <LeaveDetials />
            </div>
            <div class="col-span-3 w-[100%]  !rounded-[20px]  ">
                <HolidayWidget />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 ">
            <div class="col-span-8 !rounded-[20px]">
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div class="!rounded-[20px] overflow-hidden">
                        <LeaveBalance />
                    </div>
                    <div class="!rounded-[20px] overflow-hidden">
                        <Calender />
                    </div>
                </div>
                <div class="grid grid-cols-1 ">
                    <div>
                        <events />
                    </div>
                </div>
            </div>
            <div class="col-span-4 my-2">
                <Notification />
            </div>
        </div>
    </div>
</template>

<script setup>
import WelcomeCard from "./welcome_card/welcome_card.vue";
import LeaveDetials from "./leave_details/leave_details.vue";
import Notification from "./notifications/notification.vue";
import LeaveBalance from "./leave_balance/leave_balance.vue";
import Calender from "./calender/calender.vue";
import HolidayWidget from "./holiday_widget/holiday_widget.vue";
import events from "../events/events.vue";
import * as ExcelJS from 'exceljs'

import { useMainDashboardStore } from "../stores/dashboard_service";


const useDashboard = useMainDashboardStore()

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
