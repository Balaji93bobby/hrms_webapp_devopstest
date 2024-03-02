<template>
    <div class="mr-4 card">
        <div class="px-5 row d-flex justify-content-start align-items-center card-body">
            <div class="flex justify-between gap-6 my-2">
                <div class=" fs-4">
                    <p class="text-xl font-medium">You are eligible for the Loan with Interest as per the
                        <span class="text-lg text-primary text-decoration-underline"> Company's Loan Policy </span>
                    </p>
                </div>

                <div class="float-right ">
                    <button class="btn btn-border-orange">View Report</button>
                    <button class="mx-4 btn btn-orange" @click="openPosition('top')">
                        <i class="mx-2 fa fa-plus" aria-hidden="true"></i>
                        New Request
                    </button>
                </div>
            </div>

            <div class="my-6 widget-card">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5 lg:grid-cols-5">
                    <div class="p-3 text-center bg-red-100 border-l-4 rounded-lg tw-card border-l-red-400">
                        <p class="mb-2 font-bold text-ash-medium f-13">Total Advance Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                    <div class="p-2 text-center bg-green-100 border-l-4 rounded-lg tw-card border-l-green-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 "> Total Repaid Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>

                    <div class="p-2 text-center bg-blue-100 border-l-4 rounded-lg tw-card border-l-blue-400 ">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Balance Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">Not Submited</h6>
                    </div>
                    <div class="p-2 text-center bg-orange-100 border-l-4 rounded-lg tw-card border-l-orange-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Pending Request</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                    <div class="p-2 text-center bg-yellow-100 border-l-4 rounded-lg tw-card border-l-yellow-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Completed Rquests</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <!-- {{useEmpStore.InterestWithLoanData}} -->
                <DataTable :value="useEmpStore.InterestWithLoanData" ref="dt" dataKey="id" :paginator="true" :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll">

                    <Column header="Request ID" field="request_id" style="min-width: 8rem">

                    </Column>
                    <Column header="Loan Amount" field="borrowed_amount" style="min-width: 8rem">
                    </Column>

                    <Column field="emi_per_month" header="Monthly EMI" style="min-width: 12rem">

                    </Column>

                    <Column field="tenure_months" header="Tenure" style="min-width: 12rem">

                    </Column>
                    <Column field="deduction_starting_month" header="EMI Start Date" style="min-width: 12rem">

                    </Column>
                    <Column field="deduction_ending_month" header="EMI End Date" style="min-width: 12rem">

                    </Column>
                    <Column field="loan_status" header="Status" style="min-width: 12rem">
                        {{ slotProps.data.loan_status }}
                    </Column>

                </DataTable>

            </div>

        </div>
    </div>

    <Dialog v-model:visible="useEmpStore.dialogInterestwithLoan" modal header="Header" :style="{ width: '60vw' }">
        <template #header>
            <div>
                <h1 style="border-left: 3px solid var( --orange);padding-left: 10px ;" class="fs-4">New interest With Loan
                    Request</h1>
            </div>
        </template>
        <div class="row p-2">
            <!-- {{ useEmpStore.InterestWithLoan.details }} -->
            <div class="col-7">

                <div class="card border-0">
                    <div class="card-body bg-gray-100 ">
                        <div class="row  ">
                            <div class="col-6   " style="margin-right: 30px;">
                                <h1 class="fs-5 my-2 ">Required Amount</h1>
                                <!-- <InputText type="text" v-model="useEmpStore.InterestWithLoan.required_amount" placeholder="&#8377; Enter The Required Amount" /> -->
                                <InputNumber v-model="useEmpStore.InterestWithLoan.required_amount"
                                    placeholder="&#8377; Enter The Required Amount" inputId="withoutgrouping"
                                    :useGrouping="false"
                                    :class="[v$.required_amount.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                                <br>
                                <span v-if="v$.required_amount.$error" class="font-semibold text-red-400 fs-6">
                                    {{ v$.required_amount.$errors[0].$message }}
                                </span>
                                <p class="fs-6 my-2" style="color: var(--clr-gray)">Max Eligible Amount :
                                    {{ useEmpStore.InterestWithLoan.minEligibile }}
                                </p>
                            </div>
                            <!-- {{ useEmpStore.InterestWithLoan.max_tenure_months }} -->
                            <div class="col mx-2">
                                <h1 class="fs-5 my-2">Term</h1>
                                <Dropdown v-model="useEmpStore.InterestWithLoan.Term"
                                    :options="useEmpStore.InterestWithLoan.max_tenure_months" @change="selectMonth"
                                    optionLabel="month" optionValue="month" placeholder="select month"
                                    class="w-full md:w-10rem"
                                    :class="[v$.Term.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                                <label for="" class="fs-5 ml-1" style="color:var(--navy) ; ">Month</label>
                                <br>

                                <span v-if="v$.Term.$error" class="font-semibold text-red-400 fs-6">
                                    {{ v$.Term.$errors[0].$message }}
                                </span>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pr-5">
                                <button
                                    @click="useEmpStore.calculateLoanDetails(useEmpStore.InterestWithLoan.required_amount, useEmpStore.InterestWithLoan.Interest_rate, useEmpStore.InterestWithLoan.Term)"
                                    class="bg-danger text-light pt-2 pl-4 pr-4 pb-2  float-right rounded hover:bg-red-500 shadow-md">Calculate
                                    EMI</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col">
                <div class="row">
                    <div class="col-12 pl-8 pr-8 ">
                        <div
                            class="div p-2 d-flex justify-items-center align-items-center flex-column rounded bg-blue-100 shadow-md">
                            <!-- disabled -->
                            <input
                                class="fw-bolder fs-4 text-blue-900 p-2 ml-2 d-flex justify-items-center text-center bg-blue-100"
                                placeholder="%" style="width: 100px;" v-model="useEmpStore.InterestWithLoan.Interest_rate"
                                disabled prefix="%" />
                            <h1 class=" fw-semibold  mt-1 fs-5">Interest Rate</h1>
                        </div>

                    </div>

                    <div class="col  pl-8 pr-8 ">
                        <div class="div allcenter p-2 rounded shadow-md" style="background: #FDCFCF;">

                            <div class="div d-flex justify-content-center align-items-center">

                                <h1 class="fw-bolder fs-4">&#8377; </h1>
                                <input class="fw-bolder fs-4  pl-2 text-center" style="width: 100px;background: #FDCFCF  ;"
                                    v-model="useEmpStore.InterestWithLoan.M_EMI" disabled />
                            </div>
                            <h1 class=" fw-semibold mt-2 fs-5">Monthly payment</h1>
                        </div>

                    </div>

                    <div class="col  pl-8 pr-8 ">
                        <div class="div allcenter p-2 rounded bg-green-100 shadow-md">
                            <div class="div d-flex justify-content-center align-items-center">
                                <h1 class="fw-bolder fs-4">&#8377; </h1>
                                <input v-model="useEmpStore.InterestWithLoan.total_amount"
                                    class="fw-bolder fs-4  pl-2 bg-green-100 text-center" style="width: 100px;" disabled />
                            </div>
                            <h1 class=" fw-semibold mt-2 fs-5">Total loan amount</h1>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        <div class="card bg-gray-100 bottom-0 my-4" style="border:none ">
            <div class="card-body mx-4">
                <div class="row">
                    <!-- fw-bolder -->
                    <h1 class="fs-4 my-2  ">EMI Dedution</h1>
                    <h1 class="fs-5 text-gray-600 mb-3">The EMI Dedution Will begin from the Upcoming Payroll</h1>
                    <div class="col-4">
                        <h1 class="fs-5 my-2 ml-2">EMI Start Month</h1>
                        <Dropdown @change="calculateMonth" v-model="useEmpStore.InterestWithLoan.EMI_Start_Month"
                            :options="useEmpStore.InterestWithLoan.details.deduction_starting_month" optionLabel="date"
                            placeholder="select date" class="w-full md:w-10rem" optionValue="date"
                            :class="[v$.EMI_Start_Month.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                        <br>
                        <span v-if="v$.EMI_Start_Month.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.EMI_Start_Month.$errors[0].$message }}
                        </span>
                    </div>

                    <div class="col-4 mx-2">
                        <h1 class="fs-5 my-2 ml-2">EMI End Month</h1>
                        <Calendar v-model="useEmpStore.InterestWithLoan.EMI_End_Month" showIcon />
                    </div>
                    <div class="col-3">
                        <h1 class="fs-5 my-2 ml-2">Total Months</h1>
                        <InputText type="text" v-model="useEmpStore.InterestWithLoan.Total_Month"
                            style="width: 150px !important;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
            <span class="font-semibold ">Reason</span>
            <Textarea v-model="useEmpStore.InterestWithLoan.Reason" class="my-3 capitalize form-control textbox" autoResize
                type="text" rows="3"
                :class="[v$.Reason.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
            <br>
            <span v-if="v$.Reason.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.Reason.$errors[0].$message }}
            </span>
        </div>

        <div class="float-right ">
            <button class="btn btn-border-dark border-dark px-5"
                @click="useEmpStore.dialogInterestwithLoan = false">Cancel</button>
            <button class="mx-4 btn btn-orange px-5" @click="submitForm">Submit</button>
        </div>

    </Dialog>
</template>
<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { useEmpSalaryAdvanceStore } from '../../stores/employeeSalaryAdvanceLoanMainStore';
import dayjs from 'dayjs';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { useNow, useDateFormat } from '@vueuse/core'

const useEmpStore = useEmpSalaryAdvanceStore()
const loanDetails = ref([])

onMounted(() => {
    useEmpStore.fetchInterstWithLoan();
    useEmpStore.getLoanDetails();
    // useEmpStore.getLoanDetails('InterestWithLoan').then(res => {
    //     loanDetails.value.push(res.data)
    // })
})

const value = ref();
const options = ref(['Off', 'On']);


const position = ref('center');

const openPosition = (pos) => {
    position.value = pos;
    useEmpStore.dialogInterestwithLoan = true;
}

function selectMonth() {
    console.log(useEmpStore.InterestWithLoan.Term);
    useEmpStore.InterestWithLoan.Total_Month = useEmpStore.InterestWithLoan.Term;

}


function calculateMonth() {

    function addMonthsToDate(dateString, months) {

        var dateParts = dayjs(dateString).format('MM/DD/YYYY').split('/'); // Split the string into an array of parts
        var month = parseInt(dateParts[0]) - 1; // Subtract 1 to get the zero-based month value
        var day = parseInt(dateParts[1]);
        var year = parseInt(dateParts[2]);
        console.log("testing dateparts", dateParts);

        var date = new Date(year, month, day); // Create a Date object from the parts
        date.setMonth(date.getMonth() + months); // Add the specified number of months

        // Format the resulting date back into a string in "MM/DD/YYYY" format
        var formattedDate = date.getFullYear() + '-' + (date.getMonth()) + '-' + date.getDate();
        return formattedDate;
    }
    addMonthsToDate();

    // Example usage
    var originalDate = useEmpStore.InterestWithLoan.EMI_Start_Month;
    console.log(originalDate);
    var modifiedDate = addMonthsToDate(originalDate, useEmpStore.InterestWithLoan.Term);

    console.log(modifiedDate);
    console.log(useEmpStore.interestFreeLoan.Term);

    useEmpStore.InterestWithLoan.EMI_End_Month = dayjs(modifiedDate).format('YYYY-MM-DD');

    //  let values = dayjs(useEmpStore.interestFreeLoan.EMI_Start_Month.Month).add(1,'month').format('YYYY/MM/DD');
    //  console.log(values);

}

const eligibleRequiredAmount = (value) => {
    if (value > useEmpStore.InterestWithLoan.minEligibile) {
        return false
    } else {
        return true
    }
}


const rules = computed(() => {
    return {
        required_amount: { required: helpers.withMessage('Required amount is required', required), eligibleRequiredAmount: helpers.withMessage('Must be lesser than max eligible amount', eligibleRequiredAmount) },
        Term: { required },
        EMI_Start_Month: { required },
        Reason: { required },
    }
})


const v$ = useValidate(rules, useEmpStore.InterestWithLoan)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        useEmpStore.saveInterestWithLoan()
        v$.value.$reset();
    } else {
        console.log('Form failed validation')
    }
}








// var loanDetails = calculateLoanDetails(useEmpStore.InterestWithLoan.required_amount, loanRate, loanTime);
// console.log("Monthly payment amount: " + loanDetails.monthlyPayment);
// console.log("Total loan amount: " + loanDetails.totalLoanAmount);




</script>

<style>
:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
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

.allcenter {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>



