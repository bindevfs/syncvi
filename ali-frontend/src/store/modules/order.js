import API from '@/api/user_api'
import CODE from '@/configs/code'
import _ from 'lodash'

export default {
  state: {
    listOrders: [],
    listProducts: [],
    order: {}
  },
  getters: {
    getListOrders (state) {
      if (state.listOrders.length !== 0) {
        return _.orderBy(state.listOrders, ['updated_at'], 'desc')
      }
      return []
    },
    getListProducts (state) {
      return _.orderBy(state.listProducts, ['created_at'], 'desc')
    },
    getOrder (state) {
      return state.order
    }
  },
  mutations: {
    SET_LIST_ORDERS (state, listOrders) {
      state.listOrders = listOrders
    },
    REMOVE_ORDER (state, params) {
      const order = state.listOrders.find(order => order.id === params.order_id)
      state.listOrders.splice(state.listOrders, state.listOrders.indexOf(order.id))
    },
    SET_LIST_PRODUCTS (state, listProducts) {
      state.listProducts = listProducts
    },
    SET_ORDER (state, order) {
      state.order = order
    }
  },
  actions: {
    orderProduct ({ commit, state }, params) {
      return new Promise((resolve, reject) => {
        API.orderProduct(params).then(response => {
          console.log(response)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    listOrders ({ commit }) {
      commit('LOADING', true)
      return new Promise((resolve, reject) => {
        API.listOrders().then(response => {
          if (response.code === CODE.SUCCESS) {
            commit('SET_LIST_ORDERS', response.data)
          }
          console.log('a')
          commit('LOADING', false)
          resolve(response)
        }).catch(error => {
          commit('LOADING', false)
          reject(error)
        })
      })
    },
    cancelOrder ({commit}, params) {
      return new Promise((resolve, reject) => {
        API.cancelOrder(params).then(response => {
          commit('REMOVE_ORDER', params)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    viewOrder ({commit, getters}, params) {
      return new Promise((resolve, reject) => {
        API.viewOrder(params).then(response => {
          if (response.code === CODE.SUCCESS) {
            commit('SET_LIST_PRODUCTS', response.data.listProduct)
            commit('SET_ORDER', response.data.order)
          }
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}
