<template>
    <div>

        <div class="mr-4 card">
            <div class="px-5 row d-flex justify-content-start align-items-center card-body">
                <div class="flex justify-between gap-6 my-2">
                    <div class=" fs-4">
                        <!-- <p class="text-xl font-medium text-justify">Five Team members are eligible for the Interest Free
                            Loan as per the
                            <span class="text-lg text-primary text-decoration-underline"> Company's Loan Policy</span>
                        </p> -->
                        <p class="text-xl font-medium" v-if="useEmpData == ''">Five Team members are eligible for the
                            Interest Free
                            Loan as per the
                            <span class="text-lg text-primary text-decoration-underline"> Company's Loan Policy</span>
                        </p>
                        <p v-if="useEmpData != ''" class=" fs-4 fw-semibold text-blue-900 font-sans">Employee ID : <span
                                class=" fs-4 fw-semibold font-sans mr-5">{{ CurrentUser_code }} </span> <span
                                class="ml-5 pl-14 fs-4 fw-semibold text-blue-900 font-sans"
                                style="border-left: 2px solid black;">Employee Name : {{ CurrentName }}</span></p>
                    </div>

                    <div class="float-right ">
                        <button class="btn btn-border-orange" v-if="useEmpData != ''" @click="useEmpData = ''">View
                            Report</button>
                        <button class="mx-2 btn btn-orange" v-if="useEmpData == ''" @click="ShowDialogApprovalAll">
                            Approval All
                        </button>

                        <Dialog header="Confirmation" v-model:visible="canShowConfirmationAll"
                            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '400px' }" :modal="true">
                            <div class="confirmation-content">
                                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                            </div>
                            <template #footer>
                                <Button label="Yes" icon="pi pi-check" @click="processBulkApproveReject('Approve')"
                                    class="p-button-text" autofocus />
                                <!-- <button class="btn"></button> -->
                                <Button label="No" icon="pi pi-times" @click="hideBulkConfirmDialog(true)"
                                    class="p-button-text" />
                            </template>
                        </Dialog>

                        <Dialog v-model:visible="canshowInterestFLR" header="Header" :style="{ width: '58vw' }" modal
                            :position="position">
                            <template #header>
                                <div>
                                    <h1 style="border-left: 3px solid var( --orange);padding-left: 5px ;" class="fs-4">New
                                        Interest Free Loan Request</h1>
                                </div>
                            </template>
                            <!-- v-for="(items, index ) in required_Amount.eligible_amount" :key="index" -->
                            <div class="card bg-gray-100 bottom-0 mb-10" style="border:none">
                                <div class="card-body">
                                    <div class="row mx-2">
                                        <div class="col mx-2">
                                            <h1 class="fs-5 my-2">Required Amount</h1>
                                            <!-- {{ items }} -->
                                            <!-- {{ items.emi_per_month}} -->

                                            <InputText type="text" placeholder="&#8377; Enter The Required Amount" disabled
                                                v-model="val.loan_amount" />
                                            <p class="fs-6 my-2" style="color: var(--clr-gray)">Max Eligible Amount : {{
                                                val.eligible_amount }}
                                            </p>
                                        </div>
                                        <div class="col mx-2">
                                            <h1 class="fs-5 my-2">Monthly EMI</h1>
                                            <InputText type="text" placeholder="&#8377; " disabled
                                                v-model="val.monthly_emi" />
                                        </div>
                                        <div class="col mx-2">
                                            <h1 class="fs-5 my-2">Term</h1>
                                            <!-- <Dropdown :options="cities" optionLabel="name" placeholder="1.5"
                                                class="w-full md:w-10rem" v-model="interestWithLoan.Term_year" /> -->
                                            <InputText class="w-full md:w-10rem" type="text" placeholder="&#8377; " disabled
                                                v-model="val.tenure" />
                                            <label for="" class="fs-5 ml-2" style="color:var(--navy); ">Months</label>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="card bg-gray-100 bottom-0 my-4" style="border:none ">
                                <div class="card-body mx-4">
                                    <div class="row">
                                        <!-- fw-bolder -->
                                        <h1 class="fs-4 my-2 ">EMI Dedution</h1>
                                        <h1 class="fs-5 text-gray-600 mb-3">The EMI Dedution Will begin from the Upcoming
                                            Payroll</h1>
                                        <div class="col-4">
                                            <h1 class="fs-5 my-2 ml-2">EMI Start Month</h1>
                                            <Calendar showIcon dateFormat="dd/mm/yy" disabled
                                                v-model="val.deduction_starting_month" />
                                        </div>

                                        <div class="col-4 mx-2">
                                            <h1 class="fs-5 my-2 ml-2">EMI End Month</h1>
                                            <Calendar showIcon dateFormat="dd/mm/yy" disabled
                                                v-model="val.deduction_ending_month" />
                                        </div>
                                        <div class="col-3">
                                            <h1 class="fs-5 my-2 ml-2">Total Months</h1>
                                            <InputText type="text" style="width: 150px !important;" disabled
                                                v-model="val.tenure" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
                                <span class="font-semibold ">Reason</span>
                                <Textarea class="my-3 capitalize form-control textbox" disabled v-model="val.reason"
                                    autoResize type="text" rows="3" />
                            </div>
                            <div class="gap-6 p-4 my-6 bg-gray-100 rounded-lg">
                                <span class="font-semibold ">your Comments</span>
                                <Textarea class="my-3 capitalize form-control textbox" v-model="reviewer_comments.reviewer_comments"
                                    autoResize type="text" rows="3" style="border:none; outline-: none;"
                                    :class="[v$.reviewer_comments.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
                            <br>
                            <span v-if="v$.reviewer_comments.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.reviewer_comments.$errors[0].$message }}
                            </span>
                                <!-- {{ SA_Request_comments }} -->
                            </div>

                            <template #footer>
                                <div class="float-right ">
                                    <button class="btn bg-red-500 text-white px-5"
                                        @click="submitForm(-1)">Reject</button>
                                    <button class="mx-4 btn bg-green-500  text-white px-5"
                                        @click="submitForm(1)">Approve</button>
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
                    <DataTable v-if="useEmpData == ''" :value="UseInterestFreeLoan.arrayIFL_List" :paginator="true"
                        :rows="10" class="" dataKey="id" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
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
                        <Column field="loan_amount" header="Advance Amount">
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
                        <Column field="status" header="Status">
                            <template #body="slotProps">
                                <h6 v-if="slotProps.data.loan_crd_sts == 0" class="text-orange-500">
                                    <!-- {{ slotProps.data.loan_crd_sts }} -->
                                    Pending
                                </h6>
                                <h6 v-if="slotProps.data.loan_crd_sts == 1" class=" text-green-500">
                                    Approved
                                </h6>
                                <h6 v-if="slotProps.data.loan_crd_sts == 'Rejected'" class="text-red-500">
                                    <!-- {{ slotProps.data.status }} -->
                                </h6>
                            </template>
                        </Column>
                    </DataTable>
                </div>


            </div>
        </div>


        <!--
        <Dialog header="Header" v-model:visible="UseInterestFreeLoan.canShowLoadingScreen"
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

    </div>
</template>

<script setup>
import { onMounted, ref, reactive ,computed} from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { UseSalaryAdvanceApprovals } from '../store/loanAdvanceMainStore';
import dayjs from 'dayjs';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { useNow, useDateFormat } from '@vueuse/core'

const UseInterestFreeLoan = UseSalaryAdvanceApprovals();

onMounted(async () => {
    await UseInterestFreeLoan.getInterestFreeLoanDetails()

})


const expandedRows = ref([]);
const selectedAllEmployee = ref();
const reviewer_comments = reactive({
    reviewer_comments:""
});
const canshowInterestFLR = ref(false);
const currentlySelectedRowData = ref();
const currentlySelectedStatus = ref();
const canShowConfirmationAll = ref(false);
const useEmpData = ref([""]);
const CurrentName = ref();
const CurrentUser_code = ref();

const val = ref();
// const

const interestWithLoan = ref();

const op = ref();
const toggle = (event) => {
    op.value.toggle(event);
}

function showConfirmDialog(selectedRowData) {
    canshowInterestFLR.value = true;
    currentlySelectedRowData.value = selectedRowData;
    val.value = selectedRowData;
}

function hideBulkConfirmDialog() {
    canShowConfirmationAll.value = false;
    canshowInterestFLR.value = false;
}



const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
});

function ShowDialogApprovalAll() {
    canShowConfirmationAll.value = true;
}

async function approveAndReject(status) {
    hideBulkConfirmDialog()
    await UseInterestFreeLoan.IFLapproveAndReject(currentlySelectedRowData.value, status, reviewer_comments.reviewer_comments)
    currentlySelectedStatus.value = status;
}

async function processBulkApproveReject(status) {

    currentlySelectedStatus.value = status;
    await UseInterestFreeLoan.IFLbulkApproveAndReject(currentlySelectedStatus.value, UseInterestFreeLoan.arrayIFL_List);
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
