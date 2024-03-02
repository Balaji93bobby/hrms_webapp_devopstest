<template>
    <div class="w-full p-6 my-4 shadow-sm rounded-xl bg-blue-50 ">
        <div class="flex gap-4 pt-1 row ">
            <div class="col-4">
                <p class="font-semibold py-auto">Half Day Minimum Working Hours Required</p>
            </div>
            <div  class="flex gap-4 col-4 ">
                <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.halfday_min_workhrs" inputId="minmax" :min="0" :max="24" />
                <p class="mt-1 text-lg font-semibold text-gray-600 py-auto ">Hrs</p>


            </div>


        </div>
        <div class="flex gap-4 pt-4 row">
            <div class="col-4">
                <p class="font-semibold py-auto">Full Day Minimum Working Hours Required</p>
            </div>
            <div class="flex gap-4 col-4">
                <!-- <InputText class="w-8 h-11" type="text" v-model="txt_shift_start_time" /> -->
                <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.fullday_min_workhrs" inputId="minmax" :min="0" :max="24" />
                <p class="mt-1 text-lg font-semibold text-gray-600 py-auto">Hrs</p>

            </div>


        </div>
        <div class="my-3 text-end">

            <button
                class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4 "  @click="useAttendanceStore.manageshift_exemption_steps--" >Previous</button>
            <button
                class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"  @click="useAttendanceStore.manageshift_exemption_steps++" >Next</button>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import {useAttendanceSettingMainStore} from '../../stores/attendanceSettingMainStore';

const useAttendanceStore  = useAttendanceSettingMainStore();

const position = ref("center");
let canShowAssignShift = ref(false);

const openPosition = (pos) => {
    position.value = pos;
    canShowAssignShift.value = true;
};


</script>
