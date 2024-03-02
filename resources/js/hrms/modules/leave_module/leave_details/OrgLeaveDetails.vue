<template>
    <div class="mb-0 card leave-history">
        <div class="card-body">
            <div class=" my-2 d-flex justify-content-between align-items-center">
                <h6 class="h-7 mt-3 text-lg font-semibold text-gray-900">Org Leave Balance</h6>
                <div class="mb-2 flex justify-end items-end gap-0">
                    <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
                    <Calendar view="month" dateFormat="MM-yy" class="mx-4 border-[#535353]  border-[1px] w-[200px] "
                     v-model="leaveModuleStore.selectedOrgDate"
                     @date-select="leaveModuleStore.getOrgLeaveBalFilter()"
                     style=" border-radius: 7px; height: 30px; "
                      />
                      <!-- {{ leaveModuleStore.selectedOrgDate }} -->
                    <!-- <div class="">
                        <label for=" " class="text-lg font-semibold">Start Date</label>
                        <Calendar v-model="leaveModuleStore.selectedStartDate" dateFormat="dd-mm-yy" class="pl-3"
                            style="  border-radius: 7px; height: 30px; width: 100px;" :maxDate="new Date()" />
                    </div>
                    <div class="">
                        <label for=" " class=" text-lg font-semibold mx-2 ">End Date</label>
                        <Calendar class="mr-3" v-model="leaveModuleStore.selectedEndDate" dateFormat="dd-mm-yy"
                            style="  border-radius: 7px; height: 30px;width: 100px;" :maxDate="new Date()" />

                    </div>

                    <button class=" btn-orange py-1  px-4 rounded" style="height: 30px;"
                        @click="leaveModuleStore.getOrgLeaveBalance(dayjs(leaveModuleStore.selectedStartDate).format('YYYY-MM-DD'), dayjs(leaveModuleStore.selectedEndDate).format('YYYY-MM-DD'))">submit</button> -->

                        <!-- <span class="font-['poppins'] text-[14px]">Select Month</span> -->
                        <!-- <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
<Calendar view="month" dateFormat="MM-yy" class="mx-4 border-[#535353]  border-[1px] w-[200px] " v-model="selectedDate"
                            style=" border-radius: 7px; height: 30px;" @date-select="leaveModuleStore.getOrgLeaveBalance(selectedDate)"
                             /> -->
                </div>

            </div>
            <!-- {{ leaveModuleStore.array_orgLeaveBalance }} -->
            <DataTable :value="leaveModuleStore.array_orgLeaveBalance" :paginator="true" :rows="10"
                dataKey="user_code" @rowExpand="onRowExpand" @rowCollapse="onRowCollapse"
                v-model:expandedRows="expandedRows" v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                @select-all-change="onSelectAllChange" @row-select="onRowSelect" @row-unselect="onRowUnselect"
                :rowsPerPageOptions="[5, 10, 25]"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"

                >

                <Column style="width: 1rem !important" :expander="true"  />
                <!-- <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column> -->
                <!-- <Column field="user_code" header="Employee Id" sortable></Column> -->
                <Column field="name" header="Employee Name" class=""  sortable  >
                    <template #body="slotProps" >
                        <div class="flex items-center justify-center ">
                            <p v-if="JSON.parse(slotProps.data.employee_avatar).type == 'shortname'"
                            class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                            :class="service.getBackgroundColor(slotProps.index)">
                            {{ JSON.parse(slotProps.data.employee_avatar).data }} </p>
                        <img v-else class="w-10 rounded-circle img-md userActive-status profile-img"
                            style="height: 30px !important;"
                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.employee_avatar).data}`" srcset=""
                            alt="" />

                             <p class="pl-2  text-[#000]  text-[14px] flex flex-col font-semibold text-left fs-6">{{slotProps.data.name}}
                                <span class="text-[#535353] font-['poppins'] text-[12px] font-normal">
                                    {{ slotProps.data.user_code }}
                                </span>
                             </p>
                        </div>
                    </template>
                </Column>
                <Column field="location" header="Location"  :sortable="false"   >
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-left ">{{slotProps.data.location}}</p>
                    </template>
                </Column>
                <Column field="department" header="Department"  >
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-left">{{slotProps.data.department}}</p>
                    </template>
                </Column>

                <Column header="Total Opening Balance">

                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-left">{{slotProps.data.total_opening_balance}}</p>
                    </template>

                </Column>
                <Column header="Total Availed">
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-left">{{slotProps.data.total_avalied_balance}}</p>
                    </template>
                </Column>
                <Column field="total_leave_balance" header="Total Leave Balance"     >
                    <template #body="slotProps">
                        <p class="text-[#000] font-normal text-left">{{slotProps.data.total_leave_balance}}</p>
                    </template>
                </Column>
                <template #expansion="slotProps">
                    <div>
                        <DataTable :value="slotProps.data.leave_balance_details" scrollable
                            v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                            @select-all-change="onSelectAllChange">
                            <Column field="leave_type" class="" header="Leave Type">
                                <template #body="slotProps">
                                    <div>
                                        <p class=" text-left">{{ slotProps.data.leave_type }}</p>
                                    </div>
                                </template>

                            </Column>
                            <Column field="opening_balance" header="Opening Balance">
                                <template #body="slotProps">
                                    <div>
                                        <p class=" text-left">{{ slotProps.data.opening_balance }}</p>
                                    </div>
                                </template>
                            </Column>
                            <Column field="availed" header="Availed">
                                <template #body="slotProps">
                                    <div>
                                        <p class=" text-left">{{ slotProps.data.availed }}</p>
                                    </div>
                                </template>
                            </Column>

                            <Column field="closing_balance" header="Closing Balance">
                                <template #body="slotProps">
                                    <div>
                                        <p class=" text-left">{{ slotProps.data.closing_balance }}</p>
                                    </div>
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </template>

            </DataTable>

        </div>
    </div>


    <div class="mt-3 row card">
        <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12 card-body">
            <div class="flex justify-between">
                <div>
                    <h6 class="mb-4 text-lg font-semibold text-gray-900">Org Leave history</h6>
                </div>
                <div class="mb-2 flex justify-end items-end gap-0">
                    <!-- <label for="" class="my-2 text-lg font-semibold">Select Month</label> -->
                    <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
                    <Calendar view="month" dateFormat="MM-yy" class="mx-4  border-[#535353]  border-[1px] w-[200px]" v-model="selectedLeaveDate"
                        style="border-radius: 7px; height: 30px;"
                        @date-select="leaveModuleStore.getAllEmployeesLeaveHistory(selectedLeaveDate.getMonth() + 1, selectedLeaveDate.getFullYear(), statuses)" />
                </div>
            </div>
            <!-- {{ leaveModuleStore.array_orgLeaveHistory }} -->
            <div class="table-responsive">
                <DataTable :value="leaveModuleStore.array_orgLeaveHistory" responsiveLayout="scroll" :paginator="true"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :rows="5"
                    v-model:filters="filters" filterDisplay="menu" :globalFilterFields="['name']"
                    style="white-space: nowrap;">
                    <template #empty> No Employee data..... </template>
                    <Column class="font-bold" field="employee_name" header="Employee Name"  >
                        <template #body="slotProps">
                            <div  class="flex items-center justify-center ">
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
                    <Column field="start_date" header="Start Date"  >
                        <template #body="slotProps">
                            {{  dayjs(slotProps.data.start_date).format('DD-MMM-YYYY , h:MM A')  }}
                            <!-- {{ dayjs(slotProps.data.start_date).format('DD-MMM-YYYY') }} -->
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
                                    More...
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
                                    <span :class="'customer-badge status-' + slotProps.value" v-if="slotProps.value">{{
                                        slotProps.value }}</span>
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
                            <!-- <Button icon="" class=" text-[#000] border-[#000] border-[1px] py-2.5" label="View"
                                @click="leaveModuleStore.getLeaveDetails(slotProps.data)" style="height: 2em" /> -->
                                <i class="pi pi-eye"   @click="leaveModuleStore.getLeaveDetails(slotProps.data)" ></i>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useLeaveModuleStore } from "../LeaveModuleService";
import dayjs from 'dayjs';
import { Service } from "../../Service/Service";
const leaveModuleStore = useLeaveModuleStore();
const service=Service()

const leave_types = ref();
const leave_data = ref();
const loading = ref(true);
const selectedLeaveDate = ref(new Date());
const expandedRows = ref([]);
const selectedAllEmployee = ref();
const selectedDate = ref();

//   const filters = ref({
//     global: { value: null, matchMode: FilterMatchMode.CONTAINS },
//     name: {
//         value: null,
//         matchMode: FilterMatchMode.STARTS_WITH,
//         matchMode: FilterMatchMode.EQUALS,
//         matchMode: FilterMatchMode.CONTAINS,
//     },
//     status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
// });

const filters = ref({
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
});
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
const statuses = ref(["Pending", "Approved", "Rejected","Withdrawn"]);

onMounted(async () => {
    // console.log( "Fetching leave details for current user : " +   leaveModuleStore.baseService.current_user_code );
    await leaveModuleStore.getOrgLeaveBalance();

    await leaveModuleStore.getAllEmployeesLeaveHistory(dayjs().month() + 1, dayjs().year(), ["Approved", "Pending", "Rejected","Withdrawn"]);
    console.log("Org Leave details : " + leaveModuleStore.array_orgLeaveHistory);
    selectedDate.value = new Date();
    // selectedLeaveDate.value = new Date();
    // leaveModuleStore.selectedOrgDate = new Date();
    //    isLoading.value = false;
});

// function getdateAndMonth(){
// }


</script>

<style scoped>
.p-column-header-content {
    display: flex ;
   justify-content: flex-start;
}
</style>
