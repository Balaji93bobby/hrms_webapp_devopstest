/*
Normal Onboarding

HTML fields
Validation
AJAX


*/

import { required, email, maxLength } from "@vuelidate/validators";
import axios from "axios";
// API's

export async function getBankList() {
    const response = await axios.get(`/db/getBankDetails`);
    return response.data;
}

export async function getCountryList() {
    const response = await axios.get(`/db/getCountryDetails`);
    return response.data;
}
export async function getStateList() {
    const response = await axios.get(`/db/getStatesDetails`);
    return response.data;
}
export async function ManagerDetails(){
    const response=await axios.get(`/fetch-managers-name`);
    return response.data
}

export async function DepartmentDetails(){
    const response=await axios.get(`/fetch-departments`);
    return response.data
}

export async function getMaritalStatus(){
    const response=await axios.get(`/fetch-marital-details`);
    return response.data
}


export async function getBloodGroups(){
    const response=await axios.get(`/fetch-blood-groups`);
    return response.data
}

export async function fetchQuickOnboardedEmployeeDetails(uid){

    const response = await axios.post('/fetch-quickonboarded-emp-details', {
        encr_uid: uid,
      });

      return response;
}


// Validation

export default function validation(rules) {
    return (rules = {

        employee_code: {},
        dob: {},
        gender: {},
        passport_number: {
            required,
        ValidateAadhar(value) {
            const regex = /^(?!^0+$)[a-zA-Z0-9]{3,20}$/;
            return regex.test(value);
        },
        },
        passport_date: {},
        blood_group_name: {},
        physically_challenged: {},
        gender: {},
        dl_no: {},
        nationality: {},

        doj: {
            required,
        },

        aadhar_number: {
            required,
            ValidateAadhar(value) {
                const regex = /^\d{4}\s\d{4}\s\d{4}$/;
                return regex.test(value);
            },
        },
        bank_name: {
            required,
        },
        employee_name: {
            required,

        },
        gender: {
            required,
        },
        pan_number: {
            required,
            ValidatePan(value) {
                const regex = /^[A-Za-z]{5}[0-9]{4}[a-zA-Z]{1}/;
                return regex.test(value);
            },
        },

        AccountNumber: {
            required,
            ValidateAccountNo(value) {
                const regex = /^[0-9]{9,18}$/;
                return regex.test(value);
            },
        },

        dob: {
            required,
        },
        mobile_number: {
            required,
            maxLength: 10,
        },
        bank_ifsc: {
            required,
            ValidateIfscNo(value) {
                const regex = /^[A-Za-z]{4}0[A-Za-z0-9]{6}$/;
                return regex.test(value);
            },
        },
        marital_status: { required   },

        email: {
            required,
            email,
        },
        nationality: {
            required,
        },
        physically_challenged: {
            required,
        },
        //  Person Details End

        // Address Validation Start
        current_address_line_1: {
            required,
        },
        current_address_line_2: {
            required,
        },
        current_country: {
            required,
        },
        current_state: {
            required,
        },
        current_city: {
            required,
        },
        current_pincode: {
            required,
            maxLength: 6,
        },
        permanent_address_line_1: {
            required,
        },
        permanent_address_line_2: {
            required,
        },
        permanent_country: {
            required,
        },
        permanent_state: {
            required,
        },
        permanent_city: {
            required,
        },
        permanent_pincode: {
            required,
            maxLength: 6,
        },

        // Addres End

        // Office Details Start
        process: {
        },
        designation: {
            required,
        },
        department: {},
        cost_center: {},
        probation_period: {},
        holiday_location: {},
        officical_mail: {
            // required,
            email
        },
        official_mobile: {},
        probation_period: {},
        emp_notice: {},
        work_location: {
            required,
        },
        l1_manager_code: {
            required,
        },
        confirmation_period: {
            required,
        },

        // Office Detials End

        // Family Details Start

        father_name: { required },
        dob_father: { required },
        mother_name: { required },
        dob_mother: { required },
        spouse_name: { required },
        wedding_date: {  },
        spouse_gender: { required },
        dob_spouse: { required },

        // Personal Documents
});
}
