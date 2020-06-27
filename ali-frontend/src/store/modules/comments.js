import API from '@/api/user_api'
import _ from 'lodash'

export default {
  state: {
    comments: []
  },
  getters: {
    getComments (state) {
      if (state.comments.length !== 0) {
        return _.orderBy(state.comments, 'created_at', 'asc')
      }
      return []
    }
  },
  mutations: {
    SET_COMMENTS (state, comments) {
      state.comments = comments
    },
    SET_COMMENT (state, comment) {
      state.comments.push(comment)
    }
  },
  actions: {
    comments ({commit}, params) {
      return new Promise((resolve, reject) => {
        API.comments(params).then(response => {
          commit('SET_COMMENTS', response.data.comments)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    commentAction ({commit}, params) {
      return new Promise((resolve, reject) => {
        API.comment(params).then(response => {
          console.log(response)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}
