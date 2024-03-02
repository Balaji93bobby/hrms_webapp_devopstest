<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <h6 class="mb-4 text-lg font-semibold text-gray-900">Team Leave Balance</h6>
                    <div class=" my-2 d-flex justify-content-between align-items-center">
                        <div></div>
                        <div class=" mb-2 flex justify-end items-end gap-0 ">
                            <!-- <span class="font-['poppins'] text-[14px]">Select Month</span> -->
                            <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
                           <Calendar view="month" dateFormat="MM-yy" class="mx-4 border-[#535353]  border-[1px] w-[200px] " v-model="leaveModuleStore.selectedTeamDate"
                            style=" border-radius: 7px; height: 30px; " @date-select="leaveModuleStore.getTeamLeaveBalFilter()"
                             />

                            <!-- <div class="">
                                <label for=" " class=" font-semibold text-lg mx-2">Start Date</label>
                                <Calendar v-model="leaveModuleStore.selectedStartDate" dateFormat="dd-mm-yy" class="p-l3"
                                    style="  border-radius: 7px; height: 30px; width: 100px;" :maxDate="new Date()" />
                            </div>
                            <div class="">
                                <label for=" " class=" font-semibold text-lg mx-2 ">End Date</label>
                                <Calendar class="mr-3" v-model="leaveModuleStore.selectedEndDate" dateFormat="dd-mm-yy"
                                    style="border-radius: 7px; height: 30px;width: 100px;" :maxDate="new Date()" />

                            </div>
                            <button class=" btn-orange py-1  px-4 rounded"
                                @click="leaveModuleStore.getTermLeaveBalance(dayjs(leaveModuleStore.selectedStartDate).format('YYYY-MM-DD'), dayjs(leaveModuleStore.selectedEndDate).format('YYYY-MM-DD')),leaveModuleStore.canShowLoading = true">submit</button> -->
                        </div>

                    </div>
                </div>

                <div>
                    <!-- <h1>hello</h1> -->
                   <!-- {{ leaveModuleStore.arrayTermLeaveBalance }} -->
                    <DataTable :value="leaveModuleStore.arrayTermLeaveBalance" :paginator="true" :rows="10" class=""
                        dataKey="user_code" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
                        v-model:expandedRows="expandedRows" v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                        @select-all-change="onSelectAllChange" @row-select="onRowSelect" @row-unselect="onRowUnselect"
                        :rowsPerPageOptions="[5, 10, 25]"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">


                        <Column style="width: 1rem !important;" :expander="true" />
                        <!-- <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column> -->
                        <!-- <Column field="user_code" header="Employee Id" sortable> </Column> -->
                        <Column field="name" header="Employee Name" sortable >
                            <template  #body="slotProps">
                                <div class="flex items-center justify-center">
                                    <p v-if="JSON.parse(slotProps.data.employee_avatar).type == 'shortname'"
                                    class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                                    :class="service.getBackgroundColor(slotProps.index)">
                                    {{ JSON.parse(slotProps.data.employee_avatar).data }} </p>
                                <img v-else class="w-10 rounded-circle img-md userActive-status profile-img"
                                    style="height: 30px !important;"
                                    :src="`data:image/png;base64,${JSON.parse(slotProps.data.employee_avatar).data}`" srcset=""
                                    alt="" />
                                    <p class="pl-2  text-[#000]  text-[14px] flex flex-col font-semibold text-left fs-6">{{ slotProps.data.name }}
                                      <span class="text-[#535353] font-['poppins'] text-[12px] font-normal">{{slotProps.data.user_code}}</span>
        
                                     </p>
                                </div>
                            </template>
                            
                        </Column>
                        <Column field="location" header="Location" :sortable="false" >
                        </Column>
                        <Column field="department" header="Department" >

                        </Column>
                        <Column header="Total Opening Balance">
                
                            <template #body="slotProps">
                                <p class="text-[#000] font-normal">{{slotProps.data.total_opening_balance}}</p>
                            </template>
                        
                        </Column>
                        <Column header="Total Availed">
                            <template #body="slotProps">
                                <p class="text-[#000] font-normal">{{slotProps.data.total_avalied_balance}}</p>
                            </template>
                        </Column>
                        <Column field="total_leave_balance" header="Total Leave Balance" style="min-width: 18em;"></Column>
                        <template #expansion="slotProps">
                            <div>
                                <DataTable :value="slotProps.data.leave_balance_details" responsiveLayout="scroll"
                                    v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                                    @select-all-change="onSelectAllChange">
                                    <Column field="leave_type" header="Leave Type">
                                    <p class="text-start">{{ slotProps.data.leave_type }}</p>
                                    </Column>
                                    <Column field="opening_balance" header="Opening Balance">

                                    </Column>
                                    <Column field="availed" header="Availed">

                                    </Column>

                                    <Column field="closing_balance" header="Closing Balance">

                                    </Column>
                                </DataTable>
                            </div>
                        </template>

                    </DataTable>
                </div>
            </div>

        </div>

    </div>
    <div class="mt-3 row">
        <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12 ">
            <div class="mb-0 card leave-history">
                <div class="card-body">
                    <div class="flex justify-between">
                        <div>
                            <h6 class="mb-4 text-lg font-semibold text-gray-900 ">Team Leave history</h6>
                        </div>
                        <div class="mb-2 flex justify-end items-end gap-0">
                            <!-- <label for="" class="my-2 text-lg font-semibold">Select Month</label> -->
                            <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
                            <Calendar view="month" dateFormat="MM-yy" class="mx-4  border-[#535353]  border-[1px] w-[200px] " v-model="ManagerselectedLeaveDate"
                                style=" border-radius: 7px; height: 30px;"
                                @date-select="leaveModuleStore.getTeamLeaveHistory(ManagerselectedLeaveDate.getMonth() + 1, ManagerselectedLeaveDate.getFullYear(), statuses),leaveModuleStore.canShowLoading = true" />
                        </div>
                    </div>
                   <!-- {{ leaveModuleStore.array_teamLeaveHistory }} -->
                    <div class="table-responsive">
                        <DataTable :value="leaveModuleStore.array_teamLeaveHistory" responsiveLayout="scroll"
                            :paginator="true" :rowsPerPageOptions="[5, 10, 25]"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :rows="5"
                            v-model:filters="filters" filterDisplay="menu" :globalFilterFields="['name']"
                            style="white-space: nowrap;">
                            <template #empty> No Employee data..... </template>
                            <Column class="font-bold" field="employee_name" header="Employee Name">
                                <template #body="slotProps">
                                   
                                        <div class="flex items-center justify-center">
                                            <p v-if="JSON.parse(slotProps.data.employee_avatar).type == 'shortname'"
                                            class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                                            :class="service.getBackgroundColor(slotProps.index)">
                                            {{ JSON.parse(slotProps.data.employee_avatar).data }} </p>
                                             <img v-else class="w-10 rounded-circle img-md userActive-status profile-img"
                                            style="height: 30px !important;"
                                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.employee_avatar).data}`" srcset=""
                                            alt="" />
                                            <p class="pl-2  text-[#000]  text-[14px] flex flex-col font-semibold text-left fs-6">{{ slotProps.data.employee_name }}
                                              <span class="text-[#535353] font-['poppins'] text-[12px] font-normal">{{slotProps.data.user_code}}</span>
                
                                             </p>
                                        </div>
                                   
                                </template>
                                <template #filter="{ filterModel, filterCallback }">
                                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                                        class="p-column-filter" :showClear="true" />
                                </template>
                            </Column>
                            <Column field="leave_type" header="Leave Type">

                            </Column>
                            <Column field="start_date" header="Start Date">
                                <template #body="slotProps">
                                    {{ dayjs(slotProps.data.start_date).format('DD-MMM-YYYY') }}
                                </template>
                            </Column>
                            <Column field="end_date" header="End Date">
                                <template #body="slotProps">
                                    {{ dayjs(slotProps.data.end_date).format('DD-MMM-YYYY') }}
                                </template>
                            </Column>
                            <Column field="total_leave_datetime" header="Total Leave Days">

                            </Column>
                            <Column field="leave_reason" header="Leave Reason">
                                <template #body="slotProps">
                                    <div v-if="slotProps.data.leave_reason &&
                                        slotProps.data.leave_reason.length > 70
                                        ">
                                        <p @click="toggle" class="font-medium text-orange-400 underline cursor-pointer">
                                            explore more...
                                        </p>
                                        <OverlayPanel ref="overlayPanel" style="height: 80px">
                                            {{ slotProps.data.leave_reason }}
                                        </OverlayPanel>
                                    </div>
                                    <div v-else>
                                        {{ slotProps.data.leave_reason ?? "" }}
                                    </div>
                                </template>
                            </Column>
                            <Column field="status" header="Status">
                                <template #body="{ data }">
                                    <!-- <span :class="'customer-badge status-' + data.status">{{
                                        data.status
                                    }}</span> -->
                                    <div class="flex justify-start">
                                        <Tag  :value="data.status" :severity="getSeverity(data.status)" />
                                    </div>
                                </template>
                                <template #filter="{ filterModel, filterCallback }">
                                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses"
                                        placeholder="Select" class="p-column-filter" :showClear="true">
                                        <template #value="slotProps">
                                            <span :class="'customer-badge status-' + slotProps.value"
                                                v-if="slotProps.value">{{ slotProps.value }}</span>
                                            <span v-else>{{ slotProps.placeholder }}</span>
                                        </template>
                                        <template #option="slotProps">
                                            <span :class="'customer-badge status-' + slotProps.option">
                                                {{ slotProps.option }}</span>
                                        </template>
                                    </Dropdown>
                                </template>
                            </Column>
                            <Column field="" header="Action" style="min-width: 15rem">
                                <template #body="slotProps">
                                    <!-- <Button icon="" class=" border-[1px] text-[#000] border-[#000] py-2.5" label="View"
                                       style="height: 2em" /> -->
                                        <i class="pi pi-eye"   @click="leaveModuleStore.getLeaveDetails(slotProps.data)" ></i>
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useLeaveModuleStore } from "../LeaveModuleService";
import { Service } from "../../Service/Service";
import dayjs from 'dayjs';
const service=Service()
const leaveModuleStore = useLeaveModuleStore();


const leaves = ref();
const leave_types = ref();
const leave_data = ref();
const columns = ref();
const url = ref();
const loading = ref(true);
const teamleavehistory = ref();
const expandedRows = ref([]);
const selectedAllEmployee = ref();
const ManagerselectedLeaveDate = ref();
// const selectedDate = ref();
const getSeverity = (status) => {
    switch (status) {
        case 'Rejected':
            return 'danger';

        case 'Approved':
            return 'success';


        case 'Pending':
            return 'warning';

        case 'Withdrawn':
            return 'info'

    }
};
const filters = ref({
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const statuses = ref(["Pending", "Approved", "Rejected","Withdrawn"]);

onMounted(async () => {
    // console.log( "Fetching leave details for current user : " +   leaveModuleStore.baseService.current_user_code );

    await leaveModuleStore.getTermLeaveBalance();

    await leaveModuleStore.getTeamLeaveHistory(dayjs().month() + 1, dayjs().year(), ["Approved", "Pending", "Rejected","Withdrawn"]);
    leaveModuleStore.selectedTeamDate = new Date();
    ManagerselectedLeaveDate.value = new Date();
    //    isLoading.value = false;
});





// onMounted(() => {
//   let currentLoggedInUserID = null;

//   axios.get(window.location.origin + "/currentUser").then((response) => {
//       currentLoggedInUserID = response.data;

//       axios.post(url_team_leave, { user_id: currentLoggedInUserID }).then((response) => {
//           leaves.value = Object.values(response.data);
//           leave_types.value = Object.values(response.data.leave_types);
//           leave_data.value = Object.values(response.data.employees);
//           loading.value = false;

//           //TODO : Need to fetch all the leaves types from the backend
//           //columns.value = Object.values(response.data.array_leave_details);

//           console.log(
//               "Response Data Team Leave: " + JSON.stringify(Object.values(response.data))
//           );
//       });
//   });

//   let url_team_leave = window.location.origin + "/fetch-team-leaves-balance/";

//   console.log("Fetching Team LEAVE from url : " + url_team_leave);
// });
</script>
