/*
    function needed:
    getPendingOnboardingFormStatus(client_code);

    //Get the form details of specified user
    getOnboardingFormDetails(user_code);


*/
import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const UseOnboardingFromService = defineStore('OnboardingFromService',()=>{

    const array_OnboardingFromDetails = ref([]);
    const loading = ref(false);


    // Events

    async function getOnboardingFormDetails(){
        console.log("Getting Onboarding from details")
        loading.value = true;
        await axios.get('http://localhost:3000/OnboardingFormDetails').then((res)=>{
            array_OnboardingFromDetails.value = res.data
        }).finally(()=>{
            loading.value = false;
        })
    }

    async function EditOnboardingFormDetails(){
        console.log("testing EditOnboarding form details " );
         window.location.href = "http://localhost:3000/OnboardingFormDetails"
        //  profile

    }

    async function DeleteOnboardingFormDetails(selected_Id){
        console.log("Delete Onboarding Form Details",selected_Id);
        // await
        await axios.post('http://localhost:3000/DeleteOnboardingFormDetails',{
            selected_Id:selected_Id
        }).then((res)=>{
            console.log(res.data);
        }).finally(()=>{

        })
    }


    return{
        array_OnboardingFromDetails,loading,

        getOnboardingFormDetails,EditOnboardingFormDetails,DeleteOnboardingFormDetails
    }
});

