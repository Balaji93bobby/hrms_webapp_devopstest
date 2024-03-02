<template>
    <!-- <div v-if="useStore.activeHolidaysPage === 3">
        <Holidays_Lists />
    </div> -->

    <div class="card" v-if="useStore.activeHolidaysPage === 2">
        <div class="px-3">
            <div class="w-full  d-flex justify-between my-4">
                <Calendar v-model="date" />
                <div class="">
                    <button @click="useStore.activeHolidaysPage = 2" class="btn bg-blue-900 text-light fw-bold">View All
                        Hoildays</button>
                    <button class="btn btn-orange ml-3 fw-bold" @click="canshowAddNewLocation = true"><i
                            class="pi pi-plus-circle "></i><span class="pl-2 fw-bold fs-6">Add New Location</span> </button>
                </div>
            </div>
            <!-- {{ useStore.arrayholidayMaster }} -->
            <DataTable :value="useStore.arrayholidayMaster" ref="dt" dataKey="id" :paginator="true" :rows="10"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">


                <Column field="Location" header="Location" style="min-width: 12rem">

                </Column>

                <Column header="Holidays List" field="Holidays_List" style="min-width: 8rem">
                </Column>

                <Column field="NoOfHolidays" header="No of Holidays" style="min-width: 12rem">

                </Column>

                <Column header="Employees" field="Employees" style="min-width: 8rem">
                </Column>


                <Column field="Action" header="Actions" style="min-width: 12rem">
                    <template #body="slotProps">
                        <span>
                            <Button type="button" icon="pi pi-eye" class="p-button-success Button" label="View"
                                @click="ViewHolidaysList(slotProps.data.Holidays_List)" style="height: 2.5em" />
                            <Button type="button" icon="pi pi-trash" class="p-button-danger Button" label="Delete"
                                style="margin-left: 8px; height: 2.5em" @click="DeleteHolidayList(slotProps.data.id,slotProps.data.Holidays_List)" />
                        </span>
                    </template>
                </Column>

            </DataTable>

                <Dialog v-model:visible="canshowAddNewLocation" modal header="Holiday " :style="{ width: '38vw' }"
                style="border-top:5px solid #002f56" class="popup_card">
                <template #header>
                    <div>
                        <h1 class="border-l-4 border-orange-400 fs-5 fw-bold pl-3">Assign To Location</h1>
                    </div>
                </template>
                <div class="flex-column my-3 mx-5">
                    <div style="" class="w-full border h-48 "></div>
                    <!-- d-flex justify-content-between align-content-center -->
                    <div class="row d-flex align-items-center mt-4">
                        <div class="col-5">
                            <h1 class="text-gray-700 fs-5 font-semibold">Location</h1>
                        </div>

                        <div class="col">
                            <InputText type="text" class="w-full h-12" v-model="useStore.AssignToLocation.location" />
                            <!-- <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                placeholder="Choose the location to assign" class="w-full" /> -->
                        </div>
                        <!-- <input type="text" name="" id=""> -->
                    </div>
                    <div class="row my-2 mb-4 d-flex align-items-center">
                        <div class="col-5 ">
                            <h1 class="text-gray-700 fs-5 font-semibold">Choose Holidays List</h1>
                        </div>
                        <div class="col ">
                            <!-- <MultiSelect v-model="useStore.AssignToLocation.ChooseTheHolidays" :options="useStore.arrayHolidaysList"  optionLabel="holiday_name"
                                placeholder="Select Cities" :maxSelectedLabels="3" class="w-full h-12" style="width: 230px !important;" @change="useStore.getHolidayName()" /> -->
                                <!-- {{ useStore.AssignToLocation.ChooseTheHolidays }} -->
                                <Dropdown v-model="useStore.AssignToLocation.ChooseTheHolidays" :options="useStore.arrayCreateNewList" optionLabel="name" placeholder="" class="w-full"  />
                                <!-- @change="useStore.getHolidayName()" -->
                            <!-- <MultiSelect v-model="useStore.AssignToLocation.ChooseTheHolidays" :options="cities" optionLabel="name"
                                placeholder="" :maxSelectedLabels="3" class="w-full h-12 "/> -->
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button label="Cancel" class=" border-orange-400 text-orange-500 mr-4 bg-white"
                        @click="canshowDialog = false" text />
                    <Button label="Create" class="bg-orange-500 border-none" icon="pi pi-plus-circle"
                        @click="useStore.SubmitAddNewLocation" autofocus />
                </template>
            </Dialog>

        </div>

    </div>

    <Dialog header="Header" v-model:visible="useStore.canShowLoading"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
        :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>

    <div>
        <CreateNewHolidaysList />

    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import dateFormat, { masks } from "dateformat";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import dayjs from 'dayjs';
import Holidays_Lists from "./Holidays_Lists.vue"
import { useHolidayStore } from "../attendance_settings/stores/HolidayStore";
import CreateNewHolidaysList from "./CreateNewHolidaysList.vue";
const useStore = useHolidayStore();

const canshowAddNewLocation = ref(false);

onMounted(async () => {
    await useStore.getHolidaysMaster();
    // console.log(DocumentSettingsStore.array_emp_documents_details)

});

const selectedRowdata = ref();

const selectedCities = ref();
const cities = ref([
        { name: 'TN_200', code: 1 },
        { name: 'TN_201', code: 2 },
        { name: 'TN_202', code: 3 },
        { name: 'TN_203', code: 4 },
        { name: 'TN_204', code: 5 }
]);

const ViewHolidaysList = (val) => {
    selectedRowdata.value = val;
    useStore.activeHolidaysPage =2;
    console.log(useStore.activeHolidaysPage);

    console.log(selectedRowdata.value);
    console.log("ViewHolidaysList");


}

const DeleteHolidayList = (val) => {
    selectedRowdata.value = val;
    console.log(selectedRowdata.value);
    console.log("DeleteHolidayList");
}

</script>


{
<!--
    <template>
        <div class="card flex justify-content-center">
            <MultiSelect v-model="selectedCities" :options="cities" optionLabel="name" placeholder="Select Cities"
                :maxSelectedLabels="3" class="w-full md:w-20rem" />
        </div>
    </template>

    <script setup>
    import { ref } from "vue";

    const selectedCities = ref();
    const cities = ref([
        { name: 'New York', code: 'NY' },
        { name: 'Rome', code: 'RM' },
        { name: 'London', code: 'LDN' },
        { name: 'Istanbul', code: 'IST' },
        { name: 'Paris', code: 'PRS' }
    ]);
    </script>




<template>
    <div class="card flex justify-content-center">
        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" class="w-full md:w-14rem" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
</script>


          <Dialog v-model:visible="canshowAddNewLocation" modal header="Holiday " :style="{ width: '38vw' }"
                style="border-top:5px solid #002f56" class="popup_card">
                <template #header>
                    <div>
                        <h1 class="border-l-4 border-orange-400 fs-5 fw-bold pl-3">Assign To Location</h1>
                    </div>
                </template>
                <div class="flex-column my-3 mx-5">
                    <div style="" class="w-full border h-48 "></div>
                     d-flex justify-content-between align-content-center
                    <div class="row d-flex align-items-center mt-4">
                        <div class="col-5">
                            <h1 class="text-gray-700 fs-5 font-semibold">Location</h1>
                        </div>

                        <div class="col">
                            <InputText type="text" class="w-full h-12" v-model="useStore.AssignToLocation.location" />
                             <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                placeholder="Choose the location to assign" class="w-full" />
                        </div>
                         <input type="text" name="" id="">
                    </div>
                    <div class="row my-2 mb-4 d-flex align-items-center">
                        <div class="col-5 ">
                            <h1 class="text-gray-700 fs-5 font-semibold">Choose Holidays List</h1>
                        </div>
                        <div class="col ">
                            <MultiSelect v-model="useStore.AssignToLocation.ChooseTheHolidays" :options="cities" optionLabel="name"
                                placeholder="" :maxSelectedLabels="3" class="w-full h-12 "/>
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button label="Cancel" class=" border-orange-400 text-orange-500 mr-4 bg-white"
                        @click="canshowDialog = false" text />
                    <Button label="Create" class="bg-orange-500 border-none" icon="pi pi-plus-circle"
                        @click="useStore.SubmitAddNewLocation" autofocus />
                </template>
            </Dialog>

-->
}
