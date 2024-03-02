import axios from "axios";
import { defineStore } from "pinia";
import { computed, inject, ref } from "vue";
import { useCalendarStore } from './calendar'
import { Service } from "../../../Service/Service";
const swal = inject("$swal");


export const useAttendanceTimesheetMainStore = defineStore("Timesheet", () => {

    const useCalendar = useCalendarStore()
    const service = Service()

    const canShowLoading = ref(true)
    const canShowApplyRegularizationLoading = ref(false)
    const canShowSidebar = ref(false)
    const isManager = ref(false)
    const isTeamOrg = ref('single')
    const switchTimesheet = ref('Classic');
    const CurrentlySelectedUser = ref();
    const CurrentlySelectedUserCode = ref();
    const currentlySelectedTimesheet = ref(1);
    const selected_user_code = ref();

    const mopDetails = ref({})
    const mipDetails = ref({})
    const lcDetails = ref({})
    const egDetails = ref({})
    const AttendanceLateOrMipRegularization = ref()
    const AttendanceEarylOrMopRegularization = ref()
    const absentRegularizationDetails = ref({})
    const selfieDetails = ref({})


    const dialog_Mop = ref(false)
    const dialog_Mip = ref(false)
    const dialog_Lc = ref(false)
    const dialog_Eg = ref(false)
    const dialog_Selfie = ref(false)
    const classicTimesheetSidebar = ref(false)
    const classicAttendanceRegularizationDialog = ref(false)

    const currentEmployeeAttendance = ref()
    const currentEmployeeAttendanceLength = ref(0)
    const currentlySelectedTeamMemberUserId = ref()
    const currentlySelectedTeamMemberAttendance = ref()
    const currentlySelectedOrgMemberUserId = ref()
    const currentlySelectedOrgMemberAttendance = ref()
    const currentlySelectedClientCode = ref()
    const currentlySelectedCellRecord = ref({});

    // interconnect with leave apply module.

    const selectedMonth = ref();
    const selectedyear = ref();





    const getEmployeeAttendance = async (currentlySelectedUser, currentlySelectedMonth, currentlySelectedYear) => {
        canShowLoading.value = true;

        selected_user_code.value = currentlySelectedUser;
        selectedMonth.value = currentlySelectedMonth;
        selectedyear.value = currentlySelectedYear;
        // console.log(CurrentlySelectedUser);
        let url = '/fetch-attendance-user-timesheet';

        //Returns '0' if shift is not assigned to user. Need to handle error scenario based on that value.
        try {


            return await axios.post(url, {
                month: currentlySelectedMonth + 1,
                year: currentlySelectedYear,
                user_code: currentlySelectedUser,
            }).then(res => {
                // console.log(" getEmployeeAttendance() : " + Object.values(res.data));
                // Object.values(res.data)
                return res.data;
            }).finally(()=>{
                canShowLoading.value = false;
            })

        } catch (error) {
            console.error('Error [ getEmployeeAttendance() ]:', error);
            return null;
        }
    }

    /* Get currently login employee daily attendance */
    const getSelectedEmployeeAttendance = async (currentlySelectedUserCode) => {
        currentEmployeeAttendance.value = [];
        currentEmployeeAttendanceLength.value = [];
        console.log( currentEmployeeAttendanceLength.value,  currentEmployeeAttendanceLength.value ,'currentEmployeeAttendanceLength :: :');
        try {
            let userCode;
            currentlySelectedUserCode ? userCode = currentlySelectedUserCode : userCode = service.current_user_code
            canShowLoading.value = true
            return await getEmployeeAttendance(userCode, useCalendar.getMonth, useCalendar.getYear).then(res => {
                // console.log("getSelectedEmployeeAttendance() : " + res);
                //If shift is assigned , then 0 not returned
                if (res) {
                    // console.log("Selected employee attendance : " + res.data);
                    currentEmployeeAttendance.value = res.data ? Object.values(res.data) : []
                    currentEmployeeAttendanceLength.value = res.data ? Object.values(res.data).length : 0
                }
                else {
                    //If shift is not assigned , then 0 is returned in res
                    //Todo : Show Error popup "Shift is not assigned for this user"
                    return null;
                }
            });
        }
        catch (error) {
            console.error('Error [ getSelectedEmployeeAttendance() ]:', error);
        }
        finally {
            canShowLoading.value = false

        }
    }

    /* Get currently selected team employee daily attendance */
    const getSelectedEmployeeTeamDetails = (user_code, isTeam) => {

        isTeamOrg.value = isTeam
        canShowLoading.value = true
        currentlySelectedTeamMemberUserId.value = user_code
        getEmployeeAttendance(user_code, useCalendar.getMonth, useCalendar.getYear).then(res => {
            currentlySelectedTeamMemberAttendance.value = res.data ? Object.values(res.data) : []

        })
            .catch((error) => {
                console.log('Error[ getSelectedEmployeeTeamDetails)() ]', error);
            })
            .finally(() => {
                canShowLoading.value = false
            })
    }

    /* Get currently selected organization employee daily attendance */
    const getSelectedEmployeeOrgDetails = async (user_code, isTeam, currentlySelectedUser) => {
        isTeamOrg.value = isTeam;
        // console.log("===========" + currentlySelectedUser);
        CurrentlySelectedUser.value = currentlySelectedUser;
        // console.log("employee list select function  ::", CurrentlySelectedUser.value);
        canShowLoading.value = true;
        currentlySelectedOrgMemberUserId.value = user_code
        await getEmployeeAttendance(user_code, useCalendar.getMonth, useCalendar.getYear).then(res => {
            // console.log(" getSelectedEmployeeOrgDetails() : " + Object.values(res.data));
            currentlySelectedOrgMemberAttendance.value = res.data ? Object.values(res.data) : []
        }).finally(() => {
            canShowLoading.value = false
        })
    }

    /* Get currently login employee team list  */
    const getTeamList = async (user_code) => {
        // console.log(user_code);
        return axios.post('/fetch-team-members', {
            user_code: user_code
        })
    }

    const getOrgList = async () => {
        return axios.get('/fetch-org-members')
    }

    /* Finding Attendance Mode
      -> Mobile
      ->Biometric
      ->PC

       if Employee check in or check out using mobile
       selfie image is required
    */

    const findAttendanceMode = (attendance_mode) => {
        // console.log(attendance_mode);
        if (attendance_mode == "biometric")
            // return '&nbsp;<i class="fa-solid fa-fingerprint"></i>';
            return 'fas fa-fingerprint fs-12'
        else
            if (attendance_mode == "web")
                return 'fa fa-laptop fs-12';
            else
                if (attendance_mode == "mobile")
                    return 'fa fa-mobile-phone fs-12';
                else {
                    return ''; // when attendance_mode column is empty.
                }
    }


    /* Attendance regularization for

    ->LC - Late coming
    ->EG - Early going
    ->MIP -> Missed In punch
    ->MOp -> Missed Out Punch

    */

    /* Creating constructor for Attendance Regularization request */
    const AttendanceRegularizationApplyFormat = (selectedDayRegularizationRecord, selectedAttendanceRegularizationType) => {
        let currentlySelectedUser = CurrentlySelectedUser.value
        // console.log("currentlySelectedUser".currentlySelectedUser);
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (service.current_user_role == 1 || service.current_user_role == 2) {
                let AttendanceRegularizeFormat = {
                    admin_user_code: service.current_user_code,
                    user_code: currentlySelectedUser,
                    regularization_type: selectedAttendanceRegularizationType,
                    attendance_date: selectedDayRegularizationRecord.date,
                    user_time: selectedDayRegularizationRecord.checkin_time,
                    regularize_time: selectedAttendanceRegularizationType == 'LC' || selectedAttendanceRegularizationType == 'MIP' ? convertTime(AttendanceLateOrMipRegularization.value) :
                        selectedAttendanceRegularizationType == 'EG' || selectedAttendanceRegularizationType == 'MOP' ? convertTime(AttendanceEarylOrMopRegularization.value) : '',
                    reason: selectedDayRegularizationRecord.reason,
                    custom_reason: selectedDayRegularizationRecord.custom_reason ? selectedDayRegularizationRecord.custom_reason : '',
                }
                AttendanceLateOrMipRegularization.value = null
                AttendanceEarylOrMopRegularization.value = null
                return AttendanceRegularizeFormat
            }
        } else {
            let AttendanceRegularizeFormat = {
                user_code: service.current_user_code,
                regularization_type: selectedAttendanceRegularizationType,
                attendance_date: selectedDayRegularizationRecord.date,
                user_time: selectedAttendanceRegularizationType == 'EG' ? selectedDayRegularizationRecord.checkout_time : selectedDayRegularizationRecord.checkin_time,
                regularize_time: selectedAttendanceRegularizationType == 'LC' || selectedAttendanceRegularizationType == 'MIP' ? convertTime(AttendanceLateOrMipRegularization.value) :
                    selectedAttendanceRegularizationType == 'EG' || selectedAttendanceRegularizationType == 'MOP' ? convertTime(AttendanceEarylOrMopRegularization.value) : '',
                reason: selectedDayRegularizationRecord.reason,
                custom_reason: selectedDayRegularizationRecord.custom_reason ? selectedDayRegularizationRecord.custom_reason : '',
            }
            AttendanceLateOrMipRegularization.value = null
            AttendanceEarylOrMopRegularization.value = null
            return AttendanceRegularizeFormat
        }

        // console.log(AttendanceRegularizeFormat);
        // AttendanceLateOrMipRegularization.value = null
        // AttendanceEarylOrMopRegularization.value = null
        // return AttendanceRegularizeFormat
    }


    //  Applying for Late Coming and Early Going

    const onClickShowLcRegularization = (attendance) => {
        canShowSidebar.value = true
        // dialog_Lc.value = true
        currentlySelectedCellRecord.value = { ...attendance }
        lcDetails.value = { ...attendance }
        CurrentlySelectedUser.value = attendance.user_code
    }


    const applyLcRegularization = () => {
        canShowApplyRegularizationLoading.value = true;
        let currentlySelectedUser = CurrentlySelectedUser.value ? CurrentlySelectedUser.value : service.current_user_code;
        console.log(`currentlySelectedUser :: `, currentlySelectedUser);
        let url;
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (service.current_user_role == 1 || service.current_user_role == 2) {
                url = `${window.location.origin}/checkAttendanceEmployeeAdminStatus`
            }
        } else {
            url = `${window.location.origin}/attendance-req-regularization`
        }

        axios.post(url, AttendanceRegularizationApplyFormat(lcDetails.value, 'LC'))
            .then((res) => {
                // getSelectedEmployeeAttendance(currentlySelectedUser)
                let message = res.data.message
                // console.log(message);
                if (res.data.status == 'success') {
                    canShowSidebar.value = false
                    classicAttendanceRegularizationDialog.value = false
                    Swal.fire(
                        'Good job!',
                        'Attendance Regularized Successful',
                        'success'
                    ).then(() => {
                        if (currentlySelectedTimesheet.value == 1) {
                            getSelectedEmployeeAttendance(currentlySelectedUser);

                        } else
                            if (service.current_user_role == 1 || service.current_user_role == 2) {
                                if (currentlySelectedTimesheet.value == 2) {
                                    getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                                } else
                                    if (currentlySelectedTimesheet.value == 3) {
                                        getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                    }
                            }
                    })
                } else {
                    Swal.fire(
                        'Oops!',
                        `${message}`,
                        'error'
                    ).then(() => {
                        getSelectedEmployeeAttendance(currentlySelectedUser)
                    })
                }
            }).finally(() => {
                canShowApplyRegularizationLoading.value = false
            })

    }

    const onClickShowEgRegularization = (attendance) => {
        // dialog_Eg.value = true
        egDetails.value = { ...attendance }
        currentlySelectedCellRecord.value = { ...attendance }
        canShowSidebar.value = true
        CurrentlySelectedUser.value = attendance.user_code
    }

    const applyEgRegularization = () => {
        let currentlySelectedUser = CurrentlySelectedUser.value;
        // console.log(`currentlySelectedUser :: `, currentlySelectedUser);

        let url;
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (service.current_user_role == 1 || service.current_user_role == 2) {
                url = `${window.location.origin}/checkAttendanceEmployeeAdminStatus`
            }
        } else {
            url = `${window.location.origin}/attendance-req-regularization`
        }
        canShowApplyRegularizationLoading.value = true
        axios.post(url, AttendanceRegularizationApplyFormat(egDetails.value, 'EG'))
            .then((res) => {
                getSelectedEmployeeAttendance(currentlySelectedUser);

                let message = res.data.message
                // console.log(message);
                if (res.data.status == 'success') {
                    classicAttendanceRegularizationDialog.value = false
                    canShowSidebar.value = false
                    Swal.fire(
                        'Success!',
                        'Attendance Regularized Successful',
                        'success'
                    ).then(() => {
                        if (service.current_user_role == 1 || service.current_user_role == 2) {
                            if (currentlySelectedTimesheet.value == 2) {
                                getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                            } else
                                if (currentlySelectedTimesheet.value == 3) {
                                    getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                }
                        } else {
                            getSelectedEmployeeAttendance(currentlySelectedUser);
                        }
                    })
                } else {
                    Swal.fire(
                        'Error',
                        `${message}`,
                        'error'
                    )
                }
            }).finally(() => {
                canShowApplyRegularizationLoading.value = false
            })

    }


    //  Applying for Missed In and  Out Punches

    const onClickShowMipRegularization = (attendance) => {
        // dialog_Mip.value = true
        mipDetails.value = { ...attendance }
        currentlySelectedCellRecord.value = { ...attendance }
        canShowSidebar.value = true
        CurrentlySelectedUser.value = attendance.user_code
    }


    const applyMipRegularization = () => {

        let currentlySelectedUser = CurrentlySelectedUser.value;
        // console.log(`currentlySelectedUser :: `, currentlySelectedUser);

        canShowApplyRegularizationLoading.value = true;
        let url;
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (service.current_user_role == 1 || service.current_user_role == 2) {
                url = `${window.location.origin}/checkAttendanceEmployeeAdminStatus`
            }
        } else {
            url = `${window.location.origin}/attendance-req-regularization`
        }
        axios.post(url, AttendanceRegularizationApplyFormat(mipDetails.value, 'MIP'))
            .then((res) => {
                getSelectedEmployeeAttendance(currentlySelectedUser);
                let message = res.data.message
                // console.log(message);
                if (res.data.status == 'success') {
                    classicAttendanceRegularizationDialog.value = false
                    canShowSidebar.value = false
                    Swal.fire(
                        'Good job!',
                        'Attendance Regularized Successful',
                        'success'
                    ).then(() => {
                        if (service.current_user_role == 1 || service.current_user_role == 2) {
                            if (currentlySelectedTimesheet.value == 2) {
                                getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                            } else
                                if (currentlySelectedTimesheet.value == 3) {
                                    getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                }
                        } else {
                            getSelectedEmployeeAttendance(currentlySelectedUser);
                        }
                        // currentlySelectedTimesheet.value= 3;
                    })
                } else {
                    Swal.fire(
                        'Oops!',
                        `${message}`,
                        'error'
                    )
                }
            }).finally(() => {
                canShowApplyRegularizationLoading.value = false
            })

    }

    const onClickShowMopRegularization = (attendance) => {
        // dialog_Mop.value = true
        mopDetails.value = { ...attendance }
        currentlySelectedCellRecord.value = { ...attendance }
        canShowSidebar.value = true
        CurrentlySelectedUser.value = attendance.user_code
    }

    const applyMopRegularization = () => {
        let currentlySelectedUser = CurrentlySelectedUser.value;
        // console.log(`currentlySelectedUser :: `, currentlySelectedUser);

        let url;
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (service.current_user_role == 1 || service.current_user_role == 2) {
                url = `${window.location.origin}/checkAttendanceEmployeeAdminStatus`
            }
        } else {
            url = `${window.location.origin}/attendance-req-regularization`
        }
        canShowApplyRegularizationLoading.value = true;
        axios.post(url, AttendanceRegularizationApplyFormat(mopDetails.value, 'MOP'))
            .then((res) => {
                getSelectedEmployeeAttendance(currentlySelectedUser)
                let message = res.data.message
                // console.log(message);
                if (res.data.status == 'success') {
                    classicAttendanceRegularizationDialog.value = false
                    canShowSidebar.value = false
                    Swal.fire(
                        'Good job!',
                        'Attendance Regularized Successful',
                        'success'
                    ).then(() => {
                        if (service.current_user_role == 1 || service.current_user_role == 2) {
                            if (currentlySelectedTimesheet.value == 2) {
                                getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                            } else
                                if (currentlySelectedTimesheet.value == 3) {
                                    getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                }
                        } else {
                            getSelectedEmployeeAttendance(currentlySelectedUser);
                        }
                        // currentlySelectedTimesheet.value= 3;
                    })
                } else {
                    Swal.fire(
                        'Oops!',
                        `${message}`,
                        'error'
                    )
                }
            }).finally(() => {
                canShowApplyRegularizationLoading.value = false
            })

    }


    //  Applying for Absent  Regularization
    const applyAbsentRegularization = () => {
        canShowApplyRegularizationLoading.value = true;
        let currentlySelectedUser = CurrentlySelectedUser.value;
        // console.log(`currentlySelectedUser :: `, currentlySelectedUser);

        let url;
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {

            if (service.current_user_role == 2) {
                url = `${window.location.origin}/checkAbsentEmployeeAdminStatus`;
            }
        } else {
            url = `${window.location.origin}/attendance-req-absent-regularization`;
        }
        if (currentlySelectedTimesheet.value == 2 || currentlySelectedTimesheet.value == 3) {
            if (currentlySelectedUser && (service.current_user_role == 1 || service.current_user_role == 2)) {
                axios.post(url, {
                    admin_user_code: service.current_user_code,
                    user_code: currentlySelectedUser,
                    attendance_date: absentRegularizationDetails.value.date,
                    regularization_type: "Absent Regularization",
                    checkin_time: convertTime(absentRegularizationDetails.value.start_time),
                    checkout_time: convertTime(absentRegularizationDetails.value.end_time),
                    reason: absentRegularizationDetails.value.reason,
                    custom_reason: absentRegularizationDetails.value.custom_reason ? absentRegularizationDetails.value.custom_reason : "",
                })
                    .then((res) => {
                        getSelectedEmployeeAttendance(currentlySelectedUser)
                        let message = res.data.message
                        // console.log(message);
                        if (res.data.status == 'success') {
                            classicAttendanceRegularizationDialog.value = false
                            canShowSidebar.value = false
                            Swal.fire(
                                'Good job!',
                                'Attendance Regularized Successful',
                                'success'
                            ).then(() => {
                                if (service.current_user_role == 1 || service.current_user_role == 2) {
                                    if (currentlySelectedTimesheet.value == 2) {
                                        getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                                    } else
                                        if (currentlySelectedTimesheet.value == 3) {
                                            getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                        }
                                } else {
                                    getSelectedEmployeeAttendance(currentlySelectedUser);
                                }
                            })
                        } else {
                            Swal.fire(
                                'Oops!',
                                `${message}`,
                                'error'
                            )
                        }
                    }).finally(() => {
                        canShowApplyRegularizationLoading.value = false;
                    })
            }
        } else {
            axios.post(url, {
                user_code: service.current_user_code,
                attendance_date: absentRegularizationDetails.value.date,
                regularization_type: "Absent Regularization",
                checkin_time: convertTime(absentRegularizationDetails.value.start_time),
                checkout_time: convertTime(absentRegularizationDetails.value.end_time),
                reason: absentRegularizationDetails.value.reason,
                custom_reason: absentRegularizationDetails.value.custom_reason ? absentRegularizationDetails.value.custom_reason : "",
            })
                .then((res) => {
                    getSelectedEmployeeAttendance()
                    let message = res.data.message
                    // console.log(message);
                    if (res.data.status == 'success') {
                        Swal.fire(
                            'Good job!',
                            'Attendance Regularized Successful',
                            'success'
                        ).then(() => {
                            if (service.current_user_role == 1 || service.current_user_role == 2) {
                                if (currentlySelectedTimesheet.value == 2) {
                                    getSelectedEmployeeTeamDetails(currentlySelectedUser, true)

                                } else
                                    if (currentlySelectedTimesheet.value == 3) {
                                        getSelectedEmployeeOrgDetails(currentlySelectedUser, false, currentlySelectedUser)
                                    }
                            } else {
                                getSelectedEmployeeAttendance(currentlySelectedUser);
                            }
                        })
                    } else {
                        Swal.fire(
                            'Oops!',
                            `${message}`,
                            'error'
                        )
                    }
                }).finally(() => {
                    canShowApplyRegularizationLoading.value = false
                })


        }

    }

    const withdrawAttendanceRegularization = (data,attendaceType) =>{
        console.log("attendaceType"+attendaceType);
        console.log(data);
    }



    // View check in and out selfie Images

    const onClickSViewSelfie = (attendance) => {
        dialog_Selfie.value = true
        selfieDetails.value = attendance
    }


    // Helper Functions


    // Time conversion

    const convertTime = (inputTime) => {
        if (inputTime) {
            const [time, period] = inputTime.split(' ');
            const [hours, minutes] = time.split(':');
            let convertedHours = parseInt(hours);
            if (period === 'PM' && convertedHours !== 12) {
                convertedHours += 12;
            } else if (period === 'AM' && convertedHours === 12) {
                convertedHours = 0;
            }
            let convertFormat = `${convertedHours.toString().padStart(2, '0')}:${minutes}:00`;
            return convertFormat
        }
    };

    //  Finding Difference between start date and end date

    const findDayDifference = (date) => {
        let today = new Date().toJSON().slice(0, 10);
        var seletectedCellDate = new Date(date);
        // console.log(leave_data.custom_start_date);
        // console.log(leave_data.custom_end_date);
        // To calculate the time difference of two dates
        var Difference_In_Time = seletectedCellDate.getTime() - today.getTime();
        console.log("Differenece" + Difference_In_Time);

        // To calculate the no. of days between two dates
        var Difference_In_Days = (
            Difference_In_Time /
            (1000 * 60 * 60 * 24)
        ).toFixed(0);
        let total_days = Difference_In_Days;
        // console.log(total_days);
    }


    const getLocation = () => {
        bdcApi = bdcApi
            + "?latitude=" + position.coords.latitude
            + "&longitude=" + position.coords.longitude
            + "&localityLanguage=en";
        var locationApi = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=13.026586987757538&longitude=80.20477619620871&localityLanguage=en"
    }
    // Latitude: 13.026586987757538
    // Longitude: 80.20477619620871


    const disabledDecrementMonthForDunamis = () => {
        const client_code = localStorage.getItem('client_code')
        if (client_code === 'DM' || client_code === 'DMC') {
            return true
        } else {
            return false
        }
    }


    return {
        // Timesheet Data source
        getEmployeeAttendance, currentEmployeeAttendance, currentEmployeeAttendanceLength, getSelectedEmployeeOrgDetails,
        getTeamList, getOrgList, getSelectedEmployeeTeamDetails, getSelectedEmployeeAttendance,

        CurrentlySelectedUser,

        // Classic timesheet Sidebar

        classicTimesheetSidebar,

        currentlySelectedTeamMemberUserId,
        currentlySelectedTeamMemberAttendance,
        currentlySelectedOrgMemberUserId,
        currentlySelectedOrgMemberAttendance,
        currentlySelectedTimesheet,
        currentlySelectedCellRecord,
        canShowLoading, canShowApplyRegularizationLoading, canShowSidebar, isManager, isTeamOrg,


        // Finding Attendance Mode
        findAttendanceMode,

        // Attendance Regularization

        AttendanceLateOrMipRegularization, AttendanceEarylOrMopRegularization,
        //   MOP
        onClickShowLcRegularization, applyMopRegularization, mopDetails, dialog_Mop,
        //   MIP
        onClickShowEgRegularization, applyMipRegularization, mipDetails, dialog_Mip,
        //   LC
        onClickShowMipRegularization, applyLcRegularization, lcDetails, dialog_Lc,
        //   EG
        onClickShowMopRegularization, applyEgRegularization, egDetails, dialog_Eg,
        // Selfie
        dialog_Selfie, onClickSViewSelfie, selfieDetails, switchTimesheet,
        // Absent regularization
        absentRegularizationDetails, applyAbsentRegularization, classicAttendanceRegularizationDialog,

        // withdraw
        withdrawAttendanceRegularization,

        // user_code.
        selected_user_code,

        // Client code
        disabledDecrementMonthForDunamis,

        selectedyear,
        selectedMonth







    }
})
