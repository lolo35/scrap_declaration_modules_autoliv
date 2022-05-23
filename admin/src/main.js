import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios';
import {createPinia} from 'pinia';
import VueBarcode from '@chenfengyuan/vue-barcode';

let url = "";

if(process.env.NODE_ENV === "development") url = "http://localhost:8000/api/";
axios.defaults.baseURL = url;
axios.defaults.headers.post['Content-type'] = "application/x-www-form-urlencoded";
import './assets/css/main.css';
import localforage from 'localforage';

localforage.config({
    name: "modules-scrap-disassembly"
});
import './assets/fontawesome-free-6.1.1-web (1)/fontawesome-free-6.1.1-web/css/all.css';

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$localforage = localforage;
app.use(router);
app.use(createPinia());
app.component(VueBarcode.name, VueBarcode);
app.mount('#app');
