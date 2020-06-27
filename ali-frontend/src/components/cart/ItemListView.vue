<template>
    <vx-card class="list-view-item mb-base overflow-hidden">
        <template slot="no-body">
            <div class="vx-row item-details no-gutter">
                <a target="_blank" :href="cartItem.product_url" class="vx-col sm:w-1/4 w-full item-img-container bg-white flex items-center justify-center">
                    <img
                        class="grid-view-img p-4"
                        :src="cartItem.thumbnails"
                        alt="cartItem.product_name"
                    >
                </a>
                <div class="vx-col sm:w-1/2">
                    <div class="p-4 pt-6">
                        <slot name="item-meta">
                            <a class="item-name font-semibold mb-1" target="_blank" :href="cartItem.product_url">{{ cartItem.product_name }}</a>
                            <p class="text-sm mb-2 cursor-pointer">{{ $t('orders.resource') }}:  <span class="text-primary font-semibold">{{ cartItem.resource }}</span></p>
                            <p class="font-medium text-grey mt-4">{{ cartItem.description }}</p>
                            <p class="font-medium text-grey mt-4"><b>{{ $t('orders.price') }}:</b> {{ formatPriceProduct(cartItem.price) }} ₫</p>
                            <p class="mt-4 font-bold text-sm">{{ $t('orders.quality') }}:</p>
                            <vs-input-number min="1" max="100" @input="updateQuantityAndDescription" v-model="cartItem.quality" class="inline-flex" />
                            <h6 class="item-name font-semibold mb-1">{{ cartItem.name }}</h6>
                        </slot>
                    </div>
                </div>

                <div class="vx-col sm:w-1/4 w-full flex items-center d-theme-border-grey-light">
                    <div class="p-4 flex flex-col w-full  border-r-0 border-t-0 border-b-0">
                        <div class="my-6">
                            <span class="text-grey flex items-start justify-center mt-1">
                                <span class="text-sm ml-2">{{ $t('orders.provisional_total') }}:</span>
                            </span>
                            <h5 class="font-bold text-center">{{ formatPriceProduct(subTotal) }} ₫</h5>
                        </div>
                      <div class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3" @click.prevent="openConfirm">
                        <feather-icon icon="XIcon" svgClasses="h-4 w-4" />
                        <span class="text-sm font-semibold ml-2">{{ $t('action.remove') }}</span>
                      </div>
                      <div @click="moveItemToWish(cartItem)" :class="[isInCart(cartItem) ? 'bg-primary' : 'bg-danger']" class="item-view-secondary-action-btn  p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer">
                        <feather-icon icon="HeartIcon" :svgClasses="[{'text-white fill-current': isInCart(cartItem)}, 'h-4 w-4']"/>
                        <span class="text-sm font-semibold ml-2" v-if="isInCart(cartItem)">{{ $t('orders.buy_later')}}</span>
                        <span class="text-sm font-semibold ml-2" v-else>{{ $t('action.unchecked')}}</span>
                      </div>
                    </div>
                </div>
            </div>
        </template>
    </vx-card>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import formatPrice from '@/mixins/formatPrice'
import _ from 'lodash'
import NProgress from 'nprogress'
import CODE from '@/configs/code'

export default {
  mixins: [formatPrice],
  props: {
    cartItem: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      description: ''
    }
  },
  computed: {
    ...mapGetters(['totalCart', 'isInCart']),
    isInCart () {
      return (item) => this.$store.getters['isInCart'](item)
    },
    subTotal () {
      let total = this.cartItem.price
      if (!isNaN(this.cartItem.quality)) {
        total = this.cartItem.price * this.cartItem.quality
      }
      return total
    }
  },
  methods: {
    ...mapActions(['moveProductToWishList', 'moveProductToCart', 'updateCartOrder', 'removeCartOrder']),
    updateQuantityAndDescription: _.debounce(function (event) {
      let vm = this
      NProgress.start()
      this.updateCartOrder({
        order_product_id: vm.cartItem.id,
        quality: event === '' ? 1 : parseInt(event)
      }).then(response => {
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: this.$t('messages.notification'),
            message: this.$t('messages.success.quality')
          })
        } else {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: this.$t('messages.notification'),
            message: this.$t('messages.success.quality')
          })
        }
      }).catch(() => {
        NProgress.done()
      })
    }, 1500),
    openConfirm () {
      this.$validator.validateAll('add-new-address').then(result => {
        if (result) {
          this.$vs.dialog({
            type: 'confirm',
            color: 'rgba(var(--vs-primary),1)',
            title: this.$t('messages.notification'),
            text: this.$t('messages.confirm.delete_product'),
            acceptText: this.$t('messages.confirm_message'),
            cancelText: this.$t('messages.cancel'),
            accept: this.removeCartOderItem
          })
        }
      })
    },
    removeCartOderItem () {
      NProgress.start()
      this.removeCartOrder({
        order_product_id: this.cartItem.id
      }).then(response => {
        if (response.code === 200) {
        }
      }).catch(() => {
        NProgress.done()
      })
    },
    // move product cart to list product wish
    moveItemToWish (cartOrder) {
      if (this.isInCart(cartOrder)) {
        this.moveProductToWishList(cartOrder)
      } else {
        this.moveProductToCart(cartOrder)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
    .list-view-item {
        .item-name, .item-description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-name {
            -webkit-line-clamp: 2;
        }

        .item-description {
            -webkit-line-clamp: 5;
        }

        .grid-view-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            transition: .35s;
        }

        &:hover {
             transform: translateY(-5px);
             box-shadow: 0px 4px 25px 0px rgba(0,0,0,.25);

        .grid-view-img{
            opacity: 0.9;
        }
        }
    }
    .d-theme-border-grey-light {
        border-left: 1px solid #dae1e7;
    }
    .mb-base {
        margin-bottom: 2.2rem!important;
    }
</style>
