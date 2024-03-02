<template>
    <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>

    <div>
        <p class="font-semibold text-lg">Attendance Detail Reports</p>
    </div>

    <div class="bg-white p-2 my-2 rounded-lg grid grid-cols-12">
        <div class="grid grid-cols-12 gap-6 col-span-6">
            <div class="col-span-4">
                <p>Start date</p>
                <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10"
                    v-model="variable.start_date" />
            </div>
            <div class="col-span-4">
                <p>End date</p>
                <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10" v-model="variable.end_date" />
            </div>
            <div class=" d-flex justify-content-center align-items-end col-span-4 ">
                <button @click="getEmployeeAttendanceReports" class="btn btn-orange">Generate</button>

            </div>
        </div>
        <div class="col-span-6 flex justify-end gap-4">
            <button><img src="../../../../assests/printer.svg" alt="" srcset=""
                    class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
            <button><img src="../../../../assests/download.svg" alt="" srcset="" @click="downloadDetailReports"
                    class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
        </div>
    </div>

    <div class="my-4">
        <DataTable :value="AttendanceReportSource"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
            <Column v-for="col of AttendanceReportDynamicHeaders" :key="col.title" :field="col.title" :header="col.title"
                style="white-space: nowrap;text-align: left; !important">

            </Column>
        </DataTable>
    </div>

    <div class="mb-0">
        <div class="card-body">
            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade active show" id="investment_dec" role="tabpanel" aria-labelledby="pills-home-tab">
                </div>

                <div class="tab-pane fade " id="exemptions" role="tabpanel">

                </div>
                <div class="tab-pane fade " id="investmentComputation" role="tabpanel">

                </div>
                <div class="tab-pane fade " id="other_income" role="tabpanel" aria-labelledby="pills-home-tab">

                </div>
                <div class="tab-pane fade " id="other_exemptions" role="tabpanel" aria-labelledby="pills-home-tab">

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

import { ref, onMounted, reactive } from 'vue';
import axios from 'axios'
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import moment from 'moment';
import dayjs from 'dayjs';


const canShowLoading = ref(false)
const start_date = ref()
const end_date = ref()

const selected_options_calendar_type = { "name": "Choose", "value": "" };
const options_calendar_type = [
    { "name": "Choose", "value": "" },
    { "name": "Financial Year", "value": "financial_year" },
    { "name": "Calendar Year", "value": "calendar_year" }
];

const selected_options_year = { "name": "Choose", "value": "" };
const options_year = [
    { "name": "Choose", "value": "" },
    { "name": "April - 2021 to March - 2022", "value": "April - 2021 to March - 2022" },
    { "name": "April - 2022 to March - 2023", "value": "April - 2022 to March - 2023" }
];

const selected_assignment_period = { "name": "Choose", "value": "" };
const options_assignment_period = [
    { "name": "Choose", "value": "" },
    { "name": "Q1", "value": "q1" },
    { "name": "Q2", "value": "q2" },
    { "name": "Q3", "value": "q3" },
    { "name": "Q4", "value": "q4" },
];

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,

    },
});


const variable = reactive({
    start_date: '',
    end_date: '',
})



const AttendanceReportDynamicHeaders = ref([])
const AttendanceReportSource = ref([])

const getEmployeeAttendanceReports = async () => {

    // Attendance Basic Reports
    let url = '/fetch-attendance-data'
    canShowLoading.value = true
    await axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
    }).then(res => {
        console.log(res.data.rows);
        AttendanceReportSource.value = res.data.rows
        res.data.headers.forEach(element => {
            let format = {
                title: element
            }
            AttendanceReportDynamicHeaders.value.push(format)
            console.log(element);
        });
        console.log(AttendanceReportDynamicHeaders.value);

    }).finally(() => {
        canShowLoading.value = false
    })

}

const downloadDetailReports = () => {
    let url = '/reports/generate-detailed-attendance-report'
    canShowLoading.value = true
    axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
    }, { responseType: 'blob' }).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        link.download = `Attendance Detailed Report_${dayjs(variable.start_date).format('DD-MM-YYYY')}_${dayjs(variable.end_date).format('DD-MM-YYYY')}.xlsx`;
        link.click();
    }).finally(() => {
        canShowLoading.value = false
    })
}





</script>
