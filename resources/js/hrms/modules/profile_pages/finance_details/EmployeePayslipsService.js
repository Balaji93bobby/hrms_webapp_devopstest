import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";
import dayjs from 'dayjs';
import { useRouter, useRoute } from "vue-router";
import { UseEmployeeDocumentManagerService } from "../EmployeeDocumentsManagerService";
import { Service } from "../../Service/Service";
import{profilePagesStore} from '../../profile_pages/stores/ProfilePagesStore'
export const useEmployeePayslipStore = defineStore("employeePayslipStore", () => {


    const documentService = UseEmployeeDocumentManagerService()
    const useprofilePages = profilePagesStore();
    // Variable Declarations
    const array_employeePayslips_list = ref()

    const paySlipHTMLView = ref();
    const Payroll_month =  ref('');
    const router = useRouter();
    const route = useRoute();
    const service = Service();
    const selected_payslip = ref();
    const salary_dropdown_details = ref();
    const selected_dropdown_details = ref();
    // const

    const canShowPayslipView = ref(false);

    const urlParams = new URLSearchParams(window.location.search);
    const loading = ref(false);

    function getURLParams_UID() {

        console.log('route.params.id',route.params.user_id);
        if(route.params.user_id){
            return route.params.user_id
        }else{
            return service.current_user_id
        }
    }

    // Events
    async function getEmployeeAllPayslipList() {

        loading.value = true;

        axios.post('/payroll/paycheck/getEmployeeAllPayslipList', {
            uid: useprofilePages.getURLParams_UID(),
            dropdown_value:selected_dropdown_details.value
        }).then((response) => {
            //console.log("Response [getEmployeeAllPayslipList] : " + JSON.stringify(response.data.data));

            array_employeePayslips_list.value = response.data.data;
        }).finally(()=>{
            loading.value = false;
        });
    }


    async function getEmployeePayslipDetailsAsHTML(user_code, payroll_month) {
        loading.value = true;
        console.log(user_code,"user_code ::");
        console.log('getURLParams_UID()',getURLParams_UID());

        //split the payroll_month into month and year
        Payroll_month.value = payroll_month;
        let month = parseInt(dayjs(payroll_month).month()) + 1;
        let year = dayjs(payroll_month).year();
        // /payroll/paycheck/getEmployeePayslipDetailsAsHTML
        await axios.post('/empViewPayslipdetails', {
            uid:useprofilePages.getURLParams_UID(),
            user_code:user_code,
            month: month,
            year: year,
        }).then((response) => {
            // console.log("Response [getEmployeePayslipDetailsAsHTML] : " + JSON.stringify(response.data.data));
            paySlipHTMLView.value = response.data;
            canShowPayslipView.value = true;

        }).finally(()=>{
            loading.value = false;
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

    // /empGeneratePayslipPdfMail
    async function getEmployeePayslipDetailsAsPDF(user_code, payroll_month) {
        loading.value = true;

        documentService.loading = true;
        payroll_month;
        console.log("Downloading payslip PDF.....");

        let month = parseInt(dayjs(payroll_month).month()) + 1;
        let year = dayjs(payroll_month).year();

        //split the payroll_month into month and year

        await axios.post('/empGeneratePayslipPdfMail',
            {
                uid: useprofilePages.getURLParams_UID(),
                user_code: user_code,
                month: month,
                year: year,
                type:"pdf"
            }).then((response) => {
                 //console.log("Response [getEmployeePayslipDetailsAsPDF] : " + response.data.payslip);
                console.log(" Response [downloadPayslipReleaseStatus] : " + JSON.stringify(response.data.data.payslip));

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
                documentService.loading = false;
                loading.value = false;
            })

    }

    const getsalary_details_dropdown = () => {

        axios.get('/payslipYearwiseDropdown').then((res)=>{
            salary_dropdown_details.value =  res.data.data;

            console.log(salary_dropdown_details.value ,'salary_dropdown_details');
            res.data.data.map(({ start_date, end_date ,id,year_dropdown  }) => {
                if (start_date < dayjs(new Date()).format('YYYY-MM-DD') && end_date >  dayjs(new Date()).format('YYYY-MM-DD')  ) {
                    console.log(id,":::");
                    selected_dropdown_details.value =  year_dropdown ;

                    console.log(selected_dropdown_details.value ,'asdjka');
                }
            })
        }).finally(()=>{
            getEmployeeAllPayslipList();

        })


    }






    return {

        // Varaible Declartion

        // payroll_month
        Payroll_month,

        array_employeePayslips_list, paySlipHTMLView, canShowPayslipView,loading,
        selected_payslip,

        selected_dropdown_details,
        salary_dropdown_details,
        // Functions

        getEmployeeAllPayslipList, getEmployeePayslipDetailsAsHTML, getEmployeePayslipDetailsAsPDF,getsalary_details_dropdown

    };
});
