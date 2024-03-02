<template>
            <LoadingSpinner v-if="useEmpStore.canShowLoading"  class="absolute z-50 bg-white w-[100%] h-[100%]"/>
    <div>

        <div class="p-4 pt-1 pb-0 mb-3 bg-white rounded-lg tw-card left-line">
            <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="mx-2 nav-item " role="presentation"  >
                    <a class="nav-link " id="" data-bs-toggle="pill" href=""
                        role="tab" aria-controls="" aria-selected="true" @click="activetab = 1" :class="[activetab === 1 ? 'active' : '']">
                        Salary Advance
                    </a>
                </li>

                <li class="mx-3 nav-item " role="presentation"  >
                    <a class="mx-4 text-center nav-link" id="" data-bs-toggle="pill" href="" @click="activetab = 2" :class="[activetab === 2 ? 'active' : '']" role="tab"
                        aria-controls="" aria-selected="true">
                        Interest Free Loan
                        </a>
                </li>
                <li class="mx-3 nav-item " role="presentation"  >
                    <a class="mx-4 text-center nav-link" id="" data-bs-toggle="pill" href=""  @click="activetab = 3" :class="[activetab === 3 ? 'active' : '']"
                        role="tab" aria-controls="" aria-selected="true">

                        Travel Advance
                    </a>
                </li>
                <li class="mx-3 nav-item " role="presentation" >
                    <a class="mx-4 text-center nav-link " id="" data-bs-toggle="pill" href=""  @click="activetab= 4" :class="[activetab === 4 ? 'active' : '']" role="tab"
                        aria-controls="" aria-selected="true">
                         Loan With Interest
                        </a>
                </li>
            </ul>
        </div>


        <!-- Tab Content -->


        <div class="tab-content " id="">
            <div  v-if="activetab === 1" >
              <SalaryAdvance />
            </div>
            <div  v-if="activetab === 2" >
                <InterestFreeLoan />
            </div>
            <div  v-if="activetab === 3">
                <TravelAdvance />
            </div>
            <div  v-if="activetab === 4">
                <LoanWithInterest />
            </div>


        </div>
    </div>
</template>


<script setup>


import { onMounted, ref } from 'vue';
import SalaryAdvance from './salary_advance/salary_advance.vue';
import LoanWithInterest from './loan_with_interest/loan_with_interest.vue';
import InterestFreeLoan from './interest_free_loan/interest_free_loan.vue';
import TravelAdvance from './travel_advance/travel_advance.vue';
import LoadingSpinner from '../../../components/LoadingSpinner.vue';
import {useEmpSalaryAdvanceStore} from '.././stores/employeeSalaryAdvanceLoanMainStore'


const useEmpStore = useEmpSalaryAdvanceStore()



const activetab = ref(1);



</script>
