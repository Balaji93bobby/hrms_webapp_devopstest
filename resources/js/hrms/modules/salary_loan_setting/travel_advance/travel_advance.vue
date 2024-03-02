<template>
    <div class="px-5">
        <div class="row d-flex justify-content-start align-items-center">
            <div class="mt-4 d-flex">
                <div class="col-3 fs-4" style="position: relative; left: -8px">
                    <h1 class="fw-bolder">Travel Advance Feature</h1>
                </div>
                <div class="col">
                    <button class="orange_btn" :class="[
                        salaryStore.isTravelAdvanceFeatureEnabled === 2
                            ? 'bg-white text-black border-1 border-black'
                            : 'text-white',
                    ]" @click="salaryStore.isTravelAdvanceFeatureEnabled = 1">
                        Disabled
                    </button>
                    <button class="Enable_btn" :class="[
                        salaryStore.isTravelAdvanceFeatureEnabled === 2
                            ? 'bg-green-700 text-white'
                            : '',
                    ]" @click="salaryStore.isTravelAdvanceFeatureEnabled = 2">
                        Enable
                    </button>
                </div>
            </div>

            <div class="col" v-if="salaryStore.isTravelAdvanceFeatureEnabled == '1'">
                <div>
                    <p class="fs-5">
                        Please click the "Enable" button to activate the Travel Advance
                        Feature for use within your organization.
                    </p>
                </div>
            </div>
            <div v-else class="row">
                <div class="col-10">
                    <p class="fs-5">
                        Please click the "Disable" button to deactivate the Travel Advance
                        Feature.
                    </p>
                    <h1 class="mt-10 fs-4 fw-bolder">Eligible Employees</h1>
                    <p class="my-2 fs-5">
                        Kindly choose the employees who are eligible for the Travel Advance
                        Feature.
                    </p>
                </div>
                <div class=" col-12">
                    <div class="rounded-lg shadow-sm card">
                        <div class="card-body " style="border-top:4px solid var(--navy) ; border-radius: 4px 4px 0 0 ;">
                            <div class="row ">
                                <div class="col-9">
                                    <h1 style="border-left:4px solid var(--orange); padding-left: 15px; font-size: 18px;">
                                        Employees</h1>
                                </div>
                                <div class="col-3">
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search" />
                                        <InputText placeholder="Search" v-model="filters['global'].value"
                                            class="border-color " style="height: 3em" />
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


                                                <!-- table components  -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <DataTable ref="dt" dataKey="user_code" :paginator="true" :rows="10"
                                :value="salaryStore.eligbleEmployeeSource"
                                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                                v-model:selection="salaryStore.sa.eligibleEmployee"
                                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                                responsiveLayout="scroll">
                                <Column selectionMode="multiple" headerStyle="width: 1.5rem"></Column>
                                <Column field="user_code" header="Employee Name" style="min-width: 8rem"></Column>
                                <Column field="name" header="Employee Name" style="min-width: 12rem"></Column>
                                <Column field="department_name" header="Department " style="min-width: 12rem"></Column>
                                <Column field="designation" header="Designation " style="min-width: 20rem"></Column>
                                <Column field="work_location" header="Location " style="min-width: 12rem"></Column>
                                <Column field="client_name" header="Legal Entity" style="min-width: 20rem"></Column>
                            </DataTable>
                        </div>
                    </div>
                </div>





                <div class="col">
                    <h1 class="my-3 fs-4 fw-bolder">Travel Advance Limit</h1>
                    <p class="my-2 fs-5">
                        What is the maximum Limit for the travel allowance that can be
                        availed.
                    </p>

                    <div class="shadow-sm card border-L rounded-top">
                        <div class="card-body">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-6 fs-5">
                                    Is there a maximium limit on the travel allowance that can be
                                    availed?
                                </div>
                                <div class="col-1">
                                    <div class="flex flex-wrap gap-3">
                                        <div class="flex justify-content-center align-items-center">
                                            <RadioButton v-model="salaryStore.ta.tdl" inputId="ingredient1" name="limit"
                                                value="1" />
                                            <label for="ingredient1" class="ml-2 fs-5">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="salaryStore.ta.tdl" inputId="ingredient2" name="limit"
                                            value="0" />
                                        <label for="ingredient2" class="ml-2 fs-5">No</label>
                                    </div>
                                </div>
                                <div class="col-12" v-if="activetab1 == '2'">
                                    <label for="" class="fs-5">Enter the maximum amount can be availed per month
                                        <InputText type="text" class="mx-3" v-model="value" style="max-width: 100px" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="my-3 fs-3 fw-bolder" style="margin-top: 30px !important">
                        Deduction
                    </h1>
                    <p class="my-2 fs-5">Please choose the method of deduction.</p>
                    <div class="card border-L">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h1 class="fs-5">
                                        Is this advance can be decducted from claim
                                    </h1>
                                </div>
                                <div class="col-1">
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="salaryStore.ta.deductMethod" inputId="ingredient2"
                                            name="pizza" value="1" />
                                        <label for="ingredient2" class="ml-2 fs-5">yes</label>
                                    </div>
                                </div>

                                <div class="col-1">
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="salaryStore.ta.deductMethod" inputId="ingredient2"
                                            name="pizza" value="0" />
                                        <label for="ingredient2" class="ml-2 fs-5">No</label>
                                    </div>
                                </div>

                                <div class="col d-flex align-items-center fs-5 txt_underline">
                                    <h1 class="text-primary" @click="dialog_ViewExample_Visible = true">
                                        View Example
                                    </h1>
                                </div>

                                <template>
                                    <div class="flex card justify-content-center">
                                        <Button label="Show" icon="pi pi-external-link" />
                                        <Dialog v-model:visible="dialog_ViewExample_Visible" modal header="Header"
                                            :style="{ width: '60vw' }">
                                            <template #header>
                                                <div>
                                                    <h1 style="border-left: 3px solid var(--orange); padding-left: 8px;"
                                                        class="fs-4 ">Travel Advance Deduction Example</h1>
                                                </div>
                                            </template>
                                            <div class="card">
                                                <DataTable :value="sample" rowGroupMode="rowspan" groupRowsBy="selected"
                                                    sortField="selected" showGridlines>

                                                    <Column field="selected" header="if Selected" class="bg-light"></Column>
                                                    <Column field="ta" header="Travel Advance ">
                                                    </Column>
                                                    <Column field="bs" header="Bills Submited"> </Column>
                                                    <Column field="epa" header="Payable Amount to the Employee">
                                                        <template #body="slotprops">
                                                            <div v-if="slotprops.data.epa == '56,000'">

                                                                {{ slotprops.data.epa }} <br>
                                                                <span>(Note: The Total amount be will Deducted in
                                                                    FNF)</span>

                                                            </div>

                                                            <div v-if="slotprops.data.epa == '6,000'">
                                                                {{ slotprops.data.epa }}
                                                                <br>
                                                                <span>(Note: Total amount be will refunded in subsequent
                                                                    payroll)</span>
                                                            </div>
                                                            <div v-if="slotprops.data.epa == '-2000'">
                                                                {{ slotprops.data.epa }}
                                                                <br>
                                                                <span>(Note: The Total amount be will Deducted in subsequent
                                                                    Payroll)</span>

                                                            </div>

                                                        </template>
                                                    </Column>

                                                    <template #body>
                                                        <div>
                                                            <tbody>
                                                                <tr>
                                                                    <td>


                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                        </div>
                                                    </template>

                                                </DataTable>
                                            </div>

                                        </Dialog>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <h1 class="mt-4 mb-4 fs-4 fw-bolder">Claim Settings</h1>
                    <div class="card border-L">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <h1 class="fs-5">
                                        is it for employess to submit bills or receipt to clam
                                        travel allowances?
                                    </h1>
                                </div>
                                <div class="col-1 d-flex justify-content-start align-items-center">
                                    <RadioButton v-model="salaryStore.ta.claimBill" inputId="ingredient2" name="pizza"
                                        value="1" />
                                    <label for="ingredient2" class="ml-2 fs-5">yes</label>
                                </div>
                                <div class="col-1 d-flex justify-content-start align-items-center">
                                    <RadioButton v-model="salaryStore.ta.claimBill" inputId="ingredient2" name="pizza"
                                        value="1" />
                                    <label for="ingredient2" class="ml-2 fs-5">No</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 d-flex justify-content-start align-items-center">
                                    <p class="fs-5">
                                        The employees Sumbit the bills within
                                        <InputText type="text" class="mx-3" v-model="salaryStore.ta.sumbitWithIn"
                                            style="max-width: 100px" />
                                        months for the date of travel advance.
                                    </p>
                                </div>

                                <div class="col-12 d-flex justify-content-start align-items-center">
                                    <input type="checkbox" class="mr-4" style="width: 20px; height: 20px" name="" id=""
                                        v-model="salaryStore.ta.isDeductedInsubsequentpayroll" />
                                    <p class="fs-5">
                                        If bills are by the employee within the above timeframe, the
                                        amount can be deducted from the employee's subsequent
                                        payroll.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="my-3 fs-4 fw-bolder" style="margin-top: 30px !important">
                        Approval Setting
                    </h1>
                    <p class="my-2 fs-5">
                        Please choose the approval flow for Travel Advance.
                    </p>

                    <div class="card border-L">
                        <div class="py-3 row d-flex">
                            <div class="my-3 col col-2 d-flex align-items-center" style="width: 200px;">
                                <P class="mx-3 fs-5">Employee Request
                                </P>
                                <i class="text-green-400 pi pi-angle-double-right fs-4"></i>
                            </div>
                            <div class="col col-3 d-flex" style="width: 280px;">
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


                            <div class="col col-3 d-flex" v-if="salaryStore.option1 == 1" style="width: 280px;">
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
            </div>

            <!--Next screen  -->
        </div>

        <div class="row">
            <div class="col">
                <div class="float-right" v-if="salaryStore.isTravelAdvanceFeatureEnabled == '2'">
                    <button class="btn btn-border-primary">Cancel</button>
                    <button class="mx-4 btn btn-primary" @click="salaryStore.saveTravelAdvance">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, onMounted } from "vue";
import { salaryAdvanceSettingMainStore } from "../stores/salaryAdvanceSettingMainStore";
import { FilterMatchMode } from 'primevue/api';


const salaryStore = salaryAdvanceSettingMainStore();

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const value = ref();
const options = ref(["Off", "On"]);

const dialog_ViewExample_Visible = ref(false);

const activetab = ref(1);
const activetab1 = ref(1);

const ingredient = ref("");

const opt = ref();
const op = ref([{ id: 1, dep: "res" }]);

onMounted(() => {

    opt.value = "Department";
    opt1.value = "Designation";
    opt2.value = "Location";
    opt3.value = "State";
    opt4.value = "Branch";
    opt5.value = "Legal Entity";

});

const sample = ref([
    { id: 1, selected: "Yes", ta: "50,000", "bs": '56,000', epa: '6,000' },
    { id: 2, selected: "Yes", ta: "50,000", "bs": '48,000', epa: '-2000' },
    { id: 3, selected: "No", ta: "50,000", "bs": '56,000', epa: '56,000' }

]
)

const opt1 = ref();
const opt2 = ref();
const opt3 = ref();
const opt4 = ref();
const opt5 = ref();
const opt6 = ref();
</script>
<style>
:root {
    --orange: #ff4d00;
    --white: #fff;
    --navy: #002f56;
}

.p-datatable.p-datatable-gridlines .p-datatable-tbody>tr>td:last-child {
    border-width: none !important;
}

.p-datatable .p-datatable-tbody>tr>td {
    text-align: left;
    border: none !important;
    /* border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
  border-width: 0 0 1px 0;
  padding: 1rem 1rem; */
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
    border-left: 3px solid var(--navy);
}

.border-color {
    color: #003154;
    border: 2px solid #003154;
}

.border-color::placeholder {
    color: #002f56 !important;
}

input[type="radio"] {
    border: 0px;
    width: 20px;
    height: 20px;
    color: var(--orange) !important;
    background-color: var(--orange) !important;
}

.p-dropdown-label.p-inputtext {
    color: var(--navy);
}

.txt_underline {
    text-decoration: underline #3b82f6;
}
</style>


{


<!--

<template>
    <div class="flex card justify-content-center">
        <Button label="Show" icon="pi pi-external-link" @click="visible = true" />
        <Dialog v-model:visible="visible" modal header="Header" :style="{ width: '50vw' }">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </Dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";

const visible = ref(false);
</script>





<script setup>
import { ref, onMounted } from 'vue';
import { ProductService } from '@/service/ProductService';

onMounted(() => {
    ProductService.getProductsMini().then((data) => (products.value = data));
});

const products = ref();

</script>



-->

}
