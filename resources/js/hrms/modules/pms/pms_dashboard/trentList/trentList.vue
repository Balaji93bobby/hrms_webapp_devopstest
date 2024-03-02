<template>
    <div class="w-full bg-[#E0F4D7] card p-4 h-[280px] mt-[20px] overflow-y-auto">
        <div class=" flex  justify-between items-center ">
            <h1 class=" font-['poppins'] font-semibold text-[16px]">Trend-list</h1>
            {{ useStore.activetab }}
            <Dropdown v-model="useStore.selectedtrendList" :options="useStore.trendListOptions" @change="useStore.getPmsTrendList(service.current_user_code,useStore.selectedtrendList)" optionValue="assignment_id"
                optionLabel="assignment_period" placeholder="Select" class=" border-none w-[120px] bg-[#E0F4D7]" />
        </div>
        <div class="grid grid-cols-3 gap-4 font-['poppins'] my-4">
            <div class="">
                <span class=" text-[#666666] ">Process</span>
            </div>
            <div class="text-center">
                <span class=" text-[#666666] text-center">Status</span>
            </div>
            <div class="text-center">
                <span class=" text-[#666666] text-center">days</span>
            </div>

        </div>
        <!-- {{ useStore.trendListSource }} -->

        <div v-if="useStore.trendListSource" class=" my-2 grid grid-cols-3 gap-4 font-['poppins']  overflow-hidden" v-for="(item, index) in useStore.trendListSource" :key="index">
            <div class="">
                <span class=" text-[#000] text-[15px] "> {{ item.process }} </span>
            </div>
            <div class=" text-center">
                <span class=" text-[#000] text-[15px]  text-center">{{ item.status }}</span>
            </div>
            <div class=" text-center">
                <span class=" text-[15px]  text-center" :class="[item.is_overdue!=1 ? 'text-[#387C2D]' : 'text-[#B20000]' ]" >{{item.days}}</span>
            </div>

        </div>

    </div>
</template>


<script setup>
import { ref, reactive } from 'vue';
import { use_pms_dashboard_store } from '../../stores/pms_dashboard_store';
import { Service } from '../../../Service/Service';

const useStore = use_pms_dashboard_store();
const service = Service();

const selectedtrendList = ref();

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);


const arr = ref([
    { process: 'asd', status: 'Over-Time', days: '+ 4 Days', is_overdue: 1 },
    { process: 'asd', status: 'Over-Time', days: '+ 4 Days', is_overdue: 1 },
    { process: 'asd', status: 'Over-Time', days: '+ 4 Days', is_overdue: 1 },
    { process: 'asd', status: 'Over-Time', days: '+ 4 Days', is_overdue: 1 }
])


</script>
