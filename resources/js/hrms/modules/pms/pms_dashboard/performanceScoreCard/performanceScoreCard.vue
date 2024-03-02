<template>
    <div class="bg-white rounded-2xl p-[2rem]">
    <h1 class=" text-[20px] font-['poppins']">Performance Score Card</h1>
        <Chart type="line" :data="chartData" :options="chartOptions" class="h-30rem" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { use_pms_dashboard_store } from '../../stores/pms_dashboard_store';

const usestore = use_pms_dashboard_store();

const chartData = ref();
const chartOptions = ref();

    onMounted(() => {

    chartData.value =  setChartData();
    chartOptions.value = setChartOptions();

});


const setChartData = () => {



    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels:usestore.Performance_rating_details ? usestore.Performance_rating_details.label : [] ,
        datasets: [
            {
                label: usestore.Performance_rating_details ?  usestore.Performance_rating_details.reviewer.labels_name : '',
                data:  usestore.Performance_rating_details ?  usestore.Performance_rating_details.reviewer.score :'',
                fill: false,
                borderColor: documentStyle.getPropertyValue('--pink-500'),
                tension: 0.4
            },
            {
                label: usestore.Performance_rating_details ? usestore.Performance_rating_details.assignee.labels_name : '',
                data: usestore.Performance_rating_details ?  usestore.Performance_rating_details.assignee.score : [] ,
                fill: false,
                borderColor: documentStyle.getPropertyValue('--blue-500'),
                tension: 0.4
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
    height: 240px !important;
    /* width: 240px !important; */
}

</style>
