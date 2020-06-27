<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@/assets/images/pages/login.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Đăng Nhập</h4>
                                    <p>Đăng Nhập Hệ Thống SynsVi.</p>
                                </div>
                                <vs-input
                                    v-validate="'required|email|min:3'"
                                    data-vv-validate-on="blur"
                                    name="email"
                                    icon="icon icon-user"
                                    icon-pack="feather"
                                    label-placeholder="Email"
                                    v-model="user.email"
                                    class="w-full no-icon-border"/>
                                <span class="text-danger text-sm">{{ errors.first('email') }}</span>

                                <vs-input
                                    @keyup.enter.native="login"
                                    data-vv-validate-on="blur"
                                    v-validate="'required|min:6'"
                                    type="password"
                                    name="password"
                                    icon="icon icon-lock"
                                    icon-pack="feather"
                                    label-placeholder="Mật Khẩu"
                                    v-model="user.password"
                                    class="w-full mt-6 no-icon-border"
                                />
                                <span class="text-danger text-sm">{{ errors.first('password') }}</span>

                                <div class="flex flex-wrap justify-between my-5">
                                    <router-link to="/pages/forgot-password">Quên Mật Khẩu?</router-link>
                                </div>
                                <vs-button to="/register" type="border">Đăng Ký</vs-button>
                                <vs-button class="float-right" :disabled="!validateForm" @click="login">Đăng Nhập</vs-button>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>
<script>
import CODE from '@/configs/code'
import NProgress from 'nprogress'
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      user: {
        email: 'syncvi2019@gmail.com',
        password: 'syncvi2019'
      }
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.user.email !== '' && this.user.password !== ''
    }
  },
  methods: {
    ...mapActions({
      loginAction: 'loginAction'
    }),
    login () {
      NProgress.start()
      this.loginAction(this.user).then(response => {
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: `Thông Báo`,
            message: `Đăng nhập thành công.`
          })
          this.$router.push('/list-cart')
        } else if (response.code === 400) {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: `Thông Báo`,
            message: `Tài khoản xác thực không chính xác.`
          })
        }
      }).catch(() => {
        NProgress.done()
      })
    }
  }
}
</script>
<style lang="scss">
    #page-login {
        .social-login {
            .bg-facebook {
                background-color: #1551b1;
            }
            .bg-twitter {
                background-color: #00aaff;
            }
            .bg-google {
                background-color: #1551b1;
            }
            .bg-github {
                background-color: #333;
            }
        }
    }
    #page-login {
        .vs-checkbox--check {
            .vs-checkbox--icon {
                font-size: 18px;
            }
        }
    }
</style>
