<template>
    <div class="bg-white rounded-lg p-2 ">
        <span class="text-primary font-semibold fs-6">Events</span>
        <div class="min-h-min overflow-y-scroll h-[200px]">
            <div class="grid grid-cols-4 gap-4 ">
                <div class=" relative  w-[180px] rounded-lg my-2 " v-for="(events, index) in useDashboard.allEventSource"
                    :key="index">
                    <div class="h-[80px] rounded-lg" :class="`${getBackgroundColor(index)}`">
                        <p class="font-semibold  text-center text-white my-2 text-[12px] font-['Poppins'] ">
                            {{ findEventType(events.type) }}
                        </p>
                    </div>
                    <div class="absolute top-8 w-full z-10 ">
                        <div class="grid grid-cols-2 w-11/12 bg-slate-100 mx-auto rounded-lg h-full">
                            <div class=" w-[100%] relative h-[90px]">
                                <!-- <img src="../../../assests/images/family.png" alt=""  class=" w-[100%] border-[4px] border-[#000] absolute "> -->
                                <div v-if="JSON.parse(events.avatar).type == 'shortname'" :class="getAvatarColor(index)"
                                    class="h-full rounded-lg ">
                                    <p class="font-semibold text-4xl py-4 text-center align-middle  text-white">{{
                                        JSON.parse(events.avatar).data }}</p>
                                </div>
                                <!-- <img src="../../../assests/images/evangelist.png" alt=""  class="rounded-lg absolute w-[100%] h-[100%] top-0"> -->
                                <img v-else :src="`data:image/png;base64,${JSON.parse(events.avatar).data}`" alt=""
                                    class="rounded-lg absolute w-[100%]  h-[100%] top-0">
                            </div>
                            <div class="h-full">
                                <div class="py-6">
                                    <p class="font-semibold text-[12px] font-['Poppins']  text-center text-black my-auto"
                                        v-if="events.name.length <= 8"> {{ events.name }}</p>
                                    <p class="font-semibold text-[12px] font-['Poppins']  text-center text-black my-auto"
                                        v-tooltip="events.name" v-else> {{ events.name ? events.name.substring(0, 8) + '..'
                                            : ''
                                        }}</p>
                                    <p class="font-semibold text-sm text-center text-gray-600 my-auto"> {{
                                        dayjs(events.dob).format('DD') }}th {{ dayjs(events.dob).format('MMM') }}</p>
                                    <p>
                                        <i v-tooltip="'wish'"
                                            class="text-xs absolute right-6 fa fa-commenting-o text-right cursor-pointer"
                                            data-bs-target="#wishes_popup" data-bs-toggle="modal"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center my-2">
                            <!-- <button class=" border-2 border-gray-300 rounded-lg p-1 px-10 hover:bg-gray-100">Wish Narasimma</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="my-3 event-wrapper">
        <div class="mb-0 overflow-x-hidden overflow-y-auto border-0 card">
            <div class="card-body">
                <div class="mb-3 f-18 text-primary" id=""> <span class="text-primary font-semibold fs-5">Events</span>
                </div>
                <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1 xxl:grid-cols-4 xl:grid-cols-4 lg:grid-cols-4"
                    style="display: grid;">
                    <div class="mb-3 card left-line" v-for="events in useDashboard.allEventSource" :key="events">
                        <div class="card-body flex">
                            <div>
                                <div class="text-left" style="width: 170px;">
                                    <p class=" text-muted font-semibold fs-5" style="width: 210px;">
                                        {{ events.name }}
                                    </p>
                                    <p class="fs-6 fw-bold text-orange program-day mt-2">
                                        {{ dayjs(events.dob).format('DD') }}th {{ dayjs(events.dob).format('MMM') }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <i style="font-size: 23px;
                                        transform: rotate(45deg);
                                        position: absolute;
                                        opacity: 0.4;
                                        right: 4px;
                                        top: 3px;" :class="findCurrentEvent(events.type)" class="fa text-orange fa-birthday-cake"></i>
                                <i style="font-size: 20px;
                                        position: absolute;
                                        top: 20px;
                                        right: 4px;
                                        " class=" f-15 fa fa-commenting-o text-right my-5 cursor-pointer"
                                    data-bs-target="#wishes_popup" data-bs-toggle="modal"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div id="wishes_popup" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="py-2 border-0 modal-header">
                    <h6 class="modal-title ">
                        Wishes Text</h6>
                    <button type="button" class="" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"><i class="pi pi-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p for="" class="text-muted f-14 fw-bold">Comments here</p>
                    <textarea name="" id="" cols="" placeholder="Comments here...." rows="2"
                        class="resize-none form-control"></textarea>
                    <div class="text-end">
                        <button class="mt-2 btn btn-border-orange" id=""><i class="fa fa-paper-plane me"
                                aria-hidden="true"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import dayjs from "dayjs";
import { ref } from "vue";
import { useMainDashboardStore } from "../stores/dashboard_service"
import { Service } from "../../Service/Service";


const service = Service()

const useDashboard = useMainDashboardStore()


const colors = [
    'bg-emerald-600',
    'bg-yellow-600',
    'bg-rose-600',
    'bg-cyan-600',
    'bg-amber-600',
    'bg-red-600',
    'bg-pink-600',
    'bg-green-600',
    'bg-fuchsia-600',
];

const avatarColors = [
    'bg-emerald-200',
    'bg-yellow-200',
    'bg-rose-200',
    'bg-cyan-200',
    'bg-amber-200',
    'bg-red-200',
    'bg-pink-200',
    'bg-green-200',
    'bg-fuchsia-200',
];

const getBackgroundColor = (index) => {
    return colors[index % colors.length];
};
const getAvatarColor = (index) => {
    return avatarColors[index % colors.length];
};

const findEventType = (type) => {
    if (type == 'birthday') {
        return 'Happy Birthday'
    } else
        if (type == 'work anniversery') {
            return 'Work Anniversary'
        }
}


</script>


<style>
.modal-backdrop{
    width: 0;
}
</style>

