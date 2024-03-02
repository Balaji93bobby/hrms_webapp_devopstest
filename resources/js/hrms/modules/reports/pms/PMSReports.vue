<template>

    <!-- <loadingSpinner v-if="useEmployeeReport.canShowLoading" class="absolute z-50 bg-white" /> -->
    <div class="px-2">
        <div class="flex justify-between mb-[10px]">
            <h1 class=" text-black text-[24px] font-semibold ">PMS Report</h1>
            <div class="flex item-center">
                <!-- @click="useEmployeeReport.clearfilterBtn(activetab)" -->
                <button
                    class="my-2 flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px] !bg-[#E6E6E6]  mx-2 rounded-[4px] "><i
                        class="mr-2 pi pi-times"></i> Clear Filter</button>
                        <!-- @click="useEmployeeReport.updateEmployeeApplyFilter(activetab)" -->
                        <!-- @click="usePMSReport.getPMSBasicReport()" -->
                        <!-- @click="usePMSReport.getPMSAnnualReport()" -->
                        <button @click="usePMSReport.updatePMSReport(activetab)"
                    class="my-2 flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px] bg-[#F9BE00]     mx-2 rounded-[4px] "><i
                        class="mr-2 pi pi-filter"></i> Run</button>
            </div>
        </div>

        <div style="position: relative;">
            <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
            <div class="flex justify-between ">
                <ul class="flex mb-3 h-[3rem]  !border-[0px]  divide-x !w-[380px] nav nav-pills divide-solid nav-tabs-dashed max-[1024px]:w-[100%]" id="pills-tab" role="tablist">
                    <li class="flex items-center nav-item !border-[0px] " role="presentation">
                        <!-- @click = useEmployeeReport.clearfilterBtn(activetab) -->
                        <a class="p-2 position-relative font-['poppins'] !border-r-[0px] text-[14px] text-[#001820] w-[100%] !m-[0px] " id=""
                            data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="activetab = 1"
                            :class="[activetab === 1 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                           Basic Annual Report
                        </a>
                    </li>

                    <li class="flex items-center nav-item !border-[0px]" role="presentation">
                        <!-- useEmployeeReport.clearfilterBtn(activetab) -->
                        <a class="p-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]" id=""
                            data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="activetab = 2"
                            :class="[activetab === 2 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            Detailed Annual Report
                        </a>
                    </li>
                </ul>

                <!-- <ul class="flex justify-between max-[1200px]:w-[60%] max-[1200px]:justify-start flex-wrap max-[1024px]:w-[100%] ">
                    <li class="flex items-center ">
                        <h1 class="text-[12px] text-black px-1  font-semibold font-['poppins'] whitespace-nowrap">Period :
                        </h1>
                        <Dropdown optionLabel="month" optionValue="date" :options="useEmployeeReport.PeriodMonth"
                            v-model="useEmployeeReport.period_Date"
                            @change="useEmployeeReport.getSelectoption('date', useEmployeeReport.period_Date, activetab)"
                            placeholder="   -- Select --"
                            class="w-[150px]  mx-1 !h-10  !font-semibold !font-['poppins'] !text-[#000] !bg-[#E6E6E6]" />

                    </li>
                    <li class="flex items-center">
                        <h1 class="text-[12px] text-black px-1 font-semibold  font-['poppins']  whitespace-nowrap">
                            Department : </h1>

                        <MultiSelect v-model="useEmployeeReport.Department" :options="useEmployeeReport.department"
                            optionLabel="name" placeholder=" -- Select --"
                            @change="useEmployeeReport.getSelectoption('department', useEmployeeReport.Department, activetab)"
                            optionValue="id" :maxSelectedLabels="3"
                            class="min-w-[100px] w-[150px]   !font-semibold !font-['poppins'] !h-10 text-[#000] !bg-[#E6E6E6]" />
                    </li>
                    <li class="flex items-center">
                        <h1 class="text-[12px] text-black px-1 font-semibold  font-['poppins']  whitespace-nowrap">Legal
                            Entity : </h1>
                        <MultiSelect
                            @change="useEmployeeReport.getSelectoption('legal_entity', useEmployeeReport.legal_Entity, activetab)"
                            v-model="useEmployeeReport.legal_Entity" :options="useEmployeeReport.client_ids"
                            optionLabel="client_fullname" placeholder=" -- Select --" optionValue="id" :maxSelectedLabels="3"
                            class="min-w-[100px] w-[150px]  !font-semibold !font-['poppins'] !h-10 text-[#000] !bg-[#E6E6E6]" />
                    </li>
                    <li class="flex items-center my-1">
                        <h1 class="text-[12px] text-black px-1 font-semibold  font-['poppins']  whitespace-nowrap">Status :
                        </h1>
                        <MultiSelect
                            @change="useEmployeeReport.getSelectoption('Category', useEmployeeReport.select_Category, activetab)"
                            v-model="useEmployeeReport.select_Category" optionValue="id" :options="dropdown"
                            optionLabel="name" placeholder="-- Select --" :maxSelectedLabels="3"
                            class="min-w-[100px] w-[150px]  !font-semibold !font-['poppins'] !h-10 text-[#000] !bg-[#E6E6E6] mx-2 " />
                    </li>
                </ul> -->

            </div>

            <!-- </div> -->
            <!-- Tab Content -->
            <div class="tab-content" id="">
                <div>
                    <div class="card-body">
                        <div v-if="activetab === 1">
                            <loadingSpinner v-if="useEmployeeReport.canShowLoading" class="absolute z-50 bg-white" />
                            <BasicReport />
                        </div>
                        <div v-if="activetab === 2">
                            <loadingSpinner v-if="useEmployeeReport.canShowLoading" class="absolute z-50 bg-white" />
                            <!-- <EmployeeSummary /> -->
                            <DetailReport />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { onMounted, ref } from 'vue';
import BasicReport from './BasicReport.vue'
import DetailReport from './DetailReport.vue'
import { EmployeeMasterStore } from "../employee_master_report/employee_master_reportsStore";
import loadingSpinner from "../../../components/LoadingSpinner.vue";
import { PMSMasterStore} from './PMSReport'

const usePMSReport = PMSMasterStore()




const useEmployeeReport = EmployeeMasterStore();

onMounted(() => {
    // useEmployeeReport.fetchFilterClientIds();
    // // useEmployeeReport.getEmployeeCTC();
    // useEmployeeReport.getALLdepartment();
    // useEmployeeReport.getPeriodMonth();

})

const activeClass = ref('border-[1px] border-[#F9BE00]');

const deactivate = ref('border-[1px] border-[#DCDCDC]');



const activetab = ref(1);



const dropdown = ref([
    { name: "Active", id: 1 },
    { name: "Yet To Active", id: 0 },
    { name: "Exit", id: -1 },
])






</script>

<style>
.dropdown:hover .dropdown-content
{
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content
{
    padding: 0;
    z-index: 0 !important;
}

.p-dropdown-label,
.p-inputtext
{
    position: relative;
    top: 2px;
}

.p-inputtext::placeholder
{
    color: #000 !important;
}

.p-dropdown-label::placeholder,
.p-inputtext::placeholder
{
    color: #000 !important;
    font-size: 10px;
}

.p-placeholder
{
    color: #000 !important;
    font-family: 'poppins';
    font-size: 12px;
    /* font-size:11px; */
}

.p-inputtext
{
    color: #000 !important;
    font-family: 'poppins';
}

.p-dropdown-label
{
    position: relative;
    top: -2px;
}

.p-multiselect-header::after
{
    content: "All";
    font-weight: 502;
    position: absolute;
    left: 50px;
}

a
{
    color: #000 !important;
}

.p-multiselect-panel {
    z-index: 0 !important;
}

.p-dropdown .p-dropdown-label{
    margin-top: 0px;
}
</style>
