<template>
    <div class="w-full ">
        <!-- <section id="header" class="flex justify-between w-full my-4 ">
            <p class="mx-1 font-semibold text-lg">Salary Compenents</p>
            <div><button class="btn btn-orange mx-5 whitespace-nowrap" @click="usePayroll.dailogNewSalaryComponents = true">Add Components</button>
            </div>
        </section> -->
        <div class="table-responsive">
            <!-- <DataTable :value="helper.filterSource(usePayroll.salaryComponentsSource, 1)"
                :rows="helper.filterSource(usePayroll.salaryComponentsSource, 1).length" :rowsPerPageOptions="[5, 10, 25]">
                <ColumnGroup type="header">
                    <Row>
                        <Column header="Name" :rowspan="3" style="min-width: 15rem" />
                        <Column header="Type" :rowspan="3" style="min-width: 8rem" />
                        <Column header="Type of calculation" :rowspan="3" style="min-width: 18rem" />
                        <Column header="Consider for" :colspan="2" style="min-width: 12rem" />
                        <Column header="Status" :rowspan="3" style="min-width: 12rem" />
                        <Column header="Action" :rowspan="3" style="min-width: 12rem" />

                    </Row>
                    <Row>
                    </Row>
                    <Row>
                        <Column header="EPF" :rowspan="3" />
                        <Column header="ESI" :rowspan="3" />
                    </Row>
                </ColumnGroup>
                <Column field="comp_name" style="text-align: left !important;" />
                <Column field="comp_type_id">
                    <template #body="{ data }">
                        <p>{{ helper.findCompType(data.comp_type_id) }}</p>
                    </template>
                </Column>
                <Column field="calculation_method">
                    <template #body="{ data }">
                        {{ data }} -->
                        <!-- <p v-if="data.calculation_method_id == 1">{{ data.flat_amount }} </p>
                        <p v-if="data.calculation_method_id == 2">{{ data.percentage }}</p>

                    </template>
                </Column>
                <Column field="epf">
                    <template #body="{ data }">
                        <p>{{ helper.findIsSelected(data.epf) }}</p>
                    </template>
                </Column>
                <Column field="esi">
                    <template #body="{ data }">
                        <p>{{ helper.findIsSelected(data.esi) }}</p>
                    </template>
                </Column> -->
                <!-- <Column field="status">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.status">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Enabled</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Disabled</span>
                        </div>
                    </template>
                </Column> -->
                <!-- <Column>
                    <template #body="{ data }">
                        <button v-if="data.is_default == 1" class="p-2" v-tooltip.bottom="'fixed variable'">
                            <i class="pi pi-lock" style="font-size: 1.5rem"></i>
                        </button>
                        <div v-else>
                            <button class="p-1 mx-4 bg-green-200 border-green-500 rounded-xl"
                                @click="usePayroll.editNewSalaryComponent(true, data)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-8 h-6 px-auto text-center">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <button class="p-1 bg-red-200 border-red-500 rounded-xl"
                                @click="usePayroll.deleteSalaryComponent(data.id)"> -->
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-8 h-6 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </Column>


            </DataTable>  -->
            <!-- {{ usePayroll.salaryDetails }} -->
            <DataTable  :value="usePayroll.salaryDetails" >
                <Column field="comp_name" header="Name"></Column>
                <Column field="comp_type" header="Type"></Column>
                <Column field="calculation_desc" header="Type of Calculation"></Column>
                <Column field="is_part_of_epf" header="EPF">
                    <template #body="{data}">
                        <div v-if="data.is_part_of_epf">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Yes</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">No</span>
                        </div>
                    </template>
                </Column>
                <Column field="is_part_of_esi" header="ESI">
                    <template #body="{data}">
                        <div v-if="data.is_part_of_esi">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Yes</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">No</span>
                        </div>
                    </template>
                </Column>
                <Column field="enabled_status" header="Status">
                    <template #body="{data}">
                        <div v-if="data.enabled_status">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Enabled</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">Disabled</span>
                        </div>
                    </template>
                </Column>
                <Column class="font-['poppins'] text-[16px] font-medium" header="Action">
                    <template #body="{ data }">
                        <i class="pi pi-ellipsis-v"></i>
                    </template>
                </Column>
            </DataTable>
             
        </div>
        <Dialog v-model:visible="usePayroll.dailogNewSalaryComponents" :modal="true" :closable="true"
            :style="{ width: '80vw', borderTop: '5px solid #002f56' }">
            <template #header>
                <span class="text-lg font-semibold modal-title text-indigo-950">Add New Components</span>
            </template>
            <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1 xxl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 mt-4"
                style="display: grid;">
                <div class="px-4">
                    <div class="">
                        <label for="metro_city" class="block mb-2  text-gray-700 font-semibold fs-6">Type of the
                            component</label>
                        <Dropdown :options="helper.componentTypes" editable class="w-full" optionLabel="name"
                            optionValue="value" placeholder="Select component"
                            v-model="usePayroll.salaryComponents.typeOfComp" />
                    </div>
                    <div class="my-3">
                        <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Name of the
                            component</label>
                        <InputText class="w-full" placeholder="Enter name of the component "
                            v-model="usePayroll.salaryComponents.name" />
                    </div>
                    <div class="">
                        <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Name of the
                            component(In Payslip)</label>
                        <InputText class="w-full" placeholder="Enter name of the component"
                            v-model="usePayroll.salaryComponents.nameInPayslip" />

                    </div>
                    <div class="my-3">
                        <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Type of
                            calculation</label>
                        <Dropdown editable class="w-full"  :options="helper.calculationTypes"  optionLabel="name" optionValue="value"
                           placeholder="Select calculation type"
                            v-model="usePayroll.salaryComponents.typeOfCalc" />
                    </div>
                    <div class="" v-if="usePayroll.salaryComponents.typeOfCalc == 1">
                        <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Enter the
                            amount</label>
                        <InputText class="w-full" placeholder="Enter the amount"
                            v-model="usePayroll.salaryComponents.amount" />
                    </div>
                    <div class="" v-if="usePayroll.salaryComponents.typeOfCalc == 2">
                        <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Enter the
                            percentage</label>
                        <InputText class="w-full" placeholder="Enter the amount"
                            v-model="usePayroll.salaryComponents.percentage" />
                    </div>
                </div>
                <div>
                    <div class="border-1 rounded-lg p-2">
                        <div class="mx-2 my-3">
                            <span>Status</span>
                            <div class="form-check form-check-inline mx-8">
                                <input style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="status"
                                    id="full_day" value="1" v-model="usePayroll.salaryComponents.status" />
                                <label class="form-check-label leave_type ms-2" for="full_day">Enable</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="status" :true-value=1 :false-value=0
                                    id="full_day" value="0" v-model="usePayroll.salaryComponents.status" />
                                <label class="form-check-label leave_type ms-2" for="full_day">Disable</label>
                            </div>
                        </div>
                        <div class="flex my-5">
                            <input :true-value=1 :false-value=0
                                v-model="usePayroll.salaryComponents.isPartOfEmpSalStructure" type="checkbox" name="" id=""
                                style="height: 20px;width: 20px;" class="form-check-input">
                            <p class="mx-3">Make this earning a part of the employee's salary structure</p>
                        </div>
                        <div class="flex my-5">
                            <input :true-value=1 :false-value=0 v-model="usePayroll.salaryComponents.isTaxable"
                                type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input">
                            <p class="mx-3">This salary component is taxable</p>
                        </div>
                        <div class="flex my-5">
                            <input :true-value=1 :false-value=0 v-model="usePayroll.salaryComponents.isCalcShowProBasis"
                                type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input">
                            <p class="mx-3">Calculate on pro-rate basis</p>
                        </div>
                        <div class="flex my-5">
                            <input :true-value=1 :false-value=0 v-model="usePayroll.salaryComponents.isShowInPayslip"
                                type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input">
                            <p class="mx-3">Show the component in payslip</p>
                        </div>
                        <div class=" my-5 mx-2">
                            <span class="w-8">Considered for EPF</span>
                            <div class="form-check form-check-inline mx-8">
                                <input v-model="usePayroll.salaryComponents.isConsiderForEPF"
                                    style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="epf"
                                    id="full_day" value="1" />
                                <label class="form-check-label leave_type ms-2" for="full_day">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="usePayroll.salaryComponents.isConsiderForEPF"
                                    style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="epf"
                                    id="full_day" value="0" />
                                <label class="form-check-label leave_type ms-2" for="full_day">No</label>
                            </div>
                        </div>
                        <div class=" my-5 mx-2">
                            <span>Considered for ESI</span>
                            <div class="form-check form-check-inline  mx-8">
                                <input v-model="usePayroll.salaryComponents.isConsiderForESI"
                                    style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="esi"
                                    id="full_day" value="1" />
                                <label class="form-check-label leave_type ms-2" for="full_day">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="usePayroll.salaryComponents.isConsiderForESI"
                                    style="height: 20px;width: 20px;" class="form-check-input" type="radio" name="esi"
                                    id="full_day" value="0"  />
                                <label class="form-check-label leave_type ms-2" for="full_day">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right">
                <div class="flex">
                    <button @click=" usePayroll.dailogNewSalaryComponents = false"
                        class="btn btn-orange-outline">Cancel</button>
                    <button @click="usePayroll.saveNewSalaryComponent(1)" class="btn btn-orange mx-2">Save</button>
                </div>
            </div>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, computed,onMounted } from 'vue';
import { usePayrollMainStore } from '../../../../stores/payrollMainStore';
import { usePayrollHelper } from '../../../../stores/payrollHelper';

const usePayroll = usePayrollMainStore()
const helper = usePayrollHelper()
const columns=[
    {field:'nameval',header:'Name'},
    {field:'type',header:'Type'},
    {field:'typeofCalc',header:'Type of Calculation'},
    {field:'epf',header:'EPF'},
    {field:'esi',header:'ESI'},
    {field:'status',header:'Status'},
   

]
onMounted(()=>{
    usePayroll.getsalaryDetails();
})


</script>


<style>
.p-dropdown-label.p-inputtext {
    height: 34px;
}

.p-inputtext.p-component.w-full {
    height: 34px;

}

.p-datatable-table .p-datatable-thead>tr {
    box-shadow: 0px 0px 0px 0px !important;
    border-radius: 6px;
}
</style>
