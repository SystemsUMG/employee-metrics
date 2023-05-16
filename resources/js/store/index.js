import { createStore } from "vuex";
import auth from "../modules/auth";

export default createStore({
    state: {
        hideConfigButton: false,
        isPinned: true,
        showConfig: false,
        sidebarType: "bg-white",
        isRTL: false,
        mcolor: "",
        darkMode: true,
        isNavFixed: false,
        isAbsolute: false,
        showNavs: true,
        showSidenav: true,
        showNavbar: true,
        showFooter: true,
        showMain: true,
        layout: "default",

        user: null,
        auth: false
    },
    mutations: {
        toggleConfigurator(state) {
            state.showConfig = !state.showConfig;
        },
        navbarMinimize(state) {
            const sidenav_show = document.querySelector(".g-sidenav-show");

            if (sidenav_show.classList.contains("g-sidenav-hidden")) {
                sidenav_show.classList.remove("g-sidenav-hidden");
                sidenav_show.classList.add("g-sidenav-pinned");
                state.isPinned = true;
            } else {
                sidenav_show.classList.add("g-sidenav-hidden");
                sidenav_show.classList.remove("g-sidenav-pinned");
                state.isPinned = false;
            }
        },
        sidebarType(state, payload) {
            state.sidebarType = payload;
        },
        navbarFixed(state) {
            if (state.isNavFixed === false) {
                state.isNavFixed = true;
            } else {
                state.isNavFixed = false;
            }
        },


        SET_USER(state, user) {
            state.user = user;
            state.auth = Boolean(user);
        }
    },
    actions: {
        toggleSidebarColor({ commit }, payload) {
            commit("sidebarType", payload);
        },

        async logout({ dispatch }) {
            await axios.post("/logout");
            return dispatch("getUser");
        },
        async login({ dispatch }, credentials) {
            await axios.get("/sanctum/csrf-cookie");
            await axios.post("/login", credentials);
            return dispatch("getUser");
        },
        getUser({ commit }) {
            axios.get("/user").then((response) => {
                commit("SET_USER", response.data);
            }).catch(() => {
                commit("SET_USER", null);
            });
        }
    },
    getters: {},

    modules: {
        //auth,
    }
});
