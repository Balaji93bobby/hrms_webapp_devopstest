<template>
    <div class="offer-letter-wrapper mt-30">
        <div class="card  left-line mb-2">
            <div class="card-body  pb-0 pt-1">

                <ul class="nav nav-pills nav-tabs-dashed " role="tablist">
                    <li class="nav-item text-muted" role="presentation">
                        <button class="nav-link active pb-2" id="pills-offer-pending-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-pending" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true"> Pending</button>
                    </li>
                    <li class="nav-item text-muted mx-4 " role="presentation">
                        <button class="nav-link pb-2" id="pills-offer-completed-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-completed" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Completed</button>
                    </li>
                    <li class="nav-item text-muted" role="presentation">
                        <button class="nav-link pb-2" id="pills-offer-resent-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-offer-resent" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Resent</button>
                    </li>
                </ul>

            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane  fade " id="offer_completed" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="card mb-0">
                    <div class="card-body">
                        <div id="offerletter_completedTable" style=""></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane  fade " id="offer_resent" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="card mb-0">
                    <div class="card-body">

                        <div id="offerletter_resentTable" class="no-customize" style=""></div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-offer-pending" role="tabpanel"
            aria-labelledby="pills-offer-pending-tab">
            <div class="card ">
                <div class="card-body">
                    <div class="offer-pending-content">
                        <OfferLetterPending />
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane fade  active" id="pills-offer-completed" role="tabpanel"
            aria-labelledby="pills-offer-completed-tab">
            <div class="card ">
                <div class="card-body">
                    <div class="offer-pending-content">
                        <OfferLetterCompleted />
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane  fade " id="pills-offer-resent" role="tabpanel"
            aria-labelledby="pills-offer-resent-tab">
            <div class="card">
                <div class="card-body">
                    <div class="offer-pending-content">
                        <OfferLetterResent />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <router-view></router-view>
</template>


<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import OfferLetterPending from './offer_letter_pending/OfferLetterPending.vue';
import OfferLetterCompleted from './offer_letter_completed/OfferLetterCompleted.vue';
import OfferLetterResent from './offer_letter_resent/OfferLetterResent.vue';

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>
