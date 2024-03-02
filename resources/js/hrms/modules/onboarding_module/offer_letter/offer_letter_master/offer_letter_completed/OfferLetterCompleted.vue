<template>
    <div>
        <DataTable :value="products" responsiveLayout="scroll" v-model:filters="filters"
            :globalFilterFields="['name', 'country.name', 'representative.name', 'status']">
            <template #header>
                <div class="flex justify-content-start align-items-center">

                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" class="w-100" placeholder="Keyword Search" />

                    </span>
                </div>
            </template>
            <Column field="candidate_id" header="Candidate ID"></Column>
            <Column field="candidate_name" header="Candidate Name"></Column>
            <Column field="candidate_role" header="Role"></Column>
            <Column field="candidate_offerPay" header="Offered Pay"></Column>
            <Column field="candidate_status" header="Status ">
                <template #body>

                    <button class="bg-transparent outline-none border-0 btn " @click="viewOffer"><span
                            class="me-1 font-medium"> Sent </span> <i class="fa text-muted fa-eye me-1"></i></button>
                    <!-- <button  class="bg-transparent outline-none border-0 btn "  @click="viewOffer"><span class="me-1 text-info font-medium">Accepted </span> <i class="fa text-muted fa-eye me-1"></i></button>
                        <button  class="bg-transparent outline-none border-0 btn "  @click="viewOffer"><span class="me-1 text-danger font-medium"> Declined </span> <i class="fa text-muted fa-eye me-1"></i></button> -->

                </template>
            </Column>
            <Column field="actions" header="Actions">
                <template #body>

                    <button class="btn btn-orange me-2" @click="revokeOffer">Revoke Offer</button>

                    <button class="btn btn-border-primary" @click="cancelOffer">Cancel Offer</button>

                </template>
            </Column>
        </DataTable>

    </div>
    <Dialog header="Header" v-model:visible="viewPopup" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '50vw' }">
        <div class="no-data-wrapper text-center mx-auto col-lg-5" id="">


        </div>

    </Dialog>
    <Dialog header="Header" v-model:visible="revokePopup" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '50vw' }">

        <div class="no-data-wrapper text-center mx-auto col-lg-5" id="">



        </div>
    </Dialog>
    <Dialog header="Cancelling the offer" v-model:visible="cancelPopup" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '50vw' }">
        <div class="" id="">
            <p class="font-medium fs-14 mb-1">Reason for cancelling</p>
            <textarea name="" id="" cols="" class="w-100 resize-none rounded" placeholder="Reason for cancelling" rows="3"></textarea>

            <p class="text-muted fs-10"><i class="fa fa-exclamation-circle text-muted me-1" aria-hidden="true"></i>The reason will be send to the candidate through mail</p>


        </div>
    </Dialog>
</template>



<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { FilterMatchMode, FilterOperator } from "primevue/api";

const products = ref();
const revokePopup = ref(false);
const cancelPopup = ref(false);
const viewPopup = ref(false);


const revokeOffer = () => {
    revokePopup.value = true
}

const viewOffer = () => {
    viewPopup.value = true
}

const cancelOffer = () => {
    cancelPopup.value = true
}



const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

onMounted(() => {
    products.value = getProductDetails().data;

    axios.get('https://jsonplaceholder.typicode.com/posts/1')
        .then((response) => {
            console.log("Axios : " + response.data.title);
        });

})

function getProductDetails() {
    return {
        "data": [
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "candidate_status": "pending", "actions": "" }



        ]
    };
}




</script>
