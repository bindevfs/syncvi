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
            <h2 class="font-bold text-center mb-12 text-primary">Quy Định Và Chính Sách Đặt Hàng Của SyncVi</h2>
            <h1 class="font-bold mb-6 text-danger">Đây là quy định ảnh hưởng trực tiếp đến quyền lợi của khách hàng. Do đó quý khách hãy đọc kĩ để đảm bảo quyền lợi của mình.</h1>
            <h3>I. Sự cố liên quan đến chất lượng sản phẩm</h3>
            <p>Mọi vấn đề về chất lượng sản phẩm chúng tôi sẽ không chịu trách nhiệm vì chúng tôi chỉ là dịch vụ trung gian giúp quý khách mua hàng đơn
            giản hơn từ Trung Quốc về Việt Nam, chúng tôi không phải nhà sản xuất nên chúng tôi chỉ hỗ trợ để khách hàng khiếu nại với người bán.</p>
            <strong>Lưu ý về mặt chất lượng sản phẩm: </strong>
            <p>Khi khách hàng mua hàng với số lượng lớn hoặc trước khi quyết định kinh doanh mặt hàng nào đó, chúng tôi khuyên quý khách nên tìm hiểu kĩ shop về: đánh giá,
            điểm chất lượng, xếp hạng,...Không nên chọn mặt hàng quá rẻ tiền. Ngoài ra trước khi đặt một lô lớn, quý khách nên đặt mẫu thử trước để xem chất lượng sản phẩm
            để trách việc mua phải sản phẩm kém chất lượng và mất khá nhiều chi phí đổi trả, thời gian và cả giải quyết hậu quả.</p>
            <h3>II. Sự cố liên quan đến vận chuyển hàng hóa</h3>
            <p>Hàng hóa dễ vỡ quý khách thông báo với nhân viên tư vấn cách đóng hàng và giảm thiểu rủi ro tới mức thấp nhất.</p>
            <p>SyncVi Xin cảm ơn quý khách.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import NavBar from '@/components/NavBar'

export default {
  components: {
    NavBar
  }
}
</script>
<style lang="scss">
  .content-area__heading {
    p {
      line-height: 2.3;
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
