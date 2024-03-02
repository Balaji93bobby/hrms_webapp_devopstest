import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";
import { Service } from "../../Service/Service";

export const usePMSFormsMgmtStore = defineStore("pmsFormsMgmtStore", () => {
    //variable declaration
    const array_pms_forms_authors_list = ref([]);
    const array_pms_forms_usage_details = ref();
    const pms_form_template_details = ref();

    // async function getAllEmployeesList() {
    //     loading.value = true;

    //     //  array_all_employees_list

    //     await service
    //         .getAllEmployees()
    //         .then((result) => {
    //             allEmployees.value = result.data;
    //             console.log("testing data:", result.data);
    //         })
    //         .then(() => {
    //             loading.value = false;
    //         });
    // }

    // async function getEmployeePMSHrview(response) {
    //     loading.value = true;

    //     await axios
    //         .post("getEmployeePMSHrview", {
    //             pms_kpiform_id: array_pms_forms_list.pms_kpiform_id,
    //         })
    //         .then(() => {
    //             array_pms_forms_list.value = response.data;
    //             console.log("testing form details : ", array_pms_forms_list);
    //         });
    // }

    // const downloadForm = async (form_id) => {
    //     console.log(form_id);
    //     axios
    //         .post("/get-employee-PMS-form-template-excel", {
    //             form_id: form_id,
    //         })
    //         .then((res) => {
    //             console.log(res);
    //         })
    //         .finally(() => {
    //             console.log("form id sent");
    //         });
    // };

    // async function getAllPMSFormsList() {

    //     await axios
    //         .get("/pms-forms-mgmt/get-all-PMS-form-Templates")
    //         .then(function (response) {

    //             if (response.data.status == "success") {
    //                 //array_pms_forms_list.value = Object.entries(response.data.data);
    //               //  array_pms_forms_list.value = Object.entries(response.data.data);
    //                 //console.log("getPMSFormsList() Data : "+response.data.data);
    //             } else if (response.data.status == "failure") {

    //             }

    //             console.log("getPMSFormsList() status : " + response.data.status);
    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         })
    //         .finally(function () {

    //         });
    // }

    async function getAllPMSFormAuthors(){

        await axios.get('/pms-forms-mgmt/get-all-PMS-form-Authors')
                .then(function (response){
                    array_pms_forms_authors_list.value  = Object.entries(response.data.data);
                }).catch(function (error){
                    console.log("Error : "+error);
                }).finally(function (){

                });
    }

    async function getPMSFormUsageDetails(pms_form_id){

        await axios.post('/pms-forms-mgmt/getPMSFormUsageDetails',{
                        "pms_form_id" : pms_form_id
                })
                .then(function (response){
                    array_pms_forms_usage_details.value = response.data;
                })
                .catch((error)=>{
                    console.log("Error getPMSFormUsageDetails() : "+error);
                    array_pms_forms_usage_details.value = null;
                })
                .finally(()=>{

                });
    }

    async function getPMSFormTemplateDetails(pms_form_id) {
        console.log("Getting PMS form for the form_id : " +pms_form_id);

        await axios.post('/pms-forms-mgmt/getPMSFormTemplateDetails',{
                    "pms_form_id" : pms_form_id
                })
                .then( (response)=>{
                    console.log("getPMSFormTemplateDetails() : "+response.data)
                    pms_form_template_details.value = response.data;
                })
                .catch( (error)=>{
                    console.log(error);
                    pms_form_template_details.value = null;

                })
                .finally( ()=>{


        });

    }

    return {


        array_pms_forms_authors_list, array_pms_forms_usage_details, pms_form_template_details,

        getAllPMSFormAuthors,getPMSFormUsageDetails,getPMSFormTemplateDetails


    };
});
