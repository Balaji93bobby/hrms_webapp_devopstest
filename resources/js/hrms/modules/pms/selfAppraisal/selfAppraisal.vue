<template>
    <Toast />
    <loadingSpinner v-if="useStore.canShowLoading" class="absolute z-50 bg-white" />
    <div>
        <div class="">
            <!-- <h1 class=" text-[20px] text-[#000] font-semibold my-2 ">PMS - Review Dashboard</h1> -->
            <div class="grid grid-cols-3 gap-2"
                v-if="useStore.selfReviewDashboardSource ? useStore.selfReviewDashboardSource.employee_details : ''">
                <div class="card h-[200px] p-4"
                    v-if="useStore.selfReviewDashboardSource ? useStore.selfReviewDashboardSource.employee_details ? useStore.selfReviewDashboardSource.employee_details : {} : ''">
                    <div class=" flex justify-start items-center">
                        <div class="flex items-center justify-center">
                            <span
                                v-if="useStore.selfReviewDashboardSource.employee_details.avatar_or_shortname.type == 'shortname'"
                                class="font-semibold text-white rounded-full w-[40px] h-[40px] flex justify-center items-center"
                                :class="useStore.selfReviewDashboardSource.employee_details.avatar_or_shortname.type == 'shortname' ? useService.getBackgroundColor(1) : ''">
                                {{ useStore.selfReviewDashboardSource.employee_details.avatar_or_shortname.data }} </span>
                            <img v-else class="rounded-circle userActive-status profile-img w-[40px] h-[40px] "
                                :src="`data:image/png;base64,${useStore.selfReviewDashboardSource.employee_details.avatar_or_shortname.data}`"
                                srcset="" alt="" />
                        </div>
                        <div class=" flex flex-col justify-center mx-4">
                            <h1 class=" text-[#000] font-semibold font-['poppins'] ">
                                {{ useStore.selfReviewDashboardSource.employee_details.name }}-
                                {{ useStore.selfReviewDashboardSource.employee_details.user_code }}</h1>
                            <p class=" text-[#535353] font-['poppins'] my-1">
                                {{ useStore.selfReviewDashboardSource.employee_details.designation }}</p>
                        </div>
                    </div>
                    <div class=" flex flex-col justify-start my-2">
                        <p class="text-[#535353] font-['poppins'] my-1">Reporting Manager</p>
                        <h1 class=" text-[#000] font-semibold font-['poppins']">
                            {{ useStore.selfReviewDashboardSource.employee_details.reporting_manager }}-( {{
                                useStore.selfReviewDashboardSource.employee_details.reporting_manager_usercode }}) </h1>
                    </div>
                    <div class=" flex flex-col justify-start my-2">
                        <p class="text-[#535353] font-['poppins'] my-1">Review Period</p>
                        <h1 class=" text-[#000] font-semibold font-['poppins']">
                            {{ useStore.selfReviewDashboardSource.employee_details.review_period }} </h1>
                    </div>
                </div>
                <div class="card h-[200px]"
                    v-if="useStore.selfReviewDashboardSource.current_form_rating ? useStore.selfReviewDashboardSource.current_form_rating : {}">
                    <div class="bg-[#E6E6E6] p-3">
                        <h1 class="text-[#000] font-semibold font-['poppins']">Current Rating</h1>
                    </div>
                    <div class="p-3">
                        <h1 class="text-[#535353] font-['poppins'] my-1">Current Period
                            ({{ useStore.selfReviewDashboardSource.current_form_rating.frequency }})</h1>
                        <h1 class="text-[#000] font-semibold font-['poppins'] my-1">
                            {{ useStore.selfReviewDashboardSource.current_form_rating.period }}</h1>
                        <h1 class="text-[#535353] font-['poppins'] mt-[25px] my-2">Scores</h1>
                        <div class="grid grid-cols-3 gap-2 !font-['poppins'] ">
                            <div class=" h-[54px]  bg-[#F6F6F6] rounded-md flex flex-col justify-center items-center p-2">
                                <h1 class=" font-semibold mt-2 ">Self</h1>
                                <div class=" flex  justify-center items-center">
                                    <h1 class="my-2"
                                        v-if="useStore.selfReviewDashboardSource.current_form_rating.score.self_score == 0 || useStore.selfReviewDashboardSource.current_form_rating.score.self_score == ''">
                                        {{ useStore.selfReviewDashboardSource.current_form_rating.score.self_score }}
                                        %</h1>
                                    <div v-else class=" flex items-center justify-center">
                                        <h1 class="my-2"
                                            :class="[useStore.selfReviewDashboardSource.current_form_rating.score.self_score >= 100 ? ' text-[#387C2D] ' : 'text-[#B20000]']">
                                            {{ useStore.selfReviewDashboardSource.current_form_rating.score.self_score }}
                                            %</h1>
                                        <!-- useStore.selfReviewDashboardSource.current_form_rating.score.self_score  -->
                                        <i class="pi pi-arrow-up text-[#387C2D]"
                                            v-if="useStore.selfReviewDashboardSource.current_form_rating.score.self_score >= 100"></i>
                                        <i class="pi text-[#B20000] pi-arrow-down" v-else></i>
                                    </div>
                                </div>
                            </div>
                            <div class=" h-[54px]  bg-[#F6F6F6] rounded-md flex flex-col justify-center items-center p-2 ">
                                <h1 class="font-semibold ">Manager</h1>
                                <!--   -->

                                <div class="flex justify-center items-center">
                                    <h1 class="my-2"
                                        v-if="useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score == '' || useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score == 0">
                                        0 %</h1>
                                    <div v-else class=" flex items-center justify-center">
                                        <!-- {{ useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score
                                        }} -->
                                        <h1 class="my-2"
                                            :class="[useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score > useStore.selfReviewDashboardSource.current_form_rating.score.self_score ? ' text-[#387C2D] ' : 'text-[#B20000]']">
                                            {{
                                                useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score
                                            }}
                                            %</h1>
                                        <!-- useStore.selfReviewDashboardSource.current_form_rating.score.self_score  -->
                                        <i class="pi pi-arrow-up text-[#387C2D]"
                                            v-if="useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score > useStore.selfReviewDashboardSource.current_form_rating.score.self_score"></i>
                                        <i class="pi text-[#B20000] pi-arrow-down" v-else></i>
                                    </div>

                                </div>
                            </div>
                            <div class=" h-[54px]  bg-[#F6F6F6] rounded-md flex flex-col justify-center items-center p-2">
                                <h1 class="font-semibold ">HR</h1>
                                <div class="">
                                    <h1 class="my-2"
                                        v-if="useStore.selfReviewDashboardSource.current_form_rating.score.hr_score == '' || useStore.selfReviewDashboardSource.current_form_rating.score.hr_score == 0">
                                        0 %
                                    </h1>
                                    <div class="flex justify-center items-center " v-else>
                                        <h1
                                            :class="[useStore.selfReviewDashboardSource.current_form_rating.score.hr_score >= useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score ? ' text-[#387C2D]' : 'text-[#B20000] ']">
                                            {{ useStore.selfReviewDashboardSource.current_form_rating.score.hr_score }} %
                                        </h1>
                                        <i class="pi pi-arrow-up text-[#387C2D]"
                                            v-if="useStore.selfReviewDashboardSource.current_form_rating.score.hr_score >= useStore.selfReviewDashboardSource.current_form_rating.score.l1_reviewers_score"></i>
                                        <i class="pi text-[#B20000] pi-arrow-down" v-else></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card h-[200px]"
                    v-if="useStore.selfReviewDashboardSource.overall_rating ? useStore.selfReviewDashboardSource.overall_rating : []">
                    <div class="bg-[#E6E6E6] p-3">
                        <h1 class="text-[#000] font-semibold font-['poppins']">Overall Ratings</h1>
                    </div>
                    <div class=" p-3">
                        <p class="my-2 font-['poppins']">Overall Annual Score</p>
                        <!-- {{useStore.selfReviewDashboardSource.overall_rating.overall_perform_rating}} -->
                        <ProgressBar
                            :value="useStore.selfReviewDashboardSource.overall_rating.overall_perform_rating.annual_score"
                            class=""></ProgressBar>
                        <!-- Overall Corresponding -->
                        <div class=" flex justify-start items-center">
                            <span class=" mt-[25px] font-['poppins'] mb-1 mr-4 "> Recommendation : </span>
                            <span class=" mt-[25px] text-[#000] font-['poppins'] font-semibold text-[13px] ">
                                <span class=" text-green-500">
                                    {{ useStore.selfReviewDashboardSource.overall_rating.overall_perform_rating.perfomance
                                    }}
                                    ( {{ useStore.selfReviewDashboardSource.overall_rating.overall_perform_rating.action }}%
                                    )</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" my-4">
                <div class=" flex justify-between items-center " :class="activeTab != 3 ? '' : 'invisible'">
                    <div class=" flex justify-center items-center " :class="index == 0 ? ' ' : 'w-full'"
                        v-for="(item, index) in useStore.SelfTimeLine">
                        <div class="border-[1px] border-dashed border-[#82AB7B]  w-[100%]  "
                            :class="index == 0 ? ' border-[1px] border-dashed border-transparent' : ''">
                        </div>
                        <div class=" flex flex-col relative items-center">
                            <button class=" py-2 rounded-md font-[poppins] px-2 w-[160px]  text-center whitespace-nowrap"
                                :class="[(item.status == 1 || item.status == true) ? 'bg-[#82AB7B] text-[#ffff] ' : item.status == 0 ? 'border-[1px] bg-[white] border-[rgb(130,171,123)] text-[#82AB7B]' : ' bg-[#E6E6E6] text-[#8B8B8B]']">
                                {{ item.title }}
                            </button>
                            <div :class="item.actual_date ? ' left-[-4px]' : 'left-0'"
                                class=" !text-[9px] absolute  top-[34px] text-nowrap flex justify-center text-gray-500 font-['poppins']">
                                Exp: {{ item.expected_date }} - <span class=" ml-[2px] !text-[9px]"
                                    :class="item.is_overdue === 0 ? ' text-[green]' : 'text-[red]'">
                                    {{ item.actual_date ? '' + ' Act: ' + item.actual_date : '' }}
                                </span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-2 ">
            <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 border-b-[3px] border-gray-300 "
                role="presentation">
                <li class=" nav-item" role="presentation">
                    <a class="px-2 position-relati3e !border-none font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="activeTab = 1, useStore.createKpiForm.form_details = ''"
                        :class="[activeTab === 1 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        PENDING
                        <span class="relative left-[60px] top-[-25px] flex h-3 w-3 !z-10"
                            :class="useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalPendingStatusSource(useStore.selfDashboardPublishedFormList, '', 1).length > 0 ? '' : 'hidden' : 'hidden'">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </a>
                    <div v-if="activeTab === 1" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                </li>
                <li class=" nav-item" role="presentation">
                    <a class="px-2 position-relati3e border-none font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="activeTab = 2, useStore.getSelfTimeLine(currentUserCode, useStore.record_id)"
                        :class="[activeTab === 2 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]']">
                        CURRENT
                    </a>
                    <div v-if="activeTab === 2" class="relative h-1 rounded-l-3xl top-1 "
                        style="border: 2px solid #F9BE00 !important;"></div>
                </li>
                <li class="border-0 nav-item position-relative" role="presentation">
                    <a class=" text-center px-3  border-0 font-['poppins'] text-[12px]  text-[#001820]" id=""
                        data-bs-toggle="pill" href="" @click="activeTab = 3"
                        :class="[activeTab === 3 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]']" role="tab"
                        aria-controls="" aria-selected="true">
                        COMPLETED
                    </a>
                    <div v-if="activeTab === 3" class=" h-1 relative top-1  bottom-[1px] left-0 w-[100%]"
                        style="border: 2px solid #F9BE00 !important;"></div>
                </li>
            </ul>
            <div class="flex justify-between m-3 " v-if="useStore.addGoalStatus == 0 && activeTab === 2">
                <button
                    @click="visibleRight = true, useStore.getPmsConfiguration(3, current_user_code), editsavepublish = ''"
                    class=" bg-[#F9BE00] text-[13px] rounded-md text-[#000] !w-[120px] h-[35px] font-semibold flex justify-center items-center ">
                    <i class="mr-2 pi pi-plus"></i>
                    Add Goals</button>
            </div>
        </div>
        {{ findTimeline }}
        <div class="" v-if="activeTab == 1">
            <DataTable v-if="useStore.selfDashboardPublishedFormList"  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
                :value="useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalPendingStatusSource(useStore.selfDashboardPublishedFormList, '', 1) : []"
                 class=" w-[100%] " :filters="filters">
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
                                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">
                                <!-- {{
                                    slotProps.data.assignee_name }}  -->
                                    {{
                                                slotProps.data.assignee_name.substring(0,
                                                    14) +  '..'  }} </span>
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
                <Column field="score" header="Score" style=""></Column>
                <Column header="Status">
                    <template #body="{ data }">

                        <!-- <button
                            @click="useStore.createSelfKpiSidebar = true, useStore.createKpiForm = { ...data.kpi_form_details }, useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id"
                            class=" bg-[#F9BE00] px-4 py-1 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                            Review</button> -->
                        {{ data.status }}
                    </template>
                </Column>
                <Column header="Action">
                    <template #body="{ data }">
                        <div v-if="useHelper.pmsKpiFormAcceptance([data])" class="flex justify-center ">
                            <!-- <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                                @click="useStore.acceptRejectReviewForm({ user_id: data.assignee_id, record_id: data.id, status: 1, reviewer_comments: '' })">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </button>
                            <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                                @click="useStore.acceptRejectReviewForm({ user_id: assignee_id, record_id: data.id, status: -1, reviewer_comments: '' })">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button> -->

                            <button
                                class="bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]"
                                @click="viewEditWithdrawForm(data.reviewer_details, data), selectedRowdata = data, useStore.getSelfTimeLine(currentUserCode, data.id),  useStore.selected_header = data.form_header , useStore.createSelfKpiSidebar = true, visibleRight = false, hideObjectiveInput = false, viewEditWithdraw = 'view', useStore.getKPIFormDetails(data.kpi_form_details.form_id), canHiddenUploadOptions = false, useStore.canShowAssigneeReviewForm = false">
                                <i class=" pi pi-eye"></i>
                            </button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
        <div class="" v-if="activeTab == 2">
            <!-- current -->
            <!--  -->
            <!-- {{useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, '')}} -->
            <DataTable scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
                :value="useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, '')"
                class=" w-[100%] " :filters="filters">
                <Column field="assignee_name" header="Employee" style="" class="">

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
                                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] ">   {{
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
                <!-- <Column field="employee_status" header="Employee Status" style="width: 25%"></Column>
                <Column field="manager_status" header="Manager Status" style="width: 25%"></Column>
                <Column field="hr_status" header="HR Status" style="width: 25%"></Column> -->
                <Column field="score" header="Score"></Column>
                <Column header="Status" field="status" style="">
                    <template #body="{ data }">
                        <div v-if="(data.status).toUpperCase() == 'COMPLETED'">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">{{
                                    data.status }}</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">{{
                                    data.status }}</span>
                        </div>
                        <!-- <button @click="useStore.createSelfKpiSidebar = true, useStore.createKpiForm = { ...data.kpi_form_details }"class=" bg-[#F9BE00] px-4 text-[16px] rounded-md text-[#ffff] h-[35px] font-semibold ">
                            Review</button> -->
                    </template>
                </Column>
                <Column header="Action">
                    <template #body="{ data }">
                        <div class="flex justify-center items-center">
                            <button
                                v-if="data.reviewer_details ? data.reviewer_details[0].review_order == 1 && data.reviewer_details[0].is_accepted == 1 : ''"
                                @click="useStore.getSelfTimeLine(currentUserCode, data.id), useStore.createSelfKpiSidebar = true,  useStore.selected_header = data.form_header , useStore.createKpiForm = { ...data.kpi_form_details }, review_save = 'save', viewEditWithdrawForm(data.reviewer_details, data), viewEditWithdraw = 'Review', useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id, data.is_assignee_submitted == 1 ? isFormSubmitted = true : isFormSubmitted = false, canHiddenUploadOptions = false"
                                class=" bg-[#F9BE00] px-4 py-1 !text-[13px] rounded-md text-[#ffff] h-[33px] !font-['poppins'] ">
                                Review</button>
                            <button
                                class="bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]"
                                v-else
                                @click="viewEditWithdrawForm(data.reviewer_details, data), useStore.getSelfTimeLine(currentUserCode, data.id), useStore.selected_header = data.form_header , useStore.createSelfKpiSidebar = true, visibleRight = false, hideObjectiveInput = false, viewEditWithdraw = 'view', useStore.getKPIFormDetails(data.kpi_form_details.form_id), canHiddenUploadOptions = false, useStore.canShowAssigneeReviewForm = false">
                                <i class=" pi pi-eye"></i>
                            </button>
                        </div>
                        <div v-if="edit === data.id" @mouseleave="edit = ''"
                            class="absolute flex flex-col bg-white shadow-2xl top-4 z-[1000] "
                            style="width: 120px; margin-top:12px !important;margin-right: 20px !important; ">
                            <div class="p-0 m-0 d-flex flex-column rounded-md overflow-hidden">
                                <button
                                    @click="useStore.createSelfKpiSidebar = true, visibleRight = false, hideObjectiveInput = false, viewEditWithdraw = 'view', useStore.getKPIFormDetails(data.kpi_form_details.form_id)"
                                    class=" h-[30px] p-2 text-black font-['poppins']  fw-semibold hover:bg-gray-200 border-bottom-1">View</button>
                                <button v-if="data.reviewer_details[0].is_accepted == -1"
                                    class=" !h-[33px] font-['poppins']  border-[1px] text-black fw-semibold hover:bg-gray-200 ho"
                                    @click="useStore.createSelfKpiSidebar = true, visibleRight = false, hideObjectiveInput = false, viewEditWithdraw = 'Edit', useStore.getKPIFormDetails(data.kpi_form_details.form_id), useStore.record_id = data.kpi_form_details.form_id">Edit</button>
                                <button
                                    class=" !h-[33px]  font-['poppins'] border-[1px] text-black fw-semibold hover:bg-gray-200 ho"
                                    @click="withdraw()">Withdraw</button>
                            </div>
                        </div>
                        <div v-if="useHelper.pmsKpiFormAcceptance([data])">
                            <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                                @click="useStore.acceptRejectReviewForm({ user_id: data.assignee_id, record_id: data.id, status: 1, reviewer_comments: '' })">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </button>
                            <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                                @click="useStore.acceptRejectReviewForm({ user_id: assignee_id, record_id: data.id, status: -1, reviewer_comments: '' })">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </Column>
                <Column header="Comments" style="" class=" w-[50px]">
                    <template #body="{ data }">
                        <div>
                            {{ data.reviewer_details[0].rejection_comments ?
                                data.reviewer_details[0].rejection_comments.length
                                    > 20
                                    ?
                                    data.reviewer_details[0].rejection_comments.substring(0,
                                        20) + `.. ` : data.reviewer_details[0].rejection_comments : '' }}
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
        <div class="" v-if="activeTab == 3">
            <!-- compeleted -->
            <DataTable  scrollable  paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" v-if="useStore.selfDashboardPublishedFormList" @rowSelect="onRowSelect"
                @rowUnselect="onRowUnselect" v-model:selection="selectedProduct" selectionMode="single"
                :metaKeySelection="metaKey"
                :value="useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, 1) : []"
                 class=" w-[100%] " :filters="filters">
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
                                <span class=" font-semibold  text-[#0873CD] font-['poppins']  text-[14px] "> {{
                                                slotProps.data.assignee_name.substring(0,
                                                    14) +  '..'  }} </span>
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
                <Column field="score" header="Score" style=""></Column>
                <Column header="Status">
                    <template #body="{ data }">
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">
                            {{ data.status }}</span>
                    </template>
                </Column>
                <Column header="Action">
                    <template #body="{ data }">
                        <div class="flex justify-center items-center">
                            <button
                                @click="useStore.createSelfKpiSidebar = true, selectedRowdata = data, useStore.getSelfTimeLine(currentUserCode, data.id), useStore.createKpiForm = { ...data.kpi_form_details }, useStore.selected_header = data.form_header , useStore.canShowAssigneeReviewForm = !useHelper.pmsKpiFormAcceptance([data]), currentlyRecords = data.id"
                                class="  !text-[13px] !font-['poppins']  bg-[#F9BE00] rounded-md flex justify-center items-center h-[20px] w-[30px] text-black hover:bg-[#DAAA13]">
                                <i class=" pi pi-eye"></i>
                            </button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>


        <Sidebar v-model:visible="visibleRight" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
            <h2 class="  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]"> New Goals
                Assign</h2>
            <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer"
                @click="visibleRight = false"></i>
            <div class=" p-2">
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575] my-2">Calendar Type</label>
                        {{ calendarType }}
                        <InputText type="text" v-model="useStore.createNewGoals.calendar_type" disabled
                            class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />
                    </div>
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575]  my-2">Year</label>

                        <InputText type="text" v-model="useStore.createNewGoals.year" disabled
                            class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575] my-2">Frequency</label>
                        {{ frequency }}
                        <InputText type="text" v-model="useStore.createNewGoals.frequency" disabled
                            class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                    </div>
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575]  my-2">Assignment Period</label>
                        <InputText type="text" v-model="useStore.createNewGoals.assignment_period" disabled
                            class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575] my-2">Department</label>
                        <Dropdown :options="useStore.departmentOptions" optionLabel="name" optionValue="id"
                            v-model="useStore.createNewGoals.department_id" disabled
                            class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6] border-[1px]" />
                    </div>
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575]  my-2">Employee</label>
                        <InputText type="text" v-model="useStore.createNewGoals.employee_name" disabled
                            class=" h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mt-2">
                    <div class="flex flex-col ">
                        <label for="" class=" text-[12px] text-[#757575]  my-2 ">Reviewer</label>
                        <InputText type="text" v-model="useStore.createNewGoals.manager_name" disabled
                            class="h-10 !bg-[#DDDDDD] !border-[#F6F6F6]" />
                    </div>
                </div>
                <div class="  w-[100%] ">
                    <hr class=" border-[1px] my-4 ">
                    <h1 class=" text-[#000] font-semibold text-[16px]">Goals/ Areas of Development</h1>
                    <div class="flex items-center justify-between ">
                        <p class=" text-[12px] text-[#757575] w-[240px]">Select Existing Form from the Drop Down</p>
                        {{ useStore.department }}
                        <Dropdown v-model="useStore.createNewGoals.kpi_form_id" :options="useStore.existingKpiFormOptions"
                            optionLabel="form_name" optionValue="id" placeholder="Select KPI form"
                            @click="useStore.createNewGoals.kpi_form_id ? useStore.getKPIFormDetails(useStore.createNewGoals.kpi_form_id) : null"
                            class="h-10 mx-2 w-[250px]">
                            <template #value="slotProps">
                                <div v-if="slotProps.option" class="flex align-items-center">
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="flex justify-between items-center">
                                    <p>{{ slotProps.option.form_name }}</p>
                                    <svg v-if="slotProps.option.is_assigned == 1" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-8 h-8 font-semibold text-green-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>

                                </div>
                            </template>
                        </Dropdown>
                        <button
                            @click="useStore.createNewGoals.kpi_form_id ? (useStore.createKpiForm.form_details.length === 0 ? addMore = false : addMore = false, useStore.createSelfKpiSidebar = true, viewEditWithdraw = 'Edit', visibleRight = false, hideObjectiveInput = true, useStore.getKPIFormDetails(useStore.createNewGoals.kpi_form_id), useStore.currentlySavedFormId = useStore.createNewGoals.kpi_form_id) : showWarn()"
                            class="h-[33px] w-[144px] rounded-[8px] " severity="warning"
                            :class="[useStore.createNewGoals.kpi_form_id ? 'bg-[#F9BE00]' : ' bg-[#DDDDDD] ']">View
                            Form</button>
                    </div>
                </div>
                <div class=" flex justify-center h-[200px] my-4">
                    <img src="../assests/self_Appraisal.png" alt="" class="">
                </div>

                <div class=" flex items-center justify-center left-[25%]">
                    <button class=" bg-[#001820] text-[#ffff] rounded-[8px] p-2 mx-4 w-[144px] h-[33px]"
                        @click=" addMore = true, useStore.currentlySavedFormId = '', useStore.createSelfKpiSidebar = true, viewEditWithdraw = 'Creation', hideObjectiveInput = true, visibleRight = false, useStore.canShowAssigneeReviewForm = false, useStore.createKpiForm.form_name = null, useStore.createKpiForm.form_details = [], useStore.createKpiForm.form_name = `OKR_FORM ` + `_` + currentUserCode + `_` + useService.current_user_name + `_` + useStore.createNewGoals.assignment_period.toUpperCase()">
                        Create KPI Form
                    </button>
                    <button class=" text-[#000] rounded-[8px] w-[144px] !h-[33px]"
                        :class="[useStore.createNewGoals.kpi_form_id ? 'bg-[#F9BE00]' : 'bg-[#DDDD]']"
                        @click="useStore.createNewGoals.kpi_form_id ? (useStore.publishForm(current_user_code), visibleRight = false, addMore = false, useStore.createSelfKpiSidebar = false, useStore.createNewGoals.kpi_form_id = '') : useHelper.toastmessage('error', 'Select KPI form')">
                        Publish</button>
                </div>
            </div>
        </Sidebar>

        <Sidebar v-model:visible="useStore.createSelfKpiSidebar" position="right" class="relative !z-0 "
            :style="{ width: '80vw !important' }">
            <h2
                class="  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]  cursor-pointer ">
                KPI / OKR Form
                {{ viewEditWithdraw == 'edit' ? 'Edit' : viewEditWithdraw == 'Reject Edit option' ? 'Edit' :
                    viewEditWithdraw == 'Reject Edit option' ? 'Creation' : viewEditWithdraw == 'Review' ? 'Self Review'
                        : 'view' }}</h2>
            <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200 cursor-pointer "
                @click="sidebarPopup = true"></i>
            <div class="  w-[100%]  p-3">
                <div class="flex flex-col" v-if="canHiddenUploadOptions && selectedRowdata ?  !['Completed','Employee Self Reviewed'].includes(selectedRowdata.status) : ''  ">
                    <h1 class=" text-[#000] font-semibold text-[16px] my-2">Goals/ Areas of Development</h1>
                    <div class="flex items-center justify-between">
                        <div class="flex item-center">
                            <input type="file" accept=".xlsx" class=" w-[250px] form-control file"
                                @change="useHelper.convertExcelIntoArray($event)" />
                            <button @click="useHelper.uploadconvertExcelIntoArray"
                                class="  h-[33px] w-[108px] text-[#000] rounded-[8px] mx-[20px]"
                                :class="[useHelper.excelupload ? 'bg-[#F9BE00]' : 'bg-[#DDDD] ']">
                                <i class="pi pi-upload"></i> <span class=" mx-2">Upload</span></button>
                        </div>
                        <div class="flex items-center justify-center ">
                            <p class=" text-[#000] mx-2 text-end font-['poppins']">Download the</p>
                            <button @click="useStore.downloadSampleForm(currentUserCode)"
                                class="bg-yellow-400 text-[#000] rounded-md py-2 px-2 h-[33px] w-[184px]">
                                <i class="pi pi-download"></i> <span class=" mx-1"></span> Sample File</button>
                        </div>
                    </div>

                </div>
                <div class="flex items-end justify-end">
                        <button v-if="selectedRowdata  ?  selectedRowdata.status=='Completed' || selectedRowdata.status== 'Employee Self Reviewed' : null"  @click="useStore.btn_download = !useStore.btn_download, useStore.downloadFormPMSReport()"
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
                <div v-if="useStore.canShowAssigneeReviewForm" class="">
                    <div v-if="useStore.createKpiForm.form_details" class="my-3">
                        <div class=" flex justify-between items-center ">
                            <div class=" flex justify-center items-center border-[#000]"
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
                                            :class="item.is_overdue === 0 ? ' text-[#82AB7B]' : 'text-[red]'">{{
                                                item.actual_date
                                            }}
                                        </span></div>
                                </div>
                            </div>
                        </div>
                        <div v-if="useStore.createKpiForm.form_details">
                            <div class=" grid grid-cols-12 gap-2 py-3 px-4  bg-[#DDDD] rounded-md mt-10 mb-2"
                                v-if="useStore.selected_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                                <div class="" v-for="(headerRecord, headerIndex) in useStore.selected_header"
                                    :class="[0, 1].includes(headerIndex) ? ' col-span-3 flex items-center justify-center ' : [2, 4].includes(headerIndex) ? 'col-span-2 flex items-center justify-center flex-col ' : ' col-span-2 flex flex-col items-center justify-center'">
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
                                    <p class="text-center font-semibold relative"
                                        v-if="headerRecord ? headerRecord.header_name == 'kpi_weightage' : ''">
                                        <span class=" text-gray-400 font-['poppins'] ">Overall -</span>
                                        <span class="font-['poppins']"
                                            :class="[TotalAssigneeKpiWeightage >= 100 ? ' text-green-500' : '']"> {{
                                                TotalAssigneeKpiWeightage }} %</span>
                                        <span
                                            class=" absolute  right-[-120px] text-lg font-semibold top-[-20px]">Comments</span>
                                    </p>
                                </div>

                            </div>
                        </div>
                        <Accordion :activeIndex="0"  v-if="formatConverter(useStore.createKpiForm.form_details)">
                            <AccordionTab class="flex"
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
                                <div class=" flex flex-col justify-center h-[100%]" >

                                    <div class=" " v-if="findSelectedHeaderIsEnabled(formDetails, 'assignee_review')">
                                    <div class="grid grid-cols-12 items-center font-['poppins']"
                                        v-if="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value">
                                        <div class="flex justify-start col-span-6">
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
                                        <div class="col-span-2 flex flex-col relative ">
                                            {{ selectedRowdata.is_assignee_submitted != '' ?
                                                findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review :
                                                ''
                                            }}
                                            <p class="absolute top-[-35px] text-[#8b8b8b] font-['poppins'] ">{{
                                                selectedRowdata.is_assignee_submitted == '' ? 'Achieved Target' : '' }}</p>
                                            <InputText v-if="!findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(formDetails,
                                                'target').value) && selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeForm(index, 'kpi_review', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value), reviewTotalKpiWeightage"
                                                type="text"
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review"
                                                class=" h-10 w-24  absolute !top-[-6px]  p-2   !border-[green] !bg-[#DDDDDD]" />
                                            <!-- !bg-[#DDDDDD] !border-[rgb(246,246,246)] -->
                                            <InputText v-else-if="findTargetIsNumberOrAlpha(findSelectedHeaderIsEnabled(formDetails,
                                                'target').value) && selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeFormNumberOrAlpha(index, 'kpi_review', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                type="text"
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_review"
                                                class=" h-10 w-24 absolute top-[-6px]   !bg-[#DDDDDD] !border-[#f8f8f8]  p-2" />
                                        </div>
                                        <div class="col-span-2 relative my-2">
                                            <p class="absolute top-[-34px] text-[#8b8b8b] font-['poppins']">{{
                                                selectedRowdata.is_assignee_submitted == '' ? ' Achieved KPI ' : '' }}</p>
                                            <!-- If employee entered target is text then we will allow employee to fill target in text -->
                                            <!-- readonly -->
                                            <InputText v-if="selectedRowdata.is_assignee_submitted == ''"
                                                @focusout="updateAssigneeFormKpi(index, 'kpi_percentage', $event.target.value), useStore.fillAssigneeReviewForm(findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.id, currentlyRecords, findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.target, findSelectedHeaderIsEnabled(formDetails, 'target').value, reviewTotalKpiWeightage)"
                                                type="text"
                                                v-model="findSelectedHeaderIsEnabled(formDetails, 'assignee_review').value.kpi_percentage"
                                                class=" h-10 w-24 my-2 absolute top-[-6px] !bg-[#DDDDDD]  p-2" />

                                            <!-- If employee entered target is Number then we will allow employee to fill target in Number -->
                                            <h1 v-else class="text-[12px] text-[#000]  my-2 pl-[20px] ">
                                                {{ findSelectedHeaderIsEnabled(formDetails,
                                                    'assignee_review').value.kpi_percentage == null ?
                                                    '' : findSelectedHeaderIsEnabled(formDetails,
                                                        'assignee_review').value.kpi_percentage }}
                                            </h1>
                                        </div>
                                        <div class="col-span-2">
                                            <Textarea v-if="selectedRowdata.is_assignee_submitted == ''" v-model="findSelectedHeaderIsEnabled(formDetails,
                                                'assignee_review').value.kpi_comments" rows="2" cols="12"
                                                class=" !bg-[#f6f6f6] border-[1px] border-[#dddddd]   p-2" />

                                            <h1 v-else> {{ findSelectedHeaderIsEnabled(formDetails,
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
                                    <!-- {{findSelectedHeaderIsEnabled(formDetails, 'reviews_review')}} -->
                                    <div class="" v-if="findSelectedHeaderIsEnabled(formDetails, 'reviews_review')">
                                        <div class="grid grid-cols-12 items-center"
                                            v-if="findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value"
                                            v-for="(reviewer, index) in findSelectedHeaderIsEnabled(formDetails, 'reviews_review').value">
                                            <!-- {{reviewer}} -->
                                            <!-- <div class="flex justify-center col-span-6  font-['poppins']">

                                            </div> -->
                                            <div class="flex items-center justify-start col-span-6 font-['poppins']  ">
                                                <h1 class=" text-[#000] mx-2 ">
                                                    <span class=" mx-2 text-[#8B8B8B] ">{{
                                                        reviewer.reviewer_level }}</span>
                                                    {{
                                                        reviewer.reviewer_name }}
                                                </h1>
                                                <h1 class="text-[#000] mx-2 ">{{reviewer.reviewer_code}}
                                                </h1>
                                            </div>
                                            <div class="col-span-2 flex flex-col font-['poppins']">{{ reviewer.kpi_review ?  reviewer.kpi_review : '-'  }}</div>
                                            <div class="col-span-2  font-['poppins'] p-[20px]">{{ reviewer.kpi_percentage }}</div>
                                            <div class="col-span-2  font-['poppins']">{{ reviewer.kpi_comments }}</div>
                                        </div>
                                    </div>
                                </div>

                                </div>

                            </AccordionTab>
                        </Accordion>

                        <div class=" flex justify-center items-center my-4"
                            v-if="selectedRowdata.is_assignee_submitted != 1">
                            <button class=" border-[1px] border-[#000] font-['poppins'] mx-2 rounded-md p-2"
                                @click="useStore.createSelfKpiSidebar = false, useStore.canShowAssigneeReviewForm = false">Cancel</button>
                            <button class="bg-yellow-400 text-[white] font-['poppins']  mx-2 rounded-md px-3 py-2"
                                v-if="review_save == 'save'"
                                @click="useStore.saveAssigneeReviewForm(useStore.createKpiForm.form_details, null, currentlyRecords), review_save = 'Submit'">Save
                            </button>
                            <button class="bg-yellow-400 text-[white] font-['poppins']  mx-2 rounded-md px-3 py-2"
                                v-if="review_save == 'Submit'"
                                @click="useStore.saveAssigneeReviewForm(useStore.createKpiForm.form_details, 1, currentlyRecords), review_save = 'save'">Submit</button>
                        </div>
                        <div class=" flex justify-center items-center my-4"
                            v-if="selectedRowdata.is_reviewer_submitted == '' && selectedRowdata.is_assignee_submitted == 1">
                            <button class=" border-[1px] border-[#000] font-['poppins'] mx-2 rounded-md p-2"
                                @click="useStore.createSelfKpiSidebar = false, useStore.canShowAssigneeReviewForm = false">Cancel</button>
                            <button class="bg-yellow-400 text-[white] font-['poppins']  mx-2 rounded-md px-3 py-2"
                                @click="useStore.TeamAppraisalRevoke(currentlyRecords, 'self_review')">Revoke
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div v-if="useStore.createKpiForm.form_details">
                        <div class=" grid grid-cols-12 gap-4 py-3 px-4 my-2 bg-[#DDDD] rounded-md  h-[80px] font-['poppins'] "
                            v-if="useStore.selected_header && useStore.createKpiForm.form_details && useStore.createKpiForm.form_details.length > 0">
                            <div class="" v-for="(headerRecord, headerIndex) in useStore.selected_header"
                                :class="[0, 1].includes(headerIndex) ? ' col-span-3 flex items-center h-[40px] justify-center ' : [2, 4].includes(headerIndex) ? 'col-span-2 flex items-center justify-center h-[40px] flex-col ' : ' col-span-2 flex flex-col items-center h-[40px] justify-center '">
                                <h1 class="text-[13px] font-semibold text-center">
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
                                <span class="text-center font-semibold text-[10px] relative w-[200px] mt-[6px] "
                                    v-if="headerRecord ? headerRecord.header_name == 'kpi_weightage' : ''"
                                    :class="headerRecord ? headerRecord.header_name == 'kpi_weightage' ? TotalKpiWeightage > 100 ? ' text-red-500' : null : null : null">
                                    (
                                    OverAll - {{ calculateTotalKpiWeightage }} %)
                                    <span class=" absolute  right-[-140px] text-lg font-semibold top-[-20px]">Action</span>
                                </span>
                            </div>
                        </div>
                        <!-- view and Edit -->
                        <div class="rounded-lg bg-[#FFF7EB] grid grid-cols-12 gap-4 py-3 px-4 my-2"
                            v-for="(formDetails, index) in formatConverter(useStore.createKpiForm.form_details)"
                            @mouseleave="op = 'sd'">
                            <div class=" flex justify-center !line-clamp-4 "
                                v-for="(singleRecord, recordIndex) in  filterWantedField(formDetails, ['id', 'record_id'])"
                                :class="[0, 1].includes(recordIndex) ? '  col-span-3 ' : [2, 4].includes(recordIndex) ? 'col-span-2' : recordIndex == filterWantedField(formDetails, ['id', 'record_id']).length ? 'col-span-2' : 'col-span-1'">
                                <!-- {{ singleRecord }} -->
                                <div v-if="!isEditing(index)"
                                    class="text-[16px] text-[#000] font-['poppins'] max-w-xs  my-2 flex justify-center items-center"
                                    :class="readMoreTitle == singleRecord.title ? ' ' : ''">
                                    <p v-if="expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)"
                                        class=" !break-all">
                                        {{ singleRecord.value }}
                                        <button class=" text-blue-400 font-['poppins']"
                                            @click="canShowMoreContentIndex = '', canShowMoreContentRowIndex = ''"
                                            v-if="singleRecord.value.length > 100 && expandContent(recordIndex, index, singleRecord.value) && !isEditing(index)">less...</button>
                                    </p>
                                    <span v-tooltip="singleRecord.value" v-else
                                        class="font-['poppins']  !line-clamp-1   !break-all ">
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
                            <div class="flex items-center justify-end relative"
                                v-if="viewEditWithdraw == 'Creation' || viewEditWithdraw == 'Edit' || viewEditWithdraw == 'Reject Edit option'">
                                <i class="pi pi-file-edit mx-2 cursor-pointer "
                                    @click="selectedEditIndex = index, editsavepublish = 'save'"
                                    v-if="!isEditing(index)"></i>
                                <i class="pi pi-check  mx-2 cursor-pointer "
                                    @click="useStore.createKpiForm.form_details[index], selectedEditIndex = null, editsavepublish = 'save'"
                                    v-if="isEditing(index)"></i>
                                <i class="pi pi-trash text-[red] mx-2 cursor-pointer"
                                    @click="removeTodo(useStore.createKpiForm.form_details, index)"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-2 gap-2 mt-2 "
                            v-if="useStore.selected_header && viewEditWithdraw == 'Creation' ? (addMore ? true : false) : true || viewEditWithdraw == 'Edit' ? (addMore ? true : false) : true || viewEditWithdraw == 'View' ? (addMore ? true : false) : true">
                            <div class="flex flex-col" v-for="(header, i) in useStore.selected_header" :key="i">
                                <label for="" class="text-[12px] text-[#757575]  my-2">{{ header.alias_name ?
                                    header.alias_name : ['KPI - Weightage %'].includes(header.header_label) ?
                                        'KPI / OKR - Weightage % ' : header.header_label }}
                                </label>
                                <InputText v-if="['kpi_weightage'].includes(header.header_name)" type="text"
                                    v-model="useStore.addKra[header.header_name]"
                                    class=" h-10 !bg-[#f6f6f6] border-[1px] border-[#dddddd]  p-2"
                                    @keypress="isNumber($event)" @input="() => {
                                        if (useStore.addKra[header.header_name] > 100) {
                                            useStore.addKra[header.header_name] = null
                                        } else if (useStore.addKra[header.header_name] < 1) {
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
                            <!-- edit save  -->
                            <div class=" flex justify-start items-center relative top-[14px] ">
                                <button class=" bg-[#F9BE00] text-[#000] py-2 px-4 h-[33px] rounded-md "
                                    @click="submitForm(arr), editsavepublish = 'save'"> <i class="pi pi-check"></i>
                                </button>
                                <button v-if="useStore.createKpiForm.form_details.length > 0" @click="cancelPopup = true"
                                    class=" mx-2 bg-[#000] text-[white] py-2 px-4 h-[33px] rounded-md"> <i
                                        class="pi pi-times"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center my-[40px]"
                        v-if="viewEditWithdraw == 'Creation' || viewEditWithdraw == 'View' || viewEditWithdraw == 'Edit' || viewEditWithdraw == 'Reject Edit option'">
                        <button
                            class=" border-[1px] border-[#000]  p-3 box-border text-[13px] rounded-md text-[#000] !w-[120px] h-[33px] font-semibold flex justify-center items-center "
                            @click="addMore = true">
                            <i class="pi pi-plus" style="font-size: 1rem"></i>
                            <p>Add more</p>
                        </button>
                        <button
                            v-if="editsavepublish == 'save' || useStore.errormessage == 'failure' || viewEditWithdraw == 'Reject Edit option'"
                            @click="useStore.createKpiForm.form_name ? TotalKpiWeightage == 100
                                ? (calculateKpiWeightage(useStore.createKpiForm.form_details), editsavepublish = 'publish') : useHelper.toastmessage('error', 'The combined weightage of KPIs or OKRs must equal to 100%') : useHelper.toastmessage('error', 'Form Name field is required.')"
                            class="text-[#000]  py-2 px-4 rounded-md mx-2"
                            :class="[useStore.createKpiForm.form_details.length > 0 && TotalKpiWeightage == 100 ? 'bg-[#F9BE00]' : 'bg-[#dddd]']">Save</button>
                        <button v-if="editsavepublish == 'publish' && useStore.errormessage != 'failure'"
                            class="  rounded-[8px] w-[144px] !h-[33px] mx-2"
                            :class="[useStore.currentlySavedFormId ? 'bg-[#000] text-[#ffff]' : 'bg-[#DDDD] text-[#000]']"
                            @click="useStore.currentlySavedFormId ? useStore.createNewGoals ? viewEditWithdraw == 'Reject Edit option' ? (useStore.EditedpublishForm(current_user_code), visibleRight = false, useStore.createSelfKpiSidebar = false) : (useStore.publishForm(current_user_code), visibleRight = false, useStore.createSelfKpiSidebar = false) : '' : useHelper.toastmessage('error', 'Save the form to Publish')">
                            Publish</button>
                    </div>

                    <div class="flex justify-center mt-[100px]"
                        v-if="selectedRowdata ? useHelper.pmsKpiFormAcceptance([selectedRowdata]) : null">
                        <button class=" bg-[#F9BE00] text-[#000]  py-2 px-4 rounded-md mx-2"
                            @click="visibleRight=false,useStore.acceptRejectReviewForm({ user_id: selectedRowdata.assignee_id, record_id: selectedRowdata.id, status: 1, reviewer_comments: '' })">Accept</button>
                        <button class="text-[#fff]  py-2 px-4 rounded-md mx-2 bg-black"
                            @click="visibleRight=false,useStore.acceptRejectReviewForm({ user_id: selectedRowdata.assignee_id, record_id: selectedRowdata.id, status: -1, reviewer_comments: '' })">Reject</button>
                    </div>

                    <div class="flex justify-center my-[40px]" v-if="saveSelfAppraisal">
                        <button class=""
                            v-if="saveSelfAppraisal[0] ? saveSelfAppraisal[0].review_order == 1 && saveSelfAppraisal[0].is_accepted == 0 || saveSelfAppraisal[0].is_accepted == -1 : ''">
                        </button>
                        <button
                            v-if="saveSelfAppraisal[0] ? saveSelfAppraisal[0].review_order == 1 && saveSelfAppraisal[0].is_accepted == 0 || saveSelfAppraisal[0].is_accepted == -1 : ''"
                            class=" !h-[33px]  font-['poppins'] border-[1px] px-2 bg-[#F9BE00] rounded-md"
                            @click="withdraw()">Withdraw</button>
                        <button v-if="saveSelfAppraisal[0].is_accepted == -1"
                            class=" !h-[33px] font-['poppins']  border-[1px] bg-[#000] px-4  text-[#ffff] rounded-md mx-2 "
                            @click="hideObjectiveInput = false, viewEditWithdraw = 'Reject Edit option', useStore.getKPIFormDetails(selectedRowdata.kpi_form_details.form_id), useStore.currentlySavedFormId = selectedRowdata.kpi_form_details.form_id">Edit</button>
                    </div>
                </div>
            </div>
        </Sidebar>
        <!-- withdraw popup -->
        <Dialog v-model:visible="withdrawPopup" modal :style="{ width: '30rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            class="m-0 p-0 relative  shadow-md rounded-t-full  !z-[10000]">

            <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden  !z-[10000] ">

                <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#9DC284] flex justify-center items-center  "
                    :style="{ height: '9rem' }">
                    <i type='button' @click="withdrawPopup = false" class="pi pi-times text-white"
                        style="font-size: 3rem"></i>
                </div>
                <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border"
                    :style="{ height: '19rem' }">
                    <p class="text-center font-bold text-2xl pt-4 box-border">Withdraw</p>
                    <p class="text-center font-bold text-lg">Are you sure you want to withdraw the current KPI/OKR Form?</p>

                    <div class="flex justify-center items-center pt-6 gap-3">
                        <button type="button"
                            class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                            @click="submitWithdraw(), saveSelfAppraisal = '', visibleRight = false, useStore.createSelfKpiSidebar = false, canHiddenUploadOptions = true">Yes</button>
                        <button type="button"
                            class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            @click="withdrawPopup = false">Cancel</button>
                    </div>
                </div>
            </div>
        </Dialog>
        <!-- cancel popup -->
        <Dialog v-model:visible="cancelPopup" modal :style="{ width: '30rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            class="m-0 p-0 relative  shadow-md rounded-t-full !z-[10000]">
            <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden  !z-[10000]">
                <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#9DC284] flex justify-center items-center  "
                    :style="{ height: '9rem' }">
                    <i type='button' @click="cancelPopup = false" class="pi pi-times text-white"
                        style="font-size: 3rem"></i>
                </div>
                <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border   "
                    :style="{ height: '19rem' }">
                    <p class="text-center font-bold text-2xl pt-4 box-border">Delete</p>
                    <p class="text-center font-bold text-lg">Are you sure you want to delete the current KPI/OKR Data?</p>
                    <div class="flex justify-center items-center pt-6 gap-3">
                        <button type="button"
                            class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                            @click="addMore = false, cancelPopup = false">Yes</button>
                        <button type="button"
                            class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            @click="cancelPopup = false">Cancel</button>
                    </div>
                </div>
            </div>
        </Dialog>

        <!-- sidebar popup -->
        <Dialog v-model:visible="sidebarPopup" modal :style="{ width: '30rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            class="m-0 p-0 relative  shadow-md rounded-t-full  !z-[10000]">
            <div :style="{ height: '20rem' }" class="relative rounded-lg overflow-hidden  !z-[10000]">
                <div class="m-0 p-0 fixed rounded-t-lg top-0 w-[100%]  left-0 right-0  bg-[#9DC284] flex justify-center items-center  "
                    :style="{ height: '9rem' }">
                    <i type='button' @click="sidebarPopup = false" class="pi pi-times text-white"
                        style="font-size: 3rem"></i>
                </div>
                <div class=" flex flex-col justify-center items-center gap-2  m-5 pt-[20px] object-cover  absolute box-border   "
                    :style="{ height: '19rem' }">
                    <p class="text-center font-bold text-2xl pt-4 box-border">Close</p>
                    <p class="text-center font-bold text-lg">Are you sure you want to close this Sidebar?</p>
                    <div class="flex justify-center items-center pt-6 gap-3">
                        <button type="button"
                            class="text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 text-lg font-semibold rounded-md  px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"
                            @click="useStore.createSelfKpiSidebar = false, visibleRight = false, sidebarPopup = false">Yes</button>
                        <button type="button"
                            class="text-black bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200  rounded-md text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            @click="sidebarPopup = false">Cancel</button>
                    </div>
                </div>
            </div>
        </Dialog>
    </div>
</template>

<script setup>

import { ref, reactive, onMounted, computed, watch } from 'vue';
import { usePmsMainStore } from '../stores/pmsMainStore';
import { usePmsHelperStore } from '../stores/pmsHelperStore';
import { Service } from '../../Service/Service';
import loadingSpinner from '../../../components/LoadingSpinner.vue';
import { useToast } from 'primevue/usetoast';
import useValidate from '@vuelidate/core';
import { FilterMatchMode } from 'primevue/api';
import { required, email, minLength, helpers } from '@vuelidate/validators';
import dayjs from "dayjs";
import LoadingSpinner from '../../../components/LoadingSpinner.vue';

const toast = useToast();

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const viewEditWithdraw = ref('Creation');
const edit = ref();
const editsavepublish = ref('');
const edit_withdraw = (event) => {
    if (event) {
        edit.value = event;
    }
}

const useService = Service()
const useStore = usePmsMainStore()
const useHelper = usePmsHelperStore()
const currentlyRecords = ref();

const activeTab = ref(1);
const canShowPublishAfterSaved = ref(false);
const canHiddenUploadOptions = ref(true);
const visibleRight = ref(false);
const currentUserCode = ref()
const isFormSubmitted = ref(false);
const current_user_code = ref();
const selectedEditIndex = ref();
const hideObjectiveInput = ref(false)
const formSaved = ref(false);
const TotalKpiWeightage = ref(0);
const TotalAssigneeKpiWeightage = ref(0);
const withdrawPopup = ref(false);
const selectedRowdata = ref();
const addMore = ref(false);
const saveSelfAppraisal = ref();
const canShowMoreContent = ref(false)
const canShowMoreContentIndex = ref()
const canShowMoreContentRowIndex = ref()
const readMoreTitle = ref();
const cancelPopup = ref(false)
const sidebarPopup = ref(false);
const review_save = ref();

const products = ref();
const selectedProduct = ref();
const metaKey = ref(true);

const onRowSelect = (event) => {
    console.log(event.data.id, ' event.data.id');
    useStore.record_id = event.data.id;
    useStore.getSelfReviewDashboardDetails(currentUserCode.value);
    // toast.add({ severity: 'info', summary: 'Product Selected', detail: 'Name: ' + event.data.id, life: 3000 });
};
const onRowUnselect = (event) => {
    // toast.add({ severity: 'warn', summary: 'Product Unselected', detail: 'Name: ' + event.data.id, life: 3000 });
}



const op = ref();

function showWarn() {
    toast.add({ severity: 'error', summary: 'Select KPI form', life: 3000 });
};

onMounted(async () => {
    let user_code;
    await useService.getCurrentUserCode().then(res => {
        user_code = res.data;
        current_user_code.value = res.data;
        useStore.selectedAssigneeFormUsercode = res.data
        currentUserCode.value = res.data
        console.log(user_code);

    })
    const flow_type = 3

    await useStore.getAssignmentPeriodDropdown(user_code);
    await useStore.getSelfAppraisalDashboardDetails(user_code)
    await useStore.getPmsConfiguration(flow_type, user_code)
    await useStore.getKPIFormAsDropdown(user_code)
    await useStore.getSelfReviewDashboardDetails(user_code)




    // if(useStore.selectedyear){
    //     useStore.selectedyear.map((current_period,assignment_id)=>{
    //         if(current_period == 1)
    //         console.log(current_period, assignment_id);


    //     })
    // }


    useStore.User_code = user_code;
})


function withdraw() {
    withdrawPopup.value = true;
}

function submitWithdraw() {
    useStore.withdrawEmployeeAssignedForm(selectedRowdata.value);
    withdrawPopup.value = false;

}

function viewEditWithdrawForm(data, selectedRow) {
    selectedRowdata.value = selectedRow;
    saveSelfAppraisal.value = data;
    // console.log(saveSelfAppraisal.value);
    // console.log(selectedRow);

}

const findTimeline = computed(() => {
    let user_code = currentUserCode.value
    if (activeTab.value == 1) {
        console.log("active tab" + activeTab.value);
        const source = useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalPendingStatusSource(useStore.selfDashboardPublishedFormList, '', 1) : false
        console.log(source.length > 0);
        if (source.length > 0) {
            source.forEach(async (ele) => {
                console.log("Record" + ele.id);
                if (ele.id) {
                    await useStore.getSelfTimeLine(user_code, ele.id);
                    useStore.record_id = ele.id
                    await useStore.getSelfReviewDashboardDetails(user_code)
                }
            })
        }
        else {
            const completedForms = useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, 1) : []
            console.log("Record" + completedForms.length > 0 ? completedForms[0] : '');
            useStore.record_id = completedForms.length > 0 ? completedForms[0].id : ''
            useStore.getSelfTimeLine(user_code, useStore.record_id );
            useStore.getSelfReviewDashboardDetails(user_code)
        }
    } else
        if (activeTab.value == 2) {
            console.log("active tab" + activeTab.value);
            const source = useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, '') : false
            console.log(source.length > 0)
            if (source.length > 0) {
                source.forEach(async (ele) => {
                    console.log(ele.id);
                    if (ele.id) {
                        await useStore.getSelfTimeLine(user_code, ele.id);
                        useStore.record_id = ele.id
                        useStore.getSelfTimeLine(user_code, ele.id);
                        await useStore.getSelfReviewDashboardDetails(user_code)
                    }
                }
                )
            }
            else {
                const completedForms = useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalStatusWiseSource(useStore.selfDashboardPublishedFormList, 1, 1) : []
                console.log("Record:" + completedForms);
                useStore.record_id = completedForms.length > 0  ? completedForms[0].id : ''
                useStore.getSelfTimeLine(user_code,  useStore.record_id );
                useStore.getSelfReviewDashboardDetails(user_code)
            }

        }
})


const removeTodo = (myArray, key) => {
    const indexToDelete = key;
    if (indexToDelete >= 0 && indexToDelete < myArray.length) {
        myArray.splice(indexToDelete, 1); // Delete the element at the specified index
        console.log(`Deleted element at index ${indexToDelete}`);
    } else {
        console.log(`Invalid index: ${indexToDelete}`);
    }
};

const updateValue = (index, field, newValue) => {
    if (useStore.createKpiForm.form_details[index]) {
        useStore.createKpiForm.form_details[index][field] = newValue;
    } else {
        console.log('Index out of range or form_details is not an array.');
    }
};
const updateAssigneeForm = (index, field, newValue) => {
    if (useStore.createKpiForm.form_details[index]['assignee_review']) {
        useStore.createKpiForm.form_details[index]['assignee_review'][field] = newValue;
        // useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'] =   Math.round((parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_review) / parseInt(useStore.createKpiForm.form_details[index].target)) * parseInt(useStore.createKpiForm.form_details[index].kpi_weightage));

        let containsNumbers = /\d/.test(useStore.createKpiForm.form_details[index].assignee_review.kpi_review);

        if(useStore.createKpiForm.form_details[index].assignee_review.kpi_review == newValue){
            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'] =   Math.round((parseInt(useStore.createKpiForm.form_details[index].assignee_review.kpi_review) / parseInt(useStore.createKpiForm.form_details[index].target)) * parseInt(useStore.createKpiForm.form_details[index].kpi_weightage));

        }
        if (containsNumbers) {

            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_weightage'] =  useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue) ;

        } else {
            // useStore.createKpiForm.form_details[index]['assignee_review']['kpi_weightage'] = useHelper.calculateKpiWeightage(useStore.createKpiForm.form_details[index]['target'], newValue)

            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'] = 0;
        }
    } else {
        console.log('Index out of range or form_details is not an array.');
    }
};

const updateAssigneeFormNumberOrAlpha = (index, field, newValue) => {
    if (useStore.createKpiForm.form_details[index]['assignee_review']) {
        useStore.createKpiForm.form_details[index]['assignee_review'][field] = newValue;
        if (useStore.createKpiForm.form_details[index].target === useStore.createKpiForm.form_details[index].assignee_review.kpi_review) {
            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'] = useStore.createKpiForm.form_details[index].kpi_weightage;
        }
        else {
            useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'] = 0;
            console.log(useStore.createKpiForm.form_details[index]['assignee_review']['kpi_percentage'], 'else');
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
    if (data) {
        const transformedArray = data.map(obj => {
            return Object.entries(obj).map(([title, value]) => ({ title, value }));
        });
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
        console.log(transformedObject);
        if (compareHeaders(transformedObject, useStore.addKra)) {
            toast.add({ severity: 'warn', summary: 'Validation', detail: 'Fill missing fields', life: 3000 });

        } else {
            addMore.value = false
            useStore.addFormDetails(useStore.addKra);
            // calculateTotalKpiWeightage(useStore.createKpiForm.form_details)
            console.log('Form successfully submitted.');
            useStore.addKra = {};
            v$.value.$reset(); // Reset the validation object
        }

    } else {
        console.log('Form failed validation');
    }

}

// assignereviewer validation ...

const r$ = useValidate(rules, '')

const submit_assignee_reviewer = () => {

    // v$.value.$reset();
    r$.value.$validate(); // checks all inputs
    if (!r$.value.$error) {
        // if ANY fail validation

        const transformedObject = convertToNewObject(useStore.selected_header);
        console.log(transformedObject);
        if (compareHeaders(transformedObject, useStore.addKra)) {
            toast.add({ severity: 'warn', summary: 'Validation', detail: 'Fill missing fields', life: 3000 });

        } else {
            addMore.value = false
            useStore.addFormDetails(useStore.addKra);
            // calculateTotalKpiWeightage(useStore.createKpiForm.form_details)
            console.log('Form successfully submitted.');
            useStore.addKra = {};
            r$.value.$reset(); // Reset the validation object
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


const expandContent = (currentIndex, rowIndex, string) => {
    if (canShowMoreContentRowIndex.value == rowIndex) {
        if (canShowMoreContentIndex.value === currentIndex) {
            if (string.length > 5) {
                return true
            }
        }
    }
}


function convertToTitleCase(originalString) {
    if (originalString) {
        const convertedString = originalString
            .split('_')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
        return convertedString
    }
}

const calendarType = computed(() => {
    useStore.createNewGoals.calendar_type = convertToTitleCase(useStore.createNewGoals.calendar_type);
});

const frequency = computed(() => {
    useStore.createNewGoals.frequency = capitalizeFirstLetter(useStore.createNewGoals.frequency);
    // console.log(useStore.createNewGoals.frequency);
});

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
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


const calculateKpiWeightage = (arr) => {
    let kpiValue = 0;
    arr.forEach(ele => {
        const containsNumbers = /\d/.test(ele.kpi_weightage);
        if (containsNumbers) {
            TotalKpiWeightage.value = parseInt(ele.kpi_weightage);
        } else {
            // console.log('The value is not a number.');
        }

        if (ele.kpi_weightage !== undefined && !isNaN(parseInt(ele.kpi_weightage))) {
            kpiValue += parseInt(ele.kpi_weightage);
            TotalKpiWeightage.value = kpiValue;
            // console.log(TotalKpiWeightage.value);
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
                console.log(viewEditWithdraw.value === 'Reject Edit option' ? useStore.form_id : '', ' testing rejected form id ::');
                useStore.saveKpiForm(UserCode, viewEditWithdraw.value === 'Edit' || viewEditWithdraw.value === 'Reject Edit option' ? useStore.form_id : '');

            }
}

// let count = 1;
const calculateTotalKpiWeightage = computed(() => {
    let arr = useStore.createKpiForm.form_details
    // count++
    // console.log("function count:" + count);
    let calculatedKpiWeightage = 0
    console.log(arr);
    arr.forEach(ele => {
        const containsNumbers = /\d/.test(ele.kpi_weightage);
        if (containsNumbers) {
            // console.log(parseInt(ele.kpi_weightage));
            // console.log('The value is a number.');
            TotalKpiWeightage.value = parseInt(ele.kpi_weightage);
        } else {
            // console.log('The value is not a number.');
        }

        if (ele.kpi_weightage !== undefined && !isNaN(parseInt(ele.kpi_weightage))) {
            calculatedKpiWeightage += parseInt(ele.kpi_weightage);
            TotalKpiWeightage.value = calculatedKpiWeightage;
            // console.log(TotalKpiWeightage.value);
        }
    });
    return TotalKpiWeightage.value
})


const filterWantedField = (originalArray, excludeArray) => {
    const filteredArray = originalArray.filter(item => !excludeArray.includes(item.title));
    return filteredArray
}

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



const reviewTotalKpiWeightage = computed(() => {
    let calculatedKpiWeightage = 0
    let arr = useStore.createKpiForm.form_details;
    arr.forEach(ele => {
        const containsNumbers = /\d/.test(ele.assignee_review.kpi_percentage);
        if (containsNumbers) {
            calculatedKpiWeightage += parseInt(ele.assignee_review.kpi_percentage);
            // console.log('calculateKpiWeightage' + calculatedKpiWeightage);
            TotalAssigneeKpiWeightage.value = calculatedKpiWeightage

        } else
            if (ele.assignee_review.kpi_percentage !== undefined && !isNaN(parseInt(ele.assignee_review.kpi_percentage))) {
                calculatedKpiWeightage += parseInt(ele.assignee_review.kpi_percentage);
                TotalAssigneeKpiWeightage.value = calculatedKpiWeightage
                // console.log(TotalAssigneeKpiWeightage.value);
            }
            else {
                // console.log('The value is not a number.');
            }
    });
    return TotalAssigneeKpiWeightage.value

})
</script>

<style >
.p-accordion-header-link
{
    background-color: #FFF7EB !important;
    /* height: 84px !important; */
}

.p-accordion-content
{
    height: 160px !important;
    /* border:1px solid Black !important; */

}

/* .p-progressbar-value{
    background-color: #FFC000 !important;
}

 .p-progressbar-value-animate{

} */
.progressbar .p-progressbar-value .p-progressbar-value-animate
{
    background-color: #FFC000 !important;
}

.progressbar_val2 .p-progressbar-value-animate
{
    background-color: orange !important;
    color: black !important;
}

.swal2-container
{
    z-index: 10000 !important;
}

/*
.p-dropdown-label .p-inputtext .p-placeholder
{

    margin-top: -5px !important;
} */

/* .p-dropdown .p-dropdown-label .p-placeholder
{
    color: #6c757d;
    margin-top: -5px !important;
} */
.p-dropdown-label,
.p-inputtext,
.p-placeholder
{
    margin-top: -5px !important;
}

.p-dialog-mask .p-component-overlay
{
    z-index: 10000 !important;
}
</style>
