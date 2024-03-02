
<template>
    <div class="card flex justify-center flex-row  ">
        <div class="">
            <Chart type="doughnut" :data="chartData" :options="chartOptions" class="  h-[20px]   " />
        </div>
        <div  class=" my-2 flex flex-col justify-around ">
            <!-- <Dropdown v-model="useStore.assignment_setting_id" v-if="useHelper.activetab=='Team' || useHelper.activetab == 'Org' " :options="useStore.selectedyear"
                @change="DashboardStore.selecteddropdownyear(useStore.assignment_setting_id, useStore.select_activetab )"
                optionValue="assignment_id" optionLabel="assignment_period" placeholder="    Select  Year"
                class=" h-[30px] w-[220px]  " /> -->
            <div class="flex flex-col justify-center items-start pl-4">
                <div class=" flex justify-between items-center  w-[100%] my-2">
                    <div class=" w-[20px] h-[20px] bg-[#CDB9E4] rounded-full ">
                    </div>
                    <div class="  flex justify-between w-[100%] ">
                        <span class=" text-black font-semibold font-['poppins'] mx-2 text-[14px]">Initiated</span>
                        <span class=" text-black font-semibold font-['poppins'] text-[14px]">{{
                            useStore.Dashboardprocessdetails.list.goal_initiated }} %</span>
                    </div>
                </div>
                <div class=" flex justify-between items-center  w-[100%]  ">
                    <div class=" w-[20px] h-[20px] bg-[#B2D1EF] rounded-full   my-2">
                    </div>
                    <div class=" flex justify-between   w-[100%] ">
                        <span class=" text-black font-semibold font-['poppins'] mx-2 text-[14px]">Self-Reviews</span>
                        <span class=" text-black font-semibold font-['poppins'] text-[14px]">{{
                            useStore.Dashboardprocessdetails.list.self_reviews }} %</span>
                    </div>
                </div>
                <div class=" flex justify-center items-center w-[100%]">
                    <div class=" w-[20px] h-[20px] bg-[#EFB2B2] rounded-full my-2">
                    </div>
                    <div class=" flex justify-between items-center  w-[100%]">
                        <span class=" text-black font-semibold font-['poppins'] mx-2 text-[14px]">Reviewer Reviews</span>
                        <span class=" text-black font-semibold font-['poppins'] text-[14px]">{{
                            useStore.Dashboardprocessdetails.list.reviewer_reviews }} %</span>
                    </div>
                </div>
                <!-- {{ useStore.Dashboardprocessdetails.list }} -->
                <!-- {{ useStore.Dashboardprocessdetails.list.goal_initiated }} -->
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { use_pms_dashboard_store } from '../../stores/pms_dashboard_store';
import { usePmsHelperStore } from "../../stores/pmsHelperStore";

const useStore = use_pms_dashboard_store();
const useHelper = usePmsHelperStore();
onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref(null);

const setChartData = () => {
    const documentStyle = getComputedStyle(document.body);

    return {
        labels: useStore.Dashboardprocessdetails ? useStore.Dashboardprocessdetails.labels_name : null,
        datasets: [
            {
                data: useStore.Dashboardprocessdetails ? useStore.Dashboardprocessdetails.labels_value : null,
                backgroundColor: ['#CDB9E4', '#B2D1EF', '#EFB2B2'],
                // hoverBackgroundColor: [documentStyle.getPropertyValue('--blue-400'), documentStyle.getPropertyValue('--yellow-400'), documentStyle.getPropertyValue('--green-400')]
            }
        ]
    };
};

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    cutout: '20%',
                    color: textColor
                }
            }
        }
    };
};
</script>


<style scoped>
.p-chart
{
    height: 240px !important;
    width: 240px !important;
}</style>
