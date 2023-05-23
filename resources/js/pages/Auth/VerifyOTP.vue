<template>
    <div class="modal fade mt-5 d-block show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content card">
                <form @submit.prevent="SEND()">
                    <div class="d-flex align-items-start px-3">
                        <button type="button" class="btn-close text-dark mt-2" @click="CLOSE()"/>
                    </div>
                    <div class="modal-header justify-content-center">
                        <h5 class="text-uppercase mb-0">Ingresar Código</h5>
                    </div>

                    <div class="modal-body pt-0 px-4">
                        <hr class="horizontal dark"/>
                        <p>
                            <span>Por favor ingrese el código que se le ha enviado al número de teléfono XXXXXX</span>
                            <span>{{ data.phone.substring(data.phone.length - 2) }}.</span>
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="verification_code" class="form-control-label">Código de Verificación</label>
                                    <input id="verification_code" class="form-control" type="text" v-model="verification_code" :class="errors.verification_code ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.verification_code ? errors.verification_code[0] : '' }}</small>
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
                                    <span>Enviar</span>
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
import ArgonInput from "../../components/ArgonInput.vue";
import { showToast } from "../../helpers";
import {mapActions} from "vuex";

export default {
    name: "CodeVerify",
    components: {
        ArgonInput
    },
    props: ['data'],
    data: () => ({
        verification_code: '',
        icon: '',
        message: '',
        load: false,
        count: 0,
        errors: {},
    }),
    methods: {
        ...mapActions({
            signIn: "auth/login"
        }),
        CLOSE: function(){
            this.$emit('close')
        },
        async SEND(){
            const loader = this.$showLoader()
            let _this = this
            _this.count++
            _this.load = true

            if (_this.count === 1) {
                let form = new FormData()
                for (const key of Object.keys(this.data)) {
                    const item = this.data[key]
                    if(item != null){
                        form.append(key, item)
                    }
                }
                form.append('verification_code', _this.verification_code)
                this.errors = []

                await axios.post("/verify", form)
                    .then(({ data }) => {
                        if (data.result) {
                            _this.signIn()
                            _this.icon = 'success'
                        } else {
                            _this.icon = 'warning'
                            //_this.CLOSE()
                        }
                        _this.message = data.message
                        showToast(_this.icon, _this.message)
                        loader.hide()
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
                            _this.CLOSE()
                        }
                        loader.hide()
                        _this.load = false
                        _this.count = 0
                    })
            }
        }
    }
};
</script>
