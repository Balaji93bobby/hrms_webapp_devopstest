<template>
    <Toast />
    <div class="grid content-center grid-cols-12 p-3 bg-white border rounded-lg"
        v-if="_instance_profilePagesStore.employeeDetails.get_employee_office_details">
        <div class="grid h-full grid-cols-12 col-span-4 gap-6">
            <div class="col-span-4">
                <!-- <div :class="[_instance_profilePagesStore.employeeDetails.short_name_Color ? _instance_profilePagesStore.employeeDetails.short_name_Color : '', _instance_profilePagesStore.employeeDetails.short_name_Color]" class="flex items-center justify-center w-full h-full rounded-full " v-if="!_instance_profilePagesStore.profile" >
                <p class="text-4xl font-semibold text-center text-white">
                    {{ _instance_profilePagesStore.employeeDetails.user_short_name }}
                </p>
            </div> -->
                <!-- {{ _instance_profilePagesStore.profile }} -->
                <div class="profile-pic">

                    <img v-if="_instance_profilePagesStore.profile" class="forRounded"
                        :src="`data:image/png;base64,${_instance_profilePagesStore.profile}`" srcset="" alt="" id="output"
                        width="200" />
                    <p v-else
                        class="flex items-center justify-center text-5xl font-semibold text-center text-white forRounded"
                        :class="[_instance_profilePagesStore.employeeDetails.short_name_Color ? _instance_profilePagesStore.employeeDetails.short_name_Color : '', _instance_profilePagesStore.employeeDetails.short_name_Color]">
                        {{ _instance_profilePagesStore.employeeDetails.user_short_name }}
                    </p>

                    <label class="-label" for="file">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        <!-- <span>Change</span> -->
                    </label>
                    <input id="file" type="file" @change="updateProfilePhoto($event)" />
                    <!-- v-if="route.params.user_code != _instance_profilePagesStore.user_id" -->
                </div>
            </div>
            <div class="col-span-8">
                <div class="flex justify-between pr-4 ">
                    <div>
                        <p class="font-semibold text-md">{{ _instance_profilePagesStore.employeeDetails ?
                            _instance_profilePagesStore.employeeDetails.name : '-' }}</p>
                        <p class="text-xs font-semibold text-gray-500">{{ _instance_profilePagesStore.employeeDetails ?
                            _instance_profilePagesStore.employeeDetails.get_employee_office_details.designation : '-' }}</p>
                    </div>
                    <!-- <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto cursor-pointer" alt=""
                        @click="dialog_emp_name_visible = true"> -->

                </div>
                <div class="py-2">
                    <p class="text-xs font-semibold">Profile completeness</p>

                    <div class="w-11/12 my-1">
                        <ProgressBar v-if="_instance_profilePagesStore.employeeDetails.profile_completeness <= 39"
                            :value="_instance_profilePagesStore.employeeDetails.profile_completeness"
                            :class="[_instance_profilePagesStore.employeeDetails.profile_completeness <= 39 ? 'progressbar' : '']">
                        </ProgressBar>
                        <ProgressBar class="progressbar_val2"
                            v-if="_instance_profilePagesStore.employeeDetails.profile_completeness >= 40 && _instance_profilePagesStore.employeeDetails.profile_completeness <= 59"
                            :class="[_instance_profilePagesStore.employeeDetails.profile_completeness >= 40 && _instance_profilePagesStore.employeeDetails.profile_completeness <= 59]"
                            :value="_instance_profilePagesStore.employeeDetails.profile_completeness">
                        </ProgressBar>

                        <ProgressBar class="progressbar_val3"
                            v-if="_instance_profilePagesStore.employeeDetails.profile_completeness >= 60"
                            :class="[_instance_profilePagesStore.employeeDetails.profile_completeness >= 60]"
                            :value="_instance_profilePagesStore.employeeDetails.profile_completeness">
                        </ProgressBar>
                    </div>

                    <p class="mb-2 text-muted f-10 text-start fw-bold">
                        Your profile is completed
                    </p>
                </div>
            </div>
        </div>

        <div class="grid h-full grid-cols-3 col-span-5 gap-4">
            <div class="">
                <p class="text-xs font-semibold text-gray-500">Employee Status</p>
                <p v-if="_instance_profilePagesStore.employeeDetails.active == 1" class="text-sm font-semibold">Active
                </p>
                <p v-else class="text-sm font-semibold">Not active</p>
            </div>
            <div class="">
                <p class="text-xs font-semibold text-gray-500">Designation </p>
                <p class="text-sm font-semibold">{{
                    _instance_profilePagesStore.employeeDetails.get_employee_office_details.designation ?
                    _instance_profilePagesStore.employeeDetails.get_employee_office_details.designation : '-' }}</p>
            </div>
            <div class="flex items-center justify-between ">
                <div>
                    <p class="text-xs font-semibold text-gray-500">Department</p>
                    <p class="text-sm font-semibold">{{
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name ?
                        _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name : '-' }}</p>

                </div>
                <!-- <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto cursor-pointer" v-if="_instance_profilePagesStore.employeeDetails
                    .Current_login_user.org_role == 1 || _instance_profilePagesStore.employeeDetails
                        .Current_login_user.org_role == 2 || _instance_profilePagesStore.employeeDetails
                            .Current_login_user.org_role == 3" @click="dailogDepartment = true" alt=""> -->

            </div>
            <div class="">
                <p class="text-xs font-semibold text-gray-500">Employee Code</p>
                <p class="text-sm font-semibold">{{ _instance_profilePagesStore.employeeDetails ?
                    _instance_profilePagesStore.employeeDetails.user_code : '-' }}</p>
            </div>
            <div class="">
                <p class="text-xs font-semibold text-gray-500">Location</p>
                <p class="text-sm font-semibold">{{
                    _instance_profilePagesStore.employeeDetails.get_employee_office_details.work_location ?
                    _instance_profilePagesStore.employeeDetails.get_employee_office_details.work_location : '-' }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="">
                    <p class="text-xs font-semibold text-gray-500">Reporting to</p>
                    <p class="text-sm font-semibold whitespace-nowrap" v-if="_instance_profilePagesStore.employeeDetails">
                        {{
                            `${_instance_profilePagesStore.employeeDetails
                                .get_employee_office_details.l1_manager_name}(${_instance_profilePagesStore.employeeDetails.get_employee_office_details.l1_manager_code})`
                        }}
                    </p>
                </div>
                <!--
                <img src="../../../assests/icons/edit.svg" v-if="_instance_profilePagesStore.employeeDetails
                            .Current_login_user.org_role == 1 || _instance_profilePagesStore.employeeDetails
                                .Current_login_user.org_role == 2 || _instance_profilePagesStore.employeeDetails
                                    .Current_login_user.org_role == 3" @click="dailogReporting
                        = true" class="w-4 h-4 my-auto cursor-pointer" alt=""> -->

            </div>
        </div>

        <div class="h-full  flex gap-2 justify-between col-span-3 max-sm:flex-col " v-if="_instance_profilePagesStore.employeeDetails
                    .org_role == 1 || _instance_profilePagesStore.employeeDetails
                        .org_role == 2 || _instance_profilePagesStore.employeeDetails
                            .org_role == 3">
            <div class="flex flex-col gap-2  justify-center items-center ">
                <p class="text-xs font-semibold text-gray-500 font-['poppins']">Portal Status</p>
                <div class="flex flex-row flex-wrap gap-2 max-sm:flex-col">
                    <div class="flex items-center gap-2 font-['poppins']">
                        <input id="radio1" type="radio" name="enable" value=""
                            class="w-[15px] h-[15px]  bg-gray-100 border-gray-300  dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label for="radio1" class="text-[12px] font-semibold">Enable
                        </label>
                        <!-- text-green-600 -->
                    </div>
                    <div class="flex items-center gap-2 font-['poppins']">
                        <input id="radio2" type="radio" name="enable" value=""
                            class="w-[15px] h-[15px]  bg-gray-100 border-gray-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label for="radio2" class="text-[12px] font-semibold">Disable
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex  justify-end">
                <div>
                    <!-- <p class="p-1 text-xs font-semibold border rounded-full whitespace-nowrap">
            Edit -->
                    <!-- <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto mb-1 cursor-pointer" alt=""> -->
                    <!-- <img src="../../../assests/icons/edit.svg" class="w-4 h-4 my-auto cursor-pointer" alt=""> -->

                    <!-- </p> -->
                </div>
                <div class="mx-2">
                    <button class="p-0 m-0 bg-transparent border-0 outline-none btn">
                        <i class="pi pi-pencil mx-3 " @click=" visibleRight = true, setvalue()"></i>
                        <i class="pi pi-id-card text-success fs-4" aria-hidden="true" @click="dialogIdCard = true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- <Dialog header="Status" v-model:visible="canShowCompletionScreen" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '350px' }" :modal="true">
        <div class="confirmation-content"> -->
    <!-- <i class="mr-3 pi pi-check-circle" style="font-size: 2rem" /> -->
    <!-- <span>{{ status_text_CompletionDialog }}</span>
            <i class="pi pi-times text-[#000] absolute right-4 top-4 border-[3px] rounded-full p-2 border-blue-300 cursor-pointer " @click="canShowCompletionScreen =false"  ></i>
        </div>
    </Dialog> -->

    <Dialog v-model:visible="dailogDepartment" modal header="Edit Department" :style="{ width: '30vw' }">
        <!-- {{ employee_card.department  }} -->
        <i class="pi pi-times text-[#000] absolute right-4 top-4 border-[3px] rounded-full p-2 border-blue-300 cursor-pointer "
            @click="dailogDepartment = false"></i>
        <Dropdown :options="departmentOption" optionLabel="name" v-model="employee_card.department"
            placeholder="Select Department" class="w-full form-selects" optionValue="id" />
        <template #footer>
            <div>
                <button type="button" class=" bg-black p-2 text-white rounded-md " @click="editDepartment">
                    Save
                </button>
            </div>
        </template>
    </Dialog>

    <Dialog v-model:visible="dailogReporting" modal header="Edit Reporting Manager" :style="{ width: '30vw' }">
        <Dropdown optionLabel="name" :options="reportManagerOption" v-model="employee_card.reporting_manager"
            optionValue="user_code" placeholder="Select Reporting Manager" class="w-full form-selects" />
        <i class="pi pi-times text-[#000] absolute right-4 top-4 border-[3px] rounded-full cursor-pointer p-2 border-blue-300 "
            @click="dailogReporting = false"></i>
        <template #footer>
            <div>
                <button type="button" class=" bg-black  text-white p-2 rounded-md" @click="editReportingManager">
                    Save
                </button>
            </div>
        </template>
    </Dialog>


    <Sidebar v-model:visible="dialogIdCard" position="right" :style="{ width: '40vw !important' }">
        <template #header>
            <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Digital Id Preview</h1>
            </div>
        </template>



        <div
            class=" bg-gray-200 my-4  w-100  py-4 px-2 rounded-lg d-flex justify-content-around overflow-x-scroll ... lg:w-100 overflow-hidden ">

            <div class="p-3 mr-2 card d-flex justify-items-center align-items-center :lg:mx-0 Digital_Id_Card_"
                style="width: 260px; height: 380px; flex-direction: column !important;box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">

                <div style="height: 45px;width:140px;" class="mt-2 ">
                    <img :src="`${_instance_profilePagesStore.employeeDetails.client_logo}`" alt=""
                        style=" object-fit: cover; ">
                </div>
                <div class="mt-6 card-body d-flex justify-items-center align-items-center"
                    style="flex-direction: column ; ">
                    <div class="mx-auto rounded-circle img-xl userActive-status profile-img d-flex justify-content-center align-items-center "
                        :class="[!_instance_profilePagesStore.profile ? _instance_profilePagesStore.employeeDetails.short_name_Color : '', _instance_profilePagesStore.employeeDetails.short_name_Color]">

                        <img v-if="_instance_profilePagesStore.profile"
                            class="object-cover border rounded-circle img-xl userActive-status profile-img"
                            :src="`data:image/png;base64,${_instance_profilePagesStore.profile}`" srcset=""
                            style="box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px; width: 80px; height: 80px;" />

                        <h1 v-if="!_instance_profilePagesStore.profile" class="text-white fs-4">{{
                            _instance_profilePagesStore.employeeDetails.user_short_name }}</h1>
                    </div>


                    <!-- <img v-if="profile" class="rounded-circle profile-img"
                    :src="`data:image/png;base64,${profile}`" srcset=""  /> -->

                    <h1 class="mt-12 mb-3 subpixel-antialiased font-semibold text-blue-900 card-title f-12"
                        style="text-align: center;"> {{
                            _instance_profilePagesStore.employeeDetails.name }}</h1>

                    <h5 v-if="_instance_profilePagesStore.employeeDetails
                        .get_employee_office_details.department_id
                        " class="mb-3 subpixel-antialiased font-semibold text-gray-600 f-12 card-text">
                        {{
                            _instance_profilePagesStore.employeeDetails
                                .get_employee_office_details.department_name
                        }}
                    </h5>
                    <h1 v-else class="f-12 card-text ">-</h1>

                    <h5 v-if="_instance_profilePagesStore.employeeDetails.user_code"
                        class="mb-2 subpixel-antialiased font-semibold text-gray-700 f-16">
                        {{ _instance_profilePagesStore.employeeDetails.user_code }}
                    </h5>
                    <p v-else class="mb-2 f-12 text-secondary-emphasis">-</p>
                </div>
            </div>

            <!-- Digit-al Id back side  -->

            <div class="p-2 ml-2 card d-flex justify-items-center align-items-center Digital_Id_Card_ :lg:p-2 "
                style="width: 260px;  height: 380px; flex-direction: column !important;box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">
                <div class=" w-100 d-flex justify-content-center align-items-center flex-column">
                    <h1 class="subpixel-antialiased font-semibold text-orange-500 fs-14 fw-600">EMPLOYEE DETAILS</h1>
                    <div class="mt-3 row w-100">
                        <div class="subpixel-antialiased font-semibold text-left text-blue-900 col-5 fs-14">
                            Blood Group <span class=" position-absolute" style="position: absolute; left:90px ;">:</span>
                        </div>
                        <div class="text-blue-900 col-6 fs-6 ">
                            <h1 class="pt-1 text-left ">{{ cmpBldGrp }}</h1>
                        </div>
                    </div>
                    <div class="mt-3 row w-100">
                        <div class="subpixel-antialiased font-semibold text-left text-blue-900 col-5 fs-14">
                            Phone <span class=" position-absolute" style="position: absolute; left:90px ;">:</span>
                        </div>
                        <div class="text-blue-900 col-6 fs-6 ">
                            <h1 class="pt-1 text-left ">{{
                                _instance_profilePagesStore.employeeDetails.get_employee_details.mobile_number }}</h1>

                        </div>
                    </div>
                    <div class="mt-3 row w-100">
                        <div
                            class="subpixel-antialiased font-semibold text-left text-blue-900 col-5 fs-14 position-relative">
                            Email Id <span class=" position-absolute" style="position: absolute; left:90px ;">:</span>
                        </div>
                        <div class="subpixel-antialiased col-6 fs-12">
                            <h1 class="text-left ">

                                {{ _instance_profilePagesStore.employeeDetails.get_employee_office_details.officical_mail }}
                            </h1>
                        </div>
                    </div>
                    <div class="mt-3 row w-100">
                        <div class="subpixel-antialiased font-semibold text-left text-blue-900 col fs-14">
                            <h1 class="text-orange-500 fs-12">Residential Address :</h1>
                            <div class="ml-2 ">
                                <p class="mt-2 subpixel-antialiased font-semibold text-center text-blue-900 fs-11">
                                    {{
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.current_address_line_1
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 mt-2 row bg-gradient-to-r from-orange-500 to-orange-300 w-100 :lg:mt-2">
                    </div>
                    <div class="h-3 mt-1 row bg-gradient-to-r from-orange-500 to-orange-300 w-100">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mt-2 subpixel-antialiased font-semibold text-center text-orange-500 fs-14 :lg:mt-2"
                                v-if="_instance_profilePagesStore.employeeDetails.client_details.client_name"> {{
                                    _instance_profilePagesStore.employeeDetails.client_details.client_name }}</h1>
                        </div>
                        <div class="col-12 ">
                            <h1 class="mt-2 font-semibold text-center text-blue-900 fs-11">{{
                                _instance_profilePagesStore.employeeDetails.client_details.address }}</h1>
                        </div>
                        <div class="col-12">
                            <h1 class="mt-2 font-semibold text-center text-blue-900 fs-12">{{
                                _instance_profilePagesStore.employeeDetails.client_details.authorised_person_contact_email
                            }}</h1>
                        </div>
                        <div class="col-12">
                            <h1 class="fs-11 text-center font-semibold lining-nums ... text-blue-900 mt-2">
                                {{
                                    _instance_profilePagesStore.employeeDetails.client_details.authorised_person_contact_number
                                }}</h1>
                        </div>

                        <div class="col-12">
                            <!-- <h1 class="mb-3 font-semibold text-center text-blue-900 fs-12 :lg:mb-0">{{
                                _instance_profilePagesStore.employeeDetails.email }}</h1> -->
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class=" w-[100%] flex justify-center mt-[100px]">
            <button class="border-[1px] border-[#000] rounded-md px-2 " @click="dialogIdCard = false"> cancel</button>
        </div>

    </Sidebar>

    <Sidebar v-model:visible="visibleRight" position="right" :style="{ width: '30vw !important' }">
        <template #header>
            <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Personal Details</h1>
            </div>
        </template>

        <div class="bg-[#FFE2E2] w-[100%] absolute  top-[60px] left-0 p-3 z-50">
            <p class=" w-[100%] text-[#000] font-['poppins']">Instruction : <span class=" text-gray-400">Uploading and
                    verifying documents is
                    mandatory to change the name.</span> </p>
        </div>
        <div class=" w-[100%] mt-[72px] font-['poppins'] p-3">

            <div class="flex justify-center flex-col ">
                <label class="mb-2 text-base font-semibold ">Name<span class=" text-red-500">*</span></label>
                <InputText type="text" v-model="Person_Details.employee_name" style="text-transform: uppercase"
                    class=" !p-2 form-controls bg-gray-200" />
            </div>

            <div class="">
                <!--  -->
                <div class=" form-group flex flex-col my-2">
                    <label for="" class="mb-1 text-base font-semibold">Document Type</label>
                    <Dropdown v-model="Person_Details.onboard_document_type"
                        @change="Person_Details.onboard_document_type ? PersonDetails : ''" :options="doc_name"
                        optionLabel="name" optionValue="name" placeholder="Select a document "
                        class="!w-[200px] h-12 pl-2 form-controls bg-gray-200" />
                    <span
                        :class="[error.onboard_document_type ? ' text-[red] visible' : 'hidden']">{{ error.onboard_document_type }}</span>
                </div>
            </div>
            <div class="">
                <div class=" form-group flex flex-col my-2">
                    <label for="" class="mb-1 text-base font-semibold">Upload Documents(For Verification)</label>
                    <div class=" flex flex-col justify-start">
                        <Toast />
                        <label
                            class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                            style="" id="" for="uploadPassBook">
                            <i class="pi pi-download bg-gray-300 p-3 rounded-md mr-3"></i>
                            <h1 class="text-[#000] " v-if="!Person_Details.emp_doc.name">Upload file</h1>
                            <p v-if="Person_Details.emp_doc" class="">
                                {{ Person_Details.emp_doc.name }}</p>
                        </label>
                        <div class="flex flex-col justify-center items-center  ">
                            <input type="file" accept="image/png, image/jpeg" name="" id="uploadPassBook"
                                @change="UploadEmpDocsPhoto($event), Person_Details.emp_doc ? PersonDetails : ''" hidden
                                style="text-transform: uppercase" class="form-controls pl-2" />
                            <span :class="[error.emp_doc ? ' text-[red] visible' : 'hidden']">{{ error.emp_doc }}</span>
                            <span class="text-[12px]">Accepted file types - JPEG, PNG and Maximum file size is -2MB</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class=" flex flex-col" v-if="_instance_profilePagesStore.employeeDetails
                .org_role == 1 || _instance_profilePagesStore.employeeDetails
                    .org_role == 2 || _instance_profilePagesStore.employeeDetails
                        .org_role == 3">
                <label for="" class="mb-1 text-lg font-semibold">Department</label>
                <Dropdown :options="departmentOption" optionLabel="name" v-model="employee_card.department"
                    placeholder="Select Department" class="w-full form-selects bg-gray-200" optionValue="id" />
                <!-- {{_instance_profilePagesStore.employeeDetails.get_employee_office_details.l1_manager_code}} -->
            </div>
            <div class=" flex flex-col" v-if="_instance_profilePagesStore.employeeDetails
                .org_role == 1 || _instance_profilePagesStore.employeeDetails
                    .org_role == 2 || _instance_profilePagesStore.employeeDetails
                        .org_role == 3">
                <label for="" class="mb-1 text-lg font-semibold">Reporting to</label>
                <Dropdown optionLabel="name" :options="reportManagerOption" v-model="employee_card.reporting_manager"
                    optionValue="user_code" placeholder="Select Reporting Manager"
                    class="w-full form-selects bg-gray-200" />
            </div>
            <div class=" flex flex-col" v-if="_instance_profilePagesStore.employeeDetails
                .org_role == 1 || _instance_profilePagesStore.employeeDetails
                    .org_role == 2 || _instance_profilePagesStore.employeeDetails
                        .org_role == 3">
                <label for="" class="mb-1 text-lg font-semibold">Designation</label>
                <Dropdown optionLabel="designation" :options="DesignationOption" v-model="employee_card.designation"
                    optionValue="designation" placeholder="Select Designation" class="w-full form-selects bg-gray-200" />
            </div>
            <div class=" flex flex-col" v-if="_instance_profilePagesStore.employeeDetails
                .org_role == 1 || _instance_profilePagesStore.employeeDetails
                    .org_role == 2 || _instance_profilePagesStore.employeeDetails
                        .org_role == 3">
                <label for="" class="mb-1 text-lg font-semibold">Location</label>
                <InputText type="text" v-model="employee_card.location" style="" class=" !p-2 form-controls bg-gray-200" />
            </div>

            <div class="  flex justify-center items-center mt-[100px]">
                <button class="border-[1px] border-[#000] rounded-md btn mx-2"
                    @click="visibleRight = false, error.onboard_document_type = '', error.emp_doc = '', Person_Details.emp_doc = '', employee_info.emp_upload_doc = ''">Cancel</button>
                <button class="btn !bg-[#000] !text-[#ffff] mx-2"
                    @click="error.submit_btn = 'submit_btn', PersonDetails">Submit</button>
            </div>


        </div>
    </Sidebar>





    <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
        <template #header>
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                animationDuration="2s" aria-label="Custom ProgressSpinner" />
        </template>
        <template #footer>
            <h5 style="text-align: center">Please wait...</h5>
        </template>
    </Dialog>

    <Dialog v-model:visible="dialog_emp_name_visible" modal header=" " :style="{ width: '50vw' }">
        <template #header>
            <div>
                <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                    class="fw-bold fs-5">
                    Edit Employee Name</h5>
            </div>
        </template>
        <div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 form-group">
                            <label class="mb-2 text-lg font-semibold">Employee Name</label>
                            <!-- <InputMask @focusout="panCardExists" id="serial" mask="aaaaa9999a"
                                                    v-model="employee_info.emp_name" placeholder=""
                                                    style="text-transform: uppercase" class="pl-2 form-controls" :class="[
                                                        v$.emp_name.$error ? 'p-invalid' : '',
                                                    ]" /> -->
                            <InputText type="text" v-model="employee_info.emp_name" style="text-transform: uppercase"
                                class="pl-2 form-controls" :class="[
                                    v$.emp_name.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="v$.emp_name.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.emp_name.required.$message.replace("Value", "Employee Name")
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class=" form-group">
                            <label for="" class="mb-1 text-lg font-semibold">Documents</label>
                            <Dropdown v-model="employee_info.emp_doc_name" :options="doc_name" optionLabel="name"
                                placeholder="Select a document " class="w-full h-12 pl-2 form-controls" :class="[
                                    v$.emp_doc_name.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="v$.emp_doc_name.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.emp_doc_name.required.$message.replace("Value", "Documents")
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column ">
                        <div class="d-flex justify-items-center flex-column ">
                            <label for="" class="mb-2 text-lg font-semibold float-label">Upload
                                Documents</label>
                            <div class="d-flex justify-items-center align-items-center">
                                <Toast />
                                <label
                                    class="cursor-pointer text-primary bg-[black] px-2 py-2 rounded-md d-flex align-items-center fs-5"
                                    style="width:100px ; " id="" for="uploadPassBook">
                                    <i class="pi pi-arrow-circle-up text-[white] mr-2 text-[18px]"></i>
                                    <h1 class="text-light">Upload</h1>
                                </label>

                                <div v-if="employee_info.emp_upload_doc"
                                    class="p-2 px-3 mx-4 font-semibold bg-green-100 rounded-lg fs-11">
                                    {{ employee_info.emp_upload_doc.name }}</div>

                                <input type="file" name="" id="uploadPassBook" hidden @change="UploadEmpDocsPhoto($event)"
                                    :class="[
                                        v$.emp_upload_doc.$error ? 'p-invalid' : '',
                                    ]" />
                            </div>
                            <span v-if="v$.emp_upload_doc.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.emp_upload_doc.required.$message.replace("Value", "document")
                                }}
                            </span>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="text-right">
                        <button id="btn_submit_bank_info" class="btn btn-orange submit-btn"
                            @click="submitForm">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </Dialog>
</template>

<script setup>
import { _ } from "lodash";
import axios from "axios";
import { onMounted, reactive, ref, computed } from "vue";
import { Service } from "../../Service/Service";
import { profilePagesStore } from "../stores/ProfilePagesStore";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import { useRouter, useRoute } from "vue-router";
import dayjs from 'dayjs'
// import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";

const service = Service();
const route = useRoute();

const toast = useToast();

const canShowLoading = ref(false);

const dialogIdCard = ref(false)

const visibleRight = ref(false);

const employee_card = reactive({
    department: "",
    reporting_manager: "",
    designation: '',
    location: ''
});

const employee_info = reactive({
    emp_name: "",
    emp_doc_name: "",
    emp_upload_doc: ""
});

const Person_Details = reactive({
    employee_name: "",
    onboard_document_type: "",
    emp_doc: "",
    department_id: "",
    manager_user_code: ""
});

const error = reactive({
    onboard_document_type: "",
    emp_doc: "",
    submit_btn: 0
});
// const submit_btn = ref(false);


const doc_name = ref([
    { name: 'Birth Certificate', code: 1 },
    { name: 'Aadhar Card Front', code: 2 },
    { name: 'Pan Card', code: 3 },
]);

// const


const dialog_emp_name_visible = ref(false);

let _instance_profilePagesStore = profilePagesStore();


const updateProfilePhoto = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        _instance_profilePagesStore.profile = e.target.files[0];
        // Get file size
        // Print to console
    }

    let form = new FormData();
    form.append("user_id", _instance_profilePagesStore.getURLParams_UID());
    form.append("file_object", _instance_profilePagesStore.profile);

    let url = "/profile-pages/updateProfilePicture";
    axios
        .post(url, form)
        .then((res) => {
            // console.log(res.data);
        })
        .finally(() => {
            console.log("Photo Sent");
            _instance_profilePagesStore.getProfilePhoto();
        });
};

const departmentOption = ref();

const reportManagerOption = ref();

const dailogDepartment = ref(false);

const dailogReporting = ref(false);

const DesignationOption = ref();

const canShowCompletionScreen = ref(false);
const status_text_CompletionDialog = ref("None");

const editDepartment = (dep) => {
    console.log(dep);

    axios
        .post("/profile-pages/updateDepartment", {
            user_code: _instance_profilePagesStore.employeeDetails.user_code,
            department_id: employee_card.department,
            designation: employee_card.designation,
            location: employee_card.location,
        })
        .then((res) => {
            let selected_deptName = _.find(departmentOption.value, ["id", employee_card.department]).name;
            let selected_deptid = _.find(departmentOption.value, ["id", employee_card.department]).id;
            _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name = selected_deptName;
            employee_card.department = selected_deptid;
            status_text_CompletionDialog.value = "Department updated successfully !";
        })
        .catch((err) => {
            status_text_CompletionDialog.value = "Error while updating department. Kindly contact the Admin.";
            console.log("Error while updating Department : " + err);
        })
        .finally(() => {

            canShowCompletionScreen.value = true;
            dailogDepartment.value = false;
            //console.log('Experiment completed');
        });
};

const editReportingManager = (rm) => {
    console.log("editReportingManager : " + rm);

    axios.post("/profile-pages/updateReportingManager", {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        manager_user_code: employee_card.reporting_manager,
    }).
        then((res) => {
            //console.log("Reporting Manager Options : "+ JSON.stringify(reportManagerOption.value));

            let selected_reportedManager = _.find(reportManagerOption.value, ["user_code", employee_card.reporting_manager]);

            _instance_profilePagesStore.employeeDetails.get_employee_office_details.l1_manager_name = selected_reportedManager.name;
            _instance_profilePagesStore.employeeDetails.get_employee_office_details.l1_manager_code = selected_reportedManager.user_code;

            status_text_CompletionDialog.value = "Reporting Manager updated successfully !";

        }).catch((err) => {
            status_text_CompletionDialog.value = "Error while updating Reporting Manager. Kindly contact the Admin.";
            console.log("Error while updating Reporting Manager : " + err);
        }).finally(() => {
            canShowCompletionScreen.value = true;
            dailogReporting.value = false;
        });
};

const setvalue = () => {
    Person_Details.employee_name = _instance_profilePagesStore.employeeDetails.name;
    // employee_card.department = _instance_profilePagesStore ? _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name :'' ;

    employee_card.reporting_manager = _instance_profilePagesStore.employeeDetails.get_employee_office_details.l1_manager_code;
    employee_card.designation = _instance_profilePagesStore.employeeDetails.get_employee_office_details.designation;
    employee_card.location = _instance_profilePagesStore.employeeDetails.get_employee_office_details.work_location;
    // _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name = selected_deptName;

};

onMounted(() => {

    service.DepartmentDetails().then((res) => {
        departmentOption.value = res.data;

        res.data.map(({ id, name }) => {
            if (name == _instance_profilePagesStore.employeeDetails.get_employee_office_details.department_name)
                employee_card.department = id

        })
        console.log(
            "testing" +
            _instance_profilePagesStore.employeeDetails.get_employee_office_details
                .l1_manager_name
        );
    });
    service.ManagerDetails().then((res) => {
        reportManagerOption.value = res.data;
    });
    setvalue();
    getDesignation();

    console.log();
});

const UploadEmpDocsPhoto = (e) => {

    const file = e.target.files[0];
    const maxSizeInBytes = 2 * 1024 * 1024; // 2MB

    if (file.size < maxSizeInBytes) {
        //   e.target.value = '';
        employee_info.emp_upload_doc = e.target.files[0];
        Person_Details.emp_doc = e.target.files[0]; // Reset the input

    }
    else {
        toast.add({ severity: 'warn', summary: 'Warn Message', detail: `The file its too large.Allowed maximum size is 2MB  ${employee_info.emp_upload_doc.name} `, life: 3000 });

        employee_info.emp_upload_doc = '';
        Person_Details.emp_doc = '';


        // alert('File size exceeds 1MB limit. Please choose a smaller file.');

    }

    if (e.target.files && e.target.files[0]) {

    }
}


const rules = computed(() => {
    return {
        emp_name: { required },
        emp_doc_name: { required },
        emp_upload_doc: { required }
    }
})



const v$ = useValidate(rules, employee_info)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        saveEmpChangeInfoDetails();
    } else {
        console.log('Form failed submitted.')
    }

}


const saveEmpChangeInfoDetails = () => {
    canShowLoading.value = true;

    dialog_emp_name_visible.value = false;
    let id = service.current_user_id;
    const url = `/update-EmplpoyeeName-info/${id}`;
    const form = new FormData;
    form.append('user_code', _instance_profilePagesStore.employeeDetails.user_code)
    form.append('name', employee_info.emp_name);
    form.append('onboard_document_type', employee_info.emp_doc_name.name);
    form.append('emp_doc', employee_info.emp_upload_doc);


    axios.post(url, form).finally(() => {

        canShowLoading.value = false;
    })


}

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


function save_persondetails() {

    let form = new FormData();
    form.append("user_id", _instance_profilePagesStore.getURLParams_UID());
    form.append("employee_name", Person_Details.employee_name);
    form.append("onboard_document_type", Person_Details.onboard_document_type);
    // form.append("department_id",Person_Details.department_id);
    form.append("emp_doc", Person_Details.emp_doc);
    form.append("manager_user_code", Person_Details.manager_user_code);

    // let from

    axios.post('/profile-page/uploadEmployeeDetails', form).then((res) => {
        console.log(res.data)
    }).finally(() => {
        _instance_profilePagesStore.fetchEmployeeDetails();
        visibleRight.value = false;
        Person_Details.employee_name = "";
        Person_Details.onboard_document_type = "";
        Person_Details.emp_doc = "";
        Person_Details.department_id = "";
        Person_Details.manager_user_code = "";
        error.submit_btn = '';
    })

}

function submit_btn(val) {
    if (val) {
        PersonDetails()
    }

}


const PersonDetails = computed(() => {
    editReportingManager();
    editDepartment();

    console.log(dayjs('2024-12-26').subtract(1, 'day'), " dayjs('YYYY-MM-DD').subtract(1, 'day');");
    //     const a = dayjs()
    // const b = a.add(7, 'day')

    if (Person_Details.employee_name != _instance_profilePagesStore.employeeDetails.name) {
        if (Person_Details.onboard_document_type || Person_Details.emp_doc) {

            error.emp_doc = '';
            error.onboard_document_type = '';
            if (error.submit_btn === 'submit_btn') {

                save_persondetails();
                console.log('(error.submit_btn === 1 && Person_Details.onboard_document_type', error.submit_btn)
            }
            else {
                error.submit_btn = '';
            }
        } else {
            error.emp_doc = ' Documents Type required';
            error.submit_btn = 'dsfd'
            error.onboard_document_type = 'Upload Documents required';

        }
    } else {

    }




})


function Person_Detailspopup() {
    visibleRight.value = true;
    dailogDepartment.value = false;

}

function updateEmployeeDesignation() {
    axios.post('/profile-pages/updateEmployeeDesignation').then((res) => {
        console.log(res.data);
    })
}

function getDesignation() {
    axios.get('/getDesignation').then((res) => {
        console.log(res.data, 'getDesignation');
        DesignationOption.value = res.data;
    })
}



</script>

<style lang="scss">
@mixin object-center {
    display: flex;
    justify-content: center;
    align-items: center;
}

$circleSize: 90px;
$radius: 100px;
$shadow: 0 0 10px 0 rgba(255, 255, 255, .35);
$fontColor: rgb(250, 250, 250);

.profile-pic {
    color: transparent;
    transition: all .3s ease;
    @include object-center;
    position: relative;
    transition: all .3s ease;

    input {
        display: none;
    }

    .forRounded {
        position: absolute;
        object-fit: cover;
        width: $circleSize;
        height: $circleSize;
        box-shadow: $shadow;
        border-radius: $radius;
        z-index: 0;
    }

    .-label {
        cursor: pointer;
        height: $circleSize;
        width: $circleSize;
    }

    &:hover {
        .-label {
            @include object-center;
            background-color: rgba(0, 0, 0, .8);
            z-index: 10000;
            color: $fontColor;
            transition: background-color .2s ease-in-out;
            border-radius: $radius;
            margin-bottom: 0;
        }
    }

    span {
        display: inline-flex;
        padding: .2em;
        height: 2em;
        font-size: 12px;
    }
}

.p-progressbar.p-component.p-progressbar-determinate {
    height: 13px;
    /* background-color: aqua; */
}


.progressbar_val3 .p-progressbar-value.p-progressbar-value-animate {
    /* background-color:#fff !important; */
    background-color: rgb(48, 218, 48) !important;
    color: #fff !important;
}

.progressbar .p-progressbar-value.p-progressbar-value-animate {
    /* background-color:#fff !important; */
    background-color: red !important;
    color: #fff !important;
}

.progressbar_val2 .p-progressbar-value.p-progressbar-value-animate {
    background-color: orange !important;
    color: black !important;
}

/* .p-progressbar-label{
color: black !important;
} */


/* .progressbar_val_1 >  .p-progressbar-value.p-progressbar-value-animate , .p-progressbar-label{
     background-color: red !important ;
     color: #fff !important;
} */


@media only screen and (max-width: 1280px) {
    .Digital_Id_Card_ {
        /* height: 7000px; */
    }
}</style>

