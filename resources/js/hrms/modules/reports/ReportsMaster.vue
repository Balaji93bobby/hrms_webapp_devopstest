<template>

    <div>
        <div style="position: relative;">
            <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
            <ul class="mb-3 divide-x nav nav-pills divide-solid nav-tabs-dashed w-[50%]" id="pills-tab" role="tablist">
                <li class=" nav-item" role="presentation">
                    <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="activetab = 1,EmployeeMaster.clearfilterBtn(activetab),EmployeeMaster.filterCustomDate(activetab)"
                        :class="[activetab === 1 ? 'active font-semibold border: 2px solid #F9BE00 !important;' : 'font-medium !text-[#8B8B8B] border: 2px solid #dcdcdc !important;']">
                        EMPLOYEE REPORTS
                    </a>
                    <!-- <router-link to="/testing_pradeesh" class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" @click="activetab=1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']"> EMPLOYEE REPORTS</router-link>            -->

                    <div v-if="activetab === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;">
                    </div>
                    <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"
                        style="border: 2px solid #dcdcdc !important;"></div>
                </li>

                <li class="border-0 nav-item position-relative" role="presentation" v-if="false">
                    <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 2"
                        :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        PAYROLL
                    </a>
                    <div v-if="activetab === 2" class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <div v-else class="h-1 border-gray-300 border-3"></div>
                </li>
                <li class="border-0 nav-item position-relative" role="presentation" v-if="false">
                    <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 3"
                        :class="[activetab === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        STATUTORY REPORTS
                    </a>
                    <div v-if="activetab === 3" class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <div v-else class="h-1 border-gray-300 border-3 rounded-r-3xl"></div>
                </li>
                <li class="border-0 nav-item position-relative" role="presentation">
                    <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 4,EmployeeMaster.clearfilterBtn(activetab),EmployeeMaster.filterCustomDate(activetab)"
                        :class="[activetab === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        ATTENDANCE
                    </a>
                    <!-- <router-link to="basicReport" @click="activetab = 4" class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" :class="[activetab === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']">ATTENDANCE</router-link> -->

                    <div v-if="activetab === 4" class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div>
                </li>
                <li class="border-0 nav-item position-relative" role="presentation" v-if="false">
                    <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 5"
                        :class="[activetab === 5 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        LEAVES
                    </a>
                    <div v-if="activetab === 5" class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <div v-else class="h-1 border-gray-300 border-3 rounded-r-3xl"></div>
                </li>
                <li class="border-0 nav-item position-relative" role="presentation">
                    <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 6"
                        :class="[activetab === 6 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        PMS/OKR
                    </a>
                    <div v-if="activetab === 6" class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <div v-else class="h-1 border-gray-300 border-3 rounded-r-3xl"></div>
                </li>
                <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
            </ul>
            <!-- </div> -->
            <!-- Tab Content -->
            <div class="tab-content" id="">
                <div>
                    <div class="card-body">
                        <div v-if="activetab === 1">
                            <employee_master_report />
                        </div>
                        <div v-if="activetab === 4">
                            <!-- <EmployeeSummary /> -->
                            <AttendanceMaster />
                        </div>
                        <div v-if="activetab === 6">
                            <!-- <salary_Revision_Cancelled /> -->
                            <!-- <h1>hi</h1> -->
                            <PMSReports/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import employee_master_report from "./employee_master_report/employee_master_report.vue";
import loadingSpinner from '../../components/LoadingSpinner.vue';
import AttendanceMaster from "./attendance/AttendanceMaster.vue";
import PMSReports from "./pms/PMSReports.vue";

import { EmployeeMasterStore } from "./employee_master_report/employee_master_reportsStore";

const activetab = ref(1);

const EmployeeMaster = EmployeeMasterStore();


onMounted(() => {
    EmployeeMaster.fetchFilterClientIds();
    // EmployeeMaster.getEmployeeCTC();
    EmployeeMaster.getALLdepartment();
    EmployeeMaster.getPeriodMonth();
    // EmployeeMaster.filterCustomDate(1);
})

</script>
