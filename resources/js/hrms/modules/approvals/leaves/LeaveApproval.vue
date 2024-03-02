<template>
    <LoadingSpinner v-if="canShowLoadingScreen" class="absolute z-50 bg-white" />
    <div class="w-full p-2 bg-white rounded-lg">
        <div class="col-sm-12 col-xxl-6 col-md-6 col-xl-6 col-lg-6">
            <h6 class="my-2 text-lg font-semibold">Leave Approvals</h6>
        </div>
        <!-- <ConfirmDialog></ConfirmDialog> -->
        <Toast />
        <!-- <Dialog header="Header" v-model:visible="loading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog> -->
        <!-- <Dialog header="Header" v-model:visible="canShowLoadingScreen" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog> -->

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '450px' }" :modal="true">
            <div class="mt-3 ml-3 confirmation-content d-flex justify-content-start align-items-center">
                <i class="mr-3 text-red-600 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to {{ currentlySelectedStatus }}?</span>
            </div>
            <div class="w-full pl-3 mt-4 d-flex justify-content-start align-items-center" style="margin-bottom: -12px;">
                <Textarea  name="" id="" v-model="reviewer_comments"
                    class="p-2 border rounded" cols="45" rows="4" autoResize placeholder="Add Comment" />
                <!-- {{ reviewer_comments }} -->
            </div>
            <template #footer>
                <!-- <Button label="Yes" icon="pi pi-check" @click="processApproveReject()" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text" /> -->
                <div class="flex justify-center items-center gap-3">
                    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click=" currentlySelectedStatus == 'Reject'  ? reviewer_comments ? (  processApproveReject() , canShowConfirmation = true ) : ( canShowConfirmation = true , toastmessage('warn', ' Reviewer Comment required') ) :  processApproveReject() , canShowConfirmation = false ">Yes</button>
                    <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="hideConfirmDialog(true)">No</button>
                </div>
            </template>
        </Dialog>
        <Dialog header="Error" v-model:visible="canShowErrorResponseScreen"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content">
                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />

                <span>Error while processing the request : {{ responseErrorMessage }}</span>
            </div>
            <template #footer>
                <!-- <Button label="Ok" icon="pi pi-check" autofocus /> -->
                <button class=" bg-[#000] px-4 rounded-md text-[#fff] h-[25px]"
                    @click="canShowErrorResponseScreen = false">No</button>
            </template>
        </Dialog>
        <div class="mt-3">

            <DataTable :value="att_leaves" :paginator="true" :rows="10" dataKey="emp_user_code" :rowsPerPageOptions="[5, 10, 25]"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                sortField="leaverequest_date" :sortOrder="-1" v-model:filters="filters" filterDisplay="menu"
                :globalFilterFields="['employee_name','emp_user_code','leave_type', 'status']" style="white-space: nowrap;">
                <template #header>
                <div class="text-left">
                    <div class="p-input-icon-left">
                        <i class="pi pi-search"></i>
                        <InputText class="border p-1.5 bg-gray-100   border-gray-300" v-model="filters['global'].value" placeholder="Global Search" />
                    </div>
                </div>
            </template>
                <template #empty> No Employee found </template>
                <template #loading> Loading customers data. Please wait. </template>

                <Column class="font-bold" field="employee_name" header="Employee Name" style="min-width: 18em;">
                    <template #body="slotProps">
                        <!-- {{ slotProps.data }} -->
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
                              <span class="text-[#535353] font-['poppins'] text-[12px] font-normal">{{slotProps.data.emp_user_code}}</span>

                             </p>
                        </div>
                    </template>

                    <!-- <template #filter="{ filterModel, filterCallback }">
                        {{ filterModel.value }}
                        <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Searchaaa"
                            class="p-column-filter" :showClear="true" />
                    </template> -->

                </Column>
                <Column field="leaverequest_date" header="Date" :sortable="true">
                    <template #body="slotProps">
                   <p class="text-start   text-[#000]">
                    {{  dayjs(slotProps.data.leaverequest_date).format('DD-MMM-YYYY , h:MM A')  }}
                   </p>     <!-- {{ dateFormat(slotProps.data.leaverequest_date, "dd-mm-yyyy, h:MM TT") }} -->
                    </template>
                </Column>
                <Column field="leave_type" header="Leave Type" style="min-width: 10em;white-space:pre-wrap;">
                    <template #body="slotProps">
                        <p class="text-start   text-[#000]">
                            {{slotProps.data.leave_type}}
                        </p>
                        <div>

                        </div>
                    </template>
                </Column>
                <Column field="start_date" header="Start Time">
                    <template #body="slotProps">
                        <!-- {{ slotProps.data.reimbursement_date }} -->
                        <!-- {{ Date.parse(slotProps.data.start_date) }} -->
                       <p class="text-start   text-[#000]"> {{ processDate(slotProps.data.start_date) }}</p>
                    </template>
                </Column>
                <Column field="end_date" header="End Time">
                    <template #body="slotProps">
                     <p class="text-start   text-[#000]">   {{ processDate(slotProps.data.end_date) }}</p>
                        <!-- {{ slotProps.data.reimbursement_date }} -->
                        <!-- {{ dateFormat(slotProps.data.end_date, "dd-mm-yyyy, h:MM TT") }} -->
                    </template>
                </Column>
                <!-- <Column field="total_leave_datetime" header="Total"></Column> -->
                <Column field="leave_reason" header="Leave Reason" style="min-width: 10em;white-space:pre-wrap;">
                    <template #body="slotProps">
                    <div v-if="slotProps.data.leave_reason.length > 30" >
                        <div class=" !line-clamp-4 " v-if=" leave_reason !=  slotProps.data.id ">
                        <p v-if="slotProps.data.leave_reason.length > 30" > {{ slotProps.data.leave_reason.substring(0, 30) + '...'}}</p>
                            <button v-if="slotProps.data.leave_reason.length > 30" @click="leave_reason =  slotProps.data.id ,toggle(slotProps.data.id)" class="font-medium text-blue-400 underline cursor-pointer"> more...
                            </button>
                        </div>
                        <div  v-if="leave_reason ==  slotProps.data.id " class="text-start   text-[#000]  !line-clamp-4 ">
                            {{ slotProps.data.leave_reason }}
                            <button @click="leave_reason = '' ,toggle(slotProps.data.id)" class="font-medium text-blue-400 underline cursor-pointer"> Less...
                            </button>
                        </div>
                    </div>
                    <div v-else >
                        {{ slotProps.data.leave_reason }}
                    </div>

                    </template>
                </Column>
                <Column field="reviewer_name"  header="Approver Name">
                    <template #body="slotProps">
                        <p class="text-start  text-[#000]">{{slotProps.data.reviewer_name}}</p>
                    </template>
                </Column>
                <Column field="reviewer_comments"  header="Comments"
               >
                    <!-- <template #body="slotProps">
                        <div v-if=" slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments.length > 70 :''">
                            <p @click="toggle" class="font-medium text-orange-400 underline cursor-pointer">explore more...
                            </p>
                            <OverlayPanel ref="overlayPanel" style="height: 80px;">
                                {{ slotProps.data.reviewer_comments }}
                            </OverlayPanel>
                        </div>
                        <div v-else class="text-start  text-[#000]">

                            {{  slotProps.data.reviewer_comments ? slotProps.data.reviewer_comments.length>0 ? slotProps.data.reviewer_comments:'-----' :'' }}
                        </div>
                    </template> -->
                <template>
                    <div v-if="slotProps.data.reviewer_comments.length > 70" >
                        <div class=" !line-clamp-4 " v-if=" reviewer_id !=  slotProps.data.id ">
                        <p v-if="slotProps.data.reviewer_comments.length > 70" > {{ slotProps.data.reviewer_comments.substring(0, 70) + '...'}}</p>
                            <button v-if="slotProps.data.reviewer_comments.length > 70" @click="reviewer_id =  slotProps.data.id ,toggle(slotProps.data.id)" class="font-medium text-blue-400 underline cursor-pointer"> more...
                            </button>
                        </div>
                        <div  v-if="reviewer_id ==  slotProps.data.id " class="text-start   text-[#000]  !line-clamp-4 ">
                            {{ slotProps.data.reviewer_comments}}
                            <button @click="reviewer_id = '' ,toggle(slotProps.data.id)" class="font-medium text-blue-400 underline cursor-pointer"> Less...
                            </button>
                        </div>
                    </div>
                    <div v-else >
                        {{  slotProps.data.reviewer_comments ?  slotProps.data.reviewer_comments : '-' }}
                    </div>
                </template>
                </Column>
                <Column field="status" header="Status" icon="pi pi-check">
                    <template #body="{ data }">
                        <Tag :value="data.status" :severity="getSeverity(data.status)" />
                        <!-- <span :class="'customer-badge status-' + data.status">{{ data.status }}</span> -->
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Select One" class="p-column-filter" style="min-width: 12rem" :showClear="true">
                        <template #option="slotProps">
                            <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)" />
                        </template>
                    </Dropdown>
                </template>
                </Column>

                <Column style="width: 300px"  field="" header="Actions">
                    <template #body="slotProps">
                        <!-- <Button icon="pi pi-check" class="p-button-success"  @click="confirmDialog(slotProps.data,'Approved')" label="Approval" />
                        <Button icon="pi pi-times" class="p-button-danger" @click="confirmDialog(slotProps.data,'Rejected')" label="Rejected" /> -->
                        <span v-if="slotProps.data.status == 'Pending'" class="gap-2 justify-center items-center flex">
                            <!-- <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Approve"
                                @click="showConfirmDialog(slotProps.data, 'Approve')" style="height: 2em" />
                            <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button" label="Reject"
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
                        <span v-if="slotProps.data.status=='Approved' || slotProps.data.status=='Rejected' || slotProps.data.status=='Withdrawn'">
                            <button @click="revoke_sidebar=true ,selected_leave_row = slotProps.data ">
                                <i class="pi pi-eye"></i>

                            </button>
                        </span>
                    </template>
                </Column>
            </DataTable>
        </div>
        <!-- {{ att_leaves }} -->
        <!-- approve or reject revoking sidebar -->
        <Sidebar v-model:visible="revoke_sidebar" position="right" :style="{ width: '40vw !important' }">
            <template #header>
                <div class=" bg-[#000] w-[100%] h-[60px] absolute top-0 left-0 ">
                    <h1 class=" m-4 text-[#ffff] font-['poppins] font-semibold">Leave  Details</h1>
                </div>
            </template>
    <!-- {{ selected_leave_row }} -->
            <div class="flex items-center mt-6">
                <img src="" alt="" class="rounded-full ">
                <div class="bg-blue-200 w-[40px] h-[40px] rounded-full mr-4 ml-2 flex items-center justify-center">
                    <!-- {{ selected_leave_row.employee_avatar.data }} -->  {{JSON.parse(selected_leave_row.employee_avatar).data}}
                </div>

                <div class="flex flex-col items-center justify-center ">
                    <h1 class="font-semibold ">{{selected_leave_row.employee_name}}</h1>
                    <p>{{selected_leave_row.emp_user_code}}</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 p-2 my-2 mx-2 bg-gray-200 rounded-md">
                <div class="flex flex-col ">
                    <b>Leave Type</b>
                    <span> {{selected_leave_row.leave_type}}</span>
                </div>
                <div class="flex flex-col ">
                    <b>Start Date</b>
                    <span>{{ dayjs(selected_leave_row.start_date).format('DD-MMM-YYYY') }}</span>
                </div>
                <div class="flex flex-col ">
                    <b>End Date</b>
                    <span>{{ dayjs(selected_leave_row.end_date).format('DD-MMM-YYYY')}}</span>
                </div>
                <div class="flex flex-col ">
                    <b>Total Leave Days</b>
                    <span>{{selected_leave_row.total_leave_datetime}}</span>
                </div>
                <div class="flex flex-col ">
                    <b>Status</b>
                    <span>{{selected_leave_row.status}}</span>
                </div>
            </div>
            <div class="my-2 p-2 h-[60px]">
                <b>Leave Reason</b>
                <p>
                    {{ selected_leave_row.leave_reason }}
                </p>
            </div>
            <div class="p-2 my-2">
                <b>Notified to</b>
                <div class="flex items-center mt-2">
                    <img src="" alt="" class="rounded-full ">
                    <div class="bg-orange-200 w-[40px] h-[40px] rounded-full mr-4 flex items-center justify-center">
                                 <!-- {{ selected_leave_row.reviewer_avatar.data }} -->
                                 <!-- {{  JSON.parse(selected_leave_row.employee_avatar).data }} -->
                    </div>
                    <div class="flex flex-col items-center justify-center ">
                        <h1 class="font-semibold ">
                            {{ selected_leave_row.reviewer_name }}
                        </h1>
                        <p>{{selected_leave_row.reviewer_user_code}}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-2 " v-if="selected_leave_row.status.includes('Approved') || selected_leave_row.status.includes('Rejected')">
               <b>Comments<span class="text-danger">*</span></b>
                <textarea v-model="leaveModuleStore.revoking_comment" name=""  id="" cols="10" rows="5" class="mx-2 border-[1px] border-[#000] rounded-lg mt-2 p-2"
                :class="[
                                comV$.revoking_comment.$error ? 'p-invalid' : '',
                            ]" ></textarea>
                            <span v-if="comV$.revoking_comment.$error" class="font-semibold text-red-400 fs-6">
                                {{ comV$.revoking_comment.$errors[0].$message }}
                            </span>
            </div>

            <div class=" flex justify-center items-center mt-[50px]">
                        <button @click="validateComment(selected_leave_row.id)"
                         class=" bg-[#000] text-[#fff] rounded-md font-semibold p-2 mx-2 text-[12px] ">Revoke</button>
            </div>

        </Sidebar>
    </div>
</template>
<script setup>
import { ref, onMounted,computed, reactive } from "vue";
import dateFormat from "dateformat";
import axios from "axios";
import dayjs from 'dayjs';
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { Service } from '../../Service/Service';
import LoadingSpinner from "../../../components/LoadingSpinner.vue";
import { useLeaveModuleStore } from "../../leave_module/LeaveModuleService";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

const revoke_sidebar=ref(false)
const service = Service()
const leaveModuleStore = useLeaveModuleStore();

let att_leaves = ref();
let canShowConfirmation = ref(false);
let canShowErrorResponseScreen = ref(false);
let responseErrorMessage = ref();
let canShowLoadingScreen = ref(false);
const confirm = useConfirm();
const toast = useToast();
const reviewer_comments = ref();
const selected_leave_row= ref();
const leave_reason = ref();
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    status: { value:null, matchMode: FilterMatchMode.EQUALS },
    // employee_name: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },
    // emp_user_code: {
    //     value: null,
    //     matchMode: FilterMatchMode.STARTS_WITH,
    //     matchMode: FilterMatchMode.EQUALS,
    //     matchMode: FilterMatchMode.CONTAINS,
    // },

    // status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
});

const loading = ref(false);
const statuses = ref(["Pending", "Approved", "Rejected","Withdrawn"]);

const overlayPanel = ref();
const reviewer_id  = ref();
const toggle = (event) => {
    reviewer_id.value  = event;
    overlayPanel.value = event;
}

// comment validation
const commentRule=computed(()=>{
    return{
        revoking_comment:{required:helpers.withMessage('Comments is Required',required)}
    }
})
const comV$=useValidate(commentRule,leaveModuleStore)
function validateComment(data_id)
{
    comV$.value.$validate()
    if(!comV$.value.$error)
    {
        console.log('Form successfully submitted.')

        leaveModuleStore.revokeLeaveRequest(data_id)
        revoke_sidebar.value=false
        comV$.value=''

    }
    else{
        comV$.value=''
        console.log('Form failed validation')
    }
}

function toastmessage(status, message) {
        // success Form created successfully
        toast.add({ severity: status, summary: message, life: 3000 });
        // detail: 'Message Content'

    }

let currentlySelectedStatus = null;
let currentlySelectedRowData = null;

const form_data = reactive({
    review_comment: ''
});

onMounted(() => {
    ajax_GetLeaveData();
});

function ajax_GetLeaveData() {
    canShowLoadingScreen.value = true;
    let url = window.location.origin + "/fetch-leaverequests-based-on-currentrole";
    axios.get(url).then((response) => {
        att_leaves.value = response.data.data;
    }).finally(() => {
        canShowLoadingScreen.value = false;
    });
}

function processDate(date) {
    if (isNaN(Date.parse(date)))
        return "Invalid date";
    else
        return dateFormat(date, "dd-mm-yyyy, h:MM TT");
}

function showConfirmDialog(selectedRowData, status) {
    canShowErrorResponseScreen.value = false;
    canShowConfirmation.value = true;
    currentlySelectedStatus = status;
    currentlySelectedRowData = selectedRowData;

    console.log("Selected Row Data : " + JSON.stringify(selectedRowData));
}

function hideConfirmDialog(canClearData) {

    canShowConfirmation.value = false;

    if (canClearData) resetVars();
}

function resetVars() {
    currentlySelectedStatus = "";
    currentlySelectedRowData = null;
}

////PrimeVue ConfirmDialog code -- Keeping here for reference
//const confirm = useConfirm();

// function confirmDialog(selectedRowData, status) {
//     console.log("Showing confirm dialog now...");

//     confirm.require({
//         message: 'Are you sure you want to proceed?',
//         header: 'Confirmation',
//         icon: 'pi pi-exclamation-triangle',
//         accept: () => {
//             toast.add({severity:'info', summary:'Confirmed', detail:'You have '+status, life: 3000});
//         },
//         reject: () => {
//             console.log("Rejected");
//             //toast.add({severity:'error', summary:'Rejected', detail:'You have rejected', life: 3000});
//         }
//     });
// }

const css_statusColumn = (data) => {
    return [
        {
            pending: data.status === "Pending",
            approved: data.status === "Approved",
            rejected: data.status === "Rejected",
        },
    ];
};

function processApproveReject() {
    console.log(form_data.review_comment);
    hideConfirmDialog(false);

    canShowLoadingScreen.value = true;

    //console.log("Processing Rowdata : " + JSON.stringify(currentlySelectedRowData));

    axios
        .post(window.location.origin + "/attendance-approve-rejectleave", {
            record_id: currentlySelectedRowData.id,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            review_comment: form_data.review_comment,
        })
        .then((res) => {
            console.log(res);
            resetVars();

            // if (response.data.status == "success") {
            //     ajax_GetLeaveData();

            // }
            // else
            //     if (response.data.status == "failure") {
            //         canShowErrorResponseScreen.value = true;
            //         responseErrorMessage.value = response.data.message;
            //         return;
            //     }
            Swal.fire({
                        title: res.data.status =="success"?  "Success" :  "Oops!",
                        text: res.data.message,
                        icon:  res.data.status == "success" ? "success" :"error",
                    })


        })
        .catch((error) => {
            canShowLoadingScreen.value = false;
            resetVars();

            console.log(error.toJSON());
        }).finally(() => {
            canShowLoadingScreen.value = false;

        });
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

</script>

