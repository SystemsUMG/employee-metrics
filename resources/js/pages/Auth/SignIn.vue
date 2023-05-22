<template>
    <div class="container top-0 position-sticky z-index-sticky">
        <div class="row">
            <div class="col-12">
                <navbar v-bind:darkMode="true" isBtn="bg-gradient-success" isBlur="blur border-radius-lg my-3 py-2 start-0 end-0 mx-4 shadow" v-if="show"/>
            </div>
        </div>
    </div>
    <main class="mt-0 main-content">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="mx-auto col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0">
                            <div class="card card-plain py-4">
                                <img :src="logo" alt="" class="img-fluid w-25 m-auto"/>
                                <div class="pb-0 card-header text-center mt-3">
                                    <h4 class="font-weight-bolder">Iniciar Sesión</h4>
                                    <p class="mb-0 mt-3">Ingrese su correo electrónico y contraseña</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" @submit.prevent="login" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <argon-input v-model="data.email" type="email" placeholder="Correo Electrónico" is-required />
                                        </div>
                                        <div class="mb-3">
                                            <argon-input v-model="data.password" type="password" placeholder="Contraseña" is-required />
                                        </div>
<!--                                        <argon-switch id="rememberMe">Recuérdame</argon-switch>-->
                                        <div class="text-center">
                                            <argon-button class="mt-4" variant="gradient" color="success" fullWidth size="lg">
                                                Iniciar Sesión
                                            </argon-button>
                                        </div>
                                    </form>
                                </div>
<!--                                <div class="px-1 pt-0 text-center card-footer px-lg-2">-->
<!--                                    <p class="mx-auto mb-4 text-sm">-->
<!--                                        <span>¿No tienes una cuenta? </span>-->
<!--                                        <a class="text-success text-gradient font-weight-bold">Registrarse</a>-->
<!--                                    </p>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <div class="top-0 my-auto text-center col-6 d-lg-flex d-none h-100 pe-0 position-absolute end-0 justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden bg-cover-sign-in">
                                <span class="mask bg-gradient-dark"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                                    "Lo que se mide, se mejora. <span class="ms-2 fw-lighter fst-italic">Jim Rohn</span>"
                                </h4>
                                <p class="text-white position-relative">
                                    Acceda a su cuenta para comenzar a medir su progreso y lograr el éxito en su carrera.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <code-verify v-if="verify" :data="data" @close="reload"/>
</template>

<script>
import Navbar from "../../layouts/guest/navbars/Navbar.vue";
import ArgonInput from "../../components/ArgonInput.vue";
import ArgonSwitch from "../../components/ArgonSwitch.vue";
import ArgonButton from "../../components/ArgonButton.vue";
import { showToast } from "../../helpers";
import logo from "../../assets/img/logos/logo.png"
import CodeVerify from "./VerifyOTP.vue";
import card from "../../examples/Cards/Card.vue";

const body = document.getElementsByTagName("body")[0];

export default {
    name: "sign-in",
    components: {
        CodeVerify,
        Navbar,
        ArgonInput,
        ArgonSwitch,
        ArgonButton
    },
    data: () => ({
        data: {
            email: '',
            password: '',
            phone: '',
        },
        count: 0,
        show: false,
        icon: '',
        message: '',
        verify: false,
        logo
    }),
    methods: {
        login() {
            const loader = this.$showLoader()
            let _this = this
            _this.count++

            if (_this.count === 1) {
                //_this.verify = false
                let form = new FormData()
                for (const key of Object.keys(this.data)) {
                    const item = this.data[key]
                    if(item != null){
                        form.append(key, item)
                    }
                }

                axios.post("/login", form)
                    .then(({ data }) => {
                        if (data.result) {
                            _this.data.phone = data.records.phone
                            _this.verify = true
                        } else {
                            _this.icon = 'warning'
                            _this.message = data.message
                            showToast(_this.icon, _this.message)
                        }
                        loader.hide()
                        _this.count = 0
                    })
                    .catch((err) => {
                        if (err.response) {
                            switch (err.response.status) {
                                case 422:
                                    _this.errors = err.response.data.errors
                                    _this.icon = 'error'
                                    _this.message = err.response.data.message.split("(")[0]
                                    showToast(_this.icon, _this.message)
                                    break
                                case 401:
                                    _this.icon = 'error'
                                    _this.message = err.response.data.message
                                    showToast(_this.icon, _this.message)
                                    break
                                default:
                                    showToast()
                                    break
                            }
                        } else {
                            showToast()
                        }
                        loader.hide()
                        _this.count = 0
                    })
            }
        },
        reload: function(verify = false) {
            if (verify) {
                this.login()
            } else {
                this.verify = false
            }
        },
    }
};
</script>
<style>
.bg-cover-sign-in {
    background-image: url(../../assets/img/covers/login-1.jpg) !important;
    background-size: cover;
}
</style>
