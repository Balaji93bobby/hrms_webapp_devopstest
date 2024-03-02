<template>
    <div>
        <!-- <ConfirmDialog></ConfirmDialog> -->
        <Toast />
        <Dialog header="Header" v-model:visible="canShowLoadingScreen" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '25vw'}" :modal="true" :closable="false" :closeOnEscape="false">
            <template #header>
                <ProgressSpinner style="width:50px;height:50px" strokeWidth="8" fill="var(--surface-ground)" animationDuration="2s" aria-label="Custom ProgressSpinner"/>
            </template>
            <template #footer>
                <h5 style="text-align: center;">Please wait...</h5>
            </template>
        </Dialog>

        <Dialog header="Confirmation" v-model:visible="canShowConfirmation" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '350px'}" :modal="true" >
            <div class="confirmation-content">
                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to {{currentlySelectedStatus}}?</span>
            </div>
            <template #footer>
                <Button label="Yes" icon="pi pi-check" @click="processApproveReject()" class="p-button-text" autofocus />
                <Button label="No" icon="pi pi-times" @click="hideConfirmDialog(true)" class="p-button-text"/>
            </template>
        </Dialog>
        <div>
            <!-- <div>Calander Type :
                <select v-model="selected_options_calendar_type.value">
                    <option v-for="option in options_calendar_type" :value="option.value">
                        {{ option.name}}
                    </option>
                </select>
            </div>

            <div>Year :
                <select v-model="selected_options_year.value">
                    <option v-for="option in options_year" :value="option.value">
                        {{ option.name}}
                    </option>
                </select>
            </div>

            <div>Assignment Period :
                <select v-model="selected_options_calendar_type.value">
                    <option v-for="option in options_assignment_period" :value="option.value">
                        {{ option.name}}
                    </option>
                </select>
            </div> -->
<!--
            <div>
                <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"  label="Download Excel"  @click="onclickDownloadExcelSheet(1)" style="height: 2em;" />
            </div> -->

            <DataTable :value="usePmsFormsStore.allEmployees" :paginator="true" :rows="10" dataKey="id"
                    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                    v-model:filters="filters" filterDisplay="menu" :loading="loading2"
                    :globalFilterFields="['name','status']">
                    <template #empty>
                      No Employee found
                    </template>
                    <template #loading>
                        Loading customers data. Please wait.
                    </template>
                    <!-- form_name, reviewer_name, calendar_type, year, assignment_period, department_id, -->
                <Column field="form_name" header="Form Name" >
                    <template #body="slotProps">
                        {{ usePmsFormsStore }}
                        {{ slotProps.data.form_name }}
                    </template>
                    <!-- <template #filter="{filterModel,filterCallback}">
                        <InputText v-model="filterModel.value" @input="filterCallback()"  placeholder="Search" class="p-column-filter" :showClear="true"   />
                    </template> -->
                </Column>
                <!-- <Column field="reviewer_name" header="Reviewer_name"></Column> -->
                <!-- <Column field="department" header="Department"></Column> -->
                <Column field="calendar_type" header="Calendar Type"></Column>
                <Column field="year" header="Year"></Column>
                <Column field="assignment_period" header="Date" :sortable="true" ></Column>
                <Column field="department_id" header="department_id" ></Column>
                <Column style="width: 300px;" field="" header="Action">
                    <template #body="slotProps">
                            <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"  label="Approval"  @click="showConfirmDialog(slotProps.data,'Approve')" style="height: 2em;" />
                   </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>
<script setup>

    import { ref, onMounted } from 'vue';
    import axios from 'axios'
    import {FilterMatchMode,FilterOperator} from 'primevue/api';
    import {usePMSFormsMgmtStore} from '../PMSFormsMgmtService'

    const usePmsFormsStore = usePMSFormsMgmtStore()



    // const selected_options_calendar_type =  {   "name" : "Choose", "value":""} ;
    // const options_calendar_type = [
    //                                  {   "name" : "Choose", "value":""},
    //                                  {   "name" : "Financial Year", "value":"financial_year"},
    //                                  {   "name" : "Calendar Year", "value":"calendar_year"}
    //                             ];

    // const selected_options_year =  {   "name" : "Choose", "value":""} ;
    // const options_year  = [
    //                                  {   "name" : "Choose", "value":""},
    //                                  {   "name" : "April - 2021 to March - 2022", "value":"April - 2021 to March - 2022"},
    //                                  {   "name" : "April - 2022 to March - 2023", "value":"April - 2022 to March - 2023"}
    //                             ];

    // const selected_assignment_period =  {   "name" : "Choose", "value":""} ;
    // const options_assignment_period  = [
    //                                  {   "name" : "Choose", "value":""},
    //                                  {   "name" : "Q1", "value":"q1"},
    //                                  {   "name" : "Q2", "value":"q2"},
    //                                  {   "name" : "Q3", "value":"q3"},
    //                                  {   "name" : "Q4", "value":"q4"},
    //                             ];

    const filters = ref({
            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            employee_name: {
             value: null,
                     matchMode: FilterMatchMode.STARTS_WITH,
                     matchMode:FilterMatchMode.EQUALS,
                     matchMode:FilterMatchMode.CONTAINS,

            },
    });

    const data_pmsforms = ref();

    onMounted(() => {
     usePmsFormsStore.getAllEmployeesList()
     console.log(usePmsFormsStore.getAllEmployeesList());
    })


    // function onclickDownloadExcelSheet(selected_pmsform_id) {

    //     console.log("Processing Rowdata : "+ JSON.stringify(selected_pmsform_id));


    //     axios.get(window.location.origin + '/report-download-pmsforms', {
    //         pms_form_id: selected_pmsform_id,
    //     }).then((response) => {
    //         let blob = new Blob([response.data], { type: 'data:application/vnd.ms-excel' });
    //         let fileURL = window.URL.createObjectURL(blob);

    //         var fileLink = document.createElement('a');
    //         fileLink.href = fileURL;

    //         // it forces the name of the downloaded file
    //         fileLink.download = 'pdf_name.xlsx';

    //         // triggers the click event
    //         fileLink.click();

    //         console.log(response);
    //     })
    //     .catch((error) => {
    //         console.log(error.toJSON());
    //     });
    // }


</script>
<style  lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,200&display=swap');


.p-datatable .p-datatable-thead >tr>th{
    text-align: center;
    padding: 1.3rem 1rem;
    border: 1px solid #dee2e6;
      border-top-width: 1px;
      border-right-width: 1px;
      border-bottom-width: 1px;
      border-left-width: 1px;
    border-width: 0 0 1px 0;
    font-weight: 600;
    color: #fff;
    background: #003056;
    transition: box-shadow 0.2s;
    font-size: 13px;
    .p-column-title {
        color: #fff;
        font-size: 13px;
    }
    .p-column-filter {
        width: 100%;
      }
      #pv_id_2 {
        height: 30px;
      }
    .p-fluid .p-dropdown .p-dropdown-label {
        margin-top: -10px;
      }
      .p-dropdown .p-dropdown-label.p-placeholder{
        margin-top: -12px;
      }

    .p-column-filter-menu-button{
        color: white;
        margin-left: 10px;

    }
    .p-column-filter-menu-button:hover {
        color:white;
        border-color: transparent;
        background: #023e70;
      }

  }
  .p-column-filter-overlay-menu .p-column-filter-constraint .p-column-filter-matchmode-dropdown {
    margin-bottom: 0.5rem;
    visibility: hidden;
    position: absolute;
  }

  .p-button .p-component .p-button-sm{
    background-color: #003056;
  }

.p-datatable .p-datatable-tbody > tr{
    font-size: 13px;
    .employee_name{
        font-weight: bold;
        font-size: 13.5px;
    }


  }
  .p-datatable .p-datatable-tbody > tr > td {
    text-align: left;
    border: 1px solid #dee2e6;
      border-top-width: 1px;
      border-right-width: 1px;
      border-bottom-width: 1px;
      border-left-width: 1px;
    border-width: 0 0 1px 0;
    padding: 1rem 0.6rem;

  }
  .p-datatable .p-datatable-tbody > tr > td:nth-child(1) {
    width: 20%;
  }
//   .main-content{
//     width: 105%;
//   }

.pending {
    font-weight: 700;

}


.approved {
    font-weight: 700;

}
.p-button.p-component.p-button-success.Button {
    padding: 8px;
}

.rejected {
    font-weight: 700;
    color: #ff2634;
}
.p-button.p-component.p-button-danger.Button {
    padding: 8px;
  }

  .p-confirm-dialog-icon.pi.pi-exclamation-triangle {
    color: red;
  }
  .p-button.p-component.p-confirm-dialog-accept {
    background-color: #003056;
  }
  .p-button.p-component.p-confirm-dialog-reject.p-button-text {
    color: #003056;
  }
  .p-column-filter-overlay-menu .p-column-filter-buttonbar {
    padding: 1.25rem;
    position: absolute;
    visibility: hidden;
  }
  .p-datatable .p-datatable-thead > tr > th .p-column-filter {
    width: 53%;
  }
  .p-datatable .p-datatable-thead > tr > th .p-column-filter-menu-button {
    color: white;
    border-color: transparent;

  }
  .p-column-filter-menu-button.p-column-filter-menu-button-open{
    background: none;
  }

 .p-column-filter-menu-button.p-column-filter-menu-button-active{
    background: none;

  }


 /* For Sort */

 .p-datatable .p-sortable-column:not(.p-highlight):hover {
    background: #003056;
    color:white;
  }
  .p-datatable .p-sortable-column:not(.p-highlight):hover .p-sortable-column-icon {
      color:white
  }
   .p-datatable .p-sortable-column.p-highlight {
    background: #003056;
    color:white;
  }

  .p-datatable .p-sortable-column.p-highlight:hover {
    background: #003056;
    color:white;
  }
  .p-datatable .p-sortable-column:focus {
    box-shadow: none;
    outline: none;
    color: white;
  }
  .p-datatable .p-sortable-column .p-sortable-column-icon{
    color:white
  }
  .pi-sort-amount-down::before {
    content: "\e9a0";
    color: white;
  }
  .pi-sort-amount-up-alt::before {
    content: "\e9a2";
    color: white;
  }


</style>
