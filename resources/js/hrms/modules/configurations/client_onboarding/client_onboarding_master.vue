<template>
    <div class="client-onboard-wrapper">
        <div class="mb-2 card left-line">
            <div class="pt-1 pb-0 card-body">
                <ul class="nav nav-pills nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item me-5 " role="presentation">
                        <a class="nav-link active " id="" data-bs-toggle="pill" href="" data-bs-target="#client-list"
                            role="tab" aria-controls="pills-home" aria-selected="true">
                            Client List
                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <a class="nav-link " id="" data-bs-toggle="pill" href="" data-bs-target="#client-onboarding"
                            role="tab" aria-controls="pills-home" aria-selected="true">
                            Client Onboarding
                        </a>
                    </li>

                </ul>

            </div>
        </div>
        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade active show" id="client-list" role="tabpanel" aria-labelledby="">
              <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <ClientList />
                    </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade " id="client-onboarding" role="tabpanel" aria-labelledby="">
                <ClientOnboarding />

            </div>
        </div>
    </div>
</template>


<script setup>
import ClientList from './client_list/client_list.vue';
import ClientOnboarding from './client_onboarding/client_onboarding.vue'



</script>
