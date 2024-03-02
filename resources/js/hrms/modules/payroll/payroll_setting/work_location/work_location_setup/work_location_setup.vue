<template>
    <p class="my-4 text-2xl font-bold text-black">Work Location Setup</p>


    <div class="card">
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show fade active " id="applications_tab" role="tabpanel"
                    aria-labelledby="pills-profile-tab">
                    <div class="flex justify-evenly ">
                        <div class="w-8 mx-4 my-4">
                            <p class="text-xl text-muted fs-12">This is where you can manage the different work location of
                                your
                                branches.</p>
                        </div>
                        <div class="flex gap-8">
                            <div class="search-wrapper">


                            </div>
                            <div class="my-4">
                                <button class="btn btn-orange" data-bs-toggle="modal" @click="addApps = true"><i
                                        class="fa fa-plus-circle me-2"></i>Add New </button>

                            </div>

                        </div>

                    </div>




                    <div class="flex flex-wrap my-5 ">
                        <div class="w-4 p-2 mx-6 my-4 bg-white border-black rounded-lg shadow-md border-1"
                        v-for="data in data_work_location" :key="data">
                            <div class="flex justify-between gap-8 my-4 border-gray-200 rounded-lg">
                                <div class="w-6 mx-4">
                                    <!-- <h5 class="my-4 text-2xl font-bold">Head Office</h5> -->
                                    <h5 class="my-4 text-2xl font-bold">{{data.work_location}}</h5>
                                    <p class="text-xl font-semibold text-gray-500">{{ data.state.state_name }}</p>
                                </div>
                                <div class="m-auto ml-12">
                                    <i class="pi pi-pencil" style="font-size: 1rem"></i>
                                </div>
                            </div>
                            <div class="flex gap-8 mx-4 my-4">
                                <div class="w-4">
                                    <h4 class="w-12 text-xl font-semibold text-gray-700 ">
                                    Address
                                        </h4>
                                </div>
                                <div class="w-8 mx-4">
                                    {{data.address}}
                                </div>
                            </div>
                            <div class="flex gap-8 mx-4 my-4">
                                <div class="w-3">
                                    <h4 class="w-12 text-xl font-semibold text-gray-700 "> Phone 
                                        
                                        </h4>
                                </div>
                                <div class="mx-4">
                                    {{ data.ph_no }}
                                </div>
                            </div>
                            <div class="flex gap-8 mx-4 my-4">
                                <div class="w-3">
                                    <h4 class="w-12 text-xl font-semibold text-gray-700 ">City,Pincode
                                        </h4>
                                </div>
                                <div class="w-6 mx-4">
                                    {{ data.city }} ,{{ data.pincode }} 
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <Dialog v-model:visible="addApps" modal :style="{ width: '35vw', height: '100vh' }">

        <template #header>
            <h6 class="mb-4 modal-title fs-21">
                Add New work Location</h6>
        </template>

        <div class="">

            <div class="col-12">
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="text-xl font-semibold text-black form-label">
                        Name of the Work Location</label>
                    <InputText class="form-control" id="" placeholder="Name of the Work Location"
                    v-model="newWorkLocation.work_location" />
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="text-xl font-semibold text-black form-label">
                       State </label>
                        <Dropdown class="w-full" placeholder="State"  :options="banks" optionLabel="state_name"
                        v-model="newWorkLocation.state"/>
                        
                </div>
            <div class="col-12">
                <div class="">
                    <label for="" class="text-xl font-semibold text-black form-label">Address</label>
                    <textarea class="resize-none form-control" placeholder="Address" 
                        id="" rows="3"  v-model="newWorkLocation.address"></textarea>
                </div>

            </div>
            <div class="flex gap-8 mx-2 col-12">
                <div class="w-5">
                    <label for="" class="text-xl font-semibold text-black form-label">City</label>
                    <InputText class="form-control" id="" placeholder=" City"  v-model="newWorkLocation.city" />

                </div>
                <div class="w-5">
                    <label for="" class="text-xl font-semibold text-black form-label">Pincode</label>
                    <InputText class="form-control" id="" placeholder=" Pincode"  v-model="newWorkLocation.pincode" />

                </div>

            </div>
            
            <div class="col-12">
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="text-xl font-semibold text-black form-label">
                        Phone Number</label>
                    <InputText class="form-control" id="" placeholder="Phone Number"  v-model="newWorkLocation.ph_no" />
                </div>
            </div>



        </div>
        </div>

        <template #footer>
            <button  class="btn btn-orange" @click="saveWorkLocation">Submit</button>
        </template>
    </Dialog>

</template>



<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";


const visible = ref(false)
const addApps = ref(false)
const addBanks = ref(false)
const data_work_location =ref()
const banks = ref()


const newWorkLocation =reactive ( {
    work_location:'',
    state:'',
    address:'',
    city:'',
    pincode:'',
    ph_no:''
})

const saveWorkLocation = () =>{
     addApps.value = false
    console.log("saving Work location");
    console.log(newWorkLocation);
    axios.post(' http://localhost:3000/Work_location ',newWorkLocation).then(res =>{
        console.log(res.data);
        fetchWorkLocation()
    }).catch(e => console.log(e)) 
}

const fetchWorkLocation = () =>{
    axios.get(' http://localhost:3000/Work_location').then(res =>{
        data_work_location.value = res.data
    }) 
}

const fetchBanks = () => {
    axios.get('/db/getStatesDetails').then(res =>{
        banks.value = res.data
    }) 
}


onMounted(()=>{
    fetchWorkLocation()
    fetchBanks()
})



</script>


<style>
.p-dialog .p-dialog-header .p-dialog-header-icon:last-child {
    right: 25px;
    background: white;
    position: absolute;
    z-index: 999;
}

#file_upload {
    display: inline-block;
    cursor: pointer;

}
</style>
 