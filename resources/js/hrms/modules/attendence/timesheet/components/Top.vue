<template>
    <div class="col-span-7 flex">
        <div class="my-auto">
            <!-- <SelectButton v-model="useTimesheet.switchTimesheet" :options="options" aria-labelledby="basic" style="width: 200px;" /> -->
            <ul class=" flex items-center my-auto">
                <li @click="useTimesheet.switchTimesheet = 'Classic', useTimesheet.canShowSidebar = false"
                    class="cursor-pointer border-b-[2px]  mx-2 px-2  font-semibold font-['poppins'] text-[14px] "
                    :class="[useTimesheet.switchTimesheet == 'Classic' ? 'border-[#f9be00] ' : 'border-transparent']">Classic
                </li>
                <li @click="useTimesheet.switchTimesheet = 'Detailed', useTimesheet.canShowSidebar = false"
                    class="cursor-pointer border-b-[2px] mx-2 px-2  font-semibold font-['poppins'] text-[14px]"
                    :class="[useTimesheet.switchTimesheet == 'Detailed' ? 'border-[#f9be00] border-b-[3px]' : 'border-transparent']">
                    Detailed</li>
            </ul>
        </div>
        <div class="w-full flex justify-center items-center py-2">
            <button @click="calendarStore.decrementMonth(1)">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10 hover:text-gray-800 cursor-pointer  transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg> -->
                <img src="../assests/down_arrow.png" class="h-[20px] w-[20px] rotate-90" alt="">
            </button>
            <div class="px-9">
                <div
                    class="w-full inline-flex space-x-1 text-lg md:text-2xl lg:text-2xl text-left  md:font-semibold font-semibold">
                    <span class="font-semibold text-lg md:hidden">{{ shortMonthStr }}</span><span
                        class=" font-semibold text-lg hidden md:block">{{ monthStr }}</span><span
                        class="font-semibold text-lg">{{ calendarStore.getYear }}</span>
                </div>
            </div>
            <button @click="calendarStore.incrementMonth(1)">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10 hover:text-gray-800 cursor-pointer  transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg> -->
                <img src="../assests/up_arrow.png" class="h-[20px] w-[20px] rotate-90"  alt="">
            </button>
        </div>
        <div class="flex gap-2 my-1 relative items-center">
            <button class="w-[20px] h-[20px] bg-[#ECECEC] rounded" @click="timesheetPrint()" >
                <i class="pi pi-print"></i>
            </button>
            <!-- <button class="p-2 bg-[#ECECEC] rounded">
                <i class="pi pi-download"></i>
            </button> -->
            <button class="p-2 bg-[#ECECEC]  text-[#000] font-[poppins] rounded-3xl" @focusout="show_dropdown = false"  @click="showDropdown()" >
<div class="flex items-center justify-center">
                <div class="px-2 bg-[#ff8f01] w-[25px] h-[25px] rounded-full p-1 flex justify-center items-center"> <span class="text-[#fff] font-semibold text-[12px] ">A</span></div>
                <span class="pl-1">Abbrevation</span>
            </div>
            </button>
            <transition @mouseleave="show_dropdown= false" enter-active-class="transition duration-200 ease-out transform"
                        enter-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                        leave-active-class=" transition duration-100 ease-in transform"
                        leave-class="translate-y-0 opacity-100" leave-to-class="translate-y-2 opacity-0">
            <div v-if="show_dropdown" class="absolute top-0 left-0 z-40 w-[220px]  mt-16 overflow bg-white rounded shadow-lg p-2 mx-[-70px]">
            <ul>
                <li class=" p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer"><span class="mx-3"><i class="fas fa-fingerprint text-[25px] text-[#075A19]"></i></span> <span class="pl-3">Biometric</span></li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3]">
                    <div class="flex">
                        <div class="mx-3 bg-[#51982F] rounded-full w-[25px] h-[25px] flex justify-center items-center"> <i class="pi pi-check text-[#fff] font-semibold"></i></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Approved</span>

                    </div>
                    </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer"><span class="mx-3"><i class="fa fa-exclamation-circle text-warning text-[25px] "></i></span><span class="pl-3">Not Applied</span></li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3]">
                    <div class="flex">
                        <div class="mx-3 bg-[#8B8B8B] rounded-full w-[25px] h-[25px] flex justify-center items-center"> <i class="pi pi-question text-[#fff] font-semibold text-[10px]"></i></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Pending</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 bg-[#002F56] rounded-xl  w-[28px] p-1 flex justify-center items-center"> <span class="text-[#fff] font-semibold text-[12px] ">LC</span></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Late Coming</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 bg-[#B20000] rounded-xl w-[28px] p-1 flex justify-center items-center"> <span class="text-[#fff] font-semibold text-[12px]">EG</span></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Early Going</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start mx-[-4px] hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 bg-[#0582EA] rounded-3xl p-2 w-[40px] flex justify-center items-center ml-[-4px]"> <span class="text-[#fff] font-semibold text-[12px] ">MOP</span></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start">Missed Out Punch</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start mx-[-4px] hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 bg-[#004A74] rounded-3xl p-2 w-[40px] flex justify-center items-center"> <span class="text-[#fff] font-semibold text-[12px]">MIP</span></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start">Missed in Punch</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 rounded-full w-[25px] h-[25px] flex justify-center items-center"><img src="../assests/computer.png"/></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Web</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3  rounded-full w-[25px] h-[25px] flex justify-center items-center"> <img src="../assests/mobile.png"/></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Mobile</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 bg-[#FF0000] rounded-full w-[25px] h-[25px] flex justify-center items-center"> <i class="pi pi-times text-[#fff] font-semibold text-[12px]"></i></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">Rejected</span>

                    </div>
                </li>
                <li class="p-2 font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start hover:bg-[#f3f3f3] duration-500 cursor-pointer">
                    <div class="flex">
                        <div class="mx-3 rounded-full w-[25px] h-[25px] flex justify-center items-center"><img src="../assests/profile.png"/></div>
                        <span class="font-[poppins] text-[14px] font-normal text-[#415359] flex items-center justify-start pl-3">View Image</span>

                    </div>
                </li>
            </ul>
            </div>
            </transition>
        </div>

        <div class="w-full flex px-auto" v-if="false">

            <div class="hidden md:flex px-auto items-center justify-center text-gray-600 ">
                <div class="flex space-x-12  items-center justify-center">
                    <button @click="calendarStore.decrementMonth(1)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 hover:text-gray-800 cursor-pointer  transition-all">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <div class="w-1/3 p-2 md:p-4">
                        <div
                            class="w-full inline-flex space-x-1 text-lg md:text-2xl lg:text-2xl text-left  md:font-semibold font-semibold">
                            <span class="font-semibold text-lg md:hidden">{{ shortMonthStr }}</span><span
                                class=" font-semibold text-lg hidden md:block">{{ monthStr }}</span><span
                                class="font-semibold text-lg">{{ calendarStore.getYear }}</span>
                        </div>
                    </div>
                    <button @click="calendarStore.incrementMonth(1)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 hover:text-gray-800 cursor-pointer hover:h-6 hover:w-6 transition-all">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- ----------------------------- -->

            <!-- Date picker and date view -->
            <div class="w-2/3 md:w-1/3 flex justify-end pr-2 md:pr-4">
                <div class="flex space-x-2 md:space-x-5">
                    <!-- <Datepicker
            v-model="date"
            auto-apply
            close-on-scroll
            @update:modelValue="handleDate"
          >
            <template #trigger>
              <div
                class="flex space-x-1 md:space-x-2 justify-around items-center bg-purple-300 rounded-sm px-2 md:px-8 py-1 md:py-2 cursor-pointer hover:bg-gray-200 transition-colors"
              >
                <div>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"
                    />
                  </svg>
                </div>
                <div>
                  <h1 class="text-xs md:text-base font-medium md:font-semibold">
                    {{ shortMonthStr }}
                  </h1>
                </div>
              </div>
            </template>
          </Datepicker> -->

                    <!-- <div
            class="flex justify-center items-center border rounded-sm px-2 md:px-5 py-1 md:py-2 cursor-pointer hover:bg-gray-200 transition-colors"
            @click="calendarStore.resetDate()"
          >
            <h1 class="text-xs md:text-base font-medium md:font-semibold">
              Today
            </h1>
          </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useCalendarStore } from "../stores/calendar";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { useAttendanceTimesheetMainStore } from '../stores/attendanceTimesheetMainStore.js'

// Store initialization and subscription
const calendarStore = useCalendarStore();
const useTimesheet = useAttendanceTimesheetMainStore()
calendarStore.$subscribe((mutation, state) => {
    prepareMonths();
    initializeDatePicker();
});

// Component variables
const date = ref(); // for datepicker
const monthStr = ref("");
const shortMonthStr = ref("");
const show_dropdown=ref(false)
const showDropdown =()=>{
    show_dropdown.value = !show_dropdown.value
}

const options = ref(['Classic', 'Detailed']);

function timesheetPrint(){
    window.print();
}

/**
 * Populate the month variable with month data from store
 */
const prepareMonths = () => {
    monthStr.value = new Intl.DateTimeFormat("en-US", { month: "long" }).format(
        new Date(
            calendarStore.getYear,
            calendarStore.getMonth,
            calendarStore.getDay
        )
    );
    shortMonthStr.value = monthStr.value.substring(0, 3);
};

/**
 * Initiializes the datepicker with data gotten from store
 */
const initializeDatePicker = () => {
    date.value = new Date(
        calendarStore.getYear,
        calendarStore.getMonth,
        calendarStore.getDay
    );
};

/**
 * Change date from the datepicker
 * @param {Date} modelData The selected date from the datepicker
 */
const handleDate = (modelData) => {
    date.value = modelData;

    calendarStore.setMonth(date.value.getMonth());
    calendarStore.setYear(date.value.getFullYear());

    // do something else with the data
};

/************************************************************************
 *  LIFECYCLE HOOKS
 * **********************************************************************
 */
onMounted(() => {
    prepareMonths();
    initializeDatePicker();
});
</script>


<style>
.p-button.p-component.p-highlight
{
    height: 30px;
}

.p-button.p-component
{
    height: 30px;

}

.p-selectbutton .p-button.p-highlight
{
    background: #071f53;
    border-color: #071f53;
    color: #ffffff;
}

.p-selectbutton .p-button.p-highlight:hover
{
    background: #071f53;
    border-color: #071f53;
    color: #ffffff;
}</style>
