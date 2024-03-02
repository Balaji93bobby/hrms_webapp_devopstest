<template>
    <div>

        <div class="mr-4 card">
            <div class="px-5 row d-flex justify-content-start align-items-center card-body">
                <div class="flex justify-between gap-6 my-2">
                    <div class=" fs-4">
                        <p class="text-xl font-medium">Five Team Members are eligible for the Loan with Interest as per the
                            <span class="text-lg text-primary text-decoration-underline"> Company's Loan Policy</span>
                        </p>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-border-orange" v-if="useEmpData != ''" @click="useEmpData = ''">View
                            Report</button>
                        <button class="mx-2 btn btn-orange" v-if="useEmpData == ''" @click="ShowDialogApprovalAll">
                            Approval All
                        </button>


                    </div>
                </div>


                <Dialog v-model:visible="canShowInterestWithLoan" modal header="Header" :style="{ width: '60vw' }">
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
                                <InputNumber v-model="val.loan_amount"
                                    placeholder="&#8377; Enter The Required Amount" inputId="withoutgrouping"
                                    :useGrouping="false"  />
                                <p class="fs-6 my-2" style="color: var(--clr-gray)">Max Eligible Amount :
                                    {{ val.eligible_amount }}
                                </p>
                            </div>
                            <!-- {{ useEmpStore.InterestWithLoan.max_tenure_months }} -->
                            <div class="col mx-2">
                                <h1 class="fs-5 my-2">Term</h1>
                                <InputText type="text" style="width: 100px !important;" disabled
                                                v-model="val.tenure" />
                                                <label for="" class="fs-5 ml-1" style="color:var(--navy) ; " >Month</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 pr-5">
                                <!-- <button
                                    @click="useEmpStore.calculateLoanDetails(useEmpStore.InterestWithLoan.required_amount, useEmpStore.InterestWithLoan.Interest_rate, useEmpStore.InterestWithLoan.Term)"
                                    class="bg-danger text-light pt-2 pl-4 pr-4 pb-2  float-right rounded hover:bg-red-500 shadow-md">Calculate
                                    EMI</button> -->
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
                                placeholder="%" style="width: 100px;" v-model="val.interest_rate"
                                disabled prefix="%" />
                            <h1 class=" fw-semibold  mt-1 fs-5">Interest Rate</h1>
                        </div>

                    </div>

                    <div class="col  pl-8 pr-8 ">
                        <div class="div d-flex justify-items-center align-items-center flex-column p-2 rounded shadow-md" style="background: #FDCFCF;">

                            <div class="div d-flex justify-content-center align-items-center">

                                <h1 class="fw-bolder fs-4">&#8377; </h1>
                                <input class="fw-bolder fs-4  pl-2 text-center" style="width: 100px;background: #FDCFCF  ;"
                                    v-model="val.monthly_emi" disabled />
                            </div>
                            <h1 class=" fw-semibold mt-2 fs-5">Monthly payment</h1>
                        </div>

                    </div>

                    <div class="col  pl-8 pr-8 ">
                        <div class="div d-flex justify-items-center align-items-center flex-column p-2 rounded bg-green-100 shadow-md">
                            <div class="div d-flex justify-content-center align-items-center">
                                <h1 class="fw-bolder fs-4">&#8377; </h1>
                                <input v-model="val.total_amount"
                                    class="fw-bolder fs-4  pl-2 bg-green-100 text-center" style="width: 100px;" disabled />

                            </div>
                            <h1 class=" fw-semibold mt-2 fs-5 mx-3">Total loan amount</h1>

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
                            <Calendar v-model="val.deduction_starting_month" showIcon class="w-full md:w-10rem"  />
                    </div>

                    <div class="col-4 mx-2">
                        <h1 class="fs-5 my-2 ml-2">EMI End Month</h1>
                        <Calendar v-model="val.deduction_ending_month" showIcon />
                    </div>
                    <div class="col-3">
                        <h1 class="fs-5 my-2 ml-2">Total Months</h1>
                        <InputText type="text" v-model="val.tenure" disabled
                            style="width: 150px !important;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
            <span class="font-semibold ">Reason</span>
            <Textarea v-model="reviewer_comments.reviewer_comments" class="my-3 capitalize form-control textbox" autoResize
                type="text" rows="3"
                :class="[v$.reviewer_comments.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
            <br>
            <span v-if="v$.reviewer_comments.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.reviewer_comments.$errors[0].$message }}
            </span>
        </div>

        <div class="float-right ">
            <button class="btn bg-red-500 px-5 text-white"
                @click="submitForm(-1)">Rejected</button>
            <button class="mx-4 btn btn-orange px-5 bg-green-500 text-white" @click="submitForm(1)">Approved</button>
        </div>

    </Dialog>

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
                    <!-- {{ useData.arrayIWL }} -->
                    <DataTable v-if="useEmpData == ''" :value="useData.arrayIWL" :paginator="true" :rows="10" class=""
                        dataKey="id" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
                        v-model:expandedRows="expandedRows" v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                        @select-all-change="onSelectAllChange" @row-select="onRowSelect" @row-unselect="onRowUnselect"
                        :rowsPerPageOptions="[5, 10, 25]"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">

                        <!-- <Column :expander="true" /> -->
                        <!-- <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column> -->
                        <Column field="request_id" header="Request ID" sortable></Column>
                        <Column field="user_code" header="Employee ID">
                        </Column>
                        <Column field="name" header="Employee Name" :sortable="false">
                            <template #body="slotProps">
                                <button class="fw-semibold text-primary"
                                    @click="view_more(slotProps.data.emp_prevdetails, slotProps.data.user_code, slotProps.data.name)">
                                    {{ slotProps.data.name }} </button>
                            </template>
                        </Column>
                        <Column field="loan_amount" header="Loan Amount"></Column>
                        <Column field="emi_per_month" header="Monthly EMI">

                            <template #body="slotProps">
                                <div>
                                    <h1 v-if="slotProps.data.monthly_emi == null">-</h1>
                                    <h1 v-else>{{ slotProps.data.monthly_emi }}</h1>
                                </div>
                            </template>

                        </Column>
                        <Column field="tenure" header="Tenure"> </Column>
                        <Column field="status" header="Status" style="min-width: 12rem">
                            {{ slotProps.data.status }}
                        </Column>
                        <Column field="" header="Action">
                            <template #body="slotProps">
                                <button class="" type="button" @click="toggle"> <i class="pi pi-ellipsis-v"></i>
                                </button>
                                <OverlayPanel ref="op"
                                    style="width: 160px;margin-top:12px !important;margin-right: 20px !important;"
                                    class="p-0 m-0">
                                    <div class=" d-flex flex-column p-0 m-0">
                                        <!-- bg-green-200 -->
                                        <button class="fw-semibold text-black hover:bg-gray-200 border-bottom-1 p-2"
                                            @click="showConfirmDialog(slotProps.data)">view</button>
                                        <!-- bg-blue-500 -->
                                        <button class=" fw-semibold text-black  hover:bg-gray-200 p-2"
                                            @click="view_more(slotProps.data.emp_prevdetails, slotProps.data.user_code, slotProps.data.name)">passed
                                            Transaction</button>
                                    </div>
                                </OverlayPanel>
                            </template>
                        </Column>
                    </DataTable>


                   <!-- <EmployeePayable :source="sample"/> -->

                    <DataTable v-if="useEmpData != ''" :value="useEmpData" :paginator="true" :rows="10" class=""
                        dataKey="id" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
                        v-model:expandedRows="expandedRows" v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                        @select-all-change="onSelectAllChange" @row-select="onRowSelect" @row-unselect="onRowUnselect"
                        :rowsPerPageOptions="[5, 10, 25]"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">

                        <Column field="request_id" header="Request ID" sortable></Column>
                        <Column field="borrowed_amount" header="Loan Amount">
                        </Column>
                        <Column field="eligible_amount" header="Advance Amount">
                        </Column>
                        <Column field="emi_per_month" header="Monthly EMI">
                            <template #body="slotProps">
                                <div>
                                    <h1 v-if="slotProps.data.emi_per_month == null">-</h1>
                                    <h1 v-else>{{ slotProps.data.emi_per_month }}</h1>
                                </div>
                            </template>
                        </Column>
                        <Column field="tenure_months" header="Tenure">
                        </Column>
                        <Column field="deduction_starting_month" header="EMI Start Date">
                        </Column>
                        <Column field="deduction_ending_month" header="EMI Start Date">
                        </Column>
                        <Column field="loan_status" header="Status" style="min-width: 12rem">
                            {{ slotProps.data.loan_status }}
                        </Column>
                    </DataTable>



                </div>

            </div>
        </div>



        <Dialog header="Header" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true"
            :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>






    </div>
</template>

<script setup>
// import EmployeePayable from '../../../Shared/EmployeePayable.vue';

import { onMounted, ref, reactive ,computed } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { UseSalaryAdvanceApprovals } from '../store/loanAdvanceMainStore';

import dayjs from 'dayjs';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators';
import { useNow, useDateFormat } from '@vueuse/core';


// const sample = ref([
//     {id:1,name:"vishu"}
// ])

const useData = UseSalaryAdvanceApprovals();


const useEmpData = ref([""]);

const expandedRows = ref([]);
const selectedAllEmployee = ref();
const canShowInterestWithLoan = ref(false);
const currentlySelectedRowData = ref();
const currentlySelectedStatus = ref();
const canShowConfirmationAll = ref(false);
const CurrentName = ref();
const CurrentUser_code = ref();
const reviewer_comments = reactive({
    reviewer_comments:""
});

const val = ref();
const op = ref();
const toggle = (event) => {
    op.value.toggle(event);
}

onMounted(() => {
    useData.getInterestWithLoanDetails();

})

function showConfirmDialog(selectedRowData) {
    canShowInterestWithLoan.value = true;
    currentlySelectedRowData.value = selectedRowData;
    val.value = selectedRowData;
}

function hideBulkConfirmDialog() {
    canShowConfirmationAll.value = false;
    canShowInterestWithLoan.value = false;
}

function ShowDialogApprovalAll() {
    canShowConfirmationAll.value = true;
}

async function approveAndReject(status) {
    hideBulkConfirmDialog()
    await useData.IWL_ApproveAndReject(currentlySelectedRowData.value, status, reviewer_comments.reviewer_comments)
    currentlySelectedStatus.value = status;
}

function view_more(selectedRowData, user_code, currentName) {
    useEmpData.value = selectedRowData;
    CurrentName.value = currentName;
    CurrentUser_code.value = user_code
}


const rules = computed(() => {
    return {
        reviewer_comments: { required },
    }
})


const v$ = useValidate(rules, reviewer_comments )


const submitForm = (val) => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        approveAndReject(val);
    } else {
        console.log('Form failed validation')
    }
}



</script>
