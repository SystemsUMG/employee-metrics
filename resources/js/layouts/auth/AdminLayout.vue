<template>
    <div v-show="this.$store.state.layout === 'landing'" class="landing-bg h-100 bg-gradient-primary position-fixed w-100">
    </div>
    <sidenav
        :custom_class="this.$store.state.mcolor"
        :class="[this.$store.state.isTransparent, 'fixed-start']"
        v-if="this.$store.state.showSidenav"/>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <navbar
            :class="[navClasses]"
            :textWhite="this.$store.state.isAbsolute ? 'text-white opacity-8' : 'text-white'"
            :minNav="navbarMinimize"
            v-if="this.$store.state.showNavbar"/>
        <router-view />
        <app-footer/>
    </main>
</template>
<script>
import Sidenav from "../../layouts/auth/sidenav";
import Navbar from "../../layouts/auth/navbars/Navbar.vue";
import AppFooter from "../../layouts/auth/navbars/Footer.vue";
import { mapMutations } from "vuex";

export default {
    name: "AdminLayout",
    components: {
        Sidenav,
        Navbar,
        AppFooter
    },
    methods: {
        ...mapMutations(["navbarMinimize"])
    },
    computed: {
        navClasses() {
            return {
                "position-sticky bg-white left-auto top-2 z-index-sticky":
                    this.$store.state.isNavFixed && !this.$store.state.darkMode,
                "position-sticky bg-default left-auto top-2 z-index-sticky":
                    this.$store.state.isNavFixed && this.$store.state.darkMode,
                "position-absolute px-4 mx-0 w-100 z-index-2":
                    this.$store.state.isAbsolute,
                "px-0 mx-4": !this.$store.state.isAbsolute
            };
        }
    },
    beforeMount() {
        this.$store.state.sidebarType = "bg-default";
    }
};
</script>
