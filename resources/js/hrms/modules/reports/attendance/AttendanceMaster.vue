<template>
    <div class="px-2">
        <div class="flex justify-between mb-[10px]">
            <h1 class=" text-black text-[24px] font-semibold ">Attendance Reports</h1>
            <div class="flex items-center ">
                <button @click="EmployeeMaster.clearfilterBtn(Reports_store.activetab),Reports_store.clearDataTable()"
                    class=" flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px] !bg-[#E6E6E6] mx-2 rounded-[4px] "><i
                        class="mr-2 pi pi-times"></i> Clear Filter</button>
                        <!-- useEmployeeReport.updateEmployeeApplyFilter(activetab) -->
                        <button @click="Reports_store.updateAttendanceReports(Reports_store.activetab)"
                    class="my-2 flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px]  bg-[#F9BE00]  mx-2 rounded-[4px] "><i
                        class="mr-2 pi pi-filter"></i> Run</button>
            </div>
        </div>
        <div style="position: relative;">
            <div class="flex justify-between">
                <ul class="flex mb-3 divide-x max-[1300px]:!w-[40%] max-[1400px]:![50%] nav nav-pills divide-solid nav-tabs-dashed max-[1024px]:w-[100%]"
                    id="pills-tab" role="tablist">
                    <li class="nav-item !border-0  text-center font-['poppins'] text-[14px] text-[#001820]"
                        role="presentation">
                        <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820] w-[100%]"
                            id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="Reports_store.activetab = 1,EmployeeMaster.clearfilterBtn(activetab),Reports_store.clearDataTable()"
                            :class="[Reports_store.activetab === 1 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            DETAILED REPORT
                        </a>
                    </li>

                    <li class=" nav-item  !border-0  flex items-center " role="presentation">
                        <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                            id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="Reports_store.activetab = 2,EmployeeMaster.clearfilterBtn(activetab),Reports_store.clearDataTable()"
                            :class="[Reports_store.activetab === 2 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            MUSTER ROLL
                        </a>


                    </li>
                    <li class=" nav-item  !border-0  flex items-center " role="presentation">
                        <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                            id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="Reports_store.activetab = 3,EmployeeMaster.clearfilterBtn(activetab),Reports_store.clearDataTable()"
                            :class="[Reports_store.activetab === 3 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            CONSOLIDATE
                        </a>

                    </li>
                    <li class=" nav-item  !border-0  flex items-center " role="presentation">
                        <a class="px-4 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                            id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="Reports_store.activetab = 4,EmployeeMaster.clearfilterBtn(activetab),Reports_store.clearDataTable()"
                            :class="[Reports_store.activetab === 4 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            OVERTIME
                        </a>
                    </li>
                    <li class=" nav-item !border-0  flex items-center " role="presentation">
                        <a class="px-2 position-relative  font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                            id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                            @click="Reports_store.activetab = 5,EmployeeMaster.clearfilterBtn(activetab),Reports_store.clearDataTable()"
                            :class="[Reports_store.activetab === 5 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                            OTHERS
                        </a>
                    </li>
                </ul>

                <ul
                    class=" flex justify-between max-[1300px]:w-[60%] max-[1400px]:![50%] max-[1200px]:justify-start flex-wrap max-[1024px]:w-[100%]">
                    <li class="flex items-center">
                        <h1 class="text-[12px] text-black mx-1 font-semibold font-['poppins']">Period : </h1>
                        <Dropdown optionLabel="month" optionValue="date" :options="EmployeeMaster.PeriodMonth"
                            v-model="EmployeeMaster.period_Date"
                            @change="Reports_store.getSelectoption('date', EmployeeMaster.period_Date, Reports_store.activetab)"
                            placeholder="-- Select --"
                            class="w-[120px]  mx-1 !h-10 my-1  !font-semibold !font-['poppins'] !text-[#000] !bg-[#E6E6E6]" />
                    </li>
                    <li class="flex items-center">
                        <h1 class="text-[12px] text-black mx-2 font-semibold  font-['poppins']">Department : </h1>
                        <MultiSelect v-model="EmployeeMaster.Department" :options="EmployeeMaster.department"
                            optionLabel="name" placeholder="-- Select --"
                            @change="Reports_store.getSelectoption('department', EmployeeMaster.Department, Reports_store.activetab)"
                            optionValue="id" :maxSelectedLabels="3"
                            class="min-w-[100px] w-[140px] my-1  !font-semibold !font-['poppins'] !h-10 text-[#000] !bg-[#E6E6E6]" />
                    </li>
                    <li class="flex items-center">
                        <h1 class="text-[12px] text-black mx-1 font-semibold  font-['poppins'] ">Legal Entity : </h1>
                        <MultiSelect
                            @change="Reports_store.getSelectoption('legal_entity', EmployeeMaster.legal_Entity, Reports_store.activetab)"
                            v-model="EmployeeMaster.legal_Entity" :options="EmployeeMaster.client_ids"
                            optionLabel="client_fullname" placeholder="-- Select --" optionValue="id" :maxSelectedLabels="3"
                            class="min-w-[100px] w-[140px] my-1  !font-semibold !font-['poppins'] !h-10 text-[#000] !bg-[#E6E6E6]" />
                    </li>
                </ul>

            </div>

            <div class=" border-[1px ] border-[#000]" v-if="Reports_store.activetab == 5">
                <ul class="flex mb-3 divide-x max-[1300px]:!w-[60%] max-[1400px]:![70%] nav nav-pills divide-solid nav-tabs-dashed max-[1024px]:w-[100%]"
                id="pills-tab" role="tablist">
                <li class="nav-item !border-0  text-center font-['poppins'] text-[14px] text-[#001820]"
                    role="presentation">
                    <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820] w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 1"
                        :class="[Reports_store.attendance_Type === 1 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        Late Coming
                    </a>
                </li>

                <li class=" nav-item  !border-0  flex items-center " role="presentation">
                    <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 2"
                        :class="[Reports_store.attendance_Type === 2 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        Early Going
                    </a>


                </li>
                <li class=" nav-item  !border-0  flex items-center " role="presentation">
                    <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 3"
                        :class="[Reports_store.attendance_Type === 3 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        Absent
                    </a>

                </li>
                <li class=" nav-item  !border-0  flex items-center " role="presentation">
                    <a class="px-4 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 4"
                        :class="[Reports_store.attendance_Type === 4 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        Half-Day Absent
                    </a>
                </li>
                <li class=" nav-item  !border-0  flex items-center " role="presentation">
                    <a class="px-2 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 5"
                        :class="[Reports_store.attendance_Type === 5 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        MIP
                    </a>

                </li>
                <li class=" nav-item  !border-0  flex items-center " role="presentation">
                    <a class="px-4 position-relative font-['poppins'] text-[14px] text-[#001820]  w-[100%]"
                        id="" data-bs-toggle="pill" href="" role="tab" aria-controls="" aria-selected="true"
                        @click="Reports_store.attendance_Type = 6"
                        :class="[Reports_store.attendance_Type === 6 ? 'active font-semibold !border-b-[2.2px]  !border-[#F9BE00]' : 'font-medium !text-[#8B8B8B] border-b-[2.2px] border-[#dcdcdc] ']">
                        MOP
                    </a>
                </li>
            </ul>

            </div>

            <!-- </div> -->
            <!-- Tab Content -->
            <div class="tab-content" id="">

                <div class="card-body">
                    <LoadingSpinner v-if="EmployeeMaster.canShowLoading" class="absolute z-50 bg-white" />

                    <div>
                        <div class="flex items-center justify-between p-2 bg-white">

                            <div class=" flex !items-center">
                                <div>
                                    <InputText placeholder="Search" v-model="filters['global'].value"
                                        class="border-color !h-10 my-1 " />
                                </div>

                                <div class="flex items-center pt-2 ml-2" v-if="Reports_store.activetab == 5">
                                    <!-- <h1 class="text-[12px] text-black mx-1 font-semibold font-['poppins'] ">Category : </h1>
                                    <Dropdown optionLabel="type" optionValue="id" :options="attendanceReportType"
                                        v-model="Reports_store.attendance_Type"
                                        placeholder="Select Type"
                                        class="w-[120px] text-[10px]  mx-1 !h-10 my-1  !font-semibold !font-['poppins'] !text-[#000] !bg-[#E6E6E6]" /> -->
                                </div>







                            </div>

                            <div class="flex items-center ">
                                <button class=" p-2 mx-2 rounded-md w-[120px]" :class="[ !Reports_store.AttendanceReportDynamicHeaders.length == 0 ? 'bg-[#000] text-white':' !text-[#000] !bg-[#E6E6E6] ']"
                                    @click="Reports_store.btn_download = !Reports_store.btn_download, Reports_store.downloadAttendanceReports(Reports_store.activetab)">
                                    <p class=" relative left-2 font-['poppins']" :class="[!Reports_store.AttendanceReportDynamicHeaders.length == 0 ? 'bg-[#000] !text-[#ffff]' : '!text-[#000] !bg-[#E6E6E6]']">Download</p>
                                    <div id="btn-download" style=" position: absolute; right: 0;"
                                        :class="[Reports_store.btn_download == true ? toggleClass : ' ']">
                                        <svg width="22px" height="16px" viewBox="0 0 22 16" :class="[ !Reports_store.AttendanceReportDynamicHeaders.length == 0 ? '!stroke-[#ffff] ':'!stroke-[#000]']" >
                                            <path
                                                d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15"
                                                id="check"></path>
                                            <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                                            <path d="M8,1 L8,11" class="svg-out"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>


                        </div>

                        <div>

                            <DataTable :value="Reports_store.AttendanceReportSource" paginator :rows="5"
                                :rowsPerPageOptions="[5, 10, 20, 50]" responsiveLayout="scroll" scrollable scrollHeight="240px"
                                paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                                currentPageReportTemplate="{first} to {last} of {totalRecords}" >
                                <Column v-for="col of Reports_store.AttendanceReportDynamicHeaders" :key="col.title"
                                    :field="col.title" :header="col.title"
                                    style="white-space: nowrap;text-align: left; !important;width:15rem !important; marign-right:1rem !important ;">
                                </Column>
                            </DataTable>

                            <Dialog v-model:visible="Reports_store.dialog_customDate" modal header="Custom Date" :style="{ width: '30vw' }">

                                <!-- <i class="pi pi-times text-[20px] text-[#000] " @click="Reports_store.dialog_customDate= false" ></i> -->
                                <div>
                                    <i class="pi pi-times text-[14px] text-gray-400  rounded-full border-[3px] p-2 hover:border-blue-200 font-medium absolute top-5 right-5 " @click="Reports_store.dialog_customDate= false" ></i>
                                    <div class="flex items-center justify-between">
                                    <Calendar v-model="Reports_store.Start_Date" @date-select="Reports_store.select_StartAndEnd_Date('start_date',dayjs(Reports_store.Start_Date).format('YYYY-MM-DD'), Reports_store.activetab)"  dateFormat="dd-mm-yy"  class="w-[150px] h-10 mx-2" placeholder="Start-date " />
                                    <Calendar v-model="Reports_store.End_Date"  dateFormat="dd-mm-yy" @date-select="Reports_store.select_StartAndEnd_Date('end_date',dayjs(Reports_store.End_Date).format('YYYY-MM-DD') , Reports_store.activetab)" class="w-[150px] h-10"  placeholder="End-date " />
                                 </div>
                                </div>
                            </Dialog>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { UseReports_store } from "./store/reports_store";
import dayjs from 'dayjs';
import { FilterMatchMode } from 'primevue/api';
import { EmployeeMasterStore } from "../employee_master_report/employee_master_reportsStore";
import LoadingSpinner from '../../../components/LoadingSpinner.vue';
import  {Service} from '../../Service/Service'


const EmployeeMaster = EmployeeMasterStore();
const Reports_store = UseReports_store();
const service = Service()

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const start_date = ref();
const End_date = ref();




const selectCategory = ref();

const dropdown = ref([
    { name: "Active", id: 1 },
    { name: "Yet To Active", id: 0 },
    { name: "Exit", id: -1 },
]);

const attendanceReportType = ref([
    { type: "Late Coming", id: 1 },
    { type: 'Early Going', id: 2 },
    { type: 'Absent', id: 3 },
    { type: 'Half-Day Absent', id: 4 },
])


onMounted(async ()=>{
   const userCode = await service.current_user_code
    Reports_store.selectedfilters.user_code = userCode
})






</script>

<style scoped>
.dropdown:hover .dropdown-content
{
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content
{
    padding: 0;
    z-index: 0 !important;
}

.p-inputtext
{
    position: relative;
    top: 5px;
}

.p-inputtext::placeholder
{
    color: #000 !important;
}

.p-dropdown-label::placeholder,
.p-inputtext::placeholder
{
    color: #000 !important;
}

.p-placeholder
{
    color: #000 !important;
    font-family: 'poppins';
    /* font-size:11px; */
}
.p-inputtext .p-placeholder{
    color: #000 !important;
    font-family: 'poppins';
}

.p-dropdown .p-dropdown-label
{
    background: transparent;
    border: 0 none;
}
.p-button{
    margin-top:5px;
}
</style>


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
  left: calc(15% - 24px)
  &:hover
    //  background: rgba(#223254,.03)
  svg
    margin: 16px 0 0 16px
    fill: none
    transform: translate3d(0,0,0)
    polyline,
    path
    //   stroke: #000
      stroke-width: 1.5
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
