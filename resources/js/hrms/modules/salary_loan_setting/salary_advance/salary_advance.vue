<template>

    <div class="px-1">
        <div class="row d-flex justify-content-start align-items-center">
            <div class="d-flex " v-if="salaryStore.create_new_from == '1'">
                <div class="text-center col-3 d-flex align-items-center justify-content-start"  style="">
                    <h1 class="text-xl xl:text-2xl ">Salary Advance Feature</h1>
                </div>
                <div class="col">
                    <button class="orange_btn"
                        :class="[salaryStore.isSalaryAdvanceFeatureEnabled === 1 ? 'bg-white text-black border-[1px] border-black' : 'text-white']"
                        @click="salaryStore.isSalaryAdvanceFeatureEnabled = 0">Disabled</button>
                    <button class="Enable_btn"
                        :class="[salaryStore.isSalaryAdvanceFeatureEnabled === 1 ? 'bg-green-700 text-white' : '']"
                        @click="salaryStore.isSalaryAdvanceFeatureEnabled = 1">Enable</button>
                </div>
                <div class="col">
                    <button @click="salaryStore.create_new_from = 2" v-if="salaryStore.create_new_from == '1'"
                        class="float-right px-4 py-2 text-white bg-blue-800 rounded-md ">
                        <i class="mx-1 pi pi-plus"></i> Create New From
                    </button>
                </div>
            </div>
            <div class="col" v-if="salaryStore.create_new_from == '1'">
                <div>
                    <p class="fs-5"
                        v-if="salaryStore.isSalaryAdvanceFeatureEnabled == '0' || salaryStore.isSalaryAdvanceFeatureEnabled == null">
                        Please click the "Enable" button
                        to activate the salary advance feature for use within
                        your
                        organization.</p>
                </div>
            </div>
            <p class="fs-5" v-if="salaryStore.isSalaryAdvanceFeatureEnabled == '1' && salaryStore.create_new_from == '1'">
                Please click the "Disable" button to deactivate the salary advance feature.</p>

            <!-- active from details -->
            <div class="" v-if="salaryStore.create_new_from == '1' && salaryStore.isSalaryAdvanceFeatureEnabled == '1'">
                <div class="row d-flex justify-items-center align-items-center">
                    <div class="col-3">
                        <h1 class="fs-4 ">Select organization</h1>
                    </div>

                    <div class="col">
                        <!-- v-model="salaryStore.sa.selectClientID" -->
                        <!-- {{ salaryStore.client_name_status }} -->
                        <MultiSelect v-model="salaryStore.client_name_status" :options="salaryStore.ClientsName"
                            optionLabel="client_name" :trueValue="1" :falseValue="0" optionValue="id"
                            placeholder="Select Branches" :maxSelectedLabels="3" class=""
                            @change="selectClientId('sal_adv')" />
                    </div>
                </div>
                <div class="mt-2 ml-1 mr-3 row ">
                    <div class="p-3 mb-2 rounded-md shadow-sm col-12 border-1 h-28 d-flex flex-column align-items-center justify-content-between even-card blink"
                        v-for="(item, index) in salaryStore.salaryAdvanceSettingsDetails" :key="index" :class="[]" >
                        <div class="w-full row">
                            <div class="col">
                                <h1 class="text-[15px]">{{ item.settings.settings_name }}</h1>
                            </div>
                            <div class="col">

                            </div>
                            <div class="col-4 ">
                                <button class="float-right text-blue-400 underline fs-5" @click="viewDetails(item)">View Details</button>
                            </div>
                        </div>
                        <div class="w-full row">
                            <div class="col">
                                <h1 class="  text-[15px]" v-if="item.settings.deduction_period_of_months === 1">Deduct the amount in
                                    the Upcomming Payroll</h1>
                                    <h1 class=" text-[15px]" v-else>The deduction can be made over a period of {{
                                        item.settings.deduction_period_of_months }} months. </h1>
                            </div>
                            <div class="col">
                                <h1 class=" text-[15px]  text-right">Percentage of Salary Advance: {{ item.settings.percent_salary_adv }}%</h1>
                            </div>
                            <div class="col">
                                <h1 class=" text-[15px] float-right">Employee Count : {{ item.settings.emp_count }}</h1>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <div v-if="salaryStore.create_new_from == '2'" class="grid grid-cols-1">
                <div class="">
                    <div class="my-4 flex justify-between items-center  w-[600px] ">
                        <h1 class="text-xl xl:text-2xl ">Name of the Salary Advance</h1>
                        <div class="">
                            <InputText type="text" placeholder="Give Salary Advance a Name" v-model="salaryStore.sa.SA"
                                class=" d-flex justify-items-center md:w-20rem" :class="[
                                    v$.SA.$error ? 'p-invalid ' : '',
                                ]" />
                            <span v-if="v$.SA.$error" class="font-semibold text-red-400 fs-6 position-absolute top-12">
                                {{ v$.SA.required.$message.replace("Value", "Client Name") }}
                            </span>
                        </div>
                    </div>
                    <div class="my-4 d-flex justify-content-between align-items-center w-[600px] ">
                        <h1 class="fs-4">Payment Cycle</h1>
                        <div class="" style="height: 40px; position:relative;">
                            <button class="px-4 py-2 rounded-l-md border-[1px] text-gray-500 fw-semibold border-gray-500"
                                @click="salaryStore.sa.payroll_cycle = 0"
                                :class="[salaryStore.sa.payroll_cycle == '0' ? ' text-white bg-orange-500 border-none' : '']">
                                Single</button>
                            <button class="px-4 py-2 rounded-r-md text-gray-500 border-[1px] fw-semibold border-gray-500"
                                @click="salaryStore.sa.payroll_cycle = 1"
                                :class="[salaryStore.sa.payroll_cycle == '1' ? ' text-white bg-orange-500 border-none' : '']">
                                Multiple</button>
                        </div>
                    </div>
                    <h1 class="mt-10 fs-4 ">Eligible Employees</h1>
                    <p class="my-2 fs-5">Kindly choose the employees who are eligible for the salary advance.</p>
                </div>

                <div class="">
                    <div class="rounded-lg shadow-sm card">
                        <div class="card-body " style="border-top:4px solid var(--navy) ; border-radius: 4px 4px 0 0 ;">
                            <div class="row ">
                                <div class="col-9">
                                    <h1 style="border-left:4px solid var(--orange); padding-left: 15px; font-size: 18px;">
                                        Employees</h1>
                                </div>
                                <div class="mx-2 col-3 my-[14px]">
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search" />
                                        <InputText placeholder="Search" v-model="filters['global'].value"
                                            class="border-color " style="height: 3em;  " />
                                    </span>
                                </div>
                                <div class="col-12">
                                    <div class="col-12">
                                        <div class="px-2 row">
                                            <div class="col">
                                                <div style="padding: 10px"
                                                    class="border rounded d-flex justify-content-start align-items-center border-color">
                                                    <input type="checkbox" class="mr-3" style="width: 20px; height: 20px"
                                                        @change="salaryStore.resetFilters" />
                                                    <h1>Clear Filters</h1>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <Dropdown v-model="opt" editable
                                                    :options="salaryStore.dropdownFilter.department" optionLabel="name"
                                                    optionValue="id"
                                                    @change="salaryStore.getSelectoption('department', opt)"
                                                    placeholder="Department" class="w-full text-red-500 md: border-color" />
                                            </div>
                                            <div class="col">
                                                <Dropdown v-model="opt1" editable
                                                    :options="salaryStore.dropdownFilter.designation"
                                                    optionLabel="designation" optionValue="designation"
                                                    placeholder="Designation" class="w-full text-red-500 md: border-color"
                                                    @change="salaryStore.getSelectoption('designation', opt1)" />
                                            </div>
                                            <div class="col">
                                                <Dropdown v-model="opt2" editable
                                                    :options="salaryStore.dropdownFilter.location"
                                                    optionLabel="work_location" optionValue="work_location"
                                                    placeholder="Location" class="w-full text-red-500 md: border-color"
                                                    @change="salaryStore.getSelectoption('work_location', opt2)" />
                                            </div>
                                            <div class="col">
                                                <Dropdown v-model="opt3" editable
                                                    :options="salaryStore.dropdownFilter.state" optionLabel="state_name"
                                                    optionValue="id" placeholder="State"
                                                    class="w-full text-red-500 md: border-color"
                                                    @change="salaryStore.getSelectoption('state', opt3)" />
                                            </div>
                                            <div class="col">
                                                <Dropdown v-model="opt5" editable
                                                    :options="salaryStore.dropdownFilter.legalEntity"
                                                    optionLabel="client_name" optionValue="id" placeholder="Legal Entity"
                                                    class="w-full text-red-500 md: border-color"
                                                    @change="salaryStore.getSelectoption('client_name', opt5)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <DataTable class="mt-[8px]" ref="dt" dataKey="user_code" :paginator="true" :rows="10"
                                :value="salaryStore.eligbleEmployeeSource"
                                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                                v-model:selection="salaryStore.sa.eligibleEmployee"
                                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                                responsiveLayout="scroll">
                                <Column selectionMode="multiple" headerStyle="width: 1.5rem"  >
                                    <template  #body="slotProps" v-if="view_details"  >
                                        <Checkbox   v-model:selection="setEligibleEmployee"  :inputId="slotProps.data.id"  @change="sendEmpDetails(slotProps.data,slotProps.data.id)"  :binary="true" />
                                    </template>
                                </Column>
                                <Column field="user_code" header="Employee Name" style="min-width: 8rem"></Column>
                                <Column field="name" header="Employee Name" style="min-width: 12rem"></Column>
                                <Column field="department_name" header="Department " style="min-width: 12rem"></Column>
                                <Column field="designation" header="Designation " style="min-width: 20rem"></Column>
                                <Column field="work_location" header="Location " style="min-width: 12rem"></Column>
                                <Column field="client_name" header="Legal Entity" style="min-width: 20rem"></Column>
                            </DataTable>

                            <DataTable ref="dt" dataKey="user_code" :paginator="true" :rows="10"
                            :value="salaryStore.SalaryEmpDetails" v-if="view_details"
                            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                            :rowsPerPageOptions="[5, 10, 25]"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                            responsiveLayout="scroll">
                            <!-- <Column selectionMode="multiple" headerStyle="width: 1.5rem"></Column> -->
                            <Column field="user_code" header="Employee Name" style="min-width: 8rem"></Column>
                            <Column field="name" header="Employee Name" style="min-width: 12rem"></Column>
                            <Column field="department_name" header="Department " style="min-width: 12rem"></Column>
                            <Column field="designation" header="Designation " style="min-width: 20rem"></Column>
                            <Column field="work_location" header="Location " style="min-width: 12rem"></Column>
                            <Column field="client_name" header="Legal Entity" style="min-width: 20rem"></Column>
                            <Column  header="Action">
                            <template #body="slotProps" >
                                <div>
                                    <button class="px-2 text-blue-600 border border-blue-600 rounded-md" @click="Remove(slotProps.data)">remove </button>
                                </div>
                            </template>
                            </Column>
                        </DataTable>
                        </div>
                    </div>
                </div>

                <div class="mt-4 ">
                    <h1 class="my-3 fs-4 ">Percentage of Salary Advance</h1>
                    <p class="my-2 fs-5">Please select the percentage of the salary advance that employees can avail.</p>

                    <div class="shadow-sm card border-L rounded-top">
                        <div class="card-body">
                            <div
                                class="grid gap-4 p-2 md:grid-cols-3 sm:grid-cols-1 xxl:grid-cols-3 xl:grid-cols-3 lg:grid-cols-3 align-items-center">
                                <div>
                                    <div class="flex flex-wrap gap-3">
                                        <div class="flex justify-content-center align-items-center">
                                            <RadioButton v-model="salaryStore.sa.perOfSalAdvance" inputId="ingredient1"
                                                name="percofsaladvance" :value="100" :class="[
                                                    v$.perOfSalAdvance.$error ? 'p-invalid' : '',
                                                ]" />
                                            <label for="ingredient1" class="ml-2 fs-5">100% Of Net salary</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="salaryStore.sa.perOfSalAdvance" inputId="ingredient2"
                                            name="percofsaladvance" :value="50" :class="[
                                                v$.perOfSalAdvance.$error ? 'p-invalid' : '',
                                            ]" />

                                        <label for="ingredient2" class="ml-2 fs-5">50% Of Net salary</label>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="salaryStore.sa.perOfSalAdvance" inputId="ingredient3"
                                            name="percofsaladvance" :value="'custom'" :class="[
                                                v$.perOfSalAdvance.$error ? 'p-invalid' : '',
                                            ]" />
                                        <label for="ingredient3" class="ml-2 fs-5">Custom</label>
                                    </div>
                                    <div class="flex" v-if="salaryStore.sa.perOfSalAdvance == 'custom'">
                                        <div class="flex align-items-center">
                                            <InputNumber v-model="salaryStore.sa.cusPerOfSalAdvance" name="percofsaladvance"
                                                class="w-1 mx-2" style="  width: 80px;" :class="[
                                                    v$.cusPerOfSalAdvance.$error ? 'p-invalid' : '',
                                                ]" />
                                        </div>
                                        <label for="ingredient4" class="my-auto ml-2 fs-5">% Of Net salary</label>
                                    </div>
                                </div>
                            </div>
                            <span v-if="v$.perOfSalAdvance.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.perOfSalAdvance.$errors[0].$message }}
                            </span>
                            <span v-if="v$.cusPerOfSalAdvance.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.cusPerOfSalAdvance.$errors[0].$message }}
                            </span>
                        </div>
                    </div>

                    <h1 class="my-3 mt-3 fs-4 " style="margin-top: 30px !important;">Deduction Method</h1>
                    <p class="my-2 fs-5">Please choose the method of deduction.</p>
                    <div class="card border-L">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7 d-flex justify-content-start align-items-center">

                                    <RadioButton v-model="salaryStore.sa.deductMethod" inputId="ingredient1"
                                        name="deductiomAmt" :value="1" :class="[
                                            v$.deductMethod.$error ? 'p-invalid' : '',
                                        ]" />
                                    <label for="" class="mx-3 fs-5" style="line-height: 25px;">Deduct the amount in the
                                        upcoming
                                        payroll.</label>
                                </div>
                            </div>
                            <div class="my-3 row">
                                <div class="col-7 d-flex justify-content-start align-items-center">
                                    <RadioButton v-model="salaryStore.sa.deductMethod" inputId="ingredient1"
                                        name="deductiomAmt" :value="'afterPayroll'" :class="[
                                            v$.deductMethod.$error ? 'p-invalid' : '',
                                        ]" />
                                    <label for="" class="mx-3 fs-5">The deduction can be made over a period of
                                        <InputNumber type="text" class="mx-3" v-model="salaryStore.sa.cusDeductMethod"
                                            style="max-width: 100px;" :class="[
                                                v$.cusDeductMethod.$error ? 'p-invalid' : '',
                                            ]" /> months.
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p class="text-gray-600 fs-5">(Note: Within the declared period of time, employees can
                                        choose the
                                        month
                                        in which the
                                        amount will be deducted.)</p>
                                </div>
                            </div>
                            <span v-if="v$.deductMethod.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.deductMethod.$errors[0].$message }}
                            </span>
                            <span v-if="v$.cusDeductMethod.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.cusDeductMethod.$errors[0].$message }}
                            </span>
                        </div>

                    </div>

                    <h1 class="my-3 fs-4 " style="margin-top: 30px !important;">Approval Setting</h1>
                    <p class="my-2 fs-5">Please choose the approval flow for salary advance.</p>

                    <div class="card border-L">
                        <div class="py-3 row">
                            <div class="mx-1 my-3 col-3 d-flex align-items-center" style="width: 220px;">
                                <P class="mx-3 fs-5">Employee Request
                                </P>
                                <i class="text-green-400 pi pi-angle-double-right fs-4"></i>
                            </div>

                            <div class="col">

                                <div class="row">


                            <div class="col d-flex">
                                <div class="w-10 p-1 rounded bg-slate-200 d-flex align-items-center "
                                    style="width: 225px !important;">
                                    <Dropdown v-model="salaryStore.selectedOption1" editable
                                        :options="salaryStore.filteredApprovalFlow" optionLabel="name" placeholder="Select"
                                        class="w-full pl-2 md:w-14rem"
                                        @change="salaryStore.toSelectoption(1, salaryStore.selectedOption1)" />
                                    <button
                                        @click="salaryStore.option1 = 0, salaryStore.toSelectoption(4, salaryStore.selectedOption1)"
                                        v-if="salaryStore.selectedOption1" class="mx-2">
                                        <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                                    </button>
                                </div>
                                <button @click="salaryStore.option1 = 1" class="text-green-400 " style="width: 40px;"
                                    v-if="salaryStore.option1 == 0 && salaryStore.option == 1">
                                    <i class="pi pi-plus-circle fs-4"></i></button>
                                <button class="ml-4 text-green-400 " style="width: 40px;" v-if="salaryStore.option1 == 1">
                                    <i class="pi pi-angle-double-right fs-4"></i></button>
                            </div>


                            <div class="col d-flex" v-if="salaryStore.option1 == 1" style="width: 280px;">
                                <div class="w-10 p-2 ml-2 rounded bg-slate-200 d-flex align-items-center col-8"
                                    style="width: 225px !important;">
                                    <Dropdown v-model="salaryStore.selectedOption2" editable
                                        :options="salaryStore.filteredApprovalFlow" optionLabel="name" placeholder="Select"
                                        class="w-full md:w-14rem pl-0.5"
                                        @change="salaryStore.toSelectoption(2, salaryStore.selectedOption2)" />
                                    <button
                                        @click="salaryStore.option1 = 0, salaryStore.toSelectoption(5, salaryStore.selectedOption2)"
                                        v-if="salaryStore.option1 == 1">
                                        <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                                    </button>
                                </div>
                                <button @click="salaryStore.option2 = 1" class="text-green-400 "
                                    v-if="salaryStore.option2 == 0 && salaryStore.option1 == 1" style="width: 40px;">
                                    <i class="pi pi-plus-circle fs-4"></i></button>

                                <button class="text-green-400 " style="width: 40px;" v-if="salaryStore.option2 == 1">
                                    <i class="ml-4 pi pi-angle-double-right fs-4"></i></button>
                            </div>


                            <div class="col col-3 d-flex" v-if="salaryStore.option2 == 1" style="width: 280px;">
                                <div class="w-10 p-2 ml-2 rounded bg-slate-200 d-flex align-items-center"
                                    style="width: 225px !important;">
                                    <Dropdown v-model="salaryStore.selectedOption3" editable
                                        :options="salaryStore.filteredApprovalFlow" optionLabel="name" placeholder="Select"
                                        class="w-full pl-2 md:w-14rem"
                                        @change="salaryStore.toSelectoption(3, salaryStore.selectedOption3)" />
                                    <button
                                        @click="salaryStore.option2 = 0, salaryStore.toSelectoption(6, salaryStore.selectedOption3)"
                                        v-if="salaryStore.option2 == 1">
                                        <i class="ml-2 text-red-400 pi pi-times-circle fs-4"></i>
                                    </button>
                                </div>
                            </div>

                                </div>

                            </div>



                        </div>
                        <!-- grid grid  -->

                        <span v-if="v$.approvalflow.$error" class="mx-2 font-semibold text-red-400 fs-6">
                            {{ v$.approvalflow.$errors[0].$message }}
                        </span>

                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 mt-[10px]">
            <div class="col">
                <div class=" d-flex justify-content-center" v-if="salaryStore.create_new_from == '2'" >
                    <button class="btn btn-border-primary" @click="back_btn" v-if="!view_details"  >Cancel</button>
                    <button class="mr-5 btn btn-border-primary" @click="back_btn" v-if="view_details" >Back</button>
                    <button class="btn btn-primary" v-if="salaryStore.EnableAndDisable === 0 && view_details " @click="EnableDisable(1)">Enable</button>
                    <button class="btn btn-primary" v-if="salaryStore.EnableAndDisable == 1 && view_details" @click="EnableDisable(0)">Disable</button>
                    <button class="mx-4 btn btn-primary" @click="submitForm" v-if="!view_details">Save </button>
                    <button class="mx-4 btn btn-primary" @click="savechanges" v-if="view_details">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- {{ salaryStore.selectedOption3 }} -->
</template>
<script setup>

import { ref, reactive, onMounted, computed } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { salaryAdvanceSettingMainStore } from '../stores/salaryAdvanceSettingMainStore'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators';
import {loanSettingsStore} from '../stores/loanSettingsStores';

const salaryStore = salaryAdvanceSettingMainStore()
const useSettingStore = loanSettingsStore();

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const settingHistory = ref([]);

const setEligibleEmployee = ref([]);

const settings_id = ref();

const opt = ref()
const opt1 = ref()
const opt2 = ref();
const opt3 = ref();
const opt4 = ref();
const opt5 = ref();
const opt6 = ref();

const show = ref(false);

const custPercent = (value) => {
    if (salaryStore.sa.perOfSalAdvance == 'custom') {
        if (value) {
            return true
        } else {
            false
        }
    } else {
        return true
    }
}
const custDeduct = (value) => {
    if (salaryStore.sa.deductMethod == 'afterPayroll') {
        if (value) {
            return true
        } else {
            false
        }
    } else {
        return true
    }
}



// const eligibleRequiredAmount = (value) => {
//     if ( salaryStore.sa.payroll_cycle == 0 || salaryStore.sa.payroll_cycle == 1) {
//         console.log(value);
//         return false
//     } else {
//         return true
//     }
// }

const rules = computed(() => {
    return {
        perOfSalAdvance: { required: helpers.withMessage('Percentage of salary advance is required', required) },
        SA: { required: helpers.withMessage('salary Advance Name is required', required) },
        cusPerOfSalAdvance: { custPercent: helpers.withMessage('Custom percentage of salary advance is required', custPercent) },
        deductMethod: { required: helpers.withMessage('Method of deduction is required', required) },
        cusDeductMethod: { custDeduct: helpers.withMessage('Deduction peroid is required', custDeduct) },
        approvalflow: { required: helpers.withMessage('Approval Flow is required', required) },

    }
})



const v$ = useValidate(rules, salaryStore.sa)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        salaryStore.saveSalaryAdvanceFeature();
        salaryStore.salaryAdvanceHistory();
        salaryStore.getCurrentStatus('sal_adv');
        v$.value.$reset();
    } else {
        console.log('Form failed validation')
    }
}


function selectClientId(data) {
    salaryStore.sendClient_code(data);
}



onMounted(() => {
    opt.value = "Department"
    opt1.value = "Designation"
    opt2.value = "Location"
    opt3.value = "State"
    opt4.value = "Branch"
    opt5.value = "Legal Entity"
    salaryStore.getClientsName('sal_adv');
    salaryStore.getCurrentStatus('sal_adv');
    salaryStore.getDropdownFilterDetails();
    salaryStore.salaryAdvanceHistory();

});

let view_details = ref();


const Name = [];


function viewDetails(val) {
    view_details.value  = val;
    console.log(view_details);

    salaryStore.create_new_from = 2;
    settings_id.value = val.settings.view_details.settings_id;

    salaryStore.sa.SA = val.settings.view_details.settings_name;
    salaryStore.sa.isSalaryAdvanceEnabled = val.settings.view_details;
    // salaryStore.sa.eligibleEmployee = val.settings.view_details;
    salaryStore.sa.perOfSalAdvance = val.settings.view_details.percent_salary_adv;
    salaryStore.sa.cusPerOfSalAdvance = val.settings.view_details
    salaryStore.sa.payroll_cycle = val.settings.view_details.can_borrowed_multiple;
    salaryStore.SalaryEmpDetails = val.settings.view_details.assigned_emp ;

    val.settings.view_details.approver_flow.forEach(element => {

        Name.push(element.name)

        salaryStore.selectedOption1 = Name[0];
        if (Name[1]) {
            salaryStore.selectedOption2 = Name[1];
        }
        if (Name[2]) {
            salaryStore.selectedOption2 = Name[2];
        }
    });

    if (salaryStore.selectedOption1) {
        salaryStore.option1 = 0;
        salaryStore.option = 1

        if (salaryStore.selectedOption2) {
            salaryStore.option1 = 1
            salaryStore.option2 = 1
        }
    }

    if (val.settings.view_details.deduction_period_of_months == 1) {
        salaryStore.sa.deductMethod = val.settings.view_details.deduction_period_of_months;
    }
    else {
        salaryStore.sa.deductMethod = "afterPayroll";
        salaryStore.sa.cusDeductMethod = val.settings.view_details.deduction_period_of_months;
    }

}


function back_btn(){
    salaryStore.sal_adv_reset();
    salaryStore.create_new_from = 1;
    view_details.value = "";
}

function sendEmpDetails(val,id){
    console.log(val);

    if(view_details){
        salaryStore.SalaryEmpDetails.push(val);
    }
    setEligibleEmployee.value.push(id);
    console.log();

}

function EnableDisable(val){
salaryStore.create_new_from = 1;
salaryStore.sal_adv_reset();
useSettingStore.SendEnableAndDisable( );
console.log(val);
}
// if(salaryStore.sa.eligibleEmployee){

//     salaryStore.SalaryEmpDetails.push(Object.values(salaryStore.sa.eligibleEmployee))
//     console.log("testings simma");

// }

function savechanges(){
    salaryStore.create_new_from = 1;
    console.log(salaryStore.sa.eligibleEmployee);
    useSettingStore.sendSavechanges( settings_id.value , setEligibleEmployee.value )
}

function Remove(val){
    setEligibleEmployee.value =  setEligibleEmployee.value.filter(item => item !== val.id )
    salaryStore.SalaryEmpDetails = salaryStore.SalaryEmpDetails.filter(item => item !== val );
    console.log(setEligibleEmployee.value);
}


</script>
<style>
:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
}

.orange_btn {
    background-color: var(--orange);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;
    color: var(--white);
}

.Enable_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 0 4px 4px 0;

}

.cancel_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;

}

.border-L {
    border-left: 4px solid var(--navy) !important;
}

.border-color {
    color: #003154;
    /* border: 2px solid #3B82F6 !important; */
    border: 2px solid #003487 !important;
}

.border-color::placeholder {
    color: #002f56 !important;
}

input[type=radio] {
    border: 0px;
    width: 20px;
    height: 20px;
    color: var(--orange) !important;
    background-color: var(--orange) !important;
}

.p-dropdown-label.p-inputtext {
    color: var(--navy);
}

.dropdown li {
    padding: 8px 0 16px 16px;

}

.dropdown_btn {}

.dropdown {
    padding: 8px;
    background-color: #E3E3E3;
    width: 180px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    outline: none;
    border-radius: 6px;
    ;

}

.p-inputtext.p-component.p-inputnumber-input {
    width: 75px;
}


.blink {
    animation: blink-animation 1.5s steps(5, start) infinite;
    -webkit-animation: blink-animation 1.5s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        /* visibility: hidden; */
        /* opacity: 0.5; */
        box-shadow:0px 0px 11px 1px rgba(0,0,0,0.14),
		0px 0px 19px 14px rgba(0,0,0,0.03) ;
    }
}

@-webkit-keyframes blink-animation {
    to {
        /* visibility: hidden; */
        /* opacity: 1; */

    }
}
</style>

{

}

