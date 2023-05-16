import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
import BaseLayout from "../layouts/guest/BaseLayout.vue";
import AdminLayout from "../layouts/auth/AdminLayout.vue";

const Database = () => import("../pages/Database.vue");
const SignIn = () => import("../pages/Auth/SignIn.vue");
const SignUp = () => import("../pages/Auth/SignUp.vue");
const Survey = () => import("../pages/Survey.vue");
const Dashboard = () => import("../pages/Dashboard.vue");


/*
import Tables from "../views/Tables.vue";
import Billing from "../views/Billing.vue";
import Profile from "../views/Profile.vue";
*/

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
                name: "database",
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
                name: "admin",
                component: Dashboard
            }
        ]
    }
    /*
     {
         path: '/tables',
         component: AdminLayout,
         meta:{
             middleware:"auth",
         },
         children: [
             {
                 path: "",
                 name: "tables",
                 component: Tables,
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
     },*/
];

const router = createRouter({
    history: createWebHistory(import.meta.env.APP_URL),
    routes,
    linkActiveClass: "active"
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${import.meta.env.VITE_APP_NAME}`;
    if (!localStorage.getItem("database")) {
        this.$router.push({ name: "database" });
    } else {
        if (to.meta.middleware == "guest") {
            if (store.state.auth.authenticated) {
                next({ name: "admin" });
            } else {
                next();
            }
        } else {
            if (store.state.auth.authenticated) {
                next();
            } else {
                next({ name: "sign-in" });
            }
        }
    }
});

export default router;
