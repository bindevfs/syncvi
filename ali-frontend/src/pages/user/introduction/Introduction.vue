<template>
  <div id="introduction">
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
            <h2 class="font-bold text-center mb-12 text-primary">Giới Thiệu Về SyncVi</h2>
            <h3>1. Về chúng tôi</h3>
            <br>
            <i>Tên công ty: </i><strong>Công ty TNHH SyncVi</strong>
            <br>
            <i>Địa chỉ: </i><strong>Tầng 1,2,3 tòa nhà VNPT, 344 đường 2-9, Q. Hải Châu, TP Đà Nẵng</strong>
            <br>
            <i>Phone: </i><strong>0858.64.61.63</strong>
            <br>
            <i>Email: </i><strong>syncvi2019@gmail.com</strong>
            <br>
            <p>Chuyên cung cấp các dịch vụ đặt hàng, vận chuyển từ Trung Quốc về Việt Nam, với hệ thống website bạn có thể lựa chọn các nguồn hàng, đặt hàng dễ dàng đồng thời
            theo dõi tình trạng đơn hàng của mình.
            </p>
            <h3>2. Tại sao chọn chúng tôi?</h3>
            <p>- Đáp ứng các dịch vụ cho khách hàng lớn - nhỏ</p>
            <p>- Giá cả cạnh tranh</p>
            <p>- Dịch vụ hỗ trợ tận tình, mang đến cho qúy khách dịch vụ tốt nhất</p>
            <p>- Công cụ đặt hàng với nhiều tính năng tích hợp sử dụng dễ dàng</p>
            <h3>3. Phương châm</h3>
            <p>Nhiệt tình, chăm chỉ, mến khách</p>
            <p>Luôn lắng nghe, chia sẻ, thái độ phục vụ tận tình, chuyên nghiệp, không ngừng cải tiến để đáp ứng nhu cầu của quý khách.</p>
            <h3 class="mb-3">Văn phòng SyncVi</h3>
            <google-map />
          </div>
        </div>
      </div>
    </div>
    <footer-component />
  </div>
</template>
<script>
import NavBar from '@/components/NavBar'
import ZoomImage from '@/components/ZoomImage'
import GoogleMap from '@/components/GoogleMap'
import FooterComponent from '@/components/Footer'

export default {
  components: {
    NavBar,
    ZoomImage,
    GoogleMap,
    FooterComponent
  }
}
</script>
<style lang="scss">
  .content-area__heading {
    p {
      line-height: 2;
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
