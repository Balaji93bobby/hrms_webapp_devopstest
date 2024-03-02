import axios from "axios";
import { mixin } from "lodash";
import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { inject, reactive, ref } from "vue";
import { Service} from '../../../Service/Service'
import { EmployeeMasterStore } from "../../employee_master_report/employee_master_reportsStore";


export const UseReports_store = defineStore("UseReports_store", () => {

    // variable Declaration

    const useEmployeeMaster = EmployeeMasterStore()

    // fetch filter details variables
    const get_Legal_Entity = ref();
    const getDepartment = ref();
    const getPeriodMonth = ref();

    const dialog_customDate = ref(false);


    // v-model values
    const Legal_Entity = ref();
    const Department = ref();
    const PeriodMonth = ref();
    const Start_Date = ref();
    const End_Date = ref();
    const attendance_Type = ref(1);
    const service = Service();

    // const

    const canShowLoading = ref(false);

    const activetab = ref(1);

    const btn_download = ref();

    const selectedfilters = reactive({
        date: "",
        department_id: "",
        client_id: "",
        active_status: "",
        start_date: "",
        end_date: "",
        type: "",
        user_code:service.current_user_code
    });

    const AttendanceReportSource = ref([]);
    const AttendanceReportDynamicHeaders = ref([]);

    function fetchFilterClientId() {
        canShowLoading.value = true;
        axios.get('/clients-fetchAll').then((res) => {
            get_Legal_Entity.value = res.data;
            console.log("legal_entity ::", get_Legal_Entity.value);
        }).finally(() => {
            canShowLoading.value = false;
        })
    }

    function get_All_Department() {
        canShowLoading.value = true;
        axios.get('/get-department').then((res) => {
            getDepartment.value = res.data;
        }).finally(() => {
            canShowLoading.value = false;
        })
    }

    function fetchPeriodMonth() {
        // let date = Date;
        canShowLoading.value = true;
        axios.post('/get-filter-months-for-reports').then((res) => {
            getPeriodMonth.value = res.data;
        }).finally(() => {
            canShowLoading.value = false;
        })

    }

    // function

    function downloadEmployeeMaster(val) {
        console.log(" value :: ", val);

    }

    function getSelectoption(key, filterValue, active_status) {
        console.log(key, filterValue, active_status);
        console.log(selectedfilters);
        let url;
        let subUrl;

        console.log(filterValue);

        // else if(filterValue=="custom_date" && active_status==5 ){
        //      dialog_customDate.value= false;
        // }

        if (active_status == 1) {
            // Detailed Reports
            url = `/fetch-detailed-attendance-data`;
            if (filterValue === "custom_date") {
                dialog_customDate.value = true;
            }
        } else
            if (active_status == 2) {
                // Muster Reports
                url = `/fetch-attendance-data`;
                if (filterValue === "custom_date") {
                    dialog_customDate.value = true;
                }
            }
        if (active_status == 3) {
            // consolidate Reports
            url = `/fetch-consolidate-report`;
            if (filterValue === "custom_date") {
                dialog_customDate.value = true;
            }
        } else
            if (active_status == 4) {
                // Overtime Reports
                url = `/fetch-overtime-report-data`;
                if (filterValue === "custom_date") {
                    dialog_customDate.value = true;
                }
            } else
                if (active_status == 5) {
                    if (attendance_Type.value) {
                        if (attendance_Type.value == 1) {
                            url = '/fetch-LC-report-data';
                            if (filterValue === "custom_date") {
                                dialog_customDate.value = true;
                            }
                        } else
                            if (attendance_Type.value == 2) {
                                url = '/fetch-EG-report-data';
                                if (filterValue === "custom_date") {
                                    dialog_customDate.value = true;
                                }
                            } else
                                if (attendance_Type.value == 3) {
                                    url = '/fetch-absent-report-data';
                                    if (filterValue === "custom_date") {
                                        dialog_customDate.value = true;
                                    }
                                } else
                                    if (attendance_Type.value == 4) {
                                        url = '/fetch-half-day-report';
                                        if (filterValue === "custom_date") {
                                            dialog_customDate.value = true;
                                        }
                                    } else
                                        if (attendance_Type.value == 5) {
                                            url = '/fetch-mip-mop-report';
                                            if (filterValue === "custom_date") {
                                                dialog_customDate.value = true;
                                            }
                                        } else
                                            if (attendance_Type.value == 6) {
                                                url = '/fetch-mip-mop-report';
                                                if (filterValue === "custom_date") {
                                                    dialog_customDate.value = true;
                                                }
                                            }
                    } else {
                        Swal.fire({
                            title: "error",
                            text: "selected report type",
                            icon: "error",
                            showCancelButton: false,
                        })

                        useEmployeeMaster.period_Date = null
                        useEmployeeMaster.Department = null
                        useEmployeeMaster.legal_Entity = null
                    }
                }


        if (key == "department") {
            selectedfilters.department_id = filterValue;

        } else
            if (key == "Category") {
                selectedfilters.active_status = filterValue
                console.log(selectedfilters);
            } else
                if (key == "date") {
                    selectedfilters.date = filterValue
                } else
                    if (key == "legal_entity") {
                        selectedfilters.client_id = filterValue
                    }

        // canShowLoading.value = true;

        // if (url) {
        //     useEmployeeMaster.canShowLoading = true
        //     axios.post(url, selectedfilters).then(res => {
        //         AttendanceReportSource.value = res.data.rows;
        //         res.data.headers.forEach(element => {
        //             let format = {
        //                 title: element
        //             }
        //             AttendanceReportDynamicHeaders.value.push(format);

        //             if (res.data.rows.length === 0) {
        //                 Swal.fire({
        //                     title: res.data.status = "failure",
        //                     text: "No employees found in this category",
        //                     // "Salary Advance Succesfully",
        //                     icon: "error",
        //                     showCancelButton: false,
        //                 }).then((res) => {
        //                     // blink_UI.value = res.data.data;

        //                 })

        //             }
        //         });
        //     }).finally(() => {
        //         useEmployeeMaster.canShowLoading = false
        //         useEmployeeMaster.selectedfilters.active_status="";
        //         useEmployeeMaster.selectedfilters.date="";
        //         useEmployeeMaster.selectedfilters.department_id="";
        //         useEmployeeMaster.selectedfilters.legal_entity="";

        //         useEmployeeMaster.legal_Entity="";
        //         useEmployeeMaster.Department="";
        //         useEmployeeMaster.period_Date="";
        //         useEmployeeMaster.select_Category=""
        //     })

        // }


    }

    function updateAttendanceReports(active_status) {
        AttendanceReportSource.value.splice(0, AttendanceReportSource.value.length);
        AttendanceReportDynamicHeaders.value.splice(0,
            AttendanceReportDynamicHeaders.value.length);

        let url;

        console.log(active_status, "url ");

        if (active_status == 2) {
            // Muster Reports
            url = `/fetch-attendance-data`;
        }
        else
            if (active_status == 3) {
                // Overtime Reports
                url = `/fetch-consolidate-report`;
            } else
                if (active_status == 4) {
                    // Overtime Reports
                    url = `/fetch-overtime-report-data`;
                } else
                    if (active_status == 5) {
                        if (attendance_Type.value) {
                            if (attendance_Type.value == 1) {
                                url = '/fetch-LC-report-data'
                            } else
                                if (attendance_Type.value == 2) {
                                    url = '/fetch-EG-report-data'
                                } else
                                    if (attendance_Type.value == 3) {
                                        url = '/fetch-absent-report-data'
                                    } else
                                        if (attendance_Type.value == 4) {
                                            url = '/fetch-half-day-report'
                                        }
                                        else
                                            if (attendance_Type.value == 5) {
                                                url = '/api/fetch-mip-mop-report'
                                                selectedfilters.type = 'MIP'
                                            }
                                            else
                                                if (attendance_Type.value == 6) {
                                                    url = '/api/fetch-mip-mop-report'
                                                    selectedfilters.type = 'MOP'

                                                }
                        } else {
                            Swal.fire({
                                title: "error",
                                text: "selected report type",
                                icon: "error",
                                showCancelButton: false,
                            })

                            useEmployeeMaster.period_Date = null
                            useEmployeeMaster.Department = null
                            useEmployeeMaster.legal_Entity = null
                        }
                    }

        if (url) {

            useEmployeeMaster.canShowLoading = true
            axios.post(`${window.location.origin}${url}`, selectedfilters).then(res => {
                AttendanceReportSource.value = res.data.rows;
                res.data.headers.forEach(element => {
                    let format = {
                        title: element
                    }
                    AttendanceReportDynamicHeaders.value.push(format);

                    if (res.data.rows.length === 0) {
                        Swal.fire({
                            title: res.data.status = "failure",
                            text: "No employees found in this category",
                            // "Salary Advance Succesfully",
                            icon: "error",
                            showCancelButton: false,
                        }).then((res) => {
                            // blink_UI.value = res.data.data;

                        })

                    }
                });
            }).finally(() => {
                useEmployeeMaster.canShowLoading = false
                // useEmployeeMaster.selectedfilters.active_status="";
                // useEmployeeMaster.selectedfilters.date="";
                // useEmployeeMaster.selectedfilters.department_id="";
                // useEmployeeMaster.selectedfilters.legal_entity="";

                // useEmployeeMaster.legal_Entity="";
                // useEmployeeMaster.Department="";
                // useEmployeeMaster.period_Date="";
                // useEmployeeMaster.select_Category=""
            })

        }

    }

    function select_StartAndEnd_Date(key, filterValue, active_status) {
        let url;
        let subUrl;


        if (active_status == 2) {
            // Muster Reports
            url = `/fetch-attendance-data`;
        } else
            if (active_status == 4) {
                // Overtime Reports
                url = `/fetch-overtime-report-data`;
            } else
                if (active_status == 5) {
                    if (attendance_Type.value) {
                        if (attendance_Type.value == 1) {
                            url = '/fetch-LC-report-data'
                        } else
                            if (attendance_Type.value == 2) {
                                url = '/fetch-EG-report-data'
                            } else
                                if (attendance_Type.value == 3) {
                                    url = '/fetch-absent-report-data'
                                } else
                                    if (attendance_Type.value == 4) {
                                        url = '/fetch-half-day-report'
                                    }
                    } else {
                        Swal.fire({
                            title: "error",
                            text: "selected report type",
                            icon: "error",
                            showCancelButton: false,
                        })

                        useEmployeeMaster.period_Date = null
                        useEmployeeMaster.Department = null
                        useEmployeeMaster.legal_Entity = null
                    }
                }

        if (key == "start_date") {
            selectedfilters.start_date = filterValue;
            console.log(selectedfilters);

        } else
            if (key == "end_date") {
                selectedfilters.end_date = filterValue
                console.log(selectedfilters);
            }
        if (selectedfilters.start_date && selectedfilters.end_date) {
            dialog_customDate.value = false;
        }

        // if(active_status !== 1 && selectedfilters.start_date && selectedfilters.end_date){

        //     console.log("success");

        //     useEmployeeMaster.canShowLoading = true
        //     axios.post(url, selectedfilters).then(res => {
        //         AttendanceReportSource.value = res.data.rows;
        //         res.data.headers.forEach(element => {
        //             let format = {
        //                 title: element
        //             }
        //             AttendanceReportDynamicHeaders.value.push(format);

        //             if (res.data.rows.length === 0) {
        //                 Swal.fire({
        //                     title: res.data.status = "failure",
        //                     text: "No employees found in this category",
        //                     // "Salary Advance Succesfully",
        //                     icon: "error",
        //                     showCancelButton: false,
        //                 }).then((res) => {
        //                     // blink_UI.value = res.data.data;

        //                 })

        //             }
        //         });
        //     }).finally(() => {
        //         useEmployeeMaster.canShowLoading = false
        //     })

        // }else{
        //     console.log("testing start date and end date ::",selectedfilters);
        // }

    }


    const downloadAttendanceReports = (active_status) => {
        useEmployeeMaster.canShowLoading = true
        let url;
        let filename;
        if (active_status == 1) {
            url = '/reports/generate-detailed-attendance-report'
            filename = "Attendance Detailed Report"
        } else
            if (active_status == 2) {
                url = '/reports/generate-basic-attendance'
                filename = "Attendance Basic Report"
            }
            else
                if (active_status == 3) {
                    url = '/report/download-consolidate-report'
                    filename = "consolidate Report"
                } else
                    if (active_status == 4) {
                        url = '/report/download-over-time-report'
                        filename = "Attendance Overtime Report"

                    } else
                        if (active_status == 5) {
                            if (attendance_Type.value == 1) {
                                url = '/report/download-late-coming-report'
                                filename = "Attendance Late-coming Report"
                            } else
                                if (attendance_Type.value == 2) {
                                    url = '/report/download-early-going-report'
                                    filename = "Attendance Early going Report"
                                } else
                                    if (attendance_Type.value == 3) {
                                        url = '/report/download-absent-report'
                                        filename = "Attendance Absent Report"
                                    } else
                                        if (attendance_Type.value == 4) {
                                            url = '/report/download-half-day-report'
                                            filename = "Attendance Half-day Report"
                                        } else
                                            if (attendance_Type.value == 5) {
                                                url = '/api/report/download/mip-mop-report'
                                                selectedfilters.type = 'MIP'
                                                filename = "Missed in Punch Report"
                                            }
                                            else
                                                if (attendance_Type.value == 6) {
                                                    url = '/api/report/download/mip-mop-report'
                                                    selectedfilters.type = 'MOP'
                                                    filename = "Missed out Punch Report"

                                                }

                        }

        if (url) {
            axios.post(url, selectedfilters, { responseType: 'blob' }).then((response) => {
                console.log(response.data);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(response.data);
                link.download = `${filename}.xlsx`;
                link.click();
            }).finally(() => {
                useEmployeeMaster.canShowLoading = false;
                useEmployeeMaster.selectedfilters.active_status = "";
                useEmployeeMaster.selectedfilters.date = "";
                useEmployeeMaster.selectedfilters.department_id = "";
                useEmployeeMaster.selectedfilters.legal_entity = "";

                useEmployeeMaster.legal_Entity = "";
                useEmployeeMaster.Department = "";
                useEmployeeMaster.period_Date = "";
                useEmployeeMaster.select_Category = ""
                Start_Date.value = ""
                End_Date.value = ""
                selectedfilters.end_date = ""
                selectedfilters.start_date = ""

            })
        }
    }


    const getEmployeeAttendanceReports = async () => {

        // Attendance Basic Reports
        let url = '/fetch-attendance-data'
        canShowLoading.value = true
        await axios.post(url).then(res => {
            console.log(res.data.rows);
            AttendanceReportSource.value = res.data.rows
            res.data.headers.forEach(element => {
                let format = {
                    title: element
                }
                AttendanceReportDynamicHeaders.value.push(format)
                console.log(element);
            });
            console.log(AttendanceReportDynamicHeaders.value);

        }).finally(() => {
            canShowLoading.value = false
        })

    }

    function clearDataTable() {

        AttendanceReportSource.value.splice(0, AttendanceReportSource.value.length);
        AttendanceReportDynamicHeaders.value.splice(0,
            AttendanceReportDynamicHeaders.value.length);
        // attendance_Type.value = null;
        Start_Date.value = ""
        End_Date.value = ""
        selectedfilters.end_date = ""
        selectedfilters.start_date = ""
    }




    return {

        canShowLoading,

        // variables
        Legal_Entity,
        Department,
        PeriodMonth,
        Start_Date,
        End_Date,

        btn_download,

        getPeriodMonth,
        getDepartment,
        get_Legal_Entity,

        // navbar var
        activetab,

        // functions

        // fetch leagl entity
        fetchFilterClientId,
        get_All_Department,
        fetchPeriodMonth,

        //
        getSelectoption,
        AttendanceReportSource,
        AttendanceReportDynamicHeaders,
        getEmployeeAttendanceReports,
        attendance_Type,
        downloadAttendanceReports,
        clearDataTable,
        select_StartAndEnd_Date,

        // apply filter ::
        updateAttendanceReports,

        // custom date dialog box variable
        selectedfilters,
        dialog_customDate
    }

});
