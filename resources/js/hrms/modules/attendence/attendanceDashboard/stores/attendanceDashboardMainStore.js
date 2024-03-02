import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import dayjs from 'dayjs';

export const useAttendanceDashboardMainStore = defineStore("useAttendanceDashboardMainStore", () => {

    // Variable Declaration

    const canShowLoading = ref(false);

    const attendanceDashboardMainSource = ref()
    const attendanceOverview = ref()
    const attendanceDashboardWorkShiftSource = ref()
    const canShowShiftDetails = ref(false)
    const canShowAttendanceOverview = ref(false)
    const selectedAttendanceOverviewReport = ref()
    const currentlySelectedShiftDetails = ref([])
    const currentlySelectedShiftName = ref()
    const attendanceDashboardUpcoming = ref()
    const downloadShiftDetails = ref([])
    const downloadAttendanceOverviewDetails = ref([])
    const overallEmployeeCountForExceptionAnalytics = ref()
    const overallEmployeeCountForExceptionAnalyticsForGraph = ref([])
    const totalEmployeeInOrganization = ref()
    const AttendanceAnalytics = ref()
    const AttendanceAnalyticsForGraph = ref([]);
    const departments = ref();

    const chartDetails = ref([
        { label: 'Absent', backgroundColor: '#FFB1B8', count: null },
        { label: 'Present', backgroundColor: '#7A5EA2', count: null },
        { label: 'Leave', backgroundColor: '#8D98B5', count: null },
        { label: 'Late coming', backgroundColor: '#D9AA63', count: null },
        { label: 'Early going', backgroundColor: '#6BB7C0', count: null },
        { label: 'Missed out punch', backgroundColor: '#000000', count: null },
        { label: 'Missed in punch', backgroundColor: '#000000', count: null },
    ]);

    function GetDepartment(){
        axios.get('/fetch-departments').then((res)=>{

            departments.value = res.data;
            console.log(res.data);
        }).finally(()=>{
        })
    }

    function send_selectedDepartment(val,date){
        // dayjs(date ? date : new Date()).format('MMMM-DD-YYYY')
        canShowLoading.value = true
        axios.post('/get-attendance-dashboard',{
            department_id:val,
            date:date ? date : new Date()
        }).then((res)=>{

            attendanceOverview.value = res.data.attendance_overview

            totalEmployeeInOrganization.value = res.data.total_Employees
            console.log(" totalEmployeeInOrganization.value" + totalEmployeeInOrganization.value);
            chartDetails.value[0].count = parseInt(attendanceOverview.value['absent_count'])
            chartDetails.value[1].count = parseInt(attendanceOverview.value['present_count'])
            chartDetails.value[2].count = parseInt(attendanceOverview.value['leave_emp_count'])
            chartDetails.value[3].count = parseInt(attendanceOverview.value['lc_count'])
            chartDetails.value[4].count = parseInt(attendanceOverview.value['eg_count'])
            chartDetails.value[5].count = parseInt(attendanceOverview.value['mop_count'])
            chartDetails.value[6].count = parseInt(attendanceOverview.value['mip_count'])


            attendanceDashboardWorkShiftSource.value = res.data.work_shift
            // attendanceDashboardUpcoming.value = res.data.upcomings
            let obj = Object.entries(res.data.upcomings).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            attendanceDashboardUpcoming.value = obj

            let graph = Object.entries(res.data.attendance_overview).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            overallEmployeeCountForExceptionAnalytics.value = graph

            let desiredHeaders = ["absent_count", "present_count", "leave_emp_count", "lc_count", "eg_count", "mop_count", "mip_count"]

            overallEmployeeCountForExceptionAnalytics.value.forEach(async element => {
                if (overallEmployeeCountForExceptionAnalyticsForGraph.value.length < 7) {
                    if (desiredHeaders.includes(element.title)) {
                         overallEmployeeCountForExceptionAnalyticsForGraph.value.push(element.value)
                    }

                }
            });

            AttendanceAnalytics.value = res.data.CheckInMode


            AttendanceAnalytics.value.forEach(async element => {
                if (AttendanceAnalyticsForGraph.value.length < 3) {
                    AttendanceAnalyticsForGraph.value.push(element.value)
                }
            });

        }).finally(()=>{

            canShowLoading.value = false;
        //  window.location.reload();
        })
    }


    const getAttendanceDashboardMainSource = async () => {
        canShowLoading.value = true
        let url = '/get-attendance-dashboard'
        await axios.post(url,{
            date: dayjs(new Date()).format('YYYY-MM-DD')
        }).then(res => {
            attendanceOverview.value = res.data.attendance_overview

            totalEmployeeInOrganization.value = res.data.total_Employees
            console.log(" totalEmployeeInOrganization.value" + totalEmployeeInOrganization.value);
            chartDetails.value[0].count = parseInt(attendanceOverview.value['absent_count'])
            chartDetails.value[1].count = parseInt(attendanceOverview.value['present_count'])
            chartDetails.value[2].count = parseInt(attendanceOverview.value['leave_emp_count'])
            chartDetails.value[3].count = parseInt(attendanceOverview.value['lc_count'])
            chartDetails.value[4].count = parseInt(attendanceOverview.value['eg_count'])
            chartDetails.value[5].count = parseInt(attendanceOverview.value['mop_count'])
            chartDetails.value[6].count = parseInt(attendanceOverview.value['mip_count'])


            attendanceDashboardWorkShiftSource.value = res.data.work_shift
            // attendanceDashboardUpcoming.value = res.data.upcomings
            let obj = Object.entries(res.data.upcomings).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            attendanceDashboardUpcoming.value = obj

            let graph = Object.entries(res.data.attendance_overview).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
            })
            overallEmployeeCountForExceptionAnalytics.value = graph

            let desiredHeaders = ["absent_count", "present_count", "leave_emp_count", "lc_count", "eg_count", "mop_count", "mip_count"]

            overallEmployeeCountForExceptionAnalytics.value.forEach(async element => {
                if (overallEmployeeCountForExceptionAnalyticsForGraph.value.length < 7) {
                    if (desiredHeaders.includes(element.title)) {
                         overallEmployeeCountForExceptionAnalyticsForGraph.value.push(element.value)
                    }

                }
            });

            AttendanceAnalytics.value = res.data.CheckInMode


            AttendanceAnalytics.value.forEach(async element => {
                if (AttendanceAnalyticsForGraph.value.length < 3) {
                    AttendanceAnalyticsForGraph.value.push(element.value)
                }
            });





        }).finally(() => {
            canShowLoading.value = false
        })
    }


    return {
        canShowLoading,
        attendanceDashboardWorkShiftSource, getAttendanceDashboardMainSource,

        attendanceOverview, totalEmployeeInOrganization, chartDetails,

        canShowShiftDetails, canShowAttendanceOverview, selectedAttendanceOverviewReport, currentlySelectedShiftDetails, currentlySelectedShiftName, downloadShiftDetails, downloadAttendanceOverviewDetails,

        attendanceDashboardUpcoming, overallEmployeeCountForExceptionAnalytics, overallEmployeeCountForExceptionAnalyticsForGraph,

        AttendanceAnalytics,AttendanceAnalyticsForGraph,

        GetDepartment,
        departments,

        send_selectedDepartment


    }
})
