<template>
  <div id="guide-orders">
    <div id="content-area" class="content-area-reduced">
      <div id="content-overlay"></div>
      <div class="content-wrapper-full">
        <nav-bar />
      </div>
    </div>
    <div class="mb-12 mt-12">
      <div class="vx-row">
        <div class="vx-col lg:w-8/12 mr-auto ml-auto">
          <div class="content-area__heading pr-4 border-0 border-t-0 border-b-0 border-l-0 border-solid border-grey-light">
            <h3 class="font-bold text-center mb-12 text-primary">Hướng Dẫn Đặt Hàng Trên Hệ Thống SyncVi</h3>
            <p>Chào khách hàng,</p>
            <p>Hôm nay admin SyncVi sẽ hướng dẫn các bạn đặt hàng và quản lý đơn hàng trên hệ thống website.</p>
            <p><strong>Bước 1: </strong> Các bạn tải công cụ SyncVi trên extension chrome tại <a class="inline-block" target="_blank" href="https://chrome.google.com/webstore/detail/syncvi/eggddphjiomhkpmgbapjcjnkgjgihpkj?hl=vi&gl=VN&authuser=1">đây</a></p>
            <p><strong>Bước 2: </strong> Khi đã cài đặt thành công, bạn truy cập vào website mà SyncVi hỗ trợ đặt hàng. (<a href="https://www.tmall.com/" target="_blank">tmall.com</a>)</p>
            <p><strong>Bước 3: </strong> Lựa chọn các thuộc tính của sản phẩm và bấm vào nút Thêm vào giỏ hàng.</p>
            <zoom-image
              imageWidth="100"
              :src="image.tmall"
            />
            <p>Nếu chưa đăng nhập, bạn cần bấm vào nút Đăng nhập vào hệ thống SyncVi và quay trở lại để mua hàng.</p>
            <zoom-image
              imageWidth="100"
              :src="image.not_login"
            />
            <p>Sau khi sản phẩm được thêm vào giỏ hàng thành công, bạn bấm vào nút Xem Giỏ Hàng để xem những sản phẩm mà mình đã thêm.</p>
            <zoom-image
              imageWidth="100"
              :src="image.order_success"
            />
            <p><strong>Bước 4: </strong>Sau khi chọn sản phẩm, bạn tiến hàng đặt hàng bằng cách click vào nút Đặt Hàng hoặc thêm địa chỉ giao hàng khác.</p>
            <zoom-image
              imageWidth="100"
              :src="image.cart"
            />
            <p><strong>Bước 5: </strong>Sau khi đặt hàng, đơn hàng của bạn sẽ được xử lý và phản hồi tới bạn sớm nhất về tình trạng đơn hàng.</p>
            <p>Chúc các bạn thành công.</p>
          </div>
        </div>
      </div>
    </div>
    <footer-component />
  </div>
</template>
<script>
import NavBar from '@/components/NavBar'
import FooterComponent from '@/components/Footer'
import ZoomImage from '@/components/ZoomImage'
export default {
  components: {
    NavBar,
    FooterComponent,
    ZoomImage
  },
  data () {
    return {
      image: {
        tmall: require('@/assets/images/guide/tmall.png'),
        not_login: require('@/assets/images/guide/not_login.png'),
        cart: require('@/assets/images/guide/cart.png'),
        order_success: require('@/assets/images/guide/order_success.png')
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  .content-area__heading {
    p {
      line-height: 2.5;
      font-size: 16px;
    }
  }
  .responsive.bg-img  {
    margin-top: 3rem;
    margin-bottom: 3rem;
    img {
      width: 100%;
      background-position: 50%;
      background-size: cover;
      height: auto;
    }
  }
</style>
