<template>
    <LoadingSpinner v-if="canShowLoading" class="absolute z-50 bg-white" />
    <div class="w-full">
        <div>
            <p class="font-semibold text-lg">Attendance Basic Reports</p>
        </div>

        <div class="grid grid-cols-12">
            <div class="col-span-6">
                <!-- <ul class="nav nav-pills  nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="mx-2 nav-item ember-view" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#investment_dec" role="tab" aria-controls="pills-home" aria-selected="true">
                            <p class="text-sm font-semibold">Detailed Report</p>
                        </a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="mx-2 nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#exemptions" role="tab" aria-controls="pills-home" aria-selected="true">
                            <p class="text-sm font-semibold">Muster Roll</p>
                        </a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="mx-2 nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#investmentComputation" role="tab" aria-controls="pills-home"
                            aria-selected="true">
                            <p class="text-sm font-semibold"> Consolidate</p>
                        </a>
                    </li>
                </ul> -->
            </div>
            <div class="col-span-6  gap-8 grid grid-cols-12 place-content-end  ">
                <!-- <div class="flex gap-3 col-span-3 justify-end">
                </div> -->
                <div class="flex gap-3 col-span-6 justify-end items-center">
                    <div>
                        <p class="text-sm font-semibold">Period:</p>
                    </div>
                    <div>
                        <!-- <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" class="w-full md:w-14rem" /> -->
                        <button @click="canShowPeriodDialog = true"
                            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold  fs-6 px-2 border border-gray-400 rounded shadow">
                            select
                        </button>
                    </div>
                </div>
                <!-- <div class="flex gap-3 col-span-5 justify-end items-center">
                    <div>
                        <p class="text-sm font-semibold">Legal Entity :
                        </p>
                    </div>
                    <div>
                        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" />
                    </div>
                </div> -->
                <div class="flex gap-3 col-span-5 justify-end  items-center">
                    <div>
                        <p class="text-sm font-semibold ">Department:</p>
                    </div>
                    <div>
                        <Dropdown v-model="department" @change="getEmployeeAttendanceReports" :options="departmentOption"
                            optionLabel="name" optionValue="id" />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-2 my-2 rounded-lg grid grid-cols-12 ">
            <div class="grid grid-cols-12 gap-6 col-span-6">
            </div>
            <div class="col-span-6 flex justify-end gap-4">
                <button><img src="../../../../assests/printer.svg" alt="" srcset=""
                        class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
                <button><img src="../../../../assests/download.svg" alt="" srcset="" @click="downloadAbsentReports"
                        class="w-9 h-9 p-2 bg-gray-50 rounded-lg"></button>
            </div>
        </div>


        <div class="my-4 w-full overflow-hidden" v-if="AttendanceReportSource.length > 0">
            <DataTable :value="AttendanceReportSource"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column v-for="col of AttendanceReportDynamicHeaders" :key="col.title" :field="col.title"
                    :header="col.title" style="white-space: nowrap;text-align: left; !important">

                </Column>
            </DataTable>
        </div>
        <div v-else class="w-2/5 h-1/4 mx-auto">
            <img src="../../../../assests/images/no-data.svg" alt="" class="h-full w-full">
        </div>

        <Dialog v-model:visible="canShowPeriodDialog" modal header="Header" :style="{ width: '40vw' }">
            <template #header>
                <p class="font-semibold text-lg">Select period</p>
            </template>
            <div class="w-full">
                <div class="grid grid-cols-12 gap-6 col-span-6 place-items-center">
                    <div class="col-span-4">
                        <p class="font-semibold text-sm my-1">Start date</p>
                        <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" style="height: 2.5rem;"
                            v-model="variable.start_date" />
                    </div>
                    <div class="col-span-4">
                        <p class="font-semibold text-sm my-1">End date</p>
                        <Calendar inputId="icon" dateFormat="dd-mm-yy" :showIcon="true" style="height: 2.5rem;"
                            v-model="variable.end_date" />
                    </div>
                    <div class="col-span-4 mt-4">
                        <!-- <button @click="getEmployeeAttendanceReports" class="btn btn-orange">Generate</button> -->
                        <button @click="canShowPeriodDialog = false, getEmployeeAttendanceReports()"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-semibold  fs-6 px-2 py-1.5 border border-gray-400 rounded shadow">
                            Generate
                        </button>

                    </div>

                </div>
            </div>
        </Dialog>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';
import dayjs from 'dayjs'
import { Service } from '../../../Service/Service';
import LoadingSpinner from '../../../../components/LoadingSpinner.vue';

const variable = reactive({
    start_date: '',
    end_date: '',
    department: ''
})

const service = Service()

const canShowPeriodDialog = ref(false)

const AttendanceReportDynamicHeaders = ref([])
const AttendanceReportSource = ref([])
const canShowLoading = ref(false)

const getEmployeeAttendanceReports = async () => {

    // Attendance Basic Reports
    let url = '/fetch-attendance-data'
    canShowLoading.value = true
    await axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
        department: department.value

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
    let url = '/reports/generate-basic-attendance'
    canShowLoading.value = true
    axios.post(url, {
        start_date: variable.start_date,
        end_date: variable.end_date,
        department:variable.department

    }, { responseType: 'blob' }).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        link.download = `Attendance Basic Report_${dayjs(variable.start_date).format('DD-MM-YYYY')}_${dayjs(variable.end_date).format('DD-MM-YYYY')}.xlsx`;
        link.click();
    }).finally(() => {
        canShowLoading.value = false
    })
}


const department = ref()
const departmentOption = ref()


onMounted(() => {
    // getEmployeeAttendanceReports()

    service.DepartmentDetails().then(res => {
        departmentOption.value = res.data
    })
})


</script>


<style>
.p-dropdown
{
    display: inline-flex;
    cursor: pointer;
    position: relative;
    user-select: none;
    height: 28px;
    width: 150px;
}

.p-dropdown .p-dropdown-label
{
    background: transparent;
    border: 0 none;
    margin-top: -7px;
}

.page-content
{
    padding: calc(30px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>


