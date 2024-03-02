<template>
    <div class="my-4 shadow card profile-box card-top-border">
        <div class="mb-2 card-body justify-content-center align-items-center">
            <div class="p-2 my-4 form-card">

                <div class="mt-1 row">
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="client_code ">Client Code{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class=" float-label">Client Code</label>
                            <input type="text" placeholder="Client Code" name="client_code"
                                class="onboard-form form-control textbox" required
                                v-model="client_onboarding.client_code" :class="[
                                    v$.client_code.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.client_code.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.client_code.required.$message.replace("Value", "Client Code") }}
                            </span>

                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="client_name">Legal Name of the Company{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Legal Name of the Company</label>
                            <input type="text" placeholder="Legal Name of the Company" name="client_name" id="client_name"
                                class="onboard-form form-control textbox" v-model="client_onboarding.client_name"
                                required :class="[
                                    v$.client_name.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.client_name.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.client_name.required.$message.replace("Value", "Legal Name of the Company") }}
                            </span>

                            <!-- <label for="" class="float-label">Legal Name of the Company</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="csd">Contract Start Date{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class=" float-label">Contract Start Date</label>

                            <!-- <input type="text" max="9999-12-31" placeholder="Contract Start Date" name="csd"
                                class="onboard-form form-control textbox" onfocus="(this.type='date')"
                              /> -->
                                <Calendar showIcon required class="h-10 w-[250px] relative right-2"  v-model="client_onboarding.contract_start_date" :class="[
                                    v$.contract_start_date.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.contract_start_date.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.contract_start_date.required.$message.replace("Value", "Contract Start Date") }}
                            </span>
                            <!-- <label for="" class="float-label">Contract Start Date</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="ced">Contract End Date{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Contract End Date</label>
                            <!-- <input type="text" max="9999-12-31" placeholder="Contract End Date" name="ced"
                                class="onboard-form form-control textbox" onfocus="(this.type='date')"
                                /> -->
                                <Calendar showIcon required  class="h-10 w-[250px] relative right-2" v-model="client_onboarding.contract_end_date" :class="[
                                    v$.contract_end_date.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.contract_end_date.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.contract_end_date.required.$message.replace("Value", "Contract End Date") }}
                            </span>
                            <!-- <label for="" class="float-label">Contract End Date</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="cin_no">Company Identification Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Company Identification
                                Number</label>
                            <input type="text" placeholder="Company Identification Number" name="cin_no"
                                class="onboard-form form-control textbox" pattern="alp-num" required
                                v-model="client_onboarding.cin_number" :class="[
                                    v$.cin_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.cin_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.cin_number.required.$message.replace("Value", "Company Identification Number") }}
                            </span>
                            <label class="error cin_no_label" for="cin_no" style="display: none;"></label>
                            <!-- <label for="" class="float-label">Company Identification Number</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="com_tan">Company TAN{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Company TAN</label>
                            <input type="text" placeholder="Company TAN" name="com_tan"
                                class="onboard-form form-control textbox" pattern="alp-num"
                                v-model="client_onboarding.company_tan" required :class="[
                                    v$.company_tan.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.company_tan.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.company_tan.required.$message.replace("Value", "Company TAN") }}
                            </span>
                            <label class="error com_tan_label" for="com_tan" style="display: none;"></label>
                            <!-- <label for="" class="float-label">Company TAN</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="com_pan">Company PAN{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Company PAN</label>
                            <input type="text" placeholder="Company PAN" name="com_pan" id="com_pan"
                                class="onboard-form form-control textbox" pattern="alp-num" required
                                v-model="client_onboarding.company_pan" :class="[
                                    v$.company_pan.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.company_pan.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.company_pan.required.$message.replace("Value", "Company PAN") }}
                            </span>
                            <label class="error com_pan_label" for="com_pan" style="display: none;"></label>
                            <span id="pan_err" style="display: none; color: darkred;" class="text-danger">
                                Please Enter Valid Pan Number</span>
                            <!-- <label for="" class="float-label">Company PAN</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="gst_no">GST No{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">GST No</label>
                            <input type="text" placeholder="GST No" name="gst_no" class="onboard-form form-control textbox"
                                pattern="gst" required v-model="client_onboarding.gst_no" :class="[
                                    v$.gst_no.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.gst_no.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.gst_no.required.$message.replace("Value", "GST No") }}
                            </span>
                            <label class="error gst_no_label" for="gst_no" style="display: none;"></label>
                            <!-- <label for="" class="float-label">GST No</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="epf">EPF Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">EPF Registration Number</label>
                            <input type="text" placeholder="EPF Registration Number" name="epf"
                                class="onboard-form form-control textbox" pattern="alp-num"
                                v-model="client_onboarding.epf_reg_number" required :class="[
                                    v$.epf_reg_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.epf_reg_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.epf_reg_number.required.$message.replace("Value", "EPF Registration Number") }}
                            </span>
                            <label class="error epf_label" for="epf" style="display: none;"></label>
                            <!-- <label for="" class="float-label">EPF Registration Number</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="esic">ESIC Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">ESIC Registration Number</label>

                            <input type="text" placeholder="ESIC Registration Number" name="esic"
                                class="onboard-form form-control textbox" pattern="alp-num" required
                                v-model="client_onboarding.esic_reg_number" :class="[
                                    v$.esic_reg_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.esic_reg_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.esic_reg_number.required.$message.replace("Value", "ESIC Registration Number") }}
                            </span>
                            <label class="error esic_label" for="esic" style="display: none;"></label>

                            <!-- <label for="" class="float-label">ESIC Registration Number</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="professional_tax">Professional Tax Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Professional Tax Registration
                                Number</label>

                            <input type="text" placeholder="Professional Tax Registration Number" name="professional_tax"
                                class="onboard-form form-control textbox" pattern="alp-num" required
                                v-model="client_onboarding.prof_tax_reg_number" :class="[
                                    v$.prof_tax_reg_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.prof_tax_reg_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.prof_tax_reg_number.required.$message.replace("Value", "Professional Tax Registration Number") }}
                            </span>
                            <label class="error professional_tax_label" for="professional_tax"
                                style="display: none;"></label>
                            <!-- <label for="" class="float-label">Professional Tax Registration Number</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="lwf">LWF Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">LWF Registration Number</label>

                            <input type="text" placeholder="LWF Registration Number" name="lwf"
                                v-model="client_onboarding.lwf_reg_number" class="onboard-form form-control textbox"
                                pattern="alp-num" required :class="[
                                    v$.lwf_reg_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.lwf_reg_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.lwf_reg_number.required.$message.replace("Value", "LWF Registration Number") }}
                            </span>
                            <label class="error lwf_label" for="lwf" style="display: none;"></label>
                            <!-- <label for="" class="float-label">LWF Registration Number</label> -->
                        </div>
                    </div>

                    <!--  -->

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="lwf">LWF Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">ABS Client Code</label>

                            <!-- <InputMask id="basic" v-model="client_onboarding.abs_client_code" @keypress="isAbs($event)"  class="onboard-form form-control textbox" mask="ABS_CL" placeholder="ABS Client Code" :class="[
                                v$.abs_client_code.$error ? 'border border-red-500' : '',
                            ]" />
                        <span v-if="v$.abs_client_code.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.abs_client_code.required.$message.replace("Value", "ABS Client Code") }}
                        </span> -->
                        <!-- <label class="error lwf_label" for="lwf" style="display: none;"></label> -->

                            <input type="text" placeholder="ABS Client Code" name="lwf" @keypress="isAbs($event)"
                                v-model="client_onboarding.abs_client_code" class="onboard-form form-control textbox"
                                pattern="alp-num" required :class="[
                                    v$.abs_client_code.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.abs_client_code.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.abs_client_code.required.$message.replace("Value", "ABS Client Code") }}
                            </span>
                            <label class="error lwf_label" for="lwf" style="display: none;"></label>
                            <!-- <label for="" class="float-label">LWF Registration Number</label> -->
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="lwf">LWF Registration Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Client Full Name</label>

                            <input type="text" placeholder="Client Full Name" name="lwf"
                                v-model="client_onboarding.client_full_name" class="onboard-form form-control textbox"
                                pattern="alp-num" required :class="[
                                    v$.client_full_name.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.client_full_name.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.client_full_name.required.$message.replace("Value", "Client Full Name") }}
                            </span>
                            <label class="error lwf_label" for="lwf" style="display: none;"></label>
                            <!-- <label for="" class="float-label">LWF Registration Number</label> -->
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-6 col-xs-6 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="doc_uploads">Documents Upload{!! required() !!}</label> -->
                        <!-- <div class="floating"> -->
                      <label for="" class="float-label">Client Logo </label>
                        <!-- <input @change="client_onboarding_document($event)" type="file" placeholder="Documents Upload"
                            class="onboard-form form-control textbox " required
                           /> -->
                            <div class="mb-3">
                                <!-- <label for="formFile" class="form-label btn btn-primary">Upload</label> -->
                                <input class="form-control" @change="client_logo($event)" type="file"  id="formFile"   accept=".doc,.docx,.pdf,image/*" :class="[
                                    v$.client_logo.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.client_logo.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.client_logo.required.$message.replace("Value", "Document") }}
                            </span>
                              </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="shadow card profile-box card-top-border ">
        <div class="card-body justify-content-center align-items-center">
            <div class="p-2 mb-2 form-card">
                <div class="text-primary header-card-text">
                    <h6>Authorized Details</h6>
                </div>
                <div class="mt-1 row">
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="auth_person_name">Authorized Person Name{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Authorized Person Name</label>
                            <input type="text" placeholder="Authorized Person Name"   @keypress="isLetter($event)" name="auth_person_name"
                                class="onboard-form form-control textbox" pattern="alpha" required
                                v-model="client_onboarding.authorised_person_name" :class="[
                                    v$.authorised_person_name.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.authorised_person_name.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.authorised_person_name.required.$message.replace("Value", "Authorized Person Name") }}
                            </span>
                            <label class="error auth_person_name_label" for="auth_person_name"
                                style="display: none;"></label>
                            <!-- <label for="" class="float-label">Authorized Person Name</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="auth_person_desig">Authorized Person Designation{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Authorized Person
                                Designation</label>
                            <input type="text" @keypress="isLetter($event)" placeholder="Authorized Person Designation" name="auth_person_desig"
                                class="onboard-form form-control " pattern="alpha" required
                                v-model="client_onboarding.authorised_person_designation" :class="[
                                    v$.authorised_person_designation.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.authorised_person_designation.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.authorised_person_designation.required.$message.replace("Value", "Authorized Person Designation") }}
                            </span>
                            <label class="error auth_person_desig_label" for="auth_person_desig"
                                style="display: none;"></label>
                            <!-- <label for="" class="float-label">Authorized Person Designation</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="auth_person_contact">Authorized Person Contact Number{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Authorized Person Contact
                                Number</label>
                            <!-- <input type="number" minlength="10" maxlength="10"
                                placeholder="Authorized Person Contact Number" name="auth_person_contact"
                                class="onboard-form form-control textbox" required
                               /> -->
                                <InputMask class="h-10" id="basic" mask="9999999999" placeholder="999999999"   v-model="client_onboarding.authorised_person_contact_number" :class="[
                                    v$.authorised_person_contact_number.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.authorised_person_contact_number.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.authorised_person_contact_number.required.$message.replace("Value", "Authorized Person Contact Number") }}
                            </span>
                            <!-- <label for="" class="float-label">Authorized Person Contact Number</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="auth_person_email">Authorized Person Contact Email{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Authorized Person Contact
                                Email</label>
                            <input type="email" placeholder="Authorized Person Contact Email" name="auth_person_email"
                                class="onboard-form form-control textbox" required
                                v-model="client_onboarding.authorised_person_contact_mail" :class="[
                                    v$.authorised_person_contact_mail.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.authorised_person_contact_mail.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.authorised_person_contact_mail.required.$message.replace("Value", "Authorized Person Contact Email") }}
                            </span>
                            <!-- <label for="" class="float-label">Authorized Person Contact Email</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="billing_add">Billing Address{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Billing Address</label>
                            <input type="text" placeholder="Billing Address" name="billing_add"
                                class="onboard-form form-control textbox" required
                                v-model="client_onboarding.billing_address" :class="[
                                    v$.billing_address.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.billing_address.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.billing_address.required.$message.replace("Value", "Billing Address") }}
                            </span>
                            <!-- <label for="" class="float-label">Billing Address</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="shipping_add">Shipping Address{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Shipping Address</label>

                            <input type="text" placeholder="Shipping Address" name="shipping_add"
                                class="onboard-form form-control textbox" required
                                v-model="client_onboarding.shipping_address" :class="[
                                    v$.shipping_address.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.shipping_address.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.shipping_address.required.$message.replace("Value", "Shipping Address") }}
                            </span>
                            <!-- <label for="" class="float-label">Shipping Address</label> -->
                        </div>
                    </div>

                    <div class="mb-2 col-md-6 col-sm-12 col-xs-12 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="product">Product{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Select Product</label>
                            <select placeholder="Product" name="product" id="product"
                                class="form-select onboard-form form-control" required v-model="client_onboarding.product" :class="[
                                    v$.product.$error ? 'border border-red-500' : '',
                                ]" >

                                <option value="" class="text-muted" hidden selected disabled>
                                    Select
                                    Product</option>
                                <option value="Recruitment">Recruitment</option>
                                <option value="Payroll">Payroll</option>
                                <option value="Statutory Complainces">Statutory Complainces</option>
                                <option value="Staffing">Staffing</option>
                                <option value="PMS">PMS</option>
                                <option value="Accounting">Accounting</option>
                                <option value="ROC Complainces">ROC Complainces</option>
                                <option value="Trade Mark">Trade Mark</option>
                                <option value="Patent Right">Patent Right</option>
                            </select>
                            <span v-if="v$.product.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.product.required.$message.replace("Value", "Select Product") }}
                            </span>
                            <!-- <label for="" class="float-label">Select Product</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-6 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="subscription_type">Subscription Type{!! required() !!}</label> -->
                        <div class="floating">
                            <label for="" class="float-label">Subscription Type</label>
                            <select placeholder="Subscription Type" name="subscription_type" id="subscription_type"
                                v-model="client_onboarding.subscription_type" class="form-select form-control" aria-label=""
                                required :class="[
                                    v$.subscription_type.$error ? 'border border-red-500' : '',
                                ]" >

                                <option value="" disabled selected hidden>Select Subscription
                                    Type
                                </option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="BiAnnually">BiAnnually</option>
                                <option value="Annually">Annually</option>
                            </select>
                            <span v-if="v$.subscription_type.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.subscription_type.required.$message.replace("Value", "Subscription Type") }}
                            </span>
                            <!-- <label for="" class="float-label">Subscription Type</label> -->
                        </div>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-6 col-xl-3 col-lg-3 dashBoard">
                        <!-- <label class="" for="doc_uploads">Documents Upload{!! required() !!}</label> -->
                        <!-- <div class="floating"> -->
                      <label for="" class="float-label">Document </label>
                        <!-- <input @change="client_onboarding_document($event)" type="file" placeholder="Documents Upload"
                            class="onboard-form form-control textbox " required
                           /> -->
                            <div class="mb-3">
                                <!-- <label for="formFile" class="form-label btn btn-primary">Upload</label> -->
                                <input class="form-control" @change="client_onboarding_document($event)" type="file"  id="formFile"   accept=".doc,.docx,.pdf,image/*" :class="[
                                    v$.doc_uploads.$error ? 'border border-red-500' : '',
                                ]" />
                            <span v-if="v$.doc_uploads.$error" class="font-semibold text-red-400 fs-6">
                                {{ v$.doc_uploads.required.$message.replace("Value", "Document") }}
                            </span>
                              </div>
                    </div>
                    <div class="text-right col-12">

                        <button type="button" @click="submitForm" class="text-center btn btn-orange"
                            value="Submit">Submit</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <Dialog header="Header" v-model:visible="canShowLoading"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true" :closable="false"
    :closeOnEscape="false">
    <template #header>
        <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
            animationDuration="2s" aria-label="Custom ProgressSpinner" />
    </template>
    <template #footer>
        <h5 style="text-align: center">Please wait...</h5>
    </template>
    </Dialog>

</template>


<script setup>
import axios from "axios";
import { computed, inject, reactive, ref } from "vue";
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

const swal = inject("$swal");

const canShowLoading = ref(false)


const client_onboarding = reactive({
    client_code: "",
    client_name: "",
    contract_start_date: "",
    contract_end_date: "",
    cin_number: "",
    company_tan: "",
    company_pan: "",
    product:"",
    gst_no: "",
    epf_reg_number: "",
    esic_reg_number: "",
    prof_tax_reg_number: "",
    lwf_reg_number: "",
    abs_client_code:"",
    client_full_name:"",
    client_logo:"",
    authorised_person_name: "",
    authorised_person_designation: "",
    authorised_person_contact_number: "",
    authorised_person_contact_mail: "",
    billing_address: "",
    shipping_address: "",
    subscription_type:'',
    doc_uploads:""

})

const Reset = ()=>{
    client_onboarding.client_code= ""
    client_onboarding.client_name= ""
    client_onboarding.contract_start_date= ""
    client_onboarding.contract_end_date= ""
    client_onboarding.cin_number= ""
    client_onboarding.company_tan= ""
    client_onboarding.company_pan= ""
    client_onboarding.product=""
    client_onboarding.gst_no= ""
    client_onboarding.epf_reg_number= ""
    client_onboarding.esic_reg_number= ""
    client_onboarding.prof_tax_reg_number= ""
    client_onboarding.lwf_reg_number= ""
    client_onboarding.abs_client_code=""
    client_onboarding.client_full_name=""
    client_onboarding.client_logo=""
    client_onboarding.authorised_person_name= ""
    client_onboarding.authorised_person_designation= ""
    client_onboarding.authorised_person_contact_number= ""
    client_onboarding.authorised_person_contact_mail= ""
    client_onboarding.billing_address= ""
    client_onboarding.shipping_address= ""
    client_onboarding.subscription_type=''
    client_onboarding.doc_uploads=""
}


const rules = computed(() => {
    return {
        client_code: {required},
    client_name: {required},
    contract_start_date: {required},
    contract_end_date: {required},
    cin_number: {required},
    company_tan: {required},
    company_pan: {required},
    gst_no: {required},
    epf_reg_number: {required},
    esic_reg_number: {required},
    prof_tax_reg_number: {required},
    lwf_reg_number: {required},
    abs_client_code:{required},
    client_full_name:{required},
    client_logo :{required},
    authorised_person_name: {required},
    authorised_person_designation: {required},
    authorised_person_contact_number: {required},
    authorised_person_contact_mail: {required},
    billing_address: {required},
    shipping_address: {required},
    subscription_type :{required},
    doc_uploads:{required},
    product:{required}
    }
})

const v$ = useValidate(rules,client_onboarding)

const submitForm = () => {
    console.log(v$.value);
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        submit()
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}



const submit = () => {

    canShowLoading.value = true

    const config = {
        headers: { "content-type": "multipart/form-data" },
    };

    let formData = new FormData();

    formData.append('client_name', client_onboarding.client_name)
    formData.append('client_code', client_onboarding.client_code)
    formData.append('contract_start_date', client_onboarding.contract_start_date)
    formData.append('contract_end_date', client_onboarding.contract_end_date)
    formData.append('cin_number', client_onboarding.cin_number)
    formData.append('company_tan', client_onboarding.company_tan)
    formData.append('company_pan', client_onboarding.company_pan)
    formData.append('gst_no', client_onboarding.gst_no)
    formData.append('epf_reg_number', client_onboarding.epf_reg_number)
    formData.append('esic_reg_number', client_onboarding.esic_reg_number)
    formData.append('prof_tax_reg_number', client_onboarding.prof_tax_reg_number)
    formData.append('lwf_reg_number', client_onboarding.lwf_reg_number)
    formData.append('abs_client_code', client_onboarding.abs_client_code)
    formData.append('client_full_name', client_onboarding.client_full_name)
    formData.append('client_logo', client_onboarding.client_logo)
    formData.append('authorised_person_name', client_onboarding.authorised_person_name)
    formData.append('authorised_person_designation', client_onboarding.authorised_person_designation)
    formData.append('authorised_person_contact_number', client_onboarding.authorised_person_contact_number)
    formData.append('authorised_person_contact_email', client_onboarding.authorised_person_contact_mail)
    formData.append('billing_address', client_onboarding.billing_address)
    formData.append('shipping_address', client_onboarding.shipping_address)
    formData.append('doc_uploads', client_onboarding.doc_uploads)
    formData.append('subscription_type', client_onboarding.subscription_type)

    console.log(formData);

    axios.post('vmt_clientOnboarding', formData,config).then(res => {
        console.log("onboarding successfully");
        if (res.data.status == "success") {
                Swal.fire({
                    title: res.data.status = "success",
                    text: res.data.message,
                    // "Salary Advance Succesfully",
                    icon: "success",
                }).then((res) => {
                    Reset();
                })
            }
            else {
                Swal.fire({
                    title: res.data.status = "failure",
                    text: res.data.message,
                    // "Salary Advance Succesfully",
                    icon: "error",
                    showCancelButton: false,
                }).then((res) => {
                    // blink_UI.value = res.data.data;
                    Reset();
                })
            }
    }).catch(err => console.log(err)).finally(() => {
        canShowLoading.value = false
    })

}



const client_onboarding_document = (e) => {
  // Check if file is selected
  if (e.target.files && e.target.files[0]) {
    client_onboarding.doc_uploads = e.target.files[0]
    console.log(client_onboarding.doc_uploads);
  }
};

const client_logo = (e) => {
  // Check if file is selected
  if (e.target.files && e.target.files[0]) {
    client_onboarding.client_logo = e.target.files[0]
    console.log(client_onboarding.client_logo);
  }
};

const isAbs = (e)=> {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if(/^[ABS{3}_CL{2} 0-9]+$/.test(char)) return true; // Match with regex
  else e.preventDefault(); // If not match, don't add to input text
}

const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}
// const isEmail = (e) => {
//     let char = String.fromCharCode(e.keyCode); // Get the character
//     if ( /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(char)) return true; // Match with regex


//     else e.preventDefault(); // If not match, don't add to input text
// }

// function lettersStartWithABS (){


// }

</script>

<style>
.swal2-success-line-tip{
    left: .3rem !important;
}
.swal2-success-line-long{
    left: 1rem !important;
}
.swal2-x-mark-line-left{
left: 0 !important;
}
.swal2-x-mark-line-right{
right: 0 !important;
}
</style>
<!-- right: 2.6rem !important; -->
