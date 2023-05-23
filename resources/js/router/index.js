import { createRouter, createWebHistory } from "vue-router";
import store from "../store";

import BaseLayout from "../layouts/guest/BaseLayout.vue";
import AdminLayout from "../layouts/auth/AdminLayout.vue";
import Database from "../pages/Database.vue";
import SignUp from "../pages/Auth/SignUp.vue";
import SignIn from "../pages/Auth/SignIn.vue";
import Survey from "../pages/Survey.vue";
import Dashboard from "../pages/Dashboard.vue";
import Users from "../pages/users/Index.vue";
import Departments from "../pages/departments/Index.vue";
import NotFound from "../pages/NotFound.vue";

const routes = [
    {
        path: "/",
        name: "/",
        redirect: "/database",
        meta: {
            middleware: "guest"
        }
    },
    {
        path: "/database",
        component: BaseLayout,
        meta: {
            middleware: "guest",
            title: `Database`
        },
        children: [
            {
                path: "",
                name: "Database",
                component: Database
            }
        ]
    },
    {
        path: "/sign-in",
        name: "sign-in",
        meta: {
            middleware: "guest",
            title: `Iniciar Sesión`
        },
        component: SignIn
    },
    {
        path: "/sign-up",
        name: "Sign-up",
        meta: {
            middleware: "guest",
            title: `Sign Up`
        },
        component: SignUp
    },
    {
        path: "/survey",
        component: BaseLayout,
        meta: {
            middleware: "auth",
            title: `Survey`
        },
        children: [
            {
                path: "",
                name: "Survey",
                component: Survey
            }
        ]
    },
    {
        path: "/admin",
        component: AdminLayout,
        meta: {
            middleware: "auth",
            title: `Dashboard`
        },
        children: [
            {
                path: "",
                name: "Dashboard",
                component: Dashboard
            }
        ]
    },
    {
        path: "/users",
        component: AdminLayout,
        meta: {
            middleware: "auth",
            title: `Usuarios`
        },
        children: [
            {
                path: "",
                name: "Usuarios",
                component: Users
            }
        ]
    },
    {
        path: "/departments",
        component: AdminLayout,
        meta: {
            middleware: "auth",
            title: `Departamentos`
        },
        children: [
            {
                path: "",
                name: "Departamentos",
                component: Departments
            }
        ]
    },
    {
        path: "/:catchAll(.*)",
        name: NotFound,
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.APP_URL),
    routes,
    linkActiveClass: "active"
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "Dashboard" });
        } else {
            next();
        }
    } else {
        if (store.state.auth.authenticated) {
            next();
        } else {
            next({ name: "Database" });
        }
    }
});

export default router;
