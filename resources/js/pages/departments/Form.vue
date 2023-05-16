<template>
    <div class="modal fade mt-5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN === true ? 'd-block show' : ''">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card">
                <form @submit.prevent="SEND()">
                    <div class="d-flex align-items-start px-3">
                        <button type="button" class="btn-close text-dark mt-2" @click="CLOSE()"/>
                    </div>
                    <div class="modal-body pt-0 px-4">
                        <hr class="horizontal dark"/>
                        <p class="text-uppercase text-sm">Información del Departamento</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias" class="form-control-label">Alias</label>
                                    <input id="alias" class="form-control" type="text" v-model="data.alias" :class="errors.alias ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.alias ? errors.alias[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nombre</label>
                                    <input id="name" class="form-control" type="text" v-model="data.name" :class="errors.name ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.name ? errors.name[0] : '' }}</small>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="row justify-content-center">
                            <div class="col mb-2 me-0 text-end">
                                <button @click="CLOSE()" type="button" class="btn btn-secondary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-times"></i>
                                    <span class="ms-2">Cancelar</span>
                                </button>
                            </div>
                            <div class="col mb-2 ms-0 text-start">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-spinner fa-spin me-2" v-if="load"></i>
                                    <span>Guardar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import ArgonButton from "../../components/ArgonButton.vue";
import { showToast } from "../../helpers";

export default {
    name: "DataForm",
    components: {
        ArgonButton
    },
    props: ['open', 'method', 'id'],
    data(){
        return {
            icon: '',
            message: '',
            data: {
                alias: '',
                name: ''
            },
            load: false,
            count: 0,
            url: '',
            errors: {},
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            if(_this.method === 'PUT') {
                axios({url: '/departments/' + _this.id, method: 'GET' })
                    .then((resp) => {
                        if (resp.data.result) {
                            _this.data = resp.data.records
                        } else {
                            showToast('error', resp.data.message)
                            _this.CLOSE()
                        }
                    })
                    .catch(() => {
                        _this.CLOSE()
                        showToast()
                    })
            }
            return _this.open
        },
    },
    methods:{
        CLOSE: function(){
            this.$emit('close')
        },
        SEND: function(){
            const loader = this.$showLoader()
            let _this = this
            _this.count++
            _this.load = true

            let method = _this.method === 'PUT' ? '/' + _this.data.id : ''

            if (_this.count === 1) {
                let form = new FormData()
                for (const key of Object.keys(this.data)) {
                    const item = this.data[key]
                    if(item != null){
                        form.append(key, item)
                    }
                }
                if(this.method === 'PUT'){
                    form.append('_method', 'PUT')
                }
                this.errors = []
                axios({url: '/departments' + method, method: 'POST', data: form })
                    .then((resp) => {
                        if(resp.data.result) {
                            _this.icon = 'success'
                            _this.message = resp.data.message
                            _this.CLOSE()
                        } else {
                            _this.icon = 'error'
                            _this.message = resp.data.message.split("(")[0]
                        }
                        loader.hide()
                        showToast(_this.icon, _this.message)
                        _this.load = false
                        _this.count = 0
                    })
                    .catch((err) => {
                        if(err.response.status === 422){
                            _this.errors = err.response.data.errors
                            _this.icon = 'error'
                            _this.message = err.response.data.message.split("(")[0]
                            showToast(_this.icon, _this.message)
                        } else {
                            showToast()
                        }
                        loader.hide()
                        _this.load = false
                        _this.count = 0
                    })
            }
        }
    }
}
</script>
