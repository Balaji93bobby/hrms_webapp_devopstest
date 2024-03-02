<template>
    <div class="mb-2 ">
        <div class="">
            <h6 class="text-lg font-semibold">Family Information
                <button type="button" class="float-right border-[1px] py-0 bg-blue-200 border-[#000] text-[13px] px-2 rounded-md"
                    @click="DialogFamilyinfovisible = true">
                   + Add
                </button>
                <!-- <button type="" class="float-right border-[1px] border-[#000] text-[12px] px-2 p-1 rounded-lg "
                @click="DialogFamilyinfovisible = true">
           +
        </button> -->
                <!-- v-model:visible="DialogFamilyinfovisible" -->

                <Dialog modal :style="{ width: '50vw', borderTop: '5px solid #002f56' }" id="">
                    <template #header>
                        <div>
                            <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                                class="fw-bold fs-15">
                                Family Information</h5>
                        </div>
                    </template>

                    <div class="grid grid-cols-2">
                        <div class=" mr-[10px] ml-[8px]">
                            <span>Name <span class="text-danger">*</span></span>
                            <InputText type="text" v-model="familydetails.name" class="w-[94%] h-10" />
                        </div>
                        <div class="">
                            <span>Relationship<span class="text-danger">*</span></span>
                            <InputText type="text" v-model="familydetails.relationship" class="w-[90%] h-10" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 ">
                        <div class="mr-2">
                            <span>Date of birth <span class="text-danger">*</span></span>
                            <Calendar dateFormat="dd-M-yy" v-model="familydetails.dob" class="h-10 w-[98%]"
                                :minDate="minDate" :maxDate="maxDate" />
                            <!-- <input type="date" id="datemin" name="familyDetails_dob[]" min="2000-01-02" > -->
                        </div>

                        <div class="ml-1">
                            <span>Phone<span class="text-danger">*</span></span>

                            <InputMask id="basic" mask="9999999999" placeholder="9999999999" class="h-10"
                                v-model="familydetails.phone_number" />
                        </div>
                    </div>



                    <template #footer>
                        <Toast />
                        <div>
                            <button type="button" class="submit_btn warning success" id="submit_button_family_details"
                                @click="saveFamilyDetails">submit</button>
                        </div>

                    </template>


                </Dialog>





            </h6>
            <!-- {{ _instance_profilePagesStore.employeeDetails.get_family_details }} -->
            <div class="my-6 table-responsive">
                <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10"
                    :value="_instance_profilePagesStore.employeeDetails.get_family_details"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                    responsiveLayout="scroll" class="z-0 ">

                    <Column header="Name" field="name" style="min-width: 8rem">
                    </Column>

                    <Column field="relationship" header="Relationship" style="min-width: 12rem">
                    </Column>

                    <Column field="dob" header="Date of Birth " style="min-width: 12rem">
                        <template #body="slotProps">
                            <div v-if="slotProps.data.dob == 'Invalid Date'">
                                -
                            </div>
                            <div v-else>
                                {{ dayjs(slotProps.data.dob).format('DD-MMM-YYYY') }}
                            </div>
                        </template>
                    </Column>
                    <Column field="phone_number" header="Phone" style="min-width: 12rem">
                    </Column>
                    <!-- <Column :exportable="false" header="Action" style="min-width:20rem">
                        <template #body="slotProps">

                            <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                                @click="diolog_EditFamilyDetails(slotProps.data)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                            </button>
                            <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                                @click="diolog_DeleteFamilyDetails(slotProps.data)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </template>
                    </Column> -->

                    <Column header="Action">
                        <template #body="slotProps">
                            <div class="relative flex justify-center">
                                <button class="" type="button" @click="toggle"> <i class="pi pi-ellipsis-v" @click="selectedrow= slotProps.data" ></i>
                                </button>
                                <OverlayPanel ref="op">
                                    <div class="flex flex-col w-40 py-1 bg-white rounded-lg shadow-2xl">
                                        <div class="p-0 m-0 d-flex flex-column ">
                                            <button class="p-2 text-lg font-semibold text-black divide-x hover:bg-gray-200"
                                                @click="diolog_DeleteFamilyDetails(slotProps.data)">delete</button>
                                            <button class="p-2 text-lg font-semibold text-black hover:bg-gray-200"
                                                @click="diolog_EditFamilyDetails(slotProps.data)">View</button>
                                        </div>
                                    </div>
                                </OverlayPanel>
                            </div>

                        </template>



                    </Column>


                </DataTable>

            </div>

        </div>
    </div>

    <Sidebar v-model:visible="DialogFamilyinfovisible" position="right" class=" relative w-[500px] ">
        <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
            <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Family Information</h1>
        </div>

        <div class="p-2 bg-[#FFE2E2] !w-[100%] ">
            <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] "> You can add/edit your bank details here.</span></p>
        </div>
        <div class="p-2 font-['poppins']">
            <div class="my-2">
                <span>Name <span class="text-danger">*</span></span>
                <InputText type="text" v-model="familydetails.name" class="w-[94%] h-10 mt-2" />
            </div>
            <div class="my-2">
                <span>Relationship<span class="text-danger">*</span></span>
                <InputText type="text" v-model="familydetails.relationship" class="w-[90%] h-10 mt-2" />
            </div>
            <div class="my-2">
                <span>Date of birth <span class="text-danger">*</span></span>
                <!-- <Calendar dateFormat="dd-M-yy" v-model="familydetails.dob" class="h-10 w-[100%] relative right-2 mt-2 "
                    :minDate="minDate" :maxDate="maxDate" /> -->
                    <Calendar dateFormat="dd-M-yy" v-model="familydetails.dob" class="h-10 w-[100%] relative right-2 mt-2 " :minDate="minDate" :maxDate="maxDate" :manualInput="false" />
            </div>
            <div class="my-2">
                <span>Phone<span class="text-danger">*</span></span>
                <InputMask id="basic" mask="9999999999" placeholder="9999999999" class="h-10 mt-2 "
                    v-model="familydetails.phone_number" />
            </div>
        </div>

        <!-- <template > -->
        <div class="flex justify-center my-4 ">
            <Toast />
            <div class="absolute bottom-7 left-[30%]">
                <button class=" px-4 p-2  border-[1px] border-[#000] text-[#000]  rounded-lg mx-2"
                    @click="DialogFamilyinfovisible = false">Cancel</button>
                <button class=" px-4 p-2 bg-[#000]  text-[white] mt-[240px] rounded-lg"
                    @click="saveFamilyDetails">submit</button>
            </div>
        </div>
        <!-- </template> -->


    </Sidebar>



    <Sidebar v-model:visible="DialogEditInfovisible" position="right" class=" relative w-[500px] ">
        <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
            <h1 class=" m-4  text-[#ffff] font-['poppins'] font-semibold ">Family Information </h1>
        </div>

        <div class="p-2 bg-[#FFE2E2] !w-[100%] ">
            <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] "> You can add/edit your bank details here.</span></p>
        </div>
        <div class="p-2 font-['poppins']  ">
            <div class="my-2">
                <span>Name <span class="text-danger">*</span></span>
                <InputText type="text" v-model="Editfamilydetails.name" class="h-10 w-[100%]  mt-2 " />
            </div>
            <div class="my-2 ">
                <span>Relationship<span class="text-danger">*</span></span>
                <InputText type="text" v-model="Editfamilydetails.relationship" class="h-10 w-[100%] mt-2 " />
            </div>
            <div class="my-2 ">
                <span>Date of birth <span class="text-danger">*</span></span>
                <Calendar v-model="Editfamilydetails.dob" dateFormat="dd-M-yy" min="2000-01-02"  class="w-[100%] h-10 relative right-2 mt-2" />
            </div>
            <!-- {{ Editfamilydetails }} -->
            <div class="my-2">
                <span>phone<span class="text-danger">*</span></span>
                <InputMask id="basic" v-model="Editfamilydetails.phone_number" mask="9999999999" placeholder="999999999"
                    class="h-10 w-[100%] mt-2" />
            </div>
        </div>

        <!-- <template > -->
        <div class="flex justify-center my-4 ">
            <Toast />
            <div  class="absolute bottom-7 left-[30%]">
                  <button class=" px-4 p-2 border-[1px] border-[#000] text-[#000]  rounded-lg mx-2"
                    @click="DialogEditInfovisible = false">Cancel</button>

                <button class=" px-4 p-2 bg-[#000]  text-[white]  rounded-lg"
                    @click="EditFamilyDetails">submit</button>
            </div>
        </div>
        <!-- </template> -->


    </Sidebar>

</template>
<script setup>
import dayjs from 'dayjs';
import { useNow, useDateFormat } from '@vueuse/core'
import { ref, onMounted, reactive, onUpdated } from 'vue';
import axios from 'axios'
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import { profilePagesStore } from '../stores/ProfilePagesStore'

const fetch_data = Service()

const _instance_profilePagesStore = profilePagesStore()

const toast = useToast();

const PersonalDocument = ref('');
const DialogFamilyinfovisible = ref(false);

const op = ref();
const toggle = (event) => {
    op.value.toggle(event);
    console.log(event,'event');
}

const  selectedrow = ref();

const DialogEditInfovisible = ref(false);

const familydetails = reactive({
    name: '',
    relationship: '',
    dob: '',
    phone_number: ''
})
const Editfamilydetails = reactive({
    name: '',
    relationship: '',
    dob: '',
    phone_number: ''
});

const current_table_id = ref()


const saveFamilyDetails = () => {
    _instance_profilePagesStore.loading_screen = true

    //    if(familydetails.name == ''  || familydetails.dob == '' || familydetails.relationship == '' || familydetails.phone_number == " " ){
    //     toast.add({ severity: 'warn', summary: 'Warn Message', detail: 'Message Content', life: 3000 });
    //    }else{
    let id = fetch_data.current_user_id
    let url = `/add-family-info/${id}`;

    axios.post(url, {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        name: familydetails.name,
        relationship: familydetails.relationship,
        dob: dayjs(familydetails.dob).format('YYYY-MM-DD'),
        phone_number: familydetails.phone_number
    })
        .then((res) => {

            if (res.data.status == "success") {

                toast.add({ severity: 'success', summary: 'Updated', detail: 'Family information updated', life: 3000 });
                _instance_profilePagesStore.employeeDetails.get_family_details.dob = useDateFormat(familydetails.dob, 'YYYY-MM-DD');

                // _instance_profilePagesStore.employeeDetails.dob = dialog_general_information.dob;

                _instance_profilePagesStore.employeeDetails.get_family_details.name = familydetails.gender;
                _instance_profilePagesStore.employeeDetails.get_family_details.relationship = familydetails.relationship;

                // _instance_profilePagesStore.employeeDetails.doj = dialog_general_information.doj;
                _instance_profilePagesStore.employeeDetails.get_family_details.phone_number = familydetails.phone_number;
            } else if (res.data.status == "failure") {
                // leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails();
            _instance_profilePagesStore.loading_screen = false
        });
    // window.location.reload();
    DialogFamilyinfovisible.value = false;
}


// }

const diolog_EditFamilyDetails = () => {

    DialogEditInfovisible.value = true;

    // let family = selectedrow.value;
    // console.log(family,'family');
    console.log(selectedrow,'selectedrow');

    current_table_id.value = selectedrow.value.id;

    Editfamilydetails.name = selectedrow.value.name
    Editfamilydetails.relationship = selectedrow.value.relationship
    Editfamilydetails.dob = selectedrow.value.dob
    Editfamilydetails.phone_number = selectedrow.value.phone_number


};

const diolog_DeleteFamilyDetails = (family) => {
    _instance_profilePagesStore.loading_screen = true

    current_table_id.value = selectedrow.value.id

    let id = fetch_data.current_user_id
    let url = ` /delete-family-info/${id}`;

    axios.post(url, {
        current_table_id: current_table_id.value,
    })
        .then((res) => {

            if (res.data.status == "success") {
                //  window.location.reload();
                toast.add({ severity: 'success', summary: 'Deleted', detail: 'General information updated', life: 3000 });
                _instance_profilePagesStore.employeeDetails.get_family_details.dob = useDateFormat(familydetails.dob, 'YYYY-MM-DD');

                // _instance_profilePagesStore.employeeDetails.dob = dialog_general_information.dob;

                _instance_profilePagesStore.employeeDetails.get_family_details.name = familydetails.gender;
                _instance_profilePagesStore.employeeDetails.get_family_details.relationship = familydetails.relationship;

                // _instance_profilePagesStore.employeeDetails.doj = dialog_general_information.doj;
                _instance_profilePagesStore.employeeDetails.get_family_details.phone_number = familydetails.phone_number;
            } else if (res.data.status == "failure") {
                leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.loading_screen = false;
            _instance_profilePagesStore.fetchEmployeeDetails();
        })


}

const EditFamilyDetails = (user) => {
    _instance_profilePagesStore.loading_screen = true
    // console.log(id);
    let id = fetch_data.current_user_id
    let url = `/update-family-info/${id}`;
    axios.post(url, {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        current_table_id: current_table_id.value,
        name: Editfamilydetails.name,
        relationship: Editfamilydetails.relationship,
        dob: dayjs(Editfamilydetails.dob).format('YYYY-MM-DD'),
        phone_number: Editfamilydetails.phone_number
    })
        .then((res) => {

            if (res.data.status == "success") {

                toast.add({ severity: 'success', summary: 'Updated', detail: 'General information updated', life: 3000 });
                _instance_profilePagesStore.employeeDetails.get_family_details.dob = useDateFormat(Editfamilydetails.dob, 'YYYY-MM-DD');

                // _instance_profilePagesStore.employeeDetails.dob = dialog_general_information.dob;

                _instance_profilePagesStore.employeeDetails.get_family_details.name = Editfamilydetails.gender;
                _instance_profilePagesStore.employeeDetails.get_family_details.relationship = familydetails.relationship;

                // _instance_profilePagesStore.employeeDetails.doj = dialog_general_information.doj;
                _instance_profilePagesStore.employeeDetails.get_family_details.phone_number = Editfamilydetails.phone_number;
            } else if (res.data.status == "failure") {
                leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails();
            _instance_profilePagesStore.loading_screen = false
        })
    // window.location.reload();
    DialogEditInfovisible.value = false;
}




onMounted(() => {

})


</script>


<style lang="scss">
#file_upload {
    display: inline-block;
    background-color: #003056;
    color: white;
    padding: 0.5rem;
    font-family: sans-serif;
    border-radius: 0.3rem;
    cursor: pointer;
    margin-top: 1rem;
    width: 100%;
    height: 40px;
    font-weight: 700;
    text-align: center;
}

.p-calendar .p-inputtext .p-inputwrapper .p-component {
    flex: 1 1 auto;
    width: 1%;
    background: rebeccapurple;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component::-webkit-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component:-ms-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}

.p-calendar .p-inputwrapper .p-inputtext .p-component::-ms-input-placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
}



:-ms-input-placeholder {
    /* Internet Explorer 10-11 */
    color: red;
}

::-ms-input-placeholder {
    /* Microsoft Edge */
    color: red;
}




.p-button {
    height: 2.5em;
}

.p-button .p-fileupload-choose {
    height: 2.1em;
}

i,
span,
.tabview-custom {
    vertical-align: middle;
}

span {
    margin: 0 .5rem;
}

.AadharCardFront {
    margin-left: 20px;
}

.label {
    width: 170px;
}

.p-tabview p {
    line-height: 1.5;
    margin: 0;
}

.p-dialog .p-dialog-header .p-dialog-title {
    font-weight: 700;
    font-size: 1.25rem;
    color: #002f56;
}

.p-sidebar-right .p-sidebar
{
    width: 30% !important;
    height: 100%;
}
</style>
