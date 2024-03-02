<template>
    <div class="bg-[#FFEFE2] rounded-lg overflow-hidden p-3" style="height: 200px;">
       <div class="flex justify-between">
        <span class="font-semibold  text-[14px] text-[#000] font-['Poppins]">Calendar</span>
        <!-- <div class="mb-2 font-semibold text-gray-900 text-md">Calendar</div> -->
        <svg xmlns="http://www.w3.org/2000/svg" @click="show = true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[20px] h-[20px] text-gray-900 cursor-pointer ">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
          </svg>
       </div>

       <Dialog v-model:visible="show" modal header="Calendar" :style="{ width: '30vw' }">
        <div class=" flex justify-center items-center w-[100%]">
            <Calendar v-model="date" inline  />
        </div>
            <!-- <template #footer> -->
      <button @click="show = false"  class="absolute top-4 right-4" ><i class="pi pi-times"></i></button>
    <!-- </template> -->
      </Dialog>


    

        <div class="py-8">
            <p class="text-[#d1814c] font-semibold text-[36px] mb-2 font-['Petrona']" style="">{{ dayjs(new Date()).format('D, MMMM YYYY') }}
            </p>
            <p class="mb-2 font-semibold text-gray-900 text-[16px]">{{ dayjs(new Date()).format('dddd') }}</p>
        </div>
    </div>
</template>

<script setup>
import dayjs from 'dayjs';
import {ref} from 'vue';

const show = ref(false);

</script>


<style>
@import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville&family=Poppins&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Petrona&family=Poppins&display=swap');

.p-datepicker-header {
   background-color: gainsboro !important ;
}
.p-datepicker-month {
    color:#000 !important;
}
.p-datepicker-year{
    color:#000 !important;
}
.p-datepicker-weeknumber{
    padding: 8px !important;
}
.p-datepicker-weekheader{
    padding: 8px;
}
.p-datepicker{
    padding: 8px !important;
}
.p-disabled{
    /* padding: 8px !important; */
}
.p-datepicker table th{
    padding: 4px 4px 4px 10px !important;
}


</style>
