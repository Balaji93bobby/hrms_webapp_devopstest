<template>
  <div>
    <div class=" w-full flex justify-between align-middle mt-[14px]">
      <div class=" d-flex align-items-center flex-wrap">
        <h1 class=" text-black text-[14px] tracking-wide" style="font-weight: 500 !important;">Total
          :<span>188</span></h1>

        <MultiSelect v-model="selectedCities" :options="cities" optionLabel="name" placeholder="Business Unit"
          :maxSelectedLabels="3" class="w-full md:w-14rem h-10 mx-[10px]" />


        <MultiSelect v-model="selectedCities" :options="cities" optionLabel="name" placeholder="Department"
          :maxSelectedLabels="3" class="w-full md:w-14rem  h-10 mx-[10px]" />


        <MultiSelect v-model="selectedCities" :options="cities" optionLabel="name" placeholder="Location"
          :maxSelectedLabels="3" class="w-full md:w-14rem  h-10 mx-[10px]" />
      </div>

      <!--  -->

    </div>
    <div style="position: relative; " class="">
      <div class="d-flex justify-content-between  align-items-center w-full">

        <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed border-none border-0" id="pills-tab" role="tablist">
          <li class=" nav-item" role="presentation">
            <a class="px-2 position-relative border-0" id="" data-bs-toggle="pill" href="" role="tab" aria-controls=""
              aria-selected="true" @click="activetab = 1" :class="[activetab === 1 ? ' text-black' : ' text-gray-500']">
              Pending
            </a>
            <div v-if="activetab === 1" class=" border-3 h-1 rounded-l-3xl border-orange-400"></div>
            <div v-else class=" border-3 h-1 rounded-l-3xl border-gray-400"></div>
          </li>
  
          <li class=" nav-item position-relative  border-0" role="presentation">
            <a class=" text-center px-2  border-0 " id="" data-bs-toggle="pill" href="" @click="activetab = 2"
              :class="[activetab === 2 ? ' text-black' : ' text-gray-500']" role="tab" aria-controls=""
              aria-selected="true">
              Payment Initiated
            </a>
            <div v-if="activetab === 2" class=" border-3 h-1  border-orange-400 position-absolute left-0 w-12"></div>
            <div v-else class=" border-3 h-1  border-gray-400"></div>
          </li>
          <li class=" nav-item position-relative  border-0" role="presentation">
            <a class=" text-center px-2  border-0 " id="" data-bs-toggle="pill" href="" @click="activetab = 3"
              :class="[activetab === 3 ? ' text-black' : ' text-gray-500']" role="tab" aria-controls=""
              aria-selected="true">
              Paid
            </a>
            <div v-if="activetab === 3" class=" border-3 h-1  border-orange-400 position-absolute left-0 w-12"></div>
            <div v-else class=" border-3 h-1  border-gray-400"></div>
          </li>
          <li class=" nav-item position-relative  border-0" role="presentation">
            <a class=" text-center px-2  border-0 " id="" data-bs-toggle="pill" href="" @click="activetab = 4"
              :class="[activetab === 4 ? ' text-black' : ' text-gray-500']" role="tab" aria-controls=""
              aria-selected="true">
              Rejected
            </a>
            <div v-if="activetab === 4" class=" border-3 h-1 rounded-r-3xl border-orange-400 position-absolute left-0 w-12">
            </div>
            <div v-else class=" border-3 h-1 rounded-r-3xl border-gray-400"></div>
          </li>
        </ul>

        <div class=" w-4  d-flex justify-content-center align-items-center ">
          <div class=" mx-2">
            <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText placeholder="Search" 
                    class=" " style="height: 3em" />
            </span>
        </div>
          <button class=" rounded-md px-4 py-1 border  fs-6 h-10" @click="btn_download = !btn_download"> 
            <div id="btn-download" style=" position: absolute; right: 0;"
              :class="[btn_download == true ? toggleClass : 'toggleClass', 'toggleClass']">
              <svg width="22px" height="16px" viewBox="0 0 22 16">
                <path
                  d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15"
                  id="check"></path>
                <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                <path d="M8,1 L8,11" class="svg-out"></path>
              </svg>
            </div>
            <p class=" position-relative left-2">Download</p>
  
          </button>
  
        </div>

      </div>

      <!-- <div class="p-4 pt-1 pb-0 mb-3 mr-4 bg-white rounded-lg tw-card left-line"> -->
  


    
      <!-- </div> -->
      <!-- Tab Content -->
      <div class="tab-content  " id="">
        <div>
          <div class="card-body">
            <div v-if="activetab === 1">
              <payment_pending />
            </div>
            <div v-if="activetab === 2">
              <payment_initiated />
            </div>
            <div v-if="activetab === 3">
              <payment_paid />
            </div>
            <div v-if="activetab === 4">
              <payment_Rejected />
            </div>
          </div>
        </div>


      



      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import payment_initiated from './Payment_Initiated.vue';
import payment_paid from './payment_paid.vue';
import payment_Rejected from './payment_Rejected.vue';
import payment_pending from './paymentPending.vue';


const selectedCities = ref();
const activetab = ref(1);
const cities = ref([
  { name: 'New York', code: 'NY' },
  { name: 'Rome', code: 'RM' },
  { name: 'London', code: 'LDN' },
  { name: 'Istanbul', code: 'IST' },
  { name: 'Paris', code: 'PRS' }
]);

const toggleClass = ref('downloaded');

const btn_download = ref(false);

</script>

<style lang="sass" scoped>

#btn-download
  cursor: pointer
  display: block
  width: 48px
  height: 48px
  border-radius: 50%
  -webkit-tap-highlight-color: transparent
  //transform: scale(2)
  //centering
  position: absolute
  top: calc(50% - 24px)
  left: calc(14% - 24px)
  &:hover
    background: rgba(#223254,.03)
  svg
    margin: 16px 0 0 16px
    fill: none
    transform: translate3d(0,0,0)
    polyline,
    path
      stroke: #000
      stroke-width: 2
      stroke-linecap: round
      stroke-linejoin: round
      transition: all .3s ease
      transition-delay: .3s
    path#check
      stroke-dasharray: 38
      stroke-dashoffset: 114
      transition: all .4s ease
  &.downloaded
    svg
      .svg-out
        opacity: 0
        animation: drop .3s linear
        transition-delay: .4s
      path#check
        stroke: #20CCA5
        stroke-dashoffset: 174
        transition-delay: .4s

@keyframes drop
  20%
    transform: (translate(0, -3px))
  80%
    transform: (translate(0, 2px))
  95%
    transform: (translate(0, 0))


</style>
