<template>
    <div class="w-full">
        <div class="mx-auto card top-line">
            <div class=" card-body">
                <div class="flex justify-between">
                    <h3 class="mx-2 my-2 font-semibold">Leave Type</h3>
                    <a href="/attendance-leave-policydocument" id="" class="text-md  font-medium border-1 border-orange-400 rounded-lg text-center bg-orange-400 text-white my-auto p-2 dark:text-white" role="button"
                        aria-expanded="false">
                        Leave
                        Policy Explanation
                    </a>
                </div>

                <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-6 xxl:grid-cols-6 xl:grid-cols-6 lg:grid-cols-6 my-4 "
                    style="display: grid;">
                    <button class="card p-2 rounded-lg border-1 border-orange-300 cursor-pointer focus:bg-green-100"
                        v-for="leave_balance in useLeaveStore.array_employeeLeaveBalance" :key="leave_balance"
                        @click="check(leave_balance)">
                        <div class="card-body">
                            <h6 class="text-sm h-10 font-bold text-center text-black dark:text-white"> {{
                                leave_balance.leave_type }} </h6>
                            <div class="mx-auto">
                                <h6 class="text-2xl font-bold text-center dark:text-white">{{
                                    leave_balance.availed_leaves }}
                                    <span class="text-sm">days</span>
                                </h6>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="mx-auto my-4 card top-line">
            <div class="card-body row">
                <div class="col-6">
                    <div>
                        <h3 class="mx-2 my-4 font-semibold">Set Range</h3>
                    </div>
                    <div class="mx-1 my-2 mb-3 row">
                        <div class="mb-3 col-md-1 col-sm-1 col-lg-4 col-xl-4 col-xxl-4 mb-md-0">
                            <div class="form-group">
                                <div class="floating">
                                    <label for="start"
                                        class="text-lg font-bold text-center text-black dark:text-white">Start
                                        Date</label><br>
                                    <!-- <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" id="start"
                                        v-model="useStore.leave_data.custom_start_date" :minDate="new Date()"
                                        :manualInput="true" /> -->
                                    <input class="border-1 my-1 border-orange-300 rounded-lg" type="date" name="" id="">

                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-1 col-sm-1 col-lg-6 col-xl-4 col-xxl-5 mb-md-0">
                            <div class="form-group">
                                <div class="floating" style="text-align: center;">

                                    <label for="total"
                                        class="text-lg  font-bold text-center text-black dark:text-white">Total Days</label>
                                    <!-- <InputText style="width: 60px;text-align: center;margin: auto;" id="total"
                                        class="capitalize form-onboard-form form-control textbox " type="text"
                                        v-model="useStore.leave_data.custom_total_days" readonly /> -->

                                </div>

                            </div>
                        </div>
                        <div class="mb-3 col-md-1 col-sm-1 col-lg-3 col-xl-4 col-xxl-3 mb-md-0">
                            <div class="form-group">

                                <div class="floating">

                                    <label for="end" class="text-lg  font-bold text-center text-black dark:text-white">End
                                        Day</label><br>
                                    <!-- <Calendar inputId="icon" @date-select="useStore.dayCalculation" dateFormat="dd-mm-yy"
                                        :showIcon="true" v-model="useStore.leave_data.custom_end_date" id="end"
                                        :minDate="new Date()" /> -->
                                    <input class="border-1 my-1 border-orange-300 rounded-lg" placeholder="select"
                                        type="date" name="" id="">


                                </div>
                            </div>
                        </div>
                        <div class="my-4 row">
                            <div class="">
                                <div class="form-group">
                                    <Textarea :autoResize="true" rows="3" cols="90" placeholder="Enter the Reason"
                                        v-model="useStore.leave_data.leave_reason" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="my-2">
                            <h3 class="mx-2 my-2 font-semibold">Notify To</h3>
                        </div>
                        <div class="row">
                            <div class="p-1 mx-3 my-4 border-2 rounded-lg shadow-md col-lg-3 left-line col-md-3 col-xl-2"
                                v-for="leaves in useStore.leave_types" :key="leaves.id">

                            </div>
                        </div>

                    </div>

                    <div class="mt-6 text-right">
                        <button type="button" class="btn btn-border-primary" @click="visible = false">Cancel</button>
                        <button type="button" id="btn_request_leave" class="mx-4 btn btn-primary "
                            :disabled="useStore.leave_data.selected_leave.length > 0 && useStore.leave_data.leave_reason ? false : true"
                            @click="useStore.Submit">
                            Request Leave</button>
                    </div>

                </div>
                <div class="col-6">
                    <Calendar :inline="true" :showWeek="true" style="min-width:100%" />
                </div>



            </div>


        </div>


        {{ active }}

    </div>

    <!-- {{ useStore.leave_types }} -->
</template>

<script setup>

import { onMounted, ref } from 'vue'
import { useLeaveService } from '../leave_apply/leave_apply_service'
import { useLeaveModuleStore } from '../LeaveModuleService';


const useLeaveStore = useLeaveModuleStore()

const useStore = useLeaveService()

onMounted(() => {
    useStore.get_leave_types()
})

const sickActive = ref(false)
const earnActive = ref(false)


const check = (a) => {
    console.log(a);
    const leave = ''
    switch (leave) {
        case "Sick Leave / Casual Leave":
            console.log("Sick");
            sickActive.value = true
            break;
        case "Earned Leave":
            console.log("Earned");
            earnActive.value = true
            break;
        case "Maternity Leave":
            console.log("Maternity");
            active.value = true
            break;
        case "Paternity Leave":
            active.value = true
            console.log("Paternity");
            break;
        case "On Duty":
            active.value = true
            console.log("earn");
            break;
        case "Compensatory Off":
            active.value = true
            console.log("Compensatory");
            active.value = true
            break;
        case "Permission":
            active.value = true
            console.log("Permission");

            break;

    }
}
</script>

<style scoped></style>
