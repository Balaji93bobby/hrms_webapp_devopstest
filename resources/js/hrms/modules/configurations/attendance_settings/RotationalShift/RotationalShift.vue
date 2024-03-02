<template>
    <div class="w-full">
        <div class="flex justify-between">

            <div> <button class="float-right mx-4 my-3 cursor-pointer btn btn-orange"
                    @click="canShowRotationalShift = true">
                    <i class="fa fa-plus-circle me-2"></i>Add Shift
                </button>
            </div>
        </div>
        <div>
            <DataTable :value="att_emp_details" v-model:selection="selectedEmployees" :paginator="true" :rows="5"
                dataKey="emp_code" :rowsPerPageOptions="[5, 10, 25]"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters"
                filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
                <template #empty> No Employee found </template>
                <template #loading> Loading employee data. Please wait. </template>
                <!-- <Column selectionMode="multiple"></Column> -->
                <Column field="emp_code" header="Shift Name" style="min-width: 2rem">
                    <template #body="slotProps">
                        {{ slotProps.data.emp_code }}
                    </template>
                </Column>
                <Column field="employee_name" header="Shift Code" style="min-width: 8rem">
                    <template #body="slotProps">
                        {{ slotProps.data.employee_name }}
                    </template>
                </Column>
                <Column field="designation" header="Is Default" style="min-width: 10rem">
                    <template #body="slotProps">
                        {{ slotProps.data.designation }}
                    </template>
                </Column>
                <Column style="min-width: 10rem" field="Assigned To" header="Assigned To">
                    <template #body="slotProps">
                        {{ slotProps.data.department_name }}
                    </template>
                </Column>
                <Column style="min-width: 10rem" field="work_location" header="Actions">
                    <template #body="slotProps">
                        {{ slotProps.data.work_location }}
                    </template>
                </Column>
            </DataTable>

            <Dialog v-model:visible="canShowRotationalShift" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                :style="{ width: '50vw', borderTop: '5px solid #002f56' }" :modal="true" :closable="true"
                :closeOnEscape="false">
                <template #header>
                    <h6 class=" modal-title fs-21">
                        Add Rotational Shift</h6>
                </template>
                <div class="my-3 row">
                    <div class="col-5">
                        <p class="text-lg font-semibold">Name</p>
                    </div>
                    <div class="col-4">
                        <InputText type="text" v-model="txt_shift_name" placeholder="Enter the shift name" class="w-full" />
                    </div>
                </div>
                <div class="my-3 row">
                    <div class="col-5">
                        <p class="text-lg font-semibold">Choose the rotation option</p>
                    </div>
                    <div class="col-4">
                        <Dropdown editable optionLabel="name" optionValue="name" placeholder="Choose Rotational Shift "
                            class="w-full p-error" />
                    </div>
                </div>
                <div class="my-3 row">
                    <div class="col-5">
                        <p class="text-lg font-semibold">Select the shifts to be rotated</p>
                        <div class="flex mt-2">
                            <input type="checkbox" name="" id="">
                            <p class="mx-2 my-2 text-lg font-semibold"> General Shift</p>
                        </div>
                        <div class="flex my-1">
                            <input type="checkbox" name="" id="">
                            <p class="mx-2 my-2 text-lg font-semibold"> Night Shift</p>
                        </div>
                        <div class="flex">
                            <input type="checkbox" name="" id="">
                            <p class="mx-2 my-2 text-lg font-semibold"> Other Shift</p>
                        </div>
                    </div>
                    <!-- <div class="col-4">
                <InputText type="text" v-model="txt_shift_name" placeholder="Enter the shift name" />
            </div> -->
                </div>
                <template #footer>
                    <button class="btn btn-border-primary">Close</button>
                    <button class="btn btn-orange">Save</button>
                </template>
            </Dialog>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";

import AddShift from '../ManageShift/AddShift/AddShift.vue'

let canShowRotationalShift = ref(false);




</script>
<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,200&display=swap");

.p-datatable .p-datatable-thead>tr>th {
    text-align: center;
    padding: 1.3rem 1rem;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    font-weight: 600;
    color: #fff;
    background: #003056;
    transition: box-shadow 0.2s;
    font-size: 13px;

    .p-column-title {
        font-size: 13px;
    }

    .p-column-filter {
        width: 100%;
    }

    #pv_id_2 {
        height: 30px;
    }

    .p-fluid .p-dropdown .p-dropdown-label {
        margin-top: -10px;
    }

    .p-dropdown .p-dropdown-label.p-placeholder {
        margin-top: -12px;
    }

    .p-column-filter-menu-button {
        color: white;
        margin-left: 10px;
    }

    .p-column-filter-menu-button:hover {
        color: white;
        border-color: transparent;
        background: #023e70;
    }
}

.p-column-filter-overlay-menu .p-column-filter-constraint .p-column-filter-matchmode-dropdown {
    margin-bottom: 0.5rem;
    visibility: hidden;
    position: absolute;
}

.p-button .p-component .p-button-sm {
    background-color: #003056;
}

.p-datatable .p-datatable-tbody>tr {
    font-size: 13px;

    .employee_name {
        font-weight: bold;
        font-size: 13.5px;
    }
}

.p-datatable .p-datatable-tbody>tr>td {
    text-align: left;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    padding: 1rem 0.6rem;
}

// .p-datatable .p-datatable-tbody>tr>td:nth-child(1) {
//   width: 200px;
// }

// .p-datatable .p-datatable-tbody>tr>td:nth-child(3) {
//   width: 150px;
// }

// .p-datatable .p-datatable-tbody>tr>td:nth-child(6) {
//   width: 200px;
// }

// .main-content {
//   width: 105%;
// }

.pending {
    font-weight: 700;
}

.approved {
    font-weight: 700;
}

.p-button.p-component.p-button-success.Button {
    padding: 8px;
}

.rejected {
    font-weight: 700;
    color: #ff2634;
}

.p-button.p-component.p-button-danger.Button {
    padding: 8px;
}

.p-confirm-dialog-icon.pi.pi-exclamation-triangle {
    color: red;
}

.p-button.p-component.p-confirm-dialog-accept {
    background-color: #003056;
}

.p-button.p-component.p-confirm-dialog-reject.p-button-text {
    color: #003056;
}

.p-column-filter-overlay-menu .p-column-filter-buttonbar {
    padding: 1.25rem;
    position: absolute;
    visibility: hidden;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter {
    width: 44%;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter-menu-button {
    color: white;
    border-color: transparent;
}

.p-column-filter-menu-button.p-column-filter-menu-button-open {
    background: none;
}

.p-column-filter-menu-button.p-column-filter-menu-button-active {
    background: none;
}

/* For Sort */

.p-datatable .p-sortable-column:not(.p-highlight):hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:not(.p-highlight):hover .p-sortable-column-icon {
    color: white;
}

.p-datatable .p-sortable-column.p-highlight {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column.p-highlight:hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:focus {
    box-shadow: none;
    outline: none;
    color: white;
}

.p-datatable .p-sortable-column .p-sortable-column-icon {
    color: white;
}

.pi-sort-amount-down::before {
    content: "\e9a0";
    color: white;
}

.pi-sort-amount-up-alt::before {
    content: "\e9a2";
    color: white;
}

.p-datatable .p-datatable-thead>tr>th .p-column-title {
    font-size: 13px;
    margin-left: 50px;
}

// .p-dialog .p-dialog-header {
//   border-bottom: 0 none;
//   background: #003056;
//   color: #ffff;
//   padding: 1.5rem;
//   border-top-right-radius: 6px;
//   border-top-left-radius: 6px;
// }
// .p-dialog .p-dialog-content {
//   background: #003056;
//   color: #495057;
//   padding: 0 1.5rem 2rem 1.5rem;
// }</style>
