<template>
    <div>
        <div class="flex flex-col">
            <p class="font-['poppins'] text-[16px] font-semibold">Professional Tax</p>
            <p class="font-['poppins'] text-[16px] font-normal">Each state government levies professional tax on an employee's income, and tax slabs vary across different states.</p>
        </div>
        <div class="my-4" id="table">
            <DataTable :value="usePayroll.protaxDetails">
                <Column field="pt_number" header="PT Number" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="state" header="State" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="location" header="Location" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="employees" header="Employees" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column field="deduction_cycle" header="Deduction Cycle" class="text-[14px] font-normal font-['poppins']"></Column>
                <Column header="PT Slabs" class="text-[14px] font-normal font-['poppins']">
                    <template #body="{data}">
                        <div class="flex justify-center items-center">
                           <button class="text-[#0873CD] flex gap-2">
                            <i class="pi pi-eye "></i>
                            <p class="text-[14px] font-normal font-['poppins']">View Tax Slabs </p>
                           </button>
                        </div>
                    </template>
                </Column>
               </DataTable>
        </div>
        <!-- <div class="flex justify-between" >
           <div>
            <p>Employee Assigned to <strong>Aatmanirbhar Bharat Yojana(ABRY)</strong>Scheme</p>
            <div class="p-2 my-3 bg-red-100 rounded-lg ">
               <p class="text-blue">click here to know more about ABRY Scheme</p>
            </div>
           </div>
      <div>
        <button class="mx-4 btn btn-border-orange">Cancel</button>
        <button class="btn btn-orange">Add new</button>
      </div>
        </div> -->
        <!-- <div id="table">
            <DataTable :value="products" >
                <Column field="product" header="Code"></Column>
                <Column field="lastYearSale" header="Name"></Column>
                <Column field="thisYearSale" header="Category"></Column>
                <Column field="thisYearProfit" header="Quantity"></Column>
            </DataTable>

        </div> -->
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
