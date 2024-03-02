<template>
    <div>
        <div class="flex justify-between p-2 bg-white">
            <!-- v-model="filters['global'].value" -->
            <div class="">
                <InputText placeholder="Search"  v-model="filters['global'].value" class="border-color !h-10  my-2" />
            </div>
            <div class="flex items-center">
                  <!-- :class="[!UseEmployeeMaster.employeeMaterReportSource.length == 0 ? 'bg-[#000] !text-[#ffff]' : '!text-[#000] !bg-[#E6E6E6]']" -->

                    <button class=" p-2 mx-2 rounded-md w-[120px] bg-[#000] !text-[#ffff]"

                        @click="usePMSReport.btn_download = !usePMSReport.btn_download, usePMSReport.downloadAnnualPMSReport()">
                        <p class=" relative  font-['poppins'] bg-[#000] !text-[#ffff]" ><i class="pi pi-download mx-2"></i>Download</p>
                        <div id="btn-download" style=" position: absolute; right: 0;"
                            :class="[usePMSReport.btn_download == true ? toggleClass : '']">
                            <!-- :class="[!UseEmployeeMaster.employeeMaterReportSource.length == 0 ? '!stroke-[#ffff] ' : '!stroke-[#000]']" -->

                            <!-- <svg width="22px" height="16px" viewBox="0 0 22 16"
                                >
                                <path
                                    d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15"
                                    id="check"
                                    :style="[!UseEmployeeMaster.employeeMaterReportSource.length === 0 ? 'stroke=blue' : '!bg-[#E6E6E6] !text-[#000] ']">
                                </path>
                                <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                                <path d="M8,1 L8,11" class="svg-out " stroke=""
                                    :style="[UseEmployeeMaster.employeeMaterReportSource.length === 0 ? 'red' : 'fill: red']">
                                </path>
                            </svg> -->
                        </div>
                    </button>
                </div>
            <!-- <div class="flex items-center ">
                <h1 class="text-[12px] text-black font-semibold  font-['poppins']">Personal Details -</h1>
                <button class="bg-[#E6E6E6] px-3 p-2 rounded-md mx-2 "  @click="UseEmployeeMaster.personalDetails()" >
                    <i class="pi pi-eye" v-if="UseEmployeeMaster.show && UseEmployeeMaster.personalDetail=='detailed'" ></i> <i v-else-if="!UseEmployeeMaster.show" class="pi pi-eye-slash"></i></button>



            </div> -->


        </div>

<!-- {{ usePMSReport.PMSAnnualReportSource }} -->
        <div class="">
                <DataTable :value="usePMSReport.PMSAnnualReportSource" paginator :rows="5"
                    :rowsPerPageOptions="[5, 10, 20, 50]" responsiveLayout="scroll" scrollable scrollHeight="240px"
                    paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    currentPageReportTemplate="{first} to {last} of {totalRecords}">
                    <ColumnGroup type="header">
                        <Row>
                            <Column v-for="(header, index) in usePMSReport.PMSAnnualReport_DynamicHeaders2"  :key="index" :header="header.title" />
                        </Row>
                        <Row>
                            <Column v-for="(header, index) in usePMSReport.PMSAnnualReport_DynamicHeaders1" :key="index"  :header="header.title" />
                        </Row>
                    </ColumnGroup>
                    <Column v-for="col of usePMSReport.PMSAnnualReportSourceData" :key="col.title" :field="col.title">
                    </Column>
                    

                </DataTable>

            </div>
        <!-- <div class="">
                <DataTable :value="usePMSReport.PMSAnnualReportSource" paginator :rows="5"
                    :rowsPerPageOptions="[5, 10, 20, 50]" responsiveLayout="scroll" scrollable scrollHeight="240px"
                    paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    currentPageReportTemplate="{first} to {last} of {totalRecords}">
                    <Column class="" v-for="col of usePMSReport.PMSAnnualReport_DynamicHeaders2" :key="col.title"
                        :field="col.title" :header="col.title"  style="text-align: left; !important;width:15rem !important; marign-right:1rem !important ;"  resizableColumns columnResizeMode="fit">
                    </Column>
                </DataTable>

            </div> -->

    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';
import { FilterMatchMode } from 'primevue/api';

import {PMSMasterStore} from './PMSReport'



const usePMSReport = PMSMasterStore()

onMounted(()=>{
  usePMSReport.getAssignmentPeriodDropdown()
  usePMSReport.getclient_id()
});







const client_ids = ref([]);





const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});






// const downloadEmployeeCTC = () => {
//     let url = '/report/download-early-going-report'
//     canShowLoading.value = true
//     axios.post(url, {
//         start_date: variable.start_date,
//         end_date: variable.end_date,
//     }, { responseType: 'blob' }).then((response) => {
//         console.log(response.data);
//         var link = document.createElement('a');
//         link.href = window.URL.createObjectURL(response.data);
//         link.download = `Attendance Early Going Report_${new Date(variable.start_date).getDate()}_${new Date(variable.end_date).getDate()}.xlsx`;
//         link.click();
//     }).finally(() => {
//         canShowLoading.value = false
//     })
// }


// , {
//         // start_date: variable.start_date,
//         // end_date: variable.end_date,
//     }




// function sentFilterClientIds(){
//     axios.post(url).then((res)=>{
//         console.log();
//     })

// }

const toggleClass = ref('downloaded');




</script>

<style scoped>
.dropdown:hover .dropdown-content {
    display: block !important;
}

.p-overlaypanel .p-overlaypanel-content {
    padding: 0;
    z-index: 0 !important;
}
/* .p-dropdown-label, .p-inputtext{

} */
.p-dropdown-item{
    color:black !important;
    font-family: 'poppins';


}
.p-multiselect-label , .p-placeholder{
 position: relative;
     top:-3px;
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
