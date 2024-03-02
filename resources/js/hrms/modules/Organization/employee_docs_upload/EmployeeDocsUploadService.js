import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import moment from "moment";

export const Service = defineStore("Service", () => {

    // Notification service
    const toast = useToast();

    // Variable Declarations

    const active_employees_data = ref()
    const yet_to_active_employees_data = ref()
    const exit_employees_data = ref()

    // Events

    const ajax_active_employees_data = () => {

        let url = window.location.origin + "/vmt-activeemployees-fetchall";

        console.log("AJAX URL : " + url);

        axios.get(url).then((response) => {
            console.log("Axios : " + response.data);
            active_employees_data.value = response.data;
          });

    }
    const ajax_yet_to_active_employees_data = () => {

        let url = window.location.origin + "/vmt-yet-to-activeemployees-fetchall";

        console.log("AJAX URL : " + url);

        axios.get(url).then((response) => {
            console.log("Axios : " + response.data);
            yet_to_active_employees_data.value = response.data;
          });

    }
    const ajax_exit_employees_data = () => {

        let url = window.location.origin + "/vmt-exitemployees-fetchall";

        console.log("AJAX URL : " + url);

        axios.get(url).then((response) => {
            console.log("Axios : " + response.data);
            exit_employees_data.value = response.data;
          });

    }




    return {

        // Varaible Declartion

        active_employees_data, yet_to_active_employees_data, exit_employees_data,

        // Events

        ajax_active_employees_data, ajax_yet_to_active_employees_data, ajax_exit_employees_data




    };
});
