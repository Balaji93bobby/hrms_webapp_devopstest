import axios from "axios";
import { defineStore } from "pinia";
import { investmentFormulaStore } from "./investmentFormulaStore";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import { reactive, ref } from "vue";
import { Service } from "../../Service/Service";
import { data } from "autoprefixer";
import dayjs from "dayjs";
import {
    required,
    email,
    minLength,
    sameAs,
    helpers, // include helper functions from Vuelidate
} from "@vuelidate/validators";

/*
    This Pinia code will store the ajax values of the
    profile page.
    This code is called from Parents onMounted method asynchronously


*/

export const investmentMainStore = defineStore("investmentMainStore", () => {
    // Formula Store
    const formula = investmentFormulaStore();

    // Employee Service

    const service = Service();

    const currentUSerCode = ref();

    // Notification Service

    const toast = useToast();
    const canShowSubmissionStatus = ref(false);

    // Confirmation Service

    const confirm = useConfirm();

    // Steps for Investment and exemption tab's  Next and Previous Button

    const investment_exemption_steps = ref(1);

    // loading Spinner

    const canShowLoading = ref(false);

    // Tax Saving Investments

    const taxSavingInvestments = reactive({
        max_limit: 0,
        declared_amt: 0,
        status: "Not Submited",
        Date_of_submission: "",
    });

    /* Investment and Exemptiom

    1) HRA                  - hra
    2)Section 80C & 80CCC    - sec_80cc
    3)Other Exemptions        - other_Exe

    4)House Property          - house_props

          1)sop - self occupied property
          1)lop - let out property
          1)dlop -Demmed let out property

    5)Reimbursement           - reimbursment
    6)Previous Employer Income - pre_emp_income
    7)Other Source Of Income    - oth_sour_of_income


    */

    // Getting Investment and Exemption Whole Data Source

    const investmentMainSource = ref();
    const formDataSource = reactive([]);
    const investmentSummarySource = ref()
    const getFormId = ref();
    const editingRowSource = ref();
    const updatedRowSource = ref();
    const hraSource = ref();
    const section80ccSource = ref();
    const otherExemptionSource = ref();
    const otherExeSectionData = ref();
    const housePropertySource = ref();
    const reimbursmentSource = ref();
    const otherIncomeSource = ref();
    const previousEmployeerIncomeSource = ref();
    const hop = reactive([]);
    const otherExe = reactive([]);
    const hra_fs = reactive([]);
    const AddHraButtonDisabled = ref(false);
    const employeDoj = ref()
    const isSubmitted = ref(true)
    const sumOfTotalRentPaid = ref()
    const epfPayrollDeduction = ref()
    const vpfPayrollDeduction = ref()
    const reimbursemntMaxLimit  = ref()

    const getInvestmentSource = async () => {
        let url = `/investments/investments-form-details-template`;
        canShowLoading.value = true;
        await axios
            .post(url, {
                form_name: "investment 1",
            })
            .then((res) => {
                // console.log(res.data.data.form_details);
                investmentMainSource.value = res.data.data.form_details;
                hraSource.value = res.data.data.form_details.HRA;
                section80ccSource.value =
                    res.data.data.form_details["Section 80C & 80CC "];
                otherExemptionSource.value =
                    res.data.data.form_details["Other Excemptions "];
                housePropertySource.value =
                    res.data.data.form_details["House Properties "];
                reimbursmentSource.value =
                    res.data.data.form_details["Reimbersument "];
                otherIncomeSource.value =
                    res.data.data.form_details["Other Source Of  Income"];
                previousEmployeerIncomeSource.value =
                    res.data.data.form_details["Previous Employer Income"];

                // console.log(res.data.data.form_details);

                // Getting IsSubmitted from Disable Editor

                let result = res.data.data.is_submitted == 0 ? true : false
                isSubmitted.value = result
                epfPayrollDeduction.value = res.data.data.emp_epf
                vpfPayrollDeduction.value = res.data.data.emp_vpf
                reimbursemntMaxLimit.value = res.data.data.emp_vpf
                console.log(result)

                //    Getting Employee Doj For HRA validation

                employeDoj.value = res.data.data.doj
                console.log("employee DOJ" + res.data.data.doj);

                res.data.data.form_details["House Properties "].forEach(
                    (data) => {
                        hop.push(data.fs_id);
                    }
                );

                res.data.data.form_details.HRA.forEach((data) => {
                    hra_fs.push(data.fs_id);
                    console.log(hra_fs[0]);
                });

                let sec80DD = res.data.data.form_details[
                    "Other Excemptions "
                ].filter(function (item) {
                    return item.section == "80EE";
                });
                let sec80DDB = res.data.data.form_details[
                    "Other Excemptions "
                ].filter(function (item) {
                    return item.section == "80EEA";
                });
                let sec80U = res.data.data.form_details[
                    "Other Excemptions "
                ].filter(function (item) {
                    return item.section == "80EEB";
                });

                otherExe.push(sec80DD[0].fs_id);
                otherExe.push(sec80DDB[0].fs_id);
                otherExe.push(sec80U[0].fs_id);

                // console.log(otherExe);
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false
                fetchPropertyType();
                fetchotherExe();
                fetchHraNewRental();
                setTimeout(() => {
                    hop.splice(0, hop.length);
                }, 1000);
                setTimeout(() => {
                    otherExe.splice(0, otherExe.length);
                }, 1000);
            });
    };

    const getDeclarationAmount = (amount) => {
        // Selected Row Data
        console.log(amount);
        // Getting Form ID
        // getFormId.value = amount.form_id
        getFormId.value = 1;
        var data = {
            fs_id: amount.fs_id,
            declaration_amount: amount.dec_amt,
            select_option: amount.select_option,
        };

        if (amount.dec_amt) {
            // Append Data
            formDataSource.push(data);
        } else {
            console.log("Declaration Amount Null");
        }

        // console.log(formDataSource);

        var form_data = new FormData();

        for (var key in data) {
            form_data.append(key, data[key]);
        }
        console.log(form_data);

        if (amount.dec_amt > amount.max_amount) {
            toast.add({
                severity: "error",
                summary: "Waring",
                detail: "Declaration amount is greater than Maximum Limit",
                life: 3000,
            });
        } else {
            console.log("working");
        }
    };

    const editDeclarationAmount = () => {
        console.log();
    };

    const saveFormData = () => {
        console.log(formDataSource);
        canShowLoading.value = true;
        console.log("code:" + service.current_user_code);
        console.log("Form Id:" + getFormId.value);
        let url = `/investments/saveEmpdetails`;
        axios
            .post(url, {
                user_code: service.current_user_code,
                form_id: getFormId.value,
                is_submitted: 0,
                formDataSource,
            })
            .finally(() => {
                canShowLoading.value = false;
                toast.add({
                    severity: "success",
                    summary: "Saved",
                    detail: "Data Saved Successfull",
                    life: 3000,
                });
                getInvestmentSource();
                formDataSource.splice(0, formDataSource.length);
                taxSavingInvestments.status = "Drafed";
                restChars();
                fetchInvestmentSummary();
            });
    };

    // Investment Form Submission

    const submitFormData = () => {
        let url = `/investments/saveEmpdetails`;
        axios
            .post(url, {
                user_code: service.current_user_code,
                is_submitted: 1,
            })
            .then((res) => {
                console.log(res.data);
            })
            .finally(() => {
                canShowSubmissionStatus.value = true;
                setTimeout(() => {
                    window.location.reload()
                }, 2000);
            });
    };

    // COnvert Declaration Amount Into INR Currency

    const formatCurrency = (value) => {
        let currency = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "INR",
        }).format(value);

        let format = `${currency.charAt(0)} ${currency.substring(1, currency.length)}`

        return format

    };

    // HRA Begins

    const hra_data = ref();

    const current_data = ref();

    const hra = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        from_month: "",
        to_month: "",
        city: "",
        total_rent_paid: "",
        landlord_name: "",
        landlord_PAN: "",
        address: "",
    });

    const dailogAddNewRental = ref(false);
    const dailogEditNewRental = ref(false);

    const fetchHraNewRental = async () => {
        // console.log("getting hra new rental  data.......");
        console.log(Object.values(hra_fs[0]));
        // canShowLoading.value = true;
        await axios
            .post("/investments/fetchEmpRentalDetails", {
                user_code: service.current_user_code,
                fs_id: hra_fs[0],
            })
            .then((res) => {
                res.data ? hra_data.value = Object.values(res.data.rent_details) : ''
                sumOfTotalRentPaid.value = res.data.dec_amt[0].sumofRentPaid
                if (Object.values(res.data).length == 0) {
                    AddHraButtonDisabled.value = false;
                } else {
                    AddHraButtonDisabled.value = true;
                }
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false;
            });
    };

    const editHraNewRental = (currentRowData) => {
        // console.log("editing Hra");
        console.log(currentRowData);
        dailogAddNewRental.value = true;
        hra.id = currentRowData.id;
        hra.from_month = dayjs(currentRowData.json_popups_value.from_month).format("DD-MM-YYYY");
        hra.to_month = dayjs(currentRowData.json_popups_value.to_month).format("DD-MM-YYYY");
        hra.address = currentRowData.json_popups_value.address;
        hra.city = currentRowData.json_popups_value.city;
        hra.landlord_PAN = currentRowData.json_popups_value.landlord_PAN;
        hra.landlord_name = currentRowData.json_popups_value.landlord_name;
        hra.total_rent_paid = currentRowData.json_popups_value.total_rent_paid;
    };

    const disableSaveHra = ref(false);

    const saveHraNewRental = () => {
        hra.user_code = service.current_user_code;
        hra.fs_id = hra_fs[0];
        canShowLoading.value = true;
        dailogAddNewRental.value = false;
        axios
            .post("/investments/saveSectionPopups", hra)
            .then((res) => {
                // console.log(res.data);
                toast.add({
                    severity: "success",
                    summary: "Drafted",
                    detail: "New Rental Added",
                    life: 3000,
                });
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false;
                fetchHraNewRental();
                getInvestmentSource();
                taxSavingInvestments.status = "Drafed";
                restChars();
            });
    };

    const deleteRentalDetails = (currentRowData) => {
        // console.log(currentRowData);
        confirm.require({
            message: "Do you want to delete this record?",
            header: "Delete Confirmation",
            icon: "pi pi-info-circle",
            acceptClass: "p-button-danger",
            accept: () => {
                canShowLoading.value = true;
                axios
                    .post("/investments/deleteHousePropertyDetails", {
                        current_table_id: currentRowData.id,
                    })
                    .finally(() => {
                        canShowLoading.value = false;
                        toast.add({
                            severity: "error",
                            summary: "Deleted",
                            detail: "House Rented Allowance Deleted",
                            life: 3000,
                        });
                        fetchHraNewRental();
                        getInvestmentSource()
                    });
            },
            reject: () => { },
        });
    };

    // HRA End

    // Section 80C & 80CCC Begins

    const sec80c80cc_data = ref();

    const sec80c80cc = reactive({
        EPF: "",
        VPF: "",
        PPF: "",
        LIP: "",
        SD_RCD: "",
        MD: "",
        NSC: "",
        ULIP: "",
        YTSFDR: "",
        DAP: "",
        SAP: "",
        SSY: "",
        STBIBNAR: "",
        SPF: "",
    });

    // Section 80C & 80CCC Ends

    // Other Exemptions  Begins

    const other_Exe = reactive({
        loan_sanction_date: "",
        lender_type: "",
        property_value: "",
        loan_amount: "",
        interest_amount_paid: "",
        vechicle_brand: "",
        vechicle_model: "",
        interest_amount_paid: "",
    });

    const other_exe_80EE = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        loan_sanction_date: "",
        lender_type: "",
        property_value: "",
        loan_amount: "",
        interest_amount_paid: "",
        section: "80EE",
    });
    const other_exe_80EEA = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        loan_sanction_date: "",
        lender_type: "",
        property_value: "",
        loan_amount: "",
        interest_amount_paid: "",
        section: "80EEA",
    });
    const other_exe_80EEB = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        loan_sanction_date: "",
        lender_type: "",
        property_value: "",
        loan_amount: "",
        interest_amount_paid: "",
        vechicle_brand: "",
        vechicle_model: "",
        interest_amount_paid: "",
        section: "80EEB",
    });

    const dailog_80EE = ref(false);
    const dailog_80EEA = ref(false);
    const dailog_80EEB = ref(false);

    const get80EESlotData = (data) => {
        other_exe_80EE.id = data.id
        dailog_80EE.value = true;
        // console.log(data);
        other_exe_80EE.user_code = service.current_user_code;
        other_exe_80EE.fs_id = data.fs_id;
        fetchotherExe()

    };
    const get80EEASlotData = (data) => {
        other_exe_80EEA.id = data.id
        dailog_80EEA.value = true;
        // console.log(data);
        other_exe_80EEA.user_code = service.current_user_code;
        other_exe_80EEA.fs_id = data.fs_id;
        fetchotherExe()
    };
    const get80EEBSlotData = (data) => {
        other_exe_80EEB.id = data.id
        dailog_80EEB.value = true;
        // console.log(data);
        other_exe_80EEB.user_code = service.current_user_code;
        other_exe_80EEB.fs_id = data.fs_id;
        fetchotherExe()

    };

    const Dec80EE = ref();
    const Dec80EEA = ref();
    const Dec80EEB = ref();

    const fetchotherExe = () => {
        axios
            .post("/investments/fetchOtherExemption", {
                user_code: service.current_user_code,
                otherExe,
            })
            .then((res) => {
                // console.log(res.data);
                otherExeSectionData.value = Object.values(res.data);
            });
    };

    const editOtherExe = (currentRowData) => {
        console.log(currentRowData);
        if (currentRowData.json_popups_value.section == "80EE") {
            dailog_80EE.value = true;
            other_exe_80EE.fs_id = currentRowData.json_popups_value.fs_id
            other_exe_80EE.user_code = service.current_user_code
            other_exe_80EE.loan_sanction_date = dayjs(currentRowData.json_popups_value.loan_sanction_date).format("YYYY-MM-DD");
            other_exe_80EE.lender_type =
                currentRowData.json_popups_value.lender_type;
            other_exe_80EE.loan_amount =
                currentRowData.json_popups_value.loan_amount;
            other_exe_80EE.property_value =
                currentRowData.json_popups_value.property_value;
            other_exe_80EE.interest_amount_paid =
                currentRowData.json_popups_value.interest_amount_paid;
        } else if (currentRowData.json_popups_value.section == "80EEA") {
            dailog_80EEA.value = true;
            other_exe_80EEA.fs_id = currentRowData.json_popups_value.fs_id
            other_exe_80EEA.user_code = service.current_user_code
            other_exe_80EEA.loan_sanction_date =
                dayjs(currentRowData.json_popups_value.loan_sanction_date).format("YYYY-MM-DD");
            other_exe_80EEA.lender_type =
                currentRowData.json_popups_value.lender_type;
            other_exe_80EEA.loan_amount =
                currentRowData.json_popups_value.loan_amount;
            other_exe_80EEA.property_value =
                currentRowData.json_popups_value.property_value;
            other_exe_80EEA.interest_amount_paid =
                currentRowData.json_popups_value.interest_amount_paid;
        } else if (currentRowData.json_popups_value.section == "80EEB") {
            other_exe_80EEB.fs_id = currentRowData.json_popups_value.fs_id
            other_exe_80EEB.user_code = service.current_user_code
            dailog_80EEB.value = true;
            other_exe_80EEB.loan_sanction_date =
                dayjs(currentRowData.json_popups_value.loan_sanction_date).format("YYYY-MM-DD");
            other_exe_80EEB.vechicle_brand =
                currentRowData.json_popups_value.vechicle_brand;
            other_exe_80EEB.vechicle_model =
                currentRowData.json_popups_value.vechicle_model;
            other_exe_80EEB.interest_amount_paid =
                currentRowData.json_popups_value.interest_amount_paid;
        } else {
            console.log("completed");
        }
    };

    const deleteOtherExeDetails = (currentRowData) => {
        // console.log(currentRowData);
        confirm.require({
            message: "Do you want to delete this record?",
            header: "Delete Confirmation",
            icon: "pi pi-info-circle",
            acceptClass: "p-button-danger",
            accept: () => {
                canShowLoading.value = true;
                axios
                    .post("/investments/deleteHousePropertyDetails", {
                        current_table_id: currentRowData.id,
                    })
                    .finally(() => {
                        canShowLoading.value = false;
                        toast.add({
                            severity: "error",
                            summary: "Deleted",
                            detail: `${currentRowData["json_popups_value"].section} is Deleted`,
                            life: 3000,
                        });
                        fetchotherExe();
                        getInvestmentSource();
                    });
            },
            reject: () => { },
        });
    };

    const save80EE = () => {
        dailog_80EE.value = false;
        canShowLoading.value = true;
        // console.log("Saving Other exemption 80EE");
        console.log(data);
        axios
            .post("/investments/saveSection80", other_exe_80EE)
            .then((res) => {
                // console.log(res.data);
                toast.add({
                    severity: "success",
                    summary: "Drafted",
                    detail: "80EE Added",
                    life: 3000,
                });
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false;
                getInvestmentSource();
                restChars();
                fetchotherExe();
            });
    };

    const save80EEA = () => {
        dailog_80EEA.value = false;
        canShowLoading.value = true;
        // console.log("Saving Other exemption 80EEA");
        // console.log(other_exe_80EEA);
        axios
            .post("/investments/saveSection80", other_exe_80EEA)
            .then((res) => {
                // console.log(res.data);
                canShowLoading.value = false;
                toast.add({
                    severity: "success",
                    summary: "Drafted",
                    detail: "80EEA Added",
                    life: 3000,
                });
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false;
                getInvestmentSource();
                restChars();
                fetchotherExe();
            });
    };

    const save80EEB = () => {
        dailog_80EEB.value = false;
        canShowLoading.value = true;
        // console.log("Saving Other exemption 80EEB");
        // console.log(other_exe_80EEB);
        axios
            .post("/investments/saveSection80", other_exe_80EEB)
            .then((res) => {
                // console.log(res.data);
                toast.add({
                    severity: "success",
                    summary: "Drafted",
                    detail: "80EEB Added",
                    life: 3000,
                });
            })
            .catch((e) => console.log(e))
            .finally(() => {
                canShowLoading.value = false;
                getInvestmentSource();
                restChars();
                fetchotherExe();
            });
    };

    // Other Exemptions  Ends

    // House Property Begins

    const house_props_data = ref();

    const dailog_SelfOccupiedProperty = ref(false);
    const dailog_LetOutProperty = ref(false);
    const dailog_DeemedLetOutProperty = ref(false);

    // Self Occupied Property

    const sop = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        lender_name: "",
        lender_pan: "",
        lender_type: "",
        income_loss: "",
        address: "",
        property_type: "Self Occupied Property",
    });

    // Let Out Property

    const lop = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        lender_name: "",
        lender_pan: "",
        lender_type: "",
        loss_from_housing_property: "",
        address: "",
        rent_received: "",
        municipal_tax: "",
        maintenance: "",
        net_value: "",
        interest: "",
        income_loss: "",
        property_type: "Let Out Property",
    });

    // Deemed Let Out Property

    const dlop = reactive({
        id: '',
        user_code: "",
        fs_id: "",
        lender_name: "",
        lender_pan: "",
        lender_type: "",
        loss_from_housing_property: "",
        address: "",
        rent_received: "",
        municipal_tax: "",
        maintenance: "",
        net_value: "",
        interest: "",
        income_loss: "",
        property_type: "Deemed Let Out Property",
    });

    const income_loss_calculation = () => {
        const lop_maintenance = formula.maintenance_cal(
            lop.lender_type,
            lop.rent_received,
            lop.municipal_tax
        );
        const dlop_maintenance = formula.maintenance_cal(
            dlop.lender_type,
            dlop.rent_received,
            dlop.municipal_tax
        );
        lop.maintenance = lop_maintenance;
        dlop.maintenance = dlop_maintenance;
        const lop_net = formula.net_value_cal(
            lop.rent_received,
            lop.municipal_tax,
            lop.maintenance
        );
        // console.log(lop_net);
        lop.net_value = lop_net;
        const dlop_net = formula.net_value_cal(
            dlop.rent_received,
            dlop.municipal_tax,
            dlop.maintenance
        );
        // console.log(dlop_net);
        dlop.net_value = dlop_net;
        lop.income_loss = formula.income_loss_cal(lop.interest, lop.net_value);
        dlop.income_loss = formula.income_loss_cal(
            dlop.interest,
            dlop.net_value
        );
    };
    const fetchPropertyType = () => {
        axios
            .post("/investments/fetchHousePropertyDetails", {
                user_code: service.current_user_code,
                hop,
            })
            .then((res) => {
                // console.log(res.data);
                house_props_data.value = Object.values(res.data);
            });
    };

    const getSopSlotData = (data) => {
        dailog_SelfOccupiedProperty.value = true;
        console.log(data);
        sop.user_code = service.current_user_code;
        sop.fs_id = data.fs_id;
        fetchPropertyType()
        // sop.id = data.id;
    };
    const getLopSlotData = (data) => {
        dailog_LetOutProperty.value = true;
        // console.log(data);
        lop.user_code = service.current_user_code;
        lop.fs_id = data.fs_id;
        fetchPropertyType()

        // lop.id = data.id;
    };
    const getDlopSlotData = (data) => {
        dailog_DeemedLetOutProperty.value = true;
        // console.log(data);
        dlop.user_code = service.current_user_code;
        dlop.fs_id = data.fs_id;
        fetchPropertyType()

        // dlop.id = data.id;
    };


    /*

    If house property is greater than 2,50,000
    */


    const editHouseProps = (currentRowData) => {
        // console.log(currentRowData);
        if (
            currentRowData.json_popups_value.property_type ==
            "Self Occupied Property"
        ) {
            sop.user_code = service.current_user_code;
            sop.fs_id = currentRowData.fs_id;
            sop.id = currentRowData.id;
            dailog_SelfOccupiedProperty.value = true;
            sop.lender_name = currentRowData.json_popups_value.lender_name;
            sop.lender_pan = currentRowData.json_popups_value.lender_pan;
            sop.lender_type = currentRowData.json_popups_value.lender_type;
            sop.loss_from_housing_property =
                currentRowData.json_popups_value.loss_from_housing_property;
            sop.property_type = currentRowData.json_popups_value.property_type;
            sop.address = currentRowData.json_popups_value.address;
        } else if (
            currentRowData.json_popups_value.property_type == "Let Out Property"
        ) {
            dailog_LetOutProperty.value = true;
            lop.user_code = service.current_user_code;
            lop.id = currentRowData.id;
            lop.fs_id = currentRowData.fs_id;
            lop.lender_name = currentRowData.json_popups_value.lender_name;
            lop.lender_pan = currentRowData.json_popups_value.lender_pan;
            lop.lender_type = currentRowData.json_popups_value.lender_type;
            lop.rent_received = currentRowData.json_popups_value.rent_received;
            lop.municipal_tax = currentRowData.json_popups_value.municipal_tax;
            lop.maintenance = currentRowData.json_popups_value.maintenance;
            lop.net_value = currentRowData.json_popups_value.net_value;
            lop.interest = currentRowData.json_popups_value.interest;
            lop.income_loss = currentRowData.json_popups_value.income_loss;
        } else if (
            currentRowData.json_popups_value.property_type ==
            "Deemed Let Out Property"
        ) {
            dailog_DeemedLetOutProperty.value = true;
            dlop.user_code = service.current_user_code;
            dlop.fs_id = currentRowData.fs_id;
            dlop.id = currentRowData.id;
            dlop.lender_name = currentRowData.json_popups_value.lender_name;
            dlop.lender_pan = currentRowData.json_popups_value.lender_pan;
            dlop.lender_type = currentRowData.json_popups_value.lender_type;
            dlop.rent_received = currentRowData.json_popups_value.rent_received;
            dlop.municipal_tax = currentRowData.json_popups_value.municipal_tax;
            dlop.maintenance = currentRowData.json_popups_value.maintenance;
            dlop.net_value = currentRowData.json_popups_value.net_value;
            dlop.interest = currentRowData.json_popups_value.interest;
            dlop.income_loss = currentRowData.json_popups_value.income_loss;
        } else {
            console.log("No more Property Type");
        }
    };

    const deleteHouseProps = (currentRowData) => {
        // console.log(currentRowData['json_popups_value'].property_type);
        confirm.require({
            message: "Do you want to delete this record?",
            header: "Delete Confirmation",
            icon: "pi pi-info-circle",
            acceptClass: "p-button-danger",
            accept: () => {
                canShowLoading.value = true;
                axios
                    .post("/investments/deleteHousePropertyDetails", {
                        current_table_id: currentRowData.id,
                    })
                    .finally(() => {
                        canShowLoading.value = false;
                        toast.add({
                            severity: "error",
                            summary: "Deleted",
                            detail: `${currentRowData["json_popups_value"].property_type} is Deleted`,
                            life: 3000,
                        });
                        fetchPropertyType();
                        getInvestmentSource();
                    });
            },
            reject: () => {
                console.log("House property Delete Action Rejected");
            },
        });
    };
    const saveSelfOccupiedProperty = () => {
        canShowLoading.value = true;
        dailog_SelfOccupiedProperty.value = false;
        // console.log(sop);
        axios
            .post("/investments/saveSectionPopups", sop)
            .then((res) => {
                // console.log(res.data);
            })
            .finally(() => {
                fetchPropertyType();
                getInvestmentSource();
                canShowLoading.value = false;
                toast.add({
                    severity: "success",
                    summary: "Saved",
                    detail: `new ${sop.property_type} is Drafted `,
                    life: 3000,
                });
                restChars();
            });
    };
    const saveLetOutProperty = () => {
        // console.log(lop);
        canShowLoading.value = true;
        dailog_LetOutProperty.value = false;
        axios
            .post("/investments/saveSectionPopups", lop)
            .then((res) => {
                // console.log(res.data);
            })
            .finally(() => {
                fetchPropertyType();
                getInvestmentSource();
                canShowLoading.value = false;
                toast.add({
                    severity: "success",
                    summary: "Saved",
                    detail: `new ${lop.property_type} is Drafted `,
                    life: 3000,
                });
                restChars();
            });
    };
    const saveDeemedLetOutProperty = () => {
        // console.log(dlop);
        canShowLoading.value = true;
        dailog_DeemedLetOutProperty.value = false;
        axios
            .post("/investments/saveSectionPopups", dlop)
            .then((res) => {
                // console.log(res.data);
            })
            .finally(() => {
                fetchPropertyType();
                getInvestmentSource();
                canShowLoading.value = false;
                toast.add({
                    severity: "success",
                    summary: "Saved",
                    detail: `new ${dlop.property_type} is Drafted `,
                    life: 3000,
                });
                restChars();
            });
    };

    const fetchInvestmentSummary = () => {
        axios.get('/investments/investment-summary').then(res => {
            investmentSummarySource.value = res.data
        }).finally(() => {
            canShowLoading.value = false
            var declared_amt = 0;
            var max_limit = 0;
            // console.log("completed");
            investmentSummarySource.value.forEach((item) => {
                declared_amt += item.dec_amount;
                max_limit += item.amount_rejected;
            });
            console.log("declaration amount :" + declared_amt);
            taxSavingInvestments.declared_amt = declared_amt;
            taxSavingInvestments.max_limit = parseInt(max_limit) + parseInt(declared_amt);

        })
    }

    const metrocitiesOption = ref([
        { id: 1, name: "Chennai", value: "Chennai" },
        { id: 2, name: "Mumbai", value: "Mumbai" },
        { id: 3, name: "Hyderabad", value: "Hyderabad" },
        { id: 4, name: "Kolkatta", value: "Kolkatta" },
        { id: 5, name: "Other Non Metro", value: "Other Non Metro" },
    ]);

    const lenderTypeOption = ref([
        { name: "Financial Institution", code: "Financial Institution" },
        { name: "Others", code: "Others" },
    ]);

    const restChars = () => {
        hra.from_month = null;
        hra.to_month = null;
        hra.total_rent_paid = null;
        hra.address = null;
        hra.city = null;
        hra.landlord_name = null;
        hra.landlord_PAN = null;
        other_exe_80EE.loan_sanction_date = null;
        other_exe_80EE.lender_type = null;
        other_exe_80EE.property_value = null;
        other_exe_80EE.loan_amount = null;
        other_exe_80EE.interest_amount_paid = null;
        other_exe_80EE.vechicle_brand = null;
        other_exe_80EE.vechicle_model = null;
        other_exe_80EE.interest_amount_paid = null;
        other_exe_80EEA.loan_sanction_date = null;
        other_exe_80EEA.lender_type = null;
        other_exe_80EEA.property_value = null;
        other_exe_80EEA.loan_amount = null;
        other_exe_80EEA.interest_amount_paid = null;
        other_exe_80EEA.vechicle_brand = null;
        other_exe_80EEA.vechicle_model = null;
        other_exe_80EEA.interest_amount_paid = null;
        other_exe_80EEB.loan_sanction_date = null;
        other_exe_80EEB.lender_type = null;
        other_exe_80EEB.property_value = null;
        other_exe_80EEB.loan_amount = null;
        other_exe_80EEB.interest_amount_paid = null;
        other_exe_80EEB.vechicle_brand = null;
        other_exe_80EEB.vechicle_model = null;
        other_exe_80EEB.interest_amount_paid = null;
        sop.lender_name = null;
        sop.lender_pan = null;
        sop.lender_type = null;
        sop.address = null;
        lop.lender_name = null;
        lop.lender_pan = null;
        lop.lender_type = null;
        lop.loss_from_housing_property = null;
        lop.address = null;
        lop.rent_received = null;
        lop.municipal_tax = null;
        lop.maintenance = null;
        lop.net_value = null;
        lop.interest = null;
        lop.income_loss = null;
        dlop.lender_name = null;
        dlop.lender_pan = null;
        dlop.lender_type = null;
        dlop.loss_from_housing_property = null;
        dlop.address = null;
        dlop.rent_received = null;
        dlop.municipal_tax = null;
        dlop.maintenance = null;
        dlop.net_value = null;
        dlop.interest = null;
        dlop.income_loss = null;
    };


    /*
    Tax declaration
    */


    const tax_deduction = ref()
    const total_gross = ref()
    const total_taxable = ref()
    const regime = ref()
    const age = ref()
    const lastUpdated = ref()





    const fetchTaxableIncomeInfo = async () => {
        await axios.get('/investments/TaxDeclaration').then(res => {
            tax_deduction.value = res.data
            if (res.data[7].regime == 'old') {
                total_gross.value = res.data[6].old_regime
            } else {
                total_gross.value = res.data[6].new_regime
            }

            total_taxable.value = res.data[7].old_regime
            age.value = res.data[7].age
            regime.value = res.data[7].regime
            lastUpdated.value = res.data[7].last_updated
        }).finally(() => {
            canShowLoading.value = false
            disableRegime(lastUpdated.value)
        })
    }

    const disableRegime = (value) => {

        let currentDate = new Date();
        let updatedDate = '';

        if (value) {
            updatedDate = new Date(value);
        } else {
            updatedDate = new Date();
        }

        if (updatedDate >= currentDate) {
            return true
        } else {
            return false
        }

    }

    return {
        fetchotherExe,
        Dec80EE,
        Dec80EEA,
        Dec80EEB,

        // varaible Declarations
        investment_exemption_steps,
        currentUSerCode,
        canShowLoading,
        getInvestmentSource,
        saveFormData,
        getFormId,
        formatCurrency,
        editingRowSource,
        updatedRowSource,
        canShowSubmissionStatus,
        submitFormData,

        // Data Source

        investmentMainSource,
        formDataSource,
        hraSource,
        section80ccSource,
        otherExemptionSource,
        housePropertySource,
        reimbursmentSource,
        previousEmployeerIncomeSource,
        otherIncomeSource,
        isSubmitted,
        epfPayrollDeduction,
        vpfPayrollDeduction,
        reimbursemntMaxLimit,

        // Tax Saving Investments

        taxSavingInvestments,
        fetchInvestmentSummary,
        investmentSummarySource,

        // hra begins

        hra_data,
        disableSaveHra,
        hra,
        current_data,
        dailogAddNewRental,
        dailogEditNewRental,
        editHraNewRental,
        fetchHraNewRental,
        saveHraNewRental,
        deleteRentalDetails,
        AddHraButtonDisabled,

        // hra ends

        // Sectiom 80cc Begins
        getDeclarationAmount,

        // Sectiom 80cc Ends

        // Other exemptiom Begins
        otherExe,
        other_Exe,
        dailog_80EE,
        dailog_80EEA,
        dailog_80EEB,
        other_exe_80EE,
        other_exe_80EEA,
        other_exe_80EEB,
        save80EE,
        save80EEA,
        save80EEB,
        get80EESlotData,
        get80EEASlotData,
        get80EEBSlotData,
        otherExeSectionData,
        editOtherExe,
        deleteOtherExeDetails,

        // Other exemptiom Ends

        // House Property Begins

        house_props_data,
        dailog_SelfOccupiedProperty,
        dailog_DeemedLetOutProperty,
        dailog_LetOutProperty,
        income_loss_calculation,
        fetchPropertyType,
        saveSelfOccupiedProperty,
        saveLetOutProperty,
        saveDeemedLetOutProperty,
        hop,
        lop,
        sop,
        dlop,
        getDlopSlotData,
        getLopSlotData,
        getSopSlotData,
        editHouseProps,
        deleteHouseProps,

        // House Property End

        metrocitiesOption,
        lenderTypeOption,
        employeDoj,
        sumOfTotalRentPaid,


        // Tax declaration

        fetchTaxableIncomeInfo,tax_deduction,total_gross,regime,age,lastUpdated,disableRegime

    };
});
