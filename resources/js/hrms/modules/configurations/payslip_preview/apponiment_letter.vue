<template>
    <div>
        <div class="flex flex-row">
            <div class=" mx-2 w-[332px] bg-[#E6E6E6] template">
                <h1 class=" text-[#000] m-[10px] font-[14.02px]">Standard Template</h1>
                <div class="m-[16px] relative">
                    <img src="../../../assests/images/payslipv1.png" alt="">
                    <div class="w-[100%] bg-[#00000033] p-[12px]   justify-around hide absolute bottom-0" >
                        <button class="bg-[#000] text-[#fff] p-2 rounded-md">set as Default</button>
                        <button class="bg-[#fff] text-[#000] rounded-md p-2"  @click="visibleRight = true" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-[20px] h-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>

                        <button class="p-2 bg-white rounded-md ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" class="w-[20px] h-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class=" mx-2 w-[332px] bg-[#E6E6E6] template">
                <h1 class=" text-[#000] m-[10px] font-[14.02px]">Standard Template</h1>
                <div class="m-[16px] relative">
                    <!-- <dynamicPayslip/> -->
                    <!-- <dynamicPayslipv2/> -->
                    <img src="../../../assests/images/payslip_v2.png" alt="">
                    <div class="w-[100%] bg-[#00000033] p-[12px]   justify-around hide absolute bottom-0" >
                        <button class="bg-[#000] text-[#fff] p-2 rounded-md">set as Default</button>
                        <button class="bg-[#fff] text-[#000] rounded-md p-2"  @click="visibleRight = true" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-[20px] h-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>

                        <button class="p-2 bg-white rounded-md ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" class="w-[20px] h-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>


            <!-- <Button icon="pi pi-arrow-left"  /> -->
        </div>
        <Sidebar v-model:visible="visibleRight" position="right">
    <h2>Right Sidebar</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</Sidebar>
    </div>
</template>

<script setup>
import dynamicPayslip from "../../manage_payslips/dynamicPayslip.vue";
import {ref , reactive }  from "vue";
import dynamicPayslipv2 from '../../manage_payslips/dynamicPayslipv2.vue';

const visibleRight = ref(false);

</script>

<style>
.hide{
    display: none;
    /* transition: 2s display; */
    transition: display 0.3s ease, transform 0.3s ease;
  
}
.template:hover  .hide{
display:flex;
transition-delay: 6s !important;
}
</style>