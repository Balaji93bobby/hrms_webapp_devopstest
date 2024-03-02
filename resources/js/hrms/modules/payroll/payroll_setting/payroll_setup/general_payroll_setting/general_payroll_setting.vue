<template>
    <div class="w-full">
        <!-- Payroll and Attendance End Date Settings -->
        <div class="flex  pt-3 mx-6">
            <p  class=" font-['poppins'] font-semibold pb-3 text-[16px]">Payroll and Attendance End Date Settings</p>
            <!-- <div>
                <i class="pi pi-pencil" style="font-size: 1rem" @click="active_Btn"></i>
            </div> -->
        </div>
        <div class="grid grid-cols-12 gap-6 mx-6">
            <div class="col-span-5 p-3 bg-gray-100 rounded-lg  ">
                <div class="my-1">
                    <h5 class="my-2  font-medium font-['poppins'] text-[14px]">Pay Frequency<span class="text-[#C4302B]">*</span></h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <!-- :disabled="uesPayroll.disableDropdown" -->
                            <!-- <InputText class="w-full h-11" placeholder="Monthly"
                                v-model="uesPayroll.generalPayrollSettings.pay_frequency" /> -->

                                <!-- :disabled="uesPayroll.generalPayrollSettings ? uesPayroll.generalPayrollSettings.pay_frequency_id != 1 : null"  -->
                                <!-- {{ uesPayroll.generalPayrollSettings ? uesPayroll.generalPayrollSettings.pay_frequency_id != 1 : 'hello' }} -->
                                <Dropdown v-model="uesPayroll.generalPayrollSettings.pay_frequency_id"
                               optionLabel="name" optionValue="id" :options="uesPayroll.payroll_frequency"
                               
                                placeholder="Monthly" class="pl-2 !w-[300px] md:w-[230px] h-12" 
                                :class="[genV$.pay_frequency_id.$error ? 'p-invalid' : '']"/>
                                <!-- genV$.pay_frequency_id.$error -->
                               
                               
                        </div>
                    </div>
                    <span v-if="genV$.pay_frequency_id.$error" class="font-semibold  text-red-400 fs-6">
                        {{ genV$.pay_frequency_id.$errors[0].$message }}
                    </span>
                </div>
                
                <div class="my-4">
                    <h5 class="my-2 font-medium font-['poppins'] text-[14px]">
                        When would you like to start using the ABShrms payroll?<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <!-- <InputText class="w-full h-11" placeholder="November 2023"
                                v-model="uesPayroll.generalPayrollSettings.payperiod_start_month" /> -->
                                <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.payperiod_start_month"  dateFormat="dd-mm-yy"
                            :showIcon="true" style="width: 400px;border-radius: 0.375rem; " 
                            :class="[genV$.payperiod_start_month.$error ? 'p-invalid' : '']"/>
                          
                        </div>
                    </div>
                    <span v-if="genV$.payperiod_start_month.$error" class="font-semibold text-red-400 fs-6">
                        {{ genV$.payperiod_start_month.$errors[0].$message }}
                    </span>
                </div>
                <div class="my-4">
                    <h5 class="my-2 font-medium font-['poppins'] text-[14px]">
                        On which date did the pay peroid end in November?<span class="text-[#C4302B]">*</span>
                    </h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <!-- <InputText class="w-full h-11" placeholder="Text Placeholder"
                                v-model="uesPayroll.generalPayrollSettings.payperiod_end_date" /> -->
                                <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.payperiod_end_date" dateFormat="dd-mm-yy"
                            :showIcon="true" style="width: 400px;" 
                            :class="[genV$.payperiod_end_date.$error ? 'p-invalid' : '',]" />
                           
                        </div>
                    </div>
                    <span v-if="genV$.payperiod_end_date.$error" class="font-semibold text-red-400 fs-6">
                        {{ genV$.payperiod_end_date.$errors[0].$message }}
                    </span>
                </div>
                <div class="my-4">
                    <h5 class="my-2 font-medium font-['poppins'] text-[14px]">
                        The payment date for the peroid of Nov 1st to Nov 30th?<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <!-- <InputText class="w-full h-11" placeholder="December 01"
                                v-model="uesPayroll.generalPayrollSettings.payment_date" /> -->
                              
                            <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.payment_date" dateFormat="dd-mm-yy"
                            :showIcon="true" style="width: 400px;" 
                            :class="[genV$.payment_date.$error ? 'p-invalid' : '',]" />
                           
                        </div>
                    </div>
                    <span v-if="genV$.payment_date.$error" class="font-semibold text-red-400 fs-6">
                        {{ genV$.payment_date.$errors[0].$message }}
                    </span>
                </div>
            </div>

            <div class="col-span-7 p-3 rounded-lg border-[1px] border-[#dddd]">
                <div class="p-2 bg-orange-100 rounded mt-2" v-if="active == 2">
                    This change is of most importance and has a widespread impact on the salaries of all employees. We strongly advise you to reach out to the support team for further clarification.
                </div>

                <h6 class="my-2 font-medium font-['poppins'] text-[14px]">
                    The finalized payroll peroid is <strong>JAN 1 - JAN 31</strong>
                </h6>

                <div class="mb-6  mt-4 w-full" >
                    <DataTable  :value="payArr"  style="background-color: none;">
                        <Column field="nameVal" header="" class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="feb" header="Feb" class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="mar" header="Mar" class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="apr" header="Apr" class="font-medium font-['poppins'] text-[14px]"></Column>
                    </DataTable>
                </div>
                <div class="mx-4">
                    <p class="font-medium font-['poppins'] text-[14px]">Please Note that for month of February, the number of pay days will be adjusted to 28 days unstead of
                        the standard 30 or 31 days ,As a result salary for employees will be calculated using the formula &nbsp;&nbsp;
                        SALARY * 28/28</p>
                </div>
            </div>
        </div>
         

        <!-- Attendance Cut-Off Cycle -->
        <div class="flex justify-between py-3 mx-6">
            <p class="font-['poppins'] font-semibold text-[16px]">Attendance Cut-Off Cycle</p>
        </div>
        <div class="grid grid-cols-12 gap-6 mx-6">
            
            <div class="col-span-5 p-3 bg-gray-100 rounded-lg  ">
                <div class="my-1">
                    <h6 class="my-2 font-medium font-['poppins'] text-[14px]">
                        Select the attendance cut-off peroid in a month<span class="text-[#C4302B]">*</span>
                    </h6>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <!-- <Dropdown class="w-full h-11 " placeholder="select"
                                v-model="uesPayroll.generalPayrollSettings.att_cutoff_period_id" /> -->
                                <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.attendance_cutoff_date" dateFormat="dd-mm-yy"
                                :showIcon="true" style="width: 400px;" 
                                :class="[genV$.attendance_cutoff_date.$error ? 'p-invalid' : '',]" />
                               
                        </div>
                    </div>
                    <span v-if="genV$.attendance_cutoff_date.$error" class="font-semibold text-red-400 fs-6">
                        {{ genV$.attendance_cutoff_date.$errors[0].$message }}
                    </span>
                </div>
                <!-- <div class=" p-4 my-2 bg-red-700 rounded-lg  border-1 shadow-sm"> -->
                    <!-- <div class="my-4"> -->
                        <!-- <h1 style="color: #4E4E4E;">4E4E4E</h1> -->
                        <!-- <h6 class="my-2 fs-14 font-semibold text-black-alpha-70">
                            Select the attendance cut-off peroid in a month
                        </h6>
                        <div class="flex gap-8 justify-evenly">
                            <div class="w-full">
                                <Dropdown class="w-full h-11 " placeholder="select"
                                    v-model="uesPayroll.generalPayrollSettings.att_cutoff_period_id" />
                            </div>
                        </div>
                    </div> -->

                    <div class="my-4 ">
                        <div class="grid grid-cols-6">
                            <div class="col-span-6">
                                <h5 class="my-2 font-medium font-['poppins'] text-[14px]" style="line-height: 16px;">
                                    Do you want Pay period same as Attendance Period?<span class="text-[#C4302B]">*</span>
                                </h5>
                            </div>
                            <div class="col-span-6 d-flex justify-content-start align-items-center">
                                <div class="mx-2 d-flex justify-content-between align-items-center ">
                                    <input style="height: 18px; width: 18px" class="form-check-input" type="radio" name="radiobtn"
                                        id="" value="1"
                                        v-model="uesPayroll.generalPayrollSettings.is_payperiod_same_att_period"
                                        :class="[genV$.is_payperiod_same_att_period.$error ? 'p-invalid' : '']" />
                                    <label class="ml-2 font-bold form-check-label leave_type fs-13" for="">Yes</label>
                                </div>
                                <div class="d-flex justify-content-between align-items-center ">
                                    <input style="height: 18px; width: 18px" class="form-check-input" type="radio" name="radiobtn"
                                        id="" value="0"
                                        v-model="uesPayroll.generalPayrollSettings.is_payperiod_same_att_period"
                                        :class="[genV$.is_payperiod_same_att_period.$error ? 'p-invalid' : '',]" />
                                    <label class="ml-2 font-bold form-check-label leave_type fs-13" for="">No</label>
                                </div>
                               
                            </div>
                        </div>
                        <span v-if="genV$.is_payperiod_same_att_period.$error" class="font-semibold text-red-400 fs-6">
                            {{ genV$.is_payperiod_same_att_period.$errors[0].$message }}
                        </span>
                    </div>
                <!-- </div> -->
                    <div class="my-4">
                        <div class="grid grid-cols-4">
                            <div class="col-span-2 flex flex-col">
                                <p class="font-['poppins'] font-medium text-[14px]">Attendance Start date<span class="text-[#C4302B]">*</span></p>
                                <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.attendance_start_date" 
                                :showIcon="true" dateFormat="dd-mm-yy" style="width: 200px;" 
                                :class="[genV$.attendance_start_date.$error ? 'p-invalid' : '']" />
                                <span v-if="genV$.attendance_start_date.$error" class="font-medium text-red-400 fs-6">
                                    {{ genV$.attendance_start_date.$errors[0].$message }}
                                </span>
                               
                            </div>
                            <div class="col-span-2 flex flex-col">
                                  <p class="font-['poppins'] font-medium text-[14px]">Attendance End date<span class="text-[#C4302B]">*</span></p>
                                  <Calendar inputId="icon" v-model="uesPayroll.generalPayrollSettings.attendance_end_date" 
                                  :showIcon="true" dateFormat="dd-mm-yy" style="width: 200px;"
                                  :class="[genV$.attendance_end_date.$error ? 'p-invalid' : '']"  />
                                  <span v-if="genV$.attendance_end_date.$error" class="font-semibold text-red-400 fs-6">
                                    {{ genV$.attendance_end_date.$errors[0].$message }}
                                </span>
                                </div>
                        </div>
                    </div>
                <div class="my-4">
                    <div class=" flex justify-center items-center">
                        <div class="">
                            <input v-model="uesPayroll.generalPayrollSettings.is_attcutoff_diff_payenddate" type="checkbox" name="" class="form-check-input mr-3" value="1" id=""
                                style="width: 20px; height: 20px;">
                            <!-- <Checkbox class="mx-2" :binary="true" /> -->
                        </div>
                        <div class="text-[12px]">
                            The employee's attendance cut-off date differs from their pay peroid end
                            date&nbsp;&nbsp;&nbsp;
                            <span class="text-blue-400 text-[12px] underline">what is Attendance cut-off date?</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-7 p-3   rounded-lg  border-[1px] border-[#dddd]">
                <div class="bg-orange-100 p-2 rounded " v-if="active2 == 2 " >
                    <i class="fa fa-exclamation-triangle ml-2 mb-3" style="width: 25px;" aria-hidden="true" ></i>
                    The edit option has been disabled. Please contact the ABShrms Support Team for assistance.
                </div>
                <h1 class=" mt-4 font-medium font-['poppins'] text-[14px]">
                    The finalized payroll peroid is <strong>26th - 25th</strong>
                </h1>
                <div class="mb-6 mt-4 w-full">
                    <DataTable  :value="attendArr">
                        <Column field="nameVal" header="" class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="feb" header="Feb " class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="mar" header="Mar" class="font-medium font-['poppins'] text-[14px]"></Column>
                        <Column field="apr" header="Apr" class="font-medium font-['poppins'] text-[14px]"></Column>
                    </DataTable>
                </div>
                <div class="mx-4">
                    <p class="font-medium font-['poppins'] text-[14px]">Please note that for the month of February, the number of pay days will be adjusted to 28 days instead of the standard 30 or 31 days. As a result, the salary for employees will be calculated using the formula SALARY * 31/31.</p>
                </div>
            </div>
        </div>
        <!-- <div class="mx-6">
            <p>Pay Peroid Calculation</p>
        </div>
        <div class="grid grid-cols-12 gap-6 mx-6 my-4">
            <div class="col-span-4 p-4 my-4 bg-gray-100 border-gray-400 rounded-lg shadow-md border-1">
                <div class="my-4">
                    <h5 class="my-2 text-sm font-semibold">Pay days in month</h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <InputText class="w-full h-11" placeholder="Actual days in a month "
                                v-model="uesPayroll.generalPayrollSettings.paydays_in_month" />
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <h5 class="my-2 text-sm font-semibold">Pay days in month</h5>
                    <div class="flex gap-8 my-3 justify-between">
                        <div class="my-2">
                            <p>Include Week Off's</p>
                        </div>
                        <div class="flex">
                            <div class="mx-4">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                    value="1" v-model="uesPayroll.generalPayrollSettings.include_weekoffs" />
                                <label class="ml-2 font-bold form-check-label leave_type mx-2" for="">Yes</label>
                            </div>
                            <div>
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                    value="0" v-model="uesPayroll.generalPayrollSettings.include_weekoffs" />
                                <label class="ml-2 font-bold form-check-label leave_type" for="">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-8 justify-between">
                        <div class="">
                            <p>Include Holiday's</p>
                        </div>
                        <div class="flex">
                            <div class="mx-4">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                    value="" v-model="uesPayroll.generalPayrollSettings.include_holidays" />
                                <label class="ml-2 font-bold form-check-label leave_type" for="">Yes</label>
                            </div>
                            <div>
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                    value="" v-model="uesPayroll.generalPayrollSettings.include_holidays" />
                                <label class="ml-2 font-bold form-check-label leave_type" for="">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-8 p-4 my-4 leading-8 ">
                <div class="my-6">
                    <p style="line-height: 25px;">
                        <strong class="mr-2">NOTE :</strong>
                        Please note that calculating the number of days for a given pay period can
                        significantly impact salary deductions for loss of pay due to leave or other
                        reasons. For instance, consider the example of an employee whose monthly
                        salary is INR 30,000 and who takes one day of leave without pay.
                    </p>
                    <p style="line-height: 25px;">If we
                        calculate loss of pay based on a 30-day month, the deduction would be INR
                        30,000/30 = INR 1000.
                    </p>
                    <p style="line-height: 25px;">
                        However, if we exclude weekends from the calculation,
                        assuming 8 Saturdays and Sundays in the month, the effective number of working
                        days would be 30-8 = 22 days. In this case, the deduction for one day of loss
                        of pay would be INR 30,000/22 = INR 1364.
                    </p>
                </div>
            </div>
        </div>
        <div class="mx-6">
            <p>Currency and Compensation</p>
        </div>
        <div class="grid grid-cols-12 gap-6 mx-6 ">
            <div class="col-span-4  p-4 my-4 bg-gray-100 border-gray-400 rounded-lg shadow-md border-1">
                <div class="my-4">
                    <h5 class="my-2 text-sm font-semibold">Currency</h5>
                    <div class="flex gap-8 justify-evenly">
                        <div class="w-full">
                            <InputText class="w-full h-11" placeholder="Indian Rupee (&#8377;)"
                                v-model="uesPayroll.generalPayrollSettings.currency_type" />
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column justify-evenly">
                    <h5 class="text-sm font-semibold w-7">Description</h5>
                    <div class="flex gap-6  my-3">
                        <div class="flex  ">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                value="1" v-model="uesPayroll.generalPayrollSettings.remuneration_type" />
                            <label class="ml-2 text-sm font-semibold from-check-label leave_type" for="">Monthly</label>
                        </div>
                        <div class="">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="" id=""
                                value="0" v-model="uesPayroll.generalPayrollSettings.remuneration_type" />
                            <label class="ml-2 text-sm font-semibold form-check-label leave_type" for="">Daliy</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-8 p-4 my-4 ">
                <div class="my-2">
                    <strong>EXPLANATION :</strong>
                    <p class="my-2 text-gray-600">
                        <strong class="mr-2 text-black-70">Monthly :</strong>Monthly remuneration refers to the compensation
                        paid to an
                        employee
                        in exchange for their services, which is calculated and defined on a monthly
                        basis. This compensation serves as a form of payment for the employee's work
                        performed throughout the month.
                    </p>
                    <p class="my-3 text-gray-600">
                        <strong class="mr-2 text-black-70">Daily :</strong>Daily remuneration refers to the compensation
                        paid to an
                        employee for
                        their services, which is calculated on a per-day basis. It is the amount that
                        an employee is entitled to receive for each day of work performed as per the
                        agreed terms of their employment contract.
                    </p>
                </div>
            </div>
        </div>
        <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
                @click="uesPayroll.activeTab--">Previous</button>
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
                @click="uesPayroll.saveGeneralPayrollSettings(uesPayroll.generalPayrollSettings)">Save</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="uesPayroll.activeTab++">Next</button>
        </div> -->
        <div class="w-[100%] p-[24px] box-border flex justify-center items-center gap-0">
           <button class="flex justify-center items-center border-[#000] border-[1px] bg-[#fff] text-[#001820] text-[14px] rounded-md  mx-2 py-2 w-[80px] h-[33px]">Cancel</button>
           <button class="flex justify-center items-center bg-[#001820] text-[#ffff] text-[14px] rounded-md py-2  mx-2 w-[80px] h-[33px]"   @click="validateForm(), uesPayroll.saveGeneralPayrollSettings(uesPayroll.generalPayrollSettings)">Save</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted,computed } from "vue";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

import { usePayrollMainStore } from "../../../stores/payrollMainStore";
import { usePayrollHelper } from "../../../stores/payrollHelper";
import { Service } from "../../../../Service/Service";
import dayjs from "dayjs";


const uesPayroll = usePayrollMainStore()
const useHelper = usePayrollHelper()
const editAttendanceEndDate = ref(true)
const service=Service()
// const currentMonth=new Date().getMonth()+1

// console.log(currentMonth)

const formattedDate = ref()

const active = ref(1);
const active2 = ref(1);

const active_Btn = ref(false);
const active_Btn2 = ref(false);

// function active_Btn() {
//     active.value = 2;
//     console.log(active.value);
// }
// function active_Btn2() {
//     active2.value = 2;
//     console.log(active2);
// }

const daysArray = ref([])


const daysAsDropdown = (month, year) => {
    daysArray.value.splice(0, daysArray.value.length)
    const days = new Date(year, month, 0).getDate()
    for (let day = 1; day <= days; day++) {
        daysArray.value.push({ day: day });
    }

}


// const filteredOptions=uesPayroll.payroll_frequency.map(option => ({
//       label: option.name,
//       value: option.id,
//       disabled: option.status !== 1,
//     }))
//     const disableDropdown = ref(filteredOptions.every(option => option.disabled));

// const cities = ref([
//     { name: 'New York', code: 'NY' },
//     { name: 'Rome', code: 'RM' },
//     { name: 'London', code: 'LDN' },
//     { name: 'Istanbul', code: 'IST' },
//     { name: 'Paris', code: 'PRS' }
// ]);

// validation 
const generalRules = computed(()=>{
    return{
        pay_frequency_id:{required: helpers.withMessage('Frequency is required', required)},
        payperiod_start_month:{required: helpers.withMessage('Date is required', required)},
        payperiod_end_date:{required:helpers.withMessage('Date is Required',required)},
        payment_date:{required:helpers.withMessage('Date is Required',required)},
        attendance_cutoff_date:{required:helpers.withMessage('Date is Required',required)},
        is_payperiod_same_att_period:{required:helpers.withMessage('Value is Required',required)},
        attendance_start_date:{required:helpers.withMessage('Date is Required',required)},
        attendance_end_date:{required:helpers.withMessage('Date is Required',required)},
       
    }
})

const genV$ = useValidate(generalRules,uesPayroll.generalPayrollSettings)
 
function validateForm(){
    genV$.value.$validate();

    if(!genV$.value.$error){
        console.log('Form successfully submitted.')
        genV$.value.$reset()
    }

    else
    {
        console.log('Failed Validation')
    }
}
const payArr= ref([
    {
        nameVal:'Attendance Period',
        feb:'Feb 01 - Feb 28',
        mar:'Mar 01 - Mar 31',
        apr:'Apr 01 - Apr 30'
    },
    {
        nameVal:'Payment Days',
        feb:'28/28',
        mar:'31/31',
        apr:'30/30'
    }
])
const attendArr=ref([
    {
        nameVal:'Attendance Period',
        feb:'Jan 26 - Feb 25',
        mar:'Feb 26 - Mar 25',
        apr:'Mar 26 - Apr 25'
    },
    {
        nameVal:'Payment Days',
        feb:'31/31',
        mar:'31/31',
        apr:'31/31'
    }
])
const products = ref([
    {
        product: "Bamboo Watch",
        lastYearSale: 51,
        thisYearSale: 40,
        lastYearProfit: 54406,
        thisYearProfit: 43342,
    },
    {
        product: "Black Watch",
        lastYearSale: 83,
        thisYearSale: 9,
        lastYearProfit: 423132,
        thisYearProfit: 312122,
    },
    {
        product: "Blue Band",
        lastYearSale: 38,
        thisYearSale: 5,
        lastYearProfit: 12321,
        thisYearProfit: 8500,
    },
]);


onMounted(async () => {

    await uesPayroll.generalPayrollSettings.payperiod_start_month ? dayjs(uesPayroll.generalPayrollSettings.payperiod_start_month).format('MMM') : uesPayroll.generalPayrollSettings.payperiod_start_month
    await uesPayroll.getPayFreqData();
      uesPayroll.getCurrentGeneralPayrollSettings();
    service.current_session_client_id().then((res) => {
        uesPayroll.generalPayrollSettings.client_id = res.data;
        console.log(res.data,'current_user_client_id sd');
    });

    // for (let day = 1; day <= 31; day++) {
    //     daysArray.value.push({ day: day });
    // }
})


</script>

<style>
.fs-13
{
    font-size: 13.2px !important;
}

.v-enter-active,
.v-leave-active
{
    transition: opacity 0.3s ease;
}
.p-calendar-w-btn .p-datepicker-trigger
{
    background-color: #ffff !important;
    border: none;
}
.p-button 
{
    border-radius: 10%;
}
.p-calendar-w-btn .p-datepicker-trigger >.p-icon{
    width: 15px;
    height: 15px;
}
.v-enter-from,
.v-leave-to
{
    opacity: 0;
}
</style>
