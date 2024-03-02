<template>
    <LeaveBalance />
    <div class="mt-3 row">
        <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12">
            <div class="mb-0 card leave-history">
                <div class="card-body">
                    <div class="flex justify-between">
                        <div>
                            <span class="font-semibold text-[14px] text-[#000] font-['Poppins] mb-4">
                                Leave history
                            </span>
                        </div>
                        <div class="mb-2 flex justify-end items-end gap-0">
                           
                            <!-- <label for="" class="my-2 text-lg font-semibold">Select Month</label> -->
                            <p class="font-medium text-end   font-['poppins'] text-[16px]">Select Month</p>
                            <Calendar view="month" dateFormat="MM-yy" class="mx-4 border-[#535353]  border-[1px] w-[200px] " v-model="selectedLeaveDate"
                                style=" border-radius: 7px; height: 30px;"
                                @date-select="leaveModuleStore.getEmployeeLeaveHistory(selectedLeaveDate.getMonth() + 1, selectedLeaveDate.getFullYear(), statuses), leaveModuleStore.canShowLoading = true" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <DataTable :value="leaveModuleStore.array_employeeLeaveHistory" :paginator="true" :rows="5"
                            dataKey="id" :rowsPerPageOptions="[5, 10, 25]"
                            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            responsiveLayout="scroll"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                            v-model:filters="filters" filterDisplay="menu" :globalFilterFields="['name', 'status']">
                            <template #empty> No Employee data..... </template>
                            <Column field="leave_type" header="Leave Type" style="min-width: 14rem"></Column>
                            <Column field="start_date" header="Start Date" style="min-width: 8rem">
                                <template #body="slotProps">
                                    {{ dayjs(slotProps.data.start_date).format('DD-MMM-YYYY') }}
                                </template>
                            </Column>
                            <Column field="end_date" header="End Date" dataType="date" style="min-width: 8rem">
                                <template #body="slotProps">
                                    {{ dayjs(slotProps.data.end_date).format('DD-MMM-YYYY') }}
                                </template>
                            </Column>
                            <Column field="leave_reason" header="Leave Reason" style="min-width: 12rem">
                                <template #body="slotProps">
                                    <div v-if="slotProps.data.leave_reason && slotProps.data.leave_reason.length > 70">
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
                            <Column field="reviewer_name" header="Approver Name"></Column>
                            <Column field="reviewer_comments" header="Comments" style="min-width:10em">
                                <template #body="slotProps">
                                    <div v-if="slotProps.data.reviewer_comments.length > 70">
                                        <p @click="toggle" class="font-medium text-orange-400 underline cursor-pointer">explore more...
                                        </p>
                                        <OverlayPanel ref="overlayPanel" style="height: 80px;">
                                            {{ slotProps.data.reviewer_comments }}
                                        </OverlayPanel>
                                    </div>
                                    <div v-else>
                                        {{ slotProps.data.reviewer_comments.length>0 ? slotProps.data.reviewer_comments:'----' }}
                                    </div>
                                </template>
                            
                            </Column>

                            <Column field="status" header="Status" class=""  icon="pi pi-check">
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
                                                v-if="slotProps.value">{{ slotProps.value
                                                }}</span>
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
                                    <div class="flex justify-center">
                                        <button class=" text-[#000] px-4 py-2 rounded-xl"
                                            @click="leaveModuleStore.getLeaveDetails(slotProps.data)" style="">
                                            <i class="pi pi-eye"></i>
                                            </button>
                                    </div>
                                </template>
                            </Column>
                        </DataTable>
                        <!-- <div id="emp_leaveHistory" class="custom_gridJs"></div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- <button class=" w-[100px] p-2 border-[1px] border-[#000] " @click="visibleRight = true">view</button> -->
    </div>
    <!-- v-model:visible="leaveModuleStore.canShowLeaveDetails" -->
    <Dialog header="Header"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw', borderTop: '5px solid #002f56' }"
        :modal="true" :closable="true" :closeOnEscape="true">
        <template #header>
            <div class="w-full ">
                <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                    class="text-xl font-semibold">
                    Leave Details Request</h5>
            </div>
        </template>
        <div class="w-full">

            <div class="w-full border rounded-lg">
                <div class="p-3 pl-5 border d-flex align-items-center">
                    <div class="bg-yellow-100 shadow-sm rounded-circle d-flex justify-content-center align-items-center"
                        style="width:80px ; height: 80px;">
                        <h1 class="text-3xl font-semibold ">{{ leaveModuleStore.setLeaveDetails.user_short_name }}</h1>
                    </div>
                    <div class="ml-5">
                        <h1 class="text-lg font-semibold ">{{ leaveModuleStore.setLeaveDetails.name }}</h1>

                        <div>
                            <p class="fs-6 text-neutral-400 ">Requested on
                                {{ leaveModuleStore.setLeaveDetails.leaverequest_date }}</p>

                        </div>
                    </div>
                </div>
                <div class="w-full px-4 py-4 border d-flex ">
                    <div class="p-1 mx-2 rounded-lg">
                        <h1 class="px-2 py-1 text-center text-light rounded-top fw-bold" style="background-color: navy;">{{
                            dayjs(leaveModuleStore.setLeaveDetails.end_date).format('MMM') }}</h1>
                        <h1 class="px-2 py-1 text-center fs-5 fw-bold">{{
                            dayjs(leaveModuleStore.setLeaveDetails.end_date).format('DD') }}</h1>

                        <h1 class="px-2 py-1 text-center fs-6 fw-bold">{{
                            dayjs(leaveModuleStore.setLeaveDetails.end_date).format('dddd') }}</h1>
                    </div>
                    <div class="py-3">
                        <h1 class="text-lg font-semibold text-primary-800">
                            {{
                                leaveModuleStore.setLeaveDetails.total_leave_datetime }}
                            Day of
                            {{
                                leaveModuleStore.setLeaveDetails.leave_type }}
                            <span class="text-xs font-semibold">
                                ({{
                                    leaveModuleStore.setLeaveDetails.leave_reason }})
                            </span>
                        </h1>

                    </div>
                </div>
                <div class="w-full px-4 py-4 border">
                    <h1 class="text-lg font-semibold">Notified To:</h1>
                    <div class="px-3 py-2 mt-3 card d-flex" style="min-width: 250px; max-width: 300px; display: flex;">
                        <div class="p-2 d-flex align-items-center">
                            <div class="bg-blue-100 rounded-circle d-flex justify-content-center align-items-center"
                                style="width:40px ; height: 40px;">{{ leaveModuleStore.setLeaveDetails.reviewer_short_name
                                }}
                            </div>
                            <div class="px-3 flex-column">
                                <h1 class="fs-6 fw-bold ">{{ leaveModuleStore.setLeaveDetails.reviewer_name }}</h1>
                                <h1 class="py-2 text-neutral-400">{{ leaveModuleStore.setLeaveDetails.reviewer_designation
                                }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full px-4 py-4 border ">
                    <h1 class="text-lg font-semibold">Approved by</h1>
                    <div class="px-3 py-2 mt-3 card d-flex" style="min-width: 180px; max-width: 300px; display: flex;">
                        <div class="p-2 d-flex align-items-center">
                            <div class="bg-green-400 rounded-circle d-flex justify-content-center align-items-center"
                                style="width:40px ; height: 40px;"><i class="pi pi-check text-light"></i></div>
                            <div class="px-3 flex-column">
                                <h1 class="fs-6 fw-bold ">{{ leaveModuleStore.setLeaveDetails.reviewer_name }}</h1>
                                <h1 class="py-2 text-neutral-400">
                                    on
                                    {{ dayjs(leaveModuleStore.setLeaveDetails.leaverequest_date).format('DD-MMM-YYYY hh: mm: ss A') }}
                                </h1>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mx-3 my-4">
                    <Textarea name="" id="" cols="70" rows="3" autoResize placeholder="Add Comment" />
                </div>
            </div>
        </div>
        <div class="mx-4 my-4 text-end">
            <button class="px-5 mx-2 btn btn-orange"
                @click="leaveModuleStore.performLeaveWithdraw(leaveModuleStore.setLeaveDetails.id)"
                v-if="leaveModuleStore.setLeaveDetails.can_withdraw_leave !== null && leaveModuleStore.setLeaveDetails.can_withdraw_leave">Withdraw</button>
            <!-- For Employee -->
            <button class="px-5 mx-2 btn btn-orange" @click="Leavehistory_Addcomment_btn"
                v-if="leaveModuleStore.setLeaveDetails.can_revoke_leave !== null && leaveModuleStore.setLeaveDetails.can_revoke_leave">Revoke</button>
            <!-- For Manager -->
            <button class="px-5 btn btn-orange " @click="Leavehistory_Addcomment_btn">Post</button>
        </div>
        <!-- {{ leaveModuleStore.setLeaveDetails }} -->
        <!-- {{ dayjs(slotProps.data.end_date).format('DD-MMM-YYYY') }} -->






    </Dialog>
    <!-- leave request sidebar -->
    <Sidebar v-model:visible="leaveModuleStore.canShowLeaveDetails" position="right" :style="{ width: '40vw !important' }">
       
        <template #header>
            <div class=" bg-[#000] w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold">Leave Request Details</h1>
            </div>
        </template>
        <Toast/>
        <div class="flex items-center mt-6">
            <img src="" alt="" class="rounded-full ">
            <div class="bg-blue-200 w-[40px] h-[40px] rounded-full mr-4 ml-2 flex items-center justify-center">{{ leaveModuleStore.setLeaveDetails.user_short_name }}</div>
            <div class="flex flex-col items-center justify-center ">
                <h1 class="font-semibold ">{{ leaveModuleStore.setLeaveDetails.name }}</h1>
                <p>{{leaveModuleStore.setLeaveDetails.user_code}}</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 p-2 my-2 mx-2 bg-gray-200 rounded-md">
            <div class="flex flex-col ">
                <b>Leave Type</b>
                <span>{{leaveModuleStore.setLeaveDetails.leave_type}}</span>
            </div>
            <div class="flex flex-col ">
                <b>Start Date</b>
                <span>{{ dayjs(leaveModuleStore.setLeaveDetails.start_date).format('DD-MMM-YYYY') }}</span>
            </div>
            <div class="flex flex-col ">
                <b>End Date</b>
                <span>{{ dayjs(leaveModuleStore.setLeaveDetails.end_date).format('DD-MMM-YYYY') }} </span>
            </div>
            <div class="flex flex-col ">
                <b>Total Leave Days</b>
                <span>{{leaveModuleStore.setLeaveDetails.total_leave_datetime}}</span>
            </div>
            <div class="flex flex-col ">
                <b>Status</b>
                <span>{{leaveModuleStore.setLeaveDetails.status}}</span>
            </div>
        </div>
        <div class="my-2 p-2 h-[60px]">
            <b>Leave Reason</b>
            <p>{{leaveModuleStore.setLeaveDetails.leave_reason}}
            </p>
        </div>
        <div class="p-2 my-2">
            <b>Notified to</b>
            <div class="flex items-center mt-2">
                <img src="" alt="" class="rounded-full ">
                <div class="bg-orange-200 w-[40px] h-[40px] rounded-full mr-4 flex items-center justify-center">{{leaveModuleStore.setLeaveDetails.reviewer_short_name}}  </div>
                <div class="flex flex-col items-center justify-center ">
                    <h1 class="font-semibold ">{{leaveModuleStore.setLeaveDetails.reviewer_name}}</h1>
                    <p>-</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col p-2 " v-if="leaveModuleStore.setLeaveDetails.status.includes('Pending')">
           <b>Comments</b>
            <textarea v-model="leaveModuleStore.withdraw_comment" name="" id="" cols="10" rows="5" class="mx-2 border-[1px] border-[#000] rounded-lg mt-2 p-2"
            ></textarea>
           
        </div>

        <div class=" flex justify-center items-center mt-[50px]">
             <!-- <button class=" border-[2px] border-[#000] rounded-md p-2 mx-2 font-semibold  text-[12px]"  @click="revokeLeaveRequest(leaveModuleStore.setLeaveDetails)"
                v-if="leaveModuleStore.setLeaveDetails.can_revoke_leave !== null && leaveModuleStore.setLeaveDetails.can_revoke_leave" >Revoke</button> -->
             <button class=" bg-[#000] text-[#fff] rounded-md font-semibold p-2 mx-2 text-[12px] "  @click="leaveModuleStore.withdraw_comment.length>0 ? leaveModuleStore.performLeaveWithdraw(leaveModuleStore.setLeaveDetails.id)  : toastmessage('info','Comments is required')"
                v-if="leaveModuleStore.setLeaveDetails.can_withdraw_leave !== null && leaveModuleStore.setLeaveDetails.can_withdraw_leave" >Withdraw</button>
                
        </div>
        <!-- leaveModuleStore.performLeaveWithdraw(leaveModuleStore.setLeaveDetails.id) -->
    </Sidebar>
</template>

<script setup>
import { ref, onMounted,computed } from "vue";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { FilterMatchMode, FilterOperator } from "primevue/api";
import moment from "moment";
import { useLeaveModuleStore } from "../LeaveModuleService";
import LeaveBalance from "./EmployeeLeaveBalance.vue";
import dayjs from 'dayjs';
import { useToast } from "primevue/usetoast";
// import { useLeaveService } from "../leave_apply/leave_apply_service";
// const leaveservice=useLeaveService()

const leaveModuleStore = useLeaveModuleStore();
const isLoading = ref(true);
const toast = useToast();

const overlayPanel = ref();
const selectedLeaveDate = ref();


function submitWithdraw(withdraw_id)
{
    console.log(withdraw_id)
    console.log(leaveModuleStore.withdraw_comment)
   
}

const toggle = (event) => {
    overlayPanel.value.toggle(event);
};

const visibleRight = ref(true);
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
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
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
    await leaveModuleStore.getEmployeeLeaveHistory(dayjs().month() + 1, dayjs().year(), ["Approved", "Pending", "Rejected","Withdrawn"]);
    isLoading.value = false;
    selectedLeaveDate.value = new Date() ;
});



async function showLeaveDetails(leave_record_id) {
    console.log("Showing leave details for record_id : " + leave_record_id);

    await leaveModuleStore.getLeaveInformation(leave_record_id);
}

async function revokeLeaveRequest(selected_leave_details) {

    //params : record_id , approver_user_code, user_type, review_comment
    await leaveModuleStore.revokeLeaveRequest(selected_leave_details.id , selected_leave_details.reviewer_usercode, selected_leave_details.review_comment);

    leaveModuleStore.canShowLeaveDetails = false;


}

function toastmessage(status, message) {
    // success Form created successfully
    toast.add({ severity: status, summary: message, life: 3000 });
    // detail: 'Message Content'

}

</script>
