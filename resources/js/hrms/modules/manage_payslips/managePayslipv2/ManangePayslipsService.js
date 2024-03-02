import { defineStore } from "pinia";
import { ref, reactive, inject } from "vue";
import axios from "axios";
import dayjs from "dayjs";
import { Service } from "../../Service/Service";

export const useManagePayslip = defineStore('useManagePayslip', () => {

    const manage_payslips_details = ref();

    const service = Service();
    const selectedDate = ref()
    const businessUnit = ref();
    const departments = ref();
    const getlocation = ref();
    const selected_Location = ref([]);
    const clientList = ref();
    const selectedDetails = ref();
    const swal = inject('$swal');
    const enable_select_calendar = ref();

    // This variable used form enable button color...

    const Enable_btn = ref(1);

    async function getManagePayslipDetails(select_month, select_year) {

        let url = window.location.origin + "/payroll/paycheck/getAllEmployeesPayslipDetails_v2"
        axios.post(url, {
            month: select_month,
            year: select_year
        }).then((res) => {
            manage_payslips_details.value = res.data.data;
            console.log(res.data);
            if (res.data.data.length <= 0) {
                Swal.fire({
                    title: "No employees found in this category",
                    text: '',
                    // "Salary Advance Succesfully",
                    icon: "warning",
                }).then((res) => {
                });
            }

        })
    }

    async function getLocationDetails() {
        let format = {};

        axios.get('/fetch-location').then((res) => {
            // location.value = res.data;
            getlocation.value = res.data;
            console.log(getlocation.value);
        })
    }

    async function getClientDetails() {
        axios.get('/clients-fetchAll').then(res => {
            clientList.value = res.data;
        }).finally(() => {
        });

    }



    function send_payslip_request(selectedProduct, type) {

        if (selectedProduct) {
            Enable_btn.value = selectedProduct
        }
        // console.log(selectedProduct);-MM-DD

        let formdata = selectedProduct.map(({ Payroll_month, Employee_code }) => ({ month: dayjs(Payroll_month).format('MM'), year: dayjs(Payroll_month).format('YYYY'), status: type, user_code: Employee_code }));
        let url = window.location.origin + "/payroll/paycheck/updatePayslipReleaseStatus";
        axios.post(url, formdata).then((res) => {
            // manage_payslips_details.value=res.data.data;
            console.log(res.data);

            if (type===1) {
                if (res.data.status == 'success') {
                    Swal.fire({
                        title: "",
                        text: "Employee's payslip has been released",
                        // "Salary Advance Succesfully",
                        icon: "success",
                    }).then(()=>{
                        // selectedDetails.value='';
                    })
                }
            }
            else if(type== 0){
                if (res.data.status == 'success') {
                    Swal.fire({
                        title: "success",
                        text: "Employee's payslip has been Hold Back",
                        // "Salary Advance Succesfully",
                        icon: "success",
                    }).then(()=>{
                    })
                }
            }
            // else if(type== 0){
            //     if (res.data.status == 'success') {
            //         Swal.fire({
            //             title: "",
            //             text: "employee's payslip has been Hold Back",
            //             // "Salary Advance Succesfully",
            //             icon: "warning",
            //         });
            //     }

            // }
            else if(selectedProduct){
                if (res.data.status == 'success') {
                    Swal.fire({
                        title: "",
                        text: "Employee's payslip has been sent by email",
                        // "Salary Advance Succesfully",
                        icon: "success",
                    });
                }

            }

        }).finally(() => {
            getManagePayslipDetails(selectedDate.value.getMonth() + 1, selectedDate.value.getFullYear());
        })

    }

    function send_payslip_Email(selectedProduct) {
        let formdata = selectedProduct.map(({ Payroll_month, Employee_code }) => ({ month: dayjs(Payroll_month).format('MM'), year: dayjs(Payroll_month).format('YYYY'), user_code: Employee_code, type: "mail" }));
        let url = window.location.origin + "/payroll/paycheck/sendAllEmployeePayslipPdf";
        axios.post(url, formdata).then((res) => {
            // manage_payslips_details.value=res.data.data;
            console.log(res.data);
        }).finally(() => {
            getManagePayslipDetails(selectedDate.value.getMonth() + 1, selectedDate.value.getFullYear());
        })
    }


    async function downloadPayslip(selectedProduct) {

        console.log("Downloading payslip PDF.....");
        let formdata = selectedProduct.map(({ Payroll_month, Employee_code }) => ({ month: dayjs(Payroll_month).format('MM'), year: dayjs(Payroll_month).format('YYYY'), user_code: Employee_code, type: 'pdf' }));

        //split the payroll_month into month and year

        await axios.post('/generatePayslip', formdata).then((response) => {
            //  console.log("Response [getEmployeePayslipDetailsAsPDF] : " + response.data.data);
            console.log(" Response [downloadPayslipReleaseStatus] : " + JSON.stringify(response.data.data));

            if (response.data) {
                let base64String = response.data.data.payslip;
                let employeeName = response.data.data.emp_name
                let payslipMonth = response.data.data.month;
                let payslipyear = response.data.data.year;
                console.log(base64String);
                if (base64String) {
                    if (base64String.startsWith("JVB")) {
                        base64String = "data:application/pdf;base64," + base64String;
                        downloadFileObject(base64String, employeeName, payslipMonth, payslipyear);
                    } else if (base64String.startsWith("data:application/pdf;base64")) {
                        downloadFileObject(base64String);
                    }
                }
            } else {
                console.log("Response Url Not Found");
            }



        }).finally(() => {

        })

    }

    function downloadFileObject(base64String, employeeName, payslipyear, payslipMonth) {
        const linkSource = base64String;
        const downloadLink = document.createElement("a");
        const fileName = `${employeeName}-${payslipyear}-${payslipMonth}.pdf`;
        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        downloadLink.click();
    }

    function selectedFilter(selectedFilter, val) {

        if (selectedFilter == 'Business Unit') {
            businessUnit.value = val
        }
        else
            if (selectedFilter == 'departments') {
                departments.value = val;
            }
            else if (selectedFilter == 'Location') {
                selected_Location.value = val;
                console.log(selected_Location.value);
            }

            else if (selectedFilter == 'selectedDate') {
                selectedDate.value = val;
            }


    }


    const getFilterSource = (data) => {


        if (selectedDate.value) {
            let url = window.location.origin + "/payroll/paycheck/getAllEmployeesPayslipDetails_v2";
            axios.post(url, {
                department_id: departments.value,
                location: selected_Location.value,
                legal_entity: businessUnit.value,
                month: data ? dayjs(data).format('MM') : selectedDate.value.getMonth() + 1,
                year: data ? dayjs(data).format('YYYY') : selectedDate.value.getFullYear()
            }).then((res) => {
                manage_payslips_details.value = res.data.data;
                if (res.data.data.length <= 0) {
                    Swal.fire({
                        title: "No employees found in this category",
                        text: '',
                        // "Salary Advance Succesfully",
                        icon: "warning",
                    }).then((res) => {
                    });
                }
                console.log(res.data);
            });

        } else {
            Swal.fire({
                title: "failure",
                text: 'please select the Month',
                // "Salary Advance Succesfully",
                icon: "warning",
            }).then((res) => {
            });
        }
    }

    const clearFilter = () => {
        departments.value = null
        businessUnit.value = null
        // locations.value = null
        selectedDetails.value = '';
        selectedDate.value = new Date() ;
    }



    return {

        // variables
        selectedDetails,
        manage_payslips_details,
        selectedDate,
        enable_select_calendar,
        // function

        getManagePayslipDetails,
        send_payslip_request,
        send_payslip_Email,
        downloadFileObject,
        downloadPayslip,
        selectedFilter,
        businessUnit,
        departments,
        selected_Location,
        getlocation,
        Enable_btn,
        getLocationDetails,
        // selectedlocation,
        getClientDetails,
        clientList,
        getFilterSource,
        clearFilter


    }

})
