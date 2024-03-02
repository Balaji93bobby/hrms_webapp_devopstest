<template>
        <div class="table-responsive ">
            <DataTable  ref="dt" dataKey="fs_id" :paginator="true" :rows="25"
                :value="investmentStore.housePropertySource" editMode="row" sortField="particular" :sortOrder="-1"
                v-model:editingRows="investmentStore.editingRowSource"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" @row-edit-save="onRowEditSave" tableClass="editable-cells-table"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">

                <Column header="Sections" field="section" style="min-width: 8rem;text-align: left !important;">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 12rem" :sortable="true">

                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.particular == 'Self Occupied Property'">
                            <div v-if="slotProps.data.json_popups_value">
                                <p  style="font-weight: 501;" >{{  investmentStore.formatCurrency(slotProps.data['json_popups_value'].income_loss ) }}</p>
                            </div>
                            <div v-else>
                                <button @click="investmentStore.getSopSlotData(slotProps.data)"  :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 mb-3 text-center text-white bg-orange-700 rounded-md">Add
                                    New</button>
                            </div>
                        </div>
                        <div v-if="slotProps.data.particular == 'Let Out Property'">
                            <div v-if="slotProps.data.json_popups_value">
                                <p  style="font-weight: 501;" >{{  investmentStore.formatCurrency(slotProps.data['json_popups_value'].income_loss ) }}</p>
                            </div>
                            <div v-else>
                                <button @click="investmentStore.getLopSlotData(slotProps.data)"  :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 mb-3 text-center text-white bg-orange-700 rounded-md">Add
                                    New</button>
                            </div>

                        </div>
                        <div v-if="slotProps.data.particular == 'Deemed Let Out Property'">
                            <div v-if="slotProps.data.json_popups_value">
                                <p  style="font-weight: 501;" >{{  investmentStore.formatCurrency(slotProps.data['json_popups_value'].income_loss ) }}</p>
                            </div>
                            <div v-else>
                                <button @click="investmentStore.getDlopSlotData(slotProps.data)"  :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 mb-3 text-center text-white bg-orange-700 rounded-md">Add
                                    New</button>
                            </div>

                        </div>

                        <div v-else-if="slotProps.data.dec_amount" class="dec_amt">
                            {{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                        </div>


                    </template>
                    <template #editor="{ data, field }">
                        <InputNumber v-model="data[field]" mode="currency" currency="INR" locale="en-US"
                            class="w-5 text-lg font-semibold" />
                    </template>

                </Column>

                <Column field="status" header="Status" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.json_popups_value">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
                <!-- <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"
                        header="Action">
                    </Column> -->
            </DataTable>

        </div>

        <div class="my-4 table-responsive" v-if="investmentStore.house_props_data[0] == 'failure'">
        </div>

        <div class=" table-responsive" v-else  >
            <DataTable ref="dt" dataKey="id" rowGroupMode="rowspan" groupRowsBy="property_type" sortMode="single"
                :value="investmentStore.house_props_data[0]" :sortOrder="+1" sortField="property_type" :paginator="true"
                :rows="10" scrollable
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">


                <Column header="Property Type" field="json_popups_value.property_type" style="min-width: 15rem" frozen>
                    <template #body="slotProps">
                        <p style="font-weight: 501;">{{ slotProps.data.json_popups_value.property_type }}</p>

                    </template>
                </Column>

                <Column header="Lender Name" field="lender_name" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;">{{ slotProps.data['json_popups_value'].lender_name }}</p>
                    </template>
                </Column>

                <Column field="lender_pan" header="Lender PAN" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;"> {{ slotProps.data['json_popups_value'].lender_pan.toUpperCase() }}</p>

                    </template>
                </Column>

                <Column field="lender_type" header="Lender Type " style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].lender_type">
                            {{ slotProps.data['json_popups_value'].lender_type }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>
                <Column field="rent_received" header="Rent Received" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].rent_received">
                            {{ investmentStore.formatCurrency(slotProps.data['json_popups_value'].rent_received) }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>
                <Column field="maintenance" header="Maintenace" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].maintenance">
                            {{ investmentStore.formatCurrency(slotProps.data['json_popups_value'].maintenance) }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>

                <Column field="net_value" header="Net Value" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].net_value">
                            {{ investmentStore.formatCurrency(slotProps.data['json_popups_value'].net_value) }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>
                <Column field="interest" header="Interest" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].interest">
                            {{ investmentStore.formatCurrency(slotProps.data['json_popups_value'].interest) }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>
                <Column field="income_loss" header="Income/Loss" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p style="font-weight: 501;" v-if="slotProps.data['json_popups_value'].income_loss">
                            {{ investmentStore.formatCurrency(slotProps.data['json_popups_value'].income_loss) }}
                        </p>
                        <p style="font-weight: 501;" v-else>
                            NA
                        </p>
                    </template>
                </Column>
                <Column field="" header="Action" style="min-width: 12rem" alignFrozen="right" frozen v-if="investmentStore.isSubmitted">
                    <template #body="slotProps">
                        <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                            @click="investmentStore.editHouseProps(slotProps.data)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                        <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                            @click="investmentStore.deleteHouseProps(slotProps.data)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 font-bold">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </template>
                </Column>

            </DataTable>

        </div>

    <div class="my-3 text-end">
        <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md me-4"
            @click="investmentStore.investment_exemption_steps--">Previous</button>
        <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md me-4"
            @click="investmentStore.saveFormData">Save</button>
        <button class="px-4 py-2 text-center text-orange-600 bg-transparent border border-orange-700 rounded-md"
            @click="investmentStore.investment_exemption_steps++">Next</button>
    </div>

    <Dialog v-model:visible="investmentStore.dailog_SelfOccupiedProperty" modal
        :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 modal-title text-primary">Self Occupied Property</h6>
        </template>
        <div class="grid my-4 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-2 sm:grid-cols-1 xl:grid-cols-2 lg:grid-cols-2">
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Lender
                    Name</label>
                <input type="text" id="lender_name" v-model="investmentStore.sop.lender_name" @keypress="isLetter($event)"
                    class="capitalize bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required :class="[
                        s$.lender_name.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="s$.lender_name.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.lender_name.$errors[0].$message }} -->
                    {{ s$.lender_name.required.$message.replace( "Value","Lender name"  ) }}
                </span>
            </div>
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Lender
                    PAN</label>
                <InputMask id="serial" mask="aaaaa9999a" class="w-full " placeholder="AHFCS1234F"
                    style="text-transform: uppercase" v-model="investmentStore.sop.lender_pan" required :class="[
                        s$.lender_pan.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="s$.lender_pan.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.lender_pan.$errors[0].$message }} -->
                    {{ s$.lender_pan.required.$message.replace( "Value","Lender PAN"  )}}
                </span>
            </div>



            <div class="">

                <label for="lender_type" class="block mb-2 font-medium text-gray-900 ">Lender
                    Type</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.sop.lender_type" :options="lender_types" optionLabel="name" optionValue="code"
                    placeholder="Select a Property" required :class="[
                        s$.lender_type.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="s$.lender_type.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.lender_type.$errors[0].$message }} -->
                    {{ s$.lender_type.required.$message.replace( "Value","Lender type"  )}}
                </span>
            </div>
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">
                    Income/Loss</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.sop.income_loss" required :class="[
                    s$.income_loss.$error ? 'p-invalid' : '',
                ]" />
                <span v-if="s$.income_loss.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.income_loss.$errors[0].$message }} -->
                    {{ s$.income_loss.required.$message.replace( "Value","Income loss"  ) }}
                </span>
            </div>
        </div>
        <div class="grid mb-6 gap-y-4 gap-x-6 md:grid-cols-1 2xl:grid-cols-1 sm:grid-cols-1 xl:grid-cols-1 lg:grid-cols-1">
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">
                    Address</label>
                <textarea name="" id="" rows="3" v-model="investmentStore.sop.address"
                    class="bg-gray-50 resize-none border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required :class="[
                        s$.address.$error ? 'border border-red-500' : '',
                    ]">
                    </textarea>
                <span v-if="s$.address.$error" class="font-semibold text-red-400 fs-6">
                    {{ s$.address.$errors[0].$message }}
                </span>
            </div>
        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitSOP">Save</button>
        </div>


    </Dialog>

    <Dialog v-model:visible="investmentStore.dailog_LetOutProperty" modal
        :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 modal-title text-primary">Let Out Property</h6>
        </template>


        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-3 sm:grid-cols-1 xl:grid-cols-3 lg:grid-cols-3">
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Lender
                    Name</label>
                <input type="text" id="lender_name" v-model="investmentStore.lop.lender_name" @keypress="isLetter($event)"
                    class="capitalize bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required :class="[
                        v$.lender_name.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="v$.lender_name.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.lender_name.$errors[0].$message }} -->
                    {{ v$.lender_name.required.$message.replace( "Value","Lender name"  )}}
                </span>
            </div>
            <div class="">
                <label for="lender_pan" class="block mb-2 font-medium text-gray-900 ">Lender
                    PAN</label>
                <InputMask id="serial" mask="aaaaa9999a" class="w-full " placeholder="AHFCS1234F"
                    style="text-transform: uppercase" v-model="investmentStore.lop.lender_pan" required :class="[
                        v$.lender_pan.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="v$.lender_pan.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.lender_pan.required.$message.replace( "Value","Lender PAN"  )}}
                    <!-- {{ v$.lender_pan.$errors[0].$message }} -->
                </span>

            </div>


            <div class="">

                <label for="lender_type" class="block mb-2 font-medium text-gray-900 ">Lender
                    Type</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.lop.lender_type" :options="lender_types" optionLabel="name" optionValue="code"
                    placeholder="Select a Property" required :class="[
                        v$.lender_type.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="v$.lender_type.$error" class="font-semibold text-red-400 fs-6">
                    {{ v$.lender_type.$errors[0].$message }}
                    {{ v$.lender_type.required.$message.replace( "Value","Lender type"  ) }}
                </span>
            </div>

            <div class="">
                <label for="rend_received" class="block mb-2 font-medium text-gray-900 ">Rent
                    Received</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.lop.rent_received" required :class="[
                    v$.rent_received.$error ? 'p-invalid' : '',
                ]" />
                <span v-if="v$.rent_received.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.rent_received.$errors[0].$message }} -->
                    {{ v$.rent_received.required.$message.replace( "Value","Rent received"  ) }}
                </span>
            </div>
            <div class="">

                <label for="municipal_tax" class="block mb-2 font-medium text-gray-900 ">Municipal
                    Tax</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.lop.municipal_tax" required :class="[
                    v$.municipal_tax.$error ? 'p-invalid' : '',
                ]" @focusout="investmentStore.income_loss_calculation" />
                <span v-if="v$.municipal_tax.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.municipal_tax.$errors[0].$message }} -->
                    {{ v$.municipal_tax.required.$message.replace( "Value","Municipal tax"  ) }}
                </span>
            </div>
            <div class="">
                <label for="maintenance" class="block mb-2 font-medium text-gray-900 ">Maintenance</label>
                <input type="text" id="maintenance" v-model="investmentStore.lop.maintenance" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
            </div>
            <div class="">
                <label for="Net_Value" class="block mb-2 font-medium text-gray-900 ">Net
                    Value</label>
                <input type="text" id="Net_Value" v-model="investmentStore.lop.net_value" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-100 focus:outline-none focus:ring outline-1  block w-full p-2.5 " />
            </div>
            <div class="">
                <label for="Interest" class="block mb-2 font-medium text-gray-900 ">Interest</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.lop.interest" required :class="[
                    v$.interest.$error ? 'p-invalid' : '',
                ]" @focusout="investmentStore.income_loss_calculation" />
                <span v-if="v$.interest.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.interest.$errors[0].$message }} -->
                    {{ v$.interest.required.$message.replace( "Value","Interest"  ) }}
                </span>
            </div>
            <div class="">
                <label for="Income/Loss" class="block mb-2 font-medium text-gray-900 ">Income/Loss</label>
                <input type="text" id="Income/Loss" v-model="investmentStore.lop.income_loss" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
            </div>

        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitLop">Save</button>
        </div>



    </Dialog>


    <Dialog v-model:visible="investmentStore.dailog_DeemedLetOutProperty" modal
        :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 modal-title text-primary">Deemed Let Out Property</h6>
        </template>

        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-3 sm:grid-cols-1 xl:grid-cols-3 lg:grid-cols-3">
            <div class="">
                <label for="lender_name" class="block mb-2 font-medium text-gray-900 ">Lender
                    Name</label>
                <input type="text" id="lender_name" v-model="investmentStore.dlop.lender_name" @keypress="isLetter($event)"
                    class="capitalize bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required :class="[
                        p$.lender_name.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="p$.lender_name.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.lender_name.$errors[0].$message }} -->
                    {{ p$.lender_name.required.$message.replace( "Value","Lender name"  ) }}
                </span>
            </div>
            <div class="">
                <label for="lender_pan" class="block mb-2 font-medium text-gray-900 ">Lender
                    PAN</label>
                <InputMask id="serial" mask="aaaaa9999a" class="w-full " placeholder="AHFCS1234F"
                    style="text-transform: uppercase" v-model="investmentStore.dlop.lender_pan" required :class="[
                        p$.lender_pan.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="p$.lender_pan.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.lender_pan.$errors[0].$message }} -->
                    {{ p$.lender_pan.required.$message.replace( "Value","Lender PAN"  )}}
                </span>
            </div>


            <div class="">

                <label for="lender_type" class="block mb-2 font-medium text-gray-900 ">Lender
                    Type</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.dlop.lender_type" :options="lender_types" optionLabel="name" optionValue="code"
                    placeholder="Select a Property" required :class="[
                        p$.lender_type.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="p$.lender_type.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.lender_type.$errors[0].$message }} -->
                    {{ p$.lender_type.required.$message.replace( "Value","Lender type"  ) }}
                </span>
            </div>

            <div class="">
                <label for="rend_received" class="block mb-2 font-medium text-gray-900 ">Rent
                    Received</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.dlop.rent_received" required :class="[
                    p$.rent_received.$error ? 'p-invalid' : '',
                ]" />
                <span v-if="p$.rent_received.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.rent_received.$errors[0].$message }} -->
                    {{ p$.rent_received.required.$message.replace( "Value","Rent received"  )}}
                </span>
            </div>
            <div class="">

                <label for="municipal_tax" class="block mb-2 font-medium text-gray-900 ">Municipal
                    Tax</label>

                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.dlop.municipal_tax" required :class="[
                    p$.municipal_tax.$error ? 'p-invalid' : '',
                ]" @focusout="investmentStore.income_loss_calculation" />
                <span v-if="p$.municipal_tax.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.municipal_tax.$errors[0].$message }} -->
                    {{ p$.municipal_tax.required.$message.replace( "Value","Municipal Tax"  ) }}
                </span>
            </div>
            <div class="">
                <label for="maintenance" class="block mb-2 font-medium text-gray-900 ">Maintenance</label>
                <input type="text" id="maintenance" v-model="investmentStore.dlop.maintenance" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
            </div>
            <div class="">
                <label for="Net_Value" class="block mb-2 font-medium text-gray-900 ">Net
                    Value</label>
                <input type="text" id="Net_Value" v-model="investmentStore.dlop.net_value" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-100 focus:outline-none focus:ring outline-1  block w-full p-2.5 " />
            </div>
            <div class="">
                <label for="Interest" class="block mb-2 font-medium text-gray-900 ">Interest</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.dlop.interest" required :class="[
                    p$.interest.$error ? 'p-invalid' : '',
                ]" @focusout="investmentStore.income_loss_calculation" />
                <span v-if="p$.interest.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.interest.$errors[0].$message }} -->
                    {{ p$.interest.required.$message.replace( "Value","Interest"  ) }}
                </span>
            </div>
            <div class="">
                <label for="Income/Loss" class="block mb-2 font-medium text-gray-900 ">Income/Loss</label>
                <input type="text" id="Income/Loss" v-model="investmentStore.dlop.income_loss" readonly
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
            </div>
        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitDlop">Save</button>
        </div>

    </Dialog>
</template>


<script setup>
import { onMounted, ref, computed } from "vue";
import { investmentMainStore } from "../../../stores/investmentMainStore";
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import useValidate from '@vuelidate/core'


const investmentStore = investmentMainStore()


const rulesSop = computed(() => {
    return {
        lender_name: { required },
        lender_type: { required },
        lender_pan: { required },
        income_loss: { required },
        address: { required },
    }
})

const s$ = useValidate(rulesSop, investmentStore.sop)

const submitSOP = () => {
    console.log(s$.value);
    s$.value.$validate() // checks all inputs
    if (!s$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.saveSelfOccupiedProperty()
        s$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


const ruleslop = computed(() => {
    return {
        lender_name: { required },
        lender_type: { required },
        lender_pan: { required },
        income_loss: { required },
        municipal_tax: { required },
        maintenance: { required },
        interest: { required },
        income_loss: { required },
        net_value: { required },
        rent_received: { required },
    }
})

const v$ = useValidate(ruleslop, investmentStore.lop)

const submitLop = () => {
    console.log(v$.value);
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.saveLetOutProperty()
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


const rulesDlop = computed(() => {
    return {
        lender_name: { required },
        lender_type: { required },
        lender_pan: { required },
        income_loss: { required },
        municipal_tax: { required },
        maintenance: { required },
        interest: { required },
        income_loss: { required },
        net_value: { required },
        rent_received: { required },
    }
})
const p$ = useValidate(rulesDlop, investmentStore.dlop)

const submitDlop = () => {
    console.log(p$.value);
    p$.value.$validate() // checks all inputs
    if (!p$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.saveDeemedLetOutProperty()
        p$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}


const property_type = ref();
const property_types = ref([
    { name: 'Self Occupied Property', code: 'Self Occupied Property' },
    { name: 'Let Out Property', code: 'Let Out Property' },
    { name: 'Deemed Let Out Property', code: 'Deemed Let Out Property' },

]);
const lender_types = ref([
    { name: 'Financial Institution', code: 'Financial Institution' },
    { name: 'Others', code: 'Others' },

]);




const isLetter = (e) => {
    let char = String.fromCharCode(e.keyCode); // Get the character
    if (/^[A-Za-z_ ]+$/.test(char)) return true; // Match with regex
    else e.preventDefault(); // If not match, don't add to input text
}
</script>
