import API from '@/api/user_api'

export default {
  namespace: true,
  state: {
    user: {},
    token: localStorage.getItem('token_jwt') || ''
  },
  getters: {
    loggedIn (state) {
      return !!state.token
    },
    getUser (state) {
      return state.user
    },
    getTokenJWT (state) {
      return state.token
    }
  },
  mutations: {
    SET_USER_DATA (state, user) {
      state.user = user
    },
    SET_TOKEN_DATA (state, token) {
      state.token = token
    },
    SET_TOKEN (state, userData) {
      localStorage.setItem('token_jwt', userData.token)
    },
    LOGOUT (state) {
      const initial = state
      Object.keys(initial).forEach(key => {
        state[key] = initial[key]
      })
      state.user = null
      state.token = null
      localStorage.removeItem('vuex')
      localStorage.removeItem('token_jwt')
      window.localStorage.clear()
      location.reload()
    }
  },
  actions: {
    registerAction ({ commit }, credentials) {
      return new Promise((resolve, reject) => {
        API.register(credentials).then(response => {
          resolve(response)
        }).catch(error => {
          if (error.code === 401) {
            reject(error)
          }
        })
      })
    },
    loginAction ({ state, commit }, credentials) {
      return new Promise((resolve, reject) => {
        API.login(credentials).then(response => {
          let responseData = response.data
          if (Object.entries(responseData).length !== 0 && responseData.constructor === Object) {
            console.log(responseData)
            commit('SET_TOKEN', responseData)
            commit('SET_USER_DATA', responseData.user)
            commit('SET_TOKEN_DATA', responseData.token)
          }
          resolve(response)
        }).catch(error => {
          localStorage.removeItem('user')
          localStorage.removeItem('token_jwt')
          reject(error)
        })
      })
    },
    logoutAction ({ commit }) {
      return new Promise((resolve, reject) => {
        commit('LOGOUT')
        resolve()
      })
    }
  }
}
