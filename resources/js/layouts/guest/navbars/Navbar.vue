<template>
    <nav class="navbar navbar-expand-lg top-0 z-index-3 position-absolute mt-4"
         :class="isBlur ? isBlur : 'shadow-none my-2 navbar-transparent w-100'">
        <div class="container row">
            <div class="col">
                <img src="../../../assets/img/logos/isologo.png" style="width: 45px; padding: 0; margin: 0" alt="">
            </div>
            <div class="col">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item" v-if="admin">
                        <router-link class="nav-link me-2 text-light" to="/admin">
                            <i class="ni ni-tv-2 opacity-6 me-1" aria-hidden="true"></i>
                            Panel de Administración
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import downArrWhite from "@/assets/img/down-arrow-white.svg";
import downArrBlack from "@/assets/img/down-arrow-dark.svg";

export default {
    name: "navbar",
    data() {
        return {
            downArrWhite,
            downArrBlack
        };
    },
    props: {
        btnBackground: String,
        isBlur: String,
        isBtn: { type: String, default: "bg-gradient-light" },
        darkMode: {
            type: Boolean,
            default: false
        },
        admin: false
    },
    computed: {
        darkModes() {
            return {
                "text-dark": this.darkMode
            };
        }
    }
};
</script>
