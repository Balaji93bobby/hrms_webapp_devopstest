<template>
    <Toast />
    <div class="w-full">
        <div class="">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <!-- <div id="msform"> -->
                    <form class="p-fluid" enctype="multipart/form-data">
                        <PersonDetails />
                        <Address />
                        <FamilyDetails />
                        <OfficeDetails />
                        <Compensatory />
                        <PersonDocuments />
                    </form>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- <p>{{ employee_onboarding.save_draft_messege }}</p> -->

    <Dialog v-if="!service.employee_onboarding.employee_code.length > 0 &&
        !service.employee_onboarding.aadhar_number.length > 0 ||
        !service.employee_onboarding.employee_name.length > 0 &&
        !service.employee_onboarding.email.length > 0 ||
        !service.employee_onboarding.mobile_number.length > 0 &&
        !service.employee_onboarding.dob.length > 0
        " header="Information Required" v-model:visible="service.RequiredDocument"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }">

        <div class="flex my-4" v-if="service.employee_onboarding.employee_code == '' ||
            service.employee_onboarding.employee_code.length < 0
            ">
            <img src="../../../assests/images/requirement.png" style="height: 25px;width: 38px;" alt=""><span
                class="my-auto">Employee Code is Required </span>
        </div>
        <div class="flex my-4" v-if="service.employee_onboarding.employee_name == '' ||
            service.employee_onboarding.employee_name.length < 0
            ">
            <img src="../../../assests/images/requirement.png" style="height: 25px;width: 38px;" alt=""><span
                class="my-auto">Employee Name As Per Aadhar is Required</span>
        </div>
        <div class="flex my-4" v-if="service.employee_onboarding.mobile_number == '' ||
            service.employee_onboarding.mobile_number.length < 0
            ">
            <img src="../../../assests/images/requirement.png" style="height: 25px;width: 38px;" alt=""><span
                class="my-auto">Mobile Number is Required</span>
        </div>
        <div class="flex my-4" v-if="service.employee_onboarding.email == '' ||
            service.employee_onboarding.email.length < 0
            ">
            <img src="../../../assests/images/requirement.png" style="height: 25px;width: 38px;" alt=""><span
                class="my-auto">Email is Required</span>
        </div>
    </Dialog>

    <!--

    <Dialog v-model:visible="showMessage" :breakpoints="{ '960px': '80vw' }" :style="{ width: '30vw' }" position="center">
        <div class="flex px-3 pt-6 text-center align-items-center flex-column">
            <i class="pi pi-check-circle" :style="{ fontSize: '5rem', color: 'var(--green-500)' }"></i>
            <h5 class="mb-6">Onboarding Successful!</h5>
            <p :style="{ lineHeight: 1.5, textIndent: '1rem' }">
                Your account is registered under name
                <b>{{ employee_onboarding.employee_name }}</b><br />
                Please check
                <b>{{ employee_onboarding.email }}</b> for Further Information
            </p>
        </div>
        <template #footer>
            <div class="flex justify-content-center">
                <Button label="OK" @click="toggleDialog" class="p-button-text" />
            </div>
        </template>
    </Dialog> -->
    <Dialog header="Header" v-model:visible="service.canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
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



import PersonDetails from "./PersonDetails/PersonDetails.vue";
import PersonDocuments from "./PersonDocuments/PersonDocuments.vue";
import Address from './Address/Address.vue';
import FamilyDetails from "./FamilyDetails/FamilyDetails.vue";
import OfficeDetails from './OfficeDetails/OfficeDetails.vue'
import Compensatory from './Compensatory/Compensatory.vue'


import { onMounted } from "@vue/runtime-core";
import { ref } from "@vue/runtime-core";
import { useRouter, useRoute } from "vue-router";


import { useNormalOnboardingMainStore } from './stores/NormalOnboardingMainStore'
import {useOnboardingMainStore} from '../stores/OnboardingMainStore'


const router = useRouter();
const route = useRoute();
const service = useNormalOnboardingMainStore()
const onboardingService = useOnboardingMainStore()




onMounted(() => {

    const user_id = route.params.id
    service.getBasicDeps()
    service.isQuickOrBulkOnboarding(user_id)
    service.NationalityCheck()
    onboardingService.getExistingOnboardingDocuments()



    setTimeout(() => {
        if (service.checkIsQuickOrNormal == 'quick' || service.checkIsQuickOrNormal == 'bulk') {
            console.log("calculation performs");
            service.compensatoryCalWhileQuick()
            // spouseEnable()
        } else {
            console.log("no calculation performs");
        }
    }, 6000);



});


const Sampledata = () => {
    // employee_onboarding.employee_code = ref("B090");
    //employee_onboarding.employee_name = ref("George David");
    employee_onboarding.aadhar_number = ref("3977 8798 6564");
    // employee_onboarding.doj = ref("23-4-2020");
    employee_onboarding.pan_number = ref("BGAJP6646F");
    employee_onboarding.blood_group_name = ref("B Positive");
    employee_onboarding.dob = ref("23-07-2000");
    // employee_onboarding.email = ref("example@gmail.com");
    employee_onboarding.dl_no = ref("HR-0619850034761");
    employee_onboarding.passport_number = ref("A2096457");
    employee_onboarding.passport_date = ref("23-5-2030");
    employee_onboarding.bank_name = ref("ANDHRA BANK");
    employee_onboarding.physically_challenged = ref("No");
    employee_onboarding.AccountNumber = ref("35216644292");
    employee_onboarding.bank_ifsc = ref("SBIN0121325");
    employee_onboarding.nationality = ref("Indian");
    employee_onboarding.gender = ref("Male");
    employee_onboarding.marital_status = ref("Married");
    employee_onboarding.mobile_number = ref('8248023344');
    employee_onboarding.current_address_line_1 = ref("45/21 2nd Avenue,chennai");
    employee_onboarding.current_address_line_2 = ref("45/21 2nd Avenue,chennai");
    employee_onboarding.current_country = ref("India");
    employee_onboarding.current_state = ref("Tamil Nadu");
    employee_onboarding.current_city = ref("chennai");
    employee_onboarding.current_pincode = ref("600023");
    employee_onboarding.permanent_address_line_1 = ref(
        "45/21 2nd Avenue,chennai"
    );
    employee_onboarding.permanent_address_line_2 = ref(
        "45/21 2nd Avenue,chennai"
    );
    employee_onboarding.permanent_country = ref("India");
    employee_onboarding.permanent_city = ref("chennai");
    employee_onboarding.permanent_state = ref("Tamil Nadu");
    employee_onboarding.permanent_pincode = ref("600003");
    employee_onboarding.department = ref("IT");
    employee_onboarding.process = ref("Iti");
    //employee_onboarding.designation = ref("Developer");
    employee_onboarding.cost_center = ref("Chennai");
    //  employee_onboarding.probation_period = ref("11 Month");
    employee_onboarding.holiday_location = ref("Tamilnadu");
    //  employee_onboarding.l1_manager_code = ref("PLIPL076-Muthu Selvan");
    employee_onboarding.work_location = ref("chennai");
    employee_onboarding.officical_mail = ref("voidmax@gmail.com");
    employee_onboarding.official_mobile = ref("4646454547");
    // employee_onboarding.emp_notice = ref(3);
    //  employee_onboarding.confirmation_period = ref("10-12-2019");
    employee_onboarding.father_name = ref("David");
    employee_onboarding.father_age = ref("45");
    employee_onboarding.dob_father = ref("23-09-1968");
    employee_onboarding.mother_name = ref("Licas");
    employee_onboarding.dob_mother = ref("23-8-1970");
    employee_onboarding.mother_gender = ref("Female");
    employee_onboarding.mother_age = ref("35");
    employee_onboarding.spouse_gender = ref("female");
    employee_onboarding.dob_spouse = ref("12-8-1995");
    employee_onboarding.spouse_name = ref("priyanka");
    //   employee_onboarding.basic = ref(13205);
    //   employee_onboarding.hra = ref(6603);
    //   employee_onboarding.statutory_bonus = ref(0);
    //   employee_onboarding.other_allowance = ref(0);
    //   employee_onboarding.child_education_allowance = ref(0);
    //   employee_onboarding.food_coupon = ref(0);
    //   employee_onboarding.lta = ref(0);
    //   employee_onboarding.special_allowance = ref(2200);
    //   employee_onboarding.gross = ref(1000);
    //   employee_onboarding.epf_employee= ref(1000);
    //   employee_onboarding.epf_employer_contribution = ref(1000);
    //   employee_onboarding.esic_employee = ref(1000);
    //   employee_onboarding.esic_employer_contribution = ref(1000);
    //   employee_onboarding.professional_tax = ref(1000);
    //   employee_onboarding.labour_welfare_fund = ref(1000);
    //   employee_onboarding.net_income = ref(1000);
    //   employee_onboarding.total_ctc = ref(1000);
    //   employee_onboarding.graduity = ref(1000);
    //   employee_onboarding.insurance = ref(1000);




};
</script>

<style >
.form-control
{
    height: 2.4em;
}

label
{
    font-weight: 501;
    padding-bottom: 5px;
}

.form-control:focus
{
    color: #212529;
    background-color: #fff;
    border-color: #eaecef;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%);
    outline-offset: 0;
    box-shadow: 0 0 0 0.2rem #eaecef;
    border-color: #212529;
}


.p-inputgroup
{
    display: flex;
    align-items: stretch;
    width: 100%;
    height: 2.5rem;
}

.floating input
{
    width: 100% !important;
    margin-left: 0 !important;
    height: 2.5em;
}

.p-dropdown
{
    background: #ffffff;
    border: 1px solid #ced4da;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
    border-radius: 6px;
    height: 2.5em;
}



.p-dropdown .p-dropdown-label
{
    background: transparent;
    border: 0 none;
    margin-top: -3px;
}

.p-dropdown:not(.p-disabled):hover
{
    border-color: #212529;
}

.p-dropdown:not(.p-disabled):focus
{
    color: #212529;
    background-color: #fff;
    border-color: #eaecef;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%);
    outline-offset: 0;
    box-shadow: 0 0 0 0.2rem #eaecef;
    border-color: #212529;
}

.p-dropdown .p-dropdown-label.p-placeholder
{
    color: #6c757d;
    font-size: 12.5px;
}

input.p-dropdown-filter.p-inputtext.p-component
{
    height: 2.7rem;
    width: 250px;
}

.p-dropdown-panel .p-dropdown-header .p-dropdown-filter
{
    padding-right: 1.75rem;
    margin-right: -1.75rem;
    height: 2.5em;
}

:deep(.p-dropdown-panel .p-component .p-dropdown-items-wrapper)
{
    z-index: 1001;
    transform-origin: center bottom;
    top: 792.4px;
    left: 279.8px;
    width: 275px;
}

:deep(.p-dropdown-panel .p-component .p-dropdown-items-wrapper)
{
    max-width: 280px;
}

:deep(.p-dropdown-panel .p-component)
{
    background: #ffffff;
    color: #495057;
    border: 0 none;
    border-radius: 6px;
    box-shadow: 0 2px 12px 0 rgb(0 0 0 / 10%);
    width: 100px;
}

:deep(.p-dropdown-item)
{
    cursor: pointer;
    font-weight: normal;
    white-space: nowrap;
    position: relative;
    overflow: hidden;
    width: 100px;
}

.p-dialog-mask
{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
    background: #0000005e;
}

.field
{
    margin-bottom: 1.5rem;
}

form
{
    margin-top: 2rem;
}

.card
{
    min-width: 450px;
}

@media screen and (max-width: 960px)
{
    .card
    {
        width: 80%;
    }
}

.p-datepicker .p-datepicker-header
{
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
.p-datepicker .p-datepicker-header .p-datepicker-title .p-datepicker-month
{
    color: black;
    transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 600;
    padding: 0.5rem;
}

.p-button.p-component.p-button-icon-only.p-datepicker-trigger
{
    height: 0.9rem;
    height: 32px !important;
}

.p-calendar-w-btn .p-datepicker-trigger
{
    border-top-left-radius: none;
    border-bottom-left-radius: none;
    background: #fff;
    border: 1px solid rgb(192, 183, 183);
    height: 2.5rem;
    color: black;
    font-weight: 600;
    font-size: 20px;
}

.p-button:enabled:hover
{
    background: #fff;
    color: black;
    font-weight: 600;
    border: 1px solid rgb(192, 183, 183);
}



.p-datepicker-decade
{
    color: white;
}</style>
