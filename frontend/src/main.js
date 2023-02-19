import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import router from './router'
import store from './store/StoreAuth'
import 'aos/dist/aos.css';
import Vuelidate from "./plugins/Vuelidate";
import { createPinia, PiniaVuePlugin } from 'pinia'
import {interceptors} from '../src/global/interceptors.js'
import vuetify from './plugins/vuetify'
Vue.use(PiniaVuePlugin)
export const pinia = createPinia()
Vue.config.productionTip = false
interceptors();

new Vue({
  Vuelidate,
  pinia,
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')





