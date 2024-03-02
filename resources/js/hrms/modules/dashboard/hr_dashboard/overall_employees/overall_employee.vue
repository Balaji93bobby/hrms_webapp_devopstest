<template>
    <!-- {{ useDashboard.overallEmployeeCountForGraph ? data = useDashboard.overallEmployeeCountForGraph : ''  }} -->
    <Chart type="bar" :data="chartData" :options="chartOptions" class="h-full"
        v-if="useDashboard.overallEmployeeCountForGraph" />
</template>

<script setup>
import { ref, onMounted, onUpdated } from 'vue';

import { useMainDashboardStore } from '../../stores/dashboard_service';

const useDashboard = useMainDashboardStore()

onMounted(async () => {
    // await useDashboard.overallEmployeeCountForGraph
    // chartData.value = setChartData();
    chartOptions.value = setChartOptions();
    // chartData.value.datasets[0].data = [20, 20, 20]
    setTimeout(() => {
        console.log(useDashboard.overallEmployeeCountForGraph);
        chartData.value.datasets[0].data = useDashboard.overallEmployeeCountForGraph
        // updateChartLabels()
    }, 8000);

});


const chartData = ref({
    labels: ['Male', 'Female', 'Others', 'App Check-Ins', 'Active Apps', 'Inactive Apps',],
    datasets: [
        {
            backgroundColor: [
                'rgba(8, 115, 205, 1)',
                'rgba(205, 159, 71, 1)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(80, 64, 34, 1)',
                'rgba(113, 74, 161, 1)',
                'rgba(181, 86, 151, 1)',
            ],
            borderWidth: 10,
            borderColor: 'white',
            data: [0, 0, 0, 0, 0, 0]
        },
    ],
});
const chartOptions = ref();

const data = ref()

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    return {
        labels: ['male_employee_count', 'female_employee_count', 'others_count', 'app-checkin-ins', 'active_apps', 'inactive_apps',],
        datasets: [
            {
                backgroundColor: [
                    'rgba(8, 115, 205, 1)',
                    'rgba(205, 159, 71, 1)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(80, 64, 34, 1)',
                    'rgba(113, 74, 161, 1)',
                    'rgba(181, 86, 151, 1)',
                ],
                borderWidth: 5,
                borderColor: 'white',
                data: [20, 20, 20]
            },
        ],
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue(
        '--text-color-secondary'
    );
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 100,
        plugins: {
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
        scales: {
            x: {
                ticks: {
                    autoSkip: false, // Prevent auto-skipping of labels
                    maxRotation: 0, // Rotate the labels to 0 degrees (horizontal)
                    minRotation: 0,
                    textAlign: 'center', // Center-align the tick labels
                    padding: 10, // Add some padding for better alignment
                    color: textColorSecondary,
                    font: {
                        weight: 600,
                        // align:center,
                    },
                },
                grid: {
                    display: false,
                    drawBorder: false,
                },
            },
            y: {
                display: false,
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: false,
                    drawBorder: false,
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
</script>
