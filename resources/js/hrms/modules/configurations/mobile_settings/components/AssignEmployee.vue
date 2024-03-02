<template>
    <!-- <button @click="useStore.employeeAssignDialog = true">click</button> -->
    <Dialog v-model:visible="useStore.employeeAssignDialog" modal header="Holiday " :style="{ width: '70vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }" style="border-top:5px solid #002f56" class="popup_card"
        :aria-controls="useStore.employeeAssignDialog ? '' : null"
        :aria-expanded="useStore.employeeAssignDialog ? true : canshowdialogbtn()">
        <template #header>
            <div class="w-full p-2">
                <div class="flex justify-between">
                    <div>
                        <p class="text-lg font-semibold">Employee Assign</p>
                    </div>
                    <div>
                        <!-- <Dropdown class="w-full" placeholder="select department" /> -->
                    </div>
                </div>
            </div>
        </template>
        <!-- {{ type }} -->
        <div class="flex w-[100%]">
            <div class="">
                <button
                    class="text-[12px] w-[100px] rounded-l-[8px] h-[26px] bg-[rgba(0,0,0,0.95)] hover:bg-[#000] text-[#fff]"
                    @click="EnableAllAndDisableAll(filteredSource,type,1)">Enable All</button>
                <button class="text-[12px] w-[100px] rounded-r-[8px] h-[26px] border-[2px] border-[#000] text-[#000]"
                    @click="EnableAllAndDisableAll(filteredSource,type,2)">Disable All</button>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-2 mt-3">
            <div class="flex items-center col-span-4">
                <input type="text" v-model="filters['global'].value" placeholder="Search employee.."
                    class="border rounded-lg bg-gray-100 p-1.5 w-11/12">
                <!-- <InputText  placeholder="Keyword Search" /> -->
            </div>
            <div class="flex items-center col-span-5">
                <p>Legal entity</p>
                <Dropdown v-model="legalEntity" class="w-full min-[280px]:" placeholder="Legal entity"
                    @change="getFilteredSource($event.value, '', type)"
                    :options="dropdownValues ? dropdownValues.legalEntity : []" optionLabel="client_name"
                    optionValue="id" />
            </div>
            <div class="flex items-center col-span-3">
                <p>Department</p>
                <Dropdown v-model="department" class="w-full" placeholder="Department"
                    @change="getFilteredSource('', $event.value, type)"
                    :options="dropdownValues ? dropdownValues.department : []" optionLabel="name" optionValue="id" />

            </div>
        </div>

        <div class="my-3 table-responsive">
            <DataTable v-model:selection="selectedEmployee" :value="filteredSource" ref="dt" dataKey="id" :paginator="true"
                :rows="10"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                :globalFilterFields="['name', 'department_name']" responsiveLayout="scroll">
                <!-- <Column selectionMode="multiple" headerStyle="width: 3rem"></Column> -->
                <Column field="name" filterField="name" header="Name" style="min-width: 12rem"></Column>
                <Column header="Department" filterField="department_name" field="department_name" style="min-width: 8rem">
                </Column>
                <Column field="status" header="Action" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div class="mx-auto">
                            <button class=" text-[12px] w-[100px] rounded-l-[8px] h-[26px] "
                                @click="EnableDisable(slotProps.data.id, 1, slotProps.data.status = 1, slotProps.data.client_id)"
                                :class="[slotProps.data.status == 1 ? ' bg-[#000] text-white  ' : ' bg-white !text-[#000] border-[2px] border-black']">Enable</button>
                            <button class=" text-[12px] w-[100px] rounded-r-[8px] h-[26px]"
                                @click="EnableDisable(slotProps.data.id, 0, slotProps.data.status = 0,slotProps.data.client_id)"
                                :class="[slotProps.data.status == 0 ? 'bg-[#000] text-white ' : 'bg-white text-black border-[2px] border-black']">Disable</button>
                        </div>
                    </template>
                </Column>
            </DataTable>
            <div class="flex justify-center w-1/2 p-2 mx-auto">
                <button @click="canshowdialogbtn()"
                    class="mx-2 p-2 bg-black !text-[#fff] border-[2px] border-black rounded-lg">Cancel</button>
                <!-- <button class="mx-2 bg-white !text-[#000] border-[2px] p-2 border-black rounded-lg" @click="saveCurrentlySelectedEmployeeConfig(selectedEmployee, type)">Confirm</button> -->
                <button class="mx-2 bg-white !text-[#000] border-[2px] p-2 border-black rounded-lg"
                    @click="saveCurrentlySelectedEmployeeConfig(filteredSource, type)">Confirm</button>
            </div>
        </div>
    </Dialog>
</template>


<script setup>
import axios from 'axios';
import { onMounted, onUpdated, reactive, ref } from 'vue';
import { useMobileSettingsStore } from '../MobileSettingsService';
import { FilterMatchMode } from 'primevue/api';


const useStore = useMobileSettingsStore()


const props = defineProps({
    type: {
        type: Number,
        required: true,
    },
})

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    department_name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const visible = ref(false)

const selectedEmployee = ref([]);
const dropdownValues = ref()
const legalEntity = ref()
const department = ref()
const filteredSource = ref();

const sub_module_id = ref();

let format = {
    id: "",
    isEnabled: "",
}

const btn = ref(1);

const getDropdownValues = async () => {
    await axios.get('/getAllDropdownFilterSetting').then(res => {
        dropdownValues.value = res.data
    })
}

const getFilteredSource = (legalEntity, department, type) => {
    console.log(legalEntity, department);
    console.log("sub_module_id", type);
    let sub_module_id = type;
    axios.post('/getEmployeesFilterData', {
        department_id: department,
        client_name: legalEntity,
        sub_module_id: sub_module_id
    }).then(res => {
        console.log(res.data);
        filteredSource.value = res.data;

        // useStore.client_id = res.data.client_id;
        console.log("testing   res.data.client_id", res.data.client_id);
    }).finally(() => {

        console.log("selectedUserId", selectedUserId);
    })

}


const selectedUserId = reactive([])

// Enable Disable function

function EnableDisable(user, EnableOrDisable, data, client_id) {
    console.log("isEnabled:" + EnableOrDisable, user);
    // let format = {
    //     id: user,
    //     isEnabled: EnableOrDisable,
    //     client_id: client_id
    // }
    // selectedUserId.push(format)
    // console.log(selectedUserId);

}

const selectedUserid = reactive([]);

function EnableAllAndDisableAll(data,type,btnType) {
    // filteredSource.value.forEach(element => selectedUserId.push(element.id));
    // console.log(selectedUserid.value);

    let btn = btnType;

    if(btnType==1){

        let val = data;
val.forEach((element) => {

    if(element.status==0){
        let format = {
        id:element.id ,
        isEnabled:1,
        client_id: useStore.client_details.id
    }
    selectedUserId.push(format);
   // console.log(" testing data Enable All",selectedUserId.value);
    }else{
       // console.log(console.log(element.id,"else ::"));
    }
});

    }

    if(btnType==2){
        selectedUserId.splice(0, selectedUserId.length);
    }



    useStore.canshowloading = true;
    axios.post('/updateEmployeesPermissionStatus', {
        "client_id": useStore.client_details.id,
        "app_sub_modules_link_id": type,
        "selected_employees_user_code": selectedUserId
    }).then((res) => {
        // console.log(res);
    }).finally(() => {
        selectedUserId.splice(0, selectedUserId.length);
        filteredSource.value ? filteredSource.value.splice(0, filteredSource.value.length) : []
        useStore.employeeAssignDialog = false;
        useStore.getMobileSettings();
        useStore.canshowloading = false;
    });

}


// const Employee_ConfigData = reactive([])

const saveCurrentlySelectedEmployeeConfig = (data, type) => {
    console.log("Dropdown legal Entity : "+legalEntity.value);
let val = data;
val.forEach((element) => {
    if(element.status==1){
        let format = {
        id:element.id ,
        isEnabled:element.status,
        client_id: legalEntity.value
    }
    selectedUserId.push(format);
    }else{
        console.log(console.log(element.id,"else ::"));
    }
});

    useStore.canshowloading = true;
    axios.post('/updateEmployeesPermissionStatus', {
        "client_id": useStore.client_details.id,
        "app_sub_modules_link_id": type,
        "selected_employees_user_code": selectedUserId
    }).then((res) => {
        // console.log(res);
    }).finally(() => {
        selectedUserId.splice(0, selectedUserId.length);
        filteredSource.value ? filteredSource.value.splice(0, filteredSource.value.length) : []
        useStore.employeeAssignDialog = false;
        useStore.getMobileSettings();
        useStore.canshowloading = false;
    })

    // "selected_employees_user_code": selectedUserId
    // console.log(data);
    // let format = {
    //     "is_mobile_app_active": [],
    //     "is_check_active": [],
    // }
    // data.forEach(element => {
    //     if (type == 1) {
    //         format.is_mobile_app_active.push(element.user_code)
    //     } else
    //         if (type == 2) {
    //             format.is_check_active.push(element.user_code)
    //         }
    // });
    // console.log(format);

    // axios.post('/updateEmployeesPermissionStatus', {
    //     is_mobile_app_active: format.is_mobile_app_active ? format.is_mobile_app_active : [],
    //     is_check_active: format.is_check_active ? format.is_check_active : []

    // }
    // )




}

function canshowdialogbtn() {
    selectedUserId.values = [];
    filteredSource.value = [];
    legalEntity.value = "";
    department.value = "";
    useStore.employeeAssignDialog = false
}






onMounted(() => {
    getDropdownValues()
})


onUpdated(() => {
    selectedEmployee.value = null
})


</script>


<style lang="scss">
.p-dropdown {
    background: #ffffff;
    border: 1px solid #ced4da;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
    border-radius: 6px;
    height: 30px;

    .p-dropdown-label {
        background: transparent;
        border: 0 none;
        margin-top: -7px;
    }
}
</style>



