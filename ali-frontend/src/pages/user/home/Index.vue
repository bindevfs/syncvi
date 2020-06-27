<template>
  <div id="home">
    <div id="content-area" class="content-area-reduced">
      <div id="content-overlay"></div>
      <div class="content-wrapper-full">
        <nav-bar />
      </div>
    </div>
    <div class="carousel-example">
      <swiper :options="swiperOption">
        <swiper-slide class="slide-1"></swiper-slide>
      </swiper>
    </div>
<!--    -->
    <div class="mb-2 mt-12">
      <div class="w-full text-center mb-8">
        <h2 class="title">Nguồn Hàng Phong Phú</h2>
      </div>
      <div class="vx-row lg:w-full md:w-10/12 mr-auto ml-auto flex justify-center">
        <div class="w-full lg:w-1/4 md:w-full mb-8 px-4 feature">
          <div class="box-logo">
            <h5 class="mb-6">Taobao</h5>
            <a href="https://world.taobao.com/" target="_blank">
              <img class="logo" src="@/assets/images/ali/taobao-logo.jpg" alt="Website Taobao">
            </a>
            <div class="pt-10">
              <p>
                Website bán lẻ lớn nhất Trung Quốc.
              </p>
            </div>
          </div>
        </div>
        <div class="w-full lg:w-1/4 md:w-full mb-8 px-4 feature">
          <div class="box-logo">
            <h5 class="mb-6">1688</h5>
            <a href="https://www.1688.com/" target="_blank">
              <img class="logo" src="@/assets/images/ali/1688.png" alt="Website 1688">
            </a>
            <div class="pt-10">
              <p>
                Website bán buôn lớn nhất Trung Quốc.
              </p>
            </div>
          </div>
        </div>
        <div class="w-full lg:w-1/4 md:w-full mb-8 px-4 feature">
          <div class="box-logo">
            <h5 class="mb-6">Tmall</h5>
            <a href="https://www.tmall.com/" target="_blank">
              <img class="logo" src="@/assets/images/ali/tmall.png" alt="Website tmall">
            </a>
            <div class="pt-10">
              <p>
                Website chuyên hàng hiệu, chính hãng chất lượng lớn nhất TQ.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--    -->
    <div class="mb-12 mt-12">
      <div class="w-full text-center mb-8">
        <h2 class="title">Dịch Vụ Của SyncVi</h2>
        <p>Mang đến sự hài lòng tốt nhất cho quý khách.</p>
      </div>
      <div class="vx-row lg:w-10/12 md:w-full sm:w-1/2 ml-auto mr-auto flex justify-between pt-10">
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="flight" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Tìm nguồn hàng</h3>
            <p>Bạn là chủ shop, bạn cần tìm nguồn hàng giá sỉ, chúng tôi sẽ tìm nguồn hàng với giá xưởng cho
              bạn.</p>
          </div>
        </div>
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="directions_transit" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Vận chuyển hàng hóa</h3>
            <p>Bạn có hàng và cần chuyển qua lại Việt - Trung, chúng tôi sẽ vận chuyển về kho cho bạn.</p>
          </div>
        </div>
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="attach_money" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Chuyển đổi tiền tệ</h3>
            <p>Chuyển đổi tiền Việt - Trung với giá thích hợp nhất.</p>
          </div>
        </div>
      </div>
      <div class="vx-row lg:w-10/12 md:w-full sm:w-1/2 ml-auto mr-auto flex justify-between pt-10">
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="shopping_cart" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Mua Hàng 24/24</h3>
            <p>Quý khác được đảm bảo mua hàng sớm nhất trong 24h.</p>
          </div>
        </div>
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="store" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Visa</h3>
            <p>Bạn cần sang Trung Quốc, công tác, du lịch, vui chơi, hãy liên lạc với chúng tôi.</p>
          </div>
        </div>
        <div class="lg:w-1/4 md:w-1/3 flex mb-10">
          <vs-icon icon="help" size="75px" color="#BC1254"></vs-icon>
          <div class="feature-content">
            <h3>Hỗ Trợ</h3>
            <p>Luôn luôn sãn sàng hỗ trợ Quý Khác mọi lúc.</p>
          </div>
        </div>
      </div>
    </div>
<!--    -->
    <div class="mb-12 mt-12 relative">
      <div class="background-image"></div>
      <div class="vx-row lg:w-2/3 md:w-full ml-auto mr-auto flex justify-between pt-10">
       <div class="w-full text-center">
         <h2 class="title">Quy trình đặt và giao nhận hàng</h2>
         <p>Quy trình đảm bảo đúng thứ tự</p>
       </div>
        <div class="lg:w-full sm:w-full ml-auto mr-auto">
          <ul class="list-icon">
            <li class="item-icon">
              <a href="javascript:void(0)">
                <i class="material-icons">
                  search
                </i>
                <h5>B1. Chọn Hàng</h5>
              </a>
            </li>
            <li class="item-icon">
              <a href="javascript:void(0)">
                <i class="material-icons">
                  attach_money
                </i>
                <h5>B2. Đặt Cọc</h5>
              </a>
            </li>
            <li class="item-icon">
              <a href="javascript:void(0)">
                <i class="material-icons">
                  flight
                </i>
                <h5>B3. Vận Chuyển</h5>
              </a>
            </li>
            <li class="item-icon">
              <a href="javascript:void(0)">
                <i class="material-icons">
                  thumb_up
                </i>
                <h5>B4. Kiểm Tra Hàng</h5>
              </a>
            </li>
            <li class="item-icon">
              <a href="javascript:void(0)">
                <i class="material-icons">
                  done
                </i>
                <h5>B5. Nhận Hàng</h5>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
<!--    -->
    <div class="mt-12 background-white pt-10 pb-10">
      <div class="vx-row md:w-10/12 ml-auto mr-auto">
        <div class="vx-col w-full md:w-1/2 sm:w-1/2 mb-base ml-auto mr-auto">
          <vx-card
            title-color="#fff"
            content-color="#fff"
            class="hot-line"
            >
            <h2>Hotline:</h2>
            <p class="mb-3">
              <i class="material-icons">phone</i>
              Bộ phận CSKH: <strong>0988.777.666</strong>
            </p>
            <p class="mb-3">
              <i class="material-icons">phone</i>
              Bộ phận Khiếu nại, mua hàng: <strong>0988.777.666</strong>
            </p>
            <p class="mb-3">
              <i class="material-icons">phone</i>
              Bộ phận Kế toán: <strong>0988.777.666</strong>
            </p>
            <p class="mb-3">
              <i class="material-icons">phone</i>
              Bộ phận Kho: <strong>0988.777.666</strong>
            </p>
          </vx-card>
        </div>
      </div>
      <div class="vx-row md:w-10/12 ml-auto mr-auto mt-12">
        <div class="vx-col w-full md:w-full sm:w-full mb-base ml-auto mr-auto text-center">
          <h2 class="text-gray">Email: syncvi2019@gmail.com</h2>
          <p>Tầng 1,2,3 tòa nhà VNPT, 344 đường 2-9, Q. Hải Châu, TP Đà Nẵng</p>
        </div>
      </div>
    </div>
    <google-map />
    <footer-component />
  </div>
</template>
<script>
import NavBar from '@/components/NavBar'
import FooterComponent from '@/components/Footer'
import GoogleMap from '@/components/GoogleMap'
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
export default {
  components: {
    swiper,
    swiperSlide,
    NavBar,
    FooterComponent,
    GoogleMap
  },
  data () {
    return {
      swiperOption: {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
    }
  }
}
</script>
<style lang="scss">
@import "../../../styles/home.scss";
</style>
