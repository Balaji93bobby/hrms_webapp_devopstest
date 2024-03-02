<template>
    <div v-if="source">
    <!-- {{source}} -->
        <div class="" v-if="source.doc_status">
            <div class="p-2 my-4 bg-white rounded-lg py-15">
                <div class="flex items-center justify-between py-3 border-b-2 bottom-12">
                    <div class="flex items-center mx-2 ">
                        <img src="../../../assests/images/Aadhar_Card_Front.png" class="w-[40px] mr-2" alt="page not found"
                            v-if="source.title == 'Aadhar Card'">
                        <img src="../../../assests/images/Pan_Card.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Pan_Card'">
                        <img src="../../../assests/images/Passport.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Passport'">
                        <img src="../../../assests/images/Voter_ID.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Voter_ID'">
                        <img src="../../../assests/images/Driving_License.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Driving_License'">
                        <img src="../../../assests/images/education_certificate.png" class="w-[40px] mr-2"
                            alt="page not found" v-else-if="source.title == 'Education_Certificate'">

                        <img src="../../../assests/images/birth_certificate.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Birth_Certificate'">

                        <img src="../../../assests/images/relieving_letter.png" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Relieving_Letter'">
                        <img src="../../../assests/images/bank_passbook.jpg" class="w-[40px] mr-2" alt="page not found"
                            v-else-if="source.title == 'Cheque_leaf/Bank_Passbook'">
                        <!-- <img src="../../../assests/images/Pan_Card.png" class="w-[40px] mr-2" alt="page not found" v-else-if="source.title=='Pan_Card'"> -->

                        <p class="text-lg font-semibold font-['poppins']">
                            {{ convertToTitleCase(source.title) }}
                        </p>
                        <h1 class=" bg-[#F9BE00] p-1 rounded-md font-['poppins'] mx-2 text-[10px]"
                            v-if="source.doc_status == 'Pending'">
                            {{ source.doc_status }}</h1>
                        <h1 class=" bg-[#52864A] text-[#ffff] font-['poppins'] p-1 text-[10px] rounded-md mx-4"
                            v-if="source.doc_status == 'Approved'">{{ source.doc_status }}</h1>
                    </div>
                    <div class="relative">
                        <!-- <i class="pi pi-ellipsis-v"></i> -->
                        <button class="" type="button" @click="toggle(source.title)"><i class="pi pi-ellipsis-v mr-4"></i>
                        </button>

                        <div v-if="op === source.title"
                            class="absolute flex flex-col bg-white shadow-2xl top-4 left-[-140px] "
                            style="width: 160px; margin-top:12px !important;margin-right: 20px !important; ">
                            <div class="p-0 m-0 d-flex flex-column" @mouseleave="op = ''">
                                <!-- bg-green-200 -->
                                <button class=" h-[30px] p-2 text-black fw-semibold hover:bg-gray-200 border-bottom-1"
                                    @click="canshowSidebar(source.title), usedocs.showDocument(source)">Edit</button>
                                <!-- bg-blue-500 -->
                                <button class=" !h-[33px]  border-[1px] text-black fw-semibold hover:bg-gray-200"
                                    @click="canshowSidebar(source.title), usedocs.showDocument(source)">View</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-2 p-4">
                    <div v-for="(document, i) in formatConverter(source.value)" class="my-2" :key="i">
                        <p class="text-sm font-semibold text-gray-500 font-['poppins']">
                            {{ convertToTitleCase(document.title) }}
                        </p>
                        <p class="text-[14px] font-semibold font-['poppins']">
                            {{ document.value ? document.value : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="" v-else>
            <div class=" bg-[#ffff] rounded-md my-4 p-3 flex justify-between items-center">
                <img src="../../../assests/images/Aadhar_Card_Front.png" class="w-[40px] mr-2" alt="page not found"
                    v-if="source.title == 'Aadhar Card'">
                <img src="../../../assests/images/Pan_Card.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Pan_Card'">
                <img src="../../../assests/images/globenew.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Passport'">
                <img src="../../../assests/images/Voter_ID.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Voter_ID'">
                <img src="../../../assests/images/Driving_License.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Driving_License'">
                <img src="../../../assests/images/education_certificate.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Education_Certificate'">
                <img src="../../../assests/images/birth_certificate.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Birth_Certificate'">
                <img src="../../../assests/images/relieving_letter.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Relieving_Letter'">
                <img src="../../../assests/images/checkleafnew.png" class="w-[40px] mr-2" alt="page not found"
                    v-else-if="source.title == 'Cheque_leaf/Bank_Passbook'">
                <p class="text-[#000] font-semibold text-[14px] font-['poppins] ">{{ convertToTitleCase(source.title) }}
                </p>
                <button @click="canshowSidebar(source.title)"
                    class=" border-[1px] border-blue-500 rounded-md p-2 w-[140px] text-[14px] font-['poppins'] text-blue-500 ">
                    <i class=" pi pi-plus"></i> Add Details</button>
            </div>
        </div>

        <Sidebar v-model:visible="visibleRight" position="right" :style="{ width: '60vw !important' }">
            <template #header>
                <div class=" bg-[#000] !w-[50%] h-[60px] absolute top-0 right-0 ">
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold " v-if="InformationType == 'Aadhar Card'">
                        Aadhaar Card</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold " v-if="InformationType == 'Pan_Card'">Pan
                        Card</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold " v-if="InformationType == 'Passport'">
                        Passport</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold " v-if="InformationType == 'Voter_ID'">Voter
                        ID</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold "
                        v-if="InformationType == 'Driving_License'">Driving License</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold "
                        v-if="InformationType == 'Education_Certificate'">Education Certificate</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold "
                        v-if="InformationType == 'Relieving_Letter'">Relieving Letter</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold "
                        v-if="InformationType == 'Birth_Certificate'">Birth Certificate</h1>
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold "
                        v-if="InformationType == 'Cheque_leaf/Bank_Passbook'">Cheque_leaf/Bank_Passbook</h1>
                </div>
            </template>

            <!-- Aadhar Card -->
            <div class=" overflow-auto" v-if="InformationType == 'Aadhar Card'">
                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">

                        <img :src="`data:image/png;base64,${documentPath}`" v-if="usedocs.documentPath" alt="File Not Found"
                            class="object-cover  ">
                            <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover  " v-else >
                    </div>
                    <div class=" w-[50%]  h-[100%] absolute right-0 top-[60px] font-['poppins'] overflow-auto">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 "> Uploading Aadhaar
                                    Card will be verified and approved by the Manager after you Submit this form. </span>
                            </p>
                        </div>
                        <div class="grid grid-cols-2 mx-4 my-2 gap-x-4">
                            <div class="">
                                <label for="">Aadhaar Number <span class=" text-[red]">*</span></label>
                                <InputMask id="basic" v-model="usedocs.emp_docs.aadhar_number" mask="999999999999"
                                    class="border-[1px] border-[#DDDDDD] my-[12px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md "
                                    placeholder="0000 0000 0000 0000" :class="[
                                        aadharV$.aadhar_number.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="aadharV$.aadhar_number.$error" class="font-semibold text-red-400 fs-6">
                                    {{ aadharV$.aadhar_number.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="flex flex-col items-start">
                                <label for="" class="text-start">Name <span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Aadthar Name" v-model="usedocs.emp_docs.name"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2">
                            </div>
                            <div class="">
                                <label for="">Enrollment Number</label>
                                <InputMask id="basic" v-model="usedocs.emp_docs.aadhar_enrollment_number"
                                    mask="999999999999"
                                    class="border-[1px] border-[#DDDDDD] my-[12px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md  p-2"
                                    placeholder="Enter Enrollment Number" />
                            </div>
                            <div class="">
                                <label for="">Gender <span class=" text-[red]">*</span></label>
                                <Dropdown v-model="usedocs.emp_docs.gender" :options="cities" optionValue="name"
                                    optionLabel="name" placeholder="Enter Gender"
                                    class="border-[1px] border-[#DDDDDD] my-[8px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md " />
                            </div>
                            <div class="">
                                <label for="">DOB <span class=" text-[red]">*</span></label>
                                <Calendar id="aadhar" v-model="usedocs.emp_docs.dob" placeholder="Enter DOB" showIcon
                                    class=" !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-2 m-0 " />
                            </div>
                        </div>
                        <div class="mx-4 my-2 gap-x-4">
                            <div class="">
                                <label for="">Address <span class=" text-[red]">*</span></label>
                                <textarea  placeholder="Enter Address" v-model="usedocs.emp_docs.aadhar_address"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[50px] bg-[#F9F9F9] rounded-md my-2  p-2"></textarea>
                            </div>
                            <div class="flex flex-col col-span-2 my-2 form-group">
                                <label for="" class="mb-1 text-lg font-semibold">Documents</label>
                                <div class="flex flex-col justify-start ">
                                    <Toast />
                                    <label
                                        class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                        style="" id="" for="uploadPassBook">
                                        <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                        <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                        <p v-if="usedocs.emp_docs.emp_doc" class="">
                                            {{ usedocs.emp_docs.emp_doc.name }}</p>
                                    </label>
                                    <div class="flex flex-col items-center justify-center ">
                                        <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                            @change="usedocs.uploadDocuments($event)" hidden
                                            style="text-transform: uppercase" class="pl-2 form-controls" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" mt-[10%] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="  usedocs.save_empdocs('Aadhar Card Front')">Submit</button>
                                <!-- usedocs.save_empdocs('Aadhar Card Front') -->
                                <!-- validateAadhar() -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- pan card  -->
            <div class="w-[40vh] p-4 box-border " v-if="InformationType == 'Pan_Card'">
                <div class=" grid grid-cols-6 w-[100%]">
                    <div
                        class="col-span-3 w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center  ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover">
                    </div>

                    <div class=" w-[50%] h-[100%] absolute right-0 top-[55px] font-['poppins']  overflow-auto">
                        <div class=" p-3 bg-[#FFE2E2] ">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 ">Uploading Pan Card
                                    will
                                    be verified and approved by the Manager after you Submit this form. </span> </p>
                        </div>
                        <div class="grid grid-cols-2 mx-4 my-2 gap-x-4  ">
                            <div class="col-span-1 ">
                                <label for="">PAN Number <span class=" text-[red]">*</span></label>
                                <InputMask @focusout="panCardExists" id="serial" mask="aaaaa9999a"
                                    v-model="usedocs.emp_docs.pan_number" placeholder="AHFCS1234F"
                                    class="border-[1px] border-[#DDDDDD] !w-[90%] h-[36px] bg-[#F9F9F9] rounded-md my-2 p-2"
                                    :class="[
                                        panV$.pan_number.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="panV$.pan_number.$error" class="font-semibold text-red-400 fs-6">
                                    {{ panV$.pan_number.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1 ">
                                <label for="" class="text-start">Name <span class=" text-[red]  ">*</span></label>
                                <input type="text" placeholder="Enter Aaddhar Name" v-model="usedocs.emp_docs.name"
                                    class="border-[1px] border-[#DDDDDD] !w-[90%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        panV$.name.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="panV$.name.$error" class="font-semibold text-red-400 fs-6">
                                    {{ panV$.name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1  ">
                                <label for="">DOB <span class=" text-[red]">*</span></label>
                                <Calendar id="pandob" v-model="usedocs.emp_docs.dob" placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[90%] h-[36px] border-[#DDDDDD]  rounded-md my-2 m-0 " :class="[
                                        panV$.dob.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="panV$.dob.$error" class="font-semibold text-red-400 fs-6">
                                    {{ panV$.dob.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1 ">
                                <label for="">Father's Name <span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Parent's/Spouse Name"
                                    v-model="usedocs.emp_docs.spouse"
                                    class="border-[1px] border-[#DDDDDD] !w-[90%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        panV$.spouse.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="panV$.spouse.$error" class="font-semibold text-red-400 fs-6">
                                    {{ panV$.spouse.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1 ">
                                <label for="">Gender <span class=" text-[red]">*</span></label>
                                <Dropdown v-model="usedocs.emp_docs.gender" :options="cities" optionValue="name"
                                    optionLabel="name" placeholder="Enter Gender"
                                    class="border-[1px] border-[#DDDDDD] my-[8px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md "
                                    :class="[
                                        panV$.gender.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="panV$.gender.$error" class="font-semibold text-red-400 fs-6">
                                    {{ panV$.gender.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col col-span-2 my-2 form-group">
                                <label for="" class="mb-1 text-lg font-semibold">Documents</label>
                                <div class="flex flex-col justify-start ">
                                    <Toast />
                                    <label
                                        class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                        style="" id="" for="uploadPassBook">
                                        <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                        <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                        <p v-if="usedocs.emp_docs.emp_doc" class="">
                                            {{ usedocs.emp_docs.emp_doc.name }}</p>
                                    </label>
                                    <div class="flex flex-col items-center justify-center ">
                                        <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                            @change="usedocs.uploadDocuments($event)" hidden
                                            style="text-transform: uppercase" class="pl-2 form-controls" :class="[
                                                panV$.emp_doc.$error ? 'p-invalid' : '',
                                            ]" />
                                        <span v-if="panV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                            {{ panV$.emp_doc.$errors[0].$message }}
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" mt-[10%] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validatePan">Submit</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Passport -->
            <div class="w-[40vh] overflow-auto" v-if="InformationType == 'Passport'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover">
                    </div>
                    <div class=" w-[50%]  h-[80%] absolute right-0 top-[60px] font-['poppins'] bg-[#ffff]">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 "> Uploading Passport
                                    will
                                    be verified and approved by the Manager after you Submit this form. </span> </p>
                        </div>
                        <div class="grid grid-cols-2 mx-4 my-2 gap-x-4 h-[100%] overflow-y-scroll  ">
                            <div class="">
                                <label for="">Country Code<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Country Code"
                                    v-model="usedocs.emp_docs.passport_country_code"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md my-1 p-2"
                                    :class="[
                                        passportV$.passport_country_code.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.passport_country_code.$error" class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_country_code.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col items-start">
                                <label for="" class="text-start">Passport Type <span class=" text-[red]  ">*</span></label>
                                <input type="text" placeholder="Enter Passport Type"
                                    v-model="usedocs.emp_docs.passport_type"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-1  p-2"
                                    :class="[
                                        passportV$.passport_type.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.passport_type.$error" class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_type.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="">
                                <label for="">Passport Number<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Passport Number"
                                    v-model="usedocs.emp_docs.passport_number"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md my-1 p-2"
                                    :class="[
                                        passportV$.passport_number.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.passport_number.$error"
                                    class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_number.$errors[0].$message }}
                                </span>
                            </div>

                            <!-- <div class="">
                                <label for="">DOB<span class=" text-[red]">*</span></label>
                                <Calendar v-model="usedocs.emp_docs.dob" placeholder="Enter DOB" showIcon
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-1" />
                            </div> -->
                            <div class="col-span-1  ">
                                <label for="">DOB <span class=" text-[red]">*</span></label>
                                <Calendar id="passdob" v-model="usedocs.emp_docs.dob" placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-1  " :class="[
                                        passportV$.dob.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="passportV$.dob.$error" class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.dob.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="">
                                <label for="">Name<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Name" v-model="usedocs.emp_docs.name"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-1  p-2"
                                    :class="[
                                        passportV$.name.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.name.$error" class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="">
                                <label for="">Gender <span class=" text-[red]">*</span></label>
                                <Dropdown v-model="usedocs.emp_docs.gender" :options="cities" optionValue="name"
                                    optionLabel="name" placeholder="Enter Gender"
                                    class="border-[1px] border-[#DDDDDD] my-[8px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md "
                                    :class="[
                                        passportV$.gender.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="passportV$.gender.$error" class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.gender.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1  ">
                                <label for="">Date of Issue <span class=" text-[red]">*</span></label>
                                <Calendar id="doi" v-model="usedocs.emp_docs.passport_date_of_issue"
                                    placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-1 m-0 " :class="[
                                        passportV$.passport_date_of_issue.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="passportV$.passport_date_of_issue.$error"
                                    class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_date_of_issue.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="">
                                <label for="">Place of Issues <span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Place of Issue"
                                    v-model="usedocs.emp_docs.passport_place_of_issue"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-1  p-2"
                                    :class="[
                                        passportV$.passport_place_of_issue.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.passport_place_of_issue.$error"
                                    class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_place_of_issue.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="col-span-1">
                                <label for="">Place of Birth <span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Place of Birth"
                                    v-model="usedocs.emp_docs.passport_place_of_birth"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-1  p-2"
                                    :class="[
                                        passportV$.passport_place_of_birth.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="passportV$.passport_place_of_birth.$error"
                                    class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_place_of_birth.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1  ">
                                <label for="">Exp On <span class=" text-[red]">*</span></label>
                                <Calendar id="expon" v-model="usedocs.emp_docs.passport_expire_on" placeholder="DD/MM/YYYY"
                                    showIcon class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-1  " :class="[
                                        passportV$.passport_expire_on.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="passportV$.passport_expire_on.$error"
                                    class="font-semibold text-red-400 text-[10px]">
                                    {{ passportV$.passport_expire_on.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="flex flex-col col-span-2 my-1 form-group">
                                <label for="" class="mb-1 text-lg font-semibold">Documents</label>
                                <div class="flex flex-col justify-start ">
                                    <Toast />
                                    <label
                                        class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-1 border-gary-200 "
                                        style="" id="" for="uploadPassBook">
                                        <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                        <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                        <p v-if="usedocs.emp_docs.emp_doc" class="">
                                            {{ usedocs.emp_docs.emp_doc.name }}</p>
                                    </label>
                                    <div class="flex flex-col items-center justify-center ">
                                        <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                            @change="usedocs.uploadDocuments($event)" hidden
                                            style="text-transform: uppercase" class="pl-2 form-controls" :class="[
                                                passportV$.emp_doc.$error ? 'p-invalid' : '',
                                            ]" />
                                        <span v-if="passportV$.emp_doc.$error" class="font-semibold text-red-400 text-[10px]">
                                            {{ passportV$.emp_doc.$errors[0].$message }}
                                        </span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 flex flex-row justify-center items-center gap-1">
                                <button
                                    class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                    @click="close_btn(),resetValidators()">Cancel</button>
                                <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                    @click="validatePassport">Submit</button>
                            </div>
                        </div>

                        <!-- <div class=" mt-[25px] flex justify-center col-span-2">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="usedocs.save_empdocs('Passport')">Submit</button>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Voter ID -->
            <div class="w-[40vh]" v-if="InformationType == 'Voter_ID'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover ">
                    </div>

                    <div class="w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 "> Uploading Voter ID
                                    will
                                    be verified and approved by the Manager after you Submit this form. </span> </p>
                        </div>
                        <div class="grid grid-cols-2 mx-4 my-1 gap-x-4">
                            <div class="">
                                <label for="">Voter ID Number<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Voter ID Number"
                                    v-model="usedocs.emp_docs.voterid_number"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md my-2 p-2"
                                    :class="[
                                        voterV$.voterid_number.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="voterV$.voterid_number.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.voterid_number.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col items-start">
                                <label for="" class="text-start">Name <span class=" text-[red]  ">*</span></label>
                                <input type="text" placeholder="Enter Name" v-model="usedocs.emp_docs.name"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        voterV$.name.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="voterV$.name.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="">
                                <label for="">Father's Name<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Father's Name" v-model="usedocs.emp_docs.father_name"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        voterV$.father_name.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="voterV$.father_name.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.father_name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="">
                                <label for="">Gender<span class=" text-[red]">*</span></label>
                                <Dropdown v-model="usedocs.emp_docs.gender" :options="cities" optionValue="name"
                                    optionLabel="name" placeholder="Enter Gender"
                                    class="border-[1px] border-[#DDDDDD] my-[8px] !w-[100%] h-[36px] bg-[#F9F9F9] rounded-md "
                                    :class="[
                                        voterV$.gender.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="voterV$.gender.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.gender.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1 ">
                                <label for="">DOB <span class=" text-[red] ">*</span></label>
                                <Calendar id="votedob" v-model="usedocs.emp_docs.dob" placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-2  " :class="[
                                        voterV$.dob.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="voterV$.dob.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.dob.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="col-span-1  ">
                                <label for="">Issue On <span class=" text-[red]">*</span></label>
                                <Calendar v-model="usedocs.emp_docs.voter_id_issued_on" id="isssuevote" placeholder="DD/MM/YYYY"
                                    showIcon class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-2  " :class="[
                                        voterV$.voter_id_issued_on.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="voterV$.voter_id_issued_on.$error"
                                    class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.voter_id_issued_on.$errors[0].$message }}
                                </span>
                            </div>

                            <div class=" col-span-2">
                                <label for="">Address <span class=" text-[red]">*</span></label>
                                <textarea placeholder="Enter Address" v-model="usedocs.emp_docs.voterid_emp_address"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[50px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        voterV$.voterid_emp_address.$error ? 'p-invalid' : '',
                                    ]"></textarea>
                                <span v-if="voterV$.voterid_emp_address.$error" class="font-semibold text-red-400 fs-6">
                                    {{ voterV$.voterid_emp_address.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col col-span-2 my-2 form-group">
                                <label for="" class="mb-1 text-lg font-semibold">Upload Voter ID<span class=" text-[red]">*</span></label>
                                <div class="flex flex-col justify-start ">
                                    <Toast />
                                    <label
                                        class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                        style="" id="" for="uploadPassBook">
                                        <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                        <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                        <p v-if="usedocs.emp_docs.emp_doc" class="">
                                            {{ usedocs.emp_docs.emp_doc.name }}</p>
                                    </label>
                                    <div class="flex flex-col items-center justify-center ">
                                        <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                            @change="usedocs.uploadDocuments($event)" hidden
                                            style="text-transform: uppercase" class="pl-2 form-controls" :class="[
                                               voterV$.emp_doc.$error ? 'p-invalid' : '',
                                            ]" />
                                        <span v-if="voterV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                            {{voterV$.emp_doc.$errors[0].$message }}
                                        </span>
                                    </div>

                                </div>
                            </div>




                        </div>

                        <div class=" mt-[10%] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateVote">Submit</button>
                        </div>

                    </div>

                </div>

            </div>
            <!-- Driving License -->
            <div class="w-[40vh]" v-if="InformationType == 'Driving_License'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="`data:image/png;base64,${usedocs.documentPath}`" v-if="usedocs.documentPath" alt="File Not Found"
                            class="object-cover  ">
                        <img  v-else :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover ">
                    </div>

                    <div class="w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 ">Uploading driving
                                    License will be verified and approved by the Manager after you Submit this form.
                                </span>
                            </p>
                        </div>
                        <div class="grid grid-cols-2 mx-4 my-2 gap-x-4  text-sm">
                            <div class="">
                                <label for="">License Number<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter License Number"
                                    v-model="usedocs.emp_docs.license_number"
                                    class="border-[1px] border-[#DDDDDD] !w-[90%] h-[36px] bg-[#F9F9F9] rounded-md my-2 p-2"
                                    :class="[
                                        licenseV$.license_number.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="licenseV$.license_number.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.license_number.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col items-start">
                                <label for="" class="text-start">Name<span class=" text-[red]  ">*</span></label>
                                <input type="text" placeholder="Enter Name" v-model="usedocs.emp_docs.name"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        licenseV$.name.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="licenseV$.name.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1  ">
                                <label for="licdob">DOB <span class=" text-[red]">*</span></label>
                                <Calendar id="licdob" value="" v-model="usedocs.emp_docs.dob" placeholder="DD/MM/YYYY"
                                    showIcon class="!w-[90%] h-[36px] border-[#DDDDDD]  rounded-md my-2 m-0 " :class="[
                                        licenseV$.dob.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="licenseV$.dob.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.dob.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1">
                                <label for="">Blood Group<span class=" text-[red]">*</span></label>
                                <Dropdown v-model="usedocs.emp_docs.blood_group" :options="options_blood_group"
                                    optionLabel="name" optionValue="id" placeholder="Select Blood group"
                                    class="border-[1px] border-[#DDDDDD] !w-[100%]  h-[34px] bg-[#F9F9F9] rounded-md  "
                                    :class="[
                                        licenseV$.blood_group.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="licenseV$.blood_group.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.blood_group.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="">
                                <label for="">Father's Name<span class=" text-[red]">*</span></label>
                                <input type="text" placeholder="Enter Father's Name" v-model="usedocs.emp_docs.father"
                                    class="border-[1px] border-[#DDDDDD] !w-[90%]  h-[36px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        licenseV$.father_name.$error ? 'p-invalid' : '',
                                    ]">
                                <span v-if="licenseV$.father_name.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.father_name.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="col-span-1  ">
                                <label for="issuelic">Issue Date <span class=" text-[red]">*</span></label>
                                <Calendar id="issuelic" value="" v-model="usedocs.emp_docs.license_issue_date"
                                    placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[95%] h-[36px] border-[#DDDDDD]  rounded-md my-2 m-0 " :class="[
                                        licenseV$.license_issue_date.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="licenseV$.license_issue_date.$error"
                                    class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.license_issue_date.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="col-span-1  ">
                                <label for="explic">Exp On <span class=" text-[red]">*</span></label>
                                <Calendar id="explic" value="" v-model="usedocs.emp_docs.license_expires_on"
                                    placeholder="DD/MM/YYYY" showIcon
                                    class="!w-[90%] h-[36px] border-[#DDDDDD]  rounded-md my-2 m-0 " :class="[
                                        licenseV$.license_expires_on.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="licenseV$.license_expires_on.$error"
                                    class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.license_expires_on.$errors[0].$message }}
                                </span>
                            </div>
                        </div>
                        <div class="mx-4 my-2 gap-x-4">
                            <div class="flex flex-col col-span-2 my-2 form-group">
                                <label for="">Address<span class=" text-[red]">*</span></label>
                                <textarea placeholder="Enter Address" v-model="usedocs.emp_docs.address"
                                    class="border-[1px] border-[#DDDDDD] !w-[100% ]  h-[50px] bg-[#F9F9F9] rounded-md my-2  p-2"
                                    :class="[
                                        licenseV$.address.$error ? 'p-invalid' : '',
                                    ]"></textarea>
                                <span v-if="licenseV$.address.$error" class="font-semibold text-red-400 fs-6">
                                    {{ licenseV$.address.$errors[0].$message }}
                                </span>
                            </div>

                            <div class="flex flex-col col-span-2 my-2 form-group">
                                <label for="" class="mb-1 text-lg font-semibold">Upload Driving License </label>
                                <div class="flex flex-col justify-start ">
                                    <Toast />
                                    <label
                                        class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                        style="" id="" for="uploadPassBook">
                                        <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                        <h1 class="text-[#000] " v-if="!documentfile.emp_doc.name">Upload file</h1>
                                        <p v-if="documentfile.emp_doc" class="">
                                            {{ documentfile.emp_doc.name }}</p>
                                    </label>
                                    <div class="flex flex-col items-center justify-center ">
                                        <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                            @change="usedocs.uploadDocuments($event)" hidden
                                            style="text-transform: uppercase" class="pl-2 form-controls" :class="[
                                                licenseV$.emp_doc.$error ? 'p-invalid' : '',
                                            ]" />
                                        <span v-if="licenseV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                            {{ licenseV$.emp_doc.$errors[0].$message }}
                                        </span>

                                    </div>

                                </div>
                            </div>



                        </div>


                        <div class=" mt-[10px] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateLicense">Submit</button>
                        </div>

                    </div>

                </div>

            </div>
            <!-- Education Certificate -->
            <div class="w-[40vh]" v-if="InformationType == 'Education_Certificate'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover ">
                    </div>

                    <div class="w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[110%] text-[#000]">Instruction : <span class="text-gray-400 ">Uploading Education
                                    Certificate will be verified and approved by the Manager after you Submit this form.
                                </span> </p>
                        </div>


                        <div class="flex flex-col col-span-2 mx-2 form-group p-2">
                            <label for="" class="mb-1 text-lg font-semibold">Education Certificate</label>
                            <div class="flex flex-col justify-start ">
                                <Toast />
                                <label
                                    class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                    style="" id="" for="uploadPassBook">
                                    <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                    <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                    <p v-if="usedocs.emp_docs.emp_doc" class="">
                                        {{ usedocs.emp_docs.emp_doc.name }}</p>
                                </label>
                                <div class="flex flex-col items-center justify-center ">
                                    <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                        @change="usedocs.uploadDocuments($event)" hidden style="text-transform: uppercase"
                                        class="pl-2 form-controls" :class="[
                                            documentV$.emp_doc.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="documentV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                        {{ documentV$.emp_doc.$errors[0].$message }}
                                    </span>

                                </div>

                            </div>
                        </div>

                        <div class=" mt-[50px] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateDocument">Submit</button>
                        </div>



                    </div>

                </div>
            </div>
            <!-- Relieving Letter -->
            <div class="w-[40vh]" v-if="InformationType == 'Relieving_Letter'">
                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover">
                    </div>

                    <div class="w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 ">Uploading Relieving
                                    Letter will be verified and approved by the Manager after you Submit this form. .
                                </span>
                            </p>
                        </div>


                        <div class="flex flex-col col-span-2 my-2 form-group p-2">
                            <label for="" class="mb-1 text-lg font-semibold">Upload Relieving Letter</label>
                            <div class="flex flex-col justify-start ">
                                <Toast />
                                <label
                                    class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                    style="" id="" for="uploadPassBook">
                                    <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                    <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                    <p v-if="usedocs.emp_docs.emp_doc" class="">
                                        {{ usedocs.emp_docs.emp_doc.name }}</p>
                                </label>
                                <div class="flex flex-col items-center justify-center ">
                                    <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                        @change="usedocs.uploadDocuments($event)" hidden style="text-transform: uppercase"
                                        class="pl-2 form-controls" :class="[
                                            documentV$.emp_doc.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="documentV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                        {{ documentV$.emp_doc.$errors[0].$message }}
                                    </span>

                                </div>

                            </div>
                        </div>

                        <div class=" mt-[300px] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateDocument">Submit</button>
                        </div>


                    </div>

                </div>

            </div>
            <!-- Birth Certificate -->
            <div class="w-[40vh]" v-if="InformationType == 'Birth_Certificate'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" alt="File Not Found" class="object-cover ">
                    </div>

                    <div class=" w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[100%] text-[#000]">Instruction : <span class="text-gray-400 ">Uploading Birth
                                    Certificate will be verified and approved by the Manager after you Submit this form.
                                </span> </p>
                        </div>


                        <div class="flex flex-col col-span-2 my-2 form-group p-2">
                            <label for="" class="mb-1 text-lg font-semibold">Upload Birth Certificate</label>
                            <div class="flex flex-col justify-start ">
                                <Toast />
                                <label
                                    class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                    style="" id="" for="uploadPassBook">
                                    <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                    <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                    <p v-if="usedocs.emp_docs.emp_doc" class="">
                                        {{ usedocs.emp_docs.emp_doc.name }}</p>
                                </label>
                                <div class="flex flex-col items-center justify-center ">
                                    <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                        @change="usedocs.uploadDocuments($event)" hidden style="text-transform: uppercase"
                                        class="pl-2 form-controls" :class="[
                                            documentV$.emp_doc.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="documentV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                        {{ documentV$.emp_doc.$errors[0].$message }}
                                    </span>

                                </div>

                            </div>
                        </div>

                        <div class=" mt-[300px] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateDocument">Submit</button>
                        </div>


                    </div>

                </div>

            </div>
            <!-- Cheque Leaf -->
            <div class="w-[40vh]" v-if="InformationType == 'Cheque_leaf/Bank_Passbook'">

                <div class=" flex justify-center items-center h-[100%] ">
                    <div
                        class=" w-[50%] h-[100%] absolute top-0 left-0 border-[4px] border-[#000] flex items-center justify-center ">
                        <img :src="usedocs.emp_docs.imageUrl" v-if="usedocs.emp_docs.imageUrl" alt="File Not Found"
                            class="object-cover ">
                        <img :src="`data:image/png;base64,${documentPath}`" class="" alt="File not found"
                            style="object-fit: cover; max-width: 400px; , min-height: 350px; height:300px" />
                    </div>

                    <div class="w-[50%] h-[100%] absolute right-0 top-[60px] font-['poppins']">
                        <div class=" p-3 bg-[#FFE2E2]">
                            <p class=" w-[105%] text-[#000]">Instruction : <span class="text-gray-400 text-base">Uploading
                                    Cheque_leaf /
                                    Bank_Passbook will be verified and approved by the Manager after you Submit this form.
                                </span> </p>
                        </div>


                        <div class="flex flex-col col-span-2 my-2 form-group p-2">
                            <label for="" class="mb-1 text-lg font-semibold">Upload Cheque_leaf/Bank_Passbook</label>
                            <div class="flex flex-col justify-start ">
                                <Toast />
                                <label
                                    class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                                    style="" id="" for="uploadPassBook">
                                    <i class="p-3 mr-3 bg-gray-300 rounded-md pi pi-download"></i>
                                    <h1 class="text-[#000] " v-if="!usedocs.emp_docs.emp_doc">Upload file</h1>
                                    <p v-if="usedocs.emp_docs.emp_doc" class="">
                                        {{ usedocs.emp_docs.emp_doc.name }}</p>
                                </label>
                                <div class="flex flex-col items-center justify-center ">
                                    <input type="file" accept=".png,.jpeg,.jpg" name="" id="uploadPassBook"
                                        @change="usedocs.uploadDocuments($event)" hidden style="text-transform: uppercase"
                                        class="pl-2 form-controls" :class="[
                                            documentV$.emp_doc.$error ? 'p-invalid' : '',
                                        ]" />
                                    <span v-if="documentV$.emp_doc.$error" class="font-semibold text-red-400 fs-6">
                                        {{ documentV$.emp_doc.$errors[0].$message }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <div class=" mt-[300px] flex justify-center">
                            <button class=" border-[1px] border-[#000] text-[#000] px-3  rounded-md p-2 font-['poppins']"
                                @click="close_btn(),resetValidators()">Cancel</button>
                            <button class=" bg-[#000] text-[#ffff] rounded-md p-2 px-3 mx-4 font-['poppins']"
                                @click="validateDocument">Submit</button>
                        </div>



                    </div>

                </div>


            </div>


        </Sidebar>

    </div>
</template>
<script setup>
import { computed, onMounted, reactive, ref, inject } from 'vue';
import { Service } from '../../Service/Service';
import { documentStore } from './documentStore';
import useValidate from '@vuelidate/core'

import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
const props = defineProps({
    source: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: true
    }
});
const swal = inject("$swal");
const isOpen = ref(false);

const usedocs = documentStore();
const service = Service();
const emp_docs = documentStore();
const cities = ref([
    { name: 'Male', id: '1' },
    { name: 'Female', id: '2' },
    { name: 'Other', id: '3' },
]);


function toggleSidebar() {


}

onMounted(()=>{

    service.getBloodGroups().then((result) => {
        console.log(result.data);
        options_blood_group.value = result.data;
    });



})



const documentfile = reactive({
    emp_doc: "",
});
const imageUrl = ref();

const op = ref();

const OverlayPanel = ref(true);

const visibleRight = ref(false);

const InformationType = ref();
const options_blood_group = ref();

function canshowSidebar(val) {
    visibleRight.value = true;
    // isOpen.value = !isOpen.value;

    if (val) {
        InformationType.value = val
    }

}

function close_btn() {
    usedocs.reset();
    visibleRight.value = false;
}

function convertToTitleCase(originalString) {
    if (originalString) {
        //     const title =  str.replace(/\b\w/g, match => match.toUpperCase());
        //    const converted = title.replace(/_/g, ' ');
        //     return converted
        const convertedString = originalString
            .split('_')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
        return convertedString
    }
}


const toggle = (event) => {
    // op.value = event;
    console.log(event);
    if (event) {
        op.value = event;
    }

}


const formatConverter = (data) => {
    let obj = Object.entries(data).map(item => {
        return {
            title: item[0],
            value: item[1]
        }
    })
    return obj
}

const documentHeaders = ["Aadhar Card", "PANCard", "Driving License", "Voter ID", "Passport", "Birth Certificate"]




// const uploadDocuments = (e) => {
//     console.log(fileName);
//     // Check if file is selected
//     if (e.target.files && e.target.files[0]) {
//         // Get uploaded file
//         uploadDocs.value = e.target.files[0];
//         // Get file size
//         // Print to console
//         formdata.append(`${fileName.value}`, uploadDocs.value);
//         formdata.append('user_code', usedata.employeeDetails.user_code);

//         console.log(formdata);
//         // console.log("testing", fileName.value);

//         let val = Object.keys(formdata)[0];
//         // submitEmployeeDocsUpload();

//         // console.log();
//     }
// };

function imageSource() {
    return require(`../../../assests/images/${this.source.title}.png`);

}

const panCardExists = () => {
    console.log("pan card checking");

    // let pan_no = service.employee_onboarding.pan_number;

    var regep = /^([a-zA-Z]){3}([Pp]){1}([a-zA-Z]){1}([0-9]){4}([a-zA-Z]){1}?$/;

    if (regep.test(usedocs.emp_docs.pan_number)) {
        console.log("Valid pan no.");
        // axios
        //     .get(`/pan-no-exists/${pan_no}`)
        //     .then((res) => {
        //         console.log(res.data);
        //         service.pan_card_exists = res.data;
        //     })
        //     .catch((err) => {
        //         console.log(err);
        //     })
        //     .finally(() => {
        //         console.log("completed");
        //     });


    }
    else {
        console.log("Invalid pan no.");

    }

};
// Aadhar Validation

const aadharRules = computed(() => {
    return {
        aadhar_number: { required },
    }
})
const aadharV$ = useValidate(aadharRules, usedocs.emp_docs)

const validateAadhar = () => {
    console.log(aadharV$.value);
    aadharV$.value.$validate() // checks all inputs
    if (!aadharV$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        aadharV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

// Pan Validation
const panRules = computed(() => {
    return {
        pan_number: {required: helpers.withMessage('Pan number is required', required)},
        name: {required: helpers.withMessage('Name is required', required)},
        dob: {required: helpers.withMessage('DOB is required', required)},
        gender: {required: helpers.withMessage('Gender is required', required)},
        spouse: {required: helpers.withMessage('Spouse/Parent Name is required', required)},
        emp_doc: {required: helpers.withMessage('Document is required', required)},
    }
})
const panV$ = useValidate(panRules, usedocs.emp_docs)

const validatePan = () => {
    console.log(panV$.value);
    panV$.value.$validate() // checks all inputs
    if (!panV$.value.$error) {
        // if ANY fail validation
        usedocs.save_empdocs('Pan Card'),
            visibleRight.value = false
        console.log('Form successfully submitted.')
        panV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

// Passport Validation
const passportRules = computed(() => {
    return {


        passport_number: {required: helpers.withMessage('Passport Number is required', required)},
        passport_type: {required: helpers.withMessage('Passport Type is required', required)},
        passport_country_code: {required: helpers.withMessage('Country code is required', required)},
        passport_date_of_issue: {required: helpers.withMessage('Passport Issue Date is required', required)},
        passport_expire_on: {required: helpers.withMessage('Passport Expire Date is required', required)},
        passport_place_of_birth: {required: helpers.withMessage('Birth Place is required', required)},
        passport_place_of_issue: {required: helpers.withMessage('Issue Place is required', required)},
        name: {required: helpers.withMessage('Name is required', required)},
        dob: {required: helpers.withMessage('DOB is required', required)},
        gender: {required: helpers.withMessage('Gender is required', required)},
        emp_doc: {required: helpers.withMessage('Document is required', required)},
    }
})
const passportV$ = useValidate(passportRules, usedocs.emp_docs)

const validatePassport = () => {
    console.log(passportV$.value);
    passportV$.value.$validate() // checks all inputs
    if (!passportV$.value.$error) {
        // if ANY fail validation
        usedocs.save_empdocs('Passport'),
            visibleRight.value = false
        console.log('Form successfully submitted.')
        passportV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

//voter validation
const voterRules = computed(() => {
    return {
        name: {required: helpers.withMessage('Name is required', required)},
        dob: {required: helpers.withMessage('DOB is required', required)},
        father_name: {required: helpers.withMessage('Father Name is required', required)},
        voterid_emp_address: {required: helpers.withMessage('Address is required', required)},
        voterid_number: {required: helpers.withMessage('Voter ID NO is required', required)},
        voter_id_issued_on: {required: helpers.withMessage('Voter ID Issue Date is required', required)},
        gender: {required: helpers.withMessage('Gender is required', required)},
        emp_doc: {required: helpers.withMessage('Document is required', required)},
    }
})
const voterV$ = useValidate(voterRules, usedocs.emp_docs)

const validateVote = () => {
    console.log(voterV$.value);
    voterV$.value.$validate() // checks all inputs
    if (!voterV$.value.$error) {
        // if ANY fail validation
        usedocs.save_empdocs('Voter ID'),
            visibleRight.value = false
        console.log('Form successfully submitted.')
        voterV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}
// license validation
const licenseRules = computed(() => {
    return {
        name: {required: helpers.withMessage('Name is required', required)},
        dob: {required: helpers.withMessage('DOB is required', required)},
        father_name: {required: helpers.withMessage('Father Name is required', required)},
        address: {required: helpers.withMessage('Address is required', required)},
        license_number: {required: helpers.withMessage('License NO is required', required)},
        license_issue_date: {required: helpers.withMessage('License Issue Date is required', required)},
        license_expires_on: {required: helpers.withMessage('License Expire Date is required', required)},
        blood_group:{required: helpers.withMessage('Blood Group is required', required)},
        emp_doc: {required: helpers.withMessage('Document is required', required)},
    }
})
const licenseV$ = useValidate(licenseRules, usedocs.emp_docs)

const validateLicense = () => {
    console.log(licenseV$.value);
    licenseV$.value.$validate() // checks all inputs
    if (!licenseV$.value.$error) {
        // if ANY fail validation
        usedocs.save_empdocs('Driving License'),
            visibleRight.value = false
        console.log('Form successfully submitted.')
        licenseV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

// Document Validation
const documentRules = computed(() => {
    return {
        emp_doc: {required: helpers.withMessage('Document is required', required)},
    }
})
const documentV$ = useValidate(documentRules, usedocs.emp_docs)

const validateDocument = () => {
    console.log(documentV$.value);
    documentV$.value.$validate() // checks all inputs
    if (!documentV$.value.$error) {
        // if ANY fail validation
        usedocs.save_empdocs('Document'),
            visibleRight.value = false
        console.log('Form successfully submitted.')
        documentV$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

// reset validation
const resetValidators = () =>{
    panV$.value.$reset()
    passportV$.value.$reset()
    voterV$.value.$reset()
    licenseV$.value.$reset()
    documentV$.value.$reset()
}
</script>

<style scoped>
.sidebar
{
    position: fixed;
    top: 0;
    right: -100%;
    /* Adjust the value to control how far it's initially hidden */
    width: 100%;
    /* Adjust the width as needed */
    height: 100%;
    background-color: #0000004a;
    color: white;
    transition: right 0.3s;
    z-index: 10;
}

.sidebar.open
{
    right: 0 ;
}
/* .swal2-icon.swal2-success .swal2-success-line-long{
    right: 0 !important;
}
.swal2-icon.swal2-success .swal2-success-line-tip{
    left: 4px !important;
} */
</style>
