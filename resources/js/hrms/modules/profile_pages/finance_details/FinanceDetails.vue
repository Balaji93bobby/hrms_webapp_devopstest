<template>
    <div v-if="_instance_profilePagesStore.employeeDetails.get_statutory_details">
        <div class="">
            <div class="">
                <ul class="nav nav-pills nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active " id="" data-bs-toggle="pill" href="" data-bs-target="#finance_summary"
                            role="tab" aria-controls="pills-home" aria-selected="true">Summary
                        </a>
                    </li>
                    <li class="mx-4 nav-item " role="presentation">
                        <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#finance_pay" role="tab"
                            aria-controls="pills-home" aria-selected="true">
                            Payslips
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade active show" id="finance_summary" role="tabpanel" aria-labelledby="">


                <div class="my-2" v-if="_instance_profilePagesStore.employeeDetails.get_employee_details">
                    <!-- Payroll Summary -->
                    <div class="w-full bg-white rounded-lg p-2 border">
                        <div class="flex justify-around">
                            <p class="font-semibold text-sm">Payroll Summary</p>
                            <div class="flex justify-end ">
                                <!-- <p class="rounded-full font-semibold  border whitespace-nowrap p-1 text-xs">
                                    Edit
                                <img src="../../../assests/icons/edit.svg" class="h-4 mb-1 w-4 cursor-pointer my-auto"
                                    alt="">
                                 </p> -->
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 h-full py-2">
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">Last Processed</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.payroll_summary.payroll_date ?
                                        dayjs(_instance_profilePagesStore.employeeDetails.payroll_summary.payroll_date
                                        ).format('DD-MMM-YYYY') : '-' }}

                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">Total Working Days</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.payroll_summary.worked_Days ?
                                        _instance_profilePagesStore.employeeDetails.payroll_summary.worked_Days : '-' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">Loss Of Pay(LOP)</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.payroll_summary.lop ?
                                        _instance_profilePagesStore.employeeDetails.payroll_summary.lop : '-' }}
                                </p>
                            </div>

                        </div>

                    </div>


                    <!-- Bank Information -->
                    <div class="w-full bg-white rounded-lg p-2 border my-3">
                        <div class="flex justify-around">
                            <p class="font-semibold text-sm">Bank Information</p>
                            <div class="flex justify-end ">
                                <!-- <p class="rounded-full font-semibold  border whitespace-nowrap p-1 text-xs">
                    Edit -->
                                <img src="../../../assests/icons/edit.svg" class="h-4 mb-1 w-4 cursor-pointer my-auto"
                                    @click="onClick_EditButton_BankInfo" alt="">

                                <!-- </p> -->
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 h-full py-2">
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">Bank Name</p>
                                <p class="font-semibold text-sm">
                                    {{
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.bank_name ?
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.bank_name : '-'
                                    }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">Bank Account No</p>
                                <p class="font-semibold text-sm">
                                    {{
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.bank_account_number ?
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.bank_account_number :
                                        '-'
                                    }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">IFSC Code</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_employee_details.bank_ifsc_code ?
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.bank_ifsc_code : '-'
                                    }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">PAN No</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_employee_details.pan_number ?
                                        _instance_profilePagesStore.employeeDetails.get_employee_details.pan_number : '-' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Statutory Information -->
                    <div class="w-full bg-white rounded-lg p-2 border">
                        <div class="flex justify-around">
                            <p class="font-semibold text-sm">Statutory Information</p>
                            <div class="flex justify-end ">
                                <!-- <p class="rounded-full font-semibold  border whitespace-nowrap p-1 text-xs">
                                Edit -->
                                <img src="../../../assests/icons/edit.svg" class="h-4 mb-1 w-4 cursor-pointer my-auto"
                                    @click="onClick_EditButton_Statutory_Info" alt="">

                                <!-- </p> -->
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 h-full py-2">
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">PF Applicable</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.pf_applicable ?
                                        _instance_profilePagesStore.employeeDetails.get_statutory_details.pf_applicable : '-' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">EPF Number</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.epf_number ?
                                        _instance_profilePagesStore.employeeDetails.get_statutory_details.epf_number : '-' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">UAN Number</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.uan_number ?
                                        _instance_profilePagesStore.employeeDetails.get_statutory_details.uan_number : '-' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">ESIC Applicable</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_applicable ?
                                        _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_applicable :
                                        '-' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="font-semibold text-xs text-gray-500">ESIC Number</p>
                                <p class="font-semibold text-sm">
                                    {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_number ?
                                        _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_number : '-' }}
                                </p>
                            </div>
                            <div class="col-span-11 grid grid-cols-12 ">
                                <div class="col-span-12 flex justify-start">
                                    <p class="font-semibold text-sm text-gray-500">Is Eligible for</p>
                                </div>
                                <div class="col-span-4 flex justify-around ">
                                    <p class="text-md flex  items-center !font-['poppins'] "><strong
                                            class="font-bold text-md">Pension</strong> &nbsp;(with effective from <strong
                                            class="font-bold text-md"> &nbsp; {{ _instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_effective_date ? dayjs(_instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_effective_date).format('DD-MMM-YYYY') : dayjs(_instance_profilePagesStore.employeeDetails.get_employee_details.doj).format('DD-MMM-YYYY')  }}</strong>)&nbsp;&nbsp;&nbsp;
                                        <span v-if="_instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_eligible == 1"
                                            class="bg-[#EBFFEC] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px]">
                                            <i class="pi pi-check" style="font-size:1rem;color:green"></i>
                                        </span>
                                        <span
                                            class="bg-[#FFEBEB] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px] "
                                            v-if="_instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_eligible == 0">
                                            <i class="pi pi-times" style="font-size: 1rem;color:red"></i>
                                        </span>
                                    </p>
                                    <!-- {{_instance_profilePagesStore.employeeDetails.get_statutory_details}} -->
                                </div>
                                <div class="col-span-4 flex ">
                                    <p class="text-md flex  items-center !font-['poppins'] text-[#535353]  "><strong
                                            class="font-bold text-md text-[#000]">ABRY</strong> (with effective from <strong
                                            class="font-bold text-md"> &nbsp;{{ _instance_profilePagesStore.employeeDetails.get_statutory_details.epf_abry_effective_date ?  dayjs(_instance_profilePagesStore.employeeDetails.get_statutory_details.epf_abry_effective_date).format('DD-MM-YYYY') :'-'   }}</strong>)&nbsp;&nbsp;&nbsp;
                                        <!-- <i class="pi pi-check" style="font-size:1rem;color:green" v-if="ABRYDate.length!=0"></i>
                                    <i class="pi pi-times" style="font-size: 1rem;color:red" v-if="ABRYDate.length==0"></i> -->
                                        <span v-if="_instance_profilePagesStore.employeeDetails.get_statutory_details.epf_abry_eligible == 1"
                                            class="bg-[#EBFFEC] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px]">
                                            <i class="pi pi-check" style="font-size:1rem;color:green"></i>
                                        </span>
                                        <span
                                            class="bg-[#FFEBEB] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px] "
                                            v-else>
                                            <i class="pi pi-times" style="font-size: 1rem;color:red"></i>
                                        </span>
                                    </p>

                                </div>
                                <div class="col-span-4 flex justify-around">
                                    <p class="text-md flex  items-center !font-['poppins'] text-[#535353] "><strong
                                            class="font-bold text-md text-[#000]">PMRPY</strong> (with effective from
                                        <strong class="font-bold text-md">&nbsp;{{ _instance_profilePagesStore.employeeDetails.get_statutory_details.PMRPY_is_effective_date ?   dayjs(_instance_profilePagesStore.employeeDetails.get_statutory_details.PMRPY_is_effective_date).format('DD-MM-YYYY') :'-'  }}</strong>)&nbsp;&nbsp;&nbsp;
                                        <!-- <i class="pi pi-check" style="font-size:1rem;color:green" v-if="PMRPYDate.length!=0"></i>
                                    <i class="pi pi-times" style="font-size: 1rem;color:red" v-if="PMRPYDate.length==0"></i> -->
                                        <span v-if="_instance_profilePagesStore.employeeDetails.get_statutory_details.PMRPY_is_eligible == 1"
                                            class="bg-[#EBFFEC] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px]">
                                            <i class="pi pi-check" style="font-size:1rem;color:green"></i>
                                        </span>
                                        <span
                                            class="bg-[#FFEBEB] rounded-full p-2 flex justify-center items-center w-[30px] h-[30px] "
                                            v-else>
                                            <i class="pi pi-times" style="font-size: 1rem;color:red"></i>
                                        </span>
                                    </p>


                                </div>
                            </div>
                        </div>
                    </div>


                </div>




            </div>
            <div class="tab-pane fade" id="finance_pay" role="tabpanel" aria-labelledby="">
                <div class="mb-2 card">
                    <div class="card-body">
                        <EmployeePayslips />
                    </div>
                </div>
            </div>
        </div>




        <Dialog modal header="Header" :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
            <template #header>
                <div>
                    <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                        class="fw-bold fs-5">
                        Bank Information</h5>
                </div>
            </template>

            <div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label>Bank Name</label>
                                <Dropdown editable @keypress="isLetter($event)" :options="bankNameList"
                                    optionLabel="bank_name" optionValue="id" placeholder="Select Bank Name"
                                    class="w-full form-controls" v-model="bank_information.bank_id" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label>Bank Account No</label>
                                <div class="cal-icon">
                                </div>
                                <InputNumber v-model="bank_information.bank_ac_no" class="form-controls onboard-form"
                                    inputId="withoutgrouping" :useGrouping="false" />
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label>IFSC Code</label>
                                <InputText type="text" name="bank_ifsc_" class="form-controls pl-2"
                                    v-model="bank_information.ifsc_code" />
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                        <div class="mb-3 form-group">
                            <label>PAN No</label>
                            <InputText type="text" name="pan_nos" class="form-controls pl-2"
                                v-model="bank_information.pan_no" />
                        </div>
                    </div> -->

                        <div class="col-md-6 ">
                            <div class="floating d-block justify-items-start al">
                                <label for="" class="float-label mb-2">Bank Passbook or Cheque Leaf</label>
                                <div class=" flex justify-content-start">
                                    <Toast />
                                    <label
                                        class="cursor-pointer text-primary d-flex align-items-center fs-5 btn bg-primary "
                                        style="width:135px ; " id="" for="uploadPassBook">
                                        <i class="pi pi-arrow-circle-up fs-5 mr-3"></i>
                                        <h1 class="text-light">Upload file</h1>
                                    </label>
                                    <div class="d-flex flex-column justify-content-center align-items-center border ">
                                        <input type="file" name="" id="uploadPassBook" hidden
                                            @change="updateCheckBookPhoto($event)" style="text-transform: uppercase"
                                            class="form-controls pl-2" :class="[
                                                r$.PassBook.$error ? 'p-invalid' : '',
                                            ]" />
                                        <span v-if="r$.PassBook.$error" class="text-red-400 fs-6 font-semibold text-center">
                                            {{ r$.PassBook.required.$message.replace("Value", "PassBook or Cheque Leaf") }}
                                        </span>
                                    </div>
                                    <div v-if="bank_information.PassBook"
                                        class="p-2 px-3 bg-green-100 rounded-lg font-semibold fs-11 mx-4">
                                        {{ bank_information.PassBook.name }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <div class="text-right">
                            <button id="btn_submit_bank_info" class="btn btn-orange submit-btn"
                                @click="submitBankForm">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </Dialog>
        <Sidebar v-model:visible="dialog_Bankvisible" position="right" :style="{ width: '30vw !important' }">
            <template #header>
                <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Bank Information</h1>
                </div>
            </template>

            <div class="p-2 bg-[#FFE2E2] !w-[100%]  ">
                <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] "> You can
                        add/edit your bank details here.</span></p>
            </div>
            <div class="leading-3  font-['poppins']  mt-3 p-2">

                <div class="mb-2 form-group ">
                    <label>Bank Name</label>
                    <Dropdown editable @keypress="isLetter($event)" :options="bankNameList" optionLabel="bank_name"
                        optionValue="id" placeholder="Select Bank Name" class="w-full my-3  form-controls"
                        v-model="bank_information.bank_id" />

                </div>
                <div class="mb-2 form-group">
                    <label>Bank Account No</label>
                    <div class="cal-icon ">
                    </div>
                    <InputNumber v-model="bank_information.bank_ac_no" class="form-controls m-0 my-3  onboard-form"
                        inputId="withoutgrouping" :useGrouping="false" />
                </div>
                <div class="mb-2 form-group">
                    <label>IFSC Code</label>
                    <InputText type="text" name="bank_ifsc_" class="form-controls p-3  my-3 pl-2"
                        v-model="bank_information.ifsc_code" />
                </div>
                <div class="floating d-block justify-items-start al">
                    <label for="" class="float-label mb-2">Bank Passbook or Cheque Leaf</label>
                    <div class=" flex flex-col justify-start">
                        <Toast />
                        <label
                            class="cursor-pointer flex justify-start items-center text-[12px] rounded-md w-[100%] border-[1px] my-2 border-gary-200 "
                            style="" id="" for="uploadPassBook">
                            <i class="pi pi-download bg-gray-300 p-3 rounded-md mr-3"></i>
                            <h1 class="text-[#000] " v-if="!bank_information.PassBook.name">Upload file</h1>
                            <p v-if="bank_information.PassBook" class="">
                                {{ bank_information.PassBook.name }}</p>
                        </label>
                        <div class="flex flex-col justify-center items-center  ">
                            <input type="file" name="" id="uploadPassBook" hidden @change="updateCheckBookPhoto($event)"
                                style="text-transform: uppercase" class="form-controls pl-2" :class="[
                                    r$.PassBook.$error ? 'p-invalid' : '',
                                ]" />
                            <span v-if="r$.PassBook.$error" class="text-red-400 fs-6 font-semibold text-center">
                                {{ r$.PassBook.required.$message.replace("Value", "PassBook or Cheque Leaf") }}
                            </span>
                        </div>

                    </div>
                </div>
                <div class="text-center mt-56 flex justify-center items-center ">
                    <button class=" border-[1px] border-[#000] rounded-md btn mx-2"
                        @click="dialog_Bankvisible = false">Cancel</button>
                    <button id="btn_submit_bank_info" class="btn text-[#fff] bg-black submit-btn"
                        @click="submitBankForm">Submit</button>
                </div>
            </div>
        </Sidebar>



        <Dialog v-model:visible="dialog_PanNo_visible" modal header="Header"
            :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
            <template #header>
                <div>
                    <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                        class="fw-bold fs-5">
                        Pancard Information</h5>
                </div>
            </template>
            <div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="mb-2 font-semibold text-lg">PAN No</label>
                                <InputMask @focusout="panCardExists" id="serial" mask="aaaaa9999a"
                                    v-model="pan_information.pan_no" placeholder="AHFCS1234F"
                                    style="text-transform: uppercase" class="form-controls pl-2" :class="[
                                        v$.pan_no.$error ? 'p-invalid' : '',
                                    ]" />
                                <span v-if="v$.pan_no.$error" class="text-red-400 fs-6 font-semibold">
                                    {{ v$.pan_no.required.$message.replace("Value", "Pancard number") }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex flex-column ">
                            <!-- flex-column -->
                            <div class="d-flex justify-items-center  flex-column ml-10">
                                <label for="" class="float-label mb-2 font-semibold text-lg">Pancard</label>
                                <div class="d-flex  justify-items-center align-items-center">
                                    <Toast />
                                    <label
                                        class="cursor-pointer text-primary d-flex align-items-center fs-5 btn bg-primary "
                                        style="width:100px ; " id="" for="uploadPassBook">
                                        <i class="pi pi-arrow-circle-up fs-5 mr-2"></i>
                                        <h1 class="text-light">Upload</h1>
                                    </label>

                                    <div v-if="pan_information.Pancard"
                                        class="p-2 bg-blue-100 rounded-lg font-semibold fs-11 mx-4">{{
                                            pan_information.Pancard.name }}</div>

                                    <input type="file" name="" id="uploadPassBook" hidden
                                        @change="UploadPandcardPhoto($event)" :class="[
                                            v$.Pancard.$error ? 'p-invalid' : '',
                                        ]" />
                                </div>
                                <span v-if="v$.Pancard.$error" class="text-red-400 fs-6 font-semibold">
                                    {{ v$.Pancard.required.$message.replace("Value", "Pancard attachment") }}
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <div class="text-right">
                            <button id="btn_submit_bank_info" class="btn btn-orange submit-btn"
                                @click="submitForm">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </Dialog>

        <Dialog modal header="Statutory Details" :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
            <template #header>
                <div>
                    <h5 :style="{ color: 'var(--color-blue)', borderLeft: '3px solid var(--light-orange-color', paddingLeft: '6px' }"
                        class="fw-bold fs-5">
                        Statutory information</h5>
                </div>
            </template>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="" class="">PF
                            Applicable<span class="text-danger">*</span></label>
                        <Dropdown v-model="statutory_information.pf_applicable" :options="esic_applicable_option"
                            placeholder="PF Applicable" optionLabel="name" optionValue="value" class="w-100 " />
                    </div>
                    <div class="col">
                        <label class="ml-2">EPF Number</label>
                        <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.epf_no"
                            class="w-100  mt-1" type="text" placeholder="EPF Number" />
                    </div>
                </div>
                <div class="row ">
                    <div class="col ">
                        <label class=" ml-1">UAN Number</label>
                        <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.uan_no" class="w-100"
                            type="text" placeholder="EPF Number" />
                    </div>
                    <div class="col ml-2">
                        <label class="ml-2">ESIC
                            Applicable<span class="text-danger">*</span></label>
                        <Dropdown v-model="statutory_information.esic_applicable" :options="esic_applicable_option"
                            optionLabel="name" placeholder="ESIC Applicable" class="w-100 " optionValue="value" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 ">
                        <label for="" class=" ml-2">ESIC Number</label>
                        <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.esic_no"
                            class="w-100  mt-1" type="text" placeholder="EPF Number" />
                    </div>
                    <div class="col">
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-right">
                        <button id="btn_submit_statutory_info" class="btn btn-border-orange submit-btn"
                            @click="saveinfo_statutoryDetails">Save</button>
                    </div>
                </div>
            </div>



        </Dialog>
        <Sidebar v-model:visible="dialog_statutory_visible" position="right" :style="{ width: '30vw !important' }">
            <template #header>
                <div class=" bg-[#000] !w-[100%] h-[60px] absolute top-0 left-0 ">
                    <h1 class=" m-4  text-[#ffff] font-['poppins] font-semibold ">Statutory Details</h1>
                </div>
            </template>
            <div class="p-2 bg-[#FFE2E2] !w-[100%]   ">
                <p class="text-[#000] w-[100%] font-['poppins'] ">Instruction : <span class=" text-[gray] "> You can
                        add/edit your bank details here.</span></p>
            </div>
            <div class=" mt-1 p-2">
                <div class="py-2">
                    <label for="" class="">PF
                        Applicable<span class="text-danger">*</span></label>
                    <Dropdown v-model="statutory_information.pf_applicable" :options="esic_applicable_option"
                        placeholder="PF Applicable" optionLabel="name" optionValue="value" class="w-100 mt-2" />
                </div>
                <div class="py-1">
                    <label class="ml-2">EPF Number</label>
                    <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.epf_no" class="w-100  mt-2"
                        type="text" placeholder="EPF Number" />
                </div>

                <div class="py-1">
                    <label class=" ml-1">UAN Number</label>
                    <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.uan_no"
                        class="w-100 mt-2  " type="text" placeholder="EPF Number" />
                </div>
                <div class="py-1">
                    <label class="ml-2">ESIC
                        Applicable<span class="text-danger">*</span></label>
                    <Dropdown v-model="statutory_information.esic_applicable" :options="esic_applicable_option"
                        optionLabel="name" placeholder="ESIC Applicable" class="w-100 mt-2 " optionValue="value" />
                </div>
                <div class="py-1 ">
                    <label for="" class=" ml-2">ESIC Number</label>
                    <InputText @keypress="isSpecialChars($event)" v-model="statutory_information.esic_no"
                        class="w-100  mt-2" type="text" placeholder="EPF Number" />
                </div>
                <div class="py-2 flex flex-col">
                    <label for="" class="mx-2 font-['poppins']">Is Eligible for Pension</label>
                    <div class="flex justify-between">
                        <div class="flex items-center my-2">
                            <input type="radio" name="is_eligible_pension"
                                v-model="statutory_information.is_eligible_pension" @change="statutory_information.is_eligible_pension ? statutory_information.eps_pension_effective_date = _instance_profilePagesStore.employeeDetails.get_employee_details.doj :  statutory_information.eps_pension_effective_date " value="1"
                                class="bg-[#0000] mx-2 w-[15px] h-[15px]"><label for="">Yes</label>
                            <input type="radio" name="is_eligible_pension"
                                v-model="statutory_information.is_eligible_pension" @change="statutory_information.is_eligible_pension== 0 ? statutory_information.eps_pension_effective_date = '' :  statutory_information.eps_pension_effective_date = _instance_profilePagesStore.employeeDetails.get_employee_details.doj  " value="0"
                                class="bg-[#0000]  mx-2 w-[15px] h-[15px]"><label for="">No</label>
                        </div>
                        <Calendar v-model="statutory_information.eps_pension_effective_date"  dateFormat="dd-M-yy" class=" h-[30px]" />

                    </div>

                </div>
                <div class="py-2  flex flex-col ">
                    <label for="" name="is_eligible_ABRY" class="mx-2 font-['poppins']">Is Eligible for ABRY</label>
                    <div class="flex justify-between">
                        <div class="my-2 flex items-center">
                            <input type="radio" name="is_eligible_ABRY" v-model="statutory_information.is_eligible_ABRY"
                                value="1" class="bg-[#0000] mx-2 w-[15px] h-[15px]"><label for="">Yes</label>
                            <input type="radio" name="is_eligible_ABRY" v-model="statutory_information.is_eligible_ABRY"
                                value="0" class="bg-[#0000] mx-2 w-[15px] h-[15px]"><label for="">No</label>
                        </div>
                        <Calendar v-model="statutory_information.epf_abry_effective_date" v-if=" statutory_information.is_eligible_ABRY == 1"  dateFormat="dd-M-yy" class=" h-[30px]" />

                    </div>


                </div>
                <div class="py-2 flex flex-col  ">
                    <label for="" class="mx-2 font-['poppins']">Is Eligible for PMRPY</label>
                    <div class="flex justify-between">
                        <div class="my-2 flex items-center">
                            <input type="radio" name="is_eligible_PMRPY" v-model="statutory_information.is_eligible_PMRPY"
                                value="1" class="mx-2 bg-[#0000] w-[15px] h-[15px]"><label for="" class="mx-2">Yes</label>
                            <input type="radio" name="is_eligible_PMRPY" v-model="statutory_information.is_eligible_PMRPY"
                                value="0" class="mx-2 bg-[#0000] w-[15px] h-[15px]"><label for="">No</label>
                        </div>
                        <Calendar v-if="statutory_information.is_eligible_PMRPY==1" v-model="statutory_information.PMRPY_is_effective_date"  dateFormat="dd-M-yy" class=" h-[30px]" />
                    </div>

                </div>
                <div class="text-center mt-[10px] flex justify-center items-center">
                    <button class=" text-[#000] border-[1px] border-[#000] btn mx-2"
                        @click="dialog_statutory_visible = false">Cancel</button>
                    <button id="btn_submit_statutory_info" class="btn bg-[#000] text-[#ffff] submit-btn"
                        @click="saveinfo_statutoryDetails">Save</button>
                </div>
            </div>
        </Sidebar>


        <Dialog header="Header" v-model:visible="canShowLoading" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '25vw' }" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                    animationDuration="2s" aria-label="Custom ProgressSpinner" />
            </template>
            <template #footer>
                <h5 style="text-align: center">Please wait...</h5>
            </template>
        </Dialog>

    </div>
</template>
<script setup>
import { ref, onMounted, reactive, computed } from 'vue';
import axios from 'axios'
import { useToast } from "primevue/usetoast";
import { Service } from "../../Service/Service";
import { profilePagesStore } from '../stores/ProfilePagesStore'
import EmployeePayslips from './EmployeePayslips.vue'
import useValidate from '@vuelidate/core'
import dayjs from 'dayjs';
import { useNow, useDateFormat } from '@vueuse/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'

const _instance_profilePagesStore = profilePagesStore()

const fetch_data = Service()

const pensionDate = ref('10-Aug-2023')
const ABRYDate = ref('12-Aug-2023')
const PMRPYDate = ref('')

const toast = useToast();

const canShowLoading = ref(false);

const dialog_PanNo_visible = ref(false);

const payroll_summary = ref();

payroll_summary.value = _instance_profilePagesStore.employeeDetails.payroll_summary;
console.log("testing payroll summary :", payroll_summary.value);


let form = new FormData();
form.append("user_code", Service.current_user_code);
form.append("file_object", profilePagesStore.value);

let url = "/profile-pages/updateProfilePicture";
axios
    .post(url, form)
    .then((res) => {
        // console.log(res.data);
    })
    .finally(() => {
        console.log("Photo Sent");
        // updateCheckBookPhoto();
    });



const statutory = ref([])
const bankNameList = ref();

statutory.value.push(_instance_profilePagesStore.employeeDetails.get_statutory_details)

onMounted(() => {
    // fetchData();
    fetch_data.getBankList().then(res => {
        bankNameList.value = res.data;
    })
    _instance_profilePagesStore.fetchEmployeeDetails();

});


const dialog_Bankvisible = ref(false);
const dialog_statutory_visible = ref(false);

const bank_info_data = ref()
const statutory_info_data = ref()

const bank_information = reactive({
    bank_id: '',
    bank_ac_no: '',
    ifsc_code: '',
    PassBook: ''
});

const pan_information = reactive({
    pan_no: '',
    Pancard: ''

})

const updateCheckBookPhoto = (e) => {
    // Check if file is selected
    if (e.target.files && e.target.files[0]) {
        // Get uploaded file
        bank_information.PassBook = e.target.files[0];
        // Get file size
        // Print to console
        console.log(bank_information.PassBook);
    }
}


const esic_applicable_option = ref([
    { name: 'Yes', value: 'Yes' },
    { name: 'No', value: 'No' },
]);


// save bankdetails function

const saveBankinfoDetails = () => {

    canShowLoading.value = true;

    let id = fetch_data.current_user_id;
    let url = `/update-bank-info/${id}`;
    let form = new FormData()

    form.append('user_code', _instance_profilePagesStore.employeeDetails.user_code)
    form.append('bank_id', bank_information.bank_id)
    form.append('account_no', bank_information.bank_ac_no)
    form.append('bank_ifsc', bank_information.ifsc_code)
    form.append('PassBook', bank_information.PassBook)
    form.append('onboard_document_type', "Cheque leaf/Bank Passbook")

    axios.post(url, form)
        .then((res) => {
            if (res.data.status == "success") {
                toast.add({ severity: 'success', summary: 'Updated', detail: 'Bank information updated', life: 3000 });
                _instance_profilePagesStore.employeeDetails.get_employee_details.bank_id = bank_information.bank_id;
                _instance_profilePagesStore.employeeDetails.get_employee_details.bank_account_number = bank_information.bank_ac_no;
                _instance_profilePagesStore.employeeDetails.get_employee_details.bank_ifsc_code = bank_information.ifsc_code;
                _instance_profilePagesStore.employeeDetails.get_employee_details.pan_no = bank_information.pan_no;

            } else if (res.data.status == "failure") {
                leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails();
            canShowLoading.value = false;
        })

    dialog_Bankvisible.value = false;

}

function onClick_EditButton_BankInfo() {
    // Assign json values into dialog elements also
    bank_information.bank_id = parseInt(_instance_profilePagesStore.employeeDetails.get_employee_details.bank_id);
    bank_information.bank_ac_no = _instance_profilePagesStore.employeeDetails.get_employee_details.bank_account_number;
    bank_information.ifsc_code = _instance_profilePagesStore.employeeDetails.get_employee_details.bank_ifsc_code;
    bank_information.pan_no = _instance_profilePagesStore.employeeDetails.get_employee_details.pan_number;
    dialog_Bankvisible.value = true;
}


function onClick_EditButton_Statutory_Info() {
    // Assign json values into dialog elements also

    if (_instance_profilePagesStore.employeeDetails.get_statutory_details) {
        statutory_information.pf_applicable = _instance_profilePagesStore.employeeDetails.get_statutory_details.pf_applicable;
        statutory_information.epf_no = _instance_profilePagesStore.employeeDetails.get_statutory_details.epf_number;
        statutory_information.uan_no = _instance_profilePagesStore.employeeDetails.get_statutory_details.uan_number;
        statutory_information.esic_applicable = _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_applicable;
        statutory_information.esic_no = _instance_profilePagesStore.employeeDetails.get_statutory_details.esic_number;
        statutory_information.eps_pension_effective_date  =  _instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_effective_date ?  _instance_profilePagesStore.employeeDetails.get_statutory_details.eps_pension_effective_date  :  new Date(_instance_profilePagesStore.employeeDetails.get_employee_details.doj)
    }
    else {
        dialog_statutory_visible.value = true;
    }
    dialog_statutory_visible.value = true;
}

function onClick_EditButton_PanNo_info() {
    dialog_PanNo_visible.value = true;

}

const statutory_information = reactive({
    pf_applicable: '',
    epf_no: '',
    uan_no: '',
    esic_applicable: '',
    esic_no: '',
    is_eligible_pension: '',
    is_eligible_ABRY: '',
    is_eligible_PMRPY: '',
    PMRPY_is_effective_date: '',
    eps_pension_effective_date: '',
    epf_abry_effective_date: '',
})


const saveinfo_statutoryDetails = () => {
    canShowLoading.value = true;

    let id = fetch_data.current_user_id;


    let url = `/update-statutory-info/${id}`;

    axios.post(url, {
        user_code: _instance_profilePagesStore.employeeDetails.user_code,
        pf_applicable: statutory_information.pf_applicable,
        epf_number: statutory_information.epf_no,
        uan_number: statutory_information.uan_no,
        esic_applicable: statutory_information.esic_applicable,
        esic_number: statutory_information.esic_no,
        epf_abry_eligible: statutory_information.is_eligible_ABRY,
        eps_pension_eligible: statutory_information.is_eligible_pension,
        PMRPY_is_eligible: statutory_information.is_eligible_PMRPY,
        epf_abry_effective_date: statutory_information.epf_abry_effective_date,
        eps_pension_effective_date: statutory_information.eps_pension_effective_date,
        PMRPY_is_effective_date: statutory_information.PMRPY_is_effective_date,
    })
        .then((res) => {

            if (res.data.status == "success") {

                toast.add({ severity: 'success', summary: 'Updated', detail: 'General information updated', life: 3000 });


            } else if (res.data.status == "failure") {
                leave_data.leave_request_error_messege = res.data.message;
            }
        })
        .catch((err) => {
            console.log(err);
        }).finally(() => {
            _instance_profilePagesStore.fetchEmployeeDetails();
            canShowLoading.value = false;
        })

    dialog_statutory_visible.value = false;

}

const UploadPandcardPhoto = (e) => {
    if (e.target.files && e.target.files[0]) {
        pan_information.Pancard = e.target.files[0];
        console.log(pan_information.Pancard);
    }
}


const savePancardInfoDetails = () => {
    canShowLoading.value = true
    let id = fetch_data.current_user_id;
    const url = `/update-Pancard-info/${id}`;
    const form = new FormData;
    form.append('pan_no', pan_information.pan_no);
    form.append('pancard', pan_information.Pancard);
    form.append('user_code', _instance_profilePagesStore.employeeDetails.user_code)
    form.append('onboard_document_type', "Pan Card");
    dialog_PanNo_visible.value = false;

    if (pan_information.Pancard) {
        axios.post(url, form).finally(() => {
            canShowLoading.value = false;

        })
    }


};

const bankDetailsRules = computed(() => {
    return {
        PassBook: { required },
    }
});

const r$ = useValidate(bankDetailsRules, bank_information)

const submitBankForm = () => {
    r$.value.$validate() // checks all inputs
    if (!r$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        saveBankinfoDetails()
    } else {
        console.log('Form failed submitted.')
    }

}


const rules = computed(() => {
    return {
        pan_no: { required },
        Pancard: { required },
    }
});

const v$ = useValidate(rules, pan_information)

const submitForm = () => {
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        savePancardInfoDetails()
    } else {
        console.log('Form failed submitted.')
    }

}

const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}

const isSpecialChars = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z0-9]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}



</script>

<style>
.form-controls
{
    width: 100%;
    height: 2.5rem;
    padding: 0;
}

Dropdown>placeholder
{
    margin-top: -5px;
}

.p-sidebar-right .p-sidebar
{
    width: 30% !important;
    height: 100%;
}

input[type="radio"]:checked
{
    /* background-color: black !important;  */
    /* Change this to your desired color */
    accent-color: black !important;
}
</style>
