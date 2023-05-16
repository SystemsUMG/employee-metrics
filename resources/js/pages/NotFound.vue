<template>
    <div class="container text-center mt-5">
        <h1 class="font-weight-normal text-light pt-5 mt-5">Esta página no está disponible</h1>
        <h5 class="font-weight-normal text-light">Es posible que el enlace que has seguido sea incorrecto o que se haya eliminado la página.</h5>
        <img class="d-block mx-auto py-5" :src="logo" width="250" alt="">
        <router-link to="/" class="h5 font-weight-normal d-block text-light mt-5">Volver al Principio</router-link>
    </div>
</template>
<script>
import logo from "../assets/img/logos/logo.png"
export default {
    name: "NotFound",
    data() {
        return {
            logo
        };
    },
}
</script>
