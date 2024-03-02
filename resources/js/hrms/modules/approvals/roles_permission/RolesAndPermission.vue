<template>
    <div v-if="RolePermission.rolesPermission == 1">

        <div class="w-full mt-30">
            <div class="">
                <h1 class="fs-2 fw-semibold my-3">User Roles</h1>
                <p class="  mb-3 fs-5">New roles can be Created and privileges for all these roles can be managed from this
                    section</p>
            </div>
            <div class="card bg-blue-200 h-20 border-none p-4 ">
                <div class="d-flex justify-content-between align-items-center ">
                    <div class=" w-80 ">
                        <h1 class=" fs-4 text-blue-900 fw-semibold">Created</h1>
                    </div>
                    <div class="">
                        <button class="bg-white text-blue-900 px-3 py-2 rounded shadow-md fw-semibold"
                            @click="RolePermission.rolesPermission = 2"> <i class="pi pi-plus fw-semibold"></i>
                            <span class="fw-semibold"> New Category</span>
                        </button>
                    </div>
                </div>
            </div>

            <Dialog header="Confirmation" v-model:visible="canShowConfirmationDialog"
                :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
                <div class="confirmation-content">
                    <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                    <span>Are you sure you want to {{ currentlySelectedStatus }}?</span>
                </div>
                <template #footer>
                    <Button label="Yes" icon="pi pi-check" @click="empDetailsDocumentApproveReject()" class="p-button-text"
                        autofocus />
                    <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" />
                </template>
            </Dialog>


            <!-- {{ RolePermission.arrayRoleDetails }} -->
            <!-- {{ RolePermission.AdminPrivilege }} -->
            <div class="card shadow-md mt-4">
                <DataTable :value="RolePermission.AdminPrivilege" :paginator="true" :rows="10" class="" dataKey="roles_id"
                    @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows"
                    v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
                    @row-select="onRowSelect" @row-unselect="onRowUnselect" :rowsPerPageOptions="[5, 10, 25]"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">
                    <template #empty> No Employee Details documents for the selected status filter </template>

                    <Column :expander="true" />
                    <Column field="role" header="Roles" sortable></Column>
                    <Column field="assigned_privileged" header="Assigned Privileges" :sortable="false">

                    </Column>
                    <Column field="assigned_emp" header="Assigned Employees" :sortable="false">

                    </Column>
                    <Column field="" header="Action">
                        <template #body="slotProps">
                            <button class=" text-blue-800  "><i class="pi pi-pencil "></i></button>
                            <button class=" text-blue-800 mx-4" @click="canShowConfirmation(slotProps.data)"><i
                                    class="pi pi-trash"></i></button>
                        </template>
                        <!-- <button class=" text-white bg-blue-700 px-4 py-2 rounded shadow "
                                @click="removeUserRole(slotProps.data)">Remove</button> -->
                    </Column>
                    <template #expansion="slotProps">
                        <div>
                            <DataTable :value="slotProps.data.accordian" responsiveLayout="scroll"
                                v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                                @select-all-change="onSelectAllChange">
                                <Column field="Sub_Category_Name" header="Sub_Category_Name" style="width:10rem" >{{ slotProps.data.user_code }}
                                </Column>
                                <!-- <ColumnGroup>
                                    <row> -->
                                <Column  header="Privilege Name">
                                    <template #body="{data}">
                                        <!-- {{ data.Privilege }} -->
                                                <div v-for="(item, index) in data.Privilege" :key="index" class=" border-black p-2 d-flex justify-content-start">
                                                    {{ item.Privilege_name }}
                                                </div>
                                          </template>
                                </Column>
                                <!-- </row>
                                </ColumnGroup> -->

                            </DataTable>
                        </div>
                    </template>

                </DataTable>

            </div>
        </div>

    </div>


    <!-- <div v-for="i in number" :key="i" class="mt-10">
        <input type="text" name="" id="">
    </div>
    <span><button @click="number++">click</button></span>

    {{ number }} -->

    <div v-if="RolePermission.rolesPermission == 2">
        <CreateNewRole />
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { UseRolePermissionStore } from './RolesAndPermissionStore'

import CreateNewRole from "./create_new_role/CreateNewRole.vue";
const number = ref(1)

const RolePermission = UseRolePermissionStore();

const addNewroleDailog = ref(false);
const selectedRowdata = ref();
const currentlySelectedRowData = ref();

const expandedRows = ref([]);
const expandedAllRows = ref([]);
const selectedAllEmployee = ref();
const canShowConfirmationDialog = ref(false);

onMounted(() => {
    RolePermission.getRoleDetails()
    RolePermission.getAdminRolesDetails();
})


function canShowConfirmation(SelectedRowData) {
    canShowConfirmationDialog.value = true;
    currentlySelectedRowData.value = SelectedRowData;
    console.log(currentlySelectedRowData.value);
}

async function removeUserRole() {
    canShowConfirmationDialog.value = true;
    // await RolePermission.removeRoleDetails(SelectedRowData.roles_name, SelectedRowData.user_code);
}

function editRoleDetails(SelectedRowData) {
    expandedAllRows.value = expandedRows.value;

    console.log(expandedAllRows.value);
    // console.log(expandedRows.value);
}

function hideConfirmDialog() {
    canShowConfirmationDialog.value = false;

}



</script>

<style>
.p-datatable-tbody {
    /* display: flex;
justify-content: center;
align-items: center; */
}

/* .p-column-header-content{
    display: flex;
justify-content: center;
align-items: center;
}
.columnheader{
    display: flex;
justify-content: center;
align-items: center;
} */
</style>
