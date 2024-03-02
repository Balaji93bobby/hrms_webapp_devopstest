
<template>
    <div class="" >
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-30rem" />
        <!-- {{ usestore.pmsSelfReviewOnTime_details.label }} -->
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { use_pms_dashboard_store } from '../stores/pms_dashboard_store';

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
       labels: usestore.pmsReviewerReviewOnTimeDetails ?  usestore.pmsReviewerReviewOnTimeDetails.label : null  ,
        datasets: [
            {
                type: 'line',
                label: 'On Time',
                borderColor: documentStyle.getPropertyValue('--blue-500'),
                borderWidth: 2,
                fill: false,
                tension: 0.4,
                data:  usestore.pmsReviewerReviewOnTimeDetails ?  usestore.pmsReviewerReviewOnTimeDetails.on_time_line : null
            },
            {
                type: 'bar',
                label: 'Actual Time',
                backgroundColor: '#C6907F',
                data:  usestore.pmsReviewerReviewOnTimeDetails ?  usestore.pmsReviewerReviewOnTimeDetails.reviewer_review : null ,
                borderColor: '#C6907F',
                borderWidth: 2
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder ='#F9DFDE';
    // documentStyle.getPropertyValue('--surface-border');
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
