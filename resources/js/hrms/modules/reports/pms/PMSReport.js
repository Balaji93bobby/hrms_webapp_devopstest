import axios from "axios";
import { mixin } from "lodash";
import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { inject, reactive, ref } from "vue";
import { Service } from '../../Service/Service'
import { usePmsMainStore } from '../../pms/stores/pmsMainStore'


export const PMSMasterStore = defineStore("PMSMasterStore", () => {


    const useStore = usePmsMainStore()
    const btn_download = ref(false);
    const assignment_setting_id = ref()

    const service = Service()
    const canShowLoading = ref(false);

    const employeeMaterReportSource = ref([]);
    const Employee_MaterReportDynamicHeaders = ref([]);

    const current_session_client_id = ref();
    const PMSReportSource = ref([]);
    const PMSAnnualReportSource = ref([]);
    const PMSAnnualReport_DynamicHeaders1 = ref([]);
    const PMSAnnualReport_DynamicHeaders2 = ref([]);
    const PMSBasicReportSource = ref([]);
    const PMSBasicReport_DynamicHeaders = ref([]);
    const keyvalue = ref([]);
    const PMSAnnualReportSourceData = ref([]);










    const getAssignmentPeriodDropdown = async (user_code) => {
        let client_id = '';
        await axios.get(` ${window.location.origin}/session-sessionselectedclient`).then((res) => {
            client_id = res.data.id;
        })

        console.log(client_id, 'client_id');

        await axios.post(`${window.location.origin}/api/pms/getAssignmentPeriodDropdown`, {
            user_code: service.current_user_code,
            client_id: client_id
        }).then((res) => {
            // selectedyear.value = res.data;

            res.data.map(({ current_period, assignment_id }) => {
                if (current_period == 1) {
                    assignment_setting_id.value = assignment_id;
                    console.log(current_period,);
                    console.log(assignment_id);
                }
            })
        })
    }

    const downloadAnnualPMSReport = () => {

        let format = {
            client_id: current_session_client_id.value,
            assignment_setting_id: assignment_setting_id.value
        }

        canShowLoading.value = true;

        let url = `${window.location.origin}/api/pms/pmsMasterReportExcellExport`;
        axios.post(url, format, { responseType: 'blob' }).then((response) => {
            console.log(response.data);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(response.data);
            // ${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}
            link.download = `Detail Annual PMS Report_.xlsx`;
            link.click();
        }).finally(() => {
            btn_download.value = false;
            canShowLoading.value = false;
        })
    }
    const downloadBasicReport = () => {

        let format = {
            client_id: current_session_client_id.value,
            assignment_setting_id: assignment_setting_id.value
        }

        canShowLoading.value = true;

        let url = `${window.location.origin}/api/pms/pmsScoreExportReport`;
        axios.post(url, format, { responseType: 'blob' }).then((response) => {
            console.log(response.data);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(response.data);
            // ${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}
            link.download = `Basic PMS Report_.xlsx`;
            link.click();
        }).finally(() => {
            btn_download.value = false;
            canShowLoading.value = false;
        })
    }



    function updatePMSReport(active_status) {

        console.log("active_status: ", active_status);

        PMSBasicReport_DynamicHeaders.value.splice(0, PMSBasicReport_DynamicHeaders.value.length);
        PMSBasicReportSource.value.splice(0, PMSBasicReportSource.value.length);

        PMSAnnualReportSource.value.splice(0, PMSAnnualReportSource.value.length);
        PMSAnnualReport_DynamicHeaders1.value.splice(0,
            PMSAnnualReport_DynamicHeaders1.value.length);
        PMSAnnualReport_DynamicHeaders2.value.splice(0,
            PMSAnnualReport_DynamicHeaders2.value.length);

        if (active_status == 1) {
            canShowLoading.value = true;
            let url = `${window.location.origin}/api/pms/pmsScoreExportReport`

            axios.post(url, {
                client_id: current_session_client_id.value,
                assignment_setting_id: assignment_setting_id.value,
                type: "json"
            }).then(res => {
                console.log(res)
                console.log(res.data.data, "get value ");



                PMSBasicReportSource.value = res.data.data.value
                console.log(PMSBasicReportSource.value, " testings data");
                res.data.data.header.forEach(element => {
                    let format = {
                        title: element
                    }
                    PMSBasicReport_DynamicHeaders.value.push(format)
                    console.log(element);
                });
                console.log(PMSBasicReport_DynamicHeaders.value);


                if (res.data.data.header.length === 0) {
                    Swal.fire({
                        title: res.data.data.status = "failure",
                        text: "No employees found in this category",
                        icon: "error",
                        showCancelButton: false,
                    }).then((res) => {

                    })
                }
            }).finally(() => {
                canShowLoading.value = false

            })

        }
        else if (active_status == 2) {
            canShowLoading.value = true;

            let url = `${window.location.origin}/api/pms/pmsMasterReportExcellExport`

            axios.post(url, {
                client_id: current_session_client_id.value,
                assignment_setting_id: assignment_setting_id.value,
                type: "json"
            }).then(res => {
                console.log(res)
                console.log(res.data.data, "get value ");


                console.log(res.data.data.value)
                console.log(res.data.data.value)
                PMSAnnualReportSource.value = res.data.data.value
                console.log(PMSAnnualReportSource.value, " testings data");
                res.data.data.header1.forEach(element => {
                    let format = {
                        title: element
                    }
                    PMSAnnualReport_DynamicHeaders1.value.push(format)
                    console.log(element);
                });
                console.log(PMSAnnualReport_DynamicHeaders1.value);
                res.data.data.header2.forEach(element => {
                    let format = {
                        title: element
                    }
                    PMSAnnualReport_DynamicHeaders2.value.push(format)
                    console.log(element);
                });
                console.log(PMSAnnualReport_DynamicHeaders2.value);
                Object.keys(PMSAnnualReportSource.value[0]).forEach(key => {

                    keyvalue.value.push(key);
                });

                keyvalue.value.forEach(element => {
                    let format = {
                        title: element
                    }
                    PMSAnnualReportSourceData.value.push(format)
                    console.log(element)
                });

                // PMSAnnualReportSource.value[0].forEach(obj => {

                //     Object.keys(obj).forEach(key => {
                //         keyvalue.value.push(key);

                //     });
                //   });
                console.log("Keys Array:", keyvalue.value);



                if (res.data.data.value.length === 0) {
                    Swal.fire({
                        title: res.data.data.status = "failure",
                        text: "No employees found in this category",
                        icon: "error",
                        showCancelButton: false,
                    }).then((res) => {

                    })
                }
            }).finally(() => {
                canShowLoading.value = false

            })
        }


    }


    function getPMSBasicReport() {
        let url = `${window.location.origin}/api/pms/pmsScoreExportReport`
        canShowLoading.value = true;
        axios.post(url, {
            client_id: current_session_client_id.value,
            assignment_setting_id: assignment_setting_id.value,
            type: "json"
        }).then(res => {
            console.log(res)
            console.log(res.data.data, "get value ");



            PMSBasicReportSource.value = res.data.data.value
            console.log(PMSBasicReportSource.value, " testings data");
            res.data.data.header.forEach(element => {
                let format = {
                    title: element
                }
                PMSBasicReport_DynamicHeaders.value.push(format)
                console.log(element);
            });
            console.log(PMSBasicReport_DynamicHeaders.value);

        }).finally(() => {
            canShowLoading.value = false;
        })
    }


    function getPMSAnnualReport() {
        let url = `${window.location.origin}/api/pms/pmsMasterReportExcellExport`
        canShowLoading.value = true;
        axios.post(url, {
            client_id: current_session_client_id.value,
            assignment_setting_id: assignment_setting_id.value,
            type: "json"
        }).then(res => {
            console.log(res)
            console.log(res.data.data, "get value ");



            PMSAnnualReportSource.value = res.data.data.value
            console.log(PMSBasicReportSource.value, " testings data");
            res.data.data.header1.forEach(element => {
                let format = {
                    title: element
                }
                PMSAnnualReport_DynamicHeaders1.value.push(format)
                console.log(element);
            });
            console.log(PMSAnnualReport_DynamicHeaders1.value);
            res.data.data.header2.forEach(element => {
                let format = {
                    title: element
                }
                PMSAnnualReport_DynamicHeaders2.value.push(format)
                console.log(element);
            });
            console.log(PMSAnnualReport_DynamicHeaders2.value);

        }).finally(() => {
            canShowLoading.value = false;
        })
    }

    const getclient_id = async () => {

        return await axios.get(`${window.location.origin}/getCurrentSessionClientId`)
            .then(res => {
                console.log(res.data)
                current_session_client_id.value = res.data
            })

    }















    return {

        //variables

        PMSReportSource,
        current_session_client_id,
        PMSAnnualReportSourceData,
        PMSBasicReport_DynamicHeaders,
        PMSBasicReportSource,
        PMSAnnualReport_DynamicHeaders2,
        PMSAnnualReport_DynamicHeaders1,
        PMSAnnualReportSource,



         //functions

        getclient_id,
        getAssignmentPeriodDropdown,
        getPMSBasicReport,
        updatePMSReport,
        downloadBasicReport,
        downloadAnnualPMSReport,
        getPMSAnnualReport,







    }
})
