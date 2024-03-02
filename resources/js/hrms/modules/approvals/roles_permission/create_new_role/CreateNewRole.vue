<template>
    <div v-if="RolePermission.rolesPermission ==2" class="mt-30">
        <div></div>
        <h1 class="fs-3 fw-semibold mb-2">Create New Role</h1>
        <p class="fs-6 fw-semibold mb-2">Here you can Create role and set permission to them.</p>
        <div class="card shadow-sm">
            <div class="row my-3 px-2">
                <div class="col-12 ">
                    <div class="row">
                        <div class="col-3 "><label for="" class="mx-4 fw-semibold " >Name of the Role</label></div>
                        <div class="col-9">  <InputText type="text" class="h-10 w-6" v-model="value" placeholder="Enter Name of the Role" /></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 ">
                            <label for="" class="mx-4 fw-semibold " >Description of the Role</label>
                        </div>
                        <div class="col-9">
                            <InputText type="text" class="h-10 w-6" v-model="value" placeholder="Give Description of the Role" />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-3">
                            <label for="" class="mx-4 fw-semibold " >Category Name</label>
                        </div>
                        <div class="col-9">
                            <InputText type="text" class="h-10 w-6" v-model="value" placeholder="Enter Name of the Sub Category" />
                        </div>
                    </div>
                    <!-- <button class=""><i class="pi pi-plus"></i></button> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import {UseRolePermissionStore} from '../RolesAndPermissionStore'
import axios from 'axios';
import RolesAndPermission from "../RolesAndPermission.vue";



const RolePermission = UseRolePermissionStore();

</script>
