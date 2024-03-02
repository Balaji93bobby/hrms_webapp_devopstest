<template>
         <LoadingSpinner v-if="useSalaryStore.canShowLoading"  class="absolute z-50 bg-white w-[100%] h-[100%]"/>
    <div style="position: relative;">
        <div class="row">
            <div class="col-6">
                <h1 class="mb-4 fs-4 d-flex align-items-center " style="color: #003056; "> Salary Advance & Loan Settings</h1>
            </div>
            <!-- <div class="px-4 col-6 ">
                <button class="float-right mx-2 text-blue-700 underline fs-5" @click="viewHistory(data)">History</button>
            </div> -->
        </div>



        <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line w-[98%]">
            <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="mx-2 nav-item " role="presentation">
                    <a class="nav-link " id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                        aria-selected="true" @click="activetab = 1" :class="[activetab === 1 ? 'active' : '']">
                        Salary Advance
                    </a>
                </li>

                <li class="mx-3 nav-item " role="presentation">
                    <a class="mx-4 text-center nav-link" id="" data-bs-toggle="pill" href="" @click="activetab = 2"
                        :class="[activetab === 2 ? 'active' : '']" role="tab" aria-controls="" aria-selected="true">
                        Interest Free Loan
                    </a>
                </li>
                <li class="mx-3 nav-item " role="presentation">
                    <a class="mx-4 text-center nav-link" id="" data-bs-toggle="pill" href="" @click="activetab = 3"
                        :class="[activetab === 3 ? 'active' : '']" role="tab" aria-controls="" aria-selected="true">

                        Travel Advance
                    </a>
                </li>
                <li class="mx-3 nav-item " role="presentation">
                    <a class="mx-4 text-center nav-link " id="" data-bs-toggle="pill" href="" @click="activetab = 4"
                        :class="[activetab === 4 ? 'active' : '']" role="tab" aria-controls="" aria-selected="true">
                        Loan With Interest
                    </a>
                </li>
            </ul>
        </div>
        <!-- Tab Content -->
        <div class="tab-content " id="">
            <div>
                <div class="card-body">
                    <div v-if="activetab === 1">
                        <SalaryAdvance />
                    </div>
                    <div v-if="activetab === 2">
                        <InterestFreeLoan />
                    </div>
                    <div v-if="activetab === 3">
                        <TravelAdvance />
                    </div>
                    <div v-if="activetab === 4">
                        <LoanWithInterest />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <Dialog header="Header" v-model:visible="useSalaryStore.canShowLoading"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
        :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog> -->
    <Dialog v-model:visible="useSalaryStore.canShowPopup" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '40vw' }" :modal="true"
        :closable="true" :closeOnEscape="false">
        <template #header>
            .
        </template>
        <p class="text-center"> <i class="m-auto my-2 text-center text-green-400 pi pi-check-circle"
                style="font-size: 5rem"></i>
        </p>
        <p class="font-semibold text-center fs-4 ">Submission Successfull</p>

        <ul v-for="option in useSalaryStore.AssignedClients" :key="option">
            <li class="my-2.5 text-medium ">{{ option }}</li>
        </ul>
    </Dialog>
</template>


<script setup>


import { onMounted, ref } from 'vue';
import SalaryAdvance from './salary_advance/salary_advance.vue';
import LoanWithInterest from './loan_with_interest/loan_with_interest.vue';
import InterestFreeLoan from './interest_free_loan/interest_free_loan.vue';
import TravelAdvance from './travel_advance/travel_advance.vue';
import { salaryAdvanceSettingMainStore } from './stores/salaryAdvanceSettingMainStore';
import LoadingSpinner from '../../components/LoadingSpinner.vue';

const activetab = ref(1);

const useSalaryStore = salaryAdvanceSettingMainStore()

onMounted(() => {
    useSalaryStore.getDropdownFilterDetails()
})

</script>

<style>
.page-content {
    padding: calc(20px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>
