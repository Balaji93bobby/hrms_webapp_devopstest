<template>
    <div class="">
        <div class="card">
            <div class="card-body bg-[#f6f6f6] ">
                <div class="grid grid-cols-9">
                    <ul class="my-4 nav nav-pills nav-tabs-dashed col-span-6 " role="tablist">
                        <li class="nav-item text-muted" role="presentation">
                            <button @click="activeTab = 1" class="pb-2 nav-link active" id="pills-offer-pending-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-offer-pending" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">EMPLOYEE'S PROVIDENT FUND</button>
                        </li>
                        <li class="mx-1 nav-item text-muted " role="presentation">
                            <button @click="activeTab = 2" class="pb-2 nav-link" id="pills-offer-completed-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-offer-completed" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">EMPLOYEE'S STATE INSURANCE</button>
                        </li>
                        <li class="nav-item text-muted" role="presentation">
                            <button @click="activeTab = 3" class="pb-2 nav-link" id="pills-offer-resent-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-offer-resent" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">PROFESSIONAL TAX</button>
                        </li>
                        <li class="mx-1 nav-item text-muted" role="presentation">
                            <button @click="activeTab = 4" class="pb-2 nav-link" id="pills-offer-resen-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-offer-resen" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">LABOUR WELFARE FUND</button>
                        </li>
                    </ul>
                    <div class="col-span-3  my-2 pt-2 box-border grid grid-cols-4 gap-3 ">
                        <div class="col-span-4 justify-end  flex gap-[12px] ">
                            <button v-if="activeTab == 1 && nonpfTab === false"
                                class="font-medium border-[1px] border-[#dddd] !w-[188px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[14px]"
                                @click="nonpfTab = true, pfTab = false">Non-PF
                                Employees</button>
                            <button
                                class="font-medium border-[1px] border-[#dddd] !w-[134px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[14px] flex justify-center items-center gap-2"
                                @click="activeTab == 1 ? epfSidebar = true : activeTab == 2 ? esiSidebar = true : activeTab == 3 ? protaxSidebar = true : activeTab == 4 ? localwelfare = true : ''"><i
                                    class="pi pi-plus "></i>Add New</button>
                        </div>

                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-offer-pending" role="tabpanel"
                        aria-labelledby="pills-offer-pending-tab">
                        <div class="card-body ">
                            <div v-if="pfTab == true" class="offer-pending-content">
                                <employees_provident_fund />
                            </div>
                            <div v-if="nonpfTab == true" class="offer-pending-content">
                                <non_pf_employees />
                            </div>
                        </div>
                        <div v-if="nonpfTab == true" class="my-4 flex justify-center items-center  ">
                            <button
                                class=" font-medium border-[1px] border-[#dddd] !w-[134px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[14px] flex justify-center items-center gap-2"
                                @click="nonpfTab = false, pfTab = true">Cancel</button>
                        </div>
                    </div>
                    <div class="tab-pane fade active" id="pills-offer-completed" role="tabpanel"
                        aria-labelledby="pills-offer-completed-tab">
                        <div class="card-body">
                            <div class="my-4 offer-pending-content">
                                <employees_state_insurance />
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade " id="pills-offer-resent" role="tabpanel"
                        aria-labelledby="pills-offer-resent-tab">
                        <div class="card-body ">
                            <div class="offer-pending-content  ">
                                <abry_scheme />

                            </div>
                        </div>
                        <!-- <div class="my-3 text-end">
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
                @click="uesPayroll.activeTab--">Previous</button>
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
                @click="uesPayroll.saveGeneralPayrollSettings(uesPayroll.generalPayrollSettings)">Save</button>
            <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
                @click="uesPayroll.activeTab++">Next</button>
        </div> -->
                    </div>
                    <div class="tab-pane fade " id="pills-offer-resen" role="tabpanel"
                        aria-labelledby="pills-offer-resen-tab">
                        <div class="card-body">
                            <div class="offer-pending-content">
                                <pmrpy_scheme />
                                <!-- <labour_welfare_fund/> -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- EPF SIDEBAR -->
    <Sidebar v-model:visible="epfSidebar" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Employee Provident Fund </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="epfSidebar = false"></i>
        <div class="grid grid-cols-6 p-4 box-border">
            <!-- enable/disable   -->
            <div class="col-span-6 flex flex-col ">
                <p class="font-['poppins']  text-[16px] font-semibold ">Employee Provident Fund </p>
                <div class="grid grid-cols-6 ">
                    <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                        <div class=" d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                                v-model="usePayroll.epfSettings.is_epf_enabled" name="radiobtn" id="" value="1"
                                :class="[epfV$.is_epf_enabled.$error ? 'p-invalid' : '']" />
                            <label class="ml-2  form-check-label leave_type fs-13" for="">
                                <p class="font-medium font-['poppins'] text-[16px]">Enable EPF</p>
                            </label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                                v-model="usePayroll.epfSettings.is_epf_enabled" id="" value="0"
                                :class="[epfV$.is_epf_enabled.$error ? 'p-invalid' : '']" />
                            <label class="ml-2 form-check-label leave_type fs-13" for="">
                                <p class="font-medium font-['poppins'] text-[16px]">Disable EPF</p>
                            </label>
                        </div>

                    </div>
                    <span v-if="epfV$.is_epf_enabled.$error" class="font-semibold text-red-400 fs-6">
                        {{ epfV$.is_epf_enabled.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <!-- EPF Details -->
            <div class="col-span-6 flex flex-col">
                <p class="font-medium text-[18px] font-['poppins']">EPF Details</p>
                <div class="flex flex-col py-2 box-border gap-2">
                    <p class="font-medium text-[16px] font-['poppins']">EPF Number<span class="text-[#C4302B]">*</span></p>

                    <InputText v-model="usePayroll.epfSettings.epf_number" placeholder="EPF Number" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[epfV$.epf_number.$error ? 'p-invalid' : '']" />

                </div>
                <span v-if="epfV$.epf_number.$error" class="font-semibold text-red-400 fs-6">
                    {{ epfV$.epf_number.$errors[0].$message }}
                </span>
                <div class="flex py-2 box-border gap-1">
                    <input type="checkbox" value="1" name="" class="form-check-input mr-3" id=""
                        style="width: 20px; height: 20px;" v-model="usePayroll.epfSettings.is_epf_policy_default">
                    <p class="font-medium text-[16px] font-['poppins']">Is Policy Default?</p>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        On which date do the payroll period End in {{ new Date().toLocaleString('default', {
                            month:
                                'long',
                        }) }}?<span class="text-[#C4302B]">*</span>

                    </h5>

                    <Calendar inputId="icon" class="border-[1px] border-[#e6e6e6]" showIcon
                        v-model="usePayroll.epfSettings.epf_deduction_cycle" :showIcon="true" dateFormat="dd-mm-yy"
                        style="width: 300px;" :class="[epfV$.epf_deduction_cycle.$error ? 'p-invalid' : '']" />
                    <span v-if="epfV$.epf_deduction_cycle.$error" class="font-semibold text-red-400 fs-6">
                        {{ epfV$.epf_deduction_cycle.$errors[0].$message }}
                    </span>
                </div>
                <div class="grid grid-cols-6 py-2 box-border">
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" value="1" name="" class="form-check-input mr-3" id=""
                            style="width: 20px; height: 20px;" v-model="usePayroll.epfSettings.employer_contrib_in_ctc">
                        <p class="font-medium text-[16px] font-['poppins']">Employer's contribution is included
                            in the CTC.</p>
                    </div>
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" name="" value="1" class="form-check-input mr-3" id=""
                            style="width: 20px; height: 20px;" v-model="usePayroll.epfSettings.employer_edli_contri_in_ctc">
                        <p class="font-medium text-[16px] font-['poppins']">Employer's EDLI contribution is
                            included in the CTC.</p>
                    </div>
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" value="1" name="" class="form-check-input mr-3" id=""
                            style="width: 20px; height: 20px;" v-model="usePayroll.epfSettings.admin_charges_in_ctc">
                        <p class="font-medium text-[16px] font-['poppins']">Admin charges is included in the
                            CTC.</p>
                    </div>
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" value="1" name="" class="form-check-input mr-3" id=""
                            style="width: 20px; height: 20px;" v-model="usePayroll.epfSettings.override_pf_contrib_rate">
                        <p class="font-medium text-[16px] font-['poppins']">Override PF contribution rate at
                            employee Level.</p>
                    </div>
                </div>
            </div>
            <!-- Contribution -->
            <div class="col-span-6 flex flex-col py-2 box-border">
                <p class="font-medium text-[18px] font-['poppins']">Employee/Employer Contribution</p>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Select the Rule<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.epfSettings.epf_rule" :options="usePayroll.epf_rule"
                        optionLabel="epf_rule" optionValue="id" placeholder="Choose Rule"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[epfV$.epf_rule.$error ? 'p-invalid' : '']" />
                    <span v-if="epfV$.epf_rule.$error" class="font-semibold text-red-400 fs-6">
                        {{ epfV$.epf_rule.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Select the Contribution Type<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.epfSettings.epf_contribution_type" :options="usePayroll.epf_contribution"
                        optionLabel="epf_contribution_type" optionValue="id"
                        placeholder="Choose the contribution type based on rule"
                        class=" !w-[450px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium"
                        :class="[epfV$.epf_contribution_type.$error ? 'p-invalid' : '']" />
                    <span v-if="epfV$.epf_contribution_type.$error" class="font-semibold text-red-400 fs-6">
                        {{ epfV$.epf_contribution_type.$errors[0].$message }}
                    </span>
                </div>
                <div class="grid grid-cols-6 p-2 box-border">
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" name="" value="1" class="form-check-input mr-3" id=""
                            v-model="usePayroll.epfSettings.pro_rated_lop_status" style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">Pro-rate Restricted PF Wage when LOP
                            Applied</p>
                    </div>
                    <div class="col-span-6 flex py-2 box-border">
                        <input type="checkbox" value="1" name="" class="form-check-input mr-3" id=""
                            v-model="usePayroll.epfSettings.can_consider_salcomp_pf" style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">Consider all applicable salary
                            components if PF wage is less than ₹15,000 after Loss of Pay</p>
                    </div>
                </div>

            </div>
            <!-- Example Table -->
            <div class="col-span-6 flex flex-col py-2 box-border">
                <p class="font-['poppins'] text-[16px] font-medium">Example</p>
                <p class="font-['poppins'] text-[14px] font-medium">
                    Lets Assume the Gross wages = ₹50000 and HRA = ₹4000, then the breakup of contribution will
                    be:
                </p>
                <div class="py-2 box-border">
                    <DataTable :value="sampleData">
                        <Column field="values" header="" class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                        <Column field="epf" header="EPF" class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                        <Column field="eps" header="EPS" class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                        <Column field="total" header="Total" class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                    </DataTable>
                </div>
                <div class="w-[100%]">
                    <p class="text-blue-400 underline text-end">View EPF Calculation</p>
                </div>
                <div class="flex flex-col py-2 box-border w-[100%] gap-2">
                    <p class="font-['poppins'] text-[14px] font-medium">
                        Note: (This condition works)
                    </p>
                    <p class="font-['poppins'] text-[14px] font-medium">
                        If - Gross (-) HRA is greater than ₹15,000, then PF deduction will be 15,000 (*) 12%
                    </p>
                    <p class="font-['poppins'] text-[14px] font-medium">
                        else - Gross (-) HRA is lesser than ₹15,000, and PF deduction will be Gross (-) HRA (*) 12%
                    </p>

                </div>
            </div>
            <!-- buttons -->
            <div class="col-span-6 flex justify-center  items-center gap-2">
                <button
                    class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>

                <button
                    class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateEPF(), usePayroll.EPFSettings(usePayroll.epfSettings)">Save</button>
            </div>
        </div>
    </Sidebar>
    <!-- ESI SIDEBAR -->
    <Sidebar v-model:visible="esiSidebar" position="right" class=" !z-0" :style="{ width: '50vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Employee State Insurance </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="esiSidebar = false"></i>
        <div class="grid grid-cols-6 p-2 box-border">


            <!-- input fields -->
            <div class="col-span-6 flex flex-col py-2 box-border">
                <div class="flex flex-col py-2 box-border gap-2">
                    <p class="font-medium text-[16px] font-['poppins']">ESI Number<span class="text-[#C4302B]">*</span></p>

                    <InputText v-model="usePayroll.esiSettings.esi_number" placeholder="ESI Number" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[esiV$.esi_number.$error ? 'p-invalid' : '']" />
                    <span v-if="esiV$.esi_number.$error" class="font-semibold text-red-400 fs-6">
                        {{ esiV$.esi_number.$errors[0].$message }}
                    </span>

                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        State<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.esiSettings.state" :options="usePayroll.states" optionLabel="state_name"
                        optionValue="id" placeholder="Select State" :class="[esiV$.state.$error ? 'p-invalid' : '']"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12" />
                    <span v-if="esiV$.state.$error" class="font-semibold text-red-400 fs-6">
                        {{ esiV$.state.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        District<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.esiSettings.district" :options="usePayroll.districts_tn"
                        optionLabel="district_name" optionValue="id" placeholder="Select District"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[esiV$.district.$error ? 'p-invalid' : '']" />
                    <span v-if="esiV$.district.$error" class="font-semibold text-red-400 fs-6">
                        {{ esiV$.district.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Location<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.esiSettings.location" placeholder="Enter Location" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[esiV$.location.$error ? 'p-invalid' : '']" />
                    <span v-if="esiV$.location.$error" class="font-semibold text-red-400 fs-6">
                        {{ esiV$.location.$errors[0].$message }}
                    </span>

                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Deduction Cycle<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.esiSettings.esi_deduction_cycle" optionLabel="name" optionValue="id"
                        :options="usePayroll.payroll_frequency"
                        :class="[esiV$.esi_deduction_cycle.$error ? 'p-invalid' : '']" placeholder="Monthly"
                        class=" !w-[450px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium" />
                    <span v-if="esiV$.esi_deduction_cycle.$error" class="font-semibold text-red-400 fs-6">
                        {{ esiV$.esi_deduction_cycle.$errors[0].$message }}
                    </span>
                </div>


            </div>
            <!-- Example Table -->
            <div class="col-span-6 flex flex-col py-2 box-border">
                <p class="font-['poppins'] text-[16px] font-medium">Example</p>
                <p class="font-['poppins'] text-[14px] font-medium">
                    Let's assume the Gross wage is <strong>₹ 21,000.</strong> The breakup of contribution will be:
                </p>
                <div class="py-2 box-border">
                    <DataTable :value="esiSampleData">
                        <Column field="valueName" header="" class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                        <Column field="employee" header="Employee Contribution"
                            class="font-['poppins'] text-[16px] font-medium">
                        </Column>
                        <Column field="employer" header="Employer Contribution"
                            class="font-['poppins'] text-[16px] font-medium">
                        </Column>

                    </DataTable>
                </div>

            </div>
            <!-- checkbox -->
            <div class="col-span-6 py-2 box-border flex">
                <input type="checkbox" v-model="usePayroll.esiSettings.employer_contribution_in_ctc" value="1" name=""
                    class="form-check-input mr-3" id="" style="width: 20px; height: 20px;">
                <p class="font-medium text-[16px] font-['poppins']">Employers Contribution is included in the CTC</p>
            </div>
            <!-- buttons -->
            <div class="col-span-6 flex justify-center  items-center gap-2">
                <button
                    class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>

                <button
                    class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateESI(), usePayroll.ESISettings(usePayroll.esiSettings)">Save</button>
            </div>
        </div>
    </Sidebar>
    <!-- PROFESSIONAL TAX SIDEBAR -->
    <Sidebar v-model:visible="protaxSidebar" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Professional Tax </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="protaxSidebar = false"></i>
        <div class="grid grid-cols-6 p-2 box-border">
            <!-- input fields -->
            <div class="col-span-6 flex flex-col py-2 box-border">

                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        State<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.proTaxSettings.state" :options="usePayroll.states"
                        optionLabel="state_name" optionValue="id" placeholder="Select State"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[protaxV$.state.$error ? 'p-invalid' : '']" />
                    <span v-if="protaxV$.state.$error" class="font-semibold text-red-400 fs-6">
                        {{ protaxV$.state.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        District<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.proTaxSettings.district" :options="usePayroll.districts_tn"
                        optionLabel="district_name" optionValue="id" placeholder="Select District"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[protaxV$.district.$error ? 'p-invalid' : '']" />
                    <span v-if="protaxV$.district.$error" class="font-semibold text-red-400 fs-6">
                        {{ protaxV$.district.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Location<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.proTaxSettings.location" placeholder="Enter Location" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[protaxV$.location.$error ? 'p-invalid' : '']" />
                    <span v-if="protaxV$.location.$error" class="font-semibold text-red-400 fs-6">
                        {{ protaxV$.location.$errors[0].$message }}
                    </span>

                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        PT Number<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.proTaxSettings.pt_number" placeholder="PT Number" type="text"
                        class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[protaxV$.pt_number.$error ? 'p-invalid' : '']" />
                    <span v-if="protaxV$.pt_number.$error" class="font-semibold text-red-400 fs-6">
                        {{ protaxV$.pt_number.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Deduction Cycle<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.proTaxSettings.deduction_cycle" optionLabel="name" optionValue="id"
                        :options="usePayroll.payroll_frequency"
                        :class="[protaxV$.deduction_cycle.$error ? 'p-invalid' : '']" placeholder="Monthly"
                        class=" !w-[450px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium" />
                    <span v-if="protaxV$.deduction_cycle.$error" class="font-semibold text-red-400 fs-6">
                        {{ protaxV$.deduction_cycle.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <div class="col-span-6 flex flex-col py-2 box-border">
                <p class="font-['poppins'] text-[14px] font-normal">
                    The tax slabs are determined based on an employee's Half Yearly Gross Salary.
                </p>
                <div>
                    <DataTable>
                        <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header"></Column>
                    </DataTable>
                </div>
            </div>
            <!-- buttons -->
            <div class="col-span-6  flex justify-center   items-center gap-2">
                <button
                    class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>

                <button
                    class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateProTax(), usePayroll.saveprofessTaxSetting(usePayroll.proTaxSettings)">Save</button>
            </div>
        </div>
    </Sidebar>
    <!-- LOCAL WELFARE FUND SIDEBAR -->
    <Sidebar v-model:visible="localwelfare" position="right" class=" !z-0" :style="{ width: '60vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">
            Labour Welfare Fund </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer" @click="localwelfare = false"></i>
        <div class="grid grid-cols-6 p-4 box-border">
            <!-- enable/disable   -->
            <div class="col-span-6 flex flex-col ">
                <p class="font-['poppins']  text-[16px] font-semibold ">Labour Welfare Fund </p>
                <div class="grid grid-cols-6 ">
                    <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                        <div class=" d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                                v-model="usePayroll.labourWelfareFundSettings.status" name="radiobtn" id="" value="1"
                                :class="[labV$.status.$error ? 'p-invalid' : '']" />
                            <label class="ml-2  form-check-label leave_type fs-13" for="">
                                <p class="font-medium font-['poppins'] text-[16px]">Enable</p>
                            </label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                                v-model="usePayroll.labourWelfareFundSettings.status" id="" value="0"
                                :class="[labV$.status.$error ? 'p-invalid' : '']" />
                            <label class="ml-2 form-check-label leave_type fs-13" for="">
                                <p class="font-medium font-['poppins'] text-[16px]">Disable</p>
                            </label>
                        </div>
                    </div>
                    <span v-if="labV$.status.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.status.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <!-- input fields -->
            <div class="col-span-6 flex flex-col py-2 box-border">
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        LWF Number<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.labourWelfareFundSettings.lwf_number" placeholder="LWF Number"
                        type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[labV$.lwf_number.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.lwf_number.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.lwf_number.$errors[0].$message }}
                    </span>
                </div>

                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        State<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.labourWelfareFundSettings.state" :options="usePayroll.states"
                        optionLabel="state_name" optionValue="id" placeholder="Select State"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[labV$.state.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.state.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.state.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        District<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.labourWelfareFundSettings.district" :options="usePayroll.districts_tn"
                        optionLabel="district_name" optionValue="id" placeholder="Select District"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        :class="[labV$.district.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.district.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.district.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Location<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.labourWelfareFundSettings.location" placeholder="Enter Location"
                        type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[labV$.location.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.location.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.location.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Deduction Cycle<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown v-model="usePayroll.labourWelfareFundSettings.deduction_cycle"
                        :options="usePayroll.payroll_frequency" optionLabel="name" optionValue="id" placeholder="Monthly"
                        class=" !w-[450px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium"
                        :class="[labV$.deduction_cycle.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.deduction_cycle.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.deduction_cycle.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Employees Contribution<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.labourWelfareFundSettings.employees_contrib" placeholder="Enter Amount"
                        type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[labV$.employees_contrib.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.employees_contrib.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.employees_contrib.$errors[0].$message }}
                    </span>
                </div>
                <div class="flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Employers Contribution<span class="text-[#C4302B]">*</span>

                    </h5>
                    <InputText v-model="usePayroll.labourWelfareFundSettings.employer_contrib" placeholder="Enter Amount"
                        type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                        :class="[labV$.employer_contrib.$error ? 'p-invalid' : '']" />
                    <span v-if="labV$.employer_contrib.$error" class="font-semibold text-red-400 fs-6">
                        {{ labV$.employer_contrib.$errors[0].$message }}
                    </span>
                </div>
            </div>
            <!-- buttons -->
            <div class="col-span-6 flex justify-center  items-center gap-2">
                <button
                    class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>

                <button
                    class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateLabour(), usePayroll.saveLabourWelfareSettings(usePayroll.labourWelfareFundSettings)">Save</button>
            </div>
        </div>
    </Sidebar>
    <router-view></router-view>
</template>


<script setup>
import { onMounted, ref, computed } from 'vue'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

import employees_provident_fund from './employees_provident_fund/employees_provident_fund.vue'
import employees_state_insurance from './employees_state_insurance/employees_state_insurance.vue';
import abry_scheme from './abry_scheme/abry_scheme.vue'
import pmrpy_scheme from './pmrpy_scheme/pmrpy_scheme.vue'
import { usePayrollMainStore } from "../../../stores/payrollMainStore";
import { Service } from '../../../../Service/Service';
import non_pf_employees from './employees_provident_fund/non_pf_employees/non_pf_employees.vue';
// import labour_welfare_fund from './labour_fund/labour_welfare_fund.vue';
const epfSidebar = ref(false)
const esiSidebar = ref(false)
const protaxSidebar = ref(false)
const localwelfare = ref(false)
const pfTab = ref(true)
const nonpfTab = ref(false)
const activeTab = ref(1)
const service = Service()
const usePayroll = usePayrollMainStore()
const columns = [
    { field: 'startRange', header: 'Start Range' },
    { field: 'endRange', header: 'End Range' },
    { field: 'halfTaxAmt', header: 'Half Yearly Tax Amount' }
]
const sampleData = ref([
    {
        values: 'Employees Contribution',
        epf: '₹ 1800 (12% of 15000)',
        eps: '0',
        total: '₹ 1800'
    },
    {
        values: 'Employees Contribution',
        epf: '₹ 1250 (8.33% of 15000)',
        eps: '₹ 550 (3.67% of 15000 - EPS)',
        total: '₹ 1800'
    }
])
const esiSampleData = ref([

    {
        valueName: 'ESIC',
        employee: '₹ 157.5 (0.75% of 21000)',
        employer: '₹ 682.5 (3.25% of 21000)'
    },

])
// epf validation
const epfRules = computed(() => {
    return {
        is_epf_enabled: { required: helpers.withMessage('Value is Required', required) },
        epf_number: { required: helpers.withMessage('EPF Number is Required ', required) },
        epf_deduction_cycle: { required: helpers.withMessage('Date is Required', required) },
        epf_rule: { required: helpers.withMessage('Rule is Required', required) },
        epf_contribution_type: { required: helpers.withMessage('Contribution Type is Required', required) },

    }
})
const epfV$ = useValidate(epfRules, usePayroll.epfSettings)
function validateEPF() {
    epfV$.value.$validate();
    if (!epfV$.value.$error) {
        console.log('Form successfully submitted.')
        epfV$.value.$reset()
    }
    else {
        console.log('Form Validation Failed')
    }

}
//ESI VALIDATION
const esiRules = computed(() => {
    return {

        esi_number: { required: helpers.withMessage('ESI Number is Required ', required) },
        state: { required: helpers.withMessage('State is Required', required) },
        district: { required: helpers.withMessage('District is Required', required) },
        location: { required: helpers.withMessage('Location is Required', required) },
        esi_deduction_cycle: { required: helpers.withMessage('Value is Required', required) },


    }
})
const esiV$ = useValidate(esiRules, usePayroll.esiSettings)
function validateESI() {
    esiV$.value.$validate();
    if (!esiV$.value.$error) {
        console.log('Form successfully submitted.')
        esiV$.value.$reset()
    }
    else {
        console.log('Form Validation Failed')
    }
}
// PROFESSIONAL TAX VALIDATION
const protaxRules = computed(() => {
    return {

        pt_number: { required: helpers.withMessage('PT Number is Required ', required) },
        state: { required: helpers.withMessage('State is Required', required) },
        district: { required: helpers.withMessage('District is Required', required) },
        location: { required: helpers.withMessage('Location is Required', required) },
        deduction_cycle: { required: helpers.withMessage('Value is Required', required) },


    }
})
const protaxV$ = useValidate(protaxRules, usePayroll.proTaxSettings)
function validateProTax() {
    protaxV$.value.$validate()
    if (!protaxV$.value.$error) {
        console.log('Form successfully submitted.')
        protaxV$.value.$reset()
    }
    else {
        console.log('Form Validation Failed')
    }
}
//LABOUR WELFARE FUND VALIDATION
const labRules = computed(() => {
    return {

        lwf_number: { required: helpers.withMessage('LWF Number is Required ', required) },
        state: { required: helpers.withMessage('State is Required', required) },
        district: { required: helpers.withMessage('District is Required', required) },
        location: { required: helpers.withMessage('Location is Required', required) },
        deduction_cycle: { required: helpers.withMessage('Value is Required', required) },
        status: { required: helpers.withMessage('Value is Required', required) },
        employer_contrib: { required: helpers.withMessage('Employer Contribution  is Required', required) },
        employees_contrib: { required: helpers.withMessage('Employee Contribution is Required', required) }


    }
})
const labV$ = useValidate(labRules, usePayroll.labourWelfareFundSettings)
function validateLabour() {
    labV$.value.$validate()
    if (!labV$.value.$error) {
        console.log('Form successfully submitted.')
        labV$.value.$reset()
    }
    else {
        console.log('Form Validation Failed')
    }
}
onMounted(async () => {
    await usePayroll.getEPFDetails()
    await usePayroll.getNonEPFDetails()
    await usePayroll.getESIDetails()
    await usePayroll.getProfessionalTaxDetails()
    await usePayroll.getLabourWelfareDetails()
    await usePayroll.getEpfRule()
    await usePayroll.getEpfContribution()
    await usePayroll.getStateInfo()
    await usePayroll.getDistrictInfo()
    service.current_session_client_id().then((res) => {
        usePayroll.epfSettings.client_id = res.data;
        usePayroll.esiSettings.client_id = res.data;
        usePayroll.proTaxSettings.client_id = res.data;
        usePayroll.labourWelfareFundSettings.client_id = res.data;
        console.log(res.data, 'current_user_client_id sd');
    });
})
</script>
