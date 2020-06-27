import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/pages/user/auth/Login'
import Register from '@/pages/user/auth/Register'
import Error404 from '@/pages/user/errors/Error404'
import store from '@/store/index'
import NProgress from 'nprogress'

Vue.use(Router)

const originalPush = Router.prototype.push
Router.prototype.push = function push (location) {
  return originalPush.call(this, location).catch(err => err)
}

const router = new Router({
  mode: 'history',
  linkExactActiveClass: 'is-active',
  routes: [
    {
      path: '/user',
      component: () => import('@/layouts/Main'),
      children: [
        {
          path: '/list-cart',
          name: 'list-cart',
          component: () => import('@/pages/user/cart/Cart'),
          meta: { requiresAuth: true }
        },
        {
          path: '/info-order',
          name: 'info-order',
          component: () => import('@/pages/user/order/Order'),
          meta: { requiresAuth: true }
        },
        {
          path: '/info-order/view/:id',
          name: 'order-show',
          component: () => import('@/pages/user/order/OrderShow'),
          meta: { requiresAuth: true },
          props: true,
          beforeEnter (routeTo, routeFrom, next) {
            store.dispatch('viewOrder', routeTo.params.id).then(response => {
              console.log(response)
              if (response.code === 200) {
                routeTo.params.id = response.data.order.id
                next()
              } else {
                next({name: '404'})
              }
            })
          }
        },
        {
          path: '/info-order/tracking',
          name: 'order-tracking',
          component: () => import('@/pages/user/order/OrderTracking')
        }
      ]
    },
    {
      path: '',
      component: () => import('@/layouts/FullPage'),
      children: [
        {
          path: '/',
          name: 'home',
          component: () => import('@/pages/user/home/Index')
        },
        {
          path: '/guide-order-shopping',
          name: 'guide-order',
          component: () => import('@/pages/user/guide/GuideOrder')

        },
        {
          path: '/question-answers',
          name: 'question-answers',
          component: () => import('@/pages/user/guide/QuestionAnswers')

        },
        {
          path: '/terms-of-use',
          name: 'terms-of-use',
          component: () => import('@/pages/user/guide/TermsOfUse')

        },
        {
          path: '/introduction',
          name: 'introduction',
          component: () => import('@/pages/user/introduction/Introduction')

        },
        {
          path: '/regulations',
          name: 'regulations',
          component: () => import('@/pages/user/regulations/Regulations')

        },
        {
          path: '/quotation',
          name: 'quotation',
          component: () => import('@/pages/user/quotations/Index')

        },
        {
          path: '/login',
          name: 'login',
          component: Login,
          meta: {
            guest: true
          }
        },
        {
          path: '/register',
          name: 'register',
          component: Register,
          meta: {
            guest: true
          }
        }
      ]
    },
    {
      path: '/404',
      name: '404',
      component: Error404
    },
    {
      path: '*',
      redirect: { name: '404' }
    }
  ]
})

router.beforeEach((to, from, next) => {
  NProgress.start()
  let loggedIn = store.getters.loggedIn
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!loggedIn) {
      next({path: '/login'})
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.guest)) {
    if (loggedIn) {
      next({
        name: 'list-cart'
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

router.afterEach(() => {
  NProgress.done()
})

export default router
