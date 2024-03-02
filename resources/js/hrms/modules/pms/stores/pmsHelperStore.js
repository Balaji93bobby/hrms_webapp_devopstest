import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import * as XLSX from 'xlsx';
import { useRouter, useRoute } from "vue-router";
import dayjs from "dayjs";
import * as ExcelJS from 'exceljs'
import { usePmsMainStore } from "./pmsMainStore";



export const usePmsHelperStore = defineStore("usePmsHelperStore", () => {

    // Global declaration

    const useStore = usePmsMainStore();
    const toast = useToast();

    const activetab = ref();

    const KpiForms = ref()
    const ManagerList = ref()
    const canShowAssigneeReviewForm = ref(false);
    const excelupload = ref();

    const getKpiAsDropdown = async (user_id) => {
        await axios.get(`/api/getKpiFormAsDropdown/${141}`).then(res => {
            KpiForms.value = res.data
        })
    }
    const getManagerList = async (user_id) => {
        await axios.get(`/api/getManagersListForEmployees/${141}`).then(res => {
            ManagerList.value = res.data
        })
    }



    const pmsReviewIsCompleted = (dataArray, codeToFind, statusToCheck) => {
        // console.log(codeToFind, statusToCheck);
        if (dataArray) {
            for (const item of dataArray) {
                // console.log(item);
                if (item.reviewer_user_code === codeToFind && item.is_accepted === statusToCheck) {
                    return true;
                }
            }
        }
        return false;
    }

    const pmsKpiFormAcceptance = (dataArray) => {
        for (const item of dataArray) {
            if (item.is_assignee_accepted == '' && item.is_reviewer_accepted == 1) {
                return true;
            }
        }
        return false;
    }

    const calculateKpiWeightage = (total_value, target) => {
        if (total_value === 0) {
            // Avoid division by zero
            return 0;
        }
        return (target / total_value) * 100;
    }

    const pushToArray = (array, record_id, dataItem) => {
        // console.log(record_id);
        // console.log(dataItem);
        // console.log(array);
        const existingItem = array.find(item => item.id == record_id);
        const existingItemIndex = array.findIndex(item => item.id === record_id);
        // console.log(existingItemIndex);
        if (existingItemIndex !== -1) {
            // If the title exists, remove the existing item
            array.splice(existingItemIndex, 1);
            array.push(dataItem);
        } else {
            array.push(dataItem);
        }
    }

    const filterDashboardDetails = (data, is_submitted) => {
        if (data) {
            return data.filter(ele => {
                ele.is_assignee_submitted == is_submitted
            })
        }
    }


    const downloadExcelFile = async (headers) => {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Sheet1');
        const headerRow = worksheet.addRow(headers);
        headerRow.eachCell((cell, colNumber) => {
            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: '252f70' }, // blue color for header background
            };
            cell.font = {
                bold: true,
                color: { argb: 'ffffff' }, // white color for header text
            };
            worksheet.getColumn(colNumber).width = 20;
        });

        // Create a Blob from the workbook
        const blob = await workbook.xlsx.writeBuffer();

        // Create a Blob URL for the Excel file
        const blobURL = window.URL.createObjectURL(new Blob([blob]));

        // Create a temporary link element to trigger the download
        const link = document.createElement('a');
        link.href = blobURL;
        link.download = 'pms_kpi_form.xlsx'; // Set the desired file name
        link.click();

        // Clean up the Blob URL
        window.URL.revokeObjectURL(blobURL);
    };

    const convertExcelIntoArray = (e) => {
        if (e) {
            // var file = selectedFile.value;
            var file = e.target.files[0];
            excelupload.value = file;
            // input canceled, return
            // if (!file) return;
            /* reading excel file into Array of object */

            // var reader = new FileReader();
            // reader.onload = function (e) {
            //     const data = reader.result;
            //     var workbook = XLSX.read(data, { type: 'binary', cellDates: true, dateNF: "dd-mm-yyyy" });
            //     var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

            // Dynamically Find header's from imported excel sheet
            // let currentlyImportFileHeaders = []
            // let excelHeaders = []
            // const headers = {};
            // const range = XLSX.utils.decode_range(firstSheet['!ref']);
            // let C;
            // const R = range.s.r;
            //  const R = range.s.r;
            /* start in the first row */
            // for (C = range.s.c; C <= range.e.c; ++C) {
            /* walk every column in the range */
            //     const cell = firstSheet[XLSX.utils.encode_cell({ c: C, r: R })];
            /* find the cell in the first row */
            // let hdr = "UNKNOWN " + C; // <-- replace with your desired default
            //     if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);
            //     headers[C] = hdr;

            //     currentlyImportFileHeaders.push(headers[C])

            //     let form = {
            //         title: headers[C],
            //         value: headers[C]
            //     }

            //     !headers[C].includes("UNKNOWN") ? excelHeaders.push(form) : ''
            // }

            // header: 1 instructs xlsx to create an 'array of arrays'
            // var result = XLSX.utils.sheet_to_json(firstSheet, { raw: false, header: 1, dateNF: "dd/mm/yyyy" });
            // const jsonData = workbook.SheetNames.reduce((initial, name) => {
            //     const sheet = workbook.Sheets[name];
            //     initial[name] = XLSX.utils.sheet_to_json(sheet, { raw: false, dateNF: "dd-mm-yyyy" });
            //     return initial;
            // }, {});

            //     const convertedData = convertKeys(jsonData['Worksheet'])
            //     console.log(convertedData);
            //     useStore.createKpiForm.form_details = convertedData

            // };
            // reader.readAsArrayBuffer(file);

        } else {
            toast.add({
                severity: "error",
                summary: 'file missing!',
                detail: "selected",
                life: 2000,
            });
        }


    }

    const uploadconvertExcelIntoArray = () => {

        // var file = selectedFile.value;
        var file = excelupload.value;
        //   excelupload.value =file;
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
            // const R = range.s.r;
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

            // header: 1 instructs xlsx to create an 'array of arrays'
            // var result = XLSX.utils.sheet_to_json(firstSheet, { raw: false, header: 1, dateNF: "dd/mm/yyyy" });
            const jsonData = workbook.SheetNames.reduce((initial, name) => {
                const sheet = workbook.Sheets[name];
                initial[name] = XLSX.utils.sheet_to_json(sheet, { raw: false, dateNF: "dd-mm-yyyy" });
                return initial;
            }, {});

            const convertedData = convertKeys(jsonData['Worksheet'])
            // console.log(convertedData);
            useStore.createKpiForm.form_details = convertedData

        };
        reader.readAsArrayBuffer(file);


    }

    function convertKeys(array) {
        const convertedArray = array.map(item => {
            const convertedItem = {};
            for (let key in item) {
                let newKey = key.toLowerCase().replace(/[\s-]+/g, '_'); // Replace spaces or hyphens with underscores
                let value = item[key];

                // Remove percentage symbol if present and handle specific key names
                if (typeof value === 'string') {
                    if (key.toLowerCase().includes('kpi') && key.toLowerCase().includes('weightage')) {
                        newKey = 'kpi_weightage'; // Set specific key name for KPI Weightage
                    } else if (key.toLowerCase() === 'objective') {
                        newKey = 'dimension'; // Change 'Objective' to 'Dimension'
                    }
                    value = value.replace('%', ''); // Remove percentage symbol
                }

                convertedItem[newKey] = value;
            }
            return convertedItem;
        });
        return convertedArray;
    }


    const findSelectedHeaderIsEnabled = (array, idToFind) => {
        if (array) {
            return array.find(obj => obj.header_name === idToFind);
        }
    }

    function toastmessage(status, message) {
        // success Form created successfully
        toast.add({ severity: status, summary: message, life: 3000 });
        // detail: 'Message Content'

    }

    const filterSelfAppraisalStatusWiseSource = (array, assigneeAcceptStatus, assigneeSubmitStatus) => {
        if (array) {
            return array.filter(ele => {
                return ele.is_assignee_accepted == assigneeAcceptStatus && ele.is_assignee_submitted == assigneeSubmitStatus
            })
        }
    }

    const filterSelfAppraisalPendingStatusSource = (array, assigneeStatus, reviewerStatus) => {
        if (array) {
            return array.filter(ele => {
                return ele.is_assignee_accepted == assigneeStatus && ele.is_reviewer_accepted == reviewerStatus || ele.status == 'Accept Pending'
            })
        }
    }

    const filterTeamAppraisalPendingSource = (array, assigneeAcceptedStatus, assigneeSubmittedStatus) => {
        if (array) {
            // console.log(array, 'array ::'); console.log('status ::', assigneeSubmittedStatus);
            return array.filter(ele => {
                return ele.is_assignee_accepted == assigneeAcceptedStatus && ele.is_assignee_submitted == assigneeSubmittedStatus
            })
        }
    }
    const filterOrgPendingStatusSource = (array, assigneeStatus, reviewerStatus,assignee_is_submitted,is_reviewer_submitted,status) => {
        if (array) {
            return array.filter(ele => {
                if(status=='pending'){
                    return ele.is_assignee_accepted == assigneeStatus && ele.is_reviewer_accepted == reviewerStatus ||  ele.is_assignee_accepted == assignee_is_submitted && ele.is_reviewer_accepted == is_reviewer_submitted
                }
                else if( status== 'current'){
                    return  ele.status == assigneeStatus || ele.status == reviewerStatus
                }
                // else if(status== 'Completed'){
                //     return ele.is_reviewer_submitted == reviewerStatus
                // }
            })
        }
    }
    const filterOrgcompletedStatusSource = (array,reviewer_is_submitted,status) => {
        if (array) {
            return array.filter(ele => {
                if(status== 'Completed'){
                    return ele.is_reviewer_submitted == reviewer_is_submitted
                }
            })
        }
    }

    const filterTeamAppraisalCurrentSource = (array, isReviewed, currentUserCode) => {
        // console.log("array" + array);
        // console.log("isReviewed" + isReviewed);
        // console.log("currentUserCode" + currentUserCode);
        if (array) {
            const filteredSource = array.filter(item => {
                const isAssigneeSubmitted = item.is_assignee_submitted == 1;
                const hasReviewerDetails = item.reviewer_details && item.reviewer_details.length > 0;
                const isReviewerAccepted = hasReviewerDetails && item.reviewer_details.some(reviewer => reviewer.reviewer_user_code == currentUserCode && reviewer.is_reviewed == isReviewed);
                return isAssigneeSubmitted && isReviewerAccepted;
            });
            // console.log(filteredSource);
            return filteredSource
        }

    }

    // const filter_team_current = (array,assignee_submited,reviewer_is_submitted) =>{
        // assignee_submited = 1;
        //  reviewer_submites = '';

    //     console.log(array);

    //     if(array){
    //         return  array.filter((item)=>{
    //             return item.is_assignee_submitted == assignee_submited &&  item.is_reviewer_submitted == reviewer_is_submitted
    //         })
    //     }
    // }

    const filterDepartmentWiseEmployee = (array, selectedValues) => {
        // console.log(array);
        console.log(selectedValues);
        if (array && selectedValues) {
            const filteredArray = array.filter(ele => {
                return selectedValues.includes(parseInt(ele.department_id))
            })
            return filteredArray
        } else {
            return array
        }
    }

    const convertToNewObject = (arr) => {
        const result = {};
        arr.forEach(obj => {
            const { header_name } = obj;
            result[header_name] = null;
        });
        return result;
    }

    const compareHeaders = (obj1, obj2) => {
        const headersObj1 = Object.keys(obj1);
        const headersObj2 = Object.keys(obj2);

        const missingHeadersObj1 = headersObj2.filter(header => !headersObj1.includes(header));
        const missingHeadersObj2 = headersObj1.filter(header => !headersObj2.includes(header));

        if (missingHeadersObj1.length > 0 || missingHeadersObj2.length > 0) {
            return true
        }
    }
    // Function to check if object keys don't contain null values
    function checkObjectKeysNotNull(obj) {
        for (const key in obj) {
            if (obj.hasOwnProperty(key) && obj[key] === null) {
                return false; // Object key has a null value
            }
        }
        return true; // All object keys are not null
    }

    // Check each object in the array
    function doAllObjectsHaveNotNullKeys(array) {
        for (const obj of array) {
            const keysNotNull = checkObjectKeysNotNull(obj);
            if (!keysNotNull) {
                console.log("Object keys must not contain null values.");
                return false; // At least one object has a null key
            }
        }
        return true; // All objects have keys without null values
    }

    const filter_team_current = (array,assignee_submited,reviewer_is_submitted) =>{
        // assignee_submited = 1;
        //  reviewer_submites = '';

        console.log(array);

        if(array){
            return  array.filter((item)=>{
                return item.is_assignee_submitted == assignee_submited &&  item.is_reviewer_submitted == reviewer_is_submitted
            })
        }
    }


    return {
        KpiForms, getKpiAsDropdown,
        ManagerList, getManagerList,
        calculateKpiWeightage, pushToArray,
        pmsReviewIsCompleted, pmsKpiFormAcceptance,
        filterDashboardDetails, downloadExcelFile,
        convertExcelIntoArray, findSelectedHeaderIsEnabled,
        filterSelfAppraisalStatusWiseSource,
        filterSelfAppraisalPendingStatusSource,
        filterTeamAppraisalPendingSource,
        filterTeamAppraisalCurrentSource,
        filterDepartmentWiseEmployee,
        convertToNewObject, compareHeaders,
        doAllObjectsHaveNotNullKeys,
        // toast message

        toastmessage,
        excelupload,
        uploadconvertExcelIntoArray,
        // filter_team_current,

        // org appraisal ..

        filterOrgPendingStatusSource,
        filterOrgcompletedStatusSource,
        activetab,

        filter_team_current

    }
})
