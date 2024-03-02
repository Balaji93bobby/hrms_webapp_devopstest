<template>
    <div class="w-full">
        <!-- <div class="float-right">
            toggle button
        </div>
        <div class="flex w-5 pt-4 mx-6 border ">
            <p>EPF Details</p>
            <div><button><i class="pi pi-pencil"></i></button></div>
        </div> -->
        <div class="row">
            <div class="col-6 d-flex px-4">
                <p>EPF Details</p>
                <button @click="openPosition('top')"><i class="pi pi-pencil"></i>
                </button>
            </div>
            <div class="col">
                <div class=" d-flex w-full justify-end align-items-center">
                    <label for="" class="mx-2 text-gray-500">Disable EPF</label>
                    <InputSwitch class="mx-2" v-model="checked" />
                    <h1 class="mx-2">Enable EPF</h1>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mx-1">
            <div class="col-span-5 grid grid-cols-12 gap-4 p-4 my-1 bg-gray-100 rounded-lg shadow-md border-1">
                <div class="col-span-6">
                    <div class="my-1 ">
                        <h5 class="my-2 text-sm font-semibold">EPF Number</h5>
                        <div class="flex gap-8 justify-evenly ">
                            <div class="w-full">
                                <InputText class="w-full h-10" />
                            </div>
                        </div>
                    </div>
                    <div class="my-4">
                        <h5 class="my-2 text-sm font-semibold">
                            Deduction Cycle
                        </h5>
                        <div class="flex gap-8 justify-evenly">
                            <div class="w-full">
                                <InputText class="w-full h-10" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6">
                    <input type="checkbox" class="m" style="width: 18px ; height: 20px;" name="" id="">
                    <label for="" class=" text-gray-600 fs-6">Is Default</label>
                    <p class=" text-gray-600 w-full mt-1 text-xs">
                        (Note: Once employees are onboarded they will be automatically enrolled in this PF scheme. Any
                        modifications to the enrolement can only be made before the start of payroll processing )
                    </p>
                </div>

            </div>

            <div class="col-span-7 p-4 my-4  rounded-lg shadow-md border-1">
                <div class="mx-2 my-4 d-flex align-center">
                    <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                    <label for="" class="fs-6  text-gray-600">Employer's Contribution is included in the CTC.</label>
                </div>
                <div class="mx-2 my-4">
                    <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                    <label for="" class=" text-gray-600">Employer's EDLI Contribution is included in the CTC.</label>
                </div>
                <div class="mx-2 my-4">
                    <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                    <label for="" class=" text-gray-600">Admin Charges is included in the CTC.</label>
                </div>
                <div class="mx-2 my-4">
                    <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                    <label for="" class=" text-gray-600">Override PF Contribution rate at employee level</label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <p class="fs-5 fw-semibold">Employee/Employeer Contribution</p>
            <p class="text-gray-600">Note: The Contribution made by both employers and employees will remain the same</p>
        </div>
        <div class="grid grid-cols-12 gap-6 ">
            <div class="col-span-5">
                <div class="p-4 my-4 bg-gray-100 rounded-lg shadow-md border-1">
                    <div class="my-4">
                        <h5 class="my-2 text-lg font-semibold">
                            Select the Rule
                        </h5>
                        <div class="flex gap-8 justify-evenly ">
                            <div class=" w-full ">
                                <Dropdown class=" w-20rem" />
                            </div>
                        </div>
                    </div>
                    <div class="my-4">
                        <h5 class="my-2 text-lg font-semibold">
                            Select the Contribution Tye
                        </h5>
                        <div class="flex gap-8 justify-evenly">
                            <div class=" w-full ">
                                <Dropdown class=" w-20rem" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-md border-1">
                    <div class="my-4 d-flex align-items-center">
                        <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                        <label for="" class=" text-gray-500">
                            Pro-rate restricted PF Wage When LOP Applied
                        </label>
                    </div>
                    <div class="my-4 d-flex align-items-center">
                        <input type="checkbox" name="" id="" class="mr-4" style="width: 18px ;height: 20px;">
                        <label for="" class=" text-gray-500">
                            Consider all applicable salary components if PF Wage is less tham 15,000 after loss of pay
                        </label>
                    </div>
                </div>

            </div>

            <div class="col-span-7 p-4 my-4  rounded-lg shadow-md border-1">
                <h1 class="my-2 text-xl font-bold">
                    Example
                </h1>

                <p class=" text-gray-600">Let's assume the Gross Wages = <strong>50,000</strong>
                    and HRA=<strong>4000</strong>
                    ,then the breakup of contribution will be:</p>

                <div class="my-6 w-full">
                    <DataTable :value="products">
                        <Column field="product" header="Code"></Column>
                        <Column field="lastYearSale" header="Name"></Column>
                        <Column field="thisYearSale" header="Category"></Column>
                        <Column field="thisYearProfit" header="Quantity"></Column>
                    </DataTable>
                </div>

                <div class="border-gray-300 ">
                    <p class=" text-gray-600"><strong>Note:</strong>This Condition Works</p>
                    <p class="text-gray-500">if</p>
                    <p class=" text-gray-600"><strong>Gross(<span class=" text-red-500">-</span>)HRA </strong> is Greater
                        than <strong>15,000</strong>
                        ,then PF deduction will be 15,000(<span class="text-red-500"> *</span>) 12%</p>
                    <p class="text-gray-500">Else</p>
                    <p class=" text-gray-600"><strong>Gross( <span class="text-red-500">-</span>)HRA </strong> is Lesser
                        than <strong>15,000</strong>
                        ,and PF deduction will be <strong>Gross</strong>(<span class="text-red-500">-</span> )HRA(<span
                            class="text-red-500">*</span> ) 12%</p>
                </div>
            </div>
        </div>

        <div>

            <div class=" d-flex ">
                <i class="pi pi-user-plus fs-4 mx-2 text-primary"></i>
                <p class=" text-primary fw-semibold fs-5 ">Assign Employees</p>
            </div>
        </div>
        <div>
            <p class=" fs-5"><Strong class="mx-1 fs-5">40</Strong>
                Employees Assigned
                <button class=" text-primary fs-6 fs-8">View/Edit</button>
            </p>
        </div>
    </div>

    <Dialog v-model:visible="CanShowExplanationDialog" header="Header" :style="{ width: '50vw' }" :position="position"
        :modal="true" :draggable="false">
        <p>The attendance cut off date deadline for processing an employee's within a pay period.After this date,any absence
            by the employee will not affect their</p>
        <DataTable :value="products">
            <Column field="product" header="Code"></Column>
            <Column field="lastYearSale" header="Name"></Column>
            <Column field="thisYearSale" header="Category"></Column>
            <Column field="thisYearProfit" header="Quantity"></Column>
        </DataTable>

        <template #footer>
            <!-- <Button label="No" icon="pi pi-times" @click="visible = false" text />
            <Button label="Yes" icon="pi pi-check" @click="visible = false" autofocus /> -->
            <button class=""></button>
            <button class=""></button>
        </template>
    </Dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";

const checked = ref();

const CanShowExplanationDialog = ref(false);
const position = ref('center');
const openPosition = (pos) => {
    position.value.pos;
    CanShowExplanationDialog.value = pos;
}

const products = ref([
    {
        product: "Bamboo Watch",
        lastYearSale: 51,
        thisYearSale: 40,
        lastYearProfit: 54406,
        thisYearProfit: 43342,
    },
    {
        product: "Black Watch",
        lastYearSale: 83,
        thisYearSale: 9,
        lastYearProfit: 423132,
        thisYearProfit: 312122,
    },
    {
        product: "Blue Band",
        lastYearSale: 38,
        thisYearSale: 5,
        lastYearProfit: 12321,
        thisYearProfit: 8500,
    },
]);


</script>
{
    <!--
        <template>
    <div class="card flex justify-content-center">
        <InputSwitch v-model="checked" />
    </div>
</template>

<script setup>
import { ref } from 'vue';

const checked = ref(true);
</script>
     -->
}
