import { createRouter, createWebHistory } from "vue-router";
import BaseLayout from "../layouts/guest/BaseLayout.vue";
import AdminLayout from "../layouts/auth/AdminLayout.vue";
import Database from "../pages/Database.vue";
import SignUp from "../pages/Auth/SignUp.vue";
import SignIn from "../pages/Auth/SignIn.vue";
import Survey from "../pages/Survey.vue";
import Dashboard from "../pages/Dashboard.vue";
import Users from "../pages/users/Index.vue";
import Departments from "../pages/departments/Index.vue";

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
                name: 'survey',
                component: Survey
            }
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
        path: '/users',
        component: AdminLayout,
        children: [
            {
                path: "",
                name: "users",
                component: Users,
            },
        ]
    },
    {
        path: '/departments',
        component: AdminLayout,
        children: [
            {
                path: "",
                name: "departments",
                component: Departments,
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.APP_URL),
    routes,
    linkActiveClass: "active",
});

export default router;
