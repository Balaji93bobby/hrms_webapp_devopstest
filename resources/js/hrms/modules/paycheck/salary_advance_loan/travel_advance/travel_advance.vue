<template>
    <div class="mr-4 card">
        <div class="px-5 row d-flex justify-content-start align-items-center card-body">
            <div class="flex justify-between gap-6 my-2">
                <div class=" fs-4">
                    <p class="text-xl font-medium">You are eligible for Travel Advance as per the
                        <span class="text-lg text-primary text-decoration-underline">Company's Loan Policy</span>
                    </p>
                </div>

                <div class="float-right ">
                    <button class="btn btn-border-orange">View Report</button>
                    <button class="mx-4 btn btn-orange" @click="openPosition('top')"><i class="mx-2 fa fa-plus" aria-hidden="true"></i>New
                        Request</button>
                </div>
            </div>

            <div class="my-6 widget-card">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5 lg:grid-cols-5">
                    <div class="p-3 text-center bg-red-100 border-l-4 rounded-lg tw-card border-l-red-400">
                        <p class="mb-2 font-bold text-ash-medium f-13">Total Advance Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                    <div class="p-2 text-center bg-green-100 border-l-4 rounded-lg tw-card border-l-green-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 "> Total Repaid Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>

                    <div class="p-2 text-center bg-blue-100 border-l-4 rounded-lg tw-card border-l-blue-400 ">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Balance Amount</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">Not Submited</h6>
                    </div>
                    <div class="p-2 text-center bg-orange-100 border-l-4 rounded-lg tw-card border-l-orange-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Pending Request</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                    <div class="p-2 text-center bg-yellow-100 border-l-4 rounded-lg tw-card border-l-yellow-400">
                        <p class="mb-2 font-bold text-ash-medium f-13 ">Completed Rquests</p>
                        <h6 class="mb-0 text-base font-semibold text-gray-500">-</h6>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10" :value="sample"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll">

                    <Column header="Request ID" field="section" style="min-width: 8rem">
                        <!-- <template #body="slotProps">
                        {{  slotProps.data.claim_type }}
                      </template> -->
                    </Column>

                    <Column field="particular" header="Advance Amount" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                        {{ "&#x20B9;" + slotProps.data.claim_amount }}
                      </template> -->
                    </Column>

                    <Column field="ref" header="Paid On " style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template> -->
                    </Column>

                    <Column field="max_limit" header="Expected Return" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{  slotProps.data.reimbursment_remarks }}
                        </template> -->
                    </Column>


                    <Column field="Status" header="Status" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{  slotProps.data.reimbursment_remarks }}
                        </template> -->
                    </Column>

                </DataTable>

            </div>

        </div>
    </div>
    <Dialog v-model:visible="useEmpStore.dialog_TravelAdvance" modal  :style="{ width: '50vw' }">
        <template #header>
            <div>
                <h1 style="border-left: 3px solid var( --orange);padding-left: 10px ;" class="fs-4">New Travel Advance Request</h1>
            </div>
        </template>
        <div class="flex pb-2 bg-gray-100 rounded-lg gap-7">

            <div class="w-5 p-4 mx-4">
                <span class="font-semibold">Required Amount</span>
                <input id="rentFrom_month" v-model="useEmpStore.ta.ra"
                class="my-2  border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                <p class="text-sm font-semibold text-gray-500">Max Eligible Amount : 20,000</p>
            </div>

        </div>

        <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
            <span class="font-semibold ">Repayment</span>
            <p class="my-2 fs-5 text-gray-600 text-md ">The deadline to submit the bills is on
                salary <strong class="fs-5 text-black">12/07/2023</strong>
            </p>
        </div>

        <div class="p-4 my-6 bg-gray-100 rounded-lg gap-6">
            <span class="font-semibold ">Reason</span>
            <Textarea  v-model="useEmpStore.ta.reason" class="my-3 capitalize form-control textbox" autoResize type="text" rows="3" />
        </div>

        <div class="float-right ">
          <button class="btn btn-border-orange " @click="useEmpStore.dialog_TravelAdvance = false">Cancel</button>
          <button  class="mx-4 btn btn-orange" @click="useEmpStore.saveTravelAdvance">Submit</button>
        </div>

        </Dialog>



        <Dialog header="Header" v-model:visible="useEmpStore.canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }"
        :modal="true" :closable="false" :closeOnEscape="false">
                <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
                </template>
                <template #footer>
                    <h5 style="text-align: center">Please wait...</h5>
                </template>
        </Dialog>



</template>
<script setup>
import { ref, reactive ,onMounted} from 'vue';
import {useEmpSalaryAdvanceStore} from '../../stores/employeeSalaryAdvanceLoanMainStore'

const useEmpStore = useEmpSalaryAdvanceStore()

onMounted(() => {
   useEmpStore.fetchTraveladvance();
})

const value = ref();
const options = ref(['Off', 'On']);


const position = ref('center');

const openPosition = (pos) => {
    position.value = pos;
    useEmpStore.dialog_TravelAdvance = true
}



</script>
<style>
:root {
    --orange: #FF4D00;
    --white: #fff;
    --navy: #002f56;
}

.orange_btn {
    background-color: var(--orange);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;
    color: var(--white);
}

.Enable_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 0 4px 4px 0;

}

.cancel_btn {
    border: 1px solid var(--navy);
    padding: 7px 30px;
    border-radius: 4px 0 0 4px;

}
</style>

