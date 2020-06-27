import Vue from 'vue'
export default {
  namespace: true,
  mutations: {
    NOTIFICATION_ERROR (state, {title, message}) {
      Vue.prototype.$vs.notify({
        title: `${title}`,
        text: `${message}`,
        iconPack: 'feather',
        icon: 'icon-alert-circle',
        color: 'danger'
      })
    },
    NOTIFICATION_SUCCESS (state, {title, message}) {
      Vue.prototype.$vs.notify({
        title: `${title}`,
        text: `${message}`,
        iconPack: 'feather',
        icon: 'icon-check',
        color: 'success'
      })
    }
  }
}
