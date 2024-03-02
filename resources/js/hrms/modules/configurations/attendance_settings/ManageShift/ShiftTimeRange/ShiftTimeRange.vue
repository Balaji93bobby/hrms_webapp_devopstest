<template>
    <div class="w-full p-4 mx-5 ">
        <div class="flex gap-4 pt-4 ">
            <div>
                <input style="height: 23px;width: 23px;" value="Apply Flexible Gross Hours" class="mt-1 form-check-input"
                    type="radio" name="leave" v-model="useAttendanceStore.change">
            </div>
            <div>
                <p class="font-semibold py-auto">Apply Flexible Gross Hours</p>
            </div>
            <div class="flex">
                <InputText type="text" v-model="txt_shift_start_time" class="w-8 h-10" />
                <p class="mx-4 text-lg font-semibold text-gray-600 py-auto">Min</p>
            </div>


        </div>
        <div class="p-3 my-5 rounded-lg bg-blue-50 ">
            <div class="flex gap-4 col-12">
                <input style="height: 20px;width: 20px;" value="Apply Standard General Shift Timing"
                    class="form-check-input" type="radio" name="leave" v-model="useAttendanceStore.change">
                <p class="font-semibold">Apply Standard General Shift Timing</p>
            </div>
            <div v-if="useAttendanceStore.change == 'Apply Standard General Shift Timing'">
                <div class="flex mx-6 my-4 row">
                    <div class="flex gap-4 col-6 ">
                        <div>
                            <p class="text-lg font-semibold py-auto">Shift Start Time</p>
                        </div>
                        <div>
                            <InputText type="text" v-model="txt_shift_start_time" class="h-10 " />
                        </div>
                    </div>
                    <div class="flex gap-4 col-6">
                        <div>
                            <p class="text-lg font-semibold py-auto">Shift End Time</p>

                        </div>
                        <div>
                            <InputText type="text" v-model="txt_shift_start_time" class="h-10 " />

                        </div>

                    </div>
                </div>
                <div class="flex mx-6 my-4 row ">
                    <div class="flex gap-1 col-6 d-flex align-items-center">
                        <div class="">
                            <p class="text-lg font-semibold py-auto ">Week Off</p>
                        </div>
                        <div class="ml-7 col-9">

                            <!-- <Dropdown v-model="selectedWeek_Off" :options="Week_Off_Days" optionLabel="name"
                                placeholder="Select Week Off" class="h-15 " style="width:180px" /> -->
                            <MultiSelect v-model="useAttendanceStore.shiftDetails.Week_Off" :options="Week_Off_Days" optionLabel="name"
                                placeholder="Select Week Off" :maxSelectedLabels="3" class="h-15"  style="width:180px" />

                            <!-- <InputText type="text" v-model="txt_shift_start_time" class="h-10 " /> -->

                        </div>
                    </div>
                    <div class="flex gap-1 col-6">
                        <div>
                            <p class="text-lg font-semibold py-auto">Grace Time</p>

                        </div>
                        <div class="ml-6 col-9">
                            <InputText type="text" v-model="txt_shift_start_time" class="h-10 " />

                        </div>

                    </div>
                    <!-- <div class="flex gap-1 col-6">
                    <div class="" >
                        <p class="text-lg font-semibold py-auto">Grace Time</p>

                    </div>
                    <div class="flex gap-1 ml-6 col-9" >
                        <InputText type="text" v-model="txt_shift_start_time" /><p class="text-lg font-semibold text-gray-600 py-auto ">Mins</p>
                    </div>

                </div> -->
                </div>
            </div>

            <!-- <div class="flex gap-4 p-2">
                <input type="checkbox" name="" id="">
                <p class="text-lg font-semibold py-auto">Apply To All Days Except Week Off</p>
            </div> -->
        </div>
        <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4 "
                @click="useAttendanceStore.manageshift_exemption_steps--">Previous</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="useAttendanceStore.manageshift_exemption_steps++">Next</button>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useAttendanceSettingMainStore } from '../../stores/attendanceSettingMainStore';

const useAttendanceStore = useAttendanceSettingMainStore();



const position = ref("center");
let canShowAssignShift = ref(false);


const openPosition = (pos) => {
    position.value = pos;
    canShowAssignShift.value = true;
};


const Week_Off_Days = ref([
    { name: 'Monday', id: 1 },
    { name: 'Tuesday', id: 'RM' },
    { name: 'Wednesday', code: 'LDN' },
    { name: 'Thursday', code: 'IST' },
    { name: 'Friday', code: 'PRS' },
    { name: 'saturday' },
    { name: 'Sunday', }
]);


</script>

{
    <!--


     -->
}
