<template>
    <div>
        <div class="card py-3 " style="border-left:5px solid navy ">
            <div class="d-flex justify-items-start align-content-center pl-3">
                <button class="mt-1" style="width: 15px;"> <i class="fas fa-chevron-left fs-4" style="color:#002f56 ;"></i>
                </button>
                <h1 class=" fw-bold fs-4  pl-3">General Shift</h1>
            </div>
        </div>

        <!-- <div class="card"> -->
        <!-- <div class="pb-3">
            <Button @click="active = 0" text label="Activate 1st" />
            <Button @click="active = 1" text class="mr-2" label="Activate 2nd" />
            <Button @click="active = 2" text class="mr-2" label="Activate 3rd" />
        </div> -->

        <Accordion v-model:activeIndex="active" class="mt-4">
            <AccordionTab class="fs-3 ">
                <template #header>
                    <span class="fs-5 pl-5" >Summary</span>
                </template>
                <div class="card p-3">
                    <DataTable paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" class="w-full">
                        <template #header>
                            <div class="flex justify-content-start pl-2">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                </span>
                            </div>
                        </template>
                        <template #empty> No Matching Records Found </template>
                        <Column field="name" header="Timing" :sortable="true" ></Column>
                        <Column field="name" header="Monday" :sortable="true" ></Column>
                        <Column field="name" header="Tuesday" :sortable="true" ></Column>
                        <Column field="country.name" header="Wednesday" :sortable="true" ></Column>
                        <Column field="company" header="Thursday" :sortable="true" ></Column>
                        <Column field="representative.name" header="Friday" :sortable="true" ></Column>
                        <Column field="company" header="Saturday" :sortable="true" ></Column>
                        <Column field="company" header="Sunday" :sortable="true"></Column>
                    </DataTable>
                    <div class="d-flex justify-content-around mt-5 w-full border-bottom pb-4">
                        <div class="d-flex fw-bold justify-content-center align-items-center">
                            <h1 class="fw-bold mr-4">Half Day Minimum Working Hours Required</h1>
                            <button class="btn bg-slate-300 mx-2 px-2 h-6 d-flex align-items-center">4</button>
                            <h1>Hours</h1>
                        </div>
                        <div class="d-flex fw-bold justify-content-center align-items-center">
                            <h1 class="fw-bold mr-4">Full Day Minimum Working Hours Required</h1> <button
                                class="btn bg-slate-300 mx-2 px-2 h-6 d-flex align-items-center">4</button>
                            <h1>Hours</h1>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center mt-2">
                        <div class="col-2 col-sm">
                            <h1 class="fs-5">Grace Time</h1>
                        </div>
                        <div class="col-2 d-flex align-items-center"> <button
                                class="btn bg-slate-300 mx-2 px-2 h-6 d-flex align-items-center">30</button>
                            <p class="bg-gray">Minutes</p>
                        </div>
                        <div class="col-5">
                            <p class="text-danger bg-red-100 p-1 rounded">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. Illum numquam, maiores </p>
                        </div>
                    </div>
                </div>

            </AccordionTab>
            <AccordionTab>
                <template #header>
                    <span class="fs-5 pl-5" >Employees</span>
                </template>

                <div class="card p-3">
                    <DataTable paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" class="w-full">
                        <template #header>
                            <div class="flex justify-content-start pl-2">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                </span>
                            </div>
                        </template>
                        <template #empty> No Matching Records Found </template>
                        <Column field="name" header="Employee" :sortable="true" ></Column>
                        <Column field="name" header="Employee Number" :sortable="true" ></Column>
                        <Column field="name" header="Job Title" :sortable="true" ></Column>
                        <Column field="country.name" header="Reporting To" :sortable="true" ></Column>
                        <Column field="company" header="Department" :sortable="true" ></Column>
                        <Column field="representative.name" header="Loaction" :sortable="true" ></Column>
                    </DataTable>
                </div>

            </AccordionTab>
            <AccordionTab  >
                <template #header >
                    <span class="fs-5 pl-5" >WeekOffs</span>
                </template>

                <div class="card p-3">
                    <DataTable :paginator="true" :rows="10" dataKey="id"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[5, 10, 25]" sortField="PAYROLL_MONTH" :sortOrder="-1"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                        responsiveLayout="scroll" :globalFilterFields="['name']" class="w-full">
                        <template #header>
                            <div class="flex justify-content-start pl-2">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                </span>
                            </div>
                        </template>
                        <template #empty> No Matching Records Found </template>
                        <Column field="name" header="Week Offs" :sortable="true" ></Column>
                        <Column field="name" header="Day Offs" :sortable="true" ></Column>
                    </DataTable>
                </div>


            </AccordionTab>
            <AccordionTab  >
                <template #header>
                    <span class="fs-5 pl-5" >Track Shift Versions</span>
                </template>

                <div class="card p-3">
                    <DataTable paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" class="w-full">
                        <template #header>
                            <div class="flex justify-content-start pl-2">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                </span>
                            </div>
                        </template>
                        <template #empty> No Matching Records Found </template>
                        <Column field="name" header="Current Date"></Column>
                        <Column field="name" header="Updated Date"></Column>
                        <Column field="name" header="Action"></Column>
                    </DataTable>
                </div>


            </AccordionTab>
        </Accordion>
        <!-- </div> -->



    </div>
</template>


<script setup>
import { ref, reactive } from 'vue';
import { FilterMatchMode } from 'primevue/api';

const active = ref(0);

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'country.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    representative: { value: null, matchMode: FilterMatchMode.IN },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
    verified: { value: null, matchMode: FilterMatchMode.EQUALS }
});

</script>


<style>
.p-highlight, .p-accordion-header-action{
    background-color: #002f56 !important;
    color: white !important;
    border-radius: 6px 6px 0 0;
}
.p-accordion-header-action:active ,.p-accordion-header-action:focus {
    background-color: white !important;
    color:#002f56 !important;
}

.p-accordion-header-link{

}
</style>


{
<!--

<template>
    <div class="card">
        <DataTable v-model:filters="filters" :value="customers" paginator :rows="10" dataKey="id" filterDisplay="row" :loading="loading"
                :globalFilterFields="['name', 'country.name', 'representative.name', 'status']">
            <template #header>
                <div class="flex justify-content-end">
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                    </span>
                </div>
            </template>
            <template #empty> No customers found. </template>
            <template #loading> Loading customers data. Please wait. </template>
            <Column field="name" header="Name" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.name }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by name" />
                </template>
            </Column>
            <Column header="Country" filterField="country.name" style="min-width: 12rem">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <img alt="flag" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`flag flag-${data.country.code}`" style="width: 24px" />
                        <span>{{ data.country.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by country" />
                </template>
            </Column>
            <Column header="Agent" filterField="representative" :showFilterMenu="false" :filterMenuStyle="{ width: '14rem' }" style="min-width: 14rem">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <img :alt="data.representative.name" :src="`https://primefaces.org/cdn/primevue/images/avatar/${data.representative.image}`" style="width: 32px" />
                        <span>{{ data.representative.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <MultiSelect v-model="filterModel.value" @change="filterCallback()" :options="representatives" optionLabel="name" placeholder="Any" class="p-column-filter" style="min-width: 14rem" :maxSelectedLabels="1">
                        <template #option="slotProps">
                            <div class="flex align-items-center gap-2">
                                <img :alt="slotProps.option.name" :src="`https://primefaces.org/cdn/primevue/images/avatar/${slotProps.option.image}`" style="width: 32px" />
                                <span>{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </MultiSelect>
                </template>
            </Column>
            <Column field="status" header="Status" :showFilterMenu="false" :filterMenuStyle="{ width: '14rem' }" style="min-width: 12rem">
                <template #body="{ data }">
                    <Tag :value="data.status" :severity="getSeverity(data.status)" />
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Select One" class="p-column-filter" style="min-width: 12rem" :showClear="true">
                        <template #option="slotProps">
                            <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)" />
                        </template>
                    </Dropdown>
                </template>
            </Column>
            <Column field="verified" header="Verified" dataType="boolean" style="min-width: 6rem">
                <template #body="{ data }">
                    <i class="pi" :class="{ 'pi-check-circle text-green-500': data.verified, 'pi-times-circle text-red-400': !data.verified }"></i>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { CustomerService } from '@/service/CustomerService';

const customers = ref();
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'country.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    representative: { value: null, matchMode: FilterMatchMode.IN },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
    verified: { value: null, matchMode: FilterMatchMode.EQUALS }
});
const representatives = ref([
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'XuXue Feng', image: 'xuxuefeng.png' }
]);
const statuses = ref(['unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal']);
const loading = ref(true);

onMounted(() => {
    CustomerService.getCustomersMedium().then((data) => {
            customers.value = getCustomers(data);
            loading.value = false;
        });
});

const getCustomers = (data) => {
    return [...(data || [])].map((d) => {
        d.date = new Date(d.date);

        return d;
    });
};
const formatDate = (value) => {
    return value.toLocaleDateString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};
const formatCurrency = (value) => {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
};
const getSeverity = (status) => {
    switch (status) {
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warning';

        case 'renewal':
            return null;
    }
}

</script>




<template>
    <div class="card">
        <div class="pb-3">
            <Button @click="active = 0" text label="Activate 1st" />
            <Button @click="active = 1" text class="mr-2" label="Activate 2nd" />
            <Button @click="active = 2" text class="mr-2" label="Activate 3rd" />
        </div>

        <Accordion v-model:activeIndex="active">
            <AccordionTab header="Header I">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </AccordionTab>
            <AccordionTab header="Header II">
                <p>
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                    ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
                </p>
            </AccordionTab>
            <AccordionTab header="Header III">
                <p>
                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui
                    officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                </p>
            </AccordionTab>
        </Accordion>
    </div>
</template>

<script setup>
    import { ref } from 'vue';


</script>


 -->
}
