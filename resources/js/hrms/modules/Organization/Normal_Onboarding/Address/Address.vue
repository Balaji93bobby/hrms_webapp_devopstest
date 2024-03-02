<template>
    <div class="form-card">
        <div class="flex my-2 header-card-text">
            <h6  class="my-2 font-semibold text-lg"><i class="pi pi-home mx-1 font-semibold" style="font-size: 1rem"></i>Current Address
            </h6>
        </div>
        <div class="mt-1 row">
            <div class="mb-2 col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6">
                <div class="floating">
                    <label for="" class="float-label">Address 1<span class="text-danger">*</span></label>
                    <Textarea style="height: 100px" class="capitalize form-control textbox" type="text" rows="3"
                        current_address_line_1 :class="{
                            'p-invalid':
                                v$.current_address_line_1.$error,
                        }" v-model="service.employee_onboarding.current_address_line_1"
                        placeholder="Current Address" />

                    <span v-if="(v$.current_address_line_1.$error) ||
                        v$.current_address_line_1.$pending.$response
                        " class="p-error">
                        {{
                            v$.current_address_line_1.required.$message.replace(
                                "Value",
                                "Current Address 1"
                            )
                        }}</span>
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6">
                <div class="floating">
                    <label for="" class="float-label">Address 2<span class="text-danger">*</span></label>

                    <Textarea style="height: 100px" class="capitalize form-control textbox" type="text" rows="3"
                        current_address_line_2 :class="{
                            'p-invalid':
                                v$.current_address_line_2.$error,
                        }" v-model="service.employee_onboarding.current_address_line_2"
                        placeholder="Current Address" />

                    <span v-if="(v$.current_address_line_2.$error) ||
                        v$.current_address_line_2.$pending.$response
                        " class="p-error">
                        {{
                            v$.current_address_line_2.required.$message.replace(
                                "Value",
                                "Current Address 2"
                            )
                        }}</span>
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Country<span class="text-danger">*</span></label>
                    <Dropdown v-model="service.employee_onboarding.current_country" :class="{
                        'p-invalid': v$.current_country.$error,
                    }" :options="service.country" optionValue="id" optionLabel="country_name"
                        placeholder="Select Country Name" class="p-error" @keypress="isLetter($event)" />


                    <span v-if="(v$.current_country.$error) ||
                        v$.current_country.$pending.$response
                        " class="p-error">
                        {{
                            v$.current_country.required.$message.replace(
                                "Value",
                                "country"
                            )
                        }}</span>

                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">State<span class="text-danger">*</span></label>

                    <Dropdown v-model="service.employee_onboarding.current_state" :class="{
                        'p-invalid': v$.current_state.$error,
                    }" :options="service.state" optionValue="id" optionLabel="state_name"
                        placeholder="Select State Name" class="p-error" @keypress="isLetter($event)" />

                    <span v-if="(v$.current_state.$error) ||
                        v$.current_state.$pending.$response
                        " class="p-error">
                        {{
                            v$.current_state.required.$message.replace("Value", "State")
                        }}</span>
                </div>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">
                        City<span class="text-danger">*</span></label>

                    <InputText class="form-control" type="text" :class="{
                        'p-invalid': v$.current_city.$error,
                    }" v-model="service.employee_onboarding.current_city" placeholder="current city"
                        @keypress="isLetter($event)" />
                </div>
                <span v-if="(v$.current_city.$error) ||
                    v$.current_city.$pending.$response
                    " class="p-error">
                    {{
                        v$.current_city.required.$message.replace("Value", "City")
                    }}</span>
            </div>
            <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                <div class="floating">
                    <label for="" class="float-label">Pincode<span class="text-danger">*</span></label>

                    <InputMask class="form-control" mask="999999" :class="{
                        'p-invalid': v$.current_pincode.$error,
                    }" v-model="service.employee_onboarding.current_pincode" placeholder="Pincode"
                        @keypress="isNumber($event)" />
                    <span v-if="(v$.current_pincode.$error) ||
                        v$.current_pincode.$pending.$response
                        " class="p-error">
                        {{
                            v$.current_pincode.required.$message.replace(
                                "Value",
                                "Pincode"
                            )
                        }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="my-3 col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
                <Checkbox inputId="" @click="service.ForCopyAdrress" v-model="service.CopyAddresschecked" :binary="true" />
                <label style="margin-left: 10px" for="current_address_copy">Copy current address to the permanent
                    address</label>
            </div>

            <!-- Current Address End -->

            <!-- Permanent Address Start -->
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">
                <h6  class="my-2 font-semibold text-lg"><i class="pi pi-home mx-1 font-semibold" style="font-size: 1rem"></i>Permanent Address</h6>
                <div class="mt-1 row">
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6">
                        <div class="floating">
                            <label for="" class="float-label">Address 1<span class="text-danger">*</span></label>

                            <Textarea placeholder="Permanent Address" class="capitalize form-control textbox"
                                style="height: 100px" type="text" rows="3" id="permanent_address_line_1" :class="{
                                    'p-invalid':
                                        v$.permanent_address_line_1.$error,
                                }" v-model="service.employee_onboarding.permanent_address_line_1" />
                            <span v-if="(v$.permanent_address_line_1.$error) ||
                                v$.permanent_address_line_1.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_address_line_1.required.$message.replace(
                                        "Value",
                                        "Permanent Address 1"
                                    )
                                }}</span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6">
                        <div class="floating">
                            <label for="" class="float-label">Address 2<span class="text-danger">*</span></label>

                            <Textarea placeholder="Permanent Address" class="capitalize form-control textbox"
                                style="height: 100px" type="text" rows="3" id="permanent_address_line_2" :class="{
                                    'p-invalid':
                                        v$.permanent_address_line_2.$error,
                                }" v-model="service.employee_onboarding.permanent_address_line_2" />

                            <span v-if="(v$.permanent_address_line_2.$error) ||
                                v$.permanent_address_line_2.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_address_line_2.required.$message.replace(
                                        "Value",
                                        "Permanent Address 2"
                                    )
                                }}</span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Country<span class="text-danger">*</span></label>
                            <Dropdown optionValue="id" v-model="service.employee_onboarding.permanent_country" :class="{
                                'p-invalid': v$.permanent_country.$error,
                            }" :options="service.country" optionLabel="country_name"
                                placeholder="Select Country Name" class="p-error" @keypress="isLetter($event)" />

                            <span v-if="(v$.permanent_country.$error) ||
                                v$.permanent_country.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_country.required.$message.replace(
                                        "Value",
                                        "country"
                                    )
                                }}</span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">State<span class="text-danger">*</span></label>
                            <Dropdown optionValue="id" v-model="service.employee_onboarding.permanent_state" :class="{
                                'p-invalid': v$.permanent_state.$error,
                            }" :options="service.state" optionLabel="state_name"
                                placeholder="Select State Name" class="p-error" @keypress="isLetter($event)" />

                            <span v-if="(v$.permanent_state.$error) ||
                                v$.permanent_state.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_state.required.$message.replace(
                                        "Value",
                                        "State"
                                    )
                                }}</span>
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">
                                City<span class="text-danger">*</span></label>

                            <InputText class="capitalize onboard-form form-control textbox" type="text" :class="{
                                'p-invalid': v$.permanent_city.$error,
                            }" v-model="service.employee_onboarding.permanent_city" placeholder="City"
                                @keypress="isLetter($event)" />

                            <span v-if="(v$.permanent_city.$error) ||
                                v$.permanent_city.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_city.required.$message.replace(
                                        "Value",
                                        "City"
                                    )
                                }}</span>
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Pincode<span class="text-danger">*</span></label>

                            <InputMask class="capitalize onboard-form form-control textbox" mask="999999" :class="{
                                'p-invalid': v$.permanent_pincode.$error,
                            }" v-model="service.employee_onboarding.permanent_pincode" placeholder="Pincode"
                                @keypress="isNumber($event)" />
                            <span v-if="(v$.permanent_pincode.$error) ||
                                v$.permanent_pincode.$pending.$response
                                " class="p-error">
                                {{
                                    v$.permanent_pincode.required.$message.replace(
                                        "Value",
                                        "Pincode"
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


</script>
