<template>
    <LoadingSpinner v-if="managePayslipStore.loading" class="absolute z-50 bg-white " />
    <div class="flex justify-between ">
        <div>
            <h6 class="mb-2 text-lg font-semibold">Manage Employee Payslips</h6>
        </div>
        <div class="d-flex justify-content-end">
            <label for="" class="my-2 text-lg font-semibold">Select Month</label>
            <Calendar view="month" dateFormat="mm/yy" class="mx-4 " v-model="managePayslipStore.selectedPayRollDate"
                style=" border-radius: 7px; height: 38px;"
                @date-select="managePayslipStore.getAllEmployeesPayslipDetails(managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear())" />
            <!-- <Button class="h-10 mb-2 btn btn-orange" label="Generate" /> -->
            <!-- {{ managePayslipStore.array_employees_list.user_code.data.data }} -->
        </div>
    </div>
    <div class="my-4">

        <DataTable :value="managePayslipStore.array_employees_list" :paginator="true" :rows="10" dataKey="id"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
            v-model:filters="filters" filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
            <Column headerStyle="width: 3rem"></Column>
            <Column field="user_code" header="Employee Code" headerStyle="width: 3rem">
            </Column>
            <Column field="name" header="Employee Name"></Column>
            <Column field="email" header="Personal Mail"></Column>
            <Column field="is_payslip_released" header="Payslip Status">
                <template #body="slotProps">
                    <div class="d-flex flex-column">

                        <button class="btn z-0 border-[1px solid ] border-black "
                            v-if="slotProps.data.is_payslip_released == 1"
                            @click="showWithdraw_confimationDialog(slotProps.data.user_code)">withdraw</button>

                        <button class="bg-[#000] text-[white] rounded z-0" v-else style="padding: 4px 0 !important; margin-top: 10px;"
                            @click="showReleasePayslipConfirmationDialog(slotProps.data.user_code)">Release payslip</button>

                        <!-- {{slotProps.data.is_payslip_released}} -->
                        <h1 v-if="slotProps.data.is_payslip_released == 1" class="mt-2 text-success">
                            Released
                        </h1>
                        <h1 v-if="slotProps.data.is_payslip_released == 0 || slotProps.data.is_payslip_released == null"
                            class="mt-2 text-danger">
                            Not Released
                        </h1>
                        <!-- {{is_payslip_released}} -->
                    </div>

                </template>

            </Column>

            <Column field="is_payslip_mail_sent" header="Mail Status">
                <template #body="slotProps">
                    <div v-if="slotProps.data.is_payslip_mail_sent == 1">
                        <h1> Payslip sent</h1>
                    </div>
                    <div v-else>
                        <button class="bg-[#f9be00] text-white rounded p-2 z-0"
                            @click="showConfirmationDialog(slotProps.data.user_code)">Send Payslip</button>
                    </div>
                </template>
            </Column>
            <Column header="Action">
                <template #body="slotProps">
                            <button class="" type="button" @click="toggle"> <i class="pi pi-ellipsis-v" @click="saveusercode(slotProps.data.user_code)"></i>
                            </button>
                            <OverlayPanel ref="op"
                                style="width: 160px;margin-top:12px !important;margin-right: 20px !important; "
                                class="p-0 m-0 !z-0 ">
                                <div class="p-0 m-0 d-flex flex-column">
                                    <!-- bg-green-200 -->
                                    <button class="p-2 text-black fw-semibold hover:bg-gray-200 border-bottom-1"
                                    @click="showdownloadPayslipConfirmationDialog(slotProps.data.user_code)">Download</button>
                                    <!-- bg-blue-500 -->
                                    <button class="p-2 text-black fw-semibold hover:bg-gray-200"
                                    @click="showPaySlipHTMLView(slotProps.data.user_code)">View</button>
                                </div>
                            </OverlayPanel>
                        </template>
            </Column>



            <!-- <Column header="Action">
                <Button class="btn-success" label="Send Mail" @click="managePayslipStore.sendMail_employeePayslip(slotProps.data.user_code, selectedPayRollDate.selectDate.getMonth() + 1, selectedPayRollDate.selectDate.getFullYear() )" />
                <template #body="slotProps">
                    <button class="rounded btn-success" @click="showConfirmationDialog(slotProps.data.user_code)">Send Mail</button>
                </template>

            </Column> -->
        </DataTable>

        <!-- <button class="p-2 bg-black text-[12px] text-white mt-10" @click="viewpayslip = true">view</button> -->

    </div>


    <Dialog header="Confirmation" v-model:visible="show_dialogconfirmation"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content">

            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
            <span>Are you sure you want to send Mail ?</span>
        </div>

        <div class="float-right my-3">

            <Button class="py-2 btn-primary" label="Yes" icon="pi pi-check" @click="sendMail(selectedUserCode)"
                autofocus />

            <Button label="No" icon="pi pi-times" @click="show_dialogconfirmation = false" class="py-2 p-button-text"
                autofocus />

        </div>

    </Dialog>

    <!-- show withdraw button -->

    <Dialog header="Confirmation" v-model:visible="show_withdraw_dialogConfirmation"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content">

            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
            <span>Are you sure you want to send Mail ?</span>
        </div>

        <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

            <Button class="py-2 mr-3 btn-primary" label="Yes" icon="pi pi-check"
                @click="UpdateWithDrawStatus(selectedUserCode)" autofocus />

            <Button label="No" icon="pi pi-times" @click="show_withdraw_dialogConfirmation = false"
                class="py-2 p-button-text" autofocus />

        </div>

    </Dialog>

    <Dialog header="Confirmation" v-model:visible="show_releasePayslip_dialogconfirmation"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content">

            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
            <span>Are you sure you want to release payslip? {{ managePayslipStore.name }} </span>
        </div>

        <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

            <Button class="py-2 mr-3 btn-primary" label="Yes" icon="pi pi-check"
                @click="updatePayslipReleaseStatus(selectedUserCode)" autofocus />

            <Button label="No" icon="pi pi-times" @click="show_releasePayslip_dialogconfirmation = false"
                class="py-2 p-button-text" autofocus />

        </div>

    </Dialog>
    <Dialog header="Confirmation" v-model:visible="show_downloadPayslip_dialogconfirmation"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content">

            <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
            <span>Are you sure you want to download payslip? {{ managePayslipStore.name }} </span>
        </div>

        <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

            <Button class="py-2 mr-3 btn-primary" label="Yes" icon="pi pi-check"
                @click="downloadPayslip(selectedUserCode, selectedUsername)" autofocus />

            <Button label="No" icon="pi pi-times" @click="show_downloadPayslip_dialogconfirmation = false"
                class="py-2 p-button-text" autofocus />

        </div>

    </Dialog>

    <Sidebar position="right" v-model:visible="viewpayslip" modal header="Payslip" :style="{ width: '58vw' }">

        <button class=" flex items-center p-2 absolute top-5 border-[1px] mx-2 text-[#000]  rounded-md h-[33px] "
        @click="downloadPayslip(selectedUserCode, selectedUsername)"> <i class="pi pi-download"></i></button>


        <div class=" flex justify-center w-[100%] my-3 rounded-lg">
        <div class="w-[95%] h-[90%] shadow-lg p-4 ">
            <div class="w-[100%] flex justify-between">
                <div class="flex flex-col">
                    <h1 class=" text-[25px] ">PAYSLIP <span class=" text-gray-500 text-[25px]">{{managePayslipStore.paySlipHTMLView.data.date_month.Month}} </span></h1>
                    <h2 class=" text-[16px] mt-[10px] text-[#000]" v-for="item in managePayslipStore.paySlipHTMLView.data.client_details" :key="item">{{item.client_fullname }}</h2>
                    <p class=" w-[300px] mt-[10px]"  v-for="item in managePayslipStore.paySlipHTMLView.data.client_details" :key="item">{{ item.address}}</p>
                </div>
                <div v-for="item in managePayslipStore.paySlipHTMLView.data.client_details" :key="item">
                    <img :src="`${item.client_logo}`" alt="testing" class="w-[200px]">
                </div>
            </div>
            <div class="mt-[30px]">
                <h1 class="font-semibold  text-[16px] my-[16px]" v-for="item in managePayslipStore.paySlipHTMLView.data.personal_details" :key="item" > Employee Name : {{item.name }}</h1>
                <div class="border-[1.5px] border-[#000] my-[12px]"></div>
                <div class="mx-2 row border-b-[1px] border-[gray] py-2" v-for="item in managePayslipStore.paySlipHTMLView.data.personal_details" :key="item" >
                    <div class="col-3">
                        <p class="">Employee Code</p>
                        <p class=" text-[#000] text-[12px]" >{{ item.user_code? item.user_code : '-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Date Joining</p>
                        <p class=" text-[#000]">{{  item.doj? dayjs(item.doj).format('DD-MMM-YYYY')  : '-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Department</p>
                        <p class=" text-[#000]">{{ item.department_name? item.department_name:'-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Designation</p>
                        <p class=" text-[#000]">{{ item.designation ?item.designation : '-' }}</p>
                    </div>
                </div>
                <div class="mx-2 row border-b-[1px] border-[gray] py-2"  v-for="item in managePayslipStore.paySlipHTMLView.data.personal_details" :key="item">
                    <div class="col-3">
                        <p>Payment Mode</p>
                        <p class=" text-[#000]"  > {{item.bank_account_number ? "Bank" : "cheque" }}</p>
                    </div>
                    <div class="col-3">
                        <p>Bank Name</p>
                        <p class=" text-[#000]">{{item.bank_name? item.bank_name : '-'}}</p>
                    </div>
                    <div class="col-3">
                        <p>Bank Account</p>
                        <p class=" text-[#000]">{{ item.bank_account_number? item.bank_account_number:'-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Bank ISFC</p>
                        <p class=" text-[#000]">{{ item.bank_ifsc_code?item.bank_ifsc_code:'-' }}</p>
                    </div>
                </div>
                <div class="py-2 mx-2 row" v-for="item in managePayslipStore.paySlipHTMLView.data.personal_details" :key="item">
                    <div class="col-3">
                        <p>PAN</p>
                        <p class=" text-[#000]"> {{item.pan_number? item.pan_number : '-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>ESIC</p>
                        <p class=" text-[#000]">{{'-'}}</p>
                    </div>
                    <div class="col-3">
                        <p>UAN</p>
                        <p class=" text-[#000]">{{item.uan_number ?item.uan_number : '-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>EPF Number</p>
                        <p class=" text-[#000]">{{ item.epf_number ?  item.epf_number : '-' }}</p>
                    </div>
                </div>
                     <div class="border-[1.5px] border-[#000] my-[12px]"></div>
            </div>

            <div class="">
                <h1 class="font-semibold  text-[16px] my-[16px]">LEAVE DETAILS</h1>
                <div class="border-[1.5px] border-[#000] my-[12px]"></div>

                <div class="py-2 mx-2 row"  >
                    <div class="col-3">
                        <p>Leave Type</p>
                        <p class=" text-[#000]" v-for="item in managePayslipStore.paySlipHTMLView.data.leave_data"  :key="item" >{{ item.leave_type ? item.leave_type : '-' }}</p>
                    </div>
                    <div class="col-3" >
                        <p>Opening Balance</p>
                        <p class=" text-[#000]"  v-for="item in managePayslipStore.paySlipHTMLView.data.leave_data"  :key="item" >{{ item.opening_balance ?  item.opening_balance : '-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Availed</p>
                        <p class=" text-[#000]" v-for="item in managePayslipStore.paySlipHTMLView.data.leave_data"  :key="item" >{{ item.availed ? item.availed :'-' }}</p>
                    </div>
                    <div class="col-3">
                        <p>Closing Balance</p>
                        <p class=" text-[#000]" v-for="item in managePayslipStore.paySlipHTMLView.data.leave_data"  :key="item" >{{ item.closing_balance ?  item.closing_balance : '-' }}</p>
                    </div>
                </div>


            </div>

            <div class="">
                <h1 class="font-semibold  text-[16px] my-[16px]">SALARY DETAILS</h1>
                <div class="border-[1.5px] border-[#000] my-[12px]"></div>
                <div class="py-2 mx-2 row"  v-for="item in managePayslipStore.paySlipHTMLView.data.salary_details" :key="item" >
                    <div class="col-3">
                        <p>ACTUAL PAYABLE DAYS</p>
                        <p class=" text-[#000]">{{item.month_days  ? item.month_days : '-'}}</p>

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

            <div class="row mt-2 py-2 border-y-[1px] border-[gray] mx-2" >
                <div class="col-7 border-r-[1.4px] border-[gray]" >
                    <table class=" w-[100%]" >
                        <tr class="w-[100%]" >
                            <td>
                                <h1 class="font-semibold " >Earnings</h1>
                                <h1 class="my-3" v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.earnings[0]" :key="index" :class="[key == 'Total Earnings' ?'text-black text-[16px]':'text-black']"> {{ key }}</h1>
                            </td>

                            <td class="flex flex-col items-start pt-[2px]">
                            <h1 class="font-semibold">Fixed</h1>
                            <h1 v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.compensatory_data[0]" :key="index" class="mt-[12px] text-black" > {{ value }}</h1>
                            </td>

                            <td class=" flex flex-col items-start pt-[2px]" v-if=" managePayslipStore.paySlipHTMLView.data.arrears[0] != '' ">
                                <h1 class="font-semibold " >Arrears</h1>
                                <h1 v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.arrears[0]" :key="index" class="mt-[12px]">{{ value }}</h1>
                                <!-- <h1  v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.compensatory_data[0]" :key="index" class="my-3" >&nbsp;</h1> -->
                            </td>
                            <td v-if="managePayslipStore.paySlipHTMLView.data.earnings[0]"> <h1 class="font-semibold" >Earned</h1>
                            <h1 v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.earnings[0]" :key="index" class="my-3"  :class="[key == 'Total Earnings' ?'text-black text-[16px]':'']"> {{ value }}</h1>
                            <!-- <p class="my-2"  >&nbsp;</p> -->
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="col">
                    <table border="2" class=" w-[100%]">
                        <tr class="w-[100%]">
                            <td >
                                <h1 class="font-semibold ">CONTRIBUTIONS</h1>
                                <p class=" my-2 text-[#000]"  v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.contribution[0]" :key="index" >{{ key }}</p>
                            </td>
                            <td>
                                <h1 class="font-semibold ">&nbsp;</h1>
                                <p class=" my-2 text-[#000]" v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.contribution[0]" :key="index" >{{ value }}</p>
                            </td>
                        </tr>
                       <!-- {{ managePayslipStore.paySlipHTMLView.data.Tax_Deduction}} -->
                        <tr class="w-[100%]">
                            <td >
                                <h1 class="font-semibold ">Tax Deduction</h1>
                                <p class=" my-2 text-[#000]"  v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.Tax_Deduction[0]" :key="index" :class="[key == 'Total Deduction'? 'text-[18px] ' : ' text-black']" >{{ key }}</p>
                            </td>
                            <td>
                                <h1 class="font-semibold ">&nbsp;</h1>
                                <p class=" my-2 text-[#000]" v-for="(value, key, index) in  managePayslipStore.paySlipHTMLView.data.Tax_Deduction[0]" :key="index" :class="[key == 'Total Deduction'? 'text-[18px] ' : ' text-black']"  >{{ value }}</p>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="my-2 row w-[100%] " v-for="(value, key, index) in managePayslipStore.paySlipHTMLView.data.over_all[0]" :key="index" >
                <div class="my-2 col-5" ><p class="">{{ key }} </p></div>
                <div class="my-2 col-7">
                    <p class="text-[16px]"> <span class=" text-[16px]" style=" font-family:sans-serif !important;" v-if="key=='Net Salary Payable'">₹ </span> {{ value }}</p>
                </div>
            </div>
            <div>
                <p class="mt-2 ">*** Note:All amounts displayed in this payslips are in INR</p>
                <p class="mt-[50px]">**This is computer generated statement,does not require signature.</p>
            </div>
            <div class="">
                <div class="flex items-center float-right">
                    <p class="mx-2">Powered by </p>
                    <img :src="`${managePayslipStore.paySlipHTMLView.data.date_month.abs_logo}`" alt="" class="w-[140px] h-[50px]" >
                </div>
            </div>


        </div>

        <!-- <Button class="py-2 mr-3 btn-primary" label="Yes" icon="pi pi-check"
                @click="downloadPayslip(selectedUserCode, selectedUsername)" autofocus /> -->
       </div>
    </Sidebar>

    <!-- <dynamicPayslipv2 :source="payslipSource ? payslipSource : {}"/> -->
</template>

<script setup>
import dayjs from 'dayjs';
import { ref, onMounted, reactive, computed } from "vue";
import { useManagePayslipStore } from './ManagePayslipService';
import LoadingSpinner from '../../components/LoadingSpinner.vue'

const managePayslipStore = useManagePayslipStore();

const canShowPayslipHTMLView = ref(false);
const show_dialogconfirmation = ref(false);
const show_releasePayslip_dialogconfirmation = ref(false);
const show_downloadPayslip_dialogconfirmation = ref(false);

const show_withdraw_dialogConfirmation = ref(false);

const selectedPayRollDate = ref();
const op = ref();
const toggle = (event) => {
    op.value.toggle(event);
}
const selectedUserCode = ref();
const selectedUsername = ref();
const viewpayslip = ref(false);
const payslipSource = ref();

onMounted(() => {
    managePayslipStore.selectedPayRollDate = new Date()
    managePayslipStore.getAllEmployeesPayslipDetails(managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear())
});



async function showPaySlipHTMLView(selected_user_code) {
    console.log("Showing payslip html for (user_code, month): " + selected_user_code + " , " + parseInt(managePayslipStore.selectedPayRollDate.getMonth() + 1));

    await managePayslipStore.getEmployeePayslipDetailsAsHTML(selectedUserCode.value, managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear());
    viewpayslip.value = true;
    toggle()

}

function showConfirmationDialog(selected_user_code) {
    selectedUserCode.value = selected_user_code;
    show_dialogconfirmation.value = true;
}

function showReleasePayslipConfirmationDialog(selected_user_code) {
    selectedUserCode.value = selected_user_code;

    show_releasePayslip_dialogconfirmation.value = true;
    // toggle()
}

function saveusercode(selected_user_code){
    console.log("selected_user_code",selected_user_code);
    selectedUserCode.value = selected_user_code;

}


function showdownloadPayslipConfirmationDialog() {

    show_downloadPayslip_dialogconfirmation.value = true;
}

async function sendMail(selectedUserCode) {

    await managePayslipStore.sendMail_employeePayslip(selectedUserCode, managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear());
    show_dialogconfirmation.value = false;

}

async function updatePayslipReleaseStatus(selectedUserCode) {
    await managePayslipStore.updatePayslipReleaseStatus(selectedUserCode, managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear(), 1);
    show_releasePayslip_dialogconfirmation.value = false;

}
async function showWithdraw_confimationDialog(selected_user_code) {
    selectedUserCode.value = selected_user_code;
    show_withdraw_dialogConfirmation.value = true;
}
async function UpdateWithDrawStatus(selectedUserCode) {
    await managePayslipStore.UpdateWithDrawStatus(selectedUserCode, managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear(), 0);
    show_withdraw_dialogConfirmation.value = false;

}

async function downloadPayslip() {
    show_downloadPayslip_dialogconfirmation.value = false;
    await managePayslipStore.downloadPayslip(selectedUserCode.value, managePayslipStore.selectedPayRollDate.getMonth() + 1, managePayslipStore.selectedPayRollDate.getFullYear());
    toggle()

}



</script>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,200&display=swap");

.p-dialog-mask .p-component-overlay .p-component-overlay-enter {
    z-index: 0 !important;
}

.p-datatable .p-datatable-thead>tr>th {
    text-align: center;
    padding: 1rem 0.5rem;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    font-weight: 600;
    color: #fff;
    background: #003056;
    transition: box-shadow 0.2s;
    font-size: 13px;

    .p-column-title {
        font-size: 13px;
    }

    .p-column-filter {
        width: 100%;
    }

    #pv_id_2 {
        height: 30px;
    }

    .p-fluid .p-dropdown .p-dropdown-label {
        margin-top: -10px;
    }

    .p-dropdown .p-dropdown-label.p-placeholder {
        margin-top: -12px;
    }

    .p-column-filter-menu-button {
        color: white;
        margin-left: 10px;
    }

    .p-column-filter-menu-button:hover {
        color: white;
        border-color: transparent;
        background: #023e70;
    }
}

.p-column-filter-overlay-menu .p-column-filter-constraint .p-column-filter-matchmode-dropdown {
    margin-bottom: 0.5rem;
    visibility: hidden;
    position: absolute;
}

.p-button .p-component .p-button-sm {
    background-color: #003056;
}

.p-datatable .p-datatable-tbody>tr {
    font-size: 13px;

    .employee_name {
        font-weight: bold;
        font-size: 13.5px;
    }
}

.p-datatable .p-datatable-tbody>tr>td {
    text-align: left;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    padding: 1rem 0.6rem;
}


.pending {
    font-weight: 700;
}

.approved {
    font-weight: 700;
}

.p-button.p-component.p-button-success.Button {
    padding: 8px;
}

.rejected {
    font-weight: 700;
    color: #ff2634;
}

.p-button.p-component.p-button-danger.Button {
    padding: 8px;
}

.p-confirm-dialog-icon.pi.pi-exclamation-triangle {
    color: red;
}

.p-button.p-component.p-confirm-dialog-accept {
    background-color: #003056;
}

.p-button.p-component.p-confirm-dialog-reject.p-button-text {
    color: #003056;
}

.p-column-filter-overlay-menu .p-column-filter-buttonbar {
    padding: 1.25rem;
    position: absolute;
    visibility: hidden;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter-menu-button {
    color: white;
    border-color: transparent;
}

.p-column-filter-menu-button.p-column-filter-menu-button-open {
    background: none;
}

.p-column-filter-menu-button.p-column-filter-menu-button-active {
    background: none;
}

.p-datatable .p-datatable-thead>tr>th .p-column-filter {
    width: 55%;
}

/* For Sort */

.p-datatable .p-sortable-column:not(.p-highlight):hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:not(.p-highlight):hover .p-sortable-column-icon {
    color: white;
}

.p-datatable .p-sortable-column.p-highlight {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column.p-highlight:hover {
    background: #003056;
    color: white;
}

.p-datatable .p-sortable-column:focus {
    box-shadow: none;
    outline: none;
    color: white;
}

.p-datatable .p-sortable-column .p-sortable-column-icon {
    color: white;
}

.pi-sort-amount-down::before {
    content: "\e9a0";
    color: white;
}

.pi-sort-amount-up-alt::before {
    content: "\e9a2";
    color: white;
}
.dropdown:hover .dropdown-content {
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content {
    padding: 0;
    z-index: 0 !important;
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
            <template #footer>
                <Button label="No" icon="pi pi-times" @click="visible = false" text />
                <Button label="Yes" icon="pi pi-check" @click="visible = false" autofocus />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";

const visible = ref(false);
</script>

-->


}
