import { defineStore } from 'pinia';
import axios from 'axios';
import { ref , reactive } from 'vue';


export const UseRolePermissionServie = defineStore('RolePermissionServie',()=>{

    // Variable Declarations
    const array_RolePermission_data = ref();
    const AllPermission = ref();

    const CreatingNewJobRole = reactive({
        Role_Title:'',
        Role_description:'',
        Assign_to:'',
    });



    const getAllPermissions = () => {

        axios.get('/getAllPermissions').then(res => {
            AllPermission.value = res.data;
            console.log(allpermission);
        });

    };
     const saveCreateNewJobRole = ()=>{
        axios.post('',).finally(()=>{

        })
     };

    return{

        // variable Declaration
        getAllPermissions,saveCreateNewJobRole,


//
        // function
        AllPermission,CreatingNewJobRole,array_RolePermission_data


    }
})

