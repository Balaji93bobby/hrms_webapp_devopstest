<template>
    <Toast />
    <LoadingSpinner v-if="useLeaveStore.canShowLoading" class="absolute z-50 bg-white" />
   <div class="w-full" >
    <div>
        <div v-if="service.current_user_role == 5">
            <p class="font-semibold text-2xl text-[#000] font-['Poppins]">Leave</p>
            <!-- <p class="font-semibold text-sm">Here you can apply Leave,<a ><span class="underline cursor-pointer hover:text-indigo-500"> Company's Leave Policy</span></a>.</p> -->
        </div>
        <div class="flex justify-between" v-else>
            <ul class=" divide-x py-auto nav nav-pills divide-solid nav-tabs-dashed " id="pills-tab" role="tablist">
                <li class="nav-item text-muted" role="presentation">
                    <a class="pb-2 nav-link active" data-bs-toggle="tab" href="#leave_balance" aria-selected="true"
                        role="tab">
                        Leave Balance</a>
                </li>
                <!--
                        Current User Role == 2 ,HR
                        Current User Role == 4 ,Manager
                        Current User Role == 5 ,Employee
                     -->
                <li class="nav-item text-muted " role="presentation"
                    v-if="service.current_user_role == 1 || service.current_user_role == 2 || service.current_user_role == 3|| service.current_user_role == 4" @click="service.clearfunction" >
                    <a class="pb-2 mx-4 nav-link" data-bs-toggle="tab" href="#team_leaveBalance" aria-selected="false"
                        tabindex="-1" role="tab" >
                        Team Leave Balance</a>
                </li>

                <li class="nav-item text-muted " role="presentation" v-if="service.current_user_role == 1 || service.current_user_role == 2 || service.current_user_role == 3" @click="service.clearfunction " >
                    <a class="pb-2 nav-link" data-bs-toggle="tab" href="#org_leave" aria-selected="false" tabindex="-1"
                        role="tab "  >
                        Org Leave Balance</a>
                </li>

            </ul>
            <div class="flex justify-end ">
                <!-- <Calendar v-model="date" class="h-[30px] flex relative"   />
                <label for="birth_date" class="!text-[#000] text-[12px]" :class="date ? ' hidden' :''" > <i class="pi pi-calendar"></i> Select Calender</label> -->
                <!-- <i class="pi pi-calendar absolute right-8 top-[70px] text-base font-bold " > <span class="font-['poppins'] text-[12px] mx-3"></span> </i> -->
                <Dropdown v-model="useLeaveStore.financial_year" :options="useLeaveStore.financial_year_leave_dropdown" @change="useLeaveStore.getEmployeeLeaveBalance(useLeaveStore.financial_year),useLeaveStore.getTermLeaveBalance(useLeaveStore.financial_year),useLeaveStore.getOrgLeaveBalance(useLeaveStore.financial_year)" optionLabel="year" optionValue="id"
              class="w-full md:w-14rem" />
              


            </div>

            <!-- <div class="flex items-center">
                <div class="mr-3 "> -->
                    <!-- <div class="input-group me-2">
                        <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar text-primary "
                                aria-hidden="true"></i></label>
                        <select class="form-select btn-line-primary" id="inputGroupSelect01">
                        </select>
                    </div> -->

                <!-- </div> -->
                <!-- <a href="/attendance-leave-policydocument" id=""
                    class="text-[14px] text-blue-500 !underline font-semibold"
                    role="button" aria-expanded="false">
                    Leave
                    Policy Explanation
                </a> -->
            <!-- </div> -->

        </div>
        <div>

        </div>
    </div>


    <div class="tab-content py-2" id="pills-tabContent">
        <div class="tab-pane show fade active" id="leave_balance" role="tabpanel" aria-labelledby="pills-profile-tab">
            <EmployeeLeaveDetails />
        </div>
        <div class="tab-pane fade show " id="team_leaveBalance" role="tabpanel" aria-labelledby="pills-profile-tab">
            <TeamLeaveDetails />
        </div>
        <div class="tab-pane show " id="org_leave" role="tabpanel" aria-labelledby="pills-profile-tab">
            <OrgLeaveDetails />
        </div>
    </div>
   </div>
    <!-- <Dialog header="Header" v-model:visible="useLeaveStore.canShowLoading"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
        :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog> -->



    <Dialog v-model:visible="apply" :style="{ width: '80vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
        <template #header>
            <h6 class="mb-4 modal-title fs-21">
                Leave Request</h6>
        </template>
        <leaveapply2 />
    </Dialog>
</template>

<script setup>
import { Service } from '../Service/Service';
import EmployeeLeaveDetails from './leave_details/EmployeeLeaveDetails.vue';
import OrgLeaveDetails from './leave_details/OrgLeaveDetails.vue';
import TeamLeaveDetails from './leave_details/TeamLeaveDetails.vue';
import { useLeaveModuleStore } from './LeaveModuleService'
import { onMounted, ref } from 'vue';
import LeaveApply from './leave_apply/LeaveApply.vue';
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import { useLeaveService } from './leave_apply/leave_apply_service';
const useLeaveStore = useLeaveModuleStore()
const service = Service()

const apply = ref(false)
const date= ref();



onMounted(async () => {
   await useLeaveStore.getEmployeeLeaveBalance()
   await useLeaveStore.getFinancialYearDropdown()
   await useLeaveStore.getLeaveNotifyDropdown()
   
})
</script>

