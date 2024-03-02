<template>
        <LoadingSpinner v-if="useStore.canShowLoading" class="absolute z-50 bg-white" />
    <div>
        <Toast />
        <div class=" grid grid-cols-5 gap-4 px-4 mt-[20px] ">
            <div class=" !shadow-xl border-[1px] flex rounded-lg justify-start items-center h-[80px] ">
                <img src="../assests/employee_goals.png" class=" w-[60px] " alt="">
                <div class="flex flex-col ">
                    <h1 class=" font-semibold  text-[16px]  font-['poppins']">Goals Initiated</h1>
                    <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[0].total_count :'-'  }} / {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[0].actual_count :'-'  }} </span>
                </div>
            </div>
            <div class=" !shadow-xl border-[1px] flex rounded-lg justify-start items-center h-[80px]">
                <div>
                    <img src="../assests/self_review.png" class="  w-[60px] " alt="">
                </div>
                <div class="flex flex-col ">
                    <h1 class=" font-semibold  text-[16px]  font-['poppins']">Approvals</h1>
                    <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[1].total_count :'-'  }} /  {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[1].actual_count :'-'  }} </span>
                </div>
            </div>
            <div class="flex  !shadow-xl border-[1px] rounded-lg justify-start items-center h-[80px]">
                <img src="../assests/pms_rating.png" class="  w-[60px] " alt="">
                <div class="flex flex-col ">
                    <h1 class=" font-semibold  text-[16px]  font-['poppins']">Self-Review</h1>
                    <span class=" text-[14px] font-['poppins']"> {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[2].total_count :'-'  }} /  {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[2].actual_count :'-'  }} </span>
                </div>
            </div>
            <div class="flex  !shadow-xl border-[1px] rounded-lg justify-start items-center h-[80px]">
                <img src="../assests/pms_rating.png" class="  w-[60px] " alt="">
                <div class="flex flex-col ">
                    <h1 class=" font-semibold  text-[16px]  font-['poppins']">Manager-Reivew</h1>
                    <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[3].total_count :'-'  }} /  {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[3].actual_count :'-'  }}</span>
                </div>
            </div>
            <div class="flex !shadow-xl border-[1px] rounded-lg justify-start items-center h-[80px]">
                <img src="../assests/employees_assessed.png" class="  w-[60px] " alt="">
                <div class="flex flex-col ">
                    <h1 class=" font-semibold text-[16px]  font-['poppins']">Final Score</h1>
                    <span class=" text-[14px] font-['poppins']">{{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[3].total_count :'-'  }} /  {{ useStore.DashboardCardDetails_TeamAppraisal ? useStore.DashboardCardDetails_TeamAppraisal[3].actual_count :'-'  }}</span>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-5 ">
<!-- {{activetab}} -->
            <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 border-b-[3px] border-gray-300 "
                id="pills-tab" role="tablist">
                <li class=" " role="presentation">
                    <a class="px-3 position-relatie border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="activetab = 1"
                        :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        Pending
                        <span class="relative left-[60px] top-[-25px] flex h-3 w-3 !z-10">
                            <!-- :class="useStore.teamDashboardPublishedFormList ? useHelper.filterTeamAppraisalPendingSource(useStore.teamDashboardPublishedFormList, 1, '').length > 0 ? '' : 'hidden' : 'hidden'" -->
                            <span :class="useStore.orgAppraisalDatatableDetails  ? useHelper.filterOrgPendingStatusSource(useStore.orgAppraisalDatatableDetails, 1, '', '') ? '' : 'hidden' :'hidden' "
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </a>
                    <div v-if="activetab === 1" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div> -->
                </li>
                <li class=" nav-item" role="presentation">
                    <a class="px-2 position-relati3e border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="activetab = 2"
                        :class="[activetab === 2 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        CURRENT
                    </a>
                    <div v-if="activetab === 2" class="relative h-1 rounded-l-3xl top-2 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div> -->
                </li>

                <li class="border-0 nav-item position-relative" role="presentation">
                    <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activetab = 3"
                        :class="[activetab === 3 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        COMPLETED
                    </a>
                    <div v-if="activetab === 3" class=" h-1 relative top-2  bottom-[1px] left-0 w-[100%]"
                        style="border: 2px solid #F9BE00 !important;"></div>
                    <!-- <div v-else class="h-1 border-gray-300 border-3"></div> -->
                </li>
            </ul>

            <div class="flex justify-between ">
                <button v-if="activetab == 2" @click="visibleRight = true, useStore.getPmsConfiguration(1, currentUserCode)"
                    class=" bg-[#F9BE00] text-[13px] rounded-md text-[#000] !w-[120px] h-[35px] font-semibold flex justify-center items-center ">
                    <i class="mr-2 pi pi-plus"></i>
                    Add Goals</button>
                <!-- v-model="filters['global'].value"  -->
                <!-- <InputText placeholder="Search" class="h-[35px] w-[211px] mx-4" v-model="filters['global'].value" /> -->
            </div>


        </div>

        <div class=" h-[400px] overflow-scroll" v-if="activetab==1" >
            <DataTable :value="useStore.orgAppraisalDatatableDetails ? useHelper.filterOrgPendingStatusSource(useStore.orgAppraisalDatatableDetails, 1, '', 1,'','pending') : []" scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" >
            <Column field="assignee_name" header="Employee">

                <template #body="slotProps">
                        <div class="flex justify-center items-center  gap-2">
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
                                    slotProps.data.assignee_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                                }}</span>
                            </span>


                        </div>
                    </template>

            </Column>
            <!-- <Column field="name" header="Initiated"></Column> -->
            <Column field="manager_name" header="manager_name">
                <template #body="slotProps" >
                <div class="flex flex-col justify-start items-start" >
                    <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                    slotProps.data.manager_name }} </span>
                                    <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                                }}</span>
                </div>
            </template>
            </Column>
            <Column field="assignment_period" header="Assignment Period"></Column>
            <Column field="score" header="score"></Column>
            <Column field="status" header="status"></Column>
            <Column field="" header="Action">
            <template #body="{ data }" >
                <div class=" cursor-pointer" >
                <i class="pi pi-eye" @click="useStore.canShowAssigneeReviewForm=false, useStore.createTeamKpiForm = true, useStore.createKpiForm = { ...data.kpi_form_details }, selectedRowdata = data, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false, useStore.getSelfTimeLine(currentUserCode, data.id)" ></i>
                </div>
            </template>
            </Column>
        </DataTable>
        </div>
        <div class="" v-if="activetab==2" >
            <DataTable  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" :value=" useStore.orgAppraisalDatatableDetails ?  useHelper.filterOrgPendingStatusSource(useStore.orgAppraisalDatatableDetails,'Goal Published','Employee Reviewed',1,'','current') : []" >
                <Column field="assignee_name" header="Employee">
                <template #body="slotProps">
                        <div class="flex justify-center items-center  gap-2">
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
                                    slotProps.data.assignee_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                                }}</span>
                            </span>
                        </div>
                    </template>
            </Column>
            <Column field="manager_name" header="Manager">
            <template #body="slotProps" >
                <div class="flex flex-col justify-start items-start" >
                    <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                    slotProps.data.manager_name }} </span>
                                    <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                                }}</span>
                </div>
            </template>
            </Column>
            <Column field="assignment_period" header="Assignment Period"></Column>
            <Column field="score" header="Achieved Score"></Column>
            <Column field="status" header="Review Status"></Column>
            <Column field="quantity" header="Action">
                <template #body="{ data }" >
                <div class=" cursor-pointer" >
                <i class="pi pi-eye" v-if="data.status == 'Goal Published'" @click="useStore.canShowAssigneeReviewForm= true, useStore.createTeamKpiForm = true,  useStore.selected_header = data.form_header , useStore.createKpiForm = { ...data.kpi_form_details }, selectedRowdata = data, useStore.form_header =data.form_header, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false, useStore.getSelfTimeLine(currentUserCode, data.id)" ></i>
                <i class="pi pi-eye" v-if="data.status == 'Employee Reviewed'" @click="useStore.canShowAssigneeReviewForm=true, useStore.createTeamKpiForm = true,  useStore.selected_header = data.form_header , useStore.createKpiForm = { ...data.kpi_form_details }, useStore.form_header =data.form_header , selectedRowdata = data, useStore.form_id = data.id, selectedRecordId = data.id, formvariable = 'view', canHiddenUploadOptions = false, useStore.getSelfTimeLine(currentUserCode, data.id)" ></i>
                </div>
            </template>
            </Column>
        </DataTable>

        </div>

        <div class="" v-if="activetab==3"  >
            <DataTable  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"   :value="useHelper.filterOrgcompletedStatusSource(useStore.orgAppraisalDatatableDetails, 1,'Completed')">
            <Column field="assignee_name" header="Employee">
                <template #body="slotProps">
                        <div class="flex justify-center items-center  gap-2">
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
                                    slotProps.data.assignee_name }} </span>
                                <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.assignee_code
                                }}</span>
                            </span>
                        </div>
                    </template>
            </Column>
            <Column field="manager_name" header="Manager">
            <template #body="slotProps" >
                <div class="flex flex-col justify-start items-start" >
                    <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">{{
                                    slotProps.data.manager_name }} </span>
                                    <span class=" font-['poppins'] text-[#535353] text-[12px]  ">{{ slotProps.data.manager_code
                                }}</span>
                </div>
            </template>
            </Column>
            <Column field="assignment_period" header="Assignment Period"></Column>
            <Column field="score" header="Achieved Score"></Column>
            <Column field="status" header="Review Status"></Column>
            <Column field="Action" header="Action">
            <template  #body="{ data }" >
                <div>
                    <i class="pi pi-eye" @click="useStore.createTeamKpiForm = true, useStore.canShowAssigneeReviewForm = true, useStore.selected_header = data.form_header ,  useStore.createKpiForm = { ...data.kpi_form_details }, useStore.getSelfTimeLine(currentUserCode, data.id), view_form_edit_withdraw(data.reviewer_details, data), view_edit_withdraw = 'Review', useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id, data.is_assignee_submitted == 1 ? isFormSubmitted = true : isFormSubmitted = false, canHiddenUploadOptions = false"></i>
                </div>
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
                            <!-- {{useStore.createNewTeamGoals.assignee_id}} -->
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
                            @click="useStore.createNewTeamGoals.kpi_form_id ? (useStore.createKpiForm.form_details.length == 0 ? addMore = true : addMore = false, useStore.createTeamKpiForm = true, canHiddenUploadOptions = true, formvariable = 'View', visibleRight = false, hideObjectiveInput = true, useStore.getKPIFormDetails(useStore.createNewTeamGoals.kpi_form_id)) : showWarn()"
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
                        @click="useStore.createNewTeamGoals.department_id ? useStore.createNewTeamGoals.assignee_id ? (useStore.createTeamKpiForm = true, canHiddenUploadOptions = true, formvariable = 'Creation', editsavepublish1 = 'save', hideObjectiveInput = true, visibleRight = false, useStore.createKpiForm.form_details = [], addMore = true, useStore.createKpiForm.form_name = `OKR_FORM ` + `_` + currentUserCode + `_` + useService.current_user_name + `_` + useStore.createNewTeamGoals.assignment_period.toUpperCase()) : useHelper.toastmessage('warn', 'Select Employee ') : useHelper.toastmessage('warn', 'Select Department ')  ">
                        Create KPI Form
                    </button>
                    <!-- {{ useStore.createNewTeamGoals.kpi_form_id }} -->
                    <!-- useHelper.toastmessage('error', 'This form doesn t contain any data.') :  -->
                    <!-- (useStore.publishForm(current_user_code), visibleRight = false, addMore = false, useStore.createTeamKpiForm = false, useStore.createNewTeamGoals.kpi_form_id = '')  -->
                    <button class=" text-[#000] rounded-[8px] w-[144px] !h-[33px]"
                        :class="[useStore.createNewTeamGoals.kpi_form_id ? 'bg-[#F9BE00]' : 'bg-[#DDDD]']"
                        @click="useStore.createNewTeamGoals.department_id ? useStore.createNewTeamGoals.assignee_id ? useStore.createNewTeamGoals.kpi_form_id ?(useStore.employeefilter(useStore.createNewTeamGoals.assignee_id) , useStore.publishTeamForm(current_user_code,1), visibleRight = false, addMore = false, useStore.createTeamKpiForm = false, useStore.createNewTeamGoals.kpi_form_id = '',filteredDepartmentList='')  : useHelper.toastmessage('error', 'Select KPI form') : useHelper.toastmessage('warn', 'Select Employee ') : useHelper.toastmessage('warn', 'Select Department ') ">
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
                    <div class=" flex justify-between items-center " v-if="formvariable == 'view'">
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
                        <!-- <div class=" flex justify-between items-center ">
                            <div class=" flex justify-center items-center border-[#000]  "
                                :class="index == 0 ? 'w-[50%]' : 'w-full'" v-for="(item, index) in useStore.SelfTimeLine">
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
                        </div> -->

                        <div v-if="useStore.createKpiForm.form_details">
                          <!-- {{  useStore.form_header}} -->
                            <div class=" grid grid-cols-12 gap-4 py-3 px-4  bg-[#DDDD] rounded-md mb-[10px] mt-[30px] "
                                v-if="useStore.form_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                                <div class="" v-for="(headerRecord, headerIndex) in useStore.selected_header"
                                    :class="[0, 1].includes(headerIndex) ? 'col-span-3 flex justify-start' : [2, 4].includes(headerIndex) ? 'col-span-2' : 'col-span-2 '">
                                    <h1 class="text-lg font-semibold">
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
                                    <p class="text-center font-semibold "
                                        v-if="headerRecord ? headerRecord.header_name == 'kpi_weightage' : ''">
                                        <span class=" text-gray-400 font-['poppins'] ">Overall -</span>
                                        <span class="font-['poppins']"
                                        :class="[reviewTotalKpiWeightage >= 100 ? ' text-green-500' : '']"> {{
                                            reviewTotalKpiWeightage }} %</span>
                                    </p>
                                </div>
                                <div class="">
                                    <h1 class="text-lg font-semibold " >
                                        Comments
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="accordion"  >
                            <div v-if="false" v-for="(form_details, index) in formatConverter(useStore.createKpiForm.form_details) "
                                :key="index">

                                <div class="accordion-item my-2">
                                    <div class="accordion-header items-center flex justify-center"
                                        @click="toggleItem(index)">
                                        <span> <i class="pi pi-chevron-right ml-2"
                                                :class="activeItem === index ? ' delay-100 rotate-[90deg]' : ''"></i>
                                        </span>
                                        <div class=" grid grid-cols-12  gap-2  !font-['poppins'] "
                                            v-for="(singleRecord, recordIndex) in filterWantedField(form_details, ['id', 'record_id', 'reviews_review'])">

                                            <div class="  flex justify-center !line-clamp-4  h-[100%]"
                                                :class="[0, 1].includes(recordIndex) ? ' w-[250px] ' : 'w-[120px]'">


                                                <h1 v-if="!['id', 'record_id', 'assignee_review'].includes(singleRecord.title) && expandContent(recordIndex, index, singleRecord.value)"
                                                    v-tooltip="singleRecord.value" class="text-[12px] text-[#000]  my-1 ">
                                                    {{ singleRecord.value }}
                                                    <button class=" text-blue-400 font-['poppins']"
                                                        @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                                        v-if="singleRecord.value.length > 80 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
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
                                        </div>


                                    </div>

                                    <Transition>

                                        <div v-if="activeItem === index"
                                            :class="activeItem === index ? ' !delay-200 ' : 'delay-200'"
                                            class="accordion-content bg-[#fff7eb] !font-['poppins'] border-[1px] ">
                                            <div class="grid grid-cols-12 items-center"
                                                v-if="findSelectedHeaderIsEnabled(form_details, 'assignee_review').value">
                                                <div class="flex justify-start col-span-6">
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

                                                <div class="col-span-3 pl-[140px] text-center" >
                                                    {{ singleRecord }}
                                                    {{ findSelectedHeaderIsEnabled(form_details,
                                                        'assignee_review').value.kpi_review }}

                                                </div>
                                                <div class="col-span-1">
                                                    <h1 class="text-[12px] text-[#000]  text-right pr-[2rem] my-1 ">
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
                                            <div class=" border-[1px] p-3  mt-3 bg-[#ffe9c8ca]"
                                                v-for="(reviewer, reviewerIndex) in findSelectedHeaderIsEnabled(form_details, 'reviews_review').value"
                                                v-if="findSelectedHeaderIsEnabled(form_details, 'reviews_review').value">
                                                <div class="grid grid-cols-12 items-center">
                                                    <div class="flex justify-center col-span-6">
                                                        <div class="flex items-center justify-center">
                                                            <h1 class="text-[#8B8B8B] mx-2">{{ reviewer.reviewer_level }} -
                                                            </h1>
                                                            <h1 class=" text-[#000] mx-2 ">
                                                                {{ reviewer.reviewer_name }}
                                                            </h1>
                                                            <h1 class="text-[#000] mx-2 ">(
                                                                {{ reviewer.reviewer_code }})
                                                            </h1>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-2 relative text-right ">
                                                        <span v-if="selectedRowdata.is_reviewer_submitted == 1">{{
                                                            reviewer.kpi_review }}</span>
                                                        <InputText
                                                            v-if="findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(form_details, 'assignee_review') ? findSelectedHeaderIsEnabled(form_details, 'assignee_review').value.kpi_review : '') && selectedRowdata.is_reviewer_submitted == ''"
                                                            @focusout="updateAssigneeFormNumberOrAlpha(index, reviewerIndex, 'kpi_review', $event.target.value), review_save = 'save', useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'reviews_review') ? findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value.id : '', currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review') ? findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target : '', currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review') ? findSelectedHeaderIsEnabled(formDetails, 'target').value : '', reviewTotalKpiWeightage)"
                                                            type="text" v-model="reviewer.kpi_review"
                                                            class=" h-10 w-24 bg-[#F6F6F6]  border-[1px] border-[green]  p-2" />
                                                        <InputText
                                                            v-if="!findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(form_details, 'assignee_review') ? findSelectedHeaderIsEnabled(form_details, 'assignee_review').value.kpi_review : '') && selectedRowdata.is_reviewer_submitted == ''"
                                                            @focusout="updateReviewerForm(index, reviewerIndex, 'kpi_review', $event.target.value), review_save = 'save', currentlyRecords, reviewTotalKpiWeightage"
                                                            type="text" v-model="reviewer.kpi_review"
                                                            class=" h-10 w-24 bg-[#F6F6F6]   p-2 border-[1px] border-[red] " />
                                                    </div>
                                                    <div class="col-span-2">
                                                        <p class="absolute top-[-25px] text-[#8b8b8b] font-['poppins']">{{
                                                            selectedRowdata.is_assignee_submitted == 1 ? ' Achieved KPI ' :
                                                            ''
                                                        }}</p>
                                                        <!-- If employee entered target is text then we will allow employee to fill target in text -->
                                                        <InputText readonly
                                                            v-if="selectedRowdata.is_assignee_submitted == 1 && selectedRowdata.is_reviewer_submitted == ''"
                                                            @focusout="updateAssigneeFormKpi(index, 'kpi_percentage', $event.target.value), review_save = 'save', useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                            type="text" v-model="reviewer.kpi_percentage"
                                                            class=" h-10 w-24 my-2 bg-[#F6F6F6]  !border-[rgb(246,246,246)]  p-2" />

                                                        <!-- If employee entered target is Number then we will allow employee to fill target in Number -->
                                                        <h1 v-else class="text-[12px] text-right pr-4 text-[#000]  my-1 ">
                                                            {{ reviewer.kpi_percentage }}
                                                        </h1>
                                                    </div>
                                                    <div class="col-span-2 ">
                                                        <Textarea @focusout="review_save = 'save'"
                                                            v-if="selectedRowdata.is_assignee_submitted == 1 && selectedRowdata.is_reviewer_submitted == ''"
                                                            v-model="reviewer.kpi_comments" rows="2" cols="10"
                                                            class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]  p-2" />

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </Transition>
                                </div>
                            </div>


                            <!--  -->

                        <Accordion :activeIndex="0" v-if="formatConverter(useStore.createKpiForm.form_details)">
                            <AccordionTab
                                v-for="(formDetails, index) in formatConverter(useStore.createKpiForm.form_details)">
                                <template #header class="w-[100%] ">
                                    <!-- <div class=" grid grid-cols-12  w-[100%] !font-['poppins'] ">
                                        <div class="col-span-2  "
                                            v-for="(singleRecord, recordIndex) in filterWantedField(formDetails, ['id', 'record_id'])">
                                            <h1 v-if="!['id', 'record_id', 'assignee_review','reviews_review'].includes(singleRecord.title)"
                                               v-tooltip="singleRecord.value" class="text-[12px] text-[#000]  my-1 ">
                                                {{ singleRecord.value ? singleRecord.value.length > 20 ?
                                                    singleRecord.value.substring(0,
                                                        20) + '..' : singleRecord.value : '' }}
                                            </h1>
                                            <div class="w-[170px]" v-if="['assignee_review'].includes(singleRecord.title)">
                                                <h1 v-tooltip="singleRecord.value.comments"
                                                    class="text-[12px] text-[#000]  my-1 ">
                                                    {{ singleRecord.value.comments ? singleRecord.value.comments.length > 20
                                                        ?
                                                        singleRecord.value.comments.substring(0,
                                                            20) + '..' : singleRecord.value.comments : '' }}
                                                </h1>
                                            </div>
                                        </div>s
                                    </div> -->

                                    <div class="grid grid-cols-12  gap-2  ">
                                        <div class=" flex justify-center !line-clamp-4  h-[100%]"
                                            v-for="(singleRecord, recordIndex) in  filterWantedField(formDetails, ['id', 'record_id', 'assignee_review', 'reviews_review'])"
                                            :class="[0, 1].includes(recordIndex) ? '  col-span-3  mx-5' : [2, 4].includes(recordIndex) ? ' mx-[3rem] col-span-2   ' : recordIndex == filterWantedField(formDetails, ['id', 'record_id', 'assignee_review']).length ? 'col-span-1' : 'col-span-1 '">
                                            <div v-if="!isEditing(index)"
                                                class="text-[16px] text-[#000] font-['poppins'] max-w-xs  my-2 flex justify-center items-center "
                                                :class="readMoreTitle == singleRecord.title ? ' ' : ''">
                                                <p v-if="expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)"
                                                    class=" !break-all ">
                                                    {{ singleRecord.value }}
                                                    <button class=" text-blue-400 font-['poppins']"
                                                        @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                                        v-if="singleRecord.value.length > 100 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                                </p>
                                                <!-- !line-clamp-4  -->
                                                <span v-tooltip="singleRecord.value" v-else
                                                    class="font-['poppins']  !line-clamp-1   !break-all ">
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
                                                </span>
                                            </div>
                                            <Textarea
                                                v-if="['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                                @input="updateValue(index, singleRecord.title, $event.target.value)"
                                                v-model="singleRecord.value" rows="3"
                                                :cols="['dimension'].includes(singleRecord.title) ? 30 : 20"
                                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" />

                                            <InputText @input="updateValue(index, singleRecord.title, $event.target.value)"
                                                type="text" v-model="singleRecord.value"
                                                v-else-if="!['dimension', 'kra'].includes(singleRecord.title) && isEditing(index)"
                                                class=" h-10 !bg-[#DDDDDD] !border-[rgb(246,246,246)]  p-2" />

                                            <div>
                                            </div>
                                        </div>

                                    </div>
                                </template>
                                <!-- {{findSelectedHeaderIsEnabled(formDetails, 'assignee_review')}} -->
                                <div class=" !h-[300px] borde-[5px] border-[#000] " v-if="findSelectedHeaderIsEnabled(formDetails, 'assignee_review')">
                                    <div class="grid grid-cols-12 items-center font-['poppins']"
                                        v-if="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value">
                                        <div class="flex justify-center col-span-6">
                                            <div class="flex items-center justify-center">
                                                <h1 class=" text-[#000] mx-2 ">
                                                    <span class=" mx-2 text-[#8B8B8B]">{{
                                                        findSelectedHeaderIsEnabled(formDetails,
                                                            'assignee_review').value.reviewer_level }}</span>
                                                    {{
                                                        findSelectedHeaderIsEnabled(formDetails,
                                                            'assignee_review').value.assignee_name
                                                    }}
                                                </h1>
                                                <h1 class="text-[#000] mx-2 ">({{
                                                    findSelectedHeaderIsEnabled(formDetails,
                                                        'assignee_review').value.assignee_code
                                                }})
                                                </h1>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex flex-col relative">
                                            {{ selectedRowdata.is_assignee_submitted != '' ?
                                                findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review :
                                                ''
                                            }}
                                            <p class="absolute top-[10px] text-[#8b8b8b] font-['poppins']">{{
                                                selectedRowdata.is_assignee_submitted == '' ? 'Achieved Target' : '' }}</p>
                                            <!-- <InputText v-if="!findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(formDetails,
                                                'target').value) && selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeForm(index, 'kpi_review', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value), reviewTotalKpiWeightage"
                                                type="text"
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review"
                                                class=" h-10 w-24  absolute !top-[-6px]  p-2   !border-[green] !bg-[#DDDDDD]" /> -->
                                            <!-- !bg-[#DDDDDD] !border-[rgb(246,246,246)] -->
                                            <!-- <InputText v-else-if="findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(formDetails,
                                                'target').value) && selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeFormNumberOrAlpha(index, 'kpi_review', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                type="text"
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review"
                                                class=" h-10 w-24 absolute top-[-6px]   !bg-[#DDDDDD] !border-[#f8f8f8]  p-2" /> -->
                                        </div>
                                        <div class="col-span-2 relative my-2">
                                            <p class="absolute top-[10px] text-[#8b8b8b] font-['poppins']">{{
                                                selectedRowdata.is_assignee_submitted == '' ? ' Achieved KPI ' : '' }}</p>
                                            <!-- If employee entered target is text then we will allow employee to fill target in text -->
                                            <!-- <InputText v-if="selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeFormKpi(index, 'kpi_percentage', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                type="text" readonly
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_percentage"
                                                class=" h-10 w-24 my-2 absolute top-[-6px] !bg-[#DDDDDD]  p-2" /> -->

                                            <!-- If employee entered target is Number then we will allow employee to fill target in Number -->
                                            <h1 class="text-[12px] text-[#000]  my-2 ">
                                                {{ findSelectedHeaderIsEnabled(formDetails,
                                                    'assignee_review').value.kpi_percentage == null ?
                                                    '' : findSelectedHeaderIsEnabled(formDetails,
                                                        'assignee_review').value.kpi_percentage }}
                                            </h1>
                                        </div>
                                        <div class="col-span-2">
                                            <!-- <Textarea v-if="selectedRowdata.is_assignee_submitted == ''" v-model="findSelectedHeaderIsEnabled(formDetails,
                                                'assignee_review').value.kpi_comments" rows="2" cols="12"
                                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" /> -->

                                            <h1 > {{ findSelectedHeaderIsEnabled(formDetails,
                                                'assignee_review').value.kpi_comments ?
                                                findSelectedHeaderIsEnabled(formDetails,
                                                    'assignee_review').value.kpi_comments.length > 20
                                                    ?
                                                    findSelectedHeaderIsEnabled(formDetails,
                                                        'assignee_review').value.kpi_comments.substring(0,
                                                            20) + '..' : findSelectedHeaderIsEnabled(formDetails,
                                                                'assignee_review').value.kpi_comments : '' }}</h1>
                                        </div>
                                    </div>
                                    <!-- {{findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value}} -->
                                    <div class="" v-if="findSelectedHeaderIsEnabled(formDetails, 'reviews_review')">
                                        <div class="grid grid-cols-12 items-center"
                                            v-if="findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value"
                                            v-for="(reviewer, index) in findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value">
                                            <!-- {{reviewer}} -->
                                            <div class="flex justify-center col-span-6  font-['poppins']">
                                                {{ reviewer.reviewer_name }} ({{ reviewer.reviewer_code }})
                                            </div>
                                            <div class="col-span-2 flex flex-col font-['poppins'] ">{{ reviewer.kpi_review }}</div>
                                            <div class="col-span-2  font-['poppins']">{{ reviewer.kpi_percentage }}</div>
                                            <div class="col-span-2  font-['poppins']">{{ reviewer.kpi_comments }}</div>
                                        </div>
                                    </div>
                                </div>
                            </AccordionTab>
                        </Accordion>


                            <!--  -->


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
                        <div class=" grid grid-cols-12 gap-4 py-3 px-4 my-2 bg-[#DDDD] rounded-md"
                            v-if="useStore.selected_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                            <div class=" " v-for="(headerRecord, headerIndex) in useStore.selected_header"
                                :class="[0, 1].includes(headerIndex) ? ' col-span-3 flex items-center justify-center ' : [2, 4].includes(headerIndex) ? 'col-span-2 flex items-center justify-center flex-col' : ' col-span-1 flex flex-col items-center justify-center'">
                                <h1 class="text-lg font-semibold text-center"
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
                            </div>
                        </div>

                        <div class="rounded-lg bg-[#FFF7EB] grid grid-cols-12 gap-4 p-4 my-2 relative  border-[1px] border-[#000] "
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
                                        {{ singleRecord.value }}
                                        <button class=" text-blue-400 font-['poppins']"
                                            @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                            v-if="singleRecord.value.length > 20 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                    </p>
                                    <!-- !line-clamp-4  -->
                                    <span v-else class="font-['poppins'] !line-clamp-1   !break-all ">

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
                            <div class="flex justify-center items-center col-span-2 absolute right-10 top-10 "
                                v-if="formvariable == 'Creation' || formvariable == 'View' || formvariable == 'view'">
                                <i class="pi pi-file-edit mx-2 cursor-pointer "
                                    @click="selectedEditIndex = index, editsavepublish1 = 'save', enableApproveReject = false"
                                    v-if="!isEditing(index)"></i>
                                <i class="pi pi-check  mx-2 cursor-pointer " v-if="isEditing(index)"
                                    @click="useStore.createKpiForm.form_details[index], selectedEditIndex = null, editsavepublish1 = 'save'"></i>

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

                            <button
                                v-if="formvariable == 'view' && editsavepublish1 == 'save' ? selectedRowdata ? (selectedRowdata.is_reviewer_accepted != 1) : '' : editsavepublish1 == 'save' && formvariable == 'Creation'"
                                @click="useStore.createKpiForm.form_name ? calculateTotalKpiWeightage == 100 ? (calculateKpiWeightage(useStore.createKpiForm.form_details), editsavepublish1 = 'publish', enableApproveReject = true) : useHelper.toastmessage('error', 'The combined weightage of KPIs or OKRs must equal to 100%') : useHelper.toastmessage('error', 'Form Name field is required.')"
                                class="text-[#000]  py-2 px-4 rounded-md mx-2"
                                :class="[calculateTotalKpiWeightage == 100 ? 'bg-[#F9BE00]' : 'bg-[#dddd]']">Save</button>


                            <button v-if="editsavepublish1 == 'publish' && formvariable != 'view'"
                                class="  rounded-[8px] w-[144px] !h-[33px] mx-2"
                                :class="[useStore.currentlySavedFormId ? 'bg-[#000] text-[#ffff]' : 'bg-[#DDDD] text-[#000]']"
                                @click="useStore.currentlySavedFormId ? useStore.createNewGoals ? (useStore.publishTeamForm(current_user_code,1), visibleRight = false, useStore.createTeamKpiForm = false) : '' : useHelper.toastmessage('error', 'Save the form to Publish')">
                                Publish</button>
                            <!-- <button class="text-[#000]  py-2 px-4 rounded-md mx-2 "
                                :class="[calculateTotalKpiWeightage == 100 ? enableApproveReject == true ? ' bg-[#F9BE00]' : 'bg-[#DDDD]' : 'bg-[#DDDD]']"
                                v-if="formvariable == 'view' && selectedRowdata.is_reviewer_accepted == ''"
                                @click="calculateTotalKpiWeightage == 100 ? enableApproveReject === true ? (useStore.teamKpiFormApproval(selectedRecordId, 1, ''), useStore.createTeamKpiForm = false, visibleRight = false, editsavepublish1 = '') : useHelper.toastmessage('error', '') : useHelper.toastmessage('error', 'The combined weightage of KPIs or OKRs must equal to 100%')">Approve</button> -->
<!--
                            <button class="text-[#fff]  py-2 px-4 rounded-md mx-2 bg-black "
                                v-if="formvariable == 'view' && selectedRowdata.is_reviewer_accepted == ''"
                                @click="reject_popup = true">Reject</button> -->

                            <button class="text-[#fff]  py-2 px-4 rounded-md mx-2 bg-black"
                                v-if="formvariable == 'view' && selectedRowdata.is_assignee_submitted === '' && selectedRowdata.is_reviewer_accepted == 1"
                                @click="revoke_popup = true">Revoke</button>

                        </div>
                    </div>
                </div>

            </div>
        </Sidebar>





    </div>
</template>

<script setup>
import { ref, reactive, computed , onMounted } from 'vue';
import { usePmsHelperStore} from '../stores/pmsHelperStore';
import { usePmsMainStore } from '../stores/pmsMainStore';
import { Service } from '../../Service/Service';
import LoadingSpinner from '../../../components/LoadingSpinner.vue';
import useValidate from '@vuelidate/core';
import { FilterMatchMode } from 'primevue/api';
import { required, email, minLength, helpers } from '@vuelidate/validators';
import { useToast } from 'primevue/usetoast';



const  useStore = usePmsMainStore();
const  useHelper = usePmsHelperStore();

const useService  = Service();
const toast = useToast();
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
const currentUserCode  = ref();
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

function view_form_edit_withdraw(data, selectedRow) {
    selectedRowdata.value = selectedRow;
    // save_self_appraisal.value = data;
    // console.log(save_self_appraisal.value);
    // console.log(selectedRow);

}

function toggleItem(index) {
    activeItem.value = activeItem.value === index ? null : index;
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
    useStore.orgAppraisalFlow();
    let user_code;
    await useService.getCurrentUserCode().then(res => {
        user_code = res.data;
        currentUserCode.value = res.data
    })
    const flow_type = 1
    await useStore.getTeamAppraisalDashboardDetails(user_code)
    await useStore.getPmsConfiguration(flow_type, user_code)
    await useStore.getKPIFormAsDropdown(user_code)
    await useStore.getDashboardCardDetails_TeamAppraisal(user_code,1);

    const obj = { "test": [
           { "id": 7, "num": 112},
           { "id": 8, "num": 11},
           { "id": 3, "num": 10 },
           { "id": 3, "num": 12 },
           { "id": 9, "num": 12 }
        ]};
const idSet = new Set();





// a Set stores unique values of any type
// for each element in test[] try to add the id to idSet

// const hasDuplicate = obj.test.some(element => {
//   console.log("id ", element.id, " is already in set: ", idSet.has(element.id));

  // returns true for the first duplicate and terminates .some()

//   if(idSet.size === idSet.add(element.id).size) {
//     delete
//   }

// });

});

const visibleRight  =ref(false);


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
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_percentage = (parseInt(useStore.createKpiForm.form_details[index].reviews_review[reviewerIndex].kpi_review) / parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_review)) * parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_percentage)
        let containsNumbers = /\d/.test(useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex].kpi_review);
        if (containsNumbers) {
            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_weightage'] = useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue)
            // toast.add({ severity: 'error', summary: 'Error Message', detail: 'The target should be less than or' })
            // useStore.createKpiForm.form_details[index].assignee_review.target = null
        } else {

        }
    } else {
        console.log('Index out of range or form_details is not an array.');
    }
};

const updateAssigneeFormNumberOrAlpha = (index, reviewerIndex, field, newValue) => {
    if (useStore.createKpiForm.form_details[index]['reviews_review']) {
        useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex][field] = newValue;
        if ((useStore.createKpiForm.form_details[index].assignee_review.kpi_review).toUpperCase() === (useStore.createKpiForm.form_details[index].reviews_review[reviewerIndex].kpi_review).toUpperCase()) {
            useStore.createKpiForm.form_details[index]['reviews_review'][reviewerIndex]['kpi_percentage'] = useStore.createKpiForm.form_details[index].assignee_review.kpi_percentage;
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
        useStore.createKpiForm.form_details[index]['assignee_review'][field] = newValue;
        useStore.createKpiForm.form_details[index]['assignee_review']['kpi_weightage'] = useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue)
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


<style>
.accordion-header
{
    /* Your styles */
    background-color: #fff7eb;
    padding: 1rem;
}
.accordion-content
{
    /* Your styles */
    padding: 1rem 0 0 0;
}
</style>
