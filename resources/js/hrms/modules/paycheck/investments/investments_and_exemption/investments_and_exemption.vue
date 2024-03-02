<template>
    <Toast />
    <div class="w-full">
        <TaxSavingInvestments />

        <!-- Navigation Bar -->

        <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
            <!-- hra -->
                    <li class=" nav-item" role="presentation">
                        <a class="px-2 position-relati3e border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                            aria-selected="true" @click="investmentStore.investment_exemption_steps = 1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                            HRA
                        </a>                      
                        <div v-if="investmentStore.investment_exemption_steps === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;" ></div>
                        <div v-else class=" border-2 h-1 rounded-l-3xl border-gray-300"></div>
                    </li>
           <!--   Section 80C & 80CCC -->
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 2"
                            :class="[investmentStore.investment_exemption_steps === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Section 80C & 80CCC
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 2"
                            class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]" style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1  border-gray-300"></div>
                    </li>
                      <!--   Other Exemptions -->
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 3"
                            :class="[investmentStore.investment_exemption_steps === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Other Exemptions
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 3"
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <!--  House Property -->
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 4"
                            :class="[investmentStore.investment_exemption_steps === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            House Property
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 4"
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <!-- Reimbursement -->
                    <li class=" nav-item position-relative  border-0" role="presentation" v-if="investmentStore.reimbursmentSource">
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 5"
                            :class="[investmentStore.investment_exemption_steps === 5 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Reimbursement
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 5" 
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                     <!--   Previous Employer Income -->
                    <li class=" nav-item position-relative  border-0" role="presentation" v-if="investmentStore.previousEmployeerIncomeSource" >
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 6"
                            :class="[investmentStore.investment_exemption_steps === 6 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Previous Employer Income
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 6"
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <!-- Other Source Of Income -->
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id="" data-bs-toggle="pill" href="" @click="investmentStore.investment_exemption_steps = 7"
                            :class="[investmentStore.investment_exemption_steps === 7 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Other Source Of Income
                        </a>
                        <div v-if="investmentStore.investment_exemption_steps === 7"
                            class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
        </ul>


        <!-- Tab Content -->


        <div class="tab-content" id="">
            <div v-if="investmentStore.investment_exemption_steps === 1">
                <HRA />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 2">
                <Section80cc80ccc />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 3">
                <OtherExemption />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 4">
                <HouseProperty />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 5">
                <Reimbursement />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 6">
                <PreviousEmployerIncome />
            </div>
            <div v-if="investmentStore.investment_exemption_steps === 7">
                <OtherSourceOfIncome />
            </div>

        </div>





    </div>
</template>


<script setup>

import TaxSavingInvestments from './tax_saving_investments/tax_saving_investments.vue'
import HRA from './hra/hra.vue';
import Section80cc80ccc from './section_80cc_80ccc/section_80cc_80ccc.vue';
import OtherExemption from './other_exemption/other_exemption.vue';
import HouseProperty from './house_property/house_property.vue';
import Reimbursement from './reimbursement/reimbursement.vue';
import PreviousEmployerIncome from './previous_employer_income/previous_employer_income.vue';
import OtherSourceOfIncome from './other_source_of_income/other_source_of_income.vue';
import { onMounted, ref } from 'vue';
import { investmentMainStore } from '../../stores/investmentMainStore';


const investmentStore = investmentMainStore()

const activetab = ref(investmentStore.investment_exemption_steps);

onMounted(async () => {
    console.log(activetab.value);
    // setTimeout(async () => {
    //     investmentStore.fetchPropertyType()
    // }, 3000);

    // setTimeout(async () => {
    //     investmentStore.hop.splice(0, investmentStore.hop.length);
    // }, 4000);

})

</script>

<style>
.dec_amt
{
    font-weight: 501;
}

.p-inputtext.p-component.p-inputnumber-input
{
    height: 32px;
    background: #f6f4f46e;
    border: 0.1px solid rgba(187, 187, 187, 0.65);
}

.p-inputtext:enabled:focus
{
    outline: 0 none;
    outline-offset: 0;
    box-shadow: 0 0 0 0.2rem #3b82f6fc;
    border-color: #3B82F6;
}

/* .p-dropdown .p-dropdown-label:focus,
.p-dropdown .p-dropdown-label:enabled:focus {

} */

#pv_id_20:focus
{
    outline: 0 none;
    outline-offset: 0;
    box-shadow: 0 0 0 0.2rem #3b82f6fc;
    border-color: #3B82F6;
}

.p-inputtext
{
    margin: 0;
    height: 32px;
    background: #f6f4f46e;
    border: 0.1px solid rgba(187, 187, 187, 0.65);
}
</style>
