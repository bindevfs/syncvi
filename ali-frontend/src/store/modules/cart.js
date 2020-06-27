import Vue from 'vue'
import API from '@/api/user_api'
import _ from 'lodash'
import CODE from '@/configs/code'

export default {
  state: {
    cartOrders: [],
    selectCartOrders: []
  },
  getters: {
    cartOrders (state) {
      // filter object not exist in product wish
      // order product cart with created at
      if (state.cartOrders.length !== 0) {
        return _.orderBy(state.cartOrders, 'created_at', 'desc')
      }
      return []
    },
    countNumberCart (state) {
      return state.cartOrders.length
    },
    isInCart: state => cartOrder => {
      let cartOrderProduct = _.find(state.cartOrders, { id: cartOrder.id })
      return !cartOrderProduct.product_wish
    },
    isInWish: state => {
      let productInWish = _.find(state.cartOrders, { product_wish: false })
      return !!productInWish
    },
    totalCart (state) {
      let cartOrderSelected = _.filter(state.cartOrders, function (item) { return !item.product_wish })
      let total = 0
      cartOrderSelected.map(product => {
        total += product.price * product.quality
      })

      return total
    }
  },
  mutations: {
    SET_CART_ORDERS (state, cartOrders) {
      state.cartOrders = _.map(cartOrders, function (element) {
        return _.extend({}, element, {product_wish: false})
      })
    },
    UPDATE_CART_ORDER (state, params) {
      const productOrder = state.cartOrders.find(element => element.id === params.order_product_id)
      productOrder.quality = params.quality !== undefined ? params.quality : 1
    },
    REMOVE_CART_ORDER (state, params) {
      const productOrder = state.cartOrders.find(product => product.id === params.order_product_id)
      Vue.delete(state.cartOrders, state.cartOrders.indexOf(productOrder))
    },
    MOVE_TO_WISH_LIST (state, cartOrder) {
      _.find(state.cartOrders, { id: cartOrder.id }).product_wish = true
    },
    MOVE_TO_CART (state, cartOrderId) {
      _.find(state.cartOrders, { id: cartOrderId.id }).product_wish = false
    }
  },
  actions: {
    getCartOrders ({ commit }) {
      commit('LOADING', true)
      return new Promise((resolve, reject) => {
        API.getCartOrders().then(response => {
          if (response.code === CODE.SUCCESS) {
            commit('SET_CART_ORDERS', response.data.listProduct)
            commit('SET_USER_DATA', response.data.user)
          }
          commit('LOADING', false)
          resolve(response)
        }).catch(error => {
          commit('LOADING', false)
          reject(error)
        })
      })
    },
    updateCartOrder ({ commit, state }, params) {
      return new Promise((resolve, reject) => {
        API.updateCartOrder(params).then(response => {
          commit('UPDATE_CART_ORDER', params)
          resolve(response)
        }).catch(error => {
          console.log(error)
          reject(error)
        })
      })
    },
    removeCartOrder ({ commit, state }, params) {
      return new Promise((resolve, reject) => {
        API.removeCartOrder(params).then(response => {
          commit('REMOVE_CART_ORDER', params)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    moveProductToWishList ({ commit }, cartOrder) {
      commit('MOVE_TO_WISH_LIST', cartOrder)
    },
    moveProductToCart ({ commit }, cartOrder) {
      commit('MOVE_TO_CART', cartOrder)
    }
  }

}
