import {defineStore} from "pinia";
import axios from "axios";
import { ref } from "vue";

export const EmployeePayables = defineStore("employeePayables", () => {

    const arrayPending = ref();

    // event 

    async function getPendingStatus(){
        await axios.get('/get-pending-requested-for-loan-and-advance').then((res)=>{
            arrayPending.value = res.data;
            console.log(arrayPending.value);
        }).finally(()=>{
        });
    }

    return{
        arrayPending,

        getPendingStatus
    }

});
