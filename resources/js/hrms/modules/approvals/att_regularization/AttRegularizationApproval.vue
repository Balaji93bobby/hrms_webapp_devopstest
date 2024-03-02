<template>
    <Toast />
    <LoadingSpinner v-if="UseAttendance.canShowLoadingScreen" class="absolute z-50 bg-white w-[100%] h-[100%]" />
    <div class="w-full">
        <h6 class="mb-0 text-[18px] font-semibold my-4 ">Attendance Regularization Approvals</h6>
        <div class="p-2 pb-0 my-2 mb-3 rounded-lg">
            <div class="flex justify-between">
                <ul class="py-auto nav nav-pills divide-solid nav-tabs-dashed " id="pills-tab"
                    role="tablist">
                    <li class="nav-item text-muted" role="presentation">
                        <a class="pb-2 nav-link active" data-bs-toggle="tab" href="#leave_balance" aria-selected="true"
                            role="tab">
                            Attendance Regularization</a>
                    </li>
                    <li class="nav-item text-muted " role="presentation">
                        <a class="pb-2 mx-4 nav-link" data-bs-toggle="tab" href="#team_leaveBalance" aria-selected="false"
                            tabindex="-1" role="tab">
                            Absent Regularization</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content h-[100vh]" id="pills-tabContent">

            <div class="tab-pane show fade active" id="leave_balance" role="tabpanel" aria-labelledby="pills-profile-tab">
                <attendance_regularization />
            </div>
            <div class="tab-pane fade show " id="team_leaveBalance" role="tabpanel" aria-labelledby="pills-profile-tab">
                <absent_regularization />
            </div>


        </div>
    </div>
</template>


<script setup>
import attendance_regularization from "./attendance_regularization.vue";
import absent_regularization from "./absent_Regularization.vue";
import LoadingSpinner from '../../../components/LoadingSpinner.vue';
import { UseAttendanceStore } from "./AttendanceStore";

const UseAttendance = UseAttendanceStore();

</script>



