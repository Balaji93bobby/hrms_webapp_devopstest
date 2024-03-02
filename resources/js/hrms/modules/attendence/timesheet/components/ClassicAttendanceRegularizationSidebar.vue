<template>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Date</label></div>
                <div class="col-6">
                    <span class="text-ash-medium fs-15" id="current_date">{{ dayjs( source.date).format('DD-MMM-YYYY') }}</span>
                    <input type="hidden" class="text-ash-medium form-control fs-15" name="attendance_date"
                        id="attendance_date">
                </div>
            </div>
        </div>
        <!-- {{ source }} -->
        <div class="col-12 my-2.5" v-if="type == 'LC'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Regularize Timing
                        as</label>
                </div>
                <div class="col-6">
                    <p v-if="source.lc_status.includes('Approved')"> {{ source.checkin_time }} </p>
                    <input v-else placeholder="format-09:30:00" type="time" @keypress="isNumber($event)"
                        class="border p-1.5 rounded-lg border-gray-400 w-full" name="" id=""
                        v-model="useTimesheet.AttendanceLateOrMipRegularization">
                </div>
            </div>
        </div>
        <div class="col-12 my-2.5" v-if="type == 'MIP'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Regularize Timing
                        as</label>
                </div>
                <div class="col-6">
                    <p v-if="source.mip_status.includes('Approved')"> {{ source.mip_regularized_time }} </p>
                    <input v-else placeholder="format-09:30:00" type="time" @keypress="isNumber($event)"
                        class="border p-1.5 rounded-lg border-gray-400 w-full" name="" id=""
                        v-model="useTimesheet.AttendanceLateOrMipRegularization">
                </div>
            </div>
        </div>
        <div class=" col-12 my-2.5" v-if="type == 'EG'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Regularize Timing
                        as</label>
                </div>
                <div class="col-6">
                    <p v-if="source.eg_status.includes('Approved')"> {{ source.checkout_time }} </p>
                    <input v-else placeholder="format-06:30:00" type="time" @keypress="isNumber($event)"
                        class="border p-1.5 rounded-lg border-gray-400  w-full" name="" id=""
                        v-model="useTimesheet.AttendanceEarylOrMopRegularization">
                </div>
            </div>
        </div>
        <div class=" col-12 my-2.5" v-if="type == 'MOP'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Regularize Timing
                        as</label>
                </div>
                <div class="col-6">
                    <p v-if="source.mop_status.includes('Approved')"> {{ source.mop_regularized_time }} </p>
                    <input v-else placeholder="format-06:30:00" type="time" @keypress="isNumber($event)"
                        class="border p-1.5 rounded-lg border-gray-400  w-full" name="" id=""
                        v-model="useTimesheet.AttendanceEarylOrMopRegularization">
                </div>
            </div>
        </div>

        <!-- Late coming regularization  Begins-->
        <div class="col-12" v-if="type == 'LC'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Reason</label></div>
                <div class="col-6" v-if="source.lc_status == 'None'">
                    <select name="reason" class="form-select btn-line-orange" id="reason_lc"
                        v-model="useTimesheet.lcDetails.reason">
                        <option selected hidden disabled>
                            Choose Reason
                        </option>
                        <option value="Permission">Permission</option>
                        <option value="Technical Error">Technical Error</option>
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-6" v-else>
                    <p class="max-w-min p-1"> {{ source.lc_reason }}</p>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'LC'">
            <div class="col-12" v-if="useTimesheet.lcDetails.reason == 'Others'">
                <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                    placeholder="Reason here...." v-model="useTimesheet.lcDetails.custom_reason"></textarea>
            </div>
            <div class="col-12" v-else-if="source.lc_reason == 'Others'">
                <div class="row">
                    <div class="col-6">
                        <label class="font-medium fs-6 text-gray-700">Custom reason</label>
                    </div>
                    <div class="col-6">
                        <p class="pl-3"> {{ source.lc_reason_custom }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'LC'">
            <div class="col-6">
                <label class="font-medium fs-6 text-gray-700">Status</label>
            </div>
            <div class="col-6">
                <p v-if="source.lc_status.includes('None')" class="max-w-min ml-3 p-1"
                    :class="findStatus(source.lc_status)">-</p>
                <p v-else class="max-w-min ml-3 p-1" :class="findStatus(source.lc_status)"> {{ source.lc_status }}</p>
            </div>
        </div>
        <div v-if="type == 'LC'" class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">
            <button v-if="source.lc_status == 'None'" type="button" class="btn btn-orange"
                @click="useTimesheet.applyLcRegularization()">Apply</button>
            <button v-if="source.lc_status == 'Pending'" type="button" class="btn btn-orange"
                @click="useTimesheet.withdrawAttendanceRegularization(source,'LC')">Withdraw</button>
        </div>
        <!-- Late coming regularization  Ends-->

        <!-- Missed In Punch regularization  Begins-->
        <div class="col-12" v-if="type == 'MIP'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Reason</label></div>
                <div class="col-6" v-if="source.mip_status == 'None'">
                    <select name="reason" class="form-select btn-line-orange" id="reason_lc"
                        v-model="useTimesheet.mipDetails.reason">
                        <option selected hidden disabled>
                            Choose Reason
                        </option>
                        <option value="Permission">Permission</option>
                        <option value="Technical Error">Technical Error</option>
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-6" v-else>
                    <p class="max-w-min p-1"> {{ source.mip_reason }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 " v-if="type == 'MIP'">
            <div class="row" v-if="useTimesheet.mipDetails.reason == 'Others'">
                <div class="col-12">
                    <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                        v-model="useTimesheet.mipDetails.custom_reason" placeholder="Reason here...."></textarea>
                </div>
            </div>
            <div class="col-12" v-else-if="source.mip_reason == 'Others'">
                <div class="row">
                    <div class="col-6">
                        <label class="font-medium fs-6 text-gray-700">Custom reason</label>
                    </div>
                    <div class="col-6">
                        <p class="ml-3"> {{ source.mip_reason_custom }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'MIP'">
            <div class="col-6">
                <label class="font-medium fs-6 text-gray-700">Status</label>
            </div>
            <div class="col-6">
                <p v-if="source.mip_status.includes('None')" class="p-1 ml-3 min-w-max"
                    :class="findStatus(source.mip_status)"> - </p>
                <p v-else class="p-1 ml-3 min-w-max" :class="findStatus(source.mip_status)"> {{ source.mip_status }}</p>
            </div>
        </div>
        <div v-if="type == 'MIP'" class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">
            <button v-if="source.mip_status == 'None'" type="button" class="btn btn-orange" @click="useTimesheet.applyMipRegularization()">Apply</button>
            <button v-if="source.mip_status == 'Pending'" type="button" class="btn btn-orange"
            @click="useTimesheet.withdrawAttendanceRegularization(source,'MIP')">Withdraw</button>
        </div>
        <!-- Missed In Punch regularization  Ends-->


        <!-- Early Going regularization  Begins-->
        <div class="col-12" v-if="type == 'EG'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Reason</label></div>
                <div class="col-6" v-if="source.eg_status == 'None'">
                    <select name="reason" class="form-select btn-line-orange" id="reason_lc"
                        v-model="useTimesheet.egDetails.reason">
                        <option selected hidden disabled>
                            Choose Reason
                        </option>
                        <option value="Permission">Permission</option>
                        <option value="Technical Error">Technical Error</option>
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-6" v-else>
                    <p class="ml-3"> {{ source.eg_reason }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 " v-if="type == 'EG'">
            <div class="row" v-if="useTimesheet.egDetails.reason == 'Others'">
                <div class="col-12">
                    <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                        placeholder="Reason here...." v-model="useTimesheet.egDetails.custom_reason"></textarea>
                </div>
            </div>
            <div class="col-12" v-else-if="source.eg_reason == 'Others'">
                <div class="row">
                    <div class="col-6">
                        <label class="font-medium fs-6 text-gray-700">Custom reason</label>
                    </div>
                    <div class="col-6">
                        <p class="ml-3"> {{ source.eg_reason_custom }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'EG'">
            <div class="col-6">
                <label class="font-medium fs-6 text-gray-700">Status</label>
            </div>
            <div class="col-6">
                <p v-if="source.eg_status.includes('None')" class="max-w-min p-1 ml-3"
                    :class="findStatus(source.eg_status)"> - </p>
                <p v-else class="max-w-min p-1 ml-3" :class="findStatus(source.eg_status)"> {{ source.eg_status }}</p>
            </div>
        </div>
        <div v-if="type == 'EG'" class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">
            <button v-if="source.eg_status == 'None'" type="button" class="btn btn-orange"
                @click="useTimesheet.applyEgRegularization()">Apply</button>
                <button v-if="source.eg_status == 'Pending'" type="button" class="btn btn-orange"
                @click="useTimesheet.withdrawAttendanceRegularization(source,'Eg')">Withdraw</button>
        </div>
        <!-- Early Going regularization  Ends-->

        <!-- Missed Out Punch regularization  Ends-->
        <div class="col-12" v-if="type == 'MOP'">
            <div class="row">
                <div class="col-6"><label class="font-medium fs-6 text-gray-700">Reason</label></div>
                <div class="col-6" v-if="source.mop_status == 'None'">
                    <select name="reason" class="form-select btn-line-orange" id="reason_lc"
                        v-model="useTimesheet.mopDetails.reason">
                        <option selected hidden disabled>
                            Choose Reason
                        </option>
                        <option value="Permission">Permission</option>
                        <option value="Technical Error">Technical Error</option>
                        <option value="Official">Official</option>
                        <option value="Personal">Personal</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-6" v-else>
                    <p class=" ml-3"> {{ source.mop_reason }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 " v-if="type == 'MOP'">
            <div class="row" v-if="useTimesheet.mopDetails.reason == 'Others'">
                <div class="col-12">
                    <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                        placeholder="Reason here...." v-model="useTimesheet.mopDetails.custom_reason"></textarea>
                </div>
            </div>
            <div class="col-12" v-else-if="source.mop_reason == 'Others'">
                <div class="row">
                    <div class="col-6">
                        <label class="font-medium fs-6 text-gray-700 p-1">Custom reason</label>
                    </div>
                    <div class="col-6">
                        <p class="ml-3"> {{ source.mop_reason_custom }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'MOP'">
            <div class="col-6">
                <label class="font-medium fs-6 text-gray-700">Status</label>
            </div>
            <div class="col-6">
                <p v-if="source.mop_status.includes('None')" class="p-1 ml-3 min-w-max"
                    :class="findStatus(source.mop_status)"> - </p>
                <p v-else class="p-1 ml-3 min-w-max" :class="findStatus(source.mop_status)"> {{ source.mop_status }}</p>
            </div>
        </div>
        <div v-if="type == 'MOP'" class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">
            <button v-if="source.mop_status == 'None'" type="button" class="btn btn-orange"
                @click="useTimesheet.applyMopRegularization()">Apply</button>
                <button v-if="source.mop_status == 'Pending'" type="button" class="btn btn-orange"
                @click="useTimesheet.withdrawAttendanceRegularization(source,'MOP')">Withdraw</button>
        </div>
    </div>
    <!-- Missed Out Punch regularization  Ends-->
</template>

<script setup>
import { onUpdated } from 'vue';
import { useAttendanceTimesheetMainStore } from '../stores/attendanceTimesheetMainStore';
import dayjs from 'dayjs';



const useTimesheet = useAttendanceTimesheetMainStore()

const props = defineProps({
    source: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    }
})


const findStatus = (data) => {

    if (data.includes('Approved')) {
        return ' bg-green-50 text-green-600  fs-6 rounded-lg'
    } else
        if (data.includes('Rejected')) {
            return ' bg-red-50 text-red-600  fs-6 rounded-lg'
        } else
            if (data.includes('Pending')) {
                return 'border-yellow-500 bg-yellow-50 text-yellow-600  fs-6 rounded-lg'
            } else
                if (data.includes('Revoked')) {
                    return ' bg-gray-50 text-gray-600  fs-6 rounded-lg'
                }
}

const isNumber = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[0-9:]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

</script>
