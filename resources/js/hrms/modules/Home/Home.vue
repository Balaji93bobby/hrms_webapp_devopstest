<template>
    <!-- <loadingSpinner /> -->
    <!-- <div class="flex flex-row h-screen overflow-hidden relative ">
        <Sidebar />
        <div class=" text-gray-700 bg-gray-200 h-screen w-screen">
        <Topbar />
            <div class="overflow-auto">
                <RouterView></RouterView>
            </div>
        </div>
    </div> -->

    <div id="app">
        <!--Sidebar with Dimmer -->
        <div class="flex flex-row h-screen fixed w-screen">
           <!-- Sidebar -->
           <div>
              <Sidebar />
           </div>
           <!-- Page Content -->
           <div class="bg-gray-100  text-gray-700 h-screen w-[100%] main-content  ">
              <div class="w-[100%]">
                 <Topbar />
              </div>
              <div class="h-screen p-2 !pb-20 overflow-y-auto ">
                <!-- <loadingSpinner v-if="useDashboard.canShowLoading" /> -->
                 <RouterView></RouterView>
              </div>
           </div>
        </div>
     </div>
</template>


<script setup>
import loadingSpinner from '../../components/LoadingSpinner.vue'
import Topbar from './Topbar.vue';
import Sidebar from './Sidebar.vue';
import Dashboard from '../dashboard/dashboard.vue'
import { useMainDashboardStore } from '../dashboard/stores/dashboard_service'

const useDashboard = useMainDashboardStore();


import { onMounted, ref } from 'vue';
import axios from 'axios';

const isOpen = ref(false);
const isOpens = ref(false);

const isDay = ref(true);

const toggleDayNight = () => {
    isDay.value = !isDay.value;
};


const loading = ref(true)

// onMounted(() => {
//     axios.get('/clear_cache').then((res) => {
//         console.log(res.data);
//     })
//     setTimeout(() => {
//         loading.value = false
//     }, 2000);
// })



</script>

<style>
/* This is optional if you are using Tailwind via CDN or importing it in your project. */

.dot
{
    /* Move the dot to the right when the switch is toggled on */
    transform: translateX(0);
}

/* Update the appearance of the switch when it's checked (on) */
#toggle:checked+.dot
{
    transform: translateX(6rem);
}
</style>

