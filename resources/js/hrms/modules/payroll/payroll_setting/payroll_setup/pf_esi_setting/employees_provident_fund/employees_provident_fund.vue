<template>
    <!-- <div class="flex justify-between mx-5 my-4">
        <div>
        </div>
        <div>
            <button class="mx-4 btn btn-border-orange">Non PF employee</button>
            <button class="btn btn-orange">

                Add new</button>
        </div>
    </div> -->

    <div>
        <p class=" pb-2 box-border mb-[10px] font-['poppins'] font-semibold text-[16px]">PF Employees</p>
    </div>
    <div id="table">
       
        <DataTable :value="usePayroll.epfDetails">
            <Column field="epf_number" header="EPF Number" class="text-[14px] font-normal font-['poppins']"></Column>
            <Column field="deduction_cycle" header="Deduction Cycle" class="text-[14px] font-normal font-['poppins']"></Column>
            <Column field="epf_rule" header="Contribution Rule" class="text-[14px] font-normal font-['poppins']"></Column>
            <Column field="epf_contrib_type" header="Employee/Employer Contribution" class="text-[14px] font-normal font-['poppins']"></Column>
            <Column field="employees_assigned" header="Employees Assigned" class="text-[14px] font-normal font-['poppins']"></Column>
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

    
    <!-- <add_new_employee_provident_fund /> -->
</template>


<script setup>
import { ref, onMounted } from 'vue';
// import add_new_employee_provident_fund from './add_new_employee_provident_fund/add_new_employee_provident_fund.vue';
import { usePayrollMainStore } from '../../../../stores/payrollMainStore';
const usePayroll=usePayrollMainStore()






</script>
