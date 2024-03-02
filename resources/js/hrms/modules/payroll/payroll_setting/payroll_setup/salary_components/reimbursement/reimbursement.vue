<template>
    <div class="w-full ">
        <!-- <section id="header" class="flex justify-between w-full my-4 ">
            <p class="mx-1 font-semibold fs-5.5">Salary Components</p>
            <div><button class="btn btn-orange  whitespace-nowrap" @click="dailogReimbursementComponents = true"><i class="pi pi-plus mx-1" style="font-size: 0.8rem"></i>Add Components</button></div>
        </section> -->
        <!-- {{ usePayroll.reimDetails }} -->
        <DataTable :value="usePayroll.reimDetails">
            <Column field="comp_name" header="Name"></Column>
            <!-- <Column field="is_taxable" header="Tax Status">
                <template #body="{ data }">
                    <p>{{ helper.findIsSelected(data.is_taxable) }}</p>
                </template>
            </Column> -->
            <Column field="reimburst_max_limit" header="Maximum Limit"></Column>
            <Column field="enabled_status" header="Status">
                <template #body="{data}">
                    <div v-if="data.enabled_status">
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Enabled</span>
                    </div>
                    <div v-else>
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">Disabled</span>
                    </div>
                </template>
            </Column>
            <Column  header="Actions">
                <template #body="{data}">
                    <i @click="usePayroll.editAdhocSalaryComponents(data,4),dailogReimbursementComponents = true" class="pi pi-pencil cursor-pointer" style="font-size: 1rem"></i>
                    <i class="pi pi-trash mx-3 cursor-pointer" style="font-size: 1rem"></i>
                </template>
            </Column>
        </DataTable>
        
    </div>

    <!-- <Dialog v-model:visible="dailogReimbursementComponents" :modal="true" :closable="true"
        :style="{ width: '30vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Add New Reimbursement Components</span>
        </template>
        <div class="">
            <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Name</label>
            <InputText class="w-full" placeholder="Enter name" v-model="usePayroll.reimbursementComponents.comp_name" />
        </div>
        <div class="my-4">
            <p class="block mb-2 font-semibold fs-6 text-gray-700 ">Does this have tax status</p>
            <div class="form-check form-check-inline my-2">
                <input v-model="usePayroll.reimbursementComponents.is_taxable" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="1" />
                <label class="form-check-label leave_type ms-2" for="full_day">Yes</label>
            </div>
            <div class="form-check form-check-inline mx-7">
                <input v-model="usePayroll.reimbursementComponents.is_taxable" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="0" />
                <label class="form-check-label leave_type ms-2" for="full_day">No</label>
            </div>
        </div>
        <div class="float-right">
            <div class="flex">
                <button @click="dailogReimbursementComponents = false" class="btn btn-orange-outline">Cancel</button>
                <button @click="usePayroll.saveNewSalaryComponent(4),dailogReimbursementComponents = false" class="btn btn-orange mx-2">Add</button>
            </div>
        </div>
    </Dialog> -->
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePayrollMainStore } from '../../../../stores/payrollMainStore';
import {usePayrollHelper} from '../../../../stores/payrollHelper';

const usePayroll = usePayrollMainStore()
const helper = usePayrollHelper()
const dailogReimbursementComponents = ref(false)


</script>


<style scoped></style>
