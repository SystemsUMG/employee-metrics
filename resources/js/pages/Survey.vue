<template>
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg bg-cover-main">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class=" text-center mx-auto">
                        <h1 class="text-white mt-5">Ingreso de Datos</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 container">
            <div class="row mt-n12 justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <form @submit.prevent="SEND()">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Por favor completa la información solicitada</p>
                                    <argon-button type="submit" color="success" size="sm" class="ms-auto">Enviar</argon-button>
                                </div>
                            </div>
                            <div class="card-body">
                                <hr class="horizontal light" />
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salary" class="form-control-label">Salario</label>
                                            <input id="salary" class="form-control" type="number" v-model="data.salary" :class="errors.salary ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.salary ? errors.salary[0] : '' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="study_level" class="form-control-label">Nivel de Estudios</label>
                                            <select  id="study_level" class="form-select" v-model="data.study_level" :class="errors.study_level ? 'is-invalid' : ''">
                                                <option value="" disabled hidden>Seleccione una opción</option>
                                                <option v-for="[key, value] in Object.entries(study_levels)" :value="key" :key="key">{{ value }}</option>
                                            </select>
                                            <small class="invalid-feedback">{{ errors.study_level ? errors.study_level[0] : '' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="antiquity" class="form-control-label">Antigüedad</label>
                                            <select  id="antiquity" class="form-select" v-model="data.antiquity" :class="errors.antiquity ? 'is-invalid' : ''">
                                                <option value="" disabled hidden>Seleccione una opción</option>
                                                <option v-for="[key, value] in Object.entries(antiquities)" :value="key" :key="key">{{ value }}</option>
                                            </select>
                                            <small class="invalid-feedback">{{ errors.antiquity ? errors.antiquity[0] : '' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="absences" class="form-control-label">Ausencias</label>
                                            <input id="absences" class="form-control" type="number" v-model="data.absences" :class="errors.absences ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.absences ? errors.absences[0] : '' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="age" class="form-control-label">Edad</label>
                                            <input id="age" class="form-control" type="number" v-model="data.age" :class="errors.age ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.age ? errors.age[0] : '' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <app-footer />
</template>

<script>
import ArgonButton from "../components/ArgonButton.vue";
import AppFooter from "../examples/PageLayout/Footer.vue";
import { showToast } from "../helpers";

export default {
    name: "Survey",
    data() {
        return {
            icon: '',
            message: '',
            data: {
                salary: '',
                study_level: '',
                antiquity: '',
                absences: '',
                age: '',
            },
            errors: {},
            study_levels: [],
            antiquities: []
        };
    },
    components: {
        AppFooter,
        ArgonButton
    },
    mounted() {
        const loader = this.$showLoader()
        let _this = this
        setTimeout(function() {
            axios({url: '/dynamic-values', method: 'GET' })
                .then((resp) => {
                    if (resp.data.result) {
                        _this.study_levels = resp.data.records.study_levels
                        _this.antiquities = resp.data.records.antiquities
                        _this.icon = "success"
                    }
                    _this.message = resp.data.message
                    showToast(_this.icon, _this.message)
                    loader.hide()
                })
                .catch((err) => {
                    showToast()
                    loader.hide()
                })
        }, 1000)
    },
    methods:{
        SEND: function(){
            const loader = this.$showLoader()
            let _this = this

            let form = new FormData()
            for (const key of Object.keys(this.data)) {
                const item = this.data[key]
                if(item != null){
                    form.append(key, item)
                }
            }

            this.errors = []
            setTimeout(function() {
                axios({url: '/kpis', method: 'POST', data: form })
                    .then((resp) => {
                        if (resp.data.result) {
                            _this.icon = "success"
                            _this.message = resp.data.message
                            _this.$router.push({ name: 'admin' })
                        } else {
                            _this.icon = 'error'
                            _this.message = resp.data.message.split("(")[0]
                        }
                        showToast(_this.icon, _this.message)
                        loader.hide()
                    })
                    .catch((err) => {
                        if (err.response.status === 422) {
                            _this.errors = err.response.data.errors
                            _this.icon = 'error'
                            _this.message = err.response.data.message.split("(")[0]
                            showToast(_this.icon, _this.message)
                        } else {
                            showToast()
                        }
                        loader.hide()
                    })
            }, 1000)
        }
    }
};
</script>
<style>
.bg-cover-main {
    background-image: url(../assets/img/covers/form-cover.avif);
    background-position: top;
}
</style>
