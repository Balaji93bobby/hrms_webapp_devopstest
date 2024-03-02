<template>
    <Dialog header="Header" v-model:visible="useStore.canshowloading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>
    <!-- {{ useStore.arrayMobileSetDetails ? useStore.arrayMobileSetDetails : [] }} -->
    <!-- <LoadingSpinner  v-if="useStore.canshowloading"  class="absolute z-50 bg-white w-[100%] h-[100%]"/> -->
    
    <!-- {{ useStore.arrayModuleSettingsDetails }} -->
    <div class="w-full">
        <h1 class="text-[18px] text-[#000] my-2">Module Settings</h1>
        <!-- {{ useStore.arrayMobileSetDetails }} -->
        <!-- {{ items }} -->
        <div class="" v-if="false">
            <div class="grid grid-cols-3 p-2 rounded-lg border my-2.5 h-[44px]"
                v-for="(item, index) in useStore.arrayModuleSettingsDetails" :key="index">
                <div class="my-auto">
                    <h1 class="text-[#000] text-[14px]">{{ item.module_name }}</h1>
                </div>
                <div class="mx-auto">
                    <!-- {{ item.module_status }} -->
                    <button class=" text-[12px] w-[100px] rounded-l-[8px] h-[26px]"
                        :class="[item.module_status == 1 ? ' bg-[#000] text-white  ' : ' bg-white !text-[#000] border-[2px] border-black']"
                        @click="useStore.saveEnableDisableSetting(item, 1)">Enable</button>
                    <button class=" text-[12px] w-[100px] rounded-r-[8px] h-[26px]"
                        :class="[item.module_status == 0 ? 'bg-[#000] text-white ' : 'bg-white text-black border-[2px] border-black']"
                        @click="useStore.saveEnableDisableSetting(item, 0)">Disable</button>
                </div>
                <div class="my-auto">
                    <!-- {{ val.Type }} -->
                    <div class="flex float-right cursor-pointer w-[170px] items-center" v-if="item.status === 1">
                        <i class="pi pi-users"></i>
                        <span class="text-[#000] mx-2">
                            {{ item }}</span>
                        <span class="underline "
                            @click="selectedType = item.id, useStore.employeeAssignDialog = true">Assign
                            Employee</span>
                    </div>
                    <!-- <p
                        class="text-right cursor-pointer"><span class="text-[#000]"
                            v-if="useuseStore.Emloyee_count"> <i class="pi pi-users"></i>{{
                                useuseStore.Emloyee_count }} </span>-
                         <span class="text-[#000]" > <i class="pi pi-users"></i> </span>- <span>Assign
                            Employee</span>
                    </p> -->
                </div>
            </div>
        </div>
    </div>
    <Accordion>
        <AccordionTab v-for="(item, index) in useStore.arrayModuleSettingsDetails" :key="index">
            <template #header>
                <div class="grid items-center w-full grid-cols-2">
                    <div class="my-auto">
                        <h1 class="text-[#000] text-[14px] my-auto">{{ item.module_name }}</h1>
                    </div>
                    <div>
                        <div class="mx-auto">
                            <button class=" text-[12px] w-[100px] rounded-l-[8px] h-[26px]"
                                :class="[item.module_status == 1 ? ' bg-[#000] text-white  ' : ' bg-white !text-[#000] border-[2px] border-black']"
                                @click="useStore.saveEnableDisableSetting(item, 1),item.module_status = 1">Enable</button>
                            <button class=" text-[12px] w-[100px] rounded-r-[8px] h-[26px]"
                                :class="[item.module_status  == 0 ? 'bg-[#000] text-white ' : 'bg-white text-black border-[2px] border-black']"
                                @click="useStore.saveEnableDisableSetting(item, 0),item.module_status = 0">Disable</button>
                        </div>
                    </div>
                </div>
            </template>
            <div class="grid grid-cols-2 p-2 rounded-lg border my-2.5 h-[44px]"
                v-for="(item, index) in format(item.sub_module_details)" :key="index">
                <div class="my-auto">
                    <h1 class="text-[#000] text-[14px]">{{item ?  item.value.sub_module_name : '' }}</h1>
                </div>
                <div class="mx-auto">
                    <button class=" text-[12px] w-[100px] rounded-l-[8px] h-[26px]"
                        :class="[item.value.sub_module_status == 1 ? ' bg-[#000] text-white  ' : ' bg-white !text-[#000] border-[2px] border-black']"
                        @click="useStore.saveEnableDisableSetting(item, 1),item.value.sub_module_status =1">Enable</button>
                    <button class=" text-[12px] w-[100px] rounded-r-[8px] h-[26px]"
                        :class="[item.value.sub_module_status == 0 ? 'bg-[#000] text-white ' : 'bg-white text-black border-[2px] border-black']"
                        @click="useStore.saveEnableDisableSetting(item, 0),item.value.sub_module_status =0">Disable</button>
                </div>
            </div>
        </AccordionTab>
    </Accordion>
    <AssignEmployee :type="selectedType" />
</template>

<script setup>
import { ref, reactive, onMounted, onUpdated } from "vue";
import AssignEmployee from "../mobile_settings/components/AssignEmployee.vue";
import { useModuleSettingsStore } from "./stores/moduleMainStore";


const useStore = useModuleSettingsStore();

onMounted(async () => {
    await useStore.getSessionClient();
    await useStore.getModuleSettings();

})


const format = (data) => {
    const obj = Object.entries(data).map(ele => {
        let format = {
            title: ele[0],
            value: ele[1],
        }
        return format
    })

    return obj

}



const active = ref(1);

const selectedType = ref()
const dialogValue = ref(false)



// const val = ref([
//     { name: "Mobile App", Type: 1, EnableDisableBtn: 1, },
//     { name: "Check-In / Check-out", Type: 2, EnableDisableBtn: 2, },
//     { name: "Location Capture", Type: 3, EnableDisableBtn: 1, },
//     { name: "Check-In / Check-out Selfie", Type: 4, EnableDisableBtn: 1, },
//     { name: "Reimbursement while Check-out", Type: 5, EnableDisableBtn: 1, },
//     { name: "Absent/Attendance Regularization", Type: 6, EnableDisableBtn: 1, },
//     { name: "Leave Apply", Type: 7, EnableDisableBtn: 1, },
//     { name: "Salary Advance and Loan", Type: 8, EnableDisableBtn: 1, },
//     { name: "Investments", Type: 9, EnableDisableBtn: 1, },
//     { name: "PMS", Type: 10, EnableDisableBtn: 1, },
//     { name: "Exit Apply", Type: 11, EnableDisableBtn: 1, },

// ]);

</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

*
{
    font-family: 'Poppins', sans-serif;
}
</style>
