<template>
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg bg-cover-database">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mt-5">¡Bienvenido!</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center">
                            <div class="avatar avatar-xxl position-relative">
                                <img :src="logo" class="border-radius-lg" alt="logo" />
                            </div>
                            <h5 class="my-4">Seleccione Base de Datos</h5>
                        </div>
                        <div class="card-body">
                            <argon-button fullWidth color="primary" variant="gradient" class="mb-2"
                                          @click="setDatabase('mysql')">MySQL
                            </argon-button>
                            <argon-button fullWidth color="secondary" variant="gradient" class="my-4 mb-2"
                                          @click="setDatabase('sqlsrv')">SQL Server
                            </argon-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <app-footer />
</template>
<script>
import AppFooter from "../layouts/auth/navbars/Footer.vue";
import ArgonButton from "../components/ArgonButton.vue";
import logo from "../assets/img/logos/logo.png";

export default {
    name: "Database",
    components: {
        AppFooter,
        ArgonButton
    },
    data() {
        return {
            logo
        };
    },
    methods: {
        setDatabase(database = "mysql") {
            //Header para DB
            localStorage.setItem("database", database);
            axios.defaults.headers.common["Database"] = database;
            this.$router.push({ name: "sign-in" });
        }
    }
};
</script>
<style>
.bg-cover-database {
    background-image: url(../assets/img/covers/signup-cover.jpg);
    background-position: top;
}
</style>
