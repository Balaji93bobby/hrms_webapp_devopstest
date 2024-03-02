<template>
    <LoadingSpinner v-if="employeePayslipStore.loading" class="absolute z-50 bg-white" />
    <div class="w-full">
    <div class="flex justify-between my-2">
        <!-- <h2 class="my-2 text-lg font-semibold">Salary Details</h2> -->
        <!-- {{ employeePayslipStore.salary_dropdown_details }} -->
        <div></div>
        <Dropdown v-model="employeePayslipStore.selected_dropdown_details" optionValue="year_dropdown" @change="employeePayslipStore.getEmployeeAllPayslipList(employeePayslipStore.selected_dropdown_details)" :options="employeePayslipStore.salary_dropdown_details" optionLabel="year_dropdown"  placeholder="Select Salary Details" class=" h-10 w-14rem" />
    </div>

        <DataTable :value="employeePayslipStore.array_employeePayslips_list" :paginator="true" :rows="10" dataKey="id"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]" sortField="PAYROLL_MONTH" :sortOrder="-1" :rowClass="rowClass"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
            v-model:filters="filters" filterDisplay="menu" :loading="loading2" :globalFilterFields="['name']">
            <template #empty> Salary Details Not Found.</template>
            <Column field="PAYROLL_MONTH" header="Month" :sortable="true">
                <template #body="slotProps">
                    {{ dayjs(slotProps.data.PAYROLL_MONTH).format('MMM-YYYY')  }}
                </template>
                <!-- <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                        class="p-column-filter" :showClear="true" />
                </template> -->
            </Column>

            <Column field="TOTAL_EARNED_GROSS" header="Gross Pay"></Column>
            <Column field="Reimbursements" header="Reimbursements">
                <template #body="slotProps">
                    {{ 0 }}
                </template>
            </Column>
            <Column field="TOTAL_DEDUCTIONS" header="Deductions"></Column>
            <Column field="NET_TAKE_HOME" header="Take Home"></Column>

            <Column header="Action">

                <template #body="slotProps">
                    <!-- <button class="p-2 mx-2 text-white bg-black rounded-md"
                                    @click="employeePayslipStore.getEmployeePayslipDetailsAsPDF('', slotProps.data.PAYROLL_MONTH)">Download</button> -->
                    <!-- bg-blue-500 -->
                    <button class="py-2 px-3 rounded-md"
                        @click="employeePayslipStore.getEmployeePayslipDetailsAsHTML(slotProps.data.user_code, slotProps.data.PAYROLL_MONTH)">
                        <i class="pi pi-eye"></i> </button>
                </template>

            </column>
        </DataTable>

    </div>
    <!-- <div class="d-flex justify-content-end">
        <Button class="mb-2 btn btn-primary" label="Submit" />
    </div> -->
    <!-- dialog for show details -->

    <Sidebar position="right" v-model:visible="employeePayslipStore.canShowPayslipView"
        v-if="employeePayslipStore.canShowPayslipView" modal header="Payslip" :style="{ width: '60vw !important' }">

        <template #header>
            <div class=" bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0 ">
                <!-- <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold relative">
               Reports</h1> -->
                <button class=" flex items-center p-2 absolute top-5 border-[1px] mx-2 text-white  rounded-md h-[33px] "
                    @click="employeePayslipStore.getEmployeePayslipDetailsAsPDF('', employeePayslipStore.Payroll_month)"> <i
                        class="pi pi-download"></i></button>
                        <!-- <button @click="compareObjectKeys(employeePayslipStore.paySlipHTMLView.data.earnings,employeePayslipStore.paySlipHTMLView.data.compensatory_data)" >btn</button> -->
            </div>
        </template>



        <div class=" flex justify-center w-[100%] my-3 rounded-lg">
            <!-- {{employeePayslipStore.paySlipHTMLView.data.personal_details}} -->
            <div class="w-[95%] h-[90%] shadow-lg p-4 ">
                <div class="w-[100%] flex justify-between">
                    <div class="flex flex-col">
                        <h1 class=" text-[25px] flex items-center ">PAYSLIP <span class=" text-gray-500 text-[25px]">
                                {{ employeePayslipStore.paySlipHTMLView.data.date_month.Month }}
                                {{ employeePayslipStore.paySlipHTMLView.data.date_month.Year }}</span></h1>
                        <h2 class=" text-[16px] mt-[10px] text-[#000] font-semibold "
                            v-for="item in employeePayslipStore.paySlipHTMLView.data.client_details" :key="item">
                            {{ item.client_fullname }}</h2>
                        <p class=" w-[300px] mt-[10px]"
                            v-for="item in employeePayslipStore.paySlipHTMLView.data.client_details" :key="item">{{
                                item.address }}</p>
                    </div>
                    <div v-for="item in employeePayslipStore.paySlipHTMLView.data.client_details" :key="item">
                        <img :src="`${item.client_logo}`" alt="testing" class="w-[200px]">
                    </div>
                </div>
                <div class="mt-[30px]">
                    <h1 class="font-semibold  text-[16px] my-[16px]"
                        v-for="item in employeePayslipStore.paySlipHTMLView.data.personal_details" :key="item"> Employee
                        Name : {{ item.name }}</h1>
                    <div class="border-[1.5px] border-[#000] my-[12px]"></div>
                    <div class="mx-2 row border-b-[1px] border-[gray] py-2"
                        v-for="item in employeePayslipStore.paySlipHTMLView.data.personal_details" :key="item">
                        <div class="col-3">
                            <p class="">Employee Code</p>
                            <p class=" text-[#000] text-[12px]">{{ item.user_code ? item.user_code : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>Date Joining</p>
                            <p class=" text-[#000]">{{ item.doj ? dayjs(item.doj).format('DD-MMM-YYYY') : '-' }} </p>
                        </div>
                        <div class="col-3">
                            <p>Department</p>
                            <p class=" text-[#000]">{{ item.department_name ? item.department_name : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>Designation</p>
                            <p class=" text-[#000]">{{ item.designation ? item.designation : '-' }}</p>
                        </div>
                    </div>
                    <div class="mx-2 row border-b-[1px] border-[gray] py-2"
                        v-for="item in employeePayslipStore.paySlipHTMLView.data.personal_details" :key="item">
                        <div class="col-3">
                            <p>Payment Mode</p>
                            <p class=" text-[#000]"> {{ item.bank_account_number ? "Bank" : "cheque" }}</p>
                        </div>
                        <div class="col-3">
                            <p>Bank Name</p>
                            <p class=" text-[#000]">{{ item.bank_name ? item.bank_name : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>Bank Account</p>
                            <p class=" text-[#000]">{{ item.bank_account_number ? item.bank_account_number : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>Bank ISFC</p>
                            <p class=" text-[#000]">{{ item.bank_ifsc_code ? item.bank_ifsc_code : '-' }}</p>
                        </div>
                    </div>
                    <div class="py-2 mx-2 row" v-for="item in employeePayslipStore.paySlipHTMLView.data.personal_details"
                        :key="item">
                        <div class="col-3">
                            <p>PAN</p>
                            <p class=" text-[#000]"> {{ item.pan_number ? item.pan_number : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>ESIC</p>
                            <p class=" text-[#000]">{{ '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>UAN</p>
                            <p class=" text-[#000]">{{ item.uan_number ? item.uan_number : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>EPF Number</p>
                            <p class=" text-[#000]">{{ item.epf_number ? item.epf_number
                                : '-' }}</p>
                        </div>
                    </div>
                    <div class="border-[1.5px] border-[#000] my-[12px]"></div>
                </div>

                <div class="">
                    <h1 class="font-semibold  text-[16px] my-[16px]">LEAVE DETAILS</h1>
                    <div class="border-[1.5px] border-[#000] my-[12px]"></div>

                    <div class="py-2 mx-2 row">
                        <div class="col-3">
                            <p class=" text-[#000]">Leave Types</p>
                            <p class=" text-[#000]" v-for="item in employeePayslipStore.paySlipHTMLView.data.leave_data"
                                :key="item">{{ item.leave_type ? item.leave_type : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p class=" text-[#000]">Opening Balance</p>
                            <p class=" text-[#000]" v-for="item in employeePayslipStore.paySlipHTMLView.data.leave_data"
                                :key="item">{{ item.opening_balance ? item.opening_balance : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p class=" text-[#000]">Availed</p>
                            <p class=" text-[#000]" v-for="item in employeePayslipStore.paySlipHTMLView.data.leave_data"
                                :key="item">{{ item.availed ? item.availed : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p class=" text-[#000]">Closing Balance</p>
                            <p class=" text-[#000]" v-for="item in employeePayslipStore.paySlipHTMLView.data.leave_data"
                                :key="item">{{ item.closing_balance ? item.closing_balance : '-' }}</p>
                        </div>
                    </div>


                </div>

                <div class="">
                    <h1 class="font-semibold  text-[16px] my-[16px]">SALARY DETAILS</h1>
                    <div class="border-[1.5px] border-[#000] my-[12px]"></div>
                    <div class="py-2 mx-2 row" v-for="item in employeePayslipStore.paySlipHTMLView.data.salary_details"
                        :key="item">
                        <div class="col-3">
                            <p>ACTUAL PAYABLE DAYS</p>
                            <p class=" text-[#000]">{{ item.month_days ? item.month_days : '-' }}</p>

                        </div>
                        <div class="col-3">
                            <p>TOTAL WORKING DAYS</p>
                            <p class=" text-[#000]">{{ item.worked_Days ? item.worked_Days : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>LOSS OF PAY DAYS</p>
                            <p class=" text-[#000]">{{ item.lop ? item.lop : '-' }}</p>
                        </div>
                        <div class="col-3">
                            <p>ARREAR DAYS PAYABLE</p>
                            <p class=" text-[#000]">{{ item.arrears_Days ? item.arrears_Days : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 py-2 border-y-[1px] border-[gray] mx-2">
                    <div class="col-7 border-r-[1.4px] border-[gray] relative">
                        <div class="row">
                            <div class="col-6">
                                <h1 class="font-semibold text-[#000] ">Earnings</h1>
                                <h1 class="flex items-center my-3"
                                    v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.earnings[0]"
                                    :key="index"
                                    :class="[key == 'Total Earnings' ? `text-black font-semibold` : 'text-black']"> {{ key
                                    }} <span v-if="key == 'Total Earnings'" class="font-semibold text-black">(A)</span>
                                </h1>
                            </div>
                            <!-- {{ employeePayslipStore.paySlipHTMLView.data.earnings[0] }} -->
                            <div class="col-2 relative">
                                <h1 class="font-semibold text-right text-[#000] font-['poppins']"
                                    v-if="employeePayslipStore.paySlipHTMLView.data.compensatory_data[0]">Fixed</h1>
                                <h1 v-for="(value, key, index) in  employeePayslipStore.paySlipHTMLView.data.compensatory_data[0]"
                                    :key="index" class="mt-[12px] !text-right text-[#000]" :class="[key == 'Total Earnings' ? ' absolute bottom-4 right-3' : '']"> {{  value }} </h1>
                            </div>

                            <div class="col-2">
                                <h1 class=" font-semibold text-right text-[#000] font-['poppins']"
                                    v-if="employeePayslipStore.paySlipHTMLView.data.arrears[0] != ''">Arrears</h1>
                                <h1 v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.arrears[0]"
                                    :key="index" class="mt-[12px] text-[#000]">{{ value }}</h1>
                            </div>
                            <div class="col-2">
                                <h1 class="font-semibold text-right text-[#000]">Earned</h1>
                                <h1 v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.earnings[0]"
                                    :key="index" class="my-3 text-right text-[#000]"
                                    :class="[key == 'Total Earnings' ? 'text-black text-[14px] font-semibold' : '']"> {{
                                        value }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <table border="2" class=" w-[100%]">
                            <tr class="w-[100%]">
                                <td>
                                    <h1 class="font-semibold  text-[#000] ">CONTRIBUTIONS</h1>
                                    <p class=" my-2 text-[#000] flex"
                                        v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.contribution[0]"
                                        :key="index"
                                        :class="[key == 'Total Contribution' ? 'text-[14px] text-[#000] font-semibold' : ' text-black']">
                                        {{ key }}
                                        <span v-if="key == 'Total Contribution'"
                                            class="text-black font-semibold text-[14px] "> (B)</span>
                                    </p>
                                </td>
                                <td>
                                    <h1 class="font-semibold ">&nbsp;</h1>
                                    <p class=" my-2 text-[#000] text-right"
                                        v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.contribution[0]"
                                        :key="index"
                                        :class="[key == 'Total Contribution' ? 'text-[13px] text-[#000] font-semibold' : ' text-black']">
                                        {{ value }}</p>
                                </td>
                            </tr>
                            <!-- {{ employeePayslipStore.paySlipHTMLView.data.Tax_Deduction}} -->
                            <tr class="w-[100%]">
                                <td>
                                    <h1 class="font-semibold ">Tax Deduction</h1>
                                    <p class=" my-2 text-[#000] flex items-center"
                                        v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.Tax_Deduction[0]"
                                        :key="index"
                                        :class="[key == 'Total Deduction' ? 'text-[14px] text-[#000] font-semibold' : ' text-black']">
                                        {{
                                            key }} <span v-if="key == 'Total Deduction'"
                                            class="text-[14px] text-[#000] font-semibold"> (C)</span></p>
                                </td>
                                <td>
                                    <h1 class="font-semibold ">&nbsp;</h1>
                                    <p class=" my-2 text-[#000] text-right"
                                        v-for="(value, key, index) in  employeePayslipStore.paySlipHTMLView.data.Tax_Deduction[0]"
                                        :key="index"
                                        :class="[key == 'Total Deduction' ? 'text-[14px] text-[#000] font-semibold' : ' text-black']">
                                        {{
                                            value }}</p>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="my-2 row w-[100%] "
                    v-for="(value, key, index) in employeePayslipStore.paySlipHTMLView.data.over_all[0]" :key="index">
                    <div class="my-2 col-6">
                        <p class="text-[#000]"
                            :class="[key == 'Net Salary Payable' || key == 'Net Salary in words' ? 'text-black text-[14px] font-semibold' : '']">
                            {{ key }}
                            <span v-if="key == 'Net Salary Payable'" class="font-semibold text-black ">(A-B-C)</span>
                        </p>
                    </div>
                    <div class="my-2 col-6">
                        <p class="text-[16px] text-[#000]"> <span class=" text-[16px] font-semibold text-right"
                                style=" font-family:sans-serif !important; " v-if="key == 'Net Salary Payable'"
                                :class="[key == 'Net Salary Payable' ? 'text-black text-[14px] font-semibold' : '']">₹
                            </span>{{ value }}</p>
                    </div>
                </div>
                <div>
                    <p class="mt-2 font-semibold flex text-[#000]">*** Note:All <span
                            class=" text-[16px]  text-[#000]">amounts displayed in this payslips are in</span> INR</p>
                    <p class="mt-[50px] font-semibold text-[#000]">**This is computer generated statement,does not require
                        signature.</p>
                </div>
                <div class="">
                    <div class="flex items-center float-right">
                        <p class="mx-2">Powered by </p>
                        <img :src="`${employeePayslipStore.paySlipHTMLView.data.date_month.abs_logo}`" alt=""
                            class="w-[140px] h-[50px]">
                    </div>
                </div>


            </div>


        </div>


    </Sidebar>
</template>

<script setup>
import dayjs from 'dayjs';

import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import { FilterMatchMode } from 'primevue/api';
import { useEmployeePayslipStore } from './EmployeePayslipsService';
import loadingSpinner from '../../../components/LoadingSpinner.vue'



const employeePayslipStore = useEmployeePayslipStore()

const viewpayslip = ref(true);
const op = ref();

onMounted(() => {
    console.log("EmployeePayslips,vue loaded");
    employeePayslipStore.getsalary_details_dropdown();
    // employeePayslipStore.getEmployeeAllPayslipList();

});

const filters = ref({
    PAYROLL_MONTH: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
});


function toggle(event) {
    op.value.toggle(event);
}


const rowClass = (data) => {
    return [{ '!hidden': data.payslip_release_status === 0 }];
};


const selectedindex = (data) => {

    let compensatorydata = employeePayslipStore.paySlipHTMLView.data.compensatory_data[0]

    Object.keys(compensatorydata).forEach(key => {
        if (compensatorydata.hasOwnProperty(data)) {
            return compensatorydata[key];
        } else {
            console.log('ll')
            return '';
        }
    });
}



function compareObjectKeys(array1, array2) {
  // Extract keys from the first object in array1
//   const keys1 = Object.keys(array1);

  // Extract keys from the first object in array2
//   const keys2 = Object.keys(array2);

console.log(array2,'array2');
console.log(array1,'array1')

for (const [key1, value1] of Object.entries(array1[0])) {

// for (const [key2, value2] of Object.entries(array2[0])) {

    if(array1[0][key1]){
        // console.log(value2,'value1');
    }else{
        console.log(0,'value1');
    }

// }

}

//   array1.forEach((value1,index1,key1)=>{
//     console.log(value1,key1,index1,'key1');

//     array2.forEach((value2,index2,key2)=>{

//         console.log(key2,'key2');


//     })

//   })

  // Sort the keys (if needed, to ensure order doesn't affect comparison)
//   keys1.sort();
//   keys2.sort();

  // Compare if both arrays of keys are identical
//   if (JSON.stringify(keys1) === JSON.stringify(keys2)) {
//     return true
//   } else {
//     return false
//   }
}




</script>

<style>.dropdown:hover .dropdown-content
{
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content
{
    padding: 0;
    z-index: 0 !important;
}

.p-sidebar-right .p-sidebar
{
    width: 50%;
    height: 100%;
}</style>


