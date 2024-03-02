import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "axios";

export const useManageEmployeesStore = defineStore("manageEmployees", () => {


    // Variable Declarations
    const array_active_employees = ref()
    const yet_to_active_employees_data = ref()
    const exit_employees_data = ref()

    // Events

    async function getActiveEmployees(){

        let url = window.location.origin + "/vmt-activeemployees-fetchall";

        console.log("AJAX URL : " + url);

        await axios.get(url).then((response) => {
            array_active_employees.value = response.data;
          });
    }

    async function ajax_yet_to_active_employees_data(){

        let url = window.location.origin + "/vmt-yet-to-activeemployees-fetchall";

        console.log("AJAX URL : " + url);

        await axios.get(url).then((response) => {
            console.log("Axios : " + response.data);
            yet_to_active_employees_data.value = response.data;
          });

    }

    async function ajax_exit_employees_data(){

        let url = window.location.origin + "/vmt-exitemployees-fetchall";

        console.log("AJAX URL : " + url);

       await axios.get(url).then((response) => {
            console.log("Axios : " + response.data);
            exit_employees_data.value = response.data;
          });

    }




    return {

        // Varaible Declartion

        array_active_employees, yet_to_active_employees_data, exit_employees_data,

        // Functions

        getActiveEmployees, ajax_yet_to_active_employees_data, ajax_exit_employees_data




    };
});
