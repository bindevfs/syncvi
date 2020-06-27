<template>
  <vx-card
    title-color="primary"
    :subtitle="title">
    <p class="mb-3">Để được hướng dẫn mua hàng, bạn hãy truy cập vào đường dẫn <router-link :to="{name: 'guide-order'}">này</router-link></p>
    <p class="mb-3">Nếu bạn đã cài đặt extension, Bạn vui lòng truy cập vào trang web: </p>
    <p class="mb-3"><a href="https://tmall.com/" target="_blank">Tmall.com</a></p>
    <p class="mb-3"><a href="https://world.taobao.com/" target="_blank">Taobao.com</a></p>
    <p class="mb-3"><a href="https://www.1688.com/" target="_blank">Alibaba 1688.com</a></p>
    <p class="mb-3">Để tiến hành mua hàng.</p>
  </vx-card>
</template>
<script>
export default {
  props: ['title']
}
</script>
<style lang="scss">
  .vx-card__title {
    h6 {
      font-size: 18px;
      color: rgba(var(--vs-warning),1)  ;
    }
  }
  .vx-card__body {
    p {
      font-size: 16px;
    }
  }
</style>
