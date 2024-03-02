<template>
    <div class="offer-letter-wrapper mt-30">
        <div class="card">
            <div class="card-body mx-5">
                <div class="no-data-wrapper text-center mx-auto col-lg-5" id="">
                    <img alt="no-data" id="" src="../images/no-data.svg" />

                    <a target="_self" id="create_offer" role="button" href="#" class="btn btn-orange"><i
                            class="fa fa-plus-circle me-1" aria-hidden="true"></i> Create Offer</a>
                </div>

                <div class="crate-offer-content" id="createOffer_content" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-6 col-lg-6 col-md-6 col-xxl-6 ">
                            <p class="text-muted fs-16 font-medium">Offer letter generation</p>
                            <p class="text-muted fs-12">(fill the basic details to generate the offer letter)</p>
                        </div>
                        <div class="col-xl-6 col-sm-6 col-lg-6 mb-2 col-md-6  col-xxl-6 text-center">
                            <p class="fs-15 font-medium mb-3 text-center">Choose the mode</p>
                            <div class="mx-auto flex gap-6 align-items-center justify-content-center">
                                <div class="form-check  me-4">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2" type="radio" name="offer-mode" id=""
                                            checked>
                                        <label class="form-check-label" for="">
                                            Normal Mode
                                        </label>
                                    </div>
                                    <span class="text-muted fs-10">(To Generate Single Offer Letter)</span>
                                </div>
                                <div class="form-check  me-4">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2" type="radio" name="offer-mode"
                                            id="">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Bulk Mode
                                        </label>
                                    </div>
                                    <span class="text-muted fs-10">(To Generate Bulk Offer Letter)</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-12  col-lg-6 col-md-6 mb-3 col-xxl-6 ">
                            <div class="normal-offer-content">
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 mb-3 col-xxl-12 ">
                                        <h6 class="text-muted fs-14 mb-2">Candidate Details</h6>
                                        <div class="card mb-2 bg-lite-gray">
                                            <div class="card-body">

                                                <div class="mb-3">
                                                    <label for="">Candiate Name</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.candidate_details.candidate_name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Mail Id</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.candidate_details.candidate_email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Mobile Number</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.candidate_details.candidate_mobile_no">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 mb-3 col-xxl-12 ">
                                        <h6 class="text-muted fs-14 mb-2">Salary Details</h6>
                                        <div class="card mb-3 bg-lite-gray">
                                            <div class="card-body">

                                                <div class="d-flex mb-4 align-items-center justify-content-center">
                                                    <div class="form-check  me-4">
                                                        <div class="d-flex align-items-center">
                                                            <input class="form-check-input me-2" type="radio"
                                                                name="structure-mode" id="" checked v-model="offer.salary_details.salary_structure">
                                                            <label class="form-check-label" for="">
                                                                4-Structure
                                                            </label>
                                                        </div>
                                                        <span class="text-muted fs-10">(To Generate Single Offer
                                                            Letter)</span>
                                                    </div>
                                                    <div class="form-check  me-4">
                                                        <div class="d-flex align-items-center">
                                                            <input class="form-check-input me-2" type="radio"
                                                                name="structure-mode" id="">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                10-Structure
                                                            </label>
                                                        </div>
                                                        <span class="text-muted fs-10">(To Generate Bulk Offer
                                                            Letter)</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 col-sm-12 col-lg-6 col-md-6 mb-3 col-xxl-6 mb-3">
                                                        <label for="">Pay (<i class="fa fa-inr"
                                                                aria-hidden="true"></i>)</label>
                                                        <input type="text" class="form-control" id=""
                                                            placeholder="" v-model="offer.salary_details.pay_in_rupee">
                                                    </div>
                                                    <div class="col-xl-6 col-sm-12 col-lg-6 col-md-6 mb-3 col-xxl-6 mb-3">
                                                        <label for="">Specification</label>
                                                        <select name="" id="" class="form-select" v-model="offer.salary_details.specification">
                                                            <option value=""></option>
                                                            <option value=""></option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Pay(In words)</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.salary_details.pay_in_words">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 mb-3 col-xxl-12 ">

                                        <h6 class="text-muted fs-14 mb-2">Role Details</h6>
                                        <div class="card bg-lite-gray">
                                            <div class="card-body">

                                                <div class="mb-3">
                                                    <label for="">Designation</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.role_details.designation">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Expected DOJ</label>
                                                    <input type="date" class="form-control" id=""
                                                        placeholder="" v-model="offer.role_details.exp_doj">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Location</label>
                                                    <input type="text" class="form-control" id=""
                                                        placeholder="" v-model="offer.role_details.location">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Offer Expiry Date</label>
                                                    <input type="Date" class="form-control" id=""
                                                        placeholder="Offer Expiry Date" v-model="offer.role_details.exp_doj">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bulk-offer-content">
                            </div>
                        </div>

                        <div class="col-xl-6 col-sm-12  col-lg-6 col-md-6 mb-3 col-xxl-6 ">
                            <div class="card mb-3 mt-4  m-auto bg-lite-gray offer-view-content">

                            <div class="flex gap-2 mx-4 my-4">
                                <p class="text-red-600 my-1">[Date,Month,Year]</p>
                                <p>[]</p>
                            </div>

                            <div class="mx-4 my-4 text-black">
                                <p v-if="offer.candidate_details.candidate_name == ''" class="text-red-600 my-1">Employeee Name</p>
                                <p  v-else class="text-red-600 my-1">{{offer.candidate_details.candidate_name}}</p>
                                <p class="text-red-600 my-1">Address line 1</p>
                                <p class="text-red-600 my-1">Address line 2</p>
                                <p class="text-red-600 my-1">[City][State][Pincode]</p>

                            </div>

                            <div class="mx-4 my-4">
                                <p v-if="offer.role_details.designation == ''" class="text-lg font-bold text-black">Subject:Appointment for post of [Designation]</p>
                                <p v-else class="text-lg font-bold text-black">Subject:Appointment for post of <strong class="text-red-600 text-2xl font-bold">{{offer.role_details.designation}}</strong></p>
                            </div>

                            <div class="mx-4 my-2">
                                <p><strong class="font-bold text-lg text-black">Commencement of employment</strong></p>
                                <p>Your employment will be effective as of [Starting date,month,year]</p>
                            </div>
                            <div class="mx-4 my-2">
                                <p><strong class="font-bold text-lg text-black">Job title</strong></p>
                                <p>Your job will be [Designation], and you will report to [Mr.][name],[supervisor][Designation]</p>
                            </div>
                            <div class="mx-4 my-2">
                                <p><strong class="font-bold text-lg text-black">Salary</strong></p>
                                <p>Your salary and other benefits will be set out in schedule 1,here to.</p>
                            </div>
                            <div class="mx-4 my-2">
                                <p><strong class="font-bold text-lg text-black">Place of posting</strong></p>
                                <p>You will be posted at [city,state],you may however be required to work at any place of business which the company has,or may later acquire.</p>
                            </div>
                            <div class="mx-4 my-2">
                                <p><strong class="font-bold text-lg text-black">Hour of Work </strong></p>
                                <p>The normal workings days are[Start day ]through [end day].You will be required to work for such hours as necessary for the proper discharge of your duties to the company.The normal workings hours are from [start] to [end] and you are</p>
                            </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-sm-12 text-end col-lg-12 col-md-12 mb-3 col-xxl-12 ">
                            <a href="/offer-letter" role="button"
                                class="btn btn-border-primary me-3">Save</a>
                            <button class="btn btn-dark me-3" @click="RequiredField=true">Preview</button>
                            <button class="btn btn-orange me-3">Send to candidate</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <Dialog :style="{ width: '50vw' }" header="Offer Letter Preview" :modal="true" v-model:visible="RequiredField">
        <div class="w-full">
            <div class="card mb-3 mt-4  m-auto bg-lite-gray offer-view-content">

            <div class="flex gap-2 mx-4 my-4">
                <p class="text-red-600 my-1">[Date,Month,Year]</p>
                <p>[]</p>
            </div>

            <div class="mx-4 my-4 text-black">
                <p v-if="offer.candidate_details.candidate_name == ''" class="text-red-600 my-1">Employeee Name</p>
                <p  v-else class="text-red-600 my-1">{{offer.candidate_details.candidate_name}}</p>
                <p class="text-red-600 my-1">Address line 1</p>
                <p class="text-red-600 my-1">Address line 2</p>
                <p class="text-red-600 my-1">[City][State][Pincode]</p>

            </div>

            <div class="mx-4 my-4">
                <p v-if="offer.role_details.designation == ''" class="text-lg font-bold text-black">Subject:Appointment for post of [Designation]</p>
                <p v-else class="text-lg font-bold text-black">Subject:Appointment for post of <strong class="text-red-600 text-2xl font-bold">{{offer.role_details.designation}}</strong></p>
            </div>

            <div class="mx-4 my-2">
                <p><strong class="font-bold text-lg text-black">Commencement of employment</strong></p>
                <p>Your employment will be effective as of [Starting date,month,year]</p>
            </div>
            <div class="mx-4 my-2">
                <p><strong class="font-bold text-lg text-black">Job title</strong></p>
                <p>Your job will be [Designation], and you will report to [Mr.][name],[supervisor][Designation]</p>
            </div>
            <div class="mx-4 my-2">
                <p><strong class="font-bold text-lg text-black">Salary</strong></p>
                <p>Your salary and other benefits will be set out in schedule 1,here to.</p>
            </div>
            <div class="mx-4 my-2">
                <p><strong class="font-bold text-lg text-black">Place of posting</strong></p>
                <p>You will be posted at [city,state],you may however be required to work at any place of business which the company has,or may later acquire.</p>
            </div>
            <div class="mx-4 my-2">
                <p><strong class="font-bold text-lg text-black">Hour of Work </strong></p>
                <p>The normal workings days are[Start day ]through [end day].You will be required to work for such hours as necessary for the proper discharge of your duties to the company.The normal workings hours are from [start] to [end] and you are</p>
            </div>

            </div>
        </div>
  </Dialog>



</template>


<script setup>
import { ref } from 'vue'
import {offer_letter} from '../offer_letter_service'


const RequiredField=ref(false)

const offer  = offer_letter()
</script>
