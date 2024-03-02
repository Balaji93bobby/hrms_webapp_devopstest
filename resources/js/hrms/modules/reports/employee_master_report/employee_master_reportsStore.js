import axios from "axios";
import { mixin } from "lodash";
import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { inject, reactive, ref } from "vue";


export const EmployeeMasterStore = defineStore("EmployeeMasterStore", ()=>{

    // variable


    // employee CTC

    const legal_Entity = ref();
    const Department = ref();
    const period_Date = ref();
    const select_Category = ref();

    // functions

    const client_ids = ref();
    const selectCategory = ref();
    const btn_download = ref(false);
    const personalDetail =  ref();
    const show = ref(false);
    const employeeCTCReportSource = ref([]);
    const Employee_CTCReportDynamicHeaders =  ref([]);
    const department = ref();
    const PeriodMonth = ref("");
    const filterbtn = ref(1);
    // const
    const canShowLoading   = ref(false);
    const selectedfilters = reactive({
        date:"",
        department_id:"",
        legal_entity:"",
        active_status:"",
        type:""
    });

    const employeeMaterReportSource = ref([]);
    const Employee_MaterReportDynamicHeaders =  ref([]);


    //


const getEmployeeCTC = () => {
    let url = '/fetch-employee-ctc-report'
    canShowLoading.value = true;
    axios.post(url,{
        type:""
    }).then(res => {
        console.log(res.data.rows,"get value ");
        employeeCTCReportSource.value = res.data.rows
        console.log(employeeCTCReportSource.value," testings data");
        res.data.headers.forEach(element => {
            let format = {
                title: element
            }
            Employee_CTCReportDynamicHeaders.value.push(format)
            console.log(element);
        });
        console.log(Employee_CTCReportDynamicHeaders.value);

    }).finally(() => {
        canShowLoading.value = false;
    })
}

    function fetchFilterClientIds(){
        canShowLoading.value = true;
        axios.get('/filter-client-ids').then((res)=>{
            client_ids.value = res.data;
            console.log(" testing client id",client_ids.value);
        }).finally(()=>{
            canShowLoading.value = false;
        })
    }
    function getALLdepartment(){
        canShowLoading.value = true;
     axios.get('/get-department').then((res)=>{
      department.value = res.data;
     }).finally(()=>{
         canShowLoading.value = false;
     })
     
 }
 function getPeriodMonth(){
     // let date = Date;
     canShowLoading.value = true;
     axios.post('/get-filter-months-for-reports').then((res)=>{
         PeriodMonth.value= res.data;
     }).finally(()=>{
         canShowLoading.value = false;
     })

 }

    function personalDetails(){
        employeeCTCReportSource.value.splice(0);
        Employee_CTCReportDynamicHeaders.value.splice(0);

        if(show.value == true){
            console.log(show);
            show.value = false;
            personalDetail.value = "";
            console.log(personalDetail.value);
        }
        else if(show.value == false){
            show.value = true;
            personalDetail.value = "detailed";
            console.log(personalDetail.value);
        };
        
        selectedfilters.type =   personalDetail.value;

        axios.post('/fetch-employee-ctc-report',selectedfilters).then(res => {
            console.log(res.data.rows,"get value ");
            employeeCTCReportSource.value = res.data.rows
            console.log(employeeCTCReportSource.value," testings data");
            res.data.headers.forEach(element => {
                let format = {
                    title: element
                }
                Employee_CTCReportDynamicHeaders.value.push(format)
                console.log(element);
            });
            console.log(Employee_CTCReportDynamicHeaders.value);
        })
    };




    //

    const downloadEmployeeCTC = () => {
    let url = '/generate-employee-ctc-report'
    canShowLoading.value = true;
    axios.post(url,selectedfilters, { responseType: 'blob' }).then((response) => {
        console.log(response.data);
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(response.data);
        // ${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}
        link.download = `Employee CTC Report_.xlsx`;
        link.click();
    }).finally(() => {
        btn_download.value = false;
        canShowLoading.value = false;
    })
}

function updateEmployeeApplyFilter(active_status){
    console.log("active_status: ",active_status);

    Employee_MaterReportDynamicHeaders.value.splice(0, Employee_MaterReportDynamicHeaders.value.length);
    employeeMaterReportSource.value.splice(0,employeeMaterReportSource.value.length);

    employeeCTCReportSource.value.splice(0,employeeCTCReportSource.value.length);
    Employee_CTCReportDynamicHeaders.value.splice(0,
        Employee_CTCReportDynamicHeaders.value.length);

      if(active_status == 1){
                    canShowLoading.value = true;
                   let url = `/fetch-master-employee-report`;
                   axios.post(url,selectedfilters).then(res => {
                    console.log(res.data.rows,"get value ");
                    employeeMaterReportSource.value = res.data.rows
                    console.log(employeeMaterReportSource.value," testings data");
                    res.data.headers.forEach(element => {
                        let format = {
                            title: element
                        }
                        Employee_MaterReportDynamicHeaders.value.push(format)
                        console.log(element);
                    });
                    console.log(Employee_MaterReportDynamicHeaders.value);

                    if (res.data.headers.length === 0) {
                        Swal.fire({
                            title: res.data.status = "failure",
                            text: "No employees found in this category",
                            icon: "error",
                            showCancelButton: false,
                        }).then((res) => {

                        })
                    }
                }).finally(()=>{
                    canShowLoading.value = false

                })

                }else if(active_status==2){

                    let url = '/fetch-employee-ctc-report';

                    canShowLoading.value = true;

                    axios.post(url,selectedfilters).then(res => {
                        console.log(res.data.rows,"get value ");
                        employeeCTCReportSource.value = res.data.rows
                        console.log(employeeCTCReportSource.value," testings data");
                        res.data.headers.forEach(element => {
                            let format = {
                                title: element
                            }
                            Employee_CTCReportDynamicHeaders.value.push(format)
                            console.log(element);
                        });
                        console.log(Employee_CTCReportDynamicHeaders.value);

                        if (res.data.rows.length === 0) {
                            Swal.fire({
                                title: res.data.status = "failure",
                                text: "No employees found in this category",
                                icon: "error",
                                showCancelButton: false,
                            }).then((res) => {

                            })
                        }
                    }).finally(()=>{
                        canShowLoading.value = false
    
                    })
                }


}



function getSelectoption(key,filterValue,active_status){

    console.log(key,filterValue,active_status);
    // Employee_MaterReportDynamicHeaders.value.splice(0, Employee_MaterReportDynamicHeaders.value.length);
    // employeeMaterReportSource.value.splice(0,employeeMaterReportSource.value.length);

    // employeeCTCReportSource.value.splice(0,employeeCTCReportSource.value.length);
    // Employee_CTCReportDynamicHeaders.value.splice(0,
    //     Employee_CTCReportDynamicHeaders.value.length);

        // canShowLoading.value = true
    if (key == "department") {
        selectedfilters.department_id = filterValue;

    } else
        if (key == "Category") {
            selectedfilters.active_status = filterValue
            console.log(selectedfilters);
        } else
            if (key == "date") {
                selectedfilters.date = filterValue
            } else
                if (key == "legal_entity") {
                    selectedfilters.legal_entity = filterValue
                }
                // if(active_status == 1){
                //     // canShowLoading.value = true;
                //    let url = `/fetch-master-employee-report`;
                //    axios.post(url,selectedfilters).then(res => {
                //     console.log(res.data.rows,"get value ");
                //     employeeMaterReportSource.value = res.data.rows
                //     console.log(employeeMaterReportSource.value," testings data");
                //     res.data.headers.forEach(element => {
                //         let format = {
                //             title: element
                //         }
                //         Employee_MaterReportDynamicHeaders.value.push(format)
                //         console.log(element);
                //     });
                //     console.log(Employee_MaterReportDynamicHeaders.value);

                //     if (res.data.headers.length === 0) {
                //         Swal.fire({
                //             title: res.data.status = "failure",
                //             text: "No employees found in this category",
                //             icon: "error",
                //             showCancelButton: false,
                //         }).then((res) => {

                //         })
                //     }
                // }).finally(()=>{
                //     canShowLoading.value = false

                // })

                // }else{

                //     let url = '/fetch-employee-ctc-report';

                //     canShowLoading.value = true;

                //     axios.post(url,selectedfilters).then(res => {
                //         console.log(res.data.rows,"get value ");
                //         employeeCTCReportSource.value = res.data.rows
                //         console.log(employeeCTCReportSource.value," testings data");
                //         res.data.headers.forEach(element => {
                //             let format = {
                //                 title: element
                //             }
                //             Employee_CTCReportDynamicHeaders.value.push(format)
                //             console.log(element);
                //         });
                //         console.log(Employee_CTCReportDynamicHeaders.value);

                //         if (res.data.rows.length === 0) {
                //             Swal.fire({
                //                 title: res.data.status = "failure",
                //                 text: "No employees found in this category",
                //                 icon: "error",
                //                 showCancelButton: false,
                //             }).then((res) => {

                //             })
                //         }
                //     }).finally(()=>{
                //         canShowLoading.value = false
    
                //     })
                // }
}


// employee master ctc





    function getemployeeMater(){
        let url = '/fetch-master-employee-report'
        canShowLoading.value = true;
        axios.post(url,{
            type:""
        }).then(res => {
            console.log(res.data.rows,"get value ");
            employeeMaterReportSource.value = res.data.rows
            console.log(employeeMaterReportSource.value," testings data");
            res.data.headers.forEach(element => {
                let format = {
                    title: element
                }
                Employee_MaterReportDynamicHeaders.value.push(format)
                console.log(element);
            });
            console.log(Employee_MaterReportDynamicHeaders.value);

        }).finally(() => {
            canShowLoading.value = false;
        })
    }

    function downloadEmployeeMaster(){

        let url = '/generate-master-employee-report-data'
        canShowLoading.value = true;
        axios.post(url,selectedfilters, { responseType: 'blob' }).then((response) => {
            console.log(response.data);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(response.data);
            link.download = `Employee Master Report_.xlsx`;
            link.click();
        }).finally(() => {
            btn_download.value = false;
            canShowLoading.value = false;
        })

    }


    function clearfilterBtn(val){
        console.log("testing data :",val);
        if(val===2){
            employeeCTCReportSource.value.splice(0,employeeCTCReportSource.value.length);
            Employee_CTCReportDynamicHeaders.value.splice(0,
                Employee_CTCReportDynamicHeaders.value.length);
// axios variable
            selectedfilters.active_status="";
            selectedfilters.date="";
            selectedfilters.department_id="";
            selectedfilters.legal_entity="";
    // variable
            legal_Entity.value="";
            Department.value="";
            period_Date.value="";
            select_Category.value="";
        }
        else{
            employeeMaterReportSource.value.splice(0,employeeMaterReportSource.value.length);
            Employee_MaterReportDynamicHeaders.value.splice(0, Employee_MaterReportDynamicHeaders.value.length);
           // axios variable
            selectedfilters.active_status="";
            selectedfilters.date="";
            selectedfilters.department_id="";
            selectedfilters.legal_entity="";
        // variable
            legal_Entity.value="";
            Department.value="";
            period_Date.value="";
            select_Category.value="";



        }

     


    }

    function testings(val){
        if(val){
            console.log("1",val);
        }else{
            console.log("2",val);
        }

    }

    function filterCustomDate(activetab){

        if(activetab===4){
            PeriodMonth.value.push({date: "custom_date", month: "Custom Date"});
        }else{
            PeriodMonth.value.pop();
        }


    }

    const resetChars = () =>{
        selectedfilters.active_status="";
        selectedfilters.date="";
        selectedfilters.department_id="";
        selectedfilters.legal_entity="";
    // variable
        legal_Entity.value="";
        Department.value="";
        period_Date.value="";
        select_Category.value="";
    }


    // async function

    return {
        // variables
         show,client_ids, employeeCTCReportSource, Employee_CTCReportDynamicHeaders,
         personalDetail,
         selectCategory,
         department,
         PeriodMonth,

        // functions
        fetchFilterClientIds,
        getEmployeeCTC,
        personalDetails,

        // getALLdepartment
        getALLdepartment,

        // get Period Month

        getPeriodMonth,
        updateEmployeeApplyFilter,

        // DownloadEmployee CTC

        downloadEmployeeCTC,


        // download animation btn
        btn_download,

        canShowLoading,

        filterbtn,

        legal_Entity,
        Department,
        period_Date,
        select_Category,


        // testings

        // employee master report
        getemployeeMater,
        employeeMaterReportSource,
        Employee_MaterReportDynamicHeaders ,
        downloadEmployeeMaster,
        getSelectoption,

        clearfilterBtn,
        testings,
        selectedfilters,
        resetChars,

        filterCustomDate



    }
})
