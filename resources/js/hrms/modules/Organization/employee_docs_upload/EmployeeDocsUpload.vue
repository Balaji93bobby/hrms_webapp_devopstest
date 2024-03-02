<template>
    <h2>Upload Documents</h2>
    <br />
    <div class="p-2 shadow card profile-box card-top-border">
        <div class="card-body justify-content-center align-items-center">
            <div class="header-card-text">
                <h6 class="mb-0">Personal Documents</h6>
            </div>
            <div class="mb-2 form-card">
                <div class="mt-1 row">
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label">Aadhar Card Front<span class="text-danger">*</span></label>
                        <input v-if="!AadharDocFrontInvalid" type="file" accept="image/png, image/gif, image/jpeg"
                            ref="AadharCardFront" class="onboard-form form-control file" @change="AadharFront($event)" />
                        <span class="p-error" v-if="AadharDocFrontInvalid">Aadhar Card Front is required</span>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" id="aadhar_card_backend_content">
                        <label for="" class="float-label">
                            Aadhar Card Back<span class="text-danger">*</span></label>
                        <input v-if="!AadharDocBackInvalid" type="file" accept="image/png, image/gif, image/jpeg"
                            ref="AadharCardBack" @change="AadharBack($event)" class="onboard-form form-control file" />

                        <span v-if="AadharDocBackInvalid" class="p-error">Aadhar Card Back is Required</span>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label">
                            Pan Card<span class="text-danger">*</span></label>

                        <input v-if="!PancardInvalid" type="file" accept="image/png, image/gif, image/jpeg"
                            placeholder="Pan Card" name="pan_card_file" id="pan_card_file" ref="PanCardDoc"
                            @change="PanCard($event)" class="onboard-form form-control file" />

                        <span v-if="PancardInvalid" class="p-error">Pan Card is Required</span>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label"> Passport</label>

                        <input type="file" accept="image/png, image/gif, image/jpeg" ref="PassportDoc"
                            placeholder="Passport" name="passport_file" id="passport_file" @change="Passport($event)"
                            class="onboard-form form-control file" />
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label">Voter ID</label>

                        <input type="file" accept="image/png, image/gif, image/jpeg" ref="VoterIdDoc"
                            placeholder="Voters ID" name="voters_id_file" id="voters_id_file" @change="VoterId($event)"
                            class="onboard-form form-control file" />
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label"> Driving License</label>

                        <input type="file" accept="image/png, image/gif, image/jpeg" placeholder="Driving License"
                            name="dl_file" id="dl_file" @change="DrivingLisence($event)" ref="DrivingLicenseDoc"
                            class="onboard-form form-control file" />
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label">Educations Certificate<span class="text-danger">*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" placeholder="Educations Certificate"
                            name="education_certificate_file" @change="EductionCertifacte($event)"
                            v-if="EducationCertificateInvalid" id="education_certificate_file" ref="EductionDoc"
                            class="onboard-form form-control file is-invalid" />

                        <input type="file" accept="image/png, image/gif, image/jpeg" placeholder="Educations Certificate"
                            name="education_certificate_file" @change="EductionCertifacte($event)"
                            v-if="!EducationCertificateInvalid" id="education_certificate_file" ref="EductionDoc"
                            class="onboard-form form-control file" />

                        <span v-if="EducationCertificateInvalid" class="p-error">Eduction Certifacte is Required</span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                        <label for="" class="float-label"> Relieving Letter</label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" placeholder="Relieving Letter"
                            name="reliving_letter_file" id="reliving_letter_file" @change="ReleivingLetter($event)"
                            ref="RelievingLetterDoc" class="onboard-form form-control file" />
                    </div>
                </div>
            </div>

            <div class="row">
                <template>
                    <div class="card flex justify-content-center">
                        <!-- <Toast position="top-left" group="tl" />
                        <Toast position="bottom-left" group="bl" /> -->

                        <!-- <div class="flex flex-wrap gap-2">
                            <Button label="Top Left" class="mr-2" @click="showTopLeft" />
                            <Button label="Bottom Left" severity="warning" @click="showBottomLeft" />
                            <Button label="Bottom Right" severity="success" @click="showBottomRight" />
                        </div> -->
                    </div>
                </template>

                <div class="text-right col-12">
                    <Toast />
                    <button severity="warn" type="submit" data="row-6" next="row-6" placeholder="" name="submit_form"
                        id="msform" class="text-center btn btn-orange processOnboardForm warn" value="Submit"
                        :disabled="fileUploadValidation" @click="SubmitEmployeeDocsUpload">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div>


        <div>
            <DataTable ref="dt" :value="getEmployeeDoc" dataKey="id" :paginator="true" :rows="10"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">

                <Column header="File Name" field="document_name" style="min-width: 8rem">
                    {{ getEmployeeDoc.document_name }}
                </Column>

                <Column field="status" header="status" style="min-width: 12rem">
                    <template #body="slotProps">

                        <div v-if="slotProps.data.doc_id">
                            <p class="text-green-600 font-semibold">Completed</p>
                        </div>

                        <div v-else>
                            <p class="text-red-600 font-semibold fs-5">Pending</p>
                        </div>

                    </template>
                </Column>

                <Column field="" header="View " style="min-width: 12rem">
                    <template #body="slotProps">

                        <div v-if="slotProps.data.doc_id">
                            <Button type="button" icon="pi pi-eye" class="p-button-success Button" label="View"
                                @click="showDocument(slotProps.data)" style="height: 2em"  />
                        </div>

                        <div v-else>
                            <!-- <Button type="button" icon="pi pi-upload" class="p-button-success Button" label="Upload"
                                @click="showDocument(slotProps.data)" style="height: 2em" /> -->
                                <input type="file" name="" id="file"  hidden>

                                <button class="btn btn-success" @click="UploadDocument(slotProps.data)"><label for="file"><i class="pi pi-upload"></i> Upload file</label></button>
                        </div>

                    </template>
                </Column>
            </DataTable>
        </div>

    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { useToast } from "primevue/usetoast";
import { inject } from "vue";

const swal = inject("$swal");

const toast = useToast();
const getEmployeeDoc = ref([]);




const fetch_EmployeeDocument = () => {
    axios.post('/employee-documents-details', {
        user_code: 'PSC0057'
    }).then((res) => {

        getEmployeeDoc.value = res.data.data
        console.log("employee document : ", getEmployeeDoc.value);
    }).finally((res) => {
        console.log("completed");
    })
}

onMounted(() => {
    fetch_EmployeeDocument()
})

// const fetch_data = Service();

const EmployeeDocs_upload = ref({
    AadharCardFront: null,
    AadharCardBack: null,
    PanCardDoc: null,
    DrivingLicenseDoc: null,
    EductionDoc: null,
    VoterIdDoc: null,
    RelievingLetterDoc: null,
    PassportDoc: null,
    save_draft_messege: null,
});



const AadharDocFrontInvalid = ref(false);
const AadharDocBackInvalid = ref(false);
const PancardInvalid = ref(false);
const EducationCertificateInvalid = ref(false);

const SubmitEmployeeDocsUpload = () => {
    let formData = new FormData();

    if (EmployeeDocs_upload.AadharCardFront != undefined)
        formData.append("Aadhar_Card_Front", EmployeeDocs_upload.AadharCardFront);

    if (EmployeeDocs_upload.AadharCardBack != undefined)
        formData.append("Aadhar_Card_Back", EmployeeDocs_upload.AadharCardBack);

    if (EmployeeDocs_upload.PanCardDoc != undefined)
        formData.append("Pan_Card", EmployeeDocs_upload.PanCardDoc);

    if (EmployeeDocs_upload.PassportDoc != undefined)
        formData.append("Passport", EmployeeDocs_upload.PassportDoc);

    if (EmployeeDocs_upload.VoterIdDoc != undefined)
        formData.append("Voter_ID", EmployeeDocs_upload.VoterIdDoc);

    if (EmployeeDocs_upload.DrivingLicenseDoc != undefined)
        formData.append("Driving_License", EmployeeDocs_upload.DrivingLicenseDoc);

    if (EmployeeDocs_upload.EductionDoc != undefined)
        formData.append("Education_Certificate", EmployeeDocs_upload.EductionDoc);

    if (EmployeeDocs_upload.RelievingLetterDoc != undefined)
        formData.append("Relieving_Letter", EmployeeDocs_upload.RelievingLetterDoc);


    console.log(formData);

    // const id = fetch_data;
    // let url = `/vmt-documents-route/${id}`;

    axios
        .post("/vmt-documents-route/", formData)
        .then((response) => {
            // currentObj.success = response.data.success;
            console.log("response" + response.data);

            console.log(Object(response.data));

            if (response.data.status == "Success") {
                // Swal.fire(response.data.status, response.data.message, "success");
                // window.location.reload()
                Swal.fire({
                    title: response.data.status = "Success",
                    text: response.data.message,
                    icon: "success",
                    showCancelButton: false,
                }).then((result) => {
                    window.location.reload();
                });


            }
            else if (response.data.status == "Failure") {
                Swal.fire({
                    title: response.data.status = "Failure",
                    text: response.data.message,

                    icon: "error",
                    showCancelButton: false,
                }).then((result) => {
                    //   window.location.reload();
                });
            }
        })
        .finally(() => {
            console.log("completed");
        })
        .catch(function (error) {
            // currentObj.output = error;
            console.log(error);
        });
};

const checkInputFiles = () => {
    if (
        EmployeeDocs_upload.AadharCardFront.fileName == undefined ||
        EmployeeDocs_upload.AadharCardBack.fileName == undefined ||
        EmployeeDocs_upload.PanCardDoc.fileName == undefined ||
        EmployeeDocs_upload.EductionDoc.fileName == undefined
    ) {
        fileUploadValidation.value = true;
    } else {
        fileUploadValidation.value = false;
    }
};

const AadharFront = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.AadharCardFront = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.AadharCardFront.fileSize =
                Math.round((EmployeeDocs_upload.AadharCardFront.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.AadharCardFront.fileExtention = EmployeeDocs_upload.AadharCardFront.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.AadharCardFront.fileName = EmployeeDocs_upload.AadharCardFront.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.AadharCardFront.isImage = [
                "jpg",
                "jpeg",
                "png",
                "gif",
            ].includes(EmployeeDocs_upload.AadharCardFront.fileExtention));
        // Print to console
        console.log(EmployeeDocs_upload.AadharCardFront);
    }
};
const AadharBack = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.AadharCardBack = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.AadharCardBack.fileSize =
                Math.round((EmployeeDocs_upload.AadharCardBack.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.AadharCardBack.fileExtention = EmployeeDocs_upload.AadharCardBack.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.AadharCardBack.fileName = EmployeeDocs_upload.AadharCardBack.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.AadharCardBack.isImage = [
                "jpg",
                "jpeg",
                "png",
                "gif",
            ].includes(EmployeeDocs_upload.AadharCardBack.fileExtention));
        // Print to console
        console.log(EmployeeDocs_upload.AadharCardBack);
    }
};
const PanCard = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.PanCardDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.PanCardDoc.fileSize =
                Math.round((EmployeeDocs_upload.PanCardDoc.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.PanCardDoc.fileExtention = EmployeeDocs_upload.PanCardDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.PanCardDoc.fileName = EmployeeDocs_upload.PanCardDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.PanCardDoc.isImage = ["jpg", "jpeg", "png", "gif"].includes(
                EmployeeDocs_upload.PanCardDoc.fileExtention
            ));
        // Print to console
        console.log(EmployeeDocs_upload.PanCardDoc);
    }
};
const Passport = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.PassportDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.PassportDoc.fileSize =
                Math.round((EmployeeDocs_upload.PassportDoc.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.PassportDoc.fileExtention = EmployeeDocs_upload.PassportDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.PassportDoc.fileName = EmployeeDocs_upload.PassportDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.PassportDoc.isImage = ["jpg", "jpeg", "png", "gif"].includes(
                EmployeeDocs_upload.PassportDoc.fileExtention
            ));
        // Print to console
        console.log(EmployeeDocs_upload.PassportDoc);
    }
};
const DrivingLisence = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.DrivingLicenseDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.DrivingLicenseDoc.fileSize =
                Math.round((EmployeeDocs_upload.DrivingLicenseDoc.size / 1024 / 1024) * 100) /
                100),
            // Get file extension
            (EmployeeDocs_upload.DrivingLicenseDoc.fileExtention = EmployeeDocs_upload.DrivingLicenseDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.DrivingLicenseDoc.fileName = EmployeeDocs_upload.DrivingLicenseDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.DrivingLicenseDoc.isImage = [
                "jpg",
                "jpeg",
                "png",
                "gif",
            ].includes(EmployeeDocs_upload.DrivingLicenseDoc.fileExtention));
        // Print to console
        console.log(EmployeeDocs_upload.DrivingLicenseDoc);
    }
};
const VoterId = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.VoterIdDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.VoterIdDoc.fileSize =
                Math.round((EmployeeDocs_upload.VoterIdDoc.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.VoterIdDoc.fileExtention = EmployeeDocs_upload.VoterIdDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.VoterIdDoc.fileName = EmployeeDocs_upload.VoterIdDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.VoterIdDoc.isImage = ["jpg", "jpeg", "png", "gif"].includes(
                EmployeeDocs_upload.VoterIdDoc.fileExtention
            ));
        // Print to console
        console.log(EmployeeDocs_upload.VoterIdDoc);
    }
};
const EductionCertifacte = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.EductionDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.EductionDoc.fileSize =
                Math.round((EmployeeDocs_upload.EductionDoc.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (EmployeeDocs_upload.EductionDoc.fileExtention = EmployeeDocs_upload.EductionDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.EductionDoc.fileName = EmployeeDocs_upload.EductionDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.EductionDoc.isImage = ["jpg", "jpeg", "png", "gif"].includes(
                EmployeeDocs_upload.EductionDoc.fileExtention
            ));
        // Print to console
        console.log(EmployeeDocs_upload.EductionDoc);
    }
};
const ReleivingLetter = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        (EmployeeDocs_upload.RelievingLetterDoc = e.target.files[0]),
            // Get file size
            (EmployeeDocs_upload.RelievingLetterDoc.fileSize =
                Math.round((EmployeeDocs_upload.RelievingLetterDoc.size / 1024 / 1024) * 100) /
                100),
            // Get file extension
            (EmployeeDocs_upload.RelievingLetterDoc.fileExtention = EmployeeDocs_upload.RelievingLetterDoc.name
                .split(".")
                .pop()),
            // Get file name
            (EmployeeDocs_upload.RelievingLetterDoc.fileName = EmployeeDocs_upload.RelievingLetterDoc.name
                .split(".")
                .shift()),
            // Check if file is an image
            (EmployeeDocs_upload.RelievingLetterDoc.isImage = [
                "jpg",
                "jpeg",
                "png",
                "gif",
            ].includes(EmployeeDocs_upload.RelievingLetterDoc.fileExtention));
        // Print to console
        //console.log(EmployeeDocs_upload.ReleivingLetterDoc);
    }
};


const view_document = ref({})

const visible = ref(false);

const documentPath = ref();



const showDocument = (document) => {

    view_document.value = { ...document }
    console.log(view_document.value);
    console.log(view_document.value.doc_url);
    visible.value = true
    loading.value = true


    axios.post('/view-profile-private-file', {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        document_name: view_document.value.document_name
    }).then(res => {
        console.log(res.data.data);
        documentPath.value = res.data.data
        console.log("data sent", documentPath.value);

    }).finally(() => {
        loading.value = false;
    })



}
</script>

<!-- {

 -->
