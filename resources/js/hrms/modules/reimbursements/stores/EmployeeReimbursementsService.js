import { defineStore } from "pinia";
import { ref, onMounted, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import moment from "moment/moment";
import { Service } from '../../Service/Service'

export const employee_reimbursment_service = defineStore("employee_reimbursment_service", () => {
    const toast = useToast();
    const service = Service()


    const loading_spinner = ref(false);


    // Reimbursment Varaible Declarations

    const reimbursement_datas = ref([]);
    const reimbursementsScreen = ref(true);
    const reimbursements_dailog = ref(false);

    const employee_reimbursement = reactive({
        claim_type: "",
        claim_amount: 0,
        eligible_amount: 0,
        date_of_dispatch: "",
        proof_of_delivery: "",
        reimbursment_remarks: "",
        employee_reimbursement_attachment: ''
    });

    const reimbursement_claim_types = ref([
        { label: "None", value: "None" },
    ]);

    // getting Proof of reimbursements

    function onClaimsDocumentUploaded(e){

        let uploadedFile = 0;
        console.log(e);

        // Check if file is selected
        if (e.target.files && e.target.files[0]) {

            // Get uploaded file
            uploadedFile = e.target.files[0];

            const reader = new FileReader();
            reader.onloadend = () => {
                console.log(reader.result);
                // Logs data:<type>;base64,wL2dvYWwgbW9yZ...
                employee_reimbursement.employee_reimbursement_attachment = reader.result;
            };
           reader.readAsDataURL(uploadedFile);

            // Print to console
            console.log("Uploaded Claims Document in BASE64  : "+employee_reimbursement.employee_reimbursement_attachment);
        }

    }

    const onclickOpenReimbursmentDailog = () => {
        submitted.value = false;
        reimbursements_dailog.value = true;
    };


    const data_reimbursements = ref();

    const fetch_data_from_reimbursment = () => {
        let url_all_reimbursements =
            window.location.origin + "/fetch_all_reimbursements";

        console.log("AJAX URL : " + url_all_reimbursements);

        axios.get(url_all_reimbursements).then((response) => {
            data_reimbursements.value = response.data;
            console.log(response.data);
            loading_spinner.value = false;
        })
    };

    // Reimbursement Claim types
    async function getReimbursementClaimTypes(){

        let url_all_reimbursements = '/getReimbursementClaimTypes';

        console.log("AJAX URL : " + url_all_reimbursements);

        await axios.post(url_all_reimbursements).then((response) => {
            reimbursement_claim_types.value = response.data.data;
            console.log("getReimbursementClaimTypes() : "+response.data);
        });

    }


    const onclickSwitchToReimbursmentTab = () => {
        reimbursementsScreen.value = true;
        localconverganceScreen.value = false;
    };







    // Local Conveyance Varaible Declarations

    const localconverganceScreen = ref(false);
    const localconvergance_dailog = ref(false);

    const employee_local_conveyance = reactive({
        reimbursement_type: "Local Conveyance",
        travelled_date: "",
        mode_of_transport: "",
        travel_from: "",
        travel_to: "",
        total_distance_travelled: "",
        Amt_km: "",
        local_convenyance_total_amount: "",
        local_conveyance_remarks: "",
    });

    const onclickOpenLocalConverganceDailog = () => {
        submitted.value = false;
        localconvergance_dailog.value = true;

        submitted.value = false;
    };
    const hideDialog = () => {
        reimbursements_dailog.value = false;
        localconvergance_dailog.value = false;
        submitted.value = false;
    };


    const onclickSwitchToLocalCoverganceTab = () => {
        reimbursementsScreen.value = false;
        localconverganceScreen.value = true;
    };


    const submitted = ref(false);


    const local_Conveyance_Mode_of_transport = ref();

    // Getting Mode of transport for Local Conveyance

    async function getModeOfTransport() {

        await axios.get('/reimbursements/getModeOfTransports').then((response) => {
            local_Conveyance_Mode_of_transport.value = response.data.data;
            console.log(response.data);
        });

    }


    const data_local_convergance = ref([]);
    const disableAmt = ref(true)

    const fetch_data_for_local_convergance = () => {
        let url_all_reimbursements = window.location.origin + "/fetch_employee_reimbursement_data";

        console.log("AJAX URL : " + url_all_reimbursements);

        axios.post(url_all_reimbursements).then((response) => {
            data_local_convergance.value = response.data;
            console.log(response.data);
            // loading_spinner.value = false;
        });
    };


    async function saveReimbursementClaimsData(){
        console.log("Saving Reimbursement Claims data : "+JSON.stringify(employee_reimbursement) );

        axios.post('/reimbursements/saveReimbursementData_Claims', {
            "user_code" : service.current_user_code,
            "date" : new Date().toJSON().slice(0,10),
            "reimbursement_type" : employee_reimbursement.claim_type,
            "claim_amount": employee_reimbursement.claim_amount,
            "reimbursement_remarks" : employee_reimbursement.reimbursment_remarks,
            "file_upload": employee_reimbursement.employee_reimbursement_attachment,
            "entry_mode" : "web",
        }).then((response) => {

            if (response.data.status == "success") {
                    reimbursements_dailog.value =false;
                    toast.add({
                        severity: "success",
                        summary: "Saved",
                        detail: "Reimbursement Claims Added",
                        life: 3000,
                    });

                }
                else
                if (response.data.status == "failure") {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to save Local Coveyance due to following errors : " + JSON.stringify(response.data.message),
                        life: 6000,
                    });

                    console.log("Failure Response : " + response.data.data);
                }
                else {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Unknown error occured due to following : " + JSON.stringify(response.data.message),
                        life: 6000,
                    });
                }

                console.log(response);

            }).catch(err => {
                console.log("Catch Response : "+res);
            })
            .finally(res => {
                console.log("Finally Response : "+res);
                employee_reimbursement.claim_amount = null
                employee_reimbursement.claim_type = null
                employee_reimbursement.date_of_dispatch = null
                employee_reimbursement.eligible_amount = null
                employee_reimbursement.employee_reimbursement_attachment = null
                employee_reimbursement.proof_of_delivery = null
                employee_reimbursement.reimbursment_remarks = null
            });



    }

    const post_data_for_local_convergance = () => {

        let url_all_local_convergance = '/reimbursements/saveReimbursementsData';

        localconvergance_dailog.value = false;
        loading_spinner.value = true

        axios.post(url_all_local_convergance, {
            "user_code": service.current_user_code,
            "reimbursement_type": 'Local Conveyance',
            "date": moment(employee_local_conveyance.travelled_date).format('YYYY-MM-DD'),
            "user_comments": employee_local_conveyance.local_conveyance_remarks,
            "from": employee_local_conveyance.travel_from,
            "to": employee_local_conveyance.travel_to,
            "total_expenses": employee_local_conveyance.local_convenyance_total_amount,
            "vehicle_type": employee_local_conveyance.mode_of_transport,
            "distance_travelled": employee_local_conveyance.total_distance_travelled,
            "entry_mode": "web",
        })
            .then((response) => {

                if (response.data.status == "success") {
                    localconvergance_dailog.value = false;

                    data_local_convergance.value.push(employee_local_conveyance);

                    employee_local_conveyance.local_convenyance_total_amount = response.data.total_amount;

                    toast.add({
                        severity: "success",
                        summary: "Saved",
                        detail: "Local Coveyance Added",
                        life: 3000,
                    });

                }
                else
                    if (response.data.status == "failure") {
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: "Failed to save Local Coveyance due to following errors : " + JSON.stringify(response.data.message),
                            life: 6000,
                        });

                        console.log("Failure : " + response.data.data);
                    }
                    else {
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: "Unknown error occured due to following : " + JSON.stringify(response.data.message),
                            life: 6000,
                        });
                    }

                console.log(employee_local_conveyance.value);

                console.log(response);

            }).catch(err => {
                currentObj.output = err;
                console.log(err)
            })
            .finally(res => {
                console.log(res);
                generate_ajax();
                loading_spinner.value = false
            });



    };

    function amount_calculation() {
        console.log("Calculating amount_calculation()");

        console.log(employee_local_conveyance.mode_of_transport);
        if (employee_local_conveyance.mode_of_transport == "4-Wheeler") {
            console.log("Car");

            employee_local_conveyance.local_convenyance_total_amount =
                employee_local_conveyance.total_distance_travelled * 6;
            console.log(
                employee_local_conveyance.local_convenyance_total_amount
            );
        } else if (employee_local_conveyance.mode_of_transport == "2-Wheeler") {
            employee_local_conveyance.local_convenyance_total_amount =
                employee_local_conveyance.total_distance_travelled * 3.5;
            console.log("Bike");
        } else {
            console.log("No mode of transport found. Assigning NULL to local_convenyance_total_amount");
            employee_local_conveyance.local_convenyance_total_amount = null;
        }
    }


    const amountperKm = (data) => {

        if (data == '4-Wheeler') {
            employee_local_conveyance.Amt_km = 6
            employee_local_conveyance.local_convenyance_total_amount = 6 * employee_local_conveyance.total_distance_travelled
            console.log("car");
        } else
            if (data == '2-Wheeler') {
                employee_local_conveyance.Amt_km = 3.5
                employee_local_conveyance.local_convenyance_total_amount = 3.5 * employee_local_conveyance.total_distance_travelled
                console.log("Bike");
            } else {
                console.log("public transport");
                employee_local_conveyance.Amt_km = ''
            }

    }

    const selected_date = ref()
    async function generate_ajax() {

        // loading_spinner.value = true

        console.log(selected_date.value);

        let filter_date = new Date(selected_date.value);

        let year = filter_date.getFullYear();
        let month = filter_date.getMonth() + 1;

        console.log((selected_date.value).toString());


        //show_table.value=true

        //data_checking.value = true
        console.log(month);


        await axios.post("/fetch_employee_reimbursement_data", {
                selected_year: year,
                selected_month: month
        }).then(res => {
            console.log("data sent");
            console.log("data from " + res.employee_name);
            data_local_convergance.value = res.data
            loading_spinner.value = false
        }).catch(err => {
            console.log(err);
        }).finally(() => {
            loading_spinner.value = false
        })

    }

    const download_ajax = () => {
        let filter_date = new Date(selected_date.value);


        let year = filter_date.getFullYear();
        let month = filter_date.getMonth() + 1;


        let URL = '/reports/generate-employee-reimbursements-reports?selected_year=' + year + '&selected_month=' +
            month + '&_token={{ csrf_token() }}';
        window.location = URL;
        setTimeout(greet, 1000);

    }

    return {
        hideDialog,
        localconvergance_dailog,
        employee_reimbursement,
        employee_local_conveyance,
        onclickOpenLocalConverganceDailog,
        reimbursements_dailog,
        reimbursementsScreen,
        localconverganceScreen,
        fetch_data_from_reimbursment,
        data_reimbursements,
        loading_spinner,
        amount_calculation,
        getModeOfTransport,
        getReimbursementClaimTypes,
        // employee_reimbursement
        saveReimbursementClaimsData,

        onclickSwitchToReimbursmentTab,
        onClaimsDocumentUploaded,

        reimbursement_datas,
        reimbursement_claim_types,
        onclickOpenReimbursmentDailog,


        // employee_local_convergance

        post_data_for_local_convergance,
        fetch_data_for_local_convergance,
        onclickSwitchToLocalCoverganceTab,
        data_local_convergance,
        disableAmt,
        local_Conveyance_Mode_of_transport,
        amountperKm,

        // PDF Download

        generate_ajax, download_ajax, selected_date

    };
}
);
