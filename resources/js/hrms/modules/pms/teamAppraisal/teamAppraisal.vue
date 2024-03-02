<template>
    <LoadingSpinner v-if="useStore.canShowLoading" class="absolute z-50 bg-white" />
<div>
    <Toast />
    <p v-if="false" class=" bg-[#FDDEDE] p-2 rounded-md font-['poppins']">Lorem ipsum dolor, sit amet consectetur
        adipisicing elit.
        Voluptates, ipsam quisquam incidunt adipisci commodi fugiat?</p>
    <!-- {{ useStore.pmsConfiguration }} -->
    <!-- {{ useHelper.ManagerList }} -->
    <!-- {{ useHelper.KpiForms }} -->
    <!-- {{ useStore.createNewTeamGoals }} -->
    <div class=" grid grid-cols-4 gap-4 px-4 mt-[20px] ">
        <div class=" !shadow-xl border-[1px] flex rounded-lg justify-start items-center ">
            <img src="../assests/employee_goals.png" class=" w-[60px] " alt="">
            <div class="flex flex-col ">
                <h1 class=" font-semibold  text-[16px]  font-['poppins']">Employee Goals</h1>
                <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ?
                    useStore.DashboardCardDetails_TeamAppraisal[0].total_count : '' }}/{{
    useStore.DashboardCardDetails_TeamAppraisal ?
    useStore.DashboardCardDetails_TeamAppraisal[0].actual_count : '' }}</span>
            </div>
        </div>
        <div class=" !shadow-xl border-[1px] flex rounded-lg justify-start items-center">
            <div>
                <img src="../assests/self_review.png" class="  w-[60px] " alt="">
            </div>
            <div class="flex flex-col ">
                <h1 class=" font-semibold  text-[16px]  font-['poppins']">Self review</h1>
                <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ?
                    useStore.DashboardCardDetails_TeamAppraisal[1].total_count : '' }}/{{
    useStore.DashboardCardDetails_TeamAppraisal ?
    useStore.DashboardCardDetails_TeamAppraisal[1].actual_count : '' }}</span>
            </div>
        </div>
        <div class="flex  !shadow-xl border-[1px] rounded-lg justify-start items-center">
            <img src="../assests/pms_rating.png" class="  w-[60px] " alt="">
            <div class="flex flex-col ">
                <h1 class=" font-semibold  text-[16px]  font-['poppins']">Employee Assessed</h1>
                <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ?
                    useStore.DashboardCardDetails_TeamAppraisal[2].total_count : '' }}/{{
    useStore.DashboardCardDetails_TeamAppraisal ?
    useStore.DashboardCardDetails_TeamAppraisal[2].actual_count : '' }}</span>
            </div>
        </div>
        <div class="flex !shadow-xl border-[1px] rounded-lg justify-start items-center">
            <img src="../assests/employees_assessed.png" class="  w-[60px] " alt="">
            <div class="flex flex-col ">
                <h1 class=" font-semibold text-[16px]  font-['poppins']">Final Score Published</h1>
                <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ?
                    useStore.DashboardCardDetails_TeamAppraisal[3].total_count : '' }}/{{
    useStore.DashboardCardDetails_TeamAppraisal ?
    useStore.DashboardCardDetails_TeamAppraisal[3].actual_count : '' }}</span>
            </div>
        </div>
    </div>
    <div class="flex justify-between mt-5 ">

        <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 border-b-[3px] border-gray-300 "
            id="pills-tab" role="tablist">
            <li class=" " role="presentation">
                <a class="px-3 position-relatie border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                    data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="active = 3, useStore.createKpiForm.form_details = ''"
                    :class="[active === 3 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                    Pending
                    <span class="relative left-[60px] top-[-25px] flex h-3 w-3 !z-10"
                        :class="useStore.teamDashboardPublishedFormList ? useHelper.filterTeamAppraisalPendingSource(useStore.teamDashboardPublishedFormList, 1, '').length > 0 ? '' : 'hidden' : 'hidden'">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </a>
                <div v-if="active === 3" class="relative h-1 rounded-l-3xl top-1 "
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div> -->
            </li>
            <li class=" nav-item" role="presentation">
                <a class="px-2 position-relati3e border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                    data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="active = 1, useStore.createKpiForm.form_details = ''"
                    :class="[active === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                    CURRENT
                </a>
                <div v-if="active === 1" class="relative h-1 rounded-l-3xl top-2 "
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div> -->
            </li>

            <li class="border-0 nav-item position-relative" role="presentation">
                <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                    data-bs-toggle="pill" href="" @click="active = 2, useStore.createKpiForm.form_details = ''"
                    :class="[active === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab"
                    aria-controls="" aria-selected="true">
                    COMPLETED
                </a>
                <div v-if="active === 2" class=" h-1 relative top-2  bottom-[1px] left-0 w-[100%]"
                    style="border: 2px solid #F9BE00 !important;"></div>
                <!-- <div v-else class="h-1 border-gray-300 border-3"></div> -->
            </li>
        </ul>

        <div class="flex justify-between ">
            <button v-if="active == 1"
                @click="visibleRight = true, useStore.getPmsConfiguration(2, current_user_code), editsavepublish1 = '' , useStore.createKpiForm.form_details = '' "
                class=" bg-[#F9BE00] text-[13px] rounded-md text-[#000] !w-[120px] h-[35px] font-semibold flex justify-center items-center ">
                <i class="mr-2 pi pi-plus"></i>
                Add Goals</button>
            <!-- v-model="filters['global'].value"  -->
            <!-- <InputText placeholder="Search" class="h-[35px] w-[211px] mx-4" v-model="filters['global'].value" /> -->
        </div>


    </div>

    <!-- {{ useStore.teamDashboardPublishedFormList }} -->
    <!-- useHelper.filterTeamAppraisalCurrentSource(useStore.teamDashboardPublishedFormList, 0, currentUserCode) -->
    <div class="" v-if="active == 1">
        <DataTable paginator :rows="5" scrollable
            :value="useHelper.filter_team_current(useStore.teamDashboardPublishedFormList,1,'')"
            :rowsPerPageOptions="[5, 10, 20, 50]" class=" w-[100%] " :filters="filters">
            <Column field="assignee_name" header="Employee" style="">
                <template #body="slotProps">
                    <div class="flex justify-center items-center  gap-2">
                        <!-- <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.emp_avatar).data}`" srcset=""
                            alt="" /> -->

                        <span v-if="slotProps.data.avatar_or_shortname.type == 'shortname'"
                            class=" font-semibold text-white rounded-full w-[34px] h-[34px] font-['poppins'] text-[12px] flex justify-center items-center "
                            :class="useService.getBackgroundColor(slotProps.index)" style="vertical-align: middle">
                            {{ slotProps.data.avatar_or_shortname.data }} </span>
                        <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${slotProps.data.avatar_or_shortname.data}`" srcset=""
                            alt="" />
                        <span class="flex flex-col justify-start items-start">
                            <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] "> {{
                                            slotProps.data.assignee_name.substring(0,
                                                14) +  '..'  }} </span>
                            <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                            }}</span>
                        </span>


                    </div>
                </template>
            </Column>
            <Column field="manager_name" header="Manager" style="">
                <template #body="slotProps" >
            <div class="flex flex-col justify-start items-start" >
                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                slotProps.data.manager_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                            }}</span>
            </div>
        </template>

            </Column>
            <Column field="assignment_period" header="Assignment Period" style=""></Column>
            <Column field="score" header="Score" style=""></Column>
            <Column header="Status" style="">
                <template #body="{ data }">
                <span class=" font-['poppins']" >{{ data.status }}</span>
                    <!-- <span
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span> -->
                </template>
            </Column>
            <Column field="" header="Actions" style="min-width: 6rem">
                <template #body="{ data }">
                    <!-- <div v-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, 1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">
                        Approved
                    </div>
                    <div v-else-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, -1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">
                        rejected
                    </div> -->
                    <!-- <div v-else> -->
                    <!-- <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, 1, '')">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>


                        </button>
                        <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, -1, '')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </button> -->
                    <div class="flex justify-center items-center">
                        <button v-if="!data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.selected_header = data.form_header, selectedRowdata = data, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false, useStore.getSelfTimeLine(currentUserCode, data.id)"
                            class="bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]">
                            <i class=" pi pi-eye text-[#000]"></i>
                        </button>
                        <button v-if="data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true, review_save = 'save', useStore.getSelfTimeLine(currentUserCode, data.id), useStore.selected_header = data.form_header, useStore.createKpiForm = { ...data.kpi_form_details }, view_form_edit_withdraw(data.reviewer_details, data), view_edit_withdraw = 'Review', useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), useStore.record_id = data.id, currentlyRecords = data.id, data.is_assignee_submitted == 1 ? isFormSubmitted = true : isFormSubmitted = false, canHiddenUploadOptions = false"
                            class=" bg-[#F9BE00] px-4 py-1 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                            Review</button>
                    </div>
                    <!-- <button class="" type="button" @click="edit_withdraw(data.id)"> <i class="pi pi-ellipsis-v"></i>
                    </button> -->
                    <!-- <div v-if="edit === data.id" @mouseleave="edit = ''"
                        class="absolute flex flex-col bg-white shadow-2xl top-4 z-[1000] "
                        style="width: 120px; margin-top:12px !important;margin-right: 20px !important; ">
                        <div class="p-0 m-0 d-flex flex-column">

                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">View</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">Edit</button>
                            <button
                                class=" h-[30px] p-2 font-['poppins'] ! bg-yellow-300 text-[#000]"
                                @click="useStore.teamKpiFormApproval(data.id, 1, '')">Approve</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins'] bg-black text-[#ffff]"
                                @click="useStore.teamKpiFormApproval(data.id, -1, '')">Reject</button>
                        </div>

                    </div> -->
                    <!-- </div> -->
                </template>
            </Column>
        </DataTable>

    </div>

    <div class="" v-if="active == 2">
    <!-- completed -->
        <DataTable  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            :value="useHelper.filterTeamAppraisalCurrentSource(useStore.teamDashboardPublishedFormList, 1, currentUserCode)"
             class=" w-[100%] " :filters="filters">
            <Column field="assignee_name" header="Employee" style="">
                <template #body="slotProps">
                    <div class="flex justify-center items-center  gap-2">
                        <!-- <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.emp_avatar).data}`" srcset=""
                            alt="" /> -->
                        <span v-if="slotProps.data.avatar_or_shortname.type == 'shortname'"
                            class=" font-semibold text-white rounded-full w-[34px] h-[34px] font-['poppins'] text-[12px] flex justify-center items-center "
                            :class="useService.getBackgroundColor(slotProps.index)" style="vertical-align: middle">
                            {{ slotProps.data.avatar_or_shortname.data }} </span>
                        <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${slotProps.data.avatar_or_shortname.data}`" srcset=""
                            alt="" />
                        <span class="flex flex-col justify-start items-start">
                            <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] "> {{
                                            slotProps.data.assignee_name.substring(0,
                                                14) +  '..'  }} </span>
                            <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                            }}</span>
                        </span>


                    </div>
                </template>
            </Column>
            <Column field="manager_name" header="Manager" style="">
                <template #body="slotProps" >
            <div class="flex flex-col justify-start items-start" >
                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                slotProps.data.manager_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                            }}</span>
            </div>
        </template>
            </Column>
            <Column field="assignment_period" header="Assignment Period" style=""></Column>
            <Column field="score" header="Score" style=""></Column>
            <!-- <Column field="achieved_score" header="Achieved Score" style="width: 25%;"></Column> -->
            <Column header="Status" style="">
                <template #body="{ data }">
                    <span
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">
                        {{ data.status }}</span>
                </template>
            </Column>
            <Column field="" header="Actions" style="min-width: 6rem">
                <template #body="{ data }">
                    <!-- <div v-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, 1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">
                        Approved
                    </div>
                    <div v-else-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, -1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">
                        rejected
                    </div> -->
                    <!-- <div v-else> -->
                    <!-- <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, 1, '')">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>


                        </button>
                        <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, -1, '')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </button> -->
                    <div class="flex justify-center items-center">
                        <button v-if="!data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.selected_header = data.form_header, selectedRowdata = data, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false, useStore.getSelfTimeLine(currentUserCode, data.id)"
                            class="bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]">
                            <i class=" pi pi-eye text-[#000]"></i>
                        </button>
                        <button v-if="data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.selected_header = data.form_header, useStore.getSelfTimeLine(currentUserCode, data.id), view_form_edit_withdraw(data.reviewer_details, data), view_edit_withdraw = 'Review', useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id, data.is_assignee_submitted == 1 ? isFormSubmitted = true : isFormSubmitted = false, canHiddenUploadOptions = false"
                            class=" bg-[#F9BE00] h-[20px] w-[30px] rounded-md text-[#000]  !font-['poppins'] ">
                            <i class=" pi pi-eye text-[#000]"></i>
                        </button>
                    </div>
                    <!-- <button class="" type="button" @click="edit_withdraw(data.id)"> <i class="pi pi-ellipsis-v"></i>
                    </button> -->
                    <!-- <div v-if="edit === data.id" @mouseleave="edit = ''"
                        class="absolute flex flex-col bg-white shadow-2xl top-4 z-[1000] "
                        style="width: 120px; margin-top:12px !important;margin-right: 20px !important; ">
                        <div class="p-0 m-0 d-flex flex-column">

                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">View</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">Edit</button>
                            <button
                                class=" h-[30px] p-2 font-['poppins'] ! bg-yellow-300 text-[#000]"
                                @click="useStore.teamKpiFormApproval(data.id, 1, '')">Approve</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins'] bg-black text-[#ffff]"
                                @click="useStore.teamKpiFormApproval(data.id, -1, '')">Reject</button>
                        </div>

                    </div> -->
                    <!-- </div> -->
                </template>
            </Column>

        </DataTable>
    </div>

    <div class="" v-if="active == 3">
        <!-- pending -->
        <DataTable  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            :value="useHelper.filterTeamAppraisalPendingSource(useStore.teamDashboardPublishedFormList, 1, '')"
            class=" w-[100%] " :filters="filters">
            <Column field="assignee_name" header="Employee" style="">
                <template #body="slotProps">
                    <div class="flex justify-center items-center  gap-2">
                        <!-- <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${JSON.parse(slotProps.data.emp_avatar).data}`" srcset=""
                            alt="" /> -->

                        <span v-if="slotProps.data.avatar_or_shortname.type == 'shortname'"
                            class=" font-semibold text-white rounded-full w-[34px] h-[34px] font-['poppins'] text-[12px] flex justify-center items-center "
                            :class="useService.getBackgroundColor(slotProps.index)" style="vertical-align: middle">
                            {{ slotProps.data.avatar_or_shortname.data }} </span>
                        <img v-else class="rounded-circle userActive-status profile-img"
                            style="height: 30px !important; width: 30px !important;"
                            :src="`data:image/png;base64,${slotProps.data.avatar_or_shortname.data}`" srcset=""
                            alt="" />
                        <span class="flex flex-col justify-start items-start">
                            <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                            slotProps.data.assignee_name.substring(0,
                                                14) +  '..'  }} </span>
                            <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                            }}</span>
                        </span>


                    </div>
                </template>
            </Column>
            <Column field="manager_name" header="Manager" style="">
                <template #body="slotProps" >
            <div class="flex flex-col justify-start items-start" >
                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                slotProps.data.manager_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                            }}</span>
            </div>
        </template>
            </Column>
            <Column field="assignment_period" header="Assignment Period" style=""></Column>
            <Column field="score" header="Score" style=""></Column>
            <!-- <Column field="achieved_score" header="Achieved Score" style="width: 25%;"></Column> -->
            <Column header="Status" style="">
                <template #body="{ data }">
                    <div v-if="(data.status).toUpperCase() == 'COMPLETED'">
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">{{ data.status }}</span>
                    </div>
                    <div v-else>
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">{{ data.status }}</span>
                    </div>
                    <!-- <button @click="useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }"class=" bg-[#F9BE00] px-4 text-[16px] rounded-md text-[#ffff] h-[35px] font-semibold ">
                        Review</button> -->
                </template>
            </Column>
            <Column field="" header="Actions" style="min-width: 6rem">
                <template #body="{ data }">
                    <!-- <div v-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, 1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">
                        Approved
                    </div>
                    <div v-else-if="useHelper.pmsReviewIsCompleted(data.reviewer_details, currentUserCode, -1)"
                        class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-red-100/20">
                        rejected
                    </div> -->
                    <!-- <div v-else> -->
                    <!-- <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, 1, '')">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>


                        </button>
                        <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                            @click="useStore.teamKpiFormApproval(data.id, -1, '')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </button> -->
                    <div class="flex justify-center items-center">
                        <button v-if="!data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true,useStore.canShowAssigneeReviewForm = false,  useStore.selected_header = data.form_header, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.getSelfTimeLine(currentUserCode, data.id), editsavepublish1 = '', selectedRowdata = data, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false"
                            class="bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]">
                            <i class=" pi pi-eye text-[#000]"></i>
                        </button>
                        <button v-if="data.is_assignee_submitted == 1"
                            @click="useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.selected_header = data.form_header, useStore.getSelfTimeLine(currentUserCode, data.id), view_form_edit_withdraw(data.reviewer_details, data), view_edit_withdraw = 'Review', useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id, data.is_assignee_submitted == 1 ? isFormSubmitted = true : isFormSubmitted = false, canHiddenUploadOptions = false"
                            class=" bg-[#F9BE00] px-4 py-1 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                            Review</button>
                    </div>
                    <!-- <button class="" type="button" @click="edit_withdraw(data.id)"> <i class="pi pi-ellipsis-v"></i>
                    </button> -->
                    <!-- <div v-if="edit === data.id" @mouseleave="edit = ''"
                        class="absolute flex flex-col bg-white shadow-2xl top-4 z-[1000] "
                        style="width: 120px; margin-top:12px !important;margin-right: 20px !important; ">
                        <div class="p-0 m-0 d-flex flex-column">

                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">View</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">Edit</button>
                            <button
                                class=" h-[30px] p-2 font-['poppins'] ! bg-yellow-300 text-[#000]"
                                @click="useStore.teamKpiFormApproval(data.id, 1, '')">Approve</button>
                            <button
                                class=" h-[30px] p-2 text-black font-['poppins'] bg-black text-[#ffff]"
                                @click="useStore.teamKpiFormApproval(data.id, -1, '')">Reject</button>
                        </div>

                    </div> -->
                    <!-- </div> -->
                </template>
            </Column>

        </DataTable>
    </div>

    <Sidebar v-model:visible="visibleRight" position="right" :style="{ width: '60vw !important' }">
        <h2 class="  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 z-1 left-0 bg-[#000] w-[100%]"> Team new
            Goals
            Assign</h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer"
            @click="visibleRight = false"></i>
        <div class="p-2">
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575] my-2">Calendar Type</label>
                    {{ Calendar_Type }}
                    <InputText type="text" v-model="useStore.createNewTeamGoals.calendar_type" disabled
                        class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />
                </div>
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575]  my-2">Year</label>

                    <InputText type="text" v-model="useStore.createNewTeamGoals.year" disabled
                        class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575] my-2">Frequency</label>
                    {{ frequency }}
                    <InputText type="text" v-model="useStore.createNewTeamGoals.frequency" disabled
                        class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                </div>
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575]  my-2">Assignment Period</label>
                    <InputText type="text" v-model="useStore.createNewTeamGoals.assignment_period" disabled
                        class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div class="flex flex-col ">
                    <!-- {{useStore.createNewTeamGoals}} -->

                    <label for="" class=" text-[12px] text-[#757575] my-2">Department</label>
                    <MultiSelect v-model="useStore.createNewTeamGoals.department_id" display="chip"
                        :options="useStore.departmentOptions" optionLabel="name" optionValue="id"
                        @change="filterDepartmentList" placeholder="Select Department" :maxSelectedLabels="10"
                        class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />

                </div>
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575]  my-2">Employee</label>
                    <!-- <MultiSelect v-model="useStore.createNewTeamGoals.assignee_id" display="chip"
                        :options="filteredDepartmentList" optionLabel="name" optionValue="id"
                        placeholder="Select Employee" :maxSelectedLabels="10"
                        class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" /> -->

                    <MultiSelect v-model="useStore.createNewTeamGoals.assignee_id" class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]"  :options="filteredDepartmentList" optionLabel="name" :optionValue=" filteredDepartmentList ?filteredDepartmentList.form_assigned ==1  ?'': id :''"   placeholder="Select Employee" display="chip">
                        <template #option="slotProps">
                            <div class="flex align-items-center justify-between  w-[100%]">
                                <div>{{ slotProps.option.name }}</div>
                                <div v-if=" slotProps.option.form_assigned ==1" class="inline-flex items-center px-3 py-1 font-['poppins'] text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">{{ slotProps.option.form_assigned == 1 ? 'Form Assigned' : '' }}</div>
                            </div>
                        </template>
                    </MultiSelect>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 mt-2">
                <div class="flex flex-col ">
                    <label for="" class=" text-[12px] text-[#757575]  my-2 ">Reviewer</label>
                    <InputText type="text" v-model="useStore.createNewTeamGoals.manager_name" disabled
                        class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                </div>
            </div>
            <div class="  w-[100%] ">
                <hr class=" border-[1px] my-4 ">
                <h1 class=" text-[#000] font-semibold text-[16px]">Goals/ Areas of Development</h1>
                <div class="flex items-center justify-between ">
                    <p class=" text-[12px] text-[#757575] w-[240px]">Select Existing Form from the Drop Down</p>
                    <Dropdown v-model="useStore.createNewTeamGoals.kpi_form_id"
                        :options="useStore.existingKpiFormOptions" optionLabel="form_name" optionValue="id"
                        placeholder="Select KPI form" class="h-10 mx-2 w-[250px]" />
                    <!-- hideObjectiveInput = false -->
                    <button
                        @click="useStore.createNewTeamGoals.kpi_form_id ? (useStore.createKpiForm.form_details.length == 0 ? addMore = true : addMore = false, useStore.createTeamKpiForm = true,useStore.canShowAssigneeReviewForm = false ,canHiddenUploadOptions = true, formvariable = 'View', visibleRight = false, hideObjectiveInput = true, useStore.getKPIFormDetails(useStore.createNewTeamGoals.kpi_form_id)) : showWarn()"
                        class="h-[33px] w-[144px] rounded-[8px] " severity="warning"
                        :class="[useStore.createNewTeamGoals.kpi_form_id ? 'bg-[#F9BE00]' : ' bg-[#DDDDDD] ']">View
                        Form</button>
                </div>
            </div>
            <div class=" flex justify-center h-[200px] my-4">
                <img src="../assests/self_Appraisal.png" alt="" class="">
            </div>

            <div class=" flex items-center justify-center left-[25%]">
                <!-- {{  useStore.createKpiForm.form_details.length }} -->
                <button class=" bg-[#001820] text-[#ffff] rounded-[8px] p-2 mx-4 w-[144px] h-[33px]"
                    @click="useStore.createNewTeamGoals.department_id ? useStore.createNewTeamGoals.assignee_id ? (useStore.createTeamKpiForm = true, canHiddenUploadOptions = true, formvariable = 'Creation', editsavepublish1 = 'save', hideObjectiveInput = true, visibleRight = false, useStore.createKpiForm.form_details = [], addMore = true, useStore.createKpiForm.form_name = `OKR_FORM ` + `_` + currentUserCode + `_` + useService.current_user_name + `_` + useStore.createNewGoals.assignment_period.toUpperCase()) : useHelper.toastmessage('warn', 'Select Employee ') : useHelper.toastmessage('warn', 'Select Department ')  ">
                    Create KPI Form
                </button>
                <!-- {{ useStore.createNewTeamGoals.kpi_form_id }} -->
                <!-- useHelper.toastmessage('error', 'This form doesn t contain any data.') :  -->
                <!-- (useStore.publishForm(current_user_code), visibleRight = false, addMore = false, useStore.createTeamKpiForm = false, useStore.createNewTeamGoals.kpi_form_id = '')  -->
                <!-- {{useStore.employeefilter(useStore.createNewTeamGoals.assignee_id)}} -->
                <button class=" text-[#000] rounded-[8px] w-[144px] !h-[33px]"
                    :class="[useStore.createNewTeamGoals.kpi_form_id ? 'bg-[#F9BE00]' : 'bg-[#DDDD]']"
                    @click="useStore.createNewTeamGoals.department_id ? useStore.createNewTeamGoals.assignee_id ? useStore.createNewTeamGoals.kpi_form_id ?  (useStore.publishTeamForm(current_user_code,2), visibleRight = false, addMore = false, useStore.createTeamKpiForm = false, useStore.createNewTeamGoals.kpi_form_id = '',filteredDepartmentList='') : useHelper.toastmessage('error', 'Select KPI form') : useHelper.toastmessage('warn', 'Select Employee ') : useHelper.toastmessage('warn', 'Select Department ') ">
                    Publish</button>
            </div>
        </div>
    </Sidebar>

    <Sidebar v-model:visible="useStore.createTeamKpiForm" position="right" class="relative !z-0"
        :style="{ width: '80vw !important', zindex: '0 !important' }">
        <h2
            class=" flex justify-between text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%] ">
            KPI OR OKR Form {{ formvariable }}
            <i class="pi pi-times text-blue-200" type="button" @click="sidebar_team_popup = true"
                style="font-size:1rem"></i>
        </h2>
        <div class="  w-[100%] p-2 ">
            <!-- timeline when edit form shows -->
            <div class=" my-[3rem]">
                <div class=" flex justify-between items-center " v-if="formvariable == 'view' && !useStore.canShowAssigneeReviewForm ">
                    <div class=" flex justify-center items-center  " :class="index == 0 ? '' : 'w-full'"
                        v-for="(item, index) in useStore.SelfTimeLine">
                        <div class="border-[1px] border-dashed border-[#82AB7B]  w-[100%]  "
                            :class="index == 0 ? ' border-[1px] border-dashed border-[#ffff]' : ''">
                            <!-- :class="index == 0 ? 'hidden' : ''" -->
                        </div>
                        <!-- xl:w-[120px] lg:w-[100px] md:w-[50px] -->
                        <div class=" flex flex-col relative">
                            <button
                                class=" py-2 rounded-md font-[poppins] px-2 w-[160px]  text-center whitespace-nowrap"
                                :class="[(item.status == 1 || item.status == true) ? 'bg-[#82AB7B] text-[#ffff] ' : item.status == 0 ? 'border-[1px] bg-[white] border-[rgb(130,171,123)] text-[#82AB7B]' : ' bg-[#E6E6E6] text-[#8B8B8B]']">
                                {{ item.title }}
                            </button>

                            <div
                                class=" !text-[9px] absolute left-0 w-[200px] top-[34px] flex justify-start text-gray-500 font-['poppins'] ">
                                EXP: {{ item.expected_date }} -<span class=" text-[red] !text-[9px]">{{ item.actual_date
                                }}
                                </span></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="flex flex-col" v-if="canHiddenUploadOptions">
                <h1 class=" text-[#000] font-semibold text-[16px] my-2">Goals/ Areas of Development</h1>
                <div class="flex items-center justify-between">
                    <div class="flex item-center">
                        <input type="file" accept=".xlsx" class=" w-[250px] form-control file"
                            @change="useHelper.convertExcelIntoArray($event)" />
                        <button class=" bg-[#F9BE00] h-[33px] w-[144px] text-[#000] rounded-[8px] mx-[20px]">
                            <i class="pi pi-upload"></i> Upload</button>
                    </div>
                    <div class="flex items-center justify-center ">
                        <p class=" text-[#000] mx-2 text-end font-['poppins']">Download the</p>
                        <button @click="useStore.downloadSampleForm(currentUserCode)"
                            class="bg-yellow-400 text-[#000] rounded-md p-2 h-[33px] w-[184px]">
                            <i class="pi pi-download"></i> Sample File</button>
                    </div>
                </div>
            </div>
            <div class="flex items-end justify-end">
                    <button v-if="selectedRowdata ? selectedRowdata.status=='Completed' || selectedRowdata.status== 'Employee Self Reviewed' : null"  @click="useStore.btn_download = !useStore.btn_download, useStore.downloadFormPMSReport()"
                            class="bg-yellow-400 text-[#000] rounded-md py-2 px-2 h-[33px] w-[100px]">
                            <i class="pi pi-download"></i> <span class=" mx-1"></span>Report</button>

                </div>

            <div v-if="canHiddenUploadOptions">
                <div class="my-3 ">
                    <hr class=" border-[1px] w-[100%] ">
                </div>
                <div class="flex items-center my-2" v-if="hideObjectiveInput">
                    <h1 class="font-semibold flex items-center"> Enter the Form Name <span
                            class=" text-[red] text-[20px]">*</span></h1>
                    <InputText type="text" v-model="useStore.createKpiForm.form_name" class="h-10 mx-4 w-[60%] "
                        placeholder="Enter the Form Name" />
                </div>
                <div v-else class="flex items-center my-2">
                    <h1 class="flex items-center font-['poppins']">Form Name :</h1>
                    <span class=" font-semibold  mx-2 font-['poppins']"> {{ useStore.createKpiForm.form_name }}</span>
                </div>
                <div class="p-2 mb-[12px] ">
                    <hr class=" border-[1px] w-[100%] ">
                </div>
            </div>


            <!-- Accordion -->

            <div v-if="useStore.canShowAssigneeReviewForm" class="">
                <div v-if="useStore.createKpiForm.form_details" class="my-3">
                    <div class=" flex justify-between items-center ">
                        <div class=" flex justify-center items-center border-[#000]  "
                            :class="index == 0 ? '' : 'w-full'" v-for="(item, index) in useStore.SelfTimeLine">
                            <div class="border-[1px] border-dashed border-[#82AB7B]  w-[100%]  "
                                :class="index == 0 ? ' border-[1px] border-dashed border-transparent' : ''">
                            </div>
                            <div class=" flex flex-col relative">
                                <button
                                    class=" py-2 rounded-md font-[poppins] px-2 w-[160px]  text-center whitespace-nowrap"
                                    :class="[(item.status == 1 || item.status == true) ? 'bg-[#82AB7B] text-[#ffff] ' : item.status == 0 ? 'border-[1px] bg-[white] border-[rgb(130,171,123)] text-[#82AB7B]' : ' bg-[#E6E6E6] text-[#8B8B8B]']">
                                    {{ item.title }}
                                </button>
                                <div
                                    class=" !text-[9px] absolute left-0 w-[200px] top-[34px] flex justify-start text-gray-500 font-['poppins'] ">
                                    EXP: {{ item.expected_date }} -<span class="  !text-[9px]"
                                        :class="item.is_overdue === 0 ? ' text-[green]' : 'text-[red]'">{{
                                            item.actual_date
                                        }}
                                    </span></div>
                            </div>
                        </div>
                    </div>
                    <!-- {{ useStore.selected_header }} -->
                    <div v-if="useStore.createKpiForm.form_details">
                        <!-- {{ useStore.createKpiForm.form_details }} -->
                        <!-- {{ calculateTotalKpiWeightage(useStore.createKpiForm.form_details) }} -->

                        <div class=" grid grid-cols-12 gap-4 py-3 px-4  bg-[#DDDD] rounded-md mb-[10px] mt-[30px]"
                            v-if="useStore.selected_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                            <div class="" v-for="(headerRecord, headerIndex) in useStore.selected_header"
                                :class="[0, 1].includes(headerIndex) ? 'col-span-3 flex item-center justify-start' : [2, 4].includes(headerIndex) ? 'col-span-2 flex item-center justify-center' : 'col-span-2 '">
                                <h1 class="text-[13px] flex items-center font-semibold ">
                                    {{
                                        headerRecord ?
                                        headerRecord.alias_name
                                            ?
                                            headerRecord.alias_name :
                                            headerRecord.header_label ?
                                                headerRecord.header_label :
                                                null : null
                                    }}

                                </h1>
                                <p class="text-center font-semibold flex items-center"
                                    v-if="headerRecord ? headerRecord.header_name == 'kpi_weightage' : ''">
                                    <span class=" text-gray-400 font-['poppins'] ">Overall -</span>
                                    <span class="font-['poppins']"
                                        :class="[reviewTotalKpiWeightage >= 100 ? ' text-green-500' : '']"> {{
                                            reviewTotalKpiWeightage ? reviewTotalKpiWeightage : ''  }} %</span>
                                </p>
                            </div>
                            <div class=" relative top-[10px] right-[-10px]">
                                <h1 class="text-lg font-semibold flex items-center">
                                    Comments
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="accordion">
                        <div v-for="(form_details, index) in formatConverter(useStore.createKpiForm.form_details) "
                            :key="index">

                            <div class="accordion-item my-2">
                                <div class="accordion-header items-center flex justify-center"
                                    @click="toggleItem(index)">
                                    <span> <i class="pi pi-chevron-right ml-2 mx-2"
                                            :class="activeItem === index ? ' delay-100 rotate-[90deg]' : ''"></i>
                                    </span>
                                    <!-- {{  }} -->
                                    <!-- {{ filterWantedField(form_details, ['id', 'record_id', 'reviews_review'])}} -->
                                    <!-- {{findSelectedHeaderIsEnabled(form_details,
                                                                'target').value}} -->
                                                                <!-- {{findSelectedHeaderIsEnabled(form_details,
                                                                'value')}} -->

                                    <div class=" grid grid-cols-12  gap-2  !font-['poppins'] "
                                        v-for="(singleRecord, recordIndex) in filterWantedField(form_details, ['id', 'record_id', 'reviews_review'])">
                                        <div class="  flex justify-start !line-clamp-4  h-[100%]"
                                            :class="[0, 1].includes(recordIndex) ? ' w-[250px] ' : 'w-[120px]'">
                                            <!-- {{ singleRecord.value }} -->

                                            <h1 v-if="!['id', 'record_id', 'assignee_review'].includes(singleRecord.title) && expandContent(recordIndex, index, singleRecord.value)"
                                                v-tooltip="singleRecord.value" class="text-[12px] text-[#000]  my-1 ">
                                                <!-- {{ singleRecord.value ? singleRecord.value.length > 20 ?
                                                    singleRecord.value.substring(0,
                                                        20) + '..' : singleRecord.value : '' }} -->
                                                {{ singleRecord.value }}
                                                <button class=" text-blue-400 font-['poppins']"
                                                    @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                                    v-if="singleRecord.value.length > 200 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                            </h1>

                                            <h1 v-tooltip="singleRecord.value"
                                                v-if="!['id', 'record_id', 'assignee_review'].includes(singleRecord.title) && !expandContent(recordIndex, index, singleRecord.value)"
                                                class="font-['poppins'] !line-clamp-1 !break-all text-[12px]">
                                                {{ singleRecord.value ?
                                                    singleRecord.value.length
                                                        > 80
                                                        ?
                                                        singleRecord.value.substring(0,
                                                            80) + `.. ` : singleRecord.value : '' }}
                                                <span class="mx-1" v-if="singleRecord.title == 'kpi_weightage'">%</span>
                                                <button
                                                    @click="canShowMoreContentIndex = recordIndex, canShowMoreContentRowIndex = index"
                                                    class="text-blue-400 font-['poppins']"
                                                    v-if="singleRecord.value.length > 80 && !expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">more...</button>
                                            </h1>

                                            <div class="w-[170px]"
                                                v-if="['assignee_review'].includes(singleRecord.title)">
                                                <h1 v-tooltip="singleRecord.value.comments"
                                                    class="text-[12px] text-[#000]  my-1 ">
                                                    {{ singleRecord.value.comments ? singleRecord.value.comments.length
                                                        > 20
                                                        ?
                                                        singleRecord.value.comments.substring(0,
                                                            20) + '..' : singleRecord.value.comments : '' }}
                                                </h1>
                                            </div>
                                        </div>


                                        <!-- <div class=" flex justify-center !line-clamp-4  h-[100%]"
                                            v-for="(singleRecord, recordIndex) in  filterWantedField(formDetails, ['id', 'record_id', 'assignee_review', 'reviews_review'])"
                                            :class="[0, 1].includes(recordIndex) ? '  col-span-3  mx-5' : [2, 4].includes(recordIndex) ? ' mx-[3rem] col-span-2   ' : recordIndex == filterWantedField(formDetails, ['id', 'record_id', 'assignee_review']).length ? 'col-span-1' : 'col-span-1 '">

                                            <div v-if="!isEditing(index)"
                                                class="text-[16px] text-[#000] font-['poppins'] max-w-xs  my-2 flex justify-center items-center "
                                                :class="readMoreTitle == singleRecord.title ? ' ' : ''">
                                                <p v-if="expandContent(recordIndex, index, singleRecord.value) && !isEditing(index) &&  !['id', 'record_id', 'assignee_review'].includes(singleRecord.title)"
                                                    class=" !break-all ">
                                                    {{ singleRecord.value }}
                                                    <button class=" text-blue-400 font-['poppins']"
                                                        @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                                        v-if="singleRecord.value.length > 100 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                                </p>

                                                <span v-else
                                                    class="font-['poppins'] line-clamp-1  !line-clamp-1   !break-all ">
                                                    {{ singleRecord.value ?
                                                        singleRecord.value.length
                                                            > 80
                                                            ?
                                                            singleRecord.value.substring(0,
                                                                80) + `.. ` : singleRecord.value : '' }}

                                                    <span class="mx-1"
                                                        v-if="singleRecord.title == 'kpi_weightage'">%</span>

                                                    <button
                                                        @click="canShowMoreContentIndex = recordIndex, canShowMoreContentRowIndex = index"
                                                        class="text-blue-400 font-['poppins']"
                                                        v-if="singleRecord.value.length > 80 && !expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">more...</button>
                                                </span>


                                            </div>

                                            <Textarea
                                                v-if="['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                                @input="updateValue(index, singleRecord.title, $event.target.value)"
                                                v-model="singleRecord.value" rows="3"
                                                :cols="['dimension'].includes(singleRecord.title) ? 30 : 20"
                                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" />

                                            <InputText
                                                @input="updateValue(index, singleRecord.title, $event.target.value)"
                                                type="text" v-model="singleRecord.value"
                                                v-else-if="!['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                                class=" h-10 !bg-[#DDDDDD] !border-[rgb(246,246,246)]  p-2" />

                                            <div>
                                            </div>
                                        </div> -->


                                    </div>


                                    <!-- <span class="accordion-icon">{{ activeItem === index ? '-' : '+' }}</span> -->
                                </div>
                                <!-- {{findSelectedHeaderIsEnabled(form_details, 'assignee_review').value.kpi_review}} -->
                                <Transition>
                                    <div v-if="activeItem === index"
                                        :class="activeItem === index ? ' !delay-200 ' : 'delay-200'"
                                        class="accordion-content bg-[#fff7eb] !font-['poppins'] border-[1px] ">
                                        <div class="grid grid-cols-12 items-center"
                                            v-if="findSelectedHeaderIsEnabled(form_details, 'assignee_review').value">
                                            <div class="flex justify-start col-span-6 p-[20px]">
                                                <div class="flex items-center justify-start">
                                                    <h1 class="text-[#8B8B8B] mx-2">
                                                        {{ findSelectedHeaderIsEnabled(form_details,
                                                            'assignee_review').value.reviewer_level }} -</h1>
                                                    <h1 class=" text-[#000] mx-2 ">
                                                        {{
                                                            findSelectedHeaderIsEnabled(form_details,
                                                                'assignee_review').value.assignee_name
                                                        }}

                                                    </h1>
                                                    <h1 class="text-[#000] mx-2 ">({{
                                                        findSelectedHeaderIsEnabled(form_details,
                                                            'assignee_review').value.assignee_code
                                                    }})
                                                    </h1>
                                                </div>
                                            </div>

                                            <div class="col-span-2 flex justify-center">
                                                {{ singleRecord }}
                                                {{ findSelectedHeaderIsEnabled(form_details,
                                                    'assignee_review').value.kpi_review }}
                                            </div>
                                            <div class="col-span-2 flex justify-center">
                                                <h1 class="text-[12px] text-[#000]  my-1 ">
                                                    {{ findSelectedHeaderIsEnabled(form_details,
                                                        'assignee_review').value.kpi_percentage
                                                    }}
                                                </h1>
                                            </div>
                                            <div class="col-span-2">
                                                {{ findSelectedHeaderIsEnabled(form_details,
                                                    'assignee_review').value.kpi_comments }}
                                            </div>
                                        </div>
                                        <!-- Reviewer review -->
                                        <!-- {{findSelectedHeaderIsEnabled(form_details, 'reviews_review').value}} -->
                                        <div class=" border-[1px] p-3  mt-3 bg-[#ffe9c8ca]"
                                            v-for="(reviewer, reviewerIndex) in findSelectedHeaderIsEnabled(form_details, 'reviews_review').value"
                                            v-if="findSelectedHeaderIsEnabled(form_details, 'reviews_review').value">
                                            <div class="grid grid-cols-12 items-center">
                                                <div class="flex justify-start col-span-6">
                                                    <div class="flex items-center justify-center">
                                                        <h1 class="text-[#8B8B8B] mx-2">{{ reviewer.reviewer_level }} -
                                                        </h1>
                                                        <h1 class=" text-[#000] mx-2 ">
                                                            {{ reviewer.reviewer_name }}
                                                        </h1>
                                                        <h1 class="text-[#000] mx-2 ">
                                                            {{ reviewer.reviewer_code }}
                                                        </h1>
                                                    </div>
                                                </div>
                                                <div class="col-span-2 flex justify-center  relative">
                                                    <span v-if="selectedRowdata.is_reviewer_submitted == 1">{{
                                                        reviewer.kpi_review }}</span>
                                                    <InputText
                                                        v-if="findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(form_details,
                                                                'target') ? findSelectedHeaderIsEnabled(form_details,
                                                                'target').value : '') && selectedRowdata.is_reviewer_submitted == ''"
                                                        @focusout="updateAssigneeFormNumberOrAlpha(index, reviewerIndex, 'kpi_review', $event.target.value), review_save = 'save', useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'reviews_review') ? findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value.id : '', currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review') ? findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target : '', currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review') ? findSelectedHeaderIsEnabled(formDetails, 'target').value : '', reviewTotalKpiWeightage)"
                                                        type="text" v-model="reviewer.kpi_review"
                                                        class=" h-10 w-24 bg-[#F6F6F6]   p-2" />
                                                    <InputText
                                                        v-if="!findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(form_details,
                                                                'target') ? findSelectedHeaderIsEnabled(form_details,
                                                                'target').value : '') && selectedRowdata.is_reviewer_submitted == ''"
                                                        @focusout="updateReviewerForm(index, reviewerIndex, 'kpi_review', $event.target.value), review_save = 'save', currentlyRecords, reviewTotalKpiWeightage"
                                                        type="text" v-model="reviewer.kpi_review"
                                                        class=" h-10 w-24 bg-[#F6F6F6]   p-2  " />
                                                </div>
                                                <div class="col-span-2 flex justify-center">
                                                    <!-- {{ reviewer.kpi_percentage }} -->
                                                    <!-- If employee entered target is text then we will allow employee to fill target in text -->
                                                    <!-- <InputText v-if="selectedRowdata.is_assignee_submitted = 1"
                                                @focusout="updateReviewerForm(index, 'kpi_percentage', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(form_details, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'kpi_weightage').value), calculateTotalReviewerKpiWeightage(useStore.createKpiForm.form_details)"
                                                type="text" v-model="reviewer.kpi_percentage"
                                                class=" h-10 w-24 my-2 !bg-[#DDDDDD] !border-[rgb(246,246,246)]  p-2" /> -->

                                                    <!-- If employee entered target is Number then we will allow employee to fill target in Number -->
                                                    <!-- <h1 v-else class="text-[12px] text-[#000]  my-1 ">
                                                {{ findSelectedHeaderIsEnabled(form_details,
                                                    'assignee_review').value.kpi_percentage
                                                }}
                                            </h1> -->
                                                    <!-- <span v-if="selectedRowdata.is_reviewer_submitted == 1">{{reviewer.kpi_percentage}}</span> -->

                                                    <p class="absolute top-[-25px] text-[#8b8b8b] font-['poppins']">{{
                                                        selectedRowdata.is_assignee_submitted == 1 ? ' Achieved KPI ' :
                                                        ''
                                                    }}</p>
                                                    <!-- If employee entered target is text then we will allow employee to fill target in text -->
                                                    <!-- readonly -->
                                                    <!-- findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(form_details, 'assignee_review').value.kpi_review) -->
                                                    <InputText
                                                        v-if="selectedRowdata.is_assignee_submitted == 1 && selectedRowdata.is_reviewer_submitted == ''"
                                                        @focusout="updateAssigneeFormKpi(index, 'kpi_percentage', $event.target.value), review_save = 'save', useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                        type="text" v-model="reviewer.kpi_percentage"
                                                        class=" h-10 w-24 my-2 bg-[#F6F6F6]  !border-[rgb(246,246,246)]  p-2" />

                                                    <!-- If employee entered target is Number then we will allow employee to fill target in Number -->
                                                    <h1 v-else class="text-[12px] text-[#000]  my-1 ">
                                                        <!-- {{ findSelectedHeaderIsEnabled(formDetails,'reviews_review').value.kpi_percentage == null ? '' : findSelectedHeaderIsEnabled(formDetails,'reviews_review').value.kpi_percentage }} -->
                                                        {{ reviewer.kpi_percentage }}
                                                    </h1>
                                                </div>
                                                <div class="col-span-2 ">
                                                    <Textarea @focusout="review_save = 'save'"
                                                        v-if="selectedRowdata.is_assignee_submitted == 1 && selectedRowdata.is_reviewer_submitted == ''"
                                                        v-model="reviewer.kpi_comments" rows="2" cols="10"
                                                        class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]  p-2" />
                                                    <!-- {{ reviewer.kpi_comments }} -->
                                                </div>
                                            </div>

                                        </div>

                                        <!-- {{ item.reviews_review }} -->


                                        <!-- <h1 v-for="(items,indexs) in item.reviews_review" :key="indexs"  >
                                    {{items.reviewer_code}} {{ items.reviewer_name }}
                                    </h1> -->
                                    </div>
                                </Transition>
                            </div>
                        </div>
                    </div>



                    <!-- {{useStore.createKpiForm}} -->
                    <div class=" flex justify-center items-center my-4"
                        v-if="selectedRowdata.is_reviewer_submitted == ''">
                        <button class=" border-[1px] border-[#000] font-['poppins'] mx-2 rounded-md p-2"
                            @click="useStore.createTeamKpiForm = false, useStore.canShowAssigneeReviewForm = false">cancel</button>
                        <button class="bg-yellow-400 text-[white] font-['poppins']  mx-2 rounded-md px-3 py-2"
                            @click="useStore.saveTeamAppraisalReview(useStore.createKpiForm.form_details, 0), review_save = 'submit'"
                            v-if="review_save == 'save'">Save</button>
                        <button class="bg-yellow-400 text-[white] font-['poppins']  mx-2 rounded-md px-3 py-2"
                            @click="useStore.saveTeamAppraisalReview(useStore.createKpiForm.form_details, 1)"
                            v-if="review_save == 'submit'">Submit</button>
                    </div>

                </div>
            </div>

            <div v-else>
                <div v-if="useStore.createKpiForm.form_details">
                    <!-- {{ calculateTotalKpiWeightage(useStore.createKpiForm.form_details) }} -->
                    <!-- {{ useStore.createKpiForm.form_details }} -->
                    <div class=" grid grid-cols-12 gap-4 py-3 px-4 my-2 bg-[#DDDD] rounded-md font-['poppins']"
                        v-if="useStore.selected_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                        <div class=" " v-for="(headerRecord, headerIndex) in useStore.selected_header"
                            :class="[0, 1].includes(headerIndex) ? ' col-span-3 flex items-center justify-start ' : [2, 4].includes(headerIndex) ? 'col-span-2 flex items-center justify-start ' : ' col-span-1 flex flex-col items-center justify-center'">
                            <h1 class="text-sm font-semibold text-center"
                                v-if="headerRecord.title != 'record_id' && headerRecord.title != 'assignee_review'">
                                {{
                                    headerRecord ?
                                    headerRecord.alias_name
                                        ?
                                        headerRecord.alias_name :
                                        headerRecord.header_label ?
                                            headerRecord.header_label :
                                            null : null
                                }}
                            </h1>
                            <p class="text-center"
                                v-if="headerRecord ? headerRecord.header_name == 'kpi_weightage' : ''"
                                :class="headerRecord ? headerRecord.header_name == 'kpi_weightage' ? calculateTotalKpiWeightage > 100 ? ' text-red-500' : null : null : null">
                                Overall {{ calculateTotalKpiWeightage }} %
                            </p>

                        </div>
                        <div>
                            <!-- <p class="text-center text-lg font-semibold "
                                v-if="selectedRowdata.is_assignee_submitted != '' && selectedRowdata.is_reviewer_accepted != 1">
                                Actions
                            </p> -->
                        </div>
                    </div>

                    <div class="rounded-lg bg-[#FFF7EB] grid grid-cols-12 gap-4 p-4 my-2 relative  "
                        v-for="(formDetails, index) in formatConverter(useStore.createKpiForm.form_details)"
                        @mouseleave="op = 'sd'">
                        <div class=" flex justify-center !line-clamp-4"
                            v-for="(singleRecord, recordIndex) in  filterWantedField(formDetails, ['id', 'record_id'])"
                            :class="[0, 1].includes(recordIndex) ? '  col-span-3 ' : [2, 4].includes(recordIndex) ? 'col-span-2' : recordIndex == filterWantedField(formDetails, ['id', 'record_id']).length ? 'col-span-2' : 'col-span-1'">
                            <!-- {{ singleRecord }} -->
                            <div v-if="!isEditing(index)"
                                class="text-[16px] text-[#000] font-['poppins'] max-w-xs  my-2"
                                :class="readMoreTitle == singleRecord.title ? ' ' : ''">
                                <p v-if="expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)"
                                    class=" !break-all">
                                    <!-- <Textarea v-model="singleRecord.value" :rows="2"
                                    :cols="['dimension'].includes(singleRecord.title) ? 30 : 20"
                                    class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" /> -->
                                    {{ singleRecord.value }}
                                    <button class=" text-blue-400 font-['poppins']"
                                        @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                        v-if="singleRecord.value.length > 20 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                </p>
                                <!-- !line-clamp-4  -->
                                <span v-else class="font-['poppins'] line-clamp-1  !line-clamp-1   !break-all ">
                                    <!-- {{singleRecord.value}} -->
                                    {{ singleRecord.value ?
                                        singleRecord.value.length
                                            > 100
                                            ?
                                            singleRecord.value.substring(0,
                                                100) + `.. ` : singleRecord.value : '' }}

                                    <span class="mx-1" v-if="singleRecord.title == 'kpi_weightage'">%</span>

                                    <button
                                        @click="canShowMoreContentIndex = recordIndex, canShowMoreContentRowIndex = index"
                                        class="text-blue-400 font-['poppins']"
                                        v-if="singleRecord.value ? singleRecord.value.length > 200 : '' && !expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">more...</button>
                                </span>


                            </div>

                            <Textarea v-if="['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                @input="updateValue(index, singleRecord.title, $event.target.value)"
                                v-model="singleRecord.value" rows="3"
                                :cols="['dimension'].includes(singleRecord.title) ? 30 : 20"
                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" />

                            <InputText @input="updateValue(index, singleRecord.title, $event.target.value)" type="text"
                                v-model="singleRecord.value"
                                v-else-if="!['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                class=" h-10 !bg-[#DDDDDD] !border-[rgb(246,246,246)] w-[100px]  p-2" />

                            <div>
                            </div>
                        </div>



                        <!-- {{ useStore.createKpiForm }} -->
                        <!-- {{ useStore.createKpiForm.form_details[index]['record_id'] }} -->
                        <!-- && selectedRowdata.is_assignee_submitted != '' && selectedRowdata.is_reviewer_accepted != 1 -->
                        <div class="flex justify-center items-center col-span-2 absolute right-10 top-10 "
                            v-if="formvariable == 'Creation' || formvariable == 'View' || formvariable == 'view'">
                            <i class="pi pi-file-edit mx-2 cursor-pointer "
                                @click="selectedEditIndex = index, editsavepublish1 = 'save', enableApproveReject = false"
                                v-if="!isEditing(index)"></i>

                            <!-- useStore.updateFormRowDetails(useStore.createKpiForm.form_details[index]['record_id'], useStore.createKpiForm.form_details[index]), -->
                            <!-- useStore.updateFormRowDetails(useStore.createKpiForm.form_details[index]['id'], useStore.createKpiForm.form_details[index]), -->
                            <!-- useStore.deleteFormRowDetails(useStore.createKpiForm.form_details[index]['record_id']), -->
                            <i class="pi pi-check  mx-2 cursor-pointer " v-if="isEditing(index)"
                                @click="useStore.createKpiForm.form_details[index], selectedEditIndex = null, editsavepublish1 = 'save'"></i>
                            <!-- <i @click=" calculateTotalKpiWeightage(useStore.createKpiForm.form_details), selectedEditIndex = null"
                                v-if="isEditing(index)"></i> -->
                            <i class="pi pi-trash text-[red] mx-2 cursor-pointer"
                                @click=" removeTodo(useStore.createKpiForm.form_details, index)"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-2 "
                        v-if="useStore.selected_header && formvariable == 'Creation' ? (addMore ? true : false) : true || formvariable == 'Edit' ? (addMore ? true : false) : true || formvariable == 'View' ? (addMore ? true : false) : true">
                        <div class="flex flex-col" v-for="(header, i) in useStore.selected_header" :key="i">
                            <label for="" class="text-[12px] text-[#757575]  my-2">{{ header.alias_name ?
                                header.alias_name : header.header_label }}
                            </label>
                            <!-- {{header  }} -->
                            <InputText v-if="['kpi_weightage'].includes(header.header_name)" type="text"
                                v-model="useStore.addKra[header.header_name]"
                                class=" h-10 !bg-[#f6f6f6] border-[1px] border-[#dddddd]  p-2"
                                @keypress="isNumber($event)" @input="() => {
                                    if (useStore.addKra[header.header_name] > 100) {
                                        useStore.addKra[header.header_name] = null
                                    } else if (useStore.addKra[header.header_name] == 0) {
                                        useStore.addKra[header.header_name] = null
                                    }
                                }"
                                :class="[v$[header.header_name].$error ? 'p-invalid' : '!border-[rgb(246,246,246)] ',]" />
                            <Textarea v-else-if="['dimension', 'kra'].includes(header.header_name)"
                                v-model="useStore.addKra[header.header_name]" rows="3" cols="30"
                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" />
                            <InputText v-else type="text" v-model="useStore.addKra[header.header_name]"
                                class=" h-10 !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" :class="[
                                    v$[header.header_name].$error ? 'p-invalid' : '!border-[rgb(246,246,246)]',
                                ]" />
                            <span v-if="v$[header.header_name].$error" class="font-semibold text-red-400 fs-6">
                                {{ v$[header.header_name].required.$message.replace("Value", header.alias_name ?
                                    header.alias_name : header.header_label) }}
                            </span>
                            <div>
                            </div>
                        </div>
                        <div class=" flex justify-start items-center relative top-[14px]  ">
                            <button class=" bg-[#F9BE00] text-[#000] py-2 px-4 h-[33px] rounded-md "
                                @click="submitForm(arr), editsavepublish1 = 'save'"> <i class="pi pi-check"></i>
                            </button>
                            <button v-if="useStore.createKpiForm.form_details.length > 0"
                                @click="cancel_team_popup = true"
                                class=" mx-2 bg-[#000] text-[white] py-2 px-4 h-[33px] rounded-md">
                                <i class="pi pi-times"></i> </button>
                        </div>
                    </div>
                    <div class="flex justify-center my-[40px]"
                        v-if="formvariable == 'Creation' || formvariable == 'View' || formvariable == 'view' || formvariable == 'Reject Edit option'">
                        <button
                            class=" border-[1px] border-[#000]  p-3 box-border text-[13px] rounded-md text-[#000] !w-[120px] h-[35px] font-semibold flex justify-center items-center "
                            v-if="formvariable == 'Creation' || formvariable == 'View' || formvariable == 'Reject Edit option'"
                            @click="addMore = true">
                            <i class="pi pi-plus" style="font-size: 1rem"></i>
                            <p>Add more</p>
                        </button>
                        <!-- {{formvariable}} -->
                        <button
                            v-if="formvariable == 'view' && editsavepublish1 == 'save' ? selectedRowdata ? (selectedRowdata.is_reviewer_accepted != 1) : '' : editsavepublish1 == 'save' && formvariable == 'Creation'"
                            @click="useStore.createKpiForm.form_name ? calculateTotalKpiWeightage == 100 ? (calculateKpiWeightage(useStore.createKpiForm.form_details), editsavepublish1 = 'publish', enableApproveReject = true) : useHelper.toastmessage('error', 'The combined weightage of KPIs or OKRs must equal to 100%') : useHelper.toastmessage('error', 'Form Name field is required.')"
                            class="text-[#000]  py-2 px-4 rounded-md mx-2"
                            :class="[calculateTotalKpiWeightage == 100 ? 'bg-[#F9BE00]' : 'bg-[#dddd]']">Save</button>
                        <!-- {{calculateTotalKpiWeightage}} -->

                        <button v-if="editsavepublish1 == 'publish' && formvariable != 'view'"
                            class="  rounded-[8px] w-[144px] !h-[33px] mx-2"
                            :class="[useStore.currentlySavedFormId ? 'bg-[#000] text-[#ffff]' : 'bg-[#DDDD] text-[#000]']"
                            @click="useStore.currentlySavedFormId ? useStore.createNewGoals ? (useStore.publishForm(current_user_code), visibleRight = false, useStore.createTeamKpiForm = false) : '' : useHelper.toastmessage('error', 'Save the form to Publish')">
                            Publish</button>
                        <button class="text-[#000]  py-2 px-4 rounded-md mx-2 "
                            :class="[calculateTotalKpiWeightage == 100 ? enableApproveReject == true ? ' bg-[#F9BE00]' : 'bg-[#DDDD]' : 'bg-[#DDDD]']"
                            v-if="formvariable == 'view' && selectedRowdata.is_reviewer_accepted == ''"
                            @click="calculateTotalKpiWeightage == 100 ? enableApproveReject === true ? (useStore.teamKpiFormApproval(selectedRecordId, 1, ''), useStore.createTeamKpiForm = false, visibleRight = false, editsavepublish1 = '') : useHelper.toastmessage('error', '') : useHelper.toastmessage('error', 'The combined weightage of KPIs or OKRs must equal to 100%')">Approve</button>

                        <!-- {{ useStore.teamDashboardPublishedFormList[0].is_reviewer_accepted}} -->
                        <!-- {{selectedRowdata.is_reviewer_accepted == 1 && selectedRowdata.is_assignee_submitted == '' }} -->
                        <button class="text-[#fff]  py-2 px-4 rounded-md mx-2 bg-black "
                            v-if="formvariable == 'view' && selectedRowdata.is_reviewer_accepted == ''"
                            @click="reject_popup = true">Reject</button>

                        <!-- {{selectedRowdata.is_reviewer_accepted}} -->
                        <!-- useStore.teamKpiFormApproval(selectedRecordId, -1, ''),useStore.createTeamKpiForm=false,visibleRight=false" , -->
                        <!-- {{ selectedRowdata.is_reviewer_accepted }}
                    {{ selectedRowdata.reviewer_details[0].review_order }}
                    {{ selectedRowdata.reviewer_details[0].review_order.is_reviewed }}
                    {{selectedRowdata.reviewer_details[0].is_accepted}} -->

                        <!--
                    {{selectedRowdata.is_reviewer_accepted ,selectedRowdata.reviewer_details[0].review_order, selectedRowdata.reviewer_details[0].review_order }} -->

                        <button class="text-[#fff]  py-2 px-4 rounded-md mx-2 bg-black"
                            v-if="formvariable == 'view' && selectedRowdata.is_assignee_submitted === '' && selectedRowdata.is_reviewer_accepted == 1"
                            @click="revoke_popup = true">Revoke</button>
                        <!-- {{selectedRowdata}} -->
                    </div>
                </div>
            </div>

        </div>
    </Sidebar>

    <!-- sidebar popup -->

    <Dialog v-model:visible="sidebar_team_popup" modal :style="{ width: '30rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" class="m-0 p-0 relative  shadow-md rounded-t-full">
        <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden ">
            <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#9DC284] flex justify-center items-center  "
                :style="{ height: '9rem' }">
                <i type='button' @click="sidebar_team_popup = false" class="pi pi-times text-white"
                    style="font-size: 3rem"></i>
            </div>
            <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border   "
                :style="{ height: '19rem' }">
                <p class="text-center font-bold text-2xl pt-4 box-border">Close</p>
                <p class="text-center font-bold text-lg">Are you sure you want to close this Sidebar?</p>
                <div class="flex justify-center items-center pt-6 gap-3">
                    <button type="button"
                        class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                        @click="(formvariable == 'view' ? (useStore.createTeamKpiForm = false, visibleRight = false) : (formvariable == 'Creation' ? (useStore.createTeamKpiForm = false, visibleRight = true) : (useStore.createTeamKpiForm = false, visibleRight = false))), sidebar_team_popup = false">Yes</button>
                    <button type="button"
                        class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        @click="sidebar_team_popup = false">Cancel</button>
                </div>
            </div>
        </div>
    </Dialog>

    <!-- cancel popup -->
    <Dialog v-model:visible="cancel_team_popup" modal :style="{ width: '30rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        class="m-0 p-0 relative  shadow-md rounded-t-full h-[400px]">

        <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden ">
            <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#9DC284] flex justify-center items-center  "
                :style="{ height: '9rem' }">
                <i type='button' @click="cancel_team_popup = false" class="pi pi-times text-white"
                    style="font-size: 3rem"></i>
            </div>
            <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border   "
                :style="{ height: '19rem' }">
                <p class="text-center font-bold text-2xl pt-4 box-border">Delete</p>
                <p class="text-center font-bold text-lg">Are you sure you want to delete the current KPI/OKR Data?</p>
                <div class="flex justify-center items-center pt-6 gap-3">
                    <button type="button"
                        class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                        @click="addMore = false, cancel_team_popup = false">Yes</button>
                    <button type="button"
                        class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        @click="cancel_team_popup = false">Cancel</button>
                </div>
            </div>
        </div>

    </Dialog>

    <!-- reject popup -->
    <Dialog v-model:visible="reject_popup" modal :style="{ width: '30rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" class="m-0 p-0 relative  shadow-md rounded-t-full">
        <div :style="{ height: '25rem' }" class="relative rounded-lg overflow-hidden ">
            <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#B14B4B] flex justify-center items-center  "
                :style="{ height: '9rem' }">
                <i type='button' @click="reject_popup = false" class="pi pi-times text-white"
                    style="font-size: 3rem"></i>
            </div>
            <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[22px]  box-border   "
                :style="{ height: '22rem' }">
                <p class="text-center font-bold text-2xl pt-4 box-border">Reject</p>
                <p class="text-center font-bold text-lg">Are you sure you want to Reject the KPI/OKR Form?</p>
                <Textarea rows="3" cols="36" v-model="reviewer_comments" placeholder="Your Comments..."
                    class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd] w-[350px]  p-2" />

                <div class="flex justify-center items-center pt-6 gap-3">
                    <button type="button"
                        class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                        @click="reviewer_comments ? (useStore.teamKpiFormApproval(selectedRecordId, -1, reviewer_comments), reject_popup = false, useStore.createTeamKpiForm = false, visibleRight = false) : useHelper.toastmessage('error', 'Feedback for Rejection of KPI Form is Required')">Yes</button>
                    <button type="button"
                        class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        @click="reject_popup = false">Cancel</button>
                </div>
            </div>
        </div>
    </Dialog>


    <!-- REVOKE POPUP -->
    <Dialog v-model:visible="revoke_popup" modal :style="{ width: '30rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" class="m-0 p-0 relative  shadow-md rounded-t-full">
        <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden ">
            <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#B14B4B] flex justify-center items-center  "
                :style="{ height: '9rem' }">
                <i type='button' @click="revoke_popup = false" class="pi pi-times text-white"
                    style="font-size: 3rem"></i>
            </div>
            <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border   "
                :style="{ height: '19rem' }">
                <p class="text-center font-bold text-2xl pt-4 box-border">Revoke</p>
                <p class="text-center font-bold text-lg">Are you sure you want to Revoke this KPIOKR Form?</p>
                <div class="flex justify-center items-center pt-6 gap-3">
                    <button type="button"
                        class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                        @click="useStore.TeamAppraisalRevoke(selectedRecordId,'approve_reject'), revoke_popup = false, useStore.createTeamKpiForm = false, visibleRight = false">Yes</button>
                    <button type="button"
                        class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        @click="revoke_popup = false">Cancel</button>
                </div>
            </div>
        </div>
    </Dialog>

</div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { usePmsMainStore } from '../stores/pmsMainStore'
import { usePmsHelperStore } from '../stores/pmsHelperStore'
import { Service } from '../../Service/Service';
import useValidate from '@vuelidate/core';
import { FilterMatchMode } from 'primevue/api';
import { required, email, minLength, helpers } from '@vuelidate/validators';
import { useToast } from 'primevue/usetoast';
import LoadingSpinner from '../../../components/LoadingSpinner.vue';

const useService = Service()
const useStore = usePmsMainStore()
const useHelper = usePmsHelperStore()
const toast = useToast();

const active = ref(1);
const visibleRight = ref(false);
const currentUserCode = ref()
const edit = ref()
const formvariable = ref('Creation')
const editsavepublish1 = ref('')
const reject_popup = ref(false);
const revoke_popup = ref(false)
const filters = ref({
'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});


const activetab = ref(1);
const camShowPublishAfterSaved = ref(false);
const isFormSubmitted = ref(false);
const selectedRecordId = ref()
const current_user_code = ref();
const selectedEditIndex = ref();
const hideObjectiveInput = ref(false)
const formSaved = ref(false);
const TotalKpiWeightage = ref(0);
const reviewerTotalKpiWeightage = ref(0);
const withdraw_popup = ref(false);
const selectedRowdata = ref();
const addMore = ref(false);
const review_save = ref();

const save_self_appraisal = ref();
const filteredDepartmentList = ref();

const canShowMoreContentIndex = ref()
const canShowMoreContentRowIndex = ref()

const reviewer_comments = ref();

const enableApproveReject = ref(true);
const Total_reviewer_review_KpiWeightage = ref();


const selectedRowdata_appraisal = ref();

const sidebar_team_popup = ref(false);
const cancel_team_popup = ref(false)
const canHiddenUploadOptions = ref(true);
const view_edit_withdraw = ref('');

const activeItem = ref(null);

function toggleItem(index) {
activeItem.value = activeItem.value === index ? null : index;
}

const op = ref();
const OverlayPanel = ref(true);
const toggle = (event) => {
// op.value = event;
// console.log(event);
if (event) {
    op.value = event;
}
}


function view_form_edit_withdraw(data, selectedRow) {
selectedRowdata.value = selectedRow;
// save_self_appraisal.value = data;
// console.log(save_self_appraisal.value);
// console.log(selectedRow);

}


const expandContent = (currentIndex, rowIndex, string) => {
if (canShowMoreContentRowIndex.value == rowIndex) {
    if (canShowMoreContentIndex.value === currentIndex) {
        if (string.length > 5) {
            return true
        }
    }
}
}



onMounted(async () => {
let user_code;
await useService.getCurrentUserCode().then(res => {
    user_code = res.data;
    current_user_code.value = res.data;
    currentUserCode.value = res.data
    // console.log(user_code);
})
const flow_type = 2
await useStore.getTeamAppraisalDashboardDetails(user_code)
await useStore.getPmsConfiguration(flow_type, user_code)
await useStore.getKPIFormAsDropdown(user_code)
await useStore.getDashboardCardDetails_TeamAppraisal(user_code,2);
// await useHelper.getManagerList()
});


const removeTodo = (myArray, key) => {
const indexToDelete = key;
if (indexToDelete >= 0 && indexToDelete < myArray.length) {
    myArray.splice(indexToDelete, 1); // Delete the element at the specified index
    // console.log(`Deleted element at index ${indexToDelete}`);
    calculateTotalKpiWeightage(myArray)

} else {
    // console.log(`Invalid index: ${indexToDelete}`);
}
};

const findTargetIsNumberOrAlpha = (ele) => {
const containsNumbers = /\d/.test(ele);
if (containsNumbers) {
    // console.log('The value is a number.');
    return false
} else {
    // console.log('The value is not a number.');
    return true
}

}

const updateValue = (index, field, newValue) => {
if (useStore.createKpiForm.form_details[index]) {
    useStore.createKpiForm.form_details[index][field] = newValue;
} else {
    console.log('Index out of range or form_details is not an array.');
}
};

const updateReviewerForm = (index, reviewerIndex, field, newValue) => {
if (useStore.createKpiForm.form_details[index]['reviews_review']) {
    useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex][field] = newValue;

    let containsNumbers = /\d/.test(useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_review);
    console.log(useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_review);

    console.log(useStore.createKpiForm.form_details[index].target);

    if(useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_review == newValue){
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_percentage = ''
        // Math.round((parseInt(useStore.createKpiForm.form_details[index].reviews_review[reviewerIndex].kpi_review) / parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_review)) * parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_percentage))
    }
    if (containsNumbers) {
        console.log('kpi_weightage:: num');
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex]['kpi_percentage'] =   Math.round( parseInt(useStore.createKpiForm.form_details[index].reviews_review[reviewerIndex].kpi_review) / parseInt(useStore.createKpiForm.form_details[index].target) * parseInt(useStore.createKpiForm.form_details[index].kpi_weightage))
        // toast.add({ severity: 'error', summary: 'Error Message', detail: 'The target should be less than or' })
        // Math.round(useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue))
        // useStore.createKpiForm.form_details[index].assignee_review.target = null
    } else {
        console.log('kpi_weightage:: num else');
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex]['kpi_percentage'] = 0;
    }
} else {
    console.log('Index out of range or form_details is not an array.');
}
};

const updateAssigneeFormNumberOrAlpha = (index, reviewerIndex, field, newValue) => {
if (useStore.createKpiForm.form_details[index]['reviews_review']) {
    useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex][field] = newValue;
    if ((useStore.createKpiForm.form_details[index].target).toUpperCase() === (useStore.createKpiForm.form_details[index].reviews_review[reviewerIndex].kpi_review).toUpperCase()) {
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex]['kpi_percentage'] = parseInt(useStore.createKpiForm.form_details[index].kpi_weightage);
    }
    else {
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex]['kpi_percentage'] = 0;
    }
}
else {
    console.log('Index out of range or form_details is not an array.');
}
}

const updateAssigneeFormKpi = (index, field, newValue) => {
if (useStore.createKpiForm.form_details[index]['assignee_review']) {
    // useStore.createKpiForm.form_details[index]['assignee_review'][field] = newValue;
    // useStore.createKpiForm.form_details[index]['assignee_review']['kpi_weightage'] = useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue)
}
}

const isEditing = (index) => {
return selectedEditIndex.value === index;
}

const formatConverter = (data) => {
// console.log(data);
if (data) {
    const transformedArray = data.map(obj => {
        return Object.entries(obj).map(([title, value]) => ({ title, value }));
    });
    // console.log(transformedArray);
    return transformedArray
}

}

const findSelectedHeaderIsEnabled = (array, idToFind) => {
if (array) {
    return array.find(obj => obj.title === idToFind);
}
}

const isNumber = (e) => {
if (e) {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[0-9]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

}


const rules = computed(() => {
const dynamicRules = {};
for (const header of useStore.selected_header ? useStore.selected_header : []) {
    dynamicRules[header.header_name] = { required };
}
return dynamicRules;
})

const v$ = useValidate(rules, useStore.addKra)

const submitForm = () => {
// v$.value.$reset();
v$.value.$validate(); // checks all inputs
if (!v$.value.$error) {
    // if ANY fail validation

    const transformedObject = convertToNewObject(useStore.selected_header);
    // console.log(transformedObject);
    if (compareHeaders(transformedObject, useStore.addKra)) {
        toast.add({ severity: 'warn', summary: 'Validation', detail: 'Fill missing fields', life: 3000 });

    } else {
        addMore.value = false
        useStore.addFormDetails(useStore.addKra);
        calculateTotalKpiWeightage(useStore.createKpiForm.form_details)
        // console.log('Form successfully submitted.');
        useStore.addKra = {};
        v$.value.$reset(); // Reset the validation object
    }

} else {
    console.log('Form failed validation');
}

}

const removeRecordId = (data) => {
if (data) {
    return data.filter(ele => {
        return ele.title != 'record_id'
    })
}
}





function convertToTitleCase(originalString) {
if (originalString) {
    //     const title =  str.replace(/\b\w/g, match => match.toUpperCase());
    //    const converted = title.replace(/_/g, ' ');
    //     return converted
    const convertedString = originalString
        .split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    return convertedString
}
}

const Calendar_Type = computed(() => {
useStore.createNewTeamGoals.calendar_type = convertToTitleCase(useStore.createNewTeamGoals.calendar_type);
// console.log(useStore.createNewTeamGoals.calendar_type);
});

const frequency = computed(() => {
useStore.createNewTeamGoals.frequency = capitalizeFirstLetter(useStore.createNewTeamGoals.frequency);
// console.log(useStore.createNewTeamGoals.frequency);
});

function capitalizeFirstLetter(string) {
if (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
}


const errorList = ref([])


const compareHeaders = (obj1, obj2) => {
const headersObj1 = Object.keys(obj1);
const headersObj2 = Object.keys(obj2);

const missingHeadersObj1 = headersObj2.filter(header => !headersObj1.includes(header));
const missingHeadersObj2 = headersObj1.filter(header => !headersObj2.includes(header));

if (missingHeadersObj1.length > 0 || missingHeadersObj2.length > 0) {
    return true
}
}


const convertToNewObject = (arr) => {
const result = {};
arr.forEach(obj => {
    const { header_name } = obj;
    result[header_name] = null;
});
return result;
}

let totalKPICount = 0
const calculateKpiWeightage = (arr) => {
let kpiValue = 0;
console.log("totalKPICount" + totalKPICount);
totalKPICount++
arr.forEach(ele => {
    const containsNumbers = /\d/.test(ele.kpi_weightage);
    if (containsNumbers) {
        TotalKpiWeightage.value = parseInt(ele.kpi_weightage);
        console.log('The value is not a number.');
    } else {
        console.log('The value is not a number.');
    }

    if (ele.kpi_weightage !== undefined && !isNaN(parseInt(ele.kpi_weightage))) {
        kpiValue += parseInt(ele.kpi_weightage);
        TotalKpiWeightage.value = kpiValue;
        console.log(TotalKpiWeightage.value);
    }
});
if (kpiValue > 100) {
    toast.add({ severity: 'error', summary: 'Validation', detail: 'The combined weightage of KPIs or OKRs must equal to 100% ', life: 3000 });
} else
    if (kpiValue < 100) {
        toast.add({ severity: 'error', summary: 'Validation', detail: 'The combined weightage of KPIs or OKRs must equal to 100%', life: 3000 });
    } else
        if (kpiValue == 100) {
            // toast.add({ severity: 'success', summary: 'Validation', detail: 'The OKR/ PMS form has been created successfully', life: 3000 });
            let UserCode = currentUserCode;
            // console.log(viewEditWithdraw.value === 'Reject Edit option' ? useStore.form_id : '', ' testing rejected form id ::');

            useStore.saveKpiForm(UserCode, formvariable.value === 'view' || formvariable.value === 'Reject Edit option' ? useStore.currentlySavedFormId = selectedRowdata.value.kpi_form_details.form_id : '');

        }
}

let totalKPIReviewCount = 0
const calculateTotalKpiWeightage = computed(() => {
console.log("totalKPIReviewCount" + totalKPIReviewCount);
let arr = useStore.createKpiForm.form_details
totalKPIReviewCount++
let calculatedKpiWeightage = 0
// console.log(arr);
arr.forEach(ele => {
    if (ele.kpi_weightage !== undefined && !isNaN(parseInt(ele.kpi_weightage))) {
        calculatedKpiWeightage += parseInt(ele.kpi_weightage);
        TotalKpiWeightage.value = calculatedKpiWeightage;
    }
});
console.log(calculatedKpiWeightage);
return calculatedKpiWeightage

})

const calculateTotalReviewerKpiWeightage = (arr) => {
let calculatedKpiWeightage = 0
console.log(arr);
arr.forEach(ele => {
    // console.log(ele);
    const reviewerArray = ele.reviews_review[0]
    console.log(reviewerArray);
    const containsNumbers = /\d/.test(reviewerArray.kpi_review);
    if (containsNumbers) {
        console.log((parseInt(reviewerArray.kpi_review) / parseInt(ele.target)) * parseInt(ele.kpi_weightage));
        // console.log('The value is a number.');
        reviewerTotalKpiWeightage.value += (parseInt(reviewerArray.kpi_review) / parseInt(ele.target) * parseInt(ele.kpi_weightage))
    } else {
        // console.log('The value is not a number.');
    }

    // if (ele.reviews_review.kpi_review !== undefined && !isNaN(parseInt(ele.reviews_review.kpi_review))) {
    //     calculatedKpiWeightage += parseInt(ele.kpi_weightage);
    //     TotalKpiWeightage.value = calculatedKpiWeightage;
    //     // console.log(TotalKpiWeightage.value);
    // }
});
}





const filterWantedField = (originalArray, excludeArray) => {
const filteredArray = originalArray.filter(item => !excludeArray.includes(item.title));
return filteredArray
}

const filterDepartmentList = () => {
return filteredDepartmentList.value = useHelper.filterDepartmentWiseEmployee(useStore.EmployeeOptions, useStore.createNewTeamGoals.department_id)
}


const reviewTotalKpiWeightage = computed(() => {
let calculatedKpiWeightage = 0
let arr = useStore.createKpiForm.form_details;
arr.forEach(ele => {
    const containsNumbers = /\d/.test(ele.assignee_review.kpi_percentage);
    if (containsNumbers) {
        calculatedKpiWeightage += parseInt(ele.assignee_review.kpi_percentage);
        // console.log('calculateKpiWeightage' + calculatedKpiWeightage);
        TotalKpiWeightage.value = calculatedKpiWeightage

    } else
        if (ele.assignee_review.kpi_percentage !== undefined && !isNaN(parseInt(ele.assignee_review.kpi_percentage))) {
            calculatedKpiWeightage += parseInt(ele.assignee_review.kpi_percentage);
            TotalKpiWeightage.value = calculatedKpiWeightage
            // console.log(TotalKpiWeightage.value);
        }
        else {
            // console.log('The value is not a number.');
        }
});
return calculatedKpiWeightage

})







</script>

<style scoped>
.p-dropdown .p-dropdown-label
{
background: transparent;
border: 0 none;
margin-top: -6px;
}

.p-sidebar-right .p-sidebar
{
width: 80% !important;
height: 100%;
}

.p-sidebar-mask,
.p-sidebar-visible,
.p-sidebar-right
{
z-index: 0 !important;
}

/*
@scope (.p-accordion) {
.p-accordion .p-accordion-content{
    padding: 0px !important;
}
} */
.p-accordion .p-accordion-content
{
padding: 0px !important;

}

.p-accordion-content
{}

.p-dialog-mask .p-dialog
{
z-index: 10000 !important;
}

.p-inputtext .p-inputnumber-input
{
height: 20px !important;
background-color: #dddd !important;
}

@scope(.p-dialog)
{
.p-dialog
{
    z-index: 10000 !important;
}

}

.accordion
{
/* Your styles */

}

.accordion-item
{
/* Your styles */
}

.accordion-header
{
/* Your styles */
background-color: #fff7eb;
padding: 1rem;
}

.accordion-icon
{
/* Your styles */
}

.accordion-content
{
/* Your styles */
padding: 1rem 0 0 0;
}

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
</style>
