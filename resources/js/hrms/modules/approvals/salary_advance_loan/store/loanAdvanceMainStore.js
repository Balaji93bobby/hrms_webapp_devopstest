import { defineStore } from "pinia";
import { ref, reactive, onMounted , inject } from "vue";
import axios from "axios";



export const UseSalaryAdvanceApprovals = defineStore('SalaryAdvanceApprovals', () => {

    // variables
    const arraySalaryAdvance = ref();
    const currentlySelectedStatus = ref();
    const canShowLoadingScreen = ref(false);

    const swal = inject('$swal')

    const Request_comments = ref();

    // functions

    const salaryAdvance =reactive({
    });

    async function getEmpDetails() {
        canShowLoadingScreen.value = true;
        // let url = "/SalAdvApproverFlow";
         let url = "/SalAdvApproverFlow";
        await axios.get(url).then((res) => {
            arraySalaryAdvance.value = res.data;
        }).finally(() => {
            canShowLoadingScreen.value = false;
        })
    }

    // salary Advance bulk submit button
    async function SAbulkApproveAndReject(Status, val) {
        canShowLoadingScreen.value = true;

        currentlySelectedStatus.value = Status;
        let data = val;
        await axios.post('http://localhost:3000/submitApproveAndReject', {
            record_id: data,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            reviewer_comments: "",
        }).then(() => {
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })
    }

    // salary advance datatable btn Approval and Rejected

    async function SAapproveAndReject(val, Status,reviewer_comments) {
        currentlySelectedStatus.value=Status;
        let status = Status
        canShowLoadingScreen.value = true;

        let data = val.id;
        await axios.post('/rejectOrApprovedSaladv', {
            record_id: data,
            status:
            status == 1 ? 1
            : status == -1 ? -1
                        : status,
            reviewer_comments: reviewer_comments,
        }).then((res) => {
               res.data.status == 'success' ?  Swal.fire("Success",res.data.message,"success") : Swal.fire("Failure",res.data.message,"error")
        }).finally(()=>{

            canShowLoadingScreen.value = false;
        })

    }


    // Interest free loan function and variables

    const arrayIFL_List = ref();

    async function getInterestFreeLoanDetails(){
        canShowLoadingScreen.value = true;
        arrayIFL_List.value = ""
         axios.post('/fetch-employee-for-loan-approval',{
              loan_type:"InterestFreeLoan",
        }).then((res)=>{
            arrayIFL_List.value = res.data
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })
    };

    // Interest free loan Datatable function Approval and Rejected

    async function IFLapproveAndReject(val, Status,reviewer_comments) {
        let status = Status
        canShowLoadingScreen.value = true;
        let data = val.id;
        await axios.post('/reject-or-approve-loan', {
            loan_type : 'InterestFreeLoan',
            record_id: data,
            status:
            status == 1
                    ? 1
                    : status == -1
                        ? -1
                        : status,
            reviewer_comments: reviewer_comments,
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })

    }

    //  Interest free loan function bulk approval button

    async function IFLbulkApproveAndReject(Status, val) {
        canShowLoadingScreen.value = true;
        currentlySelectedStatus.value = Status;
        let data = val;
        await axios.post('http://localhost:3000/submitApproveAndReject', {
            record_id: data,
            status:
                currentlySelectedStatus == "Approve"
                    ? "Approved"
                    : currentlySelectedStatus == "Reject"
                        ? "Rejected"
                        : currentlySelectedStatus,
            reviewer_comments: "",
        }).then(() => {
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })
    }

    // interest with loan

    const arrayIWL = ref();

    async function getInterestWithLoanDetails(){
        canShowLoadingScreen.value = true;
        let url = `/fetch-employee-for-loan-approval`;
    await  axios.post(url,{
            loan_type:"InterestWithLoan",
        }).then((res)=>{
            arrayIWL.value = res.data;
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })
    }

    async function IWL_ApproveAndReject(val, Status,reviewer_comments){
        canShowLoadingScreen.value = true;
        let status = Status
        let data = val.id;
        await axios.post('/reject-or-approve-loan', {
            loan_type : 'InterestWithLoan',
            record_id: data,
            status:
            status == 1
                    ? 1
                    : status == -1
                        ? -1
                        : status,
            reviewer_comments: reviewer_comments,
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })

    }







    return {
        // Salary Advance
        salaryAdvance,
        arraySalaryAdvance,
        currentlySelectedStatus
        ,Request_comments,
        canShowLoadingScreen

        // function
        ,getEmpDetails,
        SAbulkApproveAndReject,
        SAapproveAndReject,

        // interest free loan
        arrayIFL_List,

        //  functions
        getInterestFreeLoanDetails,
        IFLapproveAndReject,
        IFLbulkApproveAndReject,

        // interest with loan function and variables
        arrayIWL,
        getInterestWithLoanDetails,
        IWL_ApproveAndReject


    }

});

