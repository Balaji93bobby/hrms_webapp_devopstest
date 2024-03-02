<template>
    <div class="">


         <ul class="mb-3 divide-x nav nav-pills divide-solid nav-tabs-dashed " id="pills-tab" role="tablist">
            <li class=" nav-item" role="presentation">
                <a class="px-4 position-relative border-0 font-['poppins'] text-[14px] text-[#001820]" id=""
                    data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true" @click="activetab = 1"
                    :class="[activetab === 1 ? 'active font-semibold' : 'font-medium !text-[#8B8B8B]']">
                    PERSONAL DOCUMENTS
                </a>
                <div v-if="activetab === 1" class="h-1 rounded-l-3xl " style="border: 2px solid #F9BE00 !important;"></div>
                <div v-else class="h-1 border-2 border-gray-300 rounded-l-3xl"></div>
            </li>
            <div class="border-gray-300 border-b-[4px]  w-100 mt-[-7px]"></div>
        </ul>


        <div class="p-2">
            <div class="w-[100%] mb-[100px]" v-if="activetab == 1">

                <div v-for="(documents, index) in docStore.doc_details"  :key="index">
                    <DocumentCard :source="documents" />
                </div>
            </div>
        </div> 




        <div class="w-full card">
            <!-- <DataTable ref="dt" :value="usedata.employeeDetails.employee_documents" dataKey="id" :paginator="true"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" :rows="5"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">

                <Column header="File Name" field="document_name" style="min-width: 8rem">
                    {{ EmployeeDocumentManagerService.getEmployeeDoc.document_name }}
                </Column>

                <Column field="status" header="status" style="min-width: 12rem">
                    <template #body="slotProps">

                        <div v-if="slotProps.data.status == 'Approved'">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Approved</span>
                        </div>
                        <div v-else-if="slotProps.data.status === 'Pending'">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                        <div v-else-if="slotProps.data.status === 'Rejected'">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 rounded-md bg-red-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                        <div v-else>

                        </div>


                    </template>
                </Column>

                <Column field="" header="View " style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.doc_id">
                            <div v-if="slotProps.data.status == 'Rejected'">
                                <input type="file" name="" id="files" hidden @change="uploadDocuments($event)">
                                <button class="btn btn-success" @click="getFileName(slotProps.data.document_name)"><label
                                        for="files" class="cursor-pointer"><i class="pi pi-upload"></i> Upload
                                        file</label></button>

                            </div>
                            <div v-else>
                                <Button type="button" icon="pi pi-eye" class="p-button-success Button" label="View"
                                    @click="showDocument(slotProps.data)" style="height: 1.5em" />
                            </div>

                        </div>

                        <div v-else>
                            <input type="file" name="" id="files" hidden @change="uploadDocuments($event)">
                            <button class="btn btn-success" @click="getFileName(slotProps.data.document_name)"><label
                                    for="files" class="cursor-pointer"><i class="pi pi-upload"></i> Upload
                                    file</label></button>
                        </div>
                    </template>
                </Column>
            </DataTable> -->
            <!-- <button severity="warn" type="submit" data="row-6" next="row-6" name="submit_form" id="msform"
        class=" w-[100px] " value="Submit" :disabled="fileUploadValidation"
        @click="submitEmployeeDocsUpload">
        Submit
    </button> -->
            <!-- <div class="row">
            <div class="text-right col-12">
                <Toast />
                <button severity="warn" type="submit" data="row-6" next="row-6" placeholder="" name="submit_form"
                    id="msform" class="text-center btn btn-orange processOnboardForm warn" value="Submit"
                    :disabled="fileUploadValidation" @click="submitEmployeeDocsUpload">
                    Submit
                </button>
            </div>
        </div> -->
            <Sidebar position="right" v-model:visible="visible" modal header="Documents" :style="{ width: '40vw' }"
                v-if="EmployeeDocumentManagerService.loading == false">
                <div class="w-full h-full d-flex justify-content-center ">
                    <img :src="`data:image/png;base64,${documentPath}`" class="" alt="File not found"
                        style="object-fit: cover; max-width: 400px; , min-height: 350px; height:300px" />
                </div>

            </Sidebar>
            <!--
        <Dialog header="Header" v-model:visible="EmployeeDocumentManagerService.loading"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
            :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog> -->

        </div>
    </div>
    <!-- {{ EmployeeDocumentManagerService.getEmployeeDetails }} -->
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { useToast } from "primevue/usetoast";
import { UseEmployeeDocumentManagerService } from '../EmployeeDocumentsManagerService';
import { profilePagesStore } from "../stores/ProfilePagesStore";
import DocumentCard from "./DocumentCard.vue";
import { documentStore } from "./documentStore";

const EmployeeDoc = ref([]);

const activetab = ref(1);

onMounted(() => {
    EmployeeDocumentManagerService.fetch_EmployeeDocument();
    docStore.getdoc_details();
    console.log(" ", view_document.value);

    console.log("employeeDetails employee_documents ", usedata.employeeDetails.employee_documents);
    EmployeeDoc.value = usedata;
})

let usedata = profilePagesStore();
let docStore = documentStore();
// Stores
const EmployeeDocumentManagerService = UseEmployeeDocumentManagerService();



// Loading
const toast = useToast();
const visible = ref(false)

// View Documents
const view_document = ref({});
const documentPath = ref();

const col = ref({
    headers: ["aadhar number", "Name", "Date of Birth", "Gender", "Enrollment Number", "Address"],
    title: ["9090 9909 9090", "Name", "Date of Birth", "Gender", "Enrollment Number", "Address"]
});


// Upload Documents
const UploadDocument = ref();
const uploadDocs = ref();

//Get and Append Filename and Filepath
const fileName = ref()
const formdata = new FormData()

const errorstatus = ref();


const showDocument = (document) => {
    visible.value = true
    EmployeeDocumentManagerService.loading = true;
    axios.post('/view-profile-private-file', {
        user_id: usedata.getURLParams_UID(),
        document_name: document.document_name,
        record_id: document.id
    }).then(res => {
        documentPath.value = res.data.data
        console.log("data sent", documentPath.value);
    }).finally(() => {
        EmployeeDocumentManagerService.loading = false;
    })
}

const getSeverity = (status) => {
    switch (status) {
        case 'Rejected':
            return 'danger';

        case 'Approved':
            return 'success';


        case 'Pending':
            return 'warning';

    }
};

const statuses = ref(["Pending", "Approved", "Rejected"]);


const getFileName = (filename) => {
    fileName.value = filename
}

const uploadDocuments = (e) => {
    console.log(fileName);
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        uploadDocs.value = e.target.files[0];
        // Get file size
        // Print to console
        formdata.append(`${fileName.value}`, uploadDocs.value);
        formdata.append('user_code', usedata.employeeDetails.user_code);

        console.log(formdata);
        // console.log("testing", fileName.value);

        let val = Object.keys(formdata)[0];
        // submitEmployeeDocsUpload();

        // console.log();
    }


    if (errorstatus.value == "Failure") {
        Swal.fire({
            title: errorstatus.value = "Failure",
            text: 'Please upload all mandatory documents',
            icon: "error",
            showCancelButton: false,
        }).then((result) => {
            //   window.location.reload();
        });

    }
    else {
        EmployeeDocumentManagerService.loading = true;

        let url = "/profile-page/saveEmployeeDocument";
        axios.post(url, formdata)
            .then((res) => {

                errorstatus.value = res.data.status

                console.log(errorstatus.value);
                console.log("Photo not send");


                if (res.data.status == "Success") {
                    Swal.fire({
                        title: res.data.status = "Success",
                        text: res.data.message,
                        icon: "success",
                        showCancelButton: false,
                    }).then((result) => {
                        // window.location.reload();
                    });
                }
                else if (res.data.status == "Failure") {
                    Swal.fire({
                        title: res.data.status = "Failure",
                        text: res.data.message,
                        icon: "error",
                        showCancelButton: false,
                    }).then((result) => {
                        // window.location.reload();
                    });
                }
            })
            .finally(() => {
                usedata.fetchEmployeeDetails();
                EmployeeDocumentManagerService.fetch_EmployeeDocument();
                EmployeeDocumentManagerService.loading = false;
            });
    }
};

async function submitEmployeeDocsUpload() {

}



</script>


<style>
.p-sidebar-right .p-sidebar
{
    width: 50%;
    height: 100%;
}
</style>
