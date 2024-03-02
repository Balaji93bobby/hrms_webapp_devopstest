<template>
    <div class="w-full  card  font-['poppins']  ">
        <div class=" my-2 py-2 px-3 ">
            <section id="topBar" class=" border-b-2 pb-3  flex justify-between">
                <section class="flex ">
                    <strong class="text-[14px]  font-semibold">Run Payroll</strong>
                    <button class="mx-3 bg-[#2E3F4A] py-1 px-3 rounded-sm text-white   text-sm"> COMPLETED </button>
                    <div class="">
                        <!-- <p class="text-gray-400">(On May 30,2023, 3:13pm )</p> -->
                    </div>
                </section>
                <section class="flex  ">
                    <button @click="canShowRunPayroll = !canShowRunPayroll">
                        <i class="pi pi-chevron-down" style="font-size: 1rem"></i>
                    </button>
                </section>
            </section>
            <div id="Body" class="my-2 ">
                <div v-if="canShowRunPayroll"
                    class="grid gap-2 md:grid-cols-2 sm:grid-cols-1 xxl:grid-cols-4 xl:grid-cols-2 lg:grid-cols-2 transition h-[190px] duration-150 ease-in-out "
                    style="display: grid;">
                    <!-- <router-link
                        class="p-3 my-1 rounded-lg  dynamic-card-without-border flex transition ease-in-out delay-80 hover:-translate-y-1 hover:scale-100  duration-300" v-for="(item, index) in runPayroll" :key="index"
                    :to="`/payrun/${item.shorName}`"> -->
                    <div class="p-3 my-1 rounded-lg  dynamic-card-without-border flex transition ease-in-out delay-80 hover:-translate-y-1 hover:scale-100  duration-300" v-for="(item, index) in runPayroll" :key="index" >

                    <img src="" alt="" class="rounded-full h-8">
                    <div class="">
                        <i :class="[item.icons]" class="text-2xl w-9" ></i>
                    </div>
                    <div class="flex flex-col justify-start    items-start w-[100%]">
                        <h1 class="fs-7 text-[13px] font-medium  text-start  whitespace-nowrap">{{item.name}}</h1>
                        <h1 class="text-[10px] font-medium text-[#8B8B8B] text-start whitespace-nowrap">{{item.title}}</h1>
                    </div>
                </div>

                    <!-- </router-link> -->
                </div>
            </div>
            <div class="text-end text-slate-400 ">
                <p>Last Preview Run on May 05 at 4:03pm</p>
            </div>
            <div id="footer" class=" float-right py-2 ">
                <div class="text-end flex font-['poppins']  ">
                     <button class="text-[#2E3F4A]  border-[2px] rounded-md border-[#2E3F4A] px-3 py-2 ">Preview Run Payroll</button>
                     <button class="text-[#2E3F4A]  border-[2px] rounded-md border-[#2E3F4A]  px-3 py-2 mx-2">Review All Employees</button>
                     <button class="bg-[#2E3F4A] px-4 rounded-md text-white ">Finalize Payroll</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <img src="../../assests/calendar.svg" alt="" srcset=""> -->
</template>

<script setup>
import { onMounted, ref } from "vue";
import { payrunMainStore } from "../stores/payrunMainStore";
const canShowRunPayroll= ref(true)

const usePayrun = payrunMainStore()

const findIcons = (values) =>{
    if(values == 'leave'){
        return '../../assests/calendar.svg'
    }
}


onMounted(()=>{
    usePayrun.getLeaveDetails()
})




const runPayroll = ref([
    {id:1,shorName:'leave',icons :'pi pi-calendar' ,name:"Leave, Attendance & Daily Wages",title:"Last Changes on Jun 09,2023,(7:56pm)"},
    {shorName:'attendance',icons :'pi pi-user-plus' ,name:"New Joinee & Exits  " , title:"Last Changes on Jun 09,2023,(7:56pm) "},
    {shorName:'Salary-Revisions',icons :'pi pi-shopping-bag' ,name:"Bonus, Salary Revisions & Overtime" , title:"Last Changes on Jun 09,2023,(7:56pm) "},
    {shorName:'Reimbursement',icons :'pi pi-calendar-times' ,name:"Reimbursement, Adhoc Payment, Deduction" , title:"Last Changes on Jun 09,2023,(7:56pm) "},
    {shorName:'Salaries-Hold',icons :'pi pi-hourglass' ,name:"Salaries on Hold & Arrears", title:"Last Changes on Jun 09,2023,(7:56pm) "    },
    {shorName:'Override',icons :'pi pi-user' ,name:"Override (PT, ESI, TDS, LWF)",  title:"Last Changes on Jun 09,2023,(7:56pm) "},


])

</script>
