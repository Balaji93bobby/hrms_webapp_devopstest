<template>
    <div>
        <!-- current ctc and payroll -->
        <div class="card my-2 grid grid-cols-7 p-2 gap-3 ">
            <div class="col-span-3  bg-[#CBE7FF] p-2">
                <p class="font-['poppins'] my-2 pl-2 font-normal text-[16px] ">Current CTC</p>
                <div class="flex justify-between ">
                    <p class="font-['poppins'] pl-2 font-semibold text-[16px]">INR 8,92,944.00/Annum</p>
                    <p class="text-[#FF8F01] text-end font-medium text-[16px] font-['poppins']">Salary Breakup</p>
                </div>
            </div>
            <div class="col-span-4 gap-3 flex p-2 bg-[#FFE4CB]">
                <div class=" flex items-center p-2">
                    <p class="font-medium text-[16px] font-['poppins']">Payroll</p>
                </div>
                <div class="flex flex-col p-2 items-center gap-2">
                    <p class="text-[#666666] font-normal text-[14px] font-['poppins']">Renumeration</p>
                    <p class="text-[#000] font-medium text-[16px] font-['poppins']">Monthly</p>
                </div>
                <div class="flex flex-col p-2 items-center gap-2">
                    <p class="text-[#666666] font-normal text-[14px] font-['poppins']">Pay Cycle</p>
                    <p class="text-[#000] font-medium text-[16px] font-['poppins']">21,Jan - 20,Feb</p>
                </div>
                <div class="flex flex-col p-2 items-center gap-2">
                    <p class="text-[#666666] font-normal text-[14px] font-['poppins']">Attendance Cycle</p>
                    <p class="text-[#000] font-medium text-[16px] font-['poppins']">1,Feb - 20,Mar</p>
                </div>
            </div>
        </div>
        <!-- salary revised details -->
        <div class="card my-2 grid grid-cols-7 p-2 gap-3">
           <div class="grid grid-cols-7 col-span-7">
                <div class="col-span-4 ">
                    <p class="text-start font-['poppins'] text-[16px] font-semibold" >
                    Salary Revised Details
                </p></div>
                <div class="col-span-3 flex items-end justify-end pr-2">
                    <p class="font-normal text-end  py-2 font-['poppins'] text-[14px]">Your Current Income Tax Regime -</p>
                    <button class="bg-[#C1A9BF] mx-2 px-1 rounded-md w-[200px] h-[35px] font-['poppins'] text-[14px] font-normal ">
                          Old Tax Regime.</button>
                </div>
           </div>
           
        </div>
    </div>
</template>
<script setup>

</script>