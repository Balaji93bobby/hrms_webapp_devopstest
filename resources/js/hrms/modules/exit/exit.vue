<template>
    <div class="exit-wrapper mt-30">

        <div class="mb-2 card left-line">
            <div class="pt-1 pb-0 card-body">
                <div class="row">
                    <div class="col-9">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="nav-item text-muted " role="presentation">
                                <a class="pb-2 nav-link active" data-bs-toggle="tab" href="#personal-resignation"
                                    aria-selected="true" role="tab">
                                    Personal
                                </a>
                            </li>
                            <li class="mx-4 nav-item text-muted" role="presentation">
                                <a class="pb-2 nav-link" data-bs-toggle="tab" href="#team-resignation" aria-selected="true"
                                    role="tab">
                                    Team
                                </a>
                            </li>
                            <li class="nav-item text-muted " role="presentation">
                                <a class="pb-2 nav-link" data-bs-toggle="tab" href="#org-resignation" aria-selected="true"
                                    role="tab">
                                    Org
                                </a>
                            </li>

                        </ul>

                    </div>
                    <div class="col-3 text-end">
                        <button class="btn btn-primary" id="apply_resignation" @click="applyResignationDailog = true">Apply
                            Resignation</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2 card">
            <div class="py-1 card-body">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="font-semifold">Resignation</h6>
                    </div>

                    <div class="col-6 text-end">

                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0 card">
            <div class="card-body">
                <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade active show " id="personal-resignation" role="tabpanel"
                        aria-labelledby="pills-home-tab">

                        <div v-if="!exit_data" class="no-data-img " id="noData" style="">
                            <div class="mx-auto text-center col-4">
                                <img src='../../assests/images/no-data.svg' class="h-100 w-100" alt="no-data">

                            </div>
                        </div>

                        <div v-else class="table-responsive">
                            <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10" :value="exit_data"
                                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                :rowsPerPageOptions="[5, 10, 25]"
                                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                                responsiveLayout="scroll">

                                <Column header="Date Of Resignation Initiated" field="dori" style="min-width: 8rem">
                                    <!-- <template #body="slotProps">
                        {{  slotProps.data.claim_type }}
                      </template> -->
                                </Column>

                                <Column field="resignation" header="Resignation Type" style="min-width: 12rem">
                                    <!-- <template #body="slotProps">
                        {{ "&#x20B9;" + slotProps.data.claim_amount }}
                      </template> -->
                                </Column>

                                <Column field="npd" header="Notice Period Date " style="min-width: 12rem">
                                    <!-- <template #body="slotProps">
                          {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template> -->
                                </Column>

                                <Column field="elwd" header="Expected Last working Date" style="min-width: 12rem">
                                    <!-- <template #body="slotProps">
                          {{  slotProps.data.reimbursment_remarks }}
                        </template> -->
                                </Column>
                                <Column field="" header="Withdraw " style="min-width: 12rem">
                                    <template #body>
                                        <div @click="WithdrawResignationDailog = true" class="btn btn-border-orange">
                                            Withdraw
                                        </div>
                                    </template>
                                </Column>

                                <Column header="Status" style="min-width: 12rem">
                                    <template #body="slotProps">
                                        <Tag :value="slotProps.data.status" style="font-weight: 600;"
                                            :severity="getSeverity(slotProps.data)" />
                                    </template>
                                </Column>

                            </DataTable>




                        </div>
                    </div>


                    <Dialog v-model:visible="applyResignationDailog" modal header="Resignation"
                        :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
                        <div class="resignation-content " id="resignation_form">
                            <form class="" id="resignationForm">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="">Date Of Resignation Initiated</label>
                                            <input type="text" class="form-control" id="" aria-describedby=""
                                                v-model="exit.dori">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="">Resignation Type</label>
                                            <Dropdown style="height: 2.9em;"
                                                class="w-full text-sm text-gray-900 border rounded-lg " :options="reason"
                                                optionLabel="name" v-model="exit.resignation" optionValue="code"
                                                placeholder="Select a Property" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="">Notice Period Date</label>
                                            <input type="Date" class="form-control" id="" aria-describedby=""
                                                v-model="exit.npd">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="">
                                                    <label for="" class="me-2">Expected Last working Date</label>
                                                    <button
                                                        class="px-0 bg-transparent border-0 outline-none fa fa-info-circle btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit Your Expected Last working Date"></button>
                                                </div>
                                                <button @click="expected_lastDate = true" type="button"
                                                    class="bg-transparent border-0 outline-none btn fa text-info fa-pencil"
                                                    id="expectedDate_reasonButton">
                                                </button>

                                            </div>
                                            <input type="Date" :class="[!expected_lastDate ? 'bg-gray-300' : '']"
                                                class=" form-control" id="expected_lastDate" v-model="exit.elwd"
                                                aria-describedby="" :readonly="!expected_lastDate">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="">Payroll End Date</label>
                                            <input type="Date" class="form-control" id="" v-model="exit.ped">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6" v-if="expected_lastDate">
                                        <div class="mb-3" id="reason_dialogueBox">
                                            <label for="" class="">Reason For Change In Last Working
                                                Date</label>
                                            <Textarea v-model="exit.wr" name="" id="" class="my-3" cols="30" rows="3"
                                                autoResize placeholder="Add Your Reason Here...."> </Textarea>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                    <button type="button" class="btn btn-border-orange me-2" @click="save">Save</button>
                                    <button type="button" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                    </Dialog>



                    <Dialog v-model:visible="WithdrawResignationDailog" modal header="Withdraw"
                        :style="{ width: '40vw', borderTop: '5px solid #002f56' }">

                        <p class="font-bold text-gray-600 ">Please fill the reason for Resignation Withdrawal and click
                            Submit to proceed further </p>

                        <Textarea v-model="exit.wr" name="" id="" class="my-3" cols="30" rows="3" autoResize
                            placeholder="Add Your Reason Here...."> </Textarea>

                        <template #footer>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button type="button" class="btn btn-border-orange me-2" @click="save">Save</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </template>
                    </Dialog>


                    <div class="tab-pane fade " id="team-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="resignation-table">
                            <div class="row">
                                <div class="mb-2 col-12">
                                    <h6 class="mb-2">Pending Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Replace</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="cursor-pointer dropdown-item text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>
                                                <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                        data-bs-target="#switch_task">Change</button></td>
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>
                                                <td>
                                                    <div class="dropdown custom-dropDown dropdown-action">
                                                        <button
                                                            class="bg-transparent border-0 outline-none btn dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                            style="">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-eye text-info me-2" aria-hidden="true"></i>
                                                                View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-trash text-danger me-2"
                                                                    aria-hidden="true"></i>
                                                                Delete Resignation</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="col-12 ">
                                    <h6 class="mb-2">Completed Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <!-- {{-- <th>Replace</th> --}} -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="cursor-pointer dropdown-item text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-success">Approved</span></td>
                                                <!-- {{-- <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                data-bs-target="#switch_task">Change</button></td> --}} -->
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>

                                            </tr>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="cursor-pointer dropdown-item text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-danger">Rejected</span></td>
                                                <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                        data-bs-target="#switch_task">Change</button></td>
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade " id="org-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="resignation-table">
                            <div class="row">
                                <div class="mb-2 col-12">
                                    <h6 class="mb-2">Pending Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Designation</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Reporting To</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td>Lead </td>
                                                <td> <a role="button" class="cursor-pointer dropdown-item text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>

                                                <td>Karthi</td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="mb-2 col-12">
                                    <h6 class="mb-2">Completed Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Designation</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Reporting To</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td>Lead </td>
                                                <td> <a role="button" class="cursor-pointer dropdown-item text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>

                                                <td>Karthi</td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div id="switch_task" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                <div class="modal-content">
                    <div class="py-2 border-0 modal-header new-role-header d-flex align-items-center">
                        <h6 class="modal-title">
                            Switch Task Here</h6>
                        <button type="button" class="bg-transparent border-0 outline-none close h3" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <div class="mb-3">
                                    <label for="" class="">Choose The Department Here</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">IT</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <div class="mb-3">
                                    <label for="" class="">Ask Task To</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">IT</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button class="btn btn-orange me-2" data-bs-toggle="modal"
                                    data-bs-target="#switch_task">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="resignationDetailsView" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                <div class="modal-content">
                    <div class="py-2 border-0 modal-header new-role-header d-flex align-items-center">
                        <h6 class="modal-title">
                            Employee Information</h6>
                        <button type="button" class="bg-transparent border-0 outline-none close h3" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <ul class="personal-info">
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Name</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Employee Code</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Employee Email Id</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Date Of Joining(DOJ)</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Designation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Reporting Manager</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Notice Period</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Date Of Designation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Last Working Date(Exp)</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="pb-1 border-bottom-liteAsh">
                                        <div class="title">Reason For Resignation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button class="btn btn-orange " data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";


const exit = reactive({
    dori: '',
    resignation: '',
    npd: '',
    elwd: '',
    ped: '',
    exlRes: '',
    wr: '',
    status: 'pending'
})

const exit_data = ref()


const fetch = () => {
    axios.get('http://localhost:3000/exit').then(res => {
        console.log(res.data);
        exit_data.value = res.data
    })
}

const save = () => {
    console.log(exit);
    axios.post('http://localhost:3000/exit', exit).then(res => {
        console.log(res.data);

    }).finally(() => {
        fetch()
    })

    applyResignationDailog.value = false
}

onMounted(() => {
    fetch()
})

const reason = ref([
    { name: 'Better Prospect', code: 'Better Prospect' },
    { name: 'Marriage & Relocating', code: 'Marriage & Relocating' },
    { name: 'Illness', code: 'Illness' },
    { name: 'Difficult Work Environment', code: 'Difficult Work Environment' },
    { name: 'Career Prospect', code: 'Career Prospec' },
    { name: 'Others', code: 'Others' },
])

const changeLastWorking = () => {

    expected_lastDate.value = true

}

const applyResignationDailog = ref(false)

const WithdrawResignationDailog = ref(false)

const expected_lastDate = ref(false)

const getSeverity = (status) => {

    console.log(status.status)
    switch (status.status) {
        case 'Approved':
            return 'success';

        case 'pending':
            return 'warning';

        case 'Rejected':
            return 'danger';

        default:
            return null;
    }

}





</script>

<style > label {
     font-style: normal;
     font-weight: 500;
     font-size: 16px;
     line-height: 28px;
     color: #003056;
 }
</style>