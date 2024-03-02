<template>
    <Toast />
    <LoadingSpinner class="absolute z-50 bg-white" v-if="_instance_profilePagesStore.loading_screen" />
    <div class="w-full h-screen p-3 bg-gray-50"
        v-if="_instance_profilePagesStore.employeeDetails.get_employee_office_details">
        <EmployeeCard />

        <div class="w-full my-2">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xxl-12 col-xl-12">
                <div class="mb-2">
                    <div class="pt-1 pb-0 ">
                        <ul class="nav nav-pills nav-tabs-dashed" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <a class="nav-link active " id="" data-bs-toggle="pill" href=""
                                    data-bs-target="#employee_details" role="tab" aria-controls="pills-home"
                                    aria-selected="true">
                                    Employee Details</a>
                            </li>
                            <li class="mx-4 nav-item" role="presentation">
                                <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href=""
                                    data-bs-target="#family_det" role="tab" aria-controls="pills-home" aria-selected="true">
                                    Family</a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link " id="pills-home-tab" data-bs-toggle="pill" href=""
                                    data-bs-target="#experience_det" role="tab" aria-controls="pills-home"
                                    aria-selected="true">
                                    Experience</a>
                            </li>
                            <li class="mx-4 nav-item " role="presentation">
                                <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#finance_det"
                                    role="tab" aria-controls="pills-home" aria-selected="true">
                                    Paycheck</a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#document_det"
                                    role="tab" aria-controls="pills-home" aria-selected="true">
                                    Documents</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content " id="pills-tabContent">

                    <div class="tab-pane fade active show" id="employee_details" role="tabpanel" aria-labelledby="">
                        <div>
                            <EmployeeDetails />
                        </div>
                    </div>

                    <div class="tab-pane fade" id="family_det" role="tabpanel" aria-labelledby="">
                        <FamilyDetails />
                    </div>

                    <div class="tab-pane fade" id="experience_det" role="tabpanel" aria-labelledby="">
                        <ExperienceDetails />

                    </div>
                    <div class="tab-pane fade" id="finance_det" role="tabpanel" aria-labelledby="">
                        <div>
                            <FinanceDetails />
                        </div>


                    </div>
                    <div class="tab-pane fade" id="document_det" role="tabpanel" aria-labelledby="">

                        <Documents />

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, onMounted, onUpdated, watch } from 'vue'
import EmployeeCard from './EmployeeCard/EmployeeCard.vue'
import EmployeeDetails from './employee_details/EmployeeDetails.vue'
import FamilyDetails from './family_details/FamilyDetails.vue'
import FinanceDetails from './finance_details/FinanceDetails.vue'
import ExperienceDetails from './experience/ExperienceDetails.vue'
import Documents from './documents/documents.vue'
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import { Service } from '../Service/Service'
import { profilePagesStore } from './stores/ProfilePagesStore'

import { useRouter, useRoute } from "vue-router";


const service = Service()
const route = useRoute();


let _instance_profilePagesStore = profilePagesStore();

onMounted(async () => {
    _instance_profilePagesStore.fetchEmployeeDetails();
})

watch(
    () => route.params, // Watch changes in route parameters
    (newParams, oldParams) => {
        _instance_profilePagesStore.loading_screen = true
        console.log('newParams' + Object.values(newParams));
        console.log('oldParams' + Object.values(oldParams));
        // Check if the route parameters have changed
        if (Object.values(newParams) != Object.values(oldParams)) {
            _instance_profilePagesStore.user_id = service.current_user_id
            _instance_profilePagesStore.fetchEmployeeDetails().finally(() => {
                _instance_profilePagesStore.loading_screen = false
            })

        } else {
            console.log("params not changed");
            _instance_profilePagesStore.user_id = service.current_user_id
            _instance_profilePagesStore.fetchEmployeeDetails();
        }
    }
);


</script>
<style lang="scss">
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
    color: black;
    transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 600;
    padding: 0.5rem;
}

.p-button.p-component.p-button-icon-only.p-datepicker-trigger {
    height: 36px !important;
    margin-bottom: 1px;
    position: relative;
    top: -4px;
}

.p-calendar-w-btn .p-datepicker-trigger {
    border-top-left-radius: none;
    border-bottom-left-radius: none;
    background: #fff;
    border: 1px solid rgb(192, 183, 183);
    height: 2.5rem;
    color: black;
    font-weight: 600;
    font-size: 20px;
}

.p-button:enabled:hover {
    background: #fff;
    color: black;
    font-weight: 600;
    border: 1px solid rgb(192, 183, 183);
}



.p-datepicker-decade {
    color: white;
}
</style>
