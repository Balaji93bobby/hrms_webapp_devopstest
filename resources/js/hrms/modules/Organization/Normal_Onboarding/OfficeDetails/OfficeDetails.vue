<template>
    <div class="p-2 ">
        <div class=" justify-content-center align-items-center">
            <div class="flex header-card-text">
                <h6 class="my-2 font-semibold text-lg"><i class="fa fa-briefcase" aria-hidden="true"></i> Official Details
                </h6>
            </div>


            <div class="form-card">
                <div class="mt-1 row">
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="floating">
                            <label for="" class="float-label">Department</label>
                            <Dropdown v-model="service.employee_onboarding.department" :class="{
                                'p-invalid': v$.department.$error,
                            }" :options="service.departmentDetails" optionLabel="name" optionValue="id"
                                placeholder="Department" name="department" id="department" class="p-error" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="floating">
                            <label for="" class="float-label">Process
                                <!-- <span class="text-danger">*</span> -->
                            </label>
                            <InputText class="onboard-form form-control" @keypress="isLetter($event)" type="text" :class="{
                                'p-invalid': v$.process.$error,
                            }" v-model="service.employee_onboarding.process" placeholder="Process" />

                            <span v-if="(v$.process.$error) ||
                                v$.process.$pending.$response
                                " class="p-error">
                                {{
                                    v$.process.required.$message.replace("Value", "Process")
                                }}</span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="floating">
                            <label for="" class="float-label">Designation<span class="text-danger">*</span>
                            </label>

                            <InputText @keypress="isLetter($event)" class="onboard-form form-control" type="text"
                                :readonly="readonly.designation" placeholder="Designation" :class="[{
                                    'p-invalid': v$.designation.$error,
                                }, readonly.designation ? 'bg-gray-200' : '']"
                                v-model="service.employee_onboarding.designation" />

                            <span v-if="(v$.designation.$error) ||
                                v$.designation.$pending.$response
                                " class="p-error">
                                {{
                                    v$.designation.required.$message.replace(
                                        "Value",
                                        "Designation"
                                    )
                                }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Cost Center</label>

                            <InputText type="number" placeholder="Cost Center"
                                v-model="service.employee_onboarding.cost_center" name="cost_center"
                                class="onboard-form form-control textbox" />
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Work Location<span class="text-danger">*</span></label>
                            <InputText @keypress="isLetter($event)" class="onboard-form form-control" type="text"
                                placeholder="Work Location" :class="{
                                    'p-invalid': v$.work_location.$error,
                                }" v-model="service.employee_onboarding.work_location" />
                            <span v-if="(v$.work_location.$error) ||
                                v$.work_location.$pending.$response
                                " class="p-error">
                                {{
                                    v$.work_location.required.$message.replace(
                                        "Value",
                                        "Work Location"
                                    )
                                }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="floating">
                            <label for="" class="float-label">Reporting Manager Name<span
                                    class="text-danger">*</span></label>
                            <!-- {{employee_onboarding.l1_manager_code.user_code}} -->
                            <Dropdown :readonly="service.readonly.l1_code" :options="service.Managerdetails"
                                optionLabel="name" placeholder="Reporting Manager Name"
                                v-model="service.employee_onboarding.l1_manager_code" class="p-error" :class="{
                                    'p-invalid':
                                        v$.l1_manager_code.$error,
                                }">

                                <template #value="slotProps">
                                    <div v-if="slotProps.value" class="flex align-items-center">
                                        <div>
                                            {{ slotProps.value.user_code }} -
                                            {{ slotProps.value.name }}
                                        </div>
                                    </div>
                                    <span v-else>
                                        {{ slotProps.placeholder }}
                                    </span>
                                </template>
                                <template #option="slotProps">
                                    <div class="flex align-items-center">
                                        <div>
                                            {{ slotProps.option.user_code }} -
                                            {{ slotProps.option.name }}
                                        </div>
                                        <div></div>
                                    </div>
                                </template>
                            </Dropdown>

                            <span v-if="(v$.l1_manager_code.$error) ||
                                v$.l1_manager_code.$pending.$response
                                " class="p-error">
                                {{
                                    v$.l1_manager_code.required.$message.replace(
                                        "Value",
                                        "Reporting Manager Code"
                                    )
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Official Email </label>
                            <InputText type="email" placeholder="Official E-Mail Id" name="officical_mail"
                                @keypress="isEmail($event)" class="textbox form-control"
                                v-model="service.employee_onboarding.officical_mail" />
                            <span v-if="v$.officical_mail.$error" class="font-medium text-red-600 fs-6">
                                {{ v$.officical_mail.$errors[0].$message }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Official Mobile</label>

                            <InputMask id="serial" mask="9999999999" v-model="service.employee_onboarding.official_mobile"
                                placeholder="Mobile Number" style="text-transform: uppercase" class="form-control textbox"
                                :class="{
                                    'p-invalid': v$.official_mobile.$error,
                                }" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Date of confirmation<span class="text-danger">*</span></label>
                            <InputText class="onboard-form form-control" type="text" placeholder="Date of confirmation"
                                max="9999-12-31" :class="{
                                    'p-invalid': v$.confirmation_period.$error,
                                }" v-model="service.employee_onboarding.confirmation_period"
                                onfocus="(this.type='date')" />

                            <span v-if="(v$.confirmation_period.$error) ||
                                v$.confirmation_period.$pending.$response
                                " class="p-error">
                                {{
                                    v$.confirmation_period.required.$message.replace(
                                        "Value",
                                        "Date Of Confirmation"
                                    )
                                }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>

import { useNormalOnboardingMainStore } from '../stores/NormalOnboardingMainStore'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { reactive } from 'vue';

const service = useNormalOnboardingMainStore()


const v$ = useValidate(service.rules, service.employee_onboarding);



const readonly = reactive({
    statutory: false,
    child: false,
    fdc: false,
    lta: false,
    other: false,
    l1_code: false,
    designation: false,
    mobile: false,
    spouse: false

})

const isEmail = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z0-9@.]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}


const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}


</script>
