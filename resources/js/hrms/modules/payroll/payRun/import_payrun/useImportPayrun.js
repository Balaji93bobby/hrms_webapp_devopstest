import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
// import { Service } from "../../Service/Service";
import * as XLSX from 'xlsx';
import { useRouter, useRoute } from "vue-router";
// import { useNormalOnboardingMainStore } from '../Normal_Onboarding/stores/NormalOnboardingMainStore'
import dayjs from "dayjs";


export const useImportPayrun = defineStore("useImportPayrun", () => {


    // Global variables
    // const service = Service()
    // const normalOnboardingSource = useNormalOnboardingMainStore()
    const router = useRouter();
    const canShowloading = ref(false);
    const toast = useToast();


    const EmployeeSalaryAdvanceSource = ref()
    const EmployeeSalaryAdvanceDynamicHeader = ref()
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

    const convertExcelIntoArray = (e, onboardingType) => {

        // if (selectedFile.value) {
        if (e) {
            // canShowloading.value = true

            // var file = selectedFile.value;
            var file = e.target.files[0];
            // input canceled, return
            if (!file) return;

            /* reading excel file into Array of object */

            var reader = new FileReader();
            reader.onload = function (e) {
                const data = reader.result;
                var workbook = XLSX.read(data, { type: 'binary', cellDates: true, dateNF: "dd-mm-yyyy" });
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                // Dynamically Find header's from imported excel sheet
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

                    let form = {
                        title: headers[C],
                        value: headers[C]
                    }

                    !headers[C].includes("UNKNOWN") ? excelHeaders.push(form) : ''
                }
                EmployeeSalaryAdvanceDynamicHeader.value = excelHeaders
                console.log(excelHeaders);

                // header: 1 instructs xlsx to create an 'array of arrays'
                // var result = XLSX.utils.sheet_to_json(firstSheet, { raw: false, header: 1, dateNF: "dd/mm/yyyy" });
                const jsonData = workbook.SheetNames.reduce((initial, name) => {
                    const sheet = workbook.Sheets[name];
                    initial[name] = XLSX.utils.sheet_to_json(sheet, { raw: false, dateNF: "dd-mm-yyyy" });
                    return initial;
                }, {});


                // Getting Key of each object in array
                const importedExcelKey = Object.keys(jsonData)[0]
                jsonData[importedExcelKey] ? EmployeeSalaryAdvanceSource.value = jsonData[importedExcelKey] : EmployeeSalaryAdvanceSource.value = []
                EmployeeSalaryAdvanceSource.value ? getCurrentlyImportedTableDuplicateEntries(EmployeeSalaryAdvanceSource.value) : ''

                // Getting Total count of recordds
                totalRecordsCount.value.push(EmployeeSalaryAdvanceSource.value)

                for (let index = 0; index < jsonData[importedExcelKey].length; index++) {
                    console.log("jsonData['Sheet1'].length :", jsonData[importedExcelKey].length);
                    const validationResult = getValidationMessages(
                        EmployeeSalaryAdvanceSource.value[index], onboardingType
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

       // let url = '/imporExistingSalaryAdvanceData'

        let url = '/employee-payrun-data'

        if (errorRecordsCount.value == 0) {
            // canShowloading.value = true
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
                     //setTimeout(() => {
                        //     window.location.replace(window.location.origin + '/manageEmployees')
                        // }, 4000);
                    }
            }).finally(() => {
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

    const isExistsOrNot = (array, e) => {
        console.log(e);
        return array.includes(e) ? true : false
    }



    const isNumber = (e) => {
        if (/^[0-9]+$/.test(e)) {
            return false
        } else {
            return true

        }
    }


    const loanAmount = (e) => {
        // console.log("loan Amount:" + convertRupeeIntoNumber(e));
        return convertRupeeIntoNumber(e) <= 0 ? true : false
    }

    const loanTypes = ref([
        { id: '1', name: 'Salary advance' },
        { id: '2', name: 'Interest free loan' },
        { id: '3', name: 'Travel advance' },
        { id: '4', name: 'Interest with loan' },
    ])

    const findBalanceAmount = (e, loanAmount, repaymentAmount) => {
        let format = { balance: e, loanAmt: loanAmount, Repayment: repaymentAmount }
        console.log(format);
        console.log(`loanAmount${convertRupeeIntoNumber(loanAmount)}`);
        console.log(`repaymentAmount${convertRupeeIntoNumber(repaymentAmount)}`);
        if (e) {
            let balance;
            var containsNumber = /\d/.test(repaymentAmount);
            if (containsNumber) {
                balance = convertRupeeIntoNumber(loanAmount) - convertRupeeIntoNumber(repaymentAmount)
                return convertRupeeIntoNumber(e) == balance ? false : true
            } else {
                balance = convertRupeeIntoNumber(loanAmount)
                console.log("======Balance=====" + balance);
                return convertRupeeIntoNumber(e) == balance ? false : true
            }

        }
        // console.log("Actual Balance:" + convertRupeeIntoNumber(e));
        // console.log("subbed Balance:" + balance);
        console.log(convertRupeeIntoNumber(e) == balance);
    }


    const findEmiCalculation = (e, balance, tenure) => {
        let format = { emi: e, balance: balance, tenure: tenure }
        console.log(format);
        if (e) {
            let emi = convertRupeeIntoNumber(balance) / convertRupeeIntoNumber(tenure)
            console.log("Actual emi:" + convertRupeeIntoNumber(e));
            console.log("subbed emi:" + emi);
            return convertRupeeIntoNumber(e) == emi ? false : true
        }

    }


    const convertRupeeIntoNumber = (e) => {
        if (e) {
            console.log(e.split(".")[0]);
            var splittedNumber = e.split(".")[0]
            var convertedBalance = splittedNumber.match(/\d/g);
            if (convertedBalance) {
                convertedBalance = convertedBalance.join("");
                console.log(`convertRupeeIntoNumber${convertedBalance}`);
                return parseInt(convertedBalance)
            }
        }

    }



    const getValidationMessages = (data) => {
        console.log(onboardedType.value);
        let errorMessages = [];
        const digitRegexp = /\w*\d{1,}\w*/;
        const emailRegexp =
            /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const websiteRegexp =
            new RegExp('^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$');
        return errorMessages;
    }


    return {

        getCurrentlyImportedTableDuplicateEntries, currentlyImportedTableEmployeeCodeValues, findCurrentTableDups, uploadOnboardingFile, type,
        currentlyImportedTableAadharValues, currentlyImportedTablePanValues, currentlyImportedTableAccNoValues, currentlyImportedTableEmailValues, currentlyImportedTableMobileNumberValues,

        // TODO:: Separate

        loanAmount, loanTypes, findBalanceAmount, findEmiCalculation, isExistsOrNot,



        convertExcelIntoArray, EmployeeSalaryAdvanceDynamicHeader, EmployeeSalaryAdvanceSource, getValidationMessages, getExcelForUpload,

        // View

        canShowloading,


        // Onboarding Helper functions

    }
})
