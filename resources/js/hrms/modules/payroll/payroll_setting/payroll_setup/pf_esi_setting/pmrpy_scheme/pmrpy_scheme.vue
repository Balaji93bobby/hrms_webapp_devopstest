<template>
    <div>
        <div class="flex flex-col">
            <p class="font-['poppins'] text-[16px] font-semibold">Labor Welfare Fund</p>
            <p class="font-['poppins'] text-[16px] font-normal">The Labour Welfare Fund Act provides social security and enhanced working conditions for employees earning a monthly salary of Rs. 15,000 or less.</p>
        </div>
        <!-- <div class="flex justify-between">
            <div>
                <p>Employee Assigned to <strong>Pradhan Matri Rojgar Protsahan Yojana(PMRPY)</strong>Scheme</p>
                <div class="p-2 my-3 bg-red-100 rounded-lg">
                    <p class="text-blue">click here to know more about PMRPY Scheme</p>
                </div>
            </div>
            <div>
                <button class="mx-4 btn btn-border-orange">Cancel</button>
                <button class="btn btn-orange">Add new</button>
            </div>
        </div> -->
        <div id="table" class="my-4">
            <DataTable :value="usePayroll.labourwelfareDetails">
                <Column field="employees_contribution" header="Employees Contribution"  class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="employers_contribution" header="Employers Contribution"  class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="deduction_cycle" header="Deduction Cycle"  class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="employees" header="Empolyees"  class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="status" header="Status" class="text-[14px] font-normal font-['poppins']">
                    <template #body="{data}">
                        <div v-if="data.status">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Active</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">Deactivate</span>
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




</script>
