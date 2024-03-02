<template>
    <div class="mr-4 card">
        <div class="px-5 row d-flex justify-content-start align-items-center card-body">
            <div class="flex justify-between gap-6 my-2">
                <div class=" fs-4">
                    <p class="text-xl font-medium">You are eligible for the Interest Free Loan as per the
                        <span class="text-lg text-primary text-decoration-underline"> Company's Loan Policy</span>
                    </p>
                </div>

                <div class="float-right">
                    <button class="btn btn-border-orange">View Report</button>
                    <button class="mx-4 btn btn-orange" @click="openPosition('top')">
                        <i class="mx-2 fa fa-plus" aria-hidden="true"></i>
                        New Request
                    </button>

                    <Dialog v-model:visible="useEmpStore.dialog_NewInterestFreeLoanRequest" header="Header"
                        :style="{ width: '58vw' }" modal :position="position">
                        <template #header>
                            <div>
                                <h1 style="border-left: 3px solid var( --orange);padding-left: 5px ;" class="fs-4">New
                                    Interest Free Loan Request</h1>
                            </div>
                        </template>
                        <div class="card bg-gray-100 bottom-0 mb-10" style="border:none">
                            <div class="card-body">
                                <div class="row mx-2">
                                    <div class="col mx-2">
                                        <h1 class="fs-5 my-2">Required Amount</h1>
                                        <InputNumber v-model.number="useEmpStore.interestFreeLoan.required_amount"
                                            placeholder="&#8377; Enter The Required Amount" inputId="withoutgrouping"
                                            :useGrouping="false"
                                            :class="[v$.required_amount.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                                        <br>
                                        <span v-if="v$.required_amount.$error" class="font-semibold text-red-400 fs-6">
                                            {{ v$.required_amount.$errors[0].$message }}
                                        </span>
                                        <p class="fs-6 my-2" style="color: var(--clr-gray)">Max Eligible Amount : <span
                                                class=" fw-semibold">{{ useEmpStore.interestFreeLoan.minEligibile }}</span> </p>
                                    </div>
                                    <div class="col mx-2">
                                        <h1 class="fs-5 my-2">Monthly EMI</h1>
                                        <InputText type="text" readonly v-model="useEmpStore.interestFreeLoan.M_EMI"
                                            placeholder="&#8377; " />
                                    </div>
                                    <div class="col mx-2">
                                        <h1 class="fs-5 my-2">Term</h1>
                                        <!-- {{ useEmpStore.interestFreeLoan.max_tenure_months.month }} -->

                                        <!-- <Dropdown v-model="useEmpStore.interestFreeLoan.Term" @change="selectMonth" :options="useEmpStore.interestFreeLoan.max_tenure_months" optionLabel="month" placeholder="Select Month" class="w-full md:w-10rem" optionValue="val" /> -->
                                        <!-- {{useEmpStore.max_tenure_month}} -->
                                        <Dropdown v-model="useEmpStore.interestFreeLoan.Term" @change="selectMonth"
                                            :options="useEmpStore.max_tenure_month" class="w-full md:w-10rem"
                                            optionValue="month" optionLabel="month" placeholder="Select Month"
                                            :class="[v$.Term.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                                        <label for="" class="fs-5 ml-2">Month</label>
                                        <br>
                                        <span v-if="v$.Term.$error" class="font-semibold text-red-400 fs-6">
                                            {{ v$.Term.$errors[0].$message }}
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-gray-100 bottom-0 my-4" style="border:none ">
                            <div class="card-body mx-4">
                                <div class="row">
                                    <!-- fw-bolder -->
                                    <h1 class="fs-4 my-2  ">EMI Dedution</h1>
                                    <h1 class="fs-5 text-gray-600 mb-3">The EMI Dedution Will begin from the Upcoming
                                        Payroll</h1>
                                    <div class="col-4">
                                        <h1 class="fs-5 my-2 ml-2">EMI Start Month</h1>
                                        <!-- <Calendar v-model="useEmpStore.interestFreeLoan.EMI_Start_Month" showIcon /> -->
                                        <!-- {{useEmpStore.interestFreeLoan.details.deduction_starting_month  }} -->
                                        <Dropdown v-model="useEmpStore.interestFreeLoan.EMI_Start_Month" @change="calculateMonth"
                                            :options="useEmpStore.interestFreeLoan.details.deduction_starting_month" optionLabel="date"
                                            optionValue="date" placeholder="Select Month"
                                            :class="[v$.EMI_Start_Month.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                                        <br>
                                        <span v-if="v$.EMI_Start_Month.$error" class="font-semibold text-red-400 fs-6">
                                            {{ v$.EMI_Start_Month.$errors[0].$message }}
                                        </span>
                                    </div>

                                    <div class="col-4 mx-2">
                                        <h1 class="fs-5 my-2 ml-2">EMI End Month</h1>
                                        <!-- <InputText type="text" readonly v-model="useEmpStore.interestFreeLoan.EMI_End_Month"  style="width: 150px !important;" /> -->
                                        <Calendar v-model="useEmpStore.interestFreeLoan.EMI_End_Month" readonly
                                            style="width: 150px !important;" />
                                        <!-- showIcon -->
                                    </div>
                                    <div class="col-3">
                                        <h1 class="fs-5 my-2 ml-2">Total Months</h1>
                                        <InputText type="text" readonly v-model="useEmpStore.interestFreeLoan.Total_Months"
                                            style="width: 150px !important;" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
                            <span class="font-semibold ">Reason</span>
                            <Textarea class="my-3 capitalize form-control textbox" autoResize type="text" rows="3"
                                v-model="useEmpStore.interestFreeLoan.Reason"
                                :class="[v$.Reason.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                            <br>
                            <span v-if="v$.Reason.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.Reason.$errors[0].$message }}
                            </span>
                        </div>

                        <template #footer>
                            <div class="float-right ">
                                <button class="btn btn-border-orange"
                                    @click="useEmpStore.dialog_NewInterestFreeLoanRequest = false">Cancel</button>
                                <button class="mx-4 btn btn-orange" @click="submitForm">Submit</button>
                            </div>
                            <!-- <Button label="" icon="pi pi-times" @click="visible = false" text />
                            <Button label="Yes" icon="pi pi-check" @click="visible = false" text /> -->
                        </template>
                    </Dialog>
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
                <!-- {{ useEmpStore.isInterestFreeLoanFeature }} -->
                <DataTable  ref="dt" dataKey="id" :paginator="true" :rows="10" :value="useEmpStore.isInterestFreeLoanFeature"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll">

                    <Column header="Request ID" field="request_id" style="min-width: 8rem">

                    </Column>

                    <Column field="borrowed_amount" header="Loan Amount" style="min-width: 12rem">

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


</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { useEmpSalaryAdvanceStore } from '../../stores/employeeSalaryAdvanceLoanMainStore';
import dayjs from 'dayjs';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { useNow, useDateFormat } from '@vueuse/core'

const useEmpStore = useEmpSalaryAdvanceStore();

onMounted(() => {
    useEmpStore.fetchInterestfreeLoan();
    useEmpStore.getinterestfreeloan();
})

const select_date = ref();
const selectedMonth = ref()

const position = ref('center');

const openPosition = (pos) => {
    position.value = pos;
    useEmpStore.dialog_NewInterestFreeLoanRequest = true
}


function selectMonth() {

    useEmpStore.interestFreeLoan.M_EMI =  Math.round(useEmpStore.interestFreeLoan.required_amount / useEmpStore.interestFreeLoan.Term) ;
    useEmpStore.interestFreeLoan.Total_Months = useEmpStore.interestFreeLoan.Term;

    //
    if (useEmpStore.interestFreeLoan.EMI_Start_Month) {
        return calculateMonth();
    }
    // useEmpStore.interestFreeLoan.Ra
    // useEmpStore.interestFreeLoan.Term
}

function calculateMonth() {

    function addMonthsToDate(dateString, months) {

        var dateParts = dayjs(dateString).format('MM/DD/YYYY').split('/'); // Split the string into an array of parts
        var month = parseInt(dateParts[0]) - 1; // Subtract 1 to get the zero-based month value
        var day = parseInt(dateParts[1]);
        var year = parseInt(dateParts[2]);
        console.log(dateParts);

        var date = new Date(year, month, day); // Create a Date object from the parts
        date.setMonth(date.getMonth() + months); // Add the specified number of months

        // Format the resulting date back into a string in "MM/DD/YYYY" format
        var formattedDate = date.getFullYear() + '-' + (date.getMonth()) + '-' + date.getDate();
        return formattedDate;
    }
    addMonthsToDate();

    // Example usage
    console.log(useEmpStore.interestFreeLoan.EMI_Start_Month);
    var originalDate = useEmpStore.interestFreeLoan.EMI_Start_Month;
    var modifiedDate = addMonthsToDate(originalDate, useEmpStore.interestFreeLoan.Term);

    console.log(modifiedDate);
    console.log( useEmpStore.interestFreeLoan.Term);

    useEmpStore.interestFreeLoan.EMI_End_Month = dayjs(modifiedDate).format('YYYY-MM-DD');

    //  let values = dayjs(useEmpStore.interestFreeLoan.EMI_Start_Month.Month).add(1,'month').format('YYYY/MM/DD');
    //  console.log(values);

}

const value = ref();

if (useEmpStore.interestFreeLoan.Term) {
    console.log("testing ::", useEmpStore.interestFreeLoan.Term);
}

const selectedCity = ref();
const cities = ref([
    { name: 1, val: 2 },
    { name: '2', code: 'RM' },
    { name: '2.5', code: 'LDN' },
    { name: '3', code: 'IST' },
    { name: '3.5', code: 'PRS' }
]);

const date = ref();


const eligibleRequiredAmount = (value) => {
    if (value > useEmpStore.interestFreeLoan.minEligibile) {
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


const v$ = useValidate(rules, useEmpStore.interestFreeLoan)


const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        useEmpStore.saveInterestfreeLoan();
        useEmpStore.fetchInterestfreeLoan();
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


</script>
<style>
:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
    --clr-gray: #959595;
}

.pi-calendar,
.p-button-label {
    color: white !important;
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

.p-button.p-component.p-button-icon-only.p-datepicker-trigger {
    /* background: #002f56; */
    color: #002f56;
}

.p-calendar .p-component .p-inputwrapper .p-calendar-w-btn {
    margin: 0;
}
</style>

{


    <!-- <template>
        <div class="card flex justify-content-center">
            <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" class="w-full md:w-14rem" />
        </div>
    </template>

    <script setup>
    import { ref } from "vue";

    const selectedCity = ref();
    const cities = ref([
        { name: 'New York', code: 'NY' },
        { name: 'Rome', code: 'RM' },
        { name: 'London', code: 'LDN' },
        { name: 'Istanbul', code: 'IST' },
        { name: 'Paris', code: 'PRS' }
    ]);
    </script>

-->

}

