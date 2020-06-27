<template>
  <div id="info-user">
    <div class="items-grid-view vx-row match-height">
      <div class="vx-col lg:w-1/3 sm:w-1/2 w-full mb-3">
        <vx-card
          :title="$t('orders.receivers_information')">
          <p class="font-semibold mb-3">{{ order.description }}</p>
          <p class="font-semibold mb-3" v-if="order.deposit !== 0">{{ $t('orders.deposited') }}: {{ order.deposit | price_format }} ₫</p>
          <p class="font-semibold mb-3" v-else>{{ $t('orders.not_deposited') }}</p>
        </vx-card>
      </div>
      <div class="vx-col lg:w-1/3 sm:w-1/2 w-full mb-3">
        <vx-card
          :title="$t('orders.info_shop')">
          <h5 class="font-semibold"></h5>
          <p class="mb-3 font-semibold">{{ order.shop.name }}</p>
          <p class="mb-3">{{ $t('user.address') }}: {{ order.shop.address }}</p>
          <p class="mb-3">{{ $t('user.phone') }}: {{ order.shop.phone }}</p>
        </vx-card>
      </div>
      <div class="vx-col lg:w-1/3 sm:w-1/2 w-full mb-3">
        <vx-card
          :title="$t('orders.payment_methods')">
          <p class="mb-3 font-semibold">{{ methodPay }}</p>
          <p class="mb-3">STK: 2344555333444333</p>
          <p class="mb-3">{{ $t('orders.name_account')}}: Le Dinh Huan</p>
        </vx-card>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['order'],
  computed: {
    methodPay () {
      if (this.order.payment === 0) return this.$t('orders.direct_transfer')
      else return this.$t('orders.bank_transfer')
    }
  }
}
</script>
