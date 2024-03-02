<template>
    <div class="p-2 my-6 mb-0 " v-if="service.mandatoryDocuments">
        <div class=" justify-content-center align-items-center">
            <div class="flex header-card-text">
                <h6  class="my-2 text-lg font-semibold"><i class="fa fa-file-image-o" aria-hidden="true"></i> Personal Documents </h6>
            </div>
            <div class="mb-2 form-card">
                <div class="mt-1 row"  >
                    <!-- v-if="service.mandatoryDocuments[0].document_name=='Aadhar Card Front' &&  service.mandatoryDocuments[0].is_mandatory === 0 " -->
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[0].document_name=='Aadhar Card Front' && service.mandatoryDocuments[0].is_mandatory==1"  >
                      
                        <p class=" text-[#000]"></p>
                        <!-- ,application/pdf -->
                        <!-- {{ service }} -->
                        <label for="" class="float-label">Aadhar Card Front<span class="text-danger"   >*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" ref="AadharCardFront"
                            id="formFile" class="onboard-form form-control file"
                            @change="service.getPersonalDocuments($event, 'AadharFront')" />
                        <span v-if="v$.AadharCardFront.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.AadharCardFront.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>


                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" id="aadhar_card_backend_content" v-if="service.mandatoryDocuments[1].document_name=='Aadhar Card Back' && service.mandatoryDocuments[1].is_mandatory==1" >
                        <label for="" class="float-label">
                            Aadhar Card Back<span class="text-danger">*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" ref="AadharCardBack"
                            @change="service.getPersonalDocuments($event, 'AadharBack')"
                            class="onboard-form form-control file" />
                        <span v-if="v$.AadharCardBack.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.AadharCardBack.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>


                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[2].document_name=='Pan Card' && service.mandatoryDocuments[2].is_mandatory==1" >
                        <!-- application/pdf -->
                        <label for="" class="float-label">
                            Pan Card<span class="text-danger">*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" placeholder="Pan Card"
                            name="pan_card_file" id="pan_card_file" ref="PanCardDoc"
                            @change="service.getPersonalDocuments($event, 'Pancard')"
                            class="onboard-form form-control file" />
                        <span v-if="v$.PanCardDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.PanCardDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>


                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[3].document_name=='Passport' && service.mandatoryDocuments[3].is_mandatory==1">
                        <label for="" class="float-label"> Passport<span class="text-danger"   >*</span></label>

                        <input type="file" accept="image/png, image/gif, image/jpeg,application/pdf" ref="PassportDoc"
                            placeholder="Passport" name="passport_file" id="passport_file"
                            @change="service.getPersonalDocuments($event, 'Passport')"
                            class="onboard-form form-control file" />
                        <span v-if="v$.PassportDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.PassportDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[4].document_name=='Voter ID' && service.mandatoryDocuments[4].is_mandatory==1">
                        <label for="" class="float-label">Voter ID<span class="text-danger"   >*</span></label>

                        <input type="file" accept="image/png, image/gif, image/jpeg,application/pdf" ref="VoterIdDoc"
                            placeholder="Voters ID" name="voters_id_file" id="voters_id_file"
                            @change="service.getPersonalDocuments($event, 'VoterId')"
                            class="onboard-form form-control file" />
                        <span v-if="v$.VoterIdDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.VoterIdDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>
                    </div>
                    <div class="mb-2 col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[5].document_name=='Driving License' && service.mandatoryDocuments[5].is_mandatory==1">
                        <label for="" class="float-label"> Driving License<span class="text-danger"   >*</span></label>

                        <input type="file" accept="image/png, image/gif, image/jpeg,application/pdf"
                            placeholder="Driving License" name="dl_file" id="dl_file"
                            @change="service.getPersonalDocuments($event, 'DrivingLicense')" ref="DrivingLicenseDoc"
                            class="onboard-form form-control file" />
                        <span v-if="v$.DrivingLicenseDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.DrivingLicenseDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6"  v-if="service.mandatoryDocuments[6].document_name=='Education Certificate' && service.mandatoryDocuments[6].is_mandatory==1">
                        <label for="" class="float-label">Educations Certificate<span class="text-danger"   >*</span>
                            <!-- <span class="text-danger">*</span> -->
                        </label>
                        <input type="file" accept="image/png, image/gif, image/jpeg,application/pdf"
                            placeholder="Educations Certificate" name="education_certificate_file"
                            @change="service.getPersonalDocuments($event, 'EducationCertificate')"
                            id="education_certificate_file" ref="EductionDoc" class="onboard-form form-control file " />
                        <span v-if="v$.EductionDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.EductionDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>


                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6" v-if="service.mandatoryDocuments[7].document_name=='Relieving Letter' && service.mandatoryDocuments[7].is_mandatory==1">
                        <label for="" class="float-label"> Relieving Letter<span class="text-danger"   >*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg,application/pdf"
                            placeholder="Relieving Letter" name="reliving_letter_file" id="reliving_letter_file"
                            @change="service.getPersonalDocuments($event, 'RelievingLetter')" ref="ReleivingLetterDoc"
                            class="onboard-form form-control file" />
                        <span v-if="v$.RelievingLetterDoc.$error" class="font-semibold text-red-400 fs-6">
                            {{ v$.RelievingLetterDoc.$errors[0].$message }}
                        </span>
                        <span class="text-sm text-gray-500">Accepted file types - JPEG, PNG and Maximum file size is -1MB</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="text-right col-12">
                    <!-- <input type="button" value="sample" @click="service.Sampledata"
                        class="mr-4 text-center btn btn-orange processOnboardForm" /> -->

                    <!-- <input class="btn btn-orange" type="button" value="check" @click="service.compensatoryCalWhileQuick"> -->

                    <button type="button" data="row-6" next="row-6" placeholder="" name="save_form" id="save_button"
                        class="mr-4 text-center btn btn-orange processOnboardForm" value="button"
                        @click="service.submitForm(0)">
                        Save
                    </button>

                    <button type="button" data="row-6" next="row-6" placeholder="" name="submit_form" id="msform"
                        class="text-center btn btn-orange processOnboardForm" value="button" @click="service.submitForm(1)">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { useNormalOnboardingMainStore } from '../stores/NormalOnboardingMainStore';


const service = useNormalOnboardingMainStore()

import useValidate from '@vuelidate/core'

const v$ = useValidate(service.rules, service.employee_onboarding);



</script>


<style>
#custom-button
{
    padding: 5px;
    color: white;
    background-color: #00b28f;
    border: 1px solid #000;
    border-radius: 5px;
    cursor: pointer;
}

#custom-button:hover
{
    background-color: #00b28f;
}

#custom-text
{
    margin-left: 10px;
    font-family: sans-serif;
    color: #aaa;
}</style>

