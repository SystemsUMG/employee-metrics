<template>
    <div class="py-4 container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col">
                                <h6>Tabla de Usuarios</h6>
                            </div>
                            <div class="col text-end">
                                <argon-button type="button" @click="OPEN('POST')" color="primary" size="sm" class="ms-auto mb-3">Crear</argon-button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edad</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departamento</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actualizado</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                                </thead>
                                <tbody v-if="show">
                                <tr  v-for="user in users" :key="user.id">
                                    <td>
                                        <div class="px-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ user.name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="px-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ user.email }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs mb-0">{{ user.age }}</p>
                                    </td>
                                    <td>
                                        <div class="px-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ user.department.name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs mb-0">{{ user.date }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a  class="text-success font-weight-bold text-xs cursor-pointer"  @click="OPEN('PUT', user.id)">Editar</a>
                                        &nbsp
                                        <a class="text-danger font-weight-bold text-xs cursor-pointer" @click="OPEN('DELETE', user.id)">Eliminar</a>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td class="text-center py-5" colspan="6">
                                        <p>No hay usuarios registrados</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <data-form   v-if="get_open" :open="get_open" :method="method" :id="id" @close="LOAD"/>
    <data-delete v-if="get_delete" :open="get_delete" :id="id" :url="url" @close="LOAD"/>
</template>

<script>
import DataForm from './Form.vue';
import DataDelete from '../../layouts/auth/modals/Delete.vue';
import {showToast} from "../../helpers";
import ArgonButton from "../../components/ArgonButton.vue";

export default {
    name: "users",
    components: {
        ArgonButton,
        DataForm,
        DataDelete
    },
    data() {
        return {
            users: [],
            icon: '',
            message: '',
            loader: {},
            show: false,
            get_delete: false,
            get_open: false,
            method: '',
            id: '',
            url: 'users/'
        }
    },
    mounted() {
        this.LOAD()
    },
    methods: {
        LOAD(){
            const loader = this.$showLoader()
            let _this = this

            _this.get_delete = false
            _this.get_open = false

            axios({url: 'users' , method: 'GET'})
                .then((resp) => {
                    if(resp.data.records.length > 0) {
                        _this.show = true
                        _this.users = resp.data.records
                    } else {
                        _this.icon = 'warning'
                        _this.message = 'No existen registros'
                        showToast(_this.icon, _this.message)
                    }
                    loader.hide()
                })
                .catch(() => {
                    showToast()
                    loader.hide()
                })
        },
        OPEN: function(method, id = null){
            this.method = method
            this.id = id
            if(method === 'DELETE') {
                this.get_delete = true
            } else {
                this.get_open = true
            }
        }
    }
};
</script>
