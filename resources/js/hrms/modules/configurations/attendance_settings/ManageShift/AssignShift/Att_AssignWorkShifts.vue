<template>
    <div class="w-full">
        <!-- <ConfirmDialog></ConfirmDialog> -->
        <Toast />
        <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" modal >
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" modal >
            <div class="confirmation-content">
                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Proceed to save the shift details?</span>
            </div>
            <template #footer>
                <Button label="Yes" icon="pi pi-check" @click="saveWorkShiftDetails()" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" />
            </template>
        </Dialog>

        <div class="flex px-4 pt-6 gap-9">
            <div>
                <span class="text-lg font-semibold">Shift Name</span>
                <span class="mx-2">
                    <InputText type="text" v-model="useAttendanceStore.shiftDetails.shift_name"
                        placeholder="Enter the shift name" />
                </span>
            </div>
            <div>
                <span class="text-lg font-semibold">Shift Code</span>
                <span class="mx-2">
                    <InputText type="text" v-model="useAttendanceStore.shiftDetails.Shift_Code"
                        placeholder="Enter the shift code" />
                </span>
            </div>
            <div class="flex my-2">
                <p class="text-lg font-semibold px-3">Is Default</p>
                <Checkbox v-model="useAttendanceStore.shiftDetails.Is_Default" :binary="true" />
            </div>
        </div>
        <!--  -->

        <div class="w-full p-4 mx-5 ">
            <div class="flex gap-4 pt-4 ">
                <div>
                    <input style="height: 23px;width: 23px;" value="Apply Flexible Gross Hours"
                        class="mt-1 form-check-input" type="radio" name="leave" v-model="useAttendanceStore.change">
                </div>
                <div>
                    <p class="font-semibold py-auto">Apply Flexible Gross Hours</p>
                </div>
                <div class="flex">
                    <InputNumber  v-model="useAttendanceStore.shiftDetails.flexible_gross_hours" v-if="useAttendanceStore.change == 'Apply Flexible Gross Hours'" inputId="minmax" :min="0" :max="100" />
                    <p class="mx-4 text-lg font-semibold text-gray-600 py-auto" v-if="useAttendanceStore.change == 'Apply Flexible Gross Hours'"  >Min</p>
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
                                <Calendar id="calendar-timeonly" v-model="useAttendanceStore.shiftDetails.Shift_start_Time"
                                    timeOnly class="h-10 " />
                            </div>
                        </div>
                        <div class="flex gap-4 col-6">
                            <div>
                                <p class="text-lg font-semibold py-auto">Shift End Time</p>

                            </div>
                            <div>
                                <Calendar id="calendar-timeonly" v-model="useAttendanceStore.shiftDetails.Shift_End_Time"
                                    timeOnly class="h-10 " />
                            </div>

                        </div>
                    </div>
                    <div class="flex mx-6 my-4 row ">
                        <div class="flex gap-1 col-6 d-flex align-items-center">
                            <div class="">
                                <p class="text-lg font-semibold py-auto ">Week Off</p>
                            </div>
                            <div class="ml-7 col-9">
                                <MultiSelect v-model="useAttendanceStore.shiftDetails.Week_Off" :options="Week_Off_Days"
                                    optionLabel="name" placeholder="Select Week Off" :maxSelectedLabels="3" class="h-15"
                                    style="width:180px" />
                            </div>
                        </div>
                        <div class="flex gap-1 col-6  d-flex align-items-center">
                            <div>
                                <p class="text-lg font-semibold py-auto">Grace Time</p>
                            </div>
                            <div class="ml-6 col-9">
                                <!-- <InputText type="text" v-model="useAttendanceStore.shiftDetails.Grace_Time"  /> -->
                                <InputNumber class="h-10 " v-model="useAttendanceStore.shiftDetails.Grace_Time"
                                    inputId="minmax" :min="0" :max="59" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex w-full justify-content-start">
                <DataTable :value="useAttendanceStore.Week_Off_Days" tableStyle="min-width: 95rem">
                    <Column field="weeks" header="Days">
                    </Column>

                    <Column field="week_off_list" header="ALL Weeks">
                        <template #body="slotProps">
                            <!-- {{ slotProps.data.first_week }} -->
                            <div>

                                <!-- If Initial Week Off Value is 0 -->
                                <input v-if="slotProps.data.AllWeeks == 0" @change="useAttendanceStore.updateWeekOffState(slotProps.data)" @click="slotProps.data.AllWeeks = 1,
                                                                                                                                                    slotProps.data.first_week = 1 ,
                                                                                                                                                    slotProps.data.sec_week = 1 ,
                                                                                                                                                    slotProps.data.third_week = 1,
                                                                                                                                                    slotProps.data.fourth_week = 1 ,
                                                                                                                                                    slotProps.data.fifth_week = 1 "
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                    v-model="slotProps.data.AllWeeks" :true-value = 1 :false-value = 0  :checked=" slotProps.data.first_week == 1 ? true :
                                                                                                                    slotProps.data.sec_week == 1 ? true :
                                                                                                                    slotProps.data.third_week == 1 ? true :
                                                                                                                    slotProps.data.fourth_week == 1 ? true :
                                                                                                                   slotProps.data.fifth_week == 1 ? true : false"  >

                                    <!-- If Initial Week Off Value is 1 -->
                                  <input v-else-if="slotProps.data.AllWeeks == 1" @change="useAttendanceStore.updateWeekOffState(slotProps.data)" @click="slotProps.data.first_week = 0 ,
                                                                                                                                                        slotProps.data.sec_week = 0 ,
                                                                                                                                                        slotProps.data.third_week = 0,
                                                                                                                                                        slotProps.data.fourth_week = 0 ,
                                                                                                                                                        slotProps.data.fifth_week = 0 "
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                    v-model="slotProps.data.AllWeeks" :true-value = 1 :false-value = 0  :checked=" slotProps.data.first_week == 0 ? false :
                                                                                                                    slotProps.data.sec_week == 0 ? false :
                                                                                                                    slotProps.data.third_week == 0 ? false :
                                                                                                                    slotProps.data.fourth_week == 0 ? false :
                                                                                                                   slotProps.data.fifth_week == 0 ? false : true"  >

                                <!-- If Initial Week Off Value is null -->
                                <input v-else @change="useAttendanceStore.updateWeekOffState(slotProps.data)" @click="slotProps.data.first_week = 1 ,
                                                                                                                    slotProps.data.sec_week = 1 ,
                                                                                                                    slotProps.data.third_week = 1,
                                                                                                                    slotProps.data.fourth_week = 1 ,
                                                                                                                    slotProps.data.fifth_week = 1 "
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                    v-model="slotProps.data.AllWeeks" :true-value = 1 :false-value = 0  :checked=" slotProps.data.first_week == 1 ? true :
                                                                                                                    slotProps.data.sec_week == 1 ? true :
                                                                                                                    slotProps.data.third_week == 1 ? true :
                                                                                                                    slotProps.data.fourth_week == 1 ? true :
                                                                                                                   slotProps.data.fifth_week == 1 ? true : false"  >

                            </div>
                        </template>
                    </Column>
                    <Column field="first_week" header="first Week">
                        <template #body="slotProps">
                            <div>
                                <input @change="useAttendanceStore.updateWeekOffState(slotProps.data)"
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                     @click="slotProps.data.AllWeeks == 1 ? slotProps.data.first_week = 0 : slotProps.data.first_week = 1 "
                                    v-model="slotProps.data.first_week" :true-value=1 :false-value = 0 :checked="slotProps.data.AllWeeks ? true : false" >
                            </div>

                        </template>
                    </Column>
                    <Column field="sec_week" header="second week">
                        <template #body="slotProps">
                            <div>
                                <input @change="useAttendanceStore.updateWeekOffState(slotProps.data)"
                                 @click="slotProps.data.AllWeeks == 1 ? slotProps.data.sec_week = 0 : slotProps.data.sec_week = 1 "
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                    v-model="slotProps.data.sec_week"
                                    :false-value = 0 :true-value=1 :checked="slotProps.data.AllWeeks ? true : false" >
                            </div>
                        </template>
                    </Column>
                    <Column field="third_week" header="third week">
                        <template #body="slotProps">
                            <div>
                                <input @change="useAttendanceStore.updateWeekOffState(slotProps.data)"
                                @click="slotProps.data.AllWeeks == 1 ? slotProps.data.third_week = 0 : slotProps.data.third_week = 1 "
                                    style="height: 20px; width: 20px;" class="form-check-input" type="checkbox" name="" id="" v-model="slotProps.data.third_week" :true-value=1
                                    :false-value=0 :checked="slotProps.data.AllWeeks ? true : false"  >
                            </div>
                        </template>
                    </Column>
                    <Column field="fourth_week" header="fourth week">
                        <template #body="slotProps">
                            <div>
                                <input @change="useAttendanceStore.updateWeekOffState(slotProps.data)"
                                @click="slotProps.data.AllWeeks == 1 ? slotProps.data.fourth_week = 0 : slotProps.data.fourth_week = 1 "
                                    style="height: 20px;width: 20px;" class="form-check-input" type="checkbox" name="" id=""
                                    v-model="slotProps.data.fourth_week" :true-value=1
                                    :false-value=0  :checked="slotProps.data.AllWeeks ? true : false"  >
                            </div>
                        </template>
                    </Column>
                    <Column field="fifth_week" header="fifth week">
                        <template #body="slotProps">
                            <div>
                                <input @change="useAttendanceStore.updateWeekOffState(slotProps.data)"
                                 @click="slotProps.data.AllWeeks == 1 ? slotProps.data.fifth_week = 0 : slotProps.data.fifth_week = 1 "
                                    style="height: 20px;width: 20px; " class="form-check-input" type="checkbox"  v-model="slotProps.data.fifth_week"
                                    :true-value=1 :false-value=0  :checked="slotProps.data.AllWeeks ? true : false"  >
                            </div>
                        </template>
                    </Column>
                </DataTable>

            </div>
        </div>

        <!--  -->

        <div class="flex mx-4 my-6">
            <span class="text-lg font-semibold">Assign To</span>
            <span class="p-2 mx-4 my-auto mb-5 rounded-lg bg-red-50 fotn-bold"> <strong
                    class="text-orange-300">Note:</strong>
                Particular employees cannot be assigned to more than one shift unless he or she is assigned to a flexible
                shift.</span>
        </div>

        <div class="flex justify-between mx-4">
            <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Department"
                class="w-full md:w-14rem text-blue-900" style="border:1px solid navy" />
            <Dropdown v-model="selectedCity" style="border:1px solid navy" :options="cities" optionLabel="name"
                placeholder="Designation" class="w-full md:w-14rem text-blue-900" />
            <Dropdown v-model="selectedCity" style="border:1px solid navy" :options="cities" optionLabel="name"
                placeholder="Location" class="w-full md:w-14rem text-blue-900" />
            <Dropdown v-model="selectedCity" style="border:1px solid navy" :options="cities" optionLabel="name"
                placeholder="State" class="w-full md:w-14rem text-blue-900" />
            <Dropdown v-model="selectedCity" style="border:1px solid navy" :options="cities" optionLabel="name"
                placeholder="Branch" class="w-full md:w-14rem text-blue-900" />
            <Dropdown v-model="selectedCity" style="border:1px solid navy" :options="cities" optionLabel="name"
                placeholder="Legal Entity" class="w-full md:w-14rem text-blue-900 " />

        </div>
        <div class="mx-4">
            <InputText type="text" v-model="txt_shift_name" placeholder="Search..." class="my-4" />
            <!-- {{useAttendanceStore.array_shiftDetails}} -->
            <DataTable class="w-full" :value="useAttendanceStore.array_shiftDetails"
                v-model:selection="useAttendanceStore.selectedEmployees" :paginator="true" :rows="2" dataKey="emp_code"
                :rowsPerPageOptions="[5, 10, 25]"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters"
                filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']" >
                <template #empty> No Employee found </template>
                <template #loading> Loading employee data. Please wait. </template>
                <Column selectionMode="multiple"></Column>
                <Column field="emp_code" header="Employee ID" style="min-width: 2rem;">
                    <template #body="slotProps">
                        {{ slotProps.data.emp_code }}
                    </template>

                </Column>
                <Column field="employee_name" header="Employee Name" style="min-width: 8rem;">
                    <template #body="slotProps">
                        {{ slotProps.data.employee_name }}
                    </template>

                </Column>
                <Column field="designation" header="Designation" style="min-width: 10rem;">
                    <template #body="slotProps">
                        {{ slotProps.data.designation }}
                    </template>

                </Column>
                <Column style="min-width: 10rem;" field="department_name" header="Department">
                    <template #body="slotProps">
                        {{ slotProps.data.department_name }}
                    </template>

                </Column>
                <Column style="min-width: 10rem;" field="work_location" header="Location">
                    <template #body="slotProps">
                        {{ slotProps.data.work_location }}
                    </template>
                </Column>
                <Column style="min-width: 10rem;" field="work_location" header="State">
                    <template #body="slotProps">
                        {{ slotProps.data.work_location }}
                    </template>
                </Column>
            </DataTable>

        </div>
        <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="useAttendanceStore.manageshift_exemption_steps++">Next</button>
        </div>
    </div>


</template>
<script setup>
import { ref, onMounted } from "vue";
import dateFormat, { masks } from "dateformat";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
// import {GeneralShift} from "../GeneralShift/GeneralShift.vue"
import { useAttendanceSettingMainStore } from '../../stores/attendanceSettingMainStore';

const useAttendanceStore = useAttendanceSettingMainStore();

let canShowConfirmation = ref(false);

// const checked =ref(false);

const checkdata = ref();

const checked = (data) => {
    checkdata.value = data;
    console.log(data);
}


// const isChecked = (ele)=>{

// }



onMounted(() => {
    console.log(useAttendanceStore.manageshift_exemption_steps);

})


// const confirm = useConfirm();
// const toast = useToast();

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);

const select_Week_Off = ref({});





const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    emp_code: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    designation: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    department_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    location: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
});


let currentlySelectedStatus = null;
let currentlySelectedRowData = null;

onMounted(() => {
    //   ajax_GetEmployeeDetails();
    useAttendanceStore.fetchShiftDetails();
    useAttendanceStore.getWeek_Off_Days();
});

function onClickGetEmployees() {
    console.log(
        "onClickGetEmployees() button clicked : Shift Name :: " + txt_shift_name.value
    );
    console.log("Selected Employees : " + JSON.stringify(selectedEmployees.value));
}



function showConfirmDialog() {
    canShowConfirmation.value = true;

    // console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {
    canShowConfirmation.value = false;

    if (canClearData) resetVars();
}



////PrimeVue ConfirmDialog code -- Keeping here for reference
//const confirm = useConfirm();

// function confirmDialog(selectedRowData, status) {
//     console.log("Showing confirm dialog now...");

//     confirm.require({
//         message: 'Are you sure you want to proceed?',
//         header: 'Confirmation',
//         icon: 'pi pi-exclamation-triangle',
//         accept: () => {
//             toast.add({severity:'info', summary:'Confirmed', detail:'You have '+status, life: 3000});
//         },
//         reject: () => {
//             console.log("Rejected");
//             //toast.add({severity:'error', summary:'Rejected', detail:'You have rejected', life: 3000});
//         }
//     });
// }

const css_statusColumn = (data) => {
    return [
        {
            pending: data.status === "Pending",
            approved: data.status === "Approved",
            rejected: data.status === "Rejected",
        },
    ];
};

/*
    Input : Emp array obj
    Output : A 1-D array of emp ids.

*/

</script>


{
    <!--
     -->
}

