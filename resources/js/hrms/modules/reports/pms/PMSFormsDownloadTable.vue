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
            <div>Calander Type :
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
            </div>

            <div>
                <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"  label="Download Excel"  @click="onclickDownloadExcelSheet(1)" style="height: 2em;" />
            </div>

            <DataTable :value="data_pmsforms" :paginator="true" :rows="10" dataKey="id"
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

                <Column field="employee_name" header="Employee Name" >
                    <template #body="slotProps">
                        {{ slotProps.data.employee_name }}
                    </template>
                    <template #filter="{filterModel,filterCallback}">
                        <InputText v-model="filterModel.value" @input="filterCallback()"  placeholder="Search" class="p-column-filter" :showClear="true"   />
                    </template>
                </Column>
                <Column field="assignment_period" header="Date" :sortable="true"></Column>

                <Column field="status" header="Status" icon="pi pi-check">

                    <template #body="{data}">
                        <span :class="'customer-badge status-' + data.status">{{data.status}}</span>
                    </template>
                    <template #filter="{filterModel,filterCallback}">
                        <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Select" class="p-column-filter" :showClear="true">
                            <template #value="slotProps">
                                <span :class="'customer-badge status-' + slotProps.value" v-if="slotProps.value">{{slotProps.value}}</span>
                                <span v-else>{{slotProps.placeholder}}</span>
                            </template>
                            <template #option="slotProps">
                                <span :class="'customer-badge status-' + slotProps.option">{{slotProps.option}}</span>
                            </template>
                        </Dropdown>
                    </template>

                     </Column>
                <Column style="width: 300px;" field="" header="Action">
                    <template #body="slotProps">
                        <span v-if="slotProps.data.status == 'Pending'">
                            <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"  label="Approval"  @click="showConfirmDialog(slotProps.data,'Approve')" style="height: 2em;" />
                        </span>
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

    const selected_options_calendar_type =  {   "name" : "Choose", "value":""} ;
    const options_calendar_type = [
                                     {   "name" : "Choose", "value":""},
                                     {   "name" : "Financial Year", "value":"financial_year"},
                                     {   "name" : "Calendar Year", "value":"calendar_year"}
                                ];

    const selected_options_year =  {   "name" : "Choose", "value":""} ;
    const options_year  = [
                                     {   "name" : "Choose", "value":""},
                                     {   "name" : "April - 2021 to March - 2022", "value":"April - 2021 to March - 2022"},
                                     {   "name" : "April - 2022 to March - 2023", "value":"April - 2022 to March - 2023"}
                                ];

    const selected_assignment_period =  {   "name" : "Choose", "value":""} ;
    const options_assignment_period  = [
                                     {   "name" : "Choose", "value":""},
                                     {   "name" : "Q1", "value":"q1"},
                                     {   "name" : "Q2", "value":"q2"},
                                     {   "name" : "Q3", "value":"q3"},
                                     {   "name" : "Q4", "value":"q4"},
                                ];

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
        let url = window.location.origin + '/fetch-regularization-approvals';

        console.log("AJAX URL : " + url);

        axios.get(url)
            .then((response) => {
                console.log("Axios : " + response.data);
                data_pmsforms.value = response.data;
            });
    })


    function onclickDownloadExcelSheet(selected_pmsform_id) {

        console.log("Processing Rowdata : "+ JSON.stringify(selected_pmsform_id));


        axios.get(window.location.origin + '/report-download-pmsforms', {
            pms_form_id: selected_pmsform_id,
        }).then((response) => {
            let blob = new Blob([response.data], { type: 'data:application/vnd.ms-excel' });
            let fileURL = window.URL.createObjectURL(blob);

            var fileLink = document.createElement('a');
            fileLink.href = fileURL;

            // it forces the name of the downloaded file
            fileLink.download = 'pdf_name.xlsx';

            // triggers the click event
            fileLink.click();

            console.log(response);
        })
        .catch((error) => {
            console.log(error.toJSON());
        });
    }


</script>
