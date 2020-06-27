<template>
  <div id="quotation">
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
            <h2 class="font-bold mt-6 mb-6 text-primary">Cơ cấu phí nhập hàng</h2>
            <h3>Chi phí nhập 1 đơn hàng bao gồm:</h3>
            <p><strong>1. Giá vốn:</strong> gồm tiền hàng và phí vận chuyển nội địa
              Trung Quốc từ địa điểm của người bán tới kho của SyncVi tại Trung Quốc.
              Đây là phí cố định SyncVi phải trả cho người bán.
            </p>
            <h3>2. Phí dịch vụ:</h3>
            <p>- Phí dịch vụ là phí dịch vụ giao dịch với nhà cung cấp và thực hiện mua đơn hàng theo yêu cầu của Quý khách.</p>
            <p><strong>3. Phí vận chuyển quốc tế Trung Quốc - Việt Nam</strong> là chi phí chuyển hàng từ Trung Quốc về các kho của SyncVi tại Việt Nam.
            </p>
            <p><strong>4. Phí giao hàng nội địa Việt Nam</strong> là chi phí chuyển hàng từ kho của SyncVi tới địa chỉ nhận hàng của Quý khách.</p>
            <h2 class="font-bold mt-6 mb-6 text-primary">Giá vốn</h2>
            <h3>Giá vốn hàng hóa bao gồm:</h3>
            <p><strong>- Tiền hàng:</strong> được tính bằng đơn giá sản phẩm nhân với tỷ giá nhân dân tệ tại thời điểm đặt cọc đơn hàng.</p>
            <p><strong>- Phí vận chuyển nội địa Trung Quốc</strong> thông thường được các hãng vận chuyển tính như sau:</p>
            <table class="vs-table vs-table--tbody-table lg:w-full">
              <tbody>
              <tr>
                <td class="p-3">Phí vận chuyển phát nhanh thông thường</td>
                <td class="p-3">KG đầu: đưa vào quy định của chủ shop trên trang chi tiết taobao,
                  alibaba...
                </td>
                <td class="p-3">KG tiếp theo: Nếu shop thuộc Quảng Đông là <strong>6 tệ/kg</strong>,
                  khác tỉnh Quảng đông là <strong>8 tệ/kg</strong></td>
              </tr>
              <tr>
                <td class="p-3">Chuyển phát nhanh siêu tốc EMS</td>
                <td class="p-3">KG đầu: dựa vào quy định của chủ shop trên trang taoabo, alibaba...</td>
                <td class="p-3">Mỗi <strong>0.5 kg</strong> tiếp theo: <strong>5 tệ/kg</strong></td>
              </tr>
              <tr>
                <td class="p-3">Chuyển phát thường ô tô tải</td>
                <td colspan="2" class="text-center p-3"><strong>2 tệ/kg</strong> + <strong>70 tệ/đơn hàng</strong>
                </td>
              </tr>
              </tbody>
            </table>
            <h2 class="font-bold mt-6 mb-6 text-primary">Phí dịch vụ</h2>
            <p>Phí dịch vụ = Tiền hàng * % phí dịch vụ</p>
            <table class="vs-table vs-table--tbody-table lg:w-full">
              <tbody>
              <tr>
                <th>Dịch vụ</th>
                <th>Phí dịch vụ</th>
              </tr>
              </tbody>
              <tbody>
              <tr>
                <td>Phí dịch vụ</td>
                <td>3.5%</td>
              </tr>
              </tbody>
            </table>
            <h2 class="font-bold mt-6 mb-6 text-primary">Phí vận chuyển TQ-VN</h2>
            <p>Phí vận chuyển quốc tế = Phí cố định (5.000đ/đơn hàng) + Phí vận chuyển hàng hóa SYNCVI :</p>
            <img src="@/assets/images/guide/price.png" alt="">
            <h2 class="font-bold  mt-6 mb-6 text-primary">Quy cách đóng hàng</h2>
            <p>(*) Thời gian trên được tính từ ngày nhận hàng ở kho Quảng Châu(GZ)</p>
            <p>Không mất phí đóng bao.</p>
            <p>Báo giá trên về tới kho của SyncVi tại Đà Nẵng quý khách có thể tự tới kho lấy hàng hoặc nhân viên của SyncVi chuyển hàng tới tận nơi,
              phí chuyển hàng từ kho SyncVi đến nhà khách hàng, khách hàng chịu phí
            </p>
            <p>Khách hàng ở các tỉnh ngoài SyncVi sẽ chuyển phát nhanh theo yêu cầu của quý khách</p>
            <h2 class="font-bold  mt-6 mb-6 text-primary">Địa chỉ kho</h2>
            <p><strong>Đà Nẵng:</strong>Tầng 1,2,3 tòa nhà VNPT, 344 đường 2-9, Q. Hải Châu, TP Đà Nẵng</p>
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
  #quotation {
    .content-area__heading {
      p {
        line-height: 2;
        font-size: 16px;
      }
    }
  }
</style>
