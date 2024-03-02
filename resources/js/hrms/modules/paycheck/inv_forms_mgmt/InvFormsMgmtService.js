import {defineStore } from "pinia";
import {ref, reactive} from "vue";
import axios from "axios";




export const useInvFormsMgmt = defineStore("InvFormsMgmt", () => {

  const fileuploaded = ref();

  async function uploadInvestmentForm(formData){

    await axios.post('/investments/ImportInvestmentForm_Excel', {

    }).then((response) => {
        // console.log("Response [getAllEmployeesPayslipDetails] : " + JSON.stringify(response.data.data));

        fileuploaded.value = response.data.data;
    });
  }


  return{
    uploadInvestmentForm,
  }


});
