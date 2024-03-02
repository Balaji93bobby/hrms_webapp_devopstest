import { createRouter, createWebHistory } from "vue-router";
import payroll_setting from '../payroll_setting.vue'
import payrollSetup from './payroll_setup.vue'
import salary_structure from "./salary_structure/salary_structure.vue";
import new_salary_structureVue from "./salary_structure/new_salary_structure.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: payroll_setting,
        },
        {
            path: "/payrollSetup",
            name: "payrollSetup",
            component: payrollSetup,
        },
        {
            path: "/payrollSetup/structure/:name",
            name: "new_salary_structureVue",
            component: new_salary_structureVue,
        },
    ],
});
export default router;

