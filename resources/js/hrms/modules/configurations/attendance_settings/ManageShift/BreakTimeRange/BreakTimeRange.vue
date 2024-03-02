<template>
    <div class="w-full p-6 mx-5 ">
        <div class="flex gap-4 pt-4 ">
            <div>
                <input style="height: 23px;width: 23px;" class="mt-1 form-check-input" type="radio" name="leave">
            </div>
            <div>
                <p class="font-semibold py-auto">Apply Flexible Gross Break</p>
            </div>
            <div class="flex ">
                <!-- <InputText type="text" v-model="txt_shift_start_time" class="w-8 h-10" /> -->
                <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.flexible_gross_break" inputId="minmax" :min="0" :max="59" />
                <p class="mx-4 text-lg font-semibold text-gray-600 py-auto">Min</p>

            </div>


        </div>
        <div class="p-4 my-5 rounded-lg bg-blue-50 " v-if="useAttendanceStore.change == 'Apply Standard General Shift Timing'" >
            <div class="flex gap-4 col-12">
                <input style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="leave">
                <p class="font-semibold">Split The Break Down</p>
            </div>

            <div class="flex mx-6 my-4 row"  >
                <div class="flex gap-4 col-4 ">
                    <div >
                        <p class="my-auto text-lg font-semibold py-auto">Morning</p>
                    </div>
                    <div class="flex gap-3">
                        <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.breaktime_morning" inputId="minmax" :min="0" :max="59" />
                        <p class="text-lg font-semibold text-gray-600 py-auto">Mins</p>
                    </div>
                </div>
                <div class="flex gap-4 col-4"  >
                    <div >
                        <p class="my-auto text-lg font-semibold py-auto">Lunch</p>
                    </div>
                    <div class="flex gap-3">
                        <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.breaktime_lunch" inputId="minmax" :min="0" :max="59" />
                        <p class="text-lg font-semibold text-gray-600 py-auto">Mins</p>
                    </div>

                </div>
                <div class="flex gap-4 col-4"  >
                    <div >
                        <p class="my-auto text-lg font-semibold py-auto">Evening</p>
                    </div>
                    <div class="flex gap-3">
                        <InputNumber class="w-9 h-10" v-model="useAttendanceStore.shiftDetails.breaktime_evening" inputId="minmax" :min="0" :max="59" /><p class="text-lg font-semibold text-gray-600 py-auto">Mins</p>
                    </div>

                </div>
            </div>


            <!-- <div class="flex gap-4 p-4">
                <input type="checkbox" name="" id="">
                <p class="text-lg font-semibold py-auto" >Apply To All Days Except Week Off</p>
            </div> -->
        </div>
        <div class="my-3 text-end">
            <button
                class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4 " @click="useAttendanceStore.manageshift_exemption_steps--" >Previous</button>
            <button
                class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md" @click="useAttendanceStore.manageshift_exemption_steps++" >Next</button>
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
