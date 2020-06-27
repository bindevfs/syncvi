import Vue from 'vue'

export default {
  namespace: true,
  state: {
    activeLoading: false
  },
  getters: {
    loading (state) {
      return state.activeLoading
    }
  },
  mutations: {
    LOADING (state, payload) {
      if (payload) {
        state.activeLoading = payload
        Vue.prototype.$vs.loading({
          type: 'radius'
        })
      } else {
        state.activeLoading = payload
        Vue.prototype.$vs.loading.close()
      }
    }
  }
}
