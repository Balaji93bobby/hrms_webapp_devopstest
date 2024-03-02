<template>
    <!-- <p class="fs-5">Please click the "Disable" button to deactivate the Interest Free Loan Feature.</p> -->
    <div v-if="interest_free_loans ==2">
    <div class="my-4 flex  justify-between w-[600px]">
        <h1 class="text-xl  xl:text-2xl ">Name of the Interest Free Loan</h1>
        <div class=" ">
            <InputText type="text" placeholder="Name of Interest free loan" v-model="salaryStore.ifl.name"
                class=" d-flex justify-items-center w-[200px] md:w-18rem" :class="[
                    v$.name.$error ? 'p-invalid' : '',
                ]" />
            <span v-if="v$.name.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.name.$errors[0].$message }}
            </span>


        </div>
    </div>


    <div class=" flex justify-between items-center mt-5 w-[600px]">
        <h1 class="text-xl  xl:text-2xl">Select organization</h1>
        <div class="">
            <div class="d-flex flex-col position-relative">
                <MultiSelect v-model="salaryStore.ifl.selectClientID" v-if="!salaryStore.EnableAndDisable"  :options="salaryStore.ClientsName"
                    optionLabel="client_name" optionValue="id" placeholder="Select Branches" :maxSelectedLabels="3"
                    class="w-[200px]  md:w-24rem" :class="[
                        v$.selectClientID.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.selectClientID.$error" class="text-red-400 fs-6 font-semibold position-absolute top-14">
                    {{ v$.selectClientID.required.$message.replace("Value", "Client Name") }}
                </span>
                <InputText type="text" placeholder="Name of Interest free loan" disabled  v-if="salaryStore.EnableAndDisable" v-model="salaryStore.ifl.selectClientID"
                class="w-full d-flex justify-items-center md:w-18rem" />
            </div>

        </div>
    </div>
    <div class="col">
        <h1 class="mt-10 fs-4 ">Eligible Employees and Amount</h1>
        <p class="mt-3 fs-5">The employee's eligibility for the loan amount can be determined based on the
            number of
            years they have served in the organization.</p>
    </div>
    <div class=" col-12">
        <div class="rounded-lg shadow-sm card border-L ">
            <div class="card-body ">
                <div class="row">
                    <div class="col-12">
                        <h1 class="fs-5">The employee must have served for a minimum of
                            <!-- <InputText type="text" v-model="salaryStore.ifl.minEligibile"
                                    style="max-width: 100px; " class="mx-2" /> -->
                            <InputNumber v-model="salaryStore.ifl.minEligibile" inputId="withoutgrouping"
                                :useGrouping="false" :class="[
                                    v$.minEligibile.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="v$.minEligibile.$error"
                                class="text-red-400 fs-6 font-semibold position-absolute top-14">
                                {{ v$.minEligibile.required.$message.replace("Value", "") }}
                            </span>
                            months
                        </h1>
                    </div>
                    <div class="col-12">
                        <h1 class="fs-5 d-flex align-items-center">
                            <RadioButton v-model="salaryStore.ifl.precent_Or_Amt" inputId="ingredient1" name="dectmeth"
                                :value="'percnt'" class="mx-3" />
                            years to avail the loan amount of

                            <!-- <InputText type="text"   v-model="salaryStore.ifl.availPerInCtc" style="max-width: 100px;" class="mx-2" /> -->
                            <InputNumber v-if="salaryStore.ifl.precent_Or_Amt == 'percnt'" style="max-width: 100px;"
                                v-model.number="salaryStore.ifl.availPerInCtc" inputId="withoutgrouping"
                                :useGrouping="false" class="mx-2" />

                            <InputNumber v-else disabled style="max-width: 100px;"
                                v-model.number="salaryStore.ifl.availPerInCtc" inputId="withoutgrouping"
                                :useGrouping="false" class="mx-2" />
                            % of their CTC.
                        </h1>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        <RadioButton v-model="salaryStore.ifl.precent_Or_Amt" inputId="ingredient1" name="dectmeth"
                            :value="'fixed'" class="mx-3" />
                        <h1 class="fs-5">Enter the maximum eligible amount of loan can be availed by the
                            employees
                            <!-- <InputText v-if="salaryStore.ifl.precent_Or_Amt == 'fixed'" type="text"
                                    v-model="salaryStore.ifl.max_loan_limit"  /> -->
                            <InputNumber v-if="salaryStore.ifl.precent_Or_Amt == 'fixed'"
                                v-model="salaryStore.ifl.max_loan_limit" inputId="withoutgrouping" :useGrouping="false"
                                class="mx-2" />

                            <InputNumber v-else disabled v-model="salaryStore.ifl.max_loan_limit" inputId="withoutgrouping"
                                :useGrouping="false" class="mx-2" />
                            <!-- <InputText v-else disabled type="text" v-model="salaryStore.ifl.max_loan_limit"
                                    style="width: 150px;" /> -->
                        </h1>
                    </div>
                    <div class="col-10">
                        <p class="fs-6 clr-gray ">(Note: This will be calculated based on the employee's date of
                            joining.)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <h1 class="mt-2 fs-4 ">Deduction Method</h1>
        <p class="my-2 fs-5">In the case of an interest-free loan, the EMI would only consist of repayment of
            the
            principal amount borrowed, and no interest would be charged.</p>

        <div class="row">
            <div class="shadow-sm card border-L rounded-top">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7 d-flex justify-content-start align-items-center">
                            <RadioButton v-model="salaryStore.ifl.deductMethod" inputId="ingredient1" name="dectmeth"
                                :value="1" />
                            <label for="" class="mx-3 fs-5 clr-dark" style="line-height: 25px;">Begin deducting
                                the EMI in the
                                upcoming payroll.</label>
                        </div>
                    </div>


                    <div class="my-1 row">
                        <div class="col-7 d-flex justify-content-start align-items-center">
                            <RadioButton v-model="salaryStore.ifl.deductMethod" inputId="ingredient1" name="dectmeth"
                                :value="'emi'" />
                            <label for="" class="mx-3 fs-5 clr-dark">Employee can select the month when they
                                would like their EMI
                                payments to begin
                            </label>
                        </div>
                    </div>
                    <div class="ml-1 row" v-if="salaryStore.ifl.deductMethod == 'emi'">
                        <div class="ml-4 col">
                            <h2 class="fs-5 clr-dark">The EMI deductions should begin within
                                <InputText type="text" v-model="salaryStore.ifl.cusDeductMethod" style="max-width: 100px;"
                                    class="mx-2" />months from the date
                                the loan is taken.
                            </h2>
                        </div>
                    </div>
                    <div class="ml-1 row" v-if="salaryStore.ifl.deductMethod == 'emi'">
                        <div class="ml-4 col">
                            <p class="fs-6 clr-gray" style="line-height: 14px;">
                                (Note: During the specified period, employees have the option to select the
                                month in which they
                                would
                                like the EMI deductions to begin.)</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fs-5 clr-dark">Please specify the maximum duration or tenure for the
                                employee to repay the
                                loan amount
                                <!-- <InputText type="text" v-model="salaryStore.ifl.maxTenure"
                                        style="max-width: 100px;" class="mx-2" /> -->
                                <InputNumber v-model="salaryStore.ifl.maxTenure" inputId="withoutgrouping"
                                    :useGrouping="false" class="mx-2" :class="[
                                        v$.maxTenure.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="v$.maxTenure.$error"
                                    class="text-red-400 fs-6 font-semibold position-absolute top-14">
                                    {{ v$.maxTenure.required.$message.replace("Value", "maximum duration") }}
                                </span>
                                months
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h1 class="my-3 fs-4 " style="margin-top: 30px !important;">Approval Setting</h1>
        <p class="my-2 fs-5">Please choose the approval flow for Interest Free Loan Feature.</p>

        <div class="card border-L">
            <div class="py-3 row d-flex">
                <div class="my-3 col col-2 d-flex align-items-center" style="width: 200px;">
                    <P class=" text-[18px] w-[200px] ">Employee Request
                    </P>
                    <i class="text-green-400 pi pi-angle-double-right fs-4"></i>
                </div>
                <div class="col col-3 d-flex" style="width: 280px;">
                    <div class="w-10 p-1 rounded bg-slate-200 d-flex align-items-center " style="width: 225px !important;">
                        <Dropdown v-model="salaryStore.selectedOption1" editable :options="salaryStore.filteredApprovalFlow"
                            optionLabel="name" placeholder="Select" class="w-full pl-2 md:w-14rem"
                            @change="salaryStore.toSelectoption(1, salaryStore.selectedOption1)" :class="[
                                v$.selectedOption1.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="v$.selectedOption1.$error"
                            class="text-red-400 fs-6 font-semibold position-absolute top-14 mt-3">
                            {{ v$.selectedOption1.required.$message.replace("Value", "Employee Request") }}
                        </span>
                        <button @click="salaryStore.option1 = 0, salaryStore.toSelectoption(4, salaryStore.selectedOption1)"
                            v-if="salaryStore.selectedOption1" class="mx-2">
                            <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                        </button>
                    </div>
                    <button @click="salaryStore.option1 = 1" class="text-green-400 " style="width: 40px;"
                        v-if="salaryStore.option1 == 0 && salaryStore.option == 1">
                        <i class="pi pi-plus-circle fs-4"></i></button>
                    <button class="ml-4 text-green-400 " style="width: 40px;" v-if="salaryStore.option1 == 1">
                        <i class="pi pi-angle-double-right fs-4"></i></button>
                </div>


                <div class="col col-3 d-flex" v-if="salaryStore.option1 == 1" style="width: 280px;">
                    <div class="w-10 p-2 ml-2 rounded bg-slate-200 d-flex align-items-center col-8"
                        style="width: 225px !important;">
                        <Dropdown v-model="salaryStore.selectedOption2" editable :options="salaryStore.filteredApprovalFlow"
                            optionLabel="name" placeholder="Select" class="w-full md:w-14rem pl-0.5"
                            @change="salaryStore.toSelectoption(2, salaryStore.selectedOption2)" />
                        <button @click="salaryStore.option1 = 0, salaryStore.toSelectoption(5, salaryStore.selectedOption2)"
                            v-if="salaryStore.option1 == 1">
                            <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                        </button>
                    </div>
                    <button @click="salaryStore.option2 = 1" class="text-green-400 "
                        v-if="salaryStore.option2 == 0 && salaryStore.option1 == 1" style="width: 40px;">
                        <i class="pi pi-plus-circle fs-4"></i></button>

                    <button class="text-green-400 " style="width: 40px;" v-if="salaryStore.option2 == 1">
                        <i class="ml-4 pi pi-angle-double-right fs-4"></i></button>
                </div>


                <div class="col col-3 d-flex" v-if="salaryStore.option2 == 1" style="width: 280px;">
                    <div class="w-10 p-2 ml-2 rounded bg-slate-200 d-flex align-items-center"
                        style="width: 225px !important;">
                        <Dropdown v-model="salaryStore.selectedOption3" editable :options="salaryStore.filteredApprovalFlow"
                            optionLabel="name" placeholder="Select" class="w-full pl-2 md:w-14rem"
                            @change="salaryStore.toSelectoption(3, salaryStore.selectedOption3)" />
                        <button @click="salaryStore.option2 = 0, salaryStore.toSelectoption(6, salaryStore.selectedOption3)"
                            v-if="salaryStore.option2 == 1">
                            <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-[12px]">
        <div class="col">
            <div class=" flex justify-center align-middle">
                <button class="btn btn-border-primary" v-if="!salaryStore.EnableAndDisable" @click="cancel_btn">Cancel</button>
                <button class="btn btn-border-primary mx-2 " v-if="salaryStore.EnableAndDisable" @click="back_btn">back</button>
                <button class="btn btn btn-primary mx-2" v-if="salaryStore.EnableAndDisable === 0 " @click="EnableDisable(1)">Enable</button>
                <button class="btn btn btn-primary" v-if="salaryStore.EnableAndDisable == 1" @click="EnableDisable(0)">Disable</button>
                <!-- submitForm -->
                <button class="mx-4 btn btn-primary" v-if="salaryStore.EnableAndDisable===''" @click="submitForm">Save</button>
            </div>
        </div>
    </div>
</div>
    <div v-if="interest_free_loans ==1">
        <interest_free_loan/>
    </div>
</template>

<script setup>

import { ref, reactive, onMounted, computed } from 'vue';
import { salaryAdvanceSettingMainStore } from '../stores/salaryAdvanceSettingMainStore';
import useValidate from '@vuelidate/core';
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators';
import interest_free_loan from './interest_free_loan.vue';
import {loanSettingsStore} from '../stores/loanSettingsStores';

const salaryStore = salaryAdvanceSettingMainStore();

const useSettingStore = loanSettingsStore();


const interest_free_loans = ref(2);


const rules = computed(() => {
    return {
        name: { required },
        selectClientID: { required },
        minEligibile: { required },
        maxTenure: { required },
        selectedOption1: { required },
    }
})

const v$ = useValidate(rules, salaryStore.ifl)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        salaryStore.saveInterestfreeLoan();
        interest_free_loans.value = salaryStore.interstfreeloanPage
    } else {
        console.log('Form failed submitted.')
    }
}


function EnableDisable(val){

    salaryStore.resetIfl();
    interest_free_loans.value=1;
    useSettingStore.SendEnableAndDisable(val,'InterestFreeLoan');
}

function back_btn(){
      salaryStore.resetIfl();
          interest_free_loans.value=1;
}

function cancel_btn(){
    interest_free_loans.value=1;
      salaryStore.resetIfl();
}





</script>
