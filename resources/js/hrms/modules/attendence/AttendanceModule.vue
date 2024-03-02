<template>
    <LoadingSpinner v-if="useTimesheet.canShowApplyRegularizationLoading" class="!z-[10000] h-[100vh]" />
    <div class="w-full">

        <div class=" flex justify-between items-end mb-4">
            <ul class="divide-x nav nav-pills divide-solid   border-b-[3px] mx-2 border-gray-300 w-[100%]">
                <li class=" nav-item cursor-pointer" role="presentation">
                    <a class="px-2 position-relative border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        @click="activetab = 1,useTimesheet.currentlySelectedTimesheet = 1"
                        :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        Timesheet
                    </a>
                    <div v-if="activetab === 1" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-2 border-gray-300  rounded-l-3xl"></div> -->
                </li>
                <li class=" nav-item cursor-pointer" role="presentation" v-if="service.current_user_role == 1 || service.current_user_role == 2 || service.current_user_role == 4" >
                    <a class="px-2 position-relative border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        @click="activetab = 2,useTimesheet.currentlySelectedTimesheet = 2"
                        :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        Team Timesheet
                    </a>
                    <div v-if="activetab === 2" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-2 border-gray-300  rounded-l-3xl"></div> -->
                </li>
                <li class=" nav-item cursor-pointer" role="presentation"  v-if="service.current_user_role == 1 ||service.current_user_role == 2 || service.current_user_role == 3" >
                    <a class="px-2 position-relative border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        @click="activetab = 3,useTimesheet.currentlySelectedTimesheet = 3"
                        :class="[activetab === 3 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        Org Timesheet
                    </a>
                    <div v-if="activetab === 3" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-2 border-gray-300  rounded-l-3xl"></div> -->
                </li>
            </ul>
        </div>

        <div class="mb-2 card" v-if="false">
            <div class="card-body">

                <div class="row ">
                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="fas fa-fingerprint me-2 text-success "></i>Biometric
                        </p>

                    </div>

                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i
                                class="fa fa-exclamation-circle text-warning fs-15 me-2"></i>Not
                            Applied</p>

                    </div>

                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="badge bg-primary rounded-pill me-2 ">LC</i>Late
                            Coming
                        </p>

                    </div>
                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="badge bg-info rounded-pill me-2 ">MOP</i>Missed
                            Out
                            Punch</p>

                    </div>
                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="fa fa-laptop me-2 text-info"></i>Web </p>

                    </div>
                    <div class="mb-2 col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-3">

                        <p class="fw-bold textColor fs-12"><i class="fa fa-times-circle me-2 text-danger"></i>Rejected
                        </p>

                    </div>




                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class='fa fa-check-circle text-success me-1'></i> Approved
                        </p>

                    </div>
                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i
                                class="fa fa-question-circle fs-15 text-secondary me-2"></i>Pending</p>

                    </div>

                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4 ">

                        <p class="fw-bold textColor fs-12"><i class="badge bg-orange rounded-pill me-2 ">EG</i>Early
                            Going
                        </p>

                    </div>
                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="badge bg-dark rounded-pill me-3 ">MIP</i>Missed In
                            Punch</p>

                    </div>
                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="fa fa-mobile text-dark fs-15 me-3 "></i>Mobile</p>

                    </div>
                    <div class="col-xl-2 col-xxl-2 col-lg-2 col-md-3 col-sm-4">

                        <p class="fw-bold textColor fs-12"><i class="fa fa-picture-o me-2" aria-hidden="true"></i>View
                            Image</p>

                    </div>
                </div>



            </div>
        </div>
        <div class="mb-0 "  v-if="false">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="timesheet" role="tabpanel" aria-labelledby="pills-home-tab">
                        <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                        <div class="overflow-x-auto  h-[80vh] overflow-y-scroll"
                            v-if="useTimesheet.currentEmployeeAttendance">
                            <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                                :single-attendance-day="useTimesheet.currentEmployeeAttendance" />
                            <ClassicTimesheet v-else :single-attendance-day="useTimesheet.currentEmployeeAttendance"
                                :sidebar="useTimesheet.classicTimesheetSidebar" />
                        </div>
                    </div>

                    <div class="tab-pane fade " id="team" role="tabpanel">
                        <div class="flex  h-[80vh] overflow-hidden" v-if="teamListLength > 0">
                            <div class="min-w-max">
                                <EmployeeList :source="teamList" :is-team="true" />
                            </div>
                            <div class="overflow-x-auto ml-2 w-100 rounded-lg"
                                v-if="useTimesheet.currentlySelectedTeamMemberAttendance">
                                <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                                <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                                    :single-attendance-day="useTimesheet.currentlySelectedTeamMemberAttendance" />
                                <ClassicTimesheet v-else
                                    :single-attendance-day="useTimesheet.currentlySelectedTeamMemberAttendance"
                                    :sidebar="useTimesheet.classicTimesheetSidebar" />
                            </div>
                        </div>
                        <div class="mr-4 card pb-10" v-else>
                            <img src="../../assests/images/svg_oops.svg" alt="" srcset="" class="w-5 p-6 m-auto">
                            <!-- <p class="my-2 font-semibold fs-3 text-center">You are not eligible to apply salary advance</p> -->
                        </div>
                    </div>
                    <div class="tab-pane fade " id="org" role="tabpanel">
                        <div class="flex h-[80vh] overflow-hidden" v-if="orgListLength > 0">
                            <div class="min-w-max h-[100%]">
                                <EmployeeList :source="orgList" :is-team="false" />
                            </div>
                            <div class="overflow-x-auto ml-2 h-[100%] w-100 rounded-lg "
                                v-if="useTimesheet.currentlySelectedOrgMemberAttendance">
                                <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                                <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                                    :single-attendance-day="useTimesheet.currentlySelectedOrgMemberAttendance" />
                                <ClassicTimesheet v-else
                                    :single-attendance-day="useTimesheet.currentlySelectedOrgMemberAttendance"
                                    :sidebar="useTimesheet.classicTimesheetSidebar" />
                            </div>
                        </div>
                        <div class="mr-4 card pb-10" v-else>
                            <img src="../../assests/images/svg_oops.svg" alt="" srcset="" class="w-5 p-6 m-auto">
                            <!-- <p class="my-2 font-semibold fs-3 text-center">You are not eligible to apply salary advance</p> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="card" v-if="activetab == 1" >
                <div class="tab-pane fade active show">
                    <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                    <div class="overflow-x-auto  h-[80vh] overflow-y-scroll" v-if="useTimesheet.currentEmployeeAttendance">
                        <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                            :single-attendance-day="useTimesheet.currentEmployeeAttendance" />
                        <ClassicTimesheet v-else :single-attendance-day="useTimesheet.currentEmployeeAttendance"
                            :sidebar="useTimesheet.classicTimesheetSidebar" />
                    </div>
                </div>
            </div>
            <div class="card" v-if="activetab == 2" >

                <div class="flex  h-[80vh] overflow-hidden" v-if="teamListLength > 0">
                    <div class="min-w-max">
                        <EmployeeList :source="teamList" :is-team="true" />
                    </div>
                    <div class="overflow-x-auto ml-2 w-100 rounded-lg"
                        v-if="useTimesheet.currentlySelectedTeamMemberAttendance">
                        <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                        <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                            :single-attendance-day="useTimesheet.currentlySelectedTeamMemberAttendance" />
                        <ClassicTimesheet v-else :single-attendance-day="useTimesheet.currentlySelectedTeamMemberAttendance"
                            :sidebar="useTimesheet.classicTimesheetSidebar" />
                    </div>
                </div>
                <div class="mr-4 card pb-10" v-else>
                    <img src="../../assests/images/svg_oops.svg" alt="" srcset="" class="w-5 p-6 m-auto">
                    <!-- <p class="my-2 font-semibold fs-3 text-center">You are not eligible to apply salary advance</p> -->
                </div>

            </div>
            <div class="card" v-if="activetab == 3" >
                <div class="flex h-[80vh] overflow-hidden" v-if="orgListLength > 0">
                    <div class="min-w-max h-[100%]">
                        <EmployeeList :source="orgList" :is-team="false" />
                    </div>
                    <div class="overflow-x-auto ml-2 h-[100%] w-100 rounded-lg "
                        v-if="useTimesheet.currentlySelectedOrgMemberAttendance">
                        <LoadingSpinner v-if="useTimesheet.canShowLoading" class="absolute z-50 bg-white" />
                        <DetailedTimesheet v-if="useTimesheet.switchTimesheet == 'Detailed'"
                            :single-attendance-day="useTimesheet.currentlySelectedOrgMemberAttendance" />
                        <ClassicTimesheet v-else :single-attendance-day="useTimesheet.currentlySelectedOrgMemberAttendance"
                            :sidebar="useTimesheet.classicTimesheetSidebar" />
                    </div>
                </div>
                <div class="mr-4 card pb-10" v-else>
                    <img src="../../assests/images/svg_oops.svg" alt="" srcset="" class="w-5 p-6 m-auto">
                    <!-- <p class="my-2 font-semibold fs-3 text-center">You are not eligible to apply salary advance</p> -->
                </div>
            </div>
        </div>
    </div>
    <MopRegularization />
    <MipRegularization />
    <LcRegularization />
    <EgRegularization />
    <ViewSelfieImage />
    <div style="display: none;">
        <LeaveApply />
    </div>
</template>


<script setup>
import DetailedTimesheet from './timesheet/DetailedTimesheet.vue'
import ClassicTimesheet from './timesheet/ClassicTimesheet.vue'
import { useAttendanceTimesheetMainStore } from './timesheet/stores/attendanceTimesheetMainStore'
import { useCalendarStore } from './timesheet/stores/calendar'
import { Service } from '../Service/Service'
import EmployeeList from './timesheet/components/EmployeeList.vue';
import MopRegularization from './timesheet/components/MopRegularization.vue'
import MipRegularization from './timesheet/components/MipRegularization.vue';
import LcRegularization from './timesheet/components/LcRegularization.vue';
import EgRegularization from './timesheet/components/EgRegularization.vue';
import ViewSelfieImage from './timesheet/components/ViewSelfieImage.vue'
import LeaveApply from '../leave_module/leave_apply/LeaveApply.vue'



import dayjs from 'dayjs';
import { onMounted, ref } from 'vue';
import LoadingSpinner from '../../components/LoadingSpinner.vue'
// LoadingSpinnerVue

const useTimesheet = useAttendanceTimesheetMainStore()
const useCalendar = useCalendarStore()
const teamList = ref()
const orgList = ref()
const service = Service();

const teamListLength = ref(0);
const orgListLength = ref(0);
const activetab = ref(1);

onMounted(async () => {
    Service()
    await useTimesheet.getTeamList(service.current_user_code).then(res => {
        teamList.value = Object.values(res.data)
        teamListLength.value = res.data.length
    })
    await useTimesheet.getSelectedEmployeeAttendance()

    // setTimeout(() => {
    //     useTimesheet.getTeamList(service.current_user_code).then(res => {
    //         teamList.value = Object.values(res.data)
    //         teamListLength.value = res.data.length
    //     })
    // }, 3000);

    useTimesheet.getOrgList().then(res => {
        orgList.value = Object.values(res.data)
        orgListLength.value = res.data.length

    })

    // setTimeout(() => {
    //     useTimesheet.getSelectedEmployeeAttendance()
    // }, 600);


})

const emp = ref([
    {
        date: "2023-06-02 12:00",
        absent_status: null,
        attendance_mode_checkin: "web",
        attendance_mode_checkout: "mobile",
        checkin_time: "22:09:40",

    },
])
</script>


<style>
.textColor
{
    color: #003056;
}

/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active
{
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to
{
    opacity: 0;
}

.page-content
{
    padding: calc(20px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}

.p-sidebar-right .p-sidebar
{
    width: 28rem !important;
    height: 100%;
}</style>
