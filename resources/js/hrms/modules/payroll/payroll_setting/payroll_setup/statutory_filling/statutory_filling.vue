<template>

    <div class="mb-1 left-line">
        <div class="card ">
            <div class="card-body">
            <ul class="my-4 nav nav-pills nav-tabs-dashed " role="tablist">
                <li class="mx-4 nav-item text-muted " role="presentation">
                    <button class="pb-2 nav-link active" id="pills-offer-investment-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-offer-investment" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">professional Tax</button>
                </li>
                <li class="mx-4 nav-item text-muted " role="presentation">
                    <button class="pb-2 nav-link " id="pills-offer-proof-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-offer-proof" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Labour Welfare Fun</button>
                </li>

            </ul>


            <!-- y-4 nav nav-pills nav-tabs-dashed -->

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-offer-investment" role="tabpanel"
        aria-labelledby="pills-offer-investment-tab">
            <div class="card-body">
                <div class="offer-investment-content">
                    <professional_Tax />
                </div>
            </div>


    </div>
    <div class="tab-pane fade " id="pills-offer-proof" role="tabpanel"
        aria-labelledby="pills-offer-proof-tab">
            <div class="card-body">
                <div class="my-4 offer-pending-content">
                    <Labour_welfare_Fun />
                </div>
        </div>
    </div>

</div>

</div>
</div>
</div>

</template>


<script setup>

import { onMounted } from 'vue'
import  professional_Tax  from '../statutory_filling/professional_Tax/ProfeesionalTax.vue';
import  Labour_welfare_Fun from '../statutory_filling/Labour_welfare_Fund/Labour_welfare_Fun.vue';



</script>
