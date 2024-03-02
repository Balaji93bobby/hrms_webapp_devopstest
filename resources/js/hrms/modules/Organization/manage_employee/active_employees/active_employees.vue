<template>
    <div class="w-full">
        <div>
            <DataTable :value="manageEmployeesStore.array_active_employees" :paginator="true" :rows="10" dataKey="emp_code"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                :rowsPerPageOptions="[5, 10, 25]" v-model:filters="filters" filterDisplay="menu"
                :loading="canShowLoadingScreen" :globalFilterFields="['emp_name', 'emp_code','emp_designation','reporting_manager_name', 'status']">
                <template #header>
                <div class="text-left">
                    <div class="p-input-icon-left">
                        <i class="pi pi-search"></i>    
                        <InputText class="border p-1.5 bg-gray-100   border-gray-300" v-model="filters['global'].value" placeholder="Global Search" />
                    </div>
                </div>
            </template>
                <template #empty> No customers found.</template>
                <template #loading> Loading customers data. Please wait. </template>
                <Column class="font-bold" field="emp_name" header="Employee Name"
                    style="min-width: 5rem !important; text-align: center:  !important;">
                    <template #body="slotProps">
                        <div class="flex items-center justify-center">
                            <p v-if="JSON.parse(slotProps.data.emp_avatar).type == 'shortname'"
                                class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                                :class="service.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.emp_avatar).data }} </p>
                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${JSON.parse(slotProps.data.emp_avatar).data}`" srcset=""
                                alt="" />
                            <p class="pl-2 font-semibold  fs-6 flex flex-col text-[#0873CD]  text-justify">{{ slotProps.data.emp_name }}
                                <span class="text-[#535353]">{{ slotProps.data.emp_code }}</span>
                            
                            </p>
                        </div>
                    </template>
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                </Column>
                <!-- <Column field="emp_code" header="Employee Code" class=""  style="min-width: 10rem;" >
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />

                    </template>
                    <template #body="slotProps">
                    <div class="  flex justify-start">
                        <span class=" font-semibold text-[12px]">    {{ slotProps.data.emp_code }}</span>

                    </div>
                    </template>
                </Column> -->
                <Column field="emp_designation" header="Designation"   style="min-width: 10rem; text-align: start;" >
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                    <template #body="slotProps">
                    <div class="  flex justify-start">
                        <span class=" font-semibold text-[12px]">
                        {{ slotProps.data.emp_designation }}
                        </span>
                    </div>
                    </template>
                </Column>
                <Column field="reporting_manager_name" header="Reporting Manager" style="min-width: 10rem;" >
                    <!-- <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template> -->
                    <template #body="slotProps">
                    <div class=" flex justify-start">
                        <span class=" font-semibold text-[12px]">
                        {{ slotProps.data.reporting_manager_name }}
                        </span>
                    </div>
                    </template>
                </Column>
                <Column field="doj" header="DOJ" style="min-width: 10rem;">
                    <template #body="slotProps">{{ dayjs(slotProps.data.doj).format('DD-MMM-YYYY') }}</template>
                </Column>
                <!-- <Column field="blood_group_name" header="Blood Group"></Column> -->
                <Column field="profile_completeness" header="Profile Completeness">
                    <template #body="slotProps">
                        <!-- <ProgressBar :value="slotProps.data.profile_completeness"></ProgressBar> -->

                        <ProgressBar v-if="slotProps.data.profile_completeness <= 39"
                            :value="slotProps.data.profile_completeness"
                            :class="[slotProps.data.profile_completeness <= 39 ? 'progressbar' : '']">
                        </ProgressBar>
                        <ProgressBar class="progressbar_val2"
                            v-if="slotProps.data.profile_completeness >= 40 && slotProps.data.profile_completeness <= 59"
                            :class="[slotProps.data.profile_completeness >= 40 && slotProps.data.profile_completeness <= 59]"
                            :value="slotProps.data.profile_completeness">
                        </ProgressBar>

                        <ProgressBar class="progressbar_val3" v-if="slotProps.data.profile_completeness >= 60"
                            :class="[slotProps.data.profile_completeness >= 60]"
                            :value="slotProps.data.profile_completeness">
                        </ProgressBar>

                    </template>
                    <!-- <template #body="slotProps">{{ slotProps.data.profile_completeness + "%" }}</template> -->
                </Column>
                <Column field="enc_user_id" header="View Profile">
                    <template #body="slotProps">
                         <RouterLink :to="`/profile-page/${slotProps.data.user_id}`" @click="openProfilePage(slotProps.data)" class="px-2 py-1  "><i class="h-6 py-1 mx-2 pi pi-eye text-[#000]"></i></RouterLink>
                    </template>
                </Column>
            </DataTable>

        </div>
    </div>

</template>
<script setup>
import dayjs from 'dayjs';

import { ref, onMounted } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { profilePagesStore } from '../../../profile_pages/stores/ProfilePagesStore';
import { useManageEmployeesStore } from '../manage_service'
import { Service } from '../../../Service/Service';
import { useRouter, useRoute } from "vue-router";
// import loadingSpinner from '../../components/LoadingSpinner.vue';
import LoadingSpinner from '../../../../components/LoadingSpinner.vue';


const service = Service()
const manageEmployeesStore = useManageEmployeesStore()
const profilePageStore = profilePagesStore()



const enc_user_id = ref();

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    // emp_name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // emp_code: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // emp_designation: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // reporting_manager_name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },

    // status: { value: null, matchMode: FilterMatchMode.EQUALS },
});


onMounted(async () => {
    await manageEmployeesStore.getActiveEmployees();
    manageEmployeesStore.canShowLoadingScreen = false;

});

async function openProfilePage(uid) {
    console.log(uid);
    // profilePageStore.user_id = ''
    // console.log("user code ::",uid.user_id);
    // enc_user_id.value = uid.data;

    // profilePageStore.emp_user_code = ;
    // window.location.href = "/pages-profile-new?uid=" + uid.enc_user_id;
}

</script>

<style>
.btnt
{

    display: inline-block;
    outline: 0;
    border: 0;
    cursor: pointer;
    background: #000000;
    color: #FFFFFF;
    border-radius: 8px;
    padding: 5px 15px 10px;
    font-size: 18px;
    font-weight: 600;
    line-height: 1;
    transition: transform 200ms, background 200ms;
    font-size: 13px;


}

.btnt:hover
{
    transform: translateY(-2px);
}
.p-column-header-content{
    display: flex;
    justify-items: center;
}
</style>
