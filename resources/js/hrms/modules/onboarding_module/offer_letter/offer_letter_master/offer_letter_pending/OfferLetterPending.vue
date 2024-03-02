<template>
    <div>

        <div class="tab-pane show fade active" id="offer_pending" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card ">
                <div class="card-body">
                    <div class="offer-pending-content">
                        <div class="row">
                            <div class="col-xl-8 col-sm-8 col-lg-8 col-md-8 col-xxl-8"><span
                                    class="text-muted font-medium">Here you
                                    can
                                    view the saved offer letters to be sent</span></div>
                            <div class="col-xl-4 col-sm-4 col-lg-4 col-md-4 col-xxl-4 text-end">
                                <button  class="btn btn-orange">
                                    <i class=" fa fa-plus-circle me-1"></i>
                                    <router-link active-class="active" class="text-white" to="/offer_letter_generation">
                                        Create offer</router-link>
                                </button>
                            </div>
                        </div>
                        <div id="offerletter_pending" class="" style=""></div>
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-body">
                    <div class="offer-delete-content">
                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 col-xxl-12"><span
                                    class="text-muted font-medium">
                                    Deleted offer letters are stored here for 10 days</span>
                            </div>
                            <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 col-xxl-12">
                                <div id="deleted_offerletter" style=""></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <DataTable :value="products" :paginator="true" :rows="10" dataKey="id" :rowHover="true" :paginatorPosition="right"
            v-model:selection="selectedCustomers" v-model:filters="filters" filterDisplay="menu" :loading="loading"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[10, 25, 50]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            responsiveLayout="scroll" :filters="filters"
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

            <Column field="actions" header="Actions">
                <template #body>
                    <!-- <Button label="" class="bg-transparent text-dark me-3 outline-none border-0 h-25 w-25 p-0" icon="pi pi-pencil" @click="display"  />
                    <Button label="" class="bg-transparent text-danger outline-none border-0 h-25 w-25 p-0" icon="pi pi-trash" @click="display"  /> -->

                    <button class="btn fs-15 fa fa-pencil-square-o  bg-transparent outline-none border-0 me-1" @click="display"></button>
                    <button class="btn fs-15 fa fa-trash text-danger bg-transparent outline-none border-0" @click="display"></button>

                </template>
            </Column>
        </DataTable>

    </div>
    <Dialog header="Header" v-model:visible="displayBasic" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '50vw' }">
        <p></p>

    </Dialog>
    <router-view></router-view>
</template>




<script setup>

import { ref, onMounted } from 'vue';
import { initFlowbite } from 'flowbite'

import axios from 'axios';
import { FilterMatchMode, FilterOperator } from "primevue/api";

const products = ref();
const displayBasic = ref(false)


const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

onMounted(() => {
    initFlowbite();
    products.value = getProductDetails().data;

    axios.get('https://jsonplaceholder.typicode.com/posts/1')
        .then((response) => {
            console.log("Axios : " + response.data.title);
        });

})

const display = () => {
    displayBasic.value = true
}

function getProductDetails() {
    return {
        "data": [
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" },
            { "candidate_id": "ABS001", "candidate_name": "Joe", "candidate_role": "UI designer", "candidate_offerPay": "5L,Net", "actions": "" }

        ]
    };
}





</script>


<style >


.p-datatable .p-datatable-thead>tr>th {
    text-align: center;
    padding: 1.3rem 1rem;
    border: 1px solid #dee2e6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-width: 0 0 1px 0;
    font-weight: 600;
    color: #fff;
    background: #003056;
    transition: box-shadow 0.2s;
    font-size: 13px;
}

</style>
