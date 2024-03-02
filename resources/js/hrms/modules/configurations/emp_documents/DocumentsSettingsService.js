import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";
import {Service} from '../../Service/Service'

export const useDocumentSettingsStore = defineStore("DocumentSettings", () => {
    // Variable Declarations
    const array_emp_documents_details = ref()
    const loading = ref(false);
    const service =  Service()


    const is_onboarding_doc = ref();
    const updatedSource = reactive([])

    // const

    // Events

    async function getEmployeesDocumentsDetails() {
        loading.value =true;
        await axios.get('/documents/employee_doc_settings').then((res) => {
            array_emp_documents_details.value = res.data.data;
            // console.log("getEmployeesDocumentsDetails()" + res.data);
        }).finally(() => {
            loading.value = false;
        })
    }

    async function updateDocumentState(document){
        console.log("Updating doc status for : "+document.is_onboarding_doc);
        console.log("Updating doc status for : "+document.is_mandatory);

    }

    function submitDocumentSettings(name) {
        console.log("testing:", name);
        let url = '/documents/update_employee_doc_settings'
        axios.post(url,array_emp_documents_details.value
        ).then((res) => {
            console.log(res.data.status);
            if (res.data.status == "success") {
                Swal.fire({
                    title: res.data.status = "Success",
                    text: res.data.message,
                    icon: "success",
                    showCancelButton: false,
                }).then((result) => {
                    // window.location.reload();
                });

            }
            else if (res.data.status == "failure") {
                Swal.fire({
                    title: res.data.status = "Failure",
                    text: res.data.message,
                    icon: "error",
                    showCancelButton: false,
                }).then((result) => {
                    window.location.reload();
                });
            }
            // console.log(res.data);
        }).finally(()=>{
            updatedSource.splice(0,updatedSource.length)
        })
    }




    return {

        // Varaible Declartion

        array_emp_documents_details, loading, is_onboarding_doc,

        // Functions
        getEmployeesDocumentsDetails, submitDocumentSettings, updateDocumentState

    };
});
