
<template>
    <div class="" >
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-30rem" />
        <!-- {{ usestore.pmsSelfReviewOnTime_details.label }} -->
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { use_pms_dashboard_store } from '../../stores/pms_dashboard_store';

const usestore = use_pms_dashboard_store();

onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        // labels: [" " ," " ," " ," " ," " ," " ," " ," " ," " ," " ," " ," " ," " ," " ] ,
       labels: usestore.pmsSelfReviewOnTime_details ?  usestore.pmsSelfReviewOnTime_details.label : null  ,
        datasets: [
            {
                type: 'line',
                label: 'On Time',
                borderColor: documentStyle.getPropertyValue('--blue-500'),
                borderWidth: 2,
                fill: false,
                tension: 0.4,
                data:  usestore.pmsSelfReviewOnTime_details ?  usestore.pmsSelfReviewOnTime_details.on_time_line : null
            },
            {
                type: 'bar',
                label: 'Actual Time',
                backgroundColor: '#609FBB',
                data:  usestore.pmsSelfReviewOnTime_details ?  usestore.pmsSelfReviewOnTime_details.self_review : null ,
                borderColor: '#609FBB',
                borderWidth: 2,
                borerRadius: '4px 4px 0 0'
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = '#E2F6FF';

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
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
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
</script>

<style scoped>
.p-chart{
    height: 124px !important;
    width: 300px !important;
}

</style>
