<template>
  <div class="h-screen flex w-full bg-img">
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 mx-auto self-center">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">
          <div class="vx-row">
            <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
              <img src="@/assets/images/pages/register.jpg" alt="register" class="mx-auto">
            </div>
            <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
              <div class="p-8">
                <div class="vx-card__title">
                  <h4 class="mb-4">Đăng Ký Thành Viên</h4>
                  <p>Điền đầy đủ các thông tin ở bên dưới.</p>
                </div>
                <div class="clearfix">
                  <vs-input
                    v-validate="'required|min:3'"
                    data-vv-validate-on="blur"
                    data-vv-as="Họ tên"
                    label-placeholder="Họ tên"
                    name="name"
                    placeholder="Họ Tên"
                    v-model="user.name"
                    class="w-full" />
                  <span class="text-danger text-sm">{{ errors.first('name') }}</span>

                  <vs-input
                    v-validate="'required|email'"
                    data-vv-validate-on="blur"
                    data-vv-as="Email"
                    name="email"
                    type="email"
                    label-placeholder="Email"
                    placeholder="Email"
                    v-model="user.email"
                    class="w-full mt-6" />
                  <span class="text-danger text-sm">{{ errors.first('email') }}</span>

                  <vs-input
                    ref="password"
                    type="password"
                    data-vv-validate-on="blur"
                    data-vv-as="Mật khẩu"
                    v-validate="'required|min:6'"
                    name="password"
                    label-placeholder="Mật khẩu"
                    placeholder="Mật khẩu"
                    v-model="user.password"
                    class="w-full mt-6" />
                  <span class="text-danger text-sm">{{ errors.first('password') }}</span>
                  <vs-input
                    v-validate="'required|max:10'"
                    data-vv-validate-on="blur"
                    data-vv-as="Số điện thoại"
                    label-placeholder="Số điện thoại"
                    name="phone"
                    placeholder="Số điện thoại"
                    v-model="user.phone"
                    class="w-full" />
                  <span class="text-danger text-sm">{{ errors.first('phone') }}</span>

                  <vs-input
                    @keyup.enter="register"
                    data-vv-validate-on="blur"
                    data-vv-as="Địa chỉ"
                    label-placeholder="Địa chỉ"
                    name="address"
                    placeholder="Địa chỉ"
                    v-model="user.address"
                    class="w-full" />
                </div>
                <span class="text-danger text-sm">{{ errors.first('address') }}</span>
                <vs-button  type="border" to="/login" class="mt-6">Đăng Nhập</vs-button>
                <vs-button class="float-right mt-6" @click="register" :disabled="!validateForm">Đăng Ký</vs-button>
              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import { Validator } from 'vee-validate'
import { mapActions } from 'vuex'
import NProgress from 'nprogress'
import CODE from '@/configs/code'

Validator.localize({
  en: {
    messages: {
      required: (field) => field + ' không được để trống.'
    },
    custom: {
      name: {
        min: 'Họ tên phải ít nhất 3 kí tự.'
      },
      email: {
        email: 'Email không hợp lệ.'
      },
      password: {
        min: 'Mật khẩu phải chứa ít nhất 6 kí tự.'
      },
      phone: {
        max: 'Số điện thoại không được quá 10 chữ số.'
      }
    }
  }
})
export default {
  data () {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        phone: '',
        address: ''
      }
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() &&
        this.user.name !== '' &&
        this.user.email !== '' &&
        this.user.password !== '' &&
        this.user.phone !== '' &&
        this.user.address !== ''
    }
  },
  methods: {
    ...mapActions(['registerAction']),
    register () {
      NProgress.start()
      this.registerAction(this.user).then(response => {
        console.log(response)
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: `Thông Báo`,
            message: `Đăng kí thành công.`
          })
          this.$router.push('/login')
        } else if (response.code === 400) {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: `Thông Báo`,
            message: `Tài khoản đã tồn tại.`
          })
        }
      }).catch(error => {
        NProgress.done()
        console.log(error)
      })
    }
  }
}
</script>
