<template>
    <div>
        <div class="table-responsive" v-if="investmentStore.otherExemptionSource">
            <DataTable ref="dt" resizableColumns columnResizeMode="expand" dataKey="fs_id" :paginator="true" :rows="25"
                :value="investmentStore.otherExemptionSource" @row-edit-save="onRowEditSave"
                tableClass="editable-cells-table" editMode="row" v-model:editingRows="investmentStore.editingRowSource"
                responsiveLayout="scroll"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records">

                <Column header="Sections" field="section" style="min-width: 2rem">
                </Column>

                <Column field="particular" header="Particulars" style="min-width: 15rem;text-align: left !important;">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.section == '80DD'">
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                            <div class="flex py-2">
                                <input type="radio" name="80DD" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input" v-model="slotProps.data.select_option"
                                    :value="slotProps.data.section_option_1"
                                    :checked="slotProps.data.section_option_1 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_1 }}</p>
                            </div>
                            <div class="flex py-2">

                                <input type="radio" name="80DD" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input" v-model="slotProps.data.select_option"
                                    :value="slotProps.data.section_option_2"
                                    :checked="slotProps.data.section_option_2 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_2 }}</p>

                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80DDB'">
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                            <div class="flex py-2">
                                <input type="radio" name="80DDB" id="" style="height: 20px;width: 20px;"
                                    v-model="slotProps.data.select_option" class="form-check-input"
                                    :value="slotProps.data.section_option_1"
                                    :checked="slotProps.data.section_option_1 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_1 }}</p>
                            </div>
                            <div class="flex py-2">
                                <input type="radio" name="80DDB" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input" v-model="slotProps.data.select_option"
                                    :value="slotProps.data.section_option_2"
                                    :checked="slotProps.data.section_option_2 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_2 }}</p>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80U'">
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                            <div class="flex py-2">
                                <input type="radio" name="80U" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input" v-model="slotProps.data.select_option"
                                    :value="slotProps.data.section_option_1"
                                    :checked="slotProps.data.section_option_1 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_1 }}</p>
                            </div>
                            <div class="flex py-2">
                                <input type="radio" name="80U" id="" style="height: 20px;width: 20px;"
                                    class="form-check-input" v-model="slotProps.data.select_option"
                                    :value="slotProps.data.section_option_2"
                                    :checked="slotProps.data.section_option_2 == slotProps.data.selected_section_options ? true : false">
                                <p class="mx-2" style="font-weight: 501;">{{ slotProps.data.section_option_2 }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <p style="font-weight: 501;">{{ slotProps.data.particular }}</p>
                        </div>
                    </template>
                </Column>

                <Column field="reference" header="References " style="min-width: 12rem">
                    <template #body="slotProps">
                        <button type="button" class="border-0 outline-none btn btn-transprarent"
                            v-tooltip="slotProps.data.reference">
                            <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
                        </button>
                    </template>
                </Column>

                <Column field="max_amount" header="Max Limit" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.section == '80DD'">
                            <p v-if="slotProps.data.select_option == 'Normal Disability ( 40% to 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(75000) }}</p>
                            <p v-else-if="slotProps.data.select_option == 'Severe Disability (More than 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(125000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Normal Disability ( 40% to 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(75000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Severe Disability (More than 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(125000) }}</p>
                            <p v-else style="font-weight: 501;">--</p>
                        </div>
                        <div v-else-if="slotProps.data.section == '80DDB'">
                            <p v-if="slotProps.data.select_option == 'Individuals (less than 60 years)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(40000) }}</p>
                            <p v-else-if="slotProps.data.select_option == 'Senior citizen (aged 60 years or more)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(100000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Individuals (less than 60 years)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(40000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Senior citizen (aged 60 years or more)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(100000) }}</p>
                            <p v-else style="font-weight: 501;">--</p>
                        </div>
                        <div v-else-if="slotProps.data.section == '80U'">
                            <p v-if="slotProps.data.select_option == 'Normal Disability ( 40% to 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(75000) }}</p>
                            <p v-else-if="slotProps.data.select_option == 'Severe Disability (More than 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(125000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Normal Disability ( 40% to 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(75000) }}</p>
                            <p v-else-if="slotProps.data.selected_section_options == 'Severe Disability (More than 80%)'"
                                style="font-weight: 501;">{{ investmentStore.formatCurrency(125000) }}</p>
                            <p v-else style="font-weight: 501;">--</p>
                        </div>
                        <div v-else>
                            <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.max_amount) }}</p>
                        </div>
                    </template>
                </Column>

                <Column field="dec_amount" header="Declaration Amount" style="min-width: 8rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.section == '80EE'">
                            <div v-if="slotProps.data.json_popups_value">
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>
                            </div>
                            <div v-else class="px-auto">
                                <button @click="investmentStore.get80EESlotData(slotProps.data)"
                                    :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 text-center text-white bg-orange-700 rounded-md ">Add
                                    80EE</button>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80EEA'">
                            <div v-if="slotProps.data.json_popups_value">
                                <!-- <p>{{ investmentStore.formatCurrency(slotProps.data.json_popups_value.interest_amount_paid) }}</p> -->
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>

                            </div>
                            <div v-else>
                                <button @click="investmentStore.get80EEASlotData(slotProps.data)"
                                    :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 text-center text-white bg-orange-700 rounded-md ">Add
                                    80EEA</button>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80EEB'">
                            <div v-if="slotProps.data.json_popups_value">
                                <!-- <p>{{ investmentStore.formatCurrency(slotProps.data.json_popups_value.interest_amount_paid) }}</p> -->
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>
                            </div>
                            <div v-else>
                                <button @click="investmentStore.get80EEBSlotData(slotProps.data)"
                                    :disabled="!investmentStore.isSubmitted"
                                    class="px-4 py-2 text-center text-white bg-orange-700 rounded-md ">Add
                                    80EEB</button>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80DD'">
                            <div v-if="slotProps.data.selected_section_options">
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>
                            </div>
                            <div v-else-if="slotProps.data.select_option">
                                <InputNumber class="mx-auto text-lg font-semibold w-28" v-model="slotProps.data.dec_amt"
                                    @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                    currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted" />
                            </div>
                            <div v-else>
                                <p style="font-weight: 501;">--</p>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80DDB'">
                            <div v-if="slotProps.data.selected_section_options">
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>
                            </div>
                            <div v-else-if="slotProps.data.select_option">
                                <InputNumber class="mx-auto text-lg font-semibold w-28" v-model="slotProps.data.dec_amt"
                                    @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                    currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted" />
                            </div>
                            <div v-else>
                                <p style="font-weight: 501;">--</p>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.section == '80U'">
                            <div v-if="slotProps.data.selected_section_options">
                                <p style="font-weight: 501;">{{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                                </p>
                            </div>
                            <div v-else-if="slotProps.data.select_option">
                                <InputNumber class="mx-auto text-lg font-semibold w-28" v-model="slotProps.data.dec_amt"
                                    @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                    currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted" />
                            </div>
                            <div v-else>
                                <p style="font-weight: 501;">--</p>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.dec_amount" class="dec_amt">
                            {{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                        </div>
                        <div v-else>
                            <InputNumber class="mx-auto text-lg font-semibold w-28" v-model="slotProps.data.dec_amt"
                                @focusout="investmentStore.getDeclarationAmount(slotProps.data)" mode="currency"
                                currency="INR" locale="en-US" :readonly="!investmentStore.isSubmitted" />
                        </div>
                    </template>
                    <template #editor="{ data, field }">
                        <!-- <div v-if="data.section == '80EE'">
                            <InputNumber v-model="data.json_popups_value['interest_amount_paid']" mode="currency"
                                currency="INR" locale="en-US" class="w-6 text-lg font-semibold" />
                        </div>
                        <div v-else-if="data.section == '80EEA'">
                            <InputNumber v-model="data.json_popups_value['interest_amount_paid']" mode="currency"
                                currency="INR" locale="en-US" class="w-6 text-lg font-semibold" />
                        </div>
                        <div v-else-if="data.section == '80EEB'">
                            <InputNumber v-model="data.json_popups_value['interest_amount_paid']" mode="currency"
                                currency="INR" locale="en-US" class="w-6 text-lg font-semibold" />
                        </div> -->
                        <div>
                            <InputNumber v-model="data[field]" mode="currency" currency="INR" locale="en-US"
                                class="text-lg font-semibold w-28" :readonly="!investmentStore.isSubmitted" />
                        </div>


                    </template>
                </Column>
                <Column field="Status" header="Status" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.dec_amount">
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 rounded-md bg-green-50 ring-1 ring-inset ring-green-100/20">Completed</span>
                        </div>
                        <div v-else>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-100/20">Pending</span>
                        </div>
                    </template>
                </Column>
                <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center" header="Action"
                    v-if="investmentStore.isSubmitted">
                </Column>
            </DataTable>

        </div>
        <div class="my-4 table-responsive" v-if="investmentStore.otherExeSectionData[0] == 'failure'">

        </div>
        <div class="my-4 table-responsive"  v-else>
            <DataTable ref="dt" dataKey="id" :paginator="true" :rows="10" :value="investmentStore.otherExeSectionData[0]"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]" v-if="investmentStore.otherExeSectionData.length > 0 "
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll">
                <Column header="Loan Sanction Date" field="json_popups_value.loan_sanction_date" style="min-width: 8rem">
                    <template #body="slotProps">
                        {{ slotProps.data.json_popups_value.loan_sanction_date ? moment(slotProps.data.json_popups_value.loan_sanction_date).format('DD-MM-YYYY') : '-' }}
                    </template>
                </Column>

                <Column field="json_popups_value.lender_type" header="Lender Type" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p v-if="slotProps.data.json_popups_value.section == '80EEB'" style="font-weight: 501;">NA</p>
                        <p v-else style="font-weight: 501;">{{ slotProps.data.json_popups_value.lender_type ? slotProps.data.json_popups_value.lender_type : '-' }}</p>
                    </template>

                </Column>

                <Column field="json_popups_value.property_value" header="Property Value " style="min-width: 12rem">
                    <template #body="slotProps">
                        <p v-if="slotProps.data.json_popups_value.section == '80EEB'" style="font-weight: 501;">NA</p>
                        <p v-else style="font-weight: 501;">{{ slotProps.data.json_popups_value.property_value ? slotProps.data.json_popups_value.property_value : '-' }}</p>
                    </template>
                </Column>

                <Column field="json_popups_value.vechicle_model" header="Vechile Type " style="min-width: 12rem">
                    <template #body="slotProps">
                        <p v-if="slotProps.data.json_popups_value.section == '80EEB'" style="font-weight: 501;">
                            {{ slotProps.data.json_popups_value.vechicle_model }}</p>
                        <p v-else style="font-weight: 501;">NA</p>
                    </template>
                </Column>
                <Column field="json_popups_value.vechile_brand" header="Vechile Brand " style="min-width: 12rem">
                    <template #body="slotProps">
                        <p v-if="slotProps.data.json_popups_value.section == '80EEB'" style="font-weight: 501;">
                            {{ slotProps.data.json_popups_value.vechicle_brand }}</p>
                        <p v-else style="font-weight: 501;">NA</p>
                    </template>
                </Column>

                <Column field="json_popups_value.loan_amount" header="Loan Amount" style="min-width: 12rem">
                    <template #body="slotProps">
                        <p v-if="slotProps.data.json_popups_value.section == '80EEB'" style="font-weight: 501;">NA</p>
                        <p v-else style="font-weight: 501;">{{ slotProps.data.json_popups_value.loan_amount }}</p>
                    </template>
                </Column>

                <Column field="json_popups_value.interest_amount_paid" header="Interest Amount Paid"
                    style="min-width: 12rem">
                </Column>
                <Column field="" header="Action" style="min-width: 12rem" v-if="investmentStore.isSubmitted">
                    <template #body="slotProps">
                        <button class="p-2 mx-4 bg-green-200 border-green-500 rounded-xl"
                            @click="investmentStore.editOtherExe(slotProps.data)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>

                        </button>
                        <button class="p-2 bg-red-200 border-red-500 rounded-xl"
                            @click="investmentStore.deleteOtherExeDetails(slotProps.data)">
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
    </div>

    <!-- Declaration Amount Dailog -->

    <Dialog v-model:visible="investmentStore.dailog_80EE" modal :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 modal-title text-primary">80EE<span class="ml-3 text-xs font-semibold text-gray-400">(The
                    maximum deduction of Rs 50,000 can
                    be claimed under this section)</span> </h6>
        </template>
        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-3 sm:grid-cols-1 xl:grid-cols-3 lg:grid-cols-3">

            <div class="">
                <label for="sanction_date" class="block mb-2 font-medium text-gray-900 ">Loan
                    Sanction Date</label>
                <Calendar :minDate="new Date('04/01/2016')" :maxDate="new Date('03/31/2017')"
                    placeholder="Loan Sanction Date" v-model="investmentStore.other_exe_80EE.loan_sanction_date"
                    class="w-full " showIcon required :class="[
                        v$.loan_sanction_date.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.loan_sanction_date.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.loan_sanction_date.$errors[0].$message }} -->
                    {{ v$.loan_sanction_date.required.$message.replace("Value", "Loan sanction date") }}
                </span>
            </div>
            <div class="">

                <label for="lender_type" class="block mb-2 font-medium text-gray-900 ">Lender
                    Type</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.other_exe_80EE.lender_type" :options="lender_types" optionLabel="name"
                    optionValue="code" placeholder="Select a Property" required :class="[
                        v$.lender_type.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="v$.lender_type.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.lender_type.$errors[0].$message }} -->
                    {{ v$.lender_type.required.$message.replace("Value", "Lender name") }}
                </span>
            </div>

            <div class="">
                <label for="property_value" class="block mb-2 font-medium text-gray-900 ">Property
                    Value</label>
                <!-- <input type="text" id="property_value" v-model="investmentStore.other_exe_80EE.property_value"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        required :class="[
                            v$.property_value.$error ? 'border border-red-500' : '',
                        ]" /> -->
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.other_exe_80EE.property_value"
                    required :class="[
                        v$.property_value.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.property_value.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.property_value.$errors[0].$message }} -->
                    {{ v$.property_value.required.$message.replace("Value", "Property value") }}
                </span>
            </div>
            <div class="">
                <label for="loan_amount" class="block mb-2 font-medium text-gray-900 ">Loan
                    Amount</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.other_exe_80EE.loan_amount" required
                    :class="[
                        v$.loan_amount.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.loan_amount.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.loan_amount.$errors[0].$message }} -->
                    {{ v$.loan_amount.required.$message.replace("Value", "Loan Amount") }}
                </span>

            </div>
            <div class="">
                <label for="declaration_amount" class="block mb-2 font-medium text-gray-900 ">Interest
                    Amount Paid</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.other_exe_80EE.interest_amount_paid"
                    required :class="[
                        v$.interest_amount_paid.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="v$.interest_amount_paid.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ v$.interest_amount_paid.$errors[0].$message }} -->
                    {{ v$.interest_amount_paid.required.$message.replace("Value", "Loan amount paid") }}
                </span>
            </div>

        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitForm80EE">Save</button>
        </div>
    </Dialog>


    <Dialog v-model:visible="investmentStore.dailog_80EEA" modal :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 modal-title text-primary">80EEA <span class="ml-3 text-xs font-semibold text-gray-400">(The
                    maximum deduction available under
                    this section is Rs. 1.5 Lakhs)</span> </h6>
        </template>

        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-3 sm:grid-cols-1 xl:grid-cols-3 lg:grid-cols-3">

            <div class="">
                <label for="sanction_date" class="block mb-2 font-medium text-gray-900 ">Loan
                    Sanction Date</label>
                <Calendar :minDate="new Date('04/01/2019')" :maxDate="new Date('03/31/2020')"
                    placeholder="Loan Sanction Date" v-model="investmentStore.other_exe_80EEA.loan_sanction_date"
                    class="w-full " showIconrequired :class="[
                        s$.loan_sanction_date.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="s$.loan_sanction_date.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.loan_sanction_date.$errors[0].$message }} -->
                    {{ s$.loan_sanction_date.required.$message.replace("Value", "Loan sanction date") }}
                </span>
            </div>



            <div class="">

                <label for="lender_type" class="block mb-2 font-medium text-gray-900 ">Lender
                    Type</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.other_exe_80EEA.lender_type" :options="lender_types" optionLabel="name"
                    optionValue="code" placeholder="Select a Property" required :class="[
                        s$.lender_type.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="s$.lender_type.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.lender_type.$errors[0].$message }} -->
                    {{ s$.lender_type.required.$message.replace("Value", "Lender name") }}
                </span>

            </div>

            <div class="">
                <label for="property_value" class="block mb-2 font-medium text-gray-900 ">Property
                    Value</label>

                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.other_exe_80EEA.property_value"
                    required :class="[
                        s$.property_value.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="s$.property_value.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.property_value.$errors[0].$message }} -->
                    {{ s$.property_value.required.$message.replace("Value", "Property value") }}
                </span>
            </div>
            <div class="">
                <label for="loan_amount" class="block mb-2 font-medium text-gray-900 ">Loan
                    Amount</label>
                <InputNumber id="rendPaid_inp" class="w-full " v-model="investmentStore.other_exe_80EEA.loan_amount"
                    required :class="[
                        s$.loan_amount.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="s$.loan_amount.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.loan_amount.$errors[0].$message }} -->
                    {{ s$.loan_amount.required.$message.replace("Value", "Loan Amount") }}
                </span>
            </div>
            <div class="">
                <label for="declaration_amount" class="block mb-2 font-medium text-gray-900 ">Interest
                    Amount Paid</label>
                <InputNumber id="rendPaid_inp" class="w-full "
                    v-model="investmentStore.other_exe_80EEA.interest_amount_paid" required :class="[
                        s$.interest_amount_paid.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="s$.interest_amount_paid.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ s$.interest_amount_paid.$errors[0].$message }} -->
                    {{ s$.interest_amount_paid.required.$message.replace("Value", "Loan amount paid") }}
                </span>
            </div>

        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitForm80EEA">Save</button>
        </div>

    </Dialog>



    <Dialog v-model:visible="investmentStore.dailog_80EEB" modal :style="{ width: '50vw', borderTop: '5px solid #002f56' }">

        <template #header>
            <h6 class="mb-1 modal-title text-primary"> 80EEB<span class="ml-3 text-xs font-semibold text-gray-400">(The
                    maximum deduction available under
                    this section is Rs. 1.5 Lakhs for electric vehicle purchase)</span> </h6>
        </template>

        <div
            class="grid my-4 mb-6 gap-y-4 gap-x-6 md:grid-cols-2 2xl:grid-cols-2 sm:grid-cols-1 xl:grid-cols-2 lg:grid-cols-2">
            <div class="">
                <label for="sanction_date" class="block mb-2 font-medium text-gray-900 ">Loan
                    Sanction Date</label>
                <Calendar :minDate="new Date('04/01/2019')" :maxDate="new Date('03/31/2023')"
                    placeholder="Loan Sanction Date" v-model="investmentStore.other_exe_80EEB.loan_sanction_date"
                    class="w-full " showIcon required :class="[
                        p$.loan_sanction_date.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="p$.loan_sanction_date.$error" class="font-semibold text-red-400 fs-6">
                    {{ p$.loan_sanction_date.$errors[0].$message }}
                    {{ p$.loan_sanction_date.required.$message.replace("Value", "Loan sanction date") }}
                </span>
            </div>

            <div class="">
                <label for="vechicle_brand" class="block mb-2 font-medium text-gray-900 ">Vechicle Brand</label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    @change="switchVechileModel(investmentStore.other_exe_80EEB.vechicle_brand)"
                    v-model="investmentStore.other_exe_80EEB.vechicle_brand" :options="vechicle_types"
                    optionLabel="vechicle_model" optionValue="value" placeholder="Select a Vechicle Brand" required :class="[
                        p$.vechicle_brand.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="p$.vechicle_brand.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.vechicle_brand.$errors[0].$message }} -->
                    {{ p$.vechicle_brand.required.$message.replace("Value", "Vechile Brand") }}
                </span>
            </div>

            <div class="">
                <label for="vechicle_model" class="block mb-2 font-medium text-gray-900 ">Vechicle Model
                </label>
                <Dropdown class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    v-model="investmentStore.other_exe_80EEB.vechicle_model" :options="vechicle_model_options"
                    optionLabel="vechicle_model" optionValue="value" placeholder="Select a Vechicle Model" required :class="[
                        p$.vechicle_model.$error ? 'border border-red-500' : '',
                    ]" />
                <span v-if="p$.vechicle_model.$error" class="font-semibold text-red-400 fs-6">
                    <!-- {{ p$.vechicle_model.$errors[0].$message }} -->
                    {{ p$.vechicle_model.required.$message.replace("Value", "Vechile Model") }}
                </span>
            </div>

            <div class="">
                <label for="declaration_amount" class="block mb-2 font-medium text-gray-900 ">Interest
                    Amount Paid</label>
                <InputNumber id="rendPaid_inp" class="w-full "
                    v-model="investmentStore.other_exe_80EEB.interest_amount_paid" required :class="[
                        p$.interest_amount_paid.$error ? 'p-invalid' : '',
                    ]" />
                <span v-if="p$.interest_amount_paid.$error" class="font-semibold text-red-400 fs-6">
                    {{ p$.interest_amount_paid.required.$message.replace("Value", "Interest amount paid") }}
                    <!-- {{ p$.interest_amount_paid.$errors[0].$message }} -->
                </span>
            </div>

        </div>
        <div class="text-end">
            <button class="px-4 py-2 text-center text-white bg-orange-700 rounded-md" @click="submitForm80EEB">Save</button>
        </div>
    </Dialog>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { investmentMainStore } from "../../../stores/investmentMainStore";
import axios from "axios";
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import useValidate from '@vuelidate/core';
import moment from "moment";

const investmentStore = investmentMainStore()
const editingRows = ref([]);


const rulesSec80E = computed(() => {
    return {
        loan_sanction_date: { required },
        lender_type: { required },
        property_value: { required },
        loan_amount: { required },
        interest_amount_paid: { required },
    }
})

const v$ = useValidate(rulesSec80E, investmentStore.other_exe_80EE)

const submitForm80EE = () => {
    console.log(v$.value);
    v$.value.$validate() // checks all inputs
    if (!v$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.save80EE()
        v$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

const rulesSec80EA = computed(() => {
    return {
        loan_sanction_date: { required },
        lender_type: { required },
        property_value: { required },
        loan_amount: { required },
        interest_amount_paid: { required },
    }
})

const s$ = useValidate(rulesSec80EA, investmentStore.other_exe_80EEA)

const submitForm80EEA = () => {
    console.log(s$.value);
    s$.value.$validate() // checks all inputs
    if (!s$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.save80EEA()
        s$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

const rulesSec80EB = computed(() => {
    return {
        loan_sanction_date: { required },
        vechicle_brand: { required },
        vechicle_model: { required },
        interest_amount_paid: { required },
    }
})
const p$ = useValidate(rulesSec80EB, investmentStore.other_exe_80EEB)

const submitForm80EEB = () => {
    console.log(p$.value);
    p$.value.$validate() // checks all inputs
    if (!p$.value.$error) {
        // if ANY fail validation
        console.log('Form successfully submitted.')
        investmentStore.save80EEB()
        p$.value.$reset()
    } else {
        console.log('Form failed validation')
    }
}

onMounted(() => {
    // setTimeout(() => {
    //     investmentStore.fetchOtherExe()
    // }, 2000);
})

const onRowEditSave = (event) => {
    let { newData, index } = event;
    investmentStore.otherExemptionSource[index] = newData;
    investmentStore.updatedRowSource = newData;
    investmentStore.getFormId = 1
    let dec_amount = '';
    // if (newData.section == '80EE') {
    //     dec_amount = newData.json_popups_value.interest_amount_paid
    // }
    //     if (newData.section == '80EEA') {
    //         dec_amount = newData.json_popups_value.interest_amount_paid
    //         axios.post("/investments/saveSectionPopups", newData)
    //         .then((res) => {
    //             console.log(res.data);
    //         })
    //     }
    //         if (newData.section == '80EEB') {
    //             dec_amount = newData.json_popups_value.interest_amount_paid
    //             axios.post("/investments/saveSectionPopups", newData)
    //         .then((res) => {
    //             console.log(res.data);
    //         })
    //         }
    //         else {
    //             dec_amount = newData.dec_amount
    //         }
    var data = {
        fs_id: newData.fs_id,
        declaration_amount: newData.dec_amount,
        select_option: newData.select_option
    }
    // console.log(dec_amount);
    investmentStore.formDataSource.push(data)
    console.log(newData);
};


const vechicle_model_options = ref()

const lender_types = ref([
    { name: 'Financial Institution', code: 'Financial Institution' },
    { name: 'Others', code: 'Others' },

]);


const vechicle_types = ref([
    { id: 1, vechicle_model: 'Tata', value: 'Tata' },
    { id: 2, vechicle_model: 'Mahindra', value: 'Mahindra' },
    { id: 3, vechicle_model: 'Hyundai', value: 'Hyundai' },
    { id: 4, vechicle_model: 'Kia', value: 'Kia' },
    { id: 5, vechicle_model: 'MG', value: 'MG' },
])


const switchVechileModel = (vechicle_brand) => {

    console.log("function called");

    console.log(vechicle_brand);

    if (vechicle_brand == 'Tata') {

        console.log("tata");
        vechicle_model_options.value = [
            { id: 1, vechicle_model: 'Tata Tigor', value: 'Tata Tigor' },
            { id: 2, vechicle_model: 'Tata Nexon', value: 'Tata Nexon' },
            { id: 3, vechicle_model: 'Tata AVINYA', value: 'Tata AVINYA' },
            { id: 4, vechicle_model: 'Tata Punch', value: 'Tata Punch' },
            { id: 5, vechicle_model: 'Tata CURVV SUV Coupe', value: 'Tata CURVV SUV Coupe' },
            { id: 6, vechicle_model: 'Tata Tiago', value: 'Tata Tiago' },
        ]
    } else {

        if (vechicle_brand == 'Mahindra') {

            vechicle_model_options.value = [
                { id: 1, vechicle_model: 'Mahindra eVerito', value: 'Mahindra eVerito' },
                { id: 2, vechicle_model: 'Mahindra e2oPlus', value: 'Mahindra e2oPlus' },
                { id: 3, vechicle_model: 'Mahindra eSupro', value: 'Mahindra eSupro' },
                { id: 4, vechicle_model: 'Mahindra Treo', value: 'Mahindra Treo' },
                { id: 5, vechicle_model: 'Mahindra Treo Zor', value: 'Mahindra Treo Zor' },
                { id: 6, vechicle_model: 'Mahindra eAlfa Mini', value: 'Mahindra eAlfa Mini' },
                { id: 7, vechicle_model: 'Mahindra  XUV400 EV', value: 'Mahindra  XUV400 EV' },
                { id: 8, vechicle_model: 'Mahindra  Mahindra E Verito', value: 'Mahindra  Mahindra E Verito' },

            ]
        } else
            if (vechicle_brand == 'Hyundai') {
                vechicle_model_options.value = [
                    { id: 1, vechicle_model: 'Hyundai Kona Electric', value: 'Hyundai Kona Electric' },
                    { id: 2, vechicle_model: 'Hyundai IONIQ 5', value: 'Hyundai IONIQ 5' },
                    { id: 3, vechicle_model: 'Mahindra eSupro', value: 'Mahindra eSupro' },
                ]
            } else
                if (vechicle_brand == 'Kia') {
                    vechicle_model_options.value = [
                        { id: 1, vechicle_model: 'Kia EV6', value: 'Kia EV6' },
                    ]
                } else
                    if (vechicle_brand == 'MG') {
                        vechicle_model_options.value = [
                            { id: 1, vechicle_model: 'MG ZS EV', value: 'MG ZS EV' },
                        ]
                    } else {
                        console.log("no more Brand");
                    }

    }

}

</script>

<style>
.p-datepicker .p-component {
    z-index: 400;
}
</style>





