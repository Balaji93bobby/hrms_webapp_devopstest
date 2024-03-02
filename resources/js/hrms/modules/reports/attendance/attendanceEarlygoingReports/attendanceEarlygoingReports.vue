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
        <p class="font-semibold text-lg">Attendance Early Going Reports</p>
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
                <button @click="getEarlygoingAttendanceReports" class="btn btn-orange">Generate</button>

            </div>
        </div>
        <div class="col-span-6 flex justify-end gap-4">
            <button><img src="../../../../assests/printer.svg" alt="" srcset=""
                    class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
            <button><img src="../../../../assests/download.svg" alt="" srcset="" @click="downloadEarlygoingAttendanceReports"
                    class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
            <!-- <button class="bg-gray-100 rounded-full p-2 text-sm flex">
                <p class="bg-orange-400 p-1 h-6 w-6 rounded-full text-xs">A</p>
                <p class="text-sm my-auto">Abbrevation</p>
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
    let url = '/fetch-absent-report-data'
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

const downloadEarlygoingAttendanceReports = () => {
    let url = '/report/download-early-going-report'
    canShowLoading.value = true
    axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
    }, { responseType: 'blob' }).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        link.download = `Attendance Early Going Report_${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}.xlsx`;
        link.click();
    }).finally(() => {
        canShowLoading.value = false
    })
}


const getEarlygoingAttendanceReports = () =>{
    let url = '/fetch-EG-report-data'
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
        });

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

