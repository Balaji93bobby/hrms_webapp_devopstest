import axios from "axios";
import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { reactive, ref } from "vue";


export const loanSettingsStore = defineStore("loanSettings", () => {

    const CreateLoanWithNewFrom = ref(1);

    const loan_ID = ref();

    function viewHistory(data){

    }
    //

    async function SendEnableAndDisable(Status,loanType){
        let status = Status;
        let LoanType = loanType;
        let Loan_ID = loan_ID.value;
        console.log(Status);
        await axios.post('/enable-or-disable-loan-settings',{
            Status : status,
            loanType : LoanType,
            loan_ID : Loan_ID
        }).then(()=>{
        })


    }

    async function sendSavechanges(setting_id,empid){
        let settings = setting_id;
        let empDetails= empid; 
        await axios.post('/salAdvSettingEdit',{
            settings_id:settings,
            empID:empDetails
        }).then(()=>{

        })
    }


    return{

        CreateLoanWithNewFrom,
        viewHistory,
        SendEnableAndDisable,loan_ID,
        sendSavechanges
    }

});
