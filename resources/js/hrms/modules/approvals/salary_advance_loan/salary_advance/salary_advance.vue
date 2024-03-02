<template>
    <div class="mr-4 card">
        <div class="px-5 row d-flex justify-content-start align-items-center card-body">
            <div class="flex justify-between gap-6 my-2">
                <div class=" fs-4">
                    <!-- v-if="!useEmpData" -->
                    <p class="text-xl font-medium" v-if="useEmpData == ''">The company allows employees to request a salary
                        advance of up to <strong class="text-lg"> 100%</strong> of their monthly salary.</p>
                    <p v-if="useEmpData != ''" class=" fs-4 fw-semibold text-blue-900 font-sans">Employee ID : <span
                            class=" fs-4 fw-semibold font-sans mr-5">{{ CurrentUser_code }} </span> <span
                            class="ml-5 pl-14 fs-4 fw-semibold text-blue-900 font-sans"
                            style="border-left: 2px solid black;">Employee Name : {{ CurrentName }}</span></p>
                    <!-- {{ useEmpData.user_code }}
                    {{ useEmpData.name }} -->
                </div>
                <div class="float-right ">
                    <button class="btn btn-border-orange " id="" v-if="useEmpData != ''" @click="useEmpData = ''">View
                        Report</button>
                    <!-- v-if="!useEmpData" -->
                    <button @click="ShowDialogApprovalAll" v-if="useEmpData == ''" class="mx-4 btn btn-orange">Approval
                        All</button>

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
            <!-- {{ SalaryAdvanceApprovals.arraySalaryAdvance }} -->

            <div class="table-responsive">
                <DataTable v-if="useEmpData == ''" :value="SalaryAdvanceApprovals.arraySalaryAdvance" :paginator="true"
                    :rows="10" class="" dataKey="id" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
                    v-model:expandedRows="expandedRows" v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                    @select-all-change="onSelectAllChange" @row-select="onRowSelect" @row-unselect="onRowUnselect"
                    :rowsPerPageOptions="[5, 10, 25]"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">

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
                    <Column field="advance_amount" header="Advance Amount"></Column>
                    <Column field="dedction_date" header="Date"> </Column>

                    <Column field="status_flow" header="Status" style="min-width: 12rem"> </Column>

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
                <EmployeePayable :source="sample"/>

                <DataTable v-if="useEmpData != ''" :value="useEmpData" :paginator="true" :rows="10" class="" dataKey="id"
                    @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows"
                    v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
                    @row-select="onRowSelect" @row-unselect="onRowUnselect" :rowsPerPageOptions="[5, 10, 25]"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">

                    <Column field="request_id" header="Request ID" sortable></Column>
                    <Column field="borrowed_amount" header="Advance Amount">
                    </Column>
                    <Column field="requested_date" header="Paid On">
                    </Column>
                    <Column field="dedction_date" header="Expected Return">
                    </Column>
                    <Column field="sal_adv_status" header="Status">

                    </Column>
                    <!-- {{ useEmpData }} -->
                </DataTable>



            </div>
        </div>
    </div>



    <Dialog header="Confirmation" v-model:visible="canShowConfirmationAll"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '400px' }" :modal="true">
        <div class="confirmation-content">
            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
        </div>
        <template #footer>
            <Button label="Yes" icon="pi pi-check" @click="processBulkApproveReject('Approve')" class="p-button-text"
                autofocus />
            <Button label="No" icon="pi pi-times" @click="hideBulkConfirmDialog(true)" class="p-button-text" />
        </template>
    </Dialog>



    <Dialog modal v-model:visible="showAppoverDialog"
        :style="{ width: '50vw', borderTop: '5px solid #002f56', height: '100vh' }">
        <template #header>
            <h1 class="mx-3 fs-4 text-xxl " style="border-left:3px solid var(--orange) ; padding-left:10px  ;">New Salary
                Advance Request</h1>
        </template>
        <div class="flex pb-2 bg-gray-100 rounded-lg gap-3">
            <div class="w-4 p-4 mx-4">
                <span class="font-semibold">Required Amount</span>
                <input id="rentFrom_month"
                    class="my-2  border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    v-model="val.advance_amount" disabled>
                <p class="text-sm font-semibold text-gray-500">Max Eligible Amount : {{ val.eligible_amount }}</p>
            </div>
            <div class="w-5 p-4 mx-4 ">
                <span class="font-semibold">Required Amount</span>
                <div class="w-full">
                    <p class="my-2 text-gray-600 fs-5 text-md text-clip">The advance amount will be deducted from the next
                        month's
                        salary <strong class="text-black fs-5">(ie,{{ val.dedction_date }})</strong> </p>
                </div>
            </div>
        </div>
        <div class="gap-6 p-4 my-2 bg-gray-100 rounded-lg">
            <span class="font-semibold ">Reason</span>
            <div class="border w-full h-28 rounded bg-slate-50 p-2 ">{{ val.reason }}</div>
        </div>
        <div class="gap-6 p-4 my-2 bg-gray-100 rounded-lg">
            <span class="font-semibold ">Your Comments</span>
            <Textarea class="my-3 capitalize form-control textbox" v-model="reviewer_comments.reviewer_comments" autoResize type="text"
                rows="3" style="border:none; outline-: none;"  :class="[v$.reviewer_comments.$error ? ' border-2 outline-none border-red-500 rounded-lg' : '']" />
            <br>
            <span v-if="v$.reviewer_comments.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.reviewer_comments.$errors[0].$message }}
            </span>
        </div>
        <div class="float-right ">
            <button class="btn bg-red-500 text-white px-5" @click="submitForm(-1)">Reject</button>
            <button class="mx-4 btn bg-green-500  text-white px-5" @click="submitForm(1)">Approve</button>
        </div>
    </Dialog>
</template>



<script setup>
import EmployeePayable from '../../../Shared/EmployeePayable.vue';
import { onMounted, reactive, ref,computed } from 'vue';
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { UseSalaryAdvanceApprovals } from '../store/loanAdvanceMainStore';

import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators';
import { useNow, useDateFormat } from '@vueuse/core';

const SalaryAdvanceApprovals = UseSalaryAdvanceApprovals();

const expandedRows = ref([]);
const selectedAllEmployee = ref();
const currentlySelectedStatus = ref();
const op = ref();
const toggle = (event) => {
    op.value.toggle(event);
}
const currentlySelectedRowData = ref();
const showAppoverDialog = ref(false);
const canShowConfirmationAll = ref(false);
const reviewer_comments = reactive({
    reviewer_comments:""
});
const useEmpData = ref([""]);
const CurrentName = ref();
const CurrentUser_code = ref();

const val = ref();


const sample = ref([
    {id:1,name:"simma"}
])


onMounted(() => {
    SalaryAdvanceApprovals.getEmpDetails();
})

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


function showConfirmDialog(selectedRowData, status) {

    showAppoverDialog.value = true;
    currentlySelectedStatus.value = status;
    currentlySelectedRowData.value = selectedRowData;
    val.value = selectedRowData;

}

async function approveAndReject(status) {
    showAppoverDialog.value = false;
    await SalaryAdvanceApprovals.SAapproveAndReject(currentlySelectedRowData.value, status, reviewer_comments.reviewer_comments)
    currentlySelectedStatus.value = status;
}

function ShowDialogApprovalAll() {
    canShowConfirmationAll.value = true;
}

function hideBulkConfirmDialog() {
    canShowConfirmationAll.value = false;
}

async function processBulkApproveReject(status) {
    hideBulkConfirmDialog();
    currentlySelectedStatus.value = status;
    await SalaryAdvanceApprovals.SAbulkApproveAndReject(currentlySelectedStatus.value, SalaryAdvanceApprovals.arraySalaryAdvance);
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
        SalaryAdvanceApprovals.getEmpDetails();
    } else {
        console.log('Form failed validation')
    }
}

</script>

<style>
.dropdown-content {
    /* display: none; */
}

.dropdown:hover .dropdown-content {
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content {
    padding: 0;
}</style>
