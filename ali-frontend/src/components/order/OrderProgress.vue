<template>
  <div class="vs-component vs-con-table mb-10 vs-table-primary" v-if="checkStatus">
    <header class="header-table vs-table--header"></header>
    <div class="con-tablex vs-table--content">
      <div class="vs-con-tbody vs-table--tbody ">
        <table class="vs-table vs-table--tbody-table">
          <thead class="vs-table--thead">
          <tr>
            <th colspan="1" rowspan="1" class="col-0 col">
              <div class="vs-table-text">
                {{ $t('orders.order_id')}}
                <br>
                #SVO{{ listOrder.id }}
              </div>
            </th>
            <th colspan="1" rowspan="1" class="col-0 col">
              <div class="vs-table-text">
                {{ $t('orders.date_of_purchase') }}
                <br>
                {{ listOrder.created_at | date_time_format }}
              </div>
            </th>
            <th colspan="1" rowspan="1" class="col-0 col">
              <div class="vs-table-text">
                {{ $t('orders.total') }}
                <br>
                {{ listOrder.sum_price | price_format }}&nbsp;₫
              </div>
            </th>
          </tr>
          </thead>
          <tr class="tr-values vs-table--tr tr-table-state-null">
            <td class="td vs-table--td" colspan="4">
                <span>
                  <h5 class="text-primary mb-3" v-if="expectedDelivery">{{ $t('orders.expected_delivery') }}  {{ listOrder.delivery_date | date_format }}</h5>
                  <h5 class="text-primary mb-3" v-else>{{ $t('orders.expected_delivery_day') }}</h5>
                  <div class="container-progress">
                    <div class="progress-detail">
                      <vs-progress :height="12" :percent="progressStatus"
                                   color="success"></vs-progress>
                      <span class="text-success">{{ customStatus(listOrder.status) }}</span>
                    </div>
                    <div class="progress-view">
                        <vs-button color="rgb(62, 201, 214)" type="filled" @click="orderShow">{{ $t('orders.view_detail') }}</vs-button>
                    </div>
                  </div>
                  <vs-collapse>
                    <vs-collapse-item icon-pack="feather" icon-arrow="icon-arrow-down">
                      <div slot="header">
                        {{ $t('orders.list_product') }}
                      </div>
                      <div class="product flex" v-for="product in listOrder.products" :key="product.id">
                        <a :href="product.product_url" target="_blank"><img :src="product.thumbnails"
                                                                            class="responsive img"
                                                                            :alt="product.product_name"></a>
                        <div class="info-product ml-8">
                          <a :href="product.product_url" class="name" target="_blank">
                            {{ product.product_name }}
                          </a>
                          <p class="resource">{{ $t('orders.resource') }}: <span class="font-semibold">{{ product.resource }}</span></p>
                          <p class="price"><span>{{ product.price | price_format }}&nbsp;₫</span></p>
                          <p class="num">{{ $t('orders.quality') }}: <span>{{ product.quality }}</span></p>
                        </div>
                      </div>
                    </vs-collapse-item>
                  </vs-collapse>
                </span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import statusOrder from '@/configs/statusOrder'
import formatStatus from '@/mixins/formatStatus'

export default {
  props: ['listOrder'],
  mixins: [formatStatus],
  computed: {
    checkStatus () {
      return this.listOrder.status < statusOrder.COMPLETE_ORDER
    },
    progressStatus () {
      return parseInt((this.listOrder.status / statusOrder.COMPLETE_ORDER) * 100)
    },
    expectedDelivery () {
      return this.listOrder.status > statusOrder.PAID
    }
  },
  methods: {
    total (data) {
      return data.sum_price + data.charge
    },
    orderShow () {
      return this.$router.push({name: 'order-show', params: {id: this.listOrder.id}})
    }
  }
}
</script>
<style lang="scss">
  .container-progress {
    display: flex;

    .progress-detail {
      width: 60%;
      flex-grow: 2;
    }

    .progress-view {
      width: 40%;
      padding-left: 5rem;
      padding-right: 5rem;
      @media (max-width: 600px) {
        padding-left: 1rem;
        padding-right: 0;
      }
      @media (max-width: 1005px) {
        padding-left: 2rem;
        padding-right: 2rem;
      }

      button {
        width: 100%;
      }
    }
  }

  .vs-collapse-item {
    cursor: pointer;
  }

  .product {
    margin-top: 2rem;

    .img {
      width: 95px;
    }
  }
</style>
