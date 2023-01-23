import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import login from '../views/Auth/LoginView.vue'
import signup from '../views/Auth/SignUpView.vue'
import allOrderedProduct from '../views/ProfilClient/AllOrderedView.vue'
import AllFavoriteProduct from '../views/ProfilClient/AllFavoriteView.vue'
import dashboard from '../views/ProfilAdmin/dashboard/DashboardView.vue'
import editProfil from "@/views/ProfilClient/EditProfilView.vue"
import ConsulteMenuView from "@/views/Menu/ConsulteMenuView.vue"
import PanierView from "@/views/Menu/PanierView.vue"
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/PanierView',
    name: 'PanierView',
    component: PanierView
  },
  {
    path: '/ConsulteMenuView/:id',
    name: 'ConsulteMenuView',
    component: ConsulteMenuView
  },
  {
    path: '/login',
    name: 'login',
    component: login
  },
  {
    path: '/signup',
    name: 'signup',
    component: signup
  },

  {
    path: '/allOrderedProduct',
    name: 'allOrderedProduct',
    component: allOrderedProduct
  },
  {
    path: '/AllFavoriteProduct',
    name: 'AllFavoriteProduct',
    component: AllFavoriteProduct
  },
  {
    path: '/editProfil',
    name: 'editProfil',
    component: editProfil
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
