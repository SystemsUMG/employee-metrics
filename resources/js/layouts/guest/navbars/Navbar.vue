<template>
    <!-- Navbar -->
    <nav
        class="navbar navbar-expand-lg top-0 z-index-3 position-absolute mt-4"
        :class="isBlur ? isBlur : 'shadow-none my-2 navbar-transparent w-100'"
    >
        <div class="container">
            <img src="../../../assets/img/logos/isologo.png" style="width: 45px; padding: 0; margin: 0" alt="">
            <button
                class="shadow-none navbar-toggler ms-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navigation"
                aria-controls="navigation"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
        <span class="mt-2 navbar-toggler-icon">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <router-link class="nav-link me-2 text-light" to="/sign-up">
                            <i
                                class="fas fa-user-circle opacity-6 me-1"
                                aria-hidden="true"
                            ></i>
                            Registrarse
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link me-2 text-light" to="/sign-in">
                            <i
                                class="fas fa-key opacity-6 me-1"
                                aria-hidden="true"
                            ></i>
                            Iniciar Sesión
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
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
        }
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
