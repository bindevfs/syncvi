<template>
    <div id="checkout" v-if="!this.loading">
      <div class="vx-row" v-if="this.cartOrders.length !== 0">
        <div class="vx-col lg:w-2/3 w-full relative">
          <div class="items-list-view" v-for="(cartItem, index) in cartOrders" :key="index">
            <item-list-view :cartItem="cartItem" />
          </div>
        </div>
        <div class="vx-col lg:w-1/3 w-full relative">
          <vx-card>
            <h5 class="font-semibold mb-3">{{ $t('orders.total_details')}}</h5>
            <div class="flex justify-between mb-2">
              <span class="text-grey">{{ $t('orders.provisional_total')}}</span>
              <span>{{ totalCart | price_format }} ₫</span>
            </div>
            <div class="flex justify-between mb-2">
              <span class="text-grey">{{ $t('orders.provisional_fee')}}</span>
              <span class="text-primary">{{ temporaryFee | price_format }} ₫</span>
            </div>
            <div class="flex justify-between mb-2">
              <span class="text-grey">{{ $t('orders.current_rate') }}: </span>
              <a href="#" class="text-primary">{{ currentRate }} ₫</a>
            </div>
            <div class="flex justify-between mb-2">
              <span class="text-grey">{{ $t('orders.deposit') }}(60%): </span>
              <a href="#" class="text-primary">{{ deposit | price_format }} ₫</a>
            </div>
            <vs-divider />

            <div class="flex justify-between font-semibold mb-3 sum-price">
              <span>{{ $t('orders.total') }}:</span>
              <span>{{ total | price_format }} đ</span>
            </div>
            <vs-divider />
            <div class="flex justify-between font-semibold mb-3">
              <h5 class="font-semibold">{{ $t('orders.address_order')}}</h5>
            </div>
            <div class="shipping-default">
              <div class="flex justify-between font-semibold mb-3">
                <span class="font-semibold default">{{ $t('user.default_address') }}</span>
              </div>
              <form>
                <div class="vx-row">
                  <div class="vx-col w-full">
                    <div class="flex justify-between mb-2">
                      <h4 class="text-grey">{{ getUser.shipping_name ? getUser.shipping_name : getUser.name }}</h4>
                    </div>
                    <div class="flex justify-between mb-2">
                      <span class="text-grey">{{ $t('user.address') }}: {{ this.getUser.shipping_address  }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                      <span class="text-grey">{{ $t('user.phone') }}: {{ getUser.shipping_phone ? getUser.shipping_phone : getUser.phone }}</span>
                    </div>
                  </div>
                </div>
                <vs-button class="w-full mt-5"  @click.prevent="openConfirmDefault" data-default="default" ref="default" :disabled="!isInWish">{{ $t('action.order') }}</vs-button>
              </form>
            </div>
            <div class="flex">
              <p class="font-semibold">{{ $t('orders.another_address') }} </p>
              <a href="javascript:void(0)" id="addNewAddress" @click="isActive = !isActive">
                &nbsp;{{ $t('orders.new_address') }}
              </a>
            </div>
            <transition name="fade" mode="out-in">
              <div class="new-address"  v-if="isActive">
                <form data-vv-scope="add-new-address">
                  <div class="vx-row">
                    <div class="vx-col w-full">
                      <vs-input
                        v-validate="'required'"
                        data-vv-as="Họ tên"
                        name="shipping_name"
                        v-model="shipping.shipping_name"
                        :label="$t('user.name')"
                        class="w-full mt-5" />
                      <span v-show="errors.has('add-new-address.shipping_name')" class="text-danger">{{ errors.first('add-new-address.shipping_name') }}</span>
                    </div>
                  </div>
                  <div class="vx-row">
                    <div class="vx-col w-full">
                      <vs-input
                        v-validate="'required|digits:10'"
                        data-vv-as="Số ĐT"
                        name="shipping_phone"
                        v-model="shipping.shipping_phone"
                        :label="$t('user.phone')"
                        class="w-full mt-5" />
                      <span v-show="errors.has('add-new-address.shipping_phone')" class="text-danger">{{ errors.first('add-new-address.shipping_phone') }}</span>
                    </div>
                  </div>
                  <div class="vx-row">
                    <div class="vx-col w-full">
                      <vs-input
                        @keyup.enter.native="openConfirm"
                        v-validate="'required'"
                        data-vv-as="Địa chỉ"
                        name="shipping_address"
                        v-model="shipping.shipping_address"
                        :label="$t('user.address')"
                        class="w-full mt-5" />
                      <span v-show="errors.has('add-new-address.shipping_address')" class="text-danger">{{ errors.first('add-new-address.shipping_address') }}</span>
                    </div>
                  </div>
                  <div class="vx-row">
                    <div class="vx-col w-full flex mt-3">
                      <vs-checkbox v-model="isdefaultAddress"></vs-checkbox>
                      Sử dụng địa chỉ này làm mặc định.
                    </div>
                  </div>
                  <vs-button class="w-full mt-5"  @click.prevent="openConfirm" :disabled="!isInWish">{{ $t('action.order') }}</vs-button>
                </form>
              </div>
            </transition>
          </vx-card>
        </div>
      </div>
      <div class="vx-row" v-else>
        <introduction-order title="Bạn không có sản phẩm nào trong giỏ hàng"/>
      </div>
    </div>
</template>
<script>
import ItemListView from '@/components/cart/ItemListView'
import IntroductionOrder from '@/components/IntroductionOrder'
import { mapActions, mapGetters } from 'vuex'
import PRICE from '@/configs/price'
import _ from 'lodash'
import CODE from '@/configs/code'
import { Validator } from 'vee-validate'

Validator.localize({
  en: {
    messages: {
      required: (field) => field + ' không được để trống.'
    },
    custom: {
      shipping_phone: {
        digits: 'Số điện thoại không được quá 10 chữ số.'
      }
    }
  }
})
export default {
  components: {
    ItemListView,
    IntroductionOrder
  },
  data () {
    return {
      shipping: {
        shipping_name: '',
        shipping_address: '',
        shipping_phone: ''
      },
      isActive: false,
      isdefaultAddress: false
    }
  },
  computed: {
    ...mapGetters(['cartOrders', 'totalCart', 'countNumberCart', 'isInWish', 'getUser', 'loading']),
    // phi tam tinh
    temporaryFee () {
      let fixedCharge = PRICE.SERVICE_CHARGE * this.countNumberCart // 5000 * countNumberCart
      return fixedCharge + this.totalCart * PRICE.EXCHANGE_RATE
    },
    total () {
      return this.totalCart + this.temporaryFee
    },
    currentRate () {
      return PRICE.CURRENT_RATE
    },
    deposit () {
      return this.total * (PRICE.DEPOSIT / 100)
    },
    validateForm () {
      return this.shipping.shipping_name !== '' && this.shipping.shipping_address !== '' && this.shipping.shipping_phone !== ''
    }
  },
  mounted () {
    this.getCartOrders()
  },
  methods: {
    ...mapActions(['getCartOrders', 'orderProduct']),
    orderProductCartDefault () {
      let orderProductIds = _.map(_.filter(this.cartOrders, function (item) {
        return !item.product_wish
      }), 'id')
      let params = {
        order_products: orderProductIds,
        shipping_name: this.getUser.shipping_name ? this.getUser.shipping_name : this.getUser.name,
        shipping_phone: this.getUser.shipping_phone ? this.getUser.shipping_phone : this.getUser.phone,
        shipping_address: this.getUser.shipping_address ? this.getUser.shipping_address : this.getUser.address
      }
      this.orderProduct(params).then(response => {
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: this.$t('messages.notification'),
            message: this.$t('messages.success.order')
          })
          this.$router.push({name: 'info-order'})
        } else {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: this.$t('messages.error'),
            message: this.$t('messages.errors.order')
          })
        }
      })
    },
    orderProductCart () {
      let orderProductIds = _.map(_.filter(this.cartOrders, function (item) {
        return !item.product_wish
      }), 'id')
      let params = {
        order_products: orderProductIds,
        shipping_name: this.shipping.shipping_name,
        shipping_phone: this.shipping.shipping_phone,
        shipping_address: this.shipping.shipping_address,
        save: this.isdefaultAddress
      }
      this.orderProduct(params).then(response => {
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: this.$t('messages.notification'),
            message: this.$t('messages.success.order')
          })
          this.$router.push({name: 'info-order'})
        } else {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: this.$t('messages.error'),
            message: this.$t('messages.errors.order')
          })
        }
      })
    },
    openConfirmDefault () {
      this.$vs.dialog({
        type: 'confirm',
        color: 'rgba(var(--vs-primary),1)',
        title: this.$t('messages.confirm_message'),
        text: this.$t('messages.confirm.order'),
        acceptText: this.$t('messages.confirm_message'),
        cancelText: this.$t('messages.cancel'),
        accept: this.orderProductCartDefault
      })
    },
    openConfirm () {
      this.$validator.validateAll('add-new-address').then(result => {
        if (result) {
          this.$vs.dialog({
            type: 'confirm',
            color: 'rgba(var(--vs-primary),1)',
            title: this.$t('messages.confirm_message'),
            text: this.$t('messages.confirm.order'),
            acceptText: this.$t('messages.confirm_message'),
            cancelText: this.$t('messages.cancel'),
            accept: this.orderProductCart
          })
        }
      })
    }
  }
}
</script>
<style lang="scss">
  @import "../../../styles/cart";
  #checkout {
    .text-white {
      color: #fff !important;
    }
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-to {
      opacity: 0
    }
    .vs-checkbox {
      width: 23px;
      height: 23px;
    }
  }
</style>
