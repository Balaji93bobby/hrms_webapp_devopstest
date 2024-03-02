<template>
    <div class="form-card my-2">
        <div class="flex my-2 header-card-text">
            <h6 class="my-2 font-semibold text-lg">Family Details
            </h6>
        </div>

        <div class="mt-1 row">
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Father Name<span class="text-danger">*</span></label>

                    <InputText class="capitalize nboard-form form-control textbox" @keypress="isLetter($event)" type="text"
                        placeholder="Father Name" name="father_name" id="father_name" :class="{
                            'p-invalid': v$.father_name.$error,
                        }" v-model="service.employee_onboarding.father_name" />
                    <span v-if="(v$.father_name.$error) ||
                        v$.father_name.$pending.$response
                        " class="p-error">
                        {{
                            v$.father_name.required.$message.replace(
                                "Value",
                                "Father Name"
                            )
                        }}
                    </span>
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Date of Birth <span class="text-danger">*</span></label>

                    <Calendar inputId="icon" :maxDate="service.beforeYears(new Date(service.employee_onboarding.dob))"
                        showIcon v-model="service.employee_onboarding.dob_father" editable dateFormat="dd-mm-yy"
                        placeholder="Date of birth" style="width: 350px;" :class="{
                            'p-invalid': v$.dob_father.$error,
                        }" @date-select="service.fnCalculateAge" />

                    <span v-if="(v$.dob_father.$error) ||
                        v$.dob_father.$pending.$response
                        " class="p-error">
                        {{
                            v$.dob_father.required.$message.replace(
                                "Value",
                                "Father Date of Birth"
                            )
                        }}
                    </span>
                </div>
            </div>

            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Gender</label>
                    <InputText :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']" type="text"
                        class="form-control" name="father_gender" id="father_gender" value="Male" readonly />
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Age </label>

                    <InputText type="number" placeholder="Age" name="father_age"
                        v-model="service.employee_onboarding.father_age" id="father_age"
                        class="textbox onboard-form form-control" minlength="2" maxlength="3" readonly />
                </div>
            </div>

            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Mother Name <span class="text-danger">*</span></label>

                    <InputText class="capitalize onboard-form form-control textbox" type="text" placeholder="Mother Name"
                        @keypress="isLetter($event)" name="mother_name" :class="{
                            'p-invalid': v$.mother_name.$error,
                        }" v-model="service.employee_onboarding.mother_name" />

                    <span v-if="(v$.mother_name.$error) ||
                        v$.mother_name.$pending.$response
                        " class="p-error">
                        {{
                            v$.mother_name.required.$message.replace(
                                "Value",
                                "Mother Name"
                            )
                        }}
                    </span>
                </div>
            </div>

            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Date of Birth <span class="text-danger">*</span></label>

                    <Calendar inputId="icon" :maxDate="service.beforeYears(new Date(service.employee_onboarding.dob))"
                        showIcon v-model="service.employee_onboarding.dob_mother" editable dateFormat="dd-mm-yy"
                        placeholder="Date of birth" style="width: 350px;" :class="{
                            'p-invalid': v$.dob_mother.$error,
                        }" @date-select="service.fnCalculateAge" />

                    <span v-if="(v$.dob_mother.$error) ||
                        v$.dob_mother.$pending.$response
                        " class="p-error">
                        {{
                            v$.dob_mother.required.$message.replace(
                                "Value",
                                "Mother Date of Birth"
                            )
                        }}
                    </span>
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Gender</label>

                    <InputText :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']" type="text"
                        class="form-control" name="mother_gender" id="" value="Female" readonly />
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Age</label>

                    <InputText type="number" placeholder="Age" name="mother_age"
                        v-model="service.employee_onboarding.mother_age" id="mother_age"
                        class="textbox onboard-form form-control" minlength="2" maxlength="3" readonly />
                </div>
            </div>

            <div v-if="service.isSpouseDisable" class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Spouse Name <span class="text-danger">*</span></label>
                    <InputText @keypress="isLetter($event)" class="capitalize onboard-form form-control textbox" type="text"
                        placeholder="Spouse Name" name="spouse_name" :class="{
                            'p-invalid': v$.spouse_name.$error,
                        }" v-model="service.employee_onboarding.spouse_name" />

                    <span v-if="v$.spouse_name.$error" class="font-medium text-red-400 fs-6">
                        {{ v$.spouse_name.$errors[0].$message }}
                    </span>
                </div>
            </div>


            <div v-if="service.isSpouseDisable" class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Spouse DOB <span class="text-danger">*</span></label>
                    <Calendar inputId="icon" showIcon v-model="service.employee_onboarding.dob_spouse" editable
                        dateFormat="dd-mm-yy" placeholder="Date of birth" style="width: 350px;" :class="{
                            'p-invalid': v$.dob_spouse.$error,
                        }" @date-select="service.fnCalculateAge" />

                    <span v-if="v$.dob_spouse.$error" class="font-medium text-red-400 fs-6">
                        {{ v$.dob_spouse.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div v-if="service.isSpouseDisable" class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Gender <span class="text-danger">*</span></label>

                    <InputText v-if="service.readonly.spouse" class="onboard-form form-control textbox" type="text" readonly
                        placeholder="Select Spouse Gender" name="spouse_gender" :class="[{
                            'is-invalid': v$.spouse_gender.$error,
                        }, service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                        v-model="service.employee_onboarding.spouse_gender" />


                    <Dropdown v-else v-model="service.employee_onboarding.spouse_gender" :options="Gender"
                        optionLabel="name" optionValue="value" placeholder="Select Gender" class="p-error" :class="[{
                            'is-invalid': v$.spouse_gender.$error,
                        }, service.readonly.spouse ? 'bg-gray-200' : '']" :readonly="true" />

                    <span v-if="v$.spouse_gender.$error" class="font-medium text-red-400 fs-6">
                        {{ v$.spouse_gender.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div v-if="service.isSpouseDisable" class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Number of Children</label>

                    <select placeholder="Number of Children" name="no_of_children" id="no_of_children"
                        v-model="service.employee_onboarding.no_of_children"
                        class="textbox onboard-form form-control spouse_data select2_form_without_search">
                        <option value="" hidden selected disabled>
                            Select Number of Children
                        </option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <div v-if="service.isSpouseDisable" class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Date of Wedding</label>

                    <Calendar inputId="icon" showIcon v-model="service.employee_onboarding.wedding_date" editable
                        dateFormat="dd-mm-yy" placeholder="Date of Wedding" style="width: 350px;"
                        @date-select="fnCalculateAge" />

                    <!-- <span v-if="(v$.wedding_date.$error) ||
                                v$.wedding_date.$pending.$response
                                " class="p-error">
                                {{
                                    v$.wedding_date.required.$message.replace(
                                        "Value",
                                        "Date Of Wedding"
                                    )
                                }}
                            </span> -->
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

const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}



</script>
