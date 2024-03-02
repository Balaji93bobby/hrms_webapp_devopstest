import { createRouter, createWebHistory } from "vue-router";
import employeeMaster from './employee_master_report/employee_master_report.vue'
import basicReport from './attendance/attendanceBasicReports/attendanceBasicReports.vue'
import Employee_Master from "./employee_master_report/Employee_Master.vue";
import employee_CTC from "./employee_master_report/employee_CTC.vue";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/testing_pradeesh",
            name: "home",
            component: employeeMaster,
            children: [{ path: '/', name: 'user', component: Employee_Master },
            { path: '/employee_CTC', name: 'user', component: employee_CTC },

        ],
        },
        {
            path: "/attenndance",
            name: "basicReport",
            component: basicReport,
        },
        {
            path: "/employeeMaster",
            name: "employeeMaster",
            component: Employee_Master,
        },
    ],
});
export default router;

