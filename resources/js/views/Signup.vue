<template>
  <div class="container top-0 position-sticky z-index-sticky">
    <div class="row">
      <div class="col-12">
        <navbar isBtn="bg-gradient-light" />
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
      style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mt-5">Bienvenido!</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center">
              <h5>Registrate Gratis</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitForm" class="needs-validation" novalidate>
                <argon-input type="text" placeholder="Nombre" aria-label="Name" required/>
                <argon-input type="email" placeholder="Correo Electrónico" aria-label="Email" />
                <argon-input type="password" placeholder="Contraseña" aria-label="Password" />
                <argon-input type="confirm_password" placeholder="Confirmar contraseña" aria-label="Confirm Password" />
                <div class="text-center">
                  <argon-button fullWidth color="dark" variant="gradient" class="my-4 mb-2">Registrarse</argon-button>
                </div>
                <p class="text-sm mt-3 mb-0">
                  ¿Ya tienes una cuenta?
                  <a href="javascript:;" class="text-dark font-weight-bolder">Iniciar sesión</a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <app-footer />
</template>

<script>
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonCheckbox from "@/components/ArgonCheckbox.vue";
import ArgonButton from "@/components/ArgonButton.vue";
const body = document.getElementsByTagName("body")[0];

export default {
  data() {
    return {
      name: '',
      email: '',
      password: ''
    }
  },
  methods: {
    submitForm() {
      var forms = document.querySelector('.needs-validation')
      forms.classList.add('was-validated')
    }
  },
  components: {
    Navbar,
    AppFooter,
    ArgonInput,
    ArgonCheckbox,
    ArgonButton,
  },
  created() {
    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
  },
};
</script>
