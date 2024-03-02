<template>
    <!-- <div class="card" v-if="lding">
        <div class="p-4 border-round border-1 surface-border surface-card">
            <div class="flex mb-3">
                <Skeleton shape="circle" size="4rem" class="mr-2"></Skeleton>
                <div>
                    <Skeleton width="10rem" class="mb-2"></Skeleton>
                    <Skeleton width="5rem" class="mb-2"></Skeleton>
                    <Skeleton height=".5rem"></Skeleton>
                </div>
            </div>
            <Skeleton width="100%" height="150px"></Skeleton>
            <div class="flex mt-3 justify-content-between">
                <Skeleton width="4rem" height="2rem"></Skeleton>
                <Skeleton width="4rem" height="2rem"></Skeleton>
            </div>
        </div>
    </div> -->

    <div class="w-full p-3">
        <div>
            <h4 class="fs-4 text-xl font-semibold ">Employee Roles and Permissions</h4>
        </div>
        <div class="bg-white rounded-lg p-3 border my-3">
            <p class="text-lg font-semibold text-gray-700 ">Here you can manage the Employees Roles and Permissions</p>
            <div class="flex justify-between my-6">
                <InputText placeholder="Search...." class="h-10" />
                <!-- Creating New Job Roles dailog-->
                <button class="h-10 mx-6 btn btn-orange" @click="addNewroleDailog = true">Create Role</button>
            </div>

            <div>
                <DataTable>
                    <Column field="product" header="Role"></Column>
                    <Column field="lastYearSale" header="Who Has Access"></Column>
                    <Column field="thisYearSale" header="Actions"></Column>
                </DataTable>
            </div>
        </div>
    </div>





    <Dialog header="Header" v-model:visible="addNewroleDailog" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '65vw', borderTop: '5px solid #002f56' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <p class="font-semibold text-lg">
                Creating New Job Role</p>
        </template>
        <!-- <div class="px-4 row">
            <h3 class="text-xl font-semibold col-12">Roles Details</h3>
        </div> -->
        <div class="p-4">
            <div class="grid grid-cols-12">
                <h5 class="text-lg font-semibold col-span-2">Role Title</h5>
                <InputText placeholder="Role Title" class="h-10 col-span-6" />
            </div>
            <div class="my-3 grid grid-cols-12">
                <h5 class="text-lg font-semibold col-span-2">Role Description</h5>
                <Textarea placeholder="Role Description " autoResize class="col-span-6" />
            </div>
            <div class="my-3 grid grid-cols-12">
                <h5 class="text-lg font-semibold col-span-2">Assign To</h5>
                <Tree :value="nodes" selectionMode="checkbox" class="font-semibold col-span-6 ">
                </Tree>
            </div>

        </div>
        <template #footer>
            <div>
                <button class="px-4 py-2 text-lg font-semibold text-gray-900 bg-gray-400 rounded-md"
                    @click="addNewroleDailog = false">Cancel</button>
                <button class="py-2 mx-4 btn btn-orange">Create Role</button>
            </div>

        </template>
    </Dialog>
    <!-- {{ selectedKey }} -->
    <!-- {{ rolespermission.allpermission }} -->
    <!-- {{ allpermission.data }} -->
</template>


<script setup>
import { onMounted, ref } from "vue";
import { UseRolePermissionServie } from "./roles_permission_service";
import axios from 'axios';

const rolespermission = UseRolePermissionServie();

const expandedRows = ref([]);
const selectedAllEmployee = ref();

const lding = ref(true)

const selectedKey = ref()
const addNewroleDailog = ref(false)

const canShowLoadingScreen = ref(true);
const canShowCreateRole_Dialog = ref(false);
const canShowManageRoles_Dialog = ref(false);

const allpermission = ref();

axios.get('/getAllPermissions').then(res => {
    allpermission.value = res.data;
    console.log(allpermission);
});


const nodes = ref([
    {
        id: 1,
        key: '0',
        label: '',
        data: 'Documents Folder',
        icon: 'pi pi-fw pi-inbox',
        children: [
            {

                id: 2,
                key: '1',
                label: 'Work',
                data: 'Work Folder',
                icon: 'pi pi-fw pi-cog',
                children: [
                    { key: '0-0-0', label: 'Expenses.doc', icon: 'pi pi-fw pi-file', data: 'Expenses Document' },
                    { key: '0-0-1', label: 'Resume.doc', icon: 'pi pi-fw pi-file', data: 'Resume Document' }
                ]
            },
            {
                id: 3,
                key: '2',
                label: 'Home',
                data: 'Home Folder',
                icon: 'pi pi-fw pi-home',
                children: [{ key: '0-1-0', label: 'Invoices.txt', icon: 'pi pi-fw pi-file', data: 'Invoices for this month' }]
            }
        ]
    },
    {
        id: 4,
        key: '4',
        label: 'Events',
        data: 'Events Folder',
        icon: 'pi pi-fw pi-calendar',
        children: [
            { id: 5, key: '1-0', label: 'Meeting', icon: 'pi pi-fw pi-calendar-plus', data: 'Meeting' },
            { id: 6, key: '1-1', label: 'Product Launch', icon: 'pi pi-fw pi-calendar-plus', data: 'Product Launch' },
            { id: 7, key: '1-2', label: 'Report Review', icon: 'pi pi-fw pi-calendar-plus', data: 'Report Review' }
        ]
    }])

onMounted(() => {
    setTimeout(() => {
        lding.value = false
    }, 4000);
})

</script>

<style>
.p-treenode-label
{
    font-weight: 600;
}
</style>
