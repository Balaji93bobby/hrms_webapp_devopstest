<template>
    <div>

        <div  class="row" v-if="CreateLoanWithNew ==2">

<div>
    <div class="col-12  ">

        <div class="my-4 d-flex justify-content-between align-items-center w-[600px]">
            <h1 class="text-xl  xl:text-2xl">Name of the Loan With Interest</h1>
            <div class=" position-relative ">
                <InputText type="text" placeholder="Give Salary Advance a Name" v-model="salaryStore.lwif.name"
                    class="w-[200px] d-flex justify-items-center md:w-18rem" :class="[
                        v$.name.$error ? 'p-invalid ' : '',
                    ]" />
                <span v-if="v$.name.$error" class="text-red-400 fs-6 font-semibold position-absolute top-12">
                    {{ v$.name.required.$message.replace("Value", "Client Name") }}
                </span>
            </div>
        </div>


        <div class=" flex justify-between items-center mt-2 w-[600px]" >
            <h1 class="text-xl  xl:text-2xl">Select organization</h1>
            <div class="d-flex flex-col position-relative">
                <MultiSelect v-model="salaryStore.lwif.selectClientID" v-if="!salaryStore.EnableAndDisable" :options="salaryStore.ClientsName"
                    optionLabel="client_name" optionValue="id" placeholder="Select Branches"
                    :maxSelectedLabels="3" class="w-[200px]  md:w-18rem" :class="[
                        v$.selectClientID.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.selectClientID.$error"
                    class="text-red-400 fs-6 font-semibold position-absolute top-14">
                    {{ v$.selectClientID.required.$message.replace("Value", "Client Name") }}
                </span>
                <InputText type="text" placeholder="Give Salary Advance a Name" disabled  v-if="salaryStore.EnableAndDisable" v-model="salaryStore.lwif.selectClientID"
                class="w-full d-flex justify-items-center md:w-18rem" />
            </div>

        </div>



        <h1 class="mt-4 fs-4 ">Eligible Amount</h1>
        <p class="my-2 fs-5 ">The employees not eligible for Interest Free Loan can also claim the Loan with
            Interest
        </p>

        <div class=" col-12">
            <div class="rounded-lg shadow-sm card border-L ">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="fs-5">The employee must have served for a minimum of
                                <InputNumber  inputId="withoutgrouping" v-model="salaryStore.lwif.minEligibile" :useGrouping="false"
                                    style="max-width: 100px; " class="mx-2" :class="[
                                v$.minEligibile.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="v$.minEligibile.$error" class="text-red-400 fs-6 font-semibold position-absolute top-14">
                            {{ v$.minEligibile.required.$message.replace("Value", "") }}
                        </span>
                        months
                            </h1>

                        </div>
                        <div class="col-12">
                            <h1 class="fs-5 d-flex align-items-center">
                                <RadioButton v-model="salaryStore.lwif.precent_Or_Amt" inputId="ingredient1"
                                    name="dectmeth" value="percnt" class="mx-3" />
                                years to avail the loan amount of

                                <InputNumber  inputId="withoutgrouping" v-if="salaryStore.lwif.precent_Or_Amt == 'percnt'"  :useGrouping="false"
                                    style="max-width: 100px; " class="mx-2"
                                    v-model="salaryStore.lwif.availPerInCtc"
                                     />
                                <InputNumber  inputId="withoutgrouping" v-else disabled
                                    v-model="salaryStore.lwif.availPerInCtc" style="max-width: 100px;"
                                    class="mx-2" :useGrouping="false" />
                                % of their CTC.
                            </h1>
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <RadioButton v-model="salaryStore.lwif.precent_Or_Amt" inputId="ingredient1"
                                name="dectmeth" value="fixed" class="mx-3" />
                            <h1 class="fs-5">Enter the maximum eligible amount of loan can be availed by the
                                employees

                                <InputNumber  inputId="withoutgrouping" v-if="salaryStore.lwif.precent_Or_Amt == 'fixed'"
                                v-model="salaryStore.lwif.max_loan_limit" style="max-width: 100px;"
                                    class="mx-2" :useGrouping="false" />

                                <!-- <InputNumber  inputId="withoutgrouping"
                                    v-model="salaryStore.lwif.max_loan_limit" style="width: 150px;" /> -->

                                <InputNumber  inputId="withoutgrouping" v-else disabled
                                    v-model="salaryStore.lwif.max_loan_limit" style="width: 100px;" :useGrouping="false" />
                            </h1>
                        </div>
                        <div class="col-10">
                            <p class="fs-6 clr-gray ">(Note: This will be calculated based on the employee's
                                date of
                                joining.)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h1 class=" fs-4 mt-[20px]">Interest</h1>
            <p class="my-2 fs-5">Percentage of Interest </p>
            <div class="card border-L">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="fs-5">Enter the percentage of interest for the loan
                                <!-- <InputText type="text" v-model="salaryStore.lwif.loan_amt_interest"
                                    style="width: 150px;" /> -->
                                    <InputNumber  inputId="withoutgrouping"
                                    v-model="salaryStore.lwif.loan_amt_interest" style="width: 100px;" class="mx-2"  :minFractionDigits="1" :maxFractionDigits="5" :class="[
                                v$.loan_amt_interest.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="v$.loan_amt_interest.$error" class="text-red-400 fs-6 font-semibold position-absolute top-14">
                            {{ v$.loan_amt_interest.required.$message.replace("Value", "") }}
                        </span>
                                    of the loan amount.
                            </h1>
                        </div>
                        <div class="col-12">
                            <p class="fs-6 clr-gray">(Note: Please ensure that the percentage entered for
                                the loan interest rate
                                is not higher than the current SBI lending rate.)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mt-[20px]">
            <h1 class="mt-2 fs-4 ">Deduction Method</h1>
            <p class="my-2 fs-5">The EMI, or Equated Monthly Installment, is the sum of the principal amount
                borrowed
                and the interest charged on the loan.</p>
            <!--  -->
            <!--  -->

            <div class="row px-2 ">
                <div class="shadow-sm card border-L rounded-top ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-start align-items-center">
                                <RadioButton v-model="salaryStore.lwif.deductMethod" inputId="ingredient1"
                                    name="dectmeth" :value="1" />
                                <label for="" class="mx-2 fs-5 clr-dark" style="line-height: 25px;">Begin
                                    deducting
                                    the EMI in the
                                    upcoming payroll.</label>
                            </div>
                        </div>


                        <div class="my-1 row">
                            <div class="col-7 d-flex justify-content-start align-items-center">
                                <RadioButton v-model="salaryStore.lwif.deductMethod" inputId="ingredient1"
                                    name="dectmeth" :value="'emi'" />
                                <label for="" class="mx-2 fs-5 clr-dark">Employee can select the month when
                                    they
                                    would like their EMI
                                    payments to begin
                                </label>
                            </div>
                        </div>
                        <div class="ml-1 row" v-if="salaryStore.lwif.deductMethod == 'emi'">
                            <div class="ml-4 col">
                                <h2 class="fs-5 clr-dark">The EMI deductions should begin within
                                    <!-- <InputText type="text" v-model="salaryStore.lwif.cusDeductMethod"
                                        style="max-width: 100px;" class="mx-2" /> -->

                                        <InputNumber  inputId="withoutgrouping"
                                        v-model="salaryStore.lwif.cusDeductMethod" style="width: 100px;" class="mx-2" :useGrouping="false" />

                                        months from the date
                                    the loan is taken.
                                </h2>
                            </div>
                        </div>
                        <div class="ml-1 row" v-if="salaryStore.lwif.deductMethod == 'emi'">
                            <div class="ml-4 col">
                                <p class="fs-6 clr-gray" style="line-height: 14px;">
                                    (Note: During the specified period, employees have the option to select
                                    the
                                    month in which they
                                    would
                                    like the EMI deductions to begin.)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="fs-5 clr-dark">Please specify the maximum duration or tenure for
                                    the
                                    employee to repay the
                                    loan amount
                                    <!-- <InputText type="text" v-model="salaryStore.lwif.maxTenure"
                                        style="max-width: 100px;" class="mx-2" /> -->
                                        <InputNumber  inputId="withoutgrouping"
                                        v-model="salaryStore.lwif.maxTenure" style="width: 100px;" class="mx-2" :useGrouping="false" :class="[
                                v$.maxTenure.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="v$.maxTenure.$error" class="text-red-400 fs-6 font-semibold position-absolute top-14">
                            {{ v$.maxTenure.required.$message.replace("Value", "") }}
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

        </div>

        <h1 class="my-3 fs-4 " style="margin-top: 30px !important;">Approval Setting</h1>
        <p class="my-2 fs-5">Please choose the approval flow for Loan With Interest Feature.</p>

        <div class="card border-L">
            <div class="py-3 row d-flex">
                <div class="my-3 col col-2 d-flex align-items-center" style="width: 200px;">
                    <P class="mx-2 text-[16px] w-[200px]">Employee Request
                    </P>
                    <i class="text-green-400 pi pi-angle-double-right fs-4"></i>
                </div>
                <div class="col col-3 d-flex" style="width: 280px;">
                    <div class="w-10 p-1 rounded bg-slate-200 d-flex align-items-center "
                        style="width: 225px !important;">
                        <Dropdown v-model="salaryStore.selectedOption1" editable
                            :options="salaryStore.filteredApprovalFlow" optionLabel="name"
                            placeholder="Select" class="w-full pl-2 md:w-14rem"
                            @change="salaryStore.toSelectoption(1, salaryStore.selectedOption1)" :class="[
                                v$.selectedOption1.$error ? 'p-invalid' : '',
                            ]" />
                        <span v-if="v$.selectedOption1.$error" class="text-red-400 fs-6 font-semibold position-absolute top-14 mt-3">
                            {{ v$.selectedOption1.required.$message.replace("Value", "Employee Request") }}
                        </span>
                        <button
                            @click="salaryStore.option1 = 0, salaryStore.toSelectoption(4, salaryStore.selectedOption1)"
                            v-if="salaryStore.selectedOption1" class="mx-2">
                            <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                        </button>
                    </div>
                    <button @click="salaryStore.option1 = 1" class="text-green-400 " style="width: 40px;"
                        v-if="salaryStore.option1 == 0 && salaryStore.option == 1">
                        <i class="pi pi-plus-circle fs-4"></i></button>
                    <button class="ml-4 text-green-400 " style="width: 40px;"
                        v-if="salaryStore.option1 == 1">
                        <i class="pi pi-angle-double-right fs-4"></i></button>
                </div>


                <div class="col col-3 d-flex" v-if="salaryStore.option1 == 1" style="width: 280px;">
                    <div class="w-10 p-2 ml-2 rounded bg-slate-200 d-flex align-items-center col-8"
                        style="width: 225px !important;">
                        <Dropdown v-model="salaryStore.selectedOption2" editable
                            :options="salaryStore.filteredApprovalFlow" optionLabel="name"
                            placeholder="Select" class="w-full md:w-14rem pl-0.5"
                            @change="salaryStore.toSelectoption(2, salaryStore.selectedOption2)" />
                        <button
                            @click="salaryStore.option1 = 0, salaryStore.toSelectoption(5, salaryStore.selectedOption2)"
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
                        <Dropdown v-model="salaryStore.selectedOption3" editable
                            :options="salaryStore.filteredApprovalFlow" optionLabel="name"
                            placeholder="Select" class="w-full pl-2 md:w-14rem"
                            @change="salaryStore.toSelectoption(3, salaryStore.selectedOption3)" />
                        <button
                            @click="salaryStore.option2 = 0, salaryStore.toSelectoption(6, salaryStore.selectedOption3)"
                            v-if="salaryStore.option2 == 1">
                            <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!--Next screen  -->

<div class="row mt-[12px]">
    <div class="col">
        <div class=" flex justify-center align-middle" >
                 <button class="btn btn-border-primary" v-if="!salaryStore.EnableAndDisable" @click="cancel_btn">Cancel</button>
                <button class="btn btn-border-primary mx-2 " v-if="salaryStore.EnableAndDisable" @click="cancel_btn">back</button>
                <button class="btn btn btn-primary" v-if="salaryStore.EnableAndDisable === 0 " @click="EnableDisable(1)">Enable</button>
                <button class="btn btn btn-primary" v-if="salaryStore.EnableAndDisable == 1" @click="EnableDisable(0)">Disable</button>
                <!-- submitForm -->
                <!-- {{ salaryStore.EnableAndDisable }} -->
                <button class="mx-4 btn btn-primary" v-if="salaryStore.EnableAndDisable=== ''" @click="submitForm">Save</button>

        </div>
    </div>
</div>

</div>

<div v-if="CreateLoanWithNew == 1">
    <loan_with_interest/>
</div>

    </div>
</template>


<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { salaryAdvanceSettingMainStore } from '../stores/salaryAdvanceSettingMainStore';
import useValidate from '@vuelidate/core';
import { required, email, minLength, sameAs } from '@vuelidate/validators';
import  { loanSettingsStore }  from '../stores/loanSettingsStores';
import  loan_with_interest  from './loan_with_interest.vue';

const salaryStore = salaryAdvanceSettingMainStore();
const loanStores = loanSettingsStore();

const opt = ref()
const op = ref([
    { id: 1, dep: "res" }
])

const CreateLoanWithNew = ref(2);

onMounted(() => {
    opt.value = "Department";
    salaryStore.getClientsName('loan_with_int');
    salaryStore.getCurrentStatus('loan_with_int');
   
})


const rules = computed(() => {
    return {
        name:{required},
        selectClientID: { required },
        minEligibile: { required } ,
        loan_amt_interest: {required},
        maxTenure : { required },
        selectedOption1:{ required }
    }
})

const v$ = useValidate(rules, salaryStore.lwif)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        salaryStore.saveLoanWithInterest();
        CreateLoanWithNew.value = salaryStore.loanWithInterestPage;

    } else {
        console.log('Form failed submitted.')
    }

}


function cancel_btn(){
    CreateLoanWithNew.value = 1;
    salaryStore.RestLwif();
}

function EnableDisable(val){
    salaryStore.RestLwif();
    CreateLoanWithNew.value = 1;
    loanStores.SendEnableAndDisable(val,'InterestWithLoan');
    
}

</script>
