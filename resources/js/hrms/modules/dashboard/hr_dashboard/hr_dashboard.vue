<template>
    <div class="h-[100%] p-2 overflow-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-8 ">
                <div class="col-span-12 w-[100%]  !rounded-[20px] bg-white p-2">
                    <OrgEmployeeDetails />
                </div>

                <div class="col-span-12 !rounded-[20px]">
                    <div class="grid grid-cols-12 gap-4 my-2">
                        <div class="!rounded-[20px] overflow-hidden col-span-5">
                            <LeaveRequest />
                        </div>
                        <div class="!rounded-[20px] overflow-hidden bg-white col-span-7">
                            <OverallEmployee />
                        </div>
                    </div>
                </div>
                <div class="col-span-12">
                    <Events />
                </div>
            </div>

            <div class="col-span-4 w-[100%] !rounded-[20px] ">
                <div>
                    <Analytics />
                </div>
                <div class="py-3 h-[65%]">
                    <Notification />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import OrgEmployeeDetails from "./org_employee_details/org_employee_details.vue";
import Analytics from "./Analytics/Analytics.vue";
import Task from "./tasks/task.vue";
import EmployeeStatus from "./employee_status/employee_status.vue";
import LeaveRequest from "./leave_requests/leave_request.vue";
import Notification from '../employee_dashboard/notifications/notification.vue'
import OverallEmployee from "./overall_employees/overall_employee.vue";
import { useMainDashboardStore } from '../stores/dashboard_service';
import Events from '../events/events.vue'
import { ref } from "vue";


const useDashboard = useMainDashboardStore()

// onMounted(async ()=>{
//canShowLoadingScreen.value = true;
// await useDashboard.getMainDashboardData();
//await useDashboard.getAttendanceStatus();
//Service();
//canShowLoadingScreen.value = false;


// })

async function getHRDashboardData() {

}

const isSalaryAdvanceFeatureEnabled = ref(0)




</script>


<style>
:root
{
    --disable: #d4d4d4;
    --white: #fff;
    --navy: #002f56;
}

.orange_btn
{
    background-color: var(--disable);
    padding: 3px 30px;
    border-radius: 4px 0 0 4px;
}

.Enable_btn
{
    border: 1px solid var(--navy);
    padding: 3px 30px;
    border-radius: 0 4px 4px 0;
}
</style>
