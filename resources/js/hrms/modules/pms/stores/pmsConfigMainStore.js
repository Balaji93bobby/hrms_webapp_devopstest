import { defineStore } from "pinia";
import { Service } from "../../Service/Service";
import { useToast } from "primevue/usetoast";
import { computed, ref } from "vue";
import axios from "axios";
import { inject } from "vue";

export const usePmsConfigStore = defineStore("usePmsConfigStore", () => {

    const toast = useToast()
    const useService = Service()
    const swal = inject("$swal");
    const currentlySelectedClient = ref();
    const assignment_period_list = ref();
    const pmsConfig = ref({
        client_id:useService.current_client_id,
        client_code: null,
        assignment_id: null,
        pms_calendar_settings: {
            calendar_type: null,
            year: new Date().getFullYear(),
            cal_type_full_year: null,
            frequency: null,
            assignment_period: null,
        },
        pms_basic_settings: {
            can_assign_upcoming_goals: null, //auto, manual
            annual_score_cal_method: null, //sum, average
            can_emp_proceed_nextpms_wo_currpms_completion: null,
            can_org_proceed_nextpms_wo_currpms_completion: null,
        },
        pms_dashboard_page: {
            can_show_overall_score_in_selfappr_dashboard: null,
            can_show_rating_card_in_review_page: null,
            can_show_overall_scr_card_in_review_page: null,
        },
        remainder_alert: {
            //For employee
            can_alert_emp_bfr_duedate: {
                active: null,
                notif_count: null,
                notif_mode: []
            },
            can_alert_emp_for_overduedate: {
                active: null,
                notif_count: null, notif_mode: []
            },
            //For Managers
            can_alert_mgr_bfr_duedate: {
                active: null,
                notif_count: null, notif_mode: []
            },
            can_alert_mgr_for_overduedate: {
                active: null,
                notif_count: null, notif_mode: []
            },
        },
        pms_metrics: [],
        goal_settings: {
            who_can_set_goal: [],
            final_kpi_score_based_on: "HR", //L1 / L2 / L3 / HR
            should_mgr_appr_rej_goals: null, //0 or 1
            should_emp_acp_rej_goals: null,//0 or 1


            duedate_goal_initiate: null,
            duedate_approval_acceptance: null,
            duedate_self_review: null,
            duedate_mgr_review: null,
            duedate_hr_review: null,

            reviewers_flow: [],
        }
        ,
        score_card:[]
    });

    const pmsDefaultHeaders = ref();
    const pmsRatingCards = ref();
    const getAssignmentPeriod = ref();
    const canFreezeCalendarSetting = ref();

    const filteredReviewerFlow = ref()
    const roleTypes = ref([
        { role_type: "L1 Manager", role_shortname: "L1", is_selected: 0 },
        { role_type: "L2 Manager", role_shortname: "L2", is_selected: 0 },
        { role_type: "L3 Manager", role_shortname: "L3", is_selected: 0 },
        { role_type: "HR", role_shortname: "HR", is_selected: 0 },
    ])

    const whoCanSetRoleTypes = ref([
        { role_type: "Employee", role_shortname: "EMP", is_selected: 0 },
        { role_type: "L1 Manager", role_shortname: "L1", is_selected: 0 },
        { role_type: "L2 Manager", role_shortname: "L2", is_selected: 0 },
        { role_type: "L3 Manager", role_shortname: "L3", is_selected: 0 },
        { role_type: "HR", role_shortname: "HR", is_selected: 0 },
    ])

    /*
        Fetches the PMS config
    */
    async function getPmsConfigSettings() {
        //Fetch the details.
        console.log(useService.current_client_code,'useService.current_client_code');
        await axios.post(`${window.location.origin}/api/pms/getPmsConfigSettings`, {
            client_code:useService.current_client_code
            // client_code: useService.client_code
        }).then(res => {
           pmsConfig.value.score_card = res.data.pms_default_ratings[0].config_value ;
        }).finally(() => {

        })
    }

    const savePMSConfiguration = () => {

        axios.post(`${window.location.origin}/api/pms/savePmsConfigSetting`, pmsConfig.value).then((res) => {
            Swal.fire({
                title: res.data.status,
                text: res.data.message,
                icon: res.data.status == "success" ? "success" : "warning",
            })
        })
    }

    const enabledReviewerFlow = ref({})
    const reviewerFlowSelection = ref({})
    let selectedList = []
    const reviewerFlowSetter = (flow, isReviewSelected) => {
        if (flow == 1) {
            if (selectedList.includes(reviewerFlowSelection.value.flow1)) {
                reviewerFlowSelection.value.flow1 = null
                console.log("flow 1 ");
                toast.add({ severity: 'warn', summary: 'Already selected', detail: 'Message Content', life: 3000 })
            } else {
                // console.log(pmsConfig.value.goal_settings.reviewers_flow);
                let format = { order: 1, reviewer_level: reviewerFlowSelection.value.flow1 ? reviewerFlowSelection.value.flow1 : '', is_review_mandatory: enabledReviewerFlow.value.flow1 ? enabledReviewerFlow.value.flow1 : 0 }
                if (pmsConfig.value.goal_settings.reviewers_flow[0]) {
                    if (pmsConfig.value.goal_settings.reviewers_flow[0].reviewer_level != reviewerFlowSelection.value.flow1) {
                        pmsConfig.value.goal_settings.reviewers_flow[0] = format
                        selectedList[0] = reviewerFlowSelection.value.flow1
                    }
                }
                else {
                    pmsConfig.value.goal_settings.reviewers_flow.push(format)
                    selectedList.push(reviewerFlowSelection.value.flow1)
                }
            }
        } else
            if (flow == 2) {
                if (selectedList.includes(reviewerFlowSelection.value.flow2)) {
                    reviewerFlowSelection.value.flow2 = null
                    console.log("flow 2 ");
                    toast.add({ severity: 'warn', summary: 'Already selected', detail: 'Message Content', life: 3000 })

                } else {
                    let format = { order: 2, reviewer_level: reviewerFlowSelection.value.flow2 ? reviewerFlowSelection.value.flow2 : '', is_review_mandatory: enabledReviewerFlow.value.flow2 ? enabledReviewerFlow.value.flow2 : '' }
                    if (pmsConfig.value.goal_settings.reviewers_flow[1]) {
                        if (pmsConfig.value.goal_settings.reviewers_flow[1].reviewer_level != reviewerFlowSelection.value.flow2) {
                            pmsConfig.value.goal_settings.reviewers_flow[1] = format
                            selectedList[1] = reviewerFlowSelection.value.flow2
                        }
                    }
                    else {
                        pmsConfig.value.goal_settings.reviewers_flow.push(format)
                        selectedList.push(reviewerFlowSelection.value.flow2)
                    }
                }
            } else
                if (flow == 3) {
                    if (pmsConfig.value.goal_settings.reviewers_flow.includes(reviewerFlowSelection.value.flow3)) {
                        reviewerFlowSelection.value.flow3 = null
                        console.log("flow 3 ");
                        toast.add({ severity: 'warn', summary: 'Already selected', detail: 'Message Content', life: 3000 })

                    } else {
                        let format = { order: 3, reviewer_level: reviewerFlowSelection.value.flow3 ? reviewerFlowSelection.value.flow3 : '', is_review_mandatory: enabledReviewerFlow.value.flow3 ? enabledReviewerFlow.value.flow3 : '' }
                        if (pmsConfig.value.goal_settings.reviewers_flow[2]) {
                            if (pmsConfig.value.goal_settings.reviewers_flow[2].reviewer_level != reviewerFlowSelection.value.flow3) {
                                pmsConfig.value.goal_settings.reviewers_flow[2] = format
                                selectedList[2] = reviewerFlowSelection.value.flow3
                            }
                        }
                        else {
                            pmsConfig.value.goal_settings.reviewers_flow.push(format)
                            selectedList.push(reviewerFlowSelection.value.flow3)
                        }
                    }
                } else
                    if (flow == 4) {
                        if (pmsConfig.value.goal_settings.reviewers_flow.includes(reviewerFlowSelection.value.flow4)) {
                            reviewerFlowSelection.value.flow4 = null
                            console.log("flow 4 ");
                            toast.add({ severity: 'warn', summary: 'Already selected', detail: 'Message Content', life: 3000 })

                        } else {
                            let format = { order: 4, reviewer_level: reviewerFlowSelection.value.flow4 ? reviewerFlowSelection.value.flow4 : '', is_review_mandatory: enabledReviewerFlow.value.flow4 ? enabledReviewerFlow.value.flow4 : '' }
                            if (pmsConfig.value.goal_settings.reviewers_flow[3]) {
                                if (pmsConfig.value.goal_settings.reviewers_flow[3].reviewer_level != reviewerFlowSelection.value.flow4) {
                                    pmsConfig.value.goal_settings.reviewers_flow[3] = format
                                    selectedList[3] = reviewerFlowSelection.value.flow4
                                }
                            }
                            else {
                                pmsConfig.value.goal_settings.reviewers_flow.push(format)
                                selectedList.push(reviewerFlowSelection.value.flow4)
                            }
                        }
                    }
                    else {
                        console.log("Flow not matched");
                    }
        if (isReviewSelected == 1) {
            let format = { order: 1, reviewer_level: reviewerFlowSelection.value.flow1 ? reviewerFlowSelection.value.flow1 : '', is_review_mandatory: enabledReviewerFlow.value.flow1 ? enabledReviewerFlow.value.flow1 : 0 }
            if (pmsConfig.value.goal_settings.reviewers_flow[0]) {
                if (pmsConfig.value.goal_settings.reviewers_flow[0].is_review_mandatory != enabledReviewerFlow.value.flow1) {
                    pmsConfig.value.goal_settings.reviewers_flow[0] = format
                }
            }
            else {
                pmsConfig.value.goal_settings.reviewers_flow.push(format)
            }
        } else
            if (isReviewSelected == 2) {
                let format = { order: 2, reviewer_level: reviewerFlowSelection.value.flow2 ? reviewerFlowSelection.value.flow2 : '', is_review_mandatory: enabledReviewerFlow.value.flow2 ? enabledReviewerFlow.value.flow2 : 0 }
                if (pmsConfig.value.goal_settings.reviewers_flow[1]) {
                    if (pmsConfig.value.goal_settings.reviewers_flow[1].reviewer_level != reviewerFlowSelection.value.flow2) {
                        pmsConfig.value.goal_settings.reviewers_flow[1] = format
                    }
                }
                else {
                    pmsConfig.value.goal_settings.reviewers_flow.push(format)
                }
            } else
                if (isReviewSelected == 3) {
                    let format = { order: 3, reviewer_level: reviewerFlowSelection.value.flow3 ? reviewerFlowSelection.value.flow3 : '', is_review_mandatory: enabledReviewerFlow.value.flow3 ? enabledReviewerFlow.value.flow3 : 0 }
                    if (pmsConfig.value.goal_settings.reviewers_flow[2]) {
                        if (pmsConfig.value.goal_settings.reviewers_flow[2].reviewer_level != reviewerFlowSelection.value.flow3) {
                            pmsConfig.value.goal_settings.reviewers_flow[2] = format
                        }
                    }
                    else {
                        pmsConfig.value.goal_settings.reviewers_flow.push(format)
                    }
                } else
                    if (isReviewSelected == 4) {
                        let format = { order: 4, reviewer_level: reviewerFlowSelection.value.flow4 ? reviewerFlowSelection.value.flow4 : '', is_review_mandatory: enabledReviewerFlow.value.flow4 ? enabledReviewerFlow.value.flow4 : 0 }
                        if (pmsConfig.value.goal_settings.reviewers_flow[3]) {
                            if (pmsConfig.value.goal_settings.reviewers_flow[3].reviewer_level != reviewerFlowSelection.value.flow4) {
                                pmsConfig.value.goal_settings.reviewers_flow[3] = format
                            }
                        }
                        else {
                            pmsConfig.value.goal_settings.reviewers_flow.push(format)
                        }
                    }
        // console.log(pmsConfig.value.goal_settings.reviewers_flow);
    };

    async function getSessionClient() {
        await axios.get(` ${window.location.origin}/session-sessionselectedclient`).then(res => {
            pmsConfig.value.client_id = res.data.id;
            pmsConfig.value.client_code = res.data.client_code;
        });
    }


    async function getPmsSettings() {
        let format = {
            client_code: useService.current_client_code,
            year: new Date().getFullYear(),
            assignment_period: ""
        }
        await axios.post(` ${window.location.origin}/api/pms/getAllAssignmentSettings`, format).then(res => {
            pmsDefaultHeaders.value = res.data.data ?  res.data.pms_default_form_headers ? res.data.pms_default_form_headers.config_value : '' : '' ;
            getAssignmentPeriod.value = res.data.data ? res.data.data.assignment_period_list : '';
            pmsConfig.value.pms_calendar_settings.year = res.data.data ? res.data.data.year : '';
            pmsConfig.value.pms_calendar_settings.calendar_type = res.data.data ? res.data.data.calendar_type : '';
            pmsConfig.value.pms_calendar_settings.frequency = res.data.data ? res.data.data.frequency : '';
            canFreezeCalendarSetting.value = res.data.data ? res.data.data.can_freeze_calender_sett : 0;
            console.log(canFreezeCalendarSetting.value, 'res.data.can_freeze_calender_sett')
            pmsConfig.value.pms_calendar_settings.year = new Date().getFullYear()
            // console.log(filterCurrentAssignmentPeriod(res.data.data) ? filterCurrentAssignmentPeriod(res.data.data)[0].assignment_period_id : "no assignment period");
            format.assignment_period = res.data.data ? filterCurrentAssignmentPeriod(res.data.data.assignment_period_list) ? filterCurrentAssignmentPeriod(res.data.data.assignment_period_list)[0].assignment_period_id : "" : '';
            pmsConfig.value.pms_calendar_settings.assignment_period = res.data.data ? filterCurrentAssignmentPeriod(res.data.data.assignment_period_list) ? filterCurrentAssignmentPeriod(res.data.data.assignment_period_list)[0].assignment_period_id : "" : '';

            console.log(format.assignment_period ,'format.assignment_period ::: ');
        });


        await axios.post(` ${window.location.origin}/api/pms/getPMSSetting_forGivenAssignmentPeriod`, format).then(res => {
            if (format.assignment_period) {
                pmsConfig.value.goal_settings.reviewers_flow.splice(0, pmsConfig.value.goal_settings.reviewers_flow.length)
                pmsConfig.value = res.data;
                if (res.data.can_freeze_calender_sett != 0) {
                    res.data.goal_settings.reviewers_flow.forEach((ele, i) => {
                        reviewerFlowSelection.value[`flow${i + 1}`] = ele.reviewer_level
                    })
                }
                // pmsConfig.value.pms_calendar_settings.current_year = new Date().getFullYear()
                pmsConfig.value.pms_calendar_settings.assignment_period = filterCurrentAssignmentPeriod(getAssignmentPeriod.value) ? filterCurrentAssignmentPeriod(getAssignmentPeriod.value)[0].assignment_period_id : "";
                pmsConfig.value['assignment_id'] = filterCurrentAssignmentPeriod(getAssignmentPeriod.value) ? filterCurrentAssignmentPeriod(getAssignmentPeriod.value)[0].assignment_period_id : "";

                // pmsConfig.value.pms_calendar_settings.current_year =  res.data.data ? res.data.data.year : '';
                pmsDefaultHeaders.value = res.data.existings_metrics
                // canFreezeCalendarSetting.value =  res.data.can_freeze_calender_sett
                getSessionClient()

            } else {
                pmsDefaultHeaders.value = res.data.pms_default_form_headers[0].config_value;
                pmsRatingCards.value = res.data.pms_default_ratings[0].config_value;
                pmsConfig.value.score_card = res.data.pms_default_ratings[0].config_value
                // canFreezeCalendarSetting.value =  res.data.can_freeze_calender_sett
            }
        });
    }

    const getPMSSetting_forGivenAssignmentPeriod = async (data) => {
        let format = {
            client_code: pmsConfig.value.client_code,
            year: new Date().getFullYear(),
            assignment_period: data ? data : ''
        }

        await axios.post(` ${window.location.origin}/api/pms/getPMSSetting_forGivenAssignmentPeriod`, format).then(res => {
            if (format.assignment_period) {
                pmsConfig.value.goal_settings.reviewers_flow.splice(0, pmsConfig.value.goal_settings.reviewers_flow.length)
                pmsConfig.value = res.data;
                if (res.data.can_freeze_calender_sett != 0) {
                    res.data.goal_settings.reviewers_flow.forEach((ele, i) => {
                        reviewerFlowSelection.value[`flow${i + 1}`] = ele.reviewer_level
                    })
                }
                // pmsConfig.value.pms_calendar_settings.current_year = new Date().getFullYear()
                // pmsConfig.value.pms_calendar_settings.assignment_period = filterCurrentAssignmentPeriod(getAssignmentPeriod.value) ? filterCurrentAssignmentPeriod(getAssignmentPeriod.value)[0].assignment_period_id : "";
                pmsConfig.value.pms_calendar_settings.assignment_period = res.data.pms_calendar_settings.assignment_period;
                pmsConfig.value.pms_calendar_settings.cal_type_full_year = res.data ? res.data.pms_calendar_settings.year : '';
                // pmsConfig.value.pms_calendar_settings.current_year =  res.data.data ? res.data.data.year : '';
                pmsDefaultHeaders.value = res.data.existings_metrics
                // canFreezeCalendarSetting.value =  res.data.can_freeze_calender_sett
                getSessionClient()

            } else {
                pmsDefaultHeaders.value = res.data.pms_default_form_headers[0].config_value;
                pmsRatingCards.value = res.data.pms_default_ratings[0].config_value;
                pmsConfig.value.score_card = res.data.pms_default_ratings[0].config_value
                // canFreezeCalendarSetting.value =  res.data.can_freeze_calender_sett
            }
        });



    }

    const filterCurrentAssignmentPeriod = (data) => {
        // console.log(data);
        if (data) {
            // const currentMonthRecord = data.filter(ele => {
            //     const currentMonth = new Date().getMonth() + 1
            //     const startDateMonth = parseInt(ele.start_date.split('-')[1], 10);
            //     const endDateMonth = parseInt(ele.end_Date.split('-')[1], 10);
            //     return startDateMonth === currentMonth;
            // })

            const currentMonthRecord = data.filter(ele => {
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth() + 1;
                const currentDay = currentDate.getDate();

                const startDateMonth = parseInt(ele.start_date.split('-')[1], 10);
                const startDateDay = parseInt(ele.start_date.split('-')[0], 10);

                const endDateMonth = parseInt(ele.end_date.split('-')[1], 10);
                const endDateDay = parseInt(ele.end_date.split('-')[0], 10);

                // Check if the current date is within the start and end dates
                return (
                    (startDateMonth < currentMonth || (startDateMonth === currentMonth && startDateDay <= currentDay)) &&
                    (endDateMonth > currentMonth || (endDateMonth === currentMonth && endDateDay >= currentDay))
                );
            });

            // console.log(currentMonthRecord)
            return currentMonthRecord
        }
    }

    return {

        // Variable declaration
        pmsConfig,

        // Axios function
        getPmsConfigSettings,
        savePMSConfiguration,
        getSessionClient,
        currentlySelectedClient,

        // Pms Metrics
        pmsDefaultHeaders,

        // pms rating cards
        pmsRatingCards,

        // Remainder Alert

        // Reviewer flow
        reviewerFlowSelection,
        enabledReviewerFlow,
        reviewerFlowSetter,
        filteredReviewerFlow,


        // Goal settings

        roleTypes,
        whoCanSetRoleTypes,
        canFreezeCalendarSetting,

        // config settings
        getPmsSettings,
        getAssignmentPeriod,
        assignment_period_list,
        getPMSSetting_forGivenAssignmentPeriod

    }
})
