<template>
  <div
    class="relative w-full flex flex-col items-start justify-start text-left text-sm text-black font-poppins p-[6px]"
  >
    <div class="self-stretch flex flex-col items-start justify-start gap-[8px]">
      <div class="flex flex-col items-start justify-start text-[20px]">
        <div class="relative font-semibold">Resignation</div>
      </div>
      <div
        class="self-stretch flex flex-row items-center justify-start gap-[20px]"
      >
        <div class="flex-1 relative text-[12px]">
          Here you can apply for resignation and you can able to see the
          resignation status here.
        </div>
        <button
          class="rounded-md bg-cornflowerblue flex flex-row items-start justify-start py-1.5 px-[24px] cursor-pointer text-white bg-sky-600 hover:bg-sky-700"
          @click="visibleRight = true"
        >
          Apply Resignation
        </button>
      </div>
      <div
        class="relative box-border self-stretch h-2px border-t-[1px] border-solid border-color-[#dddddd]"
      ></div>
      <div
        class="self-stretch rounded-md bg-[#FFF1DD] overflow-hidden flex flex-row flex-wrap items-center justify-start p-[12px] gap-[40px] text-mild-grey"
      >
        <div class="flex gap-20 p-2">
          <div class="p-2">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Date of Resignation Initiated
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >10/08/2023</span
              >
            </p>
          </div>
          <div class="p-2">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Resignation Type
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >Better Prospect</span
              >
            </p>
          </div>
          <div class="p-2">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Notice Period Date
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >10/08/2023</span
              >
            </p>
          </div>
          <div class="p-2">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Expected Last working day
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >10/08/2023</span
              >
            </p>
          </div>
          <div class="p-2">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Payroll Processed Date
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >10/08/2023</span
              >
            </p>
          </div>
          <div class="p-2 pl-5">
            <p
              class="flex flex-col justify-start items-start font-[poppins] gap-2 font-medium text-[14px] text-[#8B8B8B]"
            >
              Status
              <span class="font-[poppins] font-medium text-[14px] text-[#000]"
                >Pending</span
              >
            </p>
          </div>
          <button class="p-1">
            <i class="pi pi-ellipsis-v" @click="toggle"></i>
          </button>
        </div>

        <!-- <div
          class="flex-1 flex flex-row flex-wrap items-center justify-start gap-[20px]"
        >
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">Initiated Date</div>
            <div class="relative font-medium text-black">10/08/2023</div>
          </div>
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">Resignation Type</div>
            <div class="relative font-medium text-black">Better Prospect</div>
          </div>
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">
              Notice Period Date
            </div>
            <div class="relative font-medium text-black">10/08/2023</div>
          </div>
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">
              Expected Last working day
            </div>
            <div class="relative font-medium text-black">10/08/2023</div>
          </div>
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">
              Payroll Processed Date
            </div>
            <div class="relative font-medium text-black">10/08/2023</div>
          </div>
          <div
            class="w-[168px] flex flex-col items-start justify-start gap-[6px]"
          >
            <div class="relative font-medium text-[#888]">Status</div>
            <div class="relative font-medium text-black">Pending</div>
          </div>
        </div> -->

        <OverlayPanel ref="op">
          <div class="flex flex-col justify-center items-center p-0 m-0">
            <button
              class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
            >
              Edit
            </button>
            <button
              class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
            >
              Delete
            </button>
            <button
              class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
            >
              Withdraw
            </button>
          </div>
        </OverlayPanel>
      </div>
    </div>
    <!-- {{ visibleRight }} -->

    <Sidebar v-model:visible="visibleRight" position="right" class="!w-[30%]">
      <!-- class=" !w-[40%]" -->

      <template #header>
        <div
          class="bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0"
        >
          <h1 class="m-4 text-[#ffff] font-['poppins] font-semibold">
            Resignation Apply
          </h1>
        </div>
      </template>
      <div class="border-box p-3">
        <div class="grid rid-cols-6">
          <div class="col-span-6 mx-2 mb-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Date of Resignation Initiated</label
            >
            <Calendar
              class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[40px] border-[1px] border-[#BBBBBB] rounded"
              v-model="date"
              placeholder="YY-MM-DD"
              dateFormat="yy-mm-dd"
            />
            <!-- <InputText class="w-[80%] my-2 text-[#8B8B8B] font-[poppins] text-[16px] h-[44px]" placeholder="DD/MM/YYYY"></InputText> -->
          </div>

          <div class="col-span-6 mx-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Resignation Type</label
            >
            <Dropdown
              v-model="selectedResignationType"
              :options="useResignation.getResignationDropdown"
              showClear
              optionLabel="reason_type"
              optionValue="id"
              class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[40px] border-[1px] border-[#BBBBBB]"
              placeholder="Choose Resignation type"
            />
          </div>

          <div v-if="selectedResignationType == 5 " class="col-span-6 mx-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Other Reson for Resignation
            </label>
            <Textarea
              class="p-1 w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] border-[1px] border-[#BBBBBB]"
              v-model="value"
              autoResize
              rows="5"
              placeholder="Enter your Comments"
            ></Textarea>
          </div>

          <div class="col-span-6 mx-2 my-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Notice Period Days</label
            >
            <InputText
              class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[40px] border-[1px] border-[#BBBBBB] rounded"
              v-model="useResignation.noticedperiodDay"
           :disabled = "useResignation.noticedperiodDay != 0"
            />
          </div>
          <div class="col-span-6 mx-2">
            <label
              class="font-[poppins] text-[14px] font-medium text-[#000]"
              for="icondisplay"
              >Expected Last working day</label
            >
            <Calendar
              class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[40px] border-[1px] border-[#BBBBBB] rounded"
              
              v-model="useResignation.lastworkingDay"
              showIcon
              iconDisplay="input"
              inputId="icondisplay"
               placeholder="YY-MM-DD"
              dateFormat="yy-mm-dd"
            />
          </div>

          <div class="col-span-6 mx-2 my-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Payroll Process Date</label
            >
            <Calendar
              class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[40px] border-[1px] border-[#BBBBBB] rounded"
              v-model="useResignation.lastpayrollDate"
               placeholder="YY-MM-DD"
              dateFormat="yy-mm-dd"
              disabled
            />
          </div>
          <div v-if="useResignation.expectedworkingday !=  dayjs(useResignation.lastworkingDay).format('YYYY-MM-DD')" class="col-span-6 mx-2">
            <label class="font-[poppins] text-[14px] font-medium text-[#000]"
              >Reason for Change in Last Working Date
            </label>
            <Textarea
              class="p-1 w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] border-[1px] border-[#BBBBBB]"
              v-model="value"
              autoResize
              rows="5"
              placeholder="Enter your Comments"
            ></Textarea>
          </div>

          <div class="col-span-6 gap-2 flex justify-center items-center my-2">
            <button
              class="border-[1px] text-[#001820] bg-[#fff] border-[#001820] rounded p-1 w-[15%] font-[poppins] text-[14px]"
            >
              Save
            </button>
            <button
              class="border-[1px] bg-[#001820] text-[#fff] border-[#001820] rounded p-1 w-[20%] font-[poppins] text-[14px]"
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </Sidebar>
  </div>
</template>


  <!-- <template>
    <div class="w-full p-[6px] flex-col justify-start items-start inline-flex">
    <div class="justify-start items-center gap-2 inline-flex">
        <div class="w-6 h-6 relative origin-top-left rotate-90"></div>
        <div class="text-slate-900 text-xl font-medium font-['Poppins'] leading-[30px]">Back</div>
    </div>
    <div class="self-stretch px-2 pt-2.5 pb-6 bg-neutral-100 rounded flex-col justify-start items-start gap-2.5 flex">
        <div class="self-stretch justify-start items-start gap-2.5 inline-flex">
            <div class="text-slate-900 text-xl font-semibold font-['Poppins'] leading-[30px]">Lead Timeline</div>
        </div>
        <div class="self-stretch pl-3 pr-5 py-3 bg-neutral-300 rounded-md flex-col justify-start items-start flex">
            <div class="self-stretch flex-col justify-start items-start flex">
                <div class="self-stretch justify-start items-center inline-flex">
                    <div class="justify-start items-center gap-[12px] flex">
                        <div class="w-[40px] h-[40px] p-2.5 bg-neutral-100 rounded-[25px] flex-col justify-center items-center gap-2.5 inline-flex">
                            <p class="text-center text-black text-[16px] font-medium font-['Poppins']">10</p>
                        </div>
                        <div class="justify-start items-start gap-3 flex">
                            <div class="text-black text-[14px] font-semibold font-['Poppins']">Order Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="self-stretch pl-[19px] justify-start items-center gap-[6px] inline-flex">
                    <div class="w-[2px] mr-[24px] self-stretch border border-black"></div>
                    <div class="self-stretch py-3 flex-col justify-start items-start gap-2.5 inline-flex">
                        <div class="self-stretch px-3 py-2.5 bg-white rounded-lg border border-neutral-200 justify-between items-start inline-flex">
                            <div class="grow shrink basis-0"><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">Order Dispatched (Delivery Challan - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">DC10032</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">) via </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Porter Transportation</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]"> (Transportation Mobile Number - 9876543210), approved by Sales and Marketing Staff - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Praveen Kumar (ABS1002) </span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">on</span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]"> 20-Oct-2023</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="self-stretch flex-col justify-start items-start flex">
                <div class="self-stretch justify-start items-center inline-flex">
                    <div class="justify-start items-center gap-[12px] flex">
                        <div class="w-[40px] h-[40px] p-2.5 bg-neutral-100 rounded-[25px] flex-col justify-center items-center gap-2.5 inline-flex">
                            <p class="text-center text-black text-[16px] font-medium font-['Poppins']">10</p>
                        </div>
                        <div class="justify-start items-start gap-3 flex">
                            <div class="text-black text-[14px] font-semibold font-['Poppins']">Order Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="self-stretch pl-[19px] justify-start items-center gap-[6px] inline-flex">
                    <div class="w-[2px] mr-[24px] self-stretch border border-black"></div>
                    <div class="self-stretch py-3 flex-col justify-start items-start gap-2.5 inline-flex">
                        <div class="self-stretch px-3 py-2.5 bg-white rounded-lg border border-neutral-200 justify-between items-start inline-flex">
                            <div class="grow shrink basis-0"><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">Order Dispatched (Delivery Challan - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">DC10032</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">) via </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Porter Transportation</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]"> (Transportation Mobile Number - 9876543210), approved by Sales and Marketing Staff - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Praveen Kumar (ABS1002) </span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">on</span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]"> 20-Oct-2023</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="self-stretch flex-col justify-start items-start flex">
                <div class="self-stretch justify-start items-center inline-flex">
                    <div class="justify-start items-center gap-[12px] flex">
                        <div class="w-[40px] h-[40px] p-2.5 bg-neutral-100 rounded-[25px] flex-col justify-center items-center gap-2.5 inline-flex">
                            <p class="text-center text-black text-[16px] font-medium font-['Poppins']">10</p>
                        </div>
                        <div class="justify-start items-start gap-3 flex">
                            <div class="text-black text-[14px] font-semibold font-['Poppins']">Order Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="self-stretch pl-[19px] justify-start items-center gap-[6px] inline-flex">
                    <div class="w-[2px] mr-[24px] self-stretch border border-black"></div>
                    <div class="self-stretch py-3 flex-col justify-start items-start gap-2.5 inline-flex">
                        <div class="self-stretch px-3 py-2.5 bg-white rounded-lg border border-neutral-200 justify-between items-start inline-flex">
                            <div class="grow shrink basis-0"><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">Order Dispatched (Delivery Challan - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">DC10032</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">) via </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Porter Transportation</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]"> (Transportation Mobile Number - 9876543210), approved by Sales and Marketing Staff - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Praveen Kumar (ABS1002) </span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">on</span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]"> 20-Oct-2023</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="self-stretch flex-col justify-start items-start flex">
                <div class="self-stretch justify-start items-center inline-flex">
                    <div class="justify-start items-center gap-[12px] flex">
                        <div class="w-[40px] h-[40px] p-2.5 bg-neutral-100 rounded-[25px] flex-col justify-center items-center gap-2.5 inline-flex">
                            <p class="text-center text-black text-[16px] font-medium font-['Poppins']">10</p>
                        </div>
                        <div class="justify-start items-start gap-3 flex">
                            <div class="text-black text-[14px] font-semibold font-['Poppins']">Order Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="self-stretch pl-[19px] justify-start items-center gap-[6px] inline-flex">
                    <div class="w-[2px] mr-[24px] self-stretch border border-black"></div>
                    <div class="self-stretch py-3 flex-col justify-start items-start gap-2.5 inline-flex">
                        <div class="self-stretch px-3 py-2.5 bg-white rounded-lg border border-neutral-200 justify-between items-start inline-flex">
                            <div class="grow shrink basis-0"><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">Order Dispatched (Delivery Challan - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">DC10032</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">) via </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Porter Transportation</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]"> (Transportation Mobile Number - 9876543210), approved by Sales and Marketing Staff - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Praveen Kumar (ABS1002) </span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">on</span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]"> 20-Oct-2023</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="self-stretch flex-col justify-start items-start flex">
                <div class="self-stretch justify-start items-center inline-flex">
                    <div class="justify-start items-center gap-[12px] flex">
                        <div class="w-[40px] h-[40px] p-2.5 bg-neutral-100 rounded-[25px] flex-col justify-center items-center gap-2.5 inline-flex">
                            <p class="text-center text-black text-[16px] font-medium font-['Poppins']">10</p>
                        </div>
                        <div class="justify-start items-start gap-3 flex">
                            <div class="text-black text-[14px] font-semibold font-['Poppins']">Order Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="self-stretch pl-[19px] justify-start items-center gap-[6px] inline-flex">
                    <div class="w-[2px] mr-[24px] self-stretch border border-black"></div>
                    <div class="self-stretch py-3 flex-col justify-start items-start gap-2.5 inline-flex">
                        <div class="self-stretch px-3 py-2.5 bg-white rounded-lg border border-neutral-200 justify-between items-start inline-flex">
                            <div class="grow shrink basis-0"><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">Order Dispatched (Delivery Challan - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">DC10032</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">) via </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Porter Transportation</span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]"> (Transportation Mobile Number - 9876543210), approved by Sales and Marketing Staff - </span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]">Praveen Kumar (ABS1002) </span><span style="text-black text-sm font-normal font-['Poppins'] leading-[30px]">on</span><span style="text-black text-sm font-semibold font-['Poppins'] leading-[30px]"> 20-Oct-2023</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  </template> -->
 <script setup>
import { ref,onMounted } from "vue";
import dayjs from "dayjs"
import {useResignationStore} from '../resignation/store/self_resignation'
const useResignation = useResignationStore()
onMounted(async ()=>{
  await useResignation.getResignationType()
   useResignation.employeeResignationDetails()
})
const changeworkingday = useResignation.lastworkingDay
const visibleRight = ref(false);
const date = ref();
const op = ref();
const toggle = (event) => {
  op.value.toggle(event);
};

const lastWorking = dayjs(useResignation.lastworkingDay).format('YYYY-MM-DD')

const selectedResignationType = ref('');


// const resignation_type = ref([
//   {
//     id: 1,
//     type: "Better Prospect",
//   },
//   {
//     id: 2,
//     type: "Better Prospect",
//   },
//   {
//     id: 3,
//     type: "Better Prospect",
//   },
//   {
//     id: 4,
//     type: "Better Prospect",
//   },
// ]);
</script>

<style>
.p-inputtext {
  /* background: #BBBBBB; */
  font-family: poppins;
  padding-left: 2px;
}
.p-dropdown-item {
  font-family: poppins;
  font-size: 14px;
  color: #001820;
}

.p-inputtext:enabled:hover {
  border-color: none !important;
  outline: none !important;
}

.p-overlaypanel .p-overlaypanel-content {
  padding: 0 !important;
}
.p-calendar-w-btn .p-datepicker-trigger {
  border: none !important;
  color: #001820;
}
</style>
