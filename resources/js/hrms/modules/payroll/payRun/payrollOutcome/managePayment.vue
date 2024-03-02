<template>
    <div class="w-full p-3">
        <div>
            <div class="flex my-1">
                <p class="font-bold fs-4">Employee Payables -{{ new Date().toLocaleString('default', { month: 'long', }) }}
                    {{ new Date().getFullYear() }}</p>
                <i class="pi pi-times"></i>
            </div>
            <p class="font-semibold fs-6">
                Payment batches
            </p>
        </div>
        <div class="card my-2">
            <div class="card-body">
                <div class="flex ">
                    <p class="font-semibold fs-5">Default batch for bank transfer</p>
                    <button class="btn btn-primary w-2">mark as paid</button>
                    <button class="mx-6">...</button>
                </div>
                <p class="text-gray-700 font-medium fs-6">Default batch for salary</p>
                <div class="my-4">
                    <p class="font-semibold fs-5 text-gray-700">
                        Employees
                    </p>
                    <p class="my-3 font-bold fs-5">189</p>
                </div>
            </div>
        </div>
        <div>
            <div></div>
            <div></div>
        </div>
    </div>
</template>