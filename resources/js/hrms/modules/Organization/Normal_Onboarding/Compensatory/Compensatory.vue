<template>
    <div class="p-2 my-6 ">
        <div class=" justify-content-center align-items-center">
            <div class="flex header-card-text">
                <!-- <img src="../../../assests/images/wages.png" class="w-1 h-14" alt=""> -->
                <h6 class="my-2 font-semibold text-lg"><i class="fa fa-money" aria-hidden="true"></i> Compensatory</h6>
            </div>



            <div class="form-card">
                <div class="row">
                    <div class="mb-3 row">
                        <!-- <div class="my-5 mb-3 col-md-12 col-sm-12 col-lg-6 col-xl-6 col-xxl-6 mb-md-0">

                  <div class="mt-2 form-check form-check-inline">
                    <label class="form-check-label leave_type ms-2" for="compensation_monthly">Compensation
                      Monthly</label>

                  </div>
                  <div class="ml-2 form-check form-check-inline">
                    <input type="number" placeholder="Cost of Company" name="cic" v-model="employee_onboarding.cic"
                    id="cic" @input="compensatory_calculation" class="onboard-form form-control textbox "
                    step="0.01" required />
                  </div>


                </div>
                <div class="mb-3 col-md-12 col-sm-12 col-lg-5 col-xl-5 col-xxl-5 mb-md-0">
                  <div class="form-check form-check-inline" v-if="mon">

                    <Dropdown :options="compensation_month" optionLabel="name" optionValue="id"
                      style="height: 2.9em;" placeholder="Select Monthly" />
                  </div>
                  <div class="form-check form-check-inline" v-if="year">

                    <Dropdown :options="compensation_yearly" optionLabel="name" optionValue="id"
                      style="height: 2.9em;" placeholder="Select Yearly" />
                  </div>

                  <div class="form-check form-check-inline" >

                    <label for="" class="float-label">Cost To Company</label>
                    <input type="number" placeholder="Cost To Company" name="basic"
                      v-model="employee_onboarding.basic" style="height: 2.9em;"
                      class="textbox onboard-form form-control calculation_data gross_data" step="0.01" />

                  </div>




                </div>-->

                        <div class="my-2 mb-3 col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12 mb-md-0">
                            <div class="mt-2 form-check form-check-inline" v-if="service.compen_disable">
                                <label class="-ml-4 font-bold form-check-label leave_type" for="compensation_monthly">
                                    Enter Monthly Gross</label>
                            </div>
                            <div class=" form-check form-check-inline" v-if="service.compen_disable">
                                <InputText type="number" placeholder="Enter Monthly Gross" name="cic"
                                    @keypress="isNumber($event)" v-model="service.employee_onboarding.cic" id="cic"
                                    @input="service.compensatory_calculation" class=" onboard-form form-control textbox"
                                    step="0.01" :class="[{
                                        'p-invalid': v$.cic.$error,
                                    }]" />

                            </div>

                            <div class="-ml-3 form-check form-check-inline">
                                <p>
                                    <strong class="font-bold">Monthly CTC</strong> (Cost to Company) :
                                    <strong v-if="service.employee_onboarding.total_ctc < 0">0</strong>
                                    <strong v-else-if="service.employee_onboarding.total_ctc > 0">{{
                                        Math.floor(service.employee_onboarding.total_ctc)
                                    }}</strong>
                                    <strong v-else>0</strong>
                                </p>
                            </div>
                        </div>
                        <span v-if="v$.cic.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.cic.$errors[0].$message }}
                        </span>

                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Basic Salary</label>
                            <InputText type="number" placeholder="Basic Salary" name="basic" @keypress="isNumber($event)"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                v-model="service.employee_onboarding.basic"
                                class="textbox onboard-form form-control calculation_data gross_data" step="0.01"
                                readonly />
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">HRA</label>

                            <InputText type="number" placeholder="HRA" name="hra" v-model="service.employee_onboarding.hra"
                                @keypress="isNumber($event)"
                                class="onboard-form form-control textbox calculation_data gross_data" step="0.01"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']" readonly />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Statutory Bonus</label>
                            <InputText :readonly="service.readonly.statutory" type="number" placeholder="Statutory Bonus"
                                @keypress="isNumber($event)" name="statutory_bonus"
                                v-model="service.employee_onboarding.statutory_bonus" @input="service.statutory_bonus"
                                class="onboard-form form-control textbox calculation_data gross_data" step="0.01"
                                :class="[service.readonly.statutory ? 'bg-gray-200' : '']" />
                            <!-- {{employee_onboarding.statutory_bonus}} -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Child Education Allowance</label>
                            <InputText :readonly="service.readonly.child" type="number"
                                placeholder="Child Education Allowance" @keypress="isNumber($event)"
                                name="child_education_allowance"
                                v-model="service.employee_onboarding.child_education_allowance"
                                class="onboard-form form-control textbox calculation_data gross_data" step="0.01"
                                :class="[service.readonly.child ? 'bg-gray-200' : '']" @input="service.child_allowance" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Food Coupon</label>
                            <InputText :readonly="service.readonly.fdc" type="number"
                                :class="[service.readonly.fdc ? 'bg-gray-200' : '']" placeholder="Food Coupon"
                                name="food_coupon" @keypress="isNumber($event)"
                                v-model="service.employee_onboarding.food_coupon" @input="service.food_coupon"
                                class="onboard-form form-control textbox calculation_data gross_data" step="0.01" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">LTA</label>
                            <InputText :readonly="service.readonly.lta" type="number"
                                :class="[service.readonly.lta ? 'bg-gray-200' : '']" placeholder="LTA" name="lta"
                                v-model="service.employee_onboarding.lta" @keypress="isNumber($event)"
                                class="textbox onboard-form form-control calculation_data gross_data" step="0.01"
                                @input="service.lta" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Special Allowance</label>
                            <InputText :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                type="number" placeholder="Special Allowance" name="special_allowance"
                                @keypress="isNumber($event)" v-model="service.employee_onboarding.special_allowance"
                                class="onboard-form form-control textbox calculation_data gross_data" step="0.01"
                                readonly />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Other Allowance</label>

                            <InputText :readonly="service.readonly.other" type="number"
                                :class="[service.readonly.other ? 'bg-gray-200' : '']" placeholder="Other Allowance"
                                name="other_allowance" @keypress="isNumber($event)"
                                v-model="service.employee_onboarding.other_allowance"
                                class="textbox onboard-form form-control calculation_data gross_data" step="0.01"
                                @input="service.other_allowance" />
                        </div>
                    </div>
                    <!-- <button @click="special_allowance_cal">tets</button> -->
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Gross Salary</label>

                            <InputText type="number"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                placeholder="Gross Salary" name="gross" v-model="service.employee_onboarding.gross"
                                class="textbox onboard-form form-control" step="0.01" readonly
                                @keypress="isNumber($event)" />
                            <!-- {{employee_onboarding.gross}} -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">EPF employer contribution</label>

                            <InputText type="number"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                placeholder="EPF employer contribution" name="epf_employer_contribution"
                                v-model="service.employee_onboarding.epf_employer_contribution" @keypress="isNumber($event)"
                                class="textbox onboard-form form-control calculation_data cic_data" step="0.01" readonly />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">ESIC employer contribution</label>
                            <InputText type="number"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                placeholder="ESIC employer contribution" name="esic_employer_contribution"
                                v-model="service.employee_onboarding.esic_employer_contribution"
                                @keypress="isNumber($event)"
                                class="onboard-form form-control textbox calculation_data cic_data" step="0.01" readonly />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Insurance</label>
                            <InputText type="number" placeholder="Insurance" name="insurance"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : '']"
                                @keypress="isNumber($event)" v-model="service.employee_onboarding.insurance"
                                @input="service.insurance"
                                class="onboard-form form-control textbox calculation_data cic_data" step="0.01" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Graduity</label>
                            <InputText type="number" placeholder="Graduity" name="graduity"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : '']"
                                @keypress="isNumber($event)" v-model="service.employee_onboarding.graduity"
                                @input="service.graduity"
                                class="onboard-form form-control textbox calculation_data cic_data" step="0.01" />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">EPF Employee</label>

                            <InputText type="number"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                placeholder="EPF Employee" name="epf_employee" @keypress="isNumber($event)"
                                v-model="service.employee_onboarding.epf_employee"
                                class="onboard-form form-control calculation_data net_data textbox" step="0.01" readonly />
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">ESIC Employee</label>

                            <InputText type="number" placeholder="ESIC Employee" name="esic_employee"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                v-model="service.employee_onboarding.esic_employee" @keypress="isNumber($event)"
                                class="textbox onboard-form form-control calculation_data net_data" step="0.01" readonly />
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3">
                        <div class="floating">
                            <label for="" class="float-label">Net Income</label>

                            <InputText type="number"
                                :class="[service.readonly.is_emp_code_quick ? 'bg-gray-200' : 'bg-gray-200']"
                                placeholder="Net Income" name="net_income" v-model="service.employee_onboarding.net_income"
                                class="onboard-form form-control textbox" step="0.01" readonly
                                @keypress="isNumber($event)" />
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
import { reactive, ref } from 'vue';

const service = useNormalOnboardingMainStore()

const v$ = useValidate(service.rules, service.employee_onboarding);


const compensation_month = ref([
    { id: "1", name: "Monthly gross" },
    { id: "2", name: "Monthly Net" },
]);
const compensation_yearly = ref([
    { id: "1", name: "Yearly Gross" },
    { id: "2", name: "Yearly Net" },
]);



const mon = ref(false);
const year = ref(false);

const comp = reactive({
    compensation_monthly: "",
    compensation_yearly: "",
});

const comp_mon = () => {
    mon.value = true;
    year.value = false;
};
const comp_year = () => {
    year.value = true;
    mon.value = false;
};


const isNumber = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[0-9]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

</script>
