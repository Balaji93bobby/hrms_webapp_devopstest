<template>
    <div class="">
        <h1 class="text-[28px] font-['poppins'] text-[#000]">Payslips - {{ dayjs(useStore.selectedDate).format('MMM-YYYY') }} </h1>
        <p class=" text-[14px] text-[#000] font-['poppins'] ">Here you can release payslips
            for employees and download the payslips. Payslips can only be sent to
            active employees. Employees who are relieved will not receive Payslips.</p>

        <div class=" flex justify-between items-center my-4">

            <div class="flex justify-center items-center ">
                <p class=" text-[#000] borde-[1px] borde-[#000]"> Total : {{useStore.manage_payslips_details ? useStore.manage_payslips_details.length : 0}}</p>
                <!-- clientList -->
                <MultiSelect optionValue="id" class=" !w-[180px]" v-model="useStore.businessUnit"
                    placeholder="Business Unit" :options="useStore.clientList"
                    @change="useStore.selectedFilter('Business Unit', useStore.businessUnit)" optionLabel="client_fullname"
                    :maxSelectedLabels="3" />
                <!-- v-model="" -->
                <MultiSelect optionValue="id" class="w-[180px]  mx-2" v-model="useStore.departments"
                    placeholder="Department" :options="departmentOption"
                    @change="useStore.selectedFilter('departments', useStore.departments)" optionLabel="name"
                    :maxSelectedLabels="3" />

                <MultiSelect optionValue="id" class="w-[180px]  mx-2"  v-model="useStore.selected_Location"
                    placeholder="Location" :options="useStore.getlocation"
                    @change="useStore.selectedFilter('Location', useStore.selected_Location)" optionLabel="name"
                    :maxSelectedLabels="3" />
                <!-- <Dropdown optionLabel="name" class="w-full md:w-14rem mx-2 h-10" /> -->

                <!-- <MultiSelect class=" mx-2" optionLabel="name"
                     placeholder="Location"
                    @change="useStore.selectedFilter('Location', useStore.selected_Location)" :maxSelectedLabels="3" /> -->

                <!-- <Dropdown optionLabel="name" optionValue="id"  placeholder="Location" :options="useStore.location"  @change="useStore.selectedfilter('Location',useStore.location)"  class="w-full md:w-14rem mx-2 h-10" /> -->
            </div>
            <div class=" flex items-center ">
                <!-- v-model="filters['global'].value" -->
                <div class="flex justify-content-end ">
                    <span class="p-input-icon-left ">
                        <i class="pi pi-search" />
                        <InputText placeholder="Keyword Search" v-model="filters['global'].value" />
                    </span>
                </div>
            </div>
        </div>
        <!-- selectedDetails -->
        <div class="flex justify-between items-center">
            <div class=" flex items-center justify-start my-4">
                <button class="  rounded-[4px]  p-2 px-4 mx-2 text-[#fff]"
                    :class="[useStore.selectedDetails ? useStore.selectedDetails.length > 0 ? 'bg-[#0873CD]' : ' !bg-[#B1AFAF]' : '!bg-[#B1AFAF]']"
                    @click="useStore.send_payslip_request(useStore.selectedDetails, 1)">Release Payslips</button>
                <button class=" rounded-[4px]  p-2 px-4 mx-2 text-[#fff]"
                    :class="[useStore.selectedDetails ? useStore.selectedDetails.length > 0 ? 'bg-[#0873CD]' : ' !bg-[#B1AFAF]' : '!bg-[#B1AFAF]']"
                    @click="useStore.send_payslip_request(useStore.selectedDetails, 0)">Hold Back Payslips</button>
                <button
                    :class="[useStore.selectedDetails ? useStore.selectedDetails.length > 0 ? 'bg-[#0873CD]' : ' !bg-[#B1AFAF]' : '!bg-[#B1AFAF]']"
                    class=" rounded-[4px]  p-2 px-4 mx-2 text-[#fff]"
                    @click="useStore.send_payslip_Email(useStore.selectedDetails)">Send Payslips by Email</button>
                <button
                    :class="[useStore.selectedDetails ? useStore.selectedDetails.length > 0 ? 'bg-[#0873CD]' : ' !bg-[#B1AFAF]' : '!bg-[#B1AFAF]']"
                    class=" rounded-[4px]  p-2 px-4 mx-2 text-[#fff]"
                    @click="useStore.downloadPayslip(useStore.selectedDetails)">Download</button>
                    <div class="flex items-center ">
                    <button @click="useStore.clearFilter()"
                        class=" flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px] !bg-[#E6E6E6] mx-2 rounded-[4px] whitespace-nowrap "><i
                            class="mr-2 pi pi-times"></i> Clear Filter</button>
                    <!-- useEmployeeReport.updateEmployeeApplyFilter(activetab) -->
                    <button @click="useStore.getFilterSource()"
                        class="my-2 flex items-center text-[#000] !font-semibold !font-['poppins'] text-[12px] px-3 py-2 border-[1px]  bg-[#F9BE00]  mx-2 rounded-[4px] "><i
                            class="mr-2 pi pi-filter"></i> Run</button>
                </div>
            </div>
            <div class=""  v-if="useStore.enable_select_calendar != 1 " >
                <label for=" " class="text-[16px] text-[#000] font-['poppins'] mx-2">Select Month</label>
                <Calendar  class="" view="month" dateFormat="mm/yy" v-model="useStore.selectedDate"
                    @date-select="useStore.selectedFilter('selectedDate',useStore.selectedDate)" />
                     <!-- useStore.selectedDate.getMonth() + 1, useStore.selectedDate.getFullYear() -->
            </div>
        </div>

        <DataTable :value="useStore.manage_payslips_details" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            v-model:filters="filters" dataKey="id" :globalFilterFields="['Employee_name']"
            v-model:selection="useStore.selectedDetails" tableStyle="min-width: 50rem my-4">
            <Column selectionMode="multiple" headerStyle="width: 3rem" @click="Enable_button(useStore.selectedDetails)">

            </Column>
            <Column class="font-bold" field="Employee_name" header="Employee Name"
                    style="min-width: 5rem !important; text-align: center:  !important;">
                    <template #body="slotProps">
                        <div class="flex items-center justify-center">
                            <p v-if="JSON.parse(slotProps.data.avatar).type == 'shortname'"
                                class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                                :class="service.getBackgroundColor(slotProps.index)">
                                {{ JSON.parse(slotProps.data.avatar).data }} </p>
                            <img v-else class="rounded-circle userActive-status profile-img"
                                style="height: 30px !important; width: 30px !important;"
                                :src="`data:image/png;base64,${JSON.parse(slotProps.data.avatar).data}`" srcset=""
                                alt="" />
                            <p class="pl-2 font-semibold text-left fs-6">{{ slotProps.data.Employee_name }} </p>
                        </div>
                    </template>
                </Column>
            <!-- <Column field="Employee_name" header="Employee ">
                <template #body="slotProps">
                    <div class=" flex justify-start items-center flex-col mx-4">
                        <h1 class="">{{ slotProps.data.Employee_name }}</h1>
                        <h1 class="">{{ slotProps.data.Employee_code }}</h1>
                    </div>
                </template>
            </Column> -->
            <Column field="Buisness_unit" header="Business"></Column>
            <Column field="Department_name" header="Department"></Column>
            <Column field="Location" header="Location"></Column>
            <Column field="Payroll_month" header="Month">
                <template #body="slotProps">
                    <div>
                        {{ dayjs(slotProps.data.Payroll_month).format('MMM-YYYY') }}
                    </div>
                </template>
            </Column>
            <Column field="is_payslip_released" header="Payslip Released">
                <template #body="slotProps">
                    <div class=" justify-center flex">
                        <h1 class="" v-if="slotProps.data.is_payslip_released == 0">No</h1>
                        <div v-if="slotProps.data.is_payslip_released == 1" class=" flex flex-col text-left">
                            <h1>Yes</h1>
                            on {{ dayjs(slotProps.data.payslip_release_date).format('DD MMM,YYYY') }}
                        </div>

                    </div>
                </template>
            </Column>
            <Column field="payslip_revoked_date" header="Payslip revoked">
                <template #body="slotProps">
                    <div class=" justify-center flex">
                        <div v-if="slotProps.data.is_payslip_released == 0 && slotProps.data.payslip_revoked_date" class=" flex flex-col text-left">
                            <h1>Yes</h1>
                            on {{ dayjs(slotProps.data.payslip_release_date).format('DD MMM,YYYY') }}
                        </div>
                        <h1 class="" v-else>No</h1>


                    </div>
                </template>
            </Column>
            <Column field="is_payslip_sent" header="Email sent">
                <template #body="slotProps">
                    <div class=" justify-center flex">
                        <h1 class="" v-if="slotProps.data.is_payslip_sent == 0"> No</h1>
                        <div v-if="slotProps.data.is_payslip_sent == 1" class=" flex flex-col text-left">
                            <h1>Yes</h1>
                            on {{ dayjs(slotProps.data.payslip_sent_date).format('DD MMM,YYYY') }}
                        </div>

                    </div>
                </template>

            </Column>

        </DataTable>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useManagePayslip } from './ManangePayslipsService'
import dayjs from "dayjs";
import { Service } from '../../Service/Service';
import { FilterMatchMode } from 'primevue/api';

const selectedDetails = ref();
const departmentOption = ref();
const useStore = useManagePayslip();
const service = Service();

const Enable_button = () => {
    if (selectedDetails.value) {
        useStore.Enable_btn = 2;
        console.log(" testing sd", useStore.Enable_btn);
    } else {
        useStore.Enable_btn = 1;
        console.log(" testing sd", useStore.Enable_btn);
    }
}

onMounted(() => {
    service.DepartmentDetails().then((res) => {
        departmentOption.value = res.data;
    });
    useStore.Enable_btn = 1;
    useStore.getClientDetails();
    useStore.getLocationDetails();
    if( useStore.enable_select_calendar == 1 &&  useStore.selectedDate){
        useStore.getFilterSource(useStore.selectedDate);
    }
    else{
        useStore.selectedDate = new Date();
    }
})

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    Employee_name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});





</script>

<style >
.p-icon,
.p-dropdown-trigger-icon
{
    rotate: 270deg !important;
}

.p-placeholder
{
    margin-top: -2px !important;
}

.p-inputtext
{
    padding-left: 40px;
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
      // stroke: #000
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
