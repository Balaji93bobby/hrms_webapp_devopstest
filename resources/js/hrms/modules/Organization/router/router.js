import { createRouter, createWebHistory } from "vue-router";
import QuickOnboarding from '../QuickOnboarding/QuickOnboarding.vue'
import BulkOnboarding from '../BulkOnboarding/BulkOnboarding.vue'



const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/import/:module",
            name: "QuickOnboarding",
            component: QuickOnboarding,
        },
    ],
});
export default router;
