<template>
   <h1 class="font-medium text-[#000] text-[18px] font-[poppins]">Resignation Setting</h1>
   <div class="p-2">
    <!-- <p class="font-medium text-[#000] text-[14px] font-[poppins] my-2">Exit module<span class="text-danger">*</span></p>
<div>
    <div class="bg-[#F2F6F9] p-2 w-[55%]  font-[poppins] font-normal text-[12px] text-[#1A2F40] rounded">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis.</div>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div> -->
<div>
    
     <Dropdown class="w-[20%] font-[poppins] font-normal text-[14px] text-[#000] bg-[#EEEEEE] rounded border-[#F5F5F5]" v-model="useResignation.selectedClient" :options="useResignation.getResignationClientList" optionLabel="client_fullname" optionValue="id" placeholder="Select" />

</div>

<div class="my-3">
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Can Employee Apply Resignation?<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input dark:ring-offset-gray-800 focus:ring-2 dark:bg-black-700 dark:border-gray-600 text-[#000]" type="radio" 
                        name="radiobtn2" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input dark:ring-offset-gray-800 focus:ring-2 dark:bg-black-700 dark:border-gray-600" type="radio" name="radiobtn2"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>
<div>
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Is it permissible for a manager to submit a Resignation on behalf of their subordinate?<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn3" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn3"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>
<div class="my-3">
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Is it permissible for a HR to submit a Resignation on behalf of employees?<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn4" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn4"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>
<div>
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Can Employee edit Last Working Day<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn5" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn5"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>
<div class="my-3">
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Auto-Approve Resignation<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn6" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn6"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>

<div>
    <p class="font-medium text-[#000] text-[14px] font-[poppins] my-2">Approval Flow<span class="text-danger">*</span></p>

    <div class="bg-[#F2F6F9] p-2 w-[55%]  font-[poppins] font-normal text-[12px] text-[#1A2F40] rounded">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis.</div>
<div class="flex gap-2">
     <Dropdown class="w-[10%] font-[poppins] font-normal text-[14px] text-[#000] bg-[#EEEEEE] rounded border-[#F5F5F5]" v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select Staff" />
     <div class="flex justify-center items-center w-[50px] h-[30px] mt-1">
        <div class="w-[50px]  b-[2px]  h-[1px] bg-[#CCCCCC] relative"></div><i class="pi pi-angle-right absolute pl-14  text-[#CCCCCC] text-[20px]"></i>
        </div>
     <!-- <i class="pi pi-arrow-right w-[200px]"></i> -->
     <Dropdown class="w-[10%] font-[poppins] font-normal text-[14px] text-[#000] bg-[#EEEEEE] rounded border-[#F5F5F5]" v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select Staff" />
     <div class="flex justify-center items-center w-[50px] h-[30px] mt-1">
        <div class="w-[50px] b-[2px] border-[#000] h-[1px] bg-[#CCCCCC] relative"></div><i class="pi pi-angle-right absolute pl-14 text-[#CCCCCC] text-[20px]"></i>
        </div>
     <Dropdown class="w-[10%] font-[poppins] font-normal text-[14px] text-[#000] bg-[#EEEEEE] rounded border-[#F5F5F5]" v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select Staff" />
    
</div>

</div>

<div class="my-3">
    <p class="font-medium text-[#000] text-[14px] font-[poppins]">Send E-mail Reminders to Manager and HR for approval<span class="text-danger">*</span></p>
    <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn7" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn7"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-normal font-[poppins] text-[14px] text-[#000]">No</p>
                    </label>
                </div>
            </div>
          
        </div>

</div>


   </div>
</template>
<script setup>

import { ref,onMounted } from "vue"
import {useResignationStore} from '../exit_modulev2/resignation/store/self_resignation'
const useResignation = useResignationStore()
onMounted(async ()=>{
  await  useResignation.getClientlistForResignation();
})

</script>

<style>
.form-check-input:checked{
    background-color: #f9be00 !important;
    border-color: #f9be00 !important;
}

</style>
