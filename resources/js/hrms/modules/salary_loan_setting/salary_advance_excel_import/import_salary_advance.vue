<template>
    <div class="grid w-10/12 grid-cols-3 mx-auto my-2 place-content-center">
        <div class="flex">
            <label class="p-2 font-semibold border-gray-500 rounded-lg cursor-pointer border-1 fs-6" for="file"><i
                    class="px-2 pi pi-folder" style="font-size: 1rem"></i>Browse</label>
            <input type="file" name="" id="file" hidden @change="useStore.convertExcelIntoArray($event)"
                accept=".xls, .xlsx">
        </div>
        <div class="p-2 mx-6 font-semibold text-black bg-white rounded-lg fs-6">Total Records : <span class="font-bold">
                2324
            </span>
        </div>
        <div class="p-2 mx-6 font-semibold text-black bg-green-100 rounded-lg fs-6">Processed Records : <span
                class="font-bold">
                2342
            </span>
        </div>
        <div class="p-2 mx-6 font-semibold text-black bg-red-100 rounded-lg fs-6">Error Records : <span class="font-bold">
                12313
            </span>
        </div>
    </div>

    <div class="py-5">
        <p class="font-semibold fs-6">Sample format:</p>
        <div class="table-responsive">
        </div>
    </div>

    <div class="table-responsive">
        <p class="font-semibold fs-6">Original data:</p>
        <DataTable class="py-4" :value="useStore.EmployeeSalaryAdvanceSource" tableStyle=" min-width: 50rem"
            responsiveLayout="scroll" stateStorage="session" stateKey="dt-state-demo-session" editMode="cell"
            @cell-edit-complete="onCellEditComplete" :rows="useStore.EmployeeSalaryAdvanceSource">
            <Column v-for="col of  useStore.EmployeeSalaryAdvanceDynamicHeader " :key="col.title" :field="col.title"
                style="min-width: 12rem;" :header="col.title">
                <template #body="{ data, field }">
                    <div v-if="field.includes('Employee Code')">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <div v-else-if="field.includes('Legal Entity')">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <div v-else-if="field.includes('Loan Type')"
                    :class="[useStore.isExistsOrNot(loanTypes,(data[field]).toUpperCase()) ? 'bg-red-100 p-2 rounded-lg' : '']">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <div v-else-if="field.includes('Category')">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <div v-else-if="field.includes('Loan Amount')"
                        :class="[useStore.loanAmount(data[field]) ? 'bg-red-100 p-2 rounded-lg' : '']">

                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <!-- <div v-else-if="field.includes('Repayment Made')">

                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div> -->
                    <div v-else-if="field.includes('Balance')" :class="[useStore.findBalanceAmount(data[field],data['Loan Amount'],data['Repayment Made']) ? 'bg-red-100 p-2 rounded-lg' : '']">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <div v-else-if="field.includes('EMI')" :class="[useStore.findEmiCalculation(data[field],data['Balance'],data['Tenure']) ? 'bg-red-100 p-2 rounded-lg' : '']">
                        <p class="font-semibold fs-6">
                            {{ data[field] ? data[field] : '-' }}
                        </p>
                    </div>
                    <p v-else class="font-semibold fs-6">
                        {{ data[field] ? data[field] : '-' }}
                    </p>
                </template>
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <template #footer>
                <button class="flex justify-center mx-auto btn btn-orange"
                    @click="useStore.uploadOnboardingFile(useStore.EmployeeSalaryAdvanceSource)">Upload</button>
            </template>
        </DataTable>

    </div>
</template>


<script setup>

import { onMounted, onUpdated, ref } from 'vue';
import * as XLSX from 'xlsx';
import axios from 'axios'
import { useImportSalaryAdvance } from './stores/useImportSalaryAdvance.js'

import { Service } from '../../Service/Service';
const service = Service()


const useStore = useImportSalaryAdvance()

const download = () => {
    const data = XLSX.utils.json_to_sheet(sampleTemplate.value)
    const wb = XLSX.utils.book_new()
    XLSX.utils.book_append_sheet(wb, data, 'sheet1')
    XLSX.writeFile(wb, 'QuickOnboarding.xlsx')
}

const getExcelIntoArray = (file) => {
    console.log(service.convertExcelIntoArray(file))
}

const onCellEditComplete = (event) => {
    let { data, newValue, field } = event;

    switch (field) {
        case 'quantity':
        case 'price':
            if (isPositiveInteger(newValue)) data[field] = newValue;
            else event.preventDefault();
            break;

        default:
            if (newValue.trim().length > 0) data[field] = newValue;
            else event.preventDefault();
            break;
    }
};


const loanTypes = ['SALARY ADVANCE','INTEREST FREE LOAN','TRAVEL ADVANCE','INTEREST wITH LOAN']

</script>
