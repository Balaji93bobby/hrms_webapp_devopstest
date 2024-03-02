<template>
    <div class="card">
        <DataTable ref="dt" :value="employee_service.data_local_convergance" dataKey="id" :paginator="true" :rows="10"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">


            <Column field="date" header="Date" style="min-width: 8rem" dataType="date" sortable>
                <template #body="slotProps">
                    {{ moment(slotProps.data.date).format('DD-MMM-YYYY') }}
                </template>
            </Column>
            <Column header="Mode Of Transport" style="min-width: 12rem">
                <template #body="slotProps">
                    {{ slotProps.data.vehicle_type }}
                </template>
            </Column>

            <Column field="from" header="From " style="min-width: 8rem">
                <template #body="slotProps">
                    {{ slotProps.data.from }}
                </template>
            </Column>
            <Column field="to" header="To" style="min-width: 8rem">
                <template #body="slotProps">
                    {{ slotProps.data.to }}
                </template>
            </Column>
            <Column field="distance_travelled" header="Total Distance" style="min-width: 4rem">
                <template #body="slotProps">
                    {{ slotProps.data.distance_travelled }}
                </template>
            </Column>
            <Column field="Amt_km" header="Amt/Km" style="min-width:4rem">
                <template #body="slotProps">
                    {{ slotProps.data.cost_per_km }}
                </template>
            </Column>

            <Column field="total_expenses" header="Amount" style="min-width: 6rem">
                <template #body="slotProps">
                    {{ slotProps.data.total_expenses }}
                </template>
            </Column>
            <Column field="user_comments" header="Remarks" style="min-width: 12rem">
                <template #body="slotProps">
                    {{ slotProps.data.user_comments }}
                </template>
            </Column>
            <Column field="user_comments" header="Entry Mode" style="min-width: 12rem text-transform: capitalize">
                <template #body="slotProps">
                    {{ slotProps.data.entry_mode }}
                </template>
            </Column>
        </DataTable>
    </div>

    <Dialog v-model:visible="employee_service.localconvergance_dailog" :style="{ width: '450px' }" header="Local Conveyance"
        :modal="true" class="p-fluid">

        <div class="field">
            <label for="name">Date <span class="text-danger">*</span></label>
            <Calendar inputId="dateformat" v-model="employee_service.employee_local_conveyance.travelled_date"
                :maxDate="new Date()" dateFormat="dd/mm/yy" :class="[
                    v$.travelled_date.$error ? 'p-invalid' : '',
                ]" />
            <span v-if="v$.travelled_date.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.travelled_date.$errors[0].$message }}
            </span>

        </div>

        <div class="field col">
            <label for="Claim Amount">Mode of transport <span class="text-danger">*</span> </label>
            <Dropdown v-model="employee_service.employee_local_conveyance.mode_of_transport"
                :options="employee_service.local_Conveyance_Mode_of_transport" optionLabel="label" optionValue="value"
                placeholder="Select Mode Of Transport" class="w-full"
                @change="employee_service.amountperKm(employee_service.employee_local_conveyance.mode_of_transport)" :class="[
                    v$.mode_of_transport.$error ? 'p-invalid' : '',
                ]" />
            <span v-if="v$.mode_of_transport.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.mode_of_transport.$errors[0].$message }}
            </span>
        </div>

        <div class="flex formgrid">
            <div class="field col">
                <label for="Eligible Amount">From <span class="text-danger">*</span> </label>
                <InputText @keypress="isLetter($event)" v-model="employee_service.employee_local_conveyance.travel_from"
                    :class="[
                        v$.travel_from.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.travel_from.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.travel_from.$errors[0].$message }}
                </span>
            </div>
            <div class="field col">
                <label for="Claim Amount">To <span class="text-danger">*</span> </label>
                <InputText @keypress="isLetter($event)" v-model="employee_service.employee_local_conveyance.travel_to"
                    :class="[
                        v$.travel_to.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.travel_to.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.travel_to.$errors[0].$message }}
                </span>
            </div>
        </div>
        <div class="flex formgrid">
            <div class="field col">
                <label for="Eligible Amount">Total Distance <span class="text-danger">*</span> </label>
                <InputText v-model="employee_service.employee_local_conveyance.total_distance_travelled"
                    @keypress="isNumber($event)" @input="employee_service.amount_calculation()" :class="[
                        v$.total_distance_travelled.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.total_distance_travelled.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.total_distance_travelled.$errors[0].$message }}
                </span>
            </div>
            <div class="field col"
                v-if="employee_service.employee_local_conveyance.mode_of_transport == 'Public Transport'">
                <label for="Eligible Amount">Actual Amount <span class="text-danger">*</span> </label>
                <InputText :readonly="employee_service.employee_local_conveyance.mode_of_transport ==
                    'Public Transport'
                    ? false
                    : true" v-model="employee_service.employee_local_conveyance.local_convenyance_total_amount
        " />
            </div>
            <div class="field col" v-else>
                <label for="Eligible Amount">Amt/Km <span class="text-danger">*</span></label>
                <InputText :readonly="employee_service.employee_local_conveyance.mode_of_transport ==
                    'Public Transport'
                    ? false
                    : true" v-model="employee_service.employee_local_conveyance.Amt_km
        " :class="[
        v$.Amt_km.$error ? 'p-invalid' : '',
    ]" />
                <span v-if="v$.Amt_km.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.Amt_km.$errors[0].$message }}
                </span>
            </div>
        </div>

        <div class="field col" :hidden="employee_service.employee_local_conveyance.mode_of_transport ==
            'Public Transport'
            ? true
            : false
            ">
            <label for="Eligible Amount">Amount <span class="text-danger">*</span> </label>
            <InputText @input="employee_service.amountperKm" v-model="employee_service.employee_local_conveyance
                .local_convenyance_total_amount
                " :class="[
        v$.local_convenyance_total_amount.$error ? 'p-invalid' : '',
    ]" :readonly="employee_service.employee_local_conveyance.mode_of_transport ==
    'Public Transport'
    ? false
    : true" />
            <span v-if="v$.local_convenyance_total_amount.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.local_convenyance_total_amount.$errors[0].$message }}
            </span>
        </div>
        <div class="field col">
            <label for="Eligible Amount">Remarks</label>
            <Textarea v-model="employee_service.employee_local_conveyance.local_conveyance_remarks
                " autoResize rows="2" cols="30" :class="[
        v$.local_conveyance_remarks.$error ? 'p-invalid' : '',
    ]" />
            <span v-if="v$.local_conveyance_remarks.$error" class="font-semibold text-red-400 fs-6">
                {{ v$.local_conveyance_remarks.$errors[0].$message }}
            </span>
        </div>

        <template #footer>
            <Button label="Cancel" icon="pi pi-times" style="height: 30px; color: black" class="p-button-text"
                @click="employee_service.hideDialog" />
            <Button label="Save" icon="pi pi-check" style="height: 30px; background: rgb(255 135 38); color: white"
                @click="submitForm()" />
        </template>
    </Dialog>
</template>


<script setup>

import { employee_reimbursment_service } from '../stores/EmployeeReimbursementsService'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import moment from 'moment';
import { computed } from 'vue';



const employee_service = employee_reimbursment_service();


const rules = computed(() => {
    return {
        travelled_date: { required: helpers.withMessage('Travelled date is required', required) },
        mode_of_transport: { required: helpers.withMessage('Mode of transport is required', required) },
        travel_from: {
            required: helpers.withMessage(' from is required', required),
            minLength: minLength(2)
        },
        travel_to: {
            required: helpers.withMessage(' to is required', required),
            minLength: minLength(2)
        },
        total_distance_travelled: { required: helpers.withMessage('Total travelled distance is required', required) },
        Amt_km: {},
        local_convenyance_total_amount: { required },
        local_conveyance_remarks: { required: helpers.withMessage('Remarks is required', required) },
    }
})


const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

const isNumber = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[0-9]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}


const v$ = useValidate(rules, employee_service.employee_local_conveyance)

const submitForm = () => {
    console.log(v$.value);
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        employee_service.post_data_for_local_convergance()
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


</script>
