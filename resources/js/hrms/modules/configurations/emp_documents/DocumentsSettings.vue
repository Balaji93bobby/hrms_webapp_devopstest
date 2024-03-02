<template>
    <div class="card p-3">

        <h1 class="mt-2 font-semibold text-lg">Documents Settings</h1>

        <div class="my-3">
            <DataTable :value="DocumentSettingsStore.array_emp_documents_details" :paginator="true" :rows="10" dataKey="id"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
               filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">

                <Column headerStyle="width: 3rem"></Column>
                <Column field="document_name" header="Document Name">
                </Column>
                <Column field="is_onboarding_doc" header="Is Onboarding Document ?">
                    <template #body="slotProps">
                        <Checkbox  @change="DocumentSettingsStore.updateDocumentState(slotProps.data)" v-model="slotProps.data.is_onboarding_doc" :binary="true" :trueValue="1" :falseValue="0" />
                    </template>
                </Column>
                <Column field="is_mandatory" header="Is Mandatory Document ?">
                    <template #body="slotProps">
                        <Checkbox @change="DocumentSettingsStore.updateDocumentState(slotProps.data)" v-model="slotProps.data.is_mandatory"  :binary="true" :trueValue="1" :falseValue="0"  />
                    </template>
                </Column>
            </DataTable>

        </div>

        <div class="mx-5 mt-4">
            <button class="btn-orange p-2 rounded float-right" @click="DocumentSettingsStore.submitDocumentSettings">Submit</button>
        </div>


        <!-- show loading -->

        <Dialog header="Header" v-model:visible="DocumentSettingsStore.loading"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
            :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>



    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, reactive, computed } from "vue";
import { useDocumentSettingsStore } from './DocumentsSettingsService';

const DocumentSettingsStore = useDocumentSettingsStore();

const selected = ref();




onMounted(async () => {
   await DocumentSettingsStore.getEmployeesDocumentsDetails();
    // console.log(DocumentSettingsStore.array_emp_documents_details)

});











</script>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,200&display=swap");

.p-dialog-mask .p-component-overlay .p-component-overlay-enter {
    z-index: 0 !important;
}

.p-datatable .p-datatable-thead>tr>th {
    text-align: center;
    padding: 1rem 0.5rem;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    font-weight: 600;
    color: #fff;
    background: #003056;
    transition: box-shadow 0.2s;
    font-size: 13px;

    .p-column-title {
        font-size: 13px;
    }

    .p-column-filter {
        width: 100%;
    }

    #pv_id_2 {
        height: 30px;
    }

    .p-fluid .p-dropdown .p-dropdown-label {
        margin-top: -10px;
    }

    .p-dropdown .p-dropdown-label.p-placeholder {
        margin-top: -12px;
    }

    .p-column-filter-menu-button {
        color: white;
        margin-left: 10px;
    }

    .p-column-filter-menu-button:hover {
        color: white;
        border-color: transparent;
        background: #023e70;
    }
}

.p-column-filter-overlay-menu .p-column-filter-constraint .p-column-filter-matchmode-dropdown {
    margin-bottom: 0.5rem;
    visibility: hidden;
    position: absolute;
}

.p-button .p-component .p-button-sm {
    background-color: #003056;
}

.p-datatable .p-datatable-tbody>tr {
    font-size: 13px;

    .employee_name {
        font-weight: bold;
        font-size: 13.5px;
    }
}

.p-datatable .p-datatable-tbody>tr>td {
    text-align: left;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    padding: 1rem 0.6rem;
}


.pending {
    font-weight: 700;
}

.approved {
    font-weight: 700;
}

.p-button.p-component.p-button-success.Button {
    padding: 8px;
}

.rejected {
    font-weight: 700;
    color: #ff2634;
}

.p-button.p-component.p-button-danger.Button {
    padding: 8px;
}

.p-confirm-dialog-icon.pi.pi-exclamation-triangle {
    color: red;
}

.p-button.p-component.p-confirm-dialog-accept {
    background-color: #003056;
}

.p-button.p-component.p-confirm-dialog-reject.p-button-text {
    color: #003056;
}

.p-column-filter-overlay-menu .p-column-filter-buttonbar {
    padding: 1.25rem;
    position: absolute;
    visibility: hidden;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter-menu-button {
    color: white;
    border-color: transparent;
}

.p-column-filter-menu-button.p-column-filter-menu-button-open {
    background: none;
}

.p-column-filter-menu-button.p-column-filter-menu-button-active {
    background: none;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter {
    width: 55%;
}

/* For Sort */

.p-datatable .p-sortable-column:not(.p-highlight):hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:not(.p-highlight):hover .p-sortable-column-icon {
    color: white;
}

.p-datatable .p-sortable-column.p-highlight {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column.p-highlight:hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:focus {
    box-shadow: none;
    outline: none;
    color: white;
}

.p-datatable .p-sortable-column .p-sortable-column-icon {
    color: white;
}

.pi-sort-amount-down::before {
    content: "\e9a0";
    color: white;
}

.pi-sort-amount-up-alt::before {
    content: "\e9a2";
    color: white;
}
</style>


{

<!--


<template>
    <div class="card flex justify-content-center">
        <Checkbox v-model="checked" :binary="true" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const checked = ref(false);
</script>

 -->

}
