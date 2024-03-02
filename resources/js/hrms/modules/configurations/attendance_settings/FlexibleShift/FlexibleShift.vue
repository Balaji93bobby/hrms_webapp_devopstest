<template>
    <div class="card">

        <div class="w-full pr-8">
            <div class="flex row">
                <div class="p-2 mx-4 my-4 rounded-lg bg-red-50 col-8 ">
                    <p><Strong class="text-lg font-semibold text-orange-400">Note:</Strong><span
                            class="mx-2 text-lg font-semibold text-gray-600">Below assigned employees are able to work any
                            shift that the company offers.</span></p>
                </div>
                <div class="col-3">
                    <button class="float-right mx-4 my-4 cursor-pointer btn btn-orange "
                        @click="canShowLoadingScreen = true">
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
            </div>

            <Dialog v-model:visible="canShowLoadingScreen" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                :style="{ width: '100vw', borderTop: '5px solid #002f56' }" :modal="true" :closable="true"
                :closeOnEscape="false">
                <template #header>
                    <div class="flex">
                        <h6 class="mx-2 my-2 modal-title fs-21 ">
                            Assigned To</h6>
                        <div class="p-2.5 mx-2 rounded-lg bg-red-50">
                            <p><Strong class="text-lg">Note:</Strong><span
                                    class="text-lg font-semibold text-gray-600">Flexible Shift employees are able to work
                                    any shift that the company offers.</span></p>
                            <!--  -->
                        </div>
                    </div>
                </template>


                <div class="flex justify-between mx-4">
                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a Department"
                        class="w-full md:w-14rem" />
                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a Designation"
                        class="w-full md:w-14rem" />
                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a Location"
                        class="w-full md:w-14rem" />
                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a State"
                        class="w-full md:w-14rem" />
                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                        placeholder="Select a Legal Entity" class="w-full md:w-14rem" />
                </div>

                <!-- <Calendar id="calendar-timeonly"  timeOnly hourFormat="12" /> -->
                <div class="mx-4">
                    <InputText type="text" v-model="txt_shift_name" placeholder="Search..." class="my-4" />

                    <DataTable :value="att_emp_details" v-model:selection="selectedEmployees" :paginator="true" :rows="2"
                        dataKey="emp_code" :rowsPerPageOptions="[5, 10, 25]"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters"
                        filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
                        <template #empty> No Employee found </template>
                        <template #loading> Loading employee data. Please wait. </template>
                        <Column selectionMode="multiple"></Column>
                        <Column field="emp_code" header="Employee ID" style="min-width: 2rem;">
                            <template #body="slotProps">
                                {{ slotProps.data.emp_code }}
                            </template>

                        </Column>
                        <Column field="employee_name" header="Employee Name" style="min-width: 8rem;">
                            <template #body="slotProps">
                                {{ slotProps.data.employee_name }}
                            </template>

                        </Column>
                        <Column field="designation" header="Designation" style="min-width: 10rem;">
                            <template #body="slotProps">
                                {{ slotProps.data.designation }}
                            </template>

                        </Column>
                        <Column style="min-width: 10rem;" field="department_name" header="Department">
                            <template #body="slotProps">
                                {{ slotProps.data.department_name }}
                            </template>

                        </Column>
                        <Column style="min-width: 10rem;" field="work_location" header="Location">
                            <template #body="slotProps">
                                {{ slotProps.data.work_location }}
                            </template>
                        </Column>
                        <Column style="min-width: 10rem;" field="work_location" header="State">
                            <template #body="slotProps">
                                {{ slotProps.data.work_location }}
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <template #footer>
                    <button class="btn btn-border-primary">Close</button>
                    <button class="btn btn-orange">Save</button>
                </template>
            </Dialog>

        </div>

    </div>

    <!-- <Button label="Show" icon="pi pi-external-link"  @click="openPosition('top')" /> -->
</template>
<script setup>
import { ref, onMounted } from "vue";
import dateFormat, { masks } from "dateformat";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

let att_emp_details = ref();
let canShowConfirmation = ref(false);
let canShowLoadingScreen = ref(false);
let selectedEmployees = ref();
let txt_shift_name = ref();
const confirm = useConfirm();
const toast = useToast();

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    emp_code: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    designation: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    department_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    location: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
});

const loading = ref(true);

let currentlySelectedStatus = null;
let currentlySelectedRowData = null;

onMounted(() => {
    ajax_GetEmployeeDetails();
});

function onClickGetEmployees() {
    console.log(
        "onClickGetEmployees() button clicked : Shift Name :: " + txt_shift_name.value
    );
    console.log("Selected Employees : " + JSON.stringify(selectedEmployees.value));
}

function ajax_GetEmployeeDetails() {
    let url = window.location.origin + "/attendance_settings/fetch-emp-details";

    console.log("AJAX URL : " + url);

    axios.get(url).then((response) => {
        console.log("Axios : " + response.data);
        att_emp_details.value = response.data;
        loading.value = false;
    });
}

function showConfirmDialog() {
    canShowConfirmation.value = true;

    // console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {
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

/*
    Input : Emp array obj
    Output : A 1-D array of emp ids.

*/
function getEmployeeIDsArray() {
    const temp = [];

    _.flatMap(selectedEmployees.value, function (data) {
        temp.push(data.user_id);
    });

    return temp;
    //console.log("Output : "+temp);
}

function saveWorkShiftDetails() {
    hideConfirmDialog(false);

    canShowLoadingScreen.value = true;

    console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));

    //squash all the emp details
    let array_assignedEmp_ids = getEmployeeIDsArray();

    //Shift name
    //Selected employees
    axios
        .post(window.location.origin + "/attendance_settings/save-shiftdetails", {
            selectedEmployees: array_assignedEmp_ids,
            workshift_name: txt_shift_name.value,
        })
        .then((response) => {
            console.log(response);
            ajax_GetEmployeeDetails();

            canShowLoadingScreen.value = false;

            resetVars();
        })
        .catch((error) => {
            canShowLoadingScreen.value = false;
            resetVars();

            console.log(error.toJSON());
        });
}

  // function processApproveReject() {
  //   hideConfirmDialog(false);

  //   canShowLoadingScreen.value = true;

  //   console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));

  //   axios
  //     .post(window.location.origin + "/attendance-approve-rejectleave", {
  //       leave_id: currentlySelectedRowData.id,
  //       status:
  //         currentlySelectedStatus == "Approve"
  //           ? "Approved"
  //           : currentlySelectedStatus == "Reject"
  //           ? "Rejected"
  //           : currentlySelectedStatus,
  //       leave_rejection_text: "",
  //     })
  //     .then((response) => {
  //       console.log(response);
  //       ajax_GetLeaveData();

  //       canShowLoadingScreen.value = false;

  //       resetVars();
  //     })
  //     .catch((error) => {
  //       canShowLoadingScreen.value = false;
  //       resetVars();

  //       console.log(error.toJSON());
  //     });
  // }
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
}</style>
