<template>
    <div class="bg-white rounded-lg p-2 border" v-if="useDashboard.chartDetails">
        <p class="font-semibold text-[14px] text-[#000] font-['Poppins] text-center">Attendance Analytics</p>
        <div class=" grid grid-cols-2 gap-4 my-2.5">
            <div class="h-full ">
                <Chart type="pie" :data="chartData" :options="chartOptions" class="h-full"
                    v-if="useDashboard.overallEmployeeCountForExceptionAnalyticsForGraph" />
            </div>
            <div class="flex items-center">
                <div class="">
                    <div>
                        <div class="flex items-center gap-3" v-for="(item, index) in useDashboard.chartDetails ">
                            <div :style="{ backgroundColor: item.backgroundColor }" class="rounded-lg h-2 w-2 p-1.5"></div>
                            <div>
                                {{ item.label }}
                                -
                                <span class="font-semibold text-lg">{{ findPercentage(item.count, useDashboard.totalEmployeeInOrganization)}}</span>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUpdated } from 'vue';
import { useAttendanceDashboardMainStore } from '../stores/attendanceDashboardMainStore.js';

const useDashboard = useAttendanceDashboardMainStore()



onMounted(() => {
    // chartData.value = setChartData();
    chartOptions.value = setChartOptions();
    // chartData.value.datasets[0].data = [20, 20, 20]
    setTimeout(() => {
        console.log(useDashboard.overallEmployeeCountForExceptionAnalyticsForGraph);
        chartData.value.datasets[0].data = useDashboard.overallEmployeeCountForExceptionAnalyticsForGraph
        // updateChartLabels()
    }, 15000);

});


const chartDetails = ref([])


const chartData = ref({
    labels: ['Absent', 'Present', 'Leave', 'Late coming', 'Early going', 'Missed out punch', 'Missed in punch'],
    datasets: [
        {
            backgroundColor: [
                '#FFB1B8',
                '#7A5EA2',
                '#8D98B5',
                '#D9AA63',
                '#6BB7C0',
                '#000000',
                '#000000',
            ],
            data: [0, 0, 0, 0, 0, 0,0]
        },
    ],
});
const chartOptions = ref();

const data = ref()

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
// Function to calculate the total employee count for each bar
const calculateTotalEmployees = () => {
    const data = chartData.value.datasets[0].data;
    return data.reduce((total, count) => total + count, 0);
};

// Update the chart labels with the total employee count
const updateChartLabels = () => {
    const labels = chartData.value.labels;
    const updatedLabels = labels.map((label, index) => {
        const total = calculateTotalEmployees();
        return `${label} (${total})`;
    });
    chartData.value.labels = updatedLabels;
};


const findPercentage = (part, whole) => {
    const percentage = (part / whole) * 100;
    return `${percentage.toFixed(0)}`;
}



</script>
