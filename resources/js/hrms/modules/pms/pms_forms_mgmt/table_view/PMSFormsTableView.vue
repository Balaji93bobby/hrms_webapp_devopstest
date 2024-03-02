<template>
    <div>
        <Toast />

        <Dialog header="Header" v-model:visible="canShowLoadingScreen" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>

        <Dialog header="PMS Form Usage details" v-model:visible="canShowPMSFormUsage_Dialog"
            :breakpoints="{ '960px': '75vw', '800px': '90vw' }" :style="{ width: '980px' }" :modal="true">
            <!-- <div v-if="pmsFormsMgmtStore.array_pms_forms_usage_details" -->
            <div class="confirmation-content d-flex justify-content-start align-items-center mt-3 ml-3">
                <DataTable :value="pmsFormsMgmtStore.array_pms_forms_usage_details.data" tableStyle="min-width: 70rem">
                    <Column header="Calendar Type/Year" style="width: 20%">
                        <template #body="slotProps">
                            <span><b>{{ slotProps.data.abbrevation }} :
                                    {{ dayjs(slotProps.data.start_date).format("YYYY") }} -
                                    {{ dayjs(slotProps.data.end_date).format("YYYY") }}</b></span>
                        </template>
                    </Column>
                    <Column field="assignment_period" header="Period" style="width: 5%">
                        <template #body="slotProps">
                            <div>
                                <span><b>{{ slotProps.data.assignment_period.toUpperCase() }}</b></span>
                            </div>
                        </template>
                    </Column>
                    <Column field="assignee_name" header="Assignee Name"></Column>
                    <Column field="reviewer_name" header="Reviewer Name"></Column>
                    <Column field="assigner_name" header="Assigner Name"></Column>
                    <!-- "assignment_period": "q3",
                    "abbrevation": "FY","start_date": "2022-04-01", "end_date": "2023-03-31",
                    "assignee_name": "SUJATHA ALAGUSELVAM",
                    "reviewer_name": "S.AMIRTHAVALLI",
                    "assigner_name": "S2 Admin" -->
                </DataTable>
            </div>
            <template #footer> </template>
        </Dialog>

        <Dialog header="PMS Form Template details" maximizable modal :contentStyle="{ height: '600px' }"
            v-model:visible="canShowPMSFormTemplate_Dialog" :breakpoints="{ '1000px': '25vw', '800px': '90vw' }"
            :style="{ width: '1200px' }" :modal="true">
            <!-- <div v-if="pmsFormsMgmtStore.array_pms_forms_usage_details" -->

            <div class="confirmation-content d-flex justify-content-center align-items-center mt-3 ml-3">
                <DataTable :value="pmsFormsMgmtStore.pms_form_template_details.data" scrollable scrollHeight="400px"
                    tableStyle="min-width: 90rem">
                    <template #header>
                        <span><b>Form Name : </b>
                            {{ pmsFormsMgmtStore.pms_form_template_details.data[0].form_name }}</span>
                    </template>
                    <Column v-for="col of availableTableColumns_PMSTemplateDetails" :key="col.field" :field="col.field"
                        style="width: 25%" :header="col.header"></Column>
                </DataTable>
            </div>
            <template #footer>
                <div>
                    <Button severity="success" label="Download as Excel" class="btn btn-orange" style="height: 2em"
                        raised />
                </div>
            </template>
        </Dialog>

        <div>
            <DataTable :value="pmsFormsMgmtStore.array_pms_forms_authors_list" @rowExpand="onRowExpand"
                @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows" :paginator="true" :rows="10"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                :rowsPerPageOptions="[5, 10, 25]" :loading="canShowLoadingScreen">
                <template #empty> No PMS forms found.</template>
                <template #loading> Loading data. Please wait. </template>
                <Column :expander="true" />
                <template #groupheader="slotProps">
                    <span class="vertical-align-middle ml-2 font-bold line-height-3">{{
                        slotProps.data[0]
                    }}</span>
                </template>
                <Column header="Author Name">
                    <template #body="slotProps">
                        {{ slotProps.data[0] }}
                    </template>
                </Column>
                <template #expansion="slotProps">
                    <div>
                        <DataTable :value="slotProps.data[1]" responsiveLayout="scroll" scrollable scrollHeight="400px">
                            <Column header="Form Name" sortable>
                                <template #body="slotProps">
                                    <p style="white-space: nowrap">{{ slotProps.data.form_name }}</p>
                                </template>
                            </Column>
                            <Column header="Form Assignment Details" sortable>
                                <template #body="slotProps">
                                    <div v-if="slotProps.data.is_pmsform_used == 1">
                                        <Button label="View" @click="getPMSFormUsageDetails(slotProps.data)"
                                            class="btn btn-orange" style="height: 2em" raised />
                                    </div>
                                    <div v-else>
                                        {{ "Not Assigned" }}
                                    </div>
                                </template>
                            </Column>
                            <Column header="Actions" sortable>
                                <template #body="slotProps">
                                    <Button severity="success" label="View Form"
                                        @click="showPMSFormTemplateDetails(slotProps.data)" class="btn btn-orange"
                                        style="height: 2em" raised />
                                    <!-- <Button  severity="success" label="Download as Excel" class="btn btn-orange " style="height: 2em" raised /> -->
                                </template>
                            </Column>
                            <!-- </div> -->
                        </DataTable>
                    </div>
                </template>
            </DataTable>

            <!-- <Column class="font-bold" field="emp_name" header="Employee Name">
            <template #body="slotProps"> {{ slotProps.data.emp_name }} </template>
            <template #filter="{ filterModel, filterCallback }">
              <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search" class="p-column-filter"
                :showClear="true" />
            </template>
          </Column>
          <Column field="emp_code" header="Employee Code">
            <template #filter="{ filterModel, filterCallback }">
              <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search" class="p-column-filter"
                :showClear="true" />
            </template>
          </Column> -->
            <!-- <Column field="emp_designation" header="Designation" style="min-width: 15rem;"></Column> -->
            <!-- <Column field="doj" header="DOJ"  style="min-width: 10rem;">
            <template #body="slotProps">{{ dayjs(slotProps.data.doj).format('DD-MMM-YYYY') }}</template>
          </Column> -->
            <!-- <Column field="enc_user_id" header="View Profile">
            <template #body="slotProps">
              <Button icon="pi pi-eye" severity="success" label="View" @click="openProfilePage(slotProps.data)" class="btn btn-orange " style="height: 2em" raised />
            </template>
          </Column> -->
        </div>
    </div>
</template>
<script setup>
import dayjs from "dayjs";

import { ref, onMounted } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";

import { usePMSFormsMgmtStore } from "../PMSFormsMgmtService";
import { useToast } from "primevue/usetoast";

const pmsFormsMgmtStore = usePMSFormsMgmtStore();
const expandedRows = ref([]);
const toast = useToast();

let canShowLoadingScreen = ref(true);
let canShowPMSFormUsage_Dialog = ref(false);
let canShowPMSFormTemplate_Dialog = ref(false);
let availableTableColumns_PMSTemplateDetails = ref();

onMounted(async () => {
    await pmsFormsMgmtStore.getAllPMSFormAuthors();
    canShowLoadingScreen.value = false;
});

async function getPMSFormUsageDetails(row_data) {
    console.log("Getting PMS Form Usage details for ID : " + row_data.pms_form_id);
    //canShowLoadingScreen.value = true;

    await pmsFormsMgmtStore.getPMSFormUsageDetails(row_data.pms_form_id);

    //console.log("Test response : "+JSON.stringify(pmsFormsMgmtStore.array_pms_forms_usage_details));
    if (
        pmsFormsMgmtStore.array_pms_forms_usage_details != null &&
        pmsFormsMgmtStore.array_pms_forms_usage_details.status == "success"
    ) {
        canShowPMSFormUsage_Dialog.value = true;
    } else {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: "Unable to fetch the requested details",
            life: 3000,
        });
    }

    //canShowLoadingScreen.value = false;
}

/*
    Show the selected PMS form in popup view
 */
async function showPMSFormTemplateDetails(row_data) {
    console.log("Getting PMS Form Template details for ID : " + row_data.pms_form_id);

    await pmsFormsMgmtStore.getPMSFormTemplateDetails(row_data.pms_form_id);

    //console.log("Test response : "+JSON.stringify(pmsFormsMgmtStore.array_pms_forms_usage_details));
    if (
        pmsFormsMgmtStore.pms_form_template_details != null &&
        pmsFormsMgmtStore.pms_form_template_details.status == "success"
    ) {
        //Get the columns that are to be shown
        availableTableColumns_PMSTemplateDetails.value =
            pmsFormsMgmtStore.pms_form_template_details.data.available_columns_primevue;

        canShowPMSFormTemplate_Dialog.value = true;
    } else {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: "Unable to fetch the requested details",
            life: 3000,
        });
    }
}

function canHideColumn() {
    return false;
}
</script>
