import { defineStore } from 'pinia';
import axios from 'axios';
import { ref, reactive } from 'vue';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import {Service} from '../../Service/Service'
import { usePayrollHelper } from './payrollHelper';
import dayjs from 'dayjs';


export const usePayrollMainStore = defineStore('usePayrollMainStore', () => {

    //Global  variable Declaration

    const helper = usePayrollHelper()
    // Confirmation Service
    const confirm = useConfirm();

    // Notification Service
    const toast = useToast();

    // Global Service

    const service = Service()

    // loading Spinner
    const canShowLoading = ref(false);

    // Currently Active Tab

    const activeTab = ref(1);

    /*  Payroll Setup Structure

        1) general payroll Setup

        2)Pf & Esi Setting
            1)Employee provident fund - epf
            2)Employee state insurance -esi
            3)Aatmanirbhar Bharat Yojana(ABRY)Scheme - abry
            4)Pradhan Matri Rojgar Protsahan Yojana(PMRPY)Scheme - pmrpy


        3)Salary components
            1)Earnings
            2)Adhoc Components
            3)Reimbursement
            4)Accounting Code

        4)Salary structure - Paygroups

        5)finance Setting
        6)Statutory Filling

     */


    // General Payroll Settings


    const generalPayrollSettings = ref({
       
    })

    const epfSettings=ref({})
    const esiSettings=ref({})
    const proTaxSettings=ref({})
    const labourWelfareFundSettings=ref({})

    

    const disableDropdown = ref(false);

    const payroll_frequency = ref([]);
    const epf_rule=ref([])
    const epf_contribution=ref([])
    const states=ref([])
    const districts_tn=ref([])
    const calcType=ref([])
    const categoryVal=ref([])
    const compNature=ref([])
    const compType=ref([]);
    const selectedarray = ref([]);

    const filteredOptions = (array) => {
      const options = array.map(option => {
        const disabled = option.status !== 1;
    
        if (disabled) {
          disableDropdown.value = true;
        }
    
        return {
          label: option.name,
          value: option.id,
          disabled,
        };
      });
    
      console.log(disableDropdown.value);
      return options;
    };

    const getPayFreqData = async() => {
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
       await axios.get(url).then((res)=>{
        console.log(res.data.data)
            console.log(res.data.data.payroll_frequency_type)
            payroll_frequency.value = res.data.data.payroll_frequency_type;
      // filteredOptions(payroll_frequency.value);
        })
    }

    const getEpfRule=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        await axios.get(url).then((res)=>{
            console.log(res.data.data.payroll_epf_dropdown)
            epf_rule.value=res.data.data.payroll_epf_dropdown
        })
    }

    const getEpfContribution=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        await axios.get(url).then((res)=>{
            epf_contribution.value=res.data.data.payroll_epf_dropdown
        })
    }

    const getStateInfo=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        await axios.get(url).then((res)=>{
            states.value=res.data.data.states
        })
    }

    const getDistrictInfo=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        await axios.get(url).then((res)=>{
            districts_tn.value=res.data.data.districts
        })
    }

    // salary components dropdown api
    const getSalarySidebar=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        await axios.get(url).then((res)=>{
            calcType.value=res.data.data.type_of_calculation
            categoryVal.value=res.data.data.comp_category
            compNature.value=res.data.data.comp_nature
            compType.value=res.data.data.comp_type

        })
    }
    
    // salary structure user code get method
    const user_code=ref('')
    
           
      
    const getCurrentGeneralPayrollSettings = () => {
        let url =    window.location.origin + '/' +'api/payroll/getGenralPayrollSettingsDetails'
        axios.post(url,{
            record_id:null
        }).then((res)=>{
            generalPayrollSettings.value.pay_frequency_id=res.data.pay_frequency_id
            generalPayrollSettings.value.payperiod_start_month=res.data.payperiod_start_month
            generalPayrollSettings.value.payperiod_end_date=res.data.payperiod_end_date
            generalPayrollSettings.value.payment_date=res.data.payment_date
            generalPayrollSettings.value.attendance_cutoff_date=res.data.attendance_cutoff_date
            generalPayrollSettings.value.is_payperiod_same_att_period=res.data.is_payperiod_same_att_period
            generalPayrollSettings.value.attendance_start_date=res.data.attendance_start_date
            generalPayrollSettings.value.attendance_end_date=res.data.attendance_end_date
            generalPayrollSettings.value.is_attcutoff_diff_payenddate=res.data.is_attcutoff_diff_payenddate
            // generalPayrollSettings.att_cutoff_period_id.value =  res.data.att_cutoff_period_id;
            
        })

    }

    const saveGeneralPayrollSettings = (data) => {
       
        let url =    window.location.origin + '/' +'api/payroll/saveOrUpdateGenralPayrollSettings'
          console.log(data);
          axios.post(url,
          {
            record_id:'',
            client_id:data.client_id,
            pay_frequency_id:data.pay_frequency_id,
            payperiod_start_month:dayjs(data.payperiod_start_month).format('YYYY-MM-DD'),
            payperiod_end_date:dayjs(data.payperiod_end_date).format('YYYY-MM-DD'),
            payment_date:dayjs(data.payment_date).format('YYYY-MM-DD'),
            attendance_cutoff_date:dayjs(data.attendance_cutoff_date).format('YYYY-MM-DD'),
            is_payperiod_same_att_period:data.is_payperiod_same_att_period,
            attendance_start_date:dayjs(data.attendance_start_date).format('YYYY-MM-DD'),
            attendance_end_date: dayjs(data.attendance_end_date).format('YYYY-MM-DD'),
            is_attcutoff_diff_payenddate:data.is_attcutoff_diff_payenddate ?  '1' :'0',
          }
          )
    }


    // PF ESI Setting

    //  - Employee provident fund
    const EPFSettings =(data)=>{
        console.log(data.epf_rule,'data');
        let url =    window.location.origin + '/' +'api/payroll/saveOrUpdatePayrollEpfDetails'
        console.log(data)
        axios.post(url,
        {
            record_id:'',
            client_id:data.client_id,
            epf_number:data.epf_number,
            is_epf_enabled:data.is_epf_enabled,
            epf_rule:data.epf_rule,
            epf_contrib_type:data.epf_contribution_type,
            is_epf_policy_default:data. is_epf_policy_default? '1':'0',
            epf_deduction_cycle:dayjs(data.epf_deduction_cycle).format('YYYY-MM-DD'),
            employer_contrib_in_ctc:data.employer_contrib_in_ctc? '1':'0',
            employer_edli_contri_in_ctc:data.employer_edli_contri_in_ctc? '1':'0',
            admin_charges_in_ctc:data.admin_charges_in_ctc? '1':'0',
            override_pf_contrib_rate:data.override_pf_contrib_rate? '1':'0',
            pro_rated_lop_status:data.pro_rated_lop_status? '1':'0',
            can_consider_salcomp_pf:data.can_consider_salcomp_pf? '1':'0',
        })
    }

    // get epf details
    let epfDetails=ref()
    const getEPFDetails=async()=>
    {
        let url =  window.location.origin + '/' +'api/payroll/getPayrollEpfDetails'
      await  axios.get(url).then((res)=>
        {
            console.log(res.data.data)
            epfDetails.value=res.data.data
        })

    }
    //GET NON PF EMPLOYEE DETAILS
    let nonepfDetails=ref()
    const getNonEPFDetails=async()=>
    {
        let url =  window.location.origin + '/' +'api/payroll/getNonPfEmployeesDetails'
        await axios.get(url).then((res)=>
        {
            console.log(res.data.data)
            nonepfDetails.value=res.data.data
        })

    }
    // Add new rule for Employee provident fund

    const addNewEpf = ref({})

    const saveNewEpf = (data) => {
        console.log(data);
        axios.post('/Paygroup/CreatePayrollEpf', data)
    }


    // Employee's State Insurance

    const ESISettings=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/saveOrUpdatePayrollEsiDetails'
        console.log(data)
        axios.post(url,
           {
            record_id:'',
            client_id:data.client_id,
            esi_number:data.esi_number,
            state:data.state,
            district:data.district,
            location:data.location,
            esi_deduction_cycle:data.esi_deduction_cycle,
            employer_contribution_in_ctc:data.employer_contribution_in_ctc?'1':'0'
            
           } )
    }
    // get ESI details
    let esiDetails=ref()
    const getESIDetails=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/getPayrollEsiDetails'
        await axios.get(url).then((res)=>{
            console.log(res.data.data)
            esiDetails.value=res.data.data
        })

    }

    const saveprofessTaxSetting=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/saveUpdateProfessionalTaxSettings'
        console.log(data)
        axios.post(url,{
            record_id:'',
            client_id:data.client_id,
            state:data.state,
            district:data.district,
            location:data.location,
            deduction_cycle:data.deduction_cycle,
            pt_number:data.pt_number
        })
    }
    // get professional tax details
    let protaxDetails=ref()
    const getProfessionalTaxDetails=async()=>
    {
        let url =  window.location.origin + '/' +'api/payroll/fetchProfessionalTaxSettings'
        await axios.get(url).then((res)=>
        {
            console.log(res.data.data)
            protaxDetails.value=res.data.data
        })
    }

    const saveLabourWelfareSettings=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/saveUpdatelwfSettings'
        console.log(data)
        axios.post(url,
            {
                record_id:'',
                client_id:data.client_id,
                state:data.state,
                district:data.district,
                location:data.location,
                deduction_cycle:data.deduction_cycle,
                lwf_number:data.lwf_number,
                employees_contrib:data.employees_contrib,
                employer_contrib:data.employer_contrib,
                status:data.status

            })
    }
    // get labour welfare details
    let labourwelfareDetails=ref()
    const getLabourWelfareDetails=async()=>
    {
        let url =  window.location.origin + '/' +'api/payroll/fetchlwfSettingsDetails'
       await axios.get(url).then((res)=>{
        console.log(res.data.data)
        labourwelfareDetails.value=res.data.data

       })
 
    }  
    // SAVE EARNING SALARY COMPONENT
    const saveEarningSalary=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/CreatePayRollComponents';
        console.log(data)
        axios.post(url,
            {
                category_id:data.category_id,
                comp_type_id:data.typeOfComp,
                comp_nature_id:data.nature_id,
                comp_name:data.name,
                calculation_method_id:data.typeOfCalc,
                calculation_desc:data.calcValue,
                is_taxable:data.isTaxable,
                enabled_status:data.status,
                is_part_of_epf:data.isConsiderForEPF,
                is_part_of_esi:data.isConsiderForESI,
                is_part_of_empsal_structure:data.isPartOfEmpSalStructure?'1':'0',
                calculate_on_prorate_basis:data.isCalcShowProBasis? '1':'0',
                can_show_inpayslip:data.isShowInPayslip?'1':'0',

            })
    }
    // GET EARNINGS DETAILS
    let salaryDetails=ref([]);
    let adhocDetails=ref([]);
    let deuctionDetails=ref([]);
    let reimDetails=ref([])
    const getsalaryDetails=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/fetchPayRollComponents'
        await axios.get(url).then((res)=>{
            // console.log('EARNINGS')
            // console.log(res.data.data)
        //   res.data.data.map((ele,i)=>{
        //         if(ele.category_name==='earnings'){
        //             // let data =ele
        //             // salaryDetails.value=data;
        //             salaryDetails.value = ele;
        //             console.log(salaryDetails.value)
        //         }
        // })

        // res.data.data.forEach((data)=>{

        //     if(data.category_name==='earnings'){
        //         salaryDetails.value=data
        //         console.log('for each')
        //         console.log(salaryDetails)
        //     }

        // })

            reimDetails.value=res.data.data.filter((ele)=>   ele.category_name==='reimbursement' );;
         salaryDetails.value = res.data.data.filter((ele)=>   ele.category_name==='earnings' );
         adhocDetails.value = res.data.data.filter((ele)=>     ele.category_name==='adhoc');
         deuctionDetails.value=res.data.data.filter((ele)=>ele.category_name==='deduction');
            console.log(deuctionDetails,'Deduction')
            console.log(adhocDetails,'Adhoc')
            // res.data.data.forEach(element => {
            //     if(element.category_name==='earnings')
            //     {
            //         salaryDetails.value.push(element);
            //     }
            // });
        })

    }
    // save reimbursement salary component
    const saveReimbursement=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/AddReimbursementComponents';
        console.log(data)
        axios.post(url,
            {
                comp_name:data.comp_name,
                category_id:data.category_id,
                reimburst_max_limit:data.reimburst_max_limit,
                reimburst_status:data.status,
            })
    }

    // adhoc components
    const saveAdhocComponent=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/AddAdhocAllowanceDetectionComp';
        console.log(data)
        axios.post(url,
            {
                comp_name:data.comp_name,
                category_type:data.category_type,
                is_taxable:data.is_taxable,
                is_tptax_deduc_samemonth:data.is_tptax_deduc_samemonth,
                is_separate_payment_allowed:data.is_separate_payment_allowed,
                is_deduc_impacton_gross:'' 
            })
    }
    // off payroll deduction components
    const saveDeductionComponent=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/AddAdhocAllowanceDetectionComp';
        console.log(data)
        axios.post(url,
            {
                comp_name:data.comp_name,
                is_deduc_impacton_gross:data.is_deduc_impacton_gross,
                category_type:data.category_type,
                is_taxable:'0',
                is_tptax_deduc_samemonth:'0',
                is_separate_payment_allowed:'0',
               
            })
    }
    
    // get payroll group details
    let paygroupDetails=ref()
    const getPayGroupDetails=async()=>
    {
        let url =  window.location.origin + '/' +'api/payroll/fetchPayRollComponents'
        await axios.get(url).then((res)=>
        {
            console.log(res.data.data)
            console.log(res.data.data ? res.data.data : [])
            paygroupDetails.value=res.data.data ? res.data.data: []
        })

    }
    // save new salary structure
    const saveNewsalaryStructure=(data)=>{
        let url =    window.location.origin + '/' +'api/payroll/addPaygroupCompStructure';
        console.log(data) 
        axios.post(url,
            {
                user_code:service.current_user_code,
                client_id:data.client_id,
                structureName:data.structureName,
                description:data.description,
                pf:data.pf ?'1':'0',
                esi:data.esi ?'1':'0',
                tds:data.tds ?'1':'0',
                fbp:data.fbp ?'1':'0',
                selectedComponents:selectedarray,
            })
    }
    // save salary compnents
    let localSalComps=ref()
    function saveLocalSalComponents(data)
    {
        selectedarray.value = data;

        console.log(selectedarray.value ,'selectedarray');



        let val = data ;
       console.log(val)
    }



    const addNewEsi = ref({})

    const saveNewEsi = (data) => {
        console.log(data);
        axios.post('/Paygroup/CreatePayrollEsi', data)

    }






    // Salary Components - Earnings

    const dailogNewSalaryComponents = ref(false);
    const salaryComponentsUpdated = ref(false)
    const adhocComponentsUpdated = ref(false)

    const salaryComponents = reactive({
        typeOfComp: null,
        nature_id: null,
        name: null,
        nameInPayslip: null,
        typeOfCalc: null,
        calcValue:null,
        status: null,
        isPartOfEmpSalStructure: null,
        isTaxable: null,
        isCalcShowProBasis: null,
        isShowInPayslip: null,
        isConsiderForEPF: null,
        isConsiderForESI: null,
        category_id:null,
    })

    const adhocComponents = ref({
        category_id: 3,
        category_type: 'adhoc'
    })

    const deductionComponents = ref({
        category_id: 2,
        category_type: 'deduction'
    })

    const reimbursementComponents = ref({
       
    })


    const salaryComponentsSource = ref()

    const getSalaryComponents = (async () => {
        canShowLoading.value = true
        let salaryComponentUrl = `/Paygroup/fetchPayRollComponents`
        await axios.get(salaryComponentUrl).then(res => {
            salaryComponentsSource.value = res.data
            console.log(helper.filterSource(res.data, 3));
        }).finally(() => {
            canShowLoading.value = false
        })
    })

   

    const saveNewSalaryComponent = (key) => {
        dailogNewSalaryComponents.value = false
        canShowLoading.value = true
        let adhocUrl = '/Paygroup/AddAdhocAllowDetectComp'
        let reimbursmenturl = '/Paygroup/AddReimbursementComponents'
        var form_data = new FormData();

        if (key == 1) {

            if (salaryComponentsUpdated.value) {
                axios.post('/Paygroup/UpdatePayRollEarningsComponents', salaryComponents)
                    .finally(() => {
                        restChars()
                        canShowLoading.value = false
                        getSalaryComponents()
                    })
            } else {
                axios.post('/Paygroup/CreatePayRollComponents', salaryComponents)
                    .finally(() => {
                        restChars()
                        canShowLoading.value = false
                        getSalaryComponents()
                    })
            }
        } else
            if (key == 3) {
                for (var key in adhocComponents.value) {
                    form_data.append(key, adhocComponents.value[key]);
                }
                if (adhocComponentsUpdated.value) {
                    axios.post('/Paygroup/UpdateAdhocAllowDetectComp', form_data)
                        .finally(() => {
                            restChars()
                            canShowLoading.value = false
                            getSalaryComponents()
                        })
                } else {
                    axios.post(adhocUrl, form_data)
                        .finally(() => {
                            restChars()
                            canShowLoading.value = false
                            getSalaryComponents()
                        })
                }

            } else
                if (key == 2) {
                    for (var key in deductionComponents.value) {
                        form_data.append(key, deductionComponents.value[key]);
                    }
                    if (adhocComponentsUpdated.value) {
                        axios.post('/Paygroup/UpdateAdhocAllowDetectComp', form_data)
                            .finally(() => {
                                restChars()
                                canShowLoading.value = false
                                getSalaryComponents()
                            })
                    } else {
                        axios.post(adhocUrl, form_data)
                            .finally(() => {
                                restChars()
                                canShowLoading.value = false
                                getSalaryComponents()
                            })
                    }
                } else
                    if (key == 4) {
                        for (var key in reimbursementComponents.value) {
                            form_data.append(key, reimbursementComponents.value[key]);
                        }
                        axios.post(reimbursmenturl, form_data)
                            .finally(() => {
                                restChars()
                                canShowLoading.value = false
                                getSalaryComponents()
                            })
                    }
                    else {
                        console.log("No More options");
                    }
        console.log(form_data);

    }

    const editNewSalaryComponent = (boolean, data) => {
        console.log(data);
        dailogNewSalaryComponents.value = true
        salaryComponentsUpdated.value = boolean
        salaryComponents.name = data.comp_name,
            salaryComponents.id = data.id,
            salaryComponents.typeOfComp = data.comp_type_id,
            salaryComponents.nameInPayslip = data.comp_name_payslip,
            salaryComponents.typeOfCalc = parseInt(data.calculation_method_id),
            salaryComponents.amount = data.flat_amount,
            salaryComponents.status = data.status,
            salaryComponents.isPartOfEmpSalStructure = data.is_part_of_empsal_structure,
            salaryComponents.isTaxable = data.is_taxable,
            salaryComponents.isCalcShowProBasis = data.calculate_on_prorate_basis,
            salaryComponents.isShowInPayslip = data.can_show_inpayslip,
            salaryComponents.isConsiderForEPF = data.epf,
            salaryComponents.isConsiderForESI = data.esi
    }

    const editAdhocSalaryComponents = (currentRowData, key, boolean) => {
        console.log(currentRowData);
        if (key == 2) {
            adhocComponentsUpdated.value = true
            let type = { category_type: 'deduction' }
            deductionComponents.value = { ...type, ...currentRowData }
        } else
            if (key == 3) {
                adhocComponentsUpdated.value = true
                let type = { category_type: 'allowance' }
                adhocComponents.value = { ...type, ...currentRowData }
            } else
                if (key == 4) {
                    adhocComponentsUpdated.value = true
                    reimbursementComponents.value = { ...currentRowData }
                } else {
                    console.log("No More options");
                }
    }


    const deleteSalaryComponent = (recordID) => {
        confirm.require({
            message: "Do you want to delete this record?",
            header: "Delete Confirmation",
            icon: "pi pi-info-circle",
            acceptClass: "p-button-danger",
            accept: () => {
                canShowLoading.value = true;
                axios.post('/Paygroup/DeletePayRollComponents', {
                    comp_id: recordID
                })
                    .finally(() => {
                        toast.add({
                            severity: "error",
                            summary: "Deleted",
                            detail: "Salary Component Deleted",
                            life: 3000,
                        });
                        canShowLoading.value = false
                        getSalaryComponents()
                    });
            },
            reject: () => { },
        });
    }

    // modified new accounting code card details - GET METHOD
    let accountingCodeDetails=ref()
    const getAccountingData=async()=>{
        let url =  window.location.origin + '/' +'api/payroll/app-integrations/getExternalAppsList'
        await axios.get(url)
        .then((res)=>{
            console.log(res.data.data)
            accountingCodeDetails.value=res.data.data
        })
        .catch(err => {
            // Handle errors
            console.error(err);
        });
    }
    // Accounting Code

    const accountingCodeSource = ref([
        {accounting_soft_name:"Tally ERP",description:"If this authentication mode is turned on the cost booking will be happened via Tally."},
        {accounting_soft_name:"Zoho Books",description:"If this authentication mode is turned on the cost booking will be happened via Zoho Books."},
        {accounting_soft_name:"Sap",description:"If this authentication mode is turned on the cost booking will be happened via Sap."},
        {accounting_soft_name:"LEDGERS",description:"If this authentication mode is turned on the cost booking will be happened via Ledgers."},
    ])

    const accountingCode = ref({})

    const getAccountingSoftware = () => {
        let accountingSoftwareUrl = `/Paygroup/fetchPayrollAppIntegrations`
        axios.get(accountingSoftwareUrl).then(res => {
            accountingCodeSource.value = res.data.data
            console.log(res.data.data);
        })
    }

    const saveAccountingCode = (data) => {
        console.log(data);
        axios.post('/Paygroup/addPayrollAppIntegrations', data)
    }

    const enableAccountingSoftware = (data, checked) => {
        console.log(data, checked);
    }


    // Salary structure

    const dailogNewSalaryStructure = ref(false);

    const salaryStructure = ref({})

    const salaryStructureSource = ref()
    const employeeSource = ref()

    const getsalaryStructure = (async () => {
        let salaryyStructureUrl = `/Paygroup/fetchPayGroupEmpComponents`
        await axios.get(salaryyStructureUrl).then(res => {
            salaryStructureSource.value = Object.values(res.data)
        })
    })

    const addsalaryComponents = (selectedData) => {
        console.log(selectedData);
        salaryStructureSource.value = selectedData;
    }

    // const saveNewsalaryStructure = () => {
    //     console.log(salaryStructure);
    //     axios.post('/Paygroup/addPaygroupCompStructure', salaryStructure)

    //     // if (salaryComponentsUpdated.value) {
    //     //     axios.post('Paygroup/addPaygroupCompStructure', salaryComponents)
    //     // } else {
    //     //     axios.post('/Paygroup/addPaygroupCompStructure', salaryComponents)
    //     //         .finally(() => {
    //     //             restChars()
    //     //         })
    //     // }
    // }


    const restChars = () => {
        salaryComponents.typeOfComp = null,
            salaryComponents.name = null,
            salaryComponents.nameInPayslip = null,
            salaryComponents.typeOfCalc = null,
            salaryComponents.amount = null,
            salaryComponents.status = null,
            salaryComponents.isPartOfEmpSalStructure = null,
            salaryComponents.isTaxable = null,
            salaryComponents.isCalcShowProBasis = null,
            salaryComponents.isShowInPayslip = null,
            salaryComponents.isConsiderForEPF = null,
            salaryComponents.isConsiderForESI = null
    }
    return {
        // Varaible Declaration
        canShowLoading,activeTab,

        // General Payroll Settings

        generalPayrollSettings,getCurrentGeneralPayrollSettings,saveGeneralPayrollSettings,disableDropdown, payroll_frequency, filteredOptions, getPayFreqData,
        // Pf & ESI Setting - EPF

        addNewEpf, saveNewEpf,getEpfRule,epf_rule,epfSettings,epf_contribution,getEpfContribution,
        EPFSettings,getEPFDetails,epfDetails,nonepfDetails,getNonEPFDetails,

        // Pf & ESI Setting - ESI

        addNewEsi, saveNewEsi,getStateInfo,esiSettings,states,getDistrictInfo,districts_tn,ESISettings,
        getESIDetails,esiDetails,
        // Professional Tax
        proTaxSettings,saveprofessTaxSetting,getProfessionalTaxDetails,protaxDetails,
        // Labour Welfare Fund
        labourWelfareFundSettings,saveLabourWelfareSettings,getLabourWelfareDetails,labourwelfareDetails,

        // Salary Components - Earnings
        //EARNING SIDEBAR
        getSalarySidebar,calcType,categoryVal,compNature,compType,saveEarningSalary,getsalaryDetails,salaryDetails,

        dailogNewSalaryComponents, salaryComponents, salaryComponentsSource, getSalaryComponents, saveNewSalaryComponent, editNewSalaryComponent, deleteSalaryComponent,
        // Salary Components - Adhoc Components and Deduction and Reimbursement Components
        adhocDetails,deuctionDetails,
        adhocComponents, deductionComponents, reimbursementComponents, editAdhocSalaryComponents,reimDetails,
        saveReimbursement,saveAdhocComponent,saveDeductionComponent,user_code,
        // Salary Components - Accounting Code
        getAccountingSoftware, saveAccountingCode, accountingCode, accountingCodeSource, enableAccountingSoftware,


        // Salary Structure - Paygroup
        dailogNewSalaryStructure, salaryStructure, salaryStructureSource, getsalaryStructure, saveNewsalaryStructure, addsalaryComponents,
        getPayGroupDetails,paygroupDetails,localSalComps,saveLocalSalComponents,

        selectedarray,
        // accunting code
        getAccountingData,accountingCodeDetails
    }

})
