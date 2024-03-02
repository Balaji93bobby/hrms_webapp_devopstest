<template>
    <div class="w-full pl-1" >
        <div class="w-full tabs pl-3 row ">
            <a class="flex px-6 col-lg-2 col-xl-2 col-md-2" @click="useAttendanceStore.manageshift_exemption_steps = 1"
                :class="[useAttendanceStore.manageshift_exemption_steps === 1 ? 'active' : '']">
                <div class="md:text-sm" :style="{ width: '25px' }">1</div>Shift Details
            </a>
            <a class="flex px-6 col-lg-2 col-xl-2 col-md-2" @click="useAttendanceStore.manageshift_exemption_steps = 2"
                :class="[useAttendanceStore.manageshift_exemption_steps === 2 ? 'active' : '']">
                <div>2</div>Break Time Range
                <!-- Shift Time Range -->
            </a>
            <a class="flex px-6 col-lg-2 col-xl-2 col-md-2" @click="useAttendanceStore.manageshift_exemption_steps = 3"
                :class="[useAttendanceStore.manageshift_exemption_steps === 3 ? 'active' : '']">
                <div>3</div>Working Hours
            </a>
            <a class="flex px-2 col-lg-2 col-xl-2 col-md-2" @click="useAttendanceStore.manageshift_exemption_steps = 4"
                :class="[useAttendanceStore.manageshift_exemption_steps === 4 ? 'active' : '']">
                <div>4</div>Late Coming & Early Going
            </a>
            <!-- <a class="flex px-2 col-lg-2 col-xl-2 col-md-2 text-center" @click="useAttendanceStore.manageshift_exemption_steps = 5"
                :class="[useAttendanceStore.manageshift_exemption_steps === 5 ? 'active' : '']"  >
                <div>5</div>
            </a> -->

        </div>

        <div class="bg-white rounded-md">
            <div v-if="useAttendanceStore.manageshift_exemption_steps === 1" class="tabcontent">
                <Att_AssignWorkShifts />
            </div>
            <div v-if="useAttendanceStore.manageshift_exemption_steps === 2" class="tabcontent">
                <!-- <ShiftTimeRange /> -->
                <BreakTimeRange />
            </div>
            <div v-if="useAttendanceStore.manageshift_exemption_steps === 3" class="tabcontent">
                <WorkingHours />
            </div>
            <div v-if="useAttendanceStore.manageshift_exemption_steps === 4" class="tabcontent">
                <LateEarlyGoing />
            </div>
            <!-- <div v-if="useAttendanceStore.manageshift_exemption_steps === 5" class="tabcontent">

            </div> -->
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Att_AssignWorkShifts from "../AssignShift/Att_AssignWorkShifts.vue";
import ShiftTimeRange from "../ShiftTimeRange/ShiftTimeRange.vue";
import BreakTimeRange from "../BreakTimeRange/BreakTimeRange.vue";
import WorkingHours from "../WorkingHours/WorkingHours.vue";
import LateEarlyGoing from "../LateEarlyGoing/LateEarlyGoing.vue";
import { useAttendanceSettingMainStore } from "../../stores/attendanceSettingMainStore";

const useAttendanceStore = useAttendanceSettingMainStore();


</script>

<style>
.tabs {
    overflow: hidden;
    margin-bottom: -2px;
}

.tabs ul {
    list-style-type: none;
}

.tabs a {
    float: left;
    cursor: pointer;
    color: #fff;
    padding: 12px 18px;
    transition: background-color 0.2s;
    border: 1px solid #003056;
    border-right: none;
    background-color: #003056;
    font-weight: 600;
    min-width: 17.5rem;
}

.tabs a>div {
    color: #aaa;
    background: #fff;
    border-radius: 50%;
    width: 20px !important;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 8px;
    font-weight: 700;
    font-family: sans-serif;
}

/* Change background color of tabs on hover */
.tabs a:hover {
    background-color: #aaa;
    color: #fff;
    border-radius: 4px 4px 0 0;

}

.tabs a:hover>div {
    background: #F36826;
    color: #fff;
    width: 20px;
    height: 20px;
    padding: 0;
}

/* Styling for active tab */
.tabs a.active {
    background-color: #fff;
    color: #0f0101;
    border-bottom: 2px solid #fff;
    cursor: default;
    border-top: 3px solid #F36826;
    border-radius: 4px 4px 0 0;
}

.tabs a.active>div {
    background: #F36826;
    color: #fff;
    width: 20px;
    height: 20px;
}

/* Style the tab content */</style>
