import { createRouter, createWebHistory } from "vue-router";
import BaseLayout from "../layouts/guest/BaseLayout.vue";
import AdminLayout from "../layouts/auth/AdminLayout.vue";
import Database from "../pages/Database.vue";
import Survey from "../pages/Survey.vue";
import Dashboard from "../pages/Dashboard.vue";
import Tables from "../views/Tables.vue";
import Billing from "../views/Billing.vue";
import Profile from "../views/Profile.vue";
import SignUp from "../pages/Auth/SignUp.vue";
import SignIn from "../pages/Auth/SignIn.vue";

const routes = [
    {
        path: "/",
        name: "/",
        redirect: "/database",
    },
    {
        path: '/database',
        component: BaseLayout,
        children: [
            {
                path: '',
                name: 'database',
                component: Database
            }
        ]
    },
    {
        path: "/sign-in",
        name: "sign-in",
        component: SignIn,
    },
    {
        path: "/sign-up",
        name: "Sign-up",
        component: SignUp,
    },
    {
        path: '/survey',
        component: BaseLayout,
        children: [
            {
                path: '',
                name: 'Survey',
                component: Survey
            }
        ]
    },
    {
        path: '/tables',
        component: AdminLayout,
        children: [
            {
                path: "",
                name: "tables",
                component: Tables,
            },
        ]
    },
    {
        path: '/admin',
        component: AdminLayout,
        children: [
            {
                path: "",
                name: "admin",
                component: Dashboard,
            },
        ]
    },
    {
        path: "/billing",
        name: "Billing",
        component: Billing,
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.APP_URL),
    routes,
    linkActiveClass: "active",
});

export default router;
