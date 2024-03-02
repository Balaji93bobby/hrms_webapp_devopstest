import { defineStore } from "pinia";
import { reactive, ref,inject } from "vue";
import axios from "axios";
import dayjs from "dayjs";
import { Service } from '../Service/Service'
// import { swal } from "sweetalert2/dist/sweetalert2";
import { useToast } from "primevue/usetoast";
const swal = inject("$swal");
// import { useLeaveService } from "./leave_apply/leave_apply_service";
// const leaveservice=useLeaveService()
export const useLeaveModuleStore = defineStore("useLeaveModuleStore", () => {
    const toast = useToast();
    const service = Service()

    const canShowLoading = ref(true)

    //Leave history vars
    const array_employeeLeaveBalance = ref()
    const array_employeeAvailedLeaveBalance = ref()
    const array_employeeLeaveHistory = ref();
    const array_teamLeaveHistory = ref();
    const array_orgLeaveHistory = ref();
    const array_orgLeaveBalance = ref();
    const selectedStartDate = ref();
    const selectedEndDate = ref();
    const canshowloadingsrceen = ref();
    const arrayTermLeaveBalance = ref();

    const selected_LeaveInformation = ref();
    const canShowLeaveDetails = ref(false);

        // financial year dropdown data
        const financial_year = ref('');
        const financial_year_leave_dropdown = ref();

    // const


    const setLeaveDetails = ref({})

    const getLeaveDetails = (leaveDetails) => {
        canShowLeaveDetails.value = true
        console.log(leaveDetails);
        setLeaveDetails.value = { ...leaveDetails }
        setLeaveDetails.emp_name = leaveDetails.name

    }

    async function getEmployeeLeaveBalance(id) {
        canShowLoading.value = true
        let url_leave_balance = `/get-employee-leave-balance`
        await axios.post(url_leave_balance,{
            id:id
        }).then(res => {
            console.log(res.data);
            array_employeeLeaveBalance.value = res.data
            array_employeeAvailedLeaveBalance.value = res.data["Avalied Leaves"]
        }).finally(() => {
            canShowLoading.value = false
        })
    }
    const withdraw_comment=ref('')
    async function performLeaveWithdraw(leave_id) {

        // leaveservice.data_checking = true;
        await axios.post('/leave/withdrawLeave', {
            leave_id: leave_id,
            withdraw_comment:withdraw_comment.value,
        }).then((res) => {
            // leaveservice.data_checking = false;
            Swal.fire({
                title: res.data.status,
                text: res.data.message,
                icon: res.data.status == 'failure' ?  "warning" : 'success',
            })
            canShowLeaveDetails.value = false
            console.log("performLeaveWithdraw() : " + res.data);
        }).finally(() => {
            canShowLoading.value = false
        });

    }


    async function getEmployeeLeaveHistory(filter_month, filter_year, filter_leave_status) {
       
        let user_code = 0;
        // 
        canShowLoading.value = true

        await axios.get(window.location.origin + "/currentUserCode ").then((response) => {
            user_code = response.data;
        });


        await axios.post('/attendance/getEmployeeLeaveDetails', {
            user_code: user_code,
            filter_month: filter_month,
            filter_year: filter_year,
            filter_leave_status: filter_leave_status,

        }).then((response) => {
            array_employeeLeaveHistory.value = response.data.data;
            console.log("getEmployeeLeaveHistory() : " + response.data);
        }).finally(() => {
            canShowLoading.value = false
        });

    }


    async function getTeamLeaveHistory(filter_month, filter_year, filter_leave_status) {


        let user_code = 0;

        await axios.get(window.location.origin + "/currentUserCode ").then((response) => {
            user_code = response.data;
        });



        axios.post('/attendance/getTeamEmployeesLeaveDetails', {
            manager_code: user_code,
            filter_month: filter_month,
            filter_year: filter_year,
            filter_leave_status: filter_leave_status
        }).then((response) => {
            array_teamLeaveHistory.value = response.data.data;
            console.log("getTeamLeaveHistory() : " + response.data);
        }).finally(() => {
            canShowLoading.value = false
        });

    }

    async function getAllEmployeesLeaveHistory(filter_month, filter_year, filter_leave_status) {
        axios.post('/attendance/getAllEmployeesLeaveDetails', {
            filter_month: filter_month,
            filter_year: filter_year,
            filter_leave_status: filter_leave_status
        }).then((response) => {
            array_orgLeaveHistory.value = response.data.data;
            console.log("getOrgLeaveHistory() : " + response.data.data);
        }).finally(() => {
            canShowLoading.value = false
        });

    }

    const revoking_comment=ref('')    
    async function revokeLeaveRequest(record_id) {

        canShowLoading.value = false;

        //$record_id, $approver_user_code, $status, $user_type, $review_comment,
        axios.post(window.location.origin + "/attendance-approve-rejectleave", {
            record_id: record_id,
            approver_user_code: service.current_user_code,
            status: "Revoked",
            // user_type: "Manager",
            review_comment: revoking_comment.value,
        })
        .then((res) => {
           
            Swal.fire({
                title: res.data.status =="success"?  "Success" :  "Oops!",
                text: res.data.message,
                icon:  res.data.status == "success" ? "success" :"error",
            })
 
                // Swal.fire({
                //     title: "Oops!",
                //     text: response.data.message,
                //     icon: "warning"
                // })
  

        })
        .catch((error) => {
            canShowLoading.value = false;
            console.log(error.toJSON());
        }).finally(() => {
            canShowLoading.value = false

        });

    }

    /*
        Get the leave details of a particular leave record_id
    */
    async function getLeaveInformation(record_id) {
        // canShowLoading.value = true
        axios.post('/attendance/getLeaveInformation', {
            record_id: record_id

        }).then((response) => {
            selected_LeaveInformation.value = response.data.data;
            console.log("getLeaveInformation() : " + response.data);
        }).finally(() => {
            canShowLoading.value = false
        });

    }

    // Get Org Leave Balance details
    const selectedOrgDate= ref(new Date());
    
    async function getOrgLeaveBalance(data) {
        // canShowLoading.value = true;

        await axios.post('/fetch-org-leaves-balance',{
            id:data
            // date:  dayjs(date).format('DD/MM/YYYY')
        }).then((res) => {
            array_orgLeaveBalance.value = res.data;
        }).finally(() => {
            canShowLoading.value = false;

            // selectedStartDate.value ='';
            // selectedEndDate.value ='';

        });
    }
    const org_start_date=ref()
    const org_end_date=ref()
    const selected_org_date=ref()
    function getOrgLeaveBalFilter()
    {
        financial_year_leave_dropdown.value.map((element)=>{
            if(element.id==financial_year.value)
            {
                org_start_date.value=element.start_date
                org_end_date.value=element.end_date
            }
        })
        selected_org_date.value=dayjs(selectedOrgDate.value).format('YYYY-MM-DD')
        isOrgWithinRange(org_start_date.value,org_end_date.value,selected_org_date.value)
  
    }
    async function isOrgWithinRange(start,end,selected)
    {
        console.log(start,end,selected)
        if(selected>=start && selected<=end)
        {
            let url_leave_balance = `/fetch-org-leaves-balance`
            await axios.post(url_leave_balance,{
              id:financial_year.value,
             month:selected
            }).then(res => {
                console.log(res.data);
                array_orgLeaveBalance.value = res.data;
            }).finally(() => {
                canShowLoading.value = false
            })
        }
        else
        {
            console.log('false')
            toast.add({ severity: 'warn', summary: 'Oops', detail: 'choose month between financial year', life: 3000 });
            selectedOrgDate.value=new Date()
        }
    }

    const selectedTeamDate=ref('')
    async function getTermLeaveBalance(data) {
        // canShowLoading.value = true;
    await   axios.post('/fetch-team-leave-balance', {
            // date:  dayjs(date).format('DD/MM/YYYY')
            id:data
        }).then((res) => {
            arrayTermLeaveBalance.value = res.data;

        }).finally(() => {
            // selectedStartDate.value ='';
            // selectedEndDate.value ='';
            canShowLoading.value = false;
        })
    }
    const team_fy_start=ref('')
    const team_fy_end=ref('')
    const selected_team_date=ref('')
     function getTeamLeaveBalFilter ()
    {
        financial_year_leave_dropdown.value.map((element)=>{
            if(element.id==financial_year.value)
            {
                team_fy_start.value=element.start_date
                team_fy_end.value=element.end_date
            }
        })
        selected_team_date.value=dayjs(selectedTeamDate.value).format('YYYY-MM-DD')
        isTeamWithinRange(team_fy_start.value,team_fy_end.value,selected_team_date.value)
    }
    async function isTeamWithinRange(start,end,selected)
    {
        console.log(start,end,selected)
        if(selected>=start && selected<=end)
        {
            let url_leave_balance = `/fetch-team-leave-balance`
            await axios.post(url_leave_balance,{
              id:financial_year.value,
             month:selected
            }).then(res => {
                console.log(res.data);
                arrayTermLeaveBalance.value = res.data;
            }).finally(() => {
                canShowLoading.value = false
            })
        }
        else
        {
            console.log('false')
            toast.add({ severity: 'warn', summary: 'Oops', detail: 'choose month between financial year', life: 3000 });
            selectedLeaveMonth.value=new Date()
        }
    }
    function clearfunction(){
        selectedStartDate.value =''
         selectedEndDate.value ='';
         console.log( ' this variable is cleared ::',selectedEndDate.value , selectedStartDate.value);

    }

    const getFinancialYearDropdown=async()=>{
        await axios.get('/get-financial-years')
        .then((res)=>{
           console.log(res.data.data,'get-financial-years')
           financial_year_leave_dropdown.value=res.data.data
           res.data.data.map(({status,id})=>{
            if(status==1){
                financial_year.value=id;}
           })
        })
        .catch((err)=>{
            console.log(err)
        })
    }
 // notify dropdown get function
 const leave_notify_to_dropdown=ref([])
 const getLeaveNotifyDropdown=async()=>{
  let url =  window.location.origin + '/' +'api/leave/getLeaveNotifyToList'
  await axios.post(url,{
      user_code: service.current_user_code
  })
  .then((res)=>{
      console.log(res.data.data)
      leave_notify_to_dropdown.value=res.data.data
  })
  .catch((err)=>{
      console.log(err)
  })
 }
 const selectedLeaveMonth=ref()
 const fy_start_date=ref('')
 const fy_end_date=ref('')
const selected_leave_bal_date=ref('')
 function leaveBalMonthFilter()
 {
    financial_year_leave_dropdown.value.map((element)=>{
        if(element.id==financial_year.value)
        {
            fy_start_date.value=element.start_date
            fy_end_date.value=element.end_date
        }
    })
   selected_leave_bal_date.value= dayjs(selectedLeaveMonth.value).format('YYYY-MM-DD')
    isWithinRange(fy_start_date.value,fy_end_date.value,selected_leave_bal_date.value)
    // console.log(selectedLeaveMonth.value)
 }
 async function isWithinRange(start,end,selected)
 {
    // console.log(selected,start,end)
    if(selected>=start && selected<=end)
    {
        let url_leave_balance = `/get-employee-leave-balance`
        await axios.post(url_leave_balance,{
          id:financial_year.value,
         month:selected
        }).then(res => {
            console.log(res.data);
            array_employeeLeaveBalance.value = res.data
            array_employeeAvailedLeaveBalance.value = res.data["Avalied Leaves"]
        }).finally(() => {
            canShowLoading.value = false
        })
    }
    else
    {
        console.log('false')
        toast.add({ severity: 'warn', summary: 'Oops', detail: 'choose month between financial year', life: 3000 });
        selectedLeaveMonth.value=new Date()
    }
 }
 // check leave apply eligibility
 const check_leave_types=ref([])
 const checkLeaveEligibility=async(selecedLeave)=>{

  await  axios.get('/fetch-leave-policy-details')
  .then(res => {
   
      res.data.map((element)=>{
        if(selecedLeave===element.leave_type)
        {
            if(element.is_finite===1)
            {
                if(element.leave_balance>=1)
                {
                    console.log('finite 1 true')
                }
                else{
                    // Swal.fire({
                    //     title: "Oops",
                    //     text: "Cannot able to apply Leave",
                    //     icon: "warning"
                    // }).then((result)=>{

                    // })
                    toast.add({ severity: 'warn', summary: 'Oops', detail: 'Cannot able to apply Leave', life: 3000 });


                }
            }
            else{
                leave
                toast.add({ severity: 'warn', summary: 'Oops', detail: 'Cannot able to apply Leave', life: 4000 })
            }
        }
      })
        
    })
    .catch((err)=>{
        console.log(err)
    })
    

 }
    return {

        canShowLoading, canShowLeaveDetails, setLeaveDetails, getLeaveDetails,

        array_employeeLeaveHistory, array_teamLeaveHistory, array_orgLeaveHistory, array_employeeLeaveBalance, array_employeeAvailedLeaveBalance, array_orgLeaveBalance,
        selectedStartDate, selectedEndDate,
        canshowloadingsrceen,

        arrayTermLeaveBalance,leave_notify_to_dropdown,

        //

        // Functions
        performLeaveWithdraw,

        getEmployeeLeaveHistory, getTeamLeaveHistory, getAllEmployeesLeaveHistory,revokeLeaveRequest, getLeaveInformation, getEmployeeLeaveBalance,
        // org leave Balance functions
        getOrgLeaveBalance,getLeaveNotifyDropdown,selectedOrgDate,getOrgLeaveBalFilter,isOrgWithinRange,org_start_date,org_end_date,selected_org_date,

        // TermLeaveBalance
        getTermLeaveBalance,selectedTeamDate,team_fy_end,team_fy_start,selected_team_date,getTeamLeaveBalFilter,

        // clear start date and end date function
        clearfunction,
        // financialyear
        getFinancialYearDropdown,financial_year_leave_dropdown,financial_year,
        
        checkLeaveEligibility,check_leave_types,

        revoking_comment,withdraw_comment,

        selectedLeaveMonth,leaveBalMonthFilter,selected_leave_bal_date,fy_end_date,fy_start_date,
        

    };
});
