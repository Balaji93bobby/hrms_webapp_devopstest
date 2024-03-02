<template>
    <!-- v-if="useStore.activeHolidaysPage === 1" -->
    <div class="card px-3" >
        <!-- <div v-if="useStore.activeHolidaysPage  === 1">
         <Holidays_Master/>
    </div>
    <div v-if="useStore.activeHolidaysPage  === 2"><Holidays_Lists /></div> -->
        <div class="w-full  d-flex justify-between my-4">
            <Calendar v-model="date" />
            <div class="">
                <button @click="useStore.activeHolidaysPage = 1"
                    class="btn font-semibold border-orange-400 text-orange-500 mr-4 bg-transparent px-5 ">Cancel</button>
                <button class="btn btn-orange ml-3 font-semibold" @click="useStore.CreateNewListDialog = true"><i
                        class="pi pi-plus-circle "></i><span class="pl-2 font-semibold text-white fs-6">Create New
                        List</span> </button>
            </div>
        </div>

        <div class="card">
            <!-- {{ useStore.arrayCreateNewList }} -->

            <DataTable :value="useStore.arrayCreateNewList" ref="dt" dataKey="id" :paginator="true" :rows="10"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">

                <Column header="Holiday List" field="name" style="min-width: 8rem">
                </Column>

                <Column field="no_of_holidays" header="No of Holidays" style="min-width: 12rem">

                </Column>

                <Column field="location" header="Location" style="min-width: 12rem">
                </Column>

                <Column field="json_popups_value.to_month" header="Actions" style="min-width: 12rem">
                </Column>

            </DataTable>

            <Dialog v-model:visible="useStore.CreateNewListDialog" modal header="Holiday " :style="{ width: '38vw' }"
                style="border-top:5px solid #002f56" class="popup_card">
                <template #header>
                    <div>
                        <h1 class="border-l-4 border-orange-400 fs-5 fw-bold pl-3">Create New List</h1>
                    </div>
                </template>
                <div class="flex-column my-3 mx-5">
                    <!-- d-flex justify-content-between align-content-center -->
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <h1 class="text-gray-700 fs-4 font-semibold">Holiday List</h1>
                        </div>

                        <div class="col ">
                            <InputText type="text" class="w-full h-12" v-model="useStore.CreateNewList.List_Name" />
                        </div>
                        <!-- <input type="text" name="" id=""> -->
                    </div>
                    <div class="row my-2 mb-4 d-flex align-items-center">
                        <div class="col">
                            <h1 class="text-gray-700 fs-4 font-semibold">Choose The Holidays</h1>
                        </div>
                        <div class="col ">
                            <!-- {{ useStore.arrayHolidaysList }} -->
                            <!-- {{ useStore.CreateNewList.ChooseTheHolidays }} -->
                            <MultiSelect v-model="useStore.ChooseTheHolidays" :options="useStore.arrayHolidaysList"  optionLabel="holiday_name"
                                placeholder="Select Cities" :maxSelectedLabels="3" class="w-full h-12" style="width: 245px !important;" @change="useStore.getHolidayName()" />
                        </div>
                    </div>
                </div>
                <template #footer>
                    <button class="btn border-orange-400 text-orange-500 fw-semibold py-2 px-5" style="padding:9px 20px !important ;" @click="useStore.CreateNewListDialog = false" > Close</button>
                    <!-- <Button label="Cancel" class=" bg-white border-orange-400 text-orange-500  mr-4"
                        @click="useStore.CreateNewListDialog = false" text /> -->
                        <!-- <button class="bg-white border-orange-400 text-orange-500  mr-4" @click="useStore.CreateNewListDialog = false" >Cancel</button> -->
                    <Button label="Create" class="bg-orange-500 border-none" icon="pi pi-plus-circle"
                        @click="useStore.SubmitCreateNewList" autofocus />
                </template>
            </Dialog>


            <Dialog header="Header" v-model:visible="useStore.canShowLoading"
                :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true"
                :closable="false" :closeOnEscape="false">
                <template #header>
                    <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                        animationDuration="2s" aria-label="Custom ProgressSpinner" />
                </template>
                <template #footer>
                    <h5 style="text-align: center">Please wait...</h5>
                </template>
            </Dialog>



        </div>
    </div>
</template>
<script setup>
import { ref,onMounted } from "vue";
import dateFormat, { masks } from "dateformat";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import dayjs from 'dayjs';
import Holidays_Lists from "./Holidays_Lists.vue";
import Holidays_Master from "./Holidays_Master.vue";
// import CreateNewHolidaysList from "./CreateNewHolidaysList.vue";
import { useHolidayStore } from "../attendance_settings/stores/HolidayStore";

const useStore = useHolidayStore();



onMounted(async () => {
    await useStore.getCreateNewList();
    await useStore.getHolidaylist();
})

</script>

{
    <!--

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
     -->
}
