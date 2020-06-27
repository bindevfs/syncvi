<template>
  <div class="vx-row">
    <div class="vx-col w-full md:w-full lg:w-11/12 mr-auto ml-auto mt-12 md:mt-0" v-if="this.getListOrders.length !== 0">
      <div class="md:p-2 sm:p-6 rounded-lg mb-base">
        <h3>{{ $t('orders.my_order') }}</h3>
      </div>
      <div class="pb-4">
        <order-progress :listOrder="listOrder" v-for="listOrder in this.getListOrders" :key="listOrder.id"/>
      </div>
      <div id="invoice-page" class="pb-12">
        <order-item :listOrder="this.getListOrders"/>
      </div>
    </div>
    <div class="vx-col w-full md:w-full lg:w-10/12 mr-auto ml-auto mt-12 md:mt-0" v-show="this.getListOrders.length === 0 && !this.loading">
      <introduction-order title="Bạn không có đơn hàng nào" />
    </div>
  </div>
</template>
<script>
import OrderItem from '@/components/order/OrderItem'
import IntroductionOrder from '@/components/IntroductionOrder'
import OrderProgress from '@/components/order/OrderProgress'
import { mapActions, mapGetters } from 'vuex'
import formatPrice from '@/mixins/formatPrice'

export default {
  components: {
    OrderProgress,
    OrderItem,
    IntroductionOrder
  },
  mixins: [formatPrice],
  computed: {
    ...mapGetters(['getListOrders', 'loading'])
  },
  mounted () {
    this.listOrders()
  },
  methods: {
    ...mapActions(['listOrders'])
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../styles/order.scss";
</style>
