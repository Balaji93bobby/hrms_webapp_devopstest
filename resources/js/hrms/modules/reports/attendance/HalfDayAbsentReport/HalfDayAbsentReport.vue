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
        <p class="text-lg font-semibold">Attendance Half Day Absent Reports</p>
    </div>

    <div class="grid grid-cols-12 p-2 my-2 bg-white rounded-lg">
        <div class="grid grid-cols-12 col-span-6 gap-6">
            <div class="col-span-4">
                <p>Start date</p>
                <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10"
                    v-model="variable.start_date" />
            </div>
            <div class="col-span-4">
                <p>End date</p>
                <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" class="h-10" v-model="variable.end_date" />
            </div>
            <div class="col-span-4 d-flex justify-content-center align-items-end">
                <button @click="getEmployeeAbsentReports" class="btn btn-orange">Generate</button>

            </div>
        </div>
        <div class="flex justify-end col-span-6 gap-4">
            <button><img src="../../../../assests/icons/printer.svg" alt="" srcset=""
                    class="p-2 rounded-lg w-9 h-9 bg-gray-50"></button>
            <button><img src="../../../../assests/download.svg" alt="" srcset="" @click="downloadAbsentReports"
                    class="p-2 rounded-lg w-9 h-9 bg-gray-50"></button>
            <!-- <button class="flex p-2 text-sm bg-gray-100 rounded-full">
                <p class="w-6 h-6 p-1 text-xs bg-orange-400 rounded-full">A</p>
                <p class="my-auto text-sm">Abbrevation</p>
            </button> -->
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
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';

const variable = reactive({
    start_date: '',
    end_date: '',
})

const products = ref([
    { product: 'Bamboo Watch', lastYearSale: 51, thisYearSale: 40, lastYearProfit: 54406, thisYearProfit: 43342 },
    { product: 'Black Watch', lastYearSale: 83, thisYearSale: 9, lastYearProfit: 423132, thisYearProfit: 312122 },
    { product: 'Blue Band', lastYearSale: 38, thisYearSale: 5, lastYearProfit: 12321, thisYearProfit: 8500 },
    { product: 'Blue T-Shirt', lastYearSale: 49, thisYearSale: 22, lastYearProfit: 745232, thisYearProfit: 65323 },

]);

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);

const reportsType = ref([
    { name: 'Absent reports', code: '1' },
    { name: 'Detailed Report', code: '2' },
]);


const AttendanceReportDynamicHeaders = ref([])
const AttendanceReportSource = ref([])
const canShowLoading = ref(false)

const getEmployeeAttendanceReports = async () => {

    // Attendance Basic Reports
    let url = '/fetch-attendance-data'
    canShowLoading.value = true
    await axios.get(url).then(res => {
        console.log(res.data.rows);
        AttendanceReportSource.value = res.data.rows
        res.data.header.forEach(element => {
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

const getEmployeeAbsentReports = () => {
    // Absent Reports
    let url = '/fetch-half-day-data'
    canShowLoading.value = true
    axios.post(url, {
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

const downloadAbsentReports = () => {
    let url = '/report/download-half-day-report'
    canShowLoading.value = true
    axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
    }, { responseType: 'blob' }).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        link.download = `Attendance Half Day Absent Report_${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}.xlsx`;
        link.click();
    }).finally(() => {
        canShowLoading.value = false
    })
}

onMounted(() => {
    // getEmployeeAttendanceReports()
})


</script>


<style>
.p-dropdown
{
    display: inline-flex;
    cursor: pointer;
    position: relative;
    user-select: none;
    height: 20px;
}

.p-dropdown .p-dropdown-label
{
    background: transparent;
    border: 0 none;
    margin-top: -11px;
}
.page-content {
    padding: calc(30px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
  }
</style>
