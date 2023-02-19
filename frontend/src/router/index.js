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
import ConfirmerCommandeView from "@/views/Menu/ConfirmerCommandeView.vue"
import CommandeView from "@/views/ProfilAdmin/Commande/CommandeView.vue"
import forgot_password from "@/views/Auth/ResetPassword/ForgotPasswordView.vue"
import changer_password from "@/views/Auth/ResetPassword/ChangerPasswordView.vue"
import { pinia } from '@/main'
import { AuthStore } from "@/store/StoreAuth.js";

Vue.use(VueRouter)
const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/CommandeView',
    name: 'CommandeView',
    component: CommandeView
  },
  {
    path: '/PanierView',
    name: 'PanierView',
    component: PanierView
  },
  {
    path: '/ConfirmerCommandeView',
    name: 'ConfirmerCommandeView',
    component: ConfirmerCommandeView
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
    path: '/forgot_password',
    name: 'forgot_password',
    component: forgot_password
  },
  {
    path: '/changer_password',
    name: 'changer_password',
    component: changer_password
  },
  {
    path: '/signup',
    name: 'signup',
    component: signup
  },
  {
    path: '/allOrderedProduct',
    name: 'allOrderedProduct',
    component: allOrderedProduct,
    meta: { requiresClient: true },
  },
  {
    path: '/AllFavoriteProduct',
    name: 'AllFavoriteProduct',
    component: AllFavoriteProduct,
    meta: { requiresClient: true },
  },
  {
    path: '/editProfil',
    name: 'editProfil',
    component: editProfil,
    meta: { requiresAuth: true },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard,
    meta: { requiresAdmin: true },
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  const auth=AuthStore(pinia);
  if (to.matched.some((record) => record.meta.requiresAdmin)) {
    if (auth.getisadmin) {
      next();
      return;
    }
    next({
      name: "login",
    });
  }else if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (auth.getisauth) {
      next();
      return;
    }
    next({
      name: "login",
    });
  } else if (to.matched.some((record) => record.meta.requiresClient)) {
    if (auth.getisadmin==false) {
      next();
      return;
    }
    next({
      name: "login",
    });
  } else {
    next();
  }

});


export default router
