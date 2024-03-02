<template>
    <div class="grid grid-cols-6">
        <!-- <div class="w-full align-middle row card-headers d-flex justify-content-between align-items-center md:justify-center"
            :style="{}">
            <div class="col-md" style="line-height: 30px;">
                <h1 class="mx-2 mb-5 font-semibold">HRA Calculation</h1>
            </div>
            <div class="col-md d-flex justify-content-end">
                <button class="mb-5 "
                    :style="{ border: '1px solid #F36826', borderRadius: '4px', color: '#F36826', padding: '8px 18px', fontSize: '15.06px' }">Release
                    Investments Declaration</button>
            </div>
        </div>

        <div class="w-full pr-4">
            <div class="p-3 bg-gray-100 rounded-lg card">
                <div class="card-body ">
                    <div class="justify-around w-full row d-flex md">
                        <div class="col-md col-8 cd">
                            <h1 :class="{ navy: isnavy, gary: isgray }">Do you want to consider default rent paid amount for
                                HRA calculation?</h1>
                        </div>
                        <div class="col-sm d-flex">
                            <div class="items-center justify-around ">
                                <input type="radio" name="INV" :style="{ color: '#002f56', fontSize: '18px' }" v-model="blu"
                                    value="blu_clr" @click="togglenavy" style="height: 20px;width: 20px;"
                                    class="form-check-input">
                                <label for="" class="mx-3 text-1xl form-check-label leave_type"
                                    :style="{ color: '#002f56' }">yes</label>
                            </div>
                            <div class="items-center justify-around ">
                                <input type="radio" name="INV" :style="{ color: '#002f56' }" value="gr_clr"
                                    @click="togglegray" style="height: 20px;width: 20px;" class="form-check-input">
                                <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="justify-around w-full mt-5 row d-flex md ">
                        <div class="mt-3 col-md col-8 cd">
                            <h1 class="w-full ">
                                How would you like the House Rent Allowance (HRA) to be taken into account for tax exemption
                                purposes?
                            </h1>
                        </div>
                        <div class="mt-2 col-md">
                            <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                placeholder=" Month on Month or Annual" class="w-full h-2.2rem"
                                :style="{ background: '#FFFFFF;' }" />
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>

            <div class="mt-5">
                <h1 class="mt-5 font-semibold">Investments Estimation and Deduction on Bonuses</h1>
                <div class="p-3 mt-5 bg-gray-100 rounded-lg card">
                    <div class="card-body">
                        <div class="justify-around w-full row d-flex md">
                            <div class="col-8 col-lg cd " style="line-height: 12px;">
                                <h1 :class="{ navy: isnavy, gary: isgray }">Do you include future payout dates for bonuses
                                    (unpaid bonuses) when projecting tax calculations?</h1>
                            </div>
                            <div class="col-sm d-flex">
                                <div class="items-center justify-around ">
                                    <input type="radio" name="INV" :style="{ color: '#002f56' }" v-model="blu"
                                        value="blu_clr" @click="togglenavy" style="height: 20px;width: 20px;"
                                        class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }">yes</label>
                                </div>
                                <div class="items-center justify-around ">
                                    <input type="radio" name="INV" :style="{ color: '#002f56' }" value="gr_clr"
                                        @click="togglegray" style="height: 20px;width: 20px;" class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="w-full">
            <div class="mt-5">
                <h1 class="mt-5 font-semibold">Approval of Financial Changes</h1>

                <div class="p-3 mt-5 bg-gray-100 rounded-lg card">
                    <div class="card-body">
                        <div class="justify-around row d-flex align-items-center md">
                            <div class="col-1 col-lg ">
                            </div> 
                            <div class="col-12">
                                <input type="checkbox" name="" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input"><span>
                                    <span class="mx-6 font-semibold fs-5" :style="{ color: '#002f56' }"> Grant authorization to employees for reviewing
                                        and approving changes to the
                                        following
                                        financial information</span>
                                </span>

                            </div>
                        </div>


                        <div class="col-sm d-flex ">
                            <ul class="ml-78 ul" :style="{ color: '#002f56' }">
                                <li class="cd">Salary Payment Mode: Bank transfer, Cheque, or Cash.</li>
                                <li class="cd">Bank Information: Bank name, Account number, IFSC Code, or Name on account.
                                </li>
                                <li class="cd">PF & ESI Information: PF number, UAN, Joining date, Name on account, or ESI
                                    number.</li>
                                <li class="cd">PAN Information: PAN number, Date of birth, Name on PAN card, or Father's
                                    Name.</li>
                                <li class="cd">Aadhaar Information: Aadhaar Number, Aadhaar enrolment number, or Name on
                                    Aadhaar.</li>
                            </ul>
                        </div>



                    </div>

                </div>

            </div>

            <div class="mt-5">
                <h1 class="mt-5 font-semibold">Opting In of New Tax Regime</h1>

                <div class="p-3 my-5 bg-gray-100 rounded-lg card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md col-8 cd">
                                <h1>The deadline for opting in or out of the new tax regime (Section 115BAC) is based on the
                                    financial year's cutoff date is </h1>
                            </div>
                            <div class="col-md d-flex">
                                <div class="items-center justify-around ">

                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="May"
                                        class="w-full md:w-7rem" />

                                </div>
                                <div class="items-center justify-around ml-4">
                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="25"
                                        class="w-full md:w-7rem" />
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="mt-4 col-md col-10 cd">
                                <h1>For New Joinee, opting in or out to be done within
                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="25"
                                        class="w-full mx-4 md:w-7rem" /> days from the date of joining.
                                </h1>
                            </div>
                        </div>

                    </div>

                </div>

            </div>



            <div class="mt-5">
                <h1 class="mt-5 font-semibold">Investments Declaration</h1>

                <div class="p-3 my-5 mt-2 bg-gray-100 rounded-lg card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md col-12 cd">
                                <h1>Employees can update their Investments Declarations anytime during a month prior to
                                    month the
                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="25"
                                        class="w-full mx-4 md:w-7rem" />
                                    month and before the cut-off period in the financial year, as defined below.
                                </h1>
                            </div>
                        </div>
                        <div class="my-4 row">
                            <div class="col-md col-6 cd">
                                <h1 :style="{ lineHeight: '45px' }">Cutoff date for changing declaration in financial year
                                    is
                                </h1>
                            </div>
                            <div class="col-md d-flex">
                                <div class="items-center justify-around ">

                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="May"
                                        class="w-full md:w-7rem" />

                                </div>
                                <div class="items-center justify-around ml-4">
                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="25"
                                        class="w-full md:w-7rem" />
                                </div>
                            </div>

                        </div>


                        <div class="my-4 row">
                            <div class="col-md col-10 cd">
                                <h1>For New Joinee, opting in or out to be done within
                                    <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="25"
                                        class="w-full mx-4 md:w-7rem" /> days from the date of joining.
                                </h1>
                            </div>
                        </div>

                        <div class="justify-around w-full row d-flex md">
                            <div class="col-md col-8 cd">
                                <h1>Is approval required for any modifications in IT declarations submitted before Feb 27?
                                </h1>
                            </div>

                            <div class="col-md d-flex">
                                <div class="items-center justify-around ">
                                    <input type="radio" name="HRA-cal" id="" style="height: 20px;width: 20px;"
                                        class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }"
                                        @click="togglenavy">yes</label>
                                </div>
                                <div class="items-center justify-around ml-3">
                                    <input type="radio" name="HRA-cal" id="" style="height: 20px;width: 20px;"
                                        class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }"
                                        @click="togglegray">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <h1 class="mt-5 font-semibold">Notification to Employees</h1>

                <div class="p-3 my-5 mt-2 bg-gray-100 rounded-lg card card-md-w-100">
                    <div class="card-body">
                        <div class="justify-around row d-flex align-items-center ">

                            <div class="w-0 mr-3 col-1 col-lg">
                                <label for=""><input type="checkbox" name="" id="" style="height: 20px;width: 20px;"
                                        class="form-check-input"></label>
                            </div>
                            <div class="col col-sm-10 ">
                                <h1>Notify the employee when the investment Delaration is released. </h1>
                            </div>
                        </div>

                        <div class="justify-around w-full my-4 row d-flex md">
                            <div class="ml-5 col-md col-8 cd ">
                                <h1> Should we consider sending email remainder to the declare the investments</h1>
                            </div>
                            <div class="col-md d-flex">
                                <div class="items-center justify-around ">
                                    <input type="radio" name="HRA-cal" :style="{ color: '#002f56' }" id=""
                                        style="height: 20px;width: 20px;" class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }"
                                        @click="togglenavy">yes</label>
                                </div>
                                <div class="items-center justify-around ml-3">
                                    <input type="radio" name="HRA-cal" :style="{ color: '#002f56' }" id=""
                                        style="height: 20px;width: 20px;" class="form-check-input">
                                    <label for="" class="mx-3 text-1xl" :style="{ color: '#002f56' }"
                                        @click="togglegray">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="justify-around row d-flex align-items-center">
                            <div class="mt-3 col-lg col-8">
                                <h1 class="ml-5">If yes,how frequently the should be sent ?</h1>
                            </div>
                            <div class="col col-lg">
                                <Dropdown v-model="month" :options="cities" optionLabel="name" placeholder="Oncee a Week"
                                    class="w-full md:w-14rem" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- NEW DESIGN INVESTMENT DECLARATION -->
        <!-- HRA CALCULATION -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">HRA Calculation</p>
        <p class="col-span-6 my-1 font-['poppins'] font-medium text-[14px]">Do you want to consider default rent paid amount for HRA calculation?<span class="text-[#C4302B]">*</span></p>
        <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">No</p>
                    </label>
                </div>
            </div>
          
        </div>
        <p class="col-span-6 my-1 font-['poppins'] font-medium text-[16px]">How would you like the House Rent Allowance (HRA) to be taken into account for tax exemption purposes?<span class="text-[#C4302B]">*</span></p>
        <Dropdown 
                        placeholder="Choose Monthly or Annually"
                        class=" !w-[300px] border-[#DDDDDD] border-[1px] md:w-[230px] h-12"
                        />
             
       </div>
       <!-- INVESTMENT Estimation -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">Investments Estimation and Deduction on Bonuses</p>
        <p class="col-span-6 my-1 font-['poppins'] font-medium text-[14px]">Do you include future payout dates for bonuses (unpaid bonuses) when projecting tax calculations?<span class="text-[#C4302B]">*</span></p>
        <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">No</p>
                    </label>
                </div>
            </div>
          
        </div>
       
             
       </div>
       <!-- EMPLOYEE FINANCIAL -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">Employee Financial Information Changes</p>
        <div class="col-span-6 py-2 box-border flex">
            <input type="checkbox"  value="1" name=""
                class="form-check-input mr-3" id="" style="width: 20px; height: 20px;">
            <p class="font-medium text-[16px] font-['poppins']">Grant authorization to employees for edit and upload the documents.</p>
        </div>
        <div class="col-span-6 p-2 box-border ml-2">
            <ul class="list-disc">
                <li class="  font-medium text-[14px] text-[#535353] font-['poppins']">Salary Payment Mode: Bank transfer, Cheque, or Cash.</li>
                <li class="font-medium text-[14px] text-[#535353] font-['poppins']" >Bank Information: Bank name, Account number, IFSC Code, or Name on account.</li>
                <li class="  font-medium text-[14px] text-[#535353] font-['poppins']">PAN Information: PAN number, Date of birth, Name on PAN card, or Father's Name.
                </li>
                <li class="font-medium text-[14px] text-[#535353] font-['poppins']" >Aadhaar Information: Aadhaar Number, Aadhaar enrolment number, or Name on Aadhaar
                </li>
            </ul>
        </div>
        <!-- OPTING IN -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">Opting in of New Tax Regime</p>
        <p class="col-span-6 font-medium text-[14px] font-['poppins'] my-2">The deadline for opting in or out of the new tax regime (Section 115BAC) is based on the financial year's cutoff date is<span class="text-[#C4302B]">*</span> </p>
        <Calendar inputId="icon" v-model="calval"  dateFormat="dd-mm-yy"
        class="border-[1px] border-[#535353] rounded-[2px] " :showIcon="true" style="width: 400px;" 
                             />
        <p class="col-span-6 my-2 font-medium text-[14px] font-['poppins']">For New Joinee, opting in or out to be done within days from the date of joining.<span class="text-[#C4302B]">*</span></p>
        <InputText  placeholder="Enter Days" type="text"
        class=" border-[1px] w-[300px] h-[40px] text-[#000]  p-3 box-border rounded-[4px]"
        />
       </div>
       <!-- INVESTMENT -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">Investment Declaration</p>
        <p class="col-span-6 font-medium text-[14px] font-['poppins'] my-2">Employees can update their Investments Declarations anytime during a month prior to month the day of that month and before the cut-off period in the financial year, as defined below.<span class="text-[#C4302B]">*</span></p>
        <InputText  placeholder="Enter Days" type="text"
        class=" border-[1px] w-[300px] h-[40px] text-[#000]  p-3 box-border rounded-[4px]"
        />
        <p class="col-span-6 font-medium text-[14px] font-['poppins'] my-2">Cutoff date for changing declaration in financial year is<span class="text-[#C4302B]">*</span></p>
        <Calendar inputId="icon" v-model="calvalue"  dateFormat="dd-mm-yy"
        class="border-[1px] border-[#535353] rounded-[2px] " :showIcon="true" style="width: 400px;" 
                             />
        <p class="col-span-6 font-medium text-[14px] font-['poppins'] my-2">For New Joinee, declaration to be done within days from the date of joining.<span class="text-[#C4302B]">*</span></p>
        <InputText  placeholder="Enter Days" type="text"
        class=" border-[1px] w-[300px] h-[40px] text-[#000]  p-3 box-border rounded-[4px]"
        />

        <p class="col-span-6 font-medium text-[14px] font-['poppins'] my-2">Is approval required for any modifications in IT declarations submitted before Feb 27?<span class="text-[#C4302B]">*</span></p>
        <div class="grid grid-cols-6  col-span-6">
            <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                <div class=" d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                        name="radiobtn" id="" value="1"
                       />
                    <label class="ml-2  form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">Yes</p>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                        id="" value="0"
                        />
                    <label class="ml-2 form-check-label leave_type fs-13" for="">
                        <p class="font-medium font-['poppins'] text-[14px]">No</p>
                    </label>
                </div>
            </div>
          
        </div>
       </div>

       <!-- NOTIFICATION T EMPLOYEES -->
       <div class="col-span-6 grid grid-cols-6">
        <p class="col-span-6 my-3 font-['poppins'] font-semibold text-[16px]">Notification to Employees</p>
        <div class="col-span-6 flex">
            <input value="1" type="checkbox" name="" class="form-check-input mr-3" id=""
            style="width: 20px; height: 20px;">
            <p class="font-['poppins'] text-[16px] font-medium">
                Notify the employees when the Investment Declaration is released.            </p>
        </div>
       

            <p class="col-span-6 font-medium text-[16px] font-['poppins'] my-2">
                Should we consider sending email reminders to the employees to declare the investments<span class="text-[#C4302B]">*</span>
            </p>
            <div class="grid grid-cols-6  col-span-6">
                <div class="col-span-6 d-flex justify-content-start align-items-center  gap-3 py-2 box-border px-0">
                    <div class=" d-flex justify-content-between align-items-center ">
                        <input style="height: 20px; width: 20px; bg-red-400;" class="form-check-input" type="radio"
                            name="radiobtn" id="" value="1"
                           />
                        <label class="ml-2  form-check-label leave_type fs-13" for="">
                            <p class="font-medium font-['poppins'] text-[14px]">Yes</p>
                        </label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ">
                        <input style="height: 20px; width: 20px" class="form-check-input" type="radio" name="radiobtn"
                            id="" value="0"
                            />
                        <label class="ml-2 form-check-label leave_type fs-13" for="">
                            <p class="font-medium font-['poppins'] text-[14px]">No</p>
                        </label>
                    </div>
                </div>
              
            </div>
            <div class="col-span-6 grid grid-cols-6">
                <p class="col-span-6 font-medium text-[16px] font-['poppins'] my-2">
                    If yes, how frequently the reminders should be sent?   </p>
                    <Dropdown       placeholder="Once a week" class=" !w-[300px] md:w-[230px] h-10" 
                    />
                   
            </div>
       </div>
             
       </div>
    </div>
    <!-- <div class="my-4 col-md d-flex justify-content-end">
        <button class=" btn btn-orange">Save</button>
    </div> -->
</template>

<script setup>
import { reactive, ref } from 'vue';


const blu = ref();
const isnavy = ref(false)

const isgray = ref(false);



function togglenavy() {
    isnavy.value = true;
    isgray.value = false;

}
function togglegray() {
    isgray.value = true;
}
const calval=ref()
const calvalue=ref()
const month = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);



</script>



<style>
.navy {
    color: #003054;
}

.gary {
    color: #B1B1B1;
}

input:checked {
    color: #F36826;
    background: #F36826;

}

.ml-78 {
    margin-left: 6rem;
    list-style: disc;
}

.Mon {
    height: 2.5rem;
    border-radius: 4px;
    border: 1px solid green;
    width: 8rem;
}

@media only screen and (max-width: 600px) {
    .cd {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 130%;
        text-align: justify;
        margin: 0;
    }

    .ml-78 {
        margin: none !important;
        position: relative;
        left: -65px;

    }

    .card {
        width: 100% !important;
        border: 1px solid red;
    }

}

.ul>li {
    margin: 1rem 0 0 0;
}
</style>

{

<!-- <template>
    <div class="flex card justify-content-center">
        <div class="flex flex-wrap gap-3">
            <div class="flex align-items-center">
                <RadioButton v-model="ingredient" inputId="ingredient1" name="pizza" value="Cheese" />
                <label for="ingredient1" class="ml-2">Cheese</label>
            </div>
            <div class="flex align-items-center">
                <RadioButton v-model="ingredient" inputId="ingredient2" name="pizza" value="Mushroom" />
                <label for="ingredient2" class="ml-2">Mushroom</label>
            </div>
            <div class="flex align-items-center">
                <RadioButton v-model="ingredient" inputId="ingredient3" name="pizza" value="Pepper" />
                <label for="ingredient3" class="ml-2">Pepper</label>
            </div>
            <div class="flex align-items-center">
                <RadioButton v-model="ingredient" inputId="ingredient4" name="pizza" value="Onion" />
                <label for="ingredient4" class="ml-2">Onion</label>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const ingredient = ref('');
</script>



<template>
    <div class="flex card justify-content-center">
        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" class="w-full md:w-14rem" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
</script>


<template>
    <div class="flex card justify-content-center">
        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" class="w-full md:w-14rem" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
</script>



-->
}
