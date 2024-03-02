<template>
    <div class="mb-1">
        <div class="card ">
            <div class="card-body">
               <div class="grid grid-cols-6">
                <ul class="my-4 nav nav-pills nav-tabs-dashed col-span-4 " role="tablist">
                    <li class="mx-4 nav-item text-muted " role="presentation">
                        <button class="pb-2 nav-link active" id="pills-offer-investment-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-investment" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false" @click="active_tab_finance=1">INVESTMENT DECLARATION</button>
                    </li>
                    <li class="mx-4 nav-item text-muted " role="presentation">
                        <button class="pb-2 nav-link " id="pills-offer-proof-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-proof" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false" @click="active_tab_finance=2">PROOF OF INVESTMENTS</button>
                    </li>

                </ul>
                <div class="col-span-2 flex justify-end ]">
                    <button v-if="active_tab_finance == 1"
                    class="font-medium border-[1px] border-[#dddd] !w-[310px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[14px] flex justify-center items-center gap-2"
                    >
                    <i class="pi pi-lock"></i>
                    Release Investment Declaration
                </button>
                    <button v-if="active_tab_finance ==2"
                    class="font-medium border-[1px] border-[#dddd] !w-[290px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[14px] flex justify-center items-center gap-3"
                    >
                    <i class="pi pi-lock"></i>
                    Release Proof of Investments
                </button>
                </div>
               </div>
                
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-offer-investment" role="tabpanel"
                        aria-labelledby="pills-offer-investment-tab">
                        <div class="card-body">
                            <div class="offer-investment-content">
                                <investment_declaration />
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade " id="pills-offer-proof" role="tabpanel"
                        aria-labelledby="pills-offer-proof-tab">
                        <div class="card-body">
                            <div class="my-4 offer-pending-content">
                                <proof_of_investments />
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
                @click="uesPayroll.activeTab--">Previous</button>
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
                @click="uesPayroll.saveGeneralPayrollSettings(uesPayroll.generalPayrollSettings)">Save</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="uesPayroll.activeTab++">Next</button>
        </div> -->
    </div>
    <router-view></router-view>
</template>


<script setup>
import { onMounted ,ref} from 'vue'
import investment_declaration from './investment_declaration/investment_declaration.vue';
import proof_of_investments from './proof_of_investments/proof_of_investments.vue';
const active_tab_finance=ref(1)
</script>


<style>
*
{
    font-size: 14px;
    font-weight: 501;
}

label
{
    font-size: 14px;
    font-weight: 501;
}</style>
