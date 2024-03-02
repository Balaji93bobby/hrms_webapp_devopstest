import { defineStore } from "pinia";
import axios from "axios";
import { Service } from "../../Service/Service";
import { ref } from "vue";
import { data } from "autoprefixer";

export const useMainDashboardStore = defineStore("mainDashboardStore", () => {
    const service = Service();

    // Varaible Declarations

    const open = ref(false)
    const canShowTopbar = ref(false)
    const canShowClients = ref(false)
    const canShowOrganization = ref(false)
    const canShowConfiguration = ref(false)
    const canShowCurrentEmployee = ref(false)

    const ShowEmployeeStatuswise = ref({})
    const reportName = ref()
    const canShowSidebar = ref(false)

    const currentDashboard = ref(0)

    const allEventSource = ref()
    const allNotificationSource = ref([])
    const leaveBalancePerMonthSource = ref([])
    const attenanceReportPerMonth = ref([])
    const canShowLoading = ref(true)

    const isDashboardDataReceived  = ref(true)
    const isHrDashboardDataReceived  = ref(true)


    // Subscribe Main DashBoard Data Source
    // const getMainDashboardSource = (async () => {

    //     let dashboardUrl = '/getAllNewDashboardDetails'
    //     await axios.get(dashboardUrl).then(res => {
    //             console.log(element);
    //             allEventSource.value = element.all_events.original.data.birthday
    //             allNotificationSource.value = element.all_notification.original.data.array_notifications
    //             leaveBalancePerMonthSource.value = element.leave_balance_per_month.original.data
    //             attenanceReportPerMonth.value = element.attenance_report_permonth.original.data
    //         });

    //     })

    // })

    async function getMainDashboardData(month, year) {
        canShowLoading.value = true
        await axios.get('/getAllNewDashboardDetails').then((response) => {
            allEventSource.value = response.data.all_events;
            // allNotificationSource.value = response.data.all_notification.array_notifications;
            leaveBalancePerMonthSource.value = response.data.leave_balance_per_month;
            attenanceReportPerMonth.value = response.data.attenance_report_permonth;

        }).finally(() => {
            canShowLoading.value = false
            isDashboardDataReceived.value = false
        });
    }

    async function getHRDashboardData() {

    }

    async function getAttendanceStatus(user_code, date) {
        await axios.get('/getAttendanceStatus', {
            user_code: 'PLIPL068',
            date: '2023-06-26',
        }).then((response) => {
            // console.log("getAttendanceStatus() : " + response.data);
        }).finally(() => {

        });
    }

    /* Employee Welcome Card
        Employee Check in and out time
    */

    const getCurrentlyLoginUser = () => {
        return axios.get("/currentUserName");
    };

    const updateCheckin_out = (data) => {
        return axios.post("/performAttendanceCheckIn", data);
    };



    // async function getMainDashboardData() {
    //     if (!currentUserCode.value) {
    //         await axios.get("/currentUserCode").then((res) => {
    //             currentUserCode.value = res.data;
    //             //  console.log("Current User Code : " + currentUserCode.value);
    //         });
    //     }

    //     // console.log("Getting maindashboard data for USERCODE : " + service.current_user_code);

    //     await axios
    //         .post("/get-maindashboard-data", {
    //             user_code: currentUserCode,
    //         })
    //         .then((res) => {

    //             if (res.data.status == "success") {
    //                 mainDashboardData.value = res.data.data;
    //             } else if (res.data.status == "failure") {
    //                 console.log(res.data.message);

    //             }

    //         })
    //         .catch((err) => {
    //             console.log("Error :: getMainDashboardData() : " + err);
    //         });
    // }

    //    Leave Details

    const fetch_leave_history = () => {
        return axios.get(
            "http://localhost:8000/fetch-leaverequests/employee/Approved,Rejected,Pending,Revoked,Withdrawn%20"
        );
    };


    const hrDashboardSource = ref()

    const orgEmployeeDetailCount = ref()
    const hrPendingRequestCount = ref()
    const overallEmployeeCount = ref()
    const overallEmployeeCountForGraph = ref([])



    const getHrDashboardMainSource = async() => {
        canShowLoading.value = true
        await axios.get('/get-employees_count-detail').then(res => {
            // console.log(res.data.pending_request_count);
            orgEmployeeDetailCount.value = res.data.employee_details_count
            // hrPendingRequestCount.value.push(res.data.pending_request_count)
            let obj = Object.entries(res.data.pending_request_count).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            hrPendingRequestCount.value = obj
            let graph = Object.entries(res.data.graph_chart_count).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            overallEmployeeCount.value = graph

            overallEmployeeCount.value.forEach(element => {
                overallEmployeeCountForGraph.value.push(element.value)
            });

        }).finally(() => {
            canShowLoading.value = false
            isHrDashboardDataReceived.value = false

        })
    }

    return {
        // varaible Declarations
        service, canShowLoading, open,isDashboardDataReceived,isHrDashboardDataReceived,
        canShowClients, canShowConfiguration, canShowCurrentEmployee, canShowOrganization, canShowTopbar,

        // Welcome Card
        getCurrentlyLoginUser,
        getAttendanceStatus,
        //getMainDashboardData,
        getMainDashboardData,
        updateCheckin_out,
        fetch_leave_history,

        // All Events
        allEventSource,

        // Leave Balance Per Month
        leaveBalancePerMonthSource,

        // Notification

        allNotificationSource,

        // Attendance report Per Month

        attenanceReportPerMonth,
        currentDashboard,

        // hr Dashboard source

        getHrDashboardMainSource, hrDashboardSource, orgEmployeeDetailCount, hrPendingRequestCount, overallEmployeeCount, overallEmployeeCountForGraph,

        ShowEmployeeStatuswise,canShowSidebar,reportName

    };
});
