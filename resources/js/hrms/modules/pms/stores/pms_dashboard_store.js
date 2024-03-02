import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import * as XLSX from 'xlsx';
import { useRouter, useRoute } from "vue-router";
import dayjs from "dayjs";
import * as ExcelJS from 'exceljs'
import { usePmsMainStore } from "./pmsMainStore";



export const use_pms_dashboard_store = defineStore("use_pms_dashboard_store", () => {

    // Global declaration

    const useStore = usePmsMainStore();
    const service = Service();

    const client_id =  ref();

    const Performance_rating_details = ref();
    const Dashboard_selfReviews_score_details = ref();
    const pmsDashboardReviewerScore_details = ref();
    const pmsSelfReviewOnTime_details = ref();
    const pmsReviewerReviewOnTimeDetails = ref();
    const DashboardQuaterlyScoreCardDetails = ref();
    const currentlySelectedTrendListAssignmentId = ref()
    const trendListSource = ref();
    const trendListOptions = ref();
    const Dashboardprocessdetails = ref();
    const loading = ref(true);

    const activetab = ref('');

    const selectedtrendList = ref();

    const PerformanceRatingGraph = async (user_code,status) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/PerformanceRatingGraph`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            Performance_rating_details.value = res.data;
            console.log(Performance_rating_details.value.label);
        }).finally(() => {
            loading.value = false;
        })
    }

    const pmsDashboardSelfReviewsScore = async (user_code,status) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardSelfReviewsScore`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            console.log(res.data);
            Dashboard_selfReviews_score_details.value = res.data;
        }).finally(() => {
            loading.value = false;
        })
    }
    const pmsDashboardReviewerScore = async (user_code,status) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardReviewerScore`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            console.log(res.data);
            pmsDashboardReviewerScore_details.value = res.data;
        }).finally(() => {
            loading.value = false;
        })
    }

    const pmsSelfReviewOnTime = async (user_code) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/pmsSelfReviewOnTime`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id
        }).then((res) => {
            console.log(res.data);
            pmsSelfReviewOnTime_details.value = res.data;
        }).finally(() => {
            loading.value = false;
        })

    }
    const pmsReviewerReviewOnTime = async (user_code) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/pmsReviewerReviewOnTime`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id
        }).then((res) => {
            console.log(res.data);
            pmsReviewerReviewOnTimeDetails.value = res.data;
        }).finally(() => {
            loading.value = false;
        })

    }

    const pmsDashboardQuaterlyScoreCard = async (user_code,status) => {
        loading.value = true;
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardQuaterlyScoreCard`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            // console.log(res.data);
            DashboardQuaterlyScoreCardDetails.value = res.data;
            console.log(DashboardQuaterlyScoreCardDetails.value, 'DashboardQuaterlyScoreCardDetails');
        }).finally(() => {
            loading.value = false;
        })
    }

    const Dashboardprocess = async (user_code,status) => {
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardprocess`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            Dashboardprocessdetails.value = res.data
        })
    }

    const selecteddropdownyear = (val,status) => {
        console.log(val, 'val');
        pmsSelfReviewOnTime_details.value = '';
        pmsReviewerReviewOnTimeDetails.value = '';
        Performance_rating_details.value = '';
        DashboardQuaterlyScoreCardDetails.value = '';
        Dashboardprocessdetails.value = '';
        useStore.assignment_setting_id = val;
        let user_code = service.current_user_code;
        if (val) {
            pmsDashboardSelfReviewsScore(user_code,status);
            PerformanceRatingGraph(user_code,status);
            pmsDashboardReviewerScore(user_code,status);
            pmsSelfReviewOnTime(user_code);
            pmsDashboardQuaterlyScoreCard(user_code,status);
            pmsReviewerReviewOnTime(user_code);
            Dashboardprocess(user_code,status);
        }
    }



    const getPmsTrendListOptions = async (user_code,status) => {
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardsTendListAssingement_Period`, {
            user_code: user_code,
            assignment_setting_id: useStore.assignment_setting_id,
            status:status
        }).then((res) => {
            trendListOptions.value = res.data;
            console.log(trendListOptions.value,'trendListOptions ::');
            // res.data.map(({ assignment_period, assignment_id }) => {
            //     if (dayjs(new Date).format('MMMM') === assignment_period) {
            //         console.log(assignment_id, 'assignment_id ::');
            //     }
            // })

            res.data.map(({ assignment_id,start_date ,end_date }) => {
                if (start_date < dayjs(new Date()).format('YYYY-MM-DD') && end_date >  dayjs(new Date()).format('YYYY-MM-DD')  ) {
                    console.log(assignment_id,":::");
                    selectedtrendList.value =  assignment_id ;
                }
            })
        })
    }

    const getPmsTrendList = async (user_code, id) => {
        await axios.post(`${window.location.origin}/api/pms/pmsDashboardsTendList`, {
            user_code: user_code,
            assignment_id: id ? id : filterCurrentAssignmentPeriod(trendListOptions.value) ? filterCurrentAssignmentPeriod(trendListOptions.value)[0].assignment_id : ''
        }).then((res) => {
            trendListSource.value = res.data.data
        })
    }


    const filterCurrentAssignmentPeriod = (data) => {
        // console.log(data);
        if (data) {

            const currentMonthRecord = data.filter(ele => {
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth() + 1;
                const currentDay = currentDate.getDate();

                const startDateMonth = new Date(ele.start_date).getMonth() + 1
                const startDateDay = new Date(ele.start_date).getDay()
                const endDateMonth = new Date(ele.end_date).getMonth() + 1
                const endDateDay = new Date(ele.end_date).getDay()

                // console.log(currentMonth,currentDay,startDateDay,startDateMonth,endDateMonth,endDateDay);


                // Check if the current date is within the start and end dates
                return (
                    currentMonth === startDateMonth
                );
            });

            console.log(currentMonthRecord)
            return currentMonthRecord
        }
    }

    function rest_val(){
        Performance_rating_details.value = '';
        trendListOptions.value = '';
        pmsSelfReviewOnTime_details.value = '';
        pmsReviewerReviewOnTimeDetails.value = '';
        Performance_rating_details.value = '';
        DashboardQuaterlyScoreCardDetails.value = '';
        Dashboardprocessdetails.value = '';
    }


    return {
        Performance_rating_details,
        Dashboard_selfReviews_score_details,
        pmsDashboardReviewerScore_details,
        pmsSelfReviewOnTime_details,
        pmsReviewerReviewOnTimeDetails,
        DashboardQuaterlyScoreCardDetails,
        pmsDashboardQuaterlyScoreCard,
        Dashboardprocessdetails,
        getPmsTrendList,
        getPmsTrendListOptions,

        // functions

        PerformanceRatingGraph,
        pmsDashboardSelfReviewsScore,
        pmsDashboardReviewerScore,
        pmsSelfReviewOnTime,
        pmsReviewerReviewOnTime,
        Dashboardprocess,
        loading,
        selecteddropdownyear,

        // Trend list
        trendListSource,
        trendListOptions,
        currentlySelectedTrendListAssignmentId,
        rest_val,
        selectedtrendList,
        activetab,
        client_id
        // getPmsTrendListForSelectedMonth



    }
})
