import { defineStore } from 'pinia';
import axios from 'axios';
import { ref , reactive } from 'vue';


export const UseRolePermissionStore = defineStore('UseRolePermissionStore',()=>{

    // variables
    const rolesPermission = ref(1);
    // const
    const arrayRoleDetails = ref();
    const LoadingScreenStatus = ref();

    const AdminPrivilege = ref();

    async function getAdminRolesDetails(){
        await axios.get('http://localhost:3000/useRolesAndPermission').then((res)=>{
            AdminPrivilege.value = res.data;
        })
    }

    async function getRoleDetails(){

        axios.get('/getRoleDetails').then((res)=>{
            arrayRoleDetails.value = res.data;
            console.log(arrayRoleDetails.value);
        })
    }


    async function removeRoleDetails (roles_name,user_id){
    console.log(roles_name,user_id);
    let url = '/removeRoleToUsers';
        await axios.post(url,{
            roles_name:roles_name,
            user_id:user_id
        }).then((res)=>{})
    }
    // Events

    async function saveRoleDetails(){

    }



    return{
        rolesPermission,
        arrayRoleDetails,
        AdminPrivilege,

        // function
        getRoleDetails,
        removeRoleDetails,
        getAdminRolesDetails

    }
})
