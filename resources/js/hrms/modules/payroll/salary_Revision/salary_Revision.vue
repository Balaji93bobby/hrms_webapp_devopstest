<template>
    <div>
        <h1 class="text-[28px] font-['poppins']">Salary Revision</h1>
        <div>
            <div style="position: relative;" >
                <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 " id="pills-tab" role="tablist">
                    <li class=" nav-item" role="presentation">
                        <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
                            aria-selected="true" @click="activetab_btn1" :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                            Pending
                        </a>                      
                        <div v-if="activetab === 1" class=" border-3 h-1 rounded-l-3xl border-[#F9BE00]"></div>
                        <div v-else class=" border-3 h-1 rounded-l-3xl border-gray-300"></div>
                    </li>
    
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn2"
                            :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                           Processed
                        </a>
                        <div v-if="activetab === 2"
                            class=" border-3 h-1 border-[#F9BE00] position-absolute left-0 w-12"></div>
                        <div v-else class=" border-3 h-1  border-gray-300"></div>
                    </li>
                    <li class=" nav-item position-relative  border-0" role="presentation">
                        <a class=" text-center px-4  border-0 font-['poppins'] text-[14px] text-[#001820]" id="" data-bs-toggle="pill" href="" @click="activetab_btn3"
                            :class="[activetab === 3 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" role="tab" aria-controls="" aria-selected="true">
                           Cancelled
                        </a>
                        <div v-if="activetab === 3"
                            class=" border-3 h-1 rounded-r-3xl border-[#F9BE00] position-absolute left-0 w-12"></div>
                        <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-300"></div>
                    </li>
                    <div class="border-gray-300 border-b-[7px]  w-100 mt-[-7px]"></div>
                </ul>
                <!-- </div> -->
                <!-- Tab Content -->
                <div class="tab-content" id="">
                    <div>
                        <div class="card-body">
                            <div v-if="activetab === 1">
                                <!-- <salary_Revision_pending /> -->
                            </div>
                            <div v-if="activetab === 2">
                                <!-- <EmployeeSummary /> -->
                                <!-- <salary_Revision_Processed /> -->
                            </div>
                            <div v-if="activetab === 3">
                                <!-- <salary_Revision_Cancelled /> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script setup>
import {ref,reactive} from "vue";
// import salary_Revision_pending from "./salary_revision_pending.vue" ;
// import salary_Revision_Processed from "./salary_Revision_Processed.vue" ;
// import salary_Revision_Cancelled from "./salary_Revision_Cancelled.vue";

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


</script>