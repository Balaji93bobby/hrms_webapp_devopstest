<template>
    <div v-if="useData.rolesPermission == 1">

        <div class="w-full mt-30">
            <div class="">
                <h1 class="fs-2 fw-semibold my-3">User Roles</h1>
                <p class=" fw-semibold mb-3">User Roles can be assigned to the employees from here. New roles can be created
                    and
                    privileges for all these roles can be managed from this section.</p>
            </div>
            <div class="card bg-blue-200 h-20 border-none p-4 ">
                <div class="d-flex justify-content-between align-items-center ">
                    <h1 class=" fw-semibold ">Assigned</h1>
                    <div class=" d-flex justify-content-between align-items-center">
                        <div class=" w-80 ">
                        <input type="text" name="" id="" placeholder="search" class="rounded h-10 w-80 pl-2 shadow-md">
                        </div>
                        <!-- <button class=" bg-blue-800 px-4 py-2 rounded text-white mx-3 shadow-md"
                            @click="saveallRoleDetails">save</button> -->
                        <button class="bg-white text-blue-800 px-3 py-2 rounded shadow-md mx-2"
                            @click="useData.rolesPermission = 2"> <i class="pi pi-plus"></i>
                            Assign New Role
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

            <!--
        {{ RolePermission.arrayRoleDetails }} -->
            <div class="card shadow-md mt-4">
                <DataTable :value="useData.arrayRoleDetails" :paginator="true" :rows="10" class="" dataKey="roles_id"
                    @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows"
                    v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
                    @row-select="onRowSelect" @row-unselect="onRowUnselect" :rowsPerPageOptions="[5, 10, 25]"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">
                    <template #empty> No Employee Details documents for the selected status filter </template>

                    <Column :expander="true" />
                    <Column field="name" header="Roles" sortable>
                        <template #body="slotProps">
                            <h1 class=" text-blue-800">{{ slotProps.data.name}}</h1>
                        </template>
                    </Column>
                    <Column field="description" header="Role Description">
                        <template #body="slotProps" >
                            <h1 class=" text-gray-600" >{{ slotProps.data.description }}</h1>
                        </template>

                    </Column>

                    <Column field="assigned_privileged" header="Assigned Privileges" :sortable="false">
                        <template #body="slotProps">
                            <h1 class=" text-blue-800">{{ slotProps.data.assigned_privileged  }}</h1>
                        </template>
                    </Column>
                    <Column field="assigned_emp" header="Assigned Employees" :sortable="false">
                        <template #body="slotProps">
                            <h1 class=" text-blue-800">{{ slotProps.data.assigned_emp}}</h1>
                        </template>

                    </Column>
                    <Column field="" header="Action">
                        <template #body="slotProps">
                                <button class=" text-blue-600 fw-semibold hover:underline "
                                @click="removeUserRole(slotProps.data)">Manage Users</button>

                        </template>
                    </Column>
                    <template #expansion="slotProps">
                        <div>
                            <DataTable :value="slotProps.data.accordian" responsiveLayout="scroll"
                                v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                                @select-all-change="onSelectAllChange">
                                <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column>
                                <Column field="user_code" header="Employee ID">
                                    <h1 class="">{{ slotProps.data.user_code }}</h1>
                                </Column>
                                <Column field="name" header="Employee Name">

                                </Column>
                                <Column field="department_name" header="Department"  >
                                </Column>

                                <Column field="" header="Action">
                                    <template #body="slotProps" >
                                            <button class=" shadow-sm px-3 py-2 rounded text-white bg-blue-700" @click="canShowConfirmation(slotProps.data)" >Remove</button>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </template>

                </DataTable>

            </div>
        </div>

    </div>
</template>


<script setup>
import { onMounted, ref } from 'vue';

import {AdminRolePermissionStore} from './AdminRolesPermissionStore';

const useData = AdminRolePermissionStore();

const currentlySelectedRowData = ref();

const expandedRows = ref([]);
const expandedAllRows = ref([]);
const selectedAllEmployee = ref();

onMounted(()=>{
    useData.getRoleDetails();
})

</script>
