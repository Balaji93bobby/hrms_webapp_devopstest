<template>
    <div class="card font-['poppins']  ">
        <div class="card-body ">
            <div class="flex justify-between p-1 ">
                <div class="  ">
                    <p class="font-bold text-lg">Payroll Summary</p>
                </div>
                <div class="  gap-4 text-sm flex items-center">
                    <p class="whitespace-nowrap text-[#2E3F4A]">View Pay Register</p>
                    <RouterLink :to="`/Payroll/Manage-Payslips`" class="px-2 py-1  "><p class="whitespace-nowrap  text-blue-500 underline underline-offset-1 " @click="usestoreManangePayslips.enable_select_calendar=1"  >Manage PaySlip</p></RouterLink>
                    <p></p>
                    <section class="flex  ">
                        <button @click="ShowRunPayroll = !ShowRunPayroll">
                            <i class="pi pi-chevron-down" style="font-size: 1rem"></i>
                        </button>
                    </section>
                </div>

            </div>
            <div v-if="ShowRunPayroll">
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.employeePayables, 'header')
                        ? useStore.findSelectedHeader(useStore.employeePayables, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.employeePayables" />
                    </div>
                </div>
                <div class="border w-  p-2 ">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.employeeIncomeTax, 'header')
                        ? useStore.findSelectedHeader(useStore.employeeIncomeTax, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.employeeIncomeTax" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.employeeEpf, 'header') ?
                        useStore.findSelectedHeader(useStore.employeeEpf, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.employeeEpf" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.employeeEsic, 'header') ?
                        useStore.findSelectedHeader(useStore.employeeEsic, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.employeeEsic" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.employeeInsurance, 'header')
                        ? useStore.findSelectedHeader(useStore.employeeInsurance, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.employeeInsurance" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.professional_tax, 'header')
                        ? useStore.findSelectedHeader(useStore.professional_tax, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.professional_tax" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.lwf, 'header') ?
                        useStore.findSelectedHeader(useStore.lwf, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.lwf" />
                    </div>
                </div>
                <div class="border w-  p-2">
                    <p class="font-semibold text-[14px]">{{ useStore.findSelectedHeader(useStore.Other_deduction, 'header') ?
                        useStore.findSelectedHeader(useStore.Other_deduction, 'header').value : '' }}</p>
                    <div class="my-2">
                        <payoutCard :source="useStore.Other_deduction" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- {{ useStore.payrollSource }} -->
    <!-- {{ useStore.payrollOutcomeSource }} -->
</template>

<script setup>

import { onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { payrunMainStore } from "../stores/payrunMainStore";
import payoutCard from "../components/payoutCard.vue";
import { Service } from "../../../Service/Service";
import {  useManagePayslip } from '../../../manage_payslips/managePayslipv2/ManangePayslipsService';

const useStore = payrunMainStore();
const service = Service();
const usestoreManangePayslips =  useManagePayslip();

const ShowRunPayroll = ref(true);

onMounted(async () => {
    // service.current_user_client_id
    service.current_session_client_id().then((res) => {
        useStore.client_id = res.data;
        console.log(res.data, 'current_user_client_id sd');
        useStore.getPayrunOutcomeDetails(selectedPayRollDate, res.data);
        useStore.getcurrentFiancialYearStatus(res.data);
    });
    // if( service.current_user_client_id != undefined){

    //     console.log( service.current_user_client_id,' service.current_user_client_id');
    // }
})

const selectedPayRollDate = new Date();

</script>
