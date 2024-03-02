import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import moment from "moment";

export const offer_letter = defineStore("Service", () => {

    // Varaible Declartions


    const candidate_details =reactive({
        candidate_name:'',
        candidate_email:'',
        candidate_mobile_no:'',

    })

    const salary_details =reactive({
        salary_structure:false,
        pay_in_rupee:'',
        pay_in_words:'',
        specification:''

    })

    const role_details =reactive({
        designation:'',
        exp_doj:'',
        location:'',
        offer_exp_date:''
    })



    return {
        // Varaible return

        candidate_details,salary_details,role_details
    }


})
