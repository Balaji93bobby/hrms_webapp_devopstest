<template>
    <div  class=" relative">
        <div class=" absolute top-[-80px] right-0  ">
            <!-- @date-select="" -->
            <div class="">
<span class="font-['poppins'] text-[16px]">Select Month</span>
<Calendar view="month" dateFormat="mm/yy" class="mx-4  " v-model="selectedDate"
                            style=" border-radius: 7px; width:120px; height: 30px;" @date-select="getAbsentRegularization(selectedDate.getMonth() + 1, selectedDate.getFullYear())"
                             />
            </div>

        </div>
        <DataTable :value="arrayAbsentRegularization" :paginator="true" :rows="10" dataKey="id"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]" sortField="attendance_date" :sortOrder="-1"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
            v-model:filters="filters" filterDisplay="menu" :globalFilterFields="['name', 'status']">
            <template #empty> No Employeee found. </template>
            <template #loading> Loading customers data. Please wait. </template>

            <Column class="font-bold" field="employee_name" header="Employee Name">
                <template #body="slotProps">
                    <div class="flex items-center !justify-left ">
                        <div>
                            <p v-if="JSON.parse(slotProps.data.employee_avatar).type == 'shortname'"
                                class=" flex justify-center items-center font-semibold text-white rounded-full h-[30px] w-[30px] text-[14px]"
                                :class="service.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.employee_avatar).data }} </p>
                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${JSON.parse(slotProps.data.employee_avatar).data}`" srcset="" alt="" />
                        </div>
                        <div>
                            <p class="pl-2 text-left font-['poppins']" :class=" slotProps.data.employee_name.length <= 20 ? 'w-[200px]' : 'w-[250px]'  ">{{ slotProps.data.employee_name }} </p>
                        </div>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Search"
                        class="p-column-filter" :showClear="true" />
                </template>
            </Column>
            <Column class="font-bold" field="attendance_date" :sortable="true" header="Attendance Date">
                <template #body="slotProps">
                    {{ dayjs(slotProps.data.attendance_date).format('DD-MMM-YYYY') }}
                </template>

            </Column>
            <Column class="font-bold" field="regularization_type" header="Regularization Type"> </Column>
            <Column class="font-bold" field="checkin_time" header="Checkin Time"> </Column>
            <Column class="font-bold" field="checkout_time" header="Checkout Time"> </Column>
            <Column class="font-bold" field="reason" header="Reason"> </Column>
            <Column class="font-bold" field="custom_reason" header="Custom Reason"> </Column>

            <Column field="reviewer_name" header="Approve Name">
                <template #body="slotProps">
                    <p class="text-bold">{{ slotProps.data.reviewer_name ? slotProps.data.reviewer_name : '---' }}</p>
                </template>
            </Column>
            <Column field="reviewer_comments" header="Approve Comments">
                <template #body="slotProps">
                    <p class="text-bold">
                        {{ slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments : '---' }}
                    </p>
                </template>
            </Column>
            <Column field="reviewer_reviewed_date" header="Reviewed Date">
                <template #body="slotProps">
                    <p class="text-bold">
                        {{ slotProps.data.reviewer_reviewed_date ? slotProps.data.reviewer_reviewed_date : '---' }}
                    </p>
                </template>
            </Column>


            <Column class="font-bold" field="status" header="Status">
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
            <Column class="font-bold" field="" header="Action">
                <template #body="slotProps">
                    <span style="width: 250px" class="flex gap-2 justify-center items-center" v-if="slotProps.data.status == 'Pending'">
                        <!-- <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Approval"
                            @click="showConfirmDialog(slotProps.data, 'Approve')" style="height: 2em" />
                        <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button" label="Rejected"
                            style="margin-left: 8px; height: 2em" @click="showConfirmDialog(slotProps.data, 'Reject')" /> -->
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

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '80vw', '640px': '90vw' }" :style="{ width: '380px' }" :modal="true">
            <div class="confirmation-content">
                <i class="mr-2 text-red-600 pi pi-exclamation-triangle" style="font-size: 1.3rem" />
                <span class="my-auto">Are you sure you want to {{ currentlySelectedStatus }}?</span>
            </div>
            <!-- v-if="reject == 'Reject'" -->
            <div class="flex w-full p-2 justify-left"  >
                <Textarea v-model="reviewer_comment" rows="3" cols="35" class="border rounded-md" placeholder="Your Comments..." />
            </div>
            <template #footer>
                <!-- <Button label="Yes" icon="pi pi-check" @click="processApproveReject" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="canShowConfirmation = false" class="p-button-text" /> -->
                <div class="flex justify-center items-center gap-3">
                <!-- {{ reject }} -->
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click="reject == 'Reject'  ? reviewer_comment ? ( processApproveReject(),canShowConfirmation = false ) : ( canShowConfirmation = true , toastmessage('warn', ' Reviewer Comment required') ) :  processApproveReject() , canShowConfirmation = false ">Yes</button>
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="canShowConfirmation = false">No</button>
                </div>
            </template>
        </Dialog>


    </div>
</template>

<script setup>
import { ref, onMounted, inject, onUpdated } from "vue";
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import dayjs from 'dayjs';
import { Service } from "../../Service/Service";
import { useToast } from "primevue/usetoast";
import {UseAttendanceStore} from "./AttendanceStore";

const UseAttendance = UseAttendanceStore();



const toast = useToast();
const arrayAbsentRegularization = ref();
const service = Service();
const swal = inject("$swal");

const canShowConfirmation = ref(false);
const canShowLoadingScreen = ref(false);
const reject = ref('');
const reviewer_comment = ref();

let currentlySelectedStatus = null;
let currentlySelectedRowData = null;
const selectedDate = ref();

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

onUpdated(() => {
    canShowConfirmation ? reviewer_comment.value = null : ''
})

onMounted(async() => {
    selectedDate.value = new Date;
    await getAbsentRegularization(dayjs().month() + 1, dayjs().year());
})

function toastmessage(status, message) {
        // success Form created successfully
        toast.add({ severity: status, summary: message, life: 3000 });
        // detail: 'Message Content'

    }


async function getAbsentRegularization(Month,Year) {
    UseAttendance.canShowLoadingScreen  = true;
    let url = window.location.origin + "/fetch-absent-regularization-data";
    // console.log("AJAX URL : " + url);
    await axios.post(url,{
        month:Month,
        year:Year
    }).then((res) => {
        arrayAbsentRegularization.value = res.data.data;
    }).finally(() => {
        UseAttendance.canShowLoadingScreen  = false
    })

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

function showConfirmDialog(selectedRowData, status) {
    currentlySelectedStatus = status;
    reject.value = status;
    currentlySelectedRowData = selectedRowData;
    canShowConfirmation.value = true
    // console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog() {
    UseAttendance.canShowLoadingScreen  = false;
}

function processApproveReject() {
    hideConfirmDialog(false);
    UseAttendance.canShowLoadingScreen  = true;
    // console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));

    axios
        .post('/approveRejectAbsentRegularization', {
            record_id: currentlySelectedRowData.id,
            approver_user_code: service.current_user_code,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            status_text: reviewer_comment.value,
            user_code: service.current_user_code,
        })
        .then((response) => {
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
            getAbsentRegularization(dayjs().month() + 1, dayjs().year());
        })
        .catch((error) => {
            UseAttendance.canShowLoadingScreen  = false;
        }).finally(() => {
            UseAttendance.canShowLoadingScreen  = false;
            reviewer_comment.value = null
        })
}

</script>
