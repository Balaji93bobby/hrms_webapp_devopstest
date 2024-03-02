
<!--
    Columns :
    Emp code, emp name, onboarding form status, Action (Edit, Delete)
-->

<template>
    <div class="mt-30">
        <h1 class="fs-4 fw-bold mb-4"> Onboarding Form management</h1>
        <div class="card">
            <DataTable :value="OnboardingFromService.array_OnboardingFromDetails" :paginator="true" :rows="10" dataKey="id"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
            v-model:filters="filters" filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
                <Column field="emp_code" header="Employee Code"></Column>
                <Column field="emp_name" header="Employee Name"></Column>
                <Column field="onboarding_status" header="Onboarding Status"></Column>
                <Column field="action" header="Action">
                    <template #body="slotProps">
                        <Button class="btn-primary mr-2 p-2" icon="pi  pi-pencil" style="" label="Edit"
                            @click="OnboardingFromService.EditOnboardingFormDetails(slotProps.data.id)" />
                        <Button class="btn-orange p-2 " icon="pi pi-delete-left" label="Delete" @click="showConfirmationDialog(slotProps.data.id)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- Delete dialog box -->
        <Dialog header="Confirmation" v-model:visible="show_dialogconfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content text-center">

                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to delete Onboarding from details ?</span>
            </div>

            <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

                <Button class="btn-primary mr-3 py-2" label="Yes" icon="pi pi-check" @click="send_Delete_Request(selected_Id)"
                    autofocus />

                <Button label="No" icon="pi pi-times" @click="show_dialogconfirmation = false" class="p-button-text py-2"
                    autofocus />

            </div>

        </Dialog>

        <Dialog header="Header" v-model:visible="OnboardingFromService.loading"
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
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { UseOnboardingFromService } from './OnboardingFormMgmtService'

const OnboardingFromService = UseOnboardingFromService();

onMounted(() => {
    OnboardingFromService.getOnboardingFormDetails()
});

const show_dialogconfirmation =ref(false);
const selected_Id = ref();

 function  showConfirmationDialog(selected_table_id) {
    selected_Id.value = selected_table_id;
    console.log(" selected_id : ", selected_Id.value);
    show_dialogconfirmation.value = true;

 }

 async function send_Delete_Request(selected_Id){
    // await
    await OnboardingFromService.DeleteOnboardingFormDetails(selected_Id);

 }




</script>
