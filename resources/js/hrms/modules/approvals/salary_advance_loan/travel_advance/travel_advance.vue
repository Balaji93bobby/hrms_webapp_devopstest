<template>
    <div class="mr-4 card">
        <div class="px-5 row d-flex justify-content-start align-items-center card-body">
            <div class="flex justify-between gap-6 my-2">
                <div class=" fs-4">
                    <p class="text-xl font-medium">Four Team Members are eligible for Travel Advance as per the
                        <span class="text-lg text-primary text-decoration-underline">Company's Loan Policy</span>
                    </p>
                </div>

                <div class="float-right ">
                    <button class="btn btn-border-orange">View Report</button>
                    <button class="mx-4 btn btn-orange" @click="openPosition('top')">
                        Approval All
                    </button>
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

            <h1 class="text-blue-700 mb-2 fs-5 fw-semibold">Pending Approval</h1>

            <div class="table-responsive mb-5">
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

                    <Column field="particular" header="Employee ID" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                        {{ "&#x20B9;" + slotProps.data.claim_amount }}
                      </template> -->
                    </Column>

                    <Column field="ref" header="Employee Name" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template> -->
                    </Column>

                    <Column field="max_limit" header="Advance Amount" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{  slotProps.data.reimbursment_remarks }}
                        </template> -->
                    </Column>


                    <Column field="Status" header="Bill Sub Deadline" style="min-width: 12rem">
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

            <h1 class="text-blue-700 mb-2 fs-5 fw-semibold mt-1" >Bills Submitted</h1>

            <div class="table-responsive mt-2">

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

                    <Column field="particular" header="Employee ID" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                        {{ "&#x20B9;" + slotProps.data.claim_amount }}
                      </template> -->
                    </Column>

                    <Column field="ref" header="Employee Name" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{ "&#x20B9;" + slotProps.data.eligible_amount }}
                        </template> -->
                    </Column>

                    <Column field="max_limit" header="Advance Amount" style="min-width: 12rem">
                        <!-- <template #body="slotProps">
                          {{  slotProps.data.reimbursment_remarks }}
                        </template> -->
                    </Column>


                    <Column field="Status" header="Bill Sub Deadline" style="min-width: 12rem">
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
    <Dialog v-model:visible="dialog_TravelAdvance" modal  :style="{ width: '50vw' }">
        <template #header>
            <div>
                <h1 style="border-left: 3px solid var( --orange);padding-left: 10px ;" class="fs-4">New Travel Advance Request</h1>
            </div>
        </template>
        <div class="flex pb-2 bg-gray-100 rounded-lg gap-7">

            <div class="w-5 p-4 mx-4">
                <span class="font-semibold">Required Amount</span>
                <input id="rentFrom_month"
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
            <Textarea  class="my-3 capitalize form-control textbox" autoResize type="text" rows="3" />
        </div>

        <div class="float-right ">
          <button class="btn btn-border-orange " >Cancel</button>
          <button  class="mx-4 btn btn-orange">Submit</button>
        </div>

        </Dialog>



        <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }"
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

// const useEmpStore = useEmpSalaryAdvanceStore();

onMounted(() => {
//    useEmpStore.fetchTraveladvance();
})

const value = ref();
const options = ref(['Off', 'On']);


const position = ref('center');

const openPosition = (pos) => {
    position.value = pos;
    useEmpStore.dialog_TravelAdvance = true
}
</script>
