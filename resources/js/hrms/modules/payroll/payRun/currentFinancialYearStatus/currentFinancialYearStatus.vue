<template>

    <div class=" border-2 border-gray-100  card  ">
        <div class="flex items-center justify-center  py-3 h-[70px] scroll-container " >

            <i class=" px-5 pi pi-angle-double-left text-[20px]" @click="scrollLeft"></i>

            <div class="scroll-content flex items-center  justify-center" ref="scrollContent">
                <div class=" flex justify-center flex-col items-center   " v-for="(item, index) in payrunstore.currentFiancialYearStatus" :key="index">
                    <div class=" flex items-center "  >
                  <div class=" border-[1.6px] border-dashed border-[#387C2D] w-[45px]" v-if="index != 0" >
                    <!-- sakd -->
                  </div>
                    <div class="">
                    <!-- {{  item  }} -->
                    <!-- {{ selecteditem }} -->
                    <div class=" w-[50px] h-[51px] cursor-pointer  !rounded-full flex justify-center items-center flex-col" :class=" selecteditem ? selecteditem == item.month  ? 'bg-blue-400 text-white  ' : item.status == -1 ? '   bg-[#77AB6E] text-[#ffff] ' : item.status == 0 ? '!bg-[#fff] !text-[#C19F2E] border-[1px] !border-[#C19F2E]' : 'bg-gray-200  ' : item.status == -1 ? '   bg-[#77AB6E] text-[#ffff] ' : item.status == 0 ? '!bg-[#fff] !text-[#C19F2E] border-[1px] !border-[#C19F2E]' : 'bg-gray-200  '  "
                    @click="payrunstore.getPayrunOutcomeDetails(item.month,payrunstore.client_id),ManagePayslip.selectedDate = item.month,selecteditem =  item.month">
                        <i v-if="item.status ==  -1 " class="pi pi-check text-[11px]"></i>
                        <p class=" font-bold text-center text-[9px] justify-center ">
                           {{  dayjs(item.month).format('MMM-YYYY')}}</p>
                    </div>
                </div>
                </div>
                <!-- <p class="text-end text-[11px]    justify-center ">{{ item.days  }}</p> -->
                </div>


            </div>

            <i class="px-5 pi pi-angle-double-right  text-[20px]" @click="scrollRight"></i>

        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import { payrunMainStore } from '../stores/payrunMainStore';
import  { useManagePayslip } from  '../../../manage_payslips/managePayslipv2/ManangePayslipsService';
import dayjs from 'dayjs'

const payrunstore= payrunMainStore();

const ManagePayslip = useManagePayslip();

const selecteditem =  ref();

onMounted(()=>{

})


function getpayroldetails(item){
    payrunstore.getPayrunOutcomeDetails(item);
}



</script>

<style scoped>
.scroll-content {
  width: 100%;  /* Adjust the width to your needs */
  white-space: nowrap; /* Prevent content from wrapping */
   /* Enable horizontal scrolling */
}
</style>
