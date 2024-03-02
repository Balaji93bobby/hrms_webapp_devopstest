import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import { Service } from "../../../../Service/Service";
import dayjs from "dayjs"


export const useResignationStore = defineStore("useResignationStore",()=>{

const getResignationClientList =ref([]);
const selectedClient = ref('')
const getResignationTypeDropdown = ref([])
const service = Service()

const getClientlistForResignation = async()=>{
   
    await axios.get(`${ window.location.origin}/api/resignation/getClientlistForResignationSettings`).then((res)=>{
        console.log(res.data.data);
        getResignationClientList.value=res.data.data
        console.log("client list",getResignationClientList.value)

        if(getResignationClientList.value.length === 1){
            getResignationClientList.value.map((element)=>{
            selectedClient.value = element.id
            })


        }

    })
    
}

const getResignationDropdown = ref([])

const getResignationType = async () =>{

    await axios.get(`${window.location.origin}/api/resignation/getResignationType`).then((res)=>{
        console.log(res.data.data)
        getResignationDropdown.value = res.data.data
        console.log("resignation type",getResignationDropdown.value)
    })
}

const noticedperiodDay = ref()
const lastworkingDay = ref()
const lastpayrollDate = ref()

const expectedworkingday = ref()

const employeeResignationDetails = async () =>{

    await axios.post(`${window.location.origin}/api/resignation/employeeResignationDetails`,{
        "user_code": service.current_user_code
    }).then((res)=>{
        console.log(res.data.data)
        noticedperiodDay.value=res.data.data.noticed_period_day
        lastpayrollDate.value=res.data.data.last_payroll_date
        // lastworkingDay.value =new Date(res.data.data.last_working_day) ;
        lastworkingDay.value = res.data.data.last_working_day
        expectedworkingday.value= res.data.data.last_working_day
    })
}
// {{dayjs(useResignation.lastworkingDay).format('YYYY-MM-DD')}}

    
    return {
        getClientlistForResignation,
        getResignationClientList,
        selectedClient,
        getResignationType,
        getResignationTypeDropdown,
        getResignationDropdown,
        employeeResignationDetails,
        noticedperiodDay,
        lastworkingDay,
        lastpayrollDate,
        expectedworkingday
        

    }
})