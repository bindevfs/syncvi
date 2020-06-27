// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css'
import '../themeConfig.js'
import './globalComponent.js'
import '@/assets/scss/main.scss'
import '@/assets/css/output.css'
import store from '@/store'
import VeeValidate from 'vee-validate'
import 'nprogress/nprogress.css'
import * as VueGoogleMaps from 'vue2-google-maps'
import './filters/filters'
import _ from 'lodash'
import i18n from './i18n/i18n'
require('@/assets/css/iconfont.css')

Object.defineProperty(Vue.prototype, '_', { value: _ })
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyBvOp0_aKn4_zS6ggkGQix6iDqQWmK8KQo',
    libraries: 'places'
  }
})

Vue.use(VeeValidate)
Vue.use(Vuesax)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  i18n,
  components: { App },
  template: '<App/>'
})
