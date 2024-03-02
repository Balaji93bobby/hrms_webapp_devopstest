<template>
    <Toast />
    <Dialog v-model:visible="show" modal header="Header" :style="{ width: '25vw' }">

        <h5>Do you want to approve all?</h5>

        <template #footer>
            <Button label="No" icon="pi pi-times" @click="show = false" text />
            <Button label="Yes" icon="pi pi-check" @click="show = false" autofocus />
        </template>
    </Dialog>
    <LoadingSpinner v-if="data_checking" class="absolute z-50 bg-white" />

    <div class="w-full">
        <h6 class="font-semibold text-lg">Reimbursement Approvals</h6>
        <div class="flex justify-end ">
            <div class="grid grid-cols-4 w-1/2 gap-2  ">
                <Calendar v-model="selected_date" view="month" dateFormat="mm/yy" class=""
                    style="  border-radius: 7px;height:30px" />
                <Dropdown v-model="selected_status" :options="statuses" placeholder="Status" class="w-full "
                    style=" border-radius: 7px;height:30px" />
                <button label="Submit" class="btn btn-primary z-0 whitespace-nowrap " severity="danger" style="height:30px"
                    :disabled="!selected_status == '' ? false : true" @click="generate_ajax"> <i class="fa fa-cog me-2"></i>
                    Generate</button>
                <!-- <Button type="button" icon="pi pi-times-circle" severity="danger" v-if="!selectedAllEmployee == ''"
                label="Reject all" style=" height: 2.5em"
                @click="showConfirmDialogForBulkApproval(selectedAllEmployee, 'Reject')" /> -->
                <button class="btn btn-primary whitespace-nowrap mx-3 z-0 "
                    :disabled="data_reimbursements == '' ? true : false" severity="success" @click="download_ajax"
                    style="height:30px"><i class="fas fa-file-download me-2"></i>Download</button>
            </div>


        </div>
        <div>
            <div>
                <DataTable :value="data_reimbursements" :paginator="true" :rows="10" class="mt-6 " dataKey="user_id"
                    @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows"
                    v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
                    @row-select="onRowSelect" @row-unselect="onRowUnselect"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">
                    <template #empty> No Reimbursement data for the selected status filter </template>
                    <template #loading> Loading customers data. Please wait. </template>
                    <Column :expander="true" />
                    <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column>
                    <Column field="user_code" header="Employee Id" sortable></Column>

                    <Column field="name" header="Employee Name">
                        <template #body="slotProps">
                            {{ slotProps.data.employee_name }}
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                                class="p-column-filter" :showClear="true" />
                        </template>
                    </Column>

                    <Column class="fontSize13px" field="total_distance_travelled" header="Overall Distance Travelled"
                        :sortable="false">
                        <template #body="slotProps">
                            {{ slotProps.data.total_distance_travelled + " KM(s)" }}
                        </template>
                    </Column>


                    <Column class="fontSize13px" field="total_expenses" header="Overall Reimbursements" :sortable="false">
                        <template #body="slotProps">
                            {{ "&#8377; " + slotProps.data.total_expenses }}
                        </template>
                    </Column>
                    <Column field="" header="Action" :style="{ width: '15vw' }">
                        <template #body="slotProps">
                            <span v-if="slotProps.data.has_pending_reimbursements == 'true'">
                                <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"
                                    label="Approve" @click="showConfirmDialog(slotProps.data, 'Approve')"
                                    style="height: 2.5em" />
                                <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button"
                                    label="Reject" style="margin-left: 8px; height: 2.5em"
                                    @click="showConfirmDialog(slotProps.data, 'Reject')" />
                            </span>
                        </template>
                    </Column>

                    <template #expansion="slotProps">

                        <div class="orders-subtable">
                            <DataTable :value="slotProps.data.reimbursement_data" responsiveLayout="scroll"
                                v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                                @select-all-change="onSelectAllChange">
                                <!-- <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column> -->
                                <Column field="" header="Date" sortable>
                                    <template #body="slotProps">
                                        <p style="white-space: nowrap;"> {{
                                            moment(slotProps.data.date).format('DD-MMM-YYYY') }}
                                        </p>
                                    </template>
                                </Column>
                                <Column field="reimbursement_type" header="Reimbursement Type"></Column>
                                <Column field="from" header="From"></Column>
                                <Column field="to" header="To"></Column>
                                <Column field="user_comments" header="Comments"></Column>
                                <Column field="vehicle_type" header="Mode of transport"></Column>
                                <Column class="fontSize13px" field="distance_travelled" header="Distance Covered">
                                    <template #body="slotProps">
                                        {{ slotProps.data.distance_travelled + " KM(s)" }}
                                    </template>
                                </Column>
                                <Column class="fontSize13px" field="total_expenses" header="Total Expenses">
                                    <template #body="slotProps">
                                        {{ "&#8377; " + slotProps.data.total_expenses }}
                                    </template>
                                </Column>
                                <Column field="status" header="Status" sortable>
                                    <template #body="slotProps">
                                        <span :class="'order-badge order-' + slotProps.data.status">{{
                                            slotProps.data.status
                                        }}</span>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </div>




    <Dialog header="Header" v-model:visible="canShowLoadingScreen" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>

    <Dialog header="Confirmation" v-model:visible="canShowConfirmation" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content">
            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
            <span>Are you sure you want to {{ currentlySelectedStatus }}?</span>
        </div>
        <template #footer>
            <Button label="Yes" icon="pi pi-check" @click="processApproveReject()" class="p-button-text" autofocus />
            <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" />
        </template>
    </Dialog>
</template>

<script setup>
import { ref, onMounted, onRenderTracked, onUpdated, nextTick, onBeforeMount, onBeforeUpdate } from "vue";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import moment from 'moment'
import { watch } from "vue";
import LoadingSpinner from '../../../components/LoadingSpinner.vue'


let data_reimbursements = ref();
let canShowConfirmation = ref(false);
let canShowLoadingScreen = ref(false);
const data_checking = ref(false)
const confirm = useConfirm();
const toast = useToast();
const loading = ref(true);
const expandedRows = ref([]);
const view_reimbursment_detials = ref(false);
const view_reimbursment_action = ref(false);
const selectedAllEmployee = ref();
const selectedOneEmployee = ref();
const metaKey = ref(true);


const data = () => {
    show.value = true;

}




const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },

    status: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const statuses = ref(["Pending", "Approved", "Rejected"]);

let currentlySelectedStatus = null;
let currentlySelectedRowData = null;
const isdisabled = ref(true)

onMounted(() => {
    data_reimbursements.value = [];
    selected_date.value = new Date()
    console.log(selected_date.value);


});



function ajax_GetReimbursementData() {
    let url_all_reimbursements =
        window.location.origin + "/fetch_all_reimbursements_as_groups";

    console.log("AJAX URL : " + url_all_reimbursements);

    axios.get(url_all_reimbursements).then((response) => {
        // console.log("Axios : " + response.data);
        data_reimbursements.value = response.data;
        console.log(response.data);
        console.log(Object.keys(response.data));
    });
}

function showConfirmDialog(selectedRowData, status) {
    canShowConfirmation.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;

    console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}
function showConfirmDialogForBulkApproval(selectedRowData, status) {
    console.log(selectedAllEmployee.value);
    const ob = Object.values(selectedAllEmployee.value)


    ob.forEach(ent => {
        console.log(ent.employee_name);
    })

    canShowConfirmation.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;

    console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {
    canShowConfirmation.value = false;

    if (canClearData) resetVars();
}

function resetVars() {
    currentlySelectedStatus = "";
    currentlySelectedRowData = null;
}

const selected_date = ref()
const selected_status = ref()
const show_table = ref(false)

const show = ref(false)

const get_data = ref()

const generate_ajax = () => {


    let filter_date = new Date(selected_date.value);

    let year = filter_date.getFullYear();
    let month = filter_date.getMonth() + 1;

    console.log((selected_date.value).toString());
    console.log(get_data);

    //show_table.value=true

    data_checking.value = true



    axios.post(window.location.origin + "/fetch_all_reimbursements_as_groups", {
        selected_year: year,
        selected_month: month,
        selected_status: selected_status.value,
        selected_reimbursement_type: '', //Need to write filter to select reimbursement types
    }).then(res => {
        console.log("data sent");
        console.log("data from " + res.employee_name);
        data_reimbursements.value = res.data
        get_data.value = res.data
        data_checking.value = false
    }).catch(err => {
        console.log(err);
    })

}

const download_ajax = () => {
    let filter_date = new Date(selected_date.value);
    data_checking.value = true

    let year = filter_date.getFullYear();
    let month = filter_date.getMonth() + 1;
    isdisabled.value = false

    let URL = '/reports/generate-manager-reimbursements-reports?selected_year=' + year + '&selected_month=' + month +
        '&selected_status=' + selected_status.value + '&_token={{ csrf_token() }}';
    window.location = URL;
    setTimeout(greet, 1000);

}

const test = () => {

    toast.add({ severity: 'warn', summary: 'Are you sure?', detail: 'Proceed to confirm', group: 'bc' });
}

const greet = () => {
    data_checking.value = false
}

setTimeout(greet, 3000);


const css_statusColumn = (data) => {
    return [
        {
            pending: data.status === "Pending",
            approved: data.status === "Approved",
            rejected: data.status === "Rejected",
        },
    ];
};

function processApproveReject() {
    hideConfirmDialog(false);

    // canShowLoadingScreen.value = true;

    console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));
    console.log("currentlySelectedStatus : " + currentlySelectedStatus);

    axios
        .post(window.location.origin + "/reimbursements_bulk_approval", {
            reimbursement_id: currentlySelectedRowData,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            reviewer_comments: "",
        })
        .then((response) => {
            console.log(response);
            generate_ajax();
            // canShowLoadingScreen.value = false;

            toast.add({ severity: "success", summary: "", detail: " Successfully Approved !", life: 3000 });

            resetVars();
        })
        .catch((error) => {
            canShowLoadingScreen.value = false;
            resetVars();

            console.log(error.toJSON());
        });
}






const expandedRowGroups = ref();
const onRowGroupExpand = (event) => {
    toast.add({ severity: 'info', summary: 'Row Group Expanded', detail: 'Value: ' + event.data, life: 3000 });
};
const onRowGroupCollapse = (event) => {
    toast.add({ severity: 'success', summary: 'Row Group Collapsed', detail: 'Value: ' + event.data, life: 3000 });
};
const calculateCustomerTotal = (name) => {
    let total = 0;

    if (customers.value) {
        for (let customer of customers.value) {
            if (customer.representative.name === name) {
                total++;
            }
        }
    }

    return total;
};
const getSeverity = (status) => {
    switch (status) {
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warning';

        case 'renewal':
            return null;
    }
};



</script>

<style>
.p-dropdown .p-dropdown-label
{
    background: transparent;
    border: 0 none;
    margin-top: -6px;
}</style>
