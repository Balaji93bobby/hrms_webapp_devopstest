<template>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
    <div class="w-full m-auto">
        <h1 class="font-semibold fs-4 py-2 mx-2">Payroll Setting</h1>
        <div class="mt-3 tabs w-full grid grid-cols-6 border-[4px] border-transparent ">
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 1"
                :class="[usePayroll.activeTab === 1 ? ' !border-b-[3px] !border-[#F9BE00]' : '']">
                <!-- <div class="md:text-sm">1</div>  -->GENERAL PAYROLL SETTING
            </a>
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 2"
                :class="[usePayroll.activeTab === 2 ? ' !border-b-[3px] !border-[#F9BE00]' : '']">
                <!-- <div>2</div> -->
                PF & ESI SETTING</a>
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 3"
                :class="[usePayroll.activeTab === 3 ? ' !border-b-[3px] !border-[#F9BE00]' : '']">
                <!-- <div>3</div> -->
                SALARY COMPONENTS</a>
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 4"
                :class="[usePayroll.activeTab === 4 ? ' !border-b-[3px] !border-[#F9BE00]' : '']">
                <!-- <div>4</div> -->
                SALARY STRUCTURE</a>
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 5"
                :class="[usePayroll.activeTab === 5 ? ' !border-b-[3px] !border-[#F9BE00]' : '' ]">
                <!-- <div>5</div> -->
                INVESTMENTS SETTINGS
            </a>
            <a class="flex font-semibold fs-6 whitespace-nowrap" @click="usePayroll.activeTab = 6"
                :class="[usePayroll.activeTab === 6 ? ' !border-b-[3px] !border-[#F9BE00]' : '']">
                <!-- <div>6</div> -->
                STATUTORY FILLING</a>
        </div>
        <!-- <div class="mt-3 tabs">
      <a class="flex font-semibold fs-6" @click="usePayroll.activeTab = 1" :class="[usePayroll.activeTab === 1 ? 'active' : '']"
        ><div class="md:text-sm">1</div> <p style="width: 200px;">General payroll Setting</p></a
      >
      <a class="d-flex font-semibold fs-6  justify-content-content align-items-center max-[1280px]:flex-col " @click="usePayroll.activeTab = 2" :class="[usePayroll.activeTab === 2 ? 'active' : '']"
        ><div>2</div><p class="max-[1280px]:text-[12px] max-[1280px]:text-center"> PF & ESI Setting</p></a
      >
      <a class="d-flex font-semibold fs-6  justify-content-content align-items-center max-[1280px]:flex-col" @click="usePayroll.activeTab = 3" :class="[usePayroll.activeTab === 3 ? 'active' : '']"
        ><div>3</div><p class="max-[1280px]:text-[12px] max-[1280px]:text-center">Salary Components</p></a
      >
      <a class="d-flex font-semibold fs-6  justify-content-content align-items-center max-[1280px]:flex-col" @click="usePayroll.activeTab = 4" :class="[usePayroll.activeTab === 4 ? 'active' : '']"
        ><div>4</div><p class="max-[1280px]:text-[12px] max-[1280px]:text-center">Salary Structure</p></a
      >
      <a class="d-flex font-semibold fs-6  justify-content-content align-items-center max-[1280px]:flex-col" @click="usePayroll.activeTab = 5" :class="[usePayroll.activeTab === 5 ? 'active' : '']"
        ><div>5</div><p class="max-[1280px]:text-[12px] max-[1280px]:text-center">Finance Setting</p>
      </a>
      <a class="d-flex font-semibold fs-6  justify-content-content align-items-center max-[1280px]:flex-col" @click="usePayroll.activeTab = 6" :class="[usePayroll.activeTab === 6 ? 'active' : '']"><div>6</div><p class="max-[1280px]:text-[12px] max-[1280px]:text-center"> Statutory Filling</p>
       </a
      >
    </div> -->

    <div class="bg-white rounded-md">
      <div v-if="usePayroll.activeTab === 1" class="tabcontent">
        <general_payroll_setting />
      </div>
      <div v-if="usePayroll.activeTab === 2" class="tabcontent">
        <pf_esi />
      </div>
      <div v-if="usePayroll.activeTab === 3" class="tabcontent">
        <salary_components />
      </div>
      <div v-if="usePayroll.activeTab === 4" class="tabcontent">
        <salart_structure />
      </div>
      <div v-if="usePayroll.activeTab === 5" class="tabcontent">
        <finance_setting />
      </div>
      <div v-if="usePayroll.activeTab === 6" class="tabcontent">
        <statutory_filling />
      </div>
    </div>
  </div>
  <Dialog header="Header" v-model:visible="usePayroll.canShowLoading"
  :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
  :closeOnEscape="false">
  <template #header>
      <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
          animationDuration="2s" aria-label="Custom ProgressSpinner" />
  </template>
  <template #footer>
      <h5 style="text-align: center">Please wait...</h5>
  </template>
</Dialog>
</template>

<script setup>
import { onMounted, ref } from "vue";
import general_payroll_setting from "./general_payroll_setting/general_payroll_setting.vue";
import pf_esi from './pf_esi_setting/pf_esi_setting.vue'
import salary_components from "./salary_components/salary_components.vue";
import salart_structure from "./salary_structure/salary_structure.vue";
import statutory_filling from "./statutory_filling/statutory_filling.vue";
import finance_setting from "./finance_setting/finance_setting.vue";

import { usePayrollMainStore } from '../../stores/payrollMainStore'

const usePayroll = usePayrollMainStore()

onMounted(() => {
    usePayroll.getSalaryComponents()
    usePayroll.getsalaryStructure()
    usePayroll.getPayGroupDetails()
})

</script>

<style>
.tabs
{
    overflow: hidden;
    margin-bottom: -2px;
}

.tabs ul
{
    list-style-type: none;
}

.tabs a
{
    float: left;
    cursor: pointer;
    color: #aaa;
    padding: 12px 18px;
    transition: background-color 0.2s;
    border-right: none;
    font-weight: bold;
}

.tabs a>div
{
    color: #aaa;
    background: gainsboro;
    border-radius: 50%;
    width: 20px !important;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 8px;
    font-weight: 700;
    font-family: sans-serif;
}

/* Change background color of tabs on hover */
.tabs a:hover
{
    
  color: #000;
    border-radius: 4px 4px 0 0;
   /* background-color: #aaa;*/
}

.tabs a:hover>div
{
   /* background: #F36826;*/
    color: #000;
    width: 20px;
    height: 20px;
    padding: 0;
}

/* Styling for active tab */
 .active
{
    background-color: #fff;
    color: #0f0101;
    cursor: default;
    border-radius: 4px 4px 0 0;
}

.tabs a.active>div
{
    background: #F36826;
    color: #fff;
    width: 20px;
    height: 20px;
}


/* Style the tab content */
</style>
<!-- .p-dropdown .p-dropdown-label.p-placeholder {
    color: #6c757d;
    margin-top: -5px;
    font-size: 10px;
  } -->
