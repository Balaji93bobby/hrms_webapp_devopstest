<template>
    <div>
        <!-- {{ investmentStore.previousEmployeerIncomeSource }} -->
        <div class="table-responsive">
            <DataTable resizableColumns columnResizeMode="expand" ref="dt" dataKey="fs_id" :paginator="true" :rows="10"
                :value="investmentStore.previousEmployeerIncomeSource" @row-edit-save="onRowEditSave"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" editMode="row" v-model:editingRows="investmentStore.editingRowSource"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column header="Sections" field="section" style="min-width: 8rem">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 12rem;text-align: left !important;">
                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 15rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.dec_amount" class="dec_amt">
                            {{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                        </div>
                        <div v-else>
                            <InputNumber class="text-lg font-semibold w-28" v-model="slotProps.data.dec_amt"
                                @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted"/>
                        </div>

                    </template>
                    <template #editor="{ data, field }">
                        <InputNumber v-model="data[field]" mode="currency" currency="INR" locale="en-US"
                            class="text-lg font-semibold w-28" :readonly="!investmentStore.isSubmitted"/>
                    </template>

                </Column>
                <Column field="Status" header="Status" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.dec_amount">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
                <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center" header="Action" v-if="investmentStore.isSubmitted" >
                </Column>
            </DataTable>

        </div>

        <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
                @click="investmentStore.investment_exemption_steps--">Previous</button>
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
                @click="investmentStore.saveFormData">Save</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="investmentStore.investment_exemption_steps++">Next</button>
        </div>
    </div>
</template>


<script setup>
import { ref } from "vue";
import { investmentMainStore } from "../../../stores/investmentMainStore";

const investmentStore = investmentMainStore()

const editingRows = ref([]);

const onRowEditSave = (event) => {
    let { newData, index } = event;
    investmentStore.previousEmployeerIncomeSource[index] = newData;
    investmentStore.updatedRowSource = newData;
    investmentStore.getFormId = 1
    var data = {
        fs_id: newData.fs_id,
        declaration_amount: newData.dec_amount,
    }

        investmentStore.formDataSource.push(data)
     console.log(newData);
};


</script>
