import axios from 'axios';
import {ref,reactive} from  'vue';
import {defineStore} from "pinia";
import {Service} from '../Service/Service';
import { profilePagesStore } from "./stores/ProfilePagesStore";

export const UseEmployeeDocumentManagerService = defineStore("EmployeeDocumentManagerService", () => {
    // variable
    const getEmployeeDetails = Service();
    const loading = ref(false);

    const getEmployeeDoc = ref([]);
    const uploadDocs = ref();
    const getEmpdocPhoto = ref();
    const usercode = profilePagesStore();


    const EmployeeDocs_upload = ref({
        AadharCardFront: null,
        AadharCardBack: null,
        PanCardDoc: null,
        DrivingLicenseDoc: null,
        EductionDoc: null,
        VoterIdDoc: null,
        RelievingLetterDoc: null,
        PassportDoc: null,
        save_draft_messege: null,
    });


const fetch_EmployeeDocument = async() => {
    let user_code = usercode.employeeDetails.user_code;
    await getEmployeeDetails.getCurrentUserCode().then(code=>{
      user_code = code.data
    })
    loading.value = true ;
    await axios.post('/employee-documents-details', {
        user_code:  user_code
    }).then((res) => {
        // console.log(res.data);
        getEmployeeDoc.value = res.data.data
        console.log("employee document : " , getEmployeeDoc.value);
    }).finally(() => {
        loading.value = false;
        console.log("completed");
    })
}
    return{
        // variable
        EmployeeDocs_upload,getEmployeeDetails,getEmployeeDoc,getEmpdocPhoto,

        // function
        fetch_EmployeeDocument,loading
    }
})
