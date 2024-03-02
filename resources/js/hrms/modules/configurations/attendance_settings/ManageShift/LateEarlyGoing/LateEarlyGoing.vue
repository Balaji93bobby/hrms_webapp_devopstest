<template>
    <div class="w-full p-6 my-4 shadow-sm rounded-xl bg-blue-50 ">
        <div class="flex gap-4 pt-1 row ">
            <div class="col-5">
                <p class="font-semibold py-auto">Does Your company have a late coming LOP Policy</p>
            </div>
            <div class="flex gap-4 col-1 ">
                <div class="mt-1">
                    <input style="height: 18px;width: 18px;" class="form-check-input" type="radio" name="leave" value="1"
                        v-model="lateComingLop">
                </div>
                <div>
                    <p class="font-semibold">Yes</p>
                </div>

            </div>
            <div class="flex gap-4 col-1 ">
                <div class="mt-1">
                    <input style="height: 18px;width: 18px;" class="form-check-input" type="radio" name="leave" value="0"
                        v-model="lateComingLop">
                </div>
                <div>
                    <p class="font-semibold">No</p>
                </div>

            </div>

            <div class="row" v-if="lateComingLop == '1'">
                <div class="flex col-5">
                    <div>
                        <p class="my-2.5 text-lg font-semibold">The number of late comings allowed in month</p>
                    </div>
                    <div class="col-2">
                        <!-- <InputText type="text" v-model="txt_shift_name" placeholder="Enter " class="w-full h-10 mx-2" /> -->
                        <InputNumber class="h-10"  v-model="useAttendanceStore.shiftDetails.lclp_number_of_late_commings_allowed_Month" inputId="minmax" :min="0" :max="24" />
                    </div>
                    <div>
                        <p class="my-2.5 text-lg font-semibold text-gray-600 mx-4">Times</p>
                    </div>
                </div>
                <div class="flex bg-orange-100 rounded-lg col-5">
                    <div class="">
                        <p class="my-2.5 text-gray-700 text-lg font-semibold">Once Exceed The Late LOP Limit </p>
                    </div>
                    <div class="col-2">
                        <InputNumber class="h-10"  v-model="useAttendanceStore.shiftDetails.lclp_Once_Exceed_TheLate_Limit_Days_Lop_Apply" inputId="minmax" :min="0" :max="24" />
                    </div>
                    <div class="">
                        <p class="my-2.5 text-lg font-semibold text-gray-600 mx-4">Days LOP Apply</p>
                    </div>

                </div>
            </div>


        </div>
        <div class="flex gap-4 pt-4 row">
            <div class="col-5">
                <p class="font-semibold py-auto">Does Your company have a early going LOP Policy</p>
            </div>
            <div class="flex gap-4 col-1 ">
                <div class="mt-1">
                    <input style="height: 18px;width: 18px;" class="form-check-input " type="radio" name="leave" value="1"
                        v-model="earlyGoingLop">
                </div>
                <div>
                    <p class="font-semibold">Yes</p>
                </div>
            </div>
            <div class="flex gap-4 col-1 ">
                <div class="mt-1">
                    <input style="height: 18px;width: 18px;" class="form-check-input" type="radio" name="leave" value="0"
                        v-model="earlyGoingLop">
                </div>
                <div>
                    <p class="font-semibold">No</p>
                </div>
            </div>
            <!-- {{ earlyGoingLop }} -->


        </div>
        <div class="my-4 row" v-if="earlyGoingLop == '1'">
            <div class="flex col-5">
                <div>
                    <p class="my-2.5 text-lg font-semibold">The number of late comings allowed in month</p>
                </div>
                <div class="col-2">
                    <InputNumber class="h-10"  v-model="useAttendanceStore.shiftDetails.eglp_number_of_late_commings_allowed_Month" inputId="minmax" :min="0" :max="24" />
                </div>
                <div>
                    <p class="my-2.5 text-lg font-semibold text-gray-600 mx-4">Times</p>
                </div>
            </div>
            <div class="flex bg-orange-100 rounded-lg col-6">
                <div class="">
                    <p class="my-2.5 text-gray-700 text-lg font-semibold">Once Exceed The Early Going LOP Limit </p>

                </div>
                <div class="col-2 ">
                    <InputNumber class="h-10"  v-model="useAttendanceStore.shiftDetails.eglp__Once_Exceed_TheEarly_Limit_Days_Lop_Apply" inputId="minmax" :min="0" :max="24" />
                </div>
                <div class="">
                    <p class="my-2.5 text-lg font-semibold text-gray-600 mx-4">Days LOP Apply</p>
                </div>

            </div>
        </div>

        <div class="my-3 text-end">

            <button
                class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4 "  @click="useAttendanceStore.manageshift_exemption_steps--" >Previous</button>
                <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4" @click="useAttendanceStore.saveWorkShiftDetails()">Save</button>
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



const lateComingLop = ref()
const earlyGoingLop = ref()


</script>

<style>
.p-inputnumber-input{
    width: 80px;
}

</style>
