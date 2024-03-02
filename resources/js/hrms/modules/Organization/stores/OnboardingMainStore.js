import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import * as XLSX from 'xlsx';
import { useRouter, useRoute } from "vue-router";
import { useNormalOnboardingMainStore } from '../Normal_Onboarding/stores/NormalOnboardingMainStore'
import dayjs from "dayjs";


export const useOnboardingMainStore = defineStore("useOnboardingMainStore", () => {


    // Global variables
    const service = Service()
    const normalOnboardingSource = useNormalOnboardingMainStore()
    const router = useRouter();
    const canShowloading = ref(false)
    const toast = useToast();


    const EmployeeQuickOnboardingSource = ref()
    const EmployeeQuickOnboardingDynamicHeader = ref()
    const currentlyImportedFileHeaders = ref()
    const selectedFile = ref()


    const totalRecordsCount = ref([])
    const errorRecordsCount = ref([])
    const initialUpdate = ref(false)
    const isValueUpdated = ref(false)
    const onboardedType = ref()
    const type = ref()



    // Getting Selected file for upload
    const getExcelForUpload = (e) => {
        selectedFile.value = e.target.files[0];
    }

    const convertExcelIntoArray = (onboardingType) => {
        onboardedType.value = onboardingType

        console.log(onboardingType);
        if (selectedFile.value) {

            var file = selectedFile.value;
            // var file = e.target.files[0];
            // input canceled, return
            if (!file) return;
            /* reading excel file into Array of object */

            var reader = new FileReader();
            reader.onload = function (e) {
                const data = reader.result;
                var workbook = XLSX.read(data, { type: 'binary', cellDates: true, dateNF: "dd-mm-yyyy" });
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                // Dynamically Find header's from imported excel sheet
                let currentlyImportFileHeaders = []
                let excelHeaders = []
                const headers = {};
                const range = XLSX.utils.decode_range(firstSheet['!ref']);
                let C;
                const R = range.s.r;
                /* start in the first row */
                for (C = range.s.c; C <= range.e.c; ++C) {
                    /* walk every column in the range */
                    const cell = firstSheet[XLSX.utils.encode_cell({ c: C, r: R })];
                    /* find the cell in the first row */
                    let hdr = "UNKNOWN " + C; // <-- replace with your desired default
                    if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);
                    headers[C] = hdr;

                    currentlyImportFileHeaders.push(headers[C])

                    let form = {
                        title: headers[C],
                        value: headers[C]
                    }

                    !headers[C].includes("UNKNOWN") ? excelHeaders.push(form) : ''
                }
                EmployeeQuickOnboardingDynamicHeader.value = excelHeaders
                currentlyImportedFileHeaders.value = currentlyImportFileHeaders
                console.log(currentlyImportFileHeaders);

                canShowloading.value = true
                setTimeout(() => {
                    if (onboardingType == 'quick') {
                        if (validateArrays(currentlyImportFileHeaders, quickOnboardingHeaders.value)) {
                            type.value = 'quick'
                            router.replace('/Organization/import')
                            canShowloading.value = false
                        } else {
                            canShowloading.value = false
                            toast.add({
                                severity: "error",
                                summary: 'Fields are not matched',
                                detail: "fill",
                                life: 2000,
                            })
                            selectedFile.value = null
                        }
                    } else
                        if (onboardingType == 'bulk') {
                            type.value = 'bulk'
                            if (validateArrays(currentlyImportFileHeaders, bulkOnboardingHeaders.value)) {
                                router.replace('/Organization/import')
                                canShowloading.value = false
                            } else {
                                canShowloading.value = false
                                toast.add({
                                    severity: "error",
                                    summary: 'Fields are not matched',
                                    detail: "fill",
                                    life: 2000,
                                })
                                selectedFile.value = null
                            }
                        }

                }, 1000);

                // header: 1 instructs xlsx to create an 'array of arrays'
                // var result = XLSX.utils.sheet_to_json(firstSheet, { raw: false, header: 1, dateNF: "dd/mm/yyyy" });
                const jsonData = workbook.SheetNames.reduce((initial, name) => {
                    const sheet = workbook.Sheets[name];
                    initial[name] = XLSX.utils.sheet_to_json(sheet, { raw: false, dateNF: "dd-mm-yyyy" });
                    return initial;
                }, {});


                // Getting Key of each object in array
                const importedExcelKey = Object.keys(jsonData)[0]
                jsonData[importedExcelKey] ? EmployeeQuickOnboardingSource.value = jsonData[importedExcelKey] : EmployeeQuickOnboardingSource.value = []
                EmployeeQuickOnboardingSource.value ? getCurrentlyImportedTableDuplicateEntries(EmployeeQuickOnboardingSource.value) : ''

                // Getting Total count of recordds
                totalRecordsCount.value.push(EmployeeQuickOnboardingSource.value)

                for (let index = 0; index < jsonData[importedExcelKey].length; index++) {
                    console.log("jsonData['Sheet1'].length :", jsonData[importedExcelKey].length);
                    const validationResult = getValidationMessages(
                        EmployeeQuickOnboardingSource.value[index], onboardingType
                    )

                }
            };
            reader.readAsArrayBuffer(file);

        } else {
            toast.add({
                severity: "error",
                summary: 'file missing!',
                detail: "selected",
                life: 2000,
            });
        }

    }
    //Upload selected file
    const uploadOnboardingFile = (data) => {

        let url = ''

        if (type.value == 'quick') {
            url = '/onboarding/storeQuickOnboardEmployees'
        } else
            if (type.value == 'bulk') {
                url = '/onboarding/storeBulkOnboardEmployees'
            }
        if (errorRecordsCount.value == 0) {
            canShowloading.value = true
            axios.post(url, data).then(res => {
                // canShowloading.value = false
                if (res.data.status == 'failure') {
                    toast.add({
                        severity: "error",
                        summary: "failure",
                        detail: `${res.data.message}`,
                        life: 3000,
                    });
                } else
                    if (res.data.status == 'success') {
                        res.data.data.forEach(element => {
                            toast.add({
                                severity: "success",
                                summary: `${element['Employee_Name']}`,
                                detail: `${element.message}`,
                                life: 3000,
                            });
                        });
                        setTimeout(() => {
                            window.location.replace(window.location.origin + '/Organization/manage-employees')
                        }, 4000);
                    }
            }).finally(() => {
                canShowloading.value = false

            })
        } else {
            toast.add({
                severity: "error",
                summary: 'Failure!',
                detail: "Clear error fields",
                life: 3000,
            });
        }
    }

    // Finding Duplicate in array
    function findDuplicates(arr) {
        return arr.filter((currentValue, currentIndex) =>
            arr.indexOf(currentValue) !== currentIndex);
    }

    // variables declared for  duplicate entries in imported excel file
    let currentlyImportedTableEmployeeCodeValues = ref([])
    let currentlyImportedTableEmailValues = ref([])
    let currentlyImportedTableMobileNumberValues = ref([])
    let currentlyImportedTablePanValues = ref([])
    let currentlyImportedTableAadharValues = ref([])
    let currentlyImportedTableAccNoValues = ref([])


    // Getting currently imported duplicate entries in table
    const getCurrentlyImportedTableDuplicateEntries = (data) => {
        data.forEach(element => {
            currentlyImportedTableEmployeeCodeValues.value.push(element['Employee Code'])
            currentlyImportedTableEmailValues.value.push(element['Email'])
            currentlyImportedTableMobileNumberValues.value.push(element['Mobile Number'])
            currentlyImportedTablePanValues.value.push(element['Pan No'])
            currentlyImportedTableAadharValues.value.push(element['Aadhar'])
            currentlyImportedTableAccNoValues.value.push(element['Account No'])
        });
    }

    // Helper function for find duplicate
    const findCurrentTableDups = (duplicateArray, e) => {
        if (findDuplicates(duplicateArray).includes(e)) {
            return true
        } else {
            return false
        }
    }

    // Helper Function
    /*

     Validation - Data format
     Duplicate Identification

    */

    //  Variable declared for already existing records in current organization

    const existingClientCode = ref()
    const existingUserCode = ref()
    const existingEmails = ref()
    const existingMobileNumbers = ref()
    const existingPanCards = ref()
    const existingAadharCards = ref()
    const existingBankAccountNumbers = ref()
    const existingBankNames = ref()
    const existingDepartments = ref()
    const existingOfficialEmails = ref()
    const existingBloodgroups = ref()
    const existingMartialStatus = ref()
    const legalEntityDropdown = ref()
    const existingLegalEntity = ref([])
    const quickOnboardingHeaders = ref()
    const bulkOnboardingHeaders = ref()

    const getExistingOnboardingDocuments = () => {

        axios.get('/onboarding/getEmployeeMandatoryDetails').then(res => {

            Object.values(res.data).forEach(element => {
                existingClientCode.value = element.client_code
                existingUserCode.value = element.user_code
                existingMobileNumbers.value = element.mobile_number
                existingEmails.value = element.email
                existingPanCards.value = element.pan_number
                existingAadharCards.value = element.aadhar_number
                existingBankAccountNumbers.value = element.bankaccount_number
                existingBankNames.value = element.bank_name
                existingDepartments.value = element.department_name
                existingOfficialEmails.value = element.official_mail
                existingBloodgroups.value = element.employees_blood_group
                existingMartialStatus.value = element.employees_marital_status
                legalEntityDropdown.value = element.client_details
                legalEntityDropdown.value ? legalEntityDropdown.value.forEach(ele => {
                    existingLegalEntity.value.push(ele.client_fullname);
                }) : null
                quickOnboardingHeaders.value = element.quick_onboard_column_data
                bulkOnboardingHeaders.value = element.bulk_onboard_column_data

            });
        })
    }

    const isLetter = (e) => {
        if (/^[ A-Za-z_ ]+$/.test(e)) {
            return false
        } else {
            return true
        }
    }

    const isSpecialChars = (e) => {
        if (/^[A-Za-z0-9]+$/.test(e) && !existingUserCode.value.includes(e)) {
            return false
        } else {
            return true

        }
    }

    function isClientCodeExists(obj, value) {
        const splitedClientCodeParts = value.split(/(?=\d)/);
        return (Object.values(obj).includes(splitedClientCodeParts[0])) ? true : false
    }

    const isUserExists = (e) => {
        if (e) {
            if (existingUserCode.value.includes(e)) {
                return false
            } else {
                return true
            }
        } else {
            return true
        }
    }

    const isNumber = (e) => {
        if (/^[0-9]+$/.test(e)) {
            return false
        } else {
            return true

        }
    }

    const isEmail = (e) => {
        if (e) {
            if (/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(e.trim()) && !existingEmails.value.includes(e.trim())) {
                return false
            } else {
                return true
            }
        } else {
            return false
        }
    }

    const isValidAadhar = (e) => {
        const result = splitNumberWithSpaces(e);
        if (e) {
            if (/^[2-9]{1}[0-9]{3}\s{1}[0-9]{4}\s{1}[0-9]{4}$/.test(result) && !existingAadharCards.value.includes(result)) {
                return false
            } else {
                return true
            }
        } else {
            return false
        }
    }

    function splitNumberWithSpaces(number) {
        const numberString = String(number);
        const groups = [];

        for (let i = 0; i < numberString.length; i += 4) {
            groups.push(numberString.substr(i, 4));
        }

        return groups.join(' ');
    }




    const isAadharExists = (e) => {
        if (!existingAadharCards.value.includes(e)) {
            return false
        } else {
            return true
        }
    }

    const isValidPancard = (e) => {
        let panFormat = ''
        e ? panFormat = e.toUpperCase() : ''
        if (e) {
            if (/^([a-zA-Z]){3}([Pp]){1}([a-zA-Z]){1}([0-9]){4}([a-zA-Z]){1}?$/.test(panFormat.trim()) && existingPanCards.value.includes(panFormat.trim())) {
                return false
            } else {
                return true
            }
        } else {
            return true
        }
    }

    const isValidBankAccountNo = (e) => {
        if (e) {
            if (!existingBankAccountNumbers.value.includes(e.trim())) {
                return false
            } else {
                return true
            }
        } else {
            return false
        }
    }

    const isValidBankIfsc = (e) => {
        let ifscFormat = ''
        e ? ifscFormat = e.toUpperCase() : ''
        if (e) {
            if (/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/.test(ifscFormat.trim())) {
                return false
            } else {
                return true
            }
        } else {
            return false
        }
    }

    const isValidDate = (e) => {
        if (e) {
            if (/^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$/.test(e)) {
                return false
            } else {
                return true
            }
        } else {
            return true
        }
    }

    const isValidMobileNumber = (e) => {
        if (e) {
            if (/^[0-9]{10,10}$/.test(e.trim()) && !existingMobileNumbers.value.includes(e.trim())) {
                return false
            } else {
                return true

            }
        } else {
            return false
        }
    }

    const isExistsOrNot = (array, e) => {
        if (e) {
            if (array.includes(e)) {
                return false
            }
            else {
                return true
            }
        } else {
            return false
        }
    }

    const isEnteredNos = (e) => {
        let char = String.fromCharCode(e.keyCode); // Get the character
        if (/^[0-9]+$/.test(char)) return true; // Match with regex
        else e.preventDefault(); // If not match, don't add to input text
    }

    const isEnterLetter = (e) => {
        let char = String.fromCharCode(e.keyCode); // Get the character
        if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
        else e.preventDefault(); // If not match, don't add to input text
    }

    const isEnterSpecialChars = (e) => {
        let char = String.fromCharCode(e.keyCode); // Get the character
        if (/^[A-Za-z0-9]+$/.test(char)) return true; // Match with regex
        else e.preventDefault(); // If not match, don't add to input text
    }

    const isBankExists = (e) => {
        if (e) {
            let value = e ? e.toUpperCase() : ''
            let bankName = value.trim()
            return existingBankNames.value.includes(bankName) ? false : true
        } else {
            return true
        }
    }

    const isDepartmentExists = (e) => {
        if (e) {
            return existingDepartments.value.includes(e) ? true : false
        } else {
            return true
        }
    }

    const isOfficialMailExists = (e) => {
        return existingOfficialEmails.value.includes(e) ? true : false
    }

    const getValidationMessages = (data) => {
        console.log(onboardedType.value);
        let errorMessages = [];
        const digitRegexp = /\w*\d{1,}\w*/;
        const emailRegexp =
            /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const websiteRegexp =
            new RegExp('^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$');


        if (onboardedType.value == 'quick') {
            if (findDuplicates(currentlyImportedTableEmployeeCodeValues.value).includes(data['Employee Code']) || !isUserExists(data["Employee Code"])) {
                errorRecordsCount.value.push('invalid')
            } else
                if (isExistsOrNot(existingLegalEntity.value, data["Legal Entity"])) {
                    errorRecordsCount.value.push('invalid')
                }
                else
                    if (!data["Legal Entity"]) {
                        errorRecordsCount.value.push('invalid')
                    }
                    else
                        if (findDuplicates(currentlyImportedTableEmailValues.value).includes(data['Email']) || isEmail(data['Email'])) {
                            errorRecordsCount.value.push('invalid')
                        }
                        else
                            if (isValidDate(data['DOJ'])) {
                                errorRecordsCount.value.push('invalid')
                            }
                            else
                                if (findDuplicates(currentlyImportedTableMobileNumberValues.value).includes(data['Mobile Number']) || isValidMobileNumber(data['Mobile Number'])) {
                                    errorRecordsCount.value.push('invalid')
                                }
        } else
            if (onboardedType.value == 'bulk') {


                if (findDuplicates(currentlyImportedTableEmployeeCodeValues.value).includes(data['Employee Code']) || !isUserExists(data["Employee Code"])) {
                    errorRecordsCount.value.push('invalid')
                }
                else
                    if (isExistsOrNot(existingLegalEntity.value, data["Legal Entity"])) {
                        errorRecordsCount.value.push('invalid')
                    }
                    else
                        if (!data["Legal Entity"]) {
                            errorRecordsCount.value.push('invalid')
                        }
                        else
                            if (findDuplicates(currentlyImportedTableEmailValues.value).includes(data['Email']) || isEmail(data['Email'])) {
                                errorRecordsCount.value.push('invalid')
                            }
                            else
                                if (isValidDate(data['DOJ'])) {
                                    errorRecordsCount.value.push('invalid')
                                }
                                else
                                    if (isValidDate(data['DOB'])) {
                                        errorRecordsCount.value.push('invalid')
                                    }
                                    else
                                        if (findDuplicates(currentlyImportedTablePanValues.value).includes(data['Pan No']) || !isValidPancard(data['Pan No'])) {
                                            errorRecordsCount.value.push('invalid')

                                        }
                                        else
                                            if (findDuplicates(currentlyImportedTableAadharValues.value).includes(data['Aadhar']) || isValidAadhar(data['Aadhar'])) {
                                                console.log(isValidAadhar(data['Aadhar']));
                                                errorRecordsCount.value.push('invalid')
                                            }

                                            else
                                                if (findDuplicates(currentlyImportedTableMobileNumberValues.value).includes(data['Mobile Number']) || isValidMobileNumber(data['Mobile Number'])) {
                                                    errorRecordsCount.value.push('invalid')
                                                }
                                                else
                                                    if (isBankExists(data['Bank Name'])) {
                                                        errorRecordsCount.value.push('invalid')
                                                    }
                                                    else
                                                        if (isExistsOrNot(existingMartialStatus.value, data['Marital Status'])) {
                                                            errorRecordsCount.value.push('invalid')
                                                        }

                                                        else
                                                            if (isValidBankIfsc(data['Bank ifsc'])) {
                                                                errorRecordsCount.value.push('invalid')
                                                            }

                                                            else
                                                                if (findDuplicates(currentlyImportedTableAccNoValues.value).includes(data['Account No']) || isValidBankAccountNo(data['Account No'])) {
                                                                    errorRecordsCount.value.push('invalid')
                                                                }
                                                                else
                                                                    if (!isDepartmentExists(data['Department'])) {
                                                                        errorRecordsCount.value.push('invalid')
                                                                    }
            }
            else {
                console.log("No more error record found!");
            }

        return errorMessages;
    }


    function validateArrays(arr1, arr2) {

        console.log(arr1, arr2);

        // Check if the arrays have the same length
        if (arr1.length !== arr2.length) {
            console.log("length is not equal");
            return false;
        }

        // Iterate through the elements and compare them
        for (let i = 0; i < arr1.length; i++) {
            if (arr1[i] !== arr2[i]) {
                console.log("not matched");
                return false;
            }
        }
        // If all elements are equal, the arrays are valid
        return true;
    }


    return {

        getCurrentlyImportedTableDuplicateEntries, currentlyImportedTableEmployeeCodeValues, findCurrentTableDups, uploadOnboardingFile, type,
        currentlyImportedTableAadharValues, currentlyImportedTablePanValues, currentlyImportedTableAccNoValues, currentlyImportedTableEmailValues, currentlyImportedTableMobileNumberValues,
        // TODO:: Separate

        getExistingOnboardingDocuments, existingUserCode, existingEmails, existingMobileNumbers, existingAadharCards, existingPanCards, existingBankAccountNumbers, initialUpdate, isValueUpdated,
        existingMartialStatus, existingBloodgroups, existingClientCode, existingLegalEntity, legalEntityDropdown,

        isLetter, isEmail, isNumber, isEnterLetter, isEnterSpecialChars, isEnterSpecialChars, isValidAadhar, isValidBankAccountNo, isValidBankIfsc, isSpecialChars,
        isValidDate, isValidMobileNumber, isValidPancard, isEnteredNos, totalRecordsCount, errorRecordsCount, selectedFile, isUserExists, isBankExists, isDepartmentExists,
        isOfficialMailExists, isAadharExists, isExistsOrNot, isClientCodeExists, splitNumberWithSpaces,



        convertExcelIntoArray, EmployeeQuickOnboardingDynamicHeader, EmployeeQuickOnboardingSource, getValidationMessages, getExcelForUpload,

        // View

        canShowloading,


        // Onboarding Helper functions

    }
})






// //  Compensatory Calculation


// const compensatory_calculation = (total_ctc) => {

//     let basic = (total_ctc * 50) / 100;
//     let hra = (basic * 50) / 100;
//     let special_allowance = basic - hra;

//     let actual_gross = basic + hra + special_allowance;

//     let format = {
//         basic: basic,
//         hra: hra,
//         special: special_allowance,
//         gross: actual_gross,
//         epf_employer_contribution: epf_esic_calculation(actual_gross, hra).epf_employer_contribution,
//         epf_employee: epf_esic_calculation(actual_gross, hra).epf_employee,
//         esic_employer_contribution: epf_esic_calculation(actual_gross, hra).esic_employer_contribution,
//         esic_employee: epf_esic_calculation(actual_gross, hra).esic_employee,
//         total_ctc: gross_calculation(actual_gross, epf_esic_calculation(actual_gross, hra).epf_employer_contribution, epf_esic_calculation(actual_gross, hra).esic_employer_contribution),
//         net_income: net_calculation(actual_gross, epf_esic_calculation(actual_gross, hra).epf_employee, epf_esic_calculation(actual_gross, hra).esic_employee)
//     }

//     // console.log(format);
//     return format

// };

// const epf_esic_calculation = (gross, hra) => {

//     let EpfCalculation = gross - hra;

//     // console.log("EpfCalculation:" + EpfCalculation);

//     let epf_esic = {

//         epf_employer_contribution: "",
//         epf_employee: "",
//         esic_employer_contribution: "",
//         esic_employee: "",
//     }

//     if (EpfCalculation < 15000) {
//         epf_esic.epf_employer_contribution = Math.floor(EpfCalculation * 12 / 100);
//         epf_esic.epf_employee = Math.floor(EpfCalculation * 12 / 100);
//     } else if (EpfCalculation > 15000) {
//         let epfConstant = 1800;
//         epf_esic.epf_employee = epfConstant;
//         epf_esic.epf_employer_contribution = epfConstant;
//     }

//     if (gross <= 21000) {
//         epf_esic.esic_employer_contribution = Math.floor((gross * 3.25) / 100);
//         epf_esic.esic_employee = Math.floor((gross * 0.75) / 100);
//     } else if (gross > 21000) {
//         console.log(gross);
//         let EsicConstant = 0;
//         epf_esic.esic_employee = EsicConstant;
//         epf_esic.esic_employer_contribution = EsicConstant;
//     }
//     // console.log(epf_esic);
//     return epf_esic
// };

// const gross_calculation = (gross, epf_employer_contribution, esic_employer_contribution) => {
//     let total_ctc = gross + epf_employer_contribution + esic_employer_contribution
//     // employee_onboarding.insurance +
//     // employee_onboarding.graduity;

//     // console.log("ctc" + total_ctc);
//     return total_ctc
// };


// const net_calculation = (gross, epf_employee, esic_employee) => {

//     let net_income = gross - epf_employee - esic_employee;
//     // console.log("net Income:" + net_income);
//     return net_income
// };

// const insurance = (total, insurance) => {
//     let sum = parseInt(total) + parseInt(insurance);
//     console.log("sum " + sum);
// };

// const graduity = (total, graduity) => {
//     let sum =
//         parseInt(total) +
//         parseInt(graduity);

//     console.log(sum);
// };




// const bankList = ref();
// const country = ref();
// const departmentDetails = ref();
// const state = ref();
// const ManagerDetails = ref();
// const maritalDetails = ref();
// const bloodGroups = ref();



// const getBasicDeps = () => {
//     // For Bank Data
//     service.getBankList().then((result) => bankList.value = result.data);
//     //  For Countries
//     service.getCountryList().then((result) => (country.value = result.data));

//     service.getStateList().then((result) => (state.value = result.data));
//     // for Manager Details
//     service.ManagerDetails().then((result) => (ManagerDetails.value = result.data));

//     //Get Department details

//     service.DepartmentDetails().then((result) => (departmentDetails.value = result.data));

//     service.getMaritalStatus().then((result) => {
//         maritalDetails.value = result.data;
//     });

//     service.getBloodGroups().then((result) => (bloodGroups.value = result.data));
// }








