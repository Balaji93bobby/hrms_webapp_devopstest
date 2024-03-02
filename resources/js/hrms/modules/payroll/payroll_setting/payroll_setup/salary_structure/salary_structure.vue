<template>
    <div class="w-full p-3">
        <div v-if="route.params.name == undefined || route.params.name == ''">
            <!-- <section id="header" class="flex justify-between mx-2">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold text-gray-800 fs-5"> Salary Structure <span
                                class="font-semibold text-gray-600 fs-6">(Paygroup)</span></p>
                    </div>


                </div>
                <div class="float-right">
                    <button class="btn btn-orange float-right px-6 py-2 w-[160px]">
                        <router-link class="   " :to="`/payrollSetup/structure/create`">Add
                            Structure</router-link>
                    </button>
                </div>
            </section> -->
            <!-- <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1 xxl:grid-cols-4 xl:grid-cols-4 lg:grid-cols-4 mx-1"
                style="display: grid;">
                <div class="p-0.5 rounded-lg shadow-md tw-card dynamic-card hover:bg-slate-100 ">
                    <p class="text-lg font-semibold text-center ">Earings</p>
                    <p class="my-0.5 text-xl font-bold text-center">
                         <span v-if="leave_balance.leave_balance == ''">0</span> 
                        <span>10</span>
                    </p>
                </div>
            </div> -->
            <!-- modified design for structure -->
            <!-- <div class="grid grid-cols-6 ">
                <div class="col-span-5 p-2 box-border flex justify-center items-center">
                    <p class="font-['poppins'] text-[18px] font-semibold">Payroll and Attendance End Date Setting</p>
                </div>
                <div class=" col-span-1 relative  p-2 box-border">
                    <button class=" box-border font-medium border-[1px] border-[#dddd] !w-[175px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[16px] absolute left-5 ">
                        <i class="pi pi-plus"></i>&nbsp;&nbsp; New Structure</button>
                </div>
            </div>
            <div id="table-responsive" class="my-4">
                <DataTable :value="usePayroll.salaryStructureSource">
                    <Column field="paygroup_name" header="Salary Structure Name"></Column>
                    <Column field="no_of_employees" header="No of Emp Assigned"></Column>
                    <Column field="created_at" header="Created On"></Column>
                    <Column field="updated_at" header="Last Modified"></Column>
                    <Column header="Action">
                        <template #body>
                            <button class="p-1 mx-4 bg-green-200 border-green-500 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-8 h-6 px-auto text-center">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <button class="p-1 bg-red-200 border-red-500 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-8 h-6 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </template>
                    </Column>
                </DataTable>

            </div> -->
        </div>
        <!-- v-if="route.params.name == 'create'" -->
        <NewSalaryStructure  />
        <!-- <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
                @click="uesPayroll.activeTab--">Previous</button>
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
                @click="uesPayroll.saveGeneralPayrollSettings(uesPayroll.generalPayrollSettings)">Save</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="uesPayroll.activeTab++">Next</button>
        </div> -->
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import NewSalaryStructure from './new_salary_structure.vue';
import { usePayrollMainStore } from '../../../stores/payrollMainStore'
import { usePayrollHelper } from '../../../stores/payrollHelper';
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();

const usePayroll = usePayrollMainStore()
const helper = usePayrollHelper()

onMounted(async() => {
    await usePayroll.getPayGroupDetails()
    console.log(route.params.name);
})

</script>

<style>
.v-enter-active,
.v-leave-active
{
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to
{
    opacity: 0;
}

.bounce-enter-active
{
    animation: bounce-in 0.5s;
}

.bounce-leave-active
{
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in
{
    0%
    {
        transform: scale(0);
    }

    50%
    {
        transform: scale(1.25);
    }

    100%
    {
        transform: scale(1);
    }
}
</style>
