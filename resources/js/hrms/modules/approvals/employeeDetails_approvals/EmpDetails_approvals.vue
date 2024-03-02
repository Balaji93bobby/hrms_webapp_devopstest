<template>
    <LoadingSpinner v-if="EmpDetailStore.canShowLoadingScreen" class="absolute z-50 bg-white" />
    <div class="w-full p-2">
        <h1 class=" font-semibold text-lg mb-2">Employee Details </h1>
        <Dialog header="Confirmation" v-model:visible="canShowConfirmationAll"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '580px' }" :modal="true">
            <div class="confirmation-content">
                Documents Approvals <span>Are you sure you want to {{ currentlySelectedStatus }} all the documents of this
                    employee?</span>
            </div>
            <template #footer>
                <!-- <Button label="Yes" icon="pi pi-check" @click="processBulkDocumentsApproveReject()" class="p-button-text"
                    autofocus />
                <Button label="No" icon="pi pi-times" @click="hideBulkConfirmDialog(true)" class="p-button-text" /> -->
                <div class="flex justify-center items-center gap-3">
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click="processBulkDocumentsApproveReject(),hideBulkConfirmDialog(true)">Yes</button>
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="hideBulkConfirmDialog(true)">No</button>
                </div>

            </template>
        </Dialog>

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content">
                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to {{ currentlySelectedStatus }}?</span>
            </div>
            <template #footer>
                <!-- <Button label="Yes" icon="pi pi-check" @click="empDetailsDocumentApproveReject()" class="p-button-text"
                    autofocus />
                <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" /> -->
                <div class="flex justify-center items-center gap-3">
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click="empDetailsDocumentApproveReject(),hideConfirmDialog(true)">Yes</button>
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="hideConfirmDialog(true)">No</button>
                </div>
            </template>
        </Dialog>




        <DataTable :value="EmpDetailStore.array_EmpDetails_list" :paginator="true" :rows="10" class="" dataKey="user_code"
            @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:filters="filters"
            v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
            @row-select="onRowSelect" @row-unselect="onRowUnselect" :rowsPerPageOptions="[5, 10, 25]"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :globalFilterFields="['name', 'user_code','doc_status']">
            <template #header>
                <div class="text-left">
                    <div class="p-input-icon-left">
                        <i class="pi pi-search"></i>
                        <InputText class="border p-1.5 bg-gray-100   border-gray-300" v-model="filters['global'].value" placeholder="Global Search" />
                    </div>
                </div>
            </template>
            <template #empty> No Employee Details documents for the selected status filter </template>

            <Column :expander="true" />
            <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column>
            <Column field="name" header="Employee Name" style="width: 30rem">
                <template #body="slotProps">
                    <div class="flex items-center !justify-center ">
                       
                            <p v-if="JSON.parse(slotProps.data.avatar).type == 'shortname'"
                                class="p-2 font-semibold text-white rounded-full w-[30px] text-[14px]"
                                :class="current_user_id.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.avatar).data }} </p>
                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${JSON.parse(slotProps.data.avatar).data}`" srcset="" alt="" />
                       
                            <!-- <p class="pl-2 font-semibold ">{{ slotProps.data.name }} </p> -->
                            <p class="pl-2 font-semibold  fs-6 flex flex-col text-[#0873CD]  text-justify">{{ slotProps.data.name }} 
                                <span class="text-[#535353]">{{ slotProps.data.user_code }}</span>
                            </p>
                       
                    </div>
                </template>
            </Column>

            <!-- <Column class="font-bold" field="name" header="Employee"  >
                    <template #body="slotProps">
                        {{ slotProps.data }}
                        <div class="flex items-center justify-center">
                            <p v-if="JSON.parse(slotProps.data.avatar).type == 'shortname'"
                                class="p-2 font-semibold text-white rounded-full w-[35px] fs-6"
                                :class="service.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.avatar).data }} </p>
                            <img v-else class="w-10 rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.avatar).data}`" srcset=""
                                alt="" />
                            <p class="pl-2 font-semibold  fs-6 flex flex-col text-[#0873CD]  text-justify">{{ slotProps.data.name }}
                                <span class="text-[#535353]">{{ slotProps.data.user_code }}</span>
                            </p>
                        </div>
                    </template>
                   
                </Column> -->
            <!-- <Column field="user_code" header="Employee Id" sortable></Column> -->

            <!-- <Column field="name" header="Employee New Name">
            </Column> -->
            <Column field="doc_status" header="Approval Status" :sortable="false">
                <template #body="{ data }">
                    {{ data.doc_status }}
                </template>
            </Column>
            <Column field="" header="Action">
                <template #body="slotProps">
                    <span class="flex gap-4 justify-center items-center">
                        <!-- <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Approve All"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Approve')" style="height: 2.5em" />
                        <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button" label="Reject All"
                            style="margin-left: 8px; height: 2.5em"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Reject')" /> -->
                            <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Approve')">Approve All</button>
                            <button class="bg-black px-4 rounded-md text-[#ffff] h-[25px]"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Reject')" >Reject All</button>
                    </span>
                </template>
            </Column>
            <template #expansion="slotProps">
                <div>
                    <DataTable :value="slotProps.data.documents" responsiveLayout="scroll"
                        v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                        @select-all-change="onSelectAllChange">
                        <Column field="doc_name" header="Document Name">{{ slotProps.data.doc_name }}</Column>
                        <Column field="doc_status" header="Status">

                        </Column>
                        <Column field="" header="View">
                            <template #body="slotProps">
                                <!-- <Button type="button" icon="pi pi-eye" class="p-button-success Button" label="View"
                                    @click="showDocDialog(slotProps.data.record_id)" style="height: 2em" /> -->
                                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                                    @click="showDocDialog(slotProps.data.record_id)">View</button>
                            </template>
                        </Column>

                        <Column field="" header="Action">
                            <template #body="slotProps">
                                <span class="flex justify-center items-center gap-4">
                                    <!-- <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"
                                        label="Approve" @click="showConfirmDialog(slotProps.data, 'Approve')"
                                        style="height: 2.5em" />
                                    <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button"
                                        label="Reject" style="margin-left: 8px; height: 2.5em"
                                        @click="showConfirmDialog(slotProps.data, 'Reject')" /> -->
                                        <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px] flex justify-center items-center"
                                        @click="showConfirmDialog(slotProps.data, 'Approve')">
                                        <i class="pi pi-check"></i>
                                        </button>
                                        <button class="bg-black px-4 rounded-md text-[#ffff] h-[25px] flex justify-center items-center"
                                        @click="showConfirmDialog(slotProps.data, 'Reject')" >
                                        <i class="pi pi-times"></i>
                                        </button>
                                </span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>

        </DataTable>

        <Dialog v-model:visible="dialog_visible" class="z-0 relative" modal header="Documents" v-if="canShowLoadingScreen == false"
            :style="{ width: '40vw' }">

            <i @click="dialog_visible=false" class="pi pi-times border-[3px] p-2 rounded-full border-blue-200 absolute cursor-pointer top-2 right-2"></i>
            <img :src="`data:image/png;base64,${documentPath}`" :alt="doc_url" class="block pb-3 m-auto" />
        </Dialog>


    </div>
</template>


<script setup>
import { ref, reactive, onMounted } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { UseEmpDetailApprovalsStore } from "./EmpDetails_approvals_service";
import axios from "axios";
import map from 'lodash/map';
import { Service } from "../../Service/Service";
import LoadingSpinner from "../../../components/LoadingSpinner.vue";

const current_user_id = Service();

const EmpDetailStore = UseEmpDetailApprovalsStore();
const expandedRows = ref([]);
const selectedAllEmployee = ref();
const canShowConfirmationAll = ref(false);
const canShowConfirmation = ref(false);
let currentlySelectedStatus = null;
let currentlySelectedRowData = null;

const canShowLoadingScreen = ref(false);

const dialog_visible = ref(false)

const documentPath = ref()

// const view_document =ref({});

onMounted(async () => {
    await EmpDetailStore.getEmpDetails_list();
    // console.log(EmpDetailStore.getEmpDetails_list());
    // console.log();
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    // name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
});

const showDocDialog = (record_id) => {
    // view_document.value = { ...document }

    dialog_visible.value = true

    axios.post(`${window.location.origin}/view/getEmpProfileProofPrivateDoc`, {
        emp_doc_record_id: record_id,
    }).then(res => {
        console.log(res.data.data);
        documentPath.value = res.data.data
        console.log("data sent", documentPath.value);
    }).finally(() => {

    })


}


function showConfirmDialog(selectedRowData, status) {
    canShowConfirmation.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;
    console.log("Selected Bulk Row Data : " + JSON.stringify(selectedRowData));
}
function showAllConfirmDialog(selectedRowData, status) {
    canShowConfirmationAll.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;
    console.log("Selected Bulk Row Data : " + JSON.stringify(selectedRowData));

}



function resetVars() {
    currentlySelectedStatus = "";
    currentlySelectedRowData = null;
}

function hideConfirmDialog(canClearData) {
    canShowConfirmation.value = false;

    if (canClearData) resetVars();
}

function hideBulkConfirmDialog(canClearData) {
    canShowConfirmationAll.value = false;
    if (canClearData) resetVars();
}

const getBulkApprovalList = (selectedRowData, status) => {
    canShowConfirmationAll.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;
}

const processBulkDocumentsApproveReject = () => {

    EmpDetailStore.canShowLoadingScreen = true;

    hideBulkConfirmDialog();

    //Get the doc ids of the selected employees rowdata
    let processed_doc_ids = map(currentlySelectedRowData, 'record_id');

    console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData.documents));
    console.log("currentlySelectedStatus : " + currentlySelectedStatus);

    console.log("Processed doc record ids : " + processed_doc_ids);


    axios.post("/approvals/EmployeeProof-bulkdocs-approve-reject", {
        approver_user_id: current_user_id.current_user_id,
        record_id: processed_doc_ids,
        status:
            currentlySelectedStatus == "Approve"
                ? "Approved"
                : currentlySelectedStatus == "Reject"
                    ? "Rejected"
                    : currentlySelectedStatus,
        reviewer_comments: "",
    }
    ).then((res) => {
        console.log("testing data", res.data);

    }).finally(() => {
        EmpDetailStore.canShowLoadingScreen = false;
        EmpDetailStore.getEmpDetails_list();

        resetVars();
    })


}


// const getBulkApprovalList = (data,selectedStatus) => {

// console.log(data);
// console.log(data[0].record_id);

// var selectList = {
//     record_id: data.record_id,
//     doc_status: selectedStatus == "Approve"
//                 ? "Approved"
//                 : selectedStatus == "Reject"
//                     ? "Rejected"
//                     : selectedStatus,
// };

// var form_data = new FormData();

// for (var key in selectList) {
//     form_data.append(key, selectList[key]);
// }
// console.log(form_data);


// }



function empDetailsDocumentApproveReject() {

    EmpDetailStore.canShowLoadingScreen = true;
    hideConfirmDialog();

    axios.post( `${window.location.origin}/approvals/EmployeeProof-docs-approve-reject`, {
        approver_user_id: current_user_id.current_user_id,
        record_id: currentlySelectedRowData.record_id,
        status:
            currentlySelectedStatus == "Approve"
                ? "Approved"
                : currentlySelectedStatus == "Reject"
                    ? "Rejected"
                    : currentlySelectedStatus,
        reviewer_comments: "",
    }
    ).then((res) => {
        console.log("testing data", res.data);

    }).finally(() => {

        EmpDetailStore.canShowLoadingScreen = false;
        resetVars();
        EmpDetailStore.getEmpDetails_list();
    })
}



</script>


