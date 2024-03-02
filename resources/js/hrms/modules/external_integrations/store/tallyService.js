import { defineStore } from "pinia";
import { ref, reactive, inject } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import { Service } from "../../Service/Service";

export const useTallyService = defineStore("useTallyService", () => {
    // NOTIFICATION
    const toast = useToast();
    const service = Service();
    const canShowLoading  = ref(false);
    /*
    getLegalEntities()

    generateAPIKey()

    getCostBookingNature()

    getCostBookingBifurcation()

    getPayrollComponents()

    downloadExcel()

    connectToTally()

    */

    const vm_tally_integration = ref({
        selected_legal_entity : null,
        generated_access_token : null,
        selected_cost_booking_nature : null,
        selected_cost_booking_bifurcation : null,
        selected_payroll_components : null,
        tally_json_mapping : null
    });

    const json_tally_mapping_arr = ref([
        {
            acc_head:'Salaries',
            gl_head:'',
            gl_name:'',
            debit:'₹30,600',
            credit:'₹0.00'
        },
        {
            acc_head:'EPF Payables',
            gl_head:'',
            gl_name:'',
            debit:'₹30,600',
            credit:'₹0.00'
        },
        {
            acc_head:'ESIC Payables',
            gl_head:'',
            gl_name:'',
            debit:'₹30,600',
            credit:'₹0.00'
        },
        {
            acc_head:'LWF Payables',
            gl_head:'',
            gl_name:'',
            debit:'₹30,600',
            credit:'₹0.00'
        }
    ])


    const addTallyComponent=()=>{
        let tallyComponent = {
            acc_head:'epf',
            gl_head:'',
            gl_name:'',
            debit:'₹30,600',
            credit:'₹0.00'

        }
        json_tally_mapping_arr.value.push(tallyComponent);
    }

    const deleteTallyComponent=(data)=>{
        console.log(data)
        let indexValue=json_tally_mapping_arr.value.indexOf(data)
        console.log(indexValue)

       json_tally_mapping_arr.value.splice(indexValue,1)
    }

    const single_json_mapping = ref({

    });

    const json_mapping_array = ref([]);

    const externalAppsList = ref();
    const tally_internal_name = ref('tally_erp');

    // legal entities dropdown
    const clients_list = ref()
    const getLegalEntities = async () => {

        let url = window.location.origin + '/' + 'api/clients/getAllClients'
        await axios.get(url)
            .then((res) => {
                clients_list.value = res.data;
            })
            .catch(err => {
                // Handle errors
                console.error(err);
            });
    }

    function onRemoveComponentMappingRow(){

    }

    function onAddComponentMappingRow(){

    }

    // generate api key
    const generateAPIKey = () => {
        console.log("Generating API token using the details ");
        canShowLoading.value =  true;

        let url = window.location.origin + '/' + 'api/payroll/app-integrations/generateExternalApp_AccessToken'
        axios.post(url,
            {
                client_code: vm_tally_integration.value.selected_legal_entity,
                externalapp_internalname: tally_internal_name.value,
                validity: null,
            })
            .then((res) => {
                vm_tally_integration.value.generated_access_token = res.data.access_token;
                console.log("Tally token generated : "+res.data.access_token);
                canShowLoading.value =  false;
            })
            .catch(err => {
                // Handle errors
                console.error(err);
            });

    }
    // booking nature dropdown
    const getCostBookingNature = () => {
        // let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        // await axios.get(url)
        // .then((res)=>{
        //     console.log(res)
        // })
        // .catch(err => {
        //     // Handle errors
        //     console.error(err);
        // });
    }
    // booking bifurcation dropdown
    const getCostBookingBifurcation = async () => {
        // let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        // await axios.get(url)
        // .then((res)=>{
        //     console.log(res)
        // })
        // .catch(err => {
        //     // Handle errors
        //     console.error(err);
        // });
    }
    // payroll components dropdown
    const getPayrollComponents = () => {
        // let url =  window.location.origin + '/' +'api/payroll/getPayrollSettingsDropdownDetails'
        // await axios.get(url)
        // .then((res)=>{
        //     console.log(res)
        // })
        // .catch(err => {
        //     // Handle errors
        //     console.error(err);
        // });
    }

    return {

        // functions

        getLegalEntities,
        getCostBookingNature,
        getCostBookingBifurcation,
        getPayrollComponents,
        generateAPIKey,
       
        addTallyComponent,
        deleteTallyComponent,

        // variables

        clients_list,
        vm_tally_integration,
        externalAppsList,
        tally_internal_name,
        json_tally_mapping_arr,

    }
})

