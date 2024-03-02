import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import * as XLSX from 'xlsx';
import { useRouter, useRoute } from "vue-router";
import dayjs from "dayjs";
import { usePmsHelperStore } from "./pmsHelperStore";


export const usePmsMainStore = defineStore("usePmsMainStore", () => {


    // Global declaration
    const useService = Service();
    const client_id = ref('');
    const toast = useToast()
    const useHelper = usePmsHelperStore()
    const canShowLoading = ref(true)
    const pmsConfiguration = ref()
    const selfDashboardPublishedFormList = ref()
    const selfReviewDashboardSource = ref()
    const teamDashboardPublishedFormList = ref()
    const selfAppraisalDashboard = ref()
    const department = ref()
    const departmentOptions = ref();
    const existingKpiFormOptions = ref()
    const kpiFormHeaders = ref()
    const EmployeeOptions = ref()
    const authorDetails = ref()
    const reviewerDetails = ref()
    const generalDetails = ref()
    const currentUserId = ref()
    const canShowAssigneeReviewForm = ref(false)
    const selectedAssigneeFormUsercode = ref();
    const selected_header = ref();
    const record_id = ref();
    const form_id = ref();
    const currentlySavedFormId = ref();
    const errormessage = ref();
    const DashboardCardDetails_TeamAppraisal = ref();
    const addGoalStatus = ref();
    const assignment_setting_id = ref();
    const createSelfKpiSidebar = ref(false)
    const createTeamKpiForm = ref(false)
    const selectedyear = ref();
    const form_header = ref();
    const btn_download = ref(false);

    // assignment setting date
   const assignment_setting_date = ref();


    const orgAppraisalDatatableDetails= ref();
    const assignform_id = ref()

    // selected form

    const currentlyselectedform = ref();

    const selectedHeadersForSampleExcel = ref([]);
    const SelfTimeLine = ref();
    const User_code = ref();

    const activetab = ref();

    const swal = inject("$swal");


    const reset = () =>{
        pmsConfiguration.value = [];
        selected_header.value = [];
        departmentOptions.value  = [];
        EmployeeOptions.value  = [];
    }

    const getPmsConfiguration = async (flow_type, user_code) => {
        reset()
        canShowLoading.value = true
        await axios.post(`${window.location.origin}/api/pms/populateNewGoalsAssignScreenUI`, {
            flow_type: flow_type,
            user_code: user_code
        }).then(res => {
            pmsConfiguration.value = res.data.data ? res.data.data.pms_config : []
            selected_header.value = res.data.data ? res.data.data.pms_config.selected_header : []
            departmentOptions.value = res.data.data ? res.data.data.department : []
            EmployeeOptions.value = res.data.data ? res.data.data.employee_details : [];
            console.log(departmentOptions.value,EmployeeOptions.value);

            addGoalStatus.value = res.data.data.add_btn_status;

            if (flow_type == 3) {
                department.value = res.data.data ? res.data.data.department_id[0].id : 0
                createNewGoals.value.department = res.data.data.department_id[0].id ? res.data.data.department_id[0].id : 0
                generalDetails.value = res.data.data ? {
                    employee_name: res.data.data.employee_details['name'], manager_name: res.data.data.manager_details['name'],
                    assignee_id: res.data.data.employee_details['id'], reviewer_id: res.data.data.manager_details['id'], flow_type: 3
                } : ''
            } else
                if (flow_type == 2) {
                    generalDetails.value = res.data.data ? {
                        manager_name: res.data.data.manager_details['name'], reviewer_id: res.data.data.manager_details['id'], flow_type: 2
                    } : ''
                }
                else
                if (flow_type == 1) {
                    generalDetails.value = res.data.data ? {
                        manager_name: res.data.data.manager_details['name'], reviewer_id: res.data.data.manager_details['id'], flow_type: 2
                    } : ''
                }

            // console.log("asd", res.data.data.department_id[0].id, createNewGoals.value.department);
        }).finally(() => {
            if (flow_type == 3) {
                createNewGoals.value = {
                    ...pmsConfiguration.value,
                    ...generalDetails.value,
                    department_id: department.value
                }
            } else
                if (flow_type == 2) {
                    createNewTeamGoals.value = {
                        ...pmsConfiguration.value,
                        ...generalDetails.value,
                        // department_id: department.value
                    }
                }
                else
                if (flow_type == 1) {
                    createNewTeamGoals.value = {
                        ...pmsConfiguration.value,
                        ...generalDetails.value,
                        // department_id: department.value
                    }
                }
            canShowLoading.value = false
        })
    }



    const getSelfTimeLine = async (author_id, assigned_form_id) => {

        assignform_id.value = assigned_form_id

        // console.log(record_id.value,'record_id.value');
        await axios.post(`${window.location.origin}/api/pms/getAssignedTimelineDetails`, {
            user_code: author_id,
            assigned_form_id: assigned_form_id ? assigned_form_id : record_id.value
        }).then((res) => {
            SelfTimeLine.value = res.data;

        })
    }

    const withdrawEmployeeAssignedForm = (data) => {
        let user_code = useService.current_user_code;
        // console.log(user_code,'user_code');
        axios.post(`${window.location.origin}/api/pms/withdrawEmployeeAssignedForm`, {
            record_id: data.id,
        }).then((res) => {
            getPmsConfiguration(3, user_code);
            getSelfAppraisalDashboardDetails(user_code);
            getSelfReviewDashboardDetails(user_code);

        })
    }


    const getSelfReviewDashboardDetails = async (author_id) => {
        // console.log(assignment_setting_id.value);
        await axios.post(`${window.location.origin}/api/pms/getDashboardCardDetails_SelfAppraisal`, {
            user_code: author_id,
            assignment_setting_id: assignment_setting_id.value,
            assinged_record_id: record_id.value
        }).then(res => {
            selfReviewDashboardSource.value = res.data.data;
        }).finally(() => {
            canShowLoading.value = false
        })
    }

    async function getSelfAppraisalDashboardDetails(author_id) {

        canShowLoading.value = true
        // console.log("user code from self" + author_id);

        await axios.post(`${window.location.origin}/api/pms/getSelfAppraisalFormDetails`, {
            user_code: author_id,
            date:assignment_setting_date.value
        }).then(res => {
            // if(res.data.status)

            selfDashboardPublishedFormList.value = res.data.data;
            record_id.value = res.data ? res.data.data.length > 0 ? res.data.data[0].id : '' : ''
            // console.log( res.data.data.length > 0 ? res.data.data[0].id : '' ,'askhdkjhsadk');
            getSelfTimeLine(useService.current_user_code, record_id.value);
        }).finally(() => {
            canShowLoading.value = false;

        })
    }


    const getTeamAppraisalDashboardDetails = async (author_id) => {
        canShowLoading.value = true
        // console.log("useer code from śelf" + author_id);
        await axios.post(`${window.location.origin}/api/pms/TeamAppraisalReviewerFlow`, {
            user_code: author_id,
            date:assignment_setting_date.value
        }).then(res => {
            teamDashboardPublishedFormList.value = res.data.data;
        }).finally(() => {
            canShowLoading.value = false;

        })
    }

    const teamKpiFormApproval = async (record_id, status, reviewer_comments) => {
        await axios.post(`${window.location.origin}/api/pms/ApproveOrReject`, {
            user_code: useService.current_user_code,
            record_id: record_id,
            status: status,
            reviewer_comments: reviewer_comments,
        }).then(res => {
            teamDashboardPublishedFormList.value = res.data.data;
            Swal.fire({
                title: res.data.status,
                text: res.data.message,
                icon: res.data.status == "success" ? "success" : "warning",
            }).then(() => {

            })

        }).finally(() => {
            getTeamAppraisalDashboardDetails(useService.current_user_code);
        })
    }

    const getKPIFormAsDropdown = async (user_code) => {
        await axios.post(`${window.location.origin}/api/pms/getKPIFormsList`, {
            user_code: user_code
        }).then(res => {
            existingKpiFormOptions.value = res.data.data;

        }).finally(() => {

        })
    }

    const createNewGoals = ref({})
    const createNewTeamGoals = ref({})
    const createKpiForm = ref({
        user_code: null,
        form_details: [],
    })
    const addKra = ref({})

    const addFormDetails = (data) => {
        // console.log(data);
        createKpiForm.value.form_details.push(data)
        addKra.value = {}
    }

    const downloadSampleForm = async (author_id) => {
        // console.log(author_id)
        try {
            // Make an Axios request to get the Excel file
            const response = await axios.post(`${window.location.origin}/api/pms/SampleKpiFormExcellV3`, {
                user_code: author_id
            }, {
                responseType: 'arraybuffer' // Important for handling binary data
            });

            // Create a Blob from the response data
            const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = `OKR FORM ${useService.current_user_code} ${useService.current_user_name} ${dayjs(new Date()).format('MMM YYYY')}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } catch (error) {
            console.error('Error downloading Excel file:', error);
        }
    };

    // saveKpiFormDetails
    const saveKpiForm = (user_code, form_id) => {
        // console.log(currentlySavedFormId.value, 'form_id');
        createKpiForm.value.user_code = user_code;
        createKpiForm.value.form_id = currentlySavedFormId.value;
        axios.post(`${window.location.origin}/api/pms/saveOrUpdateKpiFormDetails`, createKpiForm.value).then((res) => {
            // form_id.value = res.data.data;
            // console.log(res.data.data);
            currentlySavedFormId.value = res.data ? res.data.message == 'failure' ? '' : res.data.data : '';

            // console.log( currentlySavedFormId.value ,' currentlySavedFormId.value');

            // record_id.value  = res.data.data;
            if (res.data.status == 'success') {
                errormessage.value = 'success'
                useHelper.toastmessage('success', res.data.message);
            }
            else {
                errormessage.value = 'failure'
                useHelper.toastmessage('error', res.data.message);
            }

            // Swal.fire({
            //     title: res.data.status == "success" ? res.data.status = "success" : (canShowAssigneeReviewForm.value = false, res.data.status = "failure"),
            //     text: res.data.message,
            //     icon: res.data.status == "success" ? "success" : "failure",
            // }).then(() => {
            // })
        }).finally(() => {
            getKPIFormAsDropdown(createKpiForm.value.user_code);
        })
    }
    const updateFormRowDetails = (record_id, formDetails) => {
        let format = {
            record_id: record_id,
            json_formrow_details: { ...formDetails }
        }

        axios.post(`${window.location.origin}/api/pms/updateFormRowDetails`, format).catch(error => {
            // console.log(error);
        })
        // console.log(format);
    }

    const getKPIFormDetails = (form_id) => {
        axios.post(`${window.location.origin}/api/pms/getSelectedKPIForm`, {
            form_id: form_id
        }).then(res => {
            createKpiForm.value.form_name = res.data.form_name
            createKpiForm.value.form_details = res.data.form_data
        })
    }

    const assigneeReviewForm = ref({
        assignee_user_code: null,
        record_id: null,
        assignee_review: [],
        assignee_is_submitted: 0,

    })
    const fillAssigneeReviewForm = (id, record_id, target, total_value) => {
        if (target) {
            // console.log(record_id);
            assigneeReviewForm.value.record_id = record_id
            assigneeReviewForm.value.assignee_user_code = selectedAssigneeFormUsercode.value
            let format = {
                id: id,
                target: parseInt(target),
                kpi_weightage: useHelper.calculateKpiWeightage(total_value, target),
                comments: ''
            }
            useHelper.pushToArray(assigneeReviewForm.value.assignee_review, id, format)
        }
    }

    const saveAssigneeReviewForm = async (data, assignee_is_submitted, id) => {
        let user_code = useService.current_user_code;
        console.log(data);
        let assigneeReview = data;
        let array_assignee_reviews = assigneeReview.map(({ assignee_review, id }) => ({ form_details_id: id, kpi_review: assignee_review.kpi_review, kpi_percentage: assignee_review.kpi_percentage, kpi_comments: assignee_review.kpi_comments }));
        let format = {
            assignee_user_code: useService.current_user_code,
            assigned_form_id: id,
            assignee_reviews: array_assignee_reviews,
            assignee_is_submitted: assignee_is_submitted,
        }

        // assigneeReviewForm.value.assignee_is_submitted = 1
        if (assignee_is_submitted == 1) {
            const allObjectsHaveNotNullKeys = useHelper.doAllObjectsHaveNotNullKeys(array_assignee_reviews);
            // console.log(allObjectsHaveNotNullKeys);
            if (allObjectsHaveNotNullKeys) {
                canShowLoading.value = true
                await axios.post(`${window.location.origin}/api/pms/saveAssigneeReview`, format)
                    .then((res) => {
                        if (assignee_is_submitted == null) {
                            useHelper.toastmessage(res.data.status, res.data.message);
                        }
                        else {
                            canShowLoading.value = false
                            createSelfKpiSidebar.value = false
                            Swal.fire({
                                title: res.data.status,
                                text: res.data.message,
                                icon: res.data.status == "success" ? "success" : "warning",
                            }).then(() => {

                            })
                        }
                        // console.log(res.data);
                        getSelfTimeLine(user_code);
                        getSelfReviewDashboardDetails(user_code);
                        getSelfAppraisalDashboardDetails(user_code);
                    })
                    .catch((error) => {
                        // console.log("Error while saving Assignee review details : "+error.toJSON());
                    }).finally(() => {
                        // getSelfAppraisalDashboardDetails(user_code);
                        // getSelfTimeLine(user_code);
                    });
            } else {
                toast.add({ severity: 'warn', summary: 'Validation', detail: 'Fill missing fields', life: 3000 });
            }
        } else {
            await axios.post(`${window.location.origin}/api/pms/saveAssigneeReview`, format)
                .then((res) => {
                    if (assignee_is_submitted == null) {
                        useHelper.toastmessage(res.data.status, res.data.message);
                    }
                    else {

                        Swal.fire({
                            title: res.data.status,
                            text: res.data.message,
                            icon: res.data.status == "success" ? "success" : "warning",
                        }).then(() => {

                        })
                    }
                    // console.log(res.data);
                    getSelfTimeLine(user_code);
                    getSelfReviewDashboardDetails(user_code);
                    getSelfAppraisalDashboardDetails(user_code);
                })
                .catch((error) => {
                    // console.log("Error while saving Assignee review details : "+error.toJSON());
                }).finally(() => {

                    // getSelfAppraisalDashboardDetails(user_code);
                    // getSelfTimeLine(user_code);
                });
        }

    }

    const acceptRejectReviewForm = async (data) => {
        // console.log(data);
        if (data) {
            await axios.post(`${window.location.origin}/api/pms/AcceptOrReject`, data).then((res)=>{

                Swal.fire({
                    title: res.data.status,
                    text: res.data.message,
                    icon: res.data.status == "success" ? "success" : "warning",
                }).then(() => {

                })

            })
        }else{
            useHelper.toastmessage('error','data not found');
        }
    }



    async function publishForm(data) {
        let user_code = data;
   canShowLoading.value = true
        createNewGoals.value.kpi_form_id = currentlySavedFormId.value ? currentlySavedFormId.value : createNewGoals.value.kpi_form_id;
        // console.log(createNewGoals.value.kpi_form_id);
        await axios.post(`${window.location.origin}/api/pms/publishKpiform`, createNewGoals.value).then((res) => {
            canShowLoading.value = false
            Swal.fire({
                title: res.data.status == "success" ? "Success" : "Failure",
                text: res.data.status == "success" ? `Your team's OKR/KPI form has been successfully published for the period of ${dayjs(new Date()).format('MMMM')}. Wishing your team all the best as you take action to achieve this goal!` : res.data.message,
                // "Salary Advance Succesfully",
                icon: res.data.status == "success" ? "success" : "warning",
            }).then(() => {

            })
        }).finally(() => {
            getSelfAppraisalDashboardDetails(user_code);
            getSelfReviewDashboardDetails(user_code);
            // getSelfTimeLine(user_code);
            getPmsConfiguration(3, user_code);
        })
    }

    async function EditedpublishForm(data) {
        let user_code = data;

        createNewGoals.value.kpi_form_id = currentlySavedFormId.value ? currentlySavedFormId.value : createNewGoals.value.kpi_form_id;
        // console.log(createNewGoals.value.kpi_form_id);
        await axios.post(`${window.location.origin}/api/pms/selfAppraisalEditedFormPublish`, {
            assigned_record_id: record_id.value
        }).then((res) => {

            Swal.fire({
                title: res.data.status == "success" ? "Success" : "Failure",
                text: res.data.status == "success" ? `Your team's OKR/KPI form has been successfully published for the period of ${dayjs(new Date()).format('MMMM')}. Wishing your team all the best as you take action to achieve this goal!` : res.data.message,
                // "Salary Advance Succesfully",
                icon: res.data.status == "success" ? "success" : "warning",
            }).then(() => {

            })
        }).finally(() => {
            getSelfAppraisalDashboardDetails(user_code);
            getSelfReviewDashboardDetails(user_code);
            // getSelfTimeLine(user_code);
        })
    }


    const publishTeamForm = async (data,flow_type) => {
        let user_code = data;
        // console.log(employeefilter(),'employeefilter()');
        createNewTeamGoals.value.assignee_id = employeefilter(createNewTeamGoals.value.assignee_id);

        // console.log( createNewTeamGoals.value.assignee_id,' createNewTeamGoals.assignee_id');


        // console.log(createNewTeamGoals.value.assignee_id,'createNewTeamGoals.value.assignee_id');
        createNewTeamGoals.value.kpi_form_id = currentlySavedFormId.value ? currentlySavedFormId.value : createNewTeamGoals.value.kpi_form_id;
        // console.log(createNewTeamGoals.value.kpi_form_id);
        createNewTeamGoals.value.flow_type = flow_type;

        await axios.post(`${window.location.origin}/api/pms/publishKpiform`, createNewTeamGoals.value).then((res) => {
            // canShowAssigneeReviewForm
            // (canShowAssigneeReviewForm.value = false,"Failure")
            Swal.fire({
                title: res.data.status == "success" ? "Success" : "Failure",
                text: res.data.status == "success" ? `Your team's OKR/KPI form has been successfully published for the period of ${dayjs(new Date()).format('MMMM')}. Wishing your team all the best as you take action to achieve this goal!` : res.data.message,
                // "Salary Advance Succesfully",
                icon: res.data.status == "success" ? "success" : "warning",
            }).then(() => {
                // window.location.reload();
            })
        }).finally(() => {
            // getSelfTimeLine(user_code);
        })
    }

    function employeefilter(data){
        // console.log(data);
        if(data){
            return  data.filter((ele)=> { return ele.form_assigned == 0})
        }
        // console.log(data.map(({form_assigned})=> {form_assigned == 0}));
        // return  data.filter((ele)=> { return ele.form_assigned == 0})
        // console.log( data.filter((ele)=> { return ele.form_assigned == 0}) ,'filter');
        // createNewTeamGoals.value.assignee_id  =  data.filter(({form_assigned})=> {form_assigned == 0})
    }

    function deleteFormRowDetails(val) {
        // console.log(val);
        axios.post(`${window.location.origin}/api/pms/deleteFormRowDetails`, {
            record_id: val
        }).then((res) => {
        })
    }

    async function TeamAppraisalRevoke(record_id,type) {
        // console.log(record_id);
        let user_code = useService.current_user_code;

        await axios.post(`${window.location.origin}/api/pms/managerRevokeApprovedOrRejectedAssignedForm`, {
            assigned_form_id: record_id,
            type:type
        }).then((res) => {
            // console.log(record_id);
            createSelfKpiSidebar.value = false
            toast.add({ severity: `${res.data.status}` , summary: 'Revoke', detail:`${res.data.message}` , life: 3000 });

        }).finally(() => {
            getTeamAppraisalDashboardDetails(user_code);
            getSelfReviewDashboardDetails(user_code);
            getSelfAppraisalDashboardDetails(user_code);
            getSelfTimeLine(user_code);
        })

    }

    const saveTeamAppraisalReview = async (data, reviewer_is_submitted) => {
        const reviewerDetails = data
        // console.log(reviewerDetails);
        let array_reviewer_reviews = reviewerDetails.map(({ id, reviews_review }) => ({ form_details_id: id, kpi_review: reviews_review[0].kpi_review, kpi_percentage: reviews_review[0].kpi_percentage, kpi_comments: reviews_review[0].kpi_comments }));
        const user_code = useService.current_user_code
        let format = {
            reviewer_user_code: user_code,
            assigned_form_id: record_id.value,
            reviewer_review: array_reviewer_reviews,
            reviewer_is_submitted: reviewer_is_submitted,
        }

        if (reviewer_is_submitted == 1) {
            const allObjectsHaveNotNullKeys = useHelper.doAllObjectsHaveNotNullKeys(array_reviewer_reviews);
            // console.log(allObjectsHaveNotNullKeys);
            if (allObjectsHaveNotNullKeys) {
                canShowLoading.value = true
                await axios.post(`${window.location.origin}/api/pms/saveReviewsReview`, format).then((res) => {
                    if (reviewer_is_submitted == 0) {
                        useHelper.toastmessage(res.data.status, res.data.message);
                    }
                    else {
                        canShowLoading.value = false
                        createTeamKpiForm.value = false
                        Swal.fire({
                            title: res.data.status,
                            text: res.data.message,
                            icon: res.data.status == "success" ? "success" : "warning",
                        }).then(() => {

                        })
                    }
                    // console.log(record_id);
                }).finally(() => {
                    getTeamAppraisalDashboardDetails(user_code);
                })

            } else {
                toast.add({ severity: 'warn', summary: 'Validation', detail: 'Fill missing fields', life: 3000 });
            }
        } else {
            await axios.post(`${window.location.origin}/api/pms/saveReviewsReview`, format).then((res) => {
                if (reviewer_is_submitted == 0) {
                    useHelper.toastmessage(res.data.status, res.data.message);
                }
                else {
                    Swal.fire({
                        title: res.data.status,
                        text: res.data.message,
                        icon: res.data.status == "success" ? "success" : "warning",
                    })
                }
            }).finally(() => {
                getTeamAppraisalDashboardDetails(user_code);
            })

        }
    }

    const getDashboardCardDetails_TeamAppraisal = async (user_code,type) => {

        await axios.post(`${window.location.origin}/api/pms/getDashboardCardDetails_TeamAppraisal`, {
            user_code: user_code,
            type:type
        }).then((res) => {
            // console.log(res.data);
            DashboardCardDetails_TeamAppraisal.value = res.data;
        })

    }

    const getAssignmentPeriodDropdown = async (user_code) => {
        let client_id = '';
        await axios.get(` ${window.location.origin}/session-sessionselectedclient`).then((res)=>{
            client_id = res.data.id;
        })

        // console.log(client_id,'client_id');

        await axios.post(`${window.location.origin}/api/pms/getAssignmentPeriodDropdown`, {
            user_code: user_code,
            client_id:client_id
        }).then((res) => {
            selectedyear.value = res.data;

            res.data.map(({ current_period, assignment_id , assignment_period }) => {
                if (current_period == 1) {
                    assignment_setting_id.value = assignment_id;

                    // console.log(current_period,);
                    // console.log(assignment_id);
                    assignment_setting_date.value = assignment_period;
                }
            })
        })
    }

    const selecteddropdownyear = (val) => {
        // console.log(val, 'val');
        assignment_setting_id.value = val;
        if (val) {
            getSelfAppraisalDashboardDetails(useService.current_user_code);
            getSelfReviewDashboardDetails(useService.current_user_code);
            getTeamAppraisalDashboardDetails(useService.current_user_code);
            orgAppraisalFlow();
        }

    }

    const selectedrowdata = (val) => {
        console.log(val);
    }


    // org flow ..

    const  orgAppraisalFlow = async () => {
        await axios.post(`${window.location.origin}/api/pms/orgAppraisalFlow`, {
            date:   assignment_setting_date.value
        }).then((res) => {
            orgAppraisalDatatableDetails.value =  res.data;
            // console.log(res.data);
            // DashboardCardDetails_TeamAppraisal.value = res.data;
        })
    }

    const downloadFormPMSReport = () => {

        let format = {
            assinged_formid :assignform_id.value ? assignform_id.value : record_id.value
        }

    canShowLoading.value = true;

    let url = `${window.location.origin}/api/pms/pmsFormExcellExport` ;
    axios.post(url,format,{ responseType: 'blob' }).then((response) => {
        // console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        // ${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}
        link.download = `PMS Form Report_.xlsx`;
        link.click();
    }).finally(() => {
        btn_download.value = false;
        canShowLoading.value = false;
    })
}







    return {

        // Loading
        canShowLoading,client_id,
        assignment_setting_id,

        selectedrowdata,

        // Pms Configuration
        User_code,
        record_id,
        form_id,
        currentlySavedFormId,

        // select dropdown
        selectedyear,

        // add goals status btn status

        addGoalStatus,

        //  currently selected form name..

        currentlyselectedform,

        pmsConfiguration, getPmsConfiguration,

        // General Variables

        departmentOptions, EmployeeOptions, existingKpiFormOptions, getKPIFormAsDropdown, selfDashboardPublishedFormList,

        // Self Appraisal Dashboard Details

        createSelfKpiSidebar, getSelfAppraisalDashboardDetails, assigneeReviewForm, acceptRejectReviewForm, selfReviewDashboardSource, getSelfReviewDashboardDetails,

        getSelfTimeLine, SelfTimeLine, updateFormRowDetails, deleteFormRowDetails,

        // KPI Form creation

        createKpiForm, addKra, addFormDetails, saveKpiForm, getKPIFormDetails, fillAssigneeReviewForm, canShowAssigneeReviewForm,
        saveAssigneeReviewForm, selectedAssigneeFormUsercode, kpiFormHeaders, selected_header, downloadSampleForm,

        // New Goals Creation

        createNewGoals, publishForm,

        // Team Dashboard

        // Goal Creation

        createTeamKpiForm, createNewTeamGoals, publishTeamForm, EditedpublishForm, saveTeamAppraisalReview,

        getTeamAppraisalDashboardDetails, teamDashboardPublishedFormList, teamKpiFormApproval,

        withdrawEmployeeAssignedForm,
        TeamAppraisalRevoke,

        errormessage,

        getDashboardCardDetails_TeamAppraisal,
        DashboardCardDetails_TeamAppraisal,

        getAssignmentPeriodDropdown,
        selecteddropdownyear,
        employeefilter,

        // org Appraisal Flow

        orgAppraisalFlow,
        orgAppraisalDatatableDetails,
        activetab,


        form_header,
        downloadFormPMSReport,
        btn_download,
        assignment_setting_date,

        reset



    }
})
