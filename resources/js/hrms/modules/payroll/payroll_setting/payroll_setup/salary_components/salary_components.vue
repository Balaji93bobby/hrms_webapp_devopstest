<template>
        <div class=" w-full">
            <div class="p-3">
              <div class="grid grid-cols-7">
                <ul class="my-4 nav nav-pills nav-tabs-dashed col-span-5 " role="tablist">
                    <li class="nav-item text-muted" role="presentation">
                        <button @click="activeSalTab=1" class="pb-2 nav-link active" id="pills-offer-pending-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-pending" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true"> EARNINGS</button>
                    </li>
                    <li class="mx-4 nav-item text-muted " role="presentation">
                        <button @click="activeSalTab=2"  class="pb-2 nav-link" id="pills-offer-completed-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-completed" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">ADHOC COMPONENTS</button>
                    </li>
                    <li class="nav-item text-muted" role="presentation">
                        <button @click="activeSalTab=3" class="pb-2 nav-link" id="pills-offer-resent-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-resent" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">REIMBURSEMENT</button>
                    </li>
                    <li class="mx-4 nav-item tex------t-muted" role="presentation">
                        <button @click="activeSalTab=4"  class="pb-2 nav-link" id="pills-offer-resen-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-resen" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">ACCOUNTING CODE</button>
                    </li>
                </ul>
                <!-- {{ activeSalTab }} -->
                <div class="col-span-2  items-center flex justify-end">
                    <button v-if="[1,3].includes(activeSalTab)" class="font-medium border-[1px] border-[#dddd] !w-[196px] h-[36px] rounded-[4px] font-['poppins'] text-[#000] bg-[#fff] text-[16px] flex justify-center items-center gap-2" @click="activeSalTab==1?addComponentSideBar=true :activeSalTab==3?reimSideBar=true:''"><i class="pi pi-plus " ></i>Add Component</button>
                </div>
              </div>
            


                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-offer-pending" role="tabpanel"
                        aria-labelledby="pills-offer-pending-tab">
                        <div class="card-body">
                            <div class="offer-pending-content">
                                <earings />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="pills-offer-completed" role="tabpanel"
                        aria-labelledby="pills-offer-completed-tab">
                        <div class="card-body">
                            <div class="my-4 offer-pending-content">
                                <adhoc_componentsVue />
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade " id="pills-offer-resent" role="tabpanel"
                        aria-labelledby="pills-offer-resent-tab">
                        <div class="card-body">
                            <div class="offer-pending-content">
                                <reimbursement />

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="pills-offer-resen" role="tabpanel"
                        aria-labelledby="pills-offer-resen-tab">
                        <div class="card-body">
                            <div class="offer-pending-content">
                                <!-- <accounting_code /> -->
                                <external_app_integrations/>
                            </div>
                        </div>
                    </div>
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
      <!-- EARNING SIDEBAR -->
      <Sidebar v-model:visible="addComponentSideBar" position="right" class=" !z-0" :style="{ width: '50vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">Add Component  </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer"
            @click="addComponentSideBar = false"></i>
            <div class="grid grid-cols-6 p-4 box-border">
                <div class=" col-span-6 flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Category<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <Dropdown :options="usePayroll.categoryVal"
                    optionLabel="name" optionValue="id" v-model="usePayroll.salaryComponents.category_id"
                     placeholder="Select the Category" class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                     :class="[earnV$.category_id.$error ? 'p-invalid' : '']"  />
                     <span v-if="earnV$.category_id.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.category_id.$errors[0].$message }}
                    </span>
                </div>
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Component Type<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <Dropdown :options="usePayroll.compType"
                    optionLabel="name" optionValue="id" v-model="usePayroll.salaryComponents.typeOfComp"
                     placeholder="Select Component Type" class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                     :class="[earnV$.typeOfComp.$error ? 'p-invalid' : '']"   />
                     <span v-if="earnV$.typeOfComp.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.typeOfComp.$errors[0].$message }}
                    </span>
                </div>
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Component Nature<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <Dropdown v-model="usePayroll.salaryComponents.nature_id"
                    optionLabel="name" optionValue="id" :options="usePayroll.compNature"
                     placeholder="Component Nature" class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                     :class="[earnV$.nature_id.$error ? 'p-invalid' : '']"   />
                     <span v-if="earnV$.nature_id.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.nature_id.$errors[0].$message }}
                    </span>
                </div>
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Name of the Component<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <InputText v-model="usePayroll.salaryComponents.name" placeholder="Enter Component Name" type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" 
                    :class="[earnV$.name.$error ? 'p-invalid' : '']"    />
                    <span v-if="earnV$.name.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.name.$errors[0].$message }}
                    </span>
                </div>
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Type of Calculation<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <Dropdown :options="usePayroll.calcType"
                    optionLabel="name" optionValue="id" v-model="usePayroll.salaryComponents.typeOfCalc"
                     placeholder="Flat Amount" class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12" 
                     :class="[earnV$.typeOfCalc.$error ? 'p-invalid' : '']" />
                     <span v-if="earnV$.typeOfCalc.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.typeOfCalc.$errors[0].$message }}
                    </span>
                </div>
                <div  class=" col-span-6  flex flex-col py-2 box-border " v-if="usePayroll.salaryComponents.typeOfCalc==1" >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Enter the Amount<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <InputText v-model="usePayroll.salaryComponents.calcValue" placeholder="Enter Amount" type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]"
                    :class="[earnV$.calcValue.$error ? 'p-invalid' : '']"    />
                    <span v-if="earnV$.calcValue.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.calcValue.$errors[0].$message }}
                    </span>
                </div>
                <div  class=" col-span-6  flex flex-col py-2 box-border " v-if="usePayroll.salaryComponents.typeOfCalc==2" >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Enter the Percentage<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <div class="relative">
                        <i class="pi pi-percentage absolute right-[51%] bottom-4 text-[#918888] "></i>
                        <InputText v-model="usePayroll.salaryComponents.calcValue" placeholder="Enter Percentage" type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" 
                        :class="[earnV$.calcValue.$error ? 'p-invalid' : '']"    />
                        <span v-if="earnV$.calcValue.$error" class="font-semibold text-red-400 fs-6">
                            {{ earnV$.calcValue.$errors[0].$message }}
                        </span>
                    </div>    
                </div>
                <div class="col-span-6 flex flex-col py-2 box-border ">
                   <!-- Taxability -->
                    <div class="grid grid-cols-6">
                    <div class="col-span-1 flex justify-center items-center">
                        <p class=" font-['poppins'] text-[16px] font-medium">Taxability<span class="text-[#C4302B]">*</span>
                        </p>

                    </div>
                    <div class="col-span-3 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                        <div class=" d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio" name="radiobtn"
                                id="" value="1" v-model="usePayroll.salaryComponents.isTaxable"
                                :class="[earnV$.isTaxable.$error ? 'p-invalid' : '']"    />
                            <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Yes</p></label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                                id="" value="0" v-model="usePayroll.salaryComponents.isTaxable"
                                :class="[earnV$.isTaxable.$error ? 'p-invalid' : '']"   />
                            <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">No</p></label>
                        </div>
                    </div> 
                      
                    </div>
                    <span v-if="earnV$.isTaxable.$error" class="font-semibold text-red-400 fs-6">
                        {{ earnV$.isTaxable.$errors[0].$message }}
                    </span> 
                    <!-- status -->
                    <div class="grid grid-cols-6">
                        <div class="col-span-1 flex justify-center items-center">
                            <p class=" font-['poppins'] text-[16px] font-medium">Status<span class="text-[#C4302B]">*</span>
                            </p>

                        </div>
                        <div class="col-span-3 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                            <div class=" d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio" name="radiobtn1"
                                    id="" value="1" v-model="usePayroll.salaryComponents.status"
                                    :class="[earnV$.status.$error ? 'p-invalid' : '']"    />
                                <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Enable</p></label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1"
                                    id="" value="0" v-model="usePayroll.salaryComponents.status"
                                    :class="[earnV$.status.$error ? 'p-invalid' : '']"  />
                                <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Disable</p></label>
                            </div>
                        </div> 
                           
                        </div>
                        <span v-if="earnV$.status.$error" class="font-semibold text-red-400 fs-6">
                            {{ earnV$.status.$errors[0].$message }}
                        </span> 
                    <!-- consider for epf -->
                    <div class="grid grid-cols-6">
                        <div class="col-span-2 flex justify-center items-center">
                            <p class=" font-['poppins'] text-[16px] font-medium">Considered for EPF<span class="text-[#C4302B]">*</span>
                            </p>

                        </div>
                        <div class="col-span-3 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                            <div class=" d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio" name="radiobtn2"
                                    id="" value="1" v-model="usePayroll.salaryComponents.isConsiderForEPF"
                                    :class="[earnV$.isConsiderForEPF.$error ? 'p-invalid' : '']"/>
                                <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Yes</p></label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1"
                                    id="" value="0" v-model="usePayroll.salaryComponents.isConsiderForEPF"
                                    :class="[earnV$.isConsiderForEPF.$error ? 'p-invalid' : '']"  />
                                <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">No</p></label>
                            </div>
                        </div> 
                           
                        </div>
                        <span v-if="earnV$.isConsiderForEPF.$error" class="font-semibold text-red-400 fs-6">
                            {{ earnV$.isConsiderForEPF.$errors[0].$message }}
                        </span>
                    <!-- consider for esi -->
                    <div class="grid grid-cols-6">
                        <div class="col-span-2 flex justify-center items-center">
                            <p class=" font-['poppins'] text-[16px] font-medium">Considered for ESI<span class="text-[#C4302B]">*</span>
                            </p>

                        </div>
                        <div class="col-span-3 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                            <div class=" d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio" name="radiobtn3"
                                    id="" value="1" v-model="usePayroll.salaryComponents.isConsiderForESI"
                                    :class="[earnV$.isConsiderForESI.$error ? 'p-invalid' : '']" />
                                <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Yes</p></label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn3"
                                    id="" value="0" v-model="usePayroll.salaryComponents.isConsiderForESI"
                                    :class="[earnV$.isConsiderForESI.$error ? 'p-invalid' : '']" />
                                <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">No</p></label>
                            </div>
                        </div>   
                        
                        </div>
                        <span v-if="earnV$.isConsiderForESI.$error" class="font-semibold text-red-400 fs-6">
                            {{ earnV$.isConsiderForESI.$errors[0].$message }}
                        </span> 
                    <!-- checkboxes -->
                    <div class="grid grid-cols-6 py-2 box-border">
                        <div class="col-span-6 flex py-2 box-border">
                            <input value="1" v-model="usePayroll.salaryComponents.isPartOfEmpSalStructure" type="checkbox" name="" class="form-check-input mr-3" id=""
                        style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">Make this earning a part of the employee's salary structure</p>
                        </div>
                        <!-- <div class="col-span-6 flex py-2 box-border">
                            <input type="checkbox" name="" class="form-check-input mr-3" id=""
                        style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">This salary component is taxable</p>
                        </div> -->
                        <div class="col-span-6 flex py-2 box-border">
                            <input value="1" v-model="usePayroll.salaryComponents.isCalcShowProBasis" type="checkbox" name="" class="form-check-input mr-3" id=""
                        style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">Calculate on pro-rate basis</p>
                        </div>
                        <div class="col-span-6 flex py-2 box-border">
                            <input value="1" v-model="usePayroll.salaryComponents.isShowInPayslip" type="checkbox" name="" class="form-check-input mr-3" id=""
                        style="width: 20px; height: 20px;">
                        <p class="font-medium text-[16px] font-['poppins']">Show the component in payslip</p>
                        </div>
                    </div>                           
                </div>
                <!-- buttons -->
                <div class="col-span-6 flex justify-center  items-center gap-2">
                    <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                    
                    <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateEarn(),usePayroll.saveEarningSalary(usePayroll.salaryComponents)"
                    >Save</button>
                </div>
            </div>
    </Sidebar>
    <!-- REIMBURSEMENT SIDEBAR -->
    <Sidebar v-model:visible="reimSideBar" position="right" class=" !z-0" :style="{ width: '50vw !important' }">
        <h2 class="font-['poppins']  text-[#ffff] text-[16px] font-semibold absolute top-0 p-4 left-0 bg-[#000] w-[100%]">Add New Component  </h2>
        <i class="pi pi-times top-4 right-4 absolute p-2 text-blue-200  cursor-pointer"
            @click="reimSideBar = false"></i>
            <div class="grid grid-cols-6 p-4 box-border">
                
                
               
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Name of the Component<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <InputText v-model="usePayroll.reimbursementComponents.comp_name" placeholder="Enter Component Name" type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" 
                    :class="[reimV$.comp_name.$error ? 'p-invalid' : '']"   />
                    <span v-if="reimV$.comp_name.$error" class="font-semibold text-red-400 fs-6">
                        {{ reimV$.comp_name.$errors[0].$message }}
                    </span>
                </div>
                
                <div class=" col-span-6  flex flex-col py-2 box-border " >
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Enter Maximum Amount<span class="text-[#C4302B]">*</span>
                        
                    </h5>
                    <InputText v-model="usePayroll.reimbursementComponents.reimburst_max_limit" placeholder="Enter Amount" type="text" class=" border-[1px] w-[300px] h-[40px] p-3 box-border rounded-[4px]" 
                    :class="[reimV$.reimburst_max_limit.$error ? 'p-invalid' : '']"   />
                    <span v-if="reimV$.reimburst_max_limit.$error" class="font-semibold text-red-400 fs-6">
                        {{ reimV$.reimburst_max_limit.$errors[0].$message }}
                    </span>
                </div>
                <div class=" col-span-6 flex flex-col py-2 box-border ">
                    <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                        Reimbursement Period<span class="text-[#C4302B]">*</span>

                    </h5>
                    <Dropdown optionLabel="name" optionValue="id" :options='usePayroll.payroll_frequency'
                        placeholder="Monthly" v-model="usePayroll.reimbursementComponents.category_id"
                        class=" !w-[450px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12 text-[16px] font-['poppins'] font-medium"
                        :class="[reimV$.category_id.$error ? 'p-invalid' : '']" />
                        <span v-if="reimV$.category_id.$error" class="font-semibold text-red-400 fs-6">
                            {{ reimV$.category_id.$errors[0].$message }}
                        </span>
                </div>
                <!-- <div class="grid grid-cols-6">
                    <div class="col-span-6 flex justify-center items-center">
                        <p class=" font-['poppins'] text-[16px] font-medium">Status<span class="text-[#C4302B]">*</span>
                        </p>

                    </div>
                    <div class="col-span-6 flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                        <div class=" flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio" name="radiobtn1"
                                id="" value="1" v-model="usePayroll.reimbursementComponents.status"
                                :class="[reimV$.status.$error ? 'p-invalid' : '']"   />
                            <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Enable</p></label>
                        </div>
                        <div class="flex justify-content-between align-items-center ">
                            <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1"
                                id="" value="0" v-model="usePayroll.reimbursementComponents.status"
                                :class="[reimV$.status.$error ? 'p-invalid' : '']" />
                            <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Disable</p></label>
                        </div>
                    </div> 
                    
                    </div> -->
                    <div class=" col-span-6 flex flex-col py-2 box-border ">
                        <h5 class="my-2 font-medium font-['poppins'] text-[16px]">
                            Status<span class="text-[#C4302B]">*</span>
                        </h5>
                        <div class="flex flex-row gap-3">
                            <div class="">
                                <input style="height: 20px; width: 20px; " class="form-check-input" type="radio" name="radiobtn1"
                                    id="" value="1" v-model="usePayroll.reimbursementComponents.status"
                                    :class="[reimV$.status.$error ? 'p-invalid' : '']"   />
                                <label class="ml-2  form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Enable</p></label>
                            </div>
                            <div class=" ">
                                <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn1"
                                    id="" value="0" v-model="usePayroll.reimbursementComponents.status"
                                    :class="[reimV$.status.$error ? 'p-invalid' : '']" />
                                <label class="ml-2 form-check-label leave_type fs-13" for=""><p class="font-medium font-['poppins'] text-[16px]">Disable</p></label>
                            </div>
                        </div>
                        <span v-if="reimV$.status.$error" class="font-semibold text-red-400 fs-6">
                            {{ reimV$.status.$errors[0].$message }}
                        </span>
                    </div>
                   
                <!-- buttons -->
                <div class="col-span-6 flex justify-center my-4 items-center gap-2">
                    <button class="bg-[#fff] rounded-[4px] w-[100px] h-[30px] text-[#000] text-[16px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]">Cancel</button>
                    
                    <button class="bg-[#000]  text-[#fff] text-[16px]  w-[100px] h-[30px] font-['poppins'] font-medium border-[#e6e6e6] border-[1px]"
                    @click="validateReim(),usePayroll.saveReimbursement(usePayroll.reimbursementComponents)">Save</button>
                </div>
            </div>
    </Sidebar>
</template>


<script setup>
import { onMounted,ref,computed } from 'vue'
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

import earings from './earings/earings.vue';
// import adhoc_componentsVue from './adhoc_components/adhoc_components.vue';
import reimbursement from './reimbursement/reimbursement.vue';
// import external_app_integrations from 'resources/js/hrms/modules/external_integrations/external_app_integrations.vue'
import external_app_integrations from '../../../../external_integrations/external_app_integrations.vue'
import { usePayrollMainStore } from '../../../stores/payrollMainStore';
import { usePayrollHelper } from '../../../stores/payrollHelper';

const usePayroll = usePayrollMainStore()
const helper = usePayrollHelper()
const activeSalTab=ref(1)
const addComponentSideBar=ref(false)
const reimSideBar=ref(false)

// earning form validation
const earnRules=computed(()=>{
    return{
        category_id:{required:helpers.withMessage('Category is Required',required)},
        typeOfComp:{required:helpers.withMessage('Component Type is Required',required)},
        nature_id:{required:helpers.withMessage('Component Nature is Required',required)},
        name:{required:helpers.withMessage('Component Name is Required',required)},
        typeOfCalc:{required:helpers.withMessage('Calculation Type is Required',required)},
        calcValue:{required:helpers.withMessage('Value is Required',required)},
        isTaxable:{required:helpers.withMessage('Value is Required',required)},
        status: {required:helpers.withMessage('Status is Required',required)},
        isConsiderForEPF: {required:helpers.withMessage('Value is Required',required)},
        isConsiderForESI: {required:helpers.withMessage('Value is Required',required)},
    }
})
const earnV$=useValidate(earnRules,usePayroll.salaryComponents)
function validateEarn()
{
   earnV$.value.$validate();
    if(!earnV$.value.$error)
    {
        console.log('Form successfully submitted.')
       earnV$.value.$reset()
    }
    else
    {
        console.log('Form Validation Failed')
    }
}
// reimbursement form validation
const reimbursementRules=computed(()=>{
    return{
        category_id:{required:helpers.withMessage('Reimbursement Period is Required',required)},
        comp_name:{required:helpers.withMessage('Component Name is Required',required)},
        status: {required:helpers.withMessage('Status is Required',required)},
        reimburst_max_limit:{required:helpers.withMessage('Amount is Required',required)},

         }
})
const reimV$=useValidate(reimbursementRules,usePayroll.reimbursementComponents)
function validateReim()
{
    reimV$.value.$validate();
    if(!reimV$.value.$error)
    {
        console.log('Form successfully submitted.')
        reimV$.value.$reset()
    }
    else
    {
        console.log('Form Validation Failed')
    }
}
onMounted(async()=>{
    await usePayroll.getSalarySidebar()
    await usePayroll.getPayFreqData()
    await usePayroll.getsalaryDetails()
})
</script>
