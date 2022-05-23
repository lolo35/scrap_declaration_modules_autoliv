import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Cookies from 'js-cookie';

const isAuthenticated = () => {
  let jwt = Cookies.get(`scrap_declare_jwt`, { path: '/'});
  return jwt ? true : false;
}

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    beforeEnter: (to, from, next) => {
      if(!isAuthenticated()) next({name: "Barcodes"})
    }
  },
  {
    path: "/barcodes",
    name: "Barcodes",
    component: () => import('../views/BarcodesView.vue')
  },
  {
    path: '/login',
    name: "Login",
    component: () => import('../views/LoginView.vue')
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

export default router
