<template>
    <div class="modal fade mt-5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN === true ? 'd-block show' : ''">
        <div class="modal-dialog">
            <div class="modal-content card">
                <div class="d-flex align-items-start px-3 py-1">
                    <button type="button" class="btn-close text-dark mt-2" @click="CLOSE()"/>
                </div>
                <div class="modal-body pt-4 pb-3 px-4 text-center">
                    <h1 class="display-4 text-danger mb-3"><i class="fas fa-trash"></i></h1>
                    <h4 class="text-muted">¿Está seguro?</h4>
                    <p class="text-muted mb-4">¿Realmente desea eliminar estos registros?<br> Este proceso no se puede deshacer.</p>
                    <div class="row justify-content-center">
                        <div class="col-4 mb-2">
                            <button @click="CLOSE()" type="button" class="btn btn-secondary btn-sm ms-auto mt-2 mb-0">
                                <i class="fas fa-times"></i>
                                <span class="ms-2">Cancelar</span>
                            </button>
                        </div>
                        <div class="col-4 mb-2">
                            <button @click="SEND_DATA()" type="submit" class="btn btn-danger btn-sm ms-auto mt-2 mb-0">
                                <i class="fas fa-spinner fa-spin" v-if="load"></i>
                                <i class="fas fa-trash" v-else></i>
                                <span class="ms-2">Eliminar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {showToast} from "../../../helpers";

export default {
    props: ['open', 'id', 'url'],
    data(){
        return {
            icon: '',
            message: '',
            load: false,
            count: 0,
        }
    },
    computed: {
        OPEN: function(){
            return this.open
        },
    },
    methods:{
        CLOSE: function(){
            this.$emit('close')
        },
        SEND_DATA: function(){
            const loader = this.$showLoader()
            let _this = this
            _this.count++
            _this.load = true
            if(_this.count === 1){
                setTimeout(function() {
                    axios({url: _this.url + _this.id, method: 'DELETE' })
                        .then((resp) => {
                            loader.hide()
                            _this.load = false
                            _this.count = 0
                            _this.icon = resp.data.result ? 'success' : 'error'
                            _this.message = resp.data.message
                            _this.CLOSE()
                            showToast(_this.icon, _this.message)
                        }).catch((err) => {
                            if(err.response.status === 400) {
                                _this.icon = 'error'
                                _this.message = 'No se puede eliminar el registro'
                                showToast(_this.icon, _this.message)
                            } else {
                                showToast()
                            }
                            loader.hide()
                            _this.load = false
                            _this.count = 0
                            _this.CLOSE()
                        })
                }, 1000)
            }
        }
    }
}
</script>
