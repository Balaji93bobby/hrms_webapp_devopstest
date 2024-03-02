import axios from "axios";
import { defineStore } from "pinia";
import { Service } from "../../Service/Service";
import { useRouter, useRoute } from "vue-router";
import { onMounted, onUpdated } from 'vue';
import { ref,watch } from "vue";

/*
    This Pinia code will store the ajax values of the
    profile page.
    This code is called from Parents onMounted method asynchronously


*/

export const profilePagesStore = defineStore("employeeService", () => {

    const employeeDetails = ref([])

    const loading_screen = ref(true)

    const router = useRouter();
    const route = useRoute();
    const profile = ref();
    const profile_img = ref();

    const user_code = ref();

    const user_id = ref();

    const service = Service();

    const admin_profile_photo = ref();

    function getURLParams_UID() {

        if(route.params.user_code){
            return route.params.user_code
        }else{
            return service.current_user_id
        }
    }

    const getProfilePhoto = () => {

        axios
        .post("/profile-pages/getProfilePicture", {
            user_id:getURLParams_UID(),
        })
        .then((res) => {
            // console.log("profile :?", res.data.data);
            profile.value = res.data.data;
            // console.log(profile.value);

            if(service.current_user_role ==1 && service.current_user_role == employeeDetails.value.org_role || service.current_user_role ==2 && service.current_user_role == employeeDetails.value.org_role){
                get_current_profile();
                console.log(service.current_user_role,'service.current_user_role');
            }
        })
        .finally(() => {

        });
    };

    const get_current_profile = () =>{

        axios.post('/profile-pages/getAdminProfilePicture',{
            user_id:service.current_user_id
        }).then((res)=>{
            profile_img.value = res.data.data
        })
    }



    async function fetchEmployeeDetails(userId) {
        loading_screen.value = true;
        let url = '/profile-pages-getEmpDetails'
        // console.log("Getting employee details")
        await axios.get(`${url}/${getURLParams_UID()}`).then(res => {
            // console.log("fetchEmployeeDetails() : " + res.data);
            loading_screen.value = false;
            employeeDetails.value = res.data
            // console.log("Current User code :" + res.data.user_code);
        }).catch(e => console.log(e)).finally((res) => {
            getProfilePhoto()
            // console.log("completed")
            get_current_profile()
        })


    }

    return {

        // varaible Declarations
        fetchEmployeeDetails,
        employeeDetails,
        loading_screen,
        user_code,
        getProfilePhoto,
        profile,
        profile_img,
        user_id,
        getURLParams_UID,
        get_current_profile

    };
});






