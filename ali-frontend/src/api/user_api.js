import axios from 'axios'
import NProgress from 'nprogress'
import { createError } from './utils'
import store from '@/store/index'

const request = axios.create({
  baseURL: `https://syncvi.tk/api/user/`,
  headers: {
    'Accept': 'application/json'
  },
  timeout: 15000
})

request.interceptors.request.use(config => {
  NProgress.start()
  let token = store.getters.getTokenJWT
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`
  }

  return config
})

request.interceptors.response.use(response => {
  NProgress.done()
  return response
}, () => {
  store.commit('NOTIFICATION_ERROR', {
    title: `Thông Báo`,
    message: `Lỗi kết nối đến hệ thống bạn cần đăng nhập lại.`
  })
  store.commit('LOGOUT')
  NProgress.done()
})

const handleRequest = (request) => {
  return new Promise((resolve, reject) => {
    request.then(response => {
      if (response === undefined) {
        return reject(createError(400, 'No Data'))
      }
      console.log(response)
      resolve(response.data)
    }).catch(error => {
      if (error.code === 401) {
        reject(createError(401, 'Bạn cần đăng nhập'))
      } else {
        reject(error)
      }
    })
  })
}

export default {
  register (params) {
    return handleRequest(request.post(`register`, params))
  },
  login (params) {
    return handleRequest(request.post(`login`, params))
  },
  getCartOrders () {
    return handleRequest(request.get(`viewcart`))
  },
  updateCartOrder (params) {
    return handleRequest(request.post(`updateorderproduct`, params))
  },
  removeCartOrder (params) {
    return handleRequest(request.post(`removeorderproduct`, params))
  },
  orderProduct (params) {
    return handleRequest(request.post(`order`, params))
  },
  listOrders (params) {
    return handleRequest(request.get(`listorder`, params))
  },
  cancelOrder (params) {
    return handleRequest(request.post(`cancelorder`, params))
  },
  viewOrder (params) {
    return handleRequest(request.get(`vieworder?order_id=${params}`))
  },
  comment (params) {
    return handleRequest(request.post(`comment`, params))
  },
  comments (params) {
    return handleRequest(request.get(`comment?order_id=${params}`))
  }
}
