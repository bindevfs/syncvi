<template>
    <div class="relative">
        <div class="vx-navbar-wrapper">
            <vs-navbar  v-model="activeItem" class="vs-navbar vx-navbar" color="#fff">
                <div slot="title">
                    <router-link :to="{name: 'home'}">
                      <vs-navbar-title>
                        <div class="logo flex items-center">
                          <img src="@/assets/images/logo/logo.png" alt="logo" class="w-10 mr-4">
                          <span class="logo-text" style="">SyncVi</span>
                        </div>
                      </vs-navbar-title>
                    </router-link>
                </div>
                <vs-navbar-item v-if="loggedIn">
                  <router-link :to="{ name: 'list-cart' }">
                    <feather-icon icon="ShoppingCartIcon" class="cursor-pointer ml-4 mr-6 mt-1" :badge="countNumberCart"></feather-icon>
                  </router-link>
                </vs-navbar-item>
                <vs-spacer></vs-spacer>
                <vs-navbar-item class="mr-3">
                  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
                    <span class="cursor-pointer flex i18n-locale"><img class="h-4 w-5" :src="require(`@/assets/images/flags/${$i18n.locale}.png`)" :alt="$i18n.locale" /><span class="sm:block ml-2">{{ getCurrentLocaleData.lang }}</span></span>
                    <vs-dropdown-menu class="w-48 i18n-dropdown">
                      <vs-dropdown-item  @click="updateLocale('vn')"><img class="h-4 w-5 mr-1" src="@/assets/images/flags/vn.png" alt="vn" /> &nbsp;Việt Nam</vs-dropdown-item>
                      <vs-dropdown-item  @click="updateLocale('en')"><img class="h-4 w-5 mr-1" src="@/assets/images/flags/en.png" alt="en" /> &nbsp;English</vs-dropdown-item>
                    </vs-dropdown-menu>
                  </vs-dropdown>
                </vs-navbar-item>
              <vs-navbar-item class="mr-3">
                <router-link :to="{ name: 'introduction' }">Giới thiệu</router-link>
              </vs-navbar-item>
              <vs-navbar-item class="mr-3">
                <router-link :to="{ name: 'regulations' }">Quy định</router-link>
              </vs-navbar-item>
              <vs-navbar-item class="mr-3">
                <router-link :to="{ name: 'quotation' }">Báo giá</router-link>
              </vs-navbar-item>
                <vs-navbar-item class="mr-3">
                  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
                    <span class="cursor-pointer flex i18n-locale"><span class="sm:block ml-2">{{ $t('guide.tips') }}</span></span>
                    <vs-dropdown-menu class="w-48 i18n-dropdown">
                      <router-link :to="{name: 'guide-order'}"><vs-dropdown-item>{{ $t('guide.guide_order') }}</vs-dropdown-item></router-link>
                      <router-link :to="{name: 'question-answers'}"><vs-dropdown-item>{{ $t('guide.question_answer') }}</vs-dropdown-item></router-link>
                      <router-link :to="{name: 'terms-of-use'}"><vs-dropdown-item>{{ $t('guide.terms_of_use') }}</vs-dropdown-item></router-link>
                    </vs-dropdown-menu>
                  </vs-dropdown>
                </vs-navbar-item>
                <vs-navbar-item v-if="!loggedIn" class="mr-3">
                    <router-link :to="{ name: 'login' }">{{ $t('auth.login') }}</router-link>
                </vs-navbar-item>
                <vs-navbar-item v-if="!loggedIn" class="mr-3">
                  <router-link :to="{ name: 'register' }">{{ $t('auth.register') }}</router-link>
                </vs-navbar-item>
                <vs-navbar-item v-else class="mr-3">
                    <div class="the-navbar__user-meta flex items-center">
                        <div class="text-right leading-tight hidden sm:block">
                            <p class="font-semibold">{{ user }}</p>
                        </div>
                        <vs-dropdown class="cursor-pointer">
                            <div class="con-img ml-3">
                                <img
                                    src="@/assets/images/avatar/customer.png"
                                    alt="user-img"
                                    width="40"
                                    height="40"
                                    class="rounded-full shadow-md cursor-pointer block" />
                            </div>
                            <vs-dropdown-menu>
                                <ul style="min-width: 9rem">
                                    <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                                      <feather-icon icon="UserIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">{{ $t('auth.account') }}</span>
                                    </li>
                                    <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="clickOrder">
                                        <feather-icon icon="ArchiveIcon" svgClasses="w-4 h-4" ></feather-icon> <span class="ml-2">{{ $t('orders.orders') }}</span>
                                    </li>
                                    <vs-divider class="m-1"></vs-divider>
                                    <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="logout">
                                      <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">{{ $t('auth.logout') }}</span>
                                    </li>
                                </ul>
                            </vs-dropdown-menu>
                        </vs-dropdown>
                    </div>
                </vs-navbar-item>
            </vs-navbar>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data () {
    return {
      activeItem: 0
    }
  },
  computed: {
    ...mapGetters(['countNumberCart', 'loggedIn', 'getUser']),
    user () {
      return this.loggedIn ? this.getUser.name : ''
    },
    getCurrentLocaleData () {
      const locale = this.$i18n.locale
      if (locale === 'vn') return { flag: 'vn', lang: 'Việt Nam' }
      else return { flag: 'en', lang: 'English' }
    }
  },
  methods: {
    ...mapActions({
      logoutAction: 'logoutAction'
    }),
    updateLocale (locale) {
      this.$i18n.locale = locale
    },
    clickOrder () {
      this.$router.push('/info-order')
    },
    logout () {
      this.logoutAction().then(() => {
        this.$router.push('/login')
      })
    }
  }
}
</script>
<style lang="scss">
  .relative {
    .vx-navbar-wrapper {
      padding-top: 0 !important;
    }
  }
  .vs-dropdown-menu {
    width: 14rem !important;
  }
</style>
