<template lang="html">
  <div>
    <vs-table max-items="5" pagination :data="this.filterProductOrder">

      <template slot="thead">
        <vs-th>{{ $t('orders.order_id') }}</vs-th>
        <vs-th>{{ $t('orders.date_of_purchase') }}</vs-th>
        <vs-th>{{ $t('orders.product') }}</vs-th>
        <vs-th>{{ $t('orders.provisional_total') }}</vs-th>
        <vs-th>{{ $t('orders.status') }}</vs-th>
      </template>

      <template slot-scope="{data}">
        <vs-tr :key="indextr" v-for="(tr, indextr) in data">

          <vs-td :data="data[indextr].id" class="product-item">
            <router-link :to="{ name: 'order-show', params: { id: data[indextr].id } }">#SVO{{ data[indextr].id }}</router-link>
          </vs-td>

          <vs-td :data="data[indextr].created_at" class="product-item">
            {{ data[indextr].created_at | date_time_format }}
          </vs-td>
          <vs-td :data="data[indextr].id" width="40%" class="product-item" v-if="customNameProduct(data[indextr].products).p1">
            {{ customNameProduct(data[indextr].products).p1 }} & {{ customNameProduct(data[indextr].products).p2 }} {{ $t('orders.other_products')}}
          </vs-td>
          <vs-td :data="data[indextr].id" width="40%" class="product-item" v-else>
            {{ customNameProduct(data[indextr].products) }}
          </vs-td>
          <vs-td :data="data[indextr].id" class="product-item">
            <p class="font-semibold">{{ formatPriceProduct(total(data[indextr])) }} ₫</p>
          </vs-td>
          <vs-td :data="data[indextr].status" class="product-item">
            {{ customStatus(data[indextr].status) }}
          </vs-td>
        </vs-tr>
      </template>
    </vs-table>
  </div>
</template>

<script>
import formatPrice from '@/mixins/formatPrice'
import formatStatus from '@/mixins/formatStatus'
import statusOrder from '@/configs/statusOrder'
import _ from 'lodash'

export default {
  props: ['listOrder'],
  mixins: [formatPrice, formatStatus],
  computed: {
    filterProductOrder () {
      return _.filter(this.listOrder, function (item) {
        return item.status >= statusOrder.COMPLETE_ORDER
      })
    }
  },
  methods: {
    total (data) {
      return data.sum_price + data.charge
    },
    customNameProduct (product) {
      if (_.size(product) === 1) {
        return product[0].product_name
      } else {
        return {
          p1: product[0].product_name,
          p2: _.size(_.tail(product))
        }
      }
    }
  }
}
</script>
<style lang="scss">
  .product-item {
    padding-top: 1.75rem !important;
    padding-bottom: 1.75rem !important;
  }
</style>
