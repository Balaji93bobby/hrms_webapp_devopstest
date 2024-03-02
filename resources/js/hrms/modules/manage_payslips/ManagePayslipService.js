import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";
import dayjs from "dayjs";

export const useManagePayslipStore = defineStore("managePayslipStore", () => {


    // Variable Declarations
    const array_employees_list = ref()
    const selectedPayRollDate = ref()
    const paySlipHTMLView = ref()
    const loading = ref(false);
    const enable_select_calendar = ref();

    // Events
    async function getAllEmployeesPayslipDetails(month, year) {
        loading.value = true
        //reset the var
        array_employees_list.value = '';

        await axios.post('/payroll/paycheck/getAllEmployeesPayslipDetails', {
            month: month,
            year: year,
            type:"pdf"
        }).then((response) => {
            // console.log("Response [getAllEmployeesPayslipDetails] : " + JSON.stringify(response.data.data));
            array_employees_list.value = response.data.data;
        }).finally(() => {
            loading.value = false
        });
    }

    async function getEmployeePayslipDetailsAsHTML(user_code, month, year) {
        loading.value = true

        // let url = `/generatePayslip`;
        let url = `/viewPayslipdetails`;

        await axios.post(url, {
            user_code: user_code,
            month: month,
            year: year,
            type:'pdf'
        }).then((response) => {
            // console.log("Response [getEmployeePayslipDetailsAsHTML] : " + JSON.stringify(response.data.data));
            paySlipHTMLView.value = response.data;

        }).finally(() => {
            loading.value = false
        });

    }

    async function getEmployeePayslipDetailsAsPDF(user_code, month, year) {
        loading.value = true

        await axios.post('/payroll/paycheck/getEmployeePayslipDetailsAsPDF', {
            user_code: user_code,
            month: month,
            year: year
        }).then((response) => {
            // console.log("Response [getEmployeePayslipDetailsAsHTML] : " + JSON.stringify(response.data.data));

           // paySlipHTMLView.value = response.data;

        }).finally(() => {
            loading.value = false
        });

    }

    async function sendMail_employeePayslip(user_code, month, year) {
        console.log("sendMail_employeePayslip() : Sending mail to user : " + user_code);

        loading.value = true

        // show_dialogconfirmation.value= false;

        axios.post('/generatePayslip', {
            user_code: user_code,
            month: month,
            year: year,
            type:'mail'
        }).then((response) => {
            console.log(" Response [sendMail_employeePayslip] : " + response.data);
        })
            .catch((data) => {
                console.log(data);

            }).finally(()=>{
                loading.value = false
            })

    }


    async function updatePayslipReleaseStatus(user_code, month, year, status) {
        console.log("updatePayslipReleaseStatus() : Updating releasepayslip status to user : " + user_code);

        // show_dialogconfirmation.value= false;

        let selectedDate = new Date(selectedPayRollDate.value)
        axios.post('/payroll/paycheck/updatePayslipReleaseStatus', {
            user_code: user_code,
            month: month,
            year: year,
            status: status
        }).then((response) => {
            console.log(" Response [updatePayslipReleaseStatus] : " + response.data.data);
        })
            .catch((response) => {
                console.log(response.data.data);

            }).finally(() => {
                getAllEmployeesPayslipDetails(selectedDate.getMonth() + 1, selectedDate.getFullYear())
            })

    }
    async function UpdateWithDrawStatus(user_code, month, year,status){
        console.log("UpdateWithDrawStatus() : Updating withdraw :", user_code);

        let selectedDate = new Date(selectedPayRollDate.value)
        axios.post('/payroll/paycheck/updatePayslipReleaseStatus', {
            user_code: user_code,
            month: month,
            year: year,
            status: status
        }).then((response) => {
            console.log(" Response [updatePayslipReleaseStatus] : " + response.data.data);
        })
            .catch((response) => {
                console.log(response.data.data);

            }).finally(() => {
                getAllEmployeesPayslipDetails(selectedDate.getMonth() + 1, selectedDate.getFullYear())
            })

    }

    function downloadFileObject(base64String,employeeName ,payslipyear,payslipMonth) {
        const linkSource = base64String;
        const downloadLink = document.createElement("a");
        const fileName = `${employeeName}-${payslipyear}-${payslipMonth}.pdf`;
        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        downloadLink.click();
    }

    async function downloadPayslip(user_code, month, year, status) {

        // show_dialogconfirmation.value= false;

        console.log("Downloading payslip PDF.....");

        loading.value = true;
        // let month_payroll = parseInt(dayjs(payroll_month).month()) + 1;
        // let year_payroll = dayjs(payroll_month).year();

        //split the payroll_month into month and year

        await axios.post('/generatePayslip',
            {
                user_code: user_code,
                month: month,
                year: year,
                type:'pdf'
            }).then((response) => {
                //  console.log("Response [getEmployeePayslipDetailsAsPDF] : " + response.data.data);
                console.log(" Response [downloadPayslipReleaseStatus] : " + JSON.stringify(response.data.data));

                if(response.data){
                    let base64String = response.data.data.payslip;
                    let employeeName = response.data.data.emp_name
                    let payslipMonth = response.data.data.month;
                    let payslipyear = response.data.data.year;
                    console.log(base64String);
                    if(base64String){
                        if (base64String.startsWith("JVB")) {
                            base64String = "data:application/pdf;base64," + base64String;
                            downloadFileObject(base64String,employeeName,payslipMonth,payslipyear);
                        } else if (base64String.startsWith("data:application/pdf;base64")) {
                            downloadFileObject(base64String);
                        }
                    }
                }else{
                    console.log("Response Url Not Found");
                }



            }).finally(()=>{
                loading.value = false;
            })

    }


    function viewpayslipv2(){

    }



    return {

        // Varaible Declartion

        array_employees_list, paySlipHTMLView, selectedPayRollDate, loading,enable_select_calendar,

        // Functions
        getAllEmployeesPayslipDetails, getEmployeePayslipDetailsAsHTML, sendMail_employeePayslip, updatePayslipReleaseStatus,downloadPayslip,UpdateWithDrawStatus,getEmployeePayslipDetailsAsPDF

    };
});
