import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import router from './router'
import store from './store/StoreAuth'
import { createPinia, PiniaVuePlugin } from 'pinia'
import vuetify from './plugins/vuetify'
Vue.use(PiniaVuePlugin)
const pinia = createPinia()
Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  pinia,
  render: h => h(App)
}).$mount('#app')
