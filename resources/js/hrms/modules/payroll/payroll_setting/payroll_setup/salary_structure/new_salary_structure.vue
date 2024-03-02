<template>
    <!-- <div class="w-[100%]" style="transition: opacity 0.5s ease;">
        <div class="mx-6 py-6">
             <router-link :to="`/payrollSetup/structure/`">
                <i class="pi pi-arrow-left py-auto mx-2 cursor-pointer" style="font-size: 1rem"></i>
            </router-link> 

            <p class="text-gray-00 font-semibold fs-4 ">New Salary Structure</p>
            <p class="text-gray-500 font-semibold fs-6">Create custom salary package by selecting the relevant
                components
                and configuring their corresponding
                calculation </p>
        </div>
        <div class="flex">
            <div class="w-5">
                <p class="text-gray-700 font-semibold fs-5 mx-6">Structure Details</p>
                <div class="p-4 my-2 mx-6 bg-gray-100 border-gray-400 rounded-lg shadow-md border-1">
                    <div class="">
                        <label for="metro_city" class="block mb-2  text-gray-700 font-semibold fs-6">Structure
                            Name</label>
                        <InputText class="w-[100%] h-10" v-model="usePayroll.salaryStructure.structureName" />
                    </div>
                    <div class="my-4">
                        <label for="metro_city" class="block mb-2  text-gray-700 font-semibold fs-6">Description</label>
                        <div class="flex gap-8 justify-evenly">
                            <Textarea :autoResize="true" rows="3" cols="90" placeholder="Enter the Reason"
                                v-model="usePayroll.salaryStructure.description" />
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <p class="text-gray-700 font-semibold fs-5 mx-6">PF & ESI Setting</p>
                    <div class="p-4 my-2 mx-6 bg-gray-100 border-gray-400 rounded-lg shadow-md border-1">

                        <div class="flex my-5">
                            <input type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input"
                                v-model="usePayroll.salaryStructure.pf" :true-value=1 :false-value=0>
                            <p class="mx-3 text-gray-800 font-semibold fs-6">This salary structure is includes the
                                option
                                for provident fund (PF)
                                contributions</p>
                        </div>
                        <div class="flex my-5">
                            <input type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input"
                                v-model="usePayroll.salaryStructure.esi" :true-value=1 :false-value=0>
                            <p class="mx-3 text-gray-800 font-semibold fs-6">This salary structure is includes the
                                coverage
                                for employee state insurance
                                (ESI)</p>
                        </div>
                        <div class="flex my-5">
                            <input type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input"
                                v-model="usePayroll.salaryStructure.tds" :true-value=1 :false-value=0>
                            <p class="mx-3 text-gray-800 font-semibold fs-6">This salary structure is subject to TDS(Tax
                                deducted at source)</p>
                        </div>
                        <div class="flex my-5">
                            <input type="checkbox" name="" id="" style="height: 20px;width: 20px;" class="form-check-input"
                                v-model="usePayroll.salaryStructure.fbp" :true-value=1 :false-value=0>
                            <p class="mx-3 text-gray-800 font-semibold fs-6">This salary is eligible for flexible
                                benefit
                                plan(FBP)</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="w-full mr-4">
                <div class="flex justify-between">
                    <p class="text-gray-700 font-semibold fs-6">Salary Components</p>
                    <button @click="addSalaryComponents = true" class="btn btn-orange w-4">Add Components</button>
                </div>
                <div class="my-2 ">
                    <DataTable :value="usePayroll.salaryStructure.selectedComponents">
                        <Column field="comp_name" header="Components" style="min-width: 15rem">
                        </Column>
                        <Column field="calculation_method" header="Amount/Calculation" style="min-width: 15rem"></Column>
                        <Column header="Action" style="min-width: 15rem">
                            <template #body>
                                <button class="p-1 mx-4 bg-green-200 border-green-500 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-6 px-auto text-center">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <button class="p-1 bg-red-200 border-red-500 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-6 font-bold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <button @click="assignEmployee = true" class="text-blue-500"><i class="pi pi-plus mx-1"
                        style="font-size: 0.8rem"></i>Assign Employee</button>
            </div>
        </div>

        <div class="flex justify-between my-5">
            <div></div>
            <div class="flex">
                <router-link :to="`/payrollSetup/structure/`">
                    <button @click=" usePayroll.dailogNewSalaryStructure = false"
                        class="btn btn-orange-outline">Cancel</button>
                </router-link>

                <button class="btn btn-orange mx-2 " @click="usePayroll.saveNewsalaryStructure">Create structure</button>
            </div>
        </div>
    </div>


    <Dialog v-model:visible="addSalaryComponents" :modal="true" :closable="true"
        :style="{ width: '80vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Add New Components</span>
        </template>
        <DataTable :value="usePayroll.salaryComponentsSource"
            v-model:selection="usePayroll.salaryStructure.selectedComponents" dataKey="id"
            :rows="usePayroll.salaryComponentsSource.length">
            <Column selectionMode="multiple"></Column>
            <Column field="comp_name" header="Name" style="min-width: 15rem"></Column>
            <Column field="comp_name" header="Type" style="min-width: 15rem"></Column>
            <Column header="Type of calculation" style="min-width: 22rem">
                <template #body="{ data }">
                   <p>{{ helper.findCompType(data.comp_type_id) }};{{ data.calculation_method }}</p> 
                </template>
            </Column>
        </DataTable>
        <div class="float-right my-4">
            <div class="flex">
                <button @click=" usePayroll.dailogNewSalaryStructure = false" class="btn btn-orange-outline">Cancel</button>
                <button class="btn btn-orange mx-2" @click="addSalaryComponents = false">Save</button>
            </div>
        </div>
    </Dialog>
    <Dialog v-model:visible="assignEmployee" :modal="true" :closable="true"
        :style="{ width: '95vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Assign Employees</span>
        </template>
        <div class=" col-12">
            <div class="row ">
                <div class=" float-right">
                    <span class="p-input-icon-left ">
                        <i class="pi pi-search" />
                        <InputText placeholder="Search" v-model="filters['global'].value" class="border-color "
                            style="height: 3em" />
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
                                <Dropdown v-model="opt" editable :options="salaryStore.dropdownFilter.department"
                                    optionLabel="name" optionValue="id"
                                    @change="salaryStore.getSelectoption('department', opt)" placeholder="Department"
                                    class="w-full text-red-500 md: border-color" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt1" editable :options="salaryStore.dropdownFilter.designation"
                                    optionLabel="designation" optionValue="designation" placeholder="Designation"
                                    class="w-full text-red-500 md: border-color"
                                    @change="salaryStore.getSelectoption('designation', opt1)" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt2" editable :options="salaryStore.dropdownFilter.location"
                                    optionLabel="work_location" optionValue="work_location" placeholder="Location"
                                    class="w-full text-red-500 md: border-color"
                                    @change="salaryStore.getSelectoption('work_location', opt2)" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt3" editable :options="salaryStore.dropdownFilter.state"
                                    optionLabel="state_name" optionValue="id" placeholder="State"
                                    class="w-full text-red-500 md: border-color"
                                    @change="salaryStore.getSelectoption('state', opt3)" />
                            </div>
                            <div class="col">
                                <Dropdown v-model="opt5" editable :options="salaryStore.dropdownFilter.legalEntity"
                                    optionLabel="client_name" optionValue="id" placeholder="Legal Entity"
                                    class="w-full text-red-500 md: border-color"
                                    @change="salaryStore.getSelectoption('client_name', opt5)" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10" :value="salaryStore.eligbleEmployeeSource"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                v-model:selection="usePayroll.salaryStructure.assignedEmployees"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column selectionMode="multiple" headerStyle="width: 1.5rem"></Column>
                <Column field="user_code" header="Employee Name" style="min-width: 8rem"></Column>
                <Column field="name" header="Employee Name" style="min-width: 12rem"></Column>
                <Column field="department_name" header="Department " style="min-width: 12rem"></Column>
                <Column field="designation" header="Designation " style="min-width: 20rem"></Column>
                <Column field="work_location" header="Location " style="min-width: 12rem"></Column>
                <Column field="client_name" header="Legal Entity" style="min-width: 20rem"></Column>
            </DataTable>
        </div>
        <div class="float-right my-4">
            <div class="flex">
                <button @click=" assignEmployee = false" class="btn btn-orange-outline">Cancel</button>
                <button class="btn btn-orange mx-2" @click=" assignEmployee = false">Save</button>
            </div>
        </div>
    </Dialog> -->
    <div class="grid grid-cols-9">
        <div class="col-span-9 gap-1 flex flex-col py-2 box-border">
            <p class="font-['poppins'] font-semibold text-[16px]">
                New Salary Structure
            </p>
            <p class="font-['poppins'] text-[14px] font-normal">
                Create custom salary package by selecting the relevant components and configuring their corresponding calculations.
            </p>
        </div>
       <div class="col-span-4  flex flex-col py-2 box-border gap-2">
            <p class="font-['poppins'] font-medium text-[16px]">Structure Details </p>
            <p class="font-['poppins'] font-medium text-[16px]">Structure Name<span class="text-[#C4302B]">*</span>
            </p>
            <InputText v-model="usePayroll.salaryStructure.structureName" placeholder="Structure Name" type="text"
            class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" 
            :class="[newsalV$.structureName.$error ? 'p-invalid' : '']"
            />
            <span v-if="newsalV$.structureName.$error" class="font-semibold text-red-400 fs-6">
                {{ newsalV$.structureName.$errors[0].$message }}
            </span>
            <p class="font-['poppins'] font-medium text-[16px]">Description<span class="text-[#C4302B]">*</span>
            </p>
           <div class="w-[100%]">
            <Textarea v-model="usePayroll.salaryStructure.description" placeholder="Description"  class="border-[1px] p-2 box-border border-[#e6e6e6]" rows="3" cols="30"
            :class="[newsalV$.description.$error ? 'p-invalid' : '']"
            />
           </div>
           <span v-if="newsalV$.description.$error" class="font-semibold text-red-400 fs-6">
            {{ newsalV$.description.$errors[0].$message }}
        </span>
          <div class="w-[100%] grid grid-cols-4 py-2 box-border">
            <p class="col-span-4 font-['poppins'] font-semibold text-[16px]">PF & ESI Configuration</p>
            <div class="col-span-4 py-2 box-border flex">
                <input v-model="usePayroll.salaryStructure.pf" type="checkbox" name="" class="form-check-input mr-3" id=""
                style="width: 20px; height: 20px;" value="1">
                <p class="font-['poppins'] text-[16px] font-normal">
                    This salary structure includes the option for Provident Fund (PF) contributions.
                </p>
            </div>
            <div class="col-span-4 py-2 box-border flex">
                <input v-model="usePayroll.salaryStructure.esi" value="1" type="checkbox" name="" class="form-check-input mr-3" id=""
                style="width: 20px; height: 20px;">
                <p class="font-['poppins'] text-[16px] font-normal">
                    This salary structure includes coverage for Employee State Insurance (ESI).                </p>
            </div>
            <div class="col-span-4 py-2 box-border flex">
                <input value="1" v-model="usePayroll.salaryStructure.tds" type="checkbox" name="" class="form-check-input mr-3" id=""
                style="width: 20px; height: 20px;">
                <p class="font-['poppins'] text-[16px] font-normal">
                    This salary structure is subject to TDS (Tax Deducted at Source).
                    </p>
            </div>
            <div class="col-span-4 py-2 box-border flex">
                <input v-model="usePayroll.salaryStructure.fbp" type="checkbox" name="" class="form-check-input mr-3" id=""
                style="width: 20px; height: 20px;">
                <p class="font-['poppins'] text-[16px] font-normal">
                    This structure is eligible for Flexible Benefit Plan (FBP)
                </p>
            </div>
          </div>
       </div>
       <div class="col-span-5 flex flex-col py-2 box-border gap-2">
        <div class="w-[100%] flex justify-between px-2 box-border">
            <div class="flex justify-center items-center">
                <p class="font-['poppins'] font-semibold text-[16px]">
                    Salary Components
                </p>
            </div>
            <button  @click="newSalStructSidebar=true" class="font-medium border-[1px] border-[#dddd] !w-[200px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[16px] flex justify-center items-center gap-2" ><i class="pi pi-plus "></i>Add Component</button>
        </div>
        <div class="w-[100%]">
            <DataTable  :value="usePayroll.selectedarray">
                <Column field="comp_name" header="Components" class="text-[16px] font-['poppins'] font-normal"></Column>
                <Column field="calculation_desc" header="Amount/Calculation"  class="text-[16px] font-['poppins'] font-normal"></Column>
                <Column field="action" header="Action"  class="text-[16px] font-['poppins'] font-normal">
                <template #body="{data}">
                    <i class="pi pi-ellipsis-v"></i>
                </template>
                </Column>
            </DataTable>
        </div>
        <div class="w-[100%]">
            <Dropdown optionLabel="value" optionValue="value"
            placeholder="Manage Employees"
            class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium" />
        </div>
       </div>
       <div class="col-span-9 flex justify-center items-center gap-2 py-2 box-border">
        <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                    
        <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
        @click="validateNewSalStruct(),usePayroll.saveNewsalaryStructure(usePayroll.salaryStructure)"
        >Save</button>
       </div>
    </div>
     <!-- NEW SALARY STRUCTURE SIDEBAR -->
     <Sidebar v-model:visible="newSalStructSidebar" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Salary Components </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="newSalStructSidebar= false"></i>
        <div class="my-4 grid grid-cols-6">
            <DataTable  v-model:selection="usePayroll.localSalComps" dataKey="id"  class="col-span-6" :value="usePayroll.paygroupDetails">
                <Column selectionMode="multiple" class="" headerStyle="width: 3rem"></Column>
                <Column  field="comp_name" header="Name"></Column>
                <Column  field="comp_type" header="Type"></Column>
                <Column  field="calculation_desc" header="Type Of Calculation"></Column>
            </DataTable>
            <div class="col-span-6 flex justify-center items-center gap-2 my-4">
                <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                
                <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
              @click="usePayroll.saveLocalSalComponents(usePayroll.localSalComps),newSalStructSidebar= false"  >Save</button>
            </div>
        </div>
    </Sidebar>
</template>

<script setup>
import { ref, onMounted,computed } from "vue";
import { FilterMatchMode } from 'primevue/api';
import { usePayrollMainStore } from '../../../stores/payrollMainStore';
import { usePayrollHelper } from '../../../stores/payrollHelper';
import { useRouter, useRoute } from "vue-router";
import { salaryAdvanceSettingMainStore } from "../../../../salary_loan_setting/stores/salaryAdvanceSettingMainStore";
import { Service } from "../../../../Service/Service";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

const router = useRouter();
const route = useRoute();
const helper = usePayrollHelper()
const salaryStore = salaryAdvanceSettingMainStore()
const service=Service()
const usePayroll=usePayrollMainStore()
const newSalStructSidebar=ref(false)
//new salary structure form validation
const newsalstructRules=computed(()=>{
    return{
        structureName:{required:helpers.withMessage('Structure Name is Required',required)},
        description:{required:helpers.withMessage('Description is Required',required)},
        }
})
const newsalV$=useValidate(newsalstructRules,usePayroll.salaryStructure)
function validateNewSalStruct()
{
    newsalV$.value.$validate()
    if(!newsalV$.value.$error)
    {
        console.log('Form validation success')
        newsalV$.value.$reset()
    }
    else
    {
        console.log('Form Validation Failed')
    }
}
onMounted(async () => {
    console.log(route.params.id);
   await usePayroll.getsalaryStructure()
    service.current_session_client_id().then((res) => {
      usePayroll.salaryStructure.client_id=res.data
        console.log(res.data,'current_user_client_id sd');
    });
})



const addSalaryComponents = ref(false)
const assignEmployee = ref(false)
const selectedComponents = ref()



const sampleDataVal=ref([{
    components:'Basic',
    amt_cal:'40% of CTC',
   
},
{
    components:'HRA',
    amt_cal:'20% of CTC',
   
},
{
    components:'Salary Advance',
    amt_cal:'40% of CTC',
   
},
{
    components:'Special Allowance',
    amt_cal:'40% of CTC',
   
}  ,
{
    components:'ESI',
    amt_cal:'40% of CTC',
   
}  
])

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const opt = ref()
const opt1 = ref()
const opt2 = ref();
const opt3 = ref();
const opt4 = ref();
const opt5 = ref();
const opt6 = ref();


onMounted(() => {
    opt.value = "Department"
    opt1.value = "Designation"
    opt2.value = "Location"
    opt3.value = "State"
    opt4.value = "Branch"
    opt5.value = "Legal Entity"
    salaryStore.getDropdownFilterDetails()
})
</script>

<style>
:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
}

.p-dropdown-label.p-inputtext {
    color: var(--navy);
}

.border-color {
    color: #003154;
    /* border: 2px solid #3B82F6 !important; */
    border: 2px solid #003487 !important;
}
</style>
