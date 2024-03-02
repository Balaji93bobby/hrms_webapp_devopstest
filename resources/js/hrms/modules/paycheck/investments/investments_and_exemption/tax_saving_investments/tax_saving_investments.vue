<template>
    <div class="mb-3 tw-card">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-2xl font-semibold ">Tax Saving Investment </h6>

            <!-- <select name="" id="" class="w-1/6 px-2 bg-[#0873CD] font-['poppins'] text-[#ffff] form-select disabled_focus">
                <option value="" selected hidden disabled class=" text-[#ffff]" >Apr 2023 - Mar 2024 </option>
                <option value="" selected hidden disabled>Apr 2024 - Mar 2025 </option>
                <option value="" selected hidden disabled>Apr 2025 - Mar 2026 </option>
            </select> -->
            
            <Dropdown optionLabel="name" placeholder="Apr 2025 - Mar 2026" class="!bg-[#0873CD] w-[240px] md:w-14rem" />
        </div>
        <div class="my-6 mx-4 widget-card">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-4">
                <div class="p-2 text-center border-[1px] rounded-lg tw-card bg-[#F6F6F6] border-[#DDDD]">
                    <p class="mb-2 font-semibold text-[14px] font-['Poppins'] ">Declared Amount </p>
                    <h6 class="text-lg font-bold text-[#000]">{{ investmentStore.formatCurrency(investmentStore.taxSavingInvestments.declared_amt) }}</h6>
                </div>
                <div class="p-2 text-center border-[1px] rounded-lg tw-card font-['Poppins'] bg-[#F6F6F6] border-[#DDDD] ">
                    <p class="mb-2 font-semibol text-[14px] font-['Poppins'] text-[#000] ">Approved Amount</p>
                    <h6 class="text-lg font-bold text-[#000]">INR {{ investmentStore.formatCurrency(investmentStore.taxSavingInvestments.max_limit) }}</h6>
                </div>

                <div class="p-2 text-center border-[1px] rounded-lg tw-card bg-[#F6F6F6] border-[#DDDD]">
                    <p class="mb-2  font-['Poppins'] text-[#000] text-[14px] ">Status</p>
                    <h6 v-if="investmentStore.isSubmitted == 0" class="text-lg font-bold text-[#000] ">Submitted</h6>
                    <h6 v-else-if="investmentStore.isSubmitted == 1" class="text-lg font-bold text-[#000]">Drafted</h6>
                    <h6 v-else class="text-lg font-bold">{{ investmentStore.taxSavingInvestments.status }}</h6>
                </div>
                <div class="p-2 text-center border-[1px] rounded-lg tw-card bg-[#F6F6F6] border-[#DDDD]">
                    <p class="mb-2  font-['Poppins'] text-[#000] text-[14px]">Late Date For Submission</p>
                    <h6 class="text-lg font-bold text-[#000]">{{ new Date().toLocaleString('default', { month: 'long', }) }} 27, {{ new
                                Date().getFullYear() }}</h6>
                </div>
            </div>
        </div>
    </div>

</template>


<script setup>
import {investmentMainStore} from '../../../stores/investmentMainStore'
const investmentStore = investmentMainStore()
</script>

<style>

.p-placeholder{
    color:white !important;
}

.p-dropdown-label , .p-dropdown-trigger-icon, .pi-chevron-down{
    color:white !important;
}
</style>


