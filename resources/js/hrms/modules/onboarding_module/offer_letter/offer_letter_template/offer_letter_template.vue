<template>
    <div class="w-full m-2 bg-white ">
        <div class="mb-2">
            <h3 class="text-2xl font-bold">Create Offer  template</h3>
        </div>
        <div class="flex grid-cols-2 gap-6 my-4 ">
            <div class="p-4 border-gray-400 rounded-lg shadow-md border-1 w-7">
                    <div class="my-4">
                        <h5 class="my-2 text-lg font-semibold">Template Name</h5>
                        <div class="flex gap-8 justify-evenly">
                          <div class="w-6">
                            <InputText class="w-full" type="text"  v-model="re.named" />{{re.named}}</div>
                          <div class="" >
                            is default
                            <Checkbox class="mx-2" v-model="checked" :binary="true" />
                          </div>
                        </div>
                    </div>
                    <button @click="hn">hn</button>
                    <div class="my-4 ">
                        <h5 class="my-2 text-lg font-semibold">Description</h5>
                        <div class="flex gap-5 justify-evenly">
                          <div><Textarea autoResize rows="1" cols="53" /></div>

                        </div>
                    </div>
                    <div class="flex grid-cols-2 gap-8 my-4 border-gray-200 place-content-center">

                     <div class="w-6">
                        <h5 class="my-2 text-lg font-semibold">Logo</h5>
                        <div>file</div>
                     </div>
                     <div class="">
                        <h5 class="my-2 text-lg font-semibold">Authorised Sign</h5>
                        <div>file</div>
                     </div>

                    </div>
                </div>


            <div class="w-4 p-4 border-gray-400 rounded-lg shadow-md border-1">
                <h1 class="my-2 text-xl font-bold">Select the input tags to insert in offer template</h1>
                <p class="my-2">the values for these should be given during offer letter generation </p>

                <div class="h-2 my-4 w-96">
                    <div class="flex gap-4 mx-2 my-2">
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26 ">Employee name</div>
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26">Job Title</div>
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26">Doj</div>
                    </div>
                    <div class="flex gap-4 mx-2 my-2">
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26">Manager name</div>
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26 ">Offer Expire Date</div>
                        <!-- <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26 ">Employee name</div> -->
                    </div>
                    <div class="flex gap-4 mx-2 my-2">
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26">Location</div>
                        <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26 ">CTC</div>
                        <!-- <div class="p-2 mx-2 my-2 text-orange-500 border-orange-300 rounded-lg border-1 w-26 ">Employee name</div> -->
                    </div>
                </div>
            </div>

        </div>
        <div class="flex grid-cols-2 gap-6 my-6">
            <div class="border-gray-400 rounded-lg shadow-md border-1 w-7">
                <form @submit="onSubmit">
                <Editor v-model="value" editorStyle="height: 320px" />
                </form>

            </div>
            <!-- ... -->
            <div class="w-4 border-gray-400 rounded-lg shadow-md border-1">

                <h4 class="my-4 text-xl font-bold text-center">Select the salary structure pay-group</h4>
                <div style="height: 50px;" class="w-10 px-4 mx-auto my-4 bg-orange-100 border-gray-200 rounded-lg border-1 ">
                    <h1 class="my-3 text-xl font-semibold">PayGroup_1</h1>
                </div>
                <div style="height: 50px;" class="w-10 px-4 mx-auto my-4 bg-pink-100 border-gray-200 rounded-lg border-1 ">
                    <h1 class="my-3 text-xl font-semibold">PayGroup_2</h1>
                </div>
                <div style="height: 50px;" class="w-10 px-4 mx-auto my-4 bg-yellow-100 border-gray-200 rounded-lg border-1 ">
                    <h1 class="my-3 text-xl font-semibold">PayGroup_3</h1>

                </div>
                <div style="height: 50px;" class="w-10 px-4 mx-auto my-4 bg-orange-300 border-gray-200 rounded-lg border-1 ">
                    <h1 class="my-3 text-xl font-semibold">PayGroup_4</h1>
                </div>

            </div>
        </div>
    </div>


</template>


<script setup>
import { reactive, ref } from "vue";



const re=reactive({
    named:'',nss:''
})
const hn=()=>{
 console.log(value.value);
 console.log(re.nss);
 re.nss=re.named
}






const value = reactive("<div>Hello World!</div><div>PrimeVue <b v-model='re.nss'></b> Rocks</div><div><br></div>")
</script>




<style>
.page-content{
    background: white;
}

</style>
