<template>
         <LoadingSpinner v-if="useManageEmployees.canShowLoadingScreen"  class="absolute z-50 bg-white w-[100%] h-[100%]"/>


    <div class="">
        <div>
            <div style="position: relative;" >
                <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
                    <li class=" nav-item" role="presentation">
                        <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                            aria-selected="true" @click="activetab=1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                            Active Employees
                        </a>
                        <div v-if="activetab === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;" ></div>
                        <div v-else class=" border-2 h-1 rounded-l-3xl border-gray-300"></div>
                    </li>

                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab = 2"
                            :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Yet To Active Employees
                        </a>
                        <div v-if="activetab === 2"
                            class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]" style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1  border-gray-300"></div>
                    </li>
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab = 3"
                            :class="[activetab === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Exit Employee
                        </a>
                        <div v-if="activetab === 3"
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
                </ul>
                <!-- </div> -->
                <!-- Tab Content -->
                <div class="tab-content" id="">
                    <div>
                        <div class="card-body">
                            <div v-if="activetab === 1">
                                <ActiveEmployees />
                            </div>
                            <div v-if="activetab === 2">
                                <!-- <EmployeeSummary /> -->
                                <YetToActiveEmployees />
                            </div>
                            <div v-if="activetab === 3">
                                <ExitEmployees />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>
import {ref} from 'vue'
import ActiveEmployees from './active_employees/active_employees.vue'
import YetToActiveEmployees from './yet_to_active_employees/yet_to_active_employees.vue'
import ExitEmployees from './exit_employees/exit_employees.vue';
import { useManageEmployeesStore } from './manage_service';
import LoadingSpinner from '../../../components/LoadingSpinner.vue';

const useManageEmployees = useManageEmployeesStore();

const activetab = ref(1);

</script>

<style lang="scss">

.progressbar_val3 .p-progressbar-value.p-progressbar-value-animate  {
    /* background-color:#fff !important; */
    background-color: rgb(48, 218, 48) !important;
     color: #fff !important;
}
.progressbar .p-progressbar-value.p-progressbar-value-animate {
    /* background-color:#fff !important; */
    background-color: red !important;
     color: #fff !important;
}
.progressbar_val2 .p-progressbar-value.p-progressbar-value-animate {
    background-color:orange !important;
    color: black !important;
}
</style>

