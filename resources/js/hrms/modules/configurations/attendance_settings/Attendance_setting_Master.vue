<template>
    <Toast />
    <ConfirmDialog />
    <div class="mb-1">

        <div class="mb-2 shadow card left-line ">
            <div class="pt-1 pb-0 card-body">
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed " role="tablist">
                    <li class="nav-item text-muted" role="presentation">
                        <button class="pb-2 nav-link active" id="pills-offer-pending-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-pending" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Manage Shifts</button>
                    </li>
                    <li class="mx-4 nav-item text-muted " role="presentation">
                        <button class="pb-2 nav-link" id="pills-offer-completed-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-completed" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Flexible Shifts</button>
                    </li>
                    <li class="nav-item text-muted  " role="presentation">
                        <button class="pb-2 nav-link" id="pills-offer-resent-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-resent" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Rotational Shifts</button>
                    </li>
                    <li class="mx-4 nav-item text-muted" role="presentation">
                        <button class="pb-2 nav-link" id="pills-offer-holidays-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-holidays" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Holidays</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-offer-pending" role="tabpanel"
                aria-labelledby="pills-offer-pending-tab">

                <div class="card-body">
                    <div class="offer-pending-content">
                        <ManageShift />
                    </div>
                </div>


            </div>
            <div class="tab-pane fade " id="pills-offer-completed" role="tabpanel"
                aria-labelledby="pills-offer-completed-tab">
                <div class="card-body">
                    <div class="my-4 offer-pending-content">
                        <FlexibleShift />
                    </div>

                </div>
            </div>
            <div class="tab-pane fade " id="pills-offer-resent" role="tabpanel" aria-labelledby="pills-offer-resent-tab">
                <div class="card-body">
                    <div class="offer-pending-content">
                        <RotationalShift />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="pills-offer-holidays" role="tabpanel" aria-labelledby="pills-offer-holidays-tab">
                <div class="card-body">
                    <div class="offer-pending-content">
                          <Holidays_Lists />
                        <!-- <Holidays_Master/> -->
                        <!-- <CreateNewHolidaysList/> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <Dialog header="Header" v-model:visible="useAttendanceStore.canShowLoading"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
        :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>
</template>


<script setup>
import { onMounted } from 'vue'
import ManageShift from './ManageShift/ManageShift.vue';
import RotationalShift from './RotationalShift/RotationalShift.vue';
import FlexibleShift from './FlexibleShift/FlexibleShift.vue'
import Holidays_Lists from '../holidays/Holidays_Lists.vue';
import Holidays_Master from '../holidays/Holidays_Master.vue';
import CreateNewHolidaysList from '../holidays/CreateNewHolidaysList.vue';
import { useAttendanceSettingMainStore } from './stores/attendanceSettingMainStore';

const useAttendanceStore = useAttendanceSettingMainStore()



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

.p-dialog .p-dialog-header {
    border-bottom: 0 none;
    background: #ffff;
    color: #495057;
    padding: 1.5rem;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
}

.p-dialog .p-dialog-content {
    background: #ffff;
    color: #495057;
    padding: 0 1.5rem 2rem 1.5rem;
}

.p-dropdown-label.p-inputtext.p-placeholder {
    color: #003056;
}

.p-dropdown .p-dropdown-label.p-placeholder {
    color: #003360;
}

.p-dropdown {
    display: inline-flex;
    cursor: pointer;
    position: relative;
    user-select: none;
    border: 1px solid #003056;
}
</style>

