<template>
    <div class="w-full p-2 bg-white rounded-lg">
        <div class="col-sm-12 col-xxl-6 col-md-6 col-xl-6 col-lg-6">
            <h2 class="my-2 text-lg font-semibold">Testing : Queues</h2>
        </div>
            <p></p>
    <button class=" bg-[#F9BE00] px-4 rounded-md text-[#000] h-[25px]"
                    @click="checkMailSpeed()">Send Queued Mail</button>


    </div>
</template>

<script setup>
import { useTestQueueStore } from './Test_QueuesService'

import { onMounted, ref } from 'vue';
const t_useTestQueueStore = useTestQueueStore()

onMounted(async () => {
    console.log(" Test_Queues.vue :  On Mounted completed ");

})

async function checkMailSpeed(){
    // var user_code =
    // var mail_content =

    await t_useTestQueueStore.checkMailSpeed('BA002',
                                            'This is the mail content',
                                            0);
}
</script>

