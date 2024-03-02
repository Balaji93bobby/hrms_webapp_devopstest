<template>
    <div class=" p-2 mt-4">
        <h1 class=" fs-2 font-semibold">Employee Payables - Jun 2023</h1>

        <!-- Summary screen -->
        <div class="flex justify-content-between align-items-center" v-if="activetab === 1">
            <p class=" fs-5 my-2" style="font-size: 14px;">Payment Batches</p>
            <div class=" d-flex justify-content-end align-items-center" style="width: 200px;">
                <button class="mx-4 " @click="view_Details = 1" v-if="view_Details == 2"><i
                        class="pi pi-times fs-5"></i></button>
                <button class="underline text-blue-700 text-[16px] " style="color:#0873CD;font-weight:550;" @click="viewDetailsbtn"
                    v-if="view_Details == 1">View Details</button>
            </div>

        </div>

                <!-- Employees screen -->
                <div class="flex justify-content-between align-items-center" v-if="activetab === 2">
                    <p class=" fs-5 my-2" style="font-size: 14px;">Payment Batches</p>
                    <div class=" d-flex justify-content-end align-items-center" style="width: 200px;">
                        <button class="mx-4 " @click="employee_viewDetails = 1" v-if="employee_viewDetails == 2"><i
                                class="pi pi-times fs-5"></i></button>
                        <button class="underline text-blue-700 text-[16px] " style="color:#0873CD;font-weight:550;" @click="employee_viewDetails_btn"
                            v-if="employee_viewDetails == 1">View Details</button>
                    </div>
                </div>




        <div class="card" v-if="view_Details == 2 ">

            <div class=" flex justify-between align-middle border-b-2 pb-1 p-3">
                <div class="">
                    <p class="text-[16px]">Default batch for Bank Transfer</p>
                    <p class=" text-[14px] text-gray-400 mt-1">Default batch for salary</p>
                </div>
                <div class="d-flex justify-content-center align-items-center position-relative ">
                    <button class=" rounded-md px-4 py-1 border border-blue-600 text-blue-600 fs-6 h-10" @click="btn_download = !btn_download">
                        <p class=" position-relative right-3">Download</p>
                        <div id="btn-download"  style=" position: absolute; right: 0;"
                            :class="[btn_download == true ? toggleClass : 'toggleClass', 'toggleClass']">
                            <svg width="22px" height="16px" viewBox="0 0 22 16">
                                <path
                                    d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15"
                                    id="check"></path>
                                <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                                <path d="M8,1 L8,11" class="svg-out"></path>
                            </svg>
                        </div>
                    </button>
                    <button class=" bg-blue-600 text-white px-4 py-1 rounded-md h-10 mx-2">Mask As Paid</button>
                    <button class="mx-1"> <i class="pi pi-ellipsis-v  text-blue-600 "></i></button>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="grid grid-cols-6 w-full p-4 b">
                    <div>
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Employees</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Total Amount</p>
                        <span class="">INR 1,15,35,494</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Account Number</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Bank Name</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">IFSC Code</p>
                        <span class="">HDFCC0001234</span>
                    </div>

                    <div class="d-flex flex-column align-items-center justify-content-center" style="position: relative; ">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Transfer Statement</p>
                        <div class="flex">
                            <button
                                class=" mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center ">
                                <span class="text-[13px] lg:text-[14px]">TEXT</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                            <button
                                class="mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center">
                                <span class=" text-[13px] lg:text-[14px]">EXCEL</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                            <button
                                class="mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center">
                                <span class="text-[13px] lg:text-[14px]">PDF</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" v-if="employee_viewDetails == 2 ">

            <div class=" flex justify-between align-middle border-b-2 pb-1 p-3">
                <div class="">
                    <p class="text-[16px]">Default batch for Bank Transfer</p>
                    <p class=" text-[14px] text-gray-400 mt-1">Default batch for salary</p>
                </div>
                <div class="d-flex justify-content-center align-items-center position-relative ">
                    <button class=" rounded-md px-4 py-1 border border-blue-600 text-blue-600 fs-6 h-10" @click="btn_download = !btn_download">
                        <p class=" position-relative right-3">Download</p>
                        <div id="btn-download"  style=" position: absolute; right: 0;"
                            :class="[btn_download == true ? toggleClass : 'toggleClass', 'toggleClass']">
                            <svg width="22px" height="16px" viewBox="0 0 22 16">
                                <path
                                    d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15"
                                    id="check"></path>
                                <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                                <path d="M8,1 L8,11" class="svg-out"></path>
                            </svg>
                        </div>
                    </button>
                    <button class=" bg-blue-600 text-white px-4 py-1 rounded-md h-10 mx-2">Mask As Paid</button>
                    <button class="mx-1"> <i class="pi pi-ellipsis-v  text-blue-600 "></i></button>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="grid grid-cols-6 w-full p-4 b">
                    <div>
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Employees</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Total Amount</p>
                        <span class="">INR 1,15,35,494</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Account Number</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Bank Name</p>
                        <span class="">188</span>
                    </div>
                    <div class="">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">IFSC Code</p>
                        <span class="">HDFCC0001234</span>
                    </div>

                    <div class="d-flex flex-column align-items-center justify-content-center" style="position: relative; ">
                        <p class=" text-gray-700 text-[13px] lg:text-[14px] mb-2">Transfer Statement</p>
                        <div class="flex">
                            <button
                                class=" mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center ">
                                <span class="text-[13px] lg:text-[14px]">TEXT</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                            <button
                                class="mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center">
                                <span class=" text-[13px] lg:text-[14px]">EXCEL</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                            <button
                                class="mx-1 text-blue-600 font-semibold text-[13px] lg:text-[14px] d-flex justify-content-center align-items-center">
                                <span class="text-[13px] lg:text-[14px]">PDF</span>
                                <i class="pi pi-angle-down px-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h1 v-if="view_Details == 2 || employee_viewDetails ==2 " class="fs-4 text-gray-900 mt-4 ml-2" style="font-weight: 600;">Bank Transfer</h1>
<!-- 
        <h1 v-if="view_Details == 2" class="fs-4 text-gray-900 mt-4 ml-2" style="font-weight: 600;">Bank Transfer</h1> -->

        <div style="position: relative;" >

            <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
            <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed border-none border-0" id="pills-tab" role="tablist">
                <li class=" nav-item" role="presentation">
                    <a class="px-2 position-relative border-0" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                        aria-selected="true" @click="activetab_btn1" :class="[activetab === 1 ? 'active' : '']">
                        SUMMARY
                    </a>
                    <div v-if="activetab === 1" class=" border-3 h-1 rounded-l-3xl border-orange-400"></div>
                    <div v-else class=" border-3 h-1 rounded-l-3xl border-gray-400"></div>
                </li>

                <li class=" nav-item position-relative  border-0" role="presentation">
                    <a class=" text-center px-2  border-0 " id="" data-bs-toggle="pill" href="" @click="activetab_btn2"
                        :class="[activetab === 2 ? 'active ' : '']" role="tab" aria-controls="" aria-selected="true">
                        EMPLOYEES
                    </a>
                    <div v-if="activetab === 2"
                        class=" border-3 h-1 rounded-r-3xl border-orange-400 position-absolute left-0 w-12"></div>
                    <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-400"></div>
                </li>
                <!-- <li class="mx-3 nav-item " role="presentation">
                    <a class="mx-4 text-center nav-link" id="" data-bs-toggle="pill" href="" @click="activetab = 3"
                        :class="[activetab === 3 ? 'active' : '']" role="tab" aria-controls="" aria-selected="true">

                        Travel Advance
                    </a>
                </li>
                <li class="mx-3 nav-item " role="presentation">
                    <a class="mx-4 text-center nav-link " id="" data-bs-toggle="pill" href="" @click="activetab = 4"
                        :class="[activetab === 4 ? 'active' : '']" role="tab" aria-controls="" aria-selected="true">
                        Loan With Interest
                    </a>
                </li> -->
            </ul>
            <!-- </div> -->
            <!-- Tab Content -->
            <div class="tab-content " id="">
                <div>
                    <div class="card-body">
                        <div v-if="activetab === 1">
                            <summaryvue />
                        </div>
                        <div v-if="activetab === 2">
                            <EmployeeSummary />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Dialog header="Header" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true"
            :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>


    </div>
</template>

<script setup>
import { BaseTransition, ref } from "vue";
import summaryvue from "./BankTransferSummary/summary.vue";
import EmployeeSummary from "./BankTransferSummary/EmployeeSummary.vue";

const activetab = ref(1);

const view_Details = ref(1);
const employee_viewDetails = ref(1);

function viewDetailsbtn(){
    view_Details.value = 2;
    employee_viewDetails.value= 1;
}

function employee_viewDetails_btn(){
    view_Details.value = 1;
    employee_viewDetails.value= 2;
}

function activetab_btn1(){
    view_Details.value = 1;
    employee_viewDetails.value= 1;
    activetab.value = 1;
}
function activetab_btn2(){
    view_Details.value = 1;
    employee_viewDetails.value= 1;
    activetab.value = 2;
}




// const download = ref(1);



const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);


const toggleClass = ref('downloaded');

const btn_download = ref(false);




</script>


<style lang="sass" scoped>

#btn-download
  cursor: pointer
  display: block
  width: 48px
  height: 48px
  border-radius: 50%
  -webkit-tap-highlight-color: transparent
  //transform: scale(2)
  //centering
  position: absolute
  top: calc(50% - 24px)
  left: calc(85% - 24px)
  &:hover
    background: rgba(#223254,.03)
  svg
    margin: 16px 0 0 16px
    fill: none
    transform: translate3d(0,0,0)
    polyline,
    path
      stroke: #0077FF
      stroke-width: 2
      stroke-linecap: round
      stroke-linejoin: round
      transition: all .3s ease
      transition-delay: .3s
    path#check
      stroke-dasharray: 38
      stroke-dashoffset: 114
      transition: all .4s ease
  &.downloaded
    svg
      .svg-out
        opacity: 0
        animation: drop .3s linear
        transition-delay: .4s
      path#check
        stroke: #20CCA5
        stroke-dashoffset: 174
        transition-delay: .4s

@keyframes drop
  20%
    transform: (translate(0, -3px))
  80%
    transform: (translate(0, 2px))
  95%
    transform: (translate(0, 0))


</style>



