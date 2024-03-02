<template>
    <LoadingSpinner v-if="DashboardStore.loading" class="absolute z-50 bg-white" />
<div class="w-full" >
<div class=" flex justify-between items-center my-2 " >
<span></span>
    <!-- <h1 class=" text-[#000] font-['poppins']  text-[24px] my-2"> <span class=" text-[gray]  text-[24px] "> Team Dashboard,</span> {{ service.current_user_name ?  service.current_user_name : '' }} !</h1> -->
    <Dropdown v-model="useStore.assignment_setting_id" :options="useStore.selectedyear"  @change="DashboardStore.selecteddropdownyear(useStore.assignment_setting_id,'Org')" optionValue="assignment_id" optionLabel="assignment_period" placeholder="    Select  Year" class=" h-[30px] w-[220px]  " />
</div>

    <div class="grid grid-cols-4 gap-4  h-[128px]  mb-[3rem]">
        <!-- <div class="bg-white rounded-lg" v-for="item in 4">
            {{ item }}
        </div> -->
        <div class="bg-[#FFEFE2] rounded-lg p-3">
        <h1 class="font-['poppins'] text-[16px]">Self-Review</h1>
        <div class="mt-2">
        <span class="text-[20px] font-['poppins'] my-2">{{ DashboardStore.Dashboard_selfReviews_score_details }}%</span>
        <div>
            <ProgressBar class="progressbar_val2" :value="DashboardStore.Dashboard_selfReviews_score_details" ></ProgressBar>
            <div class="flex justify-between my-2 font-['poppins']"><span>Score</span></div>
        </div>

        </div>
        </div>
        <div class="bg-[#F6F3D4] rounded-lg p-3">
        <h1 class="font-['poppins'] text-[16px]">Manager-Review</h1>
        <div class="mt-2">
        <span class="text-[20px] font-['poppins'] my-2">{{ DashboardStore.pmsDashboardReviewerScore_details }}%</span>
        <div>
            <ProgressBar class="progressbar_val2" :value="DashboardStore.pmsDashboardReviewerScore_details" ></ProgressBar>
            <div class="flex justify-between my-2 font-['poppins']"><span>Score</span></div>
        </div>
        </div>
        </div>
        <div class="!bg-[#E2F6FF] rounded-xl p-2" v-if="DashboardStore.pmsSelfReviewOnTime_details" >
            <h1 class="font-['poppins'] text-[16px]">Self-Review</h1>
            <self_review_ontime/>
        </div>
        <div class="bg-[#F9DFDE] rounded-xl p-2" v-if="DashboardStore.pmsReviewerReviewOnTimeDetails" >
            <h1 class="font-['poppins'] text-[16px]">Manager-Review</h1>
            <manager_review_ontime/>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-2">
        <div class="col-span-8 h-[340px]">
            <div class="w-full" v-if="DashboardStore.Performance_rating_details" >
                <performanceScoreCard />
            </div>
            <div class="w-full mt-2 mb-[2rem]  " v-if="DashboardStore.DashboardQuaterlyScoreCardDetails" >
                <assignmentperiod />
            </div>
        </div>
        <div class="col-span-4  gap-2"  >
            <div class="w-[100%]  " v-if="DashboardStore.Dashboardprocessdetails">
                <process />
            </div>
            <div v-else>
                <Skeleton width="100%" height="240px" ></Skeleton>
            </div>
            <div class="w-[100%]  "  >
                <TrentList />
            </div>
        </div>
    </div>
</div>

</template>
<script setup>
import { onMounted, ref } from "vue";
import { Service } from "../../Service/Service";
import performanceScoreCard from './performanceScoreCard/performanceScoreCard.vue';
import { usePmsMainStore } from "../stores/pmsMainStore";
import assignmentperiod from "./assignmentperiod/assignment_period.vue";
import self_review_ontime from "./self_review_ontime/self_review_ontime.vue";
import manager_review_ontime from "../manager_review_ontime/manager_review_ontime.vue";
import process from "./process/process.vue";
import { use_pms_dashboard_store } from '../stores/pms_dashboard_store';
import LoadingSpinner from "../../../components/LoadingSpinner.vue";
import TrentList from "./trentList/trentList.vue";

const value = ref(40);
const DashboardStore = use_pms_dashboard_store();
const useStore = usePmsMainStore();

const  service = Service();

onMounted(async () => {
let user_code;
await service.getCurrentUserCode().then(res => {
    user_code = res.data;
    useStore.selectedAssigneeFormUsercode = res.data;
})

await useStore.getAssignmentPeriodDropdown(user_code);
await DashboardStore.PerformanceRatingGraph(user_code,'Org');
await DashboardStore.pmsDashboardSelfReviewsScore(user_code,'Org');
await DashboardStore.pmsDashboardReviewerScore(user_code,'Org');
await DashboardStore.pmsSelfReviewOnTime(user_code);
await DashboardStore.pmsReviewerReviewOnTime(user_code);
await DashboardStore.pmsDashboardQuaterlyScoreCard(user_code,'Org');
await DashboardStore.getPmsTrendListOptions(user_code,'Org');
await DashboardStore.getPmsTrendList(user_code,null);
await DashboardStore.Dashboardprocess(user_code,'Org');
});


</script>


<style>

.p-progressbar-label{
display: none !important;
}
.p-progressbar-value{
background-color: #D1824D !important;
}
.p-progressbar-value .p-progressbar-value-animate{
background-color: #D1824D !important;
}
.progressbar_val2 .p-progressbar-value.p-progressbar-value-animate {
background-color: #D1824D !important;;
color: black !important;
}


.p-dropdown-label,
.p-inputtext,
.p-placeholder
{
margin-top: -5px !important;
}
</style>
