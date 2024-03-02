<template>
    <div>
        <div class="flex justify-between mx-5 my-4">
        <div>
        </div>
        <!-- <div>
            <button class="btn btn-orange">Add new</button>
        </div> -->
    </div>
        <div id="table">
            <DataTable :value="usePayroll.esiDetails" >
                <Column field="esi_number" header="ESI Number" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="state" header="State" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="location" header="Location" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="deduction_cycle" header="Deduction Cycle" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="employees_assigned" header="Employees Assigned">
                    </Column>
                    <Column field="status" header="Status" class="text-[14px] font-normal font-['poppins']">
                        <template #body="{data}">
                            <div v-if="data.status">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Enabled</span>
                            </div>
                            <div v-else>
                                <span
                                    class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">Disabled</span>
                            </div>
                        </template>
                    </Column>
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
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { usePayrollMainStore } from '../../../../stores/payrollMainStore';
const usePayroll=usePayrollMainStore()
// const products = ref([
//     {product: 'Bamboo Watch', lastYearSale: 51, thisYearSale: 40, lastYearProfit: 54406, thisYearProfit: 43342},
//     {product: 'Black Watch', lastYearSale: 83, thisYearSale: 9, lastYearProfit: 423132, thisYearProfit: 312122},
//     {product: 'Blue Band', lastYearSale: 38, thisYearSale: 5, lastYearProfit: 12321, thisYearProfit: 8500},
//     {product: 'Blue T-Shirt', lastYearSale: 49, thisYearSale: 22, lastYearProfit: 745232, thisYearProfit: 65323},
//     {product: 'Brown Purse', lastYearSale: 17, thisYearSale: 79, lastYearProfit: 643242, thisYearProfit: 500332},
//     {product: 'Chakra Bracelet', lastYearSale: 52, thisYearSale:  65, lastYearProfit: 421132, thisYearProfit: 150005},
//     {product: 'Galaxy Earrings', lastYearSale: 82, thisYearSale: 12, lastYearProfit: 131211, thisYearProfit: 100214},
//     {product: 'Game Controller', lastYearSale: 44, thisYearSale: 45, lastYearProfit: 66442, thisYearProfit: 53322},
//     {product: 'Gaming Set', lastYearSale: 90, thisYearSale: 56, lastYearProfit: 765442, thisYearProfit: 296232},
//     {product: 'Gold Phone Case', lastYearSale: 75, thisYearSale: 54, lastYearProfit: 21212, thisYearProfit: 12533}
// ]);




</script>
