<template>
    <div>
        <div class="table-responsive">
            <DataTable ref="dt" dataKey="fs_id" :paginator="true" :rows="25" :value="investmentStore.reimbursmentSource"
                @row-edit-save="onRowEditSave"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" editMode="row" v-model:editingRows="investmentStore.editingRowSource"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column header="Sections" field="section" style="min-width: 8rem">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 12rem;text-align: left !important;">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.particular == 'Vehicle Reimbursement'">
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                            <div class="flex py-2">
                                <input type="radio" name="Vehicle Reimbursement" id="" style="height: 20px;width: 20px;" :value="slotProps.data.section_option_1"
                                    class="form-check-input" v-model="slotProps.data.select_option" :checked="slotProps.data.section_option_1 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_1 }}</p>
                            </div>
                            <div class="flex py-2">
                                <input type="radio" name="Vehicle Reimbursement" id="" style="height: 20px;width: 20px;" :value="slotProps.data.section_option_2"
                                    class="form-check-input" v-model="slotProps.data.select_option" :checked="slotProps.data.section_option_2 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_2 }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                        </div>
                    </template>
                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="max_amount" header="Max Limit" style="min-width: 12rem"></Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 15rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.dec_amount" class="dec_amt">
                            {{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                        </div>
                        <div v-else-if="slotProps.data.particular == 'Vehicle Reimbursement'">
                            <div v-if="slotProps.data.selected_section_options">
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}</p>
                            </div>
                            <div v-else-if="slotProps.data.select_option">
                                <InputNumber class="mx-auto text-lg font-semibold w-7" v-model="slotProps.data.dec_amt"
                                @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted"/>
                            </div>
                            <div v-else>
                                <p style="font-weight: 501;">--</p>
                            </div>
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
                            <!-- <Tag value="Pending" severity="warning" /> -->
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
                <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center" header="Action"  v-if="investmentStore.isSubmitted">
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
import LoadingSpinner from '../../../../../components/LoadingSpinner.vue'

const investmentStore = investmentMainStore()

const editingRows = ref([]);

const onRowEditSave = (event) => {
    let { newData, index } = event;
    investmentStore.reimbursmentSource[index] = newData;
    investmentStore.updatedRowSource = newData;
    investmentStore.getFormId = 1
    var data = {
        fs_id: newData.fs_id,
        declaration_amount: newData.dec_amount,
        select_option: newData.select_option
    }

    investmentStore.formDataSource.push(data)
    console.log(newData);
};


</script>
