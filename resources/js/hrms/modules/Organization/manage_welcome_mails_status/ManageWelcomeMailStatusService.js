import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const useManageWelcomeMailStatusStore = defineStore("ManageWelcomeMailStatusStore", () => {


    // Variable Declarations

    const loading = ref(false);
    const sendWelcomeMail_Status_diaconfirmation = ref(false);

    const array_employees_list = ref();

    async function getManageWelcomeMailStatus(){
        loading.value = true;
        await axios.get('/getAllEmployees_WelcomeMailStatus_Details')
        .then((res)=>{
            array_employees_list.value = res.data ;
            console.log("testing",array_employees_list);
        
        })
        .finally(()=>{
            loading.value = false;
        })
    }

       function send_WelcomeMail(user_code) {
        console.log("sendMail_employeePayslip() : Sending mail to user : " + user_code);
        loading.value = true
        sendWelcomeMail_Status_diaconfirmation.value= false;
        axios.post('/send_WelcomeMailNotification', {
            user_code: user_code,
        }).then((response) => {
            console.log(" Response [send_WelcomeMail] : " + response.data);
        })
            .catch((data) => {
                console.log(data);

            }).finally(()=>{
                getManageWelcomeMailStatus();
                loading.value = false;
            })

    }


    return {

        // Varaible Declartion
        array_employees_list,loading,sendWelcomeMail_Status_diaconfirmation,


        // Functions
        getManageWelcomeMailStatus,send_WelcomeMail,

    };

});
