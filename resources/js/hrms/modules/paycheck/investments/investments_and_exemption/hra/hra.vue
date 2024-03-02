<template>
    <div class="mb-4 tw-card bg-gray-50">
        <!-- {{ investmentStore.sumOfTotalRentPaid }} -->
        <div class="table-responsive">
            <DataTable ref="dt" dataKey="fs_id" :paginator="true" :rows="10" :value="investmentStore.hraSource"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" v-model:editingRows="investmentStore.editingRowSource" editMode="row"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column header="Sections" field="section" style="min-width: 8rem">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 12rem">
                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 12rem">
                    <template #body="slotProps">
                        <!-- {{ slotProps.data }} -->
                        <div v-if="slotProps.data.json_popups_value" class="dec_amt">
                            {{ investmentStore.formatCurrency(investmentStore.sumOfTotalRentPaid) }}
                        </div>
                        <div v-else>
                            <button class="px-4 py-2 text-center text-white bg-black rounded-md me-4"
                             :disabled="!investmentStore.isSubmitted"
                                @click="investmentStore.dailogAddNewRental = true"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i>
                                Add Rented</button>
                        </div>

                    </template>
                    <template #editor="{ data, field }">
                        <InputNumber v-model="data[field]" mode="currency" currency="INR" locale="en-US"
                            class="w-5 text-lg font-semibold" />
                    </template>

                </Column>

                <Column field="status" header="Status" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.json_popups_value">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
            </DataTable>

        </div>
    </div>


    <div class="bg-gray-50 tw-card rounded-xl">
        <div class="flex justify-between mb-3">
            <span class="mx-4 my-2 mt-2 text-2xl font-semibold text-indigo-950">Rental Property</span>
                <button v-if="investmentStore.AddHraButtonDisabled"  :disabled="!investmentStore.isSubmitted" class="my-3 mr-4 btn btn-border-orange"
                @click="investmentStore.dailogAddNewRental = true"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>
                Add Rented</button>

        </div>

        <div class="mb-3 col-sm-12 col-md-12 col-xl-12 col-xxl-12 col-lg-12">
            <div class="mb-3 table-responsive">
                <!-- {{ investmentStore.hra_data }} -->
                <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10" :value="investmentStore.hra_data"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll">

                    <Column header="Landlord Name" field="json_popups_value.landlord_name" style="min-width: 8rem">
                    </Column>

                    <Column field="json_popups_value.landlord_PAN" header="Landlord PAN" style="min-width: 12rem">
                        <template #body="slotProps">
                           <p  style="font-weight: 501;" v-if="slotProps.data.json_popups_value.landlord_PAN"> {{ (slotProps.data.json_popups_value.landlord_PAN).toUpperCase() }}</p>
                           <p  style="font-weight: 501;" v-else>NA</p>
                        </template>
                    </Column>

                    <Column field="json_popups_value.from_month" header="From Month " style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ moment(slotProps.data.json_popups_value.from_month).format('DD-MM-YYYY') }}
                        </template>
                    </Column>

                    <Column field="json_popups_value.to_month" header="To Month" style="min-width: 12rem">
                        <template #body="slotProps">
                            {{ moment(slotProps.data.json_popups_value.to_month).format('DD-MM-YYYY') }}
                        </template>
                    </Column>

                    <Column field="json_popups_value.city" header="City" style="min-width: 12rem">
                    </Column>
                    <Column field="json_popups_value.total_rent_paid" header="Total Rent" style="min-width: 12rem">

                    </Column>
                    <Column field="" header="Action" style="min-width: 12rem" v-if="investmentStore.isSubmitted"  >
                        <template #body="slotProps">
                            <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                                @click="investmentStore.editHraNewRental(slotProps.data)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                            </button>
                            <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                                @click="investmentStore.deleteRentalDetails(slotProps.data)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </template>
                    </Column>
                </DataTable>

            </div>
        </div>

    </div>
    <div class="my-3 text-end">
        <button class="px-4 py-2 text-center text-white bg-black border-[2px] border-[#000] rounded-md me-4"
            @click="investmentStore.saveHRA">Save</button>
        <button @click="investmentStore.investment_exemption_steps++"
            class="px-4 py-2 text-center text-[#000] bg-transparent border-[2px] border-[#000] rounded-md">Next</button>
    </div>



    <Dialog v-model:visible="investmentStore.dailogAddNewRental" :modal="true" :closable="true"
        :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <span class="text-lg font-semibold modal-title text-indigo-950">Add New Rental</span>
        </template>
        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-2 sm:grid-cols-1 xl:grid-cols-2 lg:grid-cols-2">

            <div class="">
                <label for="rentFrom_month" class="block mb-2 font-medium text-gray-900">From
                    Month <span class="text-red-600">*</span> </label>
                <Calendar view="month" :minDate="new Date('04/01/2023')" :maxDate="new Date('03/31/2024')"
                    dateFormat="mm/yy" v-model="investmentStore.hra.from_month" class="w-full" showIcon required :class="[
                        v$.from_month.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.from_month.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.from_month.$errors[0].$message }}
                </span>
            </div>
            <div class="">
                <label for="toFrom_month" class="block mb-2 font-medium text-gray-900 ">To
                    Month <span class="text-red-600">*</span> </label>
                <Calendar view="month" :minDate="new Date('04/01/2023')" :maxDate="new Date('03/31/2024')"
                    dateFormat="mm/yy" v-model="investmentStore.hra.to_month" class="w-full" showIcon required :class="[
                        v$.to_month.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.to_month.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.to_month.required.$message.replace("Value", "To month") }}

                </span>
            </div>
            <div class="">
                <label for="metro_city" class="block mb-2 font-medium text-gray-900 ">City</label>
                <Dropdown editable class="w-full" v-model="investmentStore.hra.city"
                    :options="investmentStore.metrocitiesOption" optionLabel="name" optionValue="value"
                    placeholder="Select City" required :class="[
                        v$.city.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.city.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.city.required.$message.replace("Value", "City") }}
                </span>
            </div>
            <div class="">
                <label for="rendPaid_inp" class="block mb-2 font-medium text-gray-900 ">Total
                    Rent Paid</label>
                <InputNumber type="text" id="rendPaid_inp" class="w-full " v-model="investmentStore.hra.total_rent_paid"
                    required :class="[
                        v$.total_rent_paid.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.total_rent_paid.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.total_rent_paid.required.$message.replace("Value", "Total rent paid") }}
                </span>
            </div>

        </div>
        <div class="grid mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-2 sm:grid-cols-1 xl:grid-cols-2 lg:grid-cols-2">
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Landlord
                    Name <span class="text-red-600">*</span> </label>
                <input type="text" id="lender_name" @keypress="isLetter($event)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 capitalize"
                    v-model="investmentStore.hra.landlord_name" required :class="[
                        v$.landlord_name.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="v$.landlord_name.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.landlord_name.required.$message.replace("Value", "Landlord name") }}
                </span>
            </div>

            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Landlord
                    PAN </label>
                <!-- <input type="text" id="lender_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    v-model="investmentStore.hra.landlord_PAN" required> -->
                <InputMask id="serial" mask="aaaaa9999a" class="w-full " placeholder="AHFCS1234F"
                    style="text-transform: uppercase" v-model="investmentStore.hra.landlord_PAN" required :class="[
                        v$.landlord_PAN.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.landlord_PAN.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.landlord_PAN.$errors[0].$message }}
                </span>

            </div>

        </div>
        <div class="grid mb-6 md:grid-cols-1 2xl:grid-cols-1 sm:grid-cols-1 xl:grid-cols-1 lg:grid-cols-1">
            <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">
                Address <span class="text-red-600">*</span>  </label>
            <Textarea name="" id="" autoResize rows="5" cols="30"
                class="bg-gray-50 resize-none border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                v-model="investmentStore.hra.address" required :class="[
                    v$.address.$error ? 'border border-red-500' : '',
                ]" />
            <span v-if="v$.address.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.address.required.$message.replace("Value", "Address") }}
            </span>

        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" type="button"
                @click="submitForm">Save</button>
        </div>
    </Dialog>
    <!-- {{ new Date(moment(investmentStore.employeDoj).format('MM/DD/YYYY'))}} -->
</template>


<script setup>
import { onMounted, onUnmounted, computed, reactive } from "vue";
import { investmentMainStore } from "../../../stores/investmentMainStore";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

import { ref } from "vue";
import moment from "moment";
import { profilePagesStore } from "../../../../profile_pages/stores/ProfilePagesStore";

const investmentStore = investmentMainStore()
const useEmployeeDetails = profilePagesStore()
const employeDoj = ref(new Date(investmentStore.employeDoj))



const dojValidation = (value) => {
    console.log("Current Date"+value);
    // console.log("Employee DOJ"+employeDoj.value);
    console.log("Employee DOJ"+new Date(investmentStore.employeDoj));
    if (new Date(investmentStore.employeDoj) < value) {
        return true
    } else {
        return false
    }
}

const panValidation = (value) => {
    if (investmentStore.hra.total_rent_paid >= 100000  ) {
        if(value){
            return true
        }else{
            false
        }
    } else {
        return true
    }
}





const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

const rules = computed(() => {
    return {
        from_month: { required: helpers.withMessage('From month is required', required), dojValidation: helpers.withMessage('Must be greater than date of Joining!', dojValidation) },
        to_month: { required },
        city: { required },
        total_rent_paid: { required },
        landlord_name: { required },
        landlord_PAN: { required: helpers.withMessage('Rent Paid is 1 lakh and above landlord PAN is mandatory!', panValidation) },
        address: { required },
    }
})

const v$ = useValidate(rules, investmentStore.hra)

const submitForm = () => {
    console.log(panValidation);
    console.log(v$.value);
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.saveHraNewRental()
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


// onUnmounted(() => {
//     setTimeout(() => {
//         investmentStore.fetchPropertyType()
//             console.log("destroyed");
//     }, 3000);
// })





</script>


<style  lang="scss">
.p-datepicker .p-monthpicker {
    margin: 2px 85px 2px 104px;
}

.p-button.p-component.p-button-icon-only.p-datepicker-trigger {
    height: 100%;
}

.p-inputtext.p-component {
    border: 0.1px solid rgb(187, 187, 187);
    width: 100%;
}

span .p-calendar.p-component.p-inputwrapper.p-calendar-w-btn {
    margin-right: 25px !important;
}


.p-button .p-component .p-button-icon-only .p-datepicker-trigger>button {
    height: 100%;

}

.pi.pi-calendar.p-button-icon {
    margin-left: 15px;
}

.p-button.p-button-icon-only {
    width: 3rem;
    padding: 6px 0;
}

// .main-content {
//     width: 85%;
// }


#file_upload {
    display: inline-block;
    background-color: #003056;
    color: white;
    padding: 0.5rem;
    font-family: sans-serif;
    border-radius: 0.3rem;
    cursor: pointer;
    margin-top: 1rem;
    width: 100%;
    height: 40px;
    font-weight: 700;
    text-align: center;
}

.p-calendar .p-inputtext .p-inputwrapper .p-component {
    flex: 1 1 auto;
    width: 1%;
    background: rebeccapurple;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component::-webkit-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component:-ms-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component::-ms-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}



:-ms-input-placeholder {
    /* Internet Explorer 10-11 */
    color: red;
}

::-ms-input-placeholder {
    /* Microsoft Edge */
    color: red;
}



.p-button {
    height: 2.5em;
}

.p-button .p-fileupload-choose {
    height: 2.1em;
}

i,
span,
.tabview-custom {
    vertical-align: middle;
}

span {
    margin: 0 .5rem;
}

.AadharCardFront {
    margin-left: 20px;
}

.label {
    width: 170px;
}

.p-tabview p {
    line-height: 1.5;
    margin: 0;
}

.p-datepicker .p-datepicker-header {
    padding: 0.5rem;
    color: #061328;
    background: #002f56;
    font-weight: 600;
    margin: 0;
    border-bottom: 1px solid #dee2e6;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
}

.p-datepicker .p-datepicker-header .p-datepicker-title .p-datepicker-year,
.p-datepicker .p-datepicker-header .p-datepicker-title .p-datepicker-month {
    color: #fff;
    transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 600;
    padding: 0.5rem;
}

.p-datepicker:not(.p-datepicker-inline) .p-datepicker-header {
    background: #002f56;
    color: black;
}

.p-calendar-w-btn .p-datepicker-trigger {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    background: #002f56;
}
</style>


