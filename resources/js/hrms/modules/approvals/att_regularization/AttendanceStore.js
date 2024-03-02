import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const UseAttendanceStore = defineStore("UseAttendance",()=>{

    const canShowLoadingScreen =ref(false);


    return{
     canShowLoadingScreen
    }
})