import axios from "axios";
import { defineStore } from "pinia";
import { Service } from "../../Service/Service";
import { useRouter, useRoute } from "vue-router";
import { onMounted, onUpdated, reactive } from 'vue';
import { ref, watch,inject } from "vue";
import { profilePagesStore } from "../stores/ProfilePagesStore";
import dayjs from "dayjs";
/*
    This Pinia code will store the ajax values of the
    profile page.
    This code is called from Parents onMounted method asynchronously


*/

export const documentStore = defineStore("documentStore", () => {

    const doc_details = ref();
    const useprofile = profilePagesStore();
    const Aadhar_Card_Front = ref();
    const documentPath = ref();
    const swal = inject("$swal");
    const canShowLoading=ref(false)
    const emp_docs = reactive({
        imageUrl:"",
        emp_doc:"",
        name:"",
        gender:"",
        dob:"",
        address:"",
        father_name:"",
        blood_group_id:"",
        spouse:"",
        gaurdian_name:"",
        gaurdian_type:"",
        doc_type:"",
        aadhar_number:"",
        aadhar_enrollment_number:"",
        aadhar_address:"",
        pan_number:"",
        license_number:"",
        license_issue_date:"",
        license_expires_on:"",
        license_address:"",
        passport_country_code:"",
        passport_type:"",
        passport_number:"",
        passport_date_of_issue:"",
        passport_place_of_issue:"",
        passport_place_of_birth:"",
        passport_expire_on:"",
        voter_id_issued_on:"",
        voterid_emp_address:"",
        voterid_number:"",
    });



    function getdoc_details() {
        axios.post('/profile-pages/getEmployeeDocumentDetails', {
            user_id: useprofile.getURLParams_UID()
        }).then((res) => {
            doc_details.value = res.data.data;
        }).finally(() => {

        })
    }

    const uploadDocuments = (e) => {
        if (e.target.files && e.target.files[0]) {
            emp_docs.emp_doc = e.target.files[0];
            emp_docs.imageUrl = URL.createObjectURL(emp_docs.emp_doc);
        }
    }


    const formatConverter = (data) => {
        let obj = Object.entries(data).map(item => {
            return {
                title: item[0],
                value: item[1]
            }
        })
        return obj
    }

    function reset(){
        emp_docs.imageUrl=""
        emp_docs.emp_doc=""
        emp_docs.name=""
        emp_docs.address=""
        emp_docs.gender=""
        emp_docs.father_name=""
        emp_docs.dob=""
        emp_docs.spouse=""
        emp_docs.blood_group_id=""
        emp_docs.gaurdian_name=""
        emp_docs.gaurdian_type=""
        emp_docs.doc_type=""
        emp_docs.aadhar_number=""
        emp_docs.aadhar_enrollment_number=""
        emp_docs.aadhar_address=""
        emp_docs.pan_number=""
        emp_docs.license_number=""
        emp_docs.license_issue_date=""
        emp_docs.license_expires_on=""
        emp_docs.license_address=""
        emp_docs.passport_country_code=""
        emp_docs.passport_type=""
        emp_docs.passport_number=""
        emp_docs.passport_date_of_issue=""
        emp_docs.passport_place_of_issue=""
        emp_docs.passport_place_of_birth=""
        emp_docs.passport_expire_on=""
        emp_docs.voter_id_issued_on=""
        emp_docs.voterid_emp_address=""
        emp_docs.voterid_number=""
    }

    function save_empdocs(document){
        // function convertToTitleCase(originalString) {
        //     if (originalString) {
        //         //     const title =  str.replace(/\b\w/g, match => match.toUpperCase());
        //         //    const converted = title.replace(/_/g, ' ');
        //         //     return converted
        //         const convertedString = originalString
        //             .split('_')
        //             .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        //             .join(' ');
        //         return convertedString
        //     }
        // }

        // format
        let form = new FormData();
         form.append("name", emp_docs.name);
         form.append("onboard_document_type",document);
         form.append("user_id", useprofile.getURLParams_UID())
         form.append("emp_docs", emp_docs.emp_doc);
         form.append("gender", emp_docs.gender);
         form.append("spouse", emp_docs.spouse);
         form.append("dob",dayjs(emp_docs.dob).format('YYYY-MM-DD') );
         form.append("address", emp_docs.address);
         form.append("blood_group_id", emp_docs.blood_group_id);
         form.append("father_name", emp_docs.father_name);
         form.append("gaurdian_name", emp_docs.gaurdian_name);
         form.append("gaurdian_type", emp_docs.gaurdian_type);
         form.append("doc_type", emp_docs.doc_type);
         form.append("aadhar_number", emp_docs.aadhar_number);
         form.append("aadhar_enrollment_number", emp_docs.aadhar_enrollment_number);
         form.append("aadhar_address", emp_docs.aadhar_address);
         form.append("pan_number", emp_docs.pan_number);
         form.append("license_number", emp_docs.license_number);
         form.append("license_issue_date", emp_docs.license_issue_date);
         form.append("license_expires_on", emp_docs.license_expires_on);
         form.append("license_address", emp_docs.license_address);
         form.append("passport_country_code", emp_docs.passport_country_code);
         form.append("passport_type", emp_docs.passport_type);
         form.append("passport_number", emp_docs.passport_number);
         form.append("passport_date_of_issue", emp_docs.passport_date_of_issue);
         form.append("passport_place_of_issue", emp_docs.passport_place_of_issue);
         form.append("passport_place_of_birth", emp_docs.passport_place_of_birth);
         form.append("passport_expire_on", emp_docs.passport_expire_on);
         form.append("voter_id_issued_on", emp_docs.voter_id_issued_on);
         form.append("voterid_number", emp_docs.voterid_number);
         form.append("voterid_emp_address", emp_docs.voterid_emp_address);

        axios.post('/profile-pages/updateEmployeeDocumentDetails',form).then((res)=>{
            console.log(res.data);
            console.log(res.data.status);
            if (res.data.status) {
                Swal.fire({
                    title: res.data.status = "success",
                    text: res.data.message,
                    icon: "success",
                }).then((res) => {
                    reset();
                })
            }
            else if (res.data.status == "failure") {
                Swal.fire({
                    title: res.data.status = "failure",
                    text: res.data.message,
                    // "Salary Advance Succesfully",
                    icon: "error",
                    showCancelButton: false,
                }).then((res) => {
                    // blink_UI.value = res.data.data;
                    create_new_from.value = 1;
                })

            }
        }).finally(()=>{
            canShowLoading.value = false;
            // approvalFormat.splice(0, approvalFormat.length);
            getdoc_details();
            reset();
        })
    }


    const showDocument = (document) => {

        console.log(document,'document');

        emp_docs.value = document.value;
        // emp_docs =

        // emp_docs.imageUrl = document.image;
        documentPath.value  =document.image;

        for(let key in emp_docs.value){
            if(emp_docs.hasOwnProperty(key) && document.value.hasOwnProperty(key)){
                emp_docs[key] = document.value[key];
                console.log( emp_docs[key] ,' document.value[key] ');
            }

        }
        // emp_docs.dob = document.value.dob;

        console.log(  emp_docs.name,'  emp_docs.name');
        console.log(emp_docs.dob,'emp_docs.dob');

        if(document.title=='Aadhar_Card_Front'){
            // emp_docs.name = ''
        }
        else if(document.title==''){

        }




        function convertToTitleCase(originalString) {
            if (originalString) {
                //     const title =  str.replace(/\b\w/g, match => match.toUpperCase());
                //    const converted = title.replace(/_/g, ' ');
                //     return converted
                const convertedString = originalString
                    .split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
                return convertedString
            }
        }




        // axios.post('/profile-page/getEmployeeApprovedDocumentsFile', {
        //     user_id: useprofile.getURLParams_UID(),
        //     doc_name: convertToTitleCase(document.title),
        //     emp_doc_record_id: document.doc_rec_id
        // }).then(res => {
        //     documentPath.value = res.data.data
        // }).finally(() => {

        // })
    }



    const headers = ["Aadhar Card","PANCard","Driving License","Voter ID","Passport"]

    return {
        getdoc_details,
        doc_details,
        formatConverter,
        canShowLoading,
        Aadhar_Card_Front,
        reset,
        emp_docs,
        save_empdocs,
        uploadDocuments,
        showDocument,
        documentPath
    }
});
