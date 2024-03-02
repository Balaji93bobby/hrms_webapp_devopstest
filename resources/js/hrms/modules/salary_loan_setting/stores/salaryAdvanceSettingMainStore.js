import axios from "axios";
import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { inject, reactive, ref } from "vue";

/*
    This Pinia code will store the ajax values of the
    profile page.
    This code is called from Parents onMounted method asynchronously


*/

export const salaryAdvanceSettingMainStore = defineStore("salaryAdvanceSettingMainStore", () => {

    /*

     Salary Advance - sa
     Loan with Interest - lwi
     Interest free Loan  - ifl
     Travel Advance - ta

    */


    //   Salary Advance Begins

    // Loading Service
    const canShowLoading = ref(false)

    // Notification service
    const swal = inject("$swal");



    // Initially Disabled
    const create_new_from = ref(1);
    const isSalaryAdvanceFeatureEnabled = ref(0)

    // Dropdown for filter employee'

    const dropdownFilter = ref();
    const selectedFilterOptions = reactive({
        department_id: '',
        designation: '',
        work_location: '',
        state: '',
        client_name: '',
    })
    const client_name_status = ref([]);
    const approvalFormat = reactive([]);

    const selectedOption1 = ref();
    const selectedOption2 = ref();
    const selectedOption3 = ref();

    const response_message = ref();
    const canShowPopup = ref()
    const AssignedClients = ref([]);
    const interstfreeloanPage =  ref(1);
    const loanWithInterestPage = ref(1);

    // Enable btn disable for loan and salary advance settings

    const EnableAndDisable = ref('');


    // Eligible Employees

    const eligbleEmployeeSource = ref();

    const SalaryEmpDetails = ref();

    // Get filter

    const getDropdownFilterDetails = async () => {
        canShowLoading.value = true
        let url = '/getAllDropdownFilter'
        await axios.get(url).then(res => {
            dropdownFilter.value = res.data
        }).finally(() => {
            canShowLoading.value = false
        })
    }

    const getSelectoption = (key, filter) => {
        console.log(filter);

        if (key == "department") {
            console.log(filter);
            selectedFilterOptions.department_id = filter
            console.log(selectedFilterOptions);
        } else
            if (key == "designation") {
                selectedFilterOptions.designation = filter
                console.log(selectedFilterOptions);
            } else
                if (key == "state") {
                    selectedFilterOptions.state = filter
                    console.log(selectedFilterOptions);
                } else
                    if (key == "work_location") {
                        selectedFilterOptions.work_location = filter
                        console.log(selectedFilterOptions);
                    } else
                        if (key == "client_name") {
                            selectedFilterOptions.client_name = filter
                            console.log(selectedFilterOptions);
                        }
                        else {
                            console.log("nope");
                        }
        let url = '/showAssignEmp'
        axios.post(url, selectedFilterOptions).then(res => {
            eligbleEmployeeSource.value = res.data
            console.log(res.data);
        })
    }

    const getElibigleEmployees = () => {
        canShowLoading.value = true
        let url = '/showAssignEmp'
        axios.post(url, selectedFilterOptions).then(res => {
            eligbleEmployeeSource.value = res.data
            console.log(res.data);
        }).finally(() => {
            canShowLoading.value = false
        })
    }

    const eligibleSalaryAdvanceEmployeeData = ref();

    // Percentage of Salary Advance
    // Deduction Method

    const sa = reactive({
        SA: '',
        isSalaryAdvanceEnabled: 0,
        eligibleEmployee: '',
        perOfSalAdvance: '',
        cusPerOfSalAdvance: '',
        deductMethod: '',
        cusDeductMethod: '',
        approvalflow: approvalFormat,
        selectClientID: '',
        payroll_cycle: ''
    })

    function sal_adv_reset() {
       sa.SA=''
       sa.isSalaryAdvanceEnabled=''
       sa.eligibleEmployee=''
       sa.perOfSalAdvance=''
       sa.cusPerOfSalAdvance=''
       sa.deductMethod=''
       sa.cusDeductMethod=''
       sa.approvalflow=''
       sa.selectClientID=''
       sa.payroll_cycle=''
       ifl.approvalflow = ""
       ifl.selectedOption1 = ""
       ifl.selectedOption2 = ""
       ifl.selectedOption3 = ""
       selectedOption1.value = ""
       selectedOption2.value = ""
       selectedOption3.value = ""
       EnableAndDisable.value = ''
       resetFilters.value= ""
       eligbleEmployeeSource.value = ""
       SalaryEmpDetails.value = ""
    }

    if(!sa.eligibleEmployee){
        console.log("testing simma :",sa.eligibleEmployee);
    }





    // Approval Flow

    const SalaryAdvanceFeatureApprovalFlow = ref({})

    const blink_UI = ref();


    const saveSalaryAdvanceFeature = () => {
        canShowLoading.value = true
        if (sa.perOfSalAdvance == 'custom') {
            sa.perOfSalAdvance = sa.cusPerOfSalAdvance
        } else {
            console.log("same of percent");
        }

        if (sa.deductMethod == 'afterPayroll') {
            sa.deductMethod = sa.cusDeductMethod
        } else {
            console.log("same of percent");
        }

        let url = '/saveSalaryAdvanceSetting'
        if (isSalaryAdvanceFeatureEnabled.value == '1') {
            console.log("salary Advance Disabled");

        } {
            console.log("salary Advance Enabled");
            sa.isSalaryAdvanceEnabled = 1
        }

        axios.post(url, sa).then((res) => {
            response_message.value = res.data;

            let val = res.data.data;

            if (res.data.status == "success") {
                Swal.fire({
                    title: res.data.status = "success",
                    text: res.data.message,
                    // "Salary Advance Succesfully",
                    icon: "success",
                }).then((res) => {
                    sal_adv_reset();
                   
                    create_new_from.value = 1;
                })
            }
            else if (res.data.status == "failure") {
                Swal.fire({
                    title: res.data.status = "failure",
                    text: res.data.message,
                    // "Salary Advance Succesfully",
                    icon: "error",
                    showCancelButton: false,
                }).then((res) => {
                    // blink_UI.value = res.data.data;
                    create_new_from.value = 1;
                })

            }
        }).finally(() => {

            canShowLoading.value = false;
            approvalFormat.splice(0, approvalFormat.length);
            sal_adv_reset();
        })
        console.log(sa);
    }


    const swalFunction = (res) => {
        // getting values after response is submitted

        let sm = [
            { heading: "All", Message: "This Setting Name Already Exist For Another Settings in All Please Change The Setting Name", record_id: 1 },
            { heading: "Brand Avatar", Message: "This Setting Name Already Exist For Another Settings in Brand Avatar Please Change The Setting Name", record_id: 2 },
            { heading: "Avatar Live", Message: "This Setting Name Already Exist For Another Settings in Avatar Live Please Change The Setting Name", record_id: 14 }
        ]

        let messege = [

        ]

        sm.forEach(element => {
            let format = `${element.heading} - ${element.Message}`
            messege.push(format)
            console.log(format);
        });

        messege.forEach((ele) => {
            console.log(ele);
        })

        // This Setting Name Already Exist For Another Settings in All Please Change The Setting Name

        console.log(messege);

        // Notification service for Showing assigned Clients

        if (res.status == "success") {
            Swal.fire({
                title: "Success",
                text: messege.forEach((ele) => {
                    return ele
                }),
                icon: "success",
            }).then((res) => {
               create_new_from.value= 1;
               interstfreeloanPage.value = 1;
               loanWithInterestPage.value = 1;
            })
        }
        else if (res.status == "failure") {
            Swal.fire({
                title: res.status = "failure",
                text: messege,
                icon: "error",
                showCancelButton: false,
            }).then((res) => {
             
                interstfreeloanPage.value = 1;
                loanWithInterestPage.value = 1;
                create_new_from.value= 1;
            })

        }

    }

   


    //   Salary Advance Ends


    // Interest Free Loan Feature Begins

    // Initially Disabled

    const isInterestFreeLoanFeature = ref(1)

    // Eligible Employees and Amount
    // Deduction Method
    const deduction_starting_months = ref();
    const createIflNewFrom = ref(1);


    const ifl = reactive({
        name: '',
        isInterestFreeLoanIsEnabled: 0,
        selectClientID: '',
        minEligibile: '',
        availPerInCtc: '',
        deductMethod: '',
        precent_Or_Amt: '',
        deductMethod: "",
        max_loan_limit: '',
        cusDeductMethod: '',
        maxTenure: '',
        payroll_cycle: '',
        approvalflow: approvalFormat,
        loan_type: 'InterestFreeLoan',
        selectedOption1: selectedOption1,
        selectedOption2: '',
        selectedOption3: '',
    })
    const ClientsName = ref();
    // deduction_starting_months
    // max_loan_limit

    function resetIfl() {
        ifl.name = ''
        ifl.selectClientID = ""
        ifl.minEligibile = ""
        ifl.availPerInCtc = ""
        ifl.deductMethod = ""
        ifl.precent_Or_Amt = ""
        ifl.deductMethod = ""
        ifl.max_loan_limit = ""
        ifl.cusDeductMethod = ""
        ifl.maxTenure = ""
        ifl.payroll_cycle = ""
        ifl.approvalflow = ""
        ifl.selectedOption1 = ""
        ifl.selectedOption2 = ""
        ifl.selectedOption3 = ""
        selectedOption1.value = ""
        selectedOption2.value = ""
        selectedOption3.value = ""
        EnableAndDisable.value = '';
    }



    const saveInterestfreeLoan = () => {
        canShowLoading.value = true
        if (ifl.deductMethod == 'emi') {
            ifl.deductMethod = ifl.cusDeductMethod
        } else {
            console.log("same of percent");
        }
        if (isInterestFreeLoanFeature.value == '1') {
            console.log("disabled");
        } else {
            console.log(ifl);
            ifl.isInterestFreeLoanIsEnabled = 1
        }
        if (ifl.precent_Or_Amt == 'fixed') {
            ifl.availPerInCtc = "";
        }
        else if (ifl.precent_Or_Amt == 'percnt') {
            ifl.max_loan_limit = "";
        }


        let url = '/save-int-and-int-free-loan-settings';
        axios.post(url, ifl).then((res) => {
            res.data.message.forEach(element => {
                let format = `${element.heading} - ${element.Message}`
                AssignedClients.value.push(format)
            });
        }).finally(() => {
            canShowLoading.value = false;
            canShowPopup.value = true;
            approvalFormat.splice(0, approvalFormat.length)
            resetIfl();
        })
    }

    // /get-clients-for-loan-adv

    async function getClientsName(Status) {
        canShowLoading.value = true;
        let status = Status;
        await axios.post('/get-clients-for-loan-adv', {
            status: status
        }).then((res) => {
            ClientsName.value = res.data;
            client_name_status.value = [];

            res.data.forEach(element => {
                if (element.status == 1) {
                    client_name_status.value.push(element.id)
                }
            });

        }).finally(() => {
            canShowLoading.value = false;
        })
    }


    async function sendClient_code(loanType) {
        let loantype = loanType
        let url = `/change-client-id-sts-for-loan`;
        await axios.post(url, {
            client_status: client_name_status.value,
            loanType: loantype
        }).then((res) => {

        })

    }







    // Interest Free Loan Feature Ends


    // Travel Advance Feature Begins

    const isTravelAdvanceFeatureEnabled = ref(1)


    // Eligible Employees

    const eligibleTravelAdvanceEmployeeData = ref(1)

    // Travel Advance Limit
    // Deduction
    // Claim Settings

    const ta = reactive({
        tdl: '',
        deductMethod: '',
        sumbitWithIn: '',
        isDeductedInsubsequentpayroll: '',
        claimBill: '',
        approvalflow: approvalFormat
    })

    const saveTravelAdvance = () => {
        canShowLoading.value = true
        if (isTravelAdvanceFeatureEnabled.value == '1') {
            console.log("disabled");
        } else {
            console.log(ta);
        }
        let url = '/saveTravelAdvanceSettings'
        axios.post(url, ta).then((res) => {
            swalFunction(res.data)
        }).finally(() => {
            canShowLoading.value = false;
            approvalFormat.splice(0, approvalFormat.length);
        })
    }


    // Travel Advance Feature Ends


    // Loan With interest Feature Begins

    const isLoanWithInterestFeature = ref();

    const lwif = reactive({
        name: "",
        LoanWithInterestFeature: '',
        selectClientID: '',
        minEligibile: '',
        availPerInCtc: '',
        deductMethod: '',
        precent_Or_Amt: '',
        deductMethod: "",
        max_loan_limit: '',
        cusDeductMethod: '',
        maxTenure: '',
        loan_amt_interest: '',
        loan_type: 'LoanWithInterest',
        approvalflow: approvalFormat,
        selectedOption1: selectedOption1,
    });

    function RestLwif() {
        lwif.name = ""
        lwif.selectClientID = ''
        lwif.minEligibile = ''
        lwif.availPerInCtc = ''
        lwif.deductMethod = ''
        lwif.precent_Or_Amt = ''
        lwif.deductMethod = ""
        lwif.max_loan_limit = ''
        lwif.cusDeductMethod = ''
        lwif.maxTenure = ''
        lwif.loan_amt_interest = ''
        lwif.loan_type = ""
        lwif.approvalflow = ""
        lwif.selectedOption1 = ""
        selectedOption1.value = ""
        selectedOption2.value = ""
        selectedOption3.value = ""
        EnableAndDisable.value = ''
    }

    const saveLoanWithInterest = () => {
        canShowLoading.value = true
        if (isLoanWithInterestFeature.value == '1') {
            console.log("disabled");
            lwif.LoanWithInterestFeature = 1;
        } else {
            console.log(ta);
        }
        if (lwif.precent_Or_Amt == 'fixed') {
            lwif.availPerInCtc = "";
        }
        else if (lwif.precent_Or_Amt == 'percnt') {
            lwif.max_loan_limit = "";
        }
        if (lwif.deductMethod == 'emi') {
            lwif.deductMethod = lwif.cusDeductMethod
        } else {
            console.log("same of percent");
        }
        let url = '/save-int-and-int-free-loan-settings';

        axios.post(url, lwif).then((res) => {
            res.data.message.forEach(element => {
                let format = `${element.heading} - ${element.Message}`
                AssignedClients.value.push(format)
            });
        }).finally(() => {
            canShowPopup.value = true
            canShowLoading.value = false
            approvalFormat.splice(0, approvalFormat.length)
        })
    }


    // Loan With interest Feature Ends



    const resetFilters = () => {
        selectedFilterOptions.client_name = ''
        selectedFilterOptions.department_id = ''
        selectedFilterOptions.designation = ''
        selectedFilterOptions.state = ''
        selectedFilterOptions.work_location = ''

        let url = '/showAssignEmp'
        axios.post(url, selectedFilterOptions).then(res => {
            eligbleEmployeeSource.value = res.data
            console.log(res.data);
        })

    }




    const toSelectoption = (flow, value) => {
        console.log(value);
        if (flow == 1) {
            option.value = 1
            selectedOption1.value = value.name
            let approvalflow = '';
            if (value.name == "Line Manager") {
                approvalflow = {
                    approver: 'l1_manager_code',
                    order: flow,
                    name: 'Line Manager'
                }
            } else if (value.name == "HR") {
                approvalflow = {
                    approver: 'hr_user_id',
                    order: flow,
                    name: 'HR'
                }
            }
            else if (value.name == "Finance Admin") {
                approvalflow = {
                    approver: 'fa_user_id',
                    order: flow,
                    name: 'Finance Admin'
                }
            }

            // let approvalflow = {
            //     approver: value.name,
            //     order: flow
            // }
            approvalFormat.push(approvalflow)
        }
        if (flow == 2) {
            selectedOption2.value = value.name
            let approvalflow = '';
            if (value.name == "Line Manager") {
                approvalflow = {
                    approver: 'l1_manager_code',
                    order: flow,
                    name: 'Line Manager'
                }
            } else if (value.name == "HR") {
                approvalflow = {
                    approver: 'hr_user_id',
                    order: flow,
                    name: 'HR'
                }
            }
            else if (value.name == "Finance Admin") {
                approvalflow = {
                    approver: 'fa_user_id',
                    order: flow,
                    name: 'Finance Admin'
                }
            }
            approvalFormat.push(approvalflow)

        }
        if (flow == 3) {
            selectedOption3.value = value.name
            let approvalflow = '';
            if (value.name == "Line Manager") {
                approvalflow = {
                    approver: 'l1_manager_code',
                    order: flow,
                    name: 'Line Manager'
                }
            } else if (value.name == "HR") {
                approvalflow = {
                    approver: 'hr_user_id',
                    order: flow,
                    name: 'HR'
                }
            }
            else if (value.name == "Finance Admin") {
                approvalflow = {
                    approver: 'fa_user_id',
                    order: flow,
                    name: 'Finance Admin'
                }
            }
            approvalFormat.push(approvalflow)
        } else {
            console.log("No More Options");
        }
        if (flow == 4) {
            console.log(value);
            var itemsWithoutCurrent = dropdownlist.value.filter(function (x) { return x.name == value; });
            console.log(itemsWithoutCurrent);
            let removedOption = { name: itemsWithoutCurrent[0].name, val: itemsWithoutCurrent[0].val };
            console.log(removedOption);
            filteredApprovalFlow.value.push(removedOption)
            selectedOption1.value = ''
            approvalFormat.pop()

        }
        if (flow == 5) {
            console.log(value);
            var itemsWithoutCurrent = dropdownlist.value.filter(function (x) { return x.name == value; });
            console.log(itemsWithoutCurrent);
            let removedOption = { name: itemsWithoutCurrent[0].name, val: itemsWithoutCurrent[0].val };
            console.log(removedOption);
            filteredApprovalFlow.value.push(removedOption)
            selectedOption2.value = ''
            approvalFormat.pop()

        }

        if (flow == 6) {
            console.log(value);
            var itemsWithoutCurrent = dropdownlist.value.filter(function (x) { return x.name == value; });
            console.log(itemsWithoutCurrent);
            let removedOption = { name: itemsWithoutCurrent[0].name, val: itemsWithoutCurrent[0].val };
            console.log(removedOption);
            filteredApprovalFlow.value.push(removedOption)
            selectedOption3.value = ''
            approvalFormat.pop()

        }

        var itemsWithoutCurrent = filteredApprovalFlow.value.filter(function (x) { return x.val !== value.val; });
        filteredApprovalFlow.value = itemsWithoutCurrent

    }



    const dropdownlist = ref([
        { name: "Line Manager", val: 1 },
        { name: "HR", val: 2 },
        { name: "Finance Admin", val: 3 }
    ])

    const filteredApprovalFlow = ref([
        { name: "Line Manager", val: 1 },
        { name: "HR", val: 2 },
        { name: "Finance Admin", val: 3 }
    ])



    const option = ref(0)
    const option1 = ref(0)
    const option2 = ref(0)


    // get loan and salary advance current status

    // const currentStatus = ref();

    const getCurrentStatus = async (Status) => {
        canShowLoading.value = true;
        let status = Status;
        await axios.post('/loan-and-salAdv-current-status', {
            Status: status
        }).then((res) => {
            if (status === 'sal_adv') {
                isSalaryAdvanceFeatureEnabled.value = res.data.status;
            } if (status === 'int_free_loan') {
                isInterestFreeLoanFeature.value = res.data.status;
            }
            if (status === 'loan_with_int') {
                isLoanWithInterestFeature.value = res.data.status;
            }
        }).finally(() => {
            canShowLoading.value = false;
        })
    }

    const salaryAdvanceSettingsDetails = ref();

    async function salaryAdvanceHistory() {
        // console.log();
        await axios.get('/settingDetails').then((res) => {
            salaryAdvanceSettingsDetails.value = res.data;
            console.log(salaryAdvanceSettingsDetails.value);
        })
    }
    const interestFreeLoanHistory = ref();
    const interestwithLoanHistory =ref();

    async function getInterestFreeAndInterestWithLoanHistory(Status) {
        let status = Status;
        axios.post('/interest-and-interestfree-loan-settings-details',
            {
                Status: status
            }
        ).then(res => {
            if (status === 'InterestFreeLoan') {
                interestFreeLoanHistory.value = res.data.settings;
            }
            if (status === 'InterestWithLoan') {
                interestwithLoanHistory.value = res.data.settings;
            }
            // interestFreeLoanHistory.value = res.data.data
        })

    }



    return {

        //
        dropdownFilter, getDropdownFilterDetails, getSelectoption, getElibigleEmployees, eligbleEmployeeSource, resetFilters, canShowLoading, canShowPopup, AssignedClients,

        // Approver Flow

        approvalFormat, selectedOption1, selectedOption2, selectedOption3, option, option1, option2, dropdownlist, filteredApprovalFlow, toSelectoption,

        // SalaryAdvanceFeature

        isSalaryAdvanceFeatureEnabled, eligibleSalaryAdvanceEmployeeData, sa, SalaryAdvanceFeatureApprovalFlow, saveSalaryAdvanceFeature, create_new_from, getCurrentStatus, client_name_status, sendClient_code, salaryAdvanceHistory, salaryAdvanceSettingsDetails,
         SalaryEmpDetails,
        // Interest Free Loan

        isInterestFreeLoanFeature, ifl, saveInterestfreeLoan, deduction_starting_months,

        getClientsName, ClientsName, createIflNewFrom,

        // Travel Advance Feature

        isTravelAdvanceFeatureEnabled, eligibleTravelAdvanceEmployeeData, ta, saveTravelAdvance,


        // Loan With interest Feature
        isLoanWithInterestFeature, lwif, saveLoanWithInterest, blink_UI, swalFunction, sal_adv_reset, resetIfl, RestLwif
        ,

        // get Interest Free Loan History
        getInterestFreeAndInterestWithLoanHistory, interestFreeLoanHistory,interestwithLoanHistory,

        EnableAndDisable,

        interstfreeloanPage,
        loanWithInterestPage



    };
});



