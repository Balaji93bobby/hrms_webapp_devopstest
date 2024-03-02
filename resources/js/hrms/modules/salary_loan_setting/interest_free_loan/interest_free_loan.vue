<template>
    <div class="px-2">
        <div class="row d-flex justify-content-start align-items-center ">
            <div class="d-flex" v-if="CreateLoanFreeNewFrom == 1">
                <div class="col-3  d-flex align-items-center justify-content-start" style="position: relative; left: -8px;">
                    <h1 class=" text-xl  xl:text-2xl ">Loan Free interest Feature</h1>
                </div>
                <div class="col">
                    <button class="orange_btn "
                        :class="[salaryStore.isInterestFreeLoanFeature === 1 ? 'bg-white text-black border-[1px] border-black' : 'text-white']"
                        @click="salaryStore.isInterestFreeLoanFeature = 0">Disabled</button>
                    <button class="Enable_btn"
                        :class="[salaryStore.isInterestFreeLoanFeature === 1 ? 'bg-green-700 text-white' : '']"
                        @click="salaryStore.isInterestFreeLoanFeature = 1">Enable</button>
                </div>
                <!-- {{loanStores.CreateLoanWithNewFrom  }} -->
                <div class="col">

                    <button @click="CreateLoanFreeNewFrom = 2" v-if="CreateLoanFreeNewFrom == 1"
                        class=" rounded-md text-white bg-blue-800 px-4 py-2 float-right">
                        <i class="pi pi-plus mx-1"></i> Create New From
                    </button>
                </div>
            </div>

            <div class="col" v-if="CreateLoanFreeNewFrom == 1">
                <p class="fs-5 "
                    v-if="salaryStore.isInterestFreeLoanFeature == 0 || salaryStore.isInterestFreeLoanFeature == null">
                    Please click the "Enable" button to activate the Loan With interest Feature for use within
                    your
                    organization.</p>
                <p class="fs-5 " v-if="salaryStore.isInterestFreeLoanFeature == '1'">Please click the "Disable" button to
                    deactivate the Loan With interest Feature.</p>
            </div>

            <div class="" v-if="CreateLoanFreeNewFrom == 1 && salaryStore.isInterestFreeLoanFeature == '1'">
                <div class="row d-flex justify-items-center align-items-center">
                    <div class="col-3">
                        <h1 class="fs-4 ">Select organization</h1>
                    </div>

                    <div class="col">
                        <!-- v-model="salaryStore.sa.selectClientID" -->
                        <!-- {{ salaryStore.client_name_status }} -->

                        <MultiSelect v-model="salaryStore.client_name_status" :options="salaryStore.ClientsName"
                            optionLabel="client_name" :trueValue="1" :falseValue="0" optionValue="id"
                            placeholder="Select Branches" :maxSelectedLabels="3" class=" md:w-18rem"
                            @change="selectClientId('int_free_loan')" />
                    </div>
                </div>

                <div class="row ml-1 mr-3 mt-2 ">

                    <div class="col-12 border-1 rounded-md h-[100px] d-flex flex-column align-items-center justify-content-between p-3 even-card shadow-sm mb-2 blink"
                        v-for="(item, index) in salaryStore.interestFreeLoanHistory" :key="index">

                        <div class="row w-full">
                            <div class="col-4 " >
                                <h1 class="  text-[15px]">Settings Name : {{ item.name }}</h1>
                            </div> 
                            <div class="col-4 ">
                                <h1 class="   text-[15px] text-center">Client Name: {{ item.client_name }}</h1>
                            </div>
                            <div class="col-4 ">
                                <button class=" underline text-blue-400  text-[15px] float-right "
                                @click="viewDetails(item.setting_prev_details,item)">View Details</button>
                            </div>

                        </div>
                        <div class="row w-full">
                            <div class="col-4">
                                <div class=" d-flex justify-content-start">
                                    <h1 class=" text-[15px] text-left mb-2" > {{
                                        item.dedction_period }}  months. </h1>
                                </div>
                              
                            </div>
                            <div class="col-4">
                                <h1 class=" text-[15px] text-green-500 text-center" v-if="item.setting_prev_details.active==1">Active</h1>
                                <h1 class="   text-[15px] text-red-500 text-center" v-if="item.setting_prev_details.active==0">Disable</h1>
                            </div>
                            <div class="col-4">
                                <h1 class=" text-[15px] float-right" v-if="item.setting_prev_details.loan_applicable_type == 'percnt' " >{{ item.loan_type }} : {{ item.perct }}%</h1>
                                <h1 class=" text-[15px] float-right" v-if="item.setting_prev_details.loan_applicable_type =='fixed'">maximum Loan Amount: {{item.setting_prev_details.max_loan_amount}}</h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="CreateLoanFreeNewFrom == 2">
                <CreateNewInterestFreeLoan />
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref, reactive, onMounted, computed } from 'vue';
import { salaryAdvanceSettingMainStore } from '../stores/salaryAdvanceSettingMainStore';
import useValidate from '@vuelidate/core';
import { required, email, minLength, sameAs } from '@vuelidate/validators';
import CreateNewInterestFreeLoan from './create_new_interest_free_loan.vue';
import axios from 'axios';
import { set } from '@vueuse/core';
import {loanSettingsStore} from '../stores/loanSettingsStores';

const salaryStore = salaryAdvanceSettingMainStore()
const showPopup = ref(false)
const CreateLoanFreeNewFrom = ref(1);
const interestFreeLoanHistory = ref();

const loanSettings = loanSettingsStore();


onMounted(() => {
    salaryStore.getClientsName('int_free_loan');
    salaryStore.getCurrentStatus('int_free_loan');
    salaryStore.getInterestFreeAndInterestWithLoanHistory('InterestFreeLoan');
})
const value = ref();
const options = ref(['Off', 'On']);

const selectClientID = ref();

const ingredient = ref('');

const opt = ref()
const op = ref([
    { id: 1, dep: "res" }
])

onMounted(() => {
    opt.value = "Department"
});



const rules = computed(() => {
    return {
        name: { required },
        selectClientID: { required },
        minEligibile: { required },
        maxTenure: { required },
        selectedOption1: { required },

    }
})

function reset() {
    salaryStore.isInterestFreeLoanFeature = 1
}

const v$ = useValidate(rules, salaryStore.ifl)

function selectClientId(data) {
    salaryStore.sendClient_code(data);
}



const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        salaryStore.saveInterestfreeLoan();
    } else {
        console.log('Form failed submitted.')
    }
}

const Name = [];

function viewDetails(setting_prev_details,item) {

    CreateLoanFreeNewFrom.value = 2;

    salaryStore.ifl.name = setting_prev_details.name;

    salaryStore.ifl.selectClientID = item.client_name ;

    salaryStore.ifl.minEligibile = setting_prev_details.min_month_served
    salaryStore.ifl.precent_Or_Amt = setting_prev_details.loan_applicable_type
    salaryStore.ifl.availPerInCtc = setting_prev_details.percent_of_ctc
    salaryStore.ifl.deductMethod = setting_prev_details.deduction_starting_months
    salaryStore.ifl.maxTenure  =setting_prev_details.max_tenure_months


    if (setting_prev_details.deduction_starting_months == 1) {
        salaryStore.ifl.deductMethod = setting_prev_details.deduction_starting_months;
    }
    else {
        salaryStore.ifl.deductMethod = "emi";
        salaryStore.ifl.cusDeductMethod = setting_prev_details.deduction_starting_months;
    }
    salaryStore.selectedOption1 = ""
    salaryStore.selectedOption2 =""
    salaryStore.selectedOption2  = ""

    salaryStore.EnableAndDisable =setting_prev_details.active;
    loanSettings.loan_ID = setting_prev_details.loan_id;

    console.log(setting_prev_details.approver_flow);


       JSON.parse(setting_prev_details.approver_flow).forEach(element => {

        Name.push(element.name)
        console.log(element.name);

        salaryStore.selectedOption1 = Name[0];
        if (Name[1]) {
            salaryStore.selectedOption2 = Name[1];
        }
        if (Name[2]) {
            salaryStore.selectedOption2 = Name[2];
        }
        console.log(Name);
    });

    if (salaryStore.selectedOption1) {
        salaryStore.option1 = 0;
        salaryStore.option = 1

        if (salaryStore.selectedOption2) {
            salaryStore.option1 = 1
            salaryStore.option2 = 1
        }
    }

}



</script>
<style>
* {
    font-family: sans-serif;
}

:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
}

.clr {
    color: var(--navy);
}

.clr-dark {
    color: #454545;

}

.clr-gray {
    color: #949494;
}

.orange_btn {
    background-color: var(--orange);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;
    color: var(--white);
}

.Enable_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 0 4px 4px 0;

}

.cancel_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;

}

.border-L {

    border-left: 3px solid var(--navy);
}

.border-color {
    color: #003154;
    border: 2px solid #003154;
}

.border-color::placeholder {
    color: #002f56 !important;
}

input[type=radio] {
    border: 0px;
    width: 20px;
    height: 20px;
    color: var(--orange) !important;
    background-color: var(--orange) !important;
}

input[type='radio']:after {
    width: 20px;
    height: 20px;
    /* border-radius: 15px; */
    top: -2px;
    left: -1px;
    position: relative;
    background-color: var(--orange);
    content: '';
    display: inline-block;
    visibility: visible;
    /* border: 2px solid white; */
}

.p-dropdown-label.p-inputtext {
    color: var(--navy);
}
</style>

