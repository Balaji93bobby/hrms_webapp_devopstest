<template>
    <div >
        <div class="flex justify-between mx-1">
            <div class="flex flex-col">
                <p class=" pb-2 box-border mb-[10px] font-['poppins'] font-semibold text-[16px]">Non-PF Employees</p>
                <p  class=" pb-2 box-border mb-[7px] font-['poppins'] font-medium text-[14px]">Once payroll processing begins, employees assigned to the Gross - HRA *12% or restricted PF wage calculation method cannot be switched to a Non-PF employee status, but the reverse is possible.</p>
                <!-- <div class="row my-3">
                    <div class="col d-flex justify-content-between align-items-center">
                        <div class="w-9 p-2 rounded-lg " style="background-color: #FFF1F1;">
                            <p class="text-blue"><strong class=" text-yellow-600">Note:</strong> Once payroll processing
                                begins employees asigned to
                                the
                                Gross - HRA * 12% or restricted PF wage calculation Method cannot be swtiched to a non-pf
                                employee status, nut the reverse is possible
                            </p>
                        </div>
                        <div class="mx-4 ">
                            <button class="mx-4 btn btn-border-orange shadow-sm px-4">Cancel</button>
                            <button class="btn btn-orange shadow-sm px-4" @click="AddMore">Add More</button>
                        </div>

                    </div>
                </div> -->
            </div>

        </div>
        <div id="table">
            <DataTable :value="usePayroll.nonepfDetails">
                <Column field="name" header="Empolyee"></Column>
                <Column field="designation" header="Designation"></Column>
                <Column field="department_name" header="Department"></Column>
                <Column field="work_location" header="Location"></Column>
                <Column field="" header="State"></Column>
                <Column field="" header="Branch"></Column>
                <Column field="client_fullname" header="Legal Entity"></Column>
                <Column field="action" header="Action">
                    <template #body="{ data}">
                       
                        <div>
                          <button> <i class="pi pi-ellipsis-v"></i></button>
                         
                        </div>
                    </template>
                </Column>
         
            </DataTable>
        </div>
        
    
    </div>
    
    <Dialog v-model:visible="CanShowDialog" :modal="true" :closable="true"
        :style="{ width: '95vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold text-indigo-950 pl-3">Assign To</span>

            <div style="background-color: #FFF1F1;" class="p-2 shadow-sm d-flex align-items-center rounded">
                <strong class=" text-yellow-600 fw-semibold mr-1" >Note:</strong>
                <p>Once the payroll processing beings Employees assigned to the Gross -HRA *12% calculation method cannot be
                    switched to the restricted PF wage calculation method, but the reverse is possible.</p>
            </div>
        </template>
        <div class=" col-12">
            <div class="row ">
                <div class="col-12">

                    <div class="col-12">
                        <div class="px-2 row">
                            <div class="col">
                                <div style="padding: 10px"
                                    class="border rounded d-flex justify-content-start align-items-center border-color">
                                    <input type="checkbox" class="mr-3" style="width: 20px; height: 20px" />
                                    <h1>Clear Filters</h1>
                                </div>
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt" editable optionLabel="name" optionValue="id"
                                    placeholder="Department" class="w-full text-red-500 md: border-color" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt1" editable optionLabel="designation" optionValue="designation"
                                    placeholder="Designation" class="w-full text-red-500 md: border-color" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt2" editable optionLabel="work_location" optionValue="work_location"
                                    placeholder="Location" class="w-full text-red-500 md: border-color" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt3" editable optionLabel="state_name" optionValue="id"
                                    placeholder="State" class="w-full text-red-500 md: border-color" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt5" editable optionLabel="client_name" optionValue="id"
                                    placeholder="Legal Entity" class="w-full text-red-500 md: border-color" />
                            </div>
                        </div>
                    </div>

                    <div class=" ml-3">
                        <span class="p-input-icon-left ">
                            <i class="pi pi-search" />
                            <InputText placeholder="Search" v-model="filters['global'].value" class="border-color "
                                style="height: 3em" />
                        </span>

                    </div>

                </div>
            </div>

            <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column selectionMode="multiple" headerStyle="width: 1.5rem"></Column>
                <Column field="user_code" header="Employee Name" style="min-width: 8rem"></Column>
                <Column field="name" header="Employee Name" style="min-width: 12rem"></Column>
                <Column field="department_name" header="Department " style="min-width: 12rem"></Column>
                <Column field="designation" header="Designation " style="min-width: 20rem"></Column>
                <Column field="work_location" header="Location " style="min-width: 12rem"></Column>
                <Column field="client_name" header="Legal Entity" style="min-width: 20rem"></Column>
            </DataTable>
        </div>
        <div class="float-right my-4">
            <div class="flex">
                <button @click=" assignEmployee = false" class="btn text-blue-900 fs-6 fw-semibold btn-orange-outline px-5 " style="border:2px solid #362F78">Cancel</button>
                <button class="btn bg-blue-900 mx-2 text-white px-5 fs-5" @click=" assignEmployee = false">Assign</button>
            </div>
        </div>
    </Dialog>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { usePayrollMainStore } from '../../../../../stores/payrollMainStore';
const usePayroll=usePayrollMainStore()
const products = ref([
    { product: 'Bamboo Watch', lastYearSale: 51, thisYearSale: 40, lastYearProfit: 54406, thisYearProfit: 43342 },
    { product: 'Black Watch', lastYearSale: 83, thisYearSale: 9, lastYearProfit: 423132, thisYearProfit: 312122 },
    { product: 'Blue Band', lastYearSale: 38, thisYearSale: 5, lastYearProfit: 12321, thisYearProfit: 8500 },
    { product: 'Blue T-Shirt', lastYearSale: 49, thisYearSale: 22, lastYearProfit: 745232, thisYearProfit: 65323 },
    { product: 'Brown Purse', lastYearSale: 17, thisYearSale: 79, lastYearProfit: 643242, thisYearProfit: 500332 },
    { product: 'Chakra Bracelet', lastYearSale: 52, thisYearSale: 65, lastYearProfit: 421132, thisYearProfit: 150005 },
    { product: 'Galaxy Earrings', lastYearSale: 82, thisYearSale: 12, lastYearProfit: 131211, thisYearProfit: 100214 },
    { product: 'Game Controller', lastYearSale: 44, thisYearSale: 45, lastYearProfit: 66442, thisYearProfit: 53322 },
    { product: 'Gaming Set', lastYearSale: 90, thisYearSale: 56, lastYearProfit: 765442, thisYearProfit: 296232 },
    { product: 'Gold Phone Case', lastYearSale: 75, thisYearSale: 54, lastYearProfit: 21212, thisYearProfit: 12533 }
]);
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const CanShowDialog = ref(false);

function AddMore() {
    CanShowDialog.value = true;
}




</script>
