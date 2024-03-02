<template>
           <div class="table-responsive">
            <DataTable ref="dt" dataKey="fs_id" :paginator="true" :rows="10" 
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" editMode="row"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column header="Sections" field="section" style="min-width: 8rem">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 12rem">
                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 12rem">
                    <template #body="slotProps">
                        <!-- {{ slotProps.data }} -->
                        <div v-if="slotProps.data.json_popups_value" class="dec_amt">
                        </div>
                

                    </template>
                    <template #editor="{ data, field }">
                        <InputNumber v-model="data[field]" mode="currency" currency="INR" locale="en-US"
                            class="w-5 text-lg font-semibold" />
                    </template>

                </Column>

                <Column field="status" header="Status" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.json_popups_value">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
            </DataTable>

        </div>
</template>
<script setup>

import {employeeInvestmentMainStore} from '../stores/employeeInvestmentMainStore'

const employeeStore = employeeInvestmentMainStore()

</script>j