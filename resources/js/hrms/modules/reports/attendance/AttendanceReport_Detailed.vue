<template>
    <div>
        <!-- <ConfirmDialog></ConfirmDialog> -->
        <Toast />
        <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width:50px;height:50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center;">Please wait...</h5>
            </template>
        </Dialog>
        <div>
            <!-- <div>Calander Type :
                <select v-model="selected_options_calendar_type.value">
                    <option v-for="option in options_calendar_type" :value="option.value">
                        {{ option.name }}
                    </option>
                </select>
            </div>

            <div>Year :
                <select v-model="selected_options_year.value">
                    <option v-for="option in options_year" :value="option.value">
                        {{ option.name }}
                    </option>
                </select>
            </div>

            <div>Legal Entity :
                <select v-model="selected_options_calendar_type.value">
                    <option v-for="option in options_assignment_period" :value="option.value">
                        {{ option.name }}
                    </option>
                </select>
            </div>

            <div>Department :
                <select v-model="selected_options_calendar_type.value">
                    <option v-for="option in options_assignment_period" :value="option.value">
                        {{ option.name }}
                    </option>
                </select>
            </div>

            <div>
                <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Download Excel"
                    @click="onclickDownloadExcelSheet(1)" style="height: 2em;" />
            </div> -->

            <div class="grid grid-cols-4 gap-6 p-2">
                <div>
                    <p>Start date</p>
                    <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10" v-model="start_date" />
                </div>
                <div>
                    <p>End date</p>
                    <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10" v-model="end_date" />
                </div>
                <div class=" d-flex justify-content-center align-items-end  ">
                    <button class="btn btn-primary py-auto"
                        @click="onclickDownloadExcelSheet(start_date, end_date)">generate</button>
                </div>
                <div></div>
                <div></div>
            </div>
            <DataTable :value="data_pmsforms" :paginator="true" :rows="10" dataKey="id"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                v-model:filters="filters" filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
                <template #empty>
                    No Employee found
                </template>
                <template #loading>
                    Loading customers data. Please wait.
                </template>

                <Column field="employee_name" header="Employee Name">
                    <template #body="slotProps">
                        {{ slotProps.data.employee_name }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template>
                </Column>
                <Column field="department" header="Designation">
                    <template #body="slotProps">
                        {{ slotProps.data.designation }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template>
                </Column>
                <Column field="department" header="Department">
                    <template #body="slotProps">
                        {{ slotProps.data.department }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template>
                </Column>

                <Column field="employee_name" header="PD">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="HD">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="HO">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="OD">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="SL/CL">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="EL">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="SL">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="CL">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
                <Column field="employee_name" header="ML">
                    <template #body="slotProps">
                        {{ slotProps.data.pd }}
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>
<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios'
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import moment from 'moment';


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

const data_pmsforms = ref();

onMounted(() => {
    let url = window.location.origin + '/fetch-regularization-approvals';

    console.log("AJAX URL : " + url);

    axios.get(url)
        .then((response) => {
            console.log("Axios : " + response.data);
            data_pmsforms.value = response.data;
        });
})


function onclickDownloadExcelSheet(start_date, end_date) {

    canShowLoading.value = true
    axios.post(window.location.origin + '/reports/generate-detailed-attendance-report', {
        start_date: moment(start_date).format('YYYY-MM-DD'),
        end_date: moment(end_date).format('YYYY-MM-DD')
    },{responseType: 'blob'}).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        link.download = ` Basic Report.xlsx`;
        link.click();
    })
        .catch((error) => {
            console.log(error.toJSON());
        }).finally(() => {
            canShowLoading.value = false
        })
}


</script>
