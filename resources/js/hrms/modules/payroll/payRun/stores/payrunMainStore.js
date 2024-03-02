import { data } from "autoprefixer";
import axios from "axios";
import dayjs from "dayjs";
import { defineStore } from "pinia";
import { ref } from "vue";
import {Service} from '../../../Service/Service';

export const payrunMainStore = defineStore("payrunMainStore", () => {

    // Variable declaration
    const currentActiveScreen = ref(0);
    const service = Service()


    /*
    1 ) Leave, Attendance & Wages Calculation
    2 ) New Joinee & Exits
    3 ) Bonus, Salary Revisions & Overtime
    4 ) Reimbursement, Adhoc Payment, Deduction
    5 ) Salaries on Hold & Arrears
    6 ) Override (PT, ESI, TDS, LWF)
    */

    // Leave, Attendance & Wages Calculation

    const leaveSource = ref()
    const payrollSource = ref()
    const employeePayables = ref()
    const employeeIncomeTax = ref()
    const employeeEpf = ref()
    const employeeEsic = ref()
    const employeeInsurance = ref();
    const professional_tax = ref();
    const lwf = ref();
    const Other_deduction = ref();
    const payroll_stats = ref();
    const currentFiancialYearStatus = ref();
    const selectedmonthdate = ref();
    const selectedmonthstartenddate = ref();
    const client_id = ref();
    const selected_start_end_date = ref();

//payoll outcome date format show in payrun

          let currentdate = dayjs(new Date()).format('YYYY-MM-DD');
          selectedmonthstartenddate.value =dayjs(new Date()).format('MMM YYYY')
          selectedmonthdate.value =  '('+dayjs(currentdate).startOf('month').format('MMM D') +' - '+dayjs(currentdate).endOf('month').format('MMM D')+','+dayjs(currentdate).daysInMonth()+'Days'+')'

    const getLeaveDetails = async () => {
        let url = '/fetch-leaverequests-based-on-currentrole'
        await axios.get(url).then(res => {
            leaveSource.value = res.data.data
        })
    }

    async function getcurrentFiancialYearStatus(client_id) {
        let url =    window.location.origin + '/' +'api/payroll/getOrgPayrollMonths'
        await axios.post(url,{
            client_id:client_id
        }).then(res => {
            currentFiancialYearStatus.value = res.data.data
        })
    }


    // Payrun Outcome


    const payrollOutcomeSource = ref()

    const getPayrunOutcomeDetails = async (data,client_id) => {
//dynamic month year change on click
        selectedmonthstartenddate.value = payrollmonthstartenddate(data);
        selectedmonthdate.value = payrollmonthyear(data);

        console.log('client_id',client_id);
        let url = 'api/payroll/getPayrollOutcomes'
        await  axios.post(window.location.origin + '/' + url, {
            client_id:client_id,
            payroll_month: dayjs(data).format('YYYY-MM-01') ,
        }).then(res => {
            payrollSource.value = res.data.data
            payrollOutcomeSource.value = res.data.data.payroll_outcome
            employeePayables.value = formatConverter(res.data.data.payroll_outcome.employee_payables)
            employeeIncomeTax.value = formatConverter(res.data.data.payroll_outcome.income_tax)
            employeeEpf.value = formatConverter(res.data.data.payroll_outcome.EPF)
            employeeEsic.value = formatConverter(res.data.data.payroll_outcome.ESIC)
            employeeInsurance.value = formatConverter(res.data.data.payroll_outcome.insurance)
            professional_tax.value = formatConverter(res.data.data.payroll_outcome.professional_tax)
            lwf.value = formatConverter(res.data.data.payroll_outcome.lwf)
            Other_deduction.value = formatConverter(res.data.data.payroll_outcome.Other_deduction)
            payroll_stats.value = res.data.data.payroll_stats
            selected_start_end_date.value =  res.data.selected_start_end_date
        })
    }




    const formatConverter = (data) => {
        let obj = Object.entries(data).map(item => {
                return {
                    title: item[0],
                    value: item[1]
                }
        })
        return obj
    }
    const payrollmonthstartenddate = (data) => {

        let  payrollmonthstartenddate ='('+dayjs(data).startOf('month').format('MMM D') +' - '+ dayjs(data).endOf('month').format('MMM D')+','+dayjs(data).daysInMonth()+'Days'+')'
        return payrollmonthstartenddate

    }
    const payrollmonthyear = (data) => {

        let  monthyear =dayjs(data).format('MMM YYYY')
    return monthyear
    }


function findSelectedHeader(array, idToFind) {
    if (array) {
        console.log(idToFind);
        return array.find(obj => obj.title == idToFind);
    }

}



    return {
        currentActiveScreen,

        // Leave, Attendance & Wages Calculation

        //  Leave
        leaveSource, getLeaveDetails,

        // Payrun Outcome
        payrollSource, getPayrunOutcomeDetails, payrollOutcomeSource,
        employeePayables, employeeIncomeTax, employeeEpf, employeeEsic, employeeInsurance,professional_tax,lwf,Other_deduction, payroll_stats,
        getcurrentFiancialYearStatus,currentFiancialYearStatus,

        // utils
        findSelectedHeader,
        client_id,
        //payroll outcome date
        selected_start_end_date,
        selectedmonthstartenddate,
        selectedmonthdate

    }

})
