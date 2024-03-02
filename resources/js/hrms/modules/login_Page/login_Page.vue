<template>
    <!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
    <div class="h-screen bg-gray-100 text-gray-900 flex  justify-between w-[100%] ">
        <div class="sm:rounded-lg flex justify-between flex-1 !w-[100%] ">
            <div class="flex-1 text-center hidden lg:flex w-[100%] ">
                <div class=" w-[100%] bg-contain bg-center bg-no-repeat relative">
                    <img src="../../assests/images/login-page-img.png" alt="" class="w-[100%] h-[100vh]">
                    <div
                        class="absolute bottom-[50%] left-[15%]  font-medium font-sans d-flex justify-center xl:absolute xl:bottom-[50%] xl:left-[20%] ">
                        <h1 class="text-[64px] text-white font-['Quicksand'] xl:text-[72px] ">Great</h1>
                        <div class="px-3 mt-2  h-[80px]">
                            <h1
                                class="text-[20px] w-[300px] text-left leading-[40px] text-white font-['Poppins'] xl:text-[24px] ">
                                Company begins with a
                                Decision</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 xl:w-5/12  sm:p-12  w-[100%] float-right h-[100vh]">
                <div class=" w-100 d-flex justify-content-center  flex-col align-items-center ">
                    <div class="flex flex-col items-center">
                        <img src="../../assests/images/evangelist.png" class="w-[150px] mx-auto" />
                    </div>

                    <div
                        class="flex-1 w-[400px] h-[480px] mt-[30px] d-flex justify-content-center align-item-center flex-col" v-if="Forgotpage==false">
                        <h1 class="text-[16px] font-medium text-center font-['Poppins']">Login to run your business together
                        </h1>
                        <div class="w-full mt-[30px]">
                            <div class="">
                                <span class="p-float-label">
                                    <InputText id="username" v-model="name" class="w-full !rounded-[20px]" />
                                    <label for="username" class="pl-[18] text-blue-800 font-['Poppins'] flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <p class="px-2">Username</p>
                                    </label>
                                </span>
                            </div>
                            <div class="w-full mt-[24px]">
                                <span class="p-float-label">
                                    <Password v-model="password" toggleMask />
                                    <label for="username"
                                        class="pl-[18] text-blue-800 font-['Poppins'] cursor-pointer flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                        <p class="px-2">password</p>
                                    </label>
                                </span>
                                <div class="w-full">
                                    <p @click="Forgotpage =true"
                                        class="w-[140px] py-2 hover:text-blue-500 text-[12px] text-color[#535353] cursor-pointer float-right font-['Poppins']  font-medium ">
                                        Forgot Password ?</p>
                                </div>

                            </div>

                            <button @click="login"
                                class=" mt-[4px] h-[35px] rounded-[20px] w-full text-[16px] font-['Poppins']"
                                style="background-color: #001820;color:#CCCCCC;">
                                Login
                            </button>

                            <div class="row mt-2">
                                <div class="col h-0  border-b-[1px] border-[#CCCCCC] mt-1"></div>
                                <div class="col-1 text-[14px] font-['Poppins'] text-[#CCCCCC]">Or</div>
                                <div class="col h-0  border-b-[1px] border-[#CCCCCC] mt-1"></div>
                            </div>

                            <div class="mt-[14px]  d-flex justify-content-center">
                                <div class="w-[150px] py-2 bg-[#E6E6E6] d-flex justify-content-between rounded-md">
                                    <img src="../../assests/images/Google_logo.png" alt="" class="mx-2"
                                        style="width: 25px; height:25px">
                                    <img src="../../assests/images/Linkedin_logo.png" alt="" class="mx-2"
                                        style="width: 25px; height:25px">
                                    <img src="../../assests/images/Microsoft_logo.png" alt="" class="mx-2"
                                        style="width: 25px; height:25px">
                                </div>

                            </div>
                            <div class=" d-flex justify-content-center align-items-center flex-col mt-[15px] ">
                                <div class=" d-flex align-items-center flex-col ">
                                    <p class="text-[10.89px]  font-['Poppins'] font-semibold text-[#8B8B8B] text-center">
                                        Available for</p>
                                    <h1 class="text-[18px]  font-['Poppins'] font-semibold  text-[#8B8B8B]">Download</h1>
                                </div>

                                <div class=" flex justify-center relative top-3">
                                    <div class="w-[120px]">
                                        <img src="../../assests/images/Playstore_Logo.png" class="" alt="">
                                    </div>
                                    <div class="w-[120px] mx-2">
                                        <img src="../../assests/images/App_Store_Logo.png" class="w-full h-full" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center  relative top-8  ">
                                <div class=" flex justify-center mt-[10px] w-[150px] ">
                                    <p class="text-[12px] text-[#8B8B8B] font-['Poppins'] ">Powered by</p>
                                    <div class="w-[148px]">
                                        <img src="../../assests/images/evangelist.png" alt="" class="w-full h-full">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="Forgotpage== true">
                        <div class="mt-16 font-['poppins']">
                            <div class="text-black">
                                <h1 class="text-black text-xl">Forgot Password</h1>
                                <p class="text-[#8B8B8B]">Please Enter your Email or Employee code to reset your password</p>
                            </div>
                            <div class="py-2">
                                <input type="email" placeholder="Email" class="w-[400px] h-12 rounded-3xl border p-3 ">
                                <div class="row  w-72 ml-24">
                                    <div class="col h-0  border-b-[1px] border-[#CCCCCC]  mt-3"></div>
                                    <div class="col-1 text-[14px] justify-center font-['Poppins'] text-[#CCCCCC]">  Or</div>
                                    <div class="col h-0  border-b-[1px] border-[#CCCCCC] ml-3 mt-3"></div>
                                </div>
                                <input type="" placeholder="Employee Code" class="w-[400px] h-12 rounded-3xl border mt-2  p-3 ">
                            </div>
                            <div class="py-3">
                                <button class="bg-black text-white  w-[400px]  h-11 rounded-3xl">Submit</button>
                            </div>
                            <div class="row  w-[400px] ml-3">
                                <div class="col h-0  border-b-[1px] border-[#CCCCCC]  mt-3"></div>
                                <div class="col-1 text-[14px] justify-center font-['Poppins'] text-[#CCCCCC]">  Or</div>
                                <div class="col h-0  border-b-[1px] border-[#CCCCCC] ml-3 mt-3"></div>
                            </div>
                        </div>
                        <div class="mt-[14px]  d-flex justify-content-center">
                            <div class="w-[150px] py-2 bg-[#E6E6E6] d-flex justify-content-between rounded-md">
                                <img src="../../assests/images/Google_logo.png" alt="" class="mx-2"
                                    style="width: 25px; height:25px">
                                <img src="../../assests/images/Linkedin_logo.png" alt="" class="mx-2"
                                    style="width: 25px; height:25px">
                                <img src="../../assests/images/Microsoft_logo.png" alt="" class="mx-2"
                                    style="width: 25px; height:25px">
                            </div>

                        </div>
                        <div class=" d-flex justify-content-center align-items-center flex-col mt-[15px] ">
                            <div class=" d-flex align-items-center flex-col ">
                                <p class="text-[10.89px]  font-['Poppins'] font-semibold text-[#8B8B8B] text-center">
                                    Available for</p>
                                <h1 class="text-[18px]  font-['Poppins'] font-semibold  text-[#8B8B8B]">Download</h1>
                            </div>

                            <div class=" flex justify-center relative top-3">
                                <div class="w-[120px]">
                                    <img src="../../assests/images/Playstore_Logo.png" class="" alt="">
                                </div>
                                <div class="w-[120px] mx-2">
                                    <img src="../../assests/images/App_Store_Logo.png" class="w-full h-full" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center  relative top-8  ">
                            <div class=" flex justify-center mt-[10px] w-[150px] ">
                                <p class="text-[12px] text-[#8B8B8B] font-['Poppins'] ">Powered by</p>
                                <div class="w-[148px]">
                                    <img src="../../assests/images/evangelist.png" alt="" class="w-full h-full">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import axios from 'axios';
import { ref } from 'vue';

const name = ref();
const email = ref();
const password = ref();
const accept = ref();
const value = ref(null);
const Forgotpage =ref(false);

const login = (username, pass) => {
    axios.post('/api/auth/login', {
        user_code: name.value,
        password: password.value
    })
}


</script>

<style>
.p-password-input
{
    width: 100%;
    border-radius: 20px;
}

.p-password
{
    width: 100%;

}

.p-password-input ::placeholder
{
    padding-left: 12px !important;
}
</style>

<!-- .p-input-icon-right .pi-eye{
    padding-right: 12px;
 } -->
