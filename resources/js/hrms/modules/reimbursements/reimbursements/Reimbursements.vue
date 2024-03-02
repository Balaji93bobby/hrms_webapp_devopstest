<template>
    <div id="table">
        <div>
            <div class="card">
                <DataTable ref="dt" :value="employee_service.reimbursement_datas" dataKey="id" :paginator="true" :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll">
                    <Column :exportable="false" style="min-width: 8rem">
                        <template #body="slotProps">
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                @click="confirmDeleteProduct(slotProps.data)" />
                        </template>
                    </Column>
                    <Column header="Claim Type" style="min-width: 8rem">
                        <template #body="slotProps">
                            {{ slotProps.data.claim_type }}
                        </template>
                    </Column>

                    <Column field="" header="Claim Amount" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ "&#x20B9;" + slotProps.data.claim_amount }}
                        </template>
                    </Column>

                    <Column field="" header="Eligible Amount" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template>
                    </Column>

                    <Column field="" header="Remarks" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ slotProps.data.reimbursment_remarks }}
                        </template>
                    </Column>
                    <Column field="" header="Status" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ slotProps.data.eligible_amount }}
                        </template>
                    </Column>
                    <Column field="" header="Date Of Dispatch" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template>
                    </Column>
                    <Column field="" header="Proof Of Delivery" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template>
                    </Column>
                </DataTable>
            </div>

            <Dialog v-model:visible="employee_service.reimbursements_dailog" :style="{ width: '450px' }"
                header="Reimbursement Details" :modal="true" class="p-fluid">
                <div class="field">
                    <label for="name">Claim Type</label>
                    <Dropdown v-model="employee_service.employee_reimbursement.claim_type"
                        :options="employee_service.reimbursement_claim_types" optionLabel="label" optionValue="value"
                        placeholder="Select Claim Type"></Dropdown>
                </div>

                <div class="grid formgrid">
                    <div class="field col">
                        <label for="Claim Amount">Claim Amount</label>
                        <InputNumber v-model="employee_service.employee_reimbursement.claim_amount" mode="currency"
                            currency="INR" locale="en-IN" integeronly />
                    </div>

                    <div class="field col">
                        <label for="Eligible Amount">Eligible Amount</label>
                        <InputNumber v-model="employee_service.employee_reimbursement.eligible_amount" mode="currency"
                            currency="INR" locale="en-IN" integeronly />
                    </div>
                </div>
                <div class="field">
                    <label class="mb-3">Remarks</label>
                    <div class="formgrid">
                        <Textarea v-model="employee_service.employee_reimbursement.reimbursment_remarks
                            " autoResize rows="2" cols="30" />
                    </div>
                </div>
                <div class="field">
                    <label class="mb-3">File Upload</label>
                    <div class="formgrid">
                        <input @change="employee_service.onClaimsDocumentUploaded($event)"
                        ref="employee_service.employee_reimbursement_attachment" type="file" id="upload" hidden />

                        <label id="file_upload" for="upload">Choose file</label>
                    </div>
                </div>

                <template #footer>
                    <Button label="Cancel" icon="pi pi-times" style="height: 30px; color: black" class="p-button-text"
                        @click="employee_service.hideDialog" />
                    <Button label="Save" :disabled="!employee_service.employee_reimbursement.claim_type == '' &&
                            !employee_service.employee_reimbursement.claim_amount == ''
                            ? false
                            : true
                        " icon="pi pi-check" style="height: 30px; background: rgb(255 135 38); color: white"
                        @click="employee_service.saveReimbursementClaimsData()" />
                </template>
            </Dialog>
        </div>
    </div>
</template>


<script setup>

import {employee_reimbursment_service} from  '../stores/EmployeeReimbursementsService'


const employee_service = employee_reimbursment_service();

</script>
