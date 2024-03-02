<template>
    <div class="mx-4 payroll-settings">
        <div class="mb-4 payroll-settings-header">
            <h4 class="mb-3 text-2xl font-semibold">Payroll Settings</h4>
            <p class="mb-4 text-sm font-bold text-gray-600">We kindly asked for your patience as we gather all the necessary
                information to process the
                payroll.We understand that is may cause a sightly delay,and we appreciate you understanding during
                this time.Rest assured that we have worked to simplify the process to male it as easy as possible
                for you.Thank you for your cooperation
            </p>
        </div>

        <div class="payroll-settings-cards ">
            <a href="/payroll/work_location"
                class="bg-blue-900   payroll-settings-content border-indigo-100  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/location.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Work Location</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100 ">[Office Location and State Confirmation]</span>
                </div>
                <div class="flex items-center col-4">
                    <button class="rounded-full text-green-200 text-sm border-1 border-solid border-green-300 py-1.5 px-4">
                        <i class="mr-2 fa fa-check-circle"></i> Completed</button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right " @click="test"></i>
                </div>
            </a>

            <a   href="/payroll/setup"
                class="bg-blue-900   payroll-settings-content border-orange-200  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/payroll.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Payroll Setup</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100 ">[General Setting,Salary Structure &
                        Compenents]</span>
                </div>
                <div class="flex items-center col-4">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>


                    <i class="ml-8 mr-6 text-xl font-bold fa fa-angle-double-right text-white-200 ">
                    </i>
                </div>
            </a>
            <a
                class="bg-blue-900   payroll-settings-content border-blue-200  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/categorize.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Misc Settings</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100">[Payment Setting and Components Rounding]</span>
                </div>
                <div class="flex items-center col-4 ">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right"></i>
                </div>
            </a>
            <a
                class="bg-blue-900   payroll-settings-content border-yellow-200  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/purchase-order.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Payslip</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100">[Payslip Option and Fields,Password
                        protections]</span>
                </div>
                <div class="flex items-center col-4">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right"></i>
                </div>
            </a>
            <a
                class="bg-blue-900   payroll-settings-content border-red-200  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center w-1/3">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/money-bag.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Full and Final Settlement</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100">[Opening & closing Notes,Notice Period Buy
                        Out]</span>
                </div>
                <div class="flex items-center col-4 ">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right"></i>
                </div>
            </a>
            <a
                class="bg-blue-900   payroll-settings-content border-green-600  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/donate.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Contribution Rate</span>
                </div>
                <div class="flex col-4 ">
                    <span class="text-sm font-semibold text-gray-100">[Manage PF Contribution Rate]</span>
                </div>
                <div class="flex items-center col-4 ">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right"></i>
                </div>
            </a>
            <a
                class="bg-blue-900   payroll-settings-content border-blue-200  cursor-pointer shadow-md text-white flex items-center justify-between rounded-lg p-2.5 ">
                <div class="flex items-center">
                    <!-- <img class="h-8" src="../../../../../../public/assets/images/dashboard/iencashment.png" alt=""> -->
                    <span class="ml-5 text-lg text-white">Leave Encashment</span>
                </div>
                <div class="flex col-4">
                    <span class="text-sm font-semibold text-gray-100">[Leave Encashment Policies Calculation]</span>
                </div>
                <div class="flex items-center col-4 ">
                    <button
                        class="rounded-full text-yellow-100 text-sm border-1 border-solid border-yellow-300 py-1.5 px-5">
                        <i class="mr-2 fa fa-exclamation-circle"></i> Pending
                    </button>
                    <i class="ml-8 mr-6 text-xl font-bold text-white fa fa-angle-double-right"></i>
                </div>
            </a>

        </div>





    </div>
</template>


<script setup>
import axios from "axios"



const test = () => {
    let app = this
    axios.get('/payroll/setup')
        .then(function (response) {
            app.brands = response.data
        })
        .catch(function (error) {
            console.log(error)
        })

}

</script>

<style scoped>
.payroll-settings-content {
    border-left: 4px solid;
    margin-bottom: 1.5em;
}

a.payroll-settings-content:hover {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    transform: scale(1);
}

a.payroll-settings-content:hover,
a.payroll-settings-content:hover span,
a.payroll-settings-content:hover,
a.payroll-settings-content:hover i {
    background-color: #fff !important;
    color: #023562 !important;
    transition: 0.2s ease-out;

}

a.payroll-settings-content:hover button {
    border: 1px solid #023562 !important;
    color: #023562 !important;
}

.page-content {
    padding: calc(30px + 1.5rem) calc(1.5rem / 2) 50px calc(1.5rem / 2);
}
</style>
