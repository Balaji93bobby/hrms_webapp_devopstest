import { defineStore } from "pinia";
import { ref, reactive ,watch } from "vue";
import axios from "axios";

export const useModuleSettingsStore = defineStore("useModuleSettingsStore", () => {


    const currentlySelectedModule = ref()
    const employeeAssignDialog = ref(false);


    const arrayModuleSettingsDetails = ref();

    const client_details = ref();

    const currentlySelectedClient = ref();

    const canshowloading = ref(false);

    async function getModuleSettings(){
        canshowloading.value = true;

            await axios.get('/getClient_AllModuleDetails').then((res)=>{
                console.log(res.data);
                // if(res.data.data[1]){
                    arrayModuleSettingsDetails.value =res.data.data;
                    console.log( "mobile settings",arrayModuleSettingsDetails.value );
                // }
            }).finally(()=>{
                canshowloading.value = false;
            })
    }

     const getSessionClient = async () => {
        await axios.get('session-sessionselectedclient').then(res => {
            console.log(res.data);
            currentlySelectedClient.value = res.data;
            if(res.data.id){
                client_details.value = res.data; //Store the client id here for future use
                // getMobileSettings(client_id.value);
            }
        })
    }

    const getClient_AllModulePermissionDetails=()=>{
        axios.get('/getClient_AllModulePermissionDetails').then((res)=>{
            console.log(res.data);
        });
    }

    const saveEnableDisableSetting = async(item,status)=>{

        let modulesettings = {
            module_id:item.module_id ? item.module_id : item.module_id ? '' : item.value.module_id,
            module_status:status,
            sub_module_id: item.sub_module_id ? '' : item.module_id ? '' : item.value.sub_module_id,
            sub_module_status:item.sub_module_status? '' : item.module_id ? '' : item.value.sub_module_status,
        }
        canshowloading.value = true;

        await axios.post('/update_AllClientModuleStatus',modulesettings).then((res)=>{

            console.log("Status received : "+res.data.status);

            if(res.data.status == "success")
            {
                item.status = status; //Toggle the button
            }

        }).finally(()=>{
            canshowloading.value = false;
            getModuleSettings();
            getClient_AllModulePermissionDetails();

        })

    }

    const updateEmployeesPermissionStatus =()=>{

        axios.post('/updateEmployeesPermissionStatus',{
            app_sub_modules_link_id:app_sub_modules_link_id,
            selected_employees_user_code:selected_employees_user_code
        }).then(()=>{

        }).finally(()=>{

        })

    }

    return {
        currentlySelectedModule,
        employeeAssignDialog,
        arrayModuleSettingsDetails,
        getSessionClient,
        saveEnableDisableSetting,
        canshowloading,
        client_details,

        // function
        updateEmployeesPermissionStatus,

        getModuleSettings,

        getClient_AllModulePermissionDetails
    };
});
