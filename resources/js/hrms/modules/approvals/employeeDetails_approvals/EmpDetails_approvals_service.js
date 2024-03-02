import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const UseEmpDetailApprovalsStore = defineStore("EmpDetailApprovalsStore",()=>{

     // Variable Declarations
     const array_EmpDetails_list = ref();
     const canShowLoadingScreen = ref();

      // Events

      async function getEmpDetails_list(){
        canShowLoadingScreen.value = true;
        await axios.get("/fetch-proof-doc").then((res)=>{
            console.log(res.data);
            array_EmpDetails_list.value = res.data;
            console.log(array_EmpDetails_list.value);
        }).finally(()=>{
            canShowLoadingScreen.value = false;
        })
      }


      return{
        // Variable
        array_EmpDetails_list,
        canShowLoadingScreen,

        // function
        getEmpDetails_list,

      };
});
