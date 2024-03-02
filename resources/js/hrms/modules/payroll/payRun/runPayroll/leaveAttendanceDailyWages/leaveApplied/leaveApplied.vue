<template>
    <div class=" investments-wrapper">
        <div class="">
            <div class="pt-1 pb-0 card-body">
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed flex gap-4" id="pills-tab" role="tablist">
                    <li class="nav-item ember-view" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Leave" role="tab" aria-controls="pills-home" aria-selected="true">
                            Rejected</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class=" nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Attendance" role="tab" aria-controls="pills-home" aria-selected="true">
                            Pending</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#LOP" role="tab" aria-controls="pills-home" aria-selected="true">
                            Approved</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content my-3" id="pills-tabContent">
            <div class="tab-pane fade active show" id="Leave" role="tabpanel" aria-labelledby="pills-home-tab">

            </div>

            <div class="tab-pane fade " id="Attendance" role="tabpanel">


            </div>
            <div class="tab-pane fade " id="LOP" role="tabpanel">


            </div>
        </div>
    </div>
    {{ usePayrun.leaveSource ?  filterCurrentResource(usePayrun.leaveSource,'Approved') : [] }}
</template>



<script setup>
import { payrunMainStore } from "../../../stores/payrunMainStore";

const usePayrun = payrunMainStore()


const filterCurrentResource = (source, status) => {

if (source) {
    let result = source.filter(ele => ele.status == status)
    return result
} else {
    let result = []
    return result

}
}

</script>
