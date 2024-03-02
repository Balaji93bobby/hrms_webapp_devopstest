<template>
    <div class="w-full" v-if="_instance_profilePagesStore.employeeDetails.get_employee_details">
        <div class="w-full p-2 bg-white border rounded-lg">
            <div class="flex justify-around">
                <p class="text-sm font-semibold">General Information</p>
                <div class="flex justify-end ">
                    <!-- <p class="p-1 text-xs font-semibold border rounded-full whitespace-nowrap">
                    Edit -->
                    <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto mb-1 cursor-pointer" alt=""
                        @click="canshowSidebar(true, 'General Information')">

                    <!-- </p> -->
                </div>
            </div>

            <div class="grid h-full grid-cols-12 gap-2 py-2">
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Date of Birth</p>
                    <p class="text-sm font-semibold">
                        {{ dayjs(_instance_profilePagesStore.employeeDetails.get_employee_details.dob).format('DD-MMM-YYYY')
                        }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Gender</p>
                    <p class="text-sm font-semibold">
                        {{
                            fetch_data.capitalizeFLetter(_instance_profilePagesStore.employeeDetails.get_employee_details.gender)
                        }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Date Of Joining (DOJ)</p>
                    <p class="text-sm font-semibold">
                        {{ dayjs(_instance_profilePagesStore.employeeDetails.get_employee_details.doj).format('DD-MMM-YYYY')
                        }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Marital Status</p>
                    <p class="text-sm font-semibold"> {{
                        _instance_profilePagesStore.employeeDetails.get_employee_details.marital_status }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Blood Group</p>
                    <p class="text-sm font-semibold"> {{
                        _instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_name }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Physically Handicapped</p>
                    <p class="text-sm font-semibold">{{
                        fetch_data.capitalizeFLetter(_instance_profilePagesStore.employeeDetails.get_employee_details.physically_challenged)
                    }}</p>
                </div>

            </div>

        </div>
        <div class="w-full p-2 my-3 bg-white border rounded-lg">
            <div class="flex justify-around">
                <p class="text-sm font-semibold">Contact Information</p>
                <div class="flex justify-end ">
                    <!-- <p class="p-1 text-xs font-semibold border rounded-full whitespace-nowrap">
                    Edit -->
                    <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto mb-1 cursor-pointer" alt=""
                        @click="canshowSidebar(true, 'Contact Information')">
                    <!-- </p> -->
                </div>
            </div>


            <div class="grid h-full grid-cols-12 gap-4 py-2">
                <div class="col-span-3">
                    <p class="text-xs font-semibold text-gray-500">Personal Email</p>
                    <p class="text-sm font-semibold"> {{ _instance_profilePagesStore.employeeDetails.email ?
                        _instance_profilePagesStore.employeeDetails.email : '-' }}</p>
                </div>
                <div class="col-span-3">
                    <p class="text-xs font-semibold text-gray-500">Official Email</p>
                    <p class="text-sm font-semibold">{{
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.officical_mail ?
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.officical_mail : '-' }}</p>
                </div>
                <div class="col-span-3">
                    <p class="text-xs font-semibold text-gray-500">Mobile Number</p>
                    <p class="text-sm font-semibold">{{
                        _instance_profilePagesStore.employeeDetails.get_employee_details.mobile_number ?
                        _instance_profilePagesStore.employeeDetails.get_employee_details.mobile_number : '-' }}</p>
                </div>
                <div class="col-span-3">
                    <p class="text-xs font-semibold text-gray-500">Official Mobile Number</p>
                    <p class="text-sm font-semibold"> {{
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.official_mobile ?
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.official_mobile : '-' }}</p>
                </div>
            </div>

        </div>
        <div class="w-full p-2 bg-white border rounded-lg">
            <div class="flex justify-around">
                <p class="text-sm font-semibold">Address</p>
                <div class="flex justify-end ">
                    <!-- <p class="p-1 text-xs font-semibold border rounded-full whitespace-nowrap">
                    Edit -->
                    <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto mb-1 cursor-pointer" alt=""
                        @click="canshowSidebar(true, 'Address Information')">

                    <!-- </p> -->
                </div>
            </div>


            <div class="grid h-full grid-cols-12 gap-4 py-2">
                <div class="col-span-6">
                    <p class="text-xs font-semibold text-gray-500">Current Address</p>
                    <p class="text-sm font-semibold">
                        {{ _instance_profilePagesStore.employeeDetails.get_employee_details.current_address_line_1 ?
                            _instance_profilePagesStore.employeeDetails.get_employee_details.current_address_line_1 : '-' }}</p>
                </div>
                <div class="col-span-6">
                    <p class="text-xs font-semibold text-gray-500">Permanent Address </p>
                    <p class="text-sm font-semibold">
                        {{ _instance_profilePagesStore.employeeDetails.get_employee_details.permanent_address_line_1 ?
                            _instance_profilePagesStore.employeeDetails.get_employee_details.permanent_address_line_1 : '-' }}
                    </p>
                </div>

            </div>

        </div>
    </div>




    <Sidebar v-model:visible="visible_dialog" position="right" class=" w-[500px]">
        <div class="" v-if="InformationType == 'General Information'">
            <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">General Information</h1>
            </div>
            <div class=" bg-[#FFE2E2] !w-[100%]  p-[20px] ">
                <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] ">Uploading and verifying documents
                    is required to change the DOB</span></p>
            </div>

            <div class="font-['poppins'] p-2 w-[100%] ">
                <div class="my-2">
                    <label class=" mb-1  text-[12px]">Birth Date<span class="text-danger">*</span>
                    </label>
                    <Calendar class=" relative right-2 w-[100%] h-10 " v-model="dialog_general_information.dob"
                        placeholder="DD-MM-YYYY" dateFormat="dd-M-yy" />
                </div>
                <div class="my-2 ">
                    <label class=" text-[12px]">Gender<span class="text-danger">*</span></label>
                    <Dropdown v-model="dialog_general_information.gender" :options="options_gender" optionLabel="name"
                        optionValue="value" placeholder="Choose Gender" class=" h-10  w-[100%]" />
                </div>
                <div class="my-2">
                    <label class=" text-[12px]">Marital status <span class="text-danger">*</span></label>
                    <Dropdown v-model="dialog_general_information.marital_status_id" :options="option_maritals_status"
                        optionLabel="name" optionValue="id" placeholder="Select Marital Status" class="h-10 w-[100%]" />
                </div>
                <div class="my-2">
                    <label class=" text-[12px]">Blood Group<span class="text-danger">*</span></label>
                    <Dropdown v-model="dialog_general_information.blood_group_id" :options="options_blood_group"
                        optionLabel="name" optionValue="id" placeholder="Select Bloodgroup" class=" w-[100%] h-10" />

                </div>
                <div class="my-2">
                    <label class="my-1  text-[12px]">Physically Handicapped</label>
                    <Dropdown v-model="dialog_general_information.physically_challenged" :options="options_phy_challenged"
                        optionLabel="name" optionValue="value" placeholder="Select" class="w-[100%] h-10" />
                </div>

                <div class="flex justify-center ">
                    <button class=" bg-[#000] text-[#ffff] px-4 p-2 rounded-md mt-[130px]"
                        @click="saveGeneralInformationDetails()">Save</button>

                </div>
            </div>


        </div>

        <div v-if="InformationType == 'Contact Information'" class="">
            <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4  text-[#ffff] font-['poppins'] font-semibold ">Contact Information</h1>
            </div>

            <div class="p-2 bg-[#FFE2E2] !w-[100.5%] relative   ">
                <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] "> You can change your
                        Official/Personal Mobile Number and Official/Personal Mail ID.</span></p>
            </div>

            <div class="p-2 font-['poppins']">
                <div class="my-2 ">
                    <label class=" mb-1  text-[12px]">Personal Email</label>
                    <input type="email" name="present_email" class="form-control" v-model="dailog_contactinfo.email">
                </div>

                <div class="my-2">
                    <label class="mb-1  text-[12px]">Office Email</label>
                    <input type="email" class="h-10 form-control" name="officical_mail"
                        v-model="dailog_contactinfo.official_email">
                </div>

                <div class="my-1">
                    <label class=" mb-2  text-[12px]">Mobile Number</label>
                    <InputMask id="basic" class="h-10 form-control" v-model="dailog_contactinfo.mobile_number"
                        mask="9999999999" placeholder="999999999" />
                </div>
                <div class="my-2">
                    <label class="mb-1  text-[12px]">Official Mobile Number</label>
                    <InputMask id="basic" class="h-10 form-control" v-model="dailog_contactinfo.official_mobile_number"
                        mask="9999999999" placeholder="999999999" />
                </div>

                <div class="absolute flex items-center !justify-center bottom-7 left-[30%] ">
                    <button class=" border-[1px] border-[#000] px-4 mx-2  h-[30px] rounded-md" @click="visible_dialog= false">cancel</button>
                    <button class=" bg-[#000] text-[#ffff] px-4 p-2 rounded-md h-[30px]"
                        @click="save_contactinfoDetails">Save</button>
                </div>

            </div>

        </div>

        <div v-if="InformationType == 'Address Information'" class="">
            <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Address Details</h1>
            </div>
            <div class="p-2 bg-red-200 !w-[100%]   ">
                <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class="text-gray-500 ">You can change your Current and
                        Permanent Address here.</span></p>
            </div>

            <div class="mt-3 font-['poppins'] col-md-12 p-2 ">
                <div class="mb-3 form-group">
                    <label class=" text-[12px]">Current Address</label>
                    <textarea name="current_address_line_1" id="current_address_line_1" cols="30" rows="3"
                        class="form-control" v-model="diolog_Addressinfo.current_address"></textarea>
                </div>
                <div class="mb-3 form-group">
                    <label class=" text-[12px]">Permanent Address </label>
                    <textarea name="permanent_address_line_1" id="permanent_address_line_1" cols="30" rows="3"
                        class="form-control" v-model="diolog_Addressinfo.Permanent_Address"></textarea>
                </div>
                <div class="mb-3 form-group">
                    <div class=" d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="border rounded-md" v-model="CopyAddress"
                            style="width: 20px; height: 20px;" @change="copyAddress" :value="1">
                        <h1 class="mx-2">Copy current address to the permanent address</h1>
                    </div>
                </div>

                <div class="absolute flex items-center !justify-center bottom-7 left-[30%] ">
                    <button class=" border-[1px] border-[#000] px-4 mx-2  h-[30px] rounded-md" @click="visible_dialog= false">cancel</button>
                    <button class=" bg-[#000] text-[#ffff] px-4 p-2 h-[30px] rounded-md "
                        @click="saveAddressinfoDetails()">Save</button>
                </div>


            </div>


        </div>

    </Sidebar>
</template>

<script setup>
import dayjs from 'dayjs';
import { ref, onMounted, reactive, computed } from "vue";
import moment from "moment";
import { useNow, useDateFormat } from '@vueuse/core'
import axios from "axios";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";


import { Service } from "../../Service/Service";
import { profilePagesStore } from '../stores/ProfilePagesStore'

const fetch_data = Service()
const _instance_profilePagesStore = profilePagesStore()

const canShowLoading = ref(false)

const toast = useToast();
const Addresstoast = useToast();

const is_dialog_generalInfo_visible = ref(false);
const ContactVisible = ref(false);
const addressVisible = ref(false);


const InformationType = ref();

const visible_dialog = ref(false);

function canshowSidebar(val, type) {

    visible_dialog.value = val;
    InformationType.value = type;

    if (type == 'General Information') {
        onClick_EditButton_GeneralInfo();
    }
    else if (type == 'Contact Information') {
        onClick_EditButtonContacttInfo();
    }
    else if (type == 'Address Information') {
        onClick_EditButtonAddressInfo();
    }

}



//Used inside dialog elements
const dialog_general_information = reactive({
    dob: '',
    gender: '',
    doj: '',
    blood_group_id: '',
    marital_status_id: '',
    physically_challenged: ''
});

const options_gender = ref([
    { name: "Male", value: "male" },
    { name: "Female", value: "female" },
    { name: "Others", value: "others" },
]);

// contact details
const contact_details = ref();

const dailog_contactinfo = reactive({
    email: "",
    official_email: "",
    mobile_number: "",
    official_mobile_number: ""

});

//  Address details //

const addressUpdateDetails = ref();

const diolog_Addressinfo = reactive({
    current_address: "",
    Permanent_Address: ""
});

const CopyAddress = ref(false);

function copyAddress() {
    if (CopyAddress.value == 1) {
        diolog_Addressinfo.Permanent_Address = diolog_Addressinfo.current_address;
    }
    else {
        CopyAddress.value = false;
    }
}


const computedGenderValue = computed(() => {
    if (_instance_profilePagesStore.employeeDetails.get_employee_details.gender == 'male')
        return "Male";
    else
        if (_instance_profilePagesStore.employeeDetails.get_employee_details.gender == 'female')
            return "Female";
        // return ""
        else
            if (_instance_profilePagesStore.employeeDetails.get_employee_details.gender == 'others')
                return "Others";

            else
                return "-"

})
const computedMarital_StatusValue = computed(() => {

    return _instance_profilePagesStore.employeeDetails.get_employee_details.marital_status;

})
const cmpBldGrp = computed(() => {
    if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 1) return "A Positive";

    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 2) return "A Negative";
    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 3) return "B Positive";

    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 4) return "B Negative";


    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 5) return "AB Positive";

    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 6) return "AB Negative";

    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 7) return "O Positive";

    else if (_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id == 8) return "O Negative";

})

const computedPhy_challenged = computed(() => {

    if (_instance_profilePagesStore.employeeDetails.get_employee_details.physically_challenged == "no") return "No";

    if (_instance_profilePagesStore.employeeDetails.get_employee_details.physically_challenged == "yes") return "Yes";

})

const options_phy_challenged = ref([
    { name: "Yes", value: "yes" },
    { name: "No", value: "no" },
]);

const options_blood_group = ref();
const option_maritals_status = ref();

const confirm = useConfirm();


onMounted(() => {

    _instance_profilePagesStore.fetchEmployeeDetails();
    fetch_data.getBloodGroups().then((result) => {
        console.log(result.data);
        options_blood_group.value = result.data;
    });

    fetch_data.getMaritalStatus().then((result) => {
        console.log(result);
        option_maritals_status.value = result.data;
    });

    //_instance_profilePagesStore

});

function onClick_EditButton_GeneralInfo() {
    console.log("Opening General Info Dialog");

    // Assign json values into dialog elements also

    dialog_general_information.dob = _instance_profilePagesStore.employeeDetails.get_employee_details.dob;

    dialog_general_information.doj = _instance_profilePagesStore.employeeDetails.get_employee_details.doj;

    dialog_general_information.marital_status_id = parseInt(_instance_profilePagesStore.employeeDetails.get_employee_details.marital_status_id);
    // dialog_general_information.marital_status_id =4;

    dialog_general_information.gender = _instance_profilePagesStore.employeeDetails.get_employee_details.gender;

    dialog_general_information.blood_group_id = parseInt(_instance_profilePagesStore.employeeDetails.get_employee_details.blood_group_id);

    // dialog_general_information.blood_group_id = 3;
    dialog_general_information.physically_challenged = _instance_profilePagesStore.employeeDetails.get_employee_details.physically_challenged;

}



function saveGeneralInformationDetails() {
    console.log(dialog_general_information);

    canShowLoading.value = true;

    let id = fetch_data.current_user_id
    let url = `/profile-pages-update-generalinfo/${id}`;

    axios.post(url, {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        dob: dayjs(dialog_general_information.dob).format('YYYY-MM-DD'),
        gender: dialog_general_information.gender,
        marital_status_id: dialog_general_information.marital_status_id,
        doj: dialog_general_information.doj,
        blood_group_id: dialog_general_information.blood_group_id,
        physically_challenged: dialog_general_information.physically_challenged,
    })
        .then((res) => {

            if (res.data.status == "success") {
                _instance_profilePagesStore.employeeDetails.get_employee_details.dob = useDateFormat(dialog_general_information.dob, 'YYYY-MM-DD');
                _instance_profilePagesStore.employeeDetails.gender = dialog_general_information.gender;
                _instance_profilePagesStore.employeeDetails.marital_status_id = dialog_general_information.marital_status_id;
                // _instance_profilePagesStore.employeeDetails.doj = dialog_general_information.doj;
                _instance_profilePagesStore.employeeDetails.get_employee_details.doj = dialog_general_information.doj;
                _instance_profilePagesStore.employeeDetails.blood_group_id = dialog_general_information.blood_group_id;
                _instance_profilePagesStore.employeeDetails.physically_challenged = dialog_general_information.physically_challenged;
            } else if (res.data.status == "failure") {
                leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails(fetch_data.current_user_id)
            canShowLoading.value = false;
            visible_dialog.value = false;
            toast.add({ severity: 'success', summary: 'Updated', detail: 'General information updated', life: 3000 });
        });


    // window.location.reload();

}



function onClick_EditButtonContacttInfo() {
    console.log("Opening General Info Dialog : ");

    // Assign json values into dialog elements also

    dailog_contactinfo.email = _instance_profilePagesStore.employeeDetails.email;
    dailog_contactinfo.official_email = _instance_profilePagesStore.employeeDetails.get_employee_office_details.officical_mail;
    dailog_contactinfo.mobile_number = parseInt(_instance_profilePagesStore.employeeDetails.get_employee_details.mobile_number);
    if (!_instance_profilePagesStore.employeeDetails.get_employee_office_details.official_mobile) {
        dailog_contactinfo.official_mobile_number = 0;
    } else {
        dailog_contactinfo.official_mobile_number = parseInt(_instance_profilePagesStore.employeeDetails.get_employee_office_details.official_mobile);
    }


}

function save_contactinfoDetails() {
    let id = fetch_data.current_user_id
    let url = `/profile-pages-update-contactinfo/${id}`;
    canShowLoading.value = true;

    axios.post(url, {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        email: dailog_contactinfo.email,
        officical_mail: dailog_contactinfo.official_email,
        mobile_number: dailog_contactinfo.mobile_number,
        official_mobile_number: dailog_contactinfo.official_mobile_number
    })
        .then((res) => {

            if (res.data.status == "success") {
                toast.add({ severity: 'success', summary: 'Updated', detail: 'Contact information updated', life: 3000 });
                _instance_profilePagesStore.employeeDetails.email = dailog_contactinfo.email
                _instance_profilePagesStore.employeeDetails.get_employee_office_details.officical_mail = dailog_contactinfo.official_email
                _instance_profilePagesStore.employeeDetails.get_employee_details.mobile_number = dailog_contactinfo.mobile_number
                _instance_profilePagesStore.employeeDetails.get_employee_office_details.official_mobile = dailog_contactinfo.official_mobile_number

            } else if (res.data.status == "failure") {
                contact_details.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails();
            canShowLoading.value = false;
            visible_dialog.value = false;
        })

}





function onClick_EditButtonAddressInfo() {
    console.log("Opening General Info Dialog");

    // Assign json values into dialog elements also

    diolog_Addressinfo.current_address = _instance_profilePagesStore.employeeDetails.get_employee_details.current_address_line_1;
    diolog_Addressinfo.Permanent_Address = _instance_profilePagesStore.employeeDetails.get_employee_details.permanent_address_line_1;


}

const saveAddressinfoDetails = () => {
    canShowLoading.value = true;

    if (diolog_Addressinfo.current_address == " " || diolog_Addressinfo.Permanent_Address == " ") {
        Addresstoast.add({ severity: 'warn', summary: 'Warn Message', detail: 'Message Content', life: 3000 });
    }
    else {
        let id = fetch_data.current_user_id
        let url = `/profile-pages-update-address_info/${id}`;

        axios.post(url, {
            user_code: _instance_profilePagesStore.employeeDetails.user_code,
            current_address_line_1: diolog_Addressinfo.current_address,
            permanent_address_line_1: diolog_Addressinfo.Permanent_Address

        })
            .then((res) => {
                data_checking.value = false;
                if (res.data.status == "success") {
                    toast.add({ severity: 'success', summary: 'Updated', detail: 'Address information updated', life: 3000 });
                    _instance_profilePagesStore.employeeDetails.current_address_line_1 = diolog_Addressinfo.current_address
                    _instance_profilePagesStore.employeeDetails.get_employee_office_details.permanent_address_line_1 = diolog_Addressinfo.Permanent_Address

                } else if (res.data.status == "failure") {
                    addressUpdateDetails.leave_request_error_messege = res.data.message;
                }
            })
            .catch((err) => {
                console.log(err);
            }).finally(() => {
                _instance_profilePagesStore.fetchEmployeeDetails();
                canShowLoading.value = false;
                visible_dialog.value = false;
            })
    }

}


</script>


<style>
.p-inputtext,
.p-placeholder,
.p-dropdown-label
{
    position: relative !important;
    top: -4px !important;
}
</style>
