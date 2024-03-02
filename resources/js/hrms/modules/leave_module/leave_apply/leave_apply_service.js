import { defineStore } from "pinia";
import { ref, reactive, inject } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import moment from "moment";
import { Service } from "../../Service/Service";
import {useAttendanceTimesheetMainStore} from "../../attendence/timesheet/stores/attendanceTimesheetMainStore";
import { useLeaveModuleStore } from "../LeaveModuleService";

import dayjs from "dayjs";
const swal = inject("$swal");


export const useLeaveService = defineStore("useLeaveService", () => {

    // Notification service
    const toast = useToast();
    const service = Service();
    const leave_apply_role_type = ref();
    const useLeaveModule = useLeaveModuleStore();

    const AttendanceTimesheetMainStore = useAttendanceTimesheetMainStore();

    // Variable Declarations
    const leave_data = reactive({
        current_login_user: "",
        selected_leave: "",
        full_day_leave_date: "",
        half_day_leave_date: "",
        half_day_leave_session: "",
        radiobtn_full_day: "",
        radiobtn_half_day: "",
        radiobtn_custom: "",
        custom_start_date: "",
        custom_start_day_session:'',
        custom_end_day_session:'',
        custom_end_date: "",
        custom_total_days: "",
        permission_date: "",
        permission_session:"",
        permission_start_time: "",
        permission_total_time: "",
        permission_total_time_in_minutes: 0,
        permission_end_time: "",
        compensatory_leaves: '',
        compensatory_leaves_dates: "",
        selected_compensatory_leaves: "",//This refers to comp days selected in dropdown
        compensatory_start_date: "",
        compensatory_total_days: "", //This refers to total days UI textbox
        compensatory_end_date: "",
        notifyTo: "",
        leave_reason: "",
        leave_request_error_message: ""
    });

    const leaveApplyDailog = ref(false)
    const TotalNoOfDays = ref(true);
    const full_day_format = ref(true);
    const half_day_format = ref(false);
    const custom_format = ref(false);
    const Permission_format = ref(false);
    const compensatory_format = ref(false);
    const invalidDates = ref();
    const leave_types = ref()
    let today = new Date();
    const RequiredField = ref(false);
    const data_checking = ref(false)
    const Email_Service = ref(false)
    const Email_Error = ref(false)

    const maxPermissionMinutes = 120;
    const isPermissionMinutesInvalid = ref(false);

    let invalidDate = new Date();
    invalidDate.setDate(today.getDate() - 1);
    invalidDates.value = [today, invalidDate];


    // compensatory leave


    const selected_compensatory_leaves = ref();
    //  const compensatory_leaves = ref([]);


    // Events

    const full_day = () => {
        leave_data.radiobtn_full_day == "full_day"
            ? (full_day_format.value = true)
            : (full_day_format.value = false);
        full_day_format.value = true;
        custom_format.value = false;
        Permission_format.value = false;
        half_day_format.value = false;
        compensatory_format.value = false;
    };

    const half_day = () => {
        leave_data.radiobtn_half_day == "half_day"
            ? (half_day_format.value = true)
            : (half_day_format.value = false);
        half_day_format.value = true;
        custom_format.value = false;
        Permission_format.value = false;
        full_day_format.value = false;
        compensatory_format.value = false;
    };
    const custom_day = () => {
        leave_data.radiobtn_custom == "custom"
            ? (custom_format.value = true)
            : (custom_format.value = false);
        custom_format.value = true;
        Permission_format.value = false;
        half_day_format.value = false;
        full_day_format.value = false;
        compensatory_format.value = false;
    };
    const dayCalculation = () => {
        if (custom_format.value == true) {
            if (
                leave_data.custom_start_date.length < 0 ||
                leave_data.custom_start_date == ""
            ) {
                toast.add({
                    severity: "info",
                    summary: "Info Message",
                    detail: "Select Start date",
                    life: 3000,
                });
            }
        }
        if (Permission_format.value == true) {
            if (
                leave_data.permission_start_time < 0 ||
                leave_data.permission_start_time == ""
            ) {
                toast.add({
                    severity: "info",
                    summary: "Info Message",
                    detail: "Select Start Time",
                    life: 3000,
                });
            }
        }
        // custom_date_validation();

        // Custom Day Calculations

        let Custom_date = new Date().toJSON().slice(0, 10);
        var Custom_date1 = new Date(leave_data.custom_start_date);
        console.log(leave_data.custom_start_date);
        var custom_date2 = new Date(leave_data.custom_end_date);
        console.log(leave_data.custom_end_date);
        if(leave_data.custom_start_date==='' && leave_data.custom_end_date==='')
        {
            leave_data.custom_total_days=''
        }
        // To calculate the time difference of two dates
        var Difference_In_Time = custom_date2.getTime() - Custom_date1.getTime();
        console.log("Differenece" + Difference_In_Time);

        // To calculate the no. of days between two dates
        var Difference_In_Days = (
            Difference_In_Time /
            (1000 * 60 * 60 * 24)
        ).toFixed(0);
        let total_custom_days = Difference_In_Days;
        console.log(total_custom_days);
        leave_data.custom_total_days = parseInt(total_custom_days) + 1;

        if(leave_data.custom_total_days<0)
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Choose correct start date and end date', life: 5000 });
            leave_data.custom_start_date=''
            leave_data.custom_end_date=''
            leave_data.custom_total_days=''

        }
        if(isNaN(leave_data.custom_total_days))
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Choose correct start date and end date', life: 5000 });
            leave_data.custom_start_date=''
            leave_data.custom_end_date=''
            leave_data.custom_total_days=''
        }
        console.log(leave_data.custom_total_days);

        // Compensatory Calculation

        var Compensatory_date1 = new Date(leave_data.compensatory_start_date);
        console.log(leave_data.compensatory_start_date);
        var Compensatory_date2 = new Date(leave_data.compensatory_end_date);
        console.log(leave_data.compensatory_end_date);
        // To calculate the time difference of two dates
        var Difference_In_Time = Compensatory_date2.getTime() - Compensatory_date1.getTime();
        console.log("Differenece" + Difference_In_Time);

        // To calculate the no. of days between two dates
        var Difference_In_Days = (
            Difference_In_Time /
            (1000 * 60 * 60 * 24)
        ).toFixed(0);
        let total_Compensatory_days = Difference_In_Days;
        console.log(total_Compensatory_days);
        leave_data.compensatory_total_days = parseInt(total_Compensatory_days) + 1;
        console.log(leave_data.compensatory_total_days);

    };

    const addHalfday =() =>{
       if(leave_data.custom_end_day_session === 'Forenoon' && Number.isInteger(leave_data.custom_total_days)){
         leave_data.custom_total_days += 0.5;
            console.log( leave_data.custom_total_days ,'add Forenoon ::');
        }
        else{
            Number.isInteger(leave_data.custom_total_days);
        }
    }

    const addFullday = () =>{
        if(leave_data.custom_end_day_session === 'Full day' && !Number.isInteger(leave_data.custom_total_days)){
            leave_data.custom_total_days -= 0.5;
               console.log( leave_data.custom_total_days ,' sub Forenoon ::');
           }
           else{
               Number.isInteger(leave_data.custom_total_days);
           }

    }

    const time_difference = () => {
        let selected_date = moment(leave_data.full_day_leave_date).format("YYYY-MM-DD");
        let start_time = leave_data.permission_start_time.toString();
        start_time = selected_date + ' ' + start_time.substring(16, 24);
        let end_time = leave_data.permission_end_time.toString();
        end_time = selected_date + ' ' + end_time.substring(16, 24);

        console.log();
        //console.log( start_time.substring(16,24));
        //console.log(selected_date );
        let t1 = new Date(leave_data.permission_start_time).getTime();
        let t2 = new Date(leave_data.permission_end_time).getTime();
        console.log("start" + t1, "end" + t2);

        var total_hours = ((t2 - t1) / 1000 / 60 / 60).toFixed(0);
        var total_minutes = ((t2 - t1) / 1000 / 60).toFixed(0);
        leave_data.permission_total_time = total_hours;
        leave_data.permission_total_time_in_minutes = total_minutes;
        console.log('Time duration : '+(t2 - t1)/1000 );
        console.log("Total Hours : "+total_hours);
        console.log("Total Minutes : "+total_minutes);
        if(leave_data.permission_start_time=='' && leave_data.permission_end_time=='')
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Choose start time and end time', life: 5000 });
            leave_data.permission_start_time=''
            leave_data.permission_end_time=''
            leave_data.permission_total_time_in_minutes=''
        }
        if(isNaN(leave_data.permission_total_time_in_minutes))
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Choose start time and end time', life: 5000 });
            leave_data.permission_start_time=''
            leave_data.permission_end_time=''
            leave_data.permission_total_time_in_minutes=''
        }
        if(leave_data.permission_total_time_in_minutes<0)
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Choose start time and end time', life: 5000 });
            leave_data.permission_start_time=''
            leave_data.permission_end_time=''
            leave_data.permission_total_time_in_minutes=''
        }
        if(leave_data.permission_total_time_in_minutes>120)
        {
            toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Total duration should not exceed 120 minutes', life: 5000 });
            leave_data.permission_start_time=''
            leave_data.permission_end_time=''
            leave_data.permission_total_time_in_minutes=''
        }
        // console.log('start '+ leave_data.start_time_for_permisson+'end '+ leave_data.end_time_for__for_permisson);
    };


    const Permission = () => {

        if (leave_data.selected_leave.includes("Permission")) {
            Permission_format.value = true;
            TotalNoOfDays.value = false;
            half_day_format.value = false;
            custom_format.value = false;
            compensatory_format.value = false;
            full_day_format.value = false;
        }
        else if (leave_data.selected_leave.includes('Compensatory')) {
            compensatory_format.value = true;
            Permission_format.value = false;
            full_day_format.value = false;
            half_day_format.value = false;
            custom_format.value = false;
            TotalNoOfDays.value = false;
            get_compensatroy_leaves();

            leave_data.compensatory_leaves_dates = moment(leave_data.compensatory_leaves.emp_attendance_date).format(`dddd DD-MMM-YYYY`);
            console.log("kn" + leave_data.compensatory_leaves.emp_attendance_date);

        } else if (leave_data.selected_leave == "Select") {
            compensatory_format.value = false;
            Permission_format.value = false;
            full_day_format.value = true;
            half_day_format.value = false;
            custom_format.value = false;
            TotalNoOfDays.value = true;
        } else {
            Permission_format.value = false;
            compensatory_format.value = false;
            TotalNoOfDays.value = true
            full_day_format.value = true
        }
    };


    const get_user = () => {

        // data_checking.value=true

        axios.get('/currentUser').then(res => {
            leave_data.current_login_user = res.data;
            data_checking.value = false;
        }).catch(err => {
            console.log(err);
        })

    }



    const get_leave_types = (user_code) => {

        axios.post('/fetch-leave-policy-details',{
            user_code:user_code
        }).then(res => {
            console.log(res.data);
            leave_types.value = res.data
        })
    }

   // check leave apply eligibility
 const check_leave_types=ref([])
 const check_full_day=ref(false)
 const check_half_day=ref(false)
 const check_custom_day=ref(false)
 const checkLeaveEligibility=async(selecedLeave,user_code)=>{
    console.log(selecedLeave)
  await  axios.post(`/fetch-leave-policy-details`,{
    user_code:user_code
  })
  .then(res => {
      res.data.map((element)=>{
        if(selecedLeave===element.leave_value)
        {
            if(element.is_finite===1)
            {
                if(element.leave_balance>1)
                {
                    console.log(true)
                    check_half_day.value=true;
                check_full_day.value=true;
                check_custom_day.value=true;

                }
               else if(element.leave_balance===1)
               {
                console.log(true)
                    check_half_day.value=true;
                check_full_day.value=true;
                check_custom_day.value=false;
               }
               else if(element.leave_balance===0.5)
               {
                console.log(true)
                check_half_day.value=true;
                check_full_day.value=false;
                check_custom_day.value=false;
               }
                else{
                    console.log(false)
                    toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Cannot able to apply Leave', life: 5000 });
                    leave_data.selected_leave = ''
                }
            }
            else{
                console.log(true)
                check_half_day.value=true;
                check_full_day.value=true;
                check_custom_day.value=true;
            }
        }
      })

    })
    .catch((err)=>{
        console.log(err)
    })

}
// calender date disabled
const attendance_start_date=ref()
const leave_restrict_dates=ref()
const before_date=ref()
const getLeaveRestrictDates=async()=>{
await axios.post(`/restrictedDaysForLeaveApply`,{
    "user_code": service.current_user_code,

})
.then((res)=>{
    console.log(res.data)
    attendance_start_date.value=new Date(res.data.attendance_start_date)
    before_date.value=new Date(attendance_start_date.value)
    before_date.value.setDate(attendance_start_date.value.getDate()+1)
    console.log(attendance_start_date.value,'Min date')
    console.log(before_date.value,'beforedate')
    leave_restrict_dates.value=res.data.restricted_days

})

}

const isRestrict=(selectedDate)=>{
    // if(leave_restrict_dates.includes(selectedDate))
    // {
    //     toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Cannot able to choose date', life: 5000 });
    //     leave_data.full_day_leave_date=''
    // }
    console.log(dayjs(selectedDate).format('YYYY-MM-DD'))
    let selectedLeaveDate=dayjs(selectedDate).format('YYYY-MM-DD');
    if(leave_restrict_dates.value.includes(selectedLeaveDate))
    {
              toast.add({ severity: 'warn', summary: 'Oops!', detail: 'Cannot able to choose date', life: 5000 });
        leave_data.full_day_leave_date=''
        leave_data.half_day_leave_date=''
        leave_data.custom_start_date=''
        leave_data.custom_end_date=''

    }
};

const custom_date_validation = () => {

    let attendance_timesheet = AttendanceTimesheetMainStore.currentlySelectedOrgMemberAttendance;
    console.log(attendance_timesheet, AttendanceTimesheetMainStore.currentEmployeeAttendance,'attendance_timesheet :: ');

    let val = '';

    let formatarray = [];

    for(let [array,key] of Object.entries(attendance_timesheet)){

        //  if(attendance_timesheet[array].date != dayjs(leave_data.custom_end_date).format('YYYY-MM-DD')){
        //     console.log(attendance_timesheet[array]);
        //     format.push(attendance_timesheet[array]);
        //  }else{
        //     break;
        //  }


        console.log( dayjs(leave_data.custom_start_date).format('YYYY-MM-DD') >= attendance_timesheet[array].date  &&  dayjs(leave_data.custom_end_date).format('YYYY-MM-DD') < attendance_timesheet[array].date);
        if(dayjs(leave_data.custom_start_date).format('YYYY-MM-DD') <= attendance_timesheet[array].date  && dayjs(leave_data.custom_end_date).format('YYYY-MM-DD') >= attendance_timesheet[array].date){
                    formatarray.push(attendance_timesheet[array]);
                 }
    }

    for(let [array,key] of Object.entries(formatarray)){

        console.log(formatarray[array].isAbsent);

        if(formatarray[array].isAbsent==true && formatarray[array].is_holiday == false && formatarray[array].is_week_off == false && formatarray[array].leave_status == null || formatarray[array].leave_status =='Rejected' && formatarray[array].absent_status =='Not Applied'  ){
            console.log(true);
        }else{
            val = true;
            leave_data.custom_end_date = '';
            console.log('custom_end_date::');
        }

    }

    if(val){
        toast.add({
            severity: "info",
            summary: "",
            detail: "",
            life: 3000,
        });
    }

    console.log(formatarray);

    // for(let [array,key] of Object.entries(attendance_timesheet)){
    //     // console.log(attendance_timesheet[array].date, dayjs(leave_data.custom_end_date).format('YYYY-MM-DD'));
    //      if(attendance_timesheet[array].date  > dayjs(leave_data.custom_end_date).format('YYYY-MM-DD')){
    //         console.log(attendance_timesheet[array] ,'::');
    //         // format.push(attendance_timesheet[array]);
    //      }else{
    //         break;
    //      }
    // }

    // for(format){

    // }

    // {absent_status,is_holiday,is_week_off,leave_status,absent_status};
    let selectedarray = [];

    console.log(dayjs(leave_data.custom_end_date).format('YYYY-MM-DD'),'leave_data.custom_end_date');






        // if(ele.absent_status == false || ele.is_holiday == false || ele.is_week_off == true || ele.leave_status == 'Not Applied' || ele.absent_status == null){
        //     console.log('2 second..');
        // }

    // })


}

    const get_compensatroy_leaves = async() => {

        let user_id = leave_data.current_login_user;
    await axios.get(`/fetch-employee-unused-compensatory-days`).then(res => {
            leave_data.compensatory_leaves = res.data
            console.log(leave_data.compensatory_leaves)

        }).catch(res => {
            console.log(res);
        })
    }

    // Request leave Events

    const leave_Request_data = reactive({
        leave_type_id: 1,
        leave_Request_date: moment().format('YYYY-MM-DD  HH:mm:ss'),
        leave_type_name: '',
        leave_session: '',
        start_date: '',
        end_date: '',
        no_of_days:'',
        hours_diff: '',
        notify_to: '',
        leave_reason: '',
        compensatory_leave_id: [],
        user_type : 'Employee', //Right now, its hard-coded. Later, we will assign "Admin or Employee" based on scenario
    })

    const ReloadPage = () => {
        location.reload();
    }

    // write Email service and axios service here

    const Submit = async (admin_or_users) => {


        //Leave applying logic happens here.

        leave_Request_data.leave_type_name = leave_data.selected_leave
        if (leave_data.radiobtn_full_day == "full_day") {
            console.log("Full day leave : " + leave_data.full_day_leave_date);
            leave_Request_data.no_of_days = 1
            //leave_Request_data.start_date = new Date(leave_data.full_day_leave_date).toISOString().slice(0,10)
            leave_Request_data.start_date = moment(leave_data.full_day_leave_date).format('YYYY-MM-DD');
            leave_Request_data.end_date = leave_Request_data.start_date
            leave_Request_data.leave_session = "";

        }
        else
            if (leave_data.radiobtn_half_day == "half_day") {
                console.log("Applying half-day leave on : " + leave_data.half_day_leave_date);
                leave_Request_data.no_of_days = 0.5;
                console.log("half day leave date" + leave_data.half_day_leave_date);
                leave_Request_data.start_date = moment(leave_data.half_day_leave_date).format('YYYY-MM-DD');
                leave_Request_data.end_date = leave_Request_data.start_date;

                if (leave_data.half_day_leave_session == "Forenoon") {
                    leave_Request_data.leave_session = "FN"
                }
                else
                    if (leave_data.half_day_leave_session == "Afternoon") {
                        leave_Request_data.leave_session = "AN"
                    }
                    else {
                        //No session selected, show error

                        toast.add({
                            severity: "info",
                            summary: "Select Session",
                            detail: "Select Leave Session",
                            life: 3000,
                        });

                        return;
                    }

            }
            else
                if (leave_data.radiobtn_custom == "custom") {
                    leave_Request_data.start_date = moment(leave_data.custom_start_date).format('YYYY-MM-DD');
                    leave_Request_data.end_date = moment(leave_data.custom_end_date).format('YYYY-MM-DD');
                    leave_Request_data.no_of_days = leave_data.custom_total_days
                    leave_Request_data.leave_session = "";

                }
                else
                    if (leave_data.selected_leave.includes('Compensatory')) {
                        leave_Request_data.start_date = moment(leave_data.compensatory_start_date).format('YYYY-MM-DD');
                        leave_Request_data.end_date = moment(leave_data.compensatory_end_date).format('YYYY-MM-DD');
                        leave_Request_data.no_of_days = leave_data.compensatory_total_days;

                        let value_selected_compensatory_leaves = Object.values(leave_data.selected_compensatory_leaves).length;
                        console.log("Selected Compensatory No.of days : " + leave_data.compensatory_total_days);
                        console.log("Selected Compensatory Leaves : " + value_selected_compensatory_leaves);

                        const find_compensatory_id = Object.values(leave_data.selected_compensatory_leaves);

                        //if textbox comp leave count != selected comp days in dropdown
                        //// TODO :  Need to check comp days based on 0.5 days also. Right it assumes as 1 day per comp day selected
                        if (parseInt(leave_data.compensatory_total_days) != value_selected_compensatory_leaves) {
                            toast.add({
                                severity: "info",
                                summary: "Error",
                                detail: "Compensatory leaves doesnt match with available leave days",
                                life: 3000,
                            });

                            return
                        }
                        else {

                            find_compensatory_id.map(data => {
                                let id = data.emp_attendance_id
                                leave_Request_data.compensatory_leave_id.push(id)
                                console.log(leave_Request_data.compensatory_leave_id);
                            })
                        }

                    } else
                        if (leave_data.selected_leave.includes('Permission')) {


                            leave_Request_data.start_date = `${dayjs(leave_data.permission_date).format('YYYY-MM-DD')}
                             ${dayjs(leave_data.permission_start_time ).format('HH:mm:ss ') }`;
                            console.log( leave_Request_data.start_date,' leave_Request_data.start_date');
                            leave_Request_data.end_date = `${dayjs(leave_data.permission_date).format('YYYY-MM-DD')}
                             ${dayjs(leave_data.permission_end_time).format('HH:mm:ss')} `;
                            leave_Request_data.hours_diff = leave_data.permission_total_time;


                        }
                        else {
                            toast.add({
                                severity: "info",
                                summary: "Info Message",
                                detail: "Select Leave",
                                life: 3000,
                            });
                        }


        leave_Request_data.notify_to = leave_data.notifyTo
        leave_Request_data.leave_reason = leave_data.leave_reason
        RequiredField.value = true;
        console.log(leave_Request_data);

        //show loading screen
        data_checking.value = true;



        // data_checking.value=true

        let url;

        // if( service.current_user_role == 2 && AttendanceTimesheetMainStore.CurrentlySelectedUser  )
        // {
        //     console.log(AttendanceTimesheetMainStore.CurrentlySelectedUser);
        //     url = `applyLeaveRequest_AdminRole`;

        //     axios.post(url, {
        //         "admin_user_code": service.current_user_code,
        //         "user_code":AttendanceTimesheetMainStore.CurrentlySelectedUser,
        //        "leave_request_date": leave_Request_data.leave_Request_date,
        //         "leave_type_name": leave_Request_data.leave_type_name,
        //         "leave_session": leave_Request_data.leave_session,
        //         "start_date": leave_Request_data.start_date,
        //         "end_date": leave_Request_data.end_date,
        //         "no_of_days": leave_Request_data.no_of_days,
        //         "hours_diff": leave_Request_data.hours_diff,
        //         "compensatory_work_days_ids": leave_Request_data.compensatory_leave_id,
        //         "notify_to": leave_Request_data.notify_to,
        //         "leave_reason": leave_Request_data.leave_reason,
        //         "user_type": leave_Request_data.user_type,
        //     }).then(res => {
        //         data_checking.value = false
        //         console.log(res.data.messege);
        //         if (res.data.status == 'success') {
        //             Swal.fire(
        //                 'Success',
        //                 res.data.message,
        //                 'success'
        //             )

        //         }
        //         if (res.data.status == 'failure') {
        //             Swal.fire(
        //                 'Failure',
        //                 res.data.message,
        //                 'error'
        //             )
        //         }

        //         console.log("Email status" + res.data.status);

        //     }).catch(err => {
        //         console.log(err);
        //     }).finally(() => {
        //         restChars();

        //         leaveApplyDailog.value = false

        //     })


        //  }else{
console.log(admin_or_users);

        url = admin_or_users == 'applyleave' ?  `/applyLeaveRequest` : `/applyLeaveRequest_AdminRole`;

        axios.post(url, {
            "admin_user_code" : admin_or_users == 'applyleave' ? ' ' : service.current_user_code,
            "user_code":  admin_or_users == 'applyleave' ?  service.current_user_code : AttendanceTimesheetMainStore.selected_user_code,
           "leave_request_date": leave_Request_data.leave_Request_date,
            "leave_type_name": leave_Request_data.leave_type_name,
            "leave_session": leave_Request_data.leave_session,
            "start_date": leave_Request_data.start_date,
            "end_date": leave_Request_data.end_date,
            "no_of_days": leave_Request_data.no_of_days,
            "hours_diff": leave_data.permission_total_time_in_minutes,
            // "hours_diff": leave_Request_data.hours_diff,
            "compensatory_work_days_ids": leave_Request_data.compensatory_leave_id,
            "notify_to": leave_Request_data.notify_to,
            "leave_reason": leave_Request_data.leave_reason,
            "user_type": leave_Request_data.user_type,
        }).then(res => {
            data_checking.value = false
            console.log(res.data.messege);
            if (res.data.status == 'success') {
                Swal.fire(
                    'Success',
                    res.data.message,
                    'success'
                )

            }
            if (res.data.status == 'failure') {
                Swal.fire(
                    'Failure',
                    res.data.message,
                    'error'
                )
            }

            console.log("Email status" + res.data.status);

        }).catch(err => {
            console.log(err);
        }).finally(() => {
            useLeaveModule.getTermLeaveBalance();
            // useLeaveModule.getEmployeeLeaveHistory();
            restChars();
            AttendanceTimesheetMainStore.getEmployeeAttendance(AttendanceTimesheetMainStore.selected_user_code,AttendanceTimesheetMainStore.selectedMonth,AttendanceTimesheetMainStore.selectedyear);

            if (AttendanceTimesheetMainStore.currentlySelectedTimesheet == 1) {
                AttendanceTimesheetMainStore.getSelectedEmployeeAttendance(AttendanceTimesheetMainStore.selected_user_code);

            } else
                if (service.current_user_role == 1 || service.current_user_role == 2) {
                    if (AttendanceTimesheetMainStore.currentlySelectedTimesheet == 2) {
                        getSelectedEmployeeTeamDetails(AttendanceTimesheetMainStore.selected_user_code, true)

                    } else
                        if (AttendanceTimesheetMainStore.currentlySelectedTimesheet == 3) {
                            AttendanceTimesheetMainStore.getSelectedEmployeeOrgDetails(AttendanceTimesheetMainStore.selected_user_code, false, AttendanceTimesheetMainStore.selected_user_code)
                        }
                }


            leaveApplyDailog.value = false;
            AttendanceTimesheetMainStore.canShowApplyRegularizationLoading = false;
            // AttendanceTimesheetMainStore
        })




        // }



    };



    const restChars = () =>{
        leave_data.current_login_user = null,
        leave_data.selected_leave = '',
        leave_data.full_day_leave_date = '',
        leave_data.half_day_leave_date = '',
        leave_data.half_day_leave_session = '',
        leave_data.radiobtn_full_day = '',
        leave_data.radiobtn_half_day = '',
        leave_data.radiobtn_custom = '',
        leave_data.custom_start_date = '',
        leave_data.custom_end_date = '',
        leave_data.custom_total_days = '',
        leave_data.permission_date = '',
        leave_data.permission_start_time = '',
        leave_data.permission_total_time = '',
        leave_data.permission_total_time_in_minutes = 0,
        leave_data.permission_end_time = '',
        leave_data.compensatory_leaves = '',
        leave_data.compensatory_leaves_dates = '',
        leave_data.selected_compensatory_leaves = '',//This refers to comp days selected in dropdown
        leave_data.compensatory_start_date = '',
        leave_data.compensatory_total_days = '', //This refers to total days UI textbox
        leave_data.compensatory_end_date = '',
        leave_data.notifyTo = '',
        leave_data.leave_reason = '',
        leave_data.leave_request_error_message = null
        leave_data.custom_start_day_session=''
        leave_data.custom_end_day_session=''
    }

    return {

        // Variable Declaration
        leaveApplyDailog,
        leave_data,
        invalidDate,
        today,
        invalidDates,
        toast,
        leave_Request_data,
        leave_types,
        data_checking,
        Email_Service,
        Email_Error,
        selected_compensatory_leaves,
        attendance_start_date,
        leave_restrict_dates,
        before_date,

        // interconnect with leave module and timesheet module
        leave_apply_role_type,

        // custom_start_day_session,
        // custom_end_day_session,


        // Events
        half_day,
        full_day,
        custom_day,
        Permission,
        Submit,
        ReloadPage,
        dayCalculation,
        time_difference,
        get_user,
        get_leave_types,
        get_compensatroy_leaves,
        checkLeaveEligibility,
        getLeaveRestrictDates,
        isRestrict,
        restChars,
        addHalfday,
        addFullday,



        // Boolean values
        full_day_format,
        half_day_format,
        custom_format,
        Permission_format,
        compensatory_format,
        TotalNoOfDays,
        RequiredField,
        check_custom_day,
        check_full_day,
        check_half_day,

        custom_date_validation
    };
});
