<template>
    {{ source }}
    <div class="">
        <div class="p-[20px]">
            <div class="flex items-center justify-between row">
                <div class="col-8">
                    <h1 class=" text-[20px] text-[#000]">ARDENS BUSINESS SOLUTIONS PRIVATE LIMITED</h1>
                    <p class="mt-[10px]">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga, voluptates. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga, voluptates.</p>
                </div>
                <div class="flex col-4">
                    <p class="text-right">Company Logo </p>
                </div>
            </div>
            <div class="border-[#f9be00] border-[1px] w-[100%] my-2"></div>
            <div>
                <p class="my-2 font-semibold">Payslip for the month of April 2023</p>
                <h1 class="text-[#f9be00] my-2 font-semibold">EMPLOYEE PAY SUMMARY</h1>
            </div>

            <div class="row">
                <div class="col-4">
                    <p class="text-[#4d4d4d] my-2">Employee Name :</p>
                    <p class="text-[#4d4d4d] my-2">Designation :</p>
                    <p class="text-[#4d4d4d] my-2">Date Joining :</p>
                    <p class="text-[#4d4d4d] my-2">Pay Period :</p>
                    <p class="text-[#4d4d4d] my-2">Pay Date :</p>
                    <p class="text-[#4d4d4d] my-2">Bank Account No:</p>
                </div>
                <div class="col-3">
                    <p class="text-[#4d4d4d] my-2 text-left">-</p>
                    <p class="text-[#4d4d4d] my-2">-</p>
                    <p class="text-[#4d4d4d] my-2">-</p>
                    <p class="text-[#4d4d4d] my-2">-</p>
                    <p class="text-[#4d4d4d] my-2">-</p>
                    <p class="text-[#4d4d4d] my-2">-</p>
                </div>
                <div class="col-5">
                    <p class="text-center text-[16px]">Employee Net Pay</p>
                    <p class="text-center text-[34px] font-semibold flex items-center"><span class="text-[34px] font-sans mx-2 ">₹</span> 82,54,82,500.00</p>
                    <p class="text-center text-[16px]">Paid Days : 30 | LOP Day : 0 | ARREAR DAYS</p>
                </div>
            </div>

            <div class="border-[#f9be00] border-[1px] w-[100%] my-2">
            </div>

            <div class="row">
                <div class="col-6">
                    <h1 class="text-[#f9be00]  font-semibold">EARNINGS</h1>
                    <h1 class=" text-[#000] my-2 ">Basic</h1>
                    <h1 class="text-[#000] my-2 ">House Education Allowance</h1>
                    <h1 class="text-[#000] my-2 ">Children Education Allowance</h1>
                    <h1 class="text-[#000] my-2 ">Fixed Allowance</h1>
                    <h1 class="text-[#000] my-2 font-semibold">Gross Earnings</h1>
                </div>
                <div class="col-2">
                    <h1 class="text-[#f9be00]  font-semibold">Amount</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                </div>
                <div class="col-2">
                    <h1 class="text-[#f9be00]  font-semibold">ARREARS</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                </div>
                <div class="col-2">
                    <h1 class="text-[#f9be00]  font-semibold">YEAR TO DATE</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>
                    <h1 class=" text-[#000] my-2 ">-</h1>

                </div>
            </div>

            <div class="border-[#f9be00] border-[1px] w-[100%] my-2">
            </div>

            <div class="row">
                <div class="col-6">
                    <h1 class="text-[#f9be00] font-semibold">DEDUCTIONS</h1>
                    <h1 class=" text-[#000] my-2">EPF contribution</h1>
                    <h1 class=" text-[#000] my-2">Income Tax</h1>
                    <h1 class=" text-[#000] my-2 font-semibold">Total Deductions</h1>
                </div>
                <div class="col-2">
                    <h1 class=" text-[#f9be00]  font-semibold">AMOUNT</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                </div>
                <div class="col">
                    <h1 class=" text-[#f9be00]  font-semibold">ARREARS</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                </div>
                <div class="col">
                    <h1 class=" text-[#f9be00]  font-semibold">YEAR TO DATE</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                    <h1 class="my-2">-</h1>
                </div>
            </div>

            <div class="row bg-[#fff6db] p-2">
                <div class="col-6">
                    <h1 class="text-[#f9be00] font-semibold text-[16px]">NET PAY (<span class=" text-[12px]">Gross Earnings - Total Deduction</span> )</h1>
                </div>
                <div class="col-6">
                    <h1 class=" text-[#000]"> <span class="mx-2 font-sans ">₹</span>---</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h1 class="my-4">Total Net Payable <span class="font-semibold">₹ 1,05,578.00</span> (  <span class=" text-[12px]">indian rupee One Lakh Five Thousand Five Hundred Seventy-Eight Only</span> )</h1>
                </div>
            </div>

            <h1 class="font-semibold text-[#f9be00]">LEAVE DETAILS</h1>
            <div class="row">
                <div class="col-3">
                    <p class=" text-gray">Leave Type</p>
                    <p>-</p>
                </div>
                <div class="col-3">
                    <p>Opening Balance</p>
                    <p>-</p>
                </div>
                <div class="col-3">
                    <p>availed</p>
                    <p>-</p>
                </div>
                <div class="col-3">
                    <p>Closing Balance</p>
                    <p>-</p>
                </div>
            </div>

            <div class="border-[#f9be00] border-[1px] w-[100%] my-2">
            </div>

            <div class="row my-[40px]">
                <div class="col"><p class="text-center ">- This is a system generated payslip, hence the signature is not required.-</p></div>
            </div>

            <div class="flex justify-end ">
                <div class="flex w-[200px] ">
                <p class="text-[gray]">Powered By</p>
                <p class="">ABS Logo</p>
                </div>
            </div>



        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const props = defineProps({
    source:{
        type:Object,
        required:true
    }
})
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Lobster&family=Poppins&display=swap');

*
{
    font-family: 'Lobster', cursive;
    font-family: 'Poppins', sans-serif !important;
}

.border
{
    border: 1px solid #f3f4f6 !important;
}

.float-right
{
    float: right
}

.float-left
{
    float: left
}

.td
{
    height: 10px !important;
}

.marign-top1
{}

p
{
    color: #000;
}</style>
