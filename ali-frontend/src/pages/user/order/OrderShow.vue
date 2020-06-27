<template>
  <div class="vx-row">
    <div class="vx-col w-full md:w-10/12 lg:w-full mt-12 md:mt-0 ml-auto mr-auto">
      <div class="content-area__heading flex justify-between pr-4 border-0 border-t-0 border-b-0 border-l-0 border-solid border-grey-light">
        <h2 class="mb-4">
          {{ $t('orders.details_orders') }} #SVO{{ getOrder.id }} - <span class="text-danger">{{ customStatus(getOrder.status) }}</span>
        </h2>
        <h4>{{ $t('orders.date_of_purchase') }}: {{ getOrder.created_at | date(true) }}, {{ getOrder.created_at | time }}</h4>
      </div>
    </div>
    <div class="vx-col w-full md:w-10/12 lg:w-full mt-12 mb-12 md:mt-0 ml-auto mr-auto">
      <info-order :order="getOrder"/>
      <order-view-table :getListProducts="getListProducts" />
      <vx-card>
        <div class="flex justify-end">
          <h5 class="mb-3 mr-3">{{ $t('orders.provisional_total') }}:</h5>
          <p class="mb-3"> {{ getOrder.sum_price | price_format }}&nbsp;₫</p>
        </div>
        <div class="flex justify-end">
          <h5 class="mb-3 mr-3">{{ $t('orders.provisional_fee') }}:</h5>
          <p class="mb-3">{{ getOrder.charge | price_format }}&nbsp;₫</p>
        </div>
        <div class="flex justify-end">
          <h4 class="mb-3 mr-3 font-semibold">{{ $t('orders.total') }}:</h4>
          <h4 class="mb-3 text-primary">{{ total | price_format }}&nbsp;₫</h4>
        </div>
      </vx-card>
      <div class="mt-10 flex items-baseline">
        <router-link :to="{name: 'info-order'}">&lt;&lt;&lt;{{ $t('orders.back_order')}}</router-link>
        <vs-button color="warning" type="filled" class="ml-6">{{ $t('orders.order_tracking') }}</vs-button>
      </div>

      <comment :order="this.getOrder"/>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import OrderViewTable from '@/components/order-show/OrderViewTable'
import InfoOrder from '@/components/order-show/InfoOrder'
import Comment from '@/components/order-show/Comment'
import formatStatus from '@/mixins/formatStatus'

export default {
  props: ['id'],
  mixins: [formatStatus],
  components: {
    OrderViewTable,
    InfoOrder,
    Comment
  },
  computed: {
    ...mapGetters(['getListProducts', 'getOrder']),
    total () {
      return this.getOrder.sum_price + this.getOrder.charge
    }
  },
  created () {
    this.viewOrder(this.id)
  },
  methods: {
    ...mapActions(['viewOrder'])
  }
}
</script>
<style lang="scss">
  @import "../../../styles/order.scss";
</style>
