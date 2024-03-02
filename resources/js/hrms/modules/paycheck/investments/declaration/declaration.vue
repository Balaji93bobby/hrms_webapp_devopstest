<template>
    <div class="p-1">

        <div class="flex w-[100%]">
            <div class="row w-[100%] items-center">
                <div class="col-8 flex items-center justify-start">
                    <p class="font-semibold text-black text-2xl items-center flex">Tax Deductions FY {{ new Date().getFullYear() }}-{{ new
                        Date().getFullYear() + 1 }}<span class="text-[red] font-['Poppins'] " >! Kindly update your PAN to avoid 20$ TDS deduction (if applicable)</span></p>
                       
                </div>       
                    <div style="col-4 font-weight: 600;" class="px-1 my-2 fs- flex text-lg col">
                        <p class=" underline text-blue-400 text-right font-['Poppins'] " >Income Tax Computations</p>
                    </div>
            </div>
        </div>
        <div class=" justify-content-center align-items-center">
            <div class="mx-2 ">

                <div class="my-4 rounded-lg ">
                    <div class="card-body">
                        <p class=" text-[14px] font-semibold text-gray-500 font-['Poppins']"  style="line-height: 20px;">
                            Not considered for exemption if opted for New tax regime (Section 115BAC). You can declare your
                            investment amount till last day of every month until the cutoff date of {{ new
                                Date().toLocaleString('default', { month: 'long', }) }} 27, {{ new Date().getFullYear() }}. Last
                            date
                            for submitting your investment proofs is {{ new Date().toLocaleString('default', {
                                month:
                                    'long',
                            }) }} 27, {{ new Date().getFullYear() }}. '$' - Not considered for exemption if
                            opted for New tax regime (Section 115BAC). You can declare your investment amount till last day
                            of every month until the cutoff date of {{ new Date().toLocaleString('default', {
                                month:
                                    'long',
                            }) }} 27, {{ new Date().getFullYear() }}.Last date for submitting your investment
                            proofs is {{ new Date().toLocaleString('default', { month: 'long', }) }} 27, {{ new
                                Date().getFullYear() }}.
                        </p>
                    </div>
                </div>
                <div class="flex justify-between gap-6 my-4">
                    <div class="">
                        <div class="font-semibold text-[16px] font-['Poppins']">Your current chosen tax regime is <strong
                                class="text-blue-500 underline cursor-pointer text-[16px] font-[600]"
                                style="font-family: Verdana, Geneva, Tahoma, sans-serif;"
                                v-tooltip.bottom="`Last Updated Date  ${dayjs(lastUpdated).format('dddd, MMMM D, YYYY h:mm A')}`">{{
                                    findRegime(regime) }}
                            </strong>
                            <span v-if="regime == 'old'">
                                <span class="text-sm text-green-600"
                                    v-if="formula.taxCalculation(total_gross, 'old', age) < formula.taxCalculation(total_gross, 'new', age) ? true : false" >Maximum
                                    benefit</span>
                            </span>
                            <span v-else>
                                <span class="text-sm text-green-600"
                                    v-if="formula.taxCalculation(total_gross, 'new', age) < formula.taxCalculation(total_gross, 'old', age) ? true : false" >Maximum
                                    benefit</span>
                            </span>
                        </div>

                        <!-- text-sm -->
                        <p class="text-gray-600 font-['Poppins'] mt-[2px]">The confirmed old tax regime will be used in future payroll
                            calculations
                        </p>
                        <div>
                        </div>
                    </div>
                    <div>
                    </div>
                    <div class="text-end">
                        <button class="px-4 text-[14px] p-2 text-[#fff] rounded-md bg-[#000] font-['Poppins'] " @click="switch_regime_dailog = true"
                            :disabled="!investmentStore.disableRegime(lastUpdated)">Switch Regime</button>
                    </div>
                </div>
                <div v-if="investmentStore.disableRegime(lastUpdated)"
                    class="flex items-center my-[8px] bg-[white] border-[1px] rounded-md border-gray-300 p-2 w-[80%]">
                    <i class="mx-2 my-1 font-bold text-[red]  pi pi-info-circle" style="font-size: 1.5rem"></i>
                    <p class="ml-2  text-[13px] text-[red] font-['Poppins']">
                        Not considered for exemption if opted for New tax regime (Section 115BAC). You can declare your
                        investment amount till last day of every month.
                    </p>
                </div>
                <div v-else class="flex h-full py-2 my-4 bg-orange-100 border-l-4 rounded-lg border-l-orange-400">
                    <i class="mx-2 my-1 font-bold text-orange-500 pi pi-info-circle" style="font-size: 1.5rem"></i>
                    <p class="ml-2 font-semibold text-black fs-5">
                        The tax regime cannot be changed until the financial year
                        {{ new Date().getFullYear() }} - {{ new Date().getFullYear() + 1 }} ends. (April {{ new
                            Date().getFullYear() }} -March {{ new Date().getFullYear() + 1 }} )
                    </p>
                </div>
            </div>
        </div>

        <DataTable :value="investmentStore.tax_deduction" dataKey="id">
            <template #empty> No Data Found. </template>
            <template #loading> Loading customers data. Please wait. </template>
            <Column header="#">
                <template #body="slotProps">
                    {{ slotProps.data.sno }}.
                </template>
            </Column>
            <Column field="section" header="" style=" width: 30rem; text-align: left !important;">
                <template #header>
                    <p style="font-weight: 501;">
                        Particulars
                    </p>
                </template>
                <template #body="slotProps">
                    <p style="font-weight: 501;" v-if="slotProps.data.section == 'Total Taxable Income'">
                        {{ slotProps.data.section }}
                    </p>
                    <p style="font-weight: 501;" v-else>
                        {{ slotProps.data.section }}
                    </p>
                </template>
            </Column>
            <Column field="old_regime" header="" style="text-align: right !important;">
                <template #header>
                    <p style="font-weight: 501;">
                        Old Tax Regime
                    </p>
                </template>
                <template #body="slotProps">
                    <!-- <p style="font-weight: 501;" v-if="slotProps.data.section == 'Total Tax Laibility'">
                        {{ investmentStore.formatCurrency(formula.taxCalculation(slotProps.data.old_regime
                            , 'old', slotProps.data.age)) }}
                    </p> -->
                    <p style="font-weight: 501;">
                        {{ investmentStore.formatCurrency(slotProps.data.old_regime) }}
                    </p>
                </template>
            </Column>
            <Column field="new_regime" header="" style="text-align: right !important;">
                <template #header>
                    <p style="font-weight: 501;">
                        New Tax Regime
                    </p>
                </template>
                <template #body="slotProps">
                    <!-- <p style="font-weight: 501;" v-if="slotProps.data.section == 'Total Tax Laibility'">
                        {{ investmentStore.formatCurrency(formula.taxCalculation(slotProps.data.new_regime, 'new', slotProps.data.age)) }}
                    </p> -->
                    <p style="font-weight: 501;">
                        {{ investmentStore.formatCurrency(slotProps.data.new_regime) }}
                    </p>
                </template>
            </Column>

        </DataTable>

        <!-- <div class="my-3">
            <p class="font-semibold text-black fs-2">Declaration</p>
        </div> -->

        <!-- <div class="my-3 card">
            <div class="grid gap-4 my-1 md:grid-cols-3 xl:grid-cols-3 lg:grid-cols-3 card-body">
                <div class="p-2 text-left border-l-4 rounded-lg bg-sky-100 border-l-sky-400">
                    <p class="font-semibold fs-6 ">Net Taxable Income</p>
                    <div class="grid  my-1 md:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2">
                        <h6 v-if="regime == 'old'" class="text-lg font-bold">
                            {{ investmentStore.formatCurrency(total_gross) }}</h6>
                        <h6 v-else class="text-lg font-bold "> {{ investmentStore.formatCurrency(total_gross) }}</h6>
                        <p class="pl-3 text-orange-400 underline lg:text-base"> Income Tax Computation</p>
                    </div>
                </div>
                <div class="p-2 text-left bg-gray-100 border-l-4 rounded-lg tw-card border-l-gray-400">
                    <p class="font-semibold fs-6 ">Total Tax Payable</p>
                    <h6 v-if="regime == 'old'" class="text-lg font-bold"> {{ investmentStore.formatCurrency(
                        formula.taxCalculation(total_gross, 'old', age)) }}</h6>
                    <h6 v-else class="text-lg font-bold"> {{ investmentStore.formatCurrency(
                        formula.taxCalculation(total_gross, 'new', age)) }}</h6>
                </div>

                <div class="p-2 text-left bg-orange-100 border-l-4 rounded-lg tw-card border-l-orange-400 ">
                    <p class="font-semibold fs-6 ">Tax Paid Till Now</p>
                    <h6 class="text-lg font-bold">{{ investmentStore.formatCurrency(0) }}</h6>
                </div>
            </div>
        </div> -->

        <div class="my-3">
            <div>
                <p class="text-2xl font-semibold ">Declaration</p>
                <div class="mx-2">
                    <ul class="font-semibold f-13">
                        <li class="my-2 text-lg font-semibold">
                            '$' - Not considered for exemption if opted for New tax regime (Section 115BAC).
                        </li>
                        <li class="my-2 text-lg font-semibold">
                            You can declare your investment amount till last day of every month until the cutoff date of {{
                                new Date().toLocaleString('default', { month: 'long', }) }}
                            27, {{ new Date().getFullYear() }}.
                        </li>
                        <li class="my-2 text-lg font-semibold">
                            Last date for submitting your investment proofs is {{ new Date().toLocaleString('default',
                                { month: 'long', }) }} 27, {{ new Date().getFullYear() }}.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-2 card">
            <div class="card-body">
                <div>
                    <p class="font-semibold fs-4 ">My Declaration</p>
                    <p class="my-2 font-semibold fs-6"> Below are the declarations done by you under various sections.</p>
                </div>
                <div class="my-2 table-responsive">
                    <DataTable :rows="7" dataKey="id" :value="investmentStore.investmentSummarySource">
                        <template #empty> No Data Found. </template>
                        <template #loading> Loading customers data. Please wait. </template>
                        <Column field="particulars" header="S.No">
                            <template #body="slotProps">
                                {{ slotProps.index + 1 }}
                            </template>
                        </Column>
                        <Column field="section_name" header="Declaration" style="width: 16rem;text-align: left !important;">
                        </Column>
                        <Column field="dec_amount" style="width: 18rem;text-align: right !important;">
                            <template #header>
                                <p style="font-weight: 501;">
                                    Amount Declared
                                </p>
                            </template>
                            <template #body="slotProps">
                                {{ investmentStore.formatCurrency(slotProps.data.dec_amount) }}
                            </template>
                        </Column>
                        <Column field="proof_submitted" style="width: 16rem;text-align: right !important;">
                            <template #header>
                                <p style="font-weight: 501;">
                                    Proof Submitted
                                </p>
                            </template>
                        </Column>
                        <Column field="amount_rejected" style="width: 16rem;text-align: right !important;">
                            <template #header>
                                <p style="font-weight: 501;">
                                    Amount Rejected
                                </p>
                            </template>
                            <template #body="slotProps">
                                {{ investmentStore.formatCurrency(slotProps.data.amount_rejected) }}
                            </template>
                        </Column>
                        <Column field="amount_accepted" style="width: 16rem;text-align: right !important;">
                            <template #header>
                                <p style="font-weight: 501;">
                                    Amount Accepted
                                </p>
                            </template>
                            <template #body="slotProps">
                                {{ investmentStore.formatCurrency(slotProps.data.amount_accepted) }}
                            </template>
                        </Column>
                    </DataTable>
                </div>
            <div class="my-6">
                    <div>
                        <p class="my-2 font-semibold font-['Poppins'] ">Month- Month Tax Deduction Details</p>
                        <p class="my-2 font-semibold text-[13px]  font-['Poppins'] text-gray-400">Below deductions are based on your declared amount. Tax amount
                            may change based on the amount approved.</p>
                    </div>


                    <div>
                        <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-3 lg:grid-cols-3 card-body ">
                            <div class=" flex rounded-lg bg-[#F6F6F6] border-[#DDDDD] items-center py-[12px] ">
                                <p class="text-ash-medium font-['Poppins'] text-[14px] text-center text-[#000] ">Tax Paid Till Now</p>
                                <p class="font-['Poppins'] text-center font-[600] text-[16px]">INR {{taxComputationSource ? taxComputationSource['Tax Paid Till Now']:0}}</p>
                            </div>
                            <div class=" flex rounded-lg bg-[#F6F6F6] border-[#DDDDD] items-center  py-[12px] ">
                                <p class="text-ash-medium font-['Poppins'] text-[14px] text-center text-[#000] ">Total Tax Payable</p>
                                <p class=" font-['Poppins'] text-[16px]  text-center font-[600]">INR {{taxComputationSource ? taxComputationSource['Total Tax Payable']:0}}</p>
                            </div>
                            <div class="flex rounded-lg bg-[#F6F6F6] border-[#DDDDD] items-center  py-[12px]">
                                <p class="text-ash-medium font-['Poppins'] text-[14px] text-center text-[#000]">Remaining Tax Amount</p>
                                <p class="font-['Poppins'] text-[16px] text-center font-[600]">INR {{taxComputationSource ? taxComputationSource['Remaining Tax Amount']:0}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <DataTable :paginator="true" :rows="1" dataKey="id" scrollable :value="monthWiseData" >
                            <template #empty> No Data Found. </template>
                            <template #loading> Loading customers data. Please wait. </template>
                            <Column field="particulars" header="Month" frozen class="font-bold">
                                <template #body>
                                    <p class="font-semibold fs-6">
                                        Monthly Tax
                                    </p>
                                </template>
                            </Column>
                            <Column v-for="col of dynmaicHeadersForMonthTax" :key="col"  :header="col.title" :field="col.title" class="font-semibold">
                                <template #body="{data,field}">
                                    <p class="font-semibold fs-6">{{data[field]}}</p>
                                </template>
                            </Column>

                        </DataTable>
                    </div>
                    <div class="flex my-3">
                        <p class="font-semibold fs-6">
                            <strong class="text-red-600">*</strong>
                            Projected Income Tax does not include any revisions, bonuses or other additional projected
                            payments other than salary.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <Dialog v-model:visible="switch_regime_dailog" modal :style="{ width: '50vw', borderTop: '5px solid #002f56' }">
        <template #header>
            <h6 class="mb-1 text-lg font-semibold modal-title text-primary">Confirm Switching Regime</h6>

        </template>

        <p class="">Your current switching regime is
            <strong class="text-lg font-semibold text-primary" v-if="regime == 'new'">{{ findRegime('old') }}
                <span class="text-sm text-green-600"
                    v-if="formula.taxCalculation(total_gross, 'old', age) < formula.taxCalculation(total_gross, 'new', age) ? true : false">Maximum
                    benefit</span>
            </strong>
            <strong class="text-lg font-semibold text-primary" v-else-if="regime == 'old'">
                {{ findRegime('new') }}
                <span class="text-sm text-green-600"
                    v-if="formula.taxCalculation(total_gross, 'new', age) < formula.taxCalculation(total_gross, 'old', age) ? true : false">Maximum
                    benefit</span>
            </strong>
            <strong class="text-lg font-semibold text-primary" v-else>
                {{ findRegime('old') }}
                <span class="text-sm text-green-600"
                    v-if="formula.taxCalculation(total_gross, 'old', age) < formula.taxCalculation(total_gross, 'new', age) ? true : false">Maximum
                    benefit</span>
            </strong>
        </p>
        <p class="my-3 text-justify text-gray-700">
            Are you sure you want to switch your regime? You cannot change your regime selection once you
            have confirmed your selection.
        </p>
        <p class="text-justify text-gray-700">
            In case of an incorrect selection, your only option will be to change your selection when you
            file your tax returns for the current financial year.
        </p>


        <div class="mt-5 text-end">
            <button id="confirm_switchRegime" class="px-4 py-2 text-lg text-center text-white bg-black rounded-md"
                @click="saveRegime">Confirm</button>
        </div>

    </Dialog>
</template>



<script setup>
import axios from 'axios'
import dayjs from 'dayjs';
import { onMounted, reactive, ref } from 'vue'
import { investmentFormulaStore } from '../../stores/investmentFormulaStore'
import { investmentMainStore } from '../../stores/investmentMainStore';
const data = ref()


const dynmaicHeadersForMonthTax = ref()

const taxComputationSource = ref()


onMounted(() => {
    investmentStore.canShowLoading = true
    investmentStore.fetchInvestmentSummary()
    investmentStore.fetchTaxableIncomeInfo()
    console.log(new Date().getFullYear() - 1);

    axios.get('/investments/monthTaxDashboard').then(res=>{
        monthWiseData.value.push(res.data.date)
        taxComputationSource.value = res.data.taxcalculation
        let obj = Object.entries(res.data.date).map(item =>{
            return{
                title:item[0],
            }
        })
        dynmaicHeadersForMonthTax.value = obj
    })



})

// investmentStore.taxSavingInvestments.declared_amt += parseInt(ele.dec_amount)
// investmentStore.taxSavingInvestments.max_limit += ele.amount_rejected
// investmentStore.taxSavingInvestments.status = ele.is_submitted

const investmentStore = investmentMainStore()
const formula = investmentFormulaStore()
const tax_deduction = ref()
const total_gross = ref()
const total_taxable = ref()
const monthWiseData = ref([])

const amount = ref()
const regime = ref()
const age = ref()
const totalTax = ref()
const lastUpdated = ref()
const isRegimeSwitched = ref(false)



const regimeOption = ref([
    { name: "old", value: "old" },
    { name: "new", value: "new" }
])

const switch_regime_dailog = ref(false);

const saveRegime = () => {
    switch_regime_dailog.value = false
    investmentStore.canShowLoading = true
    let selectedRegime = '';
    if (regime.value == 'old') {
        selectedRegime = 'new'
    } else {
        selectedRegime = 'old'
    }
    axios.post('/investments/saveRegime', {
        regime: selectedRegime
    }).finally(() => {
        investmentStore.canShowLoading = false
        fetchTaxableIncomeInfo()
        isRegimeSwitched.value = true

    })
}

const findRegime = (regime) => {
    switch (regime) {
        case "old":
            return "OLD TAX REGIME"
        case "new":
            return "NEW TAX REGIME"
        default:
            return "NEW TAX REGIME"
    }
}

const fetchTaxableIncomeInfo = async () => {
    await axios.get('/investments/TaxDeclaration').then(res => {
        tax_deduction.value = res.data
        if (res.data[7].regime == 'old') {
            total_gross.value = res.data[6].old_regime
        } else {
            total_gross.value = res.data[6].new_regime
        }

        total_taxable.value = res.data[7].old_regime
        age.value = res.data[7].age
        regime.value = res.data[7].regime
        lastUpdated.value = res.data[7].last_updated
    }).finally(() => {
        investmentStore.canShowLoading = false
        investmentStore.disableRegime(lastUpdated.value)
    })
}


</script>



<style scoped>
.p-dropdown .p-dropdown-label.p-placeholder {
    position: relative;
    top: -5px;
    border: 1px solid red;
    color: #6c757d;
}

.p-button .p-fileupload-choose {
    /* height: 2.1em; */
}

i,
span,
.tabview-custom {
    vertical-align: middle;
}

span {
    margin: 0 0.5rem;
}

.AadharCardFront {
    margin-left: 20px;
}

.label {
    width: 170px;
}

.p-tabview p {
    line-height: 1.5;
    margin: 0;
}

dialog>header {
    color: #002f56 !important;
}

.form-selects {
    padding: 0;
    width: 100%;
    height: 2.5rem;
}

.save {
    border: 1px solid #e63b1f;
    color: #e63b1f;
}

.p-dialog-header {
    border-left: #e63b1f 5px solid !important;
}

.form-selects ::-webkit-scrollbar {
    width: 10px !important;
    border-radius: 12px !important;
}

/* Track */
.form-selects ::-webkit-scrollbar-track {
    background: #f1f1f1 !important;
}

/* Handle */
.form-selects ::-webkit-scrollbar-thumb {
    background: #888 !important;
    border-radius: 12px !important;
}

/* Handle on hover */
.form-selects ::-webkit-scrollbar-thumb:hover {
    background: #252222 !important;
    border-radius: 12px !important;
}

Dialog {
    color: #002f56;
}

.p-dialog .p-dialog-header .p-dialog-title {
    font-weight: 700;
    font-size: 1.25rem;
    color: #002f56;
}
</style>

