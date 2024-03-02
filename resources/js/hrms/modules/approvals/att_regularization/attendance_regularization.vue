<template>
    <div>

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '80vw', '640px': '90vw' }" :style="{ width: '380px' }" :modal="true">
            <div class="confirmation-content">
                <i class="mr-2 text-red-600 pi pi-exclamation-triangle" style="font-size: 1.3rem" />
                <span class="my-auto">Are you sure you want to {{ currentlySelectedStatus }}?</span>
            </div>
            <div class="flex w-full p-2 justify-left">
                <Textarea v-model="reviewer_comment" rows="3" cols="35" class="border rounded-md" placeholder="Your Comments..." />
            </div>
            <template #footer>
                <!-- <Button label="Yes" icon="pi pi-check" @click="processApproveReject" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="canShowConfirmation = false" class="p-button-text" /> -->
                <div class="flex justify-center items-center gap-3">
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click="processApproveReject(),canShowConfirmation = false">Yes</button>
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="canShowConfirmation = false">No</button>
                </div>
            </template>
        </Dialog>

        <div class=" relative">

            <div class=" absolute top-[-80px] right-0 ">
                <!-- @date-select="" -->
                <!-- {{ selectedDate }} -->
                <div class="flex justify-center items-center">
                    <span class="font-['poppins'] text-[16px]">Select Month</span>
                    <Calendar view="month" dateFormat="mm/yy" class="mx-4" v-model="selectedDate"
                                style=" border-radius: 7px;  height: 30px; width:120px;" @date-select="ajax_GetAttRegularizationData(selectedDate.getMonth() + 1, selectedDate.getFullYear())"
                                 />

                </div>

            </div>

            <DataTable v-if="att_regularization" :value="att_regularization" :paginator="true" :rows="10" dataKey="id"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" sortField="attendance_date" :sortOrder="-1"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
                v-model:filters="filters" filterDisplay="menu" :globalFilterFields="['name', 'status']">
                <template #empty> No Employeee found. </template>
                <template #loading> Loading customers data. Please wait. </template>

                <Column field="employee_name" header="Employee Name" class=" " style="width: 12rem !important">
                    <!-- <template #body="slotProps">
                        <div class=" flex justify-center items-center ">
                            <div class="flex justify-center items-center">
                                <p v-if="JSON.parse(slotProps.data.employee_avatar).type == 'shortname'"
                                    class=" p-2 text-white rounded-full h-18 w-[30px] text-semibold"
                                    :class="service.getBackgroundColor(slotProps.index)">{{
                                        JSON.parse(slotProps.data.employee_avatar).data }} </p>

                                <img v-else class="w-3 rounded-circle img-md userActive-status profile-img"
                                    style="height: 30px !important;"
                                    :src="`data:image/png;base64,${JSON.parse(slotProps.data.employee_avatar).data}`"
                                    srcset="" alt="" />
                            </div>
                            <div class="">
                                <p class="pl-2 ">{{ slotProps.data.employee_name }} </p>
                            </div>
                        </div>


                    </template> -->
                    <template #body="slotProps">
                    <div class="flex items-center !justify-left ">
                        <div>
                            <p v-if="slotProps.data.employee_avatar ? JSON.parse(slotProps.data.employee_avatar).type == 'shortname' : ''"
                                class="flex justify-center items-center font-semibold text-white rounded-full h-[30px] w-[30px] text-[14px]"
                                :class="service.getBackgroundColor(slotProps.index)" >
                                {{ slotProps.data.employee_avatar?JSON.parse(slotProps.data.employee_avatar).data :null }} </p>

                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${slotProps.data.employee_avatar ? JSON.parse(slotProps.data.employee_avatar).data :''}`" srcset="" alt="" />
                        </div>
                        <div>
                            <p class="pl-2  text-left font-['poppins']" :class=" slotProps.data.employee_name.length <= 20 ? 'w-[200px]' : 'w-[250px] '  ">{{ slotProps.data.employee_name }} </p>
                        </div>
                    </div>
                </template>

                    <template #filter="{ filterModel, filterCallback }">
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                            class="p-column-filter" :showClear="true" />
                    </template>
                </Column>
                <Column field="attendance_date" header="Date" :sortable="true" style="min-width: 15rem;">
                    <template #body="slotProps">
                        <h1 class="text-center ">
                            {{  dayjs(slotProps.data.attendance_date).format('DD-MMM-YYYY')  }}</h1>
                            <!-- {{ moment(slotProps.data.attendance_date).format('DD-MM-YYYY') }} -->
                    </template>
                </Column>
                <Column field="regularization_type" header="Type" style="min-width: 10rem;">
                    <template #body="slotProps">
                        <div class="p-2 text-center">
                            {{ slotProps.data.regularization_type }}
                        </div>
                    </template>

                </Column>
                <Column field="user_time" header="Actual Time" style="min-width: 10rem;"></Column>
                <Column field="regularize_time" header="Regularize Time" style="min-width: 10rem;"></Column>
                <Column field="reason_type" header="Reason" style="min-width: 18rem;">
                    <template #body="slotProps">
                        <span class=" font-['poppins']" v-if="slotProps.data.reason_type == 'Others'">
                            {{ slotProps.data.custom_reason }}
                        </span>
                        <span v-else class=" font-['poppins']" >{{ slotProps.data.reason_type }}</span>

                    </template>
                </Column>


                <Column field="reviewer_name" header="Approve Name">
                    <template #body="slotProps">
                        <p class="text-bold">{{ slotProps.data.reviewer_name ? slotProps.data.reviewer_name : '---' }}</p>
                    </template>
                </Column>
                <Column field="reviewer_comments" header="Approve Comments">
                    <!-- <template #body="slotProps">
                        <p class="text-bold">
                            {{ slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments : '---' }}
                        </p>
                    </template> -->

                    <template #body="slotProps">
                        <div v-if="slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments.length > 80 : ''">
                            <p @click="toggle" class="font-medium text-orange-400 underline cursor-pointer">
                             <span>  {{slotProps.data ?  slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments.substring(0,
                                                    40) + '..' : '' : '' }} </span> <span class=" text-blue-400 font-['poppins']"> explore more...</span>
                            </p>
                            <OverlayPanel ref="overlayPanel" style="height: 200px; w-[400px]">
                            <span class="font-['poppins']">
                                {{ slotProps.data.reviewer_comments }}
                            </span>
                            </OverlayPanel>
                        </div>
                        <div v-else>
                            {{ slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments : '---' }}
                        </div>
                    </template>
                </Column>
                <Column field="reviewer_reviewed_date" header="Reviewed Date">
                    <template #body="slotProps">
                        <p class="text-bold">
                            {{ slotProps.data.reviewer_reviewed_date ? slotProps.data.reviewer_reviewed_date : '---' }}
                        </p>
                    </template>
                </Column>

                <Column field="status" header="Status" icon="pi pi-check">
                    <template #body="{ data }">
                        <Tag :value="data.status" :severity="getSeverity(data.status)" />
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses"
                            placeholder="Select" class="p-column-filter" :showClear="true">
                            <template #value="slotProps">
                                <span :class="'customer-badge status-' + slotProps.value" v-if="slotProps.value">{{
                                    slotProps.value
                                }}</span>
                                <span v-else>{{ slotProps.placeholder }}</span>
                            </template>
                            <template #option="slotProps">
                                <span :class="'customer-badge status-' + slotProps.option">{{
                                    slotProps.option
                                }}</span>
                            </template>
                        </Dropdown>
                    </template>
                </Column>
                <Column field="" header="Action">
                    <template #body="slotProps">
                        <span style="width: 250px " class="flex justify-center items-center gap-2" v-if="slotProps.data.status == 'Pending'">
                            <!-- <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Approval"
                                @click="showConfirmDialog(slotProps.data, 'Approve')" style="height: 2em" />
                            <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button" label="Rejected"
                                style="margin-left: 8px; height: 2em"
                                @click="showConfirmDialog(slotProps.data, 'Reject')" /> -->
                                <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px] flex justify-center items-center"
                                @click="showConfirmDialog(slotProps.data, 'Approve')">
                                <i class="pi pi-check"></i>
                                </button>
                                <button class="bg-black px-4 rounded-md text-[#ffff] h-[25px]
                                 flex justify-center items-center"
                                @click="showConfirmDialog(slotProps.data, 'Reject')" >
                                <i class="pi pi-times"></i>
                                </button>
                        </span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, inject, onUpdated } from "vue";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import moment from "moment";
import { Service } from "../../Service/Service";
import dayjs from 'dayjs';
import LoadingSpinner from '../../../components/LoadingSpinner.vue';
import { UseAttendanceStore } from "./AttendanceStore";

const UseAttendance = UseAttendanceStore();

let att_regularization = ref();
let canShowConfirmation = ref(false);
let canShowLoadingScreen = ref(false);
const confirm = useConfirm();
const toast = useToast();
const reject = ref('');
const reviewer_comment = ref();
const service = Service();
const swal = inject("$swal");
const selectedDate = ref();



onUpdated(() => {
    canShowConfirmation ? reviewer_comment.value = null : ''
})

const overlayPanel = ref();
const toggle = (event) => {
    overlayPanel.value.toggle(event);
}


const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    employee_name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },

    status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
});

const statuses = ref(["Pending", "Approved", "Rejected"]);
let currentlySelectedStatus = null;
let currentlySelectedRowData = null;

onMounted(async () => {
    selectedDate.value = new Date;
    await ajax_GetAttRegularizationData(dayjs().month() + 1, dayjs().year());
});

async function ajax_GetAttRegularizationData(Month,Year) {
    UseAttendance.canShowLoadingScreen = true
    let url = window.location.origin + "/fetch-att-regularization-data";
    // console.log("AJAX URL : " + url);
    await axios.post(url,{
        month:Month,
        year:Year
    }).then((response) => {
        // console.log("Axios : " + response.data);
        att_regularization.value =response.data.data;
    }).finally(() => {
        UseAttendance.canShowLoadingScreen = false
    });
}

function showConfirmDialog(selectedRowData, status) {
    canShowConfirmation.value = true;
    currentlySelectedStatus = status;
    reject.value = status;
    currentlySelectedRowData = selectedRowData;
    // console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {
    canShowConfirmation.value = false;
    if (canClearData) resetVars();
}

function resetVars() {
    currentlySelectedStatus = "";
    currentlySelectedRowData = null;
}

const getSeverity = (status) => {
    switch (status) {
        case 'Rejected':
            return 'danger';

        case 'Approved':
            return 'success';


        case 'Pending':
            return 'warning';

    }
};



function processApproveReject() {
    hideConfirmDialog(false);
    UseAttendance.canShowLoadingScreen = true;
    // console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));

    axios
        .post(window.location.origin + "/attendance-regularization-approvals", {
            record_id: currentlySelectedRowData.id,
            approver_user_code: service.current_user_code,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            status_text: reviewer_comment.value,

        })
        .then((response) => {
            // console.log("Response : " + response);
            if (response.data.status == 'success') {
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: 'Your request has been recorded successfully',
                    life: 3000,
                });
            } else {
                Swal.fire(
                    'Failure',
                    `${response.data.message}`,
                    'error'
                )
            }

            resetVars();
        })
        .catch((error) => {
            UseAttendance.canShowLoadingScreen = false;
            resetVars();
            // console.log(error.toJSON());
        }).finally(() => {
            reviewer_comment.value = null
            UseAttendance.canShowLoadingScreen = false;
            ajax_GetAttRegularizationData(dayjs().month() + 1, dayjs().year());
        });
}
</script>


<style>
.page-content
{
    padding: calc(30px + 1.5rem) calc(1.5rem / 2) 60px calc(1.5rem / 2);
}
/* .p-overlaypanel-content{
    width:400px !important;
} */
</style>
