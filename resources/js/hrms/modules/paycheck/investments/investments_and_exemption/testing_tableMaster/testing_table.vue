
<template>
    <div>

    <!-- <div class="card">
        <DataTable resizableColumns columnResizeMode="expand"  ref="dt" dataKey="id" :paginator="true" :rows="10" :value="Datatable"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
            <Column field="section" header="Section" >
            <input type="text" name="" id=""></Column>
            <Column field="particular" header="Particular">
                <template #body="slotProps">
                    {{ slotProps.data.particular }}
                    <div v-if="slotProps.data.particulars_options">
                        <div v-for="option in slotProps.data.particulars_options" :key="option.key">
                            <div class="flex">
                                <RadioButton v-model="slotProps.data.emp_selected_particular_option" name="asd" :inputId="option.key" :value="option.key" />
                                <label :for="option.key" class="ml-2">{{ option.value }}</label>
                            </div>
                        </div>
                    </div>
                </template>
            </Column>
            <Column field="ref" header="ref"></Column>
            <Column field="max" name="max"></Column>
            <Column field="dec_amount" header="Declaration Amount" >

                <template #body="slotProps">
                    <InputText type="text" v-model="slotProps.data.emp_dec_amount" />

                </template>

            </Column>
        </DataTable>

        <button @click="save_sec_80C_80ccc">Submit</button>
    </div> -->

    <!-- <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, libero repudiandae. Quibusdam sint aperiam dolore animi consequatur? Explicabo nesciunt exercitationem cum veritatis fuga, atque architecto sint vel nobis consectetur reiciendis?</h1> -->


    <div>
        <!-- <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, libero repudiandae. Quibusdam sint aperiam dolore animi consequatur? Explicabo nesciunt exercitationem cum veritatis fuga, atque architecto sint vel nobis consectetur reiciendis?</h1> -->

        <DataTable :value="arraylist" :paginator="true" :rows="10" class="" dataKey="user_code"
            @rowExpand="onRowExpand" @rowCollapse="onRowCollapse" v-model:expandedRows="expandedRows"
            v-model:selection="selectedAllEmployee" :selectAll="selectAll" @select-all-change="onSelectAllChange"
            @row-select="onRowSelect" @row-unselect="onRowUnselect" :rowsPerPageOptions="[5, 10, 25]"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            responsiveLayout="scroll" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}">

            <Column :expander="true" />
            <Column selectionMode="multiple" style="width: 1rem" :exportable="false"></Column>
            <!-- <Column field="user_code" header="Employee Id" sortable></Column> -->
            <Column field="name" header="Employee Name">
            </Column>
            <!-- <Column field="doc_status" header="Approval Status" :sortable="false">
                <template #body="{ data }">
                    {{ data.doc_status }}
                </template>
            </Column> -->
            <!-- <Column field="" header="Action">
                <template #body="slotProps">
                    <span>
                        <Button type="button" icon="pi pi-check-circle" class="p-button-success Button" label="Approve All"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Approve')" style="height: 2.5em" />
                        <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button" label="Reject All"
                            style="margin-left: 8px; height: 2.5em"
                            @click="getBulkApprovalList(slotProps.data.documents, 'Reject')" />
                    </span>
                </template>
            </Column> -->
            <template #expansion="slotProps">
                <div>
                    <DataTable :value="slotProps.data.Emp_data" responsiveLayout="scroll"
                        v-model:selection="selectedAllEmployee" :selectAll="selectAll"
                        @select-all-change="onSelectAllChange">
                        <Column field="pms_form_id" header="Pms form id"></Column>
                        <Column field="form_name" header="Form name">
                        </Column>
                        <Column field="author_id" header="Author id"></Column>
                        <Column field="vmt_pms_kpiform_assigned_id" header="vmt pms form assigned id"></Column>
                        <Column field="assignee_id" header="Assignee Id"></Column>
                        <Column field="assignment_period" header="Assignment Period"></Column>
                        <!-- assignee_id -->

                        <!-- <Column field="" header="View">
                            <template #body="slotProps">
                                <Button type="button" icon="pi pi-eye" class="p-button-success Button" label="View"
                                    @click="showDocDialog(slotProps.data.record_id)" style="height: 2em" />
                            </template>
                        </Column> -->

                        <!-- <Column field="" header="Action">
                            <template #body="slotProps">
                                <span>
                                    <Button type="button" icon="pi pi-check-circle" class="p-button-success Button"
                                        label="Approve" @click="showConfirmDialog(slotProps.data, 'Approve')"
                                        style="height: 2.5em" />
                                    <Button type="button" icon="pi pi-times-circle" class="p-button-danger Button"
                                        label="Reject" style="margin-left: 8px; height: 2.5em"
                                        @click="showConfirmDialog(slotProps.data, 'Reject')" />
                                </span>
                            </template>
                        </Column> -->
                    </DataTable>
                </div>
            </template>

        </DataTable>


    </div>



    </div>
</template>

<script setup>
import {ref } from  'vue';
import { FilterMatchMode, FilterOperator } from "primevue/api";
import axios from 'axios';
import map from 'lodash/map';

// import UseDatatable from  './tesing_pinia';



// const SectionData = UseDatatable();

const Datatable = ref([
    { fsp_id: 1, section: "Section 10(13A)", particular: "House Rent Allowance", particulars_options :  [{ key : '1', value:'40% To 80%'},{key:'2', value:'More than 80%'}]  , ref: 'data', max: '1000' , emp_dec_amount : '0' , emp_selected_particular_option :'' },
    { fsp_id: 2, section: "Section 10(13A)", particular: "House Rent Allowance", particulars_options :  []  ,  ref: 'data', max: '1000' , dec_amount : '10000', emp_selected_particular_option :'' },
    { fsp_id: 3, section: "Section 10(13A)", particular: "House Rent Allowance", particulars_options :  []  ,  ref: 'data', max: '1000' , dec_amount : '0' , emp_selected_particular_option :''}
]);

const text = ref({
        EPF:"",
        VPF:"",
        PPF:"",
})

const arraylist = ref();

function getpmsJson(){
    let url = `http://localhost:3000/Pms_Json_structure`;

    axios.get(url).then((res)=>{
        arraylist.value=  res.data;

    }).finally()
}
getpmsJson();


const DataTabledata = ref();

const te = (data) =>{
    console.log(text.value);
    console.log(data.test.id);
}

const expandedRows = ref([]);
const selectedAllEmployee = ref();

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: {
        value: null,
        matchMode: FilterMatchMode.STARTS_WITH,
        matchMode: FilterMatchMode.EQUALS,
        matchMode: FilterMatchMode.CONTAINS,
    },
    status: { value: 'Pending', matchMode: FilterMatchMode.EQUALS },
});

// function fetchDataTabledata(){
//         axios.get('http://localhost:3000/DataTable').then((res)=>{
//             DataTabledata.value = res.data.data
//             console.log(res.data);
//         })

//     }

function save_sec_80C_80ccc(){
    console.log('Saving data.........');

    console.log(JSON.parse(JSON.stringify(Datatable.value)));
// axios.post('http://localhost:3000/DataTable',text).finally(()=>{

//     fetchDataTabledata()
// })

}




</script>
