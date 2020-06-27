<template>
  <vs-table max-items="5" pagination :data="this.getListProducts">

    <template slot="thead">
      <vs-th>{{ $t('orders.product') }}</vs-th>
      <vs-th>{{ $t('orders.price') }}</vs-th>
      <vs-th>{{ $t('orders.quality') }}</vs-th>
      <vs-th>{{ $t('orders.provisional') }}</vs-th>
    </template>

    <template slot-scope="{data}">
      <vs-tr :key="indextr" v-for="(tr, indextr) in data">
        <vs-td :data="data[indextr].id" width="40%" class="product-item">
          <div class="container-progress">
            <div class="product flex">
              <a :href="data[indextr].product_url" target="_blank">
                <img
                  :src="data[indextr].thumbnails"
                  :alt="data[indextr].product_name" class="responsive img">
              </a>
              <div class="info-product ml-8">
                <a :href="data[indextr].product_url"
                   target="_blank"
                   class="name">{{ data[indextr].product_name }}</a>
                <p class="resource">{{ $t('orders.resource') }}: <span class="font-semibold">{{ data[indextr].resource }}</span></p>
              </div>
            </div>
          </div>
        </vs-td>
        <vs-td :data="data[indextr].id" class="product-item">
          {{ data[indextr].price | price_format }} ₫
        </vs-td>
        <vs-td :data="data[indextr].status" class="product-item">
          {{ data[indextr].quality }}
        </vs-td>
        <vs-td :data="data[indextr].status" class="product-item">
          <p class="font-semibold">{{ subTotal(data[indextr]) | price_format }} ₫</p>
        </vs-td>
      </vs-tr>
    </template>
  </vs-table>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  props: ['getListProducts'],
  computed: {
    ...mapGetters(['getOrder']),
    total () {
      return this.getOrder.sum_price + this.getOrder.charge
    }
  },
  methods: {
    subTotal (product) {
      return product.price * product.quality
    }
  }
}
</script>
