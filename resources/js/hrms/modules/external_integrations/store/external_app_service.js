import { defineStore } from "pinia";
import { ref, reactive, inject } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import { Service } from "../../Service/Service";

export const useExtAppService = defineStore("useExtAppService", () => {
    // NOTIFICATION
    const toast = useToast();
    const service = Service();

    const externalAppsList = ref();

    const getExternalAppsList = async () => {
        let url = window.location.origin + '/' + 'api/payroll/app-integrations/getExternalAppsList'
        await axios.get(url)
            .then((res) => {
                externalAppsList.value = res.data.data
                console.log(externalAppsList)
            })
            .catch(err => {
                // Handle errors
                console.error(err);
            });
    }

    // external app integration logo
    const extapp_logo_arr=ref([
        {
            id:'1',
            name:'Tally ERP',
            logo_path:'../../../../../public/assets/external_apps/tally_image.png'
        },
        {
            id:'2',
            name:'Zoho Books',
            logo_path:'../../../../../public/assets/external_apps/zoho_books_img.png'
        },
        {
            id:'3',
            name:'SAP',
            logo_path:'../../../../../public/assets/external_apps/sap_img.png'
        },
        {
            id:'4',
            name:'Ledgers',
            logo_path:'../../../../../public/assets/external_apps/ledgers_img.png'
        }
    ])
    const viewExtAppLogo=(extapp_name)=>
    {
        extapp_logo_arr.value.map(({name,logo_path})=>{
            if(name===extapp_name)
            {
                return logo_path
            }
        })
    }

    return {

        // functions
        getExternalAppsList,
        viewExtAppLogo,
        // variables
        externalAppsList,
        extapp_logo_arr,

    }
})

