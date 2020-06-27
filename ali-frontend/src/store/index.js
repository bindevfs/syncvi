import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import cart from './modules/cart'
import faq from './modules/faq'
import loading from './modules/loading'
import notification from './modules/notification'
import order from './modules/order'
import comment from './modules/comments'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    notification,
    cart,
    order,
    faq,
    loading,
    comment
  },
  plugins: [createPersistedState({
    paths: ['cart.cartOrders', 'auth.user'],
    storage: {
      getItem: key => localStorage.getItem(key),
      setItem: (key, value) => localStorage.setItem(key, value),
      removeItem: key => localStorage.removeItem(key)
    }
  })]
})
