<template>
  <div id="term-use">
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
            <h3 class="font-bold text-center mb-12 text-primary">Điều Khoản Sử Dụng</h3>
            <h5><strong>1. Giới thiệu</strong></h5>
            <p>Chào mừng quý khách đến với website SyncVi.</p>
            <p>Chúng tôi là công ty SyncVi có địa chỉ tại 344 đường 2-9, Q. Hải Châu, TP Đà Nẵng, khi quý khách truy cập vào trang web này, quý khác đã chấp nhận các điều khoản này.
            </p>
            <p>Quý khách hàng vui lòng kiểm tra thường xuyên để cập nhật những thay đổi của chúng tôi.</p>
            <h5 class="mt-8"><strong>2. Hướng dẫn sử dụng website</strong></h5>
            <p>Khi vào website quý khách cần đăng ký thông tin để có thể đặt hàng trên SyncVi và luôn cập nhật thông tin của bản thân nếu thông tin đó không chính xác.</p>
            <p>Mỗi người truy cập cần phải có trách nhiệm với các thông tin của mình, không cho người khác biết tài khoản của mình, tránh xảy ra những rủi ro đáng tiếc và chúng tôi
            sẽ không chịu trách nhiệm cho trường hợp trên.</p>
            <p>Nghiêm cấm sử dụng các phần mềm bên thứ 3 mà chúng tôi không cho phép, nếu vi phạm chúng tôi sẽ hủy tài khoản của quý khách ngay lập tức.</p>
            <h5 class="mt-8"><strong>3. Ý kiến của khách hàng</strong></h5>
            <p>SyncVi là tài sản của chúng tôi, nếu quý khách có phê bình, hoặc bôi nhọ công ty thì chúng tôi sẽ ngay lập tức khóa tài khoản và áp dụng các biện pháp xử lý theo quy định của pháp luật.</p>
            <h5 class="mt-8"><strong>4. Đơn hàng và giá cả</strong></h5>
            <p>Chúng tôi là bên trung gian để giúp quý khách đặt hàng từ Trung Quốc về Việt Nam một cách dễ dàng nhất nên mọi vấn đề về sản phẩm như (Bảo hành, lỗi sản phẩm...) chúng tôi
            sẽ không giải quyết mà thay vào đó sẽ tạo mọi điều kiện thuận lợi để quý khách giải quyết với bên kia.</p>
            <h5 class="mt-8"><strong>5. Đảm bảo an toàn giao dịch</strong></h5>
            <p>Chúng tôi sử dụng các dịch vụ để bảo vệ thông tin về nội dung mà người bán đăng  sản phẩm trên SyncVi.
              Để đảm bảo các giao dịch được tiến hành thành công, hạn chế tối đa rủi ro có thể phát sinh.</p>
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
  }
}
</script>
<style lang="scss" scoped>
  #term-use {
    .content-area__heading {
      p {
        line-height: 2.5;
        font-size: 16px;
      }
    }
  }
</style>
