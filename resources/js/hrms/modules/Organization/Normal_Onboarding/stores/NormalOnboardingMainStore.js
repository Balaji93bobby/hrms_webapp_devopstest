import { defineStore } from "pinia";
import { Service } from "../../../Service/Service";
import { computed, reactive, ref } from "vue";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import axios from "axios";
import { inject } from "vue";
import { useToast } from "primevue/usetoast";
import { faLessThanEqual } from "@fortawesome/free-solid-svg-icons";






export const useNormalOnboardingMainStore = defineStore("useNormalOnboardingMainStore", () => {

    const service = Service()
    const swal = inject("$swal");
    const canShowLoading = ref(false)
    const toast = useToast();



    // variable declaration

    const employee_onboarding = reactive({
        can_onboard_employee: 1,
        emp_client_code: '',
        employee_code: "",
        doj: "",
        aadhar_number: "",
        passport_number: "",
        bank_id: "",
        bank_name: "",
        employee_name: "",
        gender: "",
        pan_number: "",
        passport_date: "",
        AccountNumber: "",
        dob: "",
        mobile_number: "",
        dl_no: "",
        blood_group_name: "",
        blood_group_id: "",
        bank_ifsc: "",
        marital_status: "",
        marital_status_id: "",
        email: "",
        nationality: "",
        physically_challenged: "",
        first_letter_emp_name: '',
        second_letter_emp_name: '',

        // person Detials End

        // Address detials

        // Current Address Detials Start

        current_address_line_1: "",
        current_address_line_2: "",
        current_country: "",
        current_state: "",
        current_country_id: "",
        current_state_id: "",
        current_city: "",
        current_pincode: "",

        // Current Address Details End

        // Permanant Address Start

        permanent_address_line_1: "",
        permanent_address_line_2: "",
        permanent_country: "",
        permanent_state: "",
        permanent_country_id: "",
        permanent_state_id: "",
        permanent_city: "",
        permanent_pincode: "",

        // Permanant Address end

        // Office Detials Start

        department: "",
        department_id: "",
        process: "",
        designation: "",
        cost_center: "",
        probation_period: "",
        work_location: "",
        l1_manager_code: "",
        l1_manager_code_id: "",
        holiday_location: "",
        officical_mail: "",
        official_mobile: "",
        emp_notice: "",
        confirmation_period: "",

        // Office Details End

        // family Details Start

        father_name: "",
        dob_father: "",
        father_gender: "Male",
        father_age: "",
        mother_name: "",
        dob_mother: "",
        mother_gender: "Female",
        mother_age: "",
        spouse_name: "",
        wedding_date: "",
        spouse_gender: "",
        dob_spouse: "",
        no_of_children: "",

        // family Details End

        //   compensatory Detials start

        basic: "",
        hra: "",
        statutory_bonus: "",
        child_education_allowance: "",
        food_coupon: "",
        lta: "",
        other_allowance: "",
        special_allowance: "",
        graduity: "",
        cic: "",
        insurance: "",
        epf_employee: "",
        epf_employer_contribution: "",
        esic_employee: "",
        esic_employer_contribution: "",
        professional_tax: "",
        labour_welfare_fund: "",
        net_income: "0",
        total_ctc: 0,

        // Personal Documents Start

        AadharCardFront: "",
        AadharCardBack: "",
        PanCardDoc: "",
        DrivingLicenseDoc: "",
        EductionDoc: "",
        VoterIdDoc: "",
        RelievingLetterDoc: "",
        PassportDoc: "",

        save_draft_messege: ""
    });

    const CopyAddresschecked = ref(false);
    const isSpouseDisable = ref(false);
    const isNationalityVisible = ref(false);
    const checkIsQuickOrNormal = ref()
    const family_details_disable = ref(false)
    const clientCode = ref()
    const RequiredDocument = ref(false)
    const user_code_exists = ref(false);
    const personal_mail_exists = ref(false);
    const is_mobile_no_exists = ref(false)
    const is_ac_no_exists = ref(false)
    const pan_card_exists = ref(false);
    const mandatoryDocuments = ref()
    const isMandatoryDocuments = reactive({
        AadharFrontIsMandatory: true,
        AadharBackIsMandatory: true,
        panCardIsMandatory: true,
        educationCertificateIsMandatory: true,
        passport: true,
        DrivingLicense: true,
        voterId: true,
        RelievingLetter: true
    })



    const getPersonalDocuments = (e, filename) => {

        let selectedDocument = e.target.files[0]
        console.log(selectedDocument);

        const maxSizeInBytes = 2 * 512 * 512;
        // Get uploaded file
        // || selectedDocument.type == 'application/pdf'
        if (selectedDocument) {
            if (selectedDocument.type == 'image/jpeg' || selectedDocument.type == 'image/png' ) {
                if (filename == 'AadharFront') {
                    employee_onboarding.AadharCardFront = e.target.files[0]

                    if(employee_onboarding.AadharCardFront.size  > maxSizeInBytes ){

                        console.log('testing image update size :: ');
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: `The file its too large.Allowed maximum size is 1MB ${employee_onboarding.AadharCardFront.name}`,
                            life: 3000,
                        });
                        // console.log(filename,employee_onboarding.AadharCardFront);
                        employee_onboarding.AadharCardFront = '' ;
                        e.target.files[0] ="";
                        selectedDocument = "";
                    };

                } else
                    if (filename == 'AadharBack') {
                        employee_onboarding.AadharCardBack = e.target.files[0];

                        if( employee_onboarding.AadharCardBack.size  > maxSizeInBytes ){

                            console.log('testing image update size :: ');
                            toast.add({
                                severity: "error",
                                summary: "Error",
                                detail: `The file its too large.Allowed maximum size is 1MB ${employee_onboarding.AadharCardBack.name}`,
                                life: 3000,
                            });
                            // console.log(filename,employee_onboarding.AadharCardFront);
                            employee_onboarding.AadharCardBack = '' ;
                            e.target.files[0] ="";
                            selectedDocument = "";
                        };
                    } else
                        if (filename == 'Pancard') {
                            employee_onboarding.PanCardDoc = e.target.files[0];
                            if(  employee_onboarding.PanCardDoc.size  > maxSizeInBytes ){

                                console.log('testing image update size :: ');
                                toast.add({
                                    severity: "error",
                                    summary: "Error",
                                    detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.PanCardDoc.name}`,
                                    life: 3000,
                                });
                                // console.log(filename,employee_onboarding.AadharCardFront);
                                employee_onboarding.PanCardDoc = '' ;
                                e.target.files[0] ="";
                                selectedDocument = "";
                            };
                        } else
                            if (filename == 'DrivingLicense') {
                                employee_onboarding.DrivingLicenseDoc = e.target.files[0];

                                 if(  employee_onboarding.DrivingLicenseDoc.size  > maxSizeInBytes ){

                                console.log('testing image update size :: ');
                                toast.add({
                                    severity: "error",
                                    summary: "Error",
                                    detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.DrivingLicenseDoc.name}`,
                                    life: 3000,
                                });
                                // console.log(filename,employee_onboarding.AadharCardFront);
                                employee_onboarding.DrivingLicenseDoc = '' ;
                                e.target.files[0] ="";
                                selectedDocument = "";
                            };


                            } else
                                if (filename == 'Passport') {
                                    employee_onboarding.PassportDoc = e.target.files[0];
                                    if(  employee_onboarding.PassportDoc.size  > maxSizeInBytes ){

                                        console.log('testing image update size :: ');
                                        toast.add({
                                            severity: "error",
                                            summary: "Error",
                                            detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.PassportDoc.name}`,
                                            life: 3000,
                                        });
                                        // console.log(filename,employee_onboarding.AadharCardFront);
                                        employee_onboarding.PassportDoc = '' ;
                                        e.target.files[0] ="";
                                        selectedDocument = "";
                                    };
                                } else
                                    if (filename == 'VoterId') {
                                        employee_onboarding.VoterIdDoc = e.target.files[0];
                                        if(  employee_onboarding.VoterIdDoc.size  > maxSizeInBytes ){

                                            console.log('testing image update size :: ');
                                            toast.add({
                                                severity: "error",
                                                summary: "Error",
                                                detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.VoterIdDoc.name}`,
                                                life: 3000,
                                            });
                                            // console.log(filename,employee_onboarding.AadharCardFront);
                                            employee_onboarding.VoterIdDoc = '' ;
                                            e.target.files[0] ="";
                                            selectedDocument = "";
                                        };

                                    } else
                                        if (filename == 'EducationCertificate') {
                                            employee_onboarding.EductionDoc = e.target.files[0]
                                            if(  employee_onboarding.EductionDoc.size  > maxSizeInBytes ){

                                                console.log('testing image update size :: ');
                                                toast.add({
                                                    severity: "error",
                                                    summary: "Error",
                                                    detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.EductionDoc.name}`,
                                                    life: 3000,
                                                });
                                                // console.log(filename,employee_onboarding.AadharCardFront);
                                                employee_onboarding.EductionDoc = '' ;
                                                e.target.files[0] ="";
                                                selectedDocument = "";
                                            };
                                        } else
                                            if (filename == 'RelievingLetter') {
                                                employee_onboarding.RelievingLetterDoc = e.target.files[0]
                                                if(  employee_onboarding.RelievingLetterDoc.size  > maxSizeInBytes ){

                                                    console.log('testing image update size :: ');
                                                    toast.add({
                                                        severity: "error",
                                                        summary: "Error",
                                                        detail: `The file its too large.Allowed maximum size is 1MB ${ employee_onboarding.RelievingLetterDoc.name}`,
                                                        life: 3000,
                                                    });
                                                    // console.log(filename,employee_onboarding.AadharCardFront);
                                                    employee_onboarding.RelievingLetterDoc = '' ;
                                                    e.target.files[0] ="";
                                                    selectedDocument = "";
                                                };
                                            } else {
                                                console.log("No more files");
                                            }

            } else {
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Upload Valid File format",
                    life: 3000,
                });
            }


        }


    }



    const bankList = ref();
    const country = ref();
    const departmentDetails = ref();
    const state = ref();
    const Managerdetails = ref();
    const maritalDetails = ref();
    const bloodGroups = ref();



    const Sampledata = () => {
        // employee_onboarding.employee_code = ref("B090");
        //employee_onboarding.employee_name = ref("George David");
        employee_onboarding.aadhar_number = ref("3977 8798 6564");
        // employee_onboarding.doj = ref("23-4-2020");
        employee_onboarding.pan_number = ref("BGAJP6646F");
        employee_onboarding.blood_group_name = ref("B Positive");
        employee_onboarding.dob = ref("23-07-2000");
        // employee_onboarding.email = ref("example@gmail.com");
        employee_onboarding.dl_no = ref("HR-0619850034761");
        employee_onboarding.passport_number = ref("A2096457");
        employee_onboarding.passport_date = ref("23-5-2030");
        employee_onboarding.bank_name = ref("ANDHRA BANK");
        employee_onboarding.physically_challenged = ref("No");
        employee_onboarding.AccountNumber = ref("35216644292");
        employee_onboarding.bank_ifsc = ref("SBIN0121325");
        employee_onboarding.nationality = ref("Indian");
        employee_onboarding.gender = ref("Male");
        employee_onboarding.marital_status = ref("Married");
        employee_onboarding.mobile_number = ref('8248023344');
        employee_onboarding.current_address_line_1 = ref("45/21 2nd Avenue,chennai");
        employee_onboarding.current_address_line_2 = ref("45/21 2nd Avenue,chennai");
        employee_onboarding.current_country = ref("India");
        employee_onboarding.current_state = ref("Tamil Nadu");
        employee_onboarding.current_city = ref("chennai");
        employee_onboarding.current_pincode = ref("600023");
        employee_onboarding.permanent_address_line_1 = ref(
            "45/21 2nd Avenue,chennai"
        );
        employee_onboarding.permanent_address_line_2 = ref(
            "45/21 2nd Avenue,chennai"
        );
        employee_onboarding.permanent_country = ref("India");
        employee_onboarding.permanent_city = ref("chennai");
        employee_onboarding.permanent_state = ref("Tamil Nadu");
        employee_onboarding.permanent_pincode = ref("600003");
        employee_onboarding.department = ref("IT");
        employee_onboarding.process = ref("Iti");
        //employee_onboarding.designation = ref("Developer");
        employee_onboarding.cost_center = ref("Chennai");
        //  employee_onboarding.probation_period = ref("11 Month");
        employee_onboarding.holiday_location = ref("Tamilnadu");
        //  employee_onboarding.l1_manager_code = ref("PLIPL076-Muthu Selvan");
        employee_onboarding.work_location = ref("chennai");
        employee_onboarding.officical_mail = ref("voidmax@gmail.com");
        employee_onboarding.official_mobile = ref("4646454547");
        // employee_onboarding.emp_notice = ref(3);
        //  employee_onboarding.confirmation_period = ref("10-12-2019");
        employee_onboarding.father_name = ref("David");
        employee_onboarding.father_age = ref("45");
        employee_onboarding.dob_father = ref("23-09-1968");
        employee_onboarding.mother_name = ref("Licas");
        employee_onboarding.dob_mother = ref("23-8-1970");
        employee_onboarding.mother_gender = ref("Female");
        employee_onboarding.mother_age = ref("35");
        employee_onboarding.spouse_gender = ref("female");
        employee_onboarding.dob_spouse = ref("12-8-1995");
        employee_onboarding.spouse_name = ref("priyanka");
        //   employee_onboarding.basic = ref(13205);
        //   employee_onboarding.hra = ref(6603);
        //   employee_onboarding.statutory_bonus = ref(0);
        //   employee_onboarding.other_allowance = ref(0);
        //   employee_onboarding.child_education_allowance = ref(0);
        //   employee_onboarding.food_coupon = ref(0);
        //   employee_onboarding.lta = ref(0);
        //   employee_onboarding.special_allowance = ref(2200);
        //   employee_onboarding.gross = ref(1000);
        //   employee_onboarding.epf_employee= ref(1000);
        //   employee_onboarding.epf_employer_contribution = ref(1000);
        //   employee_onboarding.esic_employee = ref(1000);
        //   employee_onboarding.esic_employer_contribution = ref(1000);
        //   employee_onboarding.professional_tax = ref(1000);
        //   employee_onboarding.labour_welfare_fund = ref(1000);
        //   employee_onboarding.net_income = ref(1000);
        //   employee_onboarding.total_ctc = ref(1000);
        //   employee_onboarding.graduity = ref(1000);
        //   employee_onboarding.insurance = ref(1000);





    };


    const compensatoryCalWhileQuick = () => {
        compen_disable.value = false

        family_details_disable.value = true

        let gross = parseInt(employee_onboarding.basic) + parseInt(employee_onboarding.hra) + parseInt(employee_onboarding.special_allowance);
        employee_onboarding.gross = Math.floor(gross);
        // console.log(employee_onboarding.gross);

        let net = employee_onboarding.gross - employee_onboarding.epf_employee - employee_onboarding.esic_employee;

        employee_onboarding.net_income = net
        // console.log(net);

        let ctc = parseInt(employee_onboarding.gross) + parseInt(employee_onboarding.epf_employer_contribution) + parseInt(employee_onboarding.esic_employer_contribution) + parseInt(employee_onboarding.insurance) + parseInt(employee_onboarding.graduity)

        employee_onboarding.total_ctc = ctc

        // console.log(ctc);


    }



    function addYears(date, years) {
        date.setFullYear(date.getFullYear() + years);
        return date;
    }

    function subYears(date, years) {
        date.setFullYear(date.getFullYear() - years);
        return date;
    }

    const afterYears = (value) => {
        const newDate = addYears(value, 18);
        return newDate;
    }

    const beforeYears = (value) => {
        const newDate = subYears(value, 10);
        return newDate;
    }
    const dateOfBirth = (value) => {
        const newDate = subYears(value, 18);
        return newDate;
    }

    const isMandatoryDocument = (doc) => {
        console.log(doc);
        // if(doc == 1){
        //     return true
        // }else{
        //     return false
        // }
    }


    const validateFile = (value) => {
        if (value) {
            if (value.type == 'image/jpeg' || value.type == 'image/png' || value.type == 'application/pdf') {
                return true
            } else {
                return false
            }
        } else {
            return true
        }
    }

    const isMarried = (value) => {
        console.log("employee_onboarding.spouse_name",employee_onboarding.spouse_name);
        if (employee_onboarding.marital_status == 2) {
            if(value){
                return true
            }else{
                return false;
            }
        } else {
            return true
        }
    }

    const rules = computed(() => {

        return {
            employee_code: {},
            employee_name: { required },
            gender: {},
            passport_number: {},
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
                required: helpers.withMessage('Aadhar number is required', required),
                validateAadhar: helpers.withMessage('Invalid aadhar number', (value) => {
                    const regex = /^[2-9]{1}[0-9]{3}\s{1}[0-9]{4}\s{1}[0-9]{4}$/;
                    return regex.test(value);
                })
            },
            bank_name: {
                required,
            },

            gender: {
                required,
            },
            pan_number: {
                required: helpers.withMessage('Pan number is required', required),
                ValidatePan: helpers.withMessage('Invalid Pan number ', (value) => {
                    const regex = /^([a-zA-Z]){3}([Pp]){1}([a-zA-Z]){1}([0-9]){4}([a-zA-Z]){1}?$/;
                    return regex.test(value);
                }),
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
                required: helpers.withMessage('Ifsc code is required', required),
                ValidateIfscNo: helpers.withMessage('Invalid Ifsc code', (value) => {
                    const regex = /^[A-Za-z]{4}0[A-Za-z0-9]{6}$/;
                    return regex.test(value);
                }),
            },
            marital_status: { required },

            email: {
                required,
                email,
            },
            nationality: {
                required,
            },
            physically_challenged: {},
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
                email: helpers.withMessage('Enter valid email', email)
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
            spouse_name: {
                isMarried: helpers.withMessage('Spouse name is required', isMarried)
            },
            spouse_gender: {
                isMarried: helpers.withMessage('Spouse gender is required', isMarried)
            },
            dob_spouse: {
                isMarried: helpers.withMessage('Spouse dob is required', isMarried)
            },

            // Compensatory

            cic: {},

            // Personal Documents

            AadharCardFront: {
                required: helpers.withMessage('Aadhar front is required', (value) => {
                    if (!isMandatoryDocuments.AadharFrontIsMandatory) {
                        if (!value) {
                            return isMandatoryDocuments.AadharFrontIsMandatory
                        } else {
                            return !isMandatoryDocuments.AadharFrontIsMandatory
                        }
                    } else {
                        return true
                    }
                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            AadharCardBack: {
                required: helpers.withMessage('Aadhar back is required', (value) => {
                    if (!isMandatoryDocuments.AadharBackIsMandatory) {
                        if (!value) {
                            return isMandatoryDocuments.AadharBackIsMandatory
                        } else {
                            return !isMandatoryDocuments.AadharBackIsMandatory
                        }
                    } else {
                        return true
                    }
                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            PanCardDoc: {
                required: helpers.withMessage('Pan Card is required', (value) => {
                    if (!isMandatoryDocuments.panCardIsMandatory) {
                        if (!value) {
                            return isMandatoryDocuments.panCardIsMandatory
                        } else {
                            return !isMandatoryDocuments.panCardIsMandatory
                        }
                    } else {
                        return true
                    }

                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            DrivingLicenseDoc: {
                required: helpers.withMessage('Driving License is required', (value) => {
                    if (!isMandatoryDocuments.DrivingLicense) {
                        if (!value) {
                            return isMandatoryDocuments.DrivingLicense
                        } else {
                            return !isMandatoryDocuments.DrivingLicense
                        }
                    } else {
                        return true
                    }
                }
                ), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            EductionDoc: {
                required: helpers.withMessage('Education Certificate is required', (value) => {
                    if (!isMandatoryDocuments.educationCertificateIsMandatory) {
                        if (!value) {
                            return isMandatoryDocuments.educationCertificateIsMandatory
                        } else {
                            return !isMandatoryDocuments.educationCertificateIsMandatory
                        }
                    } else {
                        return true
                    }
                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            VoterIdDoc: {
                required: helpers.withMessage('Voter Id is required', (value) => {
                    if (!isMandatoryDocuments.voterId) {
                        if (!value) {
                            return isMandatoryDocuments.voterId
                        } else {
                            return !isMandatoryDocuments.voterId
                        }
                    } else {
                        return true
                    }
                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            RelievingLetterDoc: {
                required: helpers.withMessage('Relieving Letter is required', (value) => {
                    if (!isMandatoryDocuments.RelievingLetter) {
                        if (!value) {
                            return isMandatoryDocuments.RelievingLetter
                        } else {
                            return !isMandatoryDocuments.RelievingLetter
                        }
                    } else {
                        return true
                    }
                }), validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
            PassportDoc: {
                required: helpers.withMessage('passport is required', (value) => {
                    if (!isMandatoryDocuments.passport) {
                        if (!value) {
                            return isMandatoryDocuments.passport
                        } else {
                            return !isMandatoryDocuments.passport
                        }
                    } else {
                        return true
                    }
                }),
                validateFile: helpers.withMessage('Upload Valid format', validateFile)
            },
        }

    })

    const v$ = useValidate(rules, employee_onboarding);


    const submit = (isSubmitted) => {
        console.log(isSubmitted);

        let formData = new FormData();
        formData.append("can_onboard_employee", employee_onboarding.can_onboard_employee);
        formData.append("emp_client_code", employee_onboarding.emp_client_code);
        formData.append("employee_code", `${employee_onboarding.emp_client_code}${employee_onboarding.employee_code}`);
        formData.append("doj", employee_onboarding.doj ? moment(employee_onboarding.doj).format('YYYY-MM-DD') : employee_onboarding.doj);
        formData.append("aadhar_number", employee_onboarding.aadhar_number);
        formData.append("passport_number", employee_onboarding.passport_number);
        formData.append("bank_id", employee_onboarding.bank_name);
        //   formData.append("bank_name ", employee_onboarding.bank_name.bank_name );
        formData.append("employee_name", employee_onboarding.employee_name);
        formData.append(" gender", employee_onboarding.gender);
        formData.append("pan_number", employee_onboarding.pan_number);
        formData.append("passport_date", employee_onboarding.passport_date);
        formData.append("AccountNumber", employee_onboarding.AccountNumber);
        formData.append("dob", employee_onboarding.dob ? moment(employee_onboarding.dob).format('YYYY-MM-DD') : employee_onboarding.dob);
        formData.append("mobile_number", employee_onboarding.mobile_number);
        formData.append("dl_no", employee_onboarding.dl_no);
        formData.append("blood_group_name", employee_onboarding.blood_group_name);
        //   formData.append("blood_group_id", employee_onboarding.blood_group_id);
        formData.append("bank_ifsc", employee_onboarding.bank_ifsc);
        formData.append("marital_status", employee_onboarding.marital_status);
        //   formData.append("marital_status_id", employee_onboarding.marital_status_id);
        formData.append("email", employee_onboarding.email);
        formData.append("nationality", employee_onboarding.nationality);
        formData.append(
            "physically_challenged",
            employee_onboarding.physically_challenged
        );
        formData.append(
            "current_address_line_1",
            employee_onboarding.current_address_line_1
        );
        formData.append(
            "current_address_line_2",
            employee_onboarding.current_address_line_2
        );
        formData.append("current_country", employee_onboarding.current_country);
        //   formData.append("current_country_id", employee_onboarding.current_country_id);
        formData.append("current_state", employee_onboarding.current_state);
        //   formData.append("current_state_id", employee_onboarding.current_state_id);
        formData.append("current_city", employee_onboarding.current_city);
        formData.append("current_pincode", employee_onboarding.current_pincode);
        formData.append(
            " permanent_address_line_1",
            employee_onboarding.permanent_address_line_1
        );
        formData.append(
            "permanent_address_line_2",
            employee_onboarding.permanent_address_line_2
        );
        formData.append("permanent_country", employee_onboarding.permanent_country);
        //   formData.append(
        //     "permanent_country_id",
        //     employee_onboarding.permanent_country_id
        //   );
        formData.append("permanent_state", employee_onboarding.permanent_state);
        //   formData.append("permanent_state_id", employee_onboarding.permanent_state_id);
        formData.append("permanent_city", employee_onboarding.permanent_city);
        formData.append("permanent_pincode", employee_onboarding.permanent_pincode);
        formData.append("department", employee_onboarding.department);
        //   formData.append("department_id", employee_onboarding.department_id);
        formData.append("process", employee_onboarding.process);
        formData.append("designation", employee_onboarding.designation);
        formData.append("cost_center", employee_onboarding.cost_center);
        formData.append("probation_period", employee_onboarding.probation_period);
        formData.append("work_location", employee_onboarding.work_location);
        formData.append("l1_manager_code_id", employee_onboarding.l1_manager_code.user_code);
        formData.append("holiday_location", employee_onboarding.holiday_location);
        formData.append("officical_mail", employee_onboarding.officical_mail);
        formData.append("official_mobile", employee_onboarding.official_mobile);
        formData.append("emp_notice", employee_onboarding.emp_notice);
        formData.append(
            "confirmation_period",
            employee_onboarding.confirmation_period ? moment(employee_onboarding.confirmation_period).format('YYYY-MM-DD') : employee_onboarding.confirmation_period
        );
        formData.append("father_name", employee_onboarding.father_name);
        if (employee_onboarding.dob_father == '') {
            formData.append("dob_father", employee_onboarding.dob_father);
        } else {
            formData.append("dob_father", moment(employee_onboarding.dob_father).format('YYYY-MM-DD'));
        }
        formData.append("father_gender", employee_onboarding.father_gender);
        formData.append("father_age", employee_onboarding.father_age);
        formData.append("mother_name", employee_onboarding.mother_name);
        if (employee_onboarding.dob_mother == '') {
            formData.append("dob_mother", employee_onboarding.dob_mother);
        } else {
            formData.append("dob_mother", moment(employee_onboarding.dob_mother).format('YYYY-MM-DD'));
        }
        formData.append("mother_gender", employee_onboarding.mother_gender);
        formData.append("mother_age", employee_onboarding.mother_age);
        formData.append("spouse_name", employee_onboarding.spouse_name);
        if (employee_onboarding.wedding_date == '') {
            formData.append("wedding_date", employee_onboarding.wedding_date);
        } else {
            formData.append("wedding_date", moment(employee_onboarding.wedding_date).format('YYYY-MM-DD'));
        }
        formData.append("spouse_gender", employee_onboarding.spouse_gender);
        if (employee_onboarding.dob_spouse == '') {
            formData.append("dob_spouse", employee_onboarding.dob_spouse);
        } else {
            formData.append("dob_spouse", moment(employee_onboarding.dob_spouse).format('YYYY-MM-DD'));
        }
        formData.append("no_of_children", employee_onboarding.no_of_children);
        formData.append("basic", employee_onboarding.basic);
        formData.append("hra", employee_onboarding.hra);
        formData.append("statutory_bonus", employee_onboarding.statutory_bonus);
        formData.append(
            "child_education_allowance",
            employee_onboarding.child_education_allowance
        );
        formData.append("food_coupon", employee_onboarding.food_coupon);
        formData.append("lta", employee_onboarding.lta);
        formData.append("special_allowance", employee_onboarding.special_allowance);
        formData.append("other_allowance", employee_onboarding.other_allowance);
        formData.append("gross", employee_onboarding.gross);
        formData.append(
            "epf_employer_contribution",
            employee_onboarding.epf_employer_contribution
        );
        formData.append("graduity", employee_onboarding.graduity);
        formData.append("insurance", employee_onboarding.insurance);
        formData.append("cic", employee_onboarding.total_ctc);
        formData.append("epf_employee", employee_onboarding.epf_employee);
        formData.append("esic_employee", employee_onboarding.esic_employee);
        formData.append(
            "esic_employer_contribution",
            employee_onboarding.esic_employer_contribution
        );
        formData.append("professional_tax", employee_onboarding.professional_tax);
        formData.append(
            "labour_welfare_fund",
            employee_onboarding.labour_welfare_fund
        );
        formData.append("net_income", employee_onboarding.net_income);
        formData.append("Aadharfront", employee_onboarding.AadharCardFront);
        formData.append("AadharBack", employee_onboarding.AadharCardBack);
        formData.append("panDoc", employee_onboarding.PanCardDoc);
        formData.append("eductionDoc", employee_onboarding.EductionDoc);
        formData.append("releivingDoc", employee_onboarding.RelievingLetterDoc);
        formData.append("voterId", employee_onboarding.VoterIdDoc);
        formData.append("passport", employee_onboarding.PassportDoc);
        formData.append("dlDoc", employee_onboarding.DrivingLicenseDoc);

        console.log(formData);

        canShowLoading.value = true

        axios
            .post("/vmt-employee-onboard", formData)
            .then((response) => {
                if (response.data.status == 'success') {
                    if (isSubmitted == 1) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                    Swal.fire({
                        title: response.data.status = "success",
                        text: response.data.message,
                        icon: "success",
                        showCancelButton: false,
                    }).then((result) => {
                        if (checkIsQuickOrNormal.value == 'quick') {
                            if (response.data.can_redirect == "1") {
                                window.location.href = '/Information';
                            }
                        }
                    });


                }
                else {
                    Swal.fire(
                        'Failure',
                        `${response.data.message}`,
                        'error'
                    )
                }


                employee_onboarding.save_draft_messege = response.data;

            })
            .catch(function (error) {
                // currentObj.output = error;
                console.log(error);
            }).finally(() => {
                canShowLoading.value = false
            })
    };


    const submitForm = (isEmployeeOnboard) => {



        employee_onboarding.can_onboard_employee = isEmployeeOnboard
        v$.value.$validate() // checks all inputs

        if (!user_code_exists.value && !personal_mail_exists.value) {
            if (!is_mobile_no_exists.value && !is_ac_no_exists.value) {
                if (isEmployeeOnboard == 0) {
                    if (employee_onboarding.employee_code && employee_onboarding.employee_name) {
                        if (employee_onboarding.mobile_number && employee_onboarding.email) {
                            submit(isEmployeeOnboard)
                            v$.value.$reset()
                        } else {
                            RequiredDocument.value = true
                        }
                    } else {
                        RequiredDocument.value = true
                    }
                } else
                    if (isEmployeeOnboard == 1) {
                        if (!v$.value.$error) {
                            // if ANY fail validation
                            console.log('Form successfully submitted.')
                            submit(isEmployeeOnboard)

                            if(checkIsQuickOrNormal.value){
                                window.location.href = '/Information';
                            }
                          //  v$.value.$reset()

                        } else {
                            console.log('Form failed validation')
                            toast.add({
                                severity: "error",
                                summary: "Invalid",
                                detail: "fill mandatory fields",
                                life: 3000,
                            });
                        }
                    }
            }

        } else {
            console.log("invalid");
        }

    }

    //If the URL has hashed param, then it means quick-onboarded user is accessing this page.So, fetch his existing data



    const isQuickOrBulkOnboarding = (user_id) => {


        if (user_id) {
            axios.post('/fetch-quickonboarded-emp-details', {
                user_id: user_id,
            }).then((result) => {
                populateQuickOnboardData(result.data);
                // console.log("result" + result.data);
            });
        }
        else {
            console.log("UID not found in req params");
            axios.get('/get-client-code').then(res => {
                console.log(res.data);
                clientCode.value = res.data
                employee_onboarding.emp_client_code = res.data
            })
        }
    }


    const populateQuickOnboardData = (emp_data) => {
        console.log("populate data");
        console.log("populateQuickOnboardData : " + JSON.stringify(emp_data));

        checkIsQuickOrNormal.value = emp_data.onboard_type;

        if (emp_data.onboard_type == 'quick' || emp_data.onboard_type == 'bulk') {
            console.log(emp_data.onboard_type + "Onboarding");

            family_details_disable.value = true
            compen_disable.value = false
            readonly.is_emp_code_quick = true
            readonly.is_doj_quick = true
            readonly.is_emp_name_quick = true
            readonly.is_mob_quick = true
            readonly.is_email_quick = true
            readonly.statutory = true
            readonly.child = true
            readonly.fdc = true
            readonly.lta = true
            readonly.other = true
            readonly.mobile = true
            readonly.designation = true
            readonly.isDisableClientCode = false
            // setTimeout(() => {
            //   compensatoryCalWhileQuick()
            //   spouseEnable()
            // }, 3000);
        } else {
            console.log("normal onboarding");
        }

        if(emp_data.marital_status_id == '2'){
            isSpouseDisable.value = true;
            // console.log(emp_data.marital_status_id,'marital_status_id');
        }
        //  console.log("statustoy" + emp_data.statutory_bonus);
        console.log(ref(emp_data.gender),'ref(emp_data.gender)');
        spouseGenderCheck(emp_data.gender);
        employee_onboarding.employee_code = ref(emp_data.user_code);
        employee_onboarding.employee_name = ref(emp_data.name);
        employee_onboarding.dob = ref(emp_data.dob);
        employee_onboarding.marital_status = parseInt(emp_data.marital_status_id);
        employee_onboarding.gender = ref(emp_data.gender);
        employee_onboarding.aadhar_number = ref(emp_data.aadhar_number);
        employee_onboarding.pan_number = ref(emp_data.pan_number);
        employee_onboarding.dl_no = ref(emp_data.dl_no);
        employee_onboarding.nationality = ref(emp_data.nationality);
        employee_onboarding.blood_group_name = ref(emp_data.blood_group_name);
        employee_onboarding.email = ref(emp_data.email);
        employee_onboarding.doj = ref(emp_data.doj);
        employee_onboarding.mobile_number = ref(emp_data.mobile_number);
        employee_onboarding.designation = ref(emp_data.designation);
        employee_onboarding.l1_manager_code = ref(emp_data.l1_manager_code);
        console.log("emp_data.basic"+stringIntoNumber(emp_data.basic) );
        employee_onboarding.basic = ref(stringIntoNumber(emp_data.basic));
        employee_onboarding.hra = ref(stringIntoNumber(emp_data.hra));
        employee_onboarding.statutory_bonus = ref(stringIntoNumber(emp_data.Statutory_bonus));
        employee_onboarding.child_education_allowance = ref(stringIntoNumber(emp_data.child_education_allowance));
        employee_onboarding.food_coupon = ref(stringIntoNumber(emp_data.food_coupon));
        employee_onboarding.lta = ref(stringIntoNumber(emp_data.lta));
        employee_onboarding.special_allowance = ref(stringIntoNumber(emp_data.special_allowance));
        employee_onboarding.other_allowance = ref(stringIntoNumber(emp_data.other_allowance));
        employee_onboarding.epf_employer_contribution = ref(stringIntoNumber(emp_data.epf_employer_contribution));
        employee_onboarding.esic_employer_contribution = ref(stringIntoNumber(emp_data.esic_employer_contribution));
        employee_onboarding.insurance = ref(stringIntoNumber(emp_data.insurance));
        employee_onboarding.graduity = ref(stringIntoNumber((emp_data.graduity)));
        employee_onboarding.epf_employee = ref(stringIntoNumber(emp_data.epf_employee));
        employee_onboarding.esic_employee = ref(stringIntoNumber(emp_data.esic_employee));
        employee_onboarding.professional_tax = ref(stringIntoNumber(emp_data.professional_tax));
        employee_onboarding.labour_welfare_fund = ref(stringIntoNumber(emp_data.labour_welfare_fund));
        employee_onboarding.cic = ref(stringIntoNumber(emp_data.cic));
        // spouseDisable(emp_data.marital_status_id);

    }

    function spouseDisable(val){
        console.log(val,"spouseDisable");
        if (employee_onboarding.marital_status == 2 || val ==2) {
            isSpouseDisable.value = true;
        } else {
            isSpouseDisable.value = false;
        }
    };



    const getBasicDeps = () => {
        // For Bank Data
        service.getBankList().then((result) => bankList.value = result.data);
        //  For Countries
        service.getCountryList().then((result) => (country.value = result.data));

        service.getStateList().then((result) => (state.value = result.data));
        //   employee_onboarding.current_state = "Tamil Nadu";
        //   employee_onboarding.permanent_state = "Tamil Nadu";
        // for Manager Details
        service.ManagerDetails().then((result) => (Managerdetails.value = result.data));

        //Get Department details

        service.DepartmentDetails().then((result) => (departmentDetails.value = result.data));

        service.getMaritalStatus().then((result) => {
            maritalDetails.value = result.data;
        });

        service.getBloodGroups().then((result) => (bloodGroups.value = result.data));

        axios.get('/getMandatoryDocumentDetails').then(res => {
            mandatoryDocuments.value = res.data
            console.log(res.data[0]);
        }).finally(() => {
            if (mandatoryDocuments.value) {
                console.log("working");
                mandatoryDocuments.value.forEach(element => {
                    if (element.document_name == "Aadhar Card Front") {
                        if (element.is_mandatory == 1) {
                            console.log("Aadhar Card Front in man");
                            isMandatoryDocuments.AadharFrontIsMandatory = false
                        }
                    }
                    if (element.document_name == "Aadhar Card Back") {
                        if (element.is_mandatory == 1) {
                            console.log("Aadhar Card Back in man");

                            isMandatoryDocuments.AadharBackIsMandatory = false
                        }
                    }
                    if (element.document_name == "Pan Card") {
                        if (element.is_mandatory == 1) {
                            console.log("Pan in man");

                            isMandatoryDocuments.panCardIsMandatory = false
                        }
                    }
                    if (element.document_name == "Education Certificate") {
                        if (element.is_mandatory == 1) {
                            console.log("Education in man");

                            isMandatoryDocuments.educationCertificateIsMandatory = false
                        }
                    }
                    if (element.document_name == "Passport") {
                        if (element.is_mandatory == 1) {
                            console.log("Passport in man");

                            isMandatoryDocuments.passport = false
                        }
                    }
                    if (element.document_name == "Voter ID") {
                        if (element.is_mandatory == 1) {
                            isMandatoryDocuments.voterId = false
                        }
                    }
                    if (element.document_name == "Driving License") {
                        if (element.is_mandatory == 1) {
                            isMandatoryDocuments.DrivingLicense = false
                        }
                    }
                    if (element.document_name == "Relieving Letter") {
                        if (element.is_mandatory == 1) {
                            isMandatoryDocuments.RelievingLetter = false
                        }
                    }
                });
            }
        })



    }



    const spouseGenderCheck = (value) => {

        console.log(value);

        if (value == 'Male' || value == 'Male') {
            console.log("0" + employee_onboarding.gender);
            employee_onboarding.spouse_gender = 'Female'
            console.log(employee_onboarding.spouse_gender);
            readonly.spouse = true
        }

        if (value == 'Female' || value == 'female') {
            employee_onboarding.spouse_gender = 'Male'
            console.log("1" + employee_onboarding.gender);
            console.log(employee_onboarding.spouse_gender);
            readonly.spouse = true
        }
        if (value == 'Others' || value == 'others') {
            readonly.spouse = false
        }

    }

    const fnCalculateAge = () => {
        console.log("Father's Age" + employee_onboarding.dob_father);
        console.log("Mother's Age" + employee_onboarding.dob_mother);

        // convert user input value into date object

        // get difference from current date;

        if (employee_onboarding.dob_father) {
            var birthDate = new Date(employee_onboarding.dob_father);
            console.log(" birthDate" + birthDate);
            var difference = Date.now() - birthDate.getTime();
            var ageDate = new Date(difference);
            var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);
            employee_onboarding.father_age = calculatedAge;
        }
        if (employee_onboarding.dob_mother) {
            var birthDate = new Date(employee_onboarding.dob_mother);
            console.log(" birthDate" + birthDate);
            var difference = Date.now() - birthDate.getTime();
            var ageDate = new Date(difference);
            var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);
            employee_onboarding.mother_age = calculatedAge;
        }
        if (employee_onboarding.dob) {
            var birthDate = new Date(employee_onboarding.dob);
            console.log(" birthDate" + birthDate);
            var difference = Date.now() - birthDate.getTime();
            var ageDate = new Date(difference);
            var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);
            console.log("calculated Age" + calculatedAge);
            if (calculatedAge < 18) {
                console.log("not less than 18");
                employee_onboarding.dob = ''
            }
        }


    };




    const NationalityCheck = () => {
        if (employee_onboarding.nationality == "Other Nationality") {
            isNationalityVisible.value = true;
        } else {
            isNationalityVisible.value = false;
        }
    };



    const ForCopyAdrress = () => {

        if (CopyAddresschecked.value == false) {
            employee_onboarding.permanent_address_line_1 =
                employee_onboarding.current_address_line_1;
            employee_onboarding.permanent_address_line_2 =
                employee_onboarding.current_address_line_2;
            employee_onboarding.permanent_country = employee_onboarding.current_country;
            employee_onboarding.permanent_state = employee_onboarding.current_state;
            employee_onboarding.permanent_city = employee_onboarding.current_city;
            employee_onboarding.permanent_pincode = employee_onboarding.current_pincode;
        } else if (CopyAddresschecked.value == true) {
            employee_onboarding.permanent_address_line_1 = "";
            employee_onboarding.permanent_address_line_2 = "";
            employee_onboarding.permanent_country = "";
            employee_onboarding.permanent_city = "";
            employee_onboarding.permanent_state = "";
            employee_onboarding.permanent_pincode = "";
        }
    };

    const quickCompens = reactive({

    })

    const actual_gross = ref()

    const compensatory_calculation = () => {
        let basic = (employee_onboarding.cic * 50) / 100;

        console.log("Basic :" + Math.floor(basic));

        employee_onboarding.basic = Math.floor(basic);

        let hra = (employee_onboarding.basic * 50) / 100;

        employee_onboarding.hra = Math.floor(hra);

        employee_onboarding.special_allowance =
            employee_onboarding.basic - employee_onboarding.hra;

        console.log(employee_onboarding.special_allowance);

        actual_gross.value = basic + hra + employee_onboarding.special_allowance;

        console.log("Actual gross" + actual_gross.value);

        let gross = basic + hra + employee_onboarding.special_allowance;

        employee_onboarding.gross = Math.floor(gross);

        console.log("Gross", Math.floor(gross));


        epf_esic_calculation();

        setTimeout(() => {
            gross_calculation();
        }, 1000);

        setTimeout(() => {
            net_calculation();
        }, 1000);
    };

    const net_calculation = () => {
        employee_onboarding.net_income =
            employee_onboarding.gross -
            employee_onboarding.epf_employee -
            employee_onboarding.esic_employee;
    };

    const gross_calculation = () => {
        employee_onboarding.total_ctc =
            employee_onboarding.gross +
            employee_onboarding.epf_employer_contribution +
            employee_onboarding.esic_employer_contribution +
            employee_onboarding.insurance +
            employee_onboarding.graduity;

        console.log("ctc" + employee_onboarding.total_ctc);
    };

    const statutory_bonus = () => {

        let total = employee_onboarding.statutory_bonus;

        let sa = employee_onboarding.special_allowance;


        console.log(total, sa);

        console.log(sa - total);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 3000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 1000);
    };

    const special_allowance_cal = () => {
        let total =
            employee_onboarding.statutory_bonus +
            employee_onboarding.child_education_allowance +
            employee_onboarding.food_coupon +
            employee_onboarding.other_allowance;

        let sa = employee_onboarding.special_allowance;

        console.log(total, sa);

        console.log(sa - total);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 3000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 3000);
    };

    const child_allowance = () => {
        let total = employee_onboarding.child_education_allowance;

        let sa = employee_onboarding.special_allowance;

        console.log(total, sa);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 3000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 1100);
    };

    const food_coupon = () => {
        let total = employee_onboarding.food_coupon;

        let sa = employee_onboarding.special_allowance;

        console.log(total, sa);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 3000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 1150);
    };

    const lta = () => {
        let total = employee_onboarding.lta;

        let sa = employee_onboarding.special_allowance;

        console.log(total, sa);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 2000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 1200);
    };

    const other_allowance = () => {
        let total = employee_onboarding.other_allowance;

        let sa = employee_onboarding.special_allowance;

        console.log(total, sa);

        setTimeout(() => {
            employee_onboarding.special_allowance = sa - total;
            if (employee_onboarding.special_allowance < 0) {
                toast.add({
                    severity: "error",
                    summary: " Special Allowance",
                    detail: "Not less than zero",
                    life: 3000,
                });

                compensatory_calculation();
                employee_onboarding.statutory_bonus = "";
                employee_onboarding.child_education_allowance = "";
                employee_onboarding.food_coupon = "";
                employee_onboarding.lta = "";
                employee_onboarding.other_allowance = "";
            }
        }, 1250);
    };

    const insurance = () => {
        let total = employee_onboarding.total_ctc;
        console.log("total" + total);
        let sum = parseInt(total) + parseInt(employee_onboarding.insurance);
        console.log("sum " + sum);
        setTimeout(() => {
            employee_onboarding.total_ctc = sum;
        }, 1000);
    };
    const graduity = () => {
        let total = employee_onboarding.total_ctc;
        console.log("total" + total);
        let sum =
            parseInt(employee_onboarding.total_ctc) +
            parseInt(employee_onboarding.graduity);

        console.log(sum);
        console.log(employee_onboarding.total_ctc);

        setTimeout(() => {
            employee_onboarding.total_ctc = sum;
        }, 2000);
    };

    const epf_esic_calculation = () => {

        let EpfCalculation = employee_onboarding.gross - employee_onboarding.hra;
        let gross = actual_gross.value

        console.log("EpfCalculation:" + EpfCalculation);

        if (EpfCalculation < 15000) {
            employee_onboarding.epf_employer_contribution = Math.floor(EpfCalculation * 12 / 100);
            employee_onboarding.epf_employee = Math.floor(EpfCalculation * 12 / 100);
        } else if (EpfCalculation > 15000) {
            let epfConstant = 1800;
            employee_onboarding.epf_employee = epfConstant;
            employee_onboarding.epf_employer_contribution = epfConstant;
        }

        if (gross <= 21000) {
            employee_onboarding.esic_employer_contribution = Math.floor((employee_onboarding.gross * 3.25) / 100
            );
            employee_onboarding.esic_employee = Math.floor((employee_onboarding.gross * 0.75) / 100
            );
        } else if (gross > 21000) {
            console.log(gross);
            let EsicConstant = 0;
            employee_onboarding.esic_employee = EsicConstant;
            employee_onboarding.esic_employer_contribution = EsicConstant;
        }
    };

    const readonly = reactive({
        is_emp_code_quick: false,
        is_emp_name_quick: false,
        is_doj_quick: false,
        is_mob_quick: false,
        is_email_quick: false,
        statutory: false,
        child: false,
        fdc: false,
        lta: false,
        other: false,
        l1_code: false,
        designation: false,
        mobile: false,
        spouse: false,
        isDisableClientCode: true

    })




    const compen_disable = ref(true)


    const stringIntoNumber = (string) =>{
        const number = parseFloat(string.replace(/,/g, ''));
        console.log(number); // Output: 8098
        return number
    }

    const restChars = () => {
        employee_onboarding.can_onboard_employee = 1
        employee_onboarding.emp_client_code = ''
        employee_onboarding.employee_code = ""
        employee_onboarding.doj = ""
        employee_onboarding.aadhar_number = ""
        employee_onboarding.passport_number = ""
        employee_onboarding.bank_id = ""
        employee_onboarding.bank_name = ""
        employee_onboarding.employee_name = ""
        employee_onboarding.gender = ""
        employee_onboarding.pan_number = ""
        employee_onboarding.passport_date = ""
        employee_onboarding.AccountNumber = ""
        employee_onboarding.dob = ""
        employee_onboarding.mobile_number = ""
        employee_onboarding.dl_no = ""
        employee_onboarding.blood_group_name = ""
        employee_onboarding.blood_group_id = ""
        employee_onboarding.bank_ifsc = ""
        employee_onboarding.marital_status = ""
        employee_onboarding.marital_status_id = ""
        employee_onboarding.email = ""
        employee_onboarding.nationality = ""
        employee_onboarding.physically_challenged = ""
        employee_onboarding.first_letter_emp_name = ''
        employee_onboarding.second_letter_emp_name = ''

        // person Detials End

        // Address detials

        // Current Address Detials Start

        employee_onboarding.current_address_line_1 = ""
        employee_onboarding.current_address_line_2 = ""
        employee_onboarding.current_country = ""
        employee_onboarding.current_state = ""
        employee_onboarding.current_country_id = ""
        employee_onboarding.current_state_id = ""
        employee_onboarding.current_city = ""
        employee_onboarding.current_pincode = ""

        // Current Address Details End

        // Permanant Address Start

        employee_onboarding.permanent_address_line_1 = ""
        employee_onboarding.permanent_address_line_2 = ""
        employee_onboarding.permanent_country = ""
        employee_onboarding.permanent_state = ""
        employee_onboarding.permanent_country_id = ""
        employee_onboarding.permanent_state_id = ""
        employee_onboarding.permanent_city = ""
        employee_onboarding.permanent_pincode = ""

        // Permanant Address end

        // Office Detials Start

        employee_onboarding.department = ""
        employee_onboarding.department_id = ""
        employee_onboarding.process = ""
        employee_onboarding.designation = ""
        employee_onboarding.cost_center = ""
        employee_onboarding.probation_period = ""
        employee_onboarding.work_location = ""
        employee_onboarding.l1_manager_code = ""
        employee_onboarding.l1_manager_code_id = ""
        employee_onboarding.holiday_location = ""
        employee_onboarding.officical_mail = ""
        employee_onboarding.official_mobile = ""
        employee_onboarding.emp_notice = ""
        employee_onboarding.confirmation_period = ""

        // Office Details End

        // family Details Start

        employee_onboarding.father_name = ""
        employee_onboarding.dob_father = ""
        employee_onboarding.father_gender = "Male"
        employee_onboarding.father_age = ""
        employee_onboarding.mother_name = ""
        employee_onboarding.dob_mother = ""
        employee_onboarding.mother_gender = "Female"
        employee_onboarding.mother_age = ""
        employee_onboarding.spouse_name = ""
        employee_onboarding.wedding_date = ""
        employee_onboarding.spouse_gender = ""
        employee_onboarding.dob_spouse = ""
        employee_onboarding.no_of_children = ""

        // family Details End

        //   compensatory Detials start

        employee_onboarding.basic = ""
        employee_onboarding.hra = ""
        employee_onboarding.statutory_bonus = ""
        employee_onboarding.child_education_allowance = ""
        employee_onboarding.food_coupon = ""
        employee_onboarding.lta = ""
        employee_onboarding.other_allowance = ""
        employee_onboarding.special_allowance = ""
        employee_onboarding.graduity = ""
        employee_onboarding.cic = ""
        employee_onboarding.insurance = ""
        employee_onboarding.epf_employee = ""
        employee_onboarding.epf_employer_contribution = ""
        employee_onboarding.esic_employee = ""
        employee_onboarding.esic_employer_contribution = ""
        employee_onboarding.professional_tax = ""
        employee_onboarding.labour_welfare_fund = ""
        employee_onboarding.net_income = "0"
        employee_onboarding.total_ctc = 0

        // Personal Documents Start

        employee_onboarding.AadharCardFront = ""
        employee_onboarding.AadharCardBack = ""
        employee_onboarding.PanCardDoc = ""
        employee_onboarding.DrivingLicenseDoc = ""
        employee_onboarding.EductionDoc = ""
        employee_onboarding.VoterIdDoc = ""
        employee_onboarding.RelievingLetterDoc = ""
        employee_onboarding.PassportDoc = ""

        employee_onboarding.save_draft_messege = ""
    }




    return {

        canShowLoading,

        employee_onboarding, getBasicDeps, clientCode,

        // basic

        bankList, country, state, departmentDetails, Managerdetails, maritalDetails, bloodGroups, checkIsQuickOrNormal, family_details_disable,
        isSpouseDisable, spouseDisable, ForCopyAdrress, spouseGenderCheck, fnCalculateAge, isNationalityVisible, NationalityCheck, RequiredDocument,
        user_code_exists, is_ac_no_exists, is_mobile_no_exists, personal_mail_exists, pan_card_exists,

        mandatoryDocuments,


        // Checking is quick or bulk onboarding
        isQuickOrBulkOnboarding, populateQuickOnboardData,

        // Compensatory
        compensatory_calculation, net_calculation, gross_calculation, statutory_bonus, special_allowance_cal, child_allowance, food_coupon, lta, other_allowance, insurance, graduity, compensatoryCalWhileQuick,

        // Onboarding  form validation and sample data
        Sampledata, rules, submitForm,
        getPersonalDocuments, readonly,

        // /Helper functions
        afterYears, beforeYears, compen_disable, dateOfBirth,stringIntoNumber



    }
})
