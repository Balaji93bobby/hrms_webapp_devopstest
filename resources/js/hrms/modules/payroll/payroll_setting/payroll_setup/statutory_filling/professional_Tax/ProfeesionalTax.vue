



<template>
    <div>

        <div class="row card-headers w-full d-flex justify-content-between align-items-center  md:justify-center align-middle" :style="{}">
            <h1></h1>
            <div class="col-md" style="line-height: 30px;">
                <!-- <h1 class="mb-5">HRA Calculation</h1> -->
            </div>
            <div class="col-md d-flex justify-content-end" >
                <button class="mb-5 " :style="{backgroundColor:' #F36826', borderRadius:'4px',color:'#fff' ,padding:'8px 18px' ,fontSize:'15.06px'}" @click="visible = true" >
                   <i class="pi pi-plus"></i> Add New</button>


                   <!-- <template>
                    <div>
                        <Dialog v-model:visible="visible" modal header="" :style="{ width: '50vw' }">
                            <template #header>
                                <div >
                                    <h1 class="" style="border-left:3px solid #F36826; padding-left: 12px ; font-size: 16px;">Professional Tax</h1>
                                </div>
                            </template>

                            <div>
                                <div class="row">
                                    <div class="col">
                                        <label for="">Choose Location</label>
                                        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Choose" class="w-full md:w-full" />
                                    </div>
                                    <div class="col">
                                        <label for="">State </label>
                                        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Choose" class="w-full md:w-full" />
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col">
                                        <label for="">PT Number</label>
                                        <InputText type="text" v-model="value" class="w-full" placeholder="Enter..." />
                                    </div>
                                    <div class="col">
                                        <label for="">Decuction Cycle</label> -->
                                        <!-- <InputText type="text" v-model="value" class="w-full" /> -->
<!-- 
                                        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Half yearly" class="w-full md:w-full" />

                                    </div>
                                </div>
                                <p class="clr mt-4 mb-4 text-lg fw-normal">The tax are detemined based on an employee's Half Yearly Gross Salary. </p> -->

                                <!-- <div class="card border pl-3 pr-3">

                                    <div class="row pt-2 clrs " style="">
                                        <div class="col d-flex justify-content-center">
                                            <h1 class="fw-normal">Start Range( <span>&#8377;</span> )</h1>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <h1 class="fw-normal">End Range( <span>&#8377;</span> )</h1>

                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <h1 class="fw-normal">Half yearly Tax Amount( <span>&#8377;</span> )</h1>
                                        </div>
                                    </div>

                                    <div class="row pt-2">
                                        <div class="col d-flex justify-content-center">
                                            <InputText type="text" v-model="value" class="w-full" style="height: 2.5rem;" placeholder="From" />

                                        </div>
                                        <div class="col-1 d-flex justify-content-center align-items-center " ><span>-</span></div>
                                        <div class="col d-flex justify-content-center">
                                            <InputText type="text" v-model="value" class="w-full" style="height: 2.5rem;" placeholder="To" />
                                        </div>
                                        <div class="col-1 d-flex justify-content-center align-items-center " >
                                            <span>=</span>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <InputText type="text" v-model="value" class="w-full" style="height: 2.5rem;" placeholder="To" />
                                        </div>
                                        <div class="col-1 d-flex justify-content-center align-items-center " >
                                           <button class="p-2 text-danger"><i class="pi pi-minus-circle"></i></button>
                                           <button><i class="pi pi-plus p-2 text-success"></i></button>
                                        </div>
                                    </div>

                                </div> -->

                            <!-- </div>
                        </Dialog>
                    </div>
                   </template> -->

                   <DataTable>
                    <Column field="" header="cdd"></Column>
                    <Column field="" header="cdd"></Column>
                    <Column field="" header="cdd"></Column>
                   </DataTable>
            </div>
        </div>

    </div>
</template>



<!-- <template>
    <div class="card flex justify-content-center">
        <Button label="Show" icon="pi pi-external-link" @click="visible = true" />
        <Dialog v-model:visible="visible" modal header="Header" :style="{ width: '50vw' }">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </Dialog>
    </div>
</template> -->

<script setup>
import { ref } from "vue";

const visible = ref(false);
</script>

<style>
.clr{
    color:  #003056;
}
.clrs{
    background: #0064b51c;

}
</style>

{
    <!--

<template>
    <div class="card flex justify-content-center">
        <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" class="w-full md:w-14rem" />
    </div>
</template>

<script setup>
import { ref } from "vue";

const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
</script>
     -->
}
