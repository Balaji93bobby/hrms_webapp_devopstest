import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const useloginPage = defineStore("LoginPage", () => {

    const login_page_forgotPassword = ref(1);
    
    return{
        login_page_forgotPassword

    }
})