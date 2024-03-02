import {defineStore} from "pinia";
import axios from "axios";
import { ref } from "vue";


export const Service = defineStore("Service", () => {

    const current_user_id = ref()
    const current_user_code = ref()
    const current_user_name = ref()
    const current_user_role = ref()
    const current_user_is_ssa= ref()
    const current_client_name = ref();
    const current_client_code = ref();
    const current_client_id = ref();
    // const current_session_client_id= ref()


     axios.get('/currentUser').then(res => {
        current_user_id.value = res.data
        //  console.log("service class" + res.data);
    })

    axios.get('/currentUserName').then(res => {
        current_user_name.value = res.data
        //  console.log("service class" + res.data);

    })


    axios.get('/currentUseris_ssa').then(res => {
        current_user_is_ssa.value = res.data
         console.log("service class" + res.data);

    })

     axios.get('/currentUserCode').then(res => {
        current_user_code.value =  res.data

    })

    axios.get('/currentUserRole').then(res => {
        current_user_role.value = res.data

    })

    const getCurrentUserCode = async()=>{
        return await axios.get('/currentUserCode')
    }

    // const  getclient_id = async() =>{

    //     return await axios.get( `${window.location.origin}/getCurrentSessionClientId`)
    // .then(res => {
    //         current_session_client_id.value = res.data
    //     })

    // }


    const getBankList = () => {
        return axios.get(`/db/getBankDetails`)
    }

    const getCountryList = () => {
        return axios.get(`/db/getCountryDetails`)
    }
    const getStateList = () => {
        return axios.get(`/db/getStatesDetails`);
    }
    const ManagerDetails = () => {
        return axios.get(`/fetch-managers-name`);

    }
    const DepartmentDetails = () => {
        return axios.get(`/fetch-departments`);

    }

    const getMaritalStatus = () => {
        return axios.get(`/fetch-marital-details`);

    }

    const current_session_client_id  = () => {
        return axios.get('/getCurrentSessionClientId')
    }


    const getBloodGroups = () => {
        return axios.get(`/fetch-blood-groups`);
    }

    const getAllEmployees = () => {
        return axios.get(`/get-all-employees`);
    }



    // Helper

    function capitalizeFLetter(name) {
        let result = name.charAt(0).toUpperCase() +
            name.slice(1)
            return result
    }

    const colors = [
        'bg-orange-400',
        'bg-emerald-400',
        'bg-yellow-400',
        'bg-rose-400',
        'bg-cyan-400',
        'bg-amber-400',
        'bg-red-400',
        'bg-blue-400',
        'bg-pink-400',
        'bg-green-400',
        'bg-fuchsia-400',
    ];

    const getBackgroundColor = (index) => {
       // console.log(index);
        return colors[index % colors.length];
    };

    return {

        // varaible Declarations

        current_user_id,
        current_user_name,
        current_user_code,
        current_user_role,
        current_user_is_ssa,
        current_session_client_id,

        getCurrentUserCode,
        getBankList,
        getCountryList,
        getStateList,
        ManagerDetails,
        getBloodGroups,
        DepartmentDetails,
        getMaritalStatus,
        getAllEmployees,

        capitalizeFLetter,
        getBackgroundColor,
        current_client_name,
        current_client_code,
        current_client_id

        // getclient_id



    };
});
