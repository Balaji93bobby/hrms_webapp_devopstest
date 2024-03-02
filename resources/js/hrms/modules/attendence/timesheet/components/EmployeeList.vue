<template>
    <div class="card overflow-y-scroll h-[100%]">
        <div class="card-body">
            <input type="text" name="" id="" v-model="query" class="w-full p-1 my-2 border border-gray-300 rounded-lg first-letter"
                placeholder="Search Employees..">
            <button class="flex w-full p-3 px-1 rounded-lg list_employee_attendance hover:bg-gray-300"
                v-for="(employee, index) in globalSearch(query, source)" :class="[useTimesheet.selected_user_code == employee.user_code ?'bg-gray-300' :'' ]"
                @click="isTeam ? useTimesheet.getSelectedEmployeeTeamDetails(employee.user_code, isTeam,employee.user_code) : useTimesheet.getSelectedEmployeeOrgDetails(employee.user_code, isTeam,employee.user_code)">
                <div class="col-auto me-2">
                    <p v-if="JSON.parse(employee.employee_avatar).type == 'shortname'"
                        class="p-2 font-semibold text-white rounded-full w-11 fs-6"
                        :class="service.getBackgroundColor(index)">
                        {{ JSON.parse(employee.employee_avatar).data }} </p>
                    <img v-else class="rounded-circle userActive-status profile-img"
                        style="height: 30px !important; width: 30px !important;"
                        :src="`data:image/png;base64,${JSON.parse(employee.employee_avatar).data}`" srcset="" alt="" />
                    <!-- <div class="p-2 mx-0 text-center rounded-full" >
                        <span class="text-white fw-bold">{{ JSON.parse(employee.employee_avatar).data }}</span>
                    </div> -->
                </div>
                <div class="user_content text-start ">
                    <p class="text-sm font-semibold text-capitalize">{{ employee.name }}</p>
                    <p class=" text-muted f-11 text-capitalize">{{ employee.user_code }} - {{ employee.designation }}</p>
                </div>
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAttendanceTimesheetMainStore } from '../stores/attendanceTimesheetMainStore'
import { Service } from '../../../Service/Service';
const service = Service()

const useTimesheet = useAttendanceTimesheetMainStore()

const query = ref('')
function globalSearch(keyword, list) {
    // Use the filter method to find items whose name contains the keyword (case-insensitive)
    const searchResults = list.filter((item) =>
        item.name.toLowerCase().includes(keyword.toLowerCase()) ||  item.user_code.toLowerCase().includes(keyword.toLowerCase())
    );
    return searchResults;
}


const orgList = ref()

const props = defineProps({
    source: {
        type: Object,
        required: true,
    },
    isTeam: {
        type: Boolean,
        required: true,
    }
});


// const getEmployeeSource = (source) => {
//   teamList.value = source
//   return teamList;
// }

// onMounted(async ()=>{
//     await useTimesheet.getOrgList().then(res=>{
//         orgList.value = Object.values(res.data)
//     })
// })

</script>

