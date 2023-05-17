<template>
    <div class="container top-0 position-sticky z-index-sticky">
        <div class="row">
            <div class="col-12">
                <navbar :admin="show" isBlur="blur  border-radius-lg my-3 py-2 start-0 end-0 mx-4 shadow"/>
            </div>
        </div>
    </div>
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
        <div class="py-4 container-fluid">
            <div class="row mt-n12 justify-content-center">
                <div class="col-md-7 col-lg-6 col-xl-5">
                    <div class="card py-4 mt-2">
                        <form @submit.prevent="SEND()">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Por favor complete la información solicitada</p>
                                    <argon-button type="submit" color="success" size="sm" class="ms-auto">Enviar
                                    </argon-button>
                                </div>
                            </div>
                            <div class="card-body">
                                <hr class="horizontal light" />
                                <p class="text-uppercase text-sm">Información Personal</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salary" class="form-control-label">Ingrese su Salario
                                                Actual</label>
                                            <input id="salary" class="form-control" type="number" v-model="data.salary"
                                                   :class="errors.salary ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.salary ? errors.salary[0] : "" }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="study_level" class="form-control-label">Seleccione su Nivel de
                                                Estudios</label>
                                            <select id="study_level" class="form-select" v-model="data.study_level"
                                                    :class="errors.study_level ? 'is-invalid' : ''">
                                                <option value="" disabled hidden>Seleccione una opción</option>
                                                <option v-for="[key, value] in Object.entries(study_levels)"
                                                        :value="key" :key="key">{{ value }}
                                                </option>
                                            </select>
                                            <small
                                                class="invalid-feedback">{{ errors.study_level ? errors.study_level[0] : "" }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="age" class="form-control-label">Ingrese su Edad</label>
                                            <input id="age" class="form-control" type="number" v-model="data.age"
                                                   :class="errors.age ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.age ? errors.age[0] : "" }}</small>
                                        </div>
                                    </div>
                                    <hr class="horizontal light" />
                                    <p class="text-uppercase text-sm">Información Laboral</p>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="antiquity" class="form-control-label">Años Laborando en la
                                                Empresa</label>
                                            <select id="antiquity" class="form-select" v-model="data.antiquity"
                                                    :class="errors.antiquity ? 'is-invalid' : ''">
                                                <option value="" disabled hidden>Seleccione una opción</option>
                                                <option v-for="[key, value] in Object.entries(antiquities)" :value="key"
                                                        :key="key">{{ value }}
                                                </option>
                                            </select>
                                            <small
                                                class="invalid-feedback">{{ errors.antiquity ? errors.antiquity[0] : "" }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="absences" class="form-control-label">Promedio de Faltas al
                                                Mes</label>
                                            <input id="absences" class="form-control" type="number"
                                                   v-model="data.absences" :class="errors.absences ? 'is-invalid' : ''">
                                            <small class="invalid-feedback">{{ errors.absences ? errors.absences[0] : "" }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5 col-lg-6 col-xl-4">
                    <div class="row mt-4 mt-lg-0">
                        <div class="col-lg-12">
                            <study-levels-donut-chart :study_levels="charts.study_levels"/>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <antiquities-bar-chart :antiquities="charts.antiquities"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <app-footer />
</template>

<script>
import ArgonButton from "../components/ArgonButton.vue";
import Navbar from "../layouts/guest/navbars/Navbar.vue";
import AppFooter from "../layouts/auth/navbars/Footer.vue";
import StudyLevelsDonutChart from "../layouts/auth/charts/StudyLevelsDonutChart.vue";
import AntiquitiesBarChart from "../layouts/auth/charts/AntiquitiesBarChart.vue";
import { showToast } from "../helpers";

export default {
    name: "Survey",
    data() {
        return {
            icon: "",
            message: "",
            data: {
                salary: "",
                study_level: "",
                antiquity: "",
                absences: "",
                age: ""
            },
            errors: {},
            study_levels: [],
            antiquities: [],
            charts: {
                study_levels: {
                    labels: [],
                    values: [],
                    percentages: []
                },
                antiquities: {
                    labels: [],
                    values: []
                },
            },
            show: true
        };
    },
    components: {
        Navbar,
        AppFooter,
        ArgonButton,
        StudyLevelsDonutChart,
        AntiquitiesBarChart
    },
    mounted() {
        const loader = this.$showLoader()
        let _this = this
        _this.loadData()
        axios({url: '/dynamic-values', method: 'GET' })
            .then((resp) => {
                if (resp.data.result) {
                    _this.study_levels = resp.data.records.study_levels
                    _this.antiquities = resp.data.records.antiquities

                    axios({url: '/kpis/1', method: 'GET' })
                        .then((resp) => {
                            if (resp.data.result) {
                                let user = resp.data.records
                                _this.data.age = user.age

                                user.kpis.forEach(kpi => {
                                    const { type, value } = kpi;
                                    if (type in _this.data) {
                                        _this.data[type] = value;
                                    }
                                });

                                _this.icon = "success"
                            }
                            _this.message = resp.data.message
                            showToast(_this.icon, _this.message)
                            loader.hide()
                        })
                        .catch(() => {
                            showToast()
                            loader.hide()
                        })
                } else {
                    loader.hide()
                    showToast(_this.icon, resp.data.message)
                }
            })
            .catch(() => {
                showToast()
                loader.hide()
            })
    },
    methods: {
        SEND: function() {
            const loader = this.$showLoader();
            let _this = this;

            let form = new FormData();
            for (const key of Object.keys(this.data)) {
                const item = this.data[key];
                if (item != null) {
                    form.append(key, item);
                }
            }

            this.errors = []
            axios({url: '/kpis', method: 'POST', data: form })
                .then((resp) => {
                    if (resp.data.result) {
                        _this.icon = "success"
                        _this.message = resp.data.message
                        _this.loadData()
                    } else {
                        _this.icon = 'error'
                        _this.message = resp.data.message.split("(")[0]
                    }
                    _this.show = true
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
        },
        loadData() {
            const loader = this.$showLoader()
            let _this = this
            axios({url: '/kpis-partials', method: 'GET'})
                .then((resp) => {
                    if (resp.data.result) {
                        _this.charts.study_levels = resp.data.records.study_levels
                        _this.charts.antiquities = resp.data.records.antiquities
                    }
                    loader.hide()
                })
                .catch(() => {
                    showToast()
                    loader.hide()
                })
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
