<template>
    <LoadingSpinner v-if="investmentStore.canShowLoading" class="absolute z-50 bg-white" />

    <Toast />
    <ConfirmDialog></ConfirmDialog>
    <div class="">
        <div>
            <h1 class=" font-['Poppins'] text-[28px]  text-[#000]">Investments</h1>
            <div style="position: relative;" >
                <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
                    <li class=" nav-item" role="presentation">
                        <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                            aria-selected="true" @click="activetab_btn1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                            IT Declaration
                        </a>                      
                        <div v-if="activetab === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;" ></div>
                        <div v-else class=" border-2 h-1 rounded-l-3xl border-gray-300"></div>
                    </li>
    
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn2"
                            :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Investments and Exemptions
                        </a>
                        <div v-if="activetab === 2"
                            class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]" style="border: 2px solid #F9BE00 !important;"></div>
                        <div v-else class=" border-3 h-1  border-gray-300"></div>
                    </li>
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn3"
                            :class="[activetab === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                            Income tax Computations
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
                                <Declaration />
                            </div>
                            <div v-if="activetab === 2">
                                <!-- <EmployeeSummary /> -->
                                <InvestmentAndExemption />
                            </div>
                            <div v-if="activetab === 3">
                                <ImvestmentComputation />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- <Dialog header="Header" v-model:visible="investmentStore.canShowLoading"
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
</template>


<script setup>
import { onMounted,ref,reactive   } from 'vue'
import Declaration from './declaration/declaration.vue'
import InvestmentAndExemption from './investments_and_exemption/investments_and_exemption.vue'
import ImvestmentComputation from './income_tax_computation/incomeTaxComputation.vue'
import LoadingSpinner from '../../../components/LoadingSpinner.vue'


import { investmentMainStore } from '../stores/investmentMainStore'
import { Service } from '../../Service/Service';
import dayjs from 'dayjs'
import { profilePagesStore } from '../../profile_pages/stores/ProfilePagesStore'


const investmentStore = investmentMainStore()
const useProfilePageStore = profilePagesStore()
const service = Service()

onMounted(async () => {
    await investmentStore.getInvestmentSource()
    // await useProfilePageStore.fetchEmployeeDetails();
})


const activetab = ref(1);

const activetab_btn1 = ()=>{
    activetab.value= 1;
}

const activetab_btn2 = ()=>{
    activetab.value= 2;
}
const activetab_btn3 = ()=>{
    activetab.value= 3;
}

const styleObject = reactive({
  border: '3px solid #F9BE00 !important;'
});


</script>


<style >
@import url('https://fonts.googleapis.com/css2?family=Petrona&family=Poppins&display=swap');

.p-dropdown {
    display: inline-flex;
    cursor: pointer;
    position: relative;
    user-select: none;
    height: 32px;
    background: #f6f4f46e;
}

.p-dropdown .p-dropdown-label.p-placeholder {
    position: relative;
    top: -5px;
    /* border: 1px solid red; */
    color: #6c757d;
}

.p-dialog-mask {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
    z-index: 216;
}



i,
span,
.tabview-custom {
    vertical-align: middle;
}

span {
    margin: 0 0.5rem;
}

.AadharCardFront {
    margin-left: 20px;
}

.label {
    width: 170px;
}

.p-tabview p {
    line-height: 1.5;
    margin: 0;
}

dialog>header {
    color: #002f56 !important;
}

.form-selects {
    padding: 0;
    width: 100%;
    height: 2.5rem;
}

.save {
    border: 1px solid #e63b1f;
    color: #e63b1f;
}



.form-selects ::-webkit-scrollbar {
    width: 10px !important;
    border-radius: 12px !important;
}

/* Track */
.form-selects ::-webkit-scrollbar-track {
    background: #f1f1f1 !important;
}

/* Handle */
.form-selects ::-webkit-scrollbar-thumb {
    background: #888 !important;
    border-radius: 12px !important;
}

/* Handle on hover */
.form-selects ::-webkit-scrollbar-thumb:hover {
    background: #252222 !important;
    border-radius: 12px !important;
}

Dialog {
    color: #002f56;
}

.p-inputtext.p-component.p-inputnumber-input {
    height: 32px;
    background: #f6f4f46e;
}

</style>

