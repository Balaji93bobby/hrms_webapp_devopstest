<template>
    <loadingSpinner  v-if="useDashboard.canShowLoading"  />
    <div class="" v-if="!useDashboard.canShowLoading" >
        <div class="pt-1 pb-0 ">
            <ul class="nav nav-pills nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link active " id="" data-bs-toggle="pill" href="" data-bs-target="#employee_details"
                        role="tab" aria-controls="pills-home" aria-selected="true">
                        Self-Dashboard</a>
                </li>
                <li class="mx-4 nav-item" role="presentation"
                    v-if="service.current_user_role == 1 || service.current_user_role == 2 || service.current_user_role == 3">
                    <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#family_det"
                        role="tab" aria-controls="pills-home" aria-selected="true">
                        ORG-Dashboard</a>
                </li>
                <li class="nav-item " role="presentation"  v-if="service.current_user_role == 1">
                    <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#experience_det"
                        role="tab" aria-controls="pills-home" aria-selected="true">
                        Announcement</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content " id="pills-tabContent" v-if="!useDashboard.canShowLoading" >

        <div class="tab-pane  fade active show" id="employee_details" role="tabpanel" aria-labelledby="">
            <div>
                <employee_dashboard />
            </div>
        </div>

        <div class="tab-pane fade" id="family_det" role="tabpanel" aria-labelledby="">
            <Hr_dashboard />
        </div>

        <div class="tab-pane fade" id="experience_det" role="tabpanel" aria-labelledby="">
            <div class="flex justify-center">
                <img class="h-[430px] mx-auto" src="../../assests/images/Page-is-under-construction.svg" alt="" srcset="">
            </div>
            <p class="font-semibold text-lg text-center">Page is Under construction</p>
        </div>
    </div>


</template>


<script setup>
import employee_dashboard from './employee_dashboard/employee_dashboard.vue'
import loadingSpinner from '../../components/LoadingSpinner.vue'
import { useMainDashboardStore } from './stores/dashboard_service'
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { Service } from '../Service/Service'
import Hr_dashboard from './hr_dashboard/hr_dashboard.vue';
import axios from 'axios';
import { profilePagesStore } from '../profile_pages/stores/ProfilePagesStore'

const useDashboard = useMainDashboardStore();
const canShowLoadingScreen = ref();
const service = Service();


const _profilePagesStore = profilePagesStore();

// Watch for changes in receivedData
const stopWatchingData = watch(useDashboard.allEventSource, (newValue, oldValue) => {
    if (newValue !== null) {
        handleData(newValue);
    }
});

onMounted(async () => {
    if (useDashboard.isDashboardDataReceived && useDashboard.isHrDashboardDataReceived) {
        canShowLoadingScreen.value = true;
        await useDashboard.getMainDashboardData();
        await useDashboard.getHrDashboardMainSource()
        // await useDashboard.getAttendanceStatus();
        Service();
        canShowLoadingScreen.value = false;
        axios.get('/clear_cache').then(res => {
            console.log(res.data);
        })
    }
})

// Clean up the watcher when the component is unmounted
onUnmounted(() => {
    stopWatchingData();
});
</script>





