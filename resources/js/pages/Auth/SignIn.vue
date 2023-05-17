<template>
    <div class="container top-0 position-sticky z-index-sticky">
        <div class="row">
            <div class="col-12">
                <navbar
                    isBlur="blur  border-radius-lg my-3 py-2 start-0 end-0 mx-4 shadow"
                    v-bind:darkMode="true"
                    isBtn="bg-gradient-success"
                />
            </div>
        </div>
    </div>
    <main class="mt-0 main-content">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="mx-auto col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0">
                            <div class="card card-plain">
                                <div class="pb-0 card-header text-center">
                                    <h4 class="font-weight-bolder">Iniciar Sesión</h4>
                                    <p class="mb-0"> Ingrese su correo electrónico y contraseña para iniciar sesión</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" @submit.prevent="login" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <argon-input v-model="form.email" type="email"
                                                         placeholder="Correo Electrónico"
                                                         is-required />
                                        </div>
                                        <div class="mb-3">
                                            <argon-input v-model="form.password" type="password"
                                                         placeholder="Contraseña"
                                                         is-required />
                                        </div>
                                        <argon-switch id="rememberMe">Recuerdame</argon-switch>

                                        <div class="text-center">
                                            <argon-button
                                                class="mt-4"
                                                variant="gradient"
                                                color="success"
                                                fullWidth
                                                size="lg"
                                            >Iniciar Sesión
                                            </argon-button>
                                        </div>
                                    </form>
                                </div>
                                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                                    <p class="mx-auto mb-4 text-sm">
                                        ¿No tienes una cuenta?
                                        <a
                                            href="javascript:;"
                                            class="text-success text-gradient font-weight-bold"
                                        >Registrarse</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="top-0 my-auto text-center col-6 d-lg-flex d-none h-100 pe-0 position-absolute end-0 justify-content-center flex-column"
                        >
                            <div
                                class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden bg-cover-sign-in">
                                <span class="mask bg-gradient-dark"></span>
                                <h4
                                    class="mt-5 text-white font-weight-bolder position-relative"
                                >"Lo que se mide, se mejora.<span class="ms-2 fw-lighter fst-italic">Jim Rohn</span>"
                                </h4>
                                <p
                                    class="text-white position-relative"
                                >
                                    Acceda a su cuenta para comenzar a medir su progreso y lograr el éxito en su
                                    carrera.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Navbar from "../../layouts/guest/navbars/Navbar.vue";
import ArgonInput from "../../components/ArgonInput.vue";
import ArgonSwitch from "../../components/ArgonSwitch.vue";
import ArgonButton from "../../components/ArgonButton.vue";
import { mapActions } from "vuex";
import { showToast } from "../../helpers";

const body = document.getElementsByTagName("body")[0];

export default {
    components: {
        Navbar,
        ArgonInput,
        ArgonSwitch,
        ArgonButton
    },
    data: () => ({
        user: {},
        form: {
            email: "",
            password: ""
        }
    }),
    name: "sign-in",
    methods: {
        ...mapActions({
            signIn: "auth/login"
        }),
        async login() {
            await axios.get("/sanctum/csrf-cookie");
            await axios.post("/login", this.form).then(({ data }) => {
                this.signIn();
            }).catch(({ response: { data } }) => {
                showToast("warning", data.message);
            });
        }
    }
};
</script>
<style>
.bg-cover-sign-in {
    background-image: url(../../assets/img/covers/login-1.jpg) !important;
    background-size: cover;
}
</style>
