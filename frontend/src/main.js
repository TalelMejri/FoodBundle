import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import router from './router'
import store from './store/StoreAuth'
import Vuelidate from "./plugins/Vuelidate";
import { createPinia, PiniaVuePlugin } from 'pinia'
import {interceptors} from '../src/global/interceptors.js'
import vuetify from './plugins/vuetify'
Vue.use(PiniaVuePlugin)
const pinia = createPinia()
Vue.config.productionTip = false
interceptors();
new Vue({
  Vuelidate,
  router,
  store,
  vuetify,
  pinia,
  render: h => h(App)
}).$mount('#app')
