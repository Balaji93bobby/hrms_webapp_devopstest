<template>
    <div class="row ml-1 mr-3 mt-2 " v-if="tab == 'salaryAdvance'">
        <div class="col-12 border-1 rounded-md h-28 d-flex flex-column align-items-center justify-content-between p-3 even-card shadow-sm mb-2 blink"
            v-for="(item, index) in source" :key="index" :class="[]">
            <div class="w-100 d-flex justify-content-between align-items-center">
                <h1 class="  fs-5">{{ item.settings.settings_name }}</h1>
                <button class=" underline text-blue-400 fs-5 " @click="viewDetails(item)">View Details</button>
            </div>
            <div class="w-100 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class=" fs-5" v-if="item.settings.deduction_period_of_months === 1">Deduct the amount in
                        the Upcomming Payroll</h1>
                    <h1 class=" fs-5" v-else>The deduction can be made over a period of {{
                        item.settings.deduction_period_of_months }} months. </h1>
                </div>

                <h1 class=" fs-5">Percentage of Salary Advance: {{ item.settings.percent_salary_adv }}%</h1>
                <h1 class=" fs-5">Employee Count : {{ item.settings.emp_count }}</h1>
            </div>
        </div>
    </div>
    <div class="row ml-1 mr-3 mt-2 ">
        <div class="col-12 border-1 rounded-md h-28 d-flex flex-column align-items-center justify-content-between p-3 even-card shadow-sm mb-2 blink"
            v-for="(item, index) in source" :key="index" :class="[]">
            <div class="w-100 d-flex justify-content-between align-items-center">
                <h1 class="  fs-5">{{ item.settings.settings_name }}</h1>
                <button class=" underline text-blue-400 fs-5 " @click="viewDetails(item)">View Details</button>
            </div>
            <div class="w-100 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class=" fs-5" v-if="item.settings.deduction_period_of_months === 1">Deduct the amount in
                        the Upcomming Payroll</h1>
                    <h1 class=" fs-5" v-else>The deduction can be made over a period of {{
                        item.settings.deduction_period_of_months }} months. </h1>
                </div>

                <h1 class=" fs-5">Percentage of Salary Advance: {{ item.settings.percent_salary_adv }}%</h1>
                <h1 class=" fs-5">Employee Count : {{ item.settings.emp_count }}</h1>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { salaryAdvanceSettingMainStore } from '../stores/salaryAdvanceSettingMainStore'



const salaryStore = salaryAdvanceSettingMainStore();
const props = defineProps({
    source: {
        type: Array,
        required: true
    },
    tab:{
        type: String,
        required: true
    }
})

let view_details = ref();


const Name = [];


function viewDetails(val) {
    view_details.value = val;
    console.log(view_details);

    salaryStore.create_new_from = 2;

    salaryStore.sa.SA = val.settings.view_details.settings_name;
    salaryStore.sa.isSalaryAdvanceEnabled = val.settings.view_details;
    salaryStore.sa.eligibleEmployee = val.settings.view_details;
    salaryStore.sa.perOfSalAdvance = val.settings.view_details.percent_salary_adv;
    salaryStore.sa.cusPerOfSalAdvance = val.settings.view_details
    salaryStore.sa.payroll_cycle = val.settings.view_details.can_borrowed_multiple;
    salaryStore.eligbleEmployeeSource = val.settings.view_details.assigned_emp

    val.settings.view_details.approver_flow.forEach(element => {

        Name.push(element.name)

        salaryStore.selectedOption1 = Name[0];
        if (Name[1]) {
            salaryStore.selectedOption2 = Name[1];
        }
        if (Name[2]) {
            salaryStore.selectedOption2 = Name[2];
        }
    });

    if (salaryStore.selectedOption1) {
        salaryStore.option1 = 0;
        salaryStore.option = 1

        if (salaryStore.selectedOption2) {
            salaryStore.option1 = 1
            salaryStore.option2 = 1
        }
    }

    if (val.settings.view_details.deduction_period_of_months == 1) {
        salaryStore.sa.deductMethod = val.settings.view_details.deduction_period_of_months;
    }
    else {
        salaryStore.sa.deductMethod = "afterPayroll";
        salaryStore.sa.cusDeductMethod = val.settings.view_details.deduction_period_of_months;
    }

}

</script>
