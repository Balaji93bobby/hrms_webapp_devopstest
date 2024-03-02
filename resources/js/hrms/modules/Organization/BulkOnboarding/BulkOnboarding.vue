<template>
    <Toast />
    <div class="" v-if="route.params.module == 'bulkOnboarding'">
        <ImportQuickOnboarding />
    </div>
    <Transition name="fade" v-else>
        <div class="h-screen w-full">
            <div class="grid grid-cols-12">
                <div class=" col-span-5 px-2">
                    <p class="font-bold text-2xl">Employee Bulk Onboarding</p>
                    <ul class="list-disc p-2 my-3">
                        <li class="font-semibold fs-6">Download the <a href="/assets/ABSBulkOnboarding.xls"
                                class="font-semibold text-blue-300 cursor-pointer fs-6">Sample</a>
                        </li>
                        <li class="font-semibold fs-6">Fill the information in excel template</li>
                    </ul>
                    <div class="grid grid-cols-12 divide-x-2 divide-gray-600 border-gray-500 rounded-lg border p-2  mr-3">
                        <div @click="openFileInput" class="col-span-3 font-semibold fs-6  cursor-pointer w-full" for="file">
                            <i class="pi pi-folder px-2" style="font-size: 1rem"></i>Browse
                        </div>
                        <span class="col-span-9 px-4">
                            {{ useStore.selectedFile ? useStore.selectedFile.name : '' }}</span>
                    </div>
                    <input ref="fileInput" type="file" name="" id="file" hidden @change="useStore.getExcelForUpload($event)"
                        accept=".xls, .xlsx">
                    <button class="float-right mx-5 mt-6 btn btn-orange"
                        @click="useStore.convertExcelIntoArray('bulk')">Upload</button>
                </div>
                <div class="col-span-7  ">
                    <div class="col-form-label">
                        <!-- <p class="font-semibold fs-4"> Upload Instructions</p> -->
                        <div class="py-2 font-semibold bg-red-100 rounded-lg f-12 alert-warning fs-6"><i
                                class='mx-2 fa fa-warning text-danger'></i>
                            Read these instructions before uploading the file.
                        </div>
                        <div>
                            <ul class="m-4 font-semibold list-disc" style="">
                                <li class="font-semibold fs-6">
                                    The fields Employee Number, Employee Name, Email, Date of Joining, and Location must be
                                    filled in before adding workers.</li>
                                <li class="font-semibold fs-6">
                                    When adding an employee, you must enter your mobile phone
                                    number.</li>
                                <li class="font-semibold fs-6">
                                    To receive all messages, including those about timesheet reminders, leave requests, and
                                    attendance requests, your email address must be current.
                                </li>

                                <li class="font-semibold fs-6">
                                    Each employee's email is different. Therefore, an employee cannot be added to two
                                    organisations using
                                    the same email.</li>

                                <li class="font-semibold fs-6">
                                    Designation is required because, in cases when two or more workers share the same Name,
                                    it will aid in
                                    locating them in People Picker search results. </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <DataTable ref="dt" dataKey="id" :paginator="true" class="mt-3"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column field="Employee" header="Employee's"></Column>
                <Column field="Employee code" header="Month"></Column>
                <Column field="Employee code" header="Date Time"></Column>
                <Column field="Employee code" header="Total Employees Onboarded"></Column>
                <Column field="Employee code" header="Action"></Column>
            </DataTable>
        </div>
    </Transition>

    <Transition name="fade">
        <Dialog header="Header" v-model:visible="useStore.canShowloading"
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
    </Transition>
</template>


<script setup>

import { onMounted, onUpdated, ref } from 'vue';
import ImportQuickOnboarding from '../QuickOnboarding/ImportQuickOnboarding.vue'
import { useRoute } from "vue-router";
import { useOnboardingMainStore } from '../stores/OnboardingMainStore';
import { useNormalOnboardingMainStore } from '../Normal_Onboarding/stores/NormalOnboardingMainStore';


const useStore = useOnboardingMainStore()
const useNormalOnboardingStore = useNormalOnboardingMainStore()


const fileInput = ref(null);

const openFileInput = () => {
    fileInput.value.click();
};




onMounted(() => {
    useStore.getExistingOnboardingDocuments()
    useNormalOnboardingStore.getBasicDeps()
})

onUpdated(() => {

    if (useStore.initialUpdate) {
        useStore.currentlyImportedTableEmployeeCodeValues.splice(0, useStore.currentlyImportedTableEmployeeCodeValues.length)
        useStore.currentlyImportedTableAadharValues.splice(0, useStore.currentlyImportedTableAadharValues.length)
        useStore.currentlyImportedTableMobileNumberValues.splice(0, useStore.currentlyImportedTableMobileNumberValues.length)
        useStore.currentlyImportedTableAccNoValues.splice(0, useStore.currentlyImportedTableAccNoValues.length)
        useStore.currentlyImportedTablePanValues.splice(0, useStore.currentlyImportedTablePanValues.length)
        useStore.currentlyImportedTableEmailValues.splice(0, useStore.currentlyImportedTableEmailValues.length)
    }
})

const route = useRoute();

</script>



<style>
.page-content
{
    padding: calc(20px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>
