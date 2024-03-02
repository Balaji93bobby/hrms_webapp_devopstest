<template>
    <div>
    <div class=" flex justify-between items-end">
        <ul class="divide-x nav nav-pills divide-solid   border-b-[3px] mx-2 border-gray-300 w-[100%]"
            >
            <li class=" nav-item cursor-pointer" role="presentation" v-if="useService.current_user_role==5 ||useService.current_user_role==4 ||useService.current_user_role==3||useService.current_user_role==2 || useService.current_user_role==1 || useService.current_user_role==1 || useService.current_user_role==6" >
                <a class="px-2 position-relative border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""  @click="activetab = 1"
                    :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                    PMS Dashboard
                </a>
                <div v-if="activetab === 1 || activetab === 6 ||  activetab === 7 " class="relative h-1 rounded-l-3xl top-1 "
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-2 border-gray-300  rounded-l-3xl"></div> -->
            </li>
            <li class=" nav-item cursor-pointer" role="presentation" v-if=" useService.current_user_role==5 ||useService.current_user_role==4 || useService.current_user_role==3 || useService.current_user_role==2 || useService.current_user_role==1 || useService.current_user_role==6" >
                <a class="px-2 position-relative border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""  @click="activetab = 2"
                    :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                    SELF APPRAISAL
                </a>
                <div v-if="activetab === 2" class="relative h-1 rounded-l-3xl top-1 "
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-2 border-gray-300  rounded-l-3xl"></div> -->
            </li>

            <li class="border-0 cursor-pointer  position-relative" v-if="useService.current_user_role==4||useService.current_user_role==3||useService.current_user_role==2 || useService.current_user_role==1">
                <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]"
                     @click="activetab = 3"
                    :class="[activetab === 3 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']"
                    >
                    TEAM APPRAISAL
                </a>
                <div v-if="activetab === 3" class=" h-1 relative top-1  bottom-[1px] left-0 w-[100%]"
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-gray-300  border-3"></div> -->
            </li>

            <li class="border-0 cursor-pointer  nav-item position-relative"  v-if="useService.current_user_role==3||useService.current_user_role==2 || useService.current_user_role==1"  >
                <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                    @click="activetab = 4"   :class="[activetab === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']"
                >
                    <!-- <RouterLink :to="`/Performance/Org-Appraisal`"     :class="[activetab === 4 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']"  class="">ORGANIZATION APPRAISAL</RouterLink> -->
                    ORGANIZATION APPRAISAL
                </a>
                <div v-if="activetab === 4" class="h-1 rounded-r-3xl relative top-1 w-[100%] left-0"
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-gray-300  border-3 rounded-r-3xl"></div> -->
            </li>

            <li class="border-0  cursor-pointer nav-item position-relative" v-if="useService.current_user_role==3||useService.current_user_role==2"  >
                <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]"
                  @click="activetab = 5"
                    :class="[activetab === 5 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" >
                    PMS CONFIG
                </a>
                <div v-if="activetab === 5" class="h-1 rounded-r-3xl relative top-1 w-[100%] left-0"
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-gray-300  border-3 rounded-r-3xl"></div> -->
            </li>

            <li class="border-0 cursor-pointer  nav-item position-relative" v-if="false" >
                <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                    @click="activetab = 5"
                    :class="[activetab === 5 ? 'active font-semibold ' : 'font-medium !text-[#8B8B8B]']" >
                    PMS FORMS MANAGEMENTS
                </a>
                <div v-if="activetab === 5" class="h-1 rounded-r-3xl relative top-1 w-[100%] left-0"
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-gray-300  border-3 rounded-r-3xl"></div> -->
            </li>

        </ul>
        <!-- <button class="flex justify-center items-center gap-3   bg-white rounded-md p-3 box-border  h-[30px] w-[220px] font-['poppins'] border-[1px] border-[#DDDDDD]"> -->
        <!-- <i class="pi pi-calendar"></i> -->
         <!-- <p class=" text-[10px]"> Select Financial Year</p> -->
        <!-- </button> -->
        <div class=" relative" v-if="activetab == 1 || activetab == 6 ||  activetab == 7 && useService.current_user_role !=5 " >
        <div class=" rounded-md flex justify-between items-center border-[1px] px-3  font-['poppins'] focus:border-blue-300 cursor-pointer focus:border-[3px] hover:border-sky-700 delay-100 w-[200px] bg-white p-2" @click="enable_dropdown = !enable_dropdown" >
            <span>  {{ Dropdown_label }}</span>
            <i class="pi pi-chevron-down"></i>
        </div>
        <!-- {{ useHelper.activetab }} -->
        <transition v-if="enable_dropdown" >
            <ul class=" absolute top-[40px] bg-white rounded-b-md w-[200px] z-10 " >
            <li class=" font-['poppins'] px-3 p-2 hover:bg-blue-200 focus:bg-gray-200 cursor-pointer "  @click="usedashboard.rest_val,enable_dropdown=false,activetab=1 ,Dropdown_label='Self Dashboard' ,useHelper.activetab = 'Self' " >Self Dashboard</li>
        <li class=" font-['poppins'] px-3 p-2 hover:bg-blue-200 focus:bg-gray-200 cursor-pointer" v-if="useService.current_user_role==4 || useService.current_user_role==3 || useService.current_user_role==2 ||  useService.current_user_role==1" @click=" useHelper.activetab = 'Team',usedashboard.rest_val,enable_dropdown=false,activetab= 6,Dropdown_label='Team Dashboard'">Team Dashboard</li>
        <li class=" font-['poppins'] px-3 p-2 hover:bg-blue-200 focus:bg-gray-200 cursor-pointer" v-if="useService.current_user_role==3 || useService.current_user_role==2 ||  useService.current_user_role==1" @click="useHelper.activetab = 'Org' , usedashboard.rest_val , enable_dropdown=false, activetab=7, Dropdown_label='Org Dashboard '">Org Dashboard </li>
    </ul>

        </transition>
        </div>

        <Dropdown v-if="activetab != 1 &&  activetab != 6 &&  activetab != 7  " v-model="useStore.assignment_setting_id" :options="useStore.selectedyear"  @change="useStore.selecteddropdownyear(useStore.assignment_setting_id)" optionValue="assignment_id" optionLabel="assignment_period" placeholder="    Select  Year" class=" h-[30px] w-[220px]  " />
    </div>


        <div>
            <div v-if="activetab == 1" class="p-2">
                <pms_main_dashboard />
            </div>
            <div v-if="activetab == 2" class="p-2">
                <selfAppraisal />
            </div>
            <div v-if="activetab == 3" class=" p-2">
                <teamAppraisal />
            </div>

            <div v-if="activetab == 4">
                <organizationAppraisal />
            </div>
            <div v-if="activetab == 5">
                <pmsConfig />
            </div>

            <div v-if="activetab == 6" >
                <team_dashboard/>
            </div>
            <div v-if="activetab == 7">
                <org_dashboard/>
            </div>

        </div>

    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import selfAppraisal from './selfAppraisal/selfAppraisal.vue';
import teamAppraisal from './teamAppraisal/teamAppraisal.vue';
import organizationAppraisal from './organizationAppraisal/organizationAppraisal.vue';
import pms_main_dashboard from './pms_dashboard/pms_main_dashboard.vue';
import team_dashboard from './pms_dashboard/team_dashboard.vue';
import org_dashboard from './pms_dashboard/org_dashboard.vue';
import { usePmsMainStore } from './stores/pmsMainStore';
import pmsConfig from './pmsConfig/pmsConfig.vue';
import {usePmsHelperStore} from './stores/pmsHelperStore';
import { useMainDashboardStore } from '../dashboard/stores/dashboard_service';
import { Service } from '../Service/Service';
import axios from 'axios';
import LoadingSpinner from '../../components/LoadingSpinner.vue';
import { useRouter, useRoute } from "vue-router";

const useStore = usePmsMainStore();
const useHelper = usePmsHelperStore();
const  usedashboard  = useMainDashboardStore();

const useService = Service();

const activetab = ref(1);

onMounted(()=>{

})

const assignment_id = ref();

const items = ref([
    {name:'Self Dashboard' ,id: 1},
    {name:'Manager Dashboard',id:6},
    {name: 'Org Dashboard', id:7}
])
const Dropdown_label = ref('Self Dashboard ');

const enable_dropdown = ref(false);
</script>

