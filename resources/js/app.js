import './bootstrap';

import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import axios from 'axios';
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";
import VueLoading, {useLoading} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

window.axios = axios
axios.defaults.baseURL = '/api/'

//Header para DB
let database = localStorage.getItem('database') ? localStorage.getItem('database') : 'mysql' //Default
axios.defaults.headers.common['Database'] = database

const appInstance = createApp(App);
appInstance.use(store);
appInstance.use(router);
appInstance.use(ArgonDashboard);
appInstance.use(VueLoading);
appInstance.use(VueSweetalert2)
//Set loader and configure show/hide globally
appInstance.config.globalProperties.$showLoader = function() {
    return useLoading().show({
        container: null,
        canCancel: false,
        color: '#5e72e4',
        backgroundColor: 'rgb(27,29,33)'
    })
}

appInstance.mount("#app");
