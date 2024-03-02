import { defineStore } from 'pinia';
import axios from 'axios';
import { ref , reactive } from 'vue';


export const AdminRolePermissionStore = defineStore('AdminRolePermission',()=>{

    // variables
    const arrayRoleDetails = ref();
    const rolesPermission =  ref(1);

    async function getRoleDetails(){

        axios.get('/getRoleDetails').then((res)=>{
            arrayRoleDetails.value = res.data;
            console.log(arrayRoleDetails.value);
        })
    }

    return{
        arrayRoleDetails,
        rolesPermission,

        getRoleDetails

    }
})
