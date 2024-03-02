<template>
    <div>
        <!-- <ConfirmDialog></ConfirmDialog> -->
        <Toast />

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content">
                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to {{ currentlySelectedStatus }}?</span>
            </div>
            <template #footer>
                <Button label="Yes" icon="pi pi-check" @click="processApproveReject()" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" />
            </template>
        </Dialog>
        <!-- {{ manageEmployeesStore.yet_to_active_employees_data }} -->
        <div>
            <DataTable :value="manageEmployeesStore.yet_to_active_employees_data" :paginator="true" :rows="10" dataKey="emp_code"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                :rowsPerPageOptions="[5, 10, 25]" v-model:filters="filters" filterDisplay="menu"
                :globalFilterFields="['emp_name', 'emp_code','emp_designation','reporting_manager_name', 'status']">
                <template #header>
                <div class="text-left">
                    <div class="p-input-icon-left">
                        <i class="pi pi-search"></i>
                        <InputText class="border p-1.5 bg-gray-100   border-gray-300" v-model="filters['global'].value" placeholder="Global Search" />
                    </div>
                </div>
            </template>
                <template #empty> No customers found. </template>
                <template #loading> Loading customers data. Please wait. </template>

                <Column class="font-bold" field="emp_name" header="Employee Name"
                    style="min-width : 20rem !important; text-align: center  !important;">
                    <template #body="slotProps">
                        <div class="flex items-center justify-center !borde-[1px] !border-[#000]">
                            <p v-if="JSON.parse(slotProps.data.emp_avatar).type == 'shortname'"
                                class="p-2 font-semibold text-white rounded-full w-[30px] text-[12px]"
                                :class="service.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.emp_avatar).data }} </p>
                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${JSON.parse(slotProps.data.emp_avatar).data}`" srcset=""
                                alt="" />
                            <p class="pl-2 font-semibold  fs-6 flex flex-col text-[#0873CD]  text-justify">{{ slotProps.data.emp_name }}
                                <span class="text-[#535353]">{{ slotProps.data.emp_code }}</span>
                            </p>
                        </div>
                    </template>
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                </Column>

                
                <Column field="emp_designation" header="Designation"  class="">
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-start">{{slotProps.data.emp_designation}}</p>
                    </template>
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                </Column>
                <Column field="reporting_manager_name" header="Reporting Manager">
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-start" v-if="slotProps.data.reporting_manager_name!=null">{{slotProps.data.reporting_manager_name}}</p>
                        <p v-else class="text-center text-[#000] font-normal">---</p>
                    </template>
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                </Column>
                <Column field="doj" header="DOJ" style="min-width: 10rem;">
                    <template #body="slotProps">{{ dayjs(slotProps.data.doj).format('DD-MMM-YYYY') }}</template>
                </Column>
                <!-- <Column field="blood_group_name" header="Blood Group"></Column> -->
                <Column field="profile_completeness" header="Profile Completeness">
                    <template #body="slotProps">
                        <ProgressBar v-if="slotProps.data.profile_completeness <= 39"
                            :value="slotProps.data.profile_completeness"
                            :class="[slotProps.data.profile_completeness <= 39 ? 'progressbar' : '']">
                        </ProgressBar>
                        <ProgressBar class="progressbar_val2"
                            v-if="slotProps.data.profile_completeness >= 40 && slotProps.data.profile_completeness <= 59"
                            :class="[slotProps.data.profile_completeness >= 40 && slotProps.data.profile_completeness <= 59]"
                            :value="slotProps.data.profile_completeness">
                        </ProgressBar>

                        <ProgressBar class="progressbar_val3" v-if="slotProps.data.profile_completeness >= 60"
                            :class="[slotProps.data.profile_completeness >= 60]"
                            :value="slotProps.data.profile_completeness">
                        </ProgressBar>
                    </template>
                </Column>
                <Column field="is_onboarded" header="Onboarding Status">
                    <template #body="slotProps">
                        {{ slotProps.data.is_onboarded ? "Completed" : "Pending" }}
                    </template>

                </Column>
                <Column field="doc_status" header="Docs Approval Status">
                    <template #body="slotProps">
                        {{
                            slotProps.data.is_onboarded ? (slotProps.data.doc_status ? "Approved" : "Pending")
                            : "Pending"

                        }}
                    </template>
                </Column>
                <Column field="enc_user_id" header="View Profile">
                    <template #body="slotProps">
                        <RouterLink :to="`/profile-page/${slotProps.data.user_id}`" @click="openProfilePage(slotProps.data)" class="px-2 py-1  "><i class="h-6 py-1 mx-2 pi pi-eye text-[#000]"></i></RouterLink>
                    </template>
                </Column>
                <Column style="width: 300px" field="" header="Action">
                    <template #body="slotProps">
                        <!-- ACTIVATE button wont be shown if is_onboarded and doc_status are FALSE -->
                        <div v-if="slotProps.data.is_onboarded && slotProps.data.doc_status">
                            <Button icon="pi pi-check-circle" severity="success" label="Activate"
                                class="p-button-success Button" @click="showConfirmDialog(slotProps.data, 'Active')"
                                style="height: 2em" />
                        </div>
                        <div v-else>

                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>
<script setup>
import dayjs from 'dayjs';
import { ref, onMounted } from "vue";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { Service } from '../../../Service/Service';


const service = Service()

import { useManageEmployeesStore } from '../manage_service'

const manageEmployeesStore = useManageEmployeesStore()


onMounted(() => {
    manageEmployeesStore.ajax_yet_to_active_employees_data()
});

let att_regularization = ref();
let canShowConfirmation = ref(false);
let canShowLoadingScreen = ref(false);
const confirm = useConfirm();
const toast = useToast();
// const loading = ref(true);

function openProfilePage(uid) {
}

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    // emp_name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // emp_code: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // emp_designation: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // reporting_manager_name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },

    // status: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const statuses = ref(["Pending", "Approved", "Rejected"]);

let currentlySelectedStatus = null;
let currentlySelectedRowData = null;


// function ajax_GetAttRegularizationData() {
//   let url = window.location.origin + "/fetch-att-regularization-data";

//   console.log("AJAX URL : " + url);

//   axios.get(url).then((response) => {
//     console.log("Axios : " + response.data);
//     att_regularization.value = response.data;
//     loading.value = false;
//   });
// }

function showConfirmDialog(selectedRowData, status) {
    let user_code = selectedRowData.emp_code
    let emp_status = selectedRowData.emp_status
    console.log(useManageEmployeesStore.emp_status);
    console.log(selectedRowData.emp_status);

    canShowConfirmation.value = true;

    // manageEmployeesStore.canShowLoadingScreen =true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;
    console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {
    manageEmployeesStore.canShowLoadingScreen =false;
    canShowConfirmation.value = false;

    if (canClearData) resetVars();
}

function resetVars() {
    currentlySelectedStatus = "";
    currentlySelectedRowData = null;
}

////PrimeVue ConfirmDialog code -- Keeping here for reference
//const confirm = useConfirm();

// function confirmDialog(selectedRowData, status) {
//     console.log("Showing confirm dialog now...");

//     confirm.require({
//         message: 'Are you sure you want to proceed?',
//         header: 'Confirmation',
//         icon: 'pi pi-exclamation-triangle',
//         accept: () => {
//             toast.add({severity:'info', summary:'Confirmed', detail:'You have '+status, life: 3000});
//         },
//         reject: () => {
//             console.log("Rejected");
//             //toast.add({severity:'error', summary:'Rejected', detail:'You have rejected', life: 3000});
//         }
//     });
// }

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

    manageEmployeesStore.canShowLoadingScreen =true;

    console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));


    axios
        .post(window.location.origin + "/onboarding/updateEmployeeActive", {
            user_code: currentlySelectedRowData.emp_code,
            active_status: 1
        })
        .then((response) => {
            console.log("Response : " + response);



            toast.add({ severity: "success", summary: "Activated", detail: `${currentlySelectedRowData.emp_name} Activated Successfully`, life: 3000 });
            //manageEmployeesStore.ajax_yet_to_active_employees_data();
            //    window.location.reload();

            resetVars();
        })
        .catch((error) => {

            manageEmployeesStore.canShowLoadingScreen =false;
            resetVars();

            //   console.log(error.toJSON());
        }).finally(() => {
            manageEmployeesStore.ajax_yet_to_active_employees_data();
            manageEmployeesStore.getActiveEmployees();
            manageEmployeesStore.canShowLoadingScreen =false;
            canShowConfirmation.value = false;
        });
}
</script>
