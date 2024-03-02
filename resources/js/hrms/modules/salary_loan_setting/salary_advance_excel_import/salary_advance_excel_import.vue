<template>
    <Toast />
    <!-- v-if="route.params.module == null" -->
    <Transition name="fade" v-if="false">
        <div class="w-full h-screen">
            <div class="grid grid-cols-12">
                <div class="col-span-5 px-2">
                    <p class="text-2xl font-bold">Employee Quick Onboarding</p>
                    <ul class="p-2 my-3 list-disc">
                        <li class="font-semibold fs-6">Download the <a href="/assets//ABSQuickOnboarding.xlsx"
                                class="font-semibold text-blue-300 cursor-pointer fs-6">Sample</a>
                        </li>
                        <li class="font-semibold fs-6">Fill the information in excel template</li>
                    </ul>
                    <div class="grid grid-cols-12 p-2 mr-3 border border-gray-500 divide-x-2 divide-gray-600 rounded-lg">
                        <div @click="openFileInput" class="w-full col-span-3 font-semibold cursor-pointer fs-6" for="file">
                            <i class="px-2 pi pi-folder" style="font-size: 1rem"></i>Browse
                        </div>
                        <span class="col-span-9 px-4">
                            {{ useStore.selectedFile ? useStore.selectedFile.name : '' }}</span>
                    </div>
                    <input ref="fileInput" type="file" name="" id="file" hidden @change="useStore.getExcelForUpload($event)"
                        accept=".xls, .xlsx">
                    <button class="float-right mx-5 mt-4 btn btn-orange"
                        @click="useStore.convertExcelIntoArray('quick')">Upload</button>
                </div>
                <div class="col-span-7">
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
            <button class="flex justify-center mx-auto btn btn-orange">Upload</button>

        </div>

    </Transition>
    <!-- <div class="" v-else>
         <ImportQuickOnboarding />
    </div> -->
    <!-- <Transition name="fade" mode="out-in">
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
    </Transition> -->
    <importSalaryAdvance />
</template>


<script setup>

import { onMounted, onUpdated, ref } from 'vue';
import { useRoute } from "vue-router";
// import { useOnboardingMainStore } from '../stores/OnboardingMainStore'
import { useImportSalaryAdvance } from './stores/useImportSalaryAdvance';
import { Service } from '../../Service/Service';

import importSalaryAdvance from './import_salary_advance.vue'



const useStore = useImportSalaryAdvance()
const service = Service()
// const useNormalOnboardingStore = useSalaryAdvanceMainStore()



const fileInput = ref(null);

const openFileInput = () => {
    fileInput.value.click();
};



const route = useRoute();

</script>

<style>
.page-content
{
    padding: calc(20px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>

<style scoped>
.fade-enter-active,
.fade-leave-active
{
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to
{
    opacity: 0;
}
</style>
