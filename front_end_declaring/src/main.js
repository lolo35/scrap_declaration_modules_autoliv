import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import localforage from 'localforage';
localforage.config({
    name: "modules-scrap-declaration"
});
import './assets/css/main.css';
import { createPinia } from 'pinia';

const app = createApp(App);
app.config.globalProperties.$localforage = localforage;
app.use(router);
app.use(createPinia());
app.mount('#app');
