<template>
    <div class="w-full p-1">
        <div class="">
            <div class="pt-1 pb-0 card-body">
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed flex gap-4" id="pills-tab" role="tablist">
                    <li class="nav-item ember-view" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Leave" role="tab" aria-controls="pills-home" aria-selected="true">
                            Leave Applied</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Attendance" role="tab" aria-controls="pills-home" aria-selected="true">
                            Attendance</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#LOP" role="tab" aria-controls="pills-home" aria-selected="true">
                            LOP Summary</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Revoke " role="tab" aria-controls="pills-home" aria-selected="true">
                            Revoke LOP </a>
                    </li>
                </ul>
            </div>
        </div>
        <p class="py-2 rounded-lg flex w-10/12 justify-start  font-semibold fs-6">All leave (approved or pending) that falls under
            this payroll cycle month will be displayed here.</p>
        <!-- <div class="p-2 rounded-lg card my-2">

        </div> -->
        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade active show" id="Leave" role="tabpanel" aria-labelledby="pills-home-tab">
                <leaveApplied />
            </div>

            <div class="tab-pane fade " id="Attendance" role="tabpanel">

            </div>
            <div class="tab-pane fade " id="LOP" role="tabpanel">


            </div>
            <div class="tab-pane fade " id="Revoke" role="tabpanel">


            </div>

        </div>
    </div>
</template>

<script setup>

import { onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import leaveApplied from "./leaveApplied/leaveApplied.vue";




const router = useRouter();
const route = useRoute();
onMounted(() => {
    console.log(route.params.module);


})
</script>
