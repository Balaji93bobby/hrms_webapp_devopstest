<template>
    <div class="w-full ">
        <div class="grid grid-cols-7 ">
            <div class="col-span-6 px-2 box-border">
                <p class="font-['poppins'] text-[14px] font-medium">Adhoc components refer to salary components that are not part of an employee's regular monthly pay and are typically added for a specific payroll month. These components can take various forms, such as a joining bonus, performance bonus, reimbursements, leave encashment at the end of the year, or penalty for late arrival.</p>
            </div>
            <div class="col-span-1 relative p-2 box-border">
                <i class="pi pi-search absolute top-5 right-[83%]"></i>
                <InputText class="w-full border-[1px] !pl-10 border-[#e6e6e6] box-border"  placeholder="Search...." />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-8  my-4 ">
            <div class="">
                <div class="flex justify-between  my-4">
                    <div class="flex justify-center items-center">
                        <p class="font-medium  font-['poppins'] text-[16px]">Earnings</p>
                    </div>
                    <button class="font-medium border-[1px] border-[#dddd] !w-[150px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[16px] flex justify-center items-center gap-2" @click="earnSidebar = true"><i class="pi pi-plus mx-1" style="font-size: 0.8rem"></i>Add new</button>
                </div>
                <!-- {{ usePayroll.adhocDetails  }} -->
                <div id="table">
                    <DataTable :value="usePayroll.adhocDetails">
                        <Column field="comp_name" header="Name"></Column>
                        <Column field="" header="State"></Column>
                        <Column field="sequence" header="Sequence"></Column>
                        <!-- <Column field="stateVal" header="State"></Column>
                        <Column field="sequenceVal" header="Sequence"></Column> -->
                        <!-- <Column field="is_taxable" header="Tax Status">
                            <template #body="{ data }">
                                <p>{{ helper.findIsSelected(data.is_taxable) }}</p>
                            </template>
                        </Column> -->
                        <Column header="Actions">
                            <template #body="{data}">
                                <i @click="usePayroll.editAdhocSalaryComponents(data,3,true),dailogAdhocComponents = true" class="pi pi-pencil cursor-pointer" style="font-size: 1rem"></i>
                                <i class="pi pi-trash mx-3 cursor-pointer" style="font-size: 1rem"></i>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>
            <div class="">
                <div>
                    <div class="flex justify-between mx-2 my-4">
                       <div class="flex justify-center items-center">
                        <p class="font-medium  font-['poppins'] text-[16px]">Off-Payroll Components</p>
                       </div>
                        <button class="font-medium border-[1px] border-[#dddd] !w-[150px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[16px] flex justify-center items-center gap-2" @click="payrollSidebar = true"><i class="pi pi-plus mx-1" style="font-size: 0.8rem"></i>Add new</button>
                    </div>
                    <!-- {{usePayroll.deuctionDetails  }} -->
                    <div id="table">
                        <!-- helper.filterSource(usePayroll.salaryComponentsSource, 2) -->
                        <DataTable :value="usePayroll.deuctionDetails" >
                            <Column field="comp_name" header="Name"></Column>
                            <Column field="after_gross" header="After Gross">
                                <!-- <template #body="{ data }">
                                    <p>{{ helper.findIsSelected(data.impact_on_gross) }}</p>
                                </template> -->
                                <template #body="{data}">
                                    <div v-if="data.after_gross">
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Yes</span>
                                    </div>
                                    <div v-else>
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">No</span>
                                    </div>
                                </template>
                            </Column>
                            <Column header="Actions">
                                <template #body="{data}">
                                    <i @click="usePayroll.editAdhocSalaryComponents(data,2,true),dailogDeduction = true" class="pi pi-pencil cursor-pointer" style="font-size: 1rem"></i>
                                    <i class="pi pi-trash mx-3" style="font-size: 1rem"></i>
                                </template>
                            </Column>
                        </DataTable>

                    </div>
                </div>
            </div>
           
        </div>
    </div>
    <Dialog v-model:visible="dailogDeduction" :modal="true" :closable="true"
        :style="{ width: '30vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Add New Deduction</span>
        </template>
        <div class="">
            <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Name</label>
            <InputText v-model="usePayroll.deductionComponents.comp_name" class="w-full" placeholder="Enter name  " />
        </div>
        <div class="my-4">
            <p class="block mb-2 font-semibold fs-6 text-gray-700 ">Does this have an impact on the gross amount</p>
            <div class="form-check form-check-inline my-2">
                <input v-model="usePayroll.deductionComponents.impact_on_gross" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="1" />
                <label class="form-check-label leave_type ms-2" for="full_day">Yes</label>
            </div>
            <div class="form-check form-check-inline mx-7">
                <input v-model="usePayroll.deductionComponents.impact_on_gross" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="0" />
                <label class="form-check-label leave_type ms-2" for="full_day">No</label>
            </div>
        </div>
        <div class="float-right">
            <div class="flex">
                <button @click="dailogDeduction = false" class="btn btn-orange-outline">Cancel</button>
                <button class="btn btn-orange mx-2" @click="usePayroll.saveNewSalaryComponent(2),dailogDeduction = false">Add</button>
            </div>
        </div>
    </Dialog>

    <Dialog v-model:visible="dailogAdhocComponents" :modal="true" :closable="true"
        :style="{ width: '30vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Add New Adhoc Components</span>
        </template>
        <div class="">
            <label for="metro_city" class="block mb-2 font-semibold fs-6 text-gray-700 ">Name</label>
            <InputText class="w-full" placeholder="Enter name" v-model="usePayroll.adhocComponents.comp_name" />
        </div>
        <div class="my-4">
            <p class="block mb-2 font-semibold fs-6 text-gray-700 ">Does this have tax status</p>
            <div class="form-check form-check-inline my-2">
                <input v-model="usePayroll.adhocComponents.is_taxable" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="1" />
                <label class="form-check-label leave_type ms-2" for="full_day">Yes</label>
            </div>
            <div class="form-check form-check-inline mx-7">
                <input v-model="usePayroll.adhocComponents.is_taxable" style="height: 20px;width: 20px;"
                    class="form-check-input" type="radio" name="esi" id="full_day" value="0" />
                <label class="form-check-label leave_type ms-2" for="full_day">No</label>
            </div>
        </div>
        <div class="float-right">
            <div class="flex">
                <button @click="dailogAdhocComponents = false" class="btn btn-orange-outline">Cancel</button>
                <button @click="usePayroll.saveNewSalaryComponent(3),dailogAdhocComponents = false" class="btn btn-orange mx-2">Add</button>
            </div>
        </div>
    </Dialog>

     <!-- EARNINGS SIDEBAR -->
     <Sidebar v-model:visible="earnSidebar" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Add New Adhoc Allowance </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="earnSidebar = false"></i>
        <div class="grid grid-cols-6 p-4 box-border">
            
             <div class="col-span-6 flex flex-col py-2 box-border">
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Name<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.adhocComponents.comp_name" placeholder="Enter Name" type="text"
                    :class="[adhocV$.comp_name.$error ? 'p-invalid' : '']"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" />
                        <span v-if="adhocV$.comp_name.$error" class="font-semibold text-red-400 fs-6">
                            {{ adhocV$.comp_name.$errors[0].$message }}
                        </span>
                </div>
             </div>
             <div class="col-span-6 flex justify-center py-2 box-border items-center">
                <p class="font-['poppins']  text-[16px] font-semibold ">Status<span class="text-[#C4302B]">*</span> </p>
             </div>
             <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input v-model="usePayroll.adhocComponents.is_taxable" style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn" id="" value="1"
                        :class="[adhocV$.is_taxable.$error ? 'p-invalid' : '']" 
                        />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">Taxable</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn" v-model="usePayroll.adhocComponents.is_taxable"
                        id="" value="0"
                        :class="[adhocV$.is_taxable.$error ? 'p-invalid' : '']" 
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">Tax Free</p>
                    </label>
                </div>
            </div>
            <span v-if="adhocV$.is_taxable.$error" class="font-semibold text-red-400 fs-6">
                {{ adhocV$.is_taxable.$errors[0].$message }}
            </span>
            <div class="col-span-6 flex justify-center items-center py-2 box-border">
                <p class="font-['poppins']  text-[16px] font-semibold ">Is the total payable tax for this component is deducted in the same month when it is paid out?<span class="text-[#C4302B]">*</span> </p>
             </div>
             <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn2" id="" value="1" v-model="usePayroll.adhocComponents.is_tptax_deduc_samemonth" 
                        :class="[adhocV$.is_tptax_deduc_samemonth.$error ? 'p-invalid' : '']" />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn2"  v-model="usePayroll.adhocComponents.is_tptax_deduc_samemonth"
                        id="" value="0"
                        :class="[adhocV$.is_tptax_deduc_samemonth.$error ? 'p-invalid' : '']" />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">No</p>
                    </label>
                </div>
            </div>
            <span v-if="adhocV$.is_tptax_deduc_samemonth.$error" class="font-semibold text-red-400 fs-6">
                {{ adhocV$.is_tptax_deduc_samemonth.$errors[0].$message }}
            </span>
             <div class="col-span-6 flex justify-center items-center py-2 box-border">
                <p class="font-['poppins']  text-[16px] font-semibold ">Would you prefer to make a separate payment for this component?<span class="text-[#C4302B]">*</span> </p>
             </div>
             <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn1" id="" value="1" v-model="usePayroll.adhocComponents.is_separate_payment_allowed" 
                        :class="[adhocV$.is_separate_payment_allowed.$error ? 'p-invalid' : '']"
                        />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1"  v-model="usePayroll.adhocComponents.is_separate_payment_allowed"
                        id="" value="0"
                        :class="[adhocV$.is_separate_payment_allowed.$error ? 'p-invalid' : '']"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">No</p>
                    </label>
                </div>
            </div>
            <span v-if="adhocV$.is_separate_payment_allowed.$error" class="font-semibold text-red-400 fs-6">
                {{ adhocV$.is_separate_payment_allowed.$errors[0].$message }}
            </span>
            <!-- buttons -->
            <div class="col-span-6 flex justify-center absolute bottom-7 left-[40%]  items-center gap-2">
                <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                
                <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                @click="validateAdhoc(),usePayroll.saveAdhocComponent(usePayroll.adhocComponents)">Add</button>
            </div>
        </div>
    </Sidebar>
    <!-- PAYROLL SIDEBAR -->
    <Sidebar v-model:visible="payrollSidebar" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Add New Deduction </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="payrollSidebar= false"></i>
        <div class="grid grid-cols-6 p-4 box-border">
            <div class="col-span-6 flex flex-col py-2 box-border">
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Name<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.deductionComponents.comp_name" placeholder="Enter Name" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[deductionV$.comp_name.$error ? 'p-invalid' : '']"
                        />
                        <span v-if="deductionV$.comp_name.$error" class="font-semibold text-red-400 fs-6">
                            {{ deductionV$.comp_name.$errors[0].$message }}
                        </span>
                </div>
             </div>
             <div class="col-span-6 flex justify-center items-center py-2 box-border">
                <p class="font-['poppins']  text-[16px] font-semibold ">Does this have an impact on the gross amount?<span class="text-[#C4302B]">*</span> </p>
             </div>
             <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input v-model="usePayroll.deductionComponents.is_deduc_impacton_gross" style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                    :class="[deductionV$.is_deduc_impacton_gross.$error ? 'p-invalid' : '']"
                        name="radiobtn1" id="" value="1" />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1" v-model="usePayroll.deductionComponents.is_deduc_impacton_gross"
                        id="" value="0"
                    :class="[deductionV$.is_deduc_impacton_gross.$error ? 'p-invalid' : '']"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[16px]">No</p>
                    </label>
                </div>
            </div>
            <span v-if="deductionV$.is_deduc_impacton_gross.$error" class="font-semibold text-red-400 fs-6">
                {{ deductionV$.is_deduc_impacton_gross.$errors[0].$message }}
            </span>
            <!-- buttons -->
            <div class="col-span-6 flex justify-center absolute bottom-7 left-[40%]  items-center gap-2">
                <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                
                <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                @click="validateDeduction(),usePayroll.saveDeductionComponent(usePayroll.deductionComponents)"
                >Add</button>
            </div>
        </div>
    </Sidebar>
</template>



<script setup>
import { ref, onMounted,computed } from 'vue';
import { usePayrollMainStore } from '../../../../stores/payrollMainStore';
import { usePayrollHelper } from '../../../../stores/payrollHelper';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

const usePayroll = usePayrollMainStore()
const helper = usePayrollHelper()

const dailogDeduction = ref(false)
const dailogAdhocComponents = ref(false)
const earnSidebar=ref(false)
const payrollSidebar=ref(false)

// adhoc component form validation
const adhocRules=computed(()=>{
    return{
        comp_name:{required:helpers.withMessage('Component Name is Required',required)},
        is_taxable:{required:helpers.withMessage('Value is Required',required)},
        is_tptax_deduc_samemonth:{required:helpers.withMessage('Value is Required',required)},
        is_separate_payment_allowed:{required:helpers.withMessage('Value is Required',required)}
         }
})
const adhocV$=useValidate(adhocRules,usePayroll.adhocComponents)
function validateAdhoc()
{
    adhocV$.value.$validate()
    if(!adhocV$.value.$error)
    {
        console.log('Form validation success')
        adhocV$.value.$reset()
    }
    else
    {
        console.log('Form Validation Failed')
    }
}
// deduction component form validation
const deductionRules=computed(()=>{
    return{
        comp_name:{required:helpers.withMessage('Component Name is Required',required)},
        is_deduc_impacton_gross:{required:helpers.withMessage('Value is Required',required)},
         }
})
const deductionV$=useValidate(deductionRules,usePayroll.deductionComponents)
function validateDeduction()
{
    deductionV$.value.$validate()
    if(!deductionV$.value.$error)
    {
        console.log('Form validation success')
        deductionV$.value.$reset()
    }
    else
    {
        console.log('Form Validation Failed')
    }
}
</script>
