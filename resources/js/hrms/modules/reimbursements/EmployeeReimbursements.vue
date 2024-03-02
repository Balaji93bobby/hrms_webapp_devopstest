<template>
    <Toast />
    <LoadingSpinner v-if="employee_service.loading_spinner" class="absolute z-50 bg-white" />

    <div class="reimbursement-wrapper">
        <div class="mb-2 card left-line">
            <div class="pt-1 pb-1 card-body">
                <div class="grid grid-cols-12">
                    <div class="col-span-5">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="nav-item text-muted" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#reimbursement" aria-selected="true"
                                    role="tab" @click="employee_service.onclickSwitchToReimbursmentTab">
                                    Reimbursement
                                </a>
                            </li>

                            <li class="nav-item text-muted" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#localConveyance" aria-selected="true"
                                    role="tab" @click="employee_service.onclickSwitchToLocalCoverganceTab">
                                    Local Conveyance
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-7">
                        <div class="row">
                            <div class="col-5 d-flex justify-content-center">
                                <label for="" class="my-auto font-semibold fs-6 whitespace-nowrap"
                                    style="width: 100px;">Select Month</label>
                                <Calendar v-model="employee_service.selected_date" view="month" dateFormat="mm/yy"
                                    class="mx-4" style="border-radius: 7px; height: 35px;" />
                            </div>
                            <div class="col-2 d-flex justify-content-end ">
                                <button label="Submit" class=" my-auto btn btn-primary z-0 whitespace-nowrap"
                                    severity="danger" style="height: 33px;"
                                    :disabled="!employee_service.selected_date == '' ? false : true"
                                    @click="employee_service.generate_ajax"> <i class="fa fa-cog me-2"></i>
                                    Generate</button>
                            </div>
                            <div class="col-2 d-flex justify-content-end  mx-3">
                                <button class="my-auto btn btn-primary z-0 whitespace-nowrap "
                                    :disabled="employee_service.data_local_convergance == '' ? true : false"
                                    severity="success" style="height: 33px;" @click="employee_service.download_ajax"><i
                                        class="fas fa-file-download me-2"></i>Download</button>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-content-center mx-3">
                                <button v-if="employee_service.localconverganceScreen"
                                    @click="employee_service.onclickOpenLocalConverganceDailog"
                                    class="my-auto btn btn-orange whitespace-nowrap" style="height: 33px;width: 130px;">
                                    <i class="fa fa-plus-circle me-1"></i>Add Claim
                                </button>
                                <button v-if="employee_service.reimbursementsScreen"
                                    @click="employee_service.onclickOpenReimbursmentDailog"
                                    class="my-auto btn btn-orange whitespace-nowrap" style="height: 33px;width: 130px;">
                                    <i class="fa fa-plus-circle me-1"></i>Add Claim
                                </button>

                            </div>
                        </div>


                        <OverlayPanel ref="op">
                            <div class="py-1">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <a class="block px-4 py-2 text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100"
                                    role="menuitem" tabindex="-1" @click="employee_service.download_ajax"
                                    id="menu-item-0">Excel</a>
                                <a class="block px-4 py-2 text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100"
                                    role="menuitem" tabindex="-1" id="menu-item-1">Pdf</a>
                            </div>
                        </OverlayPanel>

                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane  show fade active " id="reimbursement" role="tabpanel" aria-labelledby="pills-profile-tab">
                <Reimbursements />
            </div>

            <!-- ----------------------------------------------------------------------------------------------------------------------------------------- -->

            <!-- Local conveyance -->
            <div class="tab-pane fade" id="localConveyance" role="tabpanel" aria-labelledby="pills-profile-tab">
                <LocalConveyance />
            </div>
        </div>

    </div>

    <!-- <Dialog header="Header" v-model:visible="employee_service.loading_spinner"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
        :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center" class="font-bold">Please wait...</h5>
        </template>
    </Dialog> -->
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { employee_reimbursment_service } from "./stores/EmployeeReimbursementsService";
import moment from 'moment'

import Reimbursements from "./reimbursements/Reimbursements.vue";
import LocalConveyance from "./localConveyance/LocalConveyance.vue";
import LoadingSpinner from "../../components/LoadingSpinner.vue";

const employee_service = employee_reimbursment_service();


onMounted(async () => {
    //    employee_service.fetch_data_from_reimbursment()

    employee_service.selected_date = new Date()

    await employee_service.generate_ajax();

    await employee_service.getModeOfTransport();

    await employee_service.getReimbursementClaimTypes();

});
</script>

