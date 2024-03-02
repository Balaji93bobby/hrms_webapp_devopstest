<template>
    <div class="bg-white rounded-lg p-2 h-[100%] " v-if="useDashboard.AttendanceAnalytics">
        <p class="font-semibold text-[14px] text-[#000] font-['Poppins] text-center">Check-In & Out Analytics </p>
        <div class=" grid grid-cols-2 gap-4 my-2.5">
            <div class="h-full ">
                <Chart type="doughnut" :data="chartData" :options="chartOptions" />
            </div>
            <div class="flex items-center">
                <div class="my-auto">
                    <!-- <div class="mb-3">
                        <button class="active_btn font-semibold text-sm"
                            :class="[currentDashboard === 1 ? 'bg-white text-slate-600 border border-black' : 'text-slate-600']"
                            @click="currentDashboard = 0">Check In </button>
                        <button class="disable_btn font-semibold text-sm"
                            :class="[currentDashboard === 1 ? 'bg-[#d4d4d4] text-slate-600' : 'text-slate-600']"
                            @click="currentDashboard = 1">Check Out </button>
                    </div> -->

                    <div>
                        <div class="flex items-center gap-3" v-for="(item, index) in useDashboard.AttendanceAnalytics ">
                            <div :style="{ backgroundColor: chartData.datasets[0].backgroundColor[index] }" class="rounded-lg h-2 w-2 p-1.5"></div>
                            <div>
                                {{ item.title }}
                                -
                                <span class="font-semibold text-lg">{{ findPercentage(item.value, useDashboard.totalEmployeeInOrganization)}}</span>%
                            </div>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAttendanceDashboardMainStore } from '../stores/attendanceDashboardMainStore.js';

const useDashboard = useAttendanceDashboardMainStore()

onMounted(() => {
    chartOptions.value = setChartOptions();

    setTimeout(() => {
        chartData.value.datasets[0].data = useDashboard.AttendanceAnalyticsForGraph
    }, 3000);

});

const chartData = ref({
    labels: ['Bio-Metric', 'Mobile', 'Web'],
    datasets: [
        {
            data: [0, 0, 0],
            backgroundColor: [
                'rgba(122, 94, 162, 1)',
                'rgba(255, 177, 184, 1)',
                'rgba(107, 183, 192, 1)'
            ],
        }
    ]
}

);
const chartOptions = ref();
const currentDashboard = ref(0);

const chartDetails = ref([
    { label: 'Bio-Metric', backgroundColor: 'rgba(122, 94, 162, 1)' },
    { label: 'Mobile', backgroundColor: 'rgba(255, 177, 184, 1)' },
    { label: 'Web', backgroundColor: 'rgba(107, 183, 192, 1)' },
])

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue(
        '--text-color-secondary'
    );
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 1,
        plugins: {
            labels: {
                usePointStyle: true
            },
            title: {
                display: false,
                text: 'Custom Chart Title'
            },
            legend: {
                display: false,
                labels: {
                    fontColor: textColor,
                },

            },
        },
    };
};

const findPercentage = (part, whole) => {
    const percentage = (part / whole) * 100;
    return `${percentage.toFixed(0)}`;
}

</script>



<style>
:root
{
    --disable: #d4d4d4;
    --white: #fff;
    --navy: #002f56;
}

.active_btn
{
    background-color: var(--disable);
    padding: 3px 5px;
    border-radius: 4px 0 0 4px;
}

.disable_btn
{
    border: 1px solid var(--navy);
    padding: 3px 5px;
    border-radius: 0 4px 4px 0;
}
</style>






<!-- <div class="h-1/4 w-1/4"> -->
