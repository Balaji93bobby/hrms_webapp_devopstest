<template>
    <div class="font-['poppins']">
         <div class="h-screen bg-gray-50 p-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xxl-12 col-xl-12  ">
                <div class="mb-2  ">
                    <div class="">
                        <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
                            <li class=" nav-item" role="presentation">
                                <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                                    aria-selected="true" @click="activetab_btn1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                                    LEAVES
                                </a>                      
                                <div v-if="activetab === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;" ></div>
                                <div v-else class=" border-2 h-1 rounded-l-3xl border-gray-300"></div>
                            </li>
            
                            <li class=" nav-item position-relative  border-0" role="presentation">
                                <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn2"
                                    :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                                    ATTENDANCE
                                </a>
                                <div v-if="activetab === 2"
                                    class=" h-1 position-absolute bottom-[1px] left-0 w-[100%]" style="border: 2px solid #F9BE00 !important;"></div>
                                <div v-else class=" border-3 h-1  border-gray-300"></div>
                            </li>
                            <li class=" nav-item position-relative  border-0" role="presentation">
                                <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn3"
                                    :class="[activetab === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                                    LOP SUMMARY
                                </a>
                                <div v-if="activetab === 3"
                                    class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                                <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                            </li>
                            <li class=" nav-item position-relative  border-0" role="presentation">
                                <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn4"
                                    :class="[activetab === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                                    REVOKE LOP
                                </a>
                                <div v-if="activetab === 4"
                                    class="h-1 rounded-r-3xl position-absolute bottom-[1px] w-[100%] left-0"  style="border: 2px solid #F9BE00 !important;"></div>
                                <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                            </li>
                            <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
                        </ul>
                    </div>
                </div>

                <div class="tab-content " id="pills-tabContent">

                    <div class="tab-pane  fade active show" id="employee_details" role="tabpanel" aria-labelledby="">
                        <div>
                            <payroll_leaves />
                        </div>
                    </div>

                 <div class="tab-pane fade" id="family_det" role="tabpanel" aria-labelledby="">
                        <payroll_attendance/>
                    </div>

                    <div class="tab-pane fade" id="experience_det" role="tabpanel" aria-labelledby="">
                        <payroll_lop_summary />

                    </div>
                    <div class="tab-pane fade" id="finance_det" role="tabpanel" aria-labelledby="">
                        <div>
                            <payroll_revoke_lop />
                        </div>


                    </div> 

                </div>
            </div>
            <div class="py-2">
                <p>All leave pending that falls under this payroll cycle month will be displayed here</p>
            </div>
            <div class="flex justify-between">
                <div class="">
                    <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 border-b-4 border-gray-300  " id="pills-tab" role="tablist">
                        <li class=" nav-item" role="presentation">
                            <a class="px-4 position-relative  font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                                aria-selected="true" @click="tab_btn5" >
                                PENDING
                            </a>                      
                            <div v-if="tab === 5" class="h-1 rounded-l-3xl relative top-[3.5px] " style="border: 2px solid #F9BE00  !important ; " ></div>
                            <div v-else class=" border-1 h-1 rounded-l-3xl border-gray-300 "></div>
                        </li>
        
                        <li class=" nav-item" role="presentation">
                            <a class=" px-4 position-relative  font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href=""   @click="tab_btn6"
                                :class="[tab === 6 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                                APPROVED
                            </a>
                            <div v-if="tab === 6"
                                class=" h-1 rounded-l-3xl relative top-[3.5px] " style="border: 2px solid #F9BE00 !important;"></div>
                            <div v-else class=" border-1 h-1 rounded-l-3xl border-gray-300"></div>
                        </li>
                        <li class=" nav-item position-relative  border-0" role="presentation">
                            <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="tab_btn7"
                                :class="[tab === 7 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                                REJECTED
                            </a>
                            <div v-if="tab === 7"
                                class="h-1 rounded-l-3xl relative top-[3.5px] "  style="border: 2px solid    #F9BE00 !important;"></div>
                            <div v-else class=" border-0  rounded-r-3xl border-gray-300"></div>
                        </li>
                        <!-- <div class="border-gray-300 border-b-[4px] border-0 w-60 mt-[-7px]"></div> -->
                    </ul>    
                   
                </div>
                <div class=" flex justify-between  mt-3 ">
                    <div class=" ">
                       <InputText v-model="inputtype" class=" !w-[200px] h-9 mr-3"  placeholder="Search"  />
                      
                    </div>
                    <div class="">
                       <button class="bg-[#387C2D] h-9 px-2 rounded-lg text-white ">Approved</button>
                       <button class="bg-[#C4302B] h-9 ml-4 rounded-lg  text-white px-2">Rejected</button>
                    </div> 
                </div>
                 
                    
            </div>    
        </div> 
    </div>

</template>

<script setup>

import payroll_leaves from './payroll_leaves.vue';
import payroll_attendance from './payroll_attendance/payroll_attendance.vue'
import payroll_lop_summary from './payroll_lop_summary/payroll_lop_summary.vue'
import payroll_revoke_lop from './payroll_revoke_lop/payroll_revoke_lop.vue'


import {ref} from 'vue';

const inputtype=ref(null);

const activetab = ref(1);

const activetab_btn1 = ()=>{
    activetab.value= 1;
}

const activetab_btn2 = ()=>{
    activetab.value= 2;
}
const activetab_btn3 = ()=>{
    activetab.value= 3;
}
const activetab_btn4 = ()=>{
    activetab.value= 4;
}

const tab = ref(5);
const tab_btn5 = ()=>{
    tab.value= 5;
}
const tab_btn6 = ()=>{
    tab.value= 6;
}
const tab_btn7 = ()=>{
    tab.value= 7;
}



</script>