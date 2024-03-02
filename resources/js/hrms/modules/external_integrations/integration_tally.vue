<template>
    <div class="grid grid-cols-6">
        <!-- tally erp -->
        <div class="col-span-6  gap-3 px-3 py-1 box-border ">
            <div class="flex justify-between ">
                <div  class="col-span-6">
                <p class="font-semibold text-start text-[16px] font-['poppins']">Tally ERP</p>
                <p class="font-normal text-[14px] font-['poppins'] ">This section provides you with the opportunity to assign the appropriate accounting codes, which are used for accounting and auditing purposes within your organization, to both recurring and adhoc components</p>
                </div>
               <!-- <div class="col-span-1 flex justify-center items-center">
                <button class=" bg-[#FFFFFF] text-[13px] rounded-full gap-2 text-[#000] !w-[70px] h-[32px] pl-2 box-border font-semibold flex justify-center items-center font-['poppins']">Back <i class="mr-2 pi pi-angle-right"></i>
                </button>
               </div> -->
            </div>

        </div>
        <!-- legal entity -->
        <div class="col-span-6 flex flex-col px-3 py-2 box-border gap-3">
           <div class="flex flex-col gap-2 col-span-6">
            <p class="font-medium text-start text-[14px] font-['poppins'] ">Legal Entity<span class="text-[#e71010]">*</span></p>
            <Dropdown  v-model="useTally.vm_tally_integration.selected_legal_entity" optionLabel="client_fullname" optionValue="client_code" :options="useTally.clients_list"
            placeholder="Select Legal Entity" class=" !w-[300px] md:w-[230px] h-10" 
            :class="[legalentityV$.selected_legal_entity.$error ? 'p-invalid' : '',]" />
            <span v-if="legalentityV$.selected_legal_entity.$error" class="font-semibold text-red-400 fs-6">
                {{ legalentityV$.selected_legal_entity.$errors[0].$message }}
            </span>
           </div>
           <div class="grid grid-cols-6">
            <div class="col-span-6 mb-2 gap-3 flex ">
                <!-- <p class="text-start text-[#000] font-normal text-[12px] font-['poppins'] ">ccfccvv5656VGJVJHVHhgvgvghVHGVHGChch8997&nbsp;&nbsp;
                    <button>   <i v-tooltip="tooltip_txt" class="mr-2 pi pi-clone text-[#CCCCCC]"></i></button>
                </p>         -->
                <!-- <Password v-model="value" toggleMask  value="ccfccvv5656VGJVJHVHhgvgvghVHGVHGChch8997"/> -->
                <input type="password" readonly  id="apiKeyValue" v-model="useTally.vm_tally_integration.generated_access_token" class="bg-transparent border-none w-[320px] text-[#000] font-normal text-[12px] font-['poppins'] "/>
                <button @click="showAPIKey()"><i class="pi pi-eye"></i></button>
                <button>   <i v-tooltip="tooltip_txt" class="mr-2 pi pi-clone text-[#CCCCCC]"></i></button>

            </div>
            <div class="col-span-1">
                <button
                @click="validateLegalEntity(),useTally.generateAPIKey()"
                class=" bg-[#0873CD] text-[15px] rounded-md text-[#fff] !w-[170px] h-[35px] font-semibold flex justify-center items-center font-['poppins'] ">Generate API Key</button>
            </div>

           </div>
           <div>
            <p><span class="text-[#B20000] font-semibold text-[14px] font-['poppins']">Note :</span>
            <span class="text-[#535353] font-normal text-[14px] font-['poppins']">&nbsp;Generate API Key above and fill in the Tally software to connect.</span>
            </p>
           </div>
           <div class="grid grid-cols-6 bg-[#ffff]">
            <div class="col-span-4 flex  p-2 box-border gap-2">
                <Dropdown  optionLabel="value" optionValue="value"
                placeholder="Select Cost Boooking Nature" class="bg-[#E6E6E6] text-[#000] text-normal text-[12px] !w-[240px] md:w-[230px] h-[36px] font-['poppins']"  />
                <Dropdown  optionLabel="value" optionValue="value"
                placeholder="Select Cost Booking Bifurcation" class="bg-[#E6E6E6] text-normal text-[12px] !w-[260px] md:w-[230px] h-[36px]"  />
                <Dropdown  optionLabel="value" optionValue="value"
                placeholder="Select Components" class="bg-[#E6E6E6] text-normal text-[12px]  !w-[198px] md:w-[230px] h-[36px]"  />
            </div>
            <div class="col-span-2 flex justify-end p-2 box-border">
                <button class=" bg-[#E6E6E6] text-[13px] rounded-lg gap-2 text-[#000] !w-[120px] h-[32px] p-2 box-border font-semibold flex justify-center items-center font-['poppins'] "><i class="mr-2 pi pi-download"></i>Download
                </button>
            </div>
           </div>
           <DataTable :value="useTally.json_tally_mapping_arr"  tableStyle="min-width: 50rem">
            <Column field="acc_head"  header="ABShrms Account Head" class="  font-['poppins'] text-[12px] font-medium"></Column>
            <Column field="gl_head" header="Tally GL Head" class="font-['poppins'] text-[12px] font-medium">
                <template #body="{ data }">
                    <div>
                        <InputText v-model="value2" type="text" class="bg-[#F6F6F6] border-[1px] w-[121px] h-[44px] rounded-[4px]"   />

                    </div>
                </template>
            </Column>
            <Column field="gl_name" header="Tally GL Name" class="font-['poppins'] text-[12px] font-medium">
                <template #body="{ data }">
                    <div >
                        <InputText v-model="value23"  type="text" class="bg-[#F6F6F6] border-[1px] w-[121px] h-[44px] rounded-[4px]"   />

                    </div>
                </template>
            </Column>
            <Column field="debit" header="Debit" class="font-['poppins'] text-[12px] font-medium"></Column>
            <Column field="credit" header="Credit" class="font-['poppins'] text-[12px] font-medium"></Column>
            <Column field="action" header="Action" class="font-['poppins'] text-[12px] font-medium">

                <template #body="{ data }">
                    <div>
                        <button
                       @click="useTally.deleteTallyComponent(data)"
                        class="w-[20px] h-[20px] rounded-[20px]  bg-[#D55151]">
                            <i class="text-[#fff] flex justify-center items-center pi pi-minus"></i>
                        </button>

                    </div>
                </template>

            </Column>
        </DataTable>
                                <!-- @click="deleteTallyComponentRow(rowIndex)" -->

           <div>
            <button @click="useTally.addTallyComponent()"
             class=" bg-[#0873CD] text-[13px] rounded-md gap-2 text-[#fff] !w-[170px] h-[32px] p-2 box-border font-semibold flex justify-center items-center font-['poppins'] "><i class="mr-2 pi pi-plus"></i>Add Components
            </button>
           </div>
           <div class="">
            <p class="font-medium text-[14px] text-start text-[#B20000] font-['poppins']">Points to be Noted :</p>
            <ul class="list-disc">
                <li class="  font-medium text-[14px] text-[#000000] font-['poppins']">When connecting cost bookings from an ABShrms to Tally software, it's crucial to have a comprehensive comprehension of how data will be aligned between the systems. Clearly define the matching fields in both ABShrms and Tally, establishing a robust mapping procedure to guarantee accurate data transfer.</li>
                <li class="font-medium text-[14px] text-[#000000] font-['poppins']" >Engage your accounts team to assist in associating the appropriate ledger accounts with transaction types (credit or debit) to ensure precise financial mapping.</li>
            </ul>
           </div>
           <div class="col-span-6 flex justify-center items-center gap-2 ">
            <button class=" bg-[#ffff] border-[#e6e6e6] border-[1px] text-[13px] rounded-md gap-2 text-[#000] !w-[100px] h-[32px] p-2 box-border font-semibold flex justify-center items-center font-['poppins']">Back
            </button>
            <button class=" bg-[#0873CD] text-[13px] rounded-md gap-2 text-[#fff] !w-[100px] h-[32px] p-2 box-border font-semibold flex justify-center items-center font-['poppins']">Connect
            </button>
           </div>
        </div>
    </div>
</template>

<script setup>
import { ref , reactive,onMounted,computed } from "vue";
import {useTallyService} from './store/tallyService';
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'

const tooltip_txt='Copy';

const useTally=useTallyService();
function showAPIKey() {
    let apikey=document.getElementById('apiKeyValue')
    if (apikey.type === "password") {
    apikey.type = "text";
  } else {
    apikey.type = "password";
  }
}


// delete row
const deleteTallyComponentRow=(rowIndex)=>{
    this.data.splice(rowIndex, 1);
}
// text copying function

// legal entity validation
const legalentityRules=computed(()=>{
    return{
        selected_legal_entity:{required:helpers.withMessage('Legal Entity is Required',required)}
    }
})
const legalentityV$=useValidate(legalentityRules,useTally.vm_tally_integration)
function validateLegalEntity()
{
    legalentityV$.value.$validate()
    if(!legalentityV$.value.$error)
    {
        console.log('Validation Successful')
        legalentityV$.value.$reset()
    }
    else{
        console.log('Failed Validation')
    }
}
onMounted(async()=>{
   
   
    // client code get method
    await useTally.getLegalEntities()


})
</script>
