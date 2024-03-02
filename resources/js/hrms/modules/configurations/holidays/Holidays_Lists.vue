<template>
    <!-- v-if="useStore.activeHolidaysPage === 3" -->
    <div class="p-5 card main-body">

        <div v-if="useStore.activeHolidaysPage === 2">
            <Holidays_Master />
        </div>
        <!-- <div v-if="useStore.activeHolidaysPage === 1">
            <CreateNewHolidaysList />
        </div> -->
        <div class="head-contant d_spc_bt d-flex flex-wrap">
            <h3 class="fs-4 fw-bold mb-3">Holiday Summary</h3>
            <div class="holiday-settings-btns">

                <ul class="d-flex flex-wrap">
                    <!-- <li><button class="cancel_btn text-blue-900 w-30 mb-3"
                            @click="useStore.activeHolidaysPage = 1">Cancel</button></li>
                    <li><button class="view_Lists w-30 mb-3" @click="useStore.activeHolidaysPage = 3">View Lists </button>
                    </li>-->
                    <li>
                        <!-- <button class="add_new_holiday_btn w-33 mb-3" @click="useStore.DialogAddNewHoliday = true"> Add New
                            Holiday</button> -->
                        <button class="add_new_holiday_btn bg-orange-500 text-white"
                            @click="useStore.CreateNewListDialog = true">
                            <i class="pi pi-plus-circle"></i> <span class="fs-6 fw-semibold">Create New List</span></button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- {{useStore.holidayData}} -->
        <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1 xxl:grid-cols-4 xl:grid-cols-4 lg:grid-cols-4"
            style="display: grid;">
            <div v-for="holiday in useStore.holidayData" :key="holiday.id">
                <div class="col w-full mx-4">
                    <div class="m-0 card-title d_spc_bt align-items-center w-full">
                        <h3 class="fs-5">{{ holiday.holiday_name }}</h3>
                        <span class="fs-6"> {{ dayjs(holiday.holiday_date).format('DD-MMM-YYYY') }}</span>
                    </div>

                    <div class="card clr-trans card-w h-48 w-full">

                        <img v-if="holiday.image" class="card-img-top" :src="`data:image/png;base64,${holiday.image}`"
                            srcset="" alt="" />
                        <!-- <div class="overlay">
                            <div class="hover_btn_div d-ard">
                                <button label="Edit" @click="useStore.editHolidaylist(holiday)" class="w-6 fs-6">
                                    Edit
                                </button>
                                <button @click="holidaylistRemoveDialog(holiday)" class="w-8 fs-6 mx-4">Remove</button>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>

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
                        <MultiSelect v-model="useStore.ChooseTheHolidays" :options="useStore.arrayHolidaysList"
                            optionLabel="holiday_name" placeholder="Select Cities" :maxSelectedLabels="3"
                            class="w-full h-12" style="width: 245px !important;" @change="useStore.getHolidayName()" />
                    </div>
                </div>
            </div>
            <template #footer>
                <button class="btn border-orange-400 text-orange-500 fw-semibold py-2 px-5"
                    style="padding:9px 20px !important ;" @click="useStore.CreateNewListDialog = false"> Close</button>
                <!-- <Button label="Cancel" class=" bg-white border-orange-400 text-orange-500  mr-4"
                        @click="useStore.CreateNewListDialog = false" text /> -->
                <!-- <button class="bg-white border-orange-400 text-orange-500  mr-4" @click="useStore.CreateNewListDialog = false" >Cancel</button> -->
                <Button label="Create" class="bg-orange-500 border-none" icon="pi pi-plus-circle"
                    @click="useStore.SubmitCreateNewList" autofocus />
            </template>
        </Dialog>

        <Dialog v-model:visible="useStore.DialogAddNewHoliday" modal header="Holiday " :style="{ width: '25vw' }"
            class="popup_card">
            <div class="card upload_img h-48 w-full rounded-lg" style="height: 150px;min-width: 200px;">

                <img class=" z-0 w-full h-full rounded-lg border-0" :src="useStore.avatar" alt="">
                <div class="img_overlay w-full position-absolute h-full z-10 rounded-lg bottom-0">
                    <label
                        class="position-absolute d-flex justify-items-center align-items-end fs-5 h-10 z-50 text-white cursor-pointer"
                        id="" for="uploadFestivalPhoto" style="bottom: 10px;right: 10px;">
                        <i class="pi pi-upload"></i>
                        <h1 class="pl-2 text-orange-500">upload</h1>
                    </label>
                    <input type="file" name="" id="uploadFestivalPhoto" hidden @change="useStore.FestivalPhoto($event)" />
                </div>



            </div>
            <div class="card-title">
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="username">Festival Title</label>
                    <InputText id="username" class="h-10" v-model="useStore.addNewHoliday.FestivalTitle"
                        aria-describedby="username-help" />
                </div>
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="username">Description</label>
                    <InputText id="username" class="h-10" v-model="useStore.addNewHoliday.Description"
                        aria-describedby="username-help" />
                </div>
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="username">Date</label>
                    <Calendar v-model="useStore.addNewHoliday.date" showIcon class="h-10 form-selects"
                        dateFormat="dd/mm/yy" />
                </div>

            </div>
            <template #footer>
                <button class="btn border-orange-400 text-orange-500 fw-semibold py-2 px-5"
                    style="padding:9px 20px !important ;" @click="useStore.DialogAddNewHoliday = false"> Close</button>
                <Button label="Submit" class="bg-orange-500 border-none" icon="pi pi-check"
                    @click="useStore.sumbitAddNewHoliday" autofocus />
            </template>
        </Dialog>

        <Dialog v-model:visible="useStore.editHoliday" modal header="Holiday " :style="{ width: '25vw' }"
            class="popup_card">
            <div class="img_container upload_img position-relative rounded-lg"
                style="height: 150px;min-width: 200px;box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; ">

                <img v-if="useStore.addNewHoliday.Holiday_Photo" class="card-img-top rounded-lg"
                    :src="`data:image/png;base64,${useStore.addNewHoliday.Holiday_Photo}`" srcset="" alt="" />
                <img v-if="useStore.avatar" class="rounded-lg z-0 position-absolute top-0 left-0" :src="useStore.avatar"
                    alt="" style="height: 150px;min-width: 100%; ">
                <div class="img_overlay w-full position-absolute h-full z-10 rounded-lg bottom-0">
                    <label
                        class="position-absolute d-flex justify-items-center align-items-end fs-5 h-10 z-50 text-orange-500 cursor-pointer"
                        id="" for="uploadFestivalPhoto" style="bottom: 10px;right: 10px;">

                        <i class="pi pi-upload"></i>
                        <h1 class="pl-2 text-orange-500">upload</h1>

                    </label>
                    <input type="file" name="" id="uploadFestivalPhoto" hidden @change="useStore.FestivalPhoto($event)" />
                </div>
            </div>
            <div class="card-title">
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="username">Festival Title</label>
                    <InputText id="username" class="h-10" v-model="useStore.addNewHoliday.FestivalTitle"
                        aria-describedby="username-help" />
                </div>
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="username">Description</label>
                    <InputText id="username" class="h-10" v-model="useStore.addNewHoliday.Description"
                        aria-describedby="username-help" />
                </div>
                <div class="flex gap-2 mt-5 flex-column">
                    <label for="date">Date</label>
                    <Calendar class="form-selects h-10" v-model="useStore.addNewHoliday.date" showIcon
                        dateFormat="dd-mm-yy" />
                </div>

            </div>
            <template #footer>
                <button class="btn border-orange-400 text-orange-500 fw-semibold py-2 px-5"
                    style="padding:9px 20px !important ;" @click="useStore.editHoliday = false"> Close</button>
                <!-- <Button label="Close" class="btn border-orange-400  text-blue-900" autofocus
                    style="color: orange !important;"  /> -->
                <Button label="Submit" class="btn bg-orange-500 border-none" icon="pi pi-check"
                    @click="useStore.sumbiteditHoliday(useStore.holidayData)" autofocus />

            </template>
        </Dialog>

        <Dialog header="Confirmation" v-model:visible="showconfirmationdialog"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content">

                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to remove this holiday ? </span>
            </div>

            <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

                <Button class="btn-primary py-2 mx-2" label="Yes" icon="pi pi-check" :style="{ width: '60px' }"
                    @click="removeholidaylist" autofocus />
                <button class="btn btn-orange  d-flex align-items-center" @click="showconfirmationdialog = false"> <i
                        class="px-1 pi pi-times"></i> No</button>
            </div>

        </Dialog>

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

        <!--  -->
    </div>
    <!-- <CreateNewHolidaysList /> -->



    <!-- {{ useStore.holidayData }} -->
    <!-- editHolidaylist -->
</template>


<script setup>
import { ref, onMounted, reactive, computed } from 'vue';
import axios from 'axios'
import { useToast } from "primevue/usetoast";
import dayjs from 'dayjs';
import { useHolidayStore } from "../attendance_settings/stores/HolidayStore";
import Holidays_Master from "./Holidays_Master.vue";
import CreateNewHolidaysList from "./CreateNewHolidaysList.vue";

const useStore = useHolidayStore()

//
const visible = ref(false);

const showconfirmationdialog = ref(false);
const holidayremoveList = ref();

const value = ref(null);
const date = ref();




const toast = useToast();

const onAdvancedUpload = () => {
    toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
};

onMounted(async () => {
    await useStore.getHolidays();
    await useStore.getHolidaylist();
})

function holidaylistRemoveDialog(holiday) {

    holidayremoveList.value = holiday;
    console.log(holidayremoveList.value);
    showconfirmationdialog.value = true;
}

async function removeholidaylist() {
    showconfirmationdialog.value = false;
    // console.log('holidaylist : ',holidayremoveList.value);
    await useStore.RemoveHolidayList(holidayremoveList.value);

}




// function sendimageURL(){

//     axios.post('',form).then(()=>{});
// }
// sendimageURL();


// const uploadFestivalPhoto = (e) => {
//     if (e.target.files && e.target.files[0]) {
//         addNewHoliday.Holiday_Photo = e.target.files[0];
//         console.log(addNewHoliday.Holiday_Photo);
//     }
// }



  // form.append('FestivalTitle', )
    // form.append('Description', addNewHoliday.Description)
    // form.append('date', addNewHoliday.date)
    // form.append('Holiday_Photo', addNewHoliday.Holiday_Photo)
    // {
    //     FestivalTitle:addNewHoliday.FestivalTitle,
    //     Description :addNewHoliday.Description,
    //     date: addNewHoliday.date,
    //     Holiday_Photo: addNewHoliday.Holiday_Photo
    // }






</script>



<style lang="scss">
.bg-orange {
    background: var(--clr-orange);
}

:root {
    --clr-blue: #002f56;
    --clr-orange: rgb(255, 83, 10);
    --clr-drk-gray: #6c757d;
    --clr-gray: #646464;
    --clr-lit-gray: #e2e2e2;
    --clr-med-gray: #c9c9c9;
    --clr-white: #fff;
}

.clr-trans {
    background: transparent !important;
}

.d-flex {
    display: flex;


}

.d_spc_bt {
    display: flex;
    align-content: center;
    justify-content: space-between;
}

li {
    list-style: none;
}

/* .holiday-settings-btns ul {

} */
.holiday-settings-btns ul>li {}

.holiday-settings-btns button {
    padding: 6px 30px;
    border-radius: 4px !important;
    font-weight: 500;
    font-size: 15px;
    font-family: sans-serif;
}

.cancel_btn {
    border: 1px solid var(--clr-orange);
    color: var(--clr-orange);
    background: var(--clr-white);
    margin: 0 10px;
}

.view_Lists {
    background: var(--clr-blue) !important;
    color: var(--clr-white);
    border: 1px solid var(--clr-blue);
    border-radius: 4px !important;
    margin: 0 10px;
}

.add_new_holiday_btn {
    background: var(--clr-orange);
    border: 1px solid var(--clr-orange);
    color: var(--clr-white);
    margin: 0 0 0 10px;
}

.card-title h3 {
    font-weight: 600;
    margin: 0;
}

.card-title span {
    margin: 0;
    color: var(--clr-drk-gray);
    font-size: 14px;
    line-height: 36px;
    font-family: sans-serif;
}

.card-title {
    width: 95%;
}

.cd-img {
    position: relative;
}

.col_w {
    width: 10rem;
    height: 23rem;
    padding: 0;
    margin: 0;
}

.hover_btn_div {
    position: absolute;
    top: 45%;
    left: 23%;
    width: 60%;
    // border: 1px solid white;
}

.hover_btn_div button {
    border: 1px solid var(--clr-white) !important;
    background: transparent;
    color: var(--clr-white);
    padding: 4px 12px;
    font-size: 18px;
    border-radius: 2px;
    visibility: hidden;
}

.d-ard {
    display: flex;
    justify-content: space-around;
    align-content: center;
    // border: 4px solid yellow;
}

.card-img-top {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}

.card-w:hover .hover_btn_div>button {
    visibility: visible;
    cursor: pointer;
    transition: 0.6s ease-in-out !important;
}


.overlay {
    position: absolute;
    width: 100% !important;
    height: 100% !important;
    // border: 4px solid yellow;
}

.card-w:hover .overlay {
    background: rgba(0, 0, 0, 0.349) !important;
    transition: 0.3s ease-in-out;
}

.upload_img:hover .img_overlay {
    background: rgba(0, 0, 0, 0.349) !important;
    transition: 0.3s ease-in-out;

}


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
    color: #fff;
    transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 600;
    padding: 0.5rem;
}

.p-datepicker:not(.p-datepicker-inline) .p-datepicker-header {
    background: #002f56;
    color: black;
}

.p-calendar-w-btn .p-datepicker-trigger {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    background: #002f56;
}

.card-img,
.img_container {
    position: relative;
}

// #file_upload {
// }
.formgrid {
    position: absolute;
    bottom: 20px;
    right: 20px;

    // border: 1px solid ;

    color: #061328;
}

.formgrid label {
    font-size: 20px !important;
    text-decoration: underline;
    color: var(--clr-blue);
    letter-spacing: 2px;
    line-height: 20px;
}
</style>

{

<!-- <template>
    <div class="card flex justify-content-center">
        <Calendar v-model="date" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const date = ref();
</script> -->
}

