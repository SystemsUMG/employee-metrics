<template>
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
         v-bind="$attrs"
         id="navbarBlur"
         data-scroll="true">
        <div class="px-3 py-1 container-fluid">
            <breadcrumbs :currentPage="currentRouteName" textWhite="text-white" />
            <div class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                <ul class="navbar-nav justify-content-end ms-md-auto">
                    <li class="nav-link font-weight-bold text-white">
                        <span>{{ user.name }}</span>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <button @click="logout" class="btn">
                            <i class="fa fa-power-off me-sm-2"></i>
                            <span class="d-sm-inline d-none">Cerrar Sesión</span>
                        </button>
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="#" @click="toggleSidebar" class="p-0 nav-link text-white" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import Breadcrumbs from "../../../components/Breadcrumbs.vue";
import { mapMutations, mapActions } from "vuex";

export default {
    name: "navbar",
    data() {
        return {
            showMenu: false,
            user: this.$store.state.auth.user
        };
    },
    props: ["minNav", "textWhite"],
    methods: {
        ...mapMutations(["navbarMinimize", "toggleConfigurator"]),
        ...mapActions(["toggleSidebarColor"]),
        toggleSidebar() {
            this.toggleSidebarColor("bg-default");
            this.navbarMinimize();
        },
        ...mapActions({
            signOut: "auth/logout"
        }),
        async logout() {
            await axios.post("/logout", {},
                {
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                }
            ).then(() => {
                this.signOut();
                this.$router.push({ name: "sign-in" });
            });
        }
    },
    components: {
        Breadcrumbs
    },
    computed: {
        currentRouteName() {
            return this.$route.name;
        }
    }
};
</script>
