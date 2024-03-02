import { createRouter, createWebHistory } from "vue-router";
import payRunVue from "../payRun.vue";
import leaveAttendanceDailyWagesVue from "../runPayroll/leaveAttendanceDailyWages/leaveAttendanceDailyWages.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/payrun/:module",
            name: "home",
            component: payRunVue,
        },
    ],
});
export default router;

