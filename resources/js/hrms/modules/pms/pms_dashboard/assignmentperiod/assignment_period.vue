<template>
    <div class="card ">
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-30rem"  />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { use_pms_dashboard_store } from '../../stores/pms_dashboard_store';

const useStore = use_pms_dashboard_store();

onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        // labels: ['January', 'February', 'March', 'April'],
        labels: useStore.DashboardQuaterlyScoreCardDetails ? useStore.DashboardQuaterlyScoreCardDetails.label : '' ,
        datasets: [
            {
                label: ' Self Review',
                backgroundColor: documentStyle.getPropertyValue('--blue-500'),
                borderColor: documentStyle.getPropertyValue('--blue-500'),
                data: useStore.DashboardQuaterlyScoreCardDetails ? useStore.DashboardQuaterlyScoreCardDetails.self_review : ''
            },
            {
                label: 'Reviewer Review',
                backgroundColor: documentStyle.getPropertyValue('--pink-500'),
                borderColor: documentStyle.getPropertyValue('--pink-500'),
                data:useStore.DashboardQuaterlyScoreCardDetails ? useStore.DashboardQuaterlyScoreCardDetails.reviewer_review : ''
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        indexAxis: 'y',
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500
                    }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false
                }
            }
        }
    };
}
</script>

<style scoped>

.p-chart{
    height: 200px !important;
}

</style>
