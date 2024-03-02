import axios from "axios";
import { constant } from "lodash";
import { defineStore } from "pinia";

import { reactive, ref } from "vue";

export const UseDatatable = defineStore("Datatable", () => {

    const DataTabledata = ref();

    const showDatatable = reactive({
        EPF:"",
        VPF:"",
        PPF:"",
        LIP:"",
        SDRCD:"",
        MF:"",
        NSC:"",
        ULIP:"",
        YTS_FDR:"",
        SSYA:"",
        ATBIN:"",
        SPF:""
    })

    function fetchDataTabledata(){
        axios.get('http://localhost:3000/DataTable').then((res)=>{
            DataTabledata.value = res.data
            console.log(res.data);
        })

    }

    function save_sec_80C_80ccc(){

        axios.post('http://localhost:3000/DataTable',showDatatable).finally((res)=>{
            console.log(res.err);
            fetchDataTabledata()
        })

    }

    function getPmsJsonStructure(){
        
        axios.post("",)
    }

    return {
        save_sec_80C_80ccc,fetchDataTabledata,showDatatable,DataTabledata
    }

})
