<template>
    <div>
        <div class="bg-white p-2 flex  justify-between">

            <div>
                <InputText placeholder="Search" v-model="filters['global'].value" class="border-color !h-10"
                    style="height: 3em; font-['poppins'] " />
            </div>
            <div class="flex items-center ">
                <button class=" bg-[#E6E6E6] p-2 mx-2 rounded-md w-[120px]"
                    @click="UseEmployeeMaster.btn_download = !UseEmployeeMaster.btn_download, UseEmployeeMaster.downloadEmployeeMaster()">
                    <p class=" relative left-2 font-['poppins']">Download</p>
                    <div id="btn-download" style=" position: absolute; right: 0;"
                        :class="[UseEmployeeMaster.btn_download == true ? toggleClass : ' ']">
                        <svg width="22px" height="16px" viewBox="0 0 22 16">
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

            <DataTable :value="UseEmployeeMaster.employeeMaterReportSource" paginator :rows="5"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                currentPageReportTemplate="{first} to {last} of {totalRecords}" responsiveLayout="scroll">
                <Column v-for="col of UseEmployeeMaster.Employee_MaterReportDynamicHeaders" :key="col.title"
                    :field="col.title" :header="col.title" style="white-space: nowrap;text-align: left; !important">
                </Column>
            </DataTable>

        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { UseReports_store } from "../store/reports_store";

const userReportsStore = UseReports_store();

</script>